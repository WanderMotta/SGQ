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
class IndicadoresEdit extends Indicadores
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "IndicadoresEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "IndicadoresEdit";

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
        $this->idindicadores->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->indicador->setVisibility();
        $this->periodicidade_idperiodicidade->setVisibility();
        $this->unidade_medida_idunidade_medida->setVisibility();
        $this->meta->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'indicadores';
        $this->TableName = 'indicadores';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (indicadores)
        if (!isset($GLOBALS["indicadores"]) || $GLOBALS["indicadores"]::class == PROJECT_NAMESPACE . "indicadores") {
            $GLOBALS["indicadores"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'indicadores');
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
                        $result["view"] = SameString($pageName, "IndicadoresView"); // If View page, no primary button
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
            $key .= @$ar['idindicadores'];
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
            $this->idindicadores->Visible = false;
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form overlay-wrapper";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->setupLookupOptions($this->periodicidade_idperiodicidade);
        $this->setupLookupOptions($this->unidade_medida_idunidade_medida);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("idindicadores") ?? Key(0) ?? Route(2)) !== null) {
                $this->idindicadores->setQueryStringValue($keyValue);
                $this->idindicadores->setOldValue($this->idindicadores->QueryStringValue);
            } elseif (Post("idindicadores") !== null) {
                $this->idindicadores->setFormValue(Post("idindicadores"));
                $this->idindicadores->setOldValue($this->idindicadores->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action", "") !== "") {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("idindicadores") ?? Route("idindicadores")) !== null) {
                    $this->idindicadores->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idindicadores->CurrentValue = null;
                }
            }

            // Load result set
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Set up detail parameters
            $this->setupDetailParms();
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("IndicadoresList"); // No matching record, return to list
                        return;
                    }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "IndicadoresList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "IndicadoresList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "IndicadoresList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
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
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = RowType::EDIT; // Render as Edit
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'idindicadores' first before field var 'x_idindicadores'
        $val = $CurrentForm->hasValue("idindicadores") ? $CurrentForm->getValue("idindicadores") : $CurrentForm->getValue("x_idindicadores");
        if (!$this->idindicadores->IsDetailKey) {
            $this->idindicadores->setFormValue($val);
        }

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

        // Check field name 'indicador' first before field var 'x_indicador'
        $val = $CurrentForm->hasValue("indicador") ? $CurrentForm->getValue("indicador") : $CurrentForm->getValue("x_indicador");
        if (!$this->indicador->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->indicador->Visible = false; // Disable update for API request
            } else {
                $this->indicador->setFormValue($val);
            }
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

        // Check field name 'unidade_medida_idunidade_medida' first before field var 'x_unidade_medida_idunidade_medida'
        $val = $CurrentForm->hasValue("unidade_medida_idunidade_medida") ? $CurrentForm->getValue("unidade_medida_idunidade_medida") : $CurrentForm->getValue("x_unidade_medida_idunidade_medida");
        if (!$this->unidade_medida_idunidade_medida->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->unidade_medida_idunidade_medida->Visible = false; // Disable update for API request
            } else {
                $this->unidade_medida_idunidade_medida->setFormValue($val);
            }
        }

        // Check field name 'meta' first before field var 'x_meta'
        $val = $CurrentForm->hasValue("meta") ? $CurrentForm->getValue("meta") : $CurrentForm->getValue("x_meta");
        if (!$this->meta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->meta->Visible = false; // Disable update for API request
            } else {
                $this->meta->setFormValue($val, true, $validate);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idindicadores->CurrentValue = $this->idindicadores->FormValue;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->indicador->CurrentValue = $this->indicador->FormValue;
        $this->periodicidade_idperiodicidade->CurrentValue = $this->periodicidade_idperiodicidade->FormValue;
        $this->unidade_medida_idunidade_medida->CurrentValue = $this->unidade_medida_idunidade_medida->FormValue;
        $this->meta->CurrentValue = $this->meta->FormValue;
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
        $this->idindicadores->setDbValue($row['idindicadores']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->indicador->setDbValue($row['indicador']);
        $this->periodicidade_idperiodicidade->setDbValue($row['periodicidade_idperiodicidade']);
        $this->unidade_medida_idunidade_medida->setDbValue($row['unidade_medida_idunidade_medida']);
        $this->meta->setDbValue($row['meta']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idindicadores'] = $this->idindicadores->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['indicador'] = $this->indicador->DefaultValue;
        $row['periodicidade_idperiodicidade'] = $this->periodicidade_idperiodicidade->DefaultValue;
        $row['unidade_medida_idunidade_medida'] = $this->unidade_medida_idunidade_medida->DefaultValue;
        $row['meta'] = $this->meta->DefaultValue;
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

        // idindicadores
        $this->idindicadores->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // indicador
        $this->indicador->RowCssClass = "row";

        // periodicidade_idperiodicidade
        $this->periodicidade_idperiodicidade->RowCssClass = "row";

        // unidade_medida_idunidade_medida
        $this->unidade_medida_idunidade_medida->RowCssClass = "row";

        // meta
        $this->meta->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idindicadores
            $this->idindicadores->ViewValue = $this->idindicadores->CurrentValue;
            $this->idindicadores->CssClass = "fw-bold";
            $this->idindicadores->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // indicador
            $this->indicador->ViewValue = $this->indicador->CurrentValue;
            $this->indicador->CssClass = "fw-bold";

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

            // unidade_medida_idunidade_medida
            $curVal = strval($this->unidade_medida_idunidade_medida->CurrentValue);
            if ($curVal != "") {
                $this->unidade_medida_idunidade_medida->ViewValue = $this->unidade_medida_idunidade_medida->lookupCacheOption($curVal);
                if ($this->unidade_medida_idunidade_medida->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->unidade_medida_idunidade_medida->Lookup->getTable()->Fields["idunidade_medida"]->searchExpression(), "=", $curVal, $this->unidade_medida_idunidade_medida->Lookup->getTable()->Fields["idunidade_medida"]->searchDataType(), "");
                    $sqlWrk = $this->unidade_medida_idunidade_medida->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->unidade_medida_idunidade_medida->Lookup->renderViewRow($rswrk[0]);
                        $this->unidade_medida_idunidade_medida->ViewValue = $this->unidade_medida_idunidade_medida->displayValue($arwrk);
                    } else {
                        $this->unidade_medida_idunidade_medida->ViewValue = FormatNumber($this->unidade_medida_idunidade_medida->CurrentValue, $this->unidade_medida_idunidade_medida->formatPattern());
                    }
                }
            } else {
                $this->unidade_medida_idunidade_medida->ViewValue = null;
            }
            $this->unidade_medida_idunidade_medida->CssClass = "fw-bold";
            $this->unidade_medida_idunidade_medida->CellCssStyle .= "text-align: left;";

            // meta
            $this->meta->ViewValue = $this->meta->CurrentValue;
            $this->meta->ViewValue = FormatCurrency($this->meta->ViewValue, $this->meta->formatPattern());
            $this->meta->CssClass = "fw-bold";
            $this->meta->CellCssStyle .= "text-align: right;";

            // idindicadores
            $this->idindicadores->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // indicador
            $this->indicador->HrefValue = "";

            // periodicidade_idperiodicidade
            $this->periodicidade_idperiodicidade->HrefValue = "";

            // unidade_medida_idunidade_medida
            $this->unidade_medida_idunidade_medida->HrefValue = "";

            // meta
            $this->meta->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // idindicadores
            $this->idindicadores->setupEditAttributes();
            $this->idindicadores->EditValue = $this->idindicadores->CurrentValue;
            $this->idindicadores->CssClass = "fw-bold";
            $this->idindicadores->CellCssStyle .= "text-align: center;";

            // dt_cadastro

            // indicador
            $this->indicador->setupEditAttributes();
            if (!$this->indicador->Raw) {
                $this->indicador->CurrentValue = HtmlDecode($this->indicador->CurrentValue);
            }
            $this->indicador->EditValue = HtmlEncode($this->indicador->CurrentValue);
            $this->indicador->PlaceHolder = RemoveHtml($this->indicador->caption());

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

            // unidade_medida_idunidade_medida
            $curVal = trim(strval($this->unidade_medida_idunidade_medida->CurrentValue));
            if ($curVal != "") {
                $this->unidade_medida_idunidade_medida->ViewValue = $this->unidade_medida_idunidade_medida->lookupCacheOption($curVal);
            } else {
                $this->unidade_medida_idunidade_medida->ViewValue = $this->unidade_medida_idunidade_medida->Lookup !== null && is_array($this->unidade_medida_idunidade_medida->lookupOptions()) && count($this->unidade_medida_idunidade_medida->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->unidade_medida_idunidade_medida->ViewValue !== null) { // Load from cache
                $this->unidade_medida_idunidade_medida->EditValue = array_values($this->unidade_medida_idunidade_medida->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->unidade_medida_idunidade_medida->Lookup->getTable()->Fields["idunidade_medida"]->searchExpression(), "=", $this->unidade_medida_idunidade_medida->CurrentValue, $this->unidade_medida_idunidade_medida->Lookup->getTable()->Fields["idunidade_medida"]->searchDataType(), "");
                }
                $sqlWrk = $this->unidade_medida_idunidade_medida->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->unidade_medida_idunidade_medida->EditValue = $arwrk;
            }
            $this->unidade_medida_idunidade_medida->PlaceHolder = RemoveHtml($this->unidade_medida_idunidade_medida->caption());

            // meta
            $this->meta->setupEditAttributes();
            $this->meta->EditValue = $this->meta->CurrentValue;
            $this->meta->PlaceHolder = RemoveHtml($this->meta->caption());
            if (strval($this->meta->EditValue) != "" && is_numeric($this->meta->EditValue)) {
                $this->meta->EditValue = FormatNumber($this->meta->EditValue, null);
            }

            // Edit refer script

            // idindicadores
            $this->idindicadores->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // indicador
            $this->indicador->HrefValue = "";

            // periodicidade_idperiodicidade
            $this->periodicidade_idperiodicidade->HrefValue = "";

            // unidade_medida_idunidade_medida
            $this->unidade_medida_idunidade_medida->HrefValue = "";

            // meta
            $this->meta->HrefValue = "";
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
            if ($this->idindicadores->Visible && $this->idindicadores->Required) {
                if (!$this->idindicadores->IsDetailKey && EmptyValue($this->idindicadores->FormValue)) {
                    $this->idindicadores->addErrorMessage(str_replace("%s", $this->idindicadores->caption(), $this->idindicadores->RequiredErrorMessage));
                }
            }
            if ($this->dt_cadastro->Visible && $this->dt_cadastro->Required) {
                if (!$this->dt_cadastro->IsDetailKey && EmptyValue($this->dt_cadastro->FormValue)) {
                    $this->dt_cadastro->addErrorMessage(str_replace("%s", $this->dt_cadastro->caption(), $this->dt_cadastro->RequiredErrorMessage));
                }
            }
            if ($this->indicador->Visible && $this->indicador->Required) {
                if (!$this->indicador->IsDetailKey && EmptyValue($this->indicador->FormValue)) {
                    $this->indicador->addErrorMessage(str_replace("%s", $this->indicador->caption(), $this->indicador->RequiredErrorMessage));
                }
            }
            if ($this->periodicidade_idperiodicidade->Visible && $this->periodicidade_idperiodicidade->Required) {
                if ($this->periodicidade_idperiodicidade->FormValue == "") {
                    $this->periodicidade_idperiodicidade->addErrorMessage(str_replace("%s", $this->periodicidade_idperiodicidade->caption(), $this->periodicidade_idperiodicidade->RequiredErrorMessage));
                }
            }
            if ($this->unidade_medida_idunidade_medida->Visible && $this->unidade_medida_idunidade_medida->Required) {
                if ($this->unidade_medida_idunidade_medida->FormValue == "") {
                    $this->unidade_medida_idunidade_medida->addErrorMessage(str_replace("%s", $this->unidade_medida_idunidade_medida->caption(), $this->unidade_medida_idunidade_medida->RequiredErrorMessage));
                }
            }
            if ($this->meta->Visible && $this->meta->Required) {
                if (!$this->meta->IsDetailKey && EmptyValue($this->meta->FormValue)) {
                    $this->meta->addErrorMessage(str_replace("%s", $this->meta->caption(), $this->meta->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->meta->FormValue)) {
                $this->meta->addErrorMessage($this->meta->getErrorMessage(false));
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("GraficosGrid");
        if (in_array("graficos", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
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

        // Check field with unique index (indicador)
        if ($this->indicador->CurrentValue != "") {
            $filterChk = "(`indicador` = '" . AdjustSql($this->indicador->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->indicador->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->indicador->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
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

            // Update detail records
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("GraficosGrid");
            if (in_array("graficos", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "graficos"); // Load user level of detail table
                $editRow = $detailPage->gridUpdate();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
            }

            // Commit/Rollback transaction
            if ($this->getCurrentDetailTable() != "") {
                if ($editRow) {
                    if ($this->UseTransaction) { // Commit transaction
                        if ($conn->isTransactionActive()) {
                            $conn->commit();
                        }
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        if ($conn->isTransactionActive()) {
                            $conn->rollback();
                        }
                    }
                }
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

        // Write JSON response
        if (IsJsonResponse() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_EDIT_ACTION"), $table => $row]);
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

        // dt_cadastro
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->getAutoUpdateValue(); // PHP
        $this->dt_cadastro->setDbValueDef($rsnew, UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->ReadOnly);

        // indicador
        $this->indicador->setDbValueDef($rsnew, $this->indicador->CurrentValue, $this->indicador->ReadOnly);

        // periodicidade_idperiodicidade
        $this->periodicidade_idperiodicidade->setDbValueDef($rsnew, $this->periodicidade_idperiodicidade->CurrentValue, $this->periodicidade_idperiodicidade->ReadOnly);

        // unidade_medida_idunidade_medida
        $this->unidade_medida_idunidade_medida->setDbValueDef($rsnew, $this->unidade_medida_idunidade_medida->CurrentValue, $this->unidade_medida_idunidade_medida->ReadOnly);

        // meta
        $this->meta->setDbValueDef($rsnew, $this->meta->CurrentValue, $this->meta->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['dt_cadastro'])) { // dt_cadastro
            $this->dt_cadastro->CurrentValue = $row['dt_cadastro'];
        }
        if (isset($row['indicador'])) { // indicador
            $this->indicador->CurrentValue = $row['indicador'];
        }
        if (isset($row['periodicidade_idperiodicidade'])) { // periodicidade_idperiodicidade
            $this->periodicidade_idperiodicidade->CurrentValue = $row['periodicidade_idperiodicidade'];
        }
        if (isset($row['unidade_medida_idunidade_medida'])) { // unidade_medida_idunidade_medida
            $this->unidade_medida_idunidade_medida->CurrentValue = $row['unidade_medida_idunidade_medida'];
        }
        if (isset($row['meta'])) { // meta
            $this->meta->CurrentValue = $row['meta'];
        }
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
            if (in_array("graficos", $detailTblVar)) {
                $detailPageObj = Container("GraficosGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->indicadores_idindicadores->IsDetailKey = true;
                    $detailPageObj->indicadores_idindicadores->CurrentValue = $this->idindicadores->CurrentValue;
                    $detailPageObj->indicadores_idindicadores->setSessionValue($detailPageObj->indicadores_idindicadores->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("IndicadoresList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_periodicidade_idperiodicidade":
                    break;
                case "x_unidade_medida_idunidade_medida":
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
