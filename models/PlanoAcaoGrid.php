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
class PlanoAcaoGrid extends PlanoAcao
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "PlanoAcaoGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fplano_acaogrid";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "PlanoAcaoGrid";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

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
        $this->idplano_acao->Visible = false;
        $this->risco_oportunidade_idrisco_oportunidade->setVisibility();
        $this->dt_cadastro->Visible = false;
        $this->o_q_sera_feito->setVisibility();
        $this->efeito_esperado->setVisibility();
        $this->departamentos_iddepartamentos->setVisibility();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setVisibility();
        $this->recursos_nec->setVisibility();
        $this->dt_limite->setVisibility();
        $this->implementado->setVisibility();
        $this->periodicidade_idperiodicidade->setVisibility();
        $this->eficaz->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'plano_acao';
        $this->TableName = 'plano_acao';

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
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (plano_acao)
        if (!isset($GLOBALS["plano_acao"]) || $GLOBALS["plano_acao"]::class == PROJECT_NAMESPACE . "plano_acao") {
            $GLOBALS["plano_acao"] = &$this;
        }
        $this->AddUrl = "PlanoAcaoAdd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'plano_acao');
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
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

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
            $key .= @$ar['idplano_acao'];
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
            $this->idplano_acao->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->dt_cadastro->Visible = false;
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
    public $ShowOtherOptions = false;
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

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }
        if (Param("export") !== null) {
            $this->Export = Param("export");
        }

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

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

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->risco_oportunidade_idrisco_oportunidade);
        $this->setupLookupOptions($this->departamentos_iddepartamentos);
        $this->setupLookupOptions($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
        $this->setupLookupOptions($this->implementado);
        $this->setupLookupOptions($this->periodicidade_idperiodicidade);
        $this->setupLookupOptions($this->eficaz);

        // Load default values for add
        $this->loadDefaultValues();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fplano_acaogrid";
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

        // Set up records per page
        $this->setupDisplayRecords();

        // Handle reset command
        $this->resetCmd();

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

        // Hide other options
        if ($this->isExport()) {
            $this->OtherOptions->hideAllOptions();
        }

        // Show grid delete link for grid add / grid edit
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $item = $this->ListOptions["griddelete"];
                if ($item) {
                    $item->Visible = $Security->allowDelete(CurrentProjectID() . $this->TableName);
                }
            }
        }

        // Set up sorting order
        $this->setupSortOrder();

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 50; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Build filter
        if (!$Security->canList()) {
            $this->Filter = "(0=1)"; // Filter all records
        }

        // Restore master/detail filter from session
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Restore master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Restore detail filter from session
        AddFilter($this->Filter, $this->DbDetailFilter);
        AddFilter($this->Filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "risco_oportunidade") {
            $masterTbl = Container("risco_oportunidade");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("RiscoOportunidadeList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = RowType::MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

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
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
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
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
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

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->recursos_nec->FormValue = ""; // Clear form value
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to grid add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to grid edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old result set
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAllAssociative();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }
        $this->loadDefaultValues();
        $wrkfilter = "";
        $key = "";

        // Update row index and get row key
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete" && $rowaction != "hide") { // Skip insert then deleted rows / hidden rows for grid edit
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                        if ($gridUpdate) { // Get inserted or updated filter
                            AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                        }
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($gridUpdate) {
            $this->FilterForModalActions = $wrkfilter;

            // Get new records
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
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

    // Perform grid add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }
        $this->loadDefaultValues();

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            $rsold = null;
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $rsold = $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success
                $gridInsert = $this->addRow($rsold); // Insert row (already validated by validateGridForm())
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->idplano_acao->CurrentValue;

                    // Add filter for this record
                    AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                } else {
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $this->FilterForModalActions = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if (
            $CurrentForm->hasValue("x_risco_oportunidade_idrisco_oportunidade") &&
            $CurrentForm->hasValue("o_risco_oportunidade_idrisco_oportunidade") &&
            $this->risco_oportunidade_idrisco_oportunidade->CurrentValue != $this->risco_oportunidade_idrisco_oportunidade->DefaultValue &&
            !($this->risco_oportunidade_idrisco_oportunidade->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->risco_oportunidade_idrisco_oportunidade->CurrentValue == $this->risco_oportunidade_idrisco_oportunidade->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_o_q_sera_feito") &&
            $CurrentForm->hasValue("o_o_q_sera_feito") &&
            $this->o_q_sera_feito->CurrentValue != $this->o_q_sera_feito->DefaultValue &&
            !($this->o_q_sera_feito->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->o_q_sera_feito->CurrentValue == $this->o_q_sera_feito->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_efeito_esperado") &&
            $CurrentForm->hasValue("o_efeito_esperado") &&
            $this->efeito_esperado->CurrentValue != $this->efeito_esperado->DefaultValue &&
            !($this->efeito_esperado->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->efeito_esperado->CurrentValue == $this->efeito_esperado->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_departamentos_iddepartamentos") &&
            $CurrentForm->hasValue("o_departamentos_iddepartamentos") &&
            $this->departamentos_iddepartamentos->CurrentValue != $this->departamentos_iddepartamentos->DefaultValue &&
            !($this->departamentos_iddepartamentos->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->departamentos_iddepartamentos->CurrentValue == $this->departamentos_iddepartamentos->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_origem_risco_oportunidade_idorigem_risco_oportunidade") &&
            $CurrentForm->hasValue("o_origem_risco_oportunidade_idorigem_risco_oportunidade") &&
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue != $this->origem_risco_oportunidade_idorigem_risco_oportunidade->DefaultValue &&
            !($this->origem_risco_oportunidade_idorigem_risco_oportunidade->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue == $this->origem_risco_oportunidade_idorigem_risco_oportunidade->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_recursos_nec") &&
            $CurrentForm->hasValue("o_recursos_nec") &&
            $this->recursos_nec->CurrentValue != $this->recursos_nec->DefaultValue &&
            !($this->recursos_nec->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->recursos_nec->CurrentValue == $this->recursos_nec->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_dt_limite") &&
            $CurrentForm->hasValue("o_dt_limite") &&
            $this->dt_limite->CurrentValue != $this->dt_limite->DefaultValue &&
            !($this->dt_limite->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->dt_limite->CurrentValue == $this->dt_limite->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_implementado") &&
            $CurrentForm->hasValue("o_implementado") &&
            $this->implementado->CurrentValue != $this->implementado->DefaultValue &&
            !($this->implementado->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->implementado->CurrentValue == $this->implementado->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_periodicidade_idperiodicidade") &&
            $CurrentForm->hasValue("o_periodicidade_idperiodicidade") &&
            $this->periodicidade_idperiodicidade->CurrentValue != $this->periodicidade_idperiodicidade->DefaultValue &&
            !($this->periodicidade_idperiodicidade->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->periodicidade_idperiodicidade->CurrentValue == $this->periodicidade_idperiodicidade->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_eficaz") &&
            $CurrentForm->hasValue("o_eficaz") &&
            $this->eficaz->CurrentValue != $this->eficaz->DefaultValue &&
            !($this->eficaz->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->eficaz->CurrentValue == $this->eficaz->getSessionValue())
        ) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;

        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Load default values for emptyRow checking
        $this->loadDefaultValues();

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete" && $rowaction != "hide") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    $this->ValidationErrors[$rowindex] = $this->getValidationErrors();
                    $this->EventCancelled = true;
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        foreach ($this->Fields as $field) {
            $field->clearErrorMessage();
        }
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->idplano_acao->Expression . " DESC"; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
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
            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->risco_oportunidade_idrisco_oportunidade->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
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

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = true;
            $item->Visible = false; // Default hidden
        }

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
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Set up list options (extensions)
    protected function setupListOptionsExt()
    {
        // Preview extension
        $this->ListOptions->hideDetailItemsForDropDown(); // Hide detail items for dropdown if necessary
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

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->allowDelete(CurrentProjectID() . $this->TableName) && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"plano_acao\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"plano_acao\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"plano_acao\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("CopyLink") . "</a>";
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
        $option = $this->OtherOptions["addedit"];
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            if ($this->ModalAdd && !IsMobile()) {
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"plano_acao\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
            } else {
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            }
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
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
            if (in_array($this->CurrentMode, ["add", "copy", "edit"]) && !$this->isConfirm()) { // Check add/copy/edit mode
                if ($this->AllowAddDeleteRow) {
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = $Security->canAdd();
                    $this->ShowOtherOptions = $item->Visible;
                }
            }
            if ($this->CurrentMode == "view") { // Check view mode
                $option = $options["addedit"];
                $item = $option["add"];
                $this->ShowOtherOptions = $item?->Visible ?? false;
            }
    }

    // Set up Grid
    public function setupGrid()
    {
        global $CurrentForm;
        $this->StartRecord = 1;
        $this->StopRecord = $this->TotalRecords; // Show all records

        // Restore number of post back records
        if ($CurrentForm && ($this->isConfirm() || $this->EventCancelled)) {
            $CurrentForm->resetIndex();
            if ($CurrentForm->hasValue($this->FormKeyCountName) && ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm())) {
                $this->KeyCount = $CurrentForm->getValue($this->FormKeyCountName);
                $this->StopRecord = $this->StartRecord + $this->KeyCount - 1;
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_plano_acao", "data-rowtype" => RowType::ADD]);
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
        if ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm() || $this->isMultiEdit()) {
            $this->RowIndex++;
            $CurrentForm->Index = $this->RowIndex;
            if ($CurrentForm->hasValue($this->FormActionName) && ($this->isConfirm() || $this->EventCancelled)) {
                $this->RowAction = strval($CurrentForm->getValue($this->FormActionName));
            } elseif ($this->isGridAdd()) {
                $this->RowAction = "insert";
            } else {
                $this->RowAction = "";
            }
        }

        // Set up key count
        $this->KeyCount = $this->RowIndex;

        // Init row class and style
        $this->resetAttributes();
        $this->CssClass = "";
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->loadRowValues($this->CurrentRow); // Load row values
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
            } else {
                $this->loadRowValues(); // Load default values
                $this->OldKey = "";
            }
        } else {
            $this->loadRowValues($this->CurrentRow); // Load row values
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
        }
        $this->setKey($this->OldKey);
        $this->RowType = RowType::VIEW; // Render view
        if (($this->isAdd() || $this->isCopy()) && $this->InlineRowCount == 0 || $this->isGridAdd()) { // Add
            $this->RowType = RowType::ADD; // Render add
        }
        if ($this->isGridAdd() && $this->EventCancelled && !$CurrentForm->hasValue($this->FormBlankRowName)) { // Insert failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
        }
        if ($this->isGridEdit()) { // Grid edit
            if ($this->EventCancelled) {
                $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
            }
            if ($this->RowAction == "insert") {
                $this->RowType = RowType::ADD; // Render add
            } else {
                $this->RowType = RowType::EDIT; // Render edit
            }
        }
        if ($this->isGridEdit() && ($this->RowType == RowType::EDIT || $this->RowType == RowType::ADD) && $this->EventCancelled) { // Update failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
        }
        if ($this->isConfirm()) { // Confirm row
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
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
            "id" => "r" . $this->RowCount . "_plano_acao",
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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->recursos_nec->DefaultValue = $this->recursos_nec->getDefault(); // PHP
        $this->recursos_nec->OldValue = $this->recursos_nec->DefaultValue;
        $this->implementado->DefaultValue = $this->implementado->getDefault(); // PHP
        $this->implementado->OldValue = $this->implementado->DefaultValue;
        $this->eficaz->DefaultValue = $this->eficaz->getDefault(); // PHP
        $this->eficaz->OldValue = $this->eficaz->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'risco_oportunidade_idrisco_oportunidade' first before field var 'x_risco_oportunidade_idrisco_oportunidade'
        $val = $CurrentForm->hasValue("risco_oportunidade_idrisco_oportunidade") ? $CurrentForm->getValue("risco_oportunidade_idrisco_oportunidade") : $CurrentForm->getValue("x_risco_oportunidade_idrisco_oportunidade");
        if (!$this->risco_oportunidade_idrisco_oportunidade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->risco_oportunidade_idrisco_oportunidade->Visible = false; // Disable update for API request
            } else {
                $this->risco_oportunidade_idrisco_oportunidade->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_risco_oportunidade_idrisco_oportunidade")) {
            $this->risco_oportunidade_idrisco_oportunidade->setOldValue($CurrentForm->getValue("o_risco_oportunidade_idrisco_oportunidade"));
        }

        // Check field name 'o_q_sera_feito' first before field var 'x_o_q_sera_feito'
        $val = $CurrentForm->hasValue("o_q_sera_feito") ? $CurrentForm->getValue("o_q_sera_feito") : $CurrentForm->getValue("x_o_q_sera_feito");
        if (!$this->o_q_sera_feito->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->o_q_sera_feito->Visible = false; // Disable update for API request
            } else {
                $this->o_q_sera_feito->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_o_q_sera_feito")) {
            $this->o_q_sera_feito->setOldValue($CurrentForm->getValue("o_o_q_sera_feito"));
        }

        // Check field name 'efeito_esperado' first before field var 'x_efeito_esperado'
        $val = $CurrentForm->hasValue("efeito_esperado") ? $CurrentForm->getValue("efeito_esperado") : $CurrentForm->getValue("x_efeito_esperado");
        if (!$this->efeito_esperado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->efeito_esperado->Visible = false; // Disable update for API request
            } else {
                $this->efeito_esperado->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_efeito_esperado")) {
            $this->efeito_esperado->setOldValue($CurrentForm->getValue("o_efeito_esperado"));
        }

        // Check field name 'departamentos_iddepartamentos' first before field var 'x_departamentos_iddepartamentos'
        $val = $CurrentForm->hasValue("departamentos_iddepartamentos") ? $CurrentForm->getValue("departamentos_iddepartamentos") : $CurrentForm->getValue("x_departamentos_iddepartamentos");
        if (!$this->departamentos_iddepartamentos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->departamentos_iddepartamentos->Visible = false; // Disable update for API request
            } else {
                $this->departamentos_iddepartamentos->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_departamentos_iddepartamentos")) {
            $this->departamentos_iddepartamentos->setOldValue($CurrentForm->getValue("o_departamentos_iddepartamentos"));
        }

        // Check field name 'origem_risco_oportunidade_idorigem_risco_oportunidade' first before field var 'x_origem_risco_oportunidade_idorigem_risco_oportunidade'
        $val = $CurrentForm->hasValue("origem_risco_oportunidade_idorigem_risco_oportunidade") ? $CurrentForm->getValue("origem_risco_oportunidade_idorigem_risco_oportunidade") : $CurrentForm->getValue("x_origem_risco_oportunidade_idorigem_risco_oportunidade");
        if (!$this->origem_risco_oportunidade_idorigem_risco_oportunidade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible = false; // Disable update for API request
            } else {
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_origem_risco_oportunidade_idorigem_risco_oportunidade")) {
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setOldValue($CurrentForm->getValue("o_origem_risco_oportunidade_idorigem_risco_oportunidade"));
        }

        // Check field name 'recursos_nec' first before field var 'x_recursos_nec'
        $val = $CurrentForm->hasValue("recursos_nec") ? $CurrentForm->getValue("recursos_nec") : $CurrentForm->getValue("x_recursos_nec");
        if (!$this->recursos_nec->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->recursos_nec->Visible = false; // Disable update for API request
            } else {
                $this->recursos_nec->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_recursos_nec")) {
            $this->recursos_nec->setOldValue($CurrentForm->getValue("o_recursos_nec"));
        }

        // Check field name 'dt_limite' first before field var 'x_dt_limite'
        $val = $CurrentForm->hasValue("dt_limite") ? $CurrentForm->getValue("dt_limite") : $CurrentForm->getValue("x_dt_limite");
        if (!$this->dt_limite->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dt_limite->Visible = false; // Disable update for API request
            } else {
                $this->dt_limite->setFormValue($val, true, $validate);
            }
            $this->dt_limite->CurrentValue = UnFormatDateTime($this->dt_limite->CurrentValue, $this->dt_limite->formatPattern());
        }
        if ($CurrentForm->hasValue("o_dt_limite")) {
            $this->dt_limite->setOldValue($CurrentForm->getValue("o_dt_limite"));
        }

        // Check field name 'implementado' first before field var 'x_implementado'
        $val = $CurrentForm->hasValue("implementado") ? $CurrentForm->getValue("implementado") : $CurrentForm->getValue("x_implementado");
        if (!$this->implementado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->implementado->Visible = false; // Disable update for API request
            } else {
                $this->implementado->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_implementado")) {
            $this->implementado->setOldValue($CurrentForm->getValue("o_implementado"));
        }

        // Check field name 'periodicidade_idperiodicidade' first before field var 'x_periodicidade_idperiodicidade'
        $val = $CurrentForm->hasValue("periodicidade_idperiodicidade") ? $CurrentForm->getValue("periodicidade_idperiodicidade") : $CurrentForm->getValue("x_periodicidade_idperiodicidade");
        if (!$this->periodicidade_idperiodicidade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->periodicidade_idperiodicidade->Visible = false; // Disable update for API request
            } else {
                $this->periodicidade_idperiodicidade->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_periodicidade_idperiodicidade")) {
            $this->periodicidade_idperiodicidade->setOldValue($CurrentForm->getValue("o_periodicidade_idperiodicidade"));
        }

        // Check field name 'eficaz' first before field var 'x_eficaz'
        $val = $CurrentForm->hasValue("eficaz") ? $CurrentForm->getValue("eficaz") : $CurrentForm->getValue("x_eficaz");
        if (!$this->eficaz->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->eficaz->Visible = false; // Disable update for API request
            } else {
                $this->eficaz->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_eficaz")) {
            $this->eficaz->setOldValue($CurrentForm->getValue("o_eficaz"));
        }

        // Check field name 'idplano_acao' first before field var 'x_idplano_acao'
        $val = $CurrentForm->hasValue("idplano_acao") ? $CurrentForm->getValue("idplano_acao") : $CurrentForm->getValue("x_idplano_acao");
        if (!$this->idplano_acao->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->idplano_acao->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->idplano_acao->CurrentValue = $this->idplano_acao->FormValue;
        }
        $this->risco_oportunidade_idrisco_oportunidade->CurrentValue = $this->risco_oportunidade_idrisco_oportunidade->FormValue;
        $this->o_q_sera_feito->CurrentValue = $this->o_q_sera_feito->FormValue;
        $this->efeito_esperado->CurrentValue = $this->efeito_esperado->FormValue;
        $this->departamentos_iddepartamentos->CurrentValue = $this->departamentos_iddepartamentos->FormValue;
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->FormValue;
        $this->recursos_nec->CurrentValue = $this->recursos_nec->FormValue;
        $this->dt_limite->CurrentValue = $this->dt_limite->FormValue;
        $this->dt_limite->CurrentValue = UnFormatDateTime($this->dt_limite->CurrentValue, $this->dt_limite->formatPattern());
        $this->implementado->CurrentValue = $this->implementado->FormValue;
        $this->periodicidade_idperiodicidade->CurrentValue = $this->periodicidade_idperiodicidade->FormValue;
        $this->eficaz->CurrentValue = $this->eficaz->FormValue;
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
        $this->idplano_acao->setDbValue($row['idplano_acao']);
        $this->risco_oportunidade_idrisco_oportunidade->setDbValue($row['risco_oportunidade_idrisco_oportunidade']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->o_q_sera_feito->setDbValue($row['o_q_sera_feito']);
        $this->efeito_esperado->setDbValue($row['efeito_esperado']);
        $this->departamentos_iddepartamentos->setDbValue($row['departamentos_iddepartamentos']);
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValue($row['origem_risco_oportunidade_idorigem_risco_oportunidade']);
        $this->recursos_nec->setDbValue($row['recursos_nec']);
        $this->dt_limite->setDbValue($row['dt_limite']);
        $this->implementado->setDbValue($row['implementado']);
        $this->periodicidade_idperiodicidade->setDbValue($row['periodicidade_idperiodicidade']);
        $this->eficaz->setDbValue($row['eficaz']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idplano_acao'] = $this->idplano_acao->DefaultValue;
        $row['risco_oportunidade_idrisco_oportunidade'] = $this->risco_oportunidade_idrisco_oportunidade->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['o_q_sera_feito'] = $this->o_q_sera_feito->DefaultValue;
        $row['efeito_esperado'] = $this->efeito_esperado->DefaultValue;
        $row['departamentos_iddepartamentos'] = $this->departamentos_iddepartamentos->DefaultValue;
        $row['origem_risco_oportunidade_idorigem_risco_oportunidade'] = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->DefaultValue;
        $row['recursos_nec'] = $this->recursos_nec->DefaultValue;
        $row['dt_limite'] = $this->dt_limite->DefaultValue;
        $row['implementado'] = $this->implementado->DefaultValue;
        $row['periodicidade_idperiodicidade'] = $this->periodicidade_idperiodicidade->DefaultValue;
        $row['eficaz'] = $this->eficaz->DefaultValue;
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
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // idplano_acao

        // risco_oportunidade_idrisco_oportunidade

        // dt_cadastro

        // o_q_sera_feito

        // efeito_esperado

        // departamentos_iddepartamentos

        // origem_risco_oportunidade_idorigem_risco_oportunidade

        // recursos_nec

        // dt_limite

        // implementado

        // periodicidade_idperiodicidade

        // eficaz

        // Accumulate aggregate value
        if ($this->RowType != RowType::AGGREGATEINIT && $this->RowType != RowType::AGGREGATE && $this->RowType != RowType::PREVIEWFIELD) {
            if (is_numeric($this->recursos_nec->CurrentValue)) {
                $this->recursos_nec->Total += $this->recursos_nec->CurrentValue; // Accumulate total
            }
        }

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idplano_acao
            $this->idplano_acao->ViewValue = $this->idplano_acao->CurrentValue;

            // risco_oportunidade_idrisco_oportunidade
            $curVal = strval($this->risco_oportunidade_idrisco_oportunidade->CurrentValue);
            if ($curVal != "") {
                $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->lookupCacheOption($curVal);
                if ($this->risco_oportunidade_idrisco_oportunidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchExpression(), "=", $curVal, $this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchDataType(), "");
                    $sqlWrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->renderViewRow($rswrk[0]);
                        $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->displayValue($arwrk);
                    } else {
                        $this->risco_oportunidade_idrisco_oportunidade->ViewValue = FormatNumber($this->risco_oportunidade_idrisco_oportunidade->CurrentValue, $this->risco_oportunidade_idrisco_oportunidade->formatPattern());
                    }
                }
            } else {
                $this->risco_oportunidade_idrisco_oportunidade->ViewValue = null;
            }
            $this->risco_oportunidade_idrisco_oportunidade->CssClass = "fw-bold";
            $this->risco_oportunidade_idrisco_oportunidade->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // o_q_sera_feito
            $this->o_q_sera_feito->ViewValue = $this->o_q_sera_feito->CurrentValue;
            $this->o_q_sera_feito->CssClass = "fw-bold";

            // efeito_esperado
            $this->efeito_esperado->ViewValue = $this->efeito_esperado->CurrentValue;
            $this->efeito_esperado->CssClass = "fw-bold";

            // departamentos_iddepartamentos
            $curVal = strval($this->departamentos_iddepartamentos->CurrentValue);
            if ($curVal != "") {
                $this->departamentos_iddepartamentos->ViewValue = $this->departamentos_iddepartamentos->lookupCacheOption($curVal);
                if ($this->departamentos_iddepartamentos->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->departamentos_iddepartamentos->Lookup->getTable()->Fields["iddepartamentos"]->searchExpression(), "=", $curVal, $this->departamentos_iddepartamentos->Lookup->getTable()->Fields["iddepartamentos"]->searchDataType(), "");
                    $sqlWrk = $this->departamentos_iddepartamentos->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->departamentos_iddepartamentos->Lookup->renderViewRow($rswrk[0]);
                        $this->departamentos_iddepartamentos->ViewValue = $this->departamentos_iddepartamentos->displayValue($arwrk);
                    } else {
                        $this->departamentos_iddepartamentos->ViewValue = FormatNumber($this->departamentos_iddepartamentos->CurrentValue, $this->departamentos_iddepartamentos->formatPattern());
                    }
                }
            } else {
                $this->departamentos_iddepartamentos->ViewValue = null;
            }
            $this->departamentos_iddepartamentos->CssClass = "fw-bold";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $curVal = strval($this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue);
            if ($curVal != "") {
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupCacheOption($curVal);
                if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getTable()->Fields["idorigem_risco_oportunidade"]->searchExpression(), "=", $curVal, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getTable()->Fields["idorigem_risco_oportunidade"]->searchDataType(), "");
                    $sqlWrk = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->renderViewRow($rswrk[0]);
                        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->displayValue($arwrk);
                    } else {
                        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue = FormatNumber($this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->formatPattern());
                    }
                }
            } else {
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue = null;
            }
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CssClass = "fw-bold";

            // recursos_nec
            $this->recursos_nec->ViewValue = $this->recursos_nec->CurrentValue;
            $this->recursos_nec->ViewValue = FormatCurrency($this->recursos_nec->ViewValue, $this->recursos_nec->formatPattern());
            $this->recursos_nec->CssClass = "fw-bold";
            $this->recursos_nec->CellCssStyle .= "text-align: right;";

            // dt_limite
            $this->dt_limite->ViewValue = $this->dt_limite->CurrentValue;
            $this->dt_limite->ViewValue = FormatDateTime($this->dt_limite->ViewValue, $this->dt_limite->formatPattern());
            $this->dt_limite->CssClass = "fw-bold";

            // implementado
            if (strval($this->implementado->CurrentValue) != "") {
                $this->implementado->ViewValue = $this->implementado->optionCaption($this->implementado->CurrentValue);
            } else {
                $this->implementado->ViewValue = null;
            }
            $this->implementado->CssClass = "fw-bold";
            $this->implementado->CellCssStyle .= "text-align: center;";

            // periodicidade_idperiodicidade
            $curVal = strval($this->periodicidade_idperiodicidade->CurrentValue);
            if ($curVal != "") {
                $this->periodicidade_idperiodicidade->ViewValue = $this->periodicidade_idperiodicidade->lookupCacheOption($curVal);
                if ($this->periodicidade_idperiodicidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchExpression(), "=", $curVal, $this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchDataType(), "");
                    $sqlWrk = $this->periodicidade_idperiodicidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->periodicidade_idperiodicidade->Lookup->renderViewRow($rswrk[0]);
                        $this->periodicidade_idperiodicidade->ViewValue = $this->periodicidade_idperiodicidade->displayValue($arwrk);
                    } else {
                        $this->periodicidade_idperiodicidade->ViewValue = FormatNumber($this->periodicidade_idperiodicidade->CurrentValue, $this->periodicidade_idperiodicidade->formatPattern());
                    }
                }
            } else {
                $this->periodicidade_idperiodicidade->ViewValue = null;
            }
            $this->periodicidade_idperiodicidade->CssClass = "fw-bold";

            // eficaz
            if (strval($this->eficaz->CurrentValue) != "") {
                $this->eficaz->ViewValue = $this->eficaz->optionCaption($this->eficaz->CurrentValue);
            } else {
                $this->eficaz->ViewValue = null;
            }
            $this->eficaz->CssClass = "fw-bold";
            $this->eficaz->CellCssStyle .= "text-align: center;";

            // risco_oportunidade_idrisco_oportunidade
            $this->risco_oportunidade_idrisco_oportunidade->HrefValue = "";
            $this->risco_oportunidade_idrisco_oportunidade->TooltipValue = "";

            // o_q_sera_feito
            $this->o_q_sera_feito->HrefValue = "";
            $this->o_q_sera_feito->TooltipValue = "";
            if (!$this->isExport()) {
                $this->o_q_sera_feito->ViewValue = $this->highlightValue($this->o_q_sera_feito);
            }

            // efeito_esperado
            $this->efeito_esperado->HrefValue = "";
            $this->efeito_esperado->TooltipValue = "";
            if (!$this->isExport()) {
                $this->efeito_esperado->ViewValue = $this->highlightValue($this->efeito_esperado);
            }

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->HrefValue = "";
            $this->departamentos_iddepartamentos->TooltipValue = "";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->TooltipValue = "";

            // recursos_nec
            $this->recursos_nec->HrefValue = "";
            $this->recursos_nec->TooltipValue = "";

            // dt_limite
            $this->dt_limite->HrefValue = "";
            $this->dt_limite->TooltipValue = "";
            if (!$this->isExport()) {
                $this->dt_limite->ViewValue = $this->highlightValue($this->dt_limite);
            }

            // implementado
            $this->implementado->HrefValue = "";
            $this->implementado->TooltipValue = "";

            // periodicidade_idperiodicidade
            $this->periodicidade_idperiodicidade->HrefValue = "";
            $this->periodicidade_idperiodicidade->TooltipValue = "";

            // eficaz
            $this->eficaz->HrefValue = "";
            $this->eficaz->TooltipValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // risco_oportunidade_idrisco_oportunidade
            $this->risco_oportunidade_idrisco_oportunidade->setupEditAttributes();
            if ($this->risco_oportunidade_idrisco_oportunidade->getSessionValue() != "") {
                $this->risco_oportunidade_idrisco_oportunidade->CurrentValue = GetForeignKeyValue($this->risco_oportunidade_idrisco_oportunidade->getSessionValue());
                $this->risco_oportunidade_idrisco_oportunidade->OldValue = $this->risco_oportunidade_idrisco_oportunidade->CurrentValue;
                $curVal = strval($this->risco_oportunidade_idrisco_oportunidade->CurrentValue);
                if ($curVal != "") {
                    $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->lookupCacheOption($curVal);
                    if ($this->risco_oportunidade_idrisco_oportunidade->ViewValue === null) { // Lookup from database
                        $filterWrk = SearchFilter($this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchExpression(), "=", $curVal, $this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchDataType(), "");
                        $sqlWrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCache($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->renderViewRow($rswrk[0]);
                            $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->displayValue($arwrk);
                        } else {
                            $this->risco_oportunidade_idrisco_oportunidade->ViewValue = FormatNumber($this->risco_oportunidade_idrisco_oportunidade->CurrentValue, $this->risco_oportunidade_idrisco_oportunidade->formatPattern());
                        }
                    }
                } else {
                    $this->risco_oportunidade_idrisco_oportunidade->ViewValue = null;
                }
                $this->risco_oportunidade_idrisco_oportunidade->CssClass = "fw-bold";
                $this->risco_oportunidade_idrisco_oportunidade->CellCssStyle .= "text-align: center;";
            } else {
                $curVal = trim(strval($this->risco_oportunidade_idrisco_oportunidade->CurrentValue));
                if ($curVal != "") {
                    $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->lookupCacheOption($curVal);
                } else {
                    $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->Lookup !== null && is_array($this->risco_oportunidade_idrisco_oportunidade->lookupOptions()) && count($this->risco_oportunidade_idrisco_oportunidade->lookupOptions()) > 0 ? $curVal : null;
                }
                if ($this->risco_oportunidade_idrisco_oportunidade->ViewValue !== null) { // Load from cache
                    $this->risco_oportunidade_idrisco_oportunidade->EditValue = array_values($this->risco_oportunidade_idrisco_oportunidade->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = SearchFilter($this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchExpression(), "=", $this->risco_oportunidade_idrisco_oportunidade->CurrentValue, $this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchDataType(), "");
                    }
                    $sqlWrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->risco_oportunidade_idrisco_oportunidade->EditValue = $arwrk;
                }
                $this->risco_oportunidade_idrisco_oportunidade->PlaceHolder = RemoveHtml($this->risco_oportunidade_idrisco_oportunidade->caption());
            }

            // o_q_sera_feito
            $this->o_q_sera_feito->setupEditAttributes();
            $this->o_q_sera_feito->EditValue = HtmlEncode($this->o_q_sera_feito->CurrentValue);
            $this->o_q_sera_feito->PlaceHolder = RemoveHtml($this->o_q_sera_feito->caption());

            // efeito_esperado
            $this->efeito_esperado->setupEditAttributes();
            $this->efeito_esperado->EditValue = HtmlEncode($this->efeito_esperado->CurrentValue);
            $this->efeito_esperado->PlaceHolder = RemoveHtml($this->efeito_esperado->caption());

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->setupEditAttributes();
            $curVal = trim(strval($this->departamentos_iddepartamentos->CurrentValue));
            if ($curVal != "") {
                $this->departamentos_iddepartamentos->ViewValue = $this->departamentos_iddepartamentos->lookupCacheOption($curVal);
            } else {
                $this->departamentos_iddepartamentos->ViewValue = $this->departamentos_iddepartamentos->Lookup !== null && is_array($this->departamentos_iddepartamentos->lookupOptions()) && count($this->departamentos_iddepartamentos->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->departamentos_iddepartamentos->ViewValue !== null) { // Load from cache
                $this->departamentos_iddepartamentos->EditValue = array_values($this->departamentos_iddepartamentos->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->departamentos_iddepartamentos->Lookup->getTable()->Fields["iddepartamentos"]->searchExpression(), "=", $this->departamentos_iddepartamentos->CurrentValue, $this->departamentos_iddepartamentos->Lookup->getTable()->Fields["iddepartamentos"]->searchDataType(), "");
                }
                $sqlWrk = $this->departamentos_iddepartamentos->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->departamentos_iddepartamentos->EditValue = $arwrk;
            }
            $this->departamentos_iddepartamentos->PlaceHolder = RemoveHtml($this->departamentos_iddepartamentos->caption());

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setupEditAttributes();
            $curVal = trim(strval($this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue));
            if ($curVal != "") {
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupCacheOption($curVal);
            } else {
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup !== null && is_array($this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupOptions()) && count($this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue !== null) { // Load from cache
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->EditValue = array_values($this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getTable()->Fields["idorigem_risco_oportunidade"]->searchExpression(), "=", $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getTable()->Fields["idorigem_risco_oportunidade"]->searchDataType(), "");
                }
                $sqlWrk = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->EditValue = $arwrk;
            }
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->PlaceHolder = RemoveHtml($this->origem_risco_oportunidade_idorigem_risco_oportunidade->caption());

            // recursos_nec
            $this->recursos_nec->setupEditAttributes();
            $this->recursos_nec->EditValue = $this->recursos_nec->CurrentValue;
            $this->recursos_nec->PlaceHolder = RemoveHtml($this->recursos_nec->caption());
            if (strval($this->recursos_nec->EditValue) != "" && is_numeric($this->recursos_nec->EditValue)) {
                $this->recursos_nec->EditValue = FormatNumber($this->recursos_nec->EditValue, null);
            }

            // dt_limite
            $this->dt_limite->setupEditAttributes();
            $this->dt_limite->EditValue = HtmlEncode(FormatDateTime($this->dt_limite->CurrentValue, $this->dt_limite->formatPattern()));
            $this->dt_limite->PlaceHolder = RemoveHtml($this->dt_limite->caption());

            // implementado
            $this->implementado->EditValue = $this->implementado->options(false);
            $this->implementado->PlaceHolder = RemoveHtml($this->implementado->caption());

            // periodicidade_idperiodicidade
            $curVal = trim(strval($this->periodicidade_idperiodicidade->CurrentValue));
            if ($curVal != "") {
                $this->periodicidade_idperiodicidade->ViewValue = $this->periodicidade_idperiodicidade->lookupCacheOption($curVal);
            } else {
                $this->periodicidade_idperiodicidade->ViewValue = $this->periodicidade_idperiodicidade->Lookup !== null && is_array($this->periodicidade_idperiodicidade->lookupOptions()) && count($this->periodicidade_idperiodicidade->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->periodicidade_idperiodicidade->ViewValue !== null) { // Load from cache
                $this->periodicidade_idperiodicidade->EditValue = array_values($this->periodicidade_idperiodicidade->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchExpression(), "=", $this->periodicidade_idperiodicidade->CurrentValue, $this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchDataType(), "");
                }
                $sqlWrk = $this->periodicidade_idperiodicidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->periodicidade_idperiodicidade->EditValue = $arwrk;
            }
            $this->periodicidade_idperiodicidade->PlaceHolder = RemoveHtml($this->periodicidade_idperiodicidade->caption());

            // eficaz
            $this->eficaz->EditValue = $this->eficaz->options(false);
            $this->eficaz->PlaceHolder = RemoveHtml($this->eficaz->caption());

            // Add refer script

            // risco_oportunidade_idrisco_oportunidade
            $this->risco_oportunidade_idrisco_oportunidade->HrefValue = "";

            // o_q_sera_feito
            $this->o_q_sera_feito->HrefValue = "";

            // efeito_esperado
            $this->efeito_esperado->HrefValue = "";

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->HrefValue = "";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";

            // recursos_nec
            $this->recursos_nec->HrefValue = "";

            // dt_limite
            $this->dt_limite->HrefValue = "";

            // implementado
            $this->implementado->HrefValue = "";

            // periodicidade_idperiodicidade
            $this->periodicidade_idperiodicidade->HrefValue = "";

            // eficaz
            $this->eficaz->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // risco_oportunidade_idrisco_oportunidade
            $this->risco_oportunidade_idrisco_oportunidade->setupEditAttributes();
            if ($this->risco_oportunidade_idrisco_oportunidade->getSessionValue() != "") {
                $this->risco_oportunidade_idrisco_oportunidade->CurrentValue = GetForeignKeyValue($this->risco_oportunidade_idrisco_oportunidade->getSessionValue());
                $this->risco_oportunidade_idrisco_oportunidade->OldValue = $this->risco_oportunidade_idrisco_oportunidade->CurrentValue;
                $curVal = strval($this->risco_oportunidade_idrisco_oportunidade->CurrentValue);
                if ($curVal != "") {
                    $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->lookupCacheOption($curVal);
                    if ($this->risco_oportunidade_idrisco_oportunidade->ViewValue === null) { // Lookup from database
                        $filterWrk = SearchFilter($this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchExpression(), "=", $curVal, $this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchDataType(), "");
                        $sqlWrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCache($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->renderViewRow($rswrk[0]);
                            $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->displayValue($arwrk);
                        } else {
                            $this->risco_oportunidade_idrisco_oportunidade->ViewValue = FormatNumber($this->risco_oportunidade_idrisco_oportunidade->CurrentValue, $this->risco_oportunidade_idrisco_oportunidade->formatPattern());
                        }
                    }
                } else {
                    $this->risco_oportunidade_idrisco_oportunidade->ViewValue = null;
                }
                $this->risco_oportunidade_idrisco_oportunidade->CssClass = "fw-bold";
                $this->risco_oportunidade_idrisco_oportunidade->CellCssStyle .= "text-align: center;";
            } else {
                $curVal = trim(strval($this->risco_oportunidade_idrisco_oportunidade->CurrentValue));
                if ($curVal != "") {
                    $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->lookupCacheOption($curVal);
                } else {
                    $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->Lookup !== null && is_array($this->risco_oportunidade_idrisco_oportunidade->lookupOptions()) && count($this->risco_oportunidade_idrisco_oportunidade->lookupOptions()) > 0 ? $curVal : null;
                }
                if ($this->risco_oportunidade_idrisco_oportunidade->ViewValue !== null) { // Load from cache
                    $this->risco_oportunidade_idrisco_oportunidade->EditValue = array_values($this->risco_oportunidade_idrisco_oportunidade->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = SearchFilter($this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchExpression(), "=", $this->risco_oportunidade_idrisco_oportunidade->CurrentValue, $this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchDataType(), "");
                    }
                    $sqlWrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->risco_oportunidade_idrisco_oportunidade->EditValue = $arwrk;
                }
                $this->risco_oportunidade_idrisco_oportunidade->PlaceHolder = RemoveHtml($this->risco_oportunidade_idrisco_oportunidade->caption());
            }

            // o_q_sera_feito
            $this->o_q_sera_feito->setupEditAttributes();
            $this->o_q_sera_feito->EditValue = HtmlEncode($this->o_q_sera_feito->CurrentValue);
            $this->o_q_sera_feito->PlaceHolder = RemoveHtml($this->o_q_sera_feito->caption());

            // efeito_esperado
            $this->efeito_esperado->setupEditAttributes();
            $this->efeito_esperado->EditValue = HtmlEncode($this->efeito_esperado->CurrentValue);
            $this->efeito_esperado->PlaceHolder = RemoveHtml($this->efeito_esperado->caption());

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->setupEditAttributes();
            $curVal = trim(strval($this->departamentos_iddepartamentos->CurrentValue));
            if ($curVal != "") {
                $this->departamentos_iddepartamentos->ViewValue = $this->departamentos_iddepartamentos->lookupCacheOption($curVal);
            } else {
                $this->departamentos_iddepartamentos->ViewValue = $this->departamentos_iddepartamentos->Lookup !== null && is_array($this->departamentos_iddepartamentos->lookupOptions()) && count($this->departamentos_iddepartamentos->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->departamentos_iddepartamentos->ViewValue !== null) { // Load from cache
                $this->departamentos_iddepartamentos->EditValue = array_values($this->departamentos_iddepartamentos->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->departamentos_iddepartamentos->Lookup->getTable()->Fields["iddepartamentos"]->searchExpression(), "=", $this->departamentos_iddepartamentos->CurrentValue, $this->departamentos_iddepartamentos->Lookup->getTable()->Fields["iddepartamentos"]->searchDataType(), "");
                }
                $sqlWrk = $this->departamentos_iddepartamentos->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->departamentos_iddepartamentos->EditValue = $arwrk;
            }
            $this->departamentos_iddepartamentos->PlaceHolder = RemoveHtml($this->departamentos_iddepartamentos->caption());

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setupEditAttributes();
            $curVal = trim(strval($this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue));
            if ($curVal != "") {
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupCacheOption($curVal);
            } else {
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup !== null && is_array($this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupOptions()) && count($this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue !== null) { // Load from cache
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->EditValue = array_values($this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getTable()->Fields["idorigem_risco_oportunidade"]->searchExpression(), "=", $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getTable()->Fields["idorigem_risco_oportunidade"]->searchDataType(), "");
                }
                $sqlWrk = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->EditValue = $arwrk;
            }
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->PlaceHolder = RemoveHtml($this->origem_risco_oportunidade_idorigem_risco_oportunidade->caption());

            // recursos_nec
            $this->recursos_nec->setupEditAttributes();
            $this->recursos_nec->EditValue = $this->recursos_nec->CurrentValue;
            $this->recursos_nec->PlaceHolder = RemoveHtml($this->recursos_nec->caption());
            if (strval($this->recursos_nec->EditValue) != "" && is_numeric($this->recursos_nec->EditValue)) {
                $this->recursos_nec->EditValue = FormatNumber($this->recursos_nec->EditValue, null);
            }

            // dt_limite
            $this->dt_limite->setupEditAttributes();
            $this->dt_limite->EditValue = HtmlEncode(FormatDateTime($this->dt_limite->CurrentValue, $this->dt_limite->formatPattern()));
            $this->dt_limite->PlaceHolder = RemoveHtml($this->dt_limite->caption());

            // implementado
            $this->implementado->EditValue = $this->implementado->options(false);
            $this->implementado->PlaceHolder = RemoveHtml($this->implementado->caption());

            // periodicidade_idperiodicidade
            $curVal = trim(strval($this->periodicidade_idperiodicidade->CurrentValue));
            if ($curVal != "") {
                $this->periodicidade_idperiodicidade->ViewValue = $this->periodicidade_idperiodicidade->lookupCacheOption($curVal);
            } else {
                $this->periodicidade_idperiodicidade->ViewValue = $this->periodicidade_idperiodicidade->Lookup !== null && is_array($this->periodicidade_idperiodicidade->lookupOptions()) && count($this->periodicidade_idperiodicidade->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->periodicidade_idperiodicidade->ViewValue !== null) { // Load from cache
                $this->periodicidade_idperiodicidade->EditValue = array_values($this->periodicidade_idperiodicidade->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchExpression(), "=", $this->periodicidade_idperiodicidade->CurrentValue, $this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchDataType(), "");
                }
                $sqlWrk = $this->periodicidade_idperiodicidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->periodicidade_idperiodicidade->EditValue = $arwrk;
            }
            $this->periodicidade_idperiodicidade->PlaceHolder = RemoveHtml($this->periodicidade_idperiodicidade->caption());

            // eficaz
            $this->eficaz->EditValue = $this->eficaz->options(false);
            $this->eficaz->PlaceHolder = RemoveHtml($this->eficaz->caption());

            // Edit refer script

            // risco_oportunidade_idrisco_oportunidade
            $this->risco_oportunidade_idrisco_oportunidade->HrefValue = "";

            // o_q_sera_feito
            $this->o_q_sera_feito->HrefValue = "";

            // efeito_esperado
            $this->efeito_esperado->HrefValue = "";

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->HrefValue = "";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";

            // recursos_nec
            $this->recursos_nec->HrefValue = "";

            // dt_limite
            $this->dt_limite->HrefValue = "";

            // implementado
            $this->implementado->HrefValue = "";

            // periodicidade_idperiodicidade
            $this->periodicidade_idperiodicidade->HrefValue = "";

            // eficaz
            $this->eficaz->HrefValue = "";
        } elseif ($this->RowType == RowType::AGGREGATEINIT) { // Initialize aggregate row
                    $this->recursos_nec->Total = 0; // Initialize total
        } elseif ($this->RowType == RowType::AGGREGATE) { // Aggregate row
            $this->recursos_nec->CurrentValue = $this->recursos_nec->Total;
            $this->recursos_nec->ViewValue = $this->recursos_nec->CurrentValue;
            $this->recursos_nec->ViewValue = FormatCurrency($this->recursos_nec->ViewValue, $this->recursos_nec->formatPattern());
            $this->recursos_nec->CssClass = "fw-bold";
            $this->recursos_nec->CellCssStyle .= "text-align: right;";
            $this->recursos_nec->HrefValue = ""; // Clear href value
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
            if ($this->risco_oportunidade_idrisco_oportunidade->Visible && $this->risco_oportunidade_idrisco_oportunidade->Required) {
                if (!$this->risco_oportunidade_idrisco_oportunidade->IsDetailKey && EmptyValue($this->risco_oportunidade_idrisco_oportunidade->FormValue)) {
                    $this->risco_oportunidade_idrisco_oportunidade->addErrorMessage(str_replace("%s", $this->risco_oportunidade_idrisco_oportunidade->caption(), $this->risco_oportunidade_idrisco_oportunidade->RequiredErrorMessage));
                }
            }
            if ($this->o_q_sera_feito->Visible && $this->o_q_sera_feito->Required) {
                if (!$this->o_q_sera_feito->IsDetailKey && EmptyValue($this->o_q_sera_feito->FormValue)) {
                    $this->o_q_sera_feito->addErrorMessage(str_replace("%s", $this->o_q_sera_feito->caption(), $this->o_q_sera_feito->RequiredErrorMessage));
                }
            }
            if ($this->efeito_esperado->Visible && $this->efeito_esperado->Required) {
                if (!$this->efeito_esperado->IsDetailKey && EmptyValue($this->efeito_esperado->FormValue)) {
                    $this->efeito_esperado->addErrorMessage(str_replace("%s", $this->efeito_esperado->caption(), $this->efeito_esperado->RequiredErrorMessage));
                }
            }
            if ($this->departamentos_iddepartamentos->Visible && $this->departamentos_iddepartamentos->Required) {
                if (!$this->departamentos_iddepartamentos->IsDetailKey && EmptyValue($this->departamentos_iddepartamentos->FormValue)) {
                    $this->departamentos_iddepartamentos->addErrorMessage(str_replace("%s", $this->departamentos_iddepartamentos->caption(), $this->departamentos_iddepartamentos->RequiredErrorMessage));
                }
            }
            if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible && $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Required) {
                if (!$this->origem_risco_oportunidade_idorigem_risco_oportunidade->IsDetailKey && EmptyValue($this->origem_risco_oportunidade_idorigem_risco_oportunidade->FormValue)) {
                    $this->origem_risco_oportunidade_idorigem_risco_oportunidade->addErrorMessage(str_replace("%s", $this->origem_risco_oportunidade_idorigem_risco_oportunidade->caption(), $this->origem_risco_oportunidade_idorigem_risco_oportunidade->RequiredErrorMessage));
                }
            }
            if ($this->recursos_nec->Visible && $this->recursos_nec->Required) {
                if (!$this->recursos_nec->IsDetailKey && EmptyValue($this->recursos_nec->FormValue)) {
                    $this->recursos_nec->addErrorMessage(str_replace("%s", $this->recursos_nec->caption(), $this->recursos_nec->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->recursos_nec->FormValue)) {
                $this->recursos_nec->addErrorMessage($this->recursos_nec->getErrorMessage(false));
            }
            if ($this->dt_limite->Visible && $this->dt_limite->Required) {
                if (!$this->dt_limite->IsDetailKey && EmptyValue($this->dt_limite->FormValue)) {
                    $this->dt_limite->addErrorMessage(str_replace("%s", $this->dt_limite->caption(), $this->dt_limite->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->dt_limite->FormValue, $this->dt_limite->formatPattern())) {
                $this->dt_limite->addErrorMessage($this->dt_limite->getErrorMessage(false));
            }
            if ($this->implementado->Visible && $this->implementado->Required) {
                if ($this->implementado->FormValue == "") {
                    $this->implementado->addErrorMessage(str_replace("%s", $this->implementado->caption(), $this->implementado->RequiredErrorMessage));
                }
            }
            if ($this->periodicidade_idperiodicidade->Visible && $this->periodicidade_idperiodicidade->Required) {
                if ($this->periodicidade_idperiodicidade->FormValue == "") {
                    $this->periodicidade_idperiodicidade->addErrorMessage(str_replace("%s", $this->periodicidade_idperiodicidade->caption(), $this->periodicidade_idperiodicidade->RequiredErrorMessage));
                }
            }
            if ($this->eficaz->Visible && $this->eficaz->Required) {
                if ($this->eficaz->FormValue == "") {
                    $this->eficaz->addErrorMessage(str_replace("%s", $this->eficaz->caption(), $this->eficaz->RequiredErrorMessage));
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

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['idplano_acao'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
                if (!$deleteRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        return $deleteRows;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Load old values
            $this->loadDbValues($rsold);
        }

        // Get new row
        $rsnew = $this->getEditRow($rsold);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check referential integrity for master table 'risco_oportunidade'
        $detailKeys = [];
        $keyValue = $rsnew['risco_oportunidade_idrisco_oportunidade'] ?? $rsold['risco_oportunidade_idrisco_oportunidade'];
        $detailKeys['risco_oportunidade_idrisco_oportunidade'] = $keyValue;
        $masterTable = Container("risco_oportunidade");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "risco_oportunidade", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
                if (!$editRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }
        return $editRow;
    }

    /**
     * Get edit row
     *
     * @return array
     */
    protected function getEditRow($rsold)
    {
        global $Security;
        $rsnew = [];

        // risco_oportunidade_idrisco_oportunidade
        if ($this->risco_oportunidade_idrisco_oportunidade->getSessionValue() != "") {
            $this->risco_oportunidade_idrisco_oportunidade->ReadOnly = true;
        }
        $this->risco_oportunidade_idrisco_oportunidade->setDbValueDef($rsnew, $this->risco_oportunidade_idrisco_oportunidade->CurrentValue, $this->risco_oportunidade_idrisco_oportunidade->ReadOnly);

        // o_q_sera_feito
        $this->o_q_sera_feito->setDbValueDef($rsnew, $this->o_q_sera_feito->CurrentValue, $this->o_q_sera_feito->ReadOnly);

        // efeito_esperado
        $this->efeito_esperado->setDbValueDef($rsnew, $this->efeito_esperado->CurrentValue, $this->efeito_esperado->ReadOnly);

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->setDbValueDef($rsnew, $this->departamentos_iddepartamentos->CurrentValue, $this->departamentos_iddepartamentos->ReadOnly);

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValueDef($rsnew, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ReadOnly);

        // recursos_nec
        $this->recursos_nec->setDbValueDef($rsnew, $this->recursos_nec->CurrentValue, $this->recursos_nec->ReadOnly);

        // dt_limite
        $this->dt_limite->setDbValueDef($rsnew, UnFormatDateTime($this->dt_limite->CurrentValue, $this->dt_limite->formatPattern()), $this->dt_limite->ReadOnly);

        // implementado
        $this->implementado->setDbValueDef($rsnew, $this->implementado->CurrentValue, $this->implementado->ReadOnly);

        // periodicidade_idperiodicidade
        $this->periodicidade_idperiodicidade->setDbValueDef($rsnew, $this->periodicidade_idperiodicidade->CurrentValue, $this->periodicidade_idperiodicidade->ReadOnly);

        // eficaz
        $this->eficaz->setDbValueDef($rsnew, $this->eficaz->CurrentValue, $this->eficaz->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['risco_oportunidade_idrisco_oportunidade'])) { // risco_oportunidade_idrisco_oportunidade
            $this->risco_oportunidade_idrisco_oportunidade->CurrentValue = $row['risco_oportunidade_idrisco_oportunidade'];
        }
        if (isset($row['o_q_sera_feito'])) { // o_q_sera_feito
            $this->o_q_sera_feito->CurrentValue = $row['o_q_sera_feito'];
        }
        if (isset($row['efeito_esperado'])) { // efeito_esperado
            $this->efeito_esperado->CurrentValue = $row['efeito_esperado'];
        }
        if (isset($row['departamentos_iddepartamentos'])) { // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->CurrentValue = $row['departamentos_iddepartamentos'];
        }
        if (isset($row['origem_risco_oportunidade_idorigem_risco_oportunidade'])) { // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue = $row['origem_risco_oportunidade_idorigem_risco_oportunidade'];
        }
        if (isset($row['recursos_nec'])) { // recursos_nec
            $this->recursos_nec->CurrentValue = $row['recursos_nec'];
        }
        if (isset($row['dt_limite'])) { // dt_limite
            $this->dt_limite->CurrentValue = $row['dt_limite'];
        }
        if (isset($row['implementado'])) { // implementado
            $this->implementado->CurrentValue = $row['implementado'];
        }
        if (isset($row['periodicidade_idperiodicidade'])) { // periodicidade_idperiodicidade
            $this->periodicidade_idperiodicidade->CurrentValue = $row['periodicidade_idperiodicidade'];
        }
        if (isset($row['eficaz'])) { // eficaz
            $this->eficaz->CurrentValue = $row['eficaz'];
        }
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "risco_oportunidade") {
            $this->risco_oportunidade_idrisco_oportunidade->Visible = true; // Need to insert foreign key
            $this->risco_oportunidade_idrisco_oportunidade->CurrentValue = $this->risco_oportunidade_idrisco_oportunidade->getSessionValue();
        }

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check referential integrity for master table 'plano_acao'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["risco_oportunidade_idrisco_oportunidade"] = $this->risco_oportunidade_idrisco_oportunidade->CurrentValue;
        $masterTable = Container("risco_oportunidade");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "risco_oportunidade", $Language->phrase("RelatedRecordRequired"));
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

        // risco_oportunidade_idrisco_oportunidade
        $this->risco_oportunidade_idrisco_oportunidade->setDbValueDef($rsnew, $this->risco_oportunidade_idrisco_oportunidade->CurrentValue, false);

        // o_q_sera_feito
        $this->o_q_sera_feito->setDbValueDef($rsnew, $this->o_q_sera_feito->CurrentValue, false);

        // efeito_esperado
        $this->efeito_esperado->setDbValueDef($rsnew, $this->efeito_esperado->CurrentValue, false);

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->setDbValueDef($rsnew, $this->departamentos_iddepartamentos->CurrentValue, false);

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValueDef($rsnew, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue, false);

        // recursos_nec
        $this->recursos_nec->setDbValueDef($rsnew, $this->recursos_nec->CurrentValue, strval($this->recursos_nec->CurrentValue) == "");

        // dt_limite
        $this->dt_limite->setDbValueDef($rsnew, UnFormatDateTime($this->dt_limite->CurrentValue, $this->dt_limite->formatPattern()), false);

        // implementado
        $this->implementado->setDbValueDef($rsnew, $this->implementado->CurrentValue, strval($this->implementado->CurrentValue) == "");

        // periodicidade_idperiodicidade
        $this->periodicidade_idperiodicidade->setDbValueDef($rsnew, $this->periodicidade_idperiodicidade->CurrentValue, false);

        // eficaz
        $this->eficaz->setDbValueDef($rsnew, $this->eficaz->CurrentValue, strval($this->eficaz->CurrentValue) == "");
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['risco_oportunidade_idrisco_oportunidade'])) { // risco_oportunidade_idrisco_oportunidade
            $this->risco_oportunidade_idrisco_oportunidade->setFormValue($row['risco_oportunidade_idrisco_oportunidade']);
        }
        if (isset($row['o_q_sera_feito'])) { // o_q_sera_feito
            $this->o_q_sera_feito->setFormValue($row['o_q_sera_feito']);
        }
        if (isset($row['efeito_esperado'])) { // efeito_esperado
            $this->efeito_esperado->setFormValue($row['efeito_esperado']);
        }
        if (isset($row['departamentos_iddepartamentos'])) { // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->setFormValue($row['departamentos_iddepartamentos']);
        }
        if (isset($row['origem_risco_oportunidade_idorigem_risco_oportunidade'])) { // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setFormValue($row['origem_risco_oportunidade_idorigem_risco_oportunidade']);
        }
        if (isset($row['recursos_nec'])) { // recursos_nec
            $this->recursos_nec->setFormValue($row['recursos_nec']);
        }
        if (isset($row['dt_limite'])) { // dt_limite
            $this->dt_limite->setFormValue($row['dt_limite']);
        }
        if (isset($row['implementado'])) { // implementado
            $this->implementado->setFormValue($row['implementado']);
        }
        if (isset($row['periodicidade_idperiodicidade'])) { // periodicidade_idperiodicidade
            $this->periodicidade_idperiodicidade->setFormValue($row['periodicidade_idperiodicidade']);
        }
        if (isset($row['eficaz'])) { // eficaz
            $this->eficaz->setFormValue($row['eficaz']);
        }
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "risco_oportunidade") {
            $masterTbl = Container("risco_oportunidade");
            $this->risco_oportunidade_idrisco_oportunidade->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
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
                case "x_risco_oportunidade_idrisco_oportunidade":
                    break;
                case "x_departamentos_iddepartamentos":
                    break;
                case "x_origem_risco_oportunidade_idorigem_risco_oportunidade":
                    break;
                case "x_implementado":
                    break;
                case "x_periodicidade_idperiodicidade":
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
}
