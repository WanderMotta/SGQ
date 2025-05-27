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
class ProcessoEdit extends Processo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ProcessoEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ProcessoEdit";

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
        $this->idprocesso->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->revisao->setVisibility();
        $this->tipo_idtipo->setVisibility();
        $this->processo->setVisibility();
        $this->responsaveis->setVisibility();
        $this->objetivo->setVisibility();
        $this->proc_antes->setVisibility();
        $this->proc_depois->setVisibility();
        $this->eqpto_recursos->setVisibility();
        $this->entradas->setVisibility();
        $this->atividade_principal->setVisibility();
        $this->saidas_resultados->setVisibility();
        $this->requsito_saidas->setVisibility();
        $this->riscos->setVisibility();
        $this->oportunidades->setVisibility();
        $this->propriedade_externa->setVisibility();
        $this->conhecimentos->setVisibility();
        $this->documentos_aplicados->setVisibility();
        $this->proced_int_trabalho->setVisibility();
        $this->mapa->setVisibility();
        $this->formulario->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'processo';
        $this->TableName = 'processo';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (processo)
        if (!isset($GLOBALS["processo"]) || $GLOBALS["processo"]::class == PROJECT_NAMESPACE . "processo") {
            $GLOBALS["processo"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'processo');
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
                        $result["view"] = SameString($pageName, "ProcessoView"); // If View page, no primary button
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
            $key .= @$ar['idprocesso'];
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
            $this->idprocesso->Visible = false;
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
        $this->setupLookupOptions($this->tipo_idtipo);
        $this->setupLookupOptions($this->responsaveis);
        $this->setupLookupOptions($this->proc_antes);
        $this->setupLookupOptions($this->proc_depois);

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
            if (($keyValue = Get("idprocesso") ?? Key(0) ?? Route(2)) !== null) {
                $this->idprocesso->setQueryStringValue($keyValue);
                $this->idprocesso->setOldValue($this->idprocesso->QueryStringValue);
            } elseif (Post("idprocesso") !== null) {
                $this->idprocesso->setFormValue(Post("idprocesso"));
                $this->idprocesso->setOldValue($this->idprocesso->FormValue);
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
                if (($keyValue = Get("idprocesso") ?? Route("idprocesso")) !== null) {
                    $this->idprocesso->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->idprocesso->CurrentValue = null;
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
                        $this->terminate("ProcessoList"); // No matching record, return to list
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
                if (GetPageName($returnUrl) == "ProcessoList") {
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
                        if (GetPageName($returnUrl) != "ProcessoList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ProcessoList"; // Return list page content
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
        $this->proced_int_trabalho->Upload->Index = $CurrentForm->Index;
        $this->proced_int_trabalho->Upload->uploadFile();
        $this->proced_int_trabalho->CurrentValue = $this->proced_int_trabalho->Upload->FileName;
        $this->mapa->Upload->Index = $CurrentForm->Index;
        $this->mapa->Upload->uploadFile();
        $this->mapa->CurrentValue = $this->mapa->Upload->FileName;
        $this->formulario->Upload->Index = $CurrentForm->Index;
        $this->formulario->Upload->uploadFile();
        $this->formulario->CurrentValue = $this->formulario->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'idprocesso' first before field var 'x_idprocesso'
        $val = $CurrentForm->hasValue("idprocesso") ? $CurrentForm->getValue("idprocesso") : $CurrentForm->getValue("x_idprocesso");
        if (!$this->idprocesso->IsDetailKey) {
            $this->idprocesso->setFormValue($val);
        }

        // Check field name 'dt_cadastro' first before field var 'x_dt_cadastro'
        $val = $CurrentForm->hasValue("dt_cadastro") ? $CurrentForm->getValue("dt_cadastro") : $CurrentForm->getValue("x_dt_cadastro");
        if (!$this->dt_cadastro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dt_cadastro->Visible = false; // Disable update for API request
            } else {
                $this->dt_cadastro->setFormValue($val, true, $validate);
            }
            $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        }

        // Check field name 'revisao' first before field var 'x_revisao'
        $val = $CurrentForm->hasValue("revisao") ? $CurrentForm->getValue("revisao") : $CurrentForm->getValue("x_revisao");
        if (!$this->revisao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->revisao->Visible = false; // Disable update for API request
            } else {
                $this->revisao->setFormValue($val);
            }
        }

        // Check field name 'tipo_idtipo' first before field var 'x_tipo_idtipo'
        $val = $CurrentForm->hasValue("tipo_idtipo") ? $CurrentForm->getValue("tipo_idtipo") : $CurrentForm->getValue("x_tipo_idtipo");
        if (!$this->tipo_idtipo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_idtipo->Visible = false; // Disable update for API request
            } else {
                $this->tipo_idtipo->setFormValue($val);
            }
        }

        // Check field name 'processo' first before field var 'x_processo'
        $val = $CurrentForm->hasValue("processo") ? $CurrentForm->getValue("processo") : $CurrentForm->getValue("x_processo");
        if (!$this->processo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->processo->Visible = false; // Disable update for API request
            } else {
                $this->processo->setFormValue($val);
            }
        }

        // Check field name 'responsaveis' first before field var 'x_responsaveis'
        $val = $CurrentForm->hasValue("responsaveis") ? $CurrentForm->getValue("responsaveis") : $CurrentForm->getValue("x_responsaveis");
        if (!$this->responsaveis->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->responsaveis->Visible = false; // Disable update for API request
            } else {
                $this->responsaveis->setFormValue($val);
            }
        }

        // Check field name 'objetivo' first before field var 'x_objetivo'
        $val = $CurrentForm->hasValue("objetivo") ? $CurrentForm->getValue("objetivo") : $CurrentForm->getValue("x_objetivo");
        if (!$this->objetivo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->objetivo->Visible = false; // Disable update for API request
            } else {
                $this->objetivo->setFormValue($val);
            }
        }

        // Check field name 'proc_antes' first before field var 'x_proc_antes'
        $val = $CurrentForm->hasValue("proc_antes") ? $CurrentForm->getValue("proc_antes") : $CurrentForm->getValue("x_proc_antes");
        if (!$this->proc_antes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->proc_antes->Visible = false; // Disable update for API request
            } else {
                $this->proc_antes->setFormValue($val);
            }
        }

        // Check field name 'proc_depois' first before field var 'x_proc_depois'
        $val = $CurrentForm->hasValue("proc_depois") ? $CurrentForm->getValue("proc_depois") : $CurrentForm->getValue("x_proc_depois");
        if (!$this->proc_depois->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->proc_depois->Visible = false; // Disable update for API request
            } else {
                $this->proc_depois->setFormValue($val);
            }
        }

        // Check field name 'eqpto_recursos' first before field var 'x_eqpto_recursos'
        $val = $CurrentForm->hasValue("eqpto_recursos") ? $CurrentForm->getValue("eqpto_recursos") : $CurrentForm->getValue("x_eqpto_recursos");
        if (!$this->eqpto_recursos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->eqpto_recursos->Visible = false; // Disable update for API request
            } else {
                $this->eqpto_recursos->setFormValue($val);
            }
        }

        // Check field name 'entradas' first before field var 'x_entradas'
        $val = $CurrentForm->hasValue("entradas") ? $CurrentForm->getValue("entradas") : $CurrentForm->getValue("x_entradas");
        if (!$this->entradas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->entradas->Visible = false; // Disable update for API request
            } else {
                $this->entradas->setFormValue($val);
            }
        }

        // Check field name 'atividade_principal' first before field var 'x_atividade_principal'
        $val = $CurrentForm->hasValue("atividade_principal") ? $CurrentForm->getValue("atividade_principal") : $CurrentForm->getValue("x_atividade_principal");
        if (!$this->atividade_principal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->atividade_principal->Visible = false; // Disable update for API request
            } else {
                $this->atividade_principal->setFormValue($val);
            }
        }

        // Check field name 'saidas_resultados' first before field var 'x_saidas_resultados'
        $val = $CurrentForm->hasValue("saidas_resultados") ? $CurrentForm->getValue("saidas_resultados") : $CurrentForm->getValue("x_saidas_resultados");
        if (!$this->saidas_resultados->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->saidas_resultados->Visible = false; // Disable update for API request
            } else {
                $this->saidas_resultados->setFormValue($val);
            }
        }

        // Check field name 'requsito_saidas' first before field var 'x_requsito_saidas'
        $val = $CurrentForm->hasValue("requsito_saidas") ? $CurrentForm->getValue("requsito_saidas") : $CurrentForm->getValue("x_requsito_saidas");
        if (!$this->requsito_saidas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->requsito_saidas->Visible = false; // Disable update for API request
            } else {
                $this->requsito_saidas->setFormValue($val);
            }
        }

        // Check field name 'riscos' first before field var 'x_riscos'
        $val = $CurrentForm->hasValue("riscos") ? $CurrentForm->getValue("riscos") : $CurrentForm->getValue("x_riscos");
        if (!$this->riscos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->riscos->Visible = false; // Disable update for API request
            } else {
                $this->riscos->setFormValue($val);
            }
        }

        // Check field name 'oportunidades' first before field var 'x_oportunidades'
        $val = $CurrentForm->hasValue("oportunidades") ? $CurrentForm->getValue("oportunidades") : $CurrentForm->getValue("x_oportunidades");
        if (!$this->oportunidades->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->oportunidades->Visible = false; // Disable update for API request
            } else {
                $this->oportunidades->setFormValue($val);
            }
        }

        // Check field name 'propriedade_externa' first before field var 'x_propriedade_externa'
        $val = $CurrentForm->hasValue("propriedade_externa") ? $CurrentForm->getValue("propriedade_externa") : $CurrentForm->getValue("x_propriedade_externa");
        if (!$this->propriedade_externa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->propriedade_externa->Visible = false; // Disable update for API request
            } else {
                $this->propriedade_externa->setFormValue($val);
            }
        }

        // Check field name 'conhecimentos' first before field var 'x_conhecimentos'
        $val = $CurrentForm->hasValue("conhecimentos") ? $CurrentForm->getValue("conhecimentos") : $CurrentForm->getValue("x_conhecimentos");
        if (!$this->conhecimentos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->conhecimentos->Visible = false; // Disable update for API request
            } else {
                $this->conhecimentos->setFormValue($val);
            }
        }

        // Check field name 'documentos_aplicados' first before field var 'x_documentos_aplicados'
        $val = $CurrentForm->hasValue("documentos_aplicados") ? $CurrentForm->getValue("documentos_aplicados") : $CurrentForm->getValue("x_documentos_aplicados");
        if (!$this->documentos_aplicados->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->documentos_aplicados->Visible = false; // Disable update for API request
            } else {
                $this->documentos_aplicados->setFormValue($val);
            }
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idprocesso->CurrentValue = $this->idprocesso->FormValue;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->revisao->CurrentValue = $this->revisao->FormValue;
        $this->tipo_idtipo->CurrentValue = $this->tipo_idtipo->FormValue;
        $this->processo->CurrentValue = $this->processo->FormValue;
        $this->responsaveis->CurrentValue = $this->responsaveis->FormValue;
        $this->objetivo->CurrentValue = $this->objetivo->FormValue;
        $this->proc_antes->CurrentValue = $this->proc_antes->FormValue;
        $this->proc_depois->CurrentValue = $this->proc_depois->FormValue;
        $this->eqpto_recursos->CurrentValue = $this->eqpto_recursos->FormValue;
        $this->entradas->CurrentValue = $this->entradas->FormValue;
        $this->atividade_principal->CurrentValue = $this->atividade_principal->FormValue;
        $this->saidas_resultados->CurrentValue = $this->saidas_resultados->FormValue;
        $this->requsito_saidas->CurrentValue = $this->requsito_saidas->FormValue;
        $this->riscos->CurrentValue = $this->riscos->FormValue;
        $this->oportunidades->CurrentValue = $this->oportunidades->FormValue;
        $this->propriedade_externa->CurrentValue = $this->propriedade_externa->FormValue;
        $this->conhecimentos->CurrentValue = $this->conhecimentos->FormValue;
        $this->documentos_aplicados->CurrentValue = $this->documentos_aplicados->FormValue;
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
        $this->idprocesso->setDbValue($row['idprocesso']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->revisao->setDbValue($row['revisao']);
        $this->tipo_idtipo->setDbValue($row['tipo_idtipo']);
        $this->processo->setDbValue($row['processo']);
        $this->responsaveis->setDbValue($row['responsaveis']);
        $this->objetivo->setDbValue($row['objetivo']);
        $this->proc_antes->setDbValue($row['proc_antes']);
        $this->proc_depois->setDbValue($row['proc_depois']);
        $this->eqpto_recursos->setDbValue($row['eqpto_recursos']);
        $this->entradas->setDbValue($row['entradas']);
        $this->atividade_principal->setDbValue($row['atividade_principal']);
        $this->saidas_resultados->setDbValue($row['saidas_resultados']);
        $this->requsito_saidas->setDbValue($row['requsito_saidas']);
        $this->riscos->setDbValue($row['riscos']);
        $this->oportunidades->setDbValue($row['oportunidades']);
        $this->propriedade_externa->setDbValue($row['propriedade_externa']);
        $this->conhecimentos->setDbValue($row['conhecimentos']);
        $this->documentos_aplicados->setDbValue($row['documentos_aplicados']);
        $this->proced_int_trabalho->Upload->DbValue = $row['proced_int_trabalho'];
        $this->proced_int_trabalho->setDbValue($this->proced_int_trabalho->Upload->DbValue);
        $this->mapa->Upload->DbValue = $row['mapa'];
        $this->mapa->setDbValue($this->mapa->Upload->DbValue);
        $this->formulario->Upload->DbValue = $row['formulario'];
        $this->formulario->setDbValue($this->formulario->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idprocesso'] = $this->idprocesso->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['revisao'] = $this->revisao->DefaultValue;
        $row['tipo_idtipo'] = $this->tipo_idtipo->DefaultValue;
        $row['processo'] = $this->processo->DefaultValue;
        $row['responsaveis'] = $this->responsaveis->DefaultValue;
        $row['objetivo'] = $this->objetivo->DefaultValue;
        $row['proc_antes'] = $this->proc_antes->DefaultValue;
        $row['proc_depois'] = $this->proc_depois->DefaultValue;
        $row['eqpto_recursos'] = $this->eqpto_recursos->DefaultValue;
        $row['entradas'] = $this->entradas->DefaultValue;
        $row['atividade_principal'] = $this->atividade_principal->DefaultValue;
        $row['saidas_resultados'] = $this->saidas_resultados->DefaultValue;
        $row['requsito_saidas'] = $this->requsito_saidas->DefaultValue;
        $row['riscos'] = $this->riscos->DefaultValue;
        $row['oportunidades'] = $this->oportunidades->DefaultValue;
        $row['propriedade_externa'] = $this->propriedade_externa->DefaultValue;
        $row['conhecimentos'] = $this->conhecimentos->DefaultValue;
        $row['documentos_aplicados'] = $this->documentos_aplicados->DefaultValue;
        $row['proced_int_trabalho'] = $this->proced_int_trabalho->DefaultValue;
        $row['mapa'] = $this->mapa->DefaultValue;
        $row['formulario'] = $this->formulario->DefaultValue;
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

        // idprocesso
        $this->idprocesso->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // revisao
        $this->revisao->RowCssClass = "row";

        // tipo_idtipo
        $this->tipo_idtipo->RowCssClass = "row";

        // processo
        $this->processo->RowCssClass = "row";

        // responsaveis
        $this->responsaveis->RowCssClass = "row";

        // objetivo
        $this->objetivo->RowCssClass = "row";

        // proc_antes
        $this->proc_antes->RowCssClass = "row";

        // proc_depois
        $this->proc_depois->RowCssClass = "row";

        // eqpto_recursos
        $this->eqpto_recursos->RowCssClass = "row";

        // entradas
        $this->entradas->RowCssClass = "row";

        // atividade_principal
        $this->atividade_principal->RowCssClass = "row";

        // saidas_resultados
        $this->saidas_resultados->RowCssClass = "row";

        // requsito_saidas
        $this->requsito_saidas->RowCssClass = "row";

        // riscos
        $this->riscos->RowCssClass = "row";

        // oportunidades
        $this->oportunidades->RowCssClass = "row";

        // propriedade_externa
        $this->propriedade_externa->RowCssClass = "row";

        // conhecimentos
        $this->conhecimentos->RowCssClass = "row";

        // documentos_aplicados
        $this->documentos_aplicados->RowCssClass = "row";

        // proced_int_trabalho
        $this->proced_int_trabalho->RowCssClass = "row";

        // mapa
        $this->mapa->RowCssClass = "row";

        // formulario
        $this->formulario->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idprocesso
            $this->idprocesso->ViewValue = $this->idprocesso->CurrentValue;

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // revisao
            $this->revisao->ViewValue = $this->revisao->CurrentValue;
            $this->revisao->CssClass = "fw-bold";
            $this->revisao->CellCssStyle .= "text-align: center;";

            // tipo_idtipo
            $curVal = strval($this->tipo_idtipo->CurrentValue);
            if ($curVal != "") {
                $this->tipo_idtipo->ViewValue = $this->tipo_idtipo->lookupCacheOption($curVal);
                if ($this->tipo_idtipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchExpression(), "=", $curVal, $this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchDataType(), "");
                    $sqlWrk = $this->tipo_idtipo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_idtipo->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_idtipo->ViewValue = $this->tipo_idtipo->displayValue($arwrk);
                    } else {
                        $this->tipo_idtipo->ViewValue = FormatNumber($this->tipo_idtipo->CurrentValue, $this->tipo_idtipo->formatPattern());
                    }
                }
            } else {
                $this->tipo_idtipo->ViewValue = null;
            }
            $this->tipo_idtipo->CssClass = "fw-bold";

            // processo
            $this->processo->ViewValue = $this->processo->CurrentValue;
            $this->processo->CssClass = "fw-bold";

            // responsaveis
            $curVal = strval($this->responsaveis->CurrentValue);
            if ($curVal != "") {
                $this->responsaveis->ViewValue = $this->responsaveis->lookupCacheOption($curVal);
                if ($this->responsaveis->ViewValue === null) { // Lookup from database
                    $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        AddFilter($filterWrk, SearchFilter($this->responsaveis->Lookup->getTable()->Fields["iddepartamentos"]->searchExpression(), "=", trim($wrk), $this->responsaveis->Lookup->getTable()->Fields["iddepartamentos"]->searchDataType(), ""), "OR");
                    }
                    $sqlWrk = $this->responsaveis->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->responsaveis->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->responsaveis->Lookup->renderViewRow($row);
                            $this->responsaveis->ViewValue->add($this->responsaveis->displayValue($arwrk));
                        }
                    } else {
                        $this->responsaveis->ViewValue = $this->responsaveis->CurrentValue;
                    }
                }
            } else {
                $this->responsaveis->ViewValue = null;
            }
            $this->responsaveis->CssClass = "fw-bold";

            // objetivo
            $this->objetivo->ViewValue = $this->objetivo->CurrentValue;
            $this->objetivo->CssClass = "fw-bold";

            // proc_antes
            $curVal = strval($this->proc_antes->CurrentValue);
            if ($curVal != "") {
                $this->proc_antes->ViewValue = $this->proc_antes->lookupCacheOption($curVal);
                if ($this->proc_antes->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->proc_antes->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $curVal, $this->proc_antes->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                    $lookupFilter = $this->proc_antes->getSelectFilter($this); // PHP
                    $sqlWrk = $this->proc_antes->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->proc_antes->Lookup->renderViewRow($rswrk[0]);
                        $this->proc_antes->ViewValue = $this->proc_antes->displayValue($arwrk);
                    } else {
                        $this->proc_antes->ViewValue = FormatNumber($this->proc_antes->CurrentValue, $this->proc_antes->formatPattern());
                    }
                }
            } else {
                $this->proc_antes->ViewValue = null;
            }
            $this->proc_antes->CssClass = "fw-bold";

            // proc_depois
            $curVal = strval($this->proc_depois->CurrentValue);
            if ($curVal != "") {
                $this->proc_depois->ViewValue = $this->proc_depois->lookupCacheOption($curVal);
                if ($this->proc_depois->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->proc_depois->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $curVal, $this->proc_depois->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                    $lookupFilter = $this->proc_depois->getSelectFilter($this); // PHP
                    $sqlWrk = $this->proc_depois->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->proc_depois->Lookup->renderViewRow($rswrk[0]);
                        $this->proc_depois->ViewValue = $this->proc_depois->displayValue($arwrk);
                    } else {
                        $this->proc_depois->ViewValue = FormatNumber($this->proc_depois->CurrentValue, $this->proc_depois->formatPattern());
                    }
                }
            } else {
                $this->proc_depois->ViewValue = null;
            }
            $this->proc_depois->CssClass = "fw-bold";

            // eqpto_recursos
            $this->eqpto_recursos->ViewValue = $this->eqpto_recursos->CurrentValue;
            $this->eqpto_recursos->CssClass = "fw-bold";

            // entradas
            $this->entradas->ViewValue = $this->entradas->CurrentValue;
            $this->entradas->CssClass = "fw-bold";

            // atividade_principal
            $this->atividade_principal->ViewValue = $this->atividade_principal->CurrentValue;
            $this->atividade_principal->CssClass = "fw-bold";

            // saidas_resultados
            $this->saidas_resultados->ViewValue = $this->saidas_resultados->CurrentValue;
            $this->saidas_resultados->CssClass = "fw-bold";

            // requsito_saidas
            $this->requsito_saidas->ViewValue = $this->requsito_saidas->CurrentValue;
            $this->requsito_saidas->CssClass = "fw-bold";

            // riscos
            $this->riscos->ViewValue = $this->riscos->CurrentValue;
            $this->riscos->CssClass = "fw-bold";

            // oportunidades
            $this->oportunidades->ViewValue = $this->oportunidades->CurrentValue;
            $this->oportunidades->CssClass = "fw-bold";

            // propriedade_externa
            $this->propriedade_externa->ViewValue = $this->propriedade_externa->CurrentValue;
            $this->propriedade_externa->CssClass = "fw-bold";

            // conhecimentos
            $this->conhecimentos->ViewValue = $this->conhecimentos->CurrentValue;
            $this->conhecimentos->CssClass = "fw-bold";

            // documentos_aplicados
            $this->documentos_aplicados->ViewValue = $this->documentos_aplicados->CurrentValue;
            $this->documentos_aplicados->CssClass = "fw-bold";

            // proced_int_trabalho
            if (!EmptyValue($this->proced_int_trabalho->Upload->DbValue)) {
                $this->proced_int_trabalho->ViewValue = $this->proced_int_trabalho->Upload->DbValue;
            } else {
                $this->proced_int_trabalho->ViewValue = "";
            }
            $this->proced_int_trabalho->CssClass = "fw-bold";

            // mapa
            if (!EmptyValue($this->mapa->Upload->DbValue)) {
                $this->mapa->ViewValue = $this->mapa->Upload->DbValue;
            } else {
                $this->mapa->ViewValue = "";
            }
            $this->mapa->CssClass = "fw-bold";

            // formulario
            if (!EmptyValue($this->formulario->Upload->DbValue)) {
                $this->formulario->ViewValue = $this->formulario->Upload->DbValue;
            } else {
                $this->formulario->ViewValue = "";
            }
            $this->formulario->CssClass = "fw-bold";

            // idprocesso
            $this->idprocesso->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // revisao
            $this->revisao->HrefValue = "";

            // tipo_idtipo
            $this->tipo_idtipo->HrefValue = "";

            // processo
            $this->processo->HrefValue = "";

            // responsaveis
            $this->responsaveis->HrefValue = "";

            // objetivo
            $this->objetivo->HrefValue = "";

            // proc_antes
            $this->proc_antes->HrefValue = "";

            // proc_depois
            $this->proc_depois->HrefValue = "";

            // eqpto_recursos
            $this->eqpto_recursos->HrefValue = "";

            // entradas
            $this->entradas->HrefValue = "";

            // atividade_principal
            $this->atividade_principal->HrefValue = "";

            // saidas_resultados
            $this->saidas_resultados->HrefValue = "";

            // requsito_saidas
            $this->requsito_saidas->HrefValue = "";

            // riscos
            $this->riscos->HrefValue = "";

            // oportunidades
            $this->oportunidades->HrefValue = "";

            // propriedade_externa
            $this->propriedade_externa->HrefValue = "";

            // conhecimentos
            $this->conhecimentos->HrefValue = "";

            // documentos_aplicados
            $this->documentos_aplicados->HrefValue = "";

            // proced_int_trabalho
            $this->proced_int_trabalho->HrefValue = "";
            $this->proced_int_trabalho->ExportHrefValue = $this->proced_int_trabalho->UploadPath . $this->proced_int_trabalho->Upload->DbValue;

            // mapa
            $this->mapa->HrefValue = "";
            $this->mapa->ExportHrefValue = $this->mapa->UploadPath . $this->mapa->Upload->DbValue;

            // formulario
            $this->formulario->HrefValue = "";
            $this->formulario->ExportHrefValue = $this->formulario->UploadPath . $this->formulario->Upload->DbValue;
        } elseif ($this->RowType == RowType::EDIT) {
            // idprocesso
            $this->idprocesso->setupEditAttributes();
            $this->idprocesso->EditValue = $this->idprocesso->CurrentValue;

            // dt_cadastro
            $this->dt_cadastro->setupEditAttributes();
            $this->dt_cadastro->EditValue = HtmlEncode(FormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern()));
            $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

            // revisao
            $this->revisao->setupEditAttributes();
            if (!$this->revisao->Raw) {
                $this->revisao->CurrentValue = HtmlDecode($this->revisao->CurrentValue);
            }
            $this->revisao->EditValue = HtmlEncode($this->revisao->CurrentValue);
            $this->revisao->PlaceHolder = RemoveHtml($this->revisao->caption());

            // tipo_idtipo
            $curVal = trim(strval($this->tipo_idtipo->CurrentValue));
            if ($curVal != "") {
                $this->tipo_idtipo->ViewValue = $this->tipo_idtipo->lookupCacheOption($curVal);
            } else {
                $this->tipo_idtipo->ViewValue = $this->tipo_idtipo->Lookup !== null && is_array($this->tipo_idtipo->lookupOptions()) && count($this->tipo_idtipo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_idtipo->ViewValue !== null) { // Load from cache
                $this->tipo_idtipo->EditValue = array_values($this->tipo_idtipo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchExpression(), "=", $this->tipo_idtipo->CurrentValue, $this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipo_idtipo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_idtipo->EditValue = $arwrk;
            }
            $this->tipo_idtipo->PlaceHolder = RemoveHtml($this->tipo_idtipo->caption());

            // processo
            $this->processo->setupEditAttributes();
            if (!$this->processo->Raw) {
                $this->processo->CurrentValue = HtmlDecode($this->processo->CurrentValue);
            }
            $this->processo->EditValue = HtmlEncode($this->processo->CurrentValue);
            $this->processo->PlaceHolder = RemoveHtml($this->processo->caption());

            // responsaveis
            $curVal = trim(strval($this->responsaveis->CurrentValue));
            if ($curVal != "") {
                $this->responsaveis->ViewValue = $this->responsaveis->lookupCacheOption($curVal);
            } else {
                $this->responsaveis->ViewValue = $this->responsaveis->Lookup !== null && is_array($this->responsaveis->lookupOptions()) && count($this->responsaveis->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->responsaveis->ViewValue !== null) { // Load from cache
                $this->responsaveis->EditValue = array_values($this->responsaveis->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        AddFilter($filterWrk, SearchFilter($this->responsaveis->Lookup->getTable()->Fields["iddepartamentos"]->searchExpression(), "=", trim($wrk), $this->responsaveis->Lookup->getTable()->Fields["iddepartamentos"]->searchDataType(), ""), "OR");
                    }
                }
                $sqlWrk = $this->responsaveis->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->responsaveis->EditValue = $arwrk;
            }
            $this->responsaveis->PlaceHolder = RemoveHtml($this->responsaveis->caption());

            // objetivo
            $this->objetivo->setupEditAttributes();
            $this->objetivo->EditValue = HtmlEncode($this->objetivo->CurrentValue);
            $this->objetivo->PlaceHolder = RemoveHtml($this->objetivo->caption());

            // proc_antes
            $curVal = trim(strval($this->proc_antes->CurrentValue));
            if ($curVal != "") {
                $this->proc_antes->ViewValue = $this->proc_antes->lookupCacheOption($curVal);
            } else {
                $this->proc_antes->ViewValue = $this->proc_antes->Lookup !== null && is_array($this->proc_antes->lookupOptions()) && count($this->proc_antes->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->proc_antes->ViewValue !== null) { // Load from cache
                $this->proc_antes->EditValue = array_values($this->proc_antes->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->proc_antes->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $this->proc_antes->CurrentValue, $this->proc_antes->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                }
                $lookupFilter = $this->proc_antes->getSelectFilter($this); // PHP
                $sqlWrk = $this->proc_antes->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->proc_antes->EditValue = $arwrk;
            }
            $this->proc_antes->PlaceHolder = RemoveHtml($this->proc_antes->caption());

            // proc_depois
            $curVal = trim(strval($this->proc_depois->CurrentValue));
            if ($curVal != "") {
                $this->proc_depois->ViewValue = $this->proc_depois->lookupCacheOption($curVal);
            } else {
                $this->proc_depois->ViewValue = $this->proc_depois->Lookup !== null && is_array($this->proc_depois->lookupOptions()) && count($this->proc_depois->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->proc_depois->ViewValue !== null) { // Load from cache
                $this->proc_depois->EditValue = array_values($this->proc_depois->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->proc_depois->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $this->proc_depois->CurrentValue, $this->proc_depois->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                }
                $lookupFilter = $this->proc_depois->getSelectFilter($this); // PHP
                $sqlWrk = $this->proc_depois->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->proc_depois->EditValue = $arwrk;
            }
            $this->proc_depois->PlaceHolder = RemoveHtml($this->proc_depois->caption());

            // eqpto_recursos
            $this->eqpto_recursos->setupEditAttributes();
            $this->eqpto_recursos->EditValue = HtmlEncode($this->eqpto_recursos->CurrentValue);
            $this->eqpto_recursos->PlaceHolder = RemoveHtml($this->eqpto_recursos->caption());

            // entradas
            $this->entradas->setupEditAttributes();
            $this->entradas->EditValue = HtmlEncode($this->entradas->CurrentValue);
            $this->entradas->PlaceHolder = RemoveHtml($this->entradas->caption());

            // atividade_principal
            $this->atividade_principal->setupEditAttributes();
            $this->atividade_principal->EditValue = HtmlEncode($this->atividade_principal->CurrentValue);
            $this->atividade_principal->PlaceHolder = RemoveHtml($this->atividade_principal->caption());

            // saidas_resultados
            $this->saidas_resultados->setupEditAttributes();
            $this->saidas_resultados->EditValue = HtmlEncode($this->saidas_resultados->CurrentValue);
            $this->saidas_resultados->PlaceHolder = RemoveHtml($this->saidas_resultados->caption());

            // requsito_saidas
            $this->requsito_saidas->setupEditAttributes();
            $this->requsito_saidas->EditValue = HtmlEncode($this->requsito_saidas->CurrentValue);
            $this->requsito_saidas->PlaceHolder = RemoveHtml($this->requsito_saidas->caption());

            // riscos
            $this->riscos->setupEditAttributes();
            $this->riscos->EditValue = HtmlEncode($this->riscos->CurrentValue);
            $this->riscos->PlaceHolder = RemoveHtml($this->riscos->caption());

            // oportunidades
            $this->oportunidades->setupEditAttributes();
            $this->oportunidades->EditValue = HtmlEncode($this->oportunidades->CurrentValue);
            $this->oportunidades->PlaceHolder = RemoveHtml($this->oportunidades->caption());

            // propriedade_externa
            $this->propriedade_externa->setupEditAttributes();
            $this->propriedade_externa->EditValue = HtmlEncode($this->propriedade_externa->CurrentValue);
            $this->propriedade_externa->PlaceHolder = RemoveHtml($this->propriedade_externa->caption());

            // conhecimentos
            $this->conhecimentos->setupEditAttributes();
            $this->conhecimentos->EditValue = HtmlEncode($this->conhecimentos->CurrentValue);
            $this->conhecimentos->PlaceHolder = RemoveHtml($this->conhecimentos->caption());

            // documentos_aplicados
            $this->documentos_aplicados->setupEditAttributes();
            $this->documentos_aplicados->EditValue = HtmlEncode($this->documentos_aplicados->CurrentValue);
            $this->documentos_aplicados->PlaceHolder = RemoveHtml($this->documentos_aplicados->caption());

            // proced_int_trabalho
            $this->proced_int_trabalho->setupEditAttributes();
            if (!EmptyValue($this->proced_int_trabalho->Upload->DbValue)) {
                $this->proced_int_trabalho->EditValue = $this->proced_int_trabalho->Upload->DbValue;
            } else {
                $this->proced_int_trabalho->EditValue = "";
            }
            if (!EmptyValue($this->proced_int_trabalho->CurrentValue)) {
                $this->proced_int_trabalho->Upload->FileName = $this->proced_int_trabalho->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->proced_int_trabalho);
            }

            // mapa
            $this->mapa->setupEditAttributes();
            if (!EmptyValue($this->mapa->Upload->DbValue)) {
                $this->mapa->EditValue = $this->mapa->Upload->DbValue;
            } else {
                $this->mapa->EditValue = "";
            }
            if (!EmptyValue($this->mapa->CurrentValue)) {
                $this->mapa->Upload->FileName = $this->mapa->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->mapa);
            }

            // formulario
            $this->formulario->setupEditAttributes();
            if (!EmptyValue($this->formulario->Upload->DbValue)) {
                $this->formulario->EditValue = $this->formulario->Upload->DbValue;
            } else {
                $this->formulario->EditValue = "";
            }
            if (!EmptyValue($this->formulario->CurrentValue)) {
                $this->formulario->Upload->FileName = $this->formulario->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->formulario);
            }

            // Edit refer script

            // idprocesso
            $this->idprocesso->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // revisao
            $this->revisao->HrefValue = "";

            // tipo_idtipo
            $this->tipo_idtipo->HrefValue = "";

            // processo
            $this->processo->HrefValue = "";

            // responsaveis
            $this->responsaveis->HrefValue = "";

            // objetivo
            $this->objetivo->HrefValue = "";

            // proc_antes
            $this->proc_antes->HrefValue = "";

            // proc_depois
            $this->proc_depois->HrefValue = "";

            // eqpto_recursos
            $this->eqpto_recursos->HrefValue = "";

            // entradas
            $this->entradas->HrefValue = "";

            // atividade_principal
            $this->atividade_principal->HrefValue = "";

            // saidas_resultados
            $this->saidas_resultados->HrefValue = "";

            // requsito_saidas
            $this->requsito_saidas->HrefValue = "";

            // riscos
            $this->riscos->HrefValue = "";

            // oportunidades
            $this->oportunidades->HrefValue = "";

            // propriedade_externa
            $this->propriedade_externa->HrefValue = "";

            // conhecimentos
            $this->conhecimentos->HrefValue = "";

            // documentos_aplicados
            $this->documentos_aplicados->HrefValue = "";

            // proced_int_trabalho
            $this->proced_int_trabalho->HrefValue = "";
            $this->proced_int_trabalho->ExportHrefValue = $this->proced_int_trabalho->UploadPath . $this->proced_int_trabalho->Upload->DbValue;

            // mapa
            $this->mapa->HrefValue = "";
            $this->mapa->ExportHrefValue = $this->mapa->UploadPath . $this->mapa->Upload->DbValue;

            // formulario
            $this->formulario->HrefValue = "";
            $this->formulario->ExportHrefValue = $this->formulario->UploadPath . $this->formulario->Upload->DbValue;
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
            if ($this->idprocesso->Visible && $this->idprocesso->Required) {
                if (!$this->idprocesso->IsDetailKey && EmptyValue($this->idprocesso->FormValue)) {
                    $this->idprocesso->addErrorMessage(str_replace("%s", $this->idprocesso->caption(), $this->idprocesso->RequiredErrorMessage));
                }
            }
            if ($this->dt_cadastro->Visible && $this->dt_cadastro->Required) {
                if (!$this->dt_cadastro->IsDetailKey && EmptyValue($this->dt_cadastro->FormValue)) {
                    $this->dt_cadastro->addErrorMessage(str_replace("%s", $this->dt_cadastro->caption(), $this->dt_cadastro->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->dt_cadastro->FormValue, $this->dt_cadastro->formatPattern())) {
                $this->dt_cadastro->addErrorMessage($this->dt_cadastro->getErrorMessage(false));
            }
            if ($this->revisao->Visible && $this->revisao->Required) {
                if (!$this->revisao->IsDetailKey && EmptyValue($this->revisao->FormValue)) {
                    $this->revisao->addErrorMessage(str_replace("%s", $this->revisao->caption(), $this->revisao->RequiredErrorMessage));
                }
            }
            if ($this->tipo_idtipo->Visible && $this->tipo_idtipo->Required) {
                if ($this->tipo_idtipo->FormValue == "") {
                    $this->tipo_idtipo->addErrorMessage(str_replace("%s", $this->tipo_idtipo->caption(), $this->tipo_idtipo->RequiredErrorMessage));
                }
            }
            if ($this->processo->Visible && $this->processo->Required) {
                if (!$this->processo->IsDetailKey && EmptyValue($this->processo->FormValue)) {
                    $this->processo->addErrorMessage(str_replace("%s", $this->processo->caption(), $this->processo->RequiredErrorMessage));
                }
            }
            if ($this->responsaveis->Visible && $this->responsaveis->Required) {
                if ($this->responsaveis->FormValue == "") {
                    $this->responsaveis->addErrorMessage(str_replace("%s", $this->responsaveis->caption(), $this->responsaveis->RequiredErrorMessage));
                }
            }
            if ($this->objetivo->Visible && $this->objetivo->Required) {
                if (!$this->objetivo->IsDetailKey && EmptyValue($this->objetivo->FormValue)) {
                    $this->objetivo->addErrorMessage(str_replace("%s", $this->objetivo->caption(), $this->objetivo->RequiredErrorMessage));
                }
            }
            if ($this->proc_antes->Visible && $this->proc_antes->Required) {
                if ($this->proc_antes->FormValue == "") {
                    $this->proc_antes->addErrorMessage(str_replace("%s", $this->proc_antes->caption(), $this->proc_antes->RequiredErrorMessage));
                }
            }
            if ($this->proc_depois->Visible && $this->proc_depois->Required) {
                if ($this->proc_depois->FormValue == "") {
                    $this->proc_depois->addErrorMessage(str_replace("%s", $this->proc_depois->caption(), $this->proc_depois->RequiredErrorMessage));
                }
            }
            if ($this->eqpto_recursos->Visible && $this->eqpto_recursos->Required) {
                if (!$this->eqpto_recursos->IsDetailKey && EmptyValue($this->eqpto_recursos->FormValue)) {
                    $this->eqpto_recursos->addErrorMessage(str_replace("%s", $this->eqpto_recursos->caption(), $this->eqpto_recursos->RequiredErrorMessage));
                }
            }
            if ($this->entradas->Visible && $this->entradas->Required) {
                if (!$this->entradas->IsDetailKey && EmptyValue($this->entradas->FormValue)) {
                    $this->entradas->addErrorMessage(str_replace("%s", $this->entradas->caption(), $this->entradas->RequiredErrorMessage));
                }
            }
            if ($this->atividade_principal->Visible && $this->atividade_principal->Required) {
                if (!$this->atividade_principal->IsDetailKey && EmptyValue($this->atividade_principal->FormValue)) {
                    $this->atividade_principal->addErrorMessage(str_replace("%s", $this->atividade_principal->caption(), $this->atividade_principal->RequiredErrorMessage));
                }
            }
            if ($this->saidas_resultados->Visible && $this->saidas_resultados->Required) {
                if (!$this->saidas_resultados->IsDetailKey && EmptyValue($this->saidas_resultados->FormValue)) {
                    $this->saidas_resultados->addErrorMessage(str_replace("%s", $this->saidas_resultados->caption(), $this->saidas_resultados->RequiredErrorMessage));
                }
            }
            if ($this->requsito_saidas->Visible && $this->requsito_saidas->Required) {
                if (!$this->requsito_saidas->IsDetailKey && EmptyValue($this->requsito_saidas->FormValue)) {
                    $this->requsito_saidas->addErrorMessage(str_replace("%s", $this->requsito_saidas->caption(), $this->requsito_saidas->RequiredErrorMessage));
                }
            }
            if ($this->riscos->Visible && $this->riscos->Required) {
                if (!$this->riscos->IsDetailKey && EmptyValue($this->riscos->FormValue)) {
                    $this->riscos->addErrorMessage(str_replace("%s", $this->riscos->caption(), $this->riscos->RequiredErrorMessage));
                }
            }
            if ($this->oportunidades->Visible && $this->oportunidades->Required) {
                if (!$this->oportunidades->IsDetailKey && EmptyValue($this->oportunidades->FormValue)) {
                    $this->oportunidades->addErrorMessage(str_replace("%s", $this->oportunidades->caption(), $this->oportunidades->RequiredErrorMessage));
                }
            }
            if ($this->propriedade_externa->Visible && $this->propriedade_externa->Required) {
                if (!$this->propriedade_externa->IsDetailKey && EmptyValue($this->propriedade_externa->FormValue)) {
                    $this->propriedade_externa->addErrorMessage(str_replace("%s", $this->propriedade_externa->caption(), $this->propriedade_externa->RequiredErrorMessage));
                }
            }
            if ($this->conhecimentos->Visible && $this->conhecimentos->Required) {
                if (!$this->conhecimentos->IsDetailKey && EmptyValue($this->conhecimentos->FormValue)) {
                    $this->conhecimentos->addErrorMessage(str_replace("%s", $this->conhecimentos->caption(), $this->conhecimentos->RequiredErrorMessage));
                }
            }
            if ($this->documentos_aplicados->Visible && $this->documentos_aplicados->Required) {
                if (!$this->documentos_aplicados->IsDetailKey && EmptyValue($this->documentos_aplicados->FormValue)) {
                    $this->documentos_aplicados->addErrorMessage(str_replace("%s", $this->documentos_aplicados->caption(), $this->documentos_aplicados->RequiredErrorMessage));
                }
            }
            if ($this->proced_int_trabalho->Visible && $this->proced_int_trabalho->Required) {
                if ($this->proced_int_trabalho->Upload->FileName == "" && !$this->proced_int_trabalho->Upload->KeepFile) {
                    $this->proced_int_trabalho->addErrorMessage(str_replace("%s", $this->proced_int_trabalho->caption(), $this->proced_int_trabalho->RequiredErrorMessage));
                }
            }
            if ($this->mapa->Visible && $this->mapa->Required) {
                if ($this->mapa->Upload->FileName == "" && !$this->mapa->Upload->KeepFile) {
                    $this->mapa->addErrorMessage(str_replace("%s", $this->mapa->caption(), $this->mapa->RequiredErrorMessage));
                }
            }
            if ($this->formulario->Visible && $this->formulario->Required) {
                if ($this->formulario->Upload->FileName == "" && !$this->formulario->Upload->KeepFile) {
                    $this->formulario->addErrorMessage(str_replace("%s", $this->formulario->caption(), $this->formulario->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ProcessoIndicadoresGrid");
        if (in_array("processo_indicadores", $detailTblVar) && $detailPage->DetailEdit) {
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

        // Check field with unique index (processo)
        if ($this->processo->CurrentValue != "") {
            $filterChk = "(`processo` = '" . AdjustSql($this->processo->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->processo->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->processo->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }
        if ($this->proced_int_trabalho->Visible && !$this->proced_int_trabalho->Upload->KeepFile) {
            if (!EmptyValue($this->proced_int_trabalho->Upload->FileName)) {
                FixUploadFileNames($this->proced_int_trabalho);
                $this->proced_int_trabalho->setDbValueDef($rsnew, $this->proced_int_trabalho->Upload->FileName, $this->proced_int_trabalho->ReadOnly);
            }
        }
        if ($this->mapa->Visible && !$this->mapa->Upload->KeepFile) {
            if (!EmptyValue($this->mapa->Upload->FileName)) {
                FixUploadFileNames($this->mapa);
                $this->mapa->setDbValueDef($rsnew, $this->mapa->Upload->FileName, $this->mapa->ReadOnly);
            }
        }
        if ($this->formulario->Visible && !$this->formulario->Upload->KeepFile) {
            if (!EmptyValue($this->formulario->Upload->FileName)) {
                FixUploadFileNames($this->formulario);
                $this->formulario->setDbValueDef($rsnew, $this->formulario->Upload->FileName, $this->formulario->ReadOnly);
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
                if ($this->proced_int_trabalho->Visible && !$this->proced_int_trabalho->Upload->KeepFile) {
                    if (!SaveUploadFiles($this->proced_int_trabalho, $rsnew['proced_int_trabalho'], false)) {
                        $this->setFailureMessage($Language->phrase("UploadError7"));
                        return false;
                    }
                }
                if ($this->mapa->Visible && !$this->mapa->Upload->KeepFile) {
                    if (!SaveUploadFiles($this->mapa, $rsnew['mapa'], false)) {
                        $this->setFailureMessage($Language->phrase("UploadError7"));
                        return false;
                    }
                }
                if ($this->formulario->Visible && !$this->formulario->Upload->KeepFile) {
                    if (!SaveUploadFiles($this->formulario, $rsnew['formulario'], false)) {
                        $this->setFailureMessage($Language->phrase("UploadError7"));
                        return false;
                    }
                }
            }

            // Update detail records
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("ProcessoIndicadoresGrid");
            if (in_array("processo_indicadores", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "processo_indicadores"); // Load user level of detail table
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
        $this->dt_cadastro->setDbValueDef($rsnew, UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->ReadOnly);

        // revisao
        $this->revisao->setDbValueDef($rsnew, $this->revisao->CurrentValue, $this->revisao->ReadOnly);

        // tipo_idtipo
        $this->tipo_idtipo->setDbValueDef($rsnew, $this->tipo_idtipo->CurrentValue, $this->tipo_idtipo->ReadOnly);

        // processo
        $this->processo->setDbValueDef($rsnew, $this->processo->CurrentValue, $this->processo->ReadOnly);

        // responsaveis
        $this->responsaveis->setDbValueDef($rsnew, $this->responsaveis->CurrentValue, $this->responsaveis->ReadOnly);

        // objetivo
        $this->objetivo->setDbValueDef($rsnew, $this->objetivo->CurrentValue, $this->objetivo->ReadOnly);

        // proc_antes
        $this->proc_antes->setDbValueDef($rsnew, $this->proc_antes->CurrentValue, $this->proc_antes->ReadOnly);

        // proc_depois
        $this->proc_depois->setDbValueDef($rsnew, $this->proc_depois->CurrentValue, $this->proc_depois->ReadOnly);

        // eqpto_recursos
        $this->eqpto_recursos->setDbValueDef($rsnew, $this->eqpto_recursos->CurrentValue, $this->eqpto_recursos->ReadOnly);

        // entradas
        $this->entradas->setDbValueDef($rsnew, $this->entradas->CurrentValue, $this->entradas->ReadOnly);

        // atividade_principal
        $this->atividade_principal->setDbValueDef($rsnew, $this->atividade_principal->CurrentValue, $this->atividade_principal->ReadOnly);

        // saidas_resultados
        $this->saidas_resultados->setDbValueDef($rsnew, $this->saidas_resultados->CurrentValue, $this->saidas_resultados->ReadOnly);

        // requsito_saidas
        $this->requsito_saidas->setDbValueDef($rsnew, $this->requsito_saidas->CurrentValue, $this->requsito_saidas->ReadOnly);

        // riscos
        $this->riscos->setDbValueDef($rsnew, $this->riscos->CurrentValue, $this->riscos->ReadOnly);

        // oportunidades
        $this->oportunidades->setDbValueDef($rsnew, $this->oportunidades->CurrentValue, $this->oportunidades->ReadOnly);

        // propriedade_externa
        $this->propriedade_externa->setDbValueDef($rsnew, $this->propriedade_externa->CurrentValue, $this->propriedade_externa->ReadOnly);

        // conhecimentos
        $this->conhecimentos->setDbValueDef($rsnew, $this->conhecimentos->CurrentValue, $this->conhecimentos->ReadOnly);

        // documentos_aplicados
        $this->documentos_aplicados->setDbValueDef($rsnew, $this->documentos_aplicados->CurrentValue, $this->documentos_aplicados->ReadOnly);

        // proced_int_trabalho
        if ($this->proced_int_trabalho->Visible && !$this->proced_int_trabalho->ReadOnly && !$this->proced_int_trabalho->Upload->KeepFile) {
            if ($this->proced_int_trabalho->Upload->FileName == "") {
                $rsnew['proced_int_trabalho'] = null;
            } else {
                FixUploadTempFileNames($this->proced_int_trabalho);
                $rsnew['proced_int_trabalho'] = $this->proced_int_trabalho->Upload->FileName;
            }
        }

        // mapa
        if ($this->mapa->Visible && !$this->mapa->ReadOnly && !$this->mapa->Upload->KeepFile) {
            if ($this->mapa->Upload->FileName == "") {
                $rsnew['mapa'] = null;
            } else {
                FixUploadTempFileNames($this->mapa);
                $rsnew['mapa'] = $this->mapa->Upload->FileName;
            }
        }

        // formulario
        if ($this->formulario->Visible && !$this->formulario->ReadOnly && !$this->formulario->Upload->KeepFile) {
            if ($this->formulario->Upload->FileName == "") {
                $rsnew['formulario'] = null;
            } else {
                FixUploadTempFileNames($this->formulario);
                $rsnew['formulario'] = $this->formulario->Upload->FileName;
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
        if (isset($row['dt_cadastro'])) { // dt_cadastro
            $this->dt_cadastro->CurrentValue = $row['dt_cadastro'];
        }
        if (isset($row['revisao'])) { // revisao
            $this->revisao->CurrentValue = $row['revisao'];
        }
        if (isset($row['tipo_idtipo'])) { // tipo_idtipo
            $this->tipo_idtipo->CurrentValue = $row['tipo_idtipo'];
        }
        if (isset($row['processo'])) { // processo
            $this->processo->CurrentValue = $row['processo'];
        }
        if (isset($row['responsaveis'])) { // responsaveis
            $this->responsaveis->CurrentValue = $row['responsaveis'];
        }
        if (isset($row['objetivo'])) { // objetivo
            $this->objetivo->CurrentValue = $row['objetivo'];
        }
        if (isset($row['proc_antes'])) { // proc_antes
            $this->proc_antes->CurrentValue = $row['proc_antes'];
        }
        if (isset($row['proc_depois'])) { // proc_depois
            $this->proc_depois->CurrentValue = $row['proc_depois'];
        }
        if (isset($row['eqpto_recursos'])) { // eqpto_recursos
            $this->eqpto_recursos->CurrentValue = $row['eqpto_recursos'];
        }
        if (isset($row['entradas'])) { // entradas
            $this->entradas->CurrentValue = $row['entradas'];
        }
        if (isset($row['atividade_principal'])) { // atividade_principal
            $this->atividade_principal->CurrentValue = $row['atividade_principal'];
        }
        if (isset($row['saidas_resultados'])) { // saidas_resultados
            $this->saidas_resultados->CurrentValue = $row['saidas_resultados'];
        }
        if (isset($row['requsito_saidas'])) { // requsito_saidas
            $this->requsito_saidas->CurrentValue = $row['requsito_saidas'];
        }
        if (isset($row['riscos'])) { // riscos
            $this->riscos->CurrentValue = $row['riscos'];
        }
        if (isset($row['oportunidades'])) { // oportunidades
            $this->oportunidades->CurrentValue = $row['oportunidades'];
        }
        if (isset($row['propriedade_externa'])) { // propriedade_externa
            $this->propriedade_externa->CurrentValue = $row['propriedade_externa'];
        }
        if (isset($row['conhecimentos'])) { // conhecimentos
            $this->conhecimentos->CurrentValue = $row['conhecimentos'];
        }
        if (isset($row['documentos_aplicados'])) { // documentos_aplicados
            $this->documentos_aplicados->CurrentValue = $row['documentos_aplicados'];
        }
        if (isset($row['proced_int_trabalho'])) { // proced_int_trabalho
            $this->proced_int_trabalho->CurrentValue = $row['proced_int_trabalho'];
        }
        if (isset($row['mapa'])) { // mapa
            $this->mapa->CurrentValue = $row['mapa'];
        }
        if (isset($row['formulario'])) { // formulario
            $this->formulario->CurrentValue = $row['formulario'];
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
            if (in_array("processo_indicadores", $detailTblVar)) {
                $detailPageObj = Container("ProcessoIndicadoresGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->processo_idprocesso->IsDetailKey = true;
                    $detailPageObj->processo_idprocesso->CurrentValue = $this->idprocesso->CurrentValue;
                    $detailPageObj->processo_idprocesso->setSessionValue($detailPageObj->processo_idprocesso->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ProcessoList"), "", $this->TableVar, true);
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
        $pages->add(5);
        $pages->add(6);
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
                case "x_tipo_idtipo":
                    break;
                case "x_responsaveis":
                    break;
                case "x_proc_antes":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_proc_depois":
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
