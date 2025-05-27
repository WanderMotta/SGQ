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
class GraficosAdd extends Graficos
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "GraficosAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "GraficosAdd";

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
        $this->idgraficos->Visible = false;
        $this->competencia_idcompetencia->setVisibility();
        $this->indicadores_idindicadores->setVisibility();
        $this->data_base->Visible = false;
        $this->valor->setVisibility();
        $this->obs->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'graficos';
        $this->TableName = 'graficos';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (graficos)
        if (!isset($GLOBALS["graficos"]) || $GLOBALS["graficos"]::class == PROJECT_NAMESPACE . "graficos") {
            $GLOBALS["graficos"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'graficos');
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
                        $result["view"] = SameString($pageName, "GraficosView"); // If View page, no primary button
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
            $key .= @$ar['idgraficos'];
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
            $this->idgraficos->Visible = false;
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
        $this->setupLookupOptions($this->competencia_idcompetencia);
        $this->setupLookupOptions($this->indicadores_idindicadores);

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
            if (($keyValue = Get("idgraficos") ?? Route("idgraficos")) !== null) {
                $this->idgraficos->setQueryStringValue($keyValue);
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
                    $this->terminate("GraficosList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "GraficosList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "GraficosView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "GraficosList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "GraficosList"; // Return list page content
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
        $this->valor->DefaultValue = $this->valor->getDefault(); // PHP
        $this->valor->OldValue = $this->valor->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'competencia_idcompetencia' first before field var 'x_competencia_idcompetencia'
        $val = $CurrentForm->hasValue("competencia_idcompetencia") ? $CurrentForm->getValue("competencia_idcompetencia") : $CurrentForm->getValue("x_competencia_idcompetencia");
        if (!$this->competencia_idcompetencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->competencia_idcompetencia->Visible = false; // Disable update for API request
            } else {
                $this->competencia_idcompetencia->setFormValue($val);
            }
        }

        // Check field name 'indicadores_idindicadores' first before field var 'x_indicadores_idindicadores'
        $val = $CurrentForm->hasValue("indicadores_idindicadores") ? $CurrentForm->getValue("indicadores_idindicadores") : $CurrentForm->getValue("x_indicadores_idindicadores");
        if (!$this->indicadores_idindicadores->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->indicadores_idindicadores->Visible = false; // Disable update for API request
            } else {
                $this->indicadores_idindicadores->setFormValue($val);
            }
        }

        // Check field name 'valor' first before field var 'x_valor'
        $val = $CurrentForm->hasValue("valor") ? $CurrentForm->getValue("valor") : $CurrentForm->getValue("x_valor");
        if (!$this->valor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->valor->Visible = false; // Disable update for API request
            } else {
                $this->valor->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'obs' first before field var 'x_obs'
        $val = $CurrentForm->hasValue("obs") ? $CurrentForm->getValue("obs") : $CurrentForm->getValue("x_obs");
        if (!$this->obs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->obs->Visible = false; // Disable update for API request
            } else {
                $this->obs->setFormValue($val);
            }
        }

        // Check field name 'idgraficos' first before field var 'x_idgraficos'
        $val = $CurrentForm->hasValue("idgraficos") ? $CurrentForm->getValue("idgraficos") : $CurrentForm->getValue("x_idgraficos");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->competencia_idcompetencia->CurrentValue = $this->competencia_idcompetencia->FormValue;
        $this->indicadores_idindicadores->CurrentValue = $this->indicadores_idindicadores->FormValue;
        $this->valor->CurrentValue = $this->valor->FormValue;
        $this->obs->CurrentValue = $this->obs->FormValue;
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
        $this->idgraficos->setDbValue($row['idgraficos']);
        $this->competencia_idcompetencia->setDbValue($row['competencia_idcompetencia']);
        $this->indicadores_idindicadores->setDbValue($row['indicadores_idindicadores']);
        $this->data_base->setDbValue($row['data_base']);
        $this->valor->setDbValue($row['valor']);
        $this->obs->setDbValue($row['obs']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idgraficos'] = $this->idgraficos->DefaultValue;
        $row['competencia_idcompetencia'] = $this->competencia_idcompetencia->DefaultValue;
        $row['indicadores_idindicadores'] = $this->indicadores_idindicadores->DefaultValue;
        $row['data_base'] = $this->data_base->DefaultValue;
        $row['valor'] = $this->valor->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
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

        // idgraficos
        $this->idgraficos->RowCssClass = "row";

        // competencia_idcompetencia
        $this->competencia_idcompetencia->RowCssClass = "row";

        // indicadores_idindicadores
        $this->indicadores_idindicadores->RowCssClass = "row";

        // data_base
        $this->data_base->RowCssClass = "row";

        // valor
        $this->valor->RowCssClass = "row";

        // obs
        $this->obs->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idgraficos
            $this->idgraficos->ViewValue = $this->idgraficos->CurrentValue;

            // competencia_idcompetencia
            $curVal = strval($this->competencia_idcompetencia->CurrentValue);
            if ($curVal != "") {
                $this->competencia_idcompetencia->ViewValue = $this->competencia_idcompetencia->lookupCacheOption($curVal);
                if ($this->competencia_idcompetencia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->competencia_idcompetencia->Lookup->getTable()->Fields["idcompetencia"]->searchExpression(), "=", $curVal, $this->competencia_idcompetencia->Lookup->getTable()->Fields["idcompetencia"]->searchDataType(), "");
                    $sqlWrk = $this->competencia_idcompetencia->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->competencia_idcompetencia->Lookup->renderViewRow($rswrk[0]);
                        $this->competencia_idcompetencia->ViewValue = $this->competencia_idcompetencia->displayValue($arwrk);
                    } else {
                        $this->competencia_idcompetencia->ViewValue = FormatNumber($this->competencia_idcompetencia->CurrentValue, $this->competencia_idcompetencia->formatPattern());
                    }
                }
            } else {
                $this->competencia_idcompetencia->ViewValue = null;
            }
            $this->competencia_idcompetencia->CssClass = "fw-bold";

            // indicadores_idindicadores
            $curVal = strval($this->indicadores_idindicadores->CurrentValue);
            if ($curVal != "") {
                $this->indicadores_idindicadores->ViewValue = $this->indicadores_idindicadores->lookupCacheOption($curVal);
                if ($this->indicadores_idindicadores->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->indicadores_idindicadores->Lookup->getTable()->Fields["idindicadores"]->searchExpression(), "=", $curVal, $this->indicadores_idindicadores->Lookup->getTable()->Fields["idindicadores"]->searchDataType(), "");
                    $sqlWrk = $this->indicadores_idindicadores->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->indicadores_idindicadores->Lookup->renderViewRow($rswrk[0]);
                        $this->indicadores_idindicadores->ViewValue = $this->indicadores_idindicadores->displayValue($arwrk);
                    } else {
                        $this->indicadores_idindicadores->ViewValue = FormatNumber($this->indicadores_idindicadores->CurrentValue, $this->indicadores_idindicadores->formatPattern());
                    }
                }
            } else {
                $this->indicadores_idindicadores->ViewValue = null;
            }
            $this->indicadores_idindicadores->CssClass = "fw-bold";
            $this->indicadores_idindicadores->CellCssStyle .= "text-align: center;";

            // data_base
            $this->data_base->ViewValue = $this->data_base->CurrentValue;
            $this->data_base->ViewValue = FormatDateTime($this->data_base->ViewValue, $this->data_base->formatPattern());
            $this->data_base->CssClass = "fw-bold";

            // valor
            $this->valor->ViewValue = $this->valor->CurrentValue;
            $this->valor->ViewValue = FormatNumber($this->valor->ViewValue, $this->valor->formatPattern());
            $this->valor->CssClass = "fw-bold";
            $this->valor->CellCssStyle .= "text-align: right;";

            // obs
            $this->obs->ViewValue = $this->obs->CurrentValue;
            $this->obs->CssClass = "fw-bold";

            // competencia_idcompetencia
            $this->competencia_idcompetencia->HrefValue = "";

            // indicadores_idindicadores
            $this->indicadores_idindicadores->HrefValue = "";

            // valor
            $this->valor->HrefValue = "";

            // obs
            $this->obs->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // competencia_idcompetencia
            $this->competencia_idcompetencia->setupEditAttributes();
            $curVal = trim(strval($this->competencia_idcompetencia->CurrentValue));
            if ($curVal != "") {
                $this->competencia_idcompetencia->ViewValue = $this->competencia_idcompetencia->lookupCacheOption($curVal);
            } else {
                $this->competencia_idcompetencia->ViewValue = $this->competencia_idcompetencia->Lookup !== null && is_array($this->competencia_idcompetencia->lookupOptions()) && count($this->competencia_idcompetencia->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->competencia_idcompetencia->ViewValue !== null) { // Load from cache
                $this->competencia_idcompetencia->EditValue = array_values($this->competencia_idcompetencia->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->competencia_idcompetencia->Lookup->getTable()->Fields["idcompetencia"]->searchExpression(), "=", $this->competencia_idcompetencia->CurrentValue, $this->competencia_idcompetencia->Lookup->getTable()->Fields["idcompetencia"]->searchDataType(), "");
                }
                $sqlWrk = $this->competencia_idcompetencia->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->competencia_idcompetencia->Lookup->renderViewRow($row);
                }
                $this->competencia_idcompetencia->EditValue = $arwrk;
            }
            $this->competencia_idcompetencia->PlaceHolder = RemoveHtml($this->competencia_idcompetencia->caption());

            // indicadores_idindicadores
            $this->indicadores_idindicadores->setupEditAttributes();
            if ($this->indicadores_idindicadores->getSessionValue() != "") {
                $this->indicadores_idindicadores->CurrentValue = GetForeignKeyValue($this->indicadores_idindicadores->getSessionValue());
                $curVal = strval($this->indicadores_idindicadores->CurrentValue);
                if ($curVal != "") {
                    $this->indicadores_idindicadores->ViewValue = $this->indicadores_idindicadores->lookupCacheOption($curVal);
                    if ($this->indicadores_idindicadores->ViewValue === null) { // Lookup from database
                        $filterWrk = SearchFilter($this->indicadores_idindicadores->Lookup->getTable()->Fields["idindicadores"]->searchExpression(), "=", $curVal, $this->indicadores_idindicadores->Lookup->getTable()->Fields["idindicadores"]->searchDataType(), "");
                        $sqlWrk = $this->indicadores_idindicadores->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCache($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->indicadores_idindicadores->Lookup->renderViewRow($rswrk[0]);
                            $this->indicadores_idindicadores->ViewValue = $this->indicadores_idindicadores->displayValue($arwrk);
                        } else {
                            $this->indicadores_idindicadores->ViewValue = FormatNumber($this->indicadores_idindicadores->CurrentValue, $this->indicadores_idindicadores->formatPattern());
                        }
                    }
                } else {
                    $this->indicadores_idindicadores->ViewValue = null;
                }
                $this->indicadores_idindicadores->CssClass = "fw-bold";
                $this->indicadores_idindicadores->CellCssStyle .= "text-align: center;";
            } else {
                $curVal = trim(strval($this->indicadores_idindicadores->CurrentValue));
                if ($curVal != "") {
                    $this->indicadores_idindicadores->ViewValue = $this->indicadores_idindicadores->lookupCacheOption($curVal);
                } else {
                    $this->indicadores_idindicadores->ViewValue = $this->indicadores_idindicadores->Lookup !== null && is_array($this->indicadores_idindicadores->lookupOptions()) && count($this->indicadores_idindicadores->lookupOptions()) > 0 ? $curVal : null;
                }
                if ($this->indicadores_idindicadores->ViewValue !== null) { // Load from cache
                    $this->indicadores_idindicadores->EditValue = array_values($this->indicadores_idindicadores->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = SearchFilter($this->indicadores_idindicadores->Lookup->getTable()->Fields["idindicadores"]->searchExpression(), "=", $this->indicadores_idindicadores->CurrentValue, $this->indicadores_idindicadores->Lookup->getTable()->Fields["idindicadores"]->searchDataType(), "");
                    }
                    $sqlWrk = $this->indicadores_idindicadores->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->indicadores_idindicadores->EditValue = $arwrk;
                }
                $this->indicadores_idindicadores->PlaceHolder = RemoveHtml($this->indicadores_idindicadores->caption());
            }

            // valor
            $this->valor->setupEditAttributes();
            $this->valor->EditValue = $this->valor->CurrentValue;
            $this->valor->PlaceHolder = RemoveHtml($this->valor->caption());
            if (strval($this->valor->EditValue) != "" && is_numeric($this->valor->EditValue)) {
                $this->valor->EditValue = FormatNumber($this->valor->EditValue, null);
            }

            // obs
            $this->obs->setupEditAttributes();
            if (!$this->obs->Raw) {
                $this->obs->CurrentValue = HtmlDecode($this->obs->CurrentValue);
            }
            $this->obs->EditValue = HtmlEncode($this->obs->CurrentValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // Add refer script

            // competencia_idcompetencia
            $this->competencia_idcompetencia->HrefValue = "";

            // indicadores_idindicadores
            $this->indicadores_idindicadores->HrefValue = "";

            // valor
            $this->valor->HrefValue = "";

            // obs
            $this->obs->HrefValue = "";
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
            if ($this->competencia_idcompetencia->Visible && $this->competencia_idcompetencia->Required) {
                if (!$this->competencia_idcompetencia->IsDetailKey && EmptyValue($this->competencia_idcompetencia->FormValue)) {
                    $this->competencia_idcompetencia->addErrorMessage(str_replace("%s", $this->competencia_idcompetencia->caption(), $this->competencia_idcompetencia->RequiredErrorMessage));
                }
            }
            if ($this->indicadores_idindicadores->Visible && $this->indicadores_idindicadores->Required) {
                if (!$this->indicadores_idindicadores->IsDetailKey && EmptyValue($this->indicadores_idindicadores->FormValue)) {
                    $this->indicadores_idindicadores->addErrorMessage(str_replace("%s", $this->indicadores_idindicadores->caption(), $this->indicadores_idindicadores->RequiredErrorMessage));
                }
            }
            if ($this->valor->Visible && $this->valor->Required) {
                if (!$this->valor->IsDetailKey && EmptyValue($this->valor->FormValue)) {
                    $this->valor->addErrorMessage(str_replace("%s", $this->valor->caption(), $this->valor->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->valor->FormValue)) {
                $this->valor->addErrorMessage($this->valor->getErrorMessage(false));
            }
            if ($this->obs->Visible && $this->obs->Required) {
                if (!$this->obs->IsDetailKey && EmptyValue($this->obs->FormValue)) {
                    $this->obs->addErrorMessage(str_replace("%s", $this->obs->caption(), $this->obs->RequiredErrorMessage));
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

        // Check referential integrity for master table 'graficos'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["indicadores_idindicadores"] = $this->indicadores_idindicadores->CurrentValue;
        $masterTable = Container("indicadores");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "indicadores", $Language->phrase("RelatedRecordRequired"));
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

        // competencia_idcompetencia
        $this->competencia_idcompetencia->setDbValueDef($rsnew, $this->competencia_idcompetencia->CurrentValue, false);

        // indicadores_idindicadores
        $this->indicadores_idindicadores->setDbValueDef($rsnew, $this->indicadores_idindicadores->CurrentValue, false);

        // valor
        $this->valor->setDbValueDef($rsnew, $this->valor->CurrentValue, strval($this->valor->CurrentValue) == "");

        // obs
        $this->obs->setDbValueDef($rsnew, $this->obs->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['competencia_idcompetencia'])) { // competencia_idcompetencia
            $this->competencia_idcompetencia->setFormValue($row['competencia_idcompetencia']);
        }
        if (isset($row['indicadores_idindicadores'])) { // indicadores_idindicadores
            $this->indicadores_idindicadores->setFormValue($row['indicadores_idindicadores']);
        }
        if (isset($row['valor'])) { // valor
            $this->valor->setFormValue($row['valor']);
        }
        if (isset($row['obs'])) { // obs
            $this->obs->setFormValue($row['obs']);
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
            if ($masterTblVar == "indicadores") {
                $validMaster = true;
                $masterTbl = Container("indicadores");
                if (($parm = Get("fk_idindicadores", Get("indicadores_idindicadores"))) !== null) {
                    $masterTbl->idindicadores->setQueryStringValue($parm);
                    $this->indicadores_idindicadores->QueryStringValue = $masterTbl->idindicadores->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->indicadores_idindicadores->setSessionValue($this->indicadores_idindicadores->QueryStringValue);
                    $foreignKeys["indicadores_idindicadores"] = $this->indicadores_idindicadores->QueryStringValue;
                    if (!is_numeric($masterTbl->idindicadores->QueryStringValue)) {
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
            if ($masterTblVar == "indicadores") {
                $validMaster = true;
                $masterTbl = Container("indicadores");
                if (($parm = Post("fk_idindicadores", Post("indicadores_idindicadores"))) !== null) {
                    $masterTbl->idindicadores->setFormValue($parm);
                    $this->indicadores_idindicadores->FormValue = $masterTbl->idindicadores->FormValue;
                    $this->indicadores_idindicadores->setSessionValue($this->indicadores_idindicadores->FormValue);
                    $foreignKeys["indicadores_idindicadores"] = $this->indicadores_idindicadores->FormValue;
                    if (!is_numeric($masterTbl->idindicadores->FormValue)) {
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
            if ($masterTblVar != "indicadores") {
                if (!array_key_exists("indicadores_idindicadores", $foreignKeys)) { // Not current foreign key
                    $this->indicadores_idindicadores->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("GraficosList"), "", $this->TableVar, true);
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
                case "x_competencia_idcompetencia":
                    break;
                case "x_indicadores_idindicadores":
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
