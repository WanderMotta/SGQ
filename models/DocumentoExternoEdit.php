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
class DocumentoExternoEdit extends DocumentoExterno
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "DocumentoExternoEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "DocumentoExternoEdit";

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
        $this->iddocumento_externo->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->titulo_documento->setVisibility();
        $this->distribuicao->setVisibility();
        $this->tem_validade->setVisibility();
        $this->valido_ate->setVisibility();
        $this->restringir_acesso->setVisibility();
        $this->localizacao_idlocalizacao->setVisibility();
        $this->usuario_responsavel->setVisibility();
        $this->anexo->setVisibility();
        $this->obs->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'documento_externo';
        $this->TableName = 'documento_externo';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (documento_externo)
        if (!isset($GLOBALS["documento_externo"]) || $GLOBALS["documento_externo"]::class == PROJECT_NAMESPACE . "documento_externo") {
            $GLOBALS["documento_externo"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'documento_externo');
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
                        $result["view"] = SameString($pageName, "DocumentoExternoView"); // If View page, no primary button
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
            $key .= @$ar['iddocumento_externo'];
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
            $this->iddocumento_externo->Visible = false;
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
        $this->setupLookupOptions($this->distribuicao);
        $this->setupLookupOptions($this->tem_validade);
        $this->setupLookupOptions($this->restringir_acesso);
        $this->setupLookupOptions($this->localizacao_idlocalizacao);
        $this->setupLookupOptions($this->usuario_responsavel);

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
            if (($keyValue = Get("iddocumento_externo") ?? Key(0) ?? Route(2)) !== null) {
                $this->iddocumento_externo->setQueryStringValue($keyValue);
                $this->iddocumento_externo->setOldValue($this->iddocumento_externo->QueryStringValue);
            } elseif (Post("iddocumento_externo") !== null) {
                $this->iddocumento_externo->setFormValue(Post("iddocumento_externo"));
                $this->iddocumento_externo->setOldValue($this->iddocumento_externo->FormValue);
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
                if (($keyValue = Get("iddocumento_externo") ?? Route("iddocumento_externo")) !== null) {
                    $this->iddocumento_externo->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->iddocumento_externo->CurrentValue = null;
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
                        $this->terminate("DocumentoExternoList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "DocumentoExternoList") {
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
                        if (GetPageName($returnUrl) != "DocumentoExternoList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "DocumentoExternoList"; // Return list page content
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

        // Check field name 'iddocumento_externo' first before field var 'x_iddocumento_externo'
        $val = $CurrentForm->hasValue("iddocumento_externo") ? $CurrentForm->getValue("iddocumento_externo") : $CurrentForm->getValue("x_iddocumento_externo");
        if (!$this->iddocumento_externo->IsDetailKey) {
            $this->iddocumento_externo->setFormValue($val);
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

        // Check field name 'titulo_documento' first before field var 'x_titulo_documento'
        $val = $CurrentForm->hasValue("titulo_documento") ? $CurrentForm->getValue("titulo_documento") : $CurrentForm->getValue("x_titulo_documento");
        if (!$this->titulo_documento->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titulo_documento->Visible = false; // Disable update for API request
            } else {
                $this->titulo_documento->setFormValue($val);
            }
        }

        // Check field name 'distribuicao' first before field var 'x_distribuicao'
        $val = $CurrentForm->hasValue("distribuicao") ? $CurrentForm->getValue("distribuicao") : $CurrentForm->getValue("x_distribuicao");
        if (!$this->distribuicao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->distribuicao->Visible = false; // Disable update for API request
            } else {
                $this->distribuicao->setFormValue($val);
            }
        }

        // Check field name 'tem_validade' first before field var 'x_tem_validade'
        $val = $CurrentForm->hasValue("tem_validade") ? $CurrentForm->getValue("tem_validade") : $CurrentForm->getValue("x_tem_validade");
        if (!$this->tem_validade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tem_validade->Visible = false; // Disable update for API request
            } else {
                $this->tem_validade->setFormValue($val);
            }
        }

        // Check field name 'valido_ate' first before field var 'x_valido_ate'
        $val = $CurrentForm->hasValue("valido_ate") ? $CurrentForm->getValue("valido_ate") : $CurrentForm->getValue("x_valido_ate");
        if (!$this->valido_ate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->valido_ate->Visible = false; // Disable update for API request
            } else {
                $this->valido_ate->setFormValue($val, true, $validate);
            }
            $this->valido_ate->CurrentValue = UnFormatDateTime($this->valido_ate->CurrentValue, $this->valido_ate->formatPattern());
        }

        // Check field name 'restringir_acesso' first before field var 'x_restringir_acesso'
        $val = $CurrentForm->hasValue("restringir_acesso") ? $CurrentForm->getValue("restringir_acesso") : $CurrentForm->getValue("x_restringir_acesso");
        if (!$this->restringir_acesso->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->restringir_acesso->Visible = false; // Disable update for API request
            } else {
                $this->restringir_acesso->setFormValue($val);
            }
        }

        // Check field name 'localizacao_idlocalizacao' first before field var 'x_localizacao_idlocalizacao'
        $val = $CurrentForm->hasValue("localizacao_idlocalizacao") ? $CurrentForm->getValue("localizacao_idlocalizacao") : $CurrentForm->getValue("x_localizacao_idlocalizacao");
        if (!$this->localizacao_idlocalizacao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->localizacao_idlocalizacao->Visible = false; // Disable update for API request
            } else {
                $this->localizacao_idlocalizacao->setFormValue($val);
            }
        }

        // Check field name 'usuario_responsavel' first before field var 'x_usuario_responsavel'
        $val = $CurrentForm->hasValue("usuario_responsavel") ? $CurrentForm->getValue("usuario_responsavel") : $CurrentForm->getValue("x_usuario_responsavel");
        if (!$this->usuario_responsavel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuario_responsavel->Visible = false; // Disable update for API request
            } else {
                $this->usuario_responsavel->setFormValue($val);
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
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->iddocumento_externo->CurrentValue = $this->iddocumento_externo->FormValue;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->titulo_documento->CurrentValue = $this->titulo_documento->FormValue;
        $this->distribuicao->CurrentValue = $this->distribuicao->FormValue;
        $this->tem_validade->CurrentValue = $this->tem_validade->FormValue;
        $this->valido_ate->CurrentValue = $this->valido_ate->FormValue;
        $this->valido_ate->CurrentValue = UnFormatDateTime($this->valido_ate->CurrentValue, $this->valido_ate->formatPattern());
        $this->restringir_acesso->CurrentValue = $this->restringir_acesso->FormValue;
        $this->localizacao_idlocalizacao->CurrentValue = $this->localizacao_idlocalizacao->FormValue;
        $this->usuario_responsavel->CurrentValue = $this->usuario_responsavel->FormValue;
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
        $this->iddocumento_externo->setDbValue($row['iddocumento_externo']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->titulo_documento->setDbValue($row['titulo_documento']);
        $this->distribuicao->setDbValue($row['distribuicao']);
        $this->tem_validade->setDbValue($row['tem_validade']);
        $this->valido_ate->setDbValue($row['valido_ate']);
        $this->restringir_acesso->setDbValue($row['restringir_acesso']);
        $this->localizacao_idlocalizacao->setDbValue($row['localizacao_idlocalizacao']);
        $this->usuario_responsavel->setDbValue($row['usuario_responsavel']);
        $this->anexo->Upload->DbValue = $row['anexo'];
        $this->anexo->setDbValue($this->anexo->Upload->DbValue);
        $this->obs->setDbValue($row['obs']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['iddocumento_externo'] = $this->iddocumento_externo->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['titulo_documento'] = $this->titulo_documento->DefaultValue;
        $row['distribuicao'] = $this->distribuicao->DefaultValue;
        $row['tem_validade'] = $this->tem_validade->DefaultValue;
        $row['valido_ate'] = $this->valido_ate->DefaultValue;
        $row['restringir_acesso'] = $this->restringir_acesso->DefaultValue;
        $row['localizacao_idlocalizacao'] = $this->localizacao_idlocalizacao->DefaultValue;
        $row['usuario_responsavel'] = $this->usuario_responsavel->DefaultValue;
        $row['anexo'] = $this->anexo->DefaultValue;
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

        // iddocumento_externo
        $this->iddocumento_externo->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // titulo_documento
        $this->titulo_documento->RowCssClass = "row";

        // distribuicao
        $this->distribuicao->RowCssClass = "row";

        // tem_validade
        $this->tem_validade->RowCssClass = "row";

        // valido_ate
        $this->valido_ate->RowCssClass = "row";

        // restringir_acesso
        $this->restringir_acesso->RowCssClass = "row";

        // localizacao_idlocalizacao
        $this->localizacao_idlocalizacao->RowCssClass = "row";

        // usuario_responsavel
        $this->usuario_responsavel->RowCssClass = "row";

        // anexo
        $this->anexo->RowCssClass = "row";

        // obs
        $this->obs->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // iddocumento_externo
            $this->iddocumento_externo->ViewValue = $this->iddocumento_externo->CurrentValue;
            $this->iddocumento_externo->CssClass = "fw-bold";
            $this->iddocumento_externo->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // titulo_documento
            $this->titulo_documento->ViewValue = $this->titulo_documento->CurrentValue;
            $this->titulo_documento->CssClass = "fw-bold";

            // distribuicao
            if (strval($this->distribuicao->CurrentValue) != "") {
                $this->distribuicao->ViewValue = $this->distribuicao->optionCaption($this->distribuicao->CurrentValue);
            } else {
                $this->distribuicao->ViewValue = null;
            }
            $this->distribuicao->CssClass = "fw-bold";

            // tem_validade
            if (strval($this->tem_validade->CurrentValue) != "") {
                $this->tem_validade->ViewValue = $this->tem_validade->optionCaption($this->tem_validade->CurrentValue);
            } else {
                $this->tem_validade->ViewValue = null;
            }
            $this->tem_validade->CssClass = "fw-bold";
            $this->tem_validade->CellCssStyle .= "text-align: center;";

            // valido_ate
            $this->valido_ate->ViewValue = $this->valido_ate->CurrentValue;
            $this->valido_ate->ViewValue = FormatDateTime($this->valido_ate->ViewValue, $this->valido_ate->formatPattern());
            $this->valido_ate->CssClass = "fw-bold";

            // restringir_acesso
            if (strval($this->restringir_acesso->CurrentValue) != "") {
                $this->restringir_acesso->ViewValue = $this->restringir_acesso->optionCaption($this->restringir_acesso->CurrentValue);
            } else {
                $this->restringir_acesso->ViewValue = null;
            }
            $this->restringir_acesso->CssClass = "fw-bold";
            $this->restringir_acesso->CellCssStyle .= "text-align: center;";

            // localizacao_idlocalizacao
            $curVal = strval($this->localizacao_idlocalizacao->CurrentValue);
            if ($curVal != "") {
                $this->localizacao_idlocalizacao->ViewValue = $this->localizacao_idlocalizacao->lookupCacheOption($curVal);
                if ($this->localizacao_idlocalizacao->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->localizacao_idlocalizacao->Lookup->getTable()->Fields["idlocalizacao"]->searchExpression(), "=", $curVal, $this->localizacao_idlocalizacao->Lookup->getTable()->Fields["idlocalizacao"]->searchDataType(), "");
                    $sqlWrk = $this->localizacao_idlocalizacao->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->localizacao_idlocalizacao->Lookup->renderViewRow($rswrk[0]);
                        $this->localizacao_idlocalizacao->ViewValue = $this->localizacao_idlocalizacao->displayValue($arwrk);
                    } else {
                        $this->localizacao_idlocalizacao->ViewValue = FormatNumber($this->localizacao_idlocalizacao->CurrentValue, $this->localizacao_idlocalizacao->formatPattern());
                    }
                }
            } else {
                $this->localizacao_idlocalizacao->ViewValue = null;
            }
            $this->localizacao_idlocalizacao->CssClass = "fw-bold";

            // usuario_responsavel
            $curVal = strval($this->usuario_responsavel->CurrentValue);
            if ($curVal != "") {
                $this->usuario_responsavel->ViewValue = $this->usuario_responsavel->lookupCacheOption($curVal);
                if ($this->usuario_responsavel->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->usuario_responsavel->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->usuario_responsavel->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                    $sqlWrk = $this->usuario_responsavel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->usuario_responsavel->Lookup->renderViewRow($rswrk[0]);
                        $this->usuario_responsavel->ViewValue = $this->usuario_responsavel->displayValue($arwrk);
                    } else {
                        $this->usuario_responsavel->ViewValue = FormatNumber($this->usuario_responsavel->CurrentValue, $this->usuario_responsavel->formatPattern());
                    }
                }
            } else {
                $this->usuario_responsavel->ViewValue = null;
            }
            $this->usuario_responsavel->CssClass = "fw-bold";

            // anexo
            if (!EmptyValue($this->anexo->Upload->DbValue)) {
                $this->anexo->ViewValue = $this->anexo->Upload->DbValue;
            } else {
                $this->anexo->ViewValue = "";
            }
            $this->anexo->CssClass = "fw-bold";

            // obs
            $this->obs->ViewValue = $this->obs->CurrentValue;
            $this->obs->CssClass = "fw-bold";

            // iddocumento_externo
            $this->iddocumento_externo->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // titulo_documento
            $this->titulo_documento->HrefValue = "";

            // distribuicao
            $this->distribuicao->HrefValue = "";

            // tem_validade
            $this->tem_validade->HrefValue = "";

            // valido_ate
            $this->valido_ate->HrefValue = "";

            // restringir_acesso
            $this->restringir_acesso->HrefValue = "";

            // localizacao_idlocalizacao
            $this->localizacao_idlocalizacao->HrefValue = "";

            // usuario_responsavel
            $this->usuario_responsavel->HrefValue = "";

            // anexo
            if (!EmptyValue($this->anexo->Upload->DbValue)) {
                $this->anexo->HrefValue = $this->anexo->getLinkPrefix() . GetFileUploadUrl($this->anexo, $this->anexo->htmlDecode($this->anexo->Upload->DbValue)); // Add prefix/suffix
                $this->anexo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->anexo->HrefValue = FullUrl($this->anexo->HrefValue, "href");
                }
            } else {
                $this->anexo->HrefValue = "";
            }
            $this->anexo->ExportHrefValue = $this->anexo->UploadPath . $this->anexo->Upload->DbValue;

            // obs
            $this->obs->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // iddocumento_externo
            $this->iddocumento_externo->setupEditAttributes();
            $this->iddocumento_externo->EditValue = $this->iddocumento_externo->CurrentValue;
            $this->iddocumento_externo->CssClass = "fw-bold";
            $this->iddocumento_externo->CellCssStyle .= "text-align: center;";

            // dt_cadastro

            // titulo_documento
            $this->titulo_documento->setupEditAttributes();
            if (!$this->titulo_documento->Raw) {
                $this->titulo_documento->CurrentValue = HtmlDecode($this->titulo_documento->CurrentValue);
            }
            $this->titulo_documento->EditValue = HtmlEncode($this->titulo_documento->CurrentValue);
            $this->titulo_documento->PlaceHolder = RemoveHtml($this->titulo_documento->caption());

            // distribuicao
            $this->distribuicao->EditValue = $this->distribuicao->options(false);
            $this->distribuicao->PlaceHolder = RemoveHtml($this->distribuicao->caption());

            // tem_validade
            $this->tem_validade->EditValue = $this->tem_validade->options(false);
            $this->tem_validade->PlaceHolder = RemoveHtml($this->tem_validade->caption());

            // valido_ate
            $this->valido_ate->setupEditAttributes();
            $this->valido_ate->EditValue = HtmlEncode(FormatDateTime($this->valido_ate->CurrentValue, $this->valido_ate->formatPattern()));
            $this->valido_ate->PlaceHolder = RemoveHtml($this->valido_ate->caption());

            // restringir_acesso
            $this->restringir_acesso->EditValue = $this->restringir_acesso->options(false);
            $this->restringir_acesso->PlaceHolder = RemoveHtml($this->restringir_acesso->caption());

            // localizacao_idlocalizacao
            $curVal = trim(strval($this->localizacao_idlocalizacao->CurrentValue));
            if ($curVal != "") {
                $this->localizacao_idlocalizacao->ViewValue = $this->localizacao_idlocalizacao->lookupCacheOption($curVal);
            } else {
                $this->localizacao_idlocalizacao->ViewValue = $this->localizacao_idlocalizacao->Lookup !== null && is_array($this->localizacao_idlocalizacao->lookupOptions()) && count($this->localizacao_idlocalizacao->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->localizacao_idlocalizacao->ViewValue !== null) { // Load from cache
                $this->localizacao_idlocalizacao->EditValue = array_values($this->localizacao_idlocalizacao->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->localizacao_idlocalizacao->Lookup->getTable()->Fields["idlocalizacao"]->searchExpression(), "=", $this->localizacao_idlocalizacao->CurrentValue, $this->localizacao_idlocalizacao->Lookup->getTable()->Fields["idlocalizacao"]->searchDataType(), "");
                }
                $sqlWrk = $this->localizacao_idlocalizacao->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->localizacao_idlocalizacao->EditValue = $arwrk;
            }
            $this->localizacao_idlocalizacao->PlaceHolder = RemoveHtml($this->localizacao_idlocalizacao->caption());

            // usuario_responsavel
            $curVal = trim(strval($this->usuario_responsavel->CurrentValue));
            if ($curVal != "") {
                $this->usuario_responsavel->ViewValue = $this->usuario_responsavel->lookupCacheOption($curVal);
            } else {
                $this->usuario_responsavel->ViewValue = $this->usuario_responsavel->Lookup !== null && is_array($this->usuario_responsavel->lookupOptions()) && count($this->usuario_responsavel->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->usuario_responsavel->ViewValue !== null) { // Load from cache
                $this->usuario_responsavel->EditValue = array_values($this->usuario_responsavel->lookupOptions());
                if ($this->usuario_responsavel->ViewValue == "") {
                    $this->usuario_responsavel->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->usuario_responsavel->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $this->usuario_responsavel->CurrentValue, $this->usuario_responsavel->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                }
                $sqlWrk = $this->usuario_responsavel->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->usuario_responsavel->Lookup->renderViewRow($rswrk[0]);
                    $this->usuario_responsavel->ViewValue = $this->usuario_responsavel->displayValue($arwrk);
                } else {
                    $this->usuario_responsavel->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->usuario_responsavel->EditValue = $arwrk;
            }
            $this->usuario_responsavel->PlaceHolder = RemoveHtml($this->usuario_responsavel->caption());

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

            // obs
            $this->obs->setupEditAttributes();
            if (!$this->obs->Raw) {
                $this->obs->CurrentValue = HtmlDecode($this->obs->CurrentValue);
            }
            $this->obs->EditValue = HtmlEncode($this->obs->CurrentValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // Edit refer script

            // iddocumento_externo
            $this->iddocumento_externo->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // titulo_documento
            $this->titulo_documento->HrefValue = "";

            // distribuicao
            $this->distribuicao->HrefValue = "";

            // tem_validade
            $this->tem_validade->HrefValue = "";

            // valido_ate
            $this->valido_ate->HrefValue = "";

            // restringir_acesso
            $this->restringir_acesso->HrefValue = "";

            // localizacao_idlocalizacao
            $this->localizacao_idlocalizacao->HrefValue = "";

            // usuario_responsavel
            $this->usuario_responsavel->HrefValue = "";

            // anexo
            if (!EmptyValue($this->anexo->Upload->DbValue)) {
                $this->anexo->HrefValue = $this->anexo->getLinkPrefix() . GetFileUploadUrl($this->anexo, $this->anexo->htmlDecode($this->anexo->Upload->DbValue)); // Add prefix/suffix
                $this->anexo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->anexo->HrefValue = FullUrl($this->anexo->HrefValue, "href");
                }
            } else {
                $this->anexo->HrefValue = "";
            }
            $this->anexo->ExportHrefValue = $this->anexo->UploadPath . $this->anexo->Upload->DbValue;

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
            if ($this->iddocumento_externo->Visible && $this->iddocumento_externo->Required) {
                if (!$this->iddocumento_externo->IsDetailKey && EmptyValue($this->iddocumento_externo->FormValue)) {
                    $this->iddocumento_externo->addErrorMessage(str_replace("%s", $this->iddocumento_externo->caption(), $this->iddocumento_externo->RequiredErrorMessage));
                }
            }
            if ($this->dt_cadastro->Visible && $this->dt_cadastro->Required) {
                if (!$this->dt_cadastro->IsDetailKey && EmptyValue($this->dt_cadastro->FormValue)) {
                    $this->dt_cadastro->addErrorMessage(str_replace("%s", $this->dt_cadastro->caption(), $this->dt_cadastro->RequiredErrorMessage));
                }
            }
            if ($this->titulo_documento->Visible && $this->titulo_documento->Required) {
                if (!$this->titulo_documento->IsDetailKey && EmptyValue($this->titulo_documento->FormValue)) {
                    $this->titulo_documento->addErrorMessage(str_replace("%s", $this->titulo_documento->caption(), $this->titulo_documento->RequiredErrorMessage));
                }
            }
            if ($this->distribuicao->Visible && $this->distribuicao->Required) {
                if ($this->distribuicao->FormValue == "") {
                    $this->distribuicao->addErrorMessage(str_replace("%s", $this->distribuicao->caption(), $this->distribuicao->RequiredErrorMessage));
                }
            }
            if ($this->tem_validade->Visible && $this->tem_validade->Required) {
                if ($this->tem_validade->FormValue == "") {
                    $this->tem_validade->addErrorMessage(str_replace("%s", $this->tem_validade->caption(), $this->tem_validade->RequiredErrorMessage));
                }
            }
            if ($this->valido_ate->Visible && $this->valido_ate->Required) {
                if (!$this->valido_ate->IsDetailKey && EmptyValue($this->valido_ate->FormValue)) {
                    $this->valido_ate->addErrorMessage(str_replace("%s", $this->valido_ate->caption(), $this->valido_ate->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->valido_ate->FormValue, $this->valido_ate->formatPattern())) {
                $this->valido_ate->addErrorMessage($this->valido_ate->getErrorMessage(false));
            }
            if ($this->restringir_acesso->Visible && $this->restringir_acesso->Required) {
                if ($this->restringir_acesso->FormValue == "") {
                    $this->restringir_acesso->addErrorMessage(str_replace("%s", $this->restringir_acesso->caption(), $this->restringir_acesso->RequiredErrorMessage));
                }
            }
            if ($this->localizacao_idlocalizacao->Visible && $this->localizacao_idlocalizacao->Required) {
                if ($this->localizacao_idlocalizacao->FormValue == "") {
                    $this->localizacao_idlocalizacao->addErrorMessage(str_replace("%s", $this->localizacao_idlocalizacao->caption(), $this->localizacao_idlocalizacao->RequiredErrorMessage));
                }
            }
            if ($this->usuario_responsavel->Visible && $this->usuario_responsavel->Required) {
                if (!$this->usuario_responsavel->IsDetailKey && EmptyValue($this->usuario_responsavel->FormValue)) {
                    $this->usuario_responsavel->addErrorMessage(str_replace("%s", $this->usuario_responsavel->caption(), $this->usuario_responsavel->RequiredErrorMessage));
                }
            }
            if ($this->anexo->Visible && $this->anexo->Required) {
                if ($this->anexo->Upload->FileName == "" && !$this->anexo->Upload->KeepFile) {
                    $this->anexo->addErrorMessage(str_replace("%s", $this->anexo->caption(), $this->anexo->RequiredErrorMessage));
                }
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

        // dt_cadastro
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->getAutoUpdateValue(); // PHP
        $this->dt_cadastro->setDbValueDef($rsnew, UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->ReadOnly);

        // titulo_documento
        $this->titulo_documento->setDbValueDef($rsnew, $this->titulo_documento->CurrentValue, $this->titulo_documento->ReadOnly);

        // distribuicao
        $this->distribuicao->setDbValueDef($rsnew, $this->distribuicao->CurrentValue, $this->distribuicao->ReadOnly);

        // tem_validade
        $this->tem_validade->setDbValueDef($rsnew, $this->tem_validade->CurrentValue, $this->tem_validade->ReadOnly);

        // valido_ate
        $this->valido_ate->setDbValueDef($rsnew, UnFormatDateTime($this->valido_ate->CurrentValue, $this->valido_ate->formatPattern()), $this->valido_ate->ReadOnly);

        // restringir_acesso
        $this->restringir_acesso->setDbValueDef($rsnew, $this->restringir_acesso->CurrentValue, $this->restringir_acesso->ReadOnly);

        // localizacao_idlocalizacao
        $this->localizacao_idlocalizacao->setDbValueDef($rsnew, $this->localizacao_idlocalizacao->CurrentValue, $this->localizacao_idlocalizacao->ReadOnly);

        // usuario_responsavel
        $this->usuario_responsavel->setDbValueDef($rsnew, $this->usuario_responsavel->CurrentValue, $this->usuario_responsavel->ReadOnly);

        // anexo
        if ($this->anexo->Visible && !$this->anexo->ReadOnly && !$this->anexo->Upload->KeepFile) {
            if ($this->anexo->Upload->FileName == "") {
                $rsnew['anexo'] = null;
            } else {
                FixUploadTempFileNames($this->anexo);
                $rsnew['anexo'] = $this->anexo->Upload->FileName;
            }
        }

        // obs
        $this->obs->setDbValueDef($rsnew, $this->obs->CurrentValue, $this->obs->ReadOnly);
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
        if (isset($row['titulo_documento'])) { // titulo_documento
            $this->titulo_documento->CurrentValue = $row['titulo_documento'];
        }
        if (isset($row['distribuicao'])) { // distribuicao
            $this->distribuicao->CurrentValue = $row['distribuicao'];
        }
        if (isset($row['tem_validade'])) { // tem_validade
            $this->tem_validade->CurrentValue = $row['tem_validade'];
        }
        if (isset($row['valido_ate'])) { // valido_ate
            $this->valido_ate->CurrentValue = $row['valido_ate'];
        }
        if (isset($row['restringir_acesso'])) { // restringir_acesso
            $this->restringir_acesso->CurrentValue = $row['restringir_acesso'];
        }
        if (isset($row['localizacao_idlocalizacao'])) { // localizacao_idlocalizacao
            $this->localizacao_idlocalizacao->CurrentValue = $row['localizacao_idlocalizacao'];
        }
        if (isset($row['usuario_responsavel'])) { // usuario_responsavel
            $this->usuario_responsavel->CurrentValue = $row['usuario_responsavel'];
        }
        if (isset($row['anexo'])) { // anexo
            $this->anexo->CurrentValue = $row['anexo'];
        }
        if (isset($row['obs'])) { // obs
            $this->obs->CurrentValue = $row['obs'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("DocumentoExternoList"), "", $this->TableVar, true);
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
                case "x_distribuicao":
                    break;
                case "x_tem_validade":
                    break;
                case "x_restringir_acesso":
                    break;
                case "x_localizacao_idlocalizacao":
                    break;
                case "x_usuario_responsavel":
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
