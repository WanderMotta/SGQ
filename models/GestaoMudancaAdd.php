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
class GestaoMudancaAdd extends GestaoMudanca
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "GestaoMudancaAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "GestaoMudancaAdd";

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
        $this->idgestao_mudanca->Visible = false;
        $this->dt_cadastro->setVisibility();
        $this->titulo->setVisibility();
        $this->dt_inicio->setVisibility();
        $this->detalhamento->setVisibility();
        $this->impacto->setVisibility();
        $this->motivo->setVisibility();
        $this->recursos->setVisibility();
        $this->prazo_ate->setVisibility();
        $this->departamentos_iddepartamentos->setVisibility();
        $this->usuario_idusuario->setVisibility();
        $this->implementado->setVisibility();
        $this->status->setVisibility();
        $this->eficaz->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'gestao_mudanca';
        $this->TableName = 'gestao_mudanca';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (gestao_mudanca)
        if (!isset($GLOBALS["gestao_mudanca"]) || $GLOBALS["gestao_mudanca"]::class == PROJECT_NAMESPACE . "gestao_mudanca") {
            $GLOBALS["gestao_mudanca"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'gestao_mudanca');
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
                        $result["view"] = SameString($pageName, "GestaoMudancaView"); // If View page, no primary button
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
            $key .= @$ar['idgestao_mudanca'];
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
            $this->idgestao_mudanca->Visible = false;
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
        $this->setupLookupOptions($this->departamentos_iddepartamentos);
        $this->setupLookupOptions($this->usuario_idusuario);
        $this->setupLookupOptions($this->implementado);
        $this->setupLookupOptions($this->status);
        $this->setupLookupOptions($this->eficaz);

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
            if (($keyValue = Get("idgestao_mudanca") ?? Route("idgestao_mudanca")) !== null) {
                $this->idgestao_mudanca->setQueryStringValue($keyValue);
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
                    $this->terminate("GestaoMudancaList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "GestaoMudancaList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "GestaoMudancaView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "GestaoMudancaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "GestaoMudancaList"; // Return list page content
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
        $this->recursos->DefaultValue = $this->recursos->getDefault(); // PHP
        $this->recursos->OldValue = $this->recursos->DefaultValue;
        $this->implementado->DefaultValue = $this->implementado->getDefault(); // PHP
        $this->implementado->OldValue = $this->implementado->DefaultValue;
        $this->status->DefaultValue = $this->status->getDefault(); // PHP
        $this->status->OldValue = $this->status->DefaultValue;
        $this->eficaz->DefaultValue = $this->eficaz->getDefault(); // PHP
        $this->eficaz->OldValue = $this->eficaz->DefaultValue;
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

        // Check field name 'titulo' first before field var 'x_titulo'
        $val = $CurrentForm->hasValue("titulo") ? $CurrentForm->getValue("titulo") : $CurrentForm->getValue("x_titulo");
        if (!$this->titulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titulo->Visible = false; // Disable update for API request
            } else {
                $this->titulo->setFormValue($val);
            }
        }

        // Check field name 'dt_inicio' first before field var 'x_dt_inicio'
        $val = $CurrentForm->hasValue("dt_inicio") ? $CurrentForm->getValue("dt_inicio") : $CurrentForm->getValue("x_dt_inicio");
        if (!$this->dt_inicio->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dt_inicio->Visible = false; // Disable update for API request
            } else {
                $this->dt_inicio->setFormValue($val, true, $validate);
            }
            $this->dt_inicio->CurrentValue = UnFormatDateTime($this->dt_inicio->CurrentValue, $this->dt_inicio->formatPattern());
        }

        // Check field name 'detalhamento' first before field var 'x_detalhamento'
        $val = $CurrentForm->hasValue("detalhamento") ? $CurrentForm->getValue("detalhamento") : $CurrentForm->getValue("x_detalhamento");
        if (!$this->detalhamento->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->detalhamento->Visible = false; // Disable update for API request
            } else {
                $this->detalhamento->setFormValue($val);
            }
        }

        // Check field name 'impacto' first before field var 'x_impacto'
        $val = $CurrentForm->hasValue("impacto") ? $CurrentForm->getValue("impacto") : $CurrentForm->getValue("x_impacto");
        if (!$this->impacto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->impacto->Visible = false; // Disable update for API request
            } else {
                $this->impacto->setFormValue($val);
            }
        }

        // Check field name 'motivo' first before field var 'x_motivo'
        $val = $CurrentForm->hasValue("motivo") ? $CurrentForm->getValue("motivo") : $CurrentForm->getValue("x_motivo");
        if (!$this->motivo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->motivo->Visible = false; // Disable update for API request
            } else {
                $this->motivo->setFormValue($val);
            }
        }

        // Check field name 'recursos' first before field var 'x_recursos'
        $val = $CurrentForm->hasValue("recursos") ? $CurrentForm->getValue("recursos") : $CurrentForm->getValue("x_recursos");
        if (!$this->recursos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->recursos->Visible = false; // Disable update for API request
            } else {
                $this->recursos->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'prazo_ate' first before field var 'x_prazo_ate'
        $val = $CurrentForm->hasValue("prazo_ate") ? $CurrentForm->getValue("prazo_ate") : $CurrentForm->getValue("x_prazo_ate");
        if (!$this->prazo_ate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->prazo_ate->Visible = false; // Disable update for API request
            } else {
                $this->prazo_ate->setFormValue($val, true, $validate);
            }
            $this->prazo_ate->CurrentValue = UnFormatDateTime($this->prazo_ate->CurrentValue, $this->prazo_ate->formatPattern());
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

        // Check field name 'usuario_idusuario' first before field var 'x_usuario_idusuario'
        $val = $CurrentForm->hasValue("usuario_idusuario") ? $CurrentForm->getValue("usuario_idusuario") : $CurrentForm->getValue("x_usuario_idusuario");
        if (!$this->usuario_idusuario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuario_idusuario->Visible = false; // Disable update for API request
            } else {
                $this->usuario_idusuario->setFormValue($val);
            }
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

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
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

        // Check field name 'idgestao_mudanca' first before field var 'x_idgestao_mudanca'
        $val = $CurrentForm->hasValue("idgestao_mudanca") ? $CurrentForm->getValue("idgestao_mudanca") : $CurrentForm->getValue("x_idgestao_mudanca");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->titulo->CurrentValue = $this->titulo->FormValue;
        $this->dt_inicio->CurrentValue = $this->dt_inicio->FormValue;
        $this->dt_inicio->CurrentValue = UnFormatDateTime($this->dt_inicio->CurrentValue, $this->dt_inicio->formatPattern());
        $this->detalhamento->CurrentValue = $this->detalhamento->FormValue;
        $this->impacto->CurrentValue = $this->impacto->FormValue;
        $this->motivo->CurrentValue = $this->motivo->FormValue;
        $this->recursos->CurrentValue = $this->recursos->FormValue;
        $this->prazo_ate->CurrentValue = $this->prazo_ate->FormValue;
        $this->prazo_ate->CurrentValue = UnFormatDateTime($this->prazo_ate->CurrentValue, $this->prazo_ate->formatPattern());
        $this->departamentos_iddepartamentos->CurrentValue = $this->departamentos_iddepartamentos->FormValue;
        $this->usuario_idusuario->CurrentValue = $this->usuario_idusuario->FormValue;
        $this->implementado->CurrentValue = $this->implementado->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->eficaz->CurrentValue = $this->eficaz->FormValue;
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
        $this->idgestao_mudanca->setDbValue($row['idgestao_mudanca']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->titulo->setDbValue($row['titulo']);
        $this->dt_inicio->setDbValue($row['dt_inicio']);
        $this->detalhamento->setDbValue($row['detalhamento']);
        $this->impacto->setDbValue($row['impacto']);
        $this->motivo->setDbValue($row['motivo']);
        $this->recursos->setDbValue($row['recursos']);
        $this->prazo_ate->setDbValue($row['prazo_ate']);
        $this->departamentos_iddepartamentos->setDbValue($row['departamentos_iddepartamentos']);
        $this->usuario_idusuario->setDbValue($row['usuario_idusuario']);
        $this->implementado->setDbValue($row['implementado']);
        $this->status->setDbValue($row['status']);
        $this->eficaz->setDbValue($row['eficaz']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idgestao_mudanca'] = $this->idgestao_mudanca->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['titulo'] = $this->titulo->DefaultValue;
        $row['dt_inicio'] = $this->dt_inicio->DefaultValue;
        $row['detalhamento'] = $this->detalhamento->DefaultValue;
        $row['impacto'] = $this->impacto->DefaultValue;
        $row['motivo'] = $this->motivo->DefaultValue;
        $row['recursos'] = $this->recursos->DefaultValue;
        $row['prazo_ate'] = $this->prazo_ate->DefaultValue;
        $row['departamentos_iddepartamentos'] = $this->departamentos_iddepartamentos->DefaultValue;
        $row['usuario_idusuario'] = $this->usuario_idusuario->DefaultValue;
        $row['implementado'] = $this->implementado->DefaultValue;
        $row['status'] = $this->status->DefaultValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // idgestao_mudanca
        $this->idgestao_mudanca->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // titulo
        $this->titulo->RowCssClass = "row";

        // dt_inicio
        $this->dt_inicio->RowCssClass = "row";

        // detalhamento
        $this->detalhamento->RowCssClass = "row";

        // impacto
        $this->impacto->RowCssClass = "row";

        // motivo
        $this->motivo->RowCssClass = "row";

        // recursos
        $this->recursos->RowCssClass = "row";

        // prazo_ate
        $this->prazo_ate->RowCssClass = "row";

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->RowCssClass = "row";

        // usuario_idusuario
        $this->usuario_idusuario->RowCssClass = "row";

        // implementado
        $this->implementado->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // eficaz
        $this->eficaz->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idgestao_mudanca
            $this->idgestao_mudanca->ViewValue = $this->idgestao_mudanca->CurrentValue;
            $this->idgestao_mudanca->CssClass = "fw-bold";
            $this->idgestao_mudanca->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // titulo
            $this->titulo->ViewValue = $this->titulo->CurrentValue;
            $this->titulo->CssClass = "fw-bold";

            // dt_inicio
            $this->dt_inicio->ViewValue = $this->dt_inicio->CurrentValue;
            $this->dt_inicio->ViewValue = FormatDateTime($this->dt_inicio->ViewValue, $this->dt_inicio->formatPattern());
            $this->dt_inicio->CssClass = "fw-bold";

            // detalhamento
            $this->detalhamento->ViewValue = $this->detalhamento->CurrentValue;
            $this->detalhamento->CssClass = "fw-bold";

            // impacto
            $this->impacto->ViewValue = $this->impacto->CurrentValue;
            $this->impacto->CssClass = "fw-bold";

            // motivo
            $this->motivo->ViewValue = $this->motivo->CurrentValue;
            $this->motivo->CssClass = "fw-bold";

            // recursos
            $this->recursos->ViewValue = $this->recursos->CurrentValue;
            $this->recursos->ViewValue = FormatCurrency($this->recursos->ViewValue, $this->recursos->formatPattern());
            $this->recursos->CssClass = "fw-bold";
            $this->recursos->CellCssStyle .= "text-align: right;";

            // prazo_ate
            $this->prazo_ate->ViewValue = $this->prazo_ate->CurrentValue;
            $this->prazo_ate->ViewValue = FormatDateTime($this->prazo_ate->ViewValue, $this->prazo_ate->formatPattern());
            $this->prazo_ate->CssClass = "fw-bold";

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

            // usuario_idusuario
            $curVal = strval($this->usuario_idusuario->CurrentValue);
            if ($curVal != "") {
                $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->lookupCacheOption($curVal);
                if ($this->usuario_idusuario->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->usuario_idusuario->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->usuario_idusuario->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                    $sqlWrk = $this->usuario_idusuario->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->usuario_idusuario->Lookup->renderViewRow($rswrk[0]);
                        $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->displayValue($arwrk);
                    } else {
                        $this->usuario_idusuario->ViewValue = FormatNumber($this->usuario_idusuario->CurrentValue, $this->usuario_idusuario->formatPattern());
                    }
                }
            } else {
                $this->usuario_idusuario->ViewValue = null;
            }
            $this->usuario_idusuario->CssClass = "fw-bold";

            // implementado
            if (strval($this->implementado->CurrentValue) != "") {
                $this->implementado->ViewValue = $this->implementado->optionCaption($this->implementado->CurrentValue);
            } else {
                $this->implementado->ViewValue = null;
            }
            $this->implementado->CssClass = "fw-bold";
            $this->implementado->CellCssStyle .= "text-align: center;";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->CssClass = "fw-bold";

            // eficaz
            if (strval($this->eficaz->CurrentValue) != "") {
                $this->eficaz->ViewValue = $this->eficaz->optionCaption($this->eficaz->CurrentValue);
            } else {
                $this->eficaz->ViewValue = null;
            }
            $this->eficaz->CssClass = "fw-bold";
            $this->eficaz->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // titulo
            $this->titulo->HrefValue = "";

            // dt_inicio
            $this->dt_inicio->HrefValue = "";

            // detalhamento
            $this->detalhamento->HrefValue = "";

            // impacto
            $this->impacto->HrefValue = "";

            // motivo
            $this->motivo->HrefValue = "";

            // recursos
            $this->recursos->HrefValue = "";

            // prazo_ate
            $this->prazo_ate->HrefValue = "";

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->HrefValue = "";

            // usuario_idusuario
            $this->usuario_idusuario->HrefValue = "";

            // implementado
            $this->implementado->HrefValue = "";

            // status
            $this->status->HrefValue = "";

            // eficaz
            $this->eficaz->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // dt_cadastro

            // titulo
            $this->titulo->setupEditAttributes();
            if (!$this->titulo->Raw) {
                $this->titulo->CurrentValue = HtmlDecode($this->titulo->CurrentValue);
            }
            $this->titulo->EditValue = HtmlEncode($this->titulo->CurrentValue);
            $this->titulo->PlaceHolder = RemoveHtml($this->titulo->caption());

            // dt_inicio
            $this->dt_inicio->setupEditAttributes();
            $this->dt_inicio->EditValue = HtmlEncode(FormatDateTime($this->dt_inicio->CurrentValue, $this->dt_inicio->formatPattern()));
            $this->dt_inicio->PlaceHolder = RemoveHtml($this->dt_inicio->caption());

            // detalhamento
            $this->detalhamento->setupEditAttributes();
            $this->detalhamento->EditValue = HtmlEncode($this->detalhamento->CurrentValue);
            $this->detalhamento->PlaceHolder = RemoveHtml($this->detalhamento->caption());

            // impacto
            $this->impacto->setupEditAttributes();
            $this->impacto->EditValue = HtmlEncode($this->impacto->CurrentValue);
            $this->impacto->PlaceHolder = RemoveHtml($this->impacto->caption());

            // motivo
            $this->motivo->setupEditAttributes();
            $this->motivo->EditValue = HtmlEncode($this->motivo->CurrentValue);
            $this->motivo->PlaceHolder = RemoveHtml($this->motivo->caption());

            // recursos
            $this->recursos->setupEditAttributes();
            $this->recursos->EditValue = $this->recursos->CurrentValue;
            $this->recursos->PlaceHolder = RemoveHtml($this->recursos->caption());
            if (strval($this->recursos->EditValue) != "" && is_numeric($this->recursos->EditValue)) {
                $this->recursos->EditValue = FormatNumber($this->recursos->EditValue, null);
            }

            // prazo_ate
            $this->prazo_ate->setupEditAttributes();
            $this->prazo_ate->EditValue = HtmlEncode(FormatDateTime($this->prazo_ate->CurrentValue, $this->prazo_ate->formatPattern()));
            $this->prazo_ate->PlaceHolder = RemoveHtml($this->prazo_ate->caption());

            // departamentos_iddepartamentos
            $curVal = trim(strval($this->departamentos_iddepartamentos->CurrentValue));
            if ($curVal != "") {
                $this->departamentos_iddepartamentos->ViewValue = $this->departamentos_iddepartamentos->lookupCacheOption($curVal);
            } else {
                $this->departamentos_iddepartamentos->ViewValue = $this->departamentos_iddepartamentos->Lookup !== null && is_array($this->departamentos_iddepartamentos->lookupOptions()) && count($this->departamentos_iddepartamentos->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->departamentos_iddepartamentos->ViewValue !== null) { // Load from cache
                $this->departamentos_iddepartamentos->EditValue = array_values($this->departamentos_iddepartamentos->lookupOptions());
                if ($this->departamentos_iddepartamentos->ViewValue == "") {
                    $this->departamentos_iddepartamentos->ViewValue = $Language->phrase("PleaseSelect");
                }
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
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->departamentos_iddepartamentos->Lookup->renderViewRow($rswrk[0]);
                    $this->departamentos_iddepartamentos->ViewValue = $this->departamentos_iddepartamentos->displayValue($arwrk);
                } else {
                    $this->departamentos_iddepartamentos->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->departamentos_iddepartamentos->EditValue = $arwrk;
            }
            $this->departamentos_iddepartamentos->PlaceHolder = RemoveHtml($this->departamentos_iddepartamentos->caption());

            // usuario_idusuario
            $this->usuario_idusuario->setupEditAttributes();
            $curVal = trim(strval($this->usuario_idusuario->CurrentValue));
            if ($curVal != "") {
                $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->lookupCacheOption($curVal);
            } else {
                $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->Lookup !== null && is_array($this->usuario_idusuario->lookupOptions()) && count($this->usuario_idusuario->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->usuario_idusuario->ViewValue !== null) { // Load from cache
                $this->usuario_idusuario->EditValue = array_values($this->usuario_idusuario->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->usuario_idusuario->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $this->usuario_idusuario->CurrentValue, $this->usuario_idusuario->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                }
                $sqlWrk = $this->usuario_idusuario->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->usuario_idusuario->EditValue = $arwrk;
            }
            $this->usuario_idusuario->PlaceHolder = RemoveHtml($this->usuario_idusuario->caption());

            // implementado
            $this->implementado->EditValue = $this->implementado->options(false);
            $this->implementado->PlaceHolder = RemoveHtml($this->implementado->caption());

            // status
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // eficaz
            $this->eficaz->EditValue = $this->eficaz->options(false);
            $this->eficaz->PlaceHolder = RemoveHtml($this->eficaz->caption());

            // Add refer script

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // titulo
            $this->titulo->HrefValue = "";

            // dt_inicio
            $this->dt_inicio->HrefValue = "";

            // detalhamento
            $this->detalhamento->HrefValue = "";

            // impacto
            $this->impacto->HrefValue = "";

            // motivo
            $this->motivo->HrefValue = "";

            // recursos
            $this->recursos->HrefValue = "";

            // prazo_ate
            $this->prazo_ate->HrefValue = "";

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->HrefValue = "";

            // usuario_idusuario
            $this->usuario_idusuario->HrefValue = "";

            // implementado
            $this->implementado->HrefValue = "";

            // status
            $this->status->HrefValue = "";

            // eficaz
            $this->eficaz->HrefValue = "";
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
            if ($this->titulo->Visible && $this->titulo->Required) {
                if (!$this->titulo->IsDetailKey && EmptyValue($this->titulo->FormValue)) {
                    $this->titulo->addErrorMessage(str_replace("%s", $this->titulo->caption(), $this->titulo->RequiredErrorMessage));
                }
            }
            if ($this->dt_inicio->Visible && $this->dt_inicio->Required) {
                if (!$this->dt_inicio->IsDetailKey && EmptyValue($this->dt_inicio->FormValue)) {
                    $this->dt_inicio->addErrorMessage(str_replace("%s", $this->dt_inicio->caption(), $this->dt_inicio->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->dt_inicio->FormValue, $this->dt_inicio->formatPattern())) {
                $this->dt_inicio->addErrorMessage($this->dt_inicio->getErrorMessage(false));
            }
            if ($this->detalhamento->Visible && $this->detalhamento->Required) {
                if (!$this->detalhamento->IsDetailKey && EmptyValue($this->detalhamento->FormValue)) {
                    $this->detalhamento->addErrorMessage(str_replace("%s", $this->detalhamento->caption(), $this->detalhamento->RequiredErrorMessage));
                }
            }
            if ($this->impacto->Visible && $this->impacto->Required) {
                if (!$this->impacto->IsDetailKey && EmptyValue($this->impacto->FormValue)) {
                    $this->impacto->addErrorMessage(str_replace("%s", $this->impacto->caption(), $this->impacto->RequiredErrorMessage));
                }
            }
            if ($this->motivo->Visible && $this->motivo->Required) {
                if (!$this->motivo->IsDetailKey && EmptyValue($this->motivo->FormValue)) {
                    $this->motivo->addErrorMessage(str_replace("%s", $this->motivo->caption(), $this->motivo->RequiredErrorMessage));
                }
            }
            if ($this->recursos->Visible && $this->recursos->Required) {
                if (!$this->recursos->IsDetailKey && EmptyValue($this->recursos->FormValue)) {
                    $this->recursos->addErrorMessage(str_replace("%s", $this->recursos->caption(), $this->recursos->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->recursos->FormValue)) {
                $this->recursos->addErrorMessage($this->recursos->getErrorMessage(false));
            }
            if ($this->prazo_ate->Visible && $this->prazo_ate->Required) {
                if (!$this->prazo_ate->IsDetailKey && EmptyValue($this->prazo_ate->FormValue)) {
                    $this->prazo_ate->addErrorMessage(str_replace("%s", $this->prazo_ate->caption(), $this->prazo_ate->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->prazo_ate->FormValue, $this->prazo_ate->formatPattern())) {
                $this->prazo_ate->addErrorMessage($this->prazo_ate->getErrorMessage(false));
            }
            if ($this->departamentos_iddepartamentos->Visible && $this->departamentos_iddepartamentos->Required) {
                if (!$this->departamentos_iddepartamentos->IsDetailKey && EmptyValue($this->departamentos_iddepartamentos->FormValue)) {
                    $this->departamentos_iddepartamentos->addErrorMessage(str_replace("%s", $this->departamentos_iddepartamentos->caption(), $this->departamentos_iddepartamentos->RequiredErrorMessage));
                }
            }
            if ($this->usuario_idusuario->Visible && $this->usuario_idusuario->Required) {
                if (!$this->usuario_idusuario->IsDetailKey && EmptyValue($this->usuario_idusuario->FormValue)) {
                    $this->usuario_idusuario->addErrorMessage(str_replace("%s", $this->usuario_idusuario->caption(), $this->usuario_idusuario->RequiredErrorMessage));
                }
            }
            if ($this->implementado->Visible && $this->implementado->Required) {
                if ($this->implementado->FormValue == "") {
                    $this->implementado->addErrorMessage(str_replace("%s", $this->implementado->caption(), $this->implementado->RequiredErrorMessage));
                }
            }
            if ($this->status->Visible && $this->status->Required) {
                if ($this->status->FormValue == "") {
                    $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
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

        // titulo
        $this->titulo->setDbValueDef($rsnew, $this->titulo->CurrentValue, false);

        // dt_inicio
        $this->dt_inicio->setDbValueDef($rsnew, UnFormatDateTime($this->dt_inicio->CurrentValue, $this->dt_inicio->formatPattern()), false);

        // detalhamento
        $this->detalhamento->setDbValueDef($rsnew, $this->detalhamento->CurrentValue, false);

        // impacto
        $this->impacto->setDbValueDef($rsnew, $this->impacto->CurrentValue, false);

        // motivo
        $this->motivo->setDbValueDef($rsnew, $this->motivo->CurrentValue, false);

        // recursos
        $this->recursos->setDbValueDef($rsnew, $this->recursos->CurrentValue, strval($this->recursos->CurrentValue) == "");

        // prazo_ate
        $this->prazo_ate->setDbValueDef($rsnew, UnFormatDateTime($this->prazo_ate->CurrentValue, $this->prazo_ate->formatPattern()), false);

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->setDbValueDef($rsnew, $this->departamentos_iddepartamentos->CurrentValue, false);

        // usuario_idusuario
        $this->usuario_idusuario->setDbValueDef($rsnew, $this->usuario_idusuario->CurrentValue, false);

        // implementado
        $this->implementado->setDbValueDef($rsnew, $this->implementado->CurrentValue, strval($this->implementado->CurrentValue) == "");

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, strval($this->status->CurrentValue) == "");

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
        if (isset($row['dt_cadastro'])) { // dt_cadastro
            $this->dt_cadastro->setFormValue($row['dt_cadastro']);
        }
        if (isset($row['titulo'])) { // titulo
            $this->titulo->setFormValue($row['titulo']);
        }
        if (isset($row['dt_inicio'])) { // dt_inicio
            $this->dt_inicio->setFormValue($row['dt_inicio']);
        }
        if (isset($row['detalhamento'])) { // detalhamento
            $this->detalhamento->setFormValue($row['detalhamento']);
        }
        if (isset($row['impacto'])) { // impacto
            $this->impacto->setFormValue($row['impacto']);
        }
        if (isset($row['motivo'])) { // motivo
            $this->motivo->setFormValue($row['motivo']);
        }
        if (isset($row['recursos'])) { // recursos
            $this->recursos->setFormValue($row['recursos']);
        }
        if (isset($row['prazo_ate'])) { // prazo_ate
            $this->prazo_ate->setFormValue($row['prazo_ate']);
        }
        if (isset($row['departamentos_iddepartamentos'])) { // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->setFormValue($row['departamentos_iddepartamentos']);
        }
        if (isset($row['usuario_idusuario'])) { // usuario_idusuario
            $this->usuario_idusuario->setFormValue($row['usuario_idusuario']);
        }
        if (isset($row['implementado'])) { // implementado
            $this->implementado->setFormValue($row['implementado']);
        }
        if (isset($row['status'])) { // status
            $this->status->setFormValue($row['status']);
        }
        if (isset($row['eficaz'])) { // eficaz
            $this->eficaz->setFormValue($row['eficaz']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("GestaoMudancaList"), "", $this->TableVar, true);
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
                case "x_departamentos_iddepartamentos":
                    break;
                case "x_usuario_idusuario":
                    break;
                case "x_implementado":
                    break;
                case "x_status":
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
}
