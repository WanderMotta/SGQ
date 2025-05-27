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
class ItemRelAudInternaAdd extends ItemRelAudInterna
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ItemRelAudInternaAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ItemRelAudInternaAdd";

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
        $this->iditem_rel_aud_interna->Visible = false;
        $this->dt_cadastro->setVisibility();
        $this->processo_idprocesso->setVisibility();
        $this->descricao->setVisibility();
        $this->acao_imediata->setVisibility();
        $this->acao_contecao->setVisibility();
        $this->abrir_nc->setVisibility();
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'item_rel_aud_interna';
        $this->TableName = 'item_rel_aud_interna';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (item_rel_aud_interna)
        if (!isset($GLOBALS["item_rel_aud_interna"]) || $GLOBALS["item_rel_aud_interna"]::class == PROJECT_NAMESPACE . "item_rel_aud_interna") {
            $GLOBALS["item_rel_aud_interna"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'item_rel_aud_interna');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $pageName = GetPageName($url);
                $result = ["url" => GetUrl($url), "modal" => "1"];  // Assume return to modal for simplicity
                if (
                    SameString($pageName, GetPageName($this->getListUrl())) ||
                    SameString($pageName, GetPageName($this->getViewUrl())) ||
                    SameString($pageName, GetPageName(CurrentMasterTable()?->getViewUrl() ?? ""))
                ) { // List / View / Master View page
                    if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                        $result["caption"] = $this->getModalCaption($pageName);
                        $result["view"] = SameString($pageName, "ItemRelAudInternaView"); // If View page, no primary button
                    } else { // List page
                        $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                        $this->clearFailureMessage();
                    }
                } else { // Other pages (add messages and then clear messages)
                    $result = array_merge($this->getMessages(), ["modal" => "1"]);
                    $this->clearMessages();
                }
                WriteJson($result);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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
            $key .= @$ar['iditem_rel_aud_interna'];
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
            $this->iditem_rel_aud_interna->Visible = false;
        }
    }

    // Lookup data
    public function lookup(array $req = [], bool $response = true)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $req["field"] ?? null;
        if (!$fieldName) {
            return [];
        }
        $fld = $this->Fields[$fieldName];
        $lookup = $fld->Lookup;
        $name = $req["name"] ?? "";
        if (ContainsString($name, "query_builder_rule")) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }

        // Get lookup parameters
        $lookupType = $req["ajax"] ?? "unknown";
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $req["q"] ?? $req["sv"] ?? "";
            $pageSize = $req["n"] ?? $req["recperpage"] ?? 10;
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $req["q"] ?? "";
            $pageSize = $req["n"] ?? -1;
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $req["start"] ?? -1;
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $req["page"] ?? -1;
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($req["s"] ?? "");
        $userFilter = Decrypt($req["f"] ?? "");
        $userOrderBy = Decrypt($req["o"] ?? "");
        $keys = $req["keys"] ?? null;
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $req["v0"] ?? $req["lookupValue"] ?? "";
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $req["v" . $i] ?? "";
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, $response); // Use settings from current page
    }
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
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

        // Set up lookup cache
        $this->setupLookupOptions($this->processo_idprocesso);
        $this->setupLookupOptions($this->abrir_nc);

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("iditem_rel_aud_interna") ?? Route("iditem_rel_aud_interna")) !== null) {
                $this->iditem_rel_aud_interna->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $rsold = $this->loadOldRecord();

        // Set up master/detail parameters
        // NOTE: Must be after loadOldRecord to prevent master key values being overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$rsold) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("ItemRelAudInternaList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "ItemRelAudInternaList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ItemRelAudInternaView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ItemRelAudInternaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ItemRelAudInternaList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = RowType::ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->abrir_nc->DefaultValue = $this->abrir_nc->getDefault(); // PHP
        $this->abrir_nc->OldValue = $this->abrir_nc->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'dt_cadastro' first before field var 'x_dt_cadastro'
        $val = $CurrentForm->hasValue("dt_cadastro") ? $CurrentForm->getValue("dt_cadastro") : $CurrentForm->getValue("x_dt_cadastro");
        if (!$this->dt_cadastro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dt_cadastro->Visible = false; // Disable update for API request
            } else {
                $this->dt_cadastro->setFormValue($val);
            }
            $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        }

        // Check field name 'processo_idprocesso' first before field var 'x_processo_idprocesso'
        $val = $CurrentForm->hasValue("processo_idprocesso") ? $CurrentForm->getValue("processo_idprocesso") : $CurrentForm->getValue("x_processo_idprocesso");
        if (!$this->processo_idprocesso->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->processo_idprocesso->Visible = false; // Disable update for API request
            } else {
                $this->processo_idprocesso->setFormValue($val);
            }
        }

        // Check field name 'descricao' first before field var 'x_descricao'
        $val = $CurrentForm->hasValue("descricao") ? $CurrentForm->getValue("descricao") : $CurrentForm->getValue("x_descricao");
        if (!$this->descricao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descricao->Visible = false; // Disable update for API request
            } else {
                $this->descricao->setFormValue($val);
            }
        }

        // Check field name 'acao_imediata' first before field var 'x_acao_imediata'
        $val = $CurrentForm->hasValue("acao_imediata") ? $CurrentForm->getValue("acao_imediata") : $CurrentForm->getValue("x_acao_imediata");
        if (!$this->acao_imediata->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->acao_imediata->Visible = false; // Disable update for API request
            } else {
                $this->acao_imediata->setFormValue($val);
            }
        }

        // Check field name 'acao_contecao' first before field var 'x_acao_contecao'
        $val = $CurrentForm->hasValue("acao_contecao") ? $CurrentForm->getValue("acao_contecao") : $CurrentForm->getValue("x_acao_contecao");
        if (!$this->acao_contecao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->acao_contecao->Visible = false; // Disable update for API request
            } else {
                $this->acao_contecao->setFormValue($val);
            }
        }

        // Check field name 'abrir_nc' first before field var 'x_abrir_nc'
        $val = $CurrentForm->hasValue("abrir_nc") ? $CurrentForm->getValue("abrir_nc") : $CurrentForm->getValue("x_abrir_nc");
        if (!$this->abrir_nc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->abrir_nc->Visible = false; // Disable update for API request
            } else {
                $this->abrir_nc->setFormValue($val);
            }
        }

        // Check field name 'iditem_rel_aud_interna' first before field var 'x_iditem_rel_aud_interna'
        $val = $CurrentForm->hasValue("iditem_rel_aud_interna") ? $CurrentForm->getValue("iditem_rel_aud_interna") : $CurrentForm->getValue("x_iditem_rel_aud_interna");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->processo_idprocesso->CurrentValue = $this->processo_idprocesso->FormValue;
        $this->descricao->CurrentValue = $this->descricao->FormValue;
        $this->acao_imediata->CurrentValue = $this->acao_imediata->FormValue;
        $this->acao_contecao->CurrentValue = $this->acao_contecao->FormValue;
        $this->abrir_nc->CurrentValue = $this->abrir_nc->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from result set or record
     *
     * @param array $row Record
     * @return void
     */
    public function loadRowValues($row = null)
    {
        $row = is_array($row) ? $row : $this->newRow();

        // Call Row Selected event
        $this->rowSelected($row);
        $this->iditem_rel_aud_interna->setDbValue($row['iditem_rel_aud_interna']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->processo_idprocesso->setDbValue($row['processo_idprocesso']);
        $this->descricao->setDbValue($row['descricao']);
        $this->acao_imediata->setDbValue($row['acao_imediata']);
        $this->acao_contecao->setDbValue($row['acao_contecao']);
        $this->abrir_nc->setDbValue($row['abrir_nc']);
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->setDbValue($row['relatorio_auditoria_interna_idrelatorio_auditoria_interna']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['iditem_rel_aud_interna'] = $this->iditem_rel_aud_interna->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['processo_idprocesso'] = $this->processo_idprocesso->DefaultValue;
        $row['descricao'] = $this->descricao->DefaultValue;
        $row['acao_imediata'] = $this->acao_imediata->DefaultValue;
        $row['acao_contecao'] = $this->acao_contecao->DefaultValue;
        $row['abrir_nc'] = $this->abrir_nc->DefaultValue;
        $row['relatorio_auditoria_interna_idrelatorio_auditoria_interna'] = $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        if ($this->OldKey != "") {
            $this->setKey($this->OldKey);
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = ExecuteQuery($sql, $conn);
            if ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Load row values
                return $row;
            }
        }
        $this->loadRowValues(); // Load default row values
        return null;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // iditem_rel_aud_interna
        $this->iditem_rel_aud_interna->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // processo_idprocesso
        $this->processo_idprocesso->RowCssClass = "row";

        // descricao
        $this->descricao->RowCssClass = "row";

        // acao_imediata
        $this->acao_imediata->RowCssClass = "row";

        // acao_contecao
        $this->acao_contecao->RowCssClass = "row";

        // abrir_nc
        $this->abrir_nc->RowCssClass = "row";

        // relatorio_auditoria_interna_idrelatorio_auditoria_interna
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // processo_idprocesso
            $curVal = strval($this->processo_idprocesso->CurrentValue);
            if ($curVal != "") {
                $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->lookupCacheOption($curVal);
                if ($this->processo_idprocesso->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $curVal, $this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                    $sqlWrk = $this->processo_idprocesso->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->processo_idprocesso->Lookup->renderViewRow($rswrk[0]);
                        $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->displayValue($arwrk);
                    } else {
                        $this->processo_idprocesso->ViewValue = FormatNumber($this->processo_idprocesso->CurrentValue, $this->processo_idprocesso->formatPattern());
                    }
                }
            } else {
                $this->processo_idprocesso->ViewValue = null;
            }
            $this->processo_idprocesso->CssClass = "fw-bold";

            // descricao
            $this->descricao->ViewValue = $this->descricao->CurrentValue;
            $this->descricao->CssClass = "fw-bold";

            // acao_imediata
            $this->acao_imediata->ViewValue = $this->acao_imediata->CurrentValue;
            $this->acao_imediata->CssClass = "fw-bold";

            // acao_contecao
            $this->acao_contecao->ViewValue = $this->acao_contecao->CurrentValue;
            $this->acao_contecao->CssClass = "fw-bold";

            // abrir_nc
            if (strval($this->abrir_nc->CurrentValue) != "") {
                $this->abrir_nc->ViewValue = $this->abrir_nc->optionCaption($this->abrir_nc->CurrentValue);
            } else {
                $this->abrir_nc->ViewValue = null;
            }
            $this->abrir_nc->CssClass = "fw-bold";
            $this->abrir_nc->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // processo_idprocesso
            $this->processo_idprocesso->HrefValue = "";

            // descricao
            $this->descricao->HrefValue = "";

            // acao_imediata
            $this->acao_imediata->HrefValue = "";

            // acao_contecao
            $this->acao_contecao->HrefValue = "";

            // abrir_nc
            $this->abrir_nc->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // dt_cadastro

            // processo_idprocesso
            $curVal = trim(strval($this->processo_idprocesso->CurrentValue));
            if ($curVal != "") {
                $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->lookupCacheOption($curVal);
            } else {
                $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->Lookup !== null && is_array($this->processo_idprocesso->lookupOptions()) && count($this->processo_idprocesso->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->processo_idprocesso->ViewValue !== null) { // Load from cache
                $this->processo_idprocesso->EditValue = array_values($this->processo_idprocesso->lookupOptions());
                if ($this->processo_idprocesso->ViewValue == "") {
                    $this->processo_idprocesso->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $this->processo_idprocesso->CurrentValue, $this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                }
                $sqlWrk = $this->processo_idprocesso->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->processo_idprocesso->Lookup->renderViewRow($rswrk[0]);
                    $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->displayValue($arwrk);
                } else {
                    $this->processo_idprocesso->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->processo_idprocesso->EditValue = $arwrk;
            }
            $this->processo_idprocesso->PlaceHolder = RemoveHtml($this->processo_idprocesso->caption());

            // descricao
            $this->descricao->setupEditAttributes();
            $this->descricao->EditValue = HtmlEncode($this->descricao->CurrentValue);
            $this->descricao->PlaceHolder = RemoveHtml($this->descricao->caption());

            // acao_imediata
            $this->acao_imediata->setupEditAttributes();
            $this->acao_imediata->EditValue = HtmlEncode($this->acao_imediata->CurrentValue);
            $this->acao_imediata->PlaceHolder = RemoveHtml($this->acao_imediata->caption());

            // acao_contecao
            $this->acao_contecao->setupEditAttributes();
            $this->acao_contecao->EditValue = HtmlEncode($this->acao_contecao->CurrentValue);
            $this->acao_contecao->PlaceHolder = RemoveHtml($this->acao_contecao->caption());

            // abrir_nc
            $this->abrir_nc->EditValue = $this->abrir_nc->options(false);
            $this->abrir_nc->PlaceHolder = RemoveHtml($this->abrir_nc->caption());

            // Add refer script

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // processo_idprocesso
            $this->processo_idprocesso->HrefValue = "";

            // descricao
            $this->descricao->HrefValue = "";

            // acao_imediata
            $this->acao_imediata->HrefValue = "";

            // acao_contecao
            $this->acao_contecao->HrefValue = "";

            // abrir_nc
            $this->abrir_nc->HrefValue = "";
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language, $Security;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
            if ($this->dt_cadastro->Visible && $this->dt_cadastro->Required) {
                if (!$this->dt_cadastro->IsDetailKey && EmptyValue($this->dt_cadastro->FormValue)) {
                    $this->dt_cadastro->addErrorMessage(str_replace("%s", $this->dt_cadastro->caption(), $this->dt_cadastro->RequiredErrorMessage));
                }
            }
            if ($this->processo_idprocesso->Visible && $this->processo_idprocesso->Required) {
                if (!$this->processo_idprocesso->IsDetailKey && EmptyValue($this->processo_idprocesso->FormValue)) {
                    $this->processo_idprocesso->addErrorMessage(str_replace("%s", $this->processo_idprocesso->caption(), $this->processo_idprocesso->RequiredErrorMessage));
                }
            }
            if ($this->descricao->Visible && $this->descricao->Required) {
                if (!$this->descricao->IsDetailKey && EmptyValue($this->descricao->FormValue)) {
                    $this->descricao->addErrorMessage(str_replace("%s", $this->descricao->caption(), $this->descricao->RequiredErrorMessage));
                }
            }
            if ($this->acao_imediata->Visible && $this->acao_imediata->Required) {
                if (!$this->acao_imediata->IsDetailKey && EmptyValue($this->acao_imediata->FormValue)) {
                    $this->acao_imediata->addErrorMessage(str_replace("%s", $this->acao_imediata->caption(), $this->acao_imediata->RequiredErrorMessage));
                }
            }
            if ($this->acao_contecao->Visible && $this->acao_contecao->Required) {
                if (!$this->acao_contecao->IsDetailKey && EmptyValue($this->acao_contecao->FormValue)) {
                    $this->acao_contecao->addErrorMessage(str_replace("%s", $this->acao_contecao->caption(), $this->acao_contecao->RequiredErrorMessage));
                }
            }
            if ($this->abrir_nc->Visible && $this->abrir_nc->Required) {
                if ($this->abrir_nc->FormValue == "") {
                    $this->abrir_nc->addErrorMessage(str_replace("%s", $this->abrir_nc->caption(), $this->abrir_nc->RequiredErrorMessage));
                }
            }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check referential integrity for master table 'item_rel_aud_interna'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["relatorio_auditoria_interna_idrelatorio_auditoria_interna"] = $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue();
        $masterTable = Container("relatorio_auditoria_interna");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "relatorio_auditoria_interna", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            } elseif (!EmptyValue($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
        }
        return $addRow;
    }

    /**
     * Get add row
     *
     * @return array
     */
    protected function getAddRow()
    {
        global $Security;
        $rsnew = [];

        // dt_cadastro
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->getAutoUpdateValue(); // PHP
        $this->dt_cadastro->setDbValueDef($rsnew, UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern()), false);

        // processo_idprocesso
        $this->processo_idprocesso->setDbValueDef($rsnew, $this->processo_idprocesso->CurrentValue, false);

        // descricao
        $this->descricao->setDbValueDef($rsnew, $this->descricao->CurrentValue, false);

        // acao_imediata
        $this->acao_imediata->setDbValueDef($rsnew, $this->acao_imediata->CurrentValue, false);

        // acao_contecao
        $this->acao_contecao->setDbValueDef($rsnew, $this->acao_contecao->CurrentValue, false);

        // abrir_nc
        $this->abrir_nc->setDbValueDef($rsnew, $this->abrir_nc->CurrentValue, strval($this->abrir_nc->CurrentValue) == "");

        // relatorio_auditoria_interna_idrelatorio_auditoria_interna
        if ($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue() != "") {
            $rsnew['relatorio_auditoria_interna_idrelatorio_auditoria_interna'] = $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue();
        }
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['dt_cadastro'])) { // dt_cadastro
            $this->dt_cadastro->setFormValue($row['dt_cadastro']);
        }
        if (isset($row['processo_idprocesso'])) { // processo_idprocesso
            $this->processo_idprocesso->setFormValue($row['processo_idprocesso']);
        }
        if (isset($row['descricao'])) { // descricao
            $this->descricao->setFormValue($row['descricao']);
        }
        if (isset($row['acao_imediata'])) { // acao_imediata
            $this->acao_imediata->setFormValue($row['acao_imediata']);
        }
        if (isset($row['acao_contecao'])) { // acao_contecao
            $this->acao_contecao->setFormValue($row['acao_contecao']);
        }
        if (isset($row['abrir_nc'])) { // abrir_nc
            $this->abrir_nc->setFormValue($row['abrir_nc']);
        }
        if (isset($row['relatorio_auditoria_interna_idrelatorio_auditoria_interna'])) { // relatorio_auditoria_interna_idrelatorio_auditoria_interna
            $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->setFormValue($row['relatorio_auditoria_interna_idrelatorio_auditoria_interna']);
        }
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        $foreignKeys = [];
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "relatorio_auditoria_interna") {
                $validMaster = true;
                $masterTbl = Container("relatorio_auditoria_interna");
                if (($parm = Get("fk_idrelatorio_auditoria_interna", Get("relatorio_auditoria_interna_idrelatorio_auditoria_interna"))) !== null) {
                    $masterTbl->idrelatorio_auditoria_interna->setQueryStringValue($parm);
                    $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->QueryStringValue = $masterTbl->idrelatorio_auditoria_interna->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->setSessionValue($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->QueryStringValue);
                    $foreignKeys["relatorio_auditoria_interna_idrelatorio_auditoria_interna"] = $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->QueryStringValue;
                    if (!is_numeric($masterTbl->idrelatorio_auditoria_interna->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "relatorio_auditoria_interna") {
                $validMaster = true;
                $masterTbl = Container("relatorio_auditoria_interna");
                if (($parm = Post("fk_idrelatorio_auditoria_interna", Post("relatorio_auditoria_interna_idrelatorio_auditoria_interna"))) !== null) {
                    $masterTbl->idrelatorio_auditoria_interna->setFormValue($parm);
                    $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->FormValue = $masterTbl->idrelatorio_auditoria_interna->FormValue;
                    $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->setSessionValue($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->FormValue);
                    $foreignKeys["relatorio_auditoria_interna_idrelatorio_auditoria_interna"] = $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->FormValue;
                    if (!is_numeric($masterTbl->idrelatorio_auditoria_interna->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "relatorio_auditoria_interna") {
                if (!array_key_exists("relatorio_auditoria_interna_idrelatorio_auditoria_interna", $foreignKeys)) { // Not current foreign key
                    $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ItemRelAudInternaList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_processo_idprocesso":
                    break;
                case "x_abrir_nc":
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
