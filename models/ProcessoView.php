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
class ProcessoView extends Processo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ProcessoView";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ProcessoView";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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
        $this->idprocesso->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->revisao->setVisibility();
        $this->tipo_idtipo->setVisibility();
        $this->processo->setVisibility();
        $this->responsaveis->setVisibility();
        $this->objetivo->setVisibility();
        $this->proc_antes->setVisibility();
        $this->proc_depois->setVisibility();
        $this->eqpto_recursos->setVisibility();
        $this->entradas->setVisibility();
        $this->atividade_principal->setVisibility();
        $this->saidas_resultados->setVisibility();
        $this->requsito_saidas->setVisibility();
        $this->riscos->setVisibility();
        $this->oportunidades->setVisibility();
        $this->propriedade_externa->setVisibility();
        $this->conhecimentos->setVisibility();
        $this->documentos_aplicados->setVisibility();
        $this->proced_int_trabalho->setVisibility();
        $this->mapa->setVisibility();
        $this->formulario->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'processo';
        $this->TableName = 'processo';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-view-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (processo)
        if (!isset($GLOBALS["processo"]) || $GLOBALS["processo"]::class == PROJECT_NAMESPACE . "processo") {
            $GLOBALS["processo"] = &$this;
        }

        // Set up record key
        if (($keyValue = Get("idprocesso") ?? Route("idprocesso")) !== null) {
            $this->RecKey["idprocesso"] = $keyValue;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'processo');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // Export options
        $this->ExportOptions = new ListOptions(TagClassName: "ew-export-option");

        // Other options
        $this->OtherOptions = new ListOptionsArray();

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(TagClassName: "ew-detail-option");
        // Actions
        $this->OtherOptions["action"] = new ListOptions(TagClassName: "ew-action-option");
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
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "ProcessoView"); // If View page, no primary button
                } else { // List page
                    $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                    $this->clearFailureMessage();
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
            $key .= @$ar['idprocesso'];
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
            $this->idprocesso->Visible = false;
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
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;
    public $MultiPages; // Multi pages object

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

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportType = $this->Export; // Get export parameter, used in header
        if ($ExportType != "") {
            global $SkipHeaderFooter;
            $SkipHeaderFooter = true;
        }
        $this->CurrentAction = Param("action"); // Set up current action
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Set up multi page object
        $this->setupMultiPages();

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
        $this->setupLookupOptions($this->tipo_idtipo);
        $this->setupLookupOptions($this->responsaveis);
        $this->setupLookupOptions($this->proc_antes);
        $this->setupLookupOptions($this->proc_depois);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;
        if (Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) {
            $loadCurrentRecord = true;
        }
        if (($keyValue = Get("idprocesso") ?? Route("idprocesso")) !== null) {
            $this->idprocesso->setQueryStringValue($keyValue);
            $this->RecKey["idprocesso"] = $this->idprocesso->QueryStringValue;
        } elseif (Post("idprocesso") !== null) {
            $this->idprocesso->setFormValue(Post("idprocesso"));
            $this->RecKey["idprocesso"] = $this->idprocesso->FormValue;
        } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
            $this->idprocesso->setQueryStringValue($keyValue);
            $this->RecKey["idprocesso"] = $this->idprocesso->QueryStringValue;
        } elseif (!$loadCurrentRecord) {
            $returnUrl = "ProcessoList"; // Return to list
        }

        // Get action
        $this->CurrentAction = "show"; // Display
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$this->IsModal && !IsApi()) { // Normal view page
                    $this->StartRecord = 1; // Initialize start position
                    $this->Recordset = $this->loadRecordset(); // Load records
                    if ($this->TotalRecords <= 0) { // No record found
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("ProcessoList"); // Return to list page
                        return;
                    } elseif ($loadCurrentRecord) { // Load current record position
                        $this->setupStartRecord(); // Set up start record position
                        // Point to current record
                        if ($this->StartRecord <= $this->TotalRecords) {
                            $matchRecord = true;
                            $this->fetch($this->StartRecord);
                            // Redirect to correct record
                            $this->loadRowValues($this->CurrentRow);
                            $url = $this->getCurrentUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable());
                            $this->terminate($url);
                            return;
                        }
                    } else { // Match key values
                        while ($this->fetch()) {
                            if (SameString($this->idprocesso->CurrentValue, $this->CurrentRow['idprocesso'])) {
                                $this->setStartRecordNumber($this->StartRecord); // Save record position
                                $matchRecord = true;
                                break;
                            } else {
                                $this->StartRecord++;
                            }
                        }
                    }
                    if (!$matchRecord) {
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "ProcessoList"; // No matching record, return to list
                    } else {
                        $this->loadRowValues($this->CurrentRow); // Load row values
                    }
                } else {
                    // Load record based on key
                    if (IsApi()) {
                        $filter = $this->getRecordFilter();
                        $this->CurrentFilter = $filter;
                        $sql = $this->getCurrentSql();
                        $conn = $this->getConnection();
                        $res = ($this->Recordset = ExecuteQuery($sql, $conn));
                    } else {
                        $res = $this->loadRow();
                    }
                    if (!$res) { // Load record based on key
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "ProcessoList"; // No matching record, return to list
                    }
                } // End modal checking
                break;
        }

        // Setup export options
        $this->setupExportOptions();
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = RowType::VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Set up detail parameters
        $this->setupDetailParms();

        // Normal return
        if (IsApi()) {
            if (!$this->isExport()) {
                $row = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
                $this->Recordset?->free();
                WriteJson(["success" => true, "action" => Config("API_VIEW_ACTION"), $this->TableVar => $row]);
                $this->terminate(true);
            }
            return;
        }

        // Set up pager
        if (!$this->IsModal) { // Normal view page
            $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, "", $this->RecordRange, $this->AutoHidePager, false, false);
            $this->Pager->PageNumberName = Config("TABLE_PAGE_NUMBER");
            $this->Pager->PagePhraseId = "Record"; // Show as record
        }

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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Disable Add/Edit/Copy/Delete for Modal and UseAjaxActions
        /*
        if ($this->IsModal && $this->UseAjaxActions) {
            $this->AddUrl = "";
            $this->EditUrl = "";
            $this->CopyUrl = "";
            $this->DeleteUrl = "";
        }
        */
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = $this->EditUrl != "" && $Security->canEdit();

        // Copy
        $item = &$option->add("copy");
        $copycaption = HtmlTitle($Language->phrase("ViewPageCopyLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        }
        $item->Visible = $this->CopyUrl != "" && $Security->canAdd();

        // Delete
        $item = &$option->add("delete");
        $url = GetUrl($this->DeleteUrl);
        $item->Body = "<a class=\"ew-action ew-delete\"" .
            ($this->InlineDelete || $this->IsModal ? " data-ew-action=\"inline-delete\"" : "") .
            " title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) .
            "\" href=\"" . HtmlEncode($url) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        $item->Visible = $this->DeleteUrl != "" && $Security->canDelete();
        $option = $options["detail"];
        $detailTableLink = "";
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_processo_indicadores"
        $item = &$option->add("detail_processo_indicadores");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->tablePhrase("processo_indicadores", "TblCaption");
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("ProcessoIndicadoresList?" . Config("TABLE_SHOW_MASTER") . "=processo&" . GetForeignKeyUrl("fk_idprocesso", $this->idprocesso->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("ProcessoIndicadoresGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'processo')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=processo_indicadores"))) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "processo_indicadores";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'processo')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=processo_indicadores"))) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "processo_indicadores";
        }
        if ($detailPageObj->DetailAdd && $Security->canAdd() && $Security->allowAdd(CurrentProjectID() . 'processo')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailCopyLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=processo_indicadores"))) . "\">" . $Language->phrase("MasterDetailCopyLink", null) . "</a></li>";
            if ($detailCopyTblVar != "") {
                $detailCopyTblVar .= ",";
            }
            $detailCopyTblVar .= "processo_indicadores";
        }
        if ($links != "") {
            $body .= "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        } else {
            $body = preg_replace('/\b\s+dropdown-toggle\b/', "", $body);
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'processo_indicadores');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "processo_indicadores";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailViewLink", true)) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar))) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailEditLink", true)) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar))) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailCopyLink", true)) . "\" href=\"" . HtmlEncode(GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar))) . "\">" . $Language->phrase("MasterDetailCopyLink", null) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlEncode($Language->phrase("MultipleMasterDetails", true)) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-dropdown-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $item = &$option->add("details");
            $item->Body = $body;
        }

        // Set up detail default
        $option = $options["detail"];
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $ar = explode(",", $detailTableLink);
        $cnt = count($ar);
        $option->UseDropDownButton = ($cnt > 1);
        $option->UseButtonGroup = true;
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = !IsJsonResponse() && false;
        $option->UseButtonGroup = true;
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    /**
     * Load result set
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return Doctrine\DBAL\Result Result
     */
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        if (property_exists($this, "TotalRecords") && $rowcnt < 0) {
            $this->TotalRecords = $result->rowCount();
            if ($this->TotalRecords <= 0) { // Handle database drivers that does not return rowCount()
                $this->TotalRecords = $this->getRecordCount($this->getListSql());
            }
        }

        // Call Recordset Selected event
        $this->recordsetSelected($result);
        return $result;
    }

    /**
     * Load records as associative array
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return void
     */
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        return $result->fetchAllAssociative();
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
        $this->idprocesso->setDbValue($row['idprocesso']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->revisao->setDbValue($row['revisao']);
        $this->tipo_idtipo->setDbValue($row['tipo_idtipo']);
        $this->processo->setDbValue($row['processo']);
        $this->responsaveis->setDbValue($row['responsaveis']);
        $this->objetivo->setDbValue($row['objetivo']);
        $this->proc_antes->setDbValue($row['proc_antes']);
        $this->proc_depois->setDbValue($row['proc_depois']);
        $this->eqpto_recursos->setDbValue($row['eqpto_recursos']);
        $this->entradas->setDbValue($row['entradas']);
        $this->atividade_principal->setDbValue($row['atividade_principal']);
        $this->saidas_resultados->setDbValue($row['saidas_resultados']);
        $this->requsito_saidas->setDbValue($row['requsito_saidas']);
        $this->riscos->setDbValue($row['riscos']);
        $this->oportunidades->setDbValue($row['oportunidades']);
        $this->propriedade_externa->setDbValue($row['propriedade_externa']);
        $this->conhecimentos->setDbValue($row['conhecimentos']);
        $this->documentos_aplicados->setDbValue($row['documentos_aplicados']);
        $this->proced_int_trabalho->Upload->DbValue = $row['proced_int_trabalho'];
        $this->proced_int_trabalho->setDbValue($this->proced_int_trabalho->Upload->DbValue);
        $this->mapa->Upload->DbValue = $row['mapa'];
        $this->mapa->setDbValue($this->mapa->Upload->DbValue);
        $this->formulario->Upload->DbValue = $row['formulario'];
        $this->formulario->setDbValue($this->formulario->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idprocesso'] = $this->idprocesso->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['revisao'] = $this->revisao->DefaultValue;
        $row['tipo_idtipo'] = $this->tipo_idtipo->DefaultValue;
        $row['processo'] = $this->processo->DefaultValue;
        $row['responsaveis'] = $this->responsaveis->DefaultValue;
        $row['objetivo'] = $this->objetivo->DefaultValue;
        $row['proc_antes'] = $this->proc_antes->DefaultValue;
        $row['proc_depois'] = $this->proc_depois->DefaultValue;
        $row['eqpto_recursos'] = $this->eqpto_recursos->DefaultValue;
        $row['entradas'] = $this->entradas->DefaultValue;
        $row['atividade_principal'] = $this->atividade_principal->DefaultValue;
        $row['saidas_resultados'] = $this->saidas_resultados->DefaultValue;
        $row['requsito_saidas'] = $this->requsito_saidas->DefaultValue;
        $row['riscos'] = $this->riscos->DefaultValue;
        $row['oportunidades'] = $this->oportunidades->DefaultValue;
        $row['propriedade_externa'] = $this->propriedade_externa->DefaultValue;
        $row['conhecimentos'] = $this->conhecimentos->DefaultValue;
        $row['documentos_aplicados'] = $this->documentos_aplicados->DefaultValue;
        $row['proced_int_trabalho'] = $this->proced_int_trabalho->DefaultValue;
        $row['mapa'] = $this->mapa->DefaultValue;
        $row['formulario'] = $this->formulario->DefaultValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // idprocesso

        // dt_cadastro

        // revisao

        // tipo_idtipo

        // processo

        // responsaveis

        // objetivo

        // proc_antes

        // proc_depois

        // eqpto_recursos

        // entradas

        // atividade_principal

        // saidas_resultados

        // requsito_saidas

        // riscos

        // oportunidades

        // propriedade_externa

        // conhecimentos

        // documentos_aplicados

        // proced_int_trabalho

        // mapa

        // formulario

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idprocesso
            $this->idprocesso->ViewValue = $this->idprocesso->CurrentValue;

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // revisao
            $this->revisao->ViewValue = $this->revisao->CurrentValue;
            $this->revisao->CssClass = "fw-bold";
            $this->revisao->CellCssStyle .= "text-align: center;";

            // tipo_idtipo
            $curVal = strval($this->tipo_idtipo->CurrentValue);
            if ($curVal != "") {
                $this->tipo_idtipo->ViewValue = $this->tipo_idtipo->lookupCacheOption($curVal);
                if ($this->tipo_idtipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchExpression(), "=", $curVal, $this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchDataType(), "");
                    $sqlWrk = $this->tipo_idtipo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_idtipo->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_idtipo->ViewValue = $this->tipo_idtipo->displayValue($arwrk);
                    } else {
                        $this->tipo_idtipo->ViewValue = FormatNumber($this->tipo_idtipo->CurrentValue, $this->tipo_idtipo->formatPattern());
                    }
                }
            } else {
                $this->tipo_idtipo->ViewValue = null;
            }
            $this->tipo_idtipo->CssClass = "fw-bold";

            // processo
            $this->processo->ViewValue = $this->processo->CurrentValue;
            $this->processo->CssClass = "fw-bold";

            // responsaveis
            $curVal = strval($this->responsaveis->CurrentValue);
            if ($curVal != "") {
                $this->responsaveis->ViewValue = $this->responsaveis->lookupCacheOption($curVal);
                if ($this->responsaveis->ViewValue === null) { // Lookup from database
                    $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        AddFilter($filterWrk, SearchFilter($this->responsaveis->Lookup->getTable()->Fields["iddepartamentos"]->searchExpression(), "=", trim($wrk), $this->responsaveis->Lookup->getTable()->Fields["iddepartamentos"]->searchDataType(), ""), "OR");
                    }
                    $sqlWrk = $this->responsaveis->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->responsaveis->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->responsaveis->Lookup->renderViewRow($row);
                            $this->responsaveis->ViewValue->add($this->responsaveis->displayValue($arwrk));
                        }
                    } else {
                        $this->responsaveis->ViewValue = $this->responsaveis->CurrentValue;
                    }
                }
            } else {
                $this->responsaveis->ViewValue = null;
            }
            $this->responsaveis->CssClass = "fw-bold";

            // objetivo
            $this->objetivo->ViewValue = $this->objetivo->CurrentValue;
            $this->objetivo->CssClass = "fw-bold";

            // proc_antes
            $curVal = strval($this->proc_antes->CurrentValue);
            if ($curVal != "") {
                $this->proc_antes->ViewValue = $this->proc_antes->lookupCacheOption($curVal);
                if ($this->proc_antes->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->proc_antes->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $curVal, $this->proc_antes->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                    $lookupFilter = $this->proc_antes->getSelectFilter($this); // PHP
                    $sqlWrk = $this->proc_antes->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->proc_antes->Lookup->renderViewRow($rswrk[0]);
                        $this->proc_antes->ViewValue = $this->proc_antes->displayValue($arwrk);
                    } else {
                        $this->proc_antes->ViewValue = FormatNumber($this->proc_antes->CurrentValue, $this->proc_antes->formatPattern());
                    }
                }
            } else {
                $this->proc_antes->ViewValue = null;
            }
            $this->proc_antes->CssClass = "fw-bold";

            // proc_depois
            $curVal = strval($this->proc_depois->CurrentValue);
            if ($curVal != "") {
                $this->proc_depois->ViewValue = $this->proc_depois->lookupCacheOption($curVal);
                if ($this->proc_depois->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->proc_depois->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $curVal, $this->proc_depois->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                    $lookupFilter = $this->proc_depois->getSelectFilter($this); // PHP
                    $sqlWrk = $this->proc_depois->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->proc_depois->Lookup->renderViewRow($rswrk[0]);
                        $this->proc_depois->ViewValue = $this->proc_depois->displayValue($arwrk);
                    } else {
                        $this->proc_depois->ViewValue = FormatNumber($this->proc_depois->CurrentValue, $this->proc_depois->formatPattern());
                    }
                }
            } else {
                $this->proc_depois->ViewValue = null;
            }
            $this->proc_depois->CssClass = "fw-bold";

            // eqpto_recursos
            $this->eqpto_recursos->ViewValue = $this->eqpto_recursos->CurrentValue;
            $this->eqpto_recursos->CssClass = "fw-bold";

            // entradas
            $this->entradas->ViewValue = $this->entradas->CurrentValue;
            $this->entradas->CssClass = "fw-bold";

            // atividade_principal
            $this->atividade_principal->ViewValue = $this->atividade_principal->CurrentValue;
            $this->atividade_principal->CssClass = "fw-bold";

            // saidas_resultados
            $this->saidas_resultados->ViewValue = $this->saidas_resultados->CurrentValue;
            $this->saidas_resultados->CssClass = "fw-bold";

            // requsito_saidas
            $this->requsito_saidas->ViewValue = $this->requsito_saidas->CurrentValue;
            $this->requsito_saidas->CssClass = "fw-bold";

            // riscos
            $this->riscos->ViewValue = $this->riscos->CurrentValue;
            $this->riscos->CssClass = "fw-bold";

            // oportunidades
            $this->oportunidades->ViewValue = $this->oportunidades->CurrentValue;
            $this->oportunidades->CssClass = "fw-bold";

            // propriedade_externa
            $this->propriedade_externa->ViewValue = $this->propriedade_externa->CurrentValue;
            $this->propriedade_externa->CssClass = "fw-bold";

            // conhecimentos
            $this->conhecimentos->ViewValue = $this->conhecimentos->CurrentValue;
            $this->conhecimentos->CssClass = "fw-bold";

            // documentos_aplicados
            $this->documentos_aplicados->ViewValue = $this->documentos_aplicados->CurrentValue;
            $this->documentos_aplicados->CssClass = "fw-bold";

            // proced_int_trabalho
            if (!EmptyValue($this->proced_int_trabalho->Upload->DbValue)) {
                $this->proced_int_trabalho->ViewValue = $this->proced_int_trabalho->Upload->DbValue;
            } else {
                $this->proced_int_trabalho->ViewValue = "";
            }
            $this->proced_int_trabalho->CssClass = "fw-bold";

            // mapa
            if (!EmptyValue($this->mapa->Upload->DbValue)) {
                $this->mapa->ViewValue = $this->mapa->Upload->DbValue;
            } else {
                $this->mapa->ViewValue = "";
            }
            $this->mapa->CssClass = "fw-bold";

            // formulario
            if (!EmptyValue($this->formulario->Upload->DbValue)) {
                $this->formulario->ViewValue = $this->formulario->Upload->DbValue;
            } else {
                $this->formulario->ViewValue = "";
            }
            $this->formulario->CssClass = "fw-bold";

            // idprocesso
            $this->idprocesso->HrefValue = "";
            $this->idprocesso->TooltipValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";
            $this->dt_cadastro->TooltipValue = "";

            // revisao
            $this->revisao->HrefValue = "";
            $this->revisao->TooltipValue = "";

            // tipo_idtipo
            $this->tipo_idtipo->HrefValue = "";
            $this->tipo_idtipo->TooltipValue = "";

            // processo
            $this->processo->HrefValue = "";
            $this->processo->TooltipValue = "";

            // responsaveis
            $this->responsaveis->HrefValue = "";
            $this->responsaveis->TooltipValue = "";

            // objetivo
            $this->objetivo->HrefValue = "";
            $this->objetivo->TooltipValue = "";

            // proc_antes
            $this->proc_antes->HrefValue = "";
            $this->proc_antes->TooltipValue = "";

            // proc_depois
            $this->proc_depois->HrefValue = "";
            $this->proc_depois->TooltipValue = "";

            // eqpto_recursos
            $this->eqpto_recursos->HrefValue = "";
            $this->eqpto_recursos->TooltipValue = "";

            // entradas
            $this->entradas->HrefValue = "";
            $this->entradas->TooltipValue = "";

            // atividade_principal
            $this->atividade_principal->HrefValue = "";
            $this->atividade_principal->TooltipValue = "";

            // saidas_resultados
            $this->saidas_resultados->HrefValue = "";
            $this->saidas_resultados->TooltipValue = "";

            // requsito_saidas
            $this->requsito_saidas->HrefValue = "";
            $this->requsito_saidas->TooltipValue = "";

            // riscos
            $this->riscos->HrefValue = "";
            $this->riscos->TooltipValue = "";

            // oportunidades
            $this->oportunidades->HrefValue = "";
            $this->oportunidades->TooltipValue = "";

            // propriedade_externa
            $this->propriedade_externa->HrefValue = "";
            $this->propriedade_externa->TooltipValue = "";

            // conhecimentos
            $this->conhecimentos->HrefValue = "";
            $this->conhecimentos->TooltipValue = "";

            // documentos_aplicados
            $this->documentos_aplicados->HrefValue = "";
            $this->documentos_aplicados->TooltipValue = "";

            // proced_int_trabalho
            $this->proced_int_trabalho->HrefValue = "";
            $this->proced_int_trabalho->ExportHrefValue = $this->proced_int_trabalho->UploadPath . $this->proced_int_trabalho->Upload->DbValue;
            $this->proced_int_trabalho->TooltipValue = "";

            // mapa
            $this->mapa->HrefValue = "";
            $this->mapa->ExportHrefValue = $this->mapa->UploadPath . $this->mapa->Upload->DbValue;
            $this->mapa->TooltipValue = "";

            // formulario
            $this->formulario->HrefValue = "";
            $this->formulario->ExportHrefValue = $this->formulario->UploadPath . $this->formulario->Upload->DbValue;
            $this->formulario->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        if ($type == "print" || $custom) { // Printer friendly / custom export
            $pageUrl = $this->pageUrl(true);
            $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        } else { // Export API URL
            $exportUrl = GetApiUrl(Config("API_EXPORT_ACTION") . "/" . $type . "/" . $this->TableVar);
            $exportUrl .= "/" . $this->getKey(true, "/");
        }
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fprocessoview\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fprocessoview\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fprocessoview\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\">" . $Language->phrase("ExportToPdf") . "</a>";
            }
        } elseif (SameText($type, "html")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtml", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtml", true)) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
        } elseif (SameText($type, "xml")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXml", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXml", true)) . "\">" . $Language->phrase("ExportToXml") . "</a>";
        } elseif (SameText($type, "csv")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsv", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsv", true)) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
        } elseif (SameText($type, "email")) {
            $url = $custom ? ' data-url="' . $exportUrl . '"' : '';
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fprocessoview" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-key="' . ArrayToJsonAttribute($this->RecKey) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language, $Security;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = true;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = true;

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = true;

        // Export to XML
        $item = &$this->ExportOptions->add("xml");
        $item->Body = $this->getExportTag("xml");
        $item->Visible = false;

        // Export to CSV
        $item = &$this->ExportOptions->add("csv");
        $item->Body = $this->getExportTag("csv");
        $item->Visible = false;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = true;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = true;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide options for export
        if ($this->isExport()) {
            $this->ExportOptions->hideAllOptions();
        }

        // Hide options if json response
        if (IsJsonResponse()) {
            $this->ExportOptions->hideAllOptions();
        }
        if (!$Security->canExport()) { // Export not allowed
            $this->ExportOptions->hideAllOptions();
        }
    }

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param bool $return Return the data rather than output it
    * @return mixed
    */
    public function exportData($doc, $keys)
    {
        global $Language;
        $rs = null;
        if (count($keys) >= 1) {
            $this->idprocesso->OldValue = $keys[0];
            $rs = $this->loadRs($this->getRecordFilter());
        }
        if (!$rs || !$doc) {
            RemoveHeader("Content-Type"); // Remove header
            RemoveHeader("Content-Disposition");
            $this->showMessage();
            return;
        }
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords;

        // Call Page Exporting server event
        $doc->ExportCustom = !$this->pageExporting($doc);

        // Page header
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        $doc->Text .= $header;
        $this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "view");

        // Set up detail parameters
        $this->setupDetailParms();

        // Export detail records (processo_indicadores)
        if (Config("EXPORT_DETAIL_RECORDS") && in_array("processo_indicadores", explode(",", $this->getCurrentDetailTable()))) {
            $processo_indicadores = new ProcessoIndicadoresList();
            $rsdetail = $processo_indicadores->loadRs($processo_indicadores->getDetailFilterFromSession(), $processo_indicadores->getSessionOrderBy()); // Load detail records
            if ($rsdetail) {
                $exportStyle = $doc->Style;
                $doc->setStyle("h"); // Change to horizontal
                if (!$this->isExport("csv") || Config("EXPORT_DETAIL_RECORDS_FOR_CSV")) {
                    $doc->exportEmptyRow();
                    $detailcnt = $rsdetail->rowCount();
                    $oldtbl = $doc->getTable();
                    $doc->setTable($processo_indicadores);
                    $processo_indicadores->exportDocument($doc, $rsdetail, 1, $detailcnt);
                    $doc->setTable($oldtbl);
                }
                $doc->setStyle($exportStyle); // Restore
            }
        }
        $rs->free();

        // Page footer
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        $doc->Text .= $footer;

        // Export header and footer
        $doc->exportHeaderAndFooter();

        // Call Page Exported server event
        $this->pageExported($doc);
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("processo_indicadores", $detailTblVar)) {
                $detailPageObj = Container("ProcessoIndicadoresGrid");
                if ($detailPageObj->DetailView) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "view";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->processo_idprocesso->IsDetailKey = true;
                    $detailPageObj->processo_idprocesso->CurrentValue = $this->idprocesso->CurrentValue;
                    $detailPageObj->processo_idprocesso->setSessionValue($detailPageObj->processo_idprocesso->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ProcessoList"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
    }

    // Set up multi pages
    protected function setupMultiPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        if ($pages->isAccordion()) {
            $pages->Parent = "#accordion_" . $this->PageObjName;
        }
        $pages->add(0);
        $pages->add(1);
        $pages->add(2);
        $pages->add(3);
        $pages->add(4);
        $pages->add(5);
        $pages->add(6);
        $this->MultiPages = $pages;
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
                case "x_tipo_idtipo":
                    break;
                case "x_responsaveis":
                    break;
                case "x_proc_antes":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_proc_depois":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = false;
        $recordNo = $pageNo ?? $startRec; // Record number = page number or start record
        if ($recordNo !== null && is_numeric($recordNo)) {
            $this->StartRecord = $recordNo;
        } else {
            $this->StartRecord = $this->getStartRecordNumber();
        }

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || intval($this->StartRecord) <= 0) { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
        }
        if (!$infiniteScroll) {
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Get page count
    public function pageCount() {
        return ceil($this->TotalRecords / $this->DisplayRecords);
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

    // Page Exporting event
    // $doc = export object
    public function pageExporting(&$doc)
    {
        //$doc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $doc = export document object
    public function rowExport($doc, $rs)
    {
        //$doc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $doc = export document object
    public function pageExported($doc)
    {
        //$doc->Text .= "my footer"; // Export footer
        //Log($doc->Text);
    }
}
