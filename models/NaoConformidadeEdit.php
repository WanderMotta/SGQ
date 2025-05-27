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
class NaoConformidadeEdit extends NaoConformidade
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "NaoConformidadeEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "NaoConformidadeEdit";

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
        $this->idnao_conformidade->setVisibility();
        $this->dt_ocorrencia->setVisibility();
        $this->tipo->setVisibility();
        $this->titulo->setVisibility();
        $this->processo_idprocesso->setVisibility();
        $this->ocorrencia->setVisibility();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setVisibility();
        $this->acao_imediata->setVisibility();
        $this->causa_raiz->setVisibility();
        $this->departamentos_iddepartamentos->setVisibility();
        $this->anexo->setVisibility();
        $this->status_nc->setVisibility();
        $this->plano_acao->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'nao_conformidade';
        $this->TableName = 'nao_conformidade';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (nao_conformidade)
        if (!isset($GLOBALS["nao_conformidade"]) || $GLOBALS["nao_conformidade"]::class == PROJECT_NAMESPACE . "nao_conformidade") {
            $GLOBALS["nao_conformidade"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'nao_conformidade');
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
                        $result["view"] = SameString($pageName, "NaoConformidadeView"); // If View page, no primary button
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
            $key .= @$ar['idnao_conformidade'];
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
            $this->idnao_conformidade->Visible = false;
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
        $this->setupLookupOptions($this->tipo);
        $this->setupLookupOptions($this->processo_idprocesso);
        $this->setupLookupOptions($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
        $this->setupLookupOptions($this->departamentos_iddepartamentos);
        $this->setupLookupOptions($this->status_nc);
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
            if (($keyValue = Get("idnao_conformidade") ?? Key(0) ?? Route(2)) !== null) {
                $this->idnao_conformidade->setQueryStringValue($keyValue);
                $this->idnao_conformidade->setOldValue($this->idnao_conformidade->QueryStringValue);
            } elseif (Post("idnao_conformidade") !== null) {
                $this->idnao_conformidade->setFormValue(Post("idnao_conformidade"));
                $this->idnao_conformidade->setOldValue($this->idnao_conformidade->FormValue);
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
                if (($keyValue = Get("idnao_conformidade") ?? Route("idnao_conformidade")) !== null) {
                    $this->idnao_conformidade->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idnao_conformidade->CurrentValue = null;
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
                        $this->terminate("NaoConformidadeList"); // No matching record, return to list
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
                if (GetPageName($returnUrl) == "NaoConformidadeList") {
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
                        if (GetPageName($returnUrl) != "NaoConformidadeList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "NaoConformidadeList"; // Return list page content
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

        // Check field name 'idnao_conformidade' first before field var 'x_idnao_conformidade'
        $val = $CurrentForm->hasValue("idnao_conformidade") ? $CurrentForm->getValue("idnao_conformidade") : $CurrentForm->getValue("x_idnao_conformidade");
        if (!$this->idnao_conformidade->IsDetailKey) {
            $this->idnao_conformidade->setFormValue($val);
        }

        // Check field name 'dt_ocorrencia' first before field var 'x_dt_ocorrencia'
        $val = $CurrentForm->hasValue("dt_ocorrencia") ? $CurrentForm->getValue("dt_ocorrencia") : $CurrentForm->getValue("x_dt_ocorrencia");
        if (!$this->dt_ocorrencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dt_ocorrencia->Visible = false; // Disable update for API request
            } else {
                $this->dt_ocorrencia->setFormValue($val, true, $validate);
            }
            $this->dt_ocorrencia->CurrentValue = UnFormatDateTime($this->dt_ocorrencia->CurrentValue, $this->dt_ocorrencia->formatPattern());
        }

        // Check field name 'tipo' first before field var 'x_tipo'
        $val = $CurrentForm->hasValue("tipo") ? $CurrentForm->getValue("tipo") : $CurrentForm->getValue("x_tipo");
        if (!$this->tipo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo->Visible = false; // Disable update for API request
            } else {
                $this->tipo->setFormValue($val);
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

        // Check field name 'processo_idprocesso' first before field var 'x_processo_idprocesso'
        $val = $CurrentForm->hasValue("processo_idprocesso") ? $CurrentForm->getValue("processo_idprocesso") : $CurrentForm->getValue("x_processo_idprocesso");
        if (!$this->processo_idprocesso->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->processo_idprocesso->Visible = false; // Disable update for API request
            } else {
                $this->processo_idprocesso->setFormValue($val);
            }
        }

        // Check field name 'ocorrencia' first before field var 'x_ocorrencia'
        $val = $CurrentForm->hasValue("ocorrencia") ? $CurrentForm->getValue("ocorrencia") : $CurrentForm->getValue("x_ocorrencia");
        if (!$this->ocorrencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ocorrencia->Visible = false; // Disable update for API request
            } else {
                $this->ocorrencia->setFormValue($val);
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

        // Check field name 'acao_imediata' first before field var 'x_acao_imediata'
        $val = $CurrentForm->hasValue("acao_imediata") ? $CurrentForm->getValue("acao_imediata") : $CurrentForm->getValue("x_acao_imediata");
        if (!$this->acao_imediata->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->acao_imediata->Visible = false; // Disable update for API request
            } else {
                $this->acao_imediata->setFormValue($val);
            }
        }

        // Check field name 'causa_raiz' first before field var 'x_causa_raiz'
        $val = $CurrentForm->hasValue("causa_raiz") ? $CurrentForm->getValue("causa_raiz") : $CurrentForm->getValue("x_causa_raiz");
        if (!$this->causa_raiz->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->causa_raiz->Visible = false; // Disable update for API request
            } else {
                $this->causa_raiz->setFormValue($val);
            }
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

        // Check field name 'status_nc' first before field var 'x_status_nc'
        $val = $CurrentForm->hasValue("status_nc") ? $CurrentForm->getValue("status_nc") : $CurrentForm->getValue("x_status_nc");
        if (!$this->status_nc->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_nc->Visible = false; // Disable update for API request
            } else {
                $this->status_nc->setFormValue($val);
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
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idnao_conformidade->CurrentValue = $this->idnao_conformidade->FormValue;
        $this->dt_ocorrencia->CurrentValue = $this->dt_ocorrencia->FormValue;
        $this->dt_ocorrencia->CurrentValue = UnFormatDateTime($this->dt_ocorrencia->CurrentValue, $this->dt_ocorrencia->formatPattern());
        $this->tipo->CurrentValue = $this->tipo->FormValue;
        $this->titulo->CurrentValue = $this->titulo->FormValue;
        $this->processo_idprocesso->CurrentValue = $this->processo_idprocesso->FormValue;
        $this->ocorrencia->CurrentValue = $this->ocorrencia->FormValue;
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->FormValue;
        $this->acao_imediata->CurrentValue = $this->acao_imediata->FormValue;
        $this->causa_raiz->CurrentValue = $this->causa_raiz->FormValue;
        $this->departamentos_iddepartamentos->CurrentValue = $this->departamentos_iddepartamentos->FormValue;
        $this->status_nc->CurrentValue = $this->status_nc->FormValue;
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
        $this->idnao_conformidade->setDbValue($row['idnao_conformidade']);
        $this->dt_ocorrencia->setDbValue($row['dt_ocorrencia']);
        $this->tipo->setDbValue($row['tipo']);
        $this->titulo->setDbValue($row['titulo']);
        $this->processo_idprocesso->setDbValue($row['processo_idprocesso']);
        $this->ocorrencia->setDbValue($row['ocorrencia']);
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValue($row['origem_risco_oportunidade_idorigem_risco_oportunidade']);
        $this->acao_imediata->setDbValue($row['acao_imediata']);
        $this->causa_raiz->setDbValue($row['causa_raiz']);
        $this->departamentos_iddepartamentos->setDbValue($row['departamentos_iddepartamentos']);
        $this->anexo->Upload->DbValue = $row['anexo'];
        $this->anexo->setDbValue($this->anexo->Upload->DbValue);
        $this->status_nc->setDbValue($row['status_nc']);
        $this->plano_acao->setDbValue($row['plano_acao']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idnao_conformidade'] = $this->idnao_conformidade->DefaultValue;
        $row['dt_ocorrencia'] = $this->dt_ocorrencia->DefaultValue;
        $row['tipo'] = $this->tipo->DefaultValue;
        $row['titulo'] = $this->titulo->DefaultValue;
        $row['processo_idprocesso'] = $this->processo_idprocesso->DefaultValue;
        $row['ocorrencia'] = $this->ocorrencia->DefaultValue;
        $row['origem_risco_oportunidade_idorigem_risco_oportunidade'] = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->DefaultValue;
        $row['acao_imediata'] = $this->acao_imediata->DefaultValue;
        $row['causa_raiz'] = $this->causa_raiz->DefaultValue;
        $row['departamentos_iddepartamentos'] = $this->departamentos_iddepartamentos->DefaultValue;
        $row['anexo'] = $this->anexo->DefaultValue;
        $row['status_nc'] = $this->status_nc->DefaultValue;
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

        // idnao_conformidade
        $this->idnao_conformidade->RowCssClass = "row";

        // dt_ocorrencia
        $this->dt_ocorrencia->RowCssClass = "row";

        // tipo
        $this->tipo->RowCssClass = "row";

        // titulo
        $this->titulo->RowCssClass = "row";

        // processo_idprocesso
        $this->processo_idprocesso->RowCssClass = "row";

        // ocorrencia
        $this->ocorrencia->RowCssClass = "row";

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->RowCssClass = "row";

        // acao_imediata
        $this->acao_imediata->RowCssClass = "row";

        // causa_raiz
        $this->causa_raiz->RowCssClass = "row";

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->RowCssClass = "row";

        // anexo
        $this->anexo->RowCssClass = "row";

        // status_nc
        $this->status_nc->RowCssClass = "row";

        // plano_acao
        $this->plano_acao->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idnao_conformidade
            $this->idnao_conformidade->ViewValue = $this->idnao_conformidade->CurrentValue;
            $this->idnao_conformidade->CssClass = "fw-bold";
            $this->idnao_conformidade->CellCssStyle .= "text-align: center;";

            // dt_ocorrencia
            $this->dt_ocorrencia->ViewValue = $this->dt_ocorrencia->CurrentValue;
            $this->dt_ocorrencia->ViewValue = FormatDateTime($this->dt_ocorrencia->ViewValue, $this->dt_ocorrencia->formatPattern());
            $this->dt_ocorrencia->CssClass = "fw-bold";
            $this->dt_ocorrencia->CellCssStyle .= "text-align: center;";

            // tipo
            if (strval($this->tipo->CurrentValue) != "") {
                $this->tipo->ViewValue = $this->tipo->optionCaption($this->tipo->CurrentValue);
            } else {
                $this->tipo->ViewValue = null;
            }
            $this->tipo->CssClass = "fw-bold";

            // titulo
            $this->titulo->ViewValue = $this->titulo->CurrentValue;
            $this->titulo->CssClass = "fw-bold";

            // processo_idprocesso
            $curVal = strval($this->processo_idprocesso->CurrentValue);
            if ($curVal != "") {
                $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->lookupCacheOption($curVal);
                if ($this->processo_idprocesso->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $curVal, $this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                    $sqlWrk = $this->processo_idprocesso->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->processo_idprocesso->Lookup->renderViewRow($rswrk[0]);
                        $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->displayValue($arwrk);
                    } else {
                        $this->processo_idprocesso->ViewValue = FormatNumber($this->processo_idprocesso->CurrentValue, $this->processo_idprocesso->formatPattern());
                    }
                }
            } else {
                $this->processo_idprocesso->ViewValue = null;
            }
            $this->processo_idprocesso->CssClass = "fw-bold";

            // ocorrencia
            $this->ocorrencia->ViewValue = $this->ocorrencia->CurrentValue;
            $this->ocorrencia->CssClass = "fw-bold";

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

            // acao_imediata
            $this->acao_imediata->ViewValue = $this->acao_imediata->CurrentValue;
            $this->acao_imediata->CssClass = "fw-bold";

            // causa_raiz
            $this->causa_raiz->ViewValue = $this->causa_raiz->CurrentValue;
            $this->causa_raiz->CssClass = "fw-bold";

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

            // anexo
            if (!EmptyValue($this->anexo->Upload->DbValue)) {
                $this->anexo->ViewValue = $this->anexo->Upload->DbValue;
            } else {
                $this->anexo->ViewValue = "";
            }
            $this->anexo->CssClass = "fw-bold";

            // status_nc
            if (strval($this->status_nc->CurrentValue) != "") {
                $this->status_nc->ViewValue = $this->status_nc->optionCaption($this->status_nc->CurrentValue);
            } else {
                $this->status_nc->ViewValue = null;
            }
            $this->status_nc->CssClass = "fw-bold";

            // plano_acao
            if (strval($this->plano_acao->CurrentValue) != "") {
                $this->plano_acao->ViewValue = $this->plano_acao->optionCaption($this->plano_acao->CurrentValue);
            } else {
                $this->plano_acao->ViewValue = null;
            }
            $this->plano_acao->CssClass = "fw-bold";
            $this->plano_acao->CellCssStyle .= "text-align: center;";

            // idnao_conformidade
            $this->idnao_conformidade->HrefValue = "";

            // dt_ocorrencia
            $this->dt_ocorrencia->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // titulo
            $this->titulo->HrefValue = "";

            // processo_idprocesso
            $this->processo_idprocesso->HrefValue = "";

            // ocorrencia
            $this->ocorrencia->HrefValue = "";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";

            // acao_imediata
            $this->acao_imediata->HrefValue = "";

            // causa_raiz
            $this->causa_raiz->HrefValue = "";

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->HrefValue = "";

            // anexo
            if (!EmptyValue($this->anexo->Upload->DbValue)) {
                $this->anexo->HrefValue = $this->anexo->getLinkPrefix() . GetFileUploadUrl($this->anexo, $this->anexo->htmlDecode($this->anexo->Upload->DbValue)); // Add prefix/suffix
                $this->anexo->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->anexo->HrefValue = FullUrl($this->anexo->HrefValue, "href");
                }
            } else {
                $this->anexo->HrefValue = "";
            }
            $this->anexo->ExportHrefValue = $this->anexo->UploadPath . $this->anexo->Upload->DbValue;

            // status_nc
            $this->status_nc->HrefValue = "";

            // plano_acao
            $this->plano_acao->HrefValue = "";
            $this->plano_acao->TooltipValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // idnao_conformidade
            $this->idnao_conformidade->setupEditAttributes();
            $this->idnao_conformidade->EditValue = $this->idnao_conformidade->CurrentValue;
            $this->idnao_conformidade->CssClass = "fw-bold";
            $this->idnao_conformidade->CellCssStyle .= "text-align: center;";

            // dt_ocorrencia
            $this->dt_ocorrencia->setupEditAttributes();
            $this->dt_ocorrencia->EditValue = HtmlEncode(FormatDateTime($this->dt_ocorrencia->CurrentValue, $this->dt_ocorrencia->formatPattern()));
            $this->dt_ocorrencia->PlaceHolder = RemoveHtml($this->dt_ocorrencia->caption());

            // tipo
            $this->tipo->EditValue = $this->tipo->options(false);
            $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

            // titulo
            $this->titulo->setupEditAttributes();
            if (!$this->titulo->Raw) {
                $this->titulo->CurrentValue = HtmlDecode($this->titulo->CurrentValue);
            }
            $this->titulo->EditValue = HtmlEncode($this->titulo->CurrentValue);
            $this->titulo->PlaceHolder = RemoveHtml($this->titulo->caption());

            // processo_idprocesso
            $curVal = trim(strval($this->processo_idprocesso->CurrentValue));
            if ($curVal != "") {
                $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->lookupCacheOption($curVal);
            } else {
                $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->Lookup !== null && is_array($this->processo_idprocesso->lookupOptions()) && count($this->processo_idprocesso->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->processo_idprocesso->ViewValue !== null) { // Load from cache
                $this->processo_idprocesso->EditValue = array_values($this->processo_idprocesso->lookupOptions());
                if ($this->processo_idprocesso->ViewValue == "") {
                    $this->processo_idprocesso->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $this->processo_idprocesso->CurrentValue, $this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                }
                $sqlWrk = $this->processo_idprocesso->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->processo_idprocesso->Lookup->renderViewRow($rswrk[0]);
                    $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->displayValue($arwrk);
                } else {
                    $this->processo_idprocesso->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->processo_idprocesso->EditValue = $arwrk;
            }
            $this->processo_idprocesso->PlaceHolder = RemoveHtml($this->processo_idprocesso->caption());

            // ocorrencia
            $this->ocorrencia->setupEditAttributes();
            $this->ocorrencia->EditValue = HtmlEncode($this->ocorrencia->CurrentValue);
            $this->ocorrencia->PlaceHolder = RemoveHtml($this->ocorrencia->caption());

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

            // acao_imediata
            $this->acao_imediata->setupEditAttributes();
            $this->acao_imediata->EditValue = HtmlEncode($this->acao_imediata->CurrentValue);
            $this->acao_imediata->PlaceHolder = RemoveHtml($this->acao_imediata->caption());

            // causa_raiz
            $this->causa_raiz->setupEditAttributes();
            $this->causa_raiz->EditValue = HtmlEncode($this->causa_raiz->CurrentValue);
            $this->causa_raiz->PlaceHolder = RemoveHtml($this->causa_raiz->caption());

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

            // status_nc
            $this->status_nc->EditValue = $this->status_nc->options(false);
            $this->status_nc->PlaceHolder = RemoveHtml($this->status_nc->caption());

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

            // idnao_conformidade
            $this->idnao_conformidade->HrefValue = "";

            // dt_ocorrencia
            $this->dt_ocorrencia->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // titulo
            $this->titulo->HrefValue = "";

            // processo_idprocesso
            $this->processo_idprocesso->HrefValue = "";

            // ocorrencia
            $this->ocorrencia->HrefValue = "";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";

            // acao_imediata
            $this->acao_imediata->HrefValue = "";

            // causa_raiz
            $this->causa_raiz->HrefValue = "";

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->HrefValue = "";

            // anexo
            if (!EmptyValue($this->anexo->Upload->DbValue)) {
                $this->anexo->HrefValue = $this->anexo->getLinkPrefix() . GetFileUploadUrl($this->anexo, $this->anexo->htmlDecode($this->anexo->Upload->DbValue)); // Add prefix/suffix
                $this->anexo->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->anexo->HrefValue = FullUrl($this->anexo->HrefValue, "href");
                }
            } else {
                $this->anexo->HrefValue = "";
            }
            $this->anexo->ExportHrefValue = $this->anexo->UploadPath . $this->anexo->Upload->DbValue;

            // status_nc
            $this->status_nc->HrefValue = "";

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
            if ($this->idnao_conformidade->Visible && $this->idnao_conformidade->Required) {
                if (!$this->idnao_conformidade->IsDetailKey && EmptyValue($this->idnao_conformidade->FormValue)) {
                    $this->idnao_conformidade->addErrorMessage(str_replace("%s", $this->idnao_conformidade->caption(), $this->idnao_conformidade->RequiredErrorMessage));
                }
            }
            if ($this->dt_ocorrencia->Visible && $this->dt_ocorrencia->Required) {
                if (!$this->dt_ocorrencia->IsDetailKey && EmptyValue($this->dt_ocorrencia->FormValue)) {
                    $this->dt_ocorrencia->addErrorMessage(str_replace("%s", $this->dt_ocorrencia->caption(), $this->dt_ocorrencia->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->dt_ocorrencia->FormValue, $this->dt_ocorrencia->formatPattern())) {
                $this->dt_ocorrencia->addErrorMessage($this->dt_ocorrencia->getErrorMessage(false));
            }
            if ($this->tipo->Visible && $this->tipo->Required) {
                if ($this->tipo->FormValue == "") {
                    $this->tipo->addErrorMessage(str_replace("%s", $this->tipo->caption(), $this->tipo->RequiredErrorMessage));
                }
            }
            if ($this->titulo->Visible && $this->titulo->Required) {
                if (!$this->titulo->IsDetailKey && EmptyValue($this->titulo->FormValue)) {
                    $this->titulo->addErrorMessage(str_replace("%s", $this->titulo->caption(), $this->titulo->RequiredErrorMessage));
                }
            }
            if ($this->processo_idprocesso->Visible && $this->processo_idprocesso->Required) {
                if (!$this->processo_idprocesso->IsDetailKey && EmptyValue($this->processo_idprocesso->FormValue)) {
                    $this->processo_idprocesso->addErrorMessage(str_replace("%s", $this->processo_idprocesso->caption(), $this->processo_idprocesso->RequiredErrorMessage));
                }
            }
            if ($this->ocorrencia->Visible && $this->ocorrencia->Required) {
                if (!$this->ocorrencia->IsDetailKey && EmptyValue($this->ocorrencia->FormValue)) {
                    $this->ocorrencia->addErrorMessage(str_replace("%s", $this->ocorrencia->caption(), $this->ocorrencia->RequiredErrorMessage));
                }
            }
            if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible && $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Required) {
                if (!$this->origem_risco_oportunidade_idorigem_risco_oportunidade->IsDetailKey && EmptyValue($this->origem_risco_oportunidade_idorigem_risco_oportunidade->FormValue)) {
                    $this->origem_risco_oportunidade_idorigem_risco_oportunidade->addErrorMessage(str_replace("%s", $this->origem_risco_oportunidade_idorigem_risco_oportunidade->caption(), $this->origem_risco_oportunidade_idorigem_risco_oportunidade->RequiredErrorMessage));
                }
            }
            if ($this->acao_imediata->Visible && $this->acao_imediata->Required) {
                if (!$this->acao_imediata->IsDetailKey && EmptyValue($this->acao_imediata->FormValue)) {
                    $this->acao_imediata->addErrorMessage(str_replace("%s", $this->acao_imediata->caption(), $this->acao_imediata->RequiredErrorMessage));
                }
            }
            if ($this->causa_raiz->Visible && $this->causa_raiz->Required) {
                if (!$this->causa_raiz->IsDetailKey && EmptyValue($this->causa_raiz->FormValue)) {
                    $this->causa_raiz->addErrorMessage(str_replace("%s", $this->causa_raiz->caption(), $this->causa_raiz->RequiredErrorMessage));
                }
            }
            if ($this->departamentos_iddepartamentos->Visible && $this->departamentos_iddepartamentos->Required) {
                if (!$this->departamentos_iddepartamentos->IsDetailKey && EmptyValue($this->departamentos_iddepartamentos->FormValue)) {
                    $this->departamentos_iddepartamentos->addErrorMessage(str_replace("%s", $this->departamentos_iddepartamentos->caption(), $this->departamentos_iddepartamentos->RequiredErrorMessage));
                }
            }
            if ($this->anexo->Visible && $this->anexo->Required) {
                if ($this->anexo->Upload->FileName == "" && !$this->anexo->Upload->KeepFile) {
                    $this->anexo->addErrorMessage(str_replace("%s", $this->anexo->caption(), $this->anexo->RequiredErrorMessage));
                }
            }
            if ($this->status_nc->Visible && $this->status_nc->Required) {
                if ($this->status_nc->FormValue == "") {
                    $this->status_nc->addErrorMessage(str_replace("%s", $this->status_nc->caption(), $this->status_nc->RequiredErrorMessage));
                }
            }
            if ($this->plano_acao->Visible && $this->plano_acao->Required) {
                if ($this->plano_acao->FormValue == "") {
                    $this->plano_acao->addErrorMessage(str_replace("%s", $this->plano_acao->caption(), $this->plano_acao->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("PlanoAcaoNcGrid");
        if (in_array("plano_acao_nc", $detailTblVar) && $detailPage->DetailEdit) {
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

            // Update detail records
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("PlanoAcaoNcGrid");
            if (in_array("plano_acao_nc", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "plano_acao_nc"); // Load user level of detail table
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

        // dt_ocorrencia
        $this->dt_ocorrencia->setDbValueDef($rsnew, UnFormatDateTime($this->dt_ocorrencia->CurrentValue, $this->dt_ocorrencia->formatPattern()), $this->dt_ocorrencia->ReadOnly);

        // tipo
        $this->tipo->setDbValueDef($rsnew, $this->tipo->CurrentValue, $this->tipo->ReadOnly);

        // titulo
        $this->titulo->setDbValueDef($rsnew, $this->titulo->CurrentValue, $this->titulo->ReadOnly);

        // processo_idprocesso
        $this->processo_idprocesso->setDbValueDef($rsnew, $this->processo_idprocesso->CurrentValue, $this->processo_idprocesso->ReadOnly);

        // ocorrencia
        $this->ocorrencia->setDbValueDef($rsnew, $this->ocorrencia->CurrentValue, $this->ocorrencia->ReadOnly);

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValueDef($rsnew, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ReadOnly);

        // acao_imediata
        $this->acao_imediata->setDbValueDef($rsnew, $this->acao_imediata->CurrentValue, $this->acao_imediata->ReadOnly);

        // causa_raiz
        $this->causa_raiz->setDbValueDef($rsnew, $this->causa_raiz->CurrentValue, $this->causa_raiz->ReadOnly);

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->setDbValueDef($rsnew, $this->departamentos_iddepartamentos->CurrentValue, $this->departamentos_iddepartamentos->ReadOnly);

        // anexo
        if ($this->anexo->Visible && !$this->anexo->ReadOnly && !$this->anexo->Upload->KeepFile) {
            if ($this->anexo->Upload->FileName == "") {
                $rsnew['anexo'] = null;
            } else {
                FixUploadTempFileNames($this->anexo);
                $rsnew['anexo'] = $this->anexo->Upload->FileName;
            }
        }

        // status_nc
        $this->status_nc->setDbValueDef($rsnew, $this->status_nc->CurrentValue, $this->status_nc->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['dt_ocorrencia'])) { // dt_ocorrencia
            $this->dt_ocorrencia->CurrentValue = $row['dt_ocorrencia'];
        }
        if (isset($row['tipo'])) { // tipo
            $this->tipo->CurrentValue = $row['tipo'];
        }
        if (isset($row['titulo'])) { // titulo
            $this->titulo->CurrentValue = $row['titulo'];
        }
        if (isset($row['processo_idprocesso'])) { // processo_idprocesso
            $this->processo_idprocesso->CurrentValue = $row['processo_idprocesso'];
        }
        if (isset($row['ocorrencia'])) { // ocorrencia
            $this->ocorrencia->CurrentValue = $row['ocorrencia'];
        }
        if (isset($row['origem_risco_oportunidade_idorigem_risco_oportunidade'])) { // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue = $row['origem_risco_oportunidade_idorigem_risco_oportunidade'];
        }
        if (isset($row['acao_imediata'])) { // acao_imediata
            $this->acao_imediata->CurrentValue = $row['acao_imediata'];
        }
        if (isset($row['causa_raiz'])) { // causa_raiz
            $this->causa_raiz->CurrentValue = $row['causa_raiz'];
        }
        if (isset($row['departamentos_iddepartamentos'])) { // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->CurrentValue = $row['departamentos_iddepartamentos'];
        }
        if (isset($row['anexo'])) { // anexo
            $this->anexo->CurrentValue = $row['anexo'];
        }
        if (isset($row['status_nc'])) { // status_nc
            $this->status_nc->CurrentValue = $row['status_nc'];
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
            if (in_array("plano_acao_nc", $detailTblVar)) {
                $detailPageObj = Container("PlanoAcaoNcGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->nao_conformidade_idnao_conformidade->IsDetailKey = true;
                    $detailPageObj->nao_conformidade_idnao_conformidade->CurrentValue = $this->idnao_conformidade->CurrentValue;
                    $detailPageObj->nao_conformidade_idnao_conformidade->setSessionValue($detailPageObj->nao_conformidade_idnao_conformidade->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NaoConformidadeList"), "", $this->TableVar, true);
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
                case "x_tipo":
                    break;
                case "x_processo_idprocesso":
                    break;
                case "x_origem_risco_oportunidade_idorigem_risco_oportunidade":
                    break;
                case "x_departamentos_iddepartamentos":
                    break;
                case "x_status_nc":
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
