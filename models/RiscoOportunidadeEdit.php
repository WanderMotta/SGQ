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
class RiscoOportunidadeEdit extends RiscoOportunidade
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RiscoOportunidadeEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "RiscoOportunidadeEdit";

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
        $this->idrisco_oportunidade->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setVisibility();
        $this->titulo->setVisibility();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setVisibility();
        $this->descricao->setVisibility();
        $this->consequencia->setVisibility();
        $this->frequencia_idfrequencia->setVisibility();
        $this->impacto_idimpacto->setVisibility();
        $this->grau_atencao->setVisibility();
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setVisibility();
        $this->plano_acao->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'risco_oportunidade';
        $this->TableName = 'risco_oportunidade';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (risco_oportunidade)
        if (!isset($GLOBALS["risco_oportunidade"]) || $GLOBALS["risco_oportunidade"]::class == PROJECT_NAMESPACE . "risco_oportunidade") {
            $GLOBALS["risco_oportunidade"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'risco_oportunidade');
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
                        $result["view"] = SameString($pageName, "RiscoOportunidadeView"); // If View page, no primary button
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
            $key .= @$ar['idrisco_oportunidade'];
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
            $this->idrisco_oportunidade->Visible = false;
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
        $this->setupLookupOptions($this->tipo_risco_oportunidade_idtipo_risco_oportunidade);
        $this->setupLookupOptions($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
        $this->setupLookupOptions($this->frequencia_idfrequencia);
        $this->setupLookupOptions($this->impacto_idimpacto);
        $this->setupLookupOptions($this->acao_risco_oportunidade_idacao_risco_oportunidade);
        $this->setupLookupOptions($this->plano_acao);

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
            if (($keyValue = Get("idrisco_oportunidade") ?? Key(0) ?? Route(2)) !== null) {
                $this->idrisco_oportunidade->setQueryStringValue($keyValue);
                $this->idrisco_oportunidade->setOldValue($this->idrisco_oportunidade->QueryStringValue);
            } elseif (Post("idrisco_oportunidade") !== null) {
                $this->idrisco_oportunidade->setFormValue(Post("idrisco_oportunidade"));
                $this->idrisco_oportunidade->setOldValue($this->idrisco_oportunidade->FormValue);
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
                if (($keyValue = Get("idrisco_oportunidade") ?? Route("idrisco_oportunidade")) !== null) {
                    $this->idrisco_oportunidade->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idrisco_oportunidade->CurrentValue = null;
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
                        $this->terminate("RiscoOportunidadeList"); // No matching record, return to list
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
                if (GetPageName($returnUrl) == "RiscoOportunidadeList") {
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
                        if (GetPageName($returnUrl) != "RiscoOportunidadeList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "RiscoOportunidadeList"; // Return list page content
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

        // Check field name 'idrisco_oportunidade' first before field var 'x_idrisco_oportunidade'
        $val = $CurrentForm->hasValue("idrisco_oportunidade") ? $CurrentForm->getValue("idrisco_oportunidade") : $CurrentForm->getValue("x_idrisco_oportunidade");
        if (!$this->idrisco_oportunidade->IsDetailKey) {
            $this->idrisco_oportunidade->setFormValue($val);
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

        // Check field name 'tipo_risco_oportunidade_idtipo_risco_oportunidade' first before field var 'x_tipo_risco_oportunidade_idtipo_risco_oportunidade'
        $val = $CurrentForm->hasValue("tipo_risco_oportunidade_idtipo_risco_oportunidade") ? $CurrentForm->getValue("tipo_risco_oportunidade_idtipo_risco_oportunidade") : $CurrentForm->getValue("x_tipo_risco_oportunidade_idtipo_risco_oportunidade");
        if (!$this->tipo_risco_oportunidade_idtipo_risco_oportunidade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible = false; // Disable update for API request
            } else {
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setFormValue($val);
            }
        }

        // Check field name 'titulo' first before field var 'x_titulo'
        $val = $CurrentForm->hasValue("titulo") ? $CurrentForm->getValue("titulo") : $CurrentForm->getValue("x_titulo");
        if (!$this->titulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titulo->Visible = false; // Disable update for API request
            } else {
                $this->titulo->setFormValue($val);
            }
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

        // Check field name 'descricao' first before field var 'x_descricao'
        $val = $CurrentForm->hasValue("descricao") ? $CurrentForm->getValue("descricao") : $CurrentForm->getValue("x_descricao");
        if (!$this->descricao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descricao->Visible = false; // Disable update for API request
            } else {
                $this->descricao->setFormValue($val);
            }
        }

        // Check field name 'consequencia' first before field var 'x_consequencia'
        $val = $CurrentForm->hasValue("consequencia") ? $CurrentForm->getValue("consequencia") : $CurrentForm->getValue("x_consequencia");
        if (!$this->consequencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->consequencia->Visible = false; // Disable update for API request
            } else {
                $this->consequencia->setFormValue($val);
            }
        }

        // Check field name 'frequencia_idfrequencia' first before field var 'x_frequencia_idfrequencia'
        $val = $CurrentForm->hasValue("frequencia_idfrequencia") ? $CurrentForm->getValue("frequencia_idfrequencia") : $CurrentForm->getValue("x_frequencia_idfrequencia");
        if (!$this->frequencia_idfrequencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->frequencia_idfrequencia->Visible = false; // Disable update for API request
            } else {
                $this->frequencia_idfrequencia->setFormValue($val);
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

        // Check field name 'grau_atencao' first before field var 'x_grau_atencao'
        $val = $CurrentForm->hasValue("grau_atencao") ? $CurrentForm->getValue("grau_atencao") : $CurrentForm->getValue("x_grau_atencao");
        if (!$this->grau_atencao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->grau_atencao->Visible = false; // Disable update for API request
            } else {
                $this->grau_atencao->setFormValue($val);
            }
        }

        // Check field name 'acao_risco_oportunidade_idacao_risco_oportunidade' first before field var 'x_acao_risco_oportunidade_idacao_risco_oportunidade'
        $val = $CurrentForm->hasValue("acao_risco_oportunidade_idacao_risco_oportunidade") ? $CurrentForm->getValue("acao_risco_oportunidade_idacao_risco_oportunidade") : $CurrentForm->getValue("x_acao_risco_oportunidade_idacao_risco_oportunidade");
        if (!$this->acao_risco_oportunidade_idacao_risco_oportunidade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->Visible = false; // Disable update for API request
            } else {
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->setFormValue($val);
            }
        }

        // Check field name 'plano_acao' first before field var 'x_plano_acao'
        $val = $CurrentForm->hasValue("plano_acao") ? $CurrentForm->getValue("plano_acao") : $CurrentForm->getValue("x_plano_acao");
        if (!$this->plano_acao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->plano_acao->Visible = false; // Disable update for API request
            } else {
                $this->plano_acao->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idrisco_oportunidade->CurrentValue = $this->idrisco_oportunidade->FormValue;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->FormValue;
        $this->titulo->CurrentValue = $this->titulo->FormValue;
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->FormValue;
        $this->descricao->CurrentValue = $this->descricao->FormValue;
        $this->consequencia->CurrentValue = $this->consequencia->FormValue;
        $this->frequencia_idfrequencia->CurrentValue = $this->frequencia_idfrequencia->FormValue;
        $this->impacto_idimpacto->CurrentValue = $this->impacto_idimpacto->FormValue;
        $this->grau_atencao->CurrentValue = $this->grau_atencao->FormValue;
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->FormValue;
        $this->plano_acao->CurrentValue = $this->plano_acao->FormValue;
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
        $this->idrisco_oportunidade->setDbValue($row['idrisco_oportunidade']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setDbValue($row['tipo_risco_oportunidade_idtipo_risco_oportunidade']);
        $this->titulo->setDbValue($row['titulo']);
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValue($row['origem_risco_oportunidade_idorigem_risco_oportunidade']);
        $this->descricao->setDbValue($row['descricao']);
        $this->consequencia->setDbValue($row['consequencia']);
        $this->frequencia_idfrequencia->setDbValue($row['frequencia_idfrequencia']);
        $this->impacto_idimpacto->setDbValue($row['impacto_idimpacto']);
        $this->grau_atencao->setDbValue($row['grau_atencao']);
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setDbValue($row['acao_risco_oportunidade_idacao_risco_oportunidade']);
        $this->plano_acao->setDbValue($row['plano_acao']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idrisco_oportunidade'] = $this->idrisco_oportunidade->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['tipo_risco_oportunidade_idtipo_risco_oportunidade'] = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->DefaultValue;
        $row['titulo'] = $this->titulo->DefaultValue;
        $row['origem_risco_oportunidade_idorigem_risco_oportunidade'] = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->DefaultValue;
        $row['descricao'] = $this->descricao->DefaultValue;
        $row['consequencia'] = $this->consequencia->DefaultValue;
        $row['frequencia_idfrequencia'] = $this->frequencia_idfrequencia->DefaultValue;
        $row['impacto_idimpacto'] = $this->impacto_idimpacto->DefaultValue;
        $row['grau_atencao'] = $this->grau_atencao->DefaultValue;
        $row['acao_risco_oportunidade_idacao_risco_oportunidade'] = $this->acao_risco_oportunidade_idacao_risco_oportunidade->DefaultValue;
        $row['plano_acao'] = $this->plano_acao->DefaultValue;
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

        // idrisco_oportunidade
        $this->idrisco_oportunidade->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // tipo_risco_oportunidade_idtipo_risco_oportunidade
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->RowCssClass = "row";

        // titulo
        $this->titulo->RowCssClass = "row";

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->RowCssClass = "row";

        // descricao
        $this->descricao->RowCssClass = "row";

        // consequencia
        $this->consequencia->RowCssClass = "row";

        // frequencia_idfrequencia
        $this->frequencia_idfrequencia->RowCssClass = "row";

        // impacto_idimpacto
        $this->impacto_idimpacto->RowCssClass = "row";

        // grau_atencao
        $this->grau_atencao->RowCssClass = "row";

        // acao_risco_oportunidade_idacao_risco_oportunidade
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->RowCssClass = "row";

        // plano_acao
        $this->plano_acao->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idrisco_oportunidade
            $this->idrisco_oportunidade->ViewValue = $this->idrisco_oportunidade->CurrentValue;
            $this->idrisco_oportunidade->CssClass = "fw-bold";
            $this->idrisco_oportunidade->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $curVal = strval($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue);
            if ($curVal != "") {
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->lookupCacheOption($curVal);
                if ($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getTable()->Fields["idtipo_risco_oportunidade"]->searchExpression(), "=", $curVal, $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getTable()->Fields["idtipo_risco_oportunidade"]->searchDataType(), "");
                    $sqlWrk = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->displayValue($arwrk);
                    } else {
                        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = FormatNumber($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue, $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->formatPattern());
                    }
                }
            } else {
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = null;
            }
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CssClass = "fw-bold";

            // titulo
            $this->titulo->ViewValue = $this->titulo->CurrentValue;
            $this->titulo->CssClass = "fw-bold";

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

            // descricao
            $this->descricao->ViewValue = $this->descricao->CurrentValue;
            $this->descricao->CssClass = "fw-bold";

            // consequencia
            $this->consequencia->ViewValue = $this->consequencia->CurrentValue;
            $this->consequencia->CssClass = "fw-bold";

            // frequencia_idfrequencia
            $curVal = strval($this->frequencia_idfrequencia->CurrentValue);
            if ($curVal != "") {
                $this->frequencia_idfrequencia->ViewValue = $this->frequencia_idfrequencia->lookupCacheOption($curVal);
                if ($this->frequencia_idfrequencia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->frequencia_idfrequencia->Lookup->getTable()->Fields["idfrequencia"]->searchExpression(), "=", $curVal, $this->frequencia_idfrequencia->Lookup->getTable()->Fields["idfrequencia"]->searchDataType(), "");
                    $sqlWrk = $this->frequencia_idfrequencia->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->frequencia_idfrequencia->Lookup->renderViewRow($rswrk[0]);
                        $this->frequencia_idfrequencia->ViewValue = $this->frequencia_idfrequencia->displayValue($arwrk);
                    } else {
                        $this->frequencia_idfrequencia->ViewValue = FormatNumber($this->frequencia_idfrequencia->CurrentValue, $this->frequencia_idfrequencia->formatPattern());
                    }
                }
            } else {
                $this->frequencia_idfrequencia->ViewValue = null;
            }
            $this->frequencia_idfrequencia->CssClass = "fw-bold";

            // impacto_idimpacto
            $curVal = strval($this->impacto_idimpacto->CurrentValue);
            if ($curVal != "") {
                $this->impacto_idimpacto->ViewValue = $this->impacto_idimpacto->lookupCacheOption($curVal);
                if ($this->impacto_idimpacto->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchExpression(), "=", $curVal, $this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchDataType(), "");
                    $sqlWrk = $this->impacto_idimpacto->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

            // grau_atencao
            $this->grau_atencao->ViewValue = $this->grau_atencao->CurrentValue;
            $this->grau_atencao->ViewValue = FormatNumber($this->grau_atencao->ViewValue, $this->grau_atencao->formatPattern());
            $this->grau_atencao->CssClass = "fw-bold";
            $this->grau_atencao->CellCssStyle .= "text-align: center;";

            // acao_risco_oportunidade_idacao_risco_oportunidade
            $curVal = strval($this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue);
            if ($curVal != "") {
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->lookupCacheOption($curVal);
                if ($this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getTable()->Fields["idacao_risco_oportunidade"]->searchExpression(), "=", $curVal, $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getTable()->Fields["idacao_risco_oportunidade"]->searchDataType(), "");
                    $sqlWrk = $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->renderViewRow($rswrk[0]);
                        $this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->displayValue($arwrk);
                    } else {
                        $this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue = FormatNumber($this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue, $this->acao_risco_oportunidade_idacao_risco_oportunidade->formatPattern());
                    }
                }
            } else {
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue = null;
            }
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->CssClass = "fw-bold";

            // plano_acao
            if (strval($this->plano_acao->CurrentValue) != "") {
                $this->plano_acao->ViewValue = $this->plano_acao->optionCaption($this->plano_acao->CurrentValue);
            } else {
                $this->plano_acao->ViewValue = null;
            }
            $this->plano_acao->CssClass = "fw-bold";
            $this->plano_acao->CellCssStyle .= "text-align: center;";

            // idrisco_oportunidade
            $this->idrisco_oportunidade->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->HrefValue = "";

            // titulo
            $this->titulo->HrefValue = "";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";

            // descricao
            $this->descricao->HrefValue = "";

            // consequencia
            $this->consequencia->HrefValue = "";

            // frequencia_idfrequencia
            $this->frequencia_idfrequencia->HrefValue = "";

            // impacto_idimpacto
            $this->impacto_idimpacto->HrefValue = "";

            // grau_atencao
            $this->grau_atencao->HrefValue = "";
            $this->grau_atencao->TooltipValue = "";

            // acao_risco_oportunidade_idacao_risco_oportunidade
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->HrefValue = "";

            // plano_acao
            $this->plano_acao->HrefValue = "";
            $this->plano_acao->TooltipValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // idrisco_oportunidade
            $this->idrisco_oportunidade->setupEditAttributes();
            $this->idrisco_oportunidade->EditValue = $this->idrisco_oportunidade->CurrentValue;
            $this->idrisco_oportunidade->CssClass = "fw-bold";
            $this->idrisco_oportunidade->CellCssStyle .= "text-align: center;";

            // dt_cadastro

            // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $curVal = trim(strval($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue));
            if ($curVal != "") {
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->lookupCacheOption($curVal);
            } else {
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup !== null && is_array($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->lookupOptions()) && count($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue !== null) { // Load from cache
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->EditValue = array_values($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getTable()->Fields["idtipo_risco_oportunidade"]->searchExpression(), "=", $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue, $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getTable()->Fields["idtipo_risco_oportunidade"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->EditValue = $arwrk;
            }
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->PlaceHolder = RemoveHtml($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption());

            // titulo
            $this->titulo->setupEditAttributes();
            if (!$this->titulo->Raw) {
                $this->titulo->CurrentValue = HtmlDecode($this->titulo->CurrentValue);
            }
            $this->titulo->EditValue = HtmlEncode($this->titulo->CurrentValue);
            $this->titulo->PlaceHolder = RemoveHtml($this->titulo->caption());

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

            // descricao
            $this->descricao->setupEditAttributes();
            $this->descricao->EditValue = HtmlEncode($this->descricao->CurrentValue);
            $this->descricao->PlaceHolder = RemoveHtml($this->descricao->caption());

            // consequencia
            $this->consequencia->setupEditAttributes();
            $this->consequencia->EditValue = HtmlEncode($this->consequencia->CurrentValue);
            $this->consequencia->PlaceHolder = RemoveHtml($this->consequencia->caption());

            // frequencia_idfrequencia
            $this->frequencia_idfrequencia->setupEditAttributes();
            $curVal = trim(strval($this->frequencia_idfrequencia->CurrentValue));
            if ($curVal != "") {
                $this->frequencia_idfrequencia->ViewValue = $this->frequencia_idfrequencia->lookupCacheOption($curVal);
            } else {
                $this->frequencia_idfrequencia->ViewValue = $this->frequencia_idfrequencia->Lookup !== null && is_array($this->frequencia_idfrequencia->lookupOptions()) && count($this->frequencia_idfrequencia->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->frequencia_idfrequencia->ViewValue !== null) { // Load from cache
                $this->frequencia_idfrequencia->EditValue = array_values($this->frequencia_idfrequencia->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->frequencia_idfrequencia->Lookup->getTable()->Fields["idfrequencia"]->searchExpression(), "=", $this->frequencia_idfrequencia->CurrentValue, $this->frequencia_idfrequencia->Lookup->getTable()->Fields["idfrequencia"]->searchDataType(), "");
                }
                $sqlWrk = $this->frequencia_idfrequencia->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->frequencia_idfrequencia->Lookup->renderViewRow($row);
                }
                $this->frequencia_idfrequencia->EditValue = $arwrk;
            }
            $this->frequencia_idfrequencia->PlaceHolder = RemoveHtml($this->frequencia_idfrequencia->caption());

            // impacto_idimpacto
            $this->impacto_idimpacto->setupEditAttributes();
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
                $sqlWrk = $this->impacto_idimpacto->Lookup->getSql(true, $filterWrk, '', $this, false, true);
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

            // grau_atencao
            $this->grau_atencao->setupEditAttributes();
            $this->grau_atencao->EditValue = $this->grau_atencao->CurrentValue;
            $this->grau_atencao->EditValue = FormatNumber($this->grau_atencao->EditValue, $this->grau_atencao->formatPattern());
            $this->grau_atencao->CssClass = "fw-bold";
            $this->grau_atencao->CellCssStyle .= "text-align: center;";

            // acao_risco_oportunidade_idacao_risco_oportunidade
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->setupEditAttributes();
            $curVal = trim(strval($this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue));
            if ($curVal != "") {
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->lookupCacheOption($curVal);
            } else {
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup !== null && is_array($this->acao_risco_oportunidade_idacao_risco_oportunidade->lookupOptions()) && count($this->acao_risco_oportunidade_idacao_risco_oportunidade->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue !== null) { // Load from cache
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->EditValue = array_values($this->acao_risco_oportunidade_idacao_risco_oportunidade->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getTable()->Fields["idacao_risco_oportunidade"]->searchExpression(), "=", $this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue, $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getTable()->Fields["idacao_risco_oportunidade"]->searchDataType(), "");
                }
                $sqlWrk = $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->EditValue = $arwrk;
            }
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->PlaceHolder = RemoveHtml($this->acao_risco_oportunidade_idacao_risco_oportunidade->caption());

            // plano_acao
            $this->plano_acao->setupEditAttributes();
            if (strval($this->plano_acao->CurrentValue) != "") {
                $this->plano_acao->EditValue = $this->plano_acao->optionCaption($this->plano_acao->CurrentValue);
            } else {
                $this->plano_acao->EditValue = null;
            }
            $this->plano_acao->CssClass = "fw-bold";
            $this->plano_acao->CellCssStyle .= "text-align: center;";

            // Edit refer script

            // idrisco_oportunidade
            $this->idrisco_oportunidade->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->HrefValue = "";

            // titulo
            $this->titulo->HrefValue = "";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";

            // descricao
            $this->descricao->HrefValue = "";

            // consequencia
            $this->consequencia->HrefValue = "";

            // frequencia_idfrequencia
            $this->frequencia_idfrequencia->HrefValue = "";

            // impacto_idimpacto
            $this->impacto_idimpacto->HrefValue = "";

            // grau_atencao
            $this->grau_atencao->HrefValue = "";
            $this->grau_atencao->TooltipValue = "";

            // acao_risco_oportunidade_idacao_risco_oportunidade
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->HrefValue = "";

            // plano_acao
            $this->plano_acao->HrefValue = "";
            $this->plano_acao->TooltipValue = "";
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
            if ($this->idrisco_oportunidade->Visible && $this->idrisco_oportunidade->Required) {
                if (!$this->idrisco_oportunidade->IsDetailKey && EmptyValue($this->idrisco_oportunidade->FormValue)) {
                    $this->idrisco_oportunidade->addErrorMessage(str_replace("%s", $this->idrisco_oportunidade->caption(), $this->idrisco_oportunidade->RequiredErrorMessage));
                }
            }
            if ($this->dt_cadastro->Visible && $this->dt_cadastro->Required) {
                if (!$this->dt_cadastro->IsDetailKey && EmptyValue($this->dt_cadastro->FormValue)) {
                    $this->dt_cadastro->addErrorMessage(str_replace("%s", $this->dt_cadastro->caption(), $this->dt_cadastro->RequiredErrorMessage));
                }
            }
            if ($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible && $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Required) {
                if ($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->FormValue == "") {
                    $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->addErrorMessage(str_replace("%s", $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption(), $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->RequiredErrorMessage));
                }
            }
            if ($this->titulo->Visible && $this->titulo->Required) {
                if (!$this->titulo->IsDetailKey && EmptyValue($this->titulo->FormValue)) {
                    $this->titulo->addErrorMessage(str_replace("%s", $this->titulo->caption(), $this->titulo->RequiredErrorMessage));
                }
            }
            if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible && $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Required) {
                if (!$this->origem_risco_oportunidade_idorigem_risco_oportunidade->IsDetailKey && EmptyValue($this->origem_risco_oportunidade_idorigem_risco_oportunidade->FormValue)) {
                    $this->origem_risco_oportunidade_idorigem_risco_oportunidade->addErrorMessage(str_replace("%s", $this->origem_risco_oportunidade_idorigem_risco_oportunidade->caption(), $this->origem_risco_oportunidade_idorigem_risco_oportunidade->RequiredErrorMessage));
                }
            }
            if ($this->descricao->Visible && $this->descricao->Required) {
                if (!$this->descricao->IsDetailKey && EmptyValue($this->descricao->FormValue)) {
                    $this->descricao->addErrorMessage(str_replace("%s", $this->descricao->caption(), $this->descricao->RequiredErrorMessage));
                }
            }
            if ($this->consequencia->Visible && $this->consequencia->Required) {
                if (!$this->consequencia->IsDetailKey && EmptyValue($this->consequencia->FormValue)) {
                    $this->consequencia->addErrorMessage(str_replace("%s", $this->consequencia->caption(), $this->consequencia->RequiredErrorMessage));
                }
            }
            if ($this->frequencia_idfrequencia->Visible && $this->frequencia_idfrequencia->Required) {
                if (!$this->frequencia_idfrequencia->IsDetailKey && EmptyValue($this->frequencia_idfrequencia->FormValue)) {
                    $this->frequencia_idfrequencia->addErrorMessage(str_replace("%s", $this->frequencia_idfrequencia->caption(), $this->frequencia_idfrequencia->RequiredErrorMessage));
                }
            }
            if ($this->impacto_idimpacto->Visible && $this->impacto_idimpacto->Required) {
                if (!$this->impacto_idimpacto->IsDetailKey && EmptyValue($this->impacto_idimpacto->FormValue)) {
                    $this->impacto_idimpacto->addErrorMessage(str_replace("%s", $this->impacto_idimpacto->caption(), $this->impacto_idimpacto->RequiredErrorMessage));
                }
            }
            if ($this->grau_atencao->Visible && $this->grau_atencao->Required) {
                if (!$this->grau_atencao->IsDetailKey && EmptyValue($this->grau_atencao->FormValue)) {
                    $this->grau_atencao->addErrorMessage(str_replace("%s", $this->grau_atencao->caption(), $this->grau_atencao->RequiredErrorMessage));
                }
            }
            if ($this->acao_risco_oportunidade_idacao_risco_oportunidade->Visible && $this->acao_risco_oportunidade_idacao_risco_oportunidade->Required) {
                if (!$this->acao_risco_oportunidade_idacao_risco_oportunidade->IsDetailKey && EmptyValue($this->acao_risco_oportunidade_idacao_risco_oportunidade->FormValue)) {
                    $this->acao_risco_oportunidade_idacao_risco_oportunidade->addErrorMessage(str_replace("%s", $this->acao_risco_oportunidade_idacao_risco_oportunidade->caption(), $this->acao_risco_oportunidade_idacao_risco_oportunidade->RequiredErrorMessage));
                }
            }
            if ($this->plano_acao->Visible && $this->plano_acao->Required) {
                if ($this->plano_acao->FormValue == "") {
                    $this->plano_acao->addErrorMessage(str_replace("%s", $this->plano_acao->caption(), $this->plano_acao->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("PlanoAcaoGrid");
        if (in_array("plano_acao", $detailTblVar) && $detailPage->DetailEdit) {
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
            $detailPage = Container("PlanoAcaoGrid");
            if (in_array("plano_acao", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "plano_acao"); // Load user level of detail table
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

        // tipo_risco_oportunidade_idtipo_risco_oportunidade
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setDbValueDef($rsnew, $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue, $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ReadOnly);

        // titulo
        $this->titulo->setDbValueDef($rsnew, $this->titulo->CurrentValue, $this->titulo->ReadOnly);

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValueDef($rsnew, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ReadOnly);

        // descricao
        $this->descricao->setDbValueDef($rsnew, $this->descricao->CurrentValue, $this->descricao->ReadOnly);

        // consequencia
        $this->consequencia->setDbValueDef($rsnew, $this->consequencia->CurrentValue, $this->consequencia->ReadOnly);

        // frequencia_idfrequencia
        $this->frequencia_idfrequencia->setDbValueDef($rsnew, $this->frequencia_idfrequencia->CurrentValue, $this->frequencia_idfrequencia->ReadOnly);

        // impacto_idimpacto
        $this->impacto_idimpacto->setDbValueDef($rsnew, $this->impacto_idimpacto->CurrentValue, $this->impacto_idimpacto->ReadOnly);

        // acao_risco_oportunidade_idacao_risco_oportunidade
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setDbValueDef($rsnew, $this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue, $this->acao_risco_oportunidade_idacao_risco_oportunidade->ReadOnly);
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
        if (isset($row['tipo_risco_oportunidade_idtipo_risco_oportunidade'])) { // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue = $row['tipo_risco_oportunidade_idtipo_risco_oportunidade'];
        }
        if (isset($row['titulo'])) { // titulo
            $this->titulo->CurrentValue = $row['titulo'];
        }
        if (isset($row['origem_risco_oportunidade_idorigem_risco_oportunidade'])) { // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue = $row['origem_risco_oportunidade_idorigem_risco_oportunidade'];
        }
        if (isset($row['descricao'])) { // descricao
            $this->descricao->CurrentValue = $row['descricao'];
        }
        if (isset($row['consequencia'])) { // consequencia
            $this->consequencia->CurrentValue = $row['consequencia'];
        }
        if (isset($row['frequencia_idfrequencia'])) { // frequencia_idfrequencia
            $this->frequencia_idfrequencia->CurrentValue = $row['frequencia_idfrequencia'];
        }
        if (isset($row['impacto_idimpacto'])) { // impacto_idimpacto
            $this->impacto_idimpacto->CurrentValue = $row['impacto_idimpacto'];
        }
        if (isset($row['acao_risco_oportunidade_idacao_risco_oportunidade'])) { // acao_risco_oportunidade_idacao_risco_oportunidade
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue = $row['acao_risco_oportunidade_idacao_risco_oportunidade'];
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
            if (in_array("plano_acao", $detailTblVar)) {
                $detailPageObj = Container("PlanoAcaoGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->risco_oportunidade_idrisco_oportunidade->IsDetailKey = true;
                    $detailPageObj->risco_oportunidade_idrisco_oportunidade->CurrentValue = $this->idrisco_oportunidade->CurrentValue;
                    $detailPageObj->risco_oportunidade_idrisco_oportunidade->setSessionValue($detailPageObj->risco_oportunidade_idrisco_oportunidade->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("RiscoOportunidadeList"), "", $this->TableVar, true);
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
                case "x_tipo_risco_oportunidade_idtipo_risco_oportunidade":
                    break;
                case "x_origem_risco_oportunidade_idorigem_risco_oportunidade":
                    break;
                case "x_frequencia_idfrequencia":
                    break;
                case "x_impacto_idimpacto":
                    break;
                case "x_acao_risco_oportunidade_idacao_risco_oportunidade":
                    break;
                case "x_plano_acao":
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
