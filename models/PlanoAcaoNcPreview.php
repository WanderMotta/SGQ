<?php

namespace PHPMaker2024\sgq;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Closure;

/**
 * Page class
 */
class PlanoAcaoNcPreview extends PlanoAcaoNc
{
    use MessagesTrait;

    // Page ID
    public $PageID = "preview";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "PlanoAcaoNcPreview";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "PlanoAcaoNcPreview";

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<div id="ew-page-header">' . $header . '</div>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<div id="ew-page-footer">' . $footer . '</div>';
        }
    }

    // Set field visibility
    public function setVisibility()
    {
        $this->idplano_acao_nc->Visible = false;
        $this->dt_cadastro->Visible = false;
        $this->nao_conformidade_idnao_conformidade->Visible = false;
        $this->o_q_sera_feito->setVisibility();
        $this->efeito_esperado->setVisibility();
        $this->usuario_idusuario->setVisibility();
        $this->recursos_nec->setVisibility();
        $this->dt_limite->setVisibility();
        $this->implementado->setVisibility();
        $this->eficaz->setVisibility();
        $this->evidencia->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'plano_acao_nc';
        $this->TableName = 'plano_acao_nc';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table ew-preview-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (plano_acao_nc)
        if (!isset($GLOBALS["plano_acao_nc"]) || $GLOBALS["plano_acao_nc"]::class == PROJECT_NAMESPACE . "plano_acao_nc") {
            $GLOBALS["plano_acao_nc"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'plano_acao_nc');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions(Tag: "td", TableVar: $this->TableVar);

        // Other options
        $this->OtherOptions = new ListOptionsArray();

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions(
            TagClassName: "ew-add-edit-option",
            UseDropDownButton: false,
            DropDownButtonPhrase: $Language->phrase("ButtonAddEdit"),
            UseButtonGroup: true
        );
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return $Response?->getBody() ?? ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }
        DispatchEvent(new PageUnloadedEvent($this), PageUnloadedEvent::NAME);
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (WithJsonResponse()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from result set
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Result set
            while ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($row);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DataType::BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['idplano_acao_nc'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->idplano_acao_nc->Visible = false;
        }
    }
    public $Recordset;
    public $CurrentRow; // Current row // PHP
    public $TotalRecords = 0;
    public $RecordCount = 0;
    public $ListOptions; // List options
    public $OtherOptions; // Other options
    public $StartRecord = 1;
    public $DisplayRecords = 5;
    public $UseModalLinks = true;
    public $IsModal = true;
    public $DetailCounts = [];

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }
        $this->CurrentAction = Param("action"); // Set up current action

        // Set up list options
        $this->setupListOptions();
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->nao_conformidade_idnao_conformidade);
        $this->setupLookupOptions($this->usuario_idusuario);
        $this->setupLookupOptions($this->implementado);
        $this->setupLookupOptions($this->eficaz);

        // Load filter
        $masterKeys = explode("|", Decrypt(Get("f", "")));
        $filter = array_shift($masterKeys);
        if ($filter == "") {
            $filter = "0=1";
        }
        $detailFilters = JsonDecode(Decrypt(Get("detailfilters", ""))) ?: [];
        foreach ($detailFilters as $detailTblVar => $detailFilter) {
            $this->DetailCounts[$detailTblVar] = Container($detailTblVar)?->loadRecordCount($detailFilter);
        }

        // Set up Sort Order
        $this->setupSortOrder();

        // Set up foreign keys
        $this->setupForeignKeys($masterKeys);

        // Call Recordset Selecting event
        $this->recordsetSelecting($filter);

        // Load result set
        $filter = $this->applyUserIDFilters($filter);
        $this->TotalRecords = $this->loadRecordCount($filter);
        if ($this->DisplayRecords <= 0) { // Show all records if page size not specified
            $this->DisplayRecords = $this->TotalRecords > 0 ? $this->TotalRecords : 10;
        }
        $sql = $this->previewSql($filter);
        if ($this->DisplayRecords > 0) {
            $sql->setFirstResult(max($this->StartRecord - 1, 0))->setMaxResults($this->DisplayRecords);
        }
        $this->Recordset = $sql->executeQuery();

        // Call Recordset Selected event
        $this->recordsetSelected($this->Recordset);
        $this->renderOtherOptions();

        // Set up pager (always use PrevNextPager for preview page)
        $url = CurrentPageName() . "?t=" . Get("t") . "&f=" . Get("f"); // Add table/filter parameters only
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, "", 10, $this->AutoHidePager, null, null, true, $url);

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            DispatchEvent(new PageRenderingEvent($this), PageRenderingEvent::NAME);

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    /**
     * Set up sort order
     *
     * @return void
     */
    protected function setupSortOrder()
    {
        $defaultSort = $this->idplano_acao_nc->Expression . " DESC"; // Set up default sort
        if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
            $this->setSessionOrderBy($defaultSort);
        }

        // Check for Ctrl pressed
        $ctrl = Get("ctrl") !== null;
        if (SameText(Get("cmd"), "resetsort")) {
            $this->StartRecord = 1;
            $this->CurrentOrder = "";
            $this->CurrentOrderType = "";
            $this->idplano_acao_nc->setSort("");
            $this->dt_cadastro->setSort("");
            $this->nao_conformidade_idnao_conformidade->setSort("");
            $this->o_q_sera_feito->setSort("");
            $this->efeito_esperado->setSort("");
            $this->usuario_idusuario->setSort("");
            $this->recursos_nec->setSort("");
            $this->dt_limite->setSort("");
            $this->implementado->setSort("");
            $this->eficaz->setSort("");
            $this->evidencia->setSort("");

            // Save sort to session
            $this->setSessionOrderBy("");
        } else {
            $this->StartRecord = 1;
            $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
            $startRec = Get(Config("TABLE_START_REC"));
            if (is_numeric($pageNo)) { // Check for page parameter
                $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
            } elseif (is_numeric($startRec)) { // Check for "start" parameter
                $this->StartRecord = $startRec;
            }
            $this->CurrentOrder = Get("sort", "");
            $this->CurrentOrderType = Get("sortorder", "");
        }

        // Check for sort field
        if ($this->CurrentOrder !== "") {
            $this->updateSort($this->o_q_sera_feito, $ctrl); // o_q_sera_feito
            $this->updateSort($this->efeito_esperado, $ctrl); // efeito_esperado
            $this->updateSort($this->usuario_idusuario, $ctrl); // usuario_idusuario
            $this->updateSort($this->recursos_nec, $ctrl); // recursos_nec
            $this->updateSort($this->dt_limite, $ctrl); // dt_limite
            $this->updateSort($this->implementado, $ctrl); // implementado
            $this->updateSort($this->eficaz, $ctrl); // eficaz
        }

        // Update field sort
        $this->updateFieldSort();
    }

    /**
     * Get preview SQL
     *
     * @param string $filter
     * @return QueryBuilder
     */
    protected function previewSql($filter)
    {
        $sort = $this->getSessionOrderBy();
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = true;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = true;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = true;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();
        $masterKeyUrl = $this->masterKeyUrl();

        // "view"
        $opt = $this->ListOptions["view"];
        if ($Security->canView()) {
            $viewCaption = $Language->phrase("ViewLink");
            $viewTitle = HtmlTitle($viewCaption);
            $viewUrl = GetUrl($this->getViewUrl($masterKeyUrl));
            if ($this->UseModalLinks && !IsMobile()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewTitle . "\" data-caption=\"" . $viewTitle . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode($viewUrl) . "\" data-btn=\"null\">" . $viewCaption . "</a>";
            } else {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewTitle . "\" data-caption=\"" . $viewTitle . "\" href=\"" . HtmlEncode($viewUrl) . "\">" . $viewCaption . "</a>";
            }
        } else {
            $opt->Body = "";
        }

        // "edit"
        $opt = $this->ListOptions["edit"];
        if ($Security->canEdit()) {
            $editCaption = $Language->phrase("EditLink");
            $editTitle = HtmlTitle($editCaption);
            $editUrl = GetUrl($this->getEditUrl($masterKeyUrl));
            if ($this->UseModalLinks && !IsMobile()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editTitle . "\" data-caption=\"" . $editTitle . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode($editUrl) . "\" data-btn=\"SaveBtn\">" . $editCaption . "</a>";
            } else {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editTitle . "\" data-caption=\"" . $editTitle . "\" href=\"" . HtmlEncode($editUrl) . "\">" . $editCaption . "</a>";
            }
        } else {
            $opt->Body = "";
        }

        // "copy"
        $opt = $this->ListOptions["copy"];
        if ($Security->canAdd()) {
            $copyCaption = $Language->phrase("CopyLink");
            $copyTitle = HtmlTitle($copyCaption);
            $copyUrl = GetUrl($this->getCopyUrl($masterKeyUrl));
            if ($this->UseModalLinks && !IsMobile()) {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copyTitle . "\" data-caption=\"" . $copyTitle . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode($copyUrl) . "\" data-btn=\"AddBtn\">" . $copyCaption . "</a>";
            } else {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copyTitle . "\" data-caption=\"" . $copyTitle . "\" href=\"" . HtmlEncode($copyUrl) . "\">" . $copyCaption . "</a>";
            }
        } else {
            $opt->Body = "";
        }

        // "delete"
        $opt = $this->ListOptions["delete"];
        if ($Security->canDelete()) {
            $deleteCaption = $Language->phrase("DeleteLink");
            $deleteTitle = HtmlTitle($deleteCaption);
            $deleteUrl = GetUrl($this->getDeleteUrl($masterKeyUrl));
            $opt->Body = "<a class=\"ew-row-link ew-delete\"" .
                (($this->InlineDelete || $this->UseModalLinks) && !IsMobile() ? " data-json=\"true\" data-ew-action=\"inline-delete\"" : "") .
                " title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" href=\"" . HtmlEncode($deleteUrl) . "\">" . $deleteCaption . "</a>";
        } else {
            $opt->Body = "";
        }

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];
        $option->UseButtonGroup = false;

        // Add group option item
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // Add
        $item = &$option->add("add");
        $item->Visible = $Security->canAdd();
    }

    // Render other options
    protected function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = $option["add"];
        if ($Security->canAdd()) {
            $addCaption = $Language->phrase("AddLink");
            $addTitle = HtmlTitle($addCaption);
            $addUrl = GetUrl($this->getAddUrl($this->masterKeyUrl()));
            if ($this->UseModalLinks && !IsMobile()) {
                $item->Body = "<a class=\"btn btn-default btn-sm ew-add-edit ew-add\" title=\"" . $addTitle . "\" data-caption=\"" . $addTitle . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode($addUrl) . "\" data-btn=\"AddBtn\">" . $addCaption . "</a>";
            } else {
                $item->Body = "<a class=\"btn btn-default btn-sm ew-add-edit ew-add\" title=\"" . $addTitle . "\" data-caption=\"" . $addTitle . "\" href=\"" . HtmlEncode($addUrl) . "\">" . $addCaption . "</a>";
            }
        } else {
            $item->Body = "";
        }
    }

    // Get master foreign key URL
    protected function masterKeyUrl()
    {
        $masterTblVar = Get("t", "");
        $url = "";
        if ($masterTblVar == "nao_conformidade") {
            $url = "" . Config("TABLE_SHOW_MASTER") . "=nao_conformidade&" . GetForeignKeyUrl("fk_idnao_conformidade", $this->nao_conformidade_idnao_conformidade->QueryStringValue) . "";
        }
        return $url;
    }

    // Set up foreign keys
    protected function setupForeignKeys($keys)
    {
        $masterTblVar = Get("t", "");
        if ($masterTblVar == "nao_conformidade") {
            $this->nao_conformidade_idnao_conformidade->setQueryStringValue($keys[0] ?? "");
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PlanoAcaoNcList"), "", $this->TableVar, true);
        $pageId = "preview";
        $Breadcrumb->add("preview", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_nao_conformidade_idnao_conformidade":
                    break;
                case "x_usuario_idusuario":
                    break;
                case "x_implementado":
                    break;
                case "x_eficaz":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == "success") {
            //$msg = "your success message";
        } elseif ($type == "failure") {
            //$msg = "your failure message";
        } elseif ($type == "warning") {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->moveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }
}
