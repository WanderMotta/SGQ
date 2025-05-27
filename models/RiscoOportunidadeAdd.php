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
class RiscoOportunidadeAdd extends RiscoOportunidade
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RiscoOportunidadeAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "RiscoOportunidadeAdd";

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
        $this->idrisco_oportunidade->Visible = false;
        $this->dt_cadastro->setVisibility();
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setVisibility();
        $this->titulo->setVisibility();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setVisibility();
        $this->descricao->setVisibility();
        $this->consequencia->setVisibility();
        $this->frequencia_idfrequencia->setVisibility();
        $this->impacto_idimpacto->setVisibility();
        $this->grau_atencao->Visible = false;
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setVisibility();
        $this->plano_acao->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'risco_oportunidade';
        $this->TableName = 'risco_oportunidade';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

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
        $this->setupLookupOptions($this->tipo_risco_oportunidade_idtipo_risco_oportunidade);
        $this->setupLookupOptions($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
        $this->setupLookupOptions($this->frequencia_idfrequencia);
        $this->setupLookupOptions($this->impacto_idimpacto);
        $this->setupLookupOptions($this->acao_risco_oportunidade_idacao_risco_oportunidade);
        $this->setupLookupOptions($this->plano_acao);

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
            if (($keyValue = Get("idrisco_oportunidade") ?? Route("idrisco_oportunidade")) !== null) {
                $this->idrisco_oportunidade->setQueryStringValue($keyValue);
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

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("RiscoOportunidadeList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "RiscoOportunidadeList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "RiscoOportunidadeView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "RiscoOportunidadeList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "RiscoOportunidadeList"; // Return list page content
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->plano_acao->DefaultValue = $this->plano_acao->getDefault(); // PHP
        $this->plano_acao->OldValue = $this->plano_acao->DefaultValue;
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

        // Check field name 'acao_risco_oportunidade_idacao_risco_oportunidade' first before field var 'x_acao_risco_oportunidade_idacao_risco_oportunidade'
        $val = $CurrentForm->hasValue("acao_risco_oportunidade_idacao_risco_oportunidade") ? $CurrentForm->getValue("acao_risco_oportunidade_idacao_risco_oportunidade") : $CurrentForm->getValue("x_acao_risco_oportunidade_idacao_risco_oportunidade");
        if (!$this->acao_risco_oportunidade_idacao_risco_oportunidade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->Visible = false; // Disable update for API request
            } else {
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->setFormValue($val);
            }
        }

        // Check field name 'idrisco_oportunidade' first before field var 'x_idrisco_oportunidade'
        $val = $CurrentForm->hasValue("idrisco_oportunidade") ? $CurrentForm->getValue("idrisco_oportunidade") : $CurrentForm->getValue("x_idrisco_oportunidade");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->FormValue;
        $this->titulo->CurrentValue = $this->titulo->FormValue;
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->FormValue;
        $this->descricao->CurrentValue = $this->descricao->FormValue;
        $this->consequencia->CurrentValue = $this->consequencia->FormValue;
        $this->frequencia_idfrequencia->CurrentValue = $this->frequencia_idfrequencia->FormValue;
        $this->impacto_idimpacto->CurrentValue = $this->impacto_idimpacto->FormValue;
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->FormValue;
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

            // acao_risco_oportunidade_idacao_risco_oportunidade
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
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

            // Add refer script

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

            // acao_risco_oportunidade_idacao_risco_oportunidade
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->HrefValue = "";
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
            if ($this->acao_risco_oportunidade_idacao_risco_oportunidade->Visible && $this->acao_risco_oportunidade_idacao_risco_oportunidade->Required) {
                if (!$this->acao_risco_oportunidade_idacao_risco_oportunidade->IsDetailKey && EmptyValue($this->acao_risco_oportunidade_idacao_risco_oportunidade->FormValue)) {
                    $this->acao_risco_oportunidade_idacao_risco_oportunidade->addErrorMessage(str_replace("%s", $this->acao_risco_oportunidade_idacao_risco_oportunidade->caption(), $this->acao_risco_oportunidade_idacao_risco_oportunidade->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("PlanoAcaoGrid");
        if (in_array("plano_acao", $detailTblVar) && $detailPage->DetailAdd) {
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("PlanoAcaoGrid");
            if (in_array("plano_acao", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->risco_oportunidade_idrisco_oportunidade->setSessionValue($this->idrisco_oportunidade->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "plano_acao"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->risco_oportunidade_idrisco_oportunidade->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
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

        // tipo_risco_oportunidade_idtipo_risco_oportunidade
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setDbValueDef($rsnew, $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue, false);

        // titulo
        $this->titulo->setDbValueDef($rsnew, $this->titulo->CurrentValue, false);

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValueDef($rsnew, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue, false);

        // descricao
        $this->descricao->setDbValueDef($rsnew, $this->descricao->CurrentValue, false);

        // consequencia
        $this->consequencia->setDbValueDef($rsnew, $this->consequencia->CurrentValue, false);

        // frequencia_idfrequencia
        $this->frequencia_idfrequencia->setDbValueDef($rsnew, $this->frequencia_idfrequencia->CurrentValue, false);

        // impacto_idimpacto
        $this->impacto_idimpacto->setDbValueDef($rsnew, $this->impacto_idimpacto->CurrentValue, false);

        // acao_risco_oportunidade_idacao_risco_oportunidade
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setDbValueDef($rsnew, $this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue, false);
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
        if (isset($row['tipo_risco_oportunidade_idtipo_risco_oportunidade'])) { // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setFormValue($row['tipo_risco_oportunidade_idtipo_risco_oportunidade']);
        }
        if (isset($row['titulo'])) { // titulo
            $this->titulo->setFormValue($row['titulo']);
        }
        if (isset($row['origem_risco_oportunidade_idorigem_risco_oportunidade'])) { // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setFormValue($row['origem_risco_oportunidade_idorigem_risco_oportunidade']);
        }
        if (isset($row['descricao'])) { // descricao
            $this->descricao->setFormValue($row['descricao']);
        }
        if (isset($row['consequencia'])) { // consequencia
            $this->consequencia->setFormValue($row['consequencia']);
        }
        if (isset($row['frequencia_idfrequencia'])) { // frequencia_idfrequencia
            $this->frequencia_idfrequencia->setFormValue($row['frequencia_idfrequencia']);
        }
        if (isset($row['impacto_idimpacto'])) { // impacto_idimpacto
            $this->impacto_idimpacto->setFormValue($row['impacto_idimpacto']);
        }
        if (isset($row['acao_risco_oportunidade_idacao_risco_oportunidade'])) { // acao_risco_oportunidade_idacao_risco_oportunidade
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->setFormValue($row['acao_risco_oportunidade_idacao_risco_oportunidade']);
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
                if ($detailPageObj->DetailAdd) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

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
