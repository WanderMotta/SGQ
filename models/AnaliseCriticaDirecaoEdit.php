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
class AnaliseCriticaDirecaoEdit extends AnaliseCriticaDirecao
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "AnaliseCriticaDirecaoEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "AnaliseCriticaDirecaoEdit";

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
        $this->idanalise_critica_direcao->setVisibility();
        $this->data->setVisibility();
        $this->participantes->setVisibility();
        $this->usuario_idusuario->setVisibility();
        $this->situacao_anterior->setVisibility();
        $this->mudanca_sqg->setVisibility();
        $this->desempenho_eficacia->setVisibility();
        $this->satisfacao_cliente->setVisibility();
        $this->objetivos_alcancados->setVisibility();
        $this->desempenho_processo->setVisibility();
        $this->nao_confomidade_acoes_corretivas->setVisibility();
        $this->monitoramento_medicao->setVisibility();
        $this->resultado_auditoria->setVisibility();
        $this->desempenho_provedores_ext->setVisibility();
        $this->suficiencia_recursos->setVisibility();
        $this->acoes_risco_oportunidades->setVisibility();
        $this->oportunidade_melhora_entrada->setVisibility();
        $this->oportunidade_melhora_saida->setVisibility();
        $this->qualquer_mudanca_sgq->setVisibility();
        $this->nec_recurso->setVisibility();
        $this->anexo->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'analise_critica_direcao';
        $this->TableName = 'analise_critica_direcao';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (analise_critica_direcao)
        if (!isset($GLOBALS["analise_critica_direcao"]) || $GLOBALS["analise_critica_direcao"]::class == PROJECT_NAMESPACE . "analise_critica_direcao") {
            $GLOBALS["analise_critica_direcao"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'analise_critica_direcao');
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
                        $result["view"] = SameString($pageName, "AnaliseCriticaDirecaoView"); // If View page, no primary button
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
            $key .= @$ar['idanalise_critica_direcao'];
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
            $this->idanalise_critica_direcao->Visible = false;
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
        $this->setupLookupOptions($this->participantes);
        $this->setupLookupOptions($this->usuario_idusuario);

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
            if (($keyValue = Get("idanalise_critica_direcao") ?? Key(0) ?? Route(2)) !== null) {
                $this->idanalise_critica_direcao->setQueryStringValue($keyValue);
                $this->idanalise_critica_direcao->setOldValue($this->idanalise_critica_direcao->QueryStringValue);
            } elseif (Post("idanalise_critica_direcao") !== null) {
                $this->idanalise_critica_direcao->setFormValue(Post("idanalise_critica_direcao"));
                $this->idanalise_critica_direcao->setOldValue($this->idanalise_critica_direcao->FormValue);
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
                if (($keyValue = Get("idanalise_critica_direcao") ?? Route("idanalise_critica_direcao")) !== null) {
                    $this->idanalise_critica_direcao->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idanalise_critica_direcao->CurrentValue = null;
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
                        $this->terminate("AnaliseCriticaDirecaoList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "AnaliseCriticaDirecaoList") {
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
                        if (GetPageName($returnUrl) != "AnaliseCriticaDirecaoList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "AnaliseCriticaDirecaoList"; // Return list page content
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
        $this->anexo->Upload->Index = $CurrentForm->Index;
        $this->anexo->Upload->uploadFile();
        $this->anexo->CurrentValue = $this->anexo->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'idanalise_critica_direcao' first before field var 'x_idanalise_critica_direcao'
        $val = $CurrentForm->hasValue("idanalise_critica_direcao") ? $CurrentForm->getValue("idanalise_critica_direcao") : $CurrentForm->getValue("x_idanalise_critica_direcao");
        if (!$this->idanalise_critica_direcao->IsDetailKey) {
            $this->idanalise_critica_direcao->setFormValue($val);
        }

        // Check field name 'data' first before field var 'x_data'
        $val = $CurrentForm->hasValue("data") ? $CurrentForm->getValue("data") : $CurrentForm->getValue("x_data");
        if (!$this->data->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->data->Visible = false; // Disable update for API request
            } else {
                $this->data->setFormValue($val, true, $validate);
            }
            $this->data->CurrentValue = UnFormatDateTime($this->data->CurrentValue, $this->data->formatPattern());
        }

        // Check field name 'participantes' first before field var 'x_participantes'
        $val = $CurrentForm->hasValue("participantes") ? $CurrentForm->getValue("participantes") : $CurrentForm->getValue("x_participantes");
        if (!$this->participantes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->participantes->Visible = false; // Disable update for API request
            } else {
                $this->participantes->setFormValue($val);
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

        // Check field name 'situacao_anterior' first before field var 'x_situacao_anterior'
        $val = $CurrentForm->hasValue("situacao_anterior") ? $CurrentForm->getValue("situacao_anterior") : $CurrentForm->getValue("x_situacao_anterior");
        if (!$this->situacao_anterior->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->situacao_anterior->Visible = false; // Disable update for API request
            } else {
                $this->situacao_anterior->setFormValue($val);
            }
        }

        // Check field name 'mudanca_sqg' first before field var 'x_mudanca_sqg'
        $val = $CurrentForm->hasValue("mudanca_sqg") ? $CurrentForm->getValue("mudanca_sqg") : $CurrentForm->getValue("x_mudanca_sqg");
        if (!$this->mudanca_sqg->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mudanca_sqg->Visible = false; // Disable update for API request
            } else {
                $this->mudanca_sqg->setFormValue($val);
            }
        }

        // Check field name 'desempenho_eficacia' first before field var 'x_desempenho_eficacia'
        $val = $CurrentForm->hasValue("desempenho_eficacia") ? $CurrentForm->getValue("desempenho_eficacia") : $CurrentForm->getValue("x_desempenho_eficacia");
        if (!$this->desempenho_eficacia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->desempenho_eficacia->Visible = false; // Disable update for API request
            } else {
                $this->desempenho_eficacia->setFormValue($val);
            }
        }

        // Check field name 'satisfacao_cliente' first before field var 'x_satisfacao_cliente'
        $val = $CurrentForm->hasValue("satisfacao_cliente") ? $CurrentForm->getValue("satisfacao_cliente") : $CurrentForm->getValue("x_satisfacao_cliente");
        if (!$this->satisfacao_cliente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->satisfacao_cliente->Visible = false; // Disable update for API request
            } else {
                $this->satisfacao_cliente->setFormValue($val);
            }
        }

        // Check field name 'objetivos_alcançados' first before field var 'x_objetivos_alcancados'
        $val = $CurrentForm->hasValue("objetivos_alcançados") ? $CurrentForm->getValue("objetivos_alcançados") : $CurrentForm->getValue("x_objetivos_alcancados");
        if (!$this->objetivos_alcancados->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->objetivos_alcancados->Visible = false; // Disable update for API request
            } else {
                $this->objetivos_alcancados->setFormValue($val);
            }
        }

        // Check field name 'desempenho_processo' first before field var 'x_desempenho_processo'
        $val = $CurrentForm->hasValue("desempenho_processo") ? $CurrentForm->getValue("desempenho_processo") : $CurrentForm->getValue("x_desempenho_processo");
        if (!$this->desempenho_processo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->desempenho_processo->Visible = false; // Disable update for API request
            } else {
                $this->desempenho_processo->setFormValue($val);
            }
        }

        // Check field name 'nao_confomidade_acoes_corretivas' first before field var 'x_nao_confomidade_acoes_corretivas'
        $val = $CurrentForm->hasValue("nao_confomidade_acoes_corretivas") ? $CurrentForm->getValue("nao_confomidade_acoes_corretivas") : $CurrentForm->getValue("x_nao_confomidade_acoes_corretivas");
        if (!$this->nao_confomidade_acoes_corretivas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nao_confomidade_acoes_corretivas->Visible = false; // Disable update for API request
            } else {
                $this->nao_confomidade_acoes_corretivas->setFormValue($val);
            }
        }

        // Check field name 'monitoramento_medicao' first before field var 'x_monitoramento_medicao'
        $val = $CurrentForm->hasValue("monitoramento_medicao") ? $CurrentForm->getValue("monitoramento_medicao") : $CurrentForm->getValue("x_monitoramento_medicao");
        if (!$this->monitoramento_medicao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monitoramento_medicao->Visible = false; // Disable update for API request
            } else {
                $this->monitoramento_medicao->setFormValue($val);
            }
        }

        // Check field name 'resultado_auditoria' first before field var 'x_resultado_auditoria'
        $val = $CurrentForm->hasValue("resultado_auditoria") ? $CurrentForm->getValue("resultado_auditoria") : $CurrentForm->getValue("x_resultado_auditoria");
        if (!$this->resultado_auditoria->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->resultado_auditoria->Visible = false; // Disable update for API request
            } else {
                $this->resultado_auditoria->setFormValue($val);
            }
        }

        // Check field name 'desempenho_provedores_ext' first before field var 'x_desempenho_provedores_ext'
        $val = $CurrentForm->hasValue("desempenho_provedores_ext") ? $CurrentForm->getValue("desempenho_provedores_ext") : $CurrentForm->getValue("x_desempenho_provedores_ext");
        if (!$this->desempenho_provedores_ext->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->desempenho_provedores_ext->Visible = false; // Disable update for API request
            } else {
                $this->desempenho_provedores_ext->setFormValue($val);
            }
        }

        // Check field name 'suficiencia_recursos' first before field var 'x_suficiencia_recursos'
        $val = $CurrentForm->hasValue("suficiencia_recursos") ? $CurrentForm->getValue("suficiencia_recursos") : $CurrentForm->getValue("x_suficiencia_recursos");
        if (!$this->suficiencia_recursos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->suficiencia_recursos->Visible = false; // Disable update for API request
            } else {
                $this->suficiencia_recursos->setFormValue($val);
            }
        }

        // Check field name 'acoes_risco_oportunidades' first before field var 'x_acoes_risco_oportunidades'
        $val = $CurrentForm->hasValue("acoes_risco_oportunidades") ? $CurrentForm->getValue("acoes_risco_oportunidades") : $CurrentForm->getValue("x_acoes_risco_oportunidades");
        if (!$this->acoes_risco_oportunidades->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->acoes_risco_oportunidades->Visible = false; // Disable update for API request
            } else {
                $this->acoes_risco_oportunidades->setFormValue($val);
            }
        }

        // Check field name 'oportunidade_melhora_entrada' first before field var 'x_oportunidade_melhora_entrada'
        $val = $CurrentForm->hasValue("oportunidade_melhora_entrada") ? $CurrentForm->getValue("oportunidade_melhora_entrada") : $CurrentForm->getValue("x_oportunidade_melhora_entrada");
        if (!$this->oportunidade_melhora_entrada->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->oportunidade_melhora_entrada->Visible = false; // Disable update for API request
            } else {
                $this->oportunidade_melhora_entrada->setFormValue($val);
            }
        }

        // Check field name 'oportunidade_melhora_saida' first before field var 'x_oportunidade_melhora_saida'
        $val = $CurrentForm->hasValue("oportunidade_melhora_saida") ? $CurrentForm->getValue("oportunidade_melhora_saida") : $CurrentForm->getValue("x_oportunidade_melhora_saida");
        if (!$this->oportunidade_melhora_saida->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->oportunidade_melhora_saida->Visible = false; // Disable update for API request
            } else {
                $this->oportunidade_melhora_saida->setFormValue($val);
            }
        }

        // Check field name 'qualquer_mudanca_sgq' first before field var 'x_qualquer_mudanca_sgq'
        $val = $CurrentForm->hasValue("qualquer_mudanca_sgq") ? $CurrentForm->getValue("qualquer_mudanca_sgq") : $CurrentForm->getValue("x_qualquer_mudanca_sgq");
        if (!$this->qualquer_mudanca_sgq->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->qualquer_mudanca_sgq->Visible = false; // Disable update for API request
            } else {
                $this->qualquer_mudanca_sgq->setFormValue($val);
            }
        }

        // Check field name 'nec_recurso' first before field var 'x_nec_recurso'
        $val = $CurrentForm->hasValue("nec_recurso") ? $CurrentForm->getValue("nec_recurso") : $CurrentForm->getValue("x_nec_recurso");
        if (!$this->nec_recurso->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nec_recurso->Visible = false; // Disable update for API request
            } else {
                $this->nec_recurso->setFormValue($val);
            }
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idanalise_critica_direcao->CurrentValue = $this->idanalise_critica_direcao->FormValue;
        $this->data->CurrentValue = $this->data->FormValue;
        $this->data->CurrentValue = UnFormatDateTime($this->data->CurrentValue, $this->data->formatPattern());
        $this->participantes->CurrentValue = $this->participantes->FormValue;
        $this->usuario_idusuario->CurrentValue = $this->usuario_idusuario->FormValue;
        $this->situacao_anterior->CurrentValue = $this->situacao_anterior->FormValue;
        $this->mudanca_sqg->CurrentValue = $this->mudanca_sqg->FormValue;
        $this->desempenho_eficacia->CurrentValue = $this->desempenho_eficacia->FormValue;
        $this->satisfacao_cliente->CurrentValue = $this->satisfacao_cliente->FormValue;
        $this->objetivos_alcancados->CurrentValue = $this->objetivos_alcancados->FormValue;
        $this->desempenho_processo->CurrentValue = $this->desempenho_processo->FormValue;
        $this->nao_confomidade_acoes_corretivas->CurrentValue = $this->nao_confomidade_acoes_corretivas->FormValue;
        $this->monitoramento_medicao->CurrentValue = $this->monitoramento_medicao->FormValue;
        $this->resultado_auditoria->CurrentValue = $this->resultado_auditoria->FormValue;
        $this->desempenho_provedores_ext->CurrentValue = $this->desempenho_provedores_ext->FormValue;
        $this->suficiencia_recursos->CurrentValue = $this->suficiencia_recursos->FormValue;
        $this->acoes_risco_oportunidades->CurrentValue = $this->acoes_risco_oportunidades->FormValue;
        $this->oportunidade_melhora_entrada->CurrentValue = $this->oportunidade_melhora_entrada->FormValue;
        $this->oportunidade_melhora_saida->CurrentValue = $this->oportunidade_melhora_saida->FormValue;
        $this->qualquer_mudanca_sgq->CurrentValue = $this->qualquer_mudanca_sgq->FormValue;
        $this->nec_recurso->CurrentValue = $this->nec_recurso->FormValue;
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
        $this->idanalise_critica_direcao->setDbValue($row['idanalise_critica_direcao']);
        $this->data->setDbValue($row['data']);
        $this->participantes->setDbValue($row['participantes']);
        $this->usuario_idusuario->setDbValue($row['usuario_idusuario']);
        $this->situacao_anterior->setDbValue($row['situacao_anterior']);
        $this->mudanca_sqg->setDbValue($row['mudanca_sqg']);
        $this->desempenho_eficacia->setDbValue($row['desempenho_eficacia']);
        $this->satisfacao_cliente->setDbValue($row['satisfacao_cliente']);
        $this->objetivos_alcancados->setDbValue($row['objetivos_alcançados']);
        $this->desempenho_processo->setDbValue($row['desempenho_processo']);
        $this->nao_confomidade_acoes_corretivas->setDbValue($row['nao_confomidade_acoes_corretivas']);
        $this->monitoramento_medicao->setDbValue($row['monitoramento_medicao']);
        $this->resultado_auditoria->setDbValue($row['resultado_auditoria']);
        $this->desempenho_provedores_ext->setDbValue($row['desempenho_provedores_ext']);
        $this->suficiencia_recursos->setDbValue($row['suficiencia_recursos']);
        $this->acoes_risco_oportunidades->setDbValue($row['acoes_risco_oportunidades']);
        $this->oportunidade_melhora_entrada->setDbValue($row['oportunidade_melhora_entrada']);
        $this->oportunidade_melhora_saida->setDbValue($row['oportunidade_melhora_saida']);
        $this->qualquer_mudanca_sgq->setDbValue($row['qualquer_mudanca_sgq']);
        $this->nec_recurso->setDbValue($row['nec_recurso']);
        $this->anexo->Upload->DbValue = $row['anexo'];
        $this->anexo->setDbValue($this->anexo->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idanalise_critica_direcao'] = $this->idanalise_critica_direcao->DefaultValue;
        $row['data'] = $this->data->DefaultValue;
        $row['participantes'] = $this->participantes->DefaultValue;
        $row['usuario_idusuario'] = $this->usuario_idusuario->DefaultValue;
        $row['situacao_anterior'] = $this->situacao_anterior->DefaultValue;
        $row['mudanca_sqg'] = $this->mudanca_sqg->DefaultValue;
        $row['desempenho_eficacia'] = $this->desempenho_eficacia->DefaultValue;
        $row['satisfacao_cliente'] = $this->satisfacao_cliente->DefaultValue;
        $row['objetivos_alcançados'] = $this->objetivos_alcancados->DefaultValue;
        $row['desempenho_processo'] = $this->desempenho_processo->DefaultValue;
        $row['nao_confomidade_acoes_corretivas'] = $this->nao_confomidade_acoes_corretivas->DefaultValue;
        $row['monitoramento_medicao'] = $this->monitoramento_medicao->DefaultValue;
        $row['resultado_auditoria'] = $this->resultado_auditoria->DefaultValue;
        $row['desempenho_provedores_ext'] = $this->desempenho_provedores_ext->DefaultValue;
        $row['suficiencia_recursos'] = $this->suficiencia_recursos->DefaultValue;
        $row['acoes_risco_oportunidades'] = $this->acoes_risco_oportunidades->DefaultValue;
        $row['oportunidade_melhora_entrada'] = $this->oportunidade_melhora_entrada->DefaultValue;
        $row['oportunidade_melhora_saida'] = $this->oportunidade_melhora_saida->DefaultValue;
        $row['qualquer_mudanca_sgq'] = $this->qualquer_mudanca_sgq->DefaultValue;
        $row['nec_recurso'] = $this->nec_recurso->DefaultValue;
        $row['anexo'] = $this->anexo->DefaultValue;
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

        // idanalise_critica_direcao
        $this->idanalise_critica_direcao->RowCssClass = "row";

        // data
        $this->data->RowCssClass = "row";

        // participantes
        $this->participantes->RowCssClass = "row";

        // usuario_idusuario
        $this->usuario_idusuario->RowCssClass = "row";

        // situacao_anterior
        $this->situacao_anterior->RowCssClass = "row";

        // mudanca_sqg
        $this->mudanca_sqg->RowCssClass = "row";

        // desempenho_eficacia
        $this->desempenho_eficacia->RowCssClass = "row";

        // satisfacao_cliente
        $this->satisfacao_cliente->RowCssClass = "row";

        // objetivos_alcançados
        $this->objetivos_alcancados->RowCssClass = "row";

        // desempenho_processo
        $this->desempenho_processo->RowCssClass = "row";

        // nao_confomidade_acoes_corretivas
        $this->nao_confomidade_acoes_corretivas->RowCssClass = "row";

        // monitoramento_medicao
        $this->monitoramento_medicao->RowCssClass = "row";

        // resultado_auditoria
        $this->resultado_auditoria->RowCssClass = "row";

        // desempenho_provedores_ext
        $this->desempenho_provedores_ext->RowCssClass = "row";

        // suficiencia_recursos
        $this->suficiencia_recursos->RowCssClass = "row";

        // acoes_risco_oportunidades
        $this->acoes_risco_oportunidades->RowCssClass = "row";

        // oportunidade_melhora_entrada
        $this->oportunidade_melhora_entrada->RowCssClass = "row";

        // oportunidade_melhora_saida
        $this->oportunidade_melhora_saida->RowCssClass = "row";

        // qualquer_mudanca_sgq
        $this->qualquer_mudanca_sgq->RowCssClass = "row";

        // nec_recurso
        $this->nec_recurso->RowCssClass = "row";

        // anexo
        $this->anexo->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idanalise_critica_direcao
            $this->idanalise_critica_direcao->ViewValue = $this->idanalise_critica_direcao->CurrentValue;
            $this->idanalise_critica_direcao->CssClass = "fw-bold";
            $this->idanalise_critica_direcao->CellCssStyle .= "text-align: center;";

            // data
            $this->data->ViewValue = $this->data->CurrentValue;
            $this->data->ViewValue = FormatDateTime($this->data->ViewValue, $this->data->formatPattern());
            $this->data->CssClass = "fw-bold";

            // participantes
            $curVal = strval($this->participantes->CurrentValue);
            if ($curVal != "") {
                $this->participantes->ViewValue = $this->participantes->lookupCacheOption($curVal);
                if ($this->participantes->ViewValue === null) { // Lookup from database
                    $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        AddFilter($filterWrk, SearchFilter($this->participantes->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", trim($wrk), $this->participantes->Lookup->getTable()->Fields["idusuario"]->searchDataType(), ""), "OR");
                    }
                    $lookupFilter = $this->participantes->getSelectFilter($this); // PHP
                    $sqlWrk = $this->participantes->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->participantes->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->participantes->Lookup->renderViewRow($row);
                            $this->participantes->ViewValue->add($this->participantes->displayValue($arwrk));
                        }
                    } else {
                        $this->participantes->ViewValue = $this->participantes->CurrentValue;
                    }
                }
            } else {
                $this->participantes->ViewValue = null;
            }
            $this->participantes->CssClass = "fw-bold";

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

            // situacao_anterior
            $this->situacao_anterior->ViewValue = $this->situacao_anterior->CurrentValue;
            $this->situacao_anterior->CssClass = "fw-bold";

            // mudanca_sqg
            $this->mudanca_sqg->ViewValue = $this->mudanca_sqg->CurrentValue;
            $this->mudanca_sqg->CssClass = "fw-bold";

            // desempenho_eficacia
            $this->desempenho_eficacia->ViewValue = $this->desempenho_eficacia->CurrentValue;
            $this->desempenho_eficacia->CssClass = "fw-bold";

            // satisfacao_cliente
            $this->satisfacao_cliente->ViewValue = $this->satisfacao_cliente->CurrentValue;
            $this->satisfacao_cliente->CssClass = "fw-bold";

            // objetivos_alcançados
            $this->objetivos_alcancados->ViewValue = $this->objetivos_alcancados->CurrentValue;
            $this->objetivos_alcancados->CssClass = "fw-bold";

            // desempenho_processo
            $this->desempenho_processo->ViewValue = $this->desempenho_processo->CurrentValue;
            $this->desempenho_processo->CssClass = "fw-bold";

            // nao_confomidade_acoes_corretivas
            $this->nao_confomidade_acoes_corretivas->ViewValue = $this->nao_confomidade_acoes_corretivas->CurrentValue;
            $this->nao_confomidade_acoes_corretivas->CssClass = "fw-bold";

            // monitoramento_medicao
            $this->monitoramento_medicao->ViewValue = $this->monitoramento_medicao->CurrentValue;
            $this->monitoramento_medicao->CssClass = "fw-bold";

            // resultado_auditoria
            $this->resultado_auditoria->ViewValue = $this->resultado_auditoria->CurrentValue;
            $this->resultado_auditoria->CssClass = "fw-bold";

            // desempenho_provedores_ext
            $this->desempenho_provedores_ext->ViewValue = $this->desempenho_provedores_ext->CurrentValue;
            $this->desempenho_provedores_ext->CssClass = "fw-bold";

            // suficiencia_recursos
            $this->suficiencia_recursos->ViewValue = $this->suficiencia_recursos->CurrentValue;
            $this->suficiencia_recursos->CssClass = "fw-bold";

            // acoes_risco_oportunidades
            $this->acoes_risco_oportunidades->ViewValue = $this->acoes_risco_oportunidades->CurrentValue;
            $this->acoes_risco_oportunidades->CssClass = "fw-bold";

            // oportunidade_melhora_entrada
            $this->oportunidade_melhora_entrada->ViewValue = $this->oportunidade_melhora_entrada->CurrentValue;
            $this->oportunidade_melhora_entrada->CssClass = "fw-bold";

            // oportunidade_melhora_saida
            $this->oportunidade_melhora_saida->ViewValue = $this->oportunidade_melhora_saida->CurrentValue;
            $this->oportunidade_melhora_saida->CssClass = "fw-bold";

            // qualquer_mudanca_sgq
            $this->qualquer_mudanca_sgq->ViewValue = $this->qualquer_mudanca_sgq->CurrentValue;
            $this->qualquer_mudanca_sgq->CssClass = "fw-bold";

            // nec_recurso
            $this->nec_recurso->ViewValue = $this->nec_recurso->CurrentValue;
            $this->nec_recurso->CssClass = "fw-bold";

            // anexo
            if (!EmptyValue($this->anexo->Upload->DbValue)) {
                $this->anexo->ViewValue = $this->anexo->Upload->DbValue;
            } else {
                $this->anexo->ViewValue = "";
            }
            $this->anexo->CssClass = "fw-bold";

            // idanalise_critica_direcao
            $this->idanalise_critica_direcao->HrefValue = "";

            // data
            $this->data->HrefValue = "";

            // participantes
            $this->participantes->HrefValue = "";

            // usuario_idusuario
            $this->usuario_idusuario->HrefValue = "";

            // situacao_anterior
            $this->situacao_anterior->HrefValue = "";

            // mudanca_sqg
            $this->mudanca_sqg->HrefValue = "";

            // desempenho_eficacia
            $this->desempenho_eficacia->HrefValue = "";

            // satisfacao_cliente
            $this->satisfacao_cliente->HrefValue = "";

            // objetivos_alcançados
            $this->objetivos_alcancados->HrefValue = "";

            // desempenho_processo
            $this->desempenho_processo->HrefValue = "";

            // nao_confomidade_acoes_corretivas
            $this->nao_confomidade_acoes_corretivas->HrefValue = "";

            // monitoramento_medicao
            $this->monitoramento_medicao->HrefValue = "";

            // resultado_auditoria
            $this->resultado_auditoria->HrefValue = "";

            // desempenho_provedores_ext
            $this->desempenho_provedores_ext->HrefValue = "";

            // suficiencia_recursos
            $this->suficiencia_recursos->HrefValue = "";

            // acoes_risco_oportunidades
            $this->acoes_risco_oportunidades->HrefValue = "";

            // oportunidade_melhora_entrada
            $this->oportunidade_melhora_entrada->HrefValue = "";

            // oportunidade_melhora_saida
            $this->oportunidade_melhora_saida->HrefValue = "";

            // qualquer_mudanca_sgq
            $this->qualquer_mudanca_sgq->HrefValue = "";

            // nec_recurso
            $this->nec_recurso->HrefValue = "";

            // anexo
            if (!EmptyValue($this->anexo->Upload->DbValue)) {
                $this->anexo->HrefValue = $this->anexo->getLinkPrefix() . "%u"; // Add prefix/suffix
                $this->anexo->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->anexo->HrefValue = FullUrl($this->anexo->HrefValue, "href");
                }
            } else {
                $this->anexo->HrefValue = "";
            }
            $this->anexo->ExportHrefValue = $this->anexo->UploadPath . $this->anexo->Upload->DbValue;
        } elseif ($this->RowType == RowType::EDIT) {
            // idanalise_critica_direcao
            $this->idanalise_critica_direcao->setupEditAttributes();
            $this->idanalise_critica_direcao->EditValue = $this->idanalise_critica_direcao->CurrentValue;
            $this->idanalise_critica_direcao->CssClass = "fw-bold";
            $this->idanalise_critica_direcao->CellCssStyle .= "text-align: center;";

            // data
            $this->data->setupEditAttributes();
            $this->data->EditValue = HtmlEncode(FormatDateTime($this->data->CurrentValue, $this->data->formatPattern()));
            $this->data->PlaceHolder = RemoveHtml($this->data->caption());

            // participantes
            $curVal = trim(strval($this->participantes->CurrentValue));
            if ($curVal != "") {
                $this->participantes->ViewValue = $this->participantes->lookupCacheOption($curVal);
            } else {
                $this->participantes->ViewValue = $this->participantes->Lookup !== null && is_array($this->participantes->lookupOptions()) && count($this->participantes->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->participantes->ViewValue !== null) { // Load from cache
                $this->participantes->EditValue = array_values($this->participantes->lookupOptions());
                if ($this->participantes->ViewValue == "") {
                    $this->participantes->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        AddFilter($filterWrk, SearchFilter($this->participantes->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", trim($wrk), $this->participantes->Lookup->getTable()->Fields["idusuario"]->searchDataType(), ""), "OR");
                    }
                }
                $lookupFilter = $this->participantes->getSelectFilter($this); // PHP
                $sqlWrk = $this->participantes->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->participantes->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->participantes->Lookup->renderViewRow($row);
                        $this->participantes->ViewValue->add($this->participantes->displayValue($arwrk));
                        $ari++;
                    }
                } else {
                    $this->participantes->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->participantes->EditValue = $arwrk;
            }
            $this->participantes->PlaceHolder = RemoveHtml($this->participantes->caption());

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

            // situacao_anterior
            $this->situacao_anterior->setupEditAttributes();
            $this->situacao_anterior->EditValue = HtmlEncode($this->situacao_anterior->CurrentValue);
            $this->situacao_anterior->PlaceHolder = RemoveHtml($this->situacao_anterior->caption());

            // mudanca_sqg
            $this->mudanca_sqg->setupEditAttributes();
            $this->mudanca_sqg->EditValue = HtmlEncode($this->mudanca_sqg->CurrentValue);
            $this->mudanca_sqg->PlaceHolder = RemoveHtml($this->mudanca_sqg->caption());

            // desempenho_eficacia
            $this->desempenho_eficacia->setupEditAttributes();
            $this->desempenho_eficacia->EditValue = HtmlEncode($this->desempenho_eficacia->CurrentValue);
            $this->desempenho_eficacia->PlaceHolder = RemoveHtml($this->desempenho_eficacia->caption());

            // satisfacao_cliente
            $this->satisfacao_cliente->setupEditAttributes();
            $this->satisfacao_cliente->EditValue = HtmlEncode($this->satisfacao_cliente->CurrentValue);
            $this->satisfacao_cliente->PlaceHolder = RemoveHtml($this->satisfacao_cliente->caption());

            // objetivos_alcançados
            $this->objetivos_alcancados->setupEditAttributes();
            $this->objetivos_alcancados->EditValue = HtmlEncode($this->objetivos_alcancados->CurrentValue);
            $this->objetivos_alcancados->PlaceHolder = RemoveHtml($this->objetivos_alcancados->caption());

            // desempenho_processo
            $this->desempenho_processo->setupEditAttributes();
            $this->desempenho_processo->EditValue = HtmlEncode($this->desempenho_processo->CurrentValue);
            $this->desempenho_processo->PlaceHolder = RemoveHtml($this->desempenho_processo->caption());

            // nao_confomidade_acoes_corretivas
            $this->nao_confomidade_acoes_corretivas->setupEditAttributes();
            $this->nao_confomidade_acoes_corretivas->EditValue = HtmlEncode($this->nao_confomidade_acoes_corretivas->CurrentValue);
            $this->nao_confomidade_acoes_corretivas->PlaceHolder = RemoveHtml($this->nao_confomidade_acoes_corretivas->caption());

            // monitoramento_medicao
            $this->monitoramento_medicao->setupEditAttributes();
            $this->monitoramento_medicao->EditValue = HtmlEncode($this->monitoramento_medicao->CurrentValue);
            $this->monitoramento_medicao->PlaceHolder = RemoveHtml($this->monitoramento_medicao->caption());

            // resultado_auditoria
            $this->resultado_auditoria->setupEditAttributes();
            $this->resultado_auditoria->EditValue = HtmlEncode($this->resultado_auditoria->CurrentValue);
            $this->resultado_auditoria->PlaceHolder = RemoveHtml($this->resultado_auditoria->caption());

            // desempenho_provedores_ext
            $this->desempenho_provedores_ext->setupEditAttributes();
            $this->desempenho_provedores_ext->EditValue = HtmlEncode($this->desempenho_provedores_ext->CurrentValue);
            $this->desempenho_provedores_ext->PlaceHolder = RemoveHtml($this->desempenho_provedores_ext->caption());

            // suficiencia_recursos
            $this->suficiencia_recursos->setupEditAttributes();
            $this->suficiencia_recursos->EditValue = HtmlEncode($this->suficiencia_recursos->CurrentValue);
            $this->suficiencia_recursos->PlaceHolder = RemoveHtml($this->suficiencia_recursos->caption());

            // acoes_risco_oportunidades
            $this->acoes_risco_oportunidades->setupEditAttributes();
            $this->acoes_risco_oportunidades->EditValue = HtmlEncode($this->acoes_risco_oportunidades->CurrentValue);
            $this->acoes_risco_oportunidades->PlaceHolder = RemoveHtml($this->acoes_risco_oportunidades->caption());

            // oportunidade_melhora_entrada
            $this->oportunidade_melhora_entrada->setupEditAttributes();
            $this->oportunidade_melhora_entrada->EditValue = HtmlEncode($this->oportunidade_melhora_entrada->CurrentValue);
            $this->oportunidade_melhora_entrada->PlaceHolder = RemoveHtml($this->oportunidade_melhora_entrada->caption());

            // oportunidade_melhora_saida
            $this->oportunidade_melhora_saida->setupEditAttributes();
            $this->oportunidade_melhora_saida->EditValue = HtmlEncode($this->oportunidade_melhora_saida->CurrentValue);
            $this->oportunidade_melhora_saida->PlaceHolder = RemoveHtml($this->oportunidade_melhora_saida->caption());

            // qualquer_mudanca_sgq
            $this->qualquer_mudanca_sgq->setupEditAttributes();
            $this->qualquer_mudanca_sgq->EditValue = HtmlEncode($this->qualquer_mudanca_sgq->CurrentValue);
            $this->qualquer_mudanca_sgq->PlaceHolder = RemoveHtml($this->qualquer_mudanca_sgq->caption());

            // nec_recurso
            $this->nec_recurso->setupEditAttributes();
            if (!$this->nec_recurso->Raw) {
                $this->nec_recurso->CurrentValue = HtmlDecode($this->nec_recurso->CurrentValue);
            }
            $this->nec_recurso->EditValue = HtmlEncode($this->nec_recurso->CurrentValue);
            $this->nec_recurso->PlaceHolder = RemoveHtml($this->nec_recurso->caption());

            // anexo
            $this->anexo->setupEditAttributes();
            if (!EmptyValue($this->anexo->Upload->DbValue)) {
                $this->anexo->EditValue = $this->anexo->Upload->DbValue;
            } else {
                $this->anexo->EditValue = "";
            }
            if (!EmptyValue($this->anexo->CurrentValue)) {
                $this->anexo->Upload->FileName = $this->anexo->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->anexo);
            }

            // Edit refer script

            // idanalise_critica_direcao
            $this->idanalise_critica_direcao->HrefValue = "";

            // data
            $this->data->HrefValue = "";

            // participantes
            $this->participantes->HrefValue = "";

            // usuario_idusuario
            $this->usuario_idusuario->HrefValue = "";

            // situacao_anterior
            $this->situacao_anterior->HrefValue = "";

            // mudanca_sqg
            $this->mudanca_sqg->HrefValue = "";

            // desempenho_eficacia
            $this->desempenho_eficacia->HrefValue = "";

            // satisfacao_cliente
            $this->satisfacao_cliente->HrefValue = "";

            // objetivos_alcançados
            $this->objetivos_alcancados->HrefValue = "";

            // desempenho_processo
            $this->desempenho_processo->HrefValue = "";

            // nao_confomidade_acoes_corretivas
            $this->nao_confomidade_acoes_corretivas->HrefValue = "";

            // monitoramento_medicao
            $this->monitoramento_medicao->HrefValue = "";

            // resultado_auditoria
            $this->resultado_auditoria->HrefValue = "";

            // desempenho_provedores_ext
            $this->desempenho_provedores_ext->HrefValue = "";

            // suficiencia_recursos
            $this->suficiencia_recursos->HrefValue = "";

            // acoes_risco_oportunidades
            $this->acoes_risco_oportunidades->HrefValue = "";

            // oportunidade_melhora_entrada
            $this->oportunidade_melhora_entrada->HrefValue = "";

            // oportunidade_melhora_saida
            $this->oportunidade_melhora_saida->HrefValue = "";

            // qualquer_mudanca_sgq
            $this->qualquer_mudanca_sgq->HrefValue = "";

            // nec_recurso
            $this->nec_recurso->HrefValue = "";

            // anexo
            if (!EmptyValue($this->anexo->Upload->DbValue)) {
                $this->anexo->HrefValue = $this->anexo->getLinkPrefix() . "%u"; // Add prefix/suffix
                $this->anexo->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->anexo->HrefValue = FullUrl($this->anexo->HrefValue, "href");
                }
            } else {
                $this->anexo->HrefValue = "";
            }
            $this->anexo->ExportHrefValue = $this->anexo->UploadPath . $this->anexo->Upload->DbValue;
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
            if ($this->idanalise_critica_direcao->Visible && $this->idanalise_critica_direcao->Required) {
                if (!$this->idanalise_critica_direcao->IsDetailKey && EmptyValue($this->idanalise_critica_direcao->FormValue)) {
                    $this->idanalise_critica_direcao->addErrorMessage(str_replace("%s", $this->idanalise_critica_direcao->caption(), $this->idanalise_critica_direcao->RequiredErrorMessage));
                }
            }
            if ($this->data->Visible && $this->data->Required) {
                if (!$this->data->IsDetailKey && EmptyValue($this->data->FormValue)) {
                    $this->data->addErrorMessage(str_replace("%s", $this->data->caption(), $this->data->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->data->FormValue, $this->data->formatPattern())) {
                $this->data->addErrorMessage($this->data->getErrorMessage(false));
            }
            if ($this->participantes->Visible && $this->participantes->Required) {
                if ($this->participantes->FormValue == "") {
                    $this->participantes->addErrorMessage(str_replace("%s", $this->participantes->caption(), $this->participantes->RequiredErrorMessage));
                }
            }
            if ($this->usuario_idusuario->Visible && $this->usuario_idusuario->Required) {
                if (!$this->usuario_idusuario->IsDetailKey && EmptyValue($this->usuario_idusuario->FormValue)) {
                    $this->usuario_idusuario->addErrorMessage(str_replace("%s", $this->usuario_idusuario->caption(), $this->usuario_idusuario->RequiredErrorMessage));
                }
            }
            if ($this->situacao_anterior->Visible && $this->situacao_anterior->Required) {
                if (!$this->situacao_anterior->IsDetailKey && EmptyValue($this->situacao_anterior->FormValue)) {
                    $this->situacao_anterior->addErrorMessage(str_replace("%s", $this->situacao_anterior->caption(), $this->situacao_anterior->RequiredErrorMessage));
                }
            }
            if ($this->mudanca_sqg->Visible && $this->mudanca_sqg->Required) {
                if (!$this->mudanca_sqg->IsDetailKey && EmptyValue($this->mudanca_sqg->FormValue)) {
                    $this->mudanca_sqg->addErrorMessage(str_replace("%s", $this->mudanca_sqg->caption(), $this->mudanca_sqg->RequiredErrorMessage));
                }
            }
            if ($this->desempenho_eficacia->Visible && $this->desempenho_eficacia->Required) {
                if (!$this->desempenho_eficacia->IsDetailKey && EmptyValue($this->desempenho_eficacia->FormValue)) {
                    $this->desempenho_eficacia->addErrorMessage(str_replace("%s", $this->desempenho_eficacia->caption(), $this->desempenho_eficacia->RequiredErrorMessage));
                }
            }
            if ($this->satisfacao_cliente->Visible && $this->satisfacao_cliente->Required) {
                if (!$this->satisfacao_cliente->IsDetailKey && EmptyValue($this->satisfacao_cliente->FormValue)) {
                    $this->satisfacao_cliente->addErrorMessage(str_replace("%s", $this->satisfacao_cliente->caption(), $this->satisfacao_cliente->RequiredErrorMessage));
                }
            }
            if ($this->objetivos_alcancados->Visible && $this->objetivos_alcancados->Required) {
                if (!$this->objetivos_alcancados->IsDetailKey && EmptyValue($this->objetivos_alcancados->FormValue)) {
                    $this->objetivos_alcancados->addErrorMessage(str_replace("%s", $this->objetivos_alcancados->caption(), $this->objetivos_alcancados->RequiredErrorMessage));
                }
            }
            if ($this->desempenho_processo->Visible && $this->desempenho_processo->Required) {
                if (!$this->desempenho_processo->IsDetailKey && EmptyValue($this->desempenho_processo->FormValue)) {
                    $this->desempenho_processo->addErrorMessage(str_replace("%s", $this->desempenho_processo->caption(), $this->desempenho_processo->RequiredErrorMessage));
                }
            }
            if ($this->nao_confomidade_acoes_corretivas->Visible && $this->nao_confomidade_acoes_corretivas->Required) {
                if (!$this->nao_confomidade_acoes_corretivas->IsDetailKey && EmptyValue($this->nao_confomidade_acoes_corretivas->FormValue)) {
                    $this->nao_confomidade_acoes_corretivas->addErrorMessage(str_replace("%s", $this->nao_confomidade_acoes_corretivas->caption(), $this->nao_confomidade_acoes_corretivas->RequiredErrorMessage));
                }
            }
            if ($this->monitoramento_medicao->Visible && $this->monitoramento_medicao->Required) {
                if (!$this->monitoramento_medicao->IsDetailKey && EmptyValue($this->monitoramento_medicao->FormValue)) {
                    $this->monitoramento_medicao->addErrorMessage(str_replace("%s", $this->monitoramento_medicao->caption(), $this->monitoramento_medicao->RequiredErrorMessage));
                }
            }
            if ($this->resultado_auditoria->Visible && $this->resultado_auditoria->Required) {
                if (!$this->resultado_auditoria->IsDetailKey && EmptyValue($this->resultado_auditoria->FormValue)) {
                    $this->resultado_auditoria->addErrorMessage(str_replace("%s", $this->resultado_auditoria->caption(), $this->resultado_auditoria->RequiredErrorMessage));
                }
            }
            if ($this->desempenho_provedores_ext->Visible && $this->desempenho_provedores_ext->Required) {
                if (!$this->desempenho_provedores_ext->IsDetailKey && EmptyValue($this->desempenho_provedores_ext->FormValue)) {
                    $this->desempenho_provedores_ext->addErrorMessage(str_replace("%s", $this->desempenho_provedores_ext->caption(), $this->desempenho_provedores_ext->RequiredErrorMessage));
                }
            }
            if ($this->suficiencia_recursos->Visible && $this->suficiencia_recursos->Required) {
                if (!$this->suficiencia_recursos->IsDetailKey && EmptyValue($this->suficiencia_recursos->FormValue)) {
                    $this->suficiencia_recursos->addErrorMessage(str_replace("%s", $this->suficiencia_recursos->caption(), $this->suficiencia_recursos->RequiredErrorMessage));
                }
            }
            if ($this->acoes_risco_oportunidades->Visible && $this->acoes_risco_oportunidades->Required) {
                if (!$this->acoes_risco_oportunidades->IsDetailKey && EmptyValue($this->acoes_risco_oportunidades->FormValue)) {
                    $this->acoes_risco_oportunidades->addErrorMessage(str_replace("%s", $this->acoes_risco_oportunidades->caption(), $this->acoes_risco_oportunidades->RequiredErrorMessage));
                }
            }
            if ($this->oportunidade_melhora_entrada->Visible && $this->oportunidade_melhora_entrada->Required) {
                if (!$this->oportunidade_melhora_entrada->IsDetailKey && EmptyValue($this->oportunidade_melhora_entrada->FormValue)) {
                    $this->oportunidade_melhora_entrada->addErrorMessage(str_replace("%s", $this->oportunidade_melhora_entrada->caption(), $this->oportunidade_melhora_entrada->RequiredErrorMessage));
                }
            }
            if ($this->oportunidade_melhora_saida->Visible && $this->oportunidade_melhora_saida->Required) {
                if (!$this->oportunidade_melhora_saida->IsDetailKey && EmptyValue($this->oportunidade_melhora_saida->FormValue)) {
                    $this->oportunidade_melhora_saida->addErrorMessage(str_replace("%s", $this->oportunidade_melhora_saida->caption(), $this->oportunidade_melhora_saida->RequiredErrorMessage));
                }
            }
            if ($this->qualquer_mudanca_sgq->Visible && $this->qualquer_mudanca_sgq->Required) {
                if (!$this->qualquer_mudanca_sgq->IsDetailKey && EmptyValue($this->qualquer_mudanca_sgq->FormValue)) {
                    $this->qualquer_mudanca_sgq->addErrorMessage(str_replace("%s", $this->qualquer_mudanca_sgq->caption(), $this->qualquer_mudanca_sgq->RequiredErrorMessage));
                }
            }
            if ($this->nec_recurso->Visible && $this->nec_recurso->Required) {
                if (!$this->nec_recurso->IsDetailKey && EmptyValue($this->nec_recurso->FormValue)) {
                    $this->nec_recurso->addErrorMessage(str_replace("%s", $this->nec_recurso->caption(), $this->nec_recurso->RequiredErrorMessage));
                }
            }
            if ($this->anexo->Visible && $this->anexo->Required) {
                if ($this->anexo->Upload->FileName == "" && !$this->anexo->Upload->KeepFile) {
                    $this->anexo->addErrorMessage(str_replace("%s", $this->anexo->caption(), $this->anexo->RequiredErrorMessage));
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
        if ($this->anexo->Visible && !$this->anexo->Upload->KeepFile) {
            if (!EmptyValue($this->anexo->Upload->FileName)) {
                FixUploadFileNames($this->anexo);
                $this->anexo->setDbValueDef($rsnew, $this->anexo->Upload->FileName, $this->anexo->ReadOnly);
            }
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
                if ($this->anexo->Visible && !$this->anexo->Upload->KeepFile) {
                    if (!SaveUploadFiles($this->anexo, $rsnew['anexo'], false)) {
                        $this->setFailureMessage($Language->phrase("UploadError7"));
                        return false;
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

        // data
        $this->data->setDbValueDef($rsnew, UnFormatDateTime($this->data->CurrentValue, $this->data->formatPattern()), $this->data->ReadOnly);

        // participantes
        $this->participantes->setDbValueDef($rsnew, $this->participantes->CurrentValue, $this->participantes->ReadOnly);

        // usuario_idusuario
        $this->usuario_idusuario->setDbValueDef($rsnew, $this->usuario_idusuario->CurrentValue, $this->usuario_idusuario->ReadOnly);

        // situacao_anterior
        $this->situacao_anterior->setDbValueDef($rsnew, $this->situacao_anterior->CurrentValue, $this->situacao_anterior->ReadOnly);

        // mudanca_sqg
        $this->mudanca_sqg->setDbValueDef($rsnew, $this->mudanca_sqg->CurrentValue, $this->mudanca_sqg->ReadOnly);

        // desempenho_eficacia
        $this->desempenho_eficacia->setDbValueDef($rsnew, $this->desempenho_eficacia->CurrentValue, $this->desempenho_eficacia->ReadOnly);

        // satisfacao_cliente
        $this->satisfacao_cliente->setDbValueDef($rsnew, $this->satisfacao_cliente->CurrentValue, $this->satisfacao_cliente->ReadOnly);

        // objetivos_alcançados
        $this->objetivos_alcancados->setDbValueDef($rsnew, $this->objetivos_alcancados->CurrentValue, $this->objetivos_alcancados->ReadOnly);

        // desempenho_processo
        $this->desempenho_processo->setDbValueDef($rsnew, $this->desempenho_processo->CurrentValue, $this->desempenho_processo->ReadOnly);

        // nao_confomidade_acoes_corretivas
        $this->nao_confomidade_acoes_corretivas->setDbValueDef($rsnew, $this->nao_confomidade_acoes_corretivas->CurrentValue, $this->nao_confomidade_acoes_corretivas->ReadOnly);

        // monitoramento_medicao
        $this->monitoramento_medicao->setDbValueDef($rsnew, $this->monitoramento_medicao->CurrentValue, $this->monitoramento_medicao->ReadOnly);

        // resultado_auditoria
        $this->resultado_auditoria->setDbValueDef($rsnew, $this->resultado_auditoria->CurrentValue, $this->resultado_auditoria->ReadOnly);

        // desempenho_provedores_ext
        $this->desempenho_provedores_ext->setDbValueDef($rsnew, $this->desempenho_provedores_ext->CurrentValue, $this->desempenho_provedores_ext->ReadOnly);

        // suficiencia_recursos
        $this->suficiencia_recursos->setDbValueDef($rsnew, $this->suficiencia_recursos->CurrentValue, $this->suficiencia_recursos->ReadOnly);

        // acoes_risco_oportunidades
        $this->acoes_risco_oportunidades->setDbValueDef($rsnew, $this->acoes_risco_oportunidades->CurrentValue, $this->acoes_risco_oportunidades->ReadOnly);

        // oportunidade_melhora_entrada
        $this->oportunidade_melhora_entrada->setDbValueDef($rsnew, $this->oportunidade_melhora_entrada->CurrentValue, $this->oportunidade_melhora_entrada->ReadOnly);

        // oportunidade_melhora_saida
        $this->oportunidade_melhora_saida->setDbValueDef($rsnew, $this->oportunidade_melhora_saida->CurrentValue, $this->oportunidade_melhora_saida->ReadOnly);

        // qualquer_mudanca_sgq
        $this->qualquer_mudanca_sgq->setDbValueDef($rsnew, $this->qualquer_mudanca_sgq->CurrentValue, $this->qualquer_mudanca_sgq->ReadOnly);

        // nec_recurso
        $this->nec_recurso->setDbValueDef($rsnew, $this->nec_recurso->CurrentValue, $this->nec_recurso->ReadOnly);

        // anexo
        if ($this->anexo->Visible && !$this->anexo->ReadOnly && !$this->anexo->Upload->KeepFile) {
            if ($this->anexo->Upload->FileName == "") {
                $rsnew['anexo'] = null;
            } else {
                FixUploadTempFileNames($this->anexo);
                $rsnew['anexo'] = $this->anexo->Upload->FileName;
            }
        }
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['data'])) { // data
            $this->data->CurrentValue = $row['data'];
        }
        if (isset($row['participantes'])) { // participantes
            $this->participantes->CurrentValue = $row['participantes'];
        }
        if (isset($row['usuario_idusuario'])) { // usuario_idusuario
            $this->usuario_idusuario->CurrentValue = $row['usuario_idusuario'];
        }
        if (isset($row['situacao_anterior'])) { // situacao_anterior
            $this->situacao_anterior->CurrentValue = $row['situacao_anterior'];
        }
        if (isset($row['mudanca_sqg'])) { // mudanca_sqg
            $this->mudanca_sqg->CurrentValue = $row['mudanca_sqg'];
        }
        if (isset($row['desempenho_eficacia'])) { // desempenho_eficacia
            $this->desempenho_eficacia->CurrentValue = $row['desempenho_eficacia'];
        }
        if (isset($row['satisfacao_cliente'])) { // satisfacao_cliente
            $this->satisfacao_cliente->CurrentValue = $row['satisfacao_cliente'];
        }
        if (isset($row['objetivos_alcançados'])) { // objetivos_alcançados
            $this->objetivos_alcancados->CurrentValue = $row['objetivos_alcançados'];
        }
        if (isset($row['desempenho_processo'])) { // desempenho_processo
            $this->desempenho_processo->CurrentValue = $row['desempenho_processo'];
        }
        if (isset($row['nao_confomidade_acoes_corretivas'])) { // nao_confomidade_acoes_corretivas
            $this->nao_confomidade_acoes_corretivas->CurrentValue = $row['nao_confomidade_acoes_corretivas'];
        }
        if (isset($row['monitoramento_medicao'])) { // monitoramento_medicao
            $this->monitoramento_medicao->CurrentValue = $row['monitoramento_medicao'];
        }
        if (isset($row['resultado_auditoria'])) { // resultado_auditoria
            $this->resultado_auditoria->CurrentValue = $row['resultado_auditoria'];
        }
        if (isset($row['desempenho_provedores_ext'])) { // desempenho_provedores_ext
            $this->desempenho_provedores_ext->CurrentValue = $row['desempenho_provedores_ext'];
        }
        if (isset($row['suficiencia_recursos'])) { // suficiencia_recursos
            $this->suficiencia_recursos->CurrentValue = $row['suficiencia_recursos'];
        }
        if (isset($row['acoes_risco_oportunidades'])) { // acoes_risco_oportunidades
            $this->acoes_risco_oportunidades->CurrentValue = $row['acoes_risco_oportunidades'];
        }
        if (isset($row['oportunidade_melhora_entrada'])) { // oportunidade_melhora_entrada
            $this->oportunidade_melhora_entrada->CurrentValue = $row['oportunidade_melhora_entrada'];
        }
        if (isset($row['oportunidade_melhora_saida'])) { // oportunidade_melhora_saida
            $this->oportunidade_melhora_saida->CurrentValue = $row['oportunidade_melhora_saida'];
        }
        if (isset($row['qualquer_mudanca_sgq'])) { // qualquer_mudanca_sgq
            $this->qualquer_mudanca_sgq->CurrentValue = $row['qualquer_mudanca_sgq'];
        }
        if (isset($row['nec_recurso'])) { // nec_recurso
            $this->nec_recurso->CurrentValue = $row['nec_recurso'];
        }
        if (isset($row['anexo'])) { // anexo
            $this->anexo->CurrentValue = $row['anexo'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("AnaliseCriticaDirecaoList"), "", $this->TableVar, true);
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
        $pages->add(3);
        $pages->add(4);
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
                case "x_participantes":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_usuario_idusuario":
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
