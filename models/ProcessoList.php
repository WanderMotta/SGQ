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
class ProcessoList extends Processo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ProcessoList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fprocessolist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ProcessoList";

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
        $this->idprocesso->Visible = false;
        $this->dt_cadastro->setVisibility();
        $this->revisao->setVisibility();
        $this->tipo_idtipo->setVisibility();
        $this->processo->setVisibility();
        $this->responsaveis->setVisibility();
        $this->objetivo->Visible = false;
        $this->proc_antes->Visible = false;
        $this->proc_depois->Visible = false;
        $this->eqpto_recursos->Visible = false;
        $this->entradas->setVisibility();
        $this->atividade_principal->setVisibility();
        $this->saidas_resultados->setVisibility();
        $this->requsito_saidas->Visible = false;
        $this->riscos->Visible = false;
        $this->oportunidades->Visible = false;
        $this->propriedade_externa->Visible = false;
        $this->conhecimentos->Visible = false;
        $this->documentos_aplicados->Visible = false;
        $this->proced_int_trabalho->Visible = false;
        $this->mapa->Visible = false;
        $this->formulario->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'processo';
        $this->TableName = 'processo';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

        // CSS class name as context
        $this->ContextClass = CheckClassName($this->TableVar);
        AppendClass($this->TableGridClass, $this->ContextClass);

        // Fixed header table
        if (!$this->UseCustomTemplate) {
            $this->setFixedHeaderTable(Config("USE_FIXED_HEADER_TABLE"), Config("FIXED_HEADER_TABLE_HEIGHT"));
        }

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (processo)
        if (!isset($GLOBALS["processo"]) || $GLOBALS["processo"]::class == PROJECT_NAMESPACE . "processo") {
            $GLOBALS["processo"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ProcessoAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ProcessoDelete";
        $this->MultiUpdateUrl = "ProcessoUpdate";

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

        // List options
        $this->ListOptions = new ListOptions(Tag: "td", TableVar: $this->TableVar);

        // Export options
        $this->ExportOptions = new ListOptions(TagClassName: "ew-export-option");

        // Import options
        $this->ImportOptions = new ListOptions(TagClassName: "ew-import-option");

        // Other options
        $this->OtherOptions = new ListOptionsArray();

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions(
            TagClassName: "ew-add-edit-option",
            UseDropDownButton: false,
            DropDownButtonPhrase: $Language->phrase("ButtonAddEdit"),
            UseButtonGroup: true
        );

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(TagClassName: "ew-detail-option");
        // Actions
        $this->OtherOptions["action"] = new ListOptions(TagClassName: "ew-action-option");

        // Column visibility
        $this->OtherOptions["column"] = new ListOptions(
            TableVar: $this->TableVar,
            TagClassName: "ew-column-option",
            ButtonGroupClass: "ew-column-dropdown",
            UseDropDownButton: true,
            DropDownButtonPhrase: $Language->phrase("Columns"),
            DropDownAutoClose: "outside",
            UseButtonGroup: false
        );

        // Filter options
        $this->FilterOptions = new ListOptions(TagClassName: "ew-filter-option");

        // List actions
        $this->ListActions = new ListActions();
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
                        if ($fld->DataType == DataType::MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $HeaderOptions; // Header options
    public $FooterOptions; // Footer options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 50;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $InlineRowCount = 0;
    public $StartRowCount = 1;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $MultiColumnGridClass = "row-cols-md";
    public $MultiColumnEditClass = "col-12 w-100";
    public $MultiColumnCardClass = "card h-100 ew-card";
    public $MultiColumnListOptionsPosition = "bottom-start";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $UserAction; // User action
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $TopContentClass = "ew-top";
    public $MiddleContentClass = "ew-middle";
    public $BottomContentClass = "ew-bottom";
    public $PageAction;
    public $RecKeys = [];
    public $IsModal = false;
    protected $FilterForModalActions = "";
    private $UseInfiniteScroll = false;

    /**
     * Load result set from filter
     *
     * @return void
     */
    public function loadRecordsetFromFilter($filter)
    {
        // Set up list options
        $this->setupListOptions();

        // Search options
        $this->setupSearchOptions();

        // Other options
        $this->setupOtherOptions();

        // Set visibility
        $this->setVisibility();

        // Load result set
        $this->TotalRecords = $this->loadRecordCount($filter);
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords;
        $this->CurrentFilter = $filter;
        $this->Recordset = $this->loadRecordset();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);
    }

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $DashboardReport;

        // Multi column button position
        $this->MultiColumnListOptionsPosition = Config("MULTI_COLUMN_LIST_OPTIONS_POSITION");
        $DashboardReport ??= Param(Config("PAGE_DASHBOARD"));

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));

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

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();

        // Setup export options
        $this->setupExportOptions();
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
        $this->setupLookupOptions($this->tipo_idtipo);
        $this->setupLookupOptions($this->responsaveis);
        $this->setupLookupOptions($this->proc_antes);
        $this->setupLookupOptions($this->proc_depois);

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fprocessogrid";
        }

        // Set up page action
        $this->PageAction = CurrentPageUrl(false);

        // Set up infinite scroll
        $this->UseInfiniteScroll = ConvertToBool(Param("infinitescroll"));

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $query = ""; // Query builder

        // Set up Dashboard Filter
        if ($DashboardReport) {
            AddFilter($this->Filter, $this->getDashboardFilter($DashboardReport, $this->TableVar));
        }

        // Get command
        $this->Command = strtolower(Get("cmd", ""));

        // Process list action first
        if ($this->processListAction()) { // Ajax request
            $this->terminate();
            return;
        }

        // Set up records per page
        $this->setupDisplayRecords();

        // Handle reset command
        $this->resetCmd();

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Hide list options
        if ($this->isExport()) {
            $this->ListOptions->hideAllOptions(["sequence"]);
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        } elseif ($this->isGridAdd() || $this->isGridEdit() || $this->isMultiEdit() || $this->isConfirm()) {
            $this->ListOptions->hideAllOptions();
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        }

        // Hide options
        if ($this->isExport() || !(EmptyValue($this->CurrentAction) || $this->isSearch())) {
            $this->ExportOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
            $this->ImportOptions->hideAllOptions();
        }

        // Hide other options
        if ($this->isExport()) {
            $this->OtherOptions->hideAllOptions();
        }

        // Get default search criteria
        AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));
        AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

        // Get basic search values
        $this->loadBasicSearchValues();

        // Get and validate search values for advanced search
        if (EmptyValue($this->UserAction)) { // Skip if user action
            $this->loadSearchValues();
        }

        // Process filter list
        if ($this->processFilterList()) {
            $this->terminate();
            return;
        }
        if (!$this->validateSearch()) {
            // Nothing to do
        }

        // Restore search parms from Session if not searching / reset / export
        if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
            $this->restoreSearchParms();
        }

        // Call Recordset SearchValidated event
        $this->recordsetSearchValidated();

        // Set up sorting order
        $this->setupSortOrder();

        // Get basic search criteria
        if (!$this->hasInvalidFields()) {
            $srchBasic = $this->basicSearchWhere();
        }

        // Get advanced search criteria
        if (!$this->hasInvalidFields()) {
            $srchAdvanced = $this->advancedSearchWhere();
        }

        // Get query builder criteria
        $query = $DashboardReport ? "" : $this->queryBuilderWhere();

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 50; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms() && !$query) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere(); // Save to session
            }

            // Load advanced search from default
            if ($this->loadAdvancedSearchDefault()) {
                $srchAdvanced = $this->advancedSearchWhere(); // Save to session
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Build search criteria
        if ($query) {
            AddFilter($this->SearchWhere, $query);
        } else {
            AddFilter($this->SearchWhere, $srchAdvanced);
            AddFilter($this->SearchWhere, $srchBasic);
        }

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json" && !$query) {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        if (!$Security->canList()) {
            $this->Filter = "(0=1)"; // Filter all records
        }
        AddFilter($this->Filter, $this->DbDetailFilter);
        AddFilter($this->Filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $this->Filter;
        } else {
            $this->setSessionWhere($this->Filter);
            $this->CurrentFilter = "";
        }
        $this->Filter = $this->applyUserIDFilters($this->Filter);
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } elseif (($this->isEdit() || $this->isCopy() || $this->isInlineInserted() || $this->isInlineUpdated()) && $this->UseInfiniteScroll) { // Get current record only
            $this->CurrentFilter = $this->isInlineUpdated() ? $this->getRecordFilter() : $this->getFilterFromRecordKeys();
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Recordset = $this->loadRecordset();
        } elseif (
            $this->UseInfiniteScroll && $this->isGridInserted() ||
            $this->UseInfiniteScroll && ($this->isGridEdit() || $this->isGridUpdated()) ||
            $this->isMultiEdit() ||
            $this->UseInfiniteScroll && $this->isMultiUpdated()
        ) { // Get current records only
            $this->CurrentFilter = $this->FilterForModalActions; // Restore filter
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Recordset = $this->loadRecordset();
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if ((EmptyValue($this->CurrentAction) || $this->isSearch()) && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Set up list action columns
        foreach ($this->ListActions as $listAction) {
            if ($listAction->Allowed) {
                if ($listAction->Select == ACTION_MULTIPLE) { // Show checkbox column if multiple action
                    $this->ListOptions["checkbox"]->Visible = true;
                } elseif ($listAction->Select == ACTION_SINGLE) { // Show list action column
                        $this->ListOptions["listactions"]->Visible = true; // Set visible if any list action is allowed
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            if ($query) { // Hide search panel if using QueryBuilder
                RemoveClass($this->SearchPanelClass, "show");
            } else {
                AppendClass($this->SearchPanelClass, "show");
            }
        }

        // API list action
        if (IsApi()) {
            if (Route(0) == Config("API_LIST_ACTION")) {
                if (!$this->isExport()) {
                    $rows = $this->getRecordsFromRecordset($this->Recordset);
                    $this->Recordset?->free();
                    WriteJson([
                        "success" => true,
                        "action" => Config("API_LIST_ACTION"),
                        $this->TableVar => $rows,
                        "totalRecordCount" => $this->TotalRecords
                    ]);
                    $this->terminate(true);
                }
                return;
            } elseif ($this->getFailureMessage() != "") {
                WriteJson(["error" => $this->getFailureMessage()]);
                $this->clearFailureMessage();
                $this->terminate(true);
                return;
            }
        }

        // Render other options
        $this->renderOtherOptions();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Set ReturnUrl in header if necessary
        if ($returnUrl = Container("app.flash")->getFirstMessage("Return-Url")) {
            AddHeader("Return-Url", GetUrl($returnUrl));
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

    // Get page number
    public function getPageNumber()
    {
        return ($this->DisplayRecords > 0 && $this->StartRecord > 0) ? ceil($this->StartRecord / $this->DisplayRecords) : 1;
    }

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 50; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Get list of filters
    public function getFilterList()
    {
        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->idprocesso->AdvancedSearch->toJson(), ","); // Field idprocesso
        $filterList = Concat($filterList, $this->dt_cadastro->AdvancedSearch->toJson(), ","); // Field dt_cadastro
        $filterList = Concat($filterList, $this->revisao->AdvancedSearch->toJson(), ","); // Field revisao
        $filterList = Concat($filterList, $this->tipo_idtipo->AdvancedSearch->toJson(), ","); // Field tipo_idtipo
        $filterList = Concat($filterList, $this->processo->AdvancedSearch->toJson(), ","); // Field processo
        $filterList = Concat($filterList, $this->responsaveis->AdvancedSearch->toJson(), ","); // Field responsaveis
        $filterList = Concat($filterList, $this->objetivo->AdvancedSearch->toJson(), ","); // Field objetivo
        $filterList = Concat($filterList, $this->proc_antes->AdvancedSearch->toJson(), ","); // Field proc_antes
        $filterList = Concat($filterList, $this->proc_depois->AdvancedSearch->toJson(), ","); // Field proc_depois
        $filterList = Concat($filterList, $this->eqpto_recursos->AdvancedSearch->toJson(), ","); // Field eqpto_recursos
        $filterList = Concat($filterList, $this->entradas->AdvancedSearch->toJson(), ","); // Field entradas
        $filterList = Concat($filterList, $this->atividade_principal->AdvancedSearch->toJson(), ","); // Field atividade_principal
        $filterList = Concat($filterList, $this->saidas_resultados->AdvancedSearch->toJson(), ","); // Field saidas_resultados
        $filterList = Concat($filterList, $this->requsito_saidas->AdvancedSearch->toJson(), ","); // Field requsito_saidas
        $filterList = Concat($filterList, $this->riscos->AdvancedSearch->toJson(), ","); // Field riscos
        $filterList = Concat($filterList, $this->oportunidades->AdvancedSearch->toJson(), ","); // Field oportunidades
        $filterList = Concat($filterList, $this->propriedade_externa->AdvancedSearch->toJson(), ","); // Field propriedade_externa
        $filterList = Concat($filterList, $this->conhecimentos->AdvancedSearch->toJson(), ","); // Field conhecimentos
        $filterList = Concat($filterList, $this->documentos_aplicados->AdvancedSearch->toJson(), ","); // Field documentos_aplicados
        $filterList = Concat($filterList, $this->proced_int_trabalho->AdvancedSearch->toJson(), ","); // Field proced_int_trabalho
        $filterList = Concat($filterList, $this->mapa->AdvancedSearch->toJson(), ","); // Field mapa
        $filterList = Concat($filterList, $this->formulario->AdvancedSearch->toJson(), ","); // Field formulario
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            Profile()->setSearchFilters("fprocessosrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field idprocesso
        $this->idprocesso->AdvancedSearch->SearchValue = @$filter["x_idprocesso"];
        $this->idprocesso->AdvancedSearch->SearchOperator = @$filter["z_idprocesso"];
        $this->idprocesso->AdvancedSearch->SearchCondition = @$filter["v_idprocesso"];
        $this->idprocesso->AdvancedSearch->SearchValue2 = @$filter["y_idprocesso"];
        $this->idprocesso->AdvancedSearch->SearchOperator2 = @$filter["w_idprocesso"];
        $this->idprocesso->AdvancedSearch->save();

        // Field dt_cadastro
        $this->dt_cadastro->AdvancedSearch->SearchValue = @$filter["x_dt_cadastro"];
        $this->dt_cadastro->AdvancedSearch->SearchOperator = @$filter["z_dt_cadastro"];
        $this->dt_cadastro->AdvancedSearch->SearchCondition = @$filter["v_dt_cadastro"];
        $this->dt_cadastro->AdvancedSearch->SearchValue2 = @$filter["y_dt_cadastro"];
        $this->dt_cadastro->AdvancedSearch->SearchOperator2 = @$filter["w_dt_cadastro"];
        $this->dt_cadastro->AdvancedSearch->save();

        // Field revisao
        $this->revisao->AdvancedSearch->SearchValue = @$filter["x_revisao"];
        $this->revisao->AdvancedSearch->SearchOperator = @$filter["z_revisao"];
        $this->revisao->AdvancedSearch->SearchCondition = @$filter["v_revisao"];
        $this->revisao->AdvancedSearch->SearchValue2 = @$filter["y_revisao"];
        $this->revisao->AdvancedSearch->SearchOperator2 = @$filter["w_revisao"];
        $this->revisao->AdvancedSearch->save();

        // Field tipo_idtipo
        $this->tipo_idtipo->AdvancedSearch->SearchValue = @$filter["x_tipo_idtipo"];
        $this->tipo_idtipo->AdvancedSearch->SearchOperator = @$filter["z_tipo_idtipo"];
        $this->tipo_idtipo->AdvancedSearch->SearchCondition = @$filter["v_tipo_idtipo"];
        $this->tipo_idtipo->AdvancedSearch->SearchValue2 = @$filter["y_tipo_idtipo"];
        $this->tipo_idtipo->AdvancedSearch->SearchOperator2 = @$filter["w_tipo_idtipo"];
        $this->tipo_idtipo->AdvancedSearch->save();

        // Field processo
        $this->processo->AdvancedSearch->SearchValue = @$filter["x_processo"];
        $this->processo->AdvancedSearch->SearchOperator = @$filter["z_processo"];
        $this->processo->AdvancedSearch->SearchCondition = @$filter["v_processo"];
        $this->processo->AdvancedSearch->SearchValue2 = @$filter["y_processo"];
        $this->processo->AdvancedSearch->SearchOperator2 = @$filter["w_processo"];
        $this->processo->AdvancedSearch->save();

        // Field responsaveis
        $this->responsaveis->AdvancedSearch->SearchValue = @$filter["x_responsaveis"];
        $this->responsaveis->AdvancedSearch->SearchOperator = @$filter["z_responsaveis"];
        $this->responsaveis->AdvancedSearch->SearchCondition = @$filter["v_responsaveis"];
        $this->responsaveis->AdvancedSearch->SearchValue2 = @$filter["y_responsaveis"];
        $this->responsaveis->AdvancedSearch->SearchOperator2 = @$filter["w_responsaveis"];
        $this->responsaveis->AdvancedSearch->save();

        // Field objetivo
        $this->objetivo->AdvancedSearch->SearchValue = @$filter["x_objetivo"];
        $this->objetivo->AdvancedSearch->SearchOperator = @$filter["z_objetivo"];
        $this->objetivo->AdvancedSearch->SearchCondition = @$filter["v_objetivo"];
        $this->objetivo->AdvancedSearch->SearchValue2 = @$filter["y_objetivo"];
        $this->objetivo->AdvancedSearch->SearchOperator2 = @$filter["w_objetivo"];
        $this->objetivo->AdvancedSearch->save();

        // Field proc_antes
        $this->proc_antes->AdvancedSearch->SearchValue = @$filter["x_proc_antes"];
        $this->proc_antes->AdvancedSearch->SearchOperator = @$filter["z_proc_antes"];
        $this->proc_antes->AdvancedSearch->SearchCondition = @$filter["v_proc_antes"];
        $this->proc_antes->AdvancedSearch->SearchValue2 = @$filter["y_proc_antes"];
        $this->proc_antes->AdvancedSearch->SearchOperator2 = @$filter["w_proc_antes"];
        $this->proc_antes->AdvancedSearch->save();

        // Field proc_depois
        $this->proc_depois->AdvancedSearch->SearchValue = @$filter["x_proc_depois"];
        $this->proc_depois->AdvancedSearch->SearchOperator = @$filter["z_proc_depois"];
        $this->proc_depois->AdvancedSearch->SearchCondition = @$filter["v_proc_depois"];
        $this->proc_depois->AdvancedSearch->SearchValue2 = @$filter["y_proc_depois"];
        $this->proc_depois->AdvancedSearch->SearchOperator2 = @$filter["w_proc_depois"];
        $this->proc_depois->AdvancedSearch->save();

        // Field eqpto_recursos
        $this->eqpto_recursos->AdvancedSearch->SearchValue = @$filter["x_eqpto_recursos"];
        $this->eqpto_recursos->AdvancedSearch->SearchOperator = @$filter["z_eqpto_recursos"];
        $this->eqpto_recursos->AdvancedSearch->SearchCondition = @$filter["v_eqpto_recursos"];
        $this->eqpto_recursos->AdvancedSearch->SearchValue2 = @$filter["y_eqpto_recursos"];
        $this->eqpto_recursos->AdvancedSearch->SearchOperator2 = @$filter["w_eqpto_recursos"];
        $this->eqpto_recursos->AdvancedSearch->save();

        // Field entradas
        $this->entradas->AdvancedSearch->SearchValue = @$filter["x_entradas"];
        $this->entradas->AdvancedSearch->SearchOperator = @$filter["z_entradas"];
        $this->entradas->AdvancedSearch->SearchCondition = @$filter["v_entradas"];
        $this->entradas->AdvancedSearch->SearchValue2 = @$filter["y_entradas"];
        $this->entradas->AdvancedSearch->SearchOperator2 = @$filter["w_entradas"];
        $this->entradas->AdvancedSearch->save();

        // Field atividade_principal
        $this->atividade_principal->AdvancedSearch->SearchValue = @$filter["x_atividade_principal"];
        $this->atividade_principal->AdvancedSearch->SearchOperator = @$filter["z_atividade_principal"];
        $this->atividade_principal->AdvancedSearch->SearchCondition = @$filter["v_atividade_principal"];
        $this->atividade_principal->AdvancedSearch->SearchValue2 = @$filter["y_atividade_principal"];
        $this->atividade_principal->AdvancedSearch->SearchOperator2 = @$filter["w_atividade_principal"];
        $this->atividade_principal->AdvancedSearch->save();

        // Field saidas_resultados
        $this->saidas_resultados->AdvancedSearch->SearchValue = @$filter["x_saidas_resultados"];
        $this->saidas_resultados->AdvancedSearch->SearchOperator = @$filter["z_saidas_resultados"];
        $this->saidas_resultados->AdvancedSearch->SearchCondition = @$filter["v_saidas_resultados"];
        $this->saidas_resultados->AdvancedSearch->SearchValue2 = @$filter["y_saidas_resultados"];
        $this->saidas_resultados->AdvancedSearch->SearchOperator2 = @$filter["w_saidas_resultados"];
        $this->saidas_resultados->AdvancedSearch->save();

        // Field requsito_saidas
        $this->requsito_saidas->AdvancedSearch->SearchValue = @$filter["x_requsito_saidas"];
        $this->requsito_saidas->AdvancedSearch->SearchOperator = @$filter["z_requsito_saidas"];
        $this->requsito_saidas->AdvancedSearch->SearchCondition = @$filter["v_requsito_saidas"];
        $this->requsito_saidas->AdvancedSearch->SearchValue2 = @$filter["y_requsito_saidas"];
        $this->requsito_saidas->AdvancedSearch->SearchOperator2 = @$filter["w_requsito_saidas"];
        $this->requsito_saidas->AdvancedSearch->save();

        // Field riscos
        $this->riscos->AdvancedSearch->SearchValue = @$filter["x_riscos"];
        $this->riscos->AdvancedSearch->SearchOperator = @$filter["z_riscos"];
        $this->riscos->AdvancedSearch->SearchCondition = @$filter["v_riscos"];
        $this->riscos->AdvancedSearch->SearchValue2 = @$filter["y_riscos"];
        $this->riscos->AdvancedSearch->SearchOperator2 = @$filter["w_riscos"];
        $this->riscos->AdvancedSearch->save();

        // Field oportunidades
        $this->oportunidades->AdvancedSearch->SearchValue = @$filter["x_oportunidades"];
        $this->oportunidades->AdvancedSearch->SearchOperator = @$filter["z_oportunidades"];
        $this->oportunidades->AdvancedSearch->SearchCondition = @$filter["v_oportunidades"];
        $this->oportunidades->AdvancedSearch->SearchValue2 = @$filter["y_oportunidades"];
        $this->oportunidades->AdvancedSearch->SearchOperator2 = @$filter["w_oportunidades"];
        $this->oportunidades->AdvancedSearch->save();

        // Field propriedade_externa
        $this->propriedade_externa->AdvancedSearch->SearchValue = @$filter["x_propriedade_externa"];
        $this->propriedade_externa->AdvancedSearch->SearchOperator = @$filter["z_propriedade_externa"];
        $this->propriedade_externa->AdvancedSearch->SearchCondition = @$filter["v_propriedade_externa"];
        $this->propriedade_externa->AdvancedSearch->SearchValue2 = @$filter["y_propriedade_externa"];
        $this->propriedade_externa->AdvancedSearch->SearchOperator2 = @$filter["w_propriedade_externa"];
        $this->propriedade_externa->AdvancedSearch->save();

        // Field conhecimentos
        $this->conhecimentos->AdvancedSearch->SearchValue = @$filter["x_conhecimentos"];
        $this->conhecimentos->AdvancedSearch->SearchOperator = @$filter["z_conhecimentos"];
        $this->conhecimentos->AdvancedSearch->SearchCondition = @$filter["v_conhecimentos"];
        $this->conhecimentos->AdvancedSearch->SearchValue2 = @$filter["y_conhecimentos"];
        $this->conhecimentos->AdvancedSearch->SearchOperator2 = @$filter["w_conhecimentos"];
        $this->conhecimentos->AdvancedSearch->save();

        // Field documentos_aplicados
        $this->documentos_aplicados->AdvancedSearch->SearchValue = @$filter["x_documentos_aplicados"];
        $this->documentos_aplicados->AdvancedSearch->SearchOperator = @$filter["z_documentos_aplicados"];
        $this->documentos_aplicados->AdvancedSearch->SearchCondition = @$filter["v_documentos_aplicados"];
        $this->documentos_aplicados->AdvancedSearch->SearchValue2 = @$filter["y_documentos_aplicados"];
        $this->documentos_aplicados->AdvancedSearch->SearchOperator2 = @$filter["w_documentos_aplicados"];
        $this->documentos_aplicados->AdvancedSearch->save();

        // Field proced_int_trabalho
        $this->proced_int_trabalho->AdvancedSearch->SearchValue = @$filter["x_proced_int_trabalho"];
        $this->proced_int_trabalho->AdvancedSearch->SearchOperator = @$filter["z_proced_int_trabalho"];
        $this->proced_int_trabalho->AdvancedSearch->SearchCondition = @$filter["v_proced_int_trabalho"];
        $this->proced_int_trabalho->AdvancedSearch->SearchValue2 = @$filter["y_proced_int_trabalho"];
        $this->proced_int_trabalho->AdvancedSearch->SearchOperator2 = @$filter["w_proced_int_trabalho"];
        $this->proced_int_trabalho->AdvancedSearch->save();

        // Field mapa
        $this->mapa->AdvancedSearch->SearchValue = @$filter["x_mapa"];
        $this->mapa->AdvancedSearch->SearchOperator = @$filter["z_mapa"];
        $this->mapa->AdvancedSearch->SearchCondition = @$filter["v_mapa"];
        $this->mapa->AdvancedSearch->SearchValue2 = @$filter["y_mapa"];
        $this->mapa->AdvancedSearch->SearchOperator2 = @$filter["w_mapa"];
        $this->mapa->AdvancedSearch->save();

        // Field formulario
        $this->formulario->AdvancedSearch->SearchValue = @$filter["x_formulario"];
        $this->formulario->AdvancedSearch->SearchOperator = @$filter["z_formulario"];
        $this->formulario->AdvancedSearch->SearchCondition = @$filter["v_formulario"];
        $this->formulario->AdvancedSearch->SearchValue2 = @$filter["y_formulario"];
        $this->formulario->AdvancedSearch->SearchOperator2 = @$filter["w_formulario"];
        $this->formulario->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Advanced search WHERE clause based on QueryString
    public function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->idprocesso, $default, false); // idprocesso
        $this->buildSearchSql($where, $this->dt_cadastro, $default, false); // dt_cadastro
        $this->buildSearchSql($where, $this->revisao, $default, false); // revisao
        $this->buildSearchSql($where, $this->tipo_idtipo, $default, false); // tipo_idtipo
        $this->buildSearchSql($where, $this->processo, $default, true); // processo
        $this->buildSearchSql($where, $this->responsaveis, $default, true); // responsaveis
        $this->buildSearchSql($where, $this->objetivo, $default, false); // objetivo
        $this->buildSearchSql($where, $this->proc_antes, $default, false); // proc_antes
        $this->buildSearchSql($where, $this->proc_depois, $default, false); // proc_depois
        $this->buildSearchSql($where, $this->eqpto_recursos, $default, false); // eqpto_recursos
        $this->buildSearchSql($where, $this->entradas, $default, false); // entradas
        $this->buildSearchSql($where, $this->atividade_principal, $default, false); // atividade_principal
        $this->buildSearchSql($where, $this->saidas_resultados, $default, false); // saidas_resultados
        $this->buildSearchSql($where, $this->requsito_saidas, $default, false); // requsito_saidas
        $this->buildSearchSql($where, $this->riscos, $default, false); // riscos
        $this->buildSearchSql($where, $this->oportunidades, $default, false); // oportunidades
        $this->buildSearchSql($where, $this->propriedade_externa, $default, false); // propriedade_externa
        $this->buildSearchSql($where, $this->conhecimentos, $default, false); // conhecimentos
        $this->buildSearchSql($where, $this->documentos_aplicados, $default, false); // documentos_aplicados
        $this->buildSearchSql($where, $this->proced_int_trabalho, $default, false); // proced_int_trabalho
        $this->buildSearchSql($where, $this->mapa, $default, false); // mapa
        $this->buildSearchSql($where, $this->formulario, $default, false); // formulario

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->idprocesso->AdvancedSearch->save(); // idprocesso
            $this->dt_cadastro->AdvancedSearch->save(); // dt_cadastro
            $this->revisao->AdvancedSearch->save(); // revisao
            $this->tipo_idtipo->AdvancedSearch->save(); // tipo_idtipo
            $this->processo->AdvancedSearch->save(); // processo
            $this->responsaveis->AdvancedSearch->save(); // responsaveis
            $this->objetivo->AdvancedSearch->save(); // objetivo
            $this->proc_antes->AdvancedSearch->save(); // proc_antes
            $this->proc_depois->AdvancedSearch->save(); // proc_depois
            $this->eqpto_recursos->AdvancedSearch->save(); // eqpto_recursos
            $this->entradas->AdvancedSearch->save(); // entradas
            $this->atividade_principal->AdvancedSearch->save(); // atividade_principal
            $this->saidas_resultados->AdvancedSearch->save(); // saidas_resultados
            $this->requsito_saidas->AdvancedSearch->save(); // requsito_saidas
            $this->riscos->AdvancedSearch->save(); // riscos
            $this->oportunidades->AdvancedSearch->save(); // oportunidades
            $this->propriedade_externa->AdvancedSearch->save(); // propriedade_externa
            $this->conhecimentos->AdvancedSearch->save(); // conhecimentos
            $this->documentos_aplicados->AdvancedSearch->save(); // documentos_aplicados
            $this->proced_int_trabalho->AdvancedSearch->save(); // proced_int_trabalho
            $this->mapa->AdvancedSearch->save(); // mapa
            $this->formulario->AdvancedSearch->save(); // formulario

            // Clear rules for QueryBuilder
            $this->setSessionRules("");
        }
        return $where;
    }

    // Query builder rules
    public function queryBuilderRules()
    {
        return Post("rules") ?? $this->getSessionRules();
    }

    // Quey builder WHERE clause
    public function queryBuilderWhere($fieldName = "")
    {
        global $Security;
        if (!$Security->canSearch()) {
            return "";
        }

        // Get rules by query builder
        $rules = $this->queryBuilderRules();

        // Decode and parse rules
        $where = $rules ? $this->parseRules(json_decode($rules, true), $fieldName) : "";

        // Clear other search and save rules to session
        if ($where && $fieldName == "") { // Skip if get query for specific field
            $this->resetSearchParms();
            $this->setSessionRules($rules);
        }

        // Return query
        return $where;
    }

    // Build search SQL
    protected function buildSearchSql(&$where, $fld, $default, $multiValue)
    {
        $fldParm = $fld->Param;
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldCond = $default ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        $fldOpr2 = $default ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
        $fldVal = ConvertSearchValue($fldVal, $fldOpr, $fld);
        $fldVal2 = ConvertSearchValue($fldVal2, $fldOpr2, $fld);
        $fldOpr = ConvertSearchOperator($fldOpr, $fld, $fldVal);
        $fldOpr2 = ConvertSearchOperator($fldOpr2, $fld, $fldVal2);
        $wrk = "";
        $sep = $fld->UseFilter ? Config("FILTER_OPTION_SEPARATOR") : Config("MULTIPLE_OPTION_SEPARATOR");
        if (is_array($fldVal)) {
            $fldVal = implode($sep, $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode($sep, $fldVal2);
        }
        if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 && !$fld->UseFilter || !IsMultiSearchOperator($fldOpr)) {
            $multiValue = false;
        }
        if ($multiValue) {
            $wrk = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
            $wrk2 = $fldVal2 != "" ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
            AddFilter($wrk, $wrk2, $fldCond);
        } else {
            $wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
        }
        if ($this->SearchOption == "AUTO" && in_array($this->BasicSearch->getType(), ["AND", "OR"])) {
            $cond = $this->BasicSearch->getType();
        } else {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
        }
        AddFilter($where, $wrk, $cond);
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Field dt_cadastro
        $filter = $this->queryBuilderWhere("dt_cadastro");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->dt_cadastro, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->dt_cadastro->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field revisao
        $filter = $this->queryBuilderWhere("revisao");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->revisao, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->revisao->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field tipo_idtipo
        $filter = $this->queryBuilderWhere("tipo_idtipo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->tipo_idtipo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->tipo_idtipo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field processo
        $filter = $this->queryBuilderWhere("processo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->processo, false, true);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->processo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field responsaveis
        $filter = $this->queryBuilderWhere("responsaveis");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->responsaveis, false, true);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->responsaveis->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field entradas
        $filter = $this->queryBuilderWhere("entradas");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->entradas, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->entradas->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field atividade_principal
        $filter = $this->queryBuilderWhere("atividade_principal");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->atividade_principal, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->atividade_principal->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field saidas_resultados
        $filter = $this->queryBuilderWhere("saidas_resultados");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->saidas_resultados, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->saidas_resultados->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field formulario
        $filter = $this->queryBuilderWhere("formulario");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->formulario, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->formulario->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }
        if ($this->BasicSearch->Keyword != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $Language->phrase("BasicSearchKeyword") . "</span>" . $captionSuffix . $this->BasicSearch->Keyword . "</div>";
        }

        // Show Filters
        if ($filterList != "") {
            $message = "<div id=\"ew-filter-list\" class=\"callout callout-info d-table\"><div id=\"ew-current-filters\">" .
                $Language->phrase("CurrentFilters") . "</div>" . $filterList . "</div>";
            $this->messageShowing($message, "");
            Write($message);
        } else { // Output empty tag
            Write("<div id=\"ew-filter-list\"></div>");
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    public function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }

        // Fields to search
        $searchFlds = [];
        $searchFlds[] = &$this->revisao;
        $searchFlds[] = &$this->processo;
        $searchFlds[] = &$this->responsaveis;
        $searchFlds[] = &$this->objetivo;
        $searchFlds[] = &$this->eqpto_recursos;
        $searchFlds[] = &$this->entradas;
        $searchFlds[] = &$this->atividade_principal;
        $searchFlds[] = &$this->saidas_resultados;
        $searchFlds[] = &$this->requsito_saidas;
        $searchFlds[] = &$this->riscos;
        $searchFlds[] = &$this->oportunidades;
        $searchFlds[] = &$this->propriedade_externa;
        $searchFlds[] = &$this->conhecimentos;
        $searchFlds[] = &$this->documentos_aplicados;
        $searchFlds[] = &$this->proced_int_trabalho;
        $searchFlds[] = &$this->mapa;
        $searchFlds[] = &$this->formulario;
        $searchKeyword = $default ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = $default ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            $searchStr = GetQuickSearchFilter($searchFlds, $ar, $searchType, Config("BASIC_SEARCH_ANY_FIELDS"), $this->Dbid);
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);

            // Clear rules for QueryBuilder
            $this->setSessionRules("");
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        if ($this->idprocesso->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->dt_cadastro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->revisao->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tipo_idtipo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->processo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->responsaveis->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->objetivo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->proc_antes->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->proc_depois->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->eqpto_recursos->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->entradas->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->atividade_principal->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->saidas_resultados->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->requsito_saidas->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->riscos->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->oportunidades->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->propriedade_externa->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->conhecimentos->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->documentos_aplicados->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->proced_int_trabalho->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->mapa->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->formulario->AdvancedSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();

        // Clear queryBuilder
        $this->setSessionRules("");
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
        $this->idprocesso->AdvancedSearch->unsetSession();
        $this->dt_cadastro->AdvancedSearch->unsetSession();
        $this->revisao->AdvancedSearch->unsetSession();
        $this->tipo_idtipo->AdvancedSearch->unsetSession();
        $this->processo->AdvancedSearch->unsetSession();
        $this->responsaveis->AdvancedSearch->unsetSession();
        $this->objetivo->AdvancedSearch->unsetSession();
        $this->proc_antes->AdvancedSearch->unsetSession();
        $this->proc_depois->AdvancedSearch->unsetSession();
        $this->eqpto_recursos->AdvancedSearch->unsetSession();
        $this->entradas->AdvancedSearch->unsetSession();
        $this->atividade_principal->AdvancedSearch->unsetSession();
        $this->saidas_resultados->AdvancedSearch->unsetSession();
        $this->requsito_saidas->AdvancedSearch->unsetSession();
        $this->riscos->AdvancedSearch->unsetSession();
        $this->oportunidades->AdvancedSearch->unsetSession();
        $this->propriedade_externa->AdvancedSearch->unsetSession();
        $this->conhecimentos->AdvancedSearch->unsetSession();
        $this->documentos_aplicados->AdvancedSearch->unsetSession();
        $this->proced_int_trabalho->AdvancedSearch->unsetSession();
        $this->mapa->AdvancedSearch->unsetSession();
        $this->formulario->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->idprocesso->AdvancedSearch->load();
        $this->dt_cadastro->AdvancedSearch->load();
        $this->revisao->AdvancedSearch->load();
        $this->tipo_idtipo->AdvancedSearch->load();
        $this->processo->AdvancedSearch->load();
        $this->responsaveis->AdvancedSearch->load();
        $this->objetivo->AdvancedSearch->load();
        $this->proc_antes->AdvancedSearch->load();
        $this->proc_depois->AdvancedSearch->load();
        $this->eqpto_recursos->AdvancedSearch->load();
        $this->entradas->AdvancedSearch->load();
        $this->atividade_principal->AdvancedSearch->load();
        $this->saidas_resultados->AdvancedSearch->load();
        $this->requsito_saidas->AdvancedSearch->load();
        $this->riscos->AdvancedSearch->load();
        $this->oportunidades->AdvancedSearch->load();
        $this->propriedade_externa->AdvancedSearch->load();
        $this->conhecimentos->AdvancedSearch->load();
        $this->documentos_aplicados->AdvancedSearch->load();
        $this->proced_int_trabalho->AdvancedSearch->load();
        $this->mapa->AdvancedSearch->load();
        $this->formulario->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->processo->Expression . " ASC"; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for Ctrl pressed
        $ctrl = Get("ctrl") !== null;

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->dt_cadastro, $ctrl); // dt_cadastro
            $this->updateSort($this->revisao, $ctrl); // revisao
            $this->updateSort($this->tipo_idtipo, $ctrl); // tipo_idtipo
            $this->updateSort($this->processo, $ctrl); // processo
            $this->updateSort($this->responsaveis, $ctrl); // responsaveis
            $this->updateSort($this->entradas, $ctrl); // entradas
            $this->updateSort($this->atividade_principal, $ctrl); // atividade_principal
            $this->updateSort($this->saidas_resultados, $ctrl); // saidas_resultados
            $this->updateSort($this->formulario, $ctrl); // formulario
            $this->setStartRecordNumber(1); // Reset start position
        }

        // Update field sort
        $this->updateFieldSort();
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->idprocesso->setSort("");
                $this->dt_cadastro->setSort("");
                $this->revisao->setSort("");
                $this->tipo_idtipo->setSort("");
                $this->processo->setSort("");
                $this->responsaveis->setSort("");
                $this->objetivo->setSort("");
                $this->proc_antes->setSort("");
                $this->proc_depois->setSort("");
                $this->eqpto_recursos->setSort("");
                $this->entradas->setSort("");
                $this->atividade_principal->setSort("");
                $this->saidas_resultados->setSort("");
                $this->requsito_saidas->setSort("");
                $this->riscos->setSort("");
                $this->oportunidades->setSort("");
                $this->propriedade_externa->setSort("");
                $this->conhecimentos->setSort("");
                $this->documentos_aplicados->setSort("");
                $this->proced_int_trabalho->setSort("");
                $this->mapa->setSort("");
                $this->formulario->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item ("button")
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

        // "detail_processo_indicadores"
        $item = &$this->ListOptions->add("detail_processo_indicadores");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'processo_indicadores');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$this->ListOptions->add("details");
            $item->CssClass = "text-nowrap";
            $item->Visible = $this->ShowMultipleDetails && $this->ListOptions->detailVisible();
            $item->OnLeft = true;
            $item->ShowInButtonGroup = false;
            $this->ListOptions->hideDetailItems();
        }

        // Set up detail pages
        $pages = new SubPages();
        $pages->add("processo_indicadores");
        $this->DetailPages = $pages;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = true;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = true;
        $item->Header = "<div class=\"form-check\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"form-check-input\" data-ew-action=\"select-all-keys\"></div>";
        if ($item->OnLeft) {
            $item->moveTo(0);
        }
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Set up list options (extensions)
    protected function setupListOptionsExt()
    {
            // Set up list options (to be implemented by extensions)
    }

    // Add "hash" parameter to URL
    public function urlAddHash($url, $hash)
    {
        return $this->UseAjaxActions ? $url : UrlAddQuery($url, "hash=" . $hash);
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();
        $pageUrl = $this->pageUrl(false);
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"processo\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                if ($this->ModalEdit && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"processo\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                if ($this->ModalAdd && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"processo\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("CopyLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
                $deleteCaption = $Language->phrase("DeleteLink");
                $deleteTitle = HtmlTitle($deleteCaption);
                if ($this->UseAjaxActions) {
                    $opt->Body = "<a class=\"ew-row-link ew-delete\" data-ew-action=\"inline\" data-action=\"delete\" title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" data-key= \"" . HtmlEncode($this->getKey(true)) . "\" data-url=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $deleteCaption . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-delete\"" .
                        ($this->InlineDelete ? " data-ew-action=\"inline-delete\"" : "") .
                        " title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $deleteCaption . "</a>";
                }
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions as $listAction) {
                $action = $listAction->Action;
                $allowed = $listAction->Allowed;
                $disabled = false;
                if ($listAction->Select == ACTION_SINGLE && $allowed) {
                    $caption = $listAction->Caption;
                    $title = HtmlTitle($caption);
                    if ($action != "") {
                        $icon = ($listAction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listAction->Icon)) . "\" data-caption=\"" . $title . "\"></i> " : "";
                        $link = $disabled
                            ? "<li><div class=\"alert alert-light\">" . $icon . " " . $caption . "</div></li>"
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fprocessolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fprocessolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
                        }
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
            }
        }
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_processo_indicadores"
        $opt = $this->ListOptions["detail_processo_indicadores"];
        if ($Security->allowList(CurrentProjectID() . 'processo_indicadores')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("processo_indicadores", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ProcessoIndicadoresList?" . Config("TABLE_SHOW_MASTER") . "=processo&" . GetForeignKeyUrl("fk_idprocesso", $this->idprocesso->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ProcessoIndicadoresGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'processo')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=processo_indicadores");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "processo_indicadores";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'processo')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=processo_indicadores");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "processo_indicadores";
            }
            if ($detailPage->DetailAdd && $Security->canAdd() && $Security->allowAdd(CurrentProjectID() . 'processo')) {
                $caption = $Language->phrase("MasterDetailCopyLink", null);
                $url = $this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=processo_indicadores");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
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
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailViewLink", true)) . "\" href=\"" . HtmlEncode($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar)) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailEditLink", true)) . "\" href=\"" . HtmlEncode($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar)) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailCopyLink", true)) . "\" href=\"" . HtmlEncode($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar)) . "\">" . $Language->phrase("MasterDetailCopyLink", null) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlEncode($Language->phrase("MultipleMasterDetails", true)) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-dropdown-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $opt = $this->ListOptions["details"];
            $opt->Body = $body;
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->idprocesso->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Render list options (extensions)
    protected function renderListOptionsExt()
    {
        // Render list options (to be implemented by extensions)
        global $Security, $Language;
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        if ($this->ModalAdd && !IsMobile()) {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"processo\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["detail"];
        $detailTableLink = "";
        $item = &$option->add("detailadd_processo_indicadores");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=processo_indicadores");
        $detailPage = Container("ProcessoIndicadoresGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'processo') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "processo_indicadores";
        }

        // Add multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$option->add("detailsadd");
            $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailTableLink);
            $caption = $Language->phrase("AddMasterDetailLink");
            $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
            $item->Visible = $detailTableLink != "" && $Security->canAdd();
            // Hide single master/detail items
            $ar = explode(",", $detailTableLink);
            $cnt = count($ar);
            for ($i = 0; $i < $cnt; $i++) {
                if ($item = $option["detailadd_" . $ar[$i]]) {
                    $item->Visible = false;
                }
            }
        }
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "dt_cadastro");
            $this->createColumnOption($option, "revisao");
            $this->createColumnOption($option, "tipo_idtipo");
            $this->createColumnOption($option, "processo");
            $this->createColumnOption($option, "responsaveis");
            $this->createColumnOption($option, "entradas");
            $this->createColumnOption($option, "atividade_principal");
            $this->createColumnOption($option, "saidas_resultados");
            $this->createColumnOption($option, "formulario");
        }

        // Set up custom actions
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions[$name] = $action;
        }

        // Set up options default
        foreach ($options as $name => $option) {
            if ($name != "column") { // Always use dropdown for column
                $option->UseDropDownButton = false;
                $option->UseButtonGroup = true;
            }
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fprocessosrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fprocessosrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Page header/footer options
        $this->HeaderOptions = new ListOptions(TagClassName: "ew-header-option", UseDropDownButton: false, UseButtonGroup: false);
        $item = &$this->HeaderOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
        $this->FooterOptions = new ListOptions(TagClassName: "ew-footer-option", UseDropDownButton: false, UseButtonGroup: false);
        $item = &$this->FooterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Show active user count from SQL
    }

    // Active user filter
    // - Get active users by SQL (SELECT COUNT(*) FROM UserTable WHERE ProfileField LIKE '%"SessionID":%')
    protected function activeUserFilter()
    {
        if (UserProfile::$FORCE_LOGOUT_USER) {
            $userProfileField = $this->Fields[Config("USER_PROFILE_FIELD_NAME")];
            return $userProfileField->Expression . " LIKE '%\"" . UserProfile::$SESSION_ID . "\":%'";
        }
        return "0=1"; // No active users
    }

    // Create new column option
    protected function createColumnOption($option, $name)
    {
        $field = $this->Fields[$name] ?? null;
        if ($field?->Visible) {
            $item = $option->add($field->Name);
            $item->Body = '<button class="dropdown-item">' .
                '<div class="form-check ew-dropdown-checkbox">' .
                '<div class="form-check-input ew-dropdown-check-input" data-field="' . $field->Param . '"></div>' .
                '<label class="form-check-label ew-dropdown-check-label">' . $field->caption() . '</label></div></button>';
        }
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions as $listAction) {
            if ($listAction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listAction->Action);
                $caption = $listAction->Caption;
                $icon = ($listAction->Icon != "") ? '<i class="' . HtmlEncode($listAction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fprocessolist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
                $item->Visible = $listAction->Allowed;
            }
        }

        // Hide multi edit, grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security, $Response;
        $users = [];
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("action", "");
        if ($filter != "" && $userAction != "") {
            $conn = $this->getConnection();
            // Clear current action
            $this->CurrentAction = "";
            // Check permission first
            $actionCaption = $userAction;
            $listAction = $this->ListActions[$userAction] ?? null;
            if ($listAction) {
                $this->UserAction = $userAction;
                $actionCaption = $listAction->Caption ?: $listAction->Action;
                if (!$listAction->Allowed) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            } else {
                $errmsg = str_replace('%s', $userAction, $Language->phrase("CustomActionNotFound"));
                if (Post("ajax") == $userAction) { // Ajax
                    echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                    return true;
                } else {
                    $this->setFailureMessage($errmsg);
                    return false;
                }
            }
            $rows = $this->loadRs($filter)->fetchAllAssociative();
            $this->SelectedCount = count($rows);
            $this->ActionValue = Post("actionvalue");

            // Call row action event
            if ($this->SelectedCount > 0) {
                if ($this->UseTransaction) {
                    $conn->beginTransaction();
                }
                $this->SelectedIndex = 0;
                foreach ($rows as $row) {
                    $this->SelectedIndex++;
                    $processed = $listAction->handle($row, $this);
                    if (!$processed) {
                        break;
                    }
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                }
                if ($processed) {
                    if ($this->UseTransaction) { // Commit transaction
                        if ($conn->isTransactionActive()) {
                            $conn->commit();
                        }
                    }
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($listAction->SuccessMessage);
                    }
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage(str_replace("%s", $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        if ($conn->isTransactionActive()) {
                            $conn->rollback();
                        }
                    }
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($listAction->FailureMessage);
                    }

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if (Post("ajax") == $userAction) { // Ajax
                if (WithJsonResponse()) { // List action returns JSON
                    $this->clearSuccessMessage(); // Clear success message
                    $this->clearFailureMessage(); // Clear failure message
                } else {
                    if ($this->getSuccessMessage() != "") {
                        echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                        $this->clearSuccessMessage(); // Clear success message
                    }
                    if ($this->getFailureMessage() != "") {
                        echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                        $this->clearFailureMessage(); // Clear failure message
                    }
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up Grid
    public function setupGrid()
    {
        global $CurrentForm;
        if ($this->ExportAll && $this->isExport()) {
            $this->StopRecord = $this->TotalRecords;
        } else {
            // Set the last record to display
            if ($this->TotalRecords > $this->StartRecord + $this->DisplayRecords - 1) {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            } else {
                $this->StopRecord = $this->TotalRecords;
            }
        }
        $this->RecordCount = $this->StartRecord - 1;
        if ($this->CurrentRow !== false) {
            // Nothing to do
        } elseif ($this->isGridAdd() && !$this->AllowAddDeleteRow && $this->StopRecord == 0) { // Grid-Add with no records
            $this->StopRecord = $this->GridAddRowCount;
        } elseif ($this->isAdd() && $this->TotalRecords == 0) { // Inline-Add with no records
            $this->StopRecord = 1;
        }

        // Initialize aggregate
        $this->RowType = RowType::AGGREGATEINIT;
        $this->resetAttributes();
        $this->renderRow();
        if (($this->isGridAdd() || $this->isGridEdit())) { // Render template row first
            $this->RowIndex = '$rowindex$';
        }
    }

    // Set up Row
    public function setupRow()
    {
        global $CurrentForm;
        if ($this->isGridAdd() || $this->isGridEdit()) {
            if ($this->RowIndex === '$rowindex$') { // Render template row first
                $this->loadRowValues();

                // Set row properties
                $this->resetAttributes();
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_processo", "data-rowtype" => RowType::ADD]);
                $this->RowAttrs->appendClass("ew-template");
                // Render row
                $this->RowType = RowType::ADD;
                $this->renderRow();

                // Render list options
                $this->renderListOptions();

                // Reset record count for template row
                $this->RecordCount--;
                return;
            }
        }

        // Set up key count
        $this->KeyCount = $this->RowIndex;

        // Init row class and style
        $this->resetAttributes();
        $this->CssClass = "";
        if ($this->isCopy() && $this->InlineRowCount == 0 && !$this->loadRow()) { // Inline copy
            $this->CurrentAction = "add";
        }
        if ($this->isAdd() && $this->InlineRowCount == 0 || $this->isGridAdd()) {
            $this->loadRowValues(); // Load default values
            $this->OldKey = "";
            $this->setKey($this->OldKey);
        } elseif ($this->isInlineInserted() && $this->UseInfiniteScroll) {
            // Nothing to do, just use current values
        } elseif (!($this->isCopy() && $this->InlineRowCount == 0)) {
            $this->loadRowValues($this->CurrentRow); // Load row values
            if ($this->isGridEdit() || $this->isMultiEdit()) {
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
                $this->setKey($this->OldKey);
            }
        }
        $this->RowType = RowType::VIEW; // Render view
        if (($this->isAdd() || $this->isCopy()) && $this->InlineRowCount == 0 || $this->isGridAdd()) { // Add
            $this->RowType = RowType::ADD; // Render add
        }

        // Inline Add/Copy row (row 0)
        if ($this->RowType == RowType::ADD && ($this->isAdd() || $this->isCopy())) {
            $this->InlineRowCount++;
            $this->RecordCount--; // Reset record count for inline add/copy row
            if ($this->TotalRecords == 0) { // Reset stop record if no records
                $this->StopRecord = 0;
            }
        } else {
            // Inline Edit row
            if ($this->RowType == RowType::EDIT && $this->isEdit()) {
                $this->InlineRowCount++;
            }
            $this->RowCount++; // Increment row count
        }

        // Set up row attributes
        $this->RowAttrs->merge([
            "data-rowindex" => $this->RowCount,
            "data-key" => $this->getKey(true),
            "id" => "r" . $this->RowCount . "_processo",
            "data-rowtype" => $this->RowType,
            "data-inline" => ($this->isAdd() || $this->isCopy() || $this->isEdit()) ? "true" : "false", // Inline-Add/Copy/Edit
            "class" => ($this->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($this->isAdd() && $this->RowType == RowType::ADD || $this->isEdit() && $this->RowType == RowType::EDIT) { // Inline-Add/Edit row
            $this->RowAttrs->appendClass("table-active");
        }

        // Render row
        $this->renderRow();

        // Render list options
        $this->renderListOptions();
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // Load query builder rules
        $rules = Post("rules");
        if ($rules && $this->Command == "") {
            $this->QueryRules = $rules;
            $this->Command = "search";
        }

        // idprocesso
        if ($this->idprocesso->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->idprocesso->AdvancedSearch->SearchValue != "" || $this->idprocesso->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // dt_cadastro
        if ($this->dt_cadastro->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->dt_cadastro->AdvancedSearch->SearchValue != "" || $this->dt_cadastro->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // revisao
        if ($this->revisao->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->revisao->AdvancedSearch->SearchValue != "" || $this->revisao->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tipo_idtipo
        if ($this->tipo_idtipo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tipo_idtipo->AdvancedSearch->SearchValue != "" || $this->tipo_idtipo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // processo
        if ($this->processo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->processo->AdvancedSearch->SearchValue != "" || $this->processo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // responsaveis
        if ($this->responsaveis->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->responsaveis->AdvancedSearch->SearchValue != "" || $this->responsaveis->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->responsaveis->AdvancedSearch->SearchValue)) {
            $this->responsaveis->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->responsaveis->AdvancedSearch->SearchValue);
        }
        if (is_array($this->responsaveis->AdvancedSearch->SearchValue2)) {
            $this->responsaveis->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->responsaveis->AdvancedSearch->SearchValue2);
        }

        // objetivo
        if ($this->objetivo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->objetivo->AdvancedSearch->SearchValue != "" || $this->objetivo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // proc_antes
        if ($this->proc_antes->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->proc_antes->AdvancedSearch->SearchValue != "" || $this->proc_antes->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // proc_depois
        if ($this->proc_depois->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->proc_depois->AdvancedSearch->SearchValue != "" || $this->proc_depois->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // eqpto_recursos
        if ($this->eqpto_recursos->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->eqpto_recursos->AdvancedSearch->SearchValue != "" || $this->eqpto_recursos->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // entradas
        if ($this->entradas->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->entradas->AdvancedSearch->SearchValue != "" || $this->entradas->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // atividade_principal
        if ($this->atividade_principal->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->atividade_principal->AdvancedSearch->SearchValue != "" || $this->atividade_principal->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // saidas_resultados
        if ($this->saidas_resultados->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->saidas_resultados->AdvancedSearch->SearchValue != "" || $this->saidas_resultados->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // requsito_saidas
        if ($this->requsito_saidas->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->requsito_saidas->AdvancedSearch->SearchValue != "" || $this->requsito_saidas->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // riscos
        if ($this->riscos->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->riscos->AdvancedSearch->SearchValue != "" || $this->riscos->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // oportunidades
        if ($this->oportunidades->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->oportunidades->AdvancedSearch->SearchValue != "" || $this->oportunidades->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // propriedade_externa
        if ($this->propriedade_externa->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->propriedade_externa->AdvancedSearch->SearchValue != "" || $this->propriedade_externa->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // conhecimentos
        if ($this->conhecimentos->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->conhecimentos->AdvancedSearch->SearchValue != "" || $this->conhecimentos->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // documentos_aplicados
        if ($this->documentos_aplicados->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->documentos_aplicados->AdvancedSearch->SearchValue != "" || $this->documentos_aplicados->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // proced_int_trabalho
        if ($this->proced_int_trabalho->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->proced_int_trabalho->AdvancedSearch->SearchValue != "" || $this->proced_int_trabalho->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // mapa
        if ($this->mapa->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->mapa->AdvancedSearch->SearchValue != "" || $this->mapa->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // formulario
        if ($this->formulario->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->formulario->AdvancedSearch->SearchValue != "" || $this->formulario->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

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

        // Accumulate aggregate value
        if ($this->RowType != RowType::AGGREGATEINIT && $this->RowType != RowType::AGGREGATE && $this->RowType != RowType::PREVIEWFIELD) {
            $this->atividade_principal->Count++; // Increment count
        }

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

            // entradas
            $this->entradas->ViewValue = $this->entradas->CurrentValue;
            $this->entradas->CssClass = "fw-bold";

            // atividade_principal
            $this->atividade_principal->ViewValue = $this->atividade_principal->CurrentValue;
            $this->atividade_principal->CssClass = "fw-bold";

            // saidas_resultados
            $this->saidas_resultados->ViewValue = $this->saidas_resultados->CurrentValue;
            $this->saidas_resultados->CssClass = "fw-bold";

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

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";
            $this->dt_cadastro->TooltipValue = "";
            if (!$this->isExport()) {
                $this->dt_cadastro->ViewValue = $this->highlightValue($this->dt_cadastro);
            }

            // revisao
            $this->revisao->HrefValue = "";
            $this->revisao->TooltipValue = "";
            if (!$this->isExport()) {
                $this->revisao->ViewValue = $this->highlightValue($this->revisao);
            }

            // tipo_idtipo
            $this->tipo_idtipo->HrefValue = "";
            $this->tipo_idtipo->TooltipValue = "";

            // processo
            $this->processo->HrefValue = "";
            $this->processo->TooltipValue = "";
            if (!$this->isExport()) {
                $this->processo->ViewValue = $this->highlightValue($this->processo);
            }

            // responsaveis
            $this->responsaveis->HrefValue = "";
            $this->responsaveis->TooltipValue = "";

            // entradas
            $this->entradas->HrefValue = "";
            $this->entradas->TooltipValue = "";
            if (!$this->isExport()) {
                $this->entradas->ViewValue = $this->highlightValue($this->entradas);
            }

            // atividade_principal
            $this->atividade_principal->HrefValue = "";
            $this->atividade_principal->TooltipValue = "";
            if (!$this->isExport()) {
                $this->atividade_principal->ViewValue = $this->highlightValue($this->atividade_principal);
            }

            // saidas_resultados
            $this->saidas_resultados->HrefValue = "";
            $this->saidas_resultados->TooltipValue = "";
            if (!$this->isExport()) {
                $this->saidas_resultados->ViewValue = $this->highlightValue($this->saidas_resultados);
            }

            // formulario
            $this->formulario->HrefValue = "";
            $this->formulario->ExportHrefValue = $this->formulario->UploadPath . $this->formulario->Upload->DbValue;
            $this->formulario->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // dt_cadastro
            $this->dt_cadastro->setupEditAttributes();
            $this->dt_cadastro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->formatPattern()));
            $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

            // revisao
            $this->revisao->setupEditAttributes();
            if (!$this->revisao->Raw) {
                $this->revisao->AdvancedSearch->SearchValue = HtmlDecode($this->revisao->AdvancedSearch->SearchValue);
            }
            $this->revisao->EditValue = HtmlEncode($this->revisao->AdvancedSearch->SearchValue);
            $this->revisao->PlaceHolder = RemoveHtml($this->revisao->caption());

            // tipo_idtipo
            $curVal = trim(strval($this->tipo_idtipo->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->tipo_idtipo->AdvancedSearch->ViewValue = $this->tipo_idtipo->lookupCacheOption($curVal);
            } else {
                $this->tipo_idtipo->AdvancedSearch->ViewValue = $this->tipo_idtipo->Lookup !== null && is_array($this->tipo_idtipo->lookupOptions()) && count($this->tipo_idtipo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_idtipo->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->tipo_idtipo->EditValue = array_values($this->tipo_idtipo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchExpression(), "=", $this->tipo_idtipo->AdvancedSearch->SearchValue, $this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipo_idtipo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_idtipo->EditValue = $arwrk;
            }
            $this->tipo_idtipo->PlaceHolder = RemoveHtml($this->tipo_idtipo->caption());

            // processo
            if ($this->processo->UseFilter && !EmptyValue($this->processo->AdvancedSearch->SearchValue)) {
                if (is_array($this->processo->AdvancedSearch->SearchValue)) {
                    $this->processo->AdvancedSearch->SearchValue = implode(Config("FILTER_OPTION_SEPARATOR"), $this->processo->AdvancedSearch->SearchValue);
                }
                $this->processo->EditValue = explode(Config("FILTER_OPTION_SEPARATOR"), $this->processo->AdvancedSearch->SearchValue);
            }

            // responsaveis
            $this->responsaveis->PlaceHolder = RemoveHtml($this->responsaveis->caption());

            // entradas
            $this->entradas->setupEditAttributes();
            $this->entradas->EditValue = HtmlEncode($this->entradas->AdvancedSearch->SearchValue);
            $this->entradas->PlaceHolder = RemoveHtml($this->entradas->caption());

            // atividade_principal
            $this->atividade_principal->setupEditAttributes();
            $this->atividade_principal->EditValue = HtmlEncode($this->atividade_principal->AdvancedSearch->SearchValue);
            $this->atividade_principal->PlaceHolder = RemoveHtml($this->atividade_principal->caption());

            // saidas_resultados
            $this->saidas_resultados->setupEditAttributes();
            $this->saidas_resultados->EditValue = HtmlEncode($this->saidas_resultados->AdvancedSearch->SearchValue);
            $this->saidas_resultados->PlaceHolder = RemoveHtml($this->saidas_resultados->caption());

            // formulario
            $this->formulario->setupEditAttributes();
            if (!$this->formulario->Raw) {
                $this->formulario->AdvancedSearch->SearchValue = HtmlDecode($this->formulario->AdvancedSearch->SearchValue);
            }
            $this->formulario->EditValue = HtmlEncode($this->formulario->AdvancedSearch->SearchValue);
            $this->formulario->PlaceHolder = RemoveHtml($this->formulario->caption());
        } elseif ($this->RowType == RowType::AGGREGATEINIT) { // Initialize aggregate row
                $this->atividade_principal->Count = 0; // Initialize count
        } elseif ($this->RowType == RowType::AGGREGATE) { // Aggregate row
            $this->atividade_principal->CurrentValue = $this->atividade_principal->Count;
            $this->atividade_principal->ViewValue = $this->atividade_principal->CurrentValue;
            $this->atividade_principal->CssClass = "fw-bold";
            $this->atividade_principal->HrefValue = ""; // Clear href value
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->idprocesso->AdvancedSearch->load();
        $this->dt_cadastro->AdvancedSearch->load();
        $this->revisao->AdvancedSearch->load();
        $this->tipo_idtipo->AdvancedSearch->load();
        $this->processo->AdvancedSearch->load();
        $this->responsaveis->AdvancedSearch->load();
        $this->objetivo->AdvancedSearch->load();
        $this->proc_antes->AdvancedSearch->load();
        $this->proc_depois->AdvancedSearch->load();
        $this->eqpto_recursos->AdvancedSearch->load();
        $this->entradas->AdvancedSearch->load();
        $this->atividade_principal->AdvancedSearch->load();
        $this->saidas_resultados->AdvancedSearch->load();
        $this->requsito_saidas->AdvancedSearch->load();
        $this->riscos->AdvancedSearch->load();
        $this->oportunidades->AdvancedSearch->load();
        $this->propriedade_externa->AdvancedSearch->load();
        $this->conhecimentos->AdvancedSearch->load();
        $this->documentos_aplicados->AdvancedSearch->load();
        $this->proced_int_trabalho->AdvancedSearch->load();
        $this->mapa->AdvancedSearch->load();
        $this->formulario->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        if ($type == "print" || $custom) { // Printer friendly / custom export
            $pageUrl = $this->pageUrl(false);
            $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        } else { // Export API URL
            $exportUrl = GetApiUrl(Config("API_EXPORT_ACTION") . "/" . $type . "/" . $this->TableVar);
        }
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fprocessolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fprocessolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fprocessolist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fprocessolist" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        if (!$Security->canExport()) { // Export not allowed
            $this->ExportOptions->hideAllOptions();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl(false);
        $this->SearchOptions = new ListOptions(TagClassName: "ew-search-option");

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fprocessosrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        if ($this->UseCustomTemplate || !$this->UseAjaxActions) {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" data-ew-action=\"refresh\" data-url=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        }
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Advanced search button
        $item = &$this->SearchOptions->add("advancedsearch");
        if ($this->ModalSearch && !IsMobile()) {
            $item->Body = "<a class=\"btn btn-default ew-advanced-search\" title=\"" . $Language->phrase("AdvancedSearch", true) . "\" data-table=\"processo\" data-caption=\"" . $Language->phrase("AdvancedSearch", true) . "\" data-ew-action=\"modal\" data-url=\"ProcessoSearch\" data-btn=\"SearchBtn\">" . $Language->phrase("AdvancedSearch", false) . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-advanced-search\" title=\"" . $Language->phrase("AdvancedSearch", true) . "\" data-caption=\"" . $Language->phrase("AdvancedSearch", true) . "\" href=\"ProcessoSearch\">" . $Language->phrase("AdvancedSearch", false) . "</a>";
        }
        $item->Visible = true;

        // Search highlight button
        $item = &$this->SearchOptions->add("searchhighlight");
        $item->Body = "<a class=\"btn btn-default ew-highlight active\" role=\"button\" title=\"" . $Language->phrase("Highlight") . "\" data-caption=\"" . $Language->phrase("Highlight") . "\" data-ew-action=\"highlight\" data-form=\"fprocessosrch\" data-name=\"" . $this->highlightName() . "\">" . $Language->phrase("HighlightBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != "" && $this->TotalRecords > 0);

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction && $this->CurrentAction != "search") {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return true;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param bool $return Return the data rather than output it
    * @return mixed
    */
    public function exportData($doc)
    {
        global $Language;
        $rs = null;
        $this->TotalRecords = $this->listRecordCount();

        // Export all
        if ($this->ExportAll) {
            if (Config("EXPORT_ALL_TIME_LIMIT") >= 0) {
                @set_time_limit(Config("EXPORT_ALL_TIME_LIMIT"));
            }
            $this->DisplayRecords = $this->TotalRecords;
            $this->StopRecord = $this->TotalRecords;
        } else { // Export one page only
            $this->setupStartRecord(); // Set up start record position
            // Set the last record to display
            if ($this->DisplayRecords <= 0) {
                $this->StopRecord = $this->TotalRecords;
            } else {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            }
        }
        $rs = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords);
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
        $this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "");
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset(all)
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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
        $infiniteScroll = ConvertToBool(Param("infinitescroll"));
        if ($pageNo !== null) { // Check for "pageno" parameter first
            $pageNo = ParseInteger($pageNo);
            if (is_numeric($pageNo)) {
                $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                if ($this->StartRecord <= 0) {
                    $this->StartRecord = 1;
                } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                    $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                }
            }
        } elseif ($startRec !== null && is_numeric($startRec)) { // Check for "start" parameter
            $this->StartRecord = $startRec;
        } elseif (!$infiniteScroll) {
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

    // Parse query builder rule
    protected function parseRules($group, $fieldName = "", $itemName = "") {
        $group["condition"] ??= "AND";
        if (!in_array($group["condition"], ["AND", "OR"])) {
            throw new \Exception("Unable to build SQL query with condition '" . $group["condition"] . "'");
        }
        if (!is_array($group["rules"] ?? null)) {
            return "";
        }
        $parts = [];
        foreach ($group["rules"] as $rule) {
            if (is_array($rule["rules"] ?? null) && count($rule["rules"]) > 0) {
                $part = $this->parseRules($rule, $fieldName, $itemName);
                if ($part) {
                    $parts[] = "(" . " " . $part . " " . ")" . " ";
                }
            } else {
                $field = $rule["field"];
                $fld = $this->fieldByParam($field);
                $dbid = $this->Dbid;
                if ($fld instanceof ReportField && is_array($fld->DashboardSearchSourceFields)) {
                    $item = $fld->DashboardSearchSourceFields[$itemName] ?? null;
                    if ($item) {
                        $tbl = Container($item["table"]);
                        $dbid = $tbl->Dbid;
                        $fld = $tbl->Fields[$item["field"]];
                    } else {
                        $fld = null;
                    }
                }
                if ($fld && ($fieldName == "" || $fld->Name == $fieldName)) { // Field name not specified or matched field name
                    $fldOpr = array_search($rule["operator"], Config("CLIENT_SEARCH_OPERATORS"));
                    $ope = Config("QUERY_BUILDER_OPERATORS")[$rule["operator"]] ?? null;
                    if (!$ope || !$fldOpr) {
                        throw new \Exception("Unknown SQL operation for operator '" . $rule["operator"] . "'");
                    }
                    if ($ope["nb_inputs"] > 0 && ($rule["value"] ?? false) || IsNullOrEmptyOperator($fldOpr)) {
                        $fldVal = $rule["value"];
                        if (is_array($fldVal)) {
                            $fldVal = $fld->isMultiSelect() ? implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal) : $fldVal[0];
                        }
                        $useFilter = $fld->UseFilter; // Query builder does not use filter
                        try {
                            if ($fld instanceof ReportField) { // Search report fields
                                if ($fld->SearchType == "dropdown") {
                                    if (is_array($fldVal)) {
                                        $sql = "";
                                        foreach ($fldVal as $val) {
                                            AddFilter($sql, DropDownFilter($fld, $val, $fldOpr, $dbid), "OR");
                                        }
                                        $parts[] = $sql;
                                    } else {
                                        $parts[] = DropDownFilter($fld, $fldVal, $fldOpr, $dbid);
                                    }
                                } else {
                                    $fld->AdvancedSearch->SearchOperator = $fldOpr;
                                    $fld->AdvancedSearch->SearchValue = $fldVal;
                                    $parts[] = GetReportFilter($fld, false, $dbid);
                                }
                            } else { // Search normal fields
                                if ($fld->isMultiSelect()) {
                                    $parts[] = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, ConvertSearchValue($fldVal, $fldOpr, $fld), $this->Dbid) : "";
                                } else {
                                    $fldVal2 = ContainsString($fldOpr, "BETWEEN") ? $rule["value"][1] : ""; // BETWEEN
                                    if (is_array($fldVal2)) {
                                        $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
                                    }
                                    $parts[] = GetSearchSql(
                                        $fld,
                                        ConvertSearchValue($fldVal, $fldOpr, $fld), // $fldVal
                                        $fldOpr,
                                        "", // $fldCond not used
                                        ConvertSearchValue($fldVal2, $fldOpr, $fld), // $fldVal2
                                        "", // $fldOpr2 not used
                                        $this->Dbid
                                    );
                                }
                            }
                        } finally {
                            $fld->UseFilter = $useFilter;
                        }
                    }
                }
            }
        }
        $where = "";
        foreach ($parts as $part) {
            AddFilter($where, $part, $group["condition"]);
        }
        if ($where && ($group["not"] ?? false)) {
            $where = "NOT (" . $where . ")";
        }
        return $where;
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

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
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

    // Page Importing event
    public function pageImporting(&$builder, &$options)
    {
        //var_dump($options); // Show all options for importing
        //$builder = fn($workflow) => $workflow->addStep($myStep);
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($obj, $results)
    {
        //var_dump($obj); // Workflow result object
        //var_dump($results); // Import results
    }
}
