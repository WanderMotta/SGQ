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
class AnaliseSwotAdd extends AnaliseSwot
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "AnaliseSwotAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "AnaliseSwotAdd";

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
        $this->idanalise_swot->Visible = false;
        $this->dt_cadastro->setVisibility();
        $this->fatores->setVisibility();
        $this->ponto->setVisibility();
        $this->analise->setVisibility();
        $this->impacto_idimpacto->setVisibility();
        $this->contexto_idcontexto->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'analise_swot';
        $this->TableName = 'analise_swot';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (analise_swot)
        if (!isset($GLOBALS["analise_swot"]) || $GLOBALS["analise_swot"]::class == PROJECT_NAMESPACE . "analise_swot") {
            $GLOBALS["analise_swot"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'analise_swot');
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
                        $result["view"] = SameString($pageName, "AnaliseSwotView"); // If View page, no primary button
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
            $key .= @$ar['idanalise_swot'];
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
            $this->idanalise_swot->Visible = false;
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
        $this->setupLookupOptions($this->fatores);
        $this->setupLookupOptions($this->ponto);
        $this->setupLookupOptions($this->impacto_idimpacto);

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
            if (($keyValue = Get("idanalise_swot") ?? Route("idanalise_swot")) !== null) {
                $this->idanalise_swot->setQueryStringValue($keyValue);
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
                    $this->terminate("AnaliseSwotList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "AnaliseSwotList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "AnaliseSwotView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "AnaliseSwotList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "AnaliseSwotList"; // Return list page content
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

        // Check field name 'fatores' first before field var 'x_fatores'
        $val = $CurrentForm->hasValue("fatores") ? $CurrentForm->getValue("fatores") : $CurrentForm->getValue("x_fatores");
        if (!$this->fatores->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fatores->Visible = false; // Disable update for API request
            } else {
                $this->fatores->setFormValue($val);
            }
        }

        // Check field name 'ponto' first before field var 'x_ponto'
        $val = $CurrentForm->hasValue("ponto") ? $CurrentForm->getValue("ponto") : $CurrentForm->getValue("x_ponto");
        if (!$this->ponto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ponto->Visible = false; // Disable update for API request
            } else {
                $this->ponto->setFormValue($val);
            }
        }

        // Check field name 'analise' first before field var 'x_analise'
        $val = $CurrentForm->hasValue("analise") ? $CurrentForm->getValue("analise") : $CurrentForm->getValue("x_analise");
        if (!$this->analise->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->analise->Visible = false; // Disable update for API request
            } else {
                $this->analise->setFormValue($val);
            }
        }

        // Check field name 'impacto_idimpacto' first before field var 'x_impacto_idimpacto'
        $val = $CurrentForm->hasValue("impacto_idimpacto") ? $CurrentForm->getValue("impacto_idimpacto") : $CurrentForm->getValue("x_impacto_idimpacto");
        if (!$this->impacto_idimpacto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->impacto_idimpacto->Visible = false; // Disable update for API request
            } else {
                $this->impacto_idimpacto->setFormValue($val);
            }
        }

        // Check field name 'contexto_idcontexto' first before field var 'x_contexto_idcontexto'
        $val = $CurrentForm->hasValue("contexto_idcontexto") ? $CurrentForm->getValue("contexto_idcontexto") : $CurrentForm->getValue("x_contexto_idcontexto");
        if (!$this->contexto_idcontexto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contexto_idcontexto->Visible = false; // Disable update for API request
            } else {
                $this->contexto_idcontexto->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'idanalise_swot' first before field var 'x_idanalise_swot'
        $val = $CurrentForm->hasValue("idanalise_swot") ? $CurrentForm->getValue("idanalise_swot") : $CurrentForm->getValue("x_idanalise_swot");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->fatores->CurrentValue = $this->fatores->FormValue;
        $this->ponto->CurrentValue = $this->ponto->FormValue;
        $this->analise->CurrentValue = $this->analise->FormValue;
        $this->impacto_idimpacto->CurrentValue = $this->impacto_idimpacto->FormValue;
        $this->contexto_idcontexto->CurrentValue = $this->contexto_idcontexto->FormValue;
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
        $this->idanalise_swot->setDbValue($row['idanalise_swot']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->fatores->setDbValue($row['fatores']);
        $this->ponto->setDbValue($row['ponto']);
        $this->analise->setDbValue($row['analise']);
        $this->impacto_idimpacto->setDbValue($row['impacto_idimpacto']);
        $this->contexto_idcontexto->setDbValue($row['contexto_idcontexto']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idanalise_swot'] = $this->idanalise_swot->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['fatores'] = $this->fatores->DefaultValue;
        $row['ponto'] = $this->ponto->DefaultValue;
        $row['analise'] = $this->analise->DefaultValue;
        $row['impacto_idimpacto'] = $this->impacto_idimpacto->DefaultValue;
        $row['contexto_idcontexto'] = $this->contexto_idcontexto->DefaultValue;
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

        // idanalise_swot
        $this->idanalise_swot->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // fatores
        $this->fatores->RowCssClass = "row";

        // ponto
        $this->ponto->RowCssClass = "row";

        // analise
        $this->analise->RowCssClass = "row";

        // impacto_idimpacto
        $this->impacto_idimpacto->RowCssClass = "row";

        // contexto_idcontexto
        $this->contexto_idcontexto->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idanalise_swot
            $this->idanalise_swot->ViewValue = $this->idanalise_swot->CurrentValue;

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // fatores
            if (strval($this->fatores->CurrentValue) != "") {
                $this->fatores->ViewValue = $this->fatores->optionCaption($this->fatores->CurrentValue);
            } else {
                $this->fatores->ViewValue = null;
            }
            $this->fatores->CssClass = "fw-bold";

            // ponto
            if (strval($this->ponto->CurrentValue) != "") {
                $this->ponto->ViewValue = $this->ponto->optionCaption($this->ponto->CurrentValue);
            } else {
                $this->ponto->ViewValue = null;
            }
            $this->ponto->CssClass = "fw-bold";

            // analise
            $this->analise->ViewValue = $this->analise->CurrentValue;
            $this->analise->CssClass = "fw-bold";

            // impacto_idimpacto
            $curVal = strval($this->impacto_idimpacto->CurrentValue);
            if ($curVal != "") {
                $this->impacto_idimpacto->ViewValue = $this->impacto_idimpacto->lookupCacheOption($curVal);
                if ($this->impacto_idimpacto->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchExpression(), "=", $curVal, $this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchDataType(), "");
                    $lookupFilter = $this->impacto_idimpacto->getSelectFilter($this); // PHP
                    $sqlWrk = $this->impacto_idimpacto->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->impacto_idimpacto->Lookup->renderViewRow($rswrk[0]);
                        $this->impacto_idimpacto->ViewValue = $this->impacto_idimpacto->displayValue($arwrk);
                    } else {
                        $this->impacto_idimpacto->ViewValue = FormatNumber($this->impacto_idimpacto->CurrentValue, $this->impacto_idimpacto->formatPattern());
                    }
                }
            } else {
                $this->impacto_idimpacto->ViewValue = null;
            }
            $this->impacto_idimpacto->CssClass = "fw-bold";

            // contexto_idcontexto
            $this->contexto_idcontexto->ViewValue = $this->contexto_idcontexto->CurrentValue;
            $this->contexto_idcontexto->ViewValue = FormatNumber($this->contexto_idcontexto->ViewValue, $this->contexto_idcontexto->formatPattern());
            $this->contexto_idcontexto->CssClass = "fw-bold";
            $this->contexto_idcontexto->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // fatores
            $this->fatores->HrefValue = "";

            // ponto
            $this->ponto->HrefValue = "";

            // analise
            $this->analise->HrefValue = "";

            // impacto_idimpacto
            $this->impacto_idimpacto->HrefValue = "";

            // contexto_idcontexto
            $this->contexto_idcontexto->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // dt_cadastro

            // fatores
            $this->fatores->EditValue = $this->fatores->options(false);
            $this->fatores->PlaceHolder = RemoveHtml($this->fatores->caption());

            // ponto
            $this->ponto->EditValue = $this->ponto->options(false);
            $this->ponto->PlaceHolder = RemoveHtml($this->ponto->caption());

            // analise
            $this->analise->setupEditAttributes();
            $this->analise->EditValue = HtmlEncode($this->analise->CurrentValue);
            $this->analise->PlaceHolder = RemoveHtml($this->analise->caption());

            // impacto_idimpacto
            $curVal = trim(strval($this->impacto_idimpacto->CurrentValue));
            if ($curVal != "") {
                $this->impacto_idimpacto->ViewValue = $this->impacto_idimpacto->lookupCacheOption($curVal);
            } else {
                $this->impacto_idimpacto->ViewValue = $this->impacto_idimpacto->Lookup !== null && is_array($this->impacto_idimpacto->lookupOptions()) && count($this->impacto_idimpacto->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->impacto_idimpacto->ViewValue !== null) { // Load from cache
                $this->impacto_idimpacto->EditValue = array_values($this->impacto_idimpacto->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchExpression(), "=", $this->impacto_idimpacto->CurrentValue, $this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchDataType(), "");
                }
                $lookupFilter = $this->impacto_idimpacto->getSelectFilter($this); // PHP
                $sqlWrk = $this->impacto_idimpacto->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->impacto_idimpacto->Lookup->renderViewRow($row);
                }
                $this->impacto_idimpacto->EditValue = $arwrk;
            }
            $this->impacto_idimpacto->PlaceHolder = RemoveHtml($this->impacto_idimpacto->caption());

            // contexto_idcontexto
            $this->contexto_idcontexto->setupEditAttributes();
            if ($this->contexto_idcontexto->getSessionValue() != "") {
                $this->contexto_idcontexto->CurrentValue = GetForeignKeyValue($this->contexto_idcontexto->getSessionValue());
                $this->contexto_idcontexto->ViewValue = $this->contexto_idcontexto->CurrentValue;
                $this->contexto_idcontexto->ViewValue = FormatNumber($this->contexto_idcontexto->ViewValue, $this->contexto_idcontexto->formatPattern());
                $this->contexto_idcontexto->CssClass = "fw-bold";
                $this->contexto_idcontexto->CellCssStyle .= "text-align: center;";
            } else {
                $this->contexto_idcontexto->EditValue = $this->contexto_idcontexto->CurrentValue;
                $this->contexto_idcontexto->PlaceHolder = RemoveHtml($this->contexto_idcontexto->caption());
                if (strval($this->contexto_idcontexto->EditValue) != "" && is_numeric($this->contexto_idcontexto->EditValue)) {
                    $this->contexto_idcontexto->EditValue = FormatNumber($this->contexto_idcontexto->EditValue, null);
                }
            }

            // Add refer script

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // fatores
            $this->fatores->HrefValue = "";

            // ponto
            $this->ponto->HrefValue = "";

            // analise
            $this->analise->HrefValue = "";

            // impacto_idimpacto
            $this->impacto_idimpacto->HrefValue = "";

            // contexto_idcontexto
            $this->contexto_idcontexto->HrefValue = "";
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
            if ($this->fatores->Visible && $this->fatores->Required) {
                if ($this->fatores->FormValue == "") {
                    $this->fatores->addErrorMessage(str_replace("%s", $this->fatores->caption(), $this->fatores->RequiredErrorMessage));
                }
            }
            if ($this->ponto->Visible && $this->ponto->Required) {
                if ($this->ponto->FormValue == "") {
                    $this->ponto->addErrorMessage(str_replace("%s", $this->ponto->caption(), $this->ponto->RequiredErrorMessage));
                }
            }
            if ($this->analise->Visible && $this->analise->Required) {
                if (!$this->analise->IsDetailKey && EmptyValue($this->analise->FormValue)) {
                    $this->analise->addErrorMessage(str_replace("%s", $this->analise->caption(), $this->analise->RequiredErrorMessage));
                }
            }
            if ($this->impacto_idimpacto->Visible && $this->impacto_idimpacto->Required) {
                if ($this->impacto_idimpacto->FormValue == "") {
                    $this->impacto_idimpacto->addErrorMessage(str_replace("%s", $this->impacto_idimpacto->caption(), $this->impacto_idimpacto->RequiredErrorMessage));
                }
            }
            if ($this->contexto_idcontexto->Visible && $this->contexto_idcontexto->Required) {
                if (!$this->contexto_idcontexto->IsDetailKey && EmptyValue($this->contexto_idcontexto->FormValue)) {
                    $this->contexto_idcontexto->addErrorMessage(str_replace("%s", $this->contexto_idcontexto->caption(), $this->contexto_idcontexto->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->contexto_idcontexto->FormValue)) {
                $this->contexto_idcontexto->addErrorMessage($this->contexto_idcontexto->getErrorMessage(false));
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

        // Check referential integrity for master table 'analise_swot'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["contexto_idcontexto"] = $this->contexto_idcontexto->CurrentValue;
        $masterTable = Container("contexto");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "contexto", $Language->phrase("RelatedRecordRequired"));
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

        // fatores
        $this->fatores->setDbValueDef($rsnew, $this->fatores->CurrentValue, false);

        // ponto
        $this->ponto->setDbValueDef($rsnew, $this->ponto->CurrentValue, false);

        // analise
        $this->analise->setDbValueDef($rsnew, $this->analise->CurrentValue, false);

        // impacto_idimpacto
        $this->impacto_idimpacto->setDbValueDef($rsnew, $this->impacto_idimpacto->CurrentValue, false);

        // contexto_idcontexto
        $this->contexto_idcontexto->setDbValueDef($rsnew, $this->contexto_idcontexto->CurrentValue, false);
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
        if (isset($row['fatores'])) { // fatores
            $this->fatores->setFormValue($row['fatores']);
        }
        if (isset($row['ponto'])) { // ponto
            $this->ponto->setFormValue($row['ponto']);
        }
        if (isset($row['analise'])) { // analise
            $this->analise->setFormValue($row['analise']);
        }
        if (isset($row['impacto_idimpacto'])) { // impacto_idimpacto
            $this->impacto_idimpacto->setFormValue($row['impacto_idimpacto']);
        }
        if (isset($row['contexto_idcontexto'])) { // contexto_idcontexto
            $this->contexto_idcontexto->setFormValue($row['contexto_idcontexto']);
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
            if ($masterTblVar == "contexto") {
                $validMaster = true;
                $masterTbl = Container("contexto");
                if (($parm = Get("fk_idcontexto", Get("contexto_idcontexto"))) !== null) {
                    $masterTbl->idcontexto->setQueryStringValue($parm);
                    $this->contexto_idcontexto->QueryStringValue = $masterTbl->idcontexto->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->contexto_idcontexto->setSessionValue($this->contexto_idcontexto->QueryStringValue);
                    $foreignKeys["contexto_idcontexto"] = $this->contexto_idcontexto->QueryStringValue;
                    if (!is_numeric($masterTbl->idcontexto->QueryStringValue)) {
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
            if ($masterTblVar == "contexto") {
                $validMaster = true;
                $masterTbl = Container("contexto");
                if (($parm = Post("fk_idcontexto", Post("contexto_idcontexto"))) !== null) {
                    $masterTbl->idcontexto->setFormValue($parm);
                    $this->contexto_idcontexto->FormValue = $masterTbl->idcontexto->FormValue;
                    $this->contexto_idcontexto->setSessionValue($this->contexto_idcontexto->FormValue);
                    $foreignKeys["contexto_idcontexto"] = $this->contexto_idcontexto->FormValue;
                    if (!is_numeric($masterTbl->idcontexto->FormValue)) {
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
            if ($masterTblVar != "contexto") {
                if (!array_key_exists("contexto_idcontexto", $foreignKeys)) { // Not current foreign key
                    $this->contexto_idcontexto->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("AnaliseSwotList"), "", $this->TableVar, true);
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
                case "x_fatores":
                    break;
                case "x_ponto":
                    break;
                case "x_impacto_idimpacto":
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
