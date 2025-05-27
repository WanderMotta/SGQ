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
class PlanoAcaoNcEdit extends PlanoAcaoNc
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "PlanoAcaoNcEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "PlanoAcaoNcEdit";

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
        $this->idplano_acao_nc->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->nao_conformidade_idnao_conformidade->setVisibility();
        $this->o_q_sera_feito->setVisibility();
        $this->efeito_esperado->setVisibility();
        $this->usuario_idusuario->setVisibility();
        $this->recursos_nec->setVisibility();
        $this->dt_limite->setVisibility();
        $this->implementado->setVisibility();
        $this->eficaz->setVisibility();
        $this->evidencia->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'plano_acao_nc';
        $this->TableName = 'plano_acao_nc';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (plano_acao_nc)
        if (!isset($GLOBALS["plano_acao_nc"]) || $GLOBALS["plano_acao_nc"]::class == PROJECT_NAMESPACE . "plano_acao_nc") {
            $GLOBALS["plano_acao_nc"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'plano_acao_nc');
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
                        $result["view"] = SameString($pageName, "PlanoAcaoNcView"); // If View page, no primary button
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
            $key .= @$ar['idplano_acao_nc'];
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
            $this->idplano_acao_nc->Visible = false;
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

        // Create form object
        $CurrentForm = new HttpForm();
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
        $this->setupLookupOptions($this->nao_conformidade_idnao_conformidade);
        $this->setupLookupOptions($this->usuario_idusuario);
        $this->setupLookupOptions($this->implementado);
        $this->setupLookupOptions($this->eficaz);

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
            if (($keyValue = Get("idplano_acao_nc") ?? Key(0) ?? Route(2)) !== null) {
                $this->idplano_acao_nc->setQueryStringValue($keyValue);
                $this->idplano_acao_nc->setOldValue($this->idplano_acao_nc->QueryStringValue);
            } elseif (Post("idplano_acao_nc") !== null) {
                $this->idplano_acao_nc->setFormValue(Post("idplano_acao_nc"));
                $this->idplano_acao_nc->setOldValue($this->idplano_acao_nc->FormValue);
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
                if (($keyValue = Get("idplano_acao_nc") ?? Route("idplano_acao_nc")) !== null) {
                    $this->idplano_acao_nc->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idplano_acao_nc->CurrentValue = null;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

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
                        $this->terminate("PlanoAcaoNcList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = "PlanoAcaoNcList";
                if (GetPageName($returnUrl) == "PlanoAcaoNcList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "PlanoAcaoNcList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "PlanoAcaoNcList"; // Return list page content
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

        // Check field name 'idplano_acao_nc' first before field var 'x_idplano_acao_nc'
        $val = $CurrentForm->hasValue("idplano_acao_nc") ? $CurrentForm->getValue("idplano_acao_nc") : $CurrentForm->getValue("x_idplano_acao_nc");
        if (!$this->idplano_acao_nc->IsDetailKey) {
            $this->idplano_acao_nc->setFormValue($val);
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

        // Check field name 'nao_conformidade_idnao_conformidade' first before field var 'x_nao_conformidade_idnao_conformidade'
        $val = $CurrentForm->hasValue("nao_conformidade_idnao_conformidade") ? $CurrentForm->getValue("nao_conformidade_idnao_conformidade") : $CurrentForm->getValue("x_nao_conformidade_idnao_conformidade");
        if (!$this->nao_conformidade_idnao_conformidade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nao_conformidade_idnao_conformidade->Visible = false; // Disable update for API request
            } else {
                $this->nao_conformidade_idnao_conformidade->setFormValue($val);
            }
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

        // Check field name 'efeito_esperado' first before field var 'x_efeito_esperado'
        $val = $CurrentForm->hasValue("efeito_esperado") ? $CurrentForm->getValue("efeito_esperado") : $CurrentForm->getValue("x_efeito_esperado");
        if (!$this->efeito_esperado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->efeito_esperado->Visible = false; // Disable update for API request
            } else {
                $this->efeito_esperado->setFormValue($val);
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

        // Check field name 'recursos_nec' first before field var 'x_recursos_nec'
        $val = $CurrentForm->hasValue("recursos_nec") ? $CurrentForm->getValue("recursos_nec") : $CurrentForm->getValue("x_recursos_nec");
        if (!$this->recursos_nec->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->recursos_nec->Visible = false; // Disable update for API request
            } else {
                $this->recursos_nec->setFormValue($val, true, $validate);
            }
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

        // Check field name 'implementado' first before field var 'x_implementado'
        $val = $CurrentForm->hasValue("implementado") ? $CurrentForm->getValue("implementado") : $CurrentForm->getValue("x_implementado");
        if (!$this->implementado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->implementado->Visible = false; // Disable update for API request
            } else {
                $this->implementado->setFormValue($val);
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

        // Check field name 'evidencia' first before field var 'x_evidencia'
        $val = $CurrentForm->hasValue("evidencia") ? $CurrentForm->getValue("evidencia") : $CurrentForm->getValue("x_evidencia");
        if (!$this->evidencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->evidencia->Visible = false; // Disable update for API request
            } else {
                $this->evidencia->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idplano_acao_nc->CurrentValue = $this->idplano_acao_nc->FormValue;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->nao_conformidade_idnao_conformidade->CurrentValue = $this->nao_conformidade_idnao_conformidade->FormValue;
        $this->o_q_sera_feito->CurrentValue = $this->o_q_sera_feito->FormValue;
        $this->efeito_esperado->CurrentValue = $this->efeito_esperado->FormValue;
        $this->usuario_idusuario->CurrentValue = $this->usuario_idusuario->FormValue;
        $this->recursos_nec->CurrentValue = $this->recursos_nec->FormValue;
        $this->dt_limite->CurrentValue = $this->dt_limite->FormValue;
        $this->dt_limite->CurrentValue = UnFormatDateTime($this->dt_limite->CurrentValue, $this->dt_limite->formatPattern());
        $this->implementado->CurrentValue = $this->implementado->FormValue;
        $this->eficaz->CurrentValue = $this->eficaz->FormValue;
        $this->evidencia->CurrentValue = $this->evidencia->FormValue;
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
        $this->idplano_acao_nc->setDbValue($row['idplano_acao_nc']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->nao_conformidade_idnao_conformidade->setDbValue($row['nao_conformidade_idnao_conformidade']);
        $this->o_q_sera_feito->setDbValue($row['o_q_sera_feito']);
        $this->efeito_esperado->setDbValue($row['efeito_esperado']);
        $this->usuario_idusuario->setDbValue($row['usuario_idusuario']);
        $this->recursos_nec->setDbValue($row['recursos_nec']);
        $this->dt_limite->setDbValue($row['dt_limite']);
        $this->implementado->setDbValue($row['implementado']);
        $this->eficaz->setDbValue($row['eficaz']);
        $this->evidencia->setDbValue($row['evidencia']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idplano_acao_nc'] = $this->idplano_acao_nc->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['nao_conformidade_idnao_conformidade'] = $this->nao_conformidade_idnao_conformidade->DefaultValue;
        $row['o_q_sera_feito'] = $this->o_q_sera_feito->DefaultValue;
        $row['efeito_esperado'] = $this->efeito_esperado->DefaultValue;
        $row['usuario_idusuario'] = $this->usuario_idusuario->DefaultValue;
        $row['recursos_nec'] = $this->recursos_nec->DefaultValue;
        $row['dt_limite'] = $this->dt_limite->DefaultValue;
        $row['implementado'] = $this->implementado->DefaultValue;
        $row['eficaz'] = $this->eficaz->DefaultValue;
        $row['evidencia'] = $this->evidencia->DefaultValue;
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

        // idplano_acao_nc
        $this->idplano_acao_nc->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // nao_conformidade_idnao_conformidade
        $this->nao_conformidade_idnao_conformidade->RowCssClass = "row";

        // o_q_sera_feito
        $this->o_q_sera_feito->RowCssClass = "row";

        // efeito_esperado
        $this->efeito_esperado->RowCssClass = "row";

        // usuario_idusuario
        $this->usuario_idusuario->RowCssClass = "row";

        // recursos_nec
        $this->recursos_nec->RowCssClass = "row";

        // dt_limite
        $this->dt_limite->RowCssClass = "row";

        // implementado
        $this->implementado->RowCssClass = "row";

        // eficaz
        $this->eficaz->RowCssClass = "row";

        // evidencia
        $this->evidencia->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idplano_acao_nc
            $this->idplano_acao_nc->ViewValue = $this->idplano_acao_nc->CurrentValue;
            $this->idplano_acao_nc->ViewValue = FormatNumber($this->idplano_acao_nc->ViewValue, $this->idplano_acao_nc->formatPattern());
            $this->idplano_acao_nc->CssClass = "fw-bold";
            $this->idplano_acao_nc->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // nao_conformidade_idnao_conformidade
            $curVal = strval($this->nao_conformidade_idnao_conformidade->CurrentValue);
            if ($curVal != "") {
                $this->nao_conformidade_idnao_conformidade->ViewValue = $this->nao_conformidade_idnao_conformidade->lookupCacheOption($curVal);
                if ($this->nao_conformidade_idnao_conformidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->nao_conformidade_idnao_conformidade->Lookup->getTable()->Fields["idnao_conformidade"]->searchExpression(), "=", $curVal, $this->nao_conformidade_idnao_conformidade->Lookup->getTable()->Fields["idnao_conformidade"]->searchDataType(), "");
                    $sqlWrk = $this->nao_conformidade_idnao_conformidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->nao_conformidade_idnao_conformidade->Lookup->renderViewRow($rswrk[0]);
                        $this->nao_conformidade_idnao_conformidade->ViewValue = $this->nao_conformidade_idnao_conformidade->displayValue($arwrk);
                    } else {
                        $this->nao_conformidade_idnao_conformidade->ViewValue = FormatNumber($this->nao_conformidade_idnao_conformidade->CurrentValue, $this->nao_conformidade_idnao_conformidade->formatPattern());
                    }
                }
            } else {
                $this->nao_conformidade_idnao_conformidade->ViewValue = null;
            }
            $this->nao_conformidade_idnao_conformidade->CssClass = "fw-bold";

            // o_q_sera_feito
            $this->o_q_sera_feito->ViewValue = $this->o_q_sera_feito->CurrentValue;
            $this->o_q_sera_feito->CssClass = "fw-bold";

            // efeito_esperado
            $this->efeito_esperado->ViewValue = $this->efeito_esperado->CurrentValue;
            $this->efeito_esperado->CssClass = "fw-bold";

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

            // eficaz
            if (strval($this->eficaz->CurrentValue) != "") {
                $this->eficaz->ViewValue = $this->eficaz->optionCaption($this->eficaz->CurrentValue);
            } else {
                $this->eficaz->ViewValue = null;
            }
            $this->eficaz->CssClass = "fw-bold";
            $this->eficaz->CellCssStyle .= "text-align: center;";

            // evidencia
            $this->evidencia->ViewValue = $this->evidencia->CurrentValue;
            $this->evidencia->CssClass = "fw-bold";

            // idplano_acao_nc
            $this->idplano_acao_nc->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // nao_conformidade_idnao_conformidade
            $this->nao_conformidade_idnao_conformidade->HrefValue = "";

            // o_q_sera_feito
            $this->o_q_sera_feito->HrefValue = "";

            // efeito_esperado
            $this->efeito_esperado->HrefValue = "";

            // usuario_idusuario
            $this->usuario_idusuario->HrefValue = "";

            // recursos_nec
            $this->recursos_nec->HrefValue = "";

            // dt_limite
            $this->dt_limite->HrefValue = "";

            // implementado
            $this->implementado->HrefValue = "";

            // eficaz
            $this->eficaz->HrefValue = "";

            // evidencia
            $this->evidencia->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // idplano_acao_nc
            $this->idplano_acao_nc->setupEditAttributes();
            $this->idplano_acao_nc->EditValue = $this->idplano_acao_nc->CurrentValue;
            $this->idplano_acao_nc->EditValue = FormatNumber($this->idplano_acao_nc->EditValue, $this->idplano_acao_nc->formatPattern());
            $this->idplano_acao_nc->CssClass = "fw-bold";
            $this->idplano_acao_nc->CellCssStyle .= "text-align: center;";

            // dt_cadastro

            // nao_conformidade_idnao_conformidade
            $this->nao_conformidade_idnao_conformidade->setupEditAttributes();
            if ($this->nao_conformidade_idnao_conformidade->getSessionValue() != "") {
                $this->nao_conformidade_idnao_conformidade->CurrentValue = GetForeignKeyValue($this->nao_conformidade_idnao_conformidade->getSessionValue());
                $curVal = strval($this->nao_conformidade_idnao_conformidade->CurrentValue);
                if ($curVal != "") {
                    $this->nao_conformidade_idnao_conformidade->ViewValue = $this->nao_conformidade_idnao_conformidade->lookupCacheOption($curVal);
                    if ($this->nao_conformidade_idnao_conformidade->ViewValue === null) { // Lookup from database
                        $filterWrk = SearchFilter($this->nao_conformidade_idnao_conformidade->Lookup->getTable()->Fields["idnao_conformidade"]->searchExpression(), "=", $curVal, $this->nao_conformidade_idnao_conformidade->Lookup->getTable()->Fields["idnao_conformidade"]->searchDataType(), "");
                        $sqlWrk = $this->nao_conformidade_idnao_conformidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCache($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->nao_conformidade_idnao_conformidade->Lookup->renderViewRow($rswrk[0]);
                            $this->nao_conformidade_idnao_conformidade->ViewValue = $this->nao_conformidade_idnao_conformidade->displayValue($arwrk);
                        } else {
                            $this->nao_conformidade_idnao_conformidade->ViewValue = FormatNumber($this->nao_conformidade_idnao_conformidade->CurrentValue, $this->nao_conformidade_idnao_conformidade->formatPattern());
                        }
                    }
                } else {
                    $this->nao_conformidade_idnao_conformidade->ViewValue = null;
                }
                $this->nao_conformidade_idnao_conformidade->CssClass = "fw-bold";
            } else {
                $curVal = trim(strval($this->nao_conformidade_idnao_conformidade->CurrentValue));
                if ($curVal != "") {
                    $this->nao_conformidade_idnao_conformidade->ViewValue = $this->nao_conformidade_idnao_conformidade->lookupCacheOption($curVal);
                } else {
                    $this->nao_conformidade_idnao_conformidade->ViewValue = $this->nao_conformidade_idnao_conformidade->Lookup !== null && is_array($this->nao_conformidade_idnao_conformidade->lookupOptions()) && count($this->nao_conformidade_idnao_conformidade->lookupOptions()) > 0 ? $curVal : null;
                }
                if ($this->nao_conformidade_idnao_conformidade->ViewValue !== null) { // Load from cache
                    $this->nao_conformidade_idnao_conformidade->EditValue = array_values($this->nao_conformidade_idnao_conformidade->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = SearchFilter($this->nao_conformidade_idnao_conformidade->Lookup->getTable()->Fields["idnao_conformidade"]->searchExpression(), "=", $this->nao_conformidade_idnao_conformidade->CurrentValue, $this->nao_conformidade_idnao_conformidade->Lookup->getTable()->Fields["idnao_conformidade"]->searchDataType(), "");
                    }
                    $sqlWrk = $this->nao_conformidade_idnao_conformidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->nao_conformidade_idnao_conformidade->EditValue = $arwrk;
                }
                $this->nao_conformidade_idnao_conformidade->PlaceHolder = RemoveHtml($this->nao_conformidade_idnao_conformidade->caption());
            }

            // o_q_sera_feito
            $this->o_q_sera_feito->setupEditAttributes();
            $this->o_q_sera_feito->EditValue = HtmlEncode($this->o_q_sera_feito->CurrentValue);
            $this->o_q_sera_feito->PlaceHolder = RemoveHtml($this->o_q_sera_feito->caption());

            // efeito_esperado
            $this->efeito_esperado->setupEditAttributes();
            $this->efeito_esperado->EditValue = HtmlEncode($this->efeito_esperado->CurrentValue);
            $this->efeito_esperado->PlaceHolder = RemoveHtml($this->efeito_esperado->caption());

            // usuario_idusuario
            $curVal = trim(strval($this->usuario_idusuario->CurrentValue));
            if ($curVal != "") {
                $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->lookupCacheOption($curVal);
            } else {
                $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->Lookup !== null && is_array($this->usuario_idusuario->lookupOptions()) && count($this->usuario_idusuario->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->usuario_idusuario->ViewValue !== null) { // Load from cache
                $this->usuario_idusuario->EditValue = array_values($this->usuario_idusuario->lookupOptions());
                if ($this->usuario_idusuario->ViewValue == "") {
                    $this->usuario_idusuario->ViewValue = $Language->phrase("PleaseSelect");
                }
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
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->usuario_idusuario->Lookup->renderViewRow($rswrk[0]);
                    $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->displayValue($arwrk);
                } else {
                    $this->usuario_idusuario->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->usuario_idusuario->EditValue = $arwrk;
            }
            $this->usuario_idusuario->PlaceHolder = RemoveHtml($this->usuario_idusuario->caption());

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

            // eficaz
            $this->eficaz->EditValue = $this->eficaz->options(false);
            $this->eficaz->PlaceHolder = RemoveHtml($this->eficaz->caption());

            // evidencia
            $this->evidencia->setupEditAttributes();
            $this->evidencia->EditValue = HtmlEncode($this->evidencia->CurrentValue);
            $this->evidencia->PlaceHolder = RemoveHtml($this->evidencia->caption());

            // Edit refer script

            // idplano_acao_nc
            $this->idplano_acao_nc->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // nao_conformidade_idnao_conformidade
            $this->nao_conformidade_idnao_conformidade->HrefValue = "";

            // o_q_sera_feito
            $this->o_q_sera_feito->HrefValue = "";

            // efeito_esperado
            $this->efeito_esperado->HrefValue = "";

            // usuario_idusuario
            $this->usuario_idusuario->HrefValue = "";

            // recursos_nec
            $this->recursos_nec->HrefValue = "";

            // dt_limite
            $this->dt_limite->HrefValue = "";

            // implementado
            $this->implementado->HrefValue = "";

            // eficaz
            $this->eficaz->HrefValue = "";

            // evidencia
            $this->evidencia->HrefValue = "";
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
            if ($this->idplano_acao_nc->Visible && $this->idplano_acao_nc->Required) {
                if (!$this->idplano_acao_nc->IsDetailKey && EmptyValue($this->idplano_acao_nc->FormValue)) {
                    $this->idplano_acao_nc->addErrorMessage(str_replace("%s", $this->idplano_acao_nc->caption(), $this->idplano_acao_nc->RequiredErrorMessage));
                }
            }
            if ($this->dt_cadastro->Visible && $this->dt_cadastro->Required) {
                if (!$this->dt_cadastro->IsDetailKey && EmptyValue($this->dt_cadastro->FormValue)) {
                    $this->dt_cadastro->addErrorMessage(str_replace("%s", $this->dt_cadastro->caption(), $this->dt_cadastro->RequiredErrorMessage));
                }
            }
            if ($this->nao_conformidade_idnao_conformidade->Visible && $this->nao_conformidade_idnao_conformidade->Required) {
                if (!$this->nao_conformidade_idnao_conformidade->IsDetailKey && EmptyValue($this->nao_conformidade_idnao_conformidade->FormValue)) {
                    $this->nao_conformidade_idnao_conformidade->addErrorMessage(str_replace("%s", $this->nao_conformidade_idnao_conformidade->caption(), $this->nao_conformidade_idnao_conformidade->RequiredErrorMessage));
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
            if ($this->usuario_idusuario->Visible && $this->usuario_idusuario->Required) {
                if (!$this->usuario_idusuario->IsDetailKey && EmptyValue($this->usuario_idusuario->FormValue)) {
                    $this->usuario_idusuario->addErrorMessage(str_replace("%s", $this->usuario_idusuario->caption(), $this->usuario_idusuario->RequiredErrorMessage));
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
            if ($this->eficaz->Visible && $this->eficaz->Required) {
                if ($this->eficaz->FormValue == "") {
                    $this->eficaz->addErrorMessage(str_replace("%s", $this->eficaz->caption(), $this->eficaz->RequiredErrorMessage));
                }
            }
            if ($this->evidencia->Visible && $this->evidencia->Required) {
                if (!$this->evidencia->IsDetailKey && EmptyValue($this->evidencia->FormValue)) {
                    $this->evidencia->addErrorMessage(str_replace("%s", $this->evidencia->caption(), $this->evidencia->RequiredErrorMessage));
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

        // Check referential integrity for master table 'nao_conformidade'
        $detailKeys = [];
        $keyValue = $rsnew['nao_conformidade_idnao_conformidade'] ?? $rsold['nao_conformidade_idnao_conformidade'];
        $detailKeys['nao_conformidade_idnao_conformidade'] = $keyValue;
        $masterTable = Container("nao_conformidade");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "nao_conformidade", $Language->phrase("RelatedRecordRequired"));
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

        // nao_conformidade_idnao_conformidade
        if ($this->nao_conformidade_idnao_conformidade->getSessionValue() != "") {
            $this->nao_conformidade_idnao_conformidade->ReadOnly = true;
        }
        $this->nao_conformidade_idnao_conformidade->setDbValueDef($rsnew, $this->nao_conformidade_idnao_conformidade->CurrentValue, $this->nao_conformidade_idnao_conformidade->ReadOnly);

        // o_q_sera_feito
        $this->o_q_sera_feito->setDbValueDef($rsnew, $this->o_q_sera_feito->CurrentValue, $this->o_q_sera_feito->ReadOnly);

        // efeito_esperado
        $this->efeito_esperado->setDbValueDef($rsnew, $this->efeito_esperado->CurrentValue, $this->efeito_esperado->ReadOnly);

        // usuario_idusuario
        $this->usuario_idusuario->setDbValueDef($rsnew, $this->usuario_idusuario->CurrentValue, $this->usuario_idusuario->ReadOnly);

        // recursos_nec
        $this->recursos_nec->setDbValueDef($rsnew, $this->recursos_nec->CurrentValue, $this->recursos_nec->ReadOnly);

        // dt_limite
        $this->dt_limite->setDbValueDef($rsnew, UnFormatDateTime($this->dt_limite->CurrentValue, $this->dt_limite->formatPattern()), $this->dt_limite->ReadOnly);

        // implementado
        $this->implementado->setDbValueDef($rsnew, $this->implementado->CurrentValue, $this->implementado->ReadOnly);

        // eficaz
        $this->eficaz->setDbValueDef($rsnew, $this->eficaz->CurrentValue, $this->eficaz->ReadOnly);

        // evidencia
        $this->evidencia->setDbValueDef($rsnew, $this->evidencia->CurrentValue, $this->evidencia->ReadOnly);
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
        if (isset($row['nao_conformidade_idnao_conformidade'])) { // nao_conformidade_idnao_conformidade
            $this->nao_conformidade_idnao_conformidade->CurrentValue = $row['nao_conformidade_idnao_conformidade'];
        }
        if (isset($row['o_q_sera_feito'])) { // o_q_sera_feito
            $this->o_q_sera_feito->CurrentValue = $row['o_q_sera_feito'];
        }
        if (isset($row['efeito_esperado'])) { // efeito_esperado
            $this->efeito_esperado->CurrentValue = $row['efeito_esperado'];
        }
        if (isset($row['usuario_idusuario'])) { // usuario_idusuario
            $this->usuario_idusuario->CurrentValue = $row['usuario_idusuario'];
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
        if (isset($row['eficaz'])) { // eficaz
            $this->eficaz->CurrentValue = $row['eficaz'];
        }
        if (isset($row['evidencia'])) { // evidencia
            $this->evidencia->CurrentValue = $row['evidencia'];
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
            if ($masterTblVar == "nao_conformidade") {
                $validMaster = true;
                $masterTbl = Container("nao_conformidade");
                if (($parm = Get("fk_idnao_conformidade", Get("nao_conformidade_idnao_conformidade"))) !== null) {
                    $masterTbl->idnao_conformidade->setQueryStringValue($parm);
                    $this->nao_conformidade_idnao_conformidade->QueryStringValue = $masterTbl->idnao_conformidade->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->nao_conformidade_idnao_conformidade->setSessionValue($this->nao_conformidade_idnao_conformidade->QueryStringValue);
                    $foreignKeys["nao_conformidade_idnao_conformidade"] = $this->nao_conformidade_idnao_conformidade->QueryStringValue;
                    if (!is_numeric($masterTbl->idnao_conformidade->QueryStringValue)) {
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
            if ($masterTblVar == "nao_conformidade") {
                $validMaster = true;
                $masterTbl = Container("nao_conformidade");
                if (($parm = Post("fk_idnao_conformidade", Post("nao_conformidade_idnao_conformidade"))) !== null) {
                    $masterTbl->idnao_conformidade->setFormValue($parm);
                    $this->nao_conformidade_idnao_conformidade->FormValue = $masterTbl->idnao_conformidade->FormValue;
                    $this->nao_conformidade_idnao_conformidade->setSessionValue($this->nao_conformidade_idnao_conformidade->FormValue);
                    $foreignKeys["nao_conformidade_idnao_conformidade"] = $this->nao_conformidade_idnao_conformidade->FormValue;
                    if (!is_numeric($masterTbl->idnao_conformidade->FormValue)) {
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
            $this->setSessionWhere($this->getDetailFilterFromSession());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "nao_conformidade") {
                if (!array_key_exists("nao_conformidade_idnao_conformidade", $foreignKeys)) { // Not current foreign key
                    $this->nao_conformidade_idnao_conformidade->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PlanoAcaoNcList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_nao_conformidade_idnao_conformidade":
                    break;
                case "x_usuario_idusuario":
                    break;
                case "x_implementado":
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
