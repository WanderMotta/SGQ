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
class RevisaoDocumentoAdd extends RevisaoDocumento
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RevisaoDocumentoAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "RevisaoDocumentoAdd";

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
        $this->idrevisao_documento->Visible = false;
        $this->documento_interno_iddocumento_interno->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->qual_alteracao->setVisibility();
        $this->status_documento_idstatus_documento->Visible = false;
        $this->revisao_nr->setVisibility();
        $this->usuario_elaborador->setVisibility();
        $this->usuario_aprovador->setVisibility();
        $this->dt_aprovacao->Visible = false;
        $this->anexo->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'revisao_documento';
        $this->TableName = 'revisao_documento';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (revisao_documento)
        if (!isset($GLOBALS["revisao_documento"]) || $GLOBALS["revisao_documento"]::class == PROJECT_NAMESPACE . "revisao_documento") {
            $GLOBALS["revisao_documento"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'revisao_documento');
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
                        $result["view"] = SameString($pageName, "RevisaoDocumentoView"); // If View page, no primary button
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
            $key .= @$ar['idrevisao_documento'];
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
            $this->idrevisao_documento->Visible = false;
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
        $this->setupLookupOptions($this->documento_interno_iddocumento_interno);
        $this->setupLookupOptions($this->status_documento_idstatus_documento);
        $this->setupLookupOptions($this->usuario_elaborador);
        $this->setupLookupOptions($this->usuario_aprovador);

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
            if (($keyValue = Get("idrevisao_documento") ?? Route("idrevisao_documento")) !== null) {
                $this->idrevisao_documento->setQueryStringValue($keyValue);
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
                    $this->terminate("RevisaoDocumentoList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "RevisaoDocumentoList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "RevisaoDocumentoView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "RevisaoDocumentoList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "RevisaoDocumentoList"; // Return list page content
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
        $this->anexo->Upload->Index = $CurrentForm->Index;
        $this->anexo->Upload->uploadFile();
        $this->anexo->CurrentValue = $this->anexo->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->dt_cadastro->DefaultValue = $this->dt_cadastro->getDefault(); // PHP
        $this->dt_cadastro->OldValue = $this->dt_cadastro->DefaultValue;
        $this->qual_alteracao->DefaultValue = $this->qual_alteracao->getDefault(); // PHP
        $this->qual_alteracao->OldValue = $this->qual_alteracao->DefaultValue;
        $this->status_documento_idstatus_documento->DefaultValue = $this->status_documento_idstatus_documento->getDefault(); // PHP
        $this->status_documento_idstatus_documento->OldValue = $this->status_documento_idstatus_documento->DefaultValue;
        $this->revisao_nr->DefaultValue = $this->revisao_nr->getDefault(); // PHP
        $this->revisao_nr->OldValue = $this->revisao_nr->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'documento_interno_iddocumento_interno' first before field var 'x_documento_interno_iddocumento_interno'
        $val = $CurrentForm->hasValue("documento_interno_iddocumento_interno") ? $CurrentForm->getValue("documento_interno_iddocumento_interno") : $CurrentForm->getValue("x_documento_interno_iddocumento_interno");
        if (!$this->documento_interno_iddocumento_interno->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->documento_interno_iddocumento_interno->Visible = false; // Disable update for API request
            } else {
                $this->documento_interno_iddocumento_interno->setFormValue($val);
            }
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

        // Check field name 'qual_alteracao' first before field var 'x_qual_alteracao'
        $val = $CurrentForm->hasValue("qual_alteracao") ? $CurrentForm->getValue("qual_alteracao") : $CurrentForm->getValue("x_qual_alteracao");
        if (!$this->qual_alteracao->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->qual_alteracao->Visible = false; // Disable update for API request
            } else {
                $this->qual_alteracao->setFormValue($val);
            }
        }

        // Check field name 'revisao_nr' first before field var 'x_revisao_nr'
        $val = $CurrentForm->hasValue("revisao_nr") ? $CurrentForm->getValue("revisao_nr") : $CurrentForm->getValue("x_revisao_nr");
        if (!$this->revisao_nr->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->revisao_nr->Visible = false; // Disable update for API request
            } else {
                $this->revisao_nr->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'usuario_elaborador' first before field var 'x_usuario_elaborador'
        $val = $CurrentForm->hasValue("usuario_elaborador") ? $CurrentForm->getValue("usuario_elaborador") : $CurrentForm->getValue("x_usuario_elaborador");
        if (!$this->usuario_elaborador->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuario_elaborador->Visible = false; // Disable update for API request
            } else {
                $this->usuario_elaborador->setFormValue($val);
            }
        }

        // Check field name 'usuario_aprovador' first before field var 'x_usuario_aprovador'
        $val = $CurrentForm->hasValue("usuario_aprovador") ? $CurrentForm->getValue("usuario_aprovador") : $CurrentForm->getValue("x_usuario_aprovador");
        if (!$this->usuario_aprovador->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuario_aprovador->Visible = false; // Disable update for API request
            } else {
                $this->usuario_aprovador->setFormValue($val);
            }
        }

        // Check field name 'idrevisao_documento' first before field var 'x_idrevisao_documento'
        $val = $CurrentForm->hasValue("idrevisao_documento") ? $CurrentForm->getValue("idrevisao_documento") : $CurrentForm->getValue("x_idrevisao_documento");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->documento_interno_iddocumento_interno->CurrentValue = $this->documento_interno_iddocumento_interno->FormValue;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->qual_alteracao->CurrentValue = $this->qual_alteracao->FormValue;
        $this->revisao_nr->CurrentValue = $this->revisao_nr->FormValue;
        $this->usuario_elaborador->CurrentValue = $this->usuario_elaborador->FormValue;
        $this->usuario_aprovador->CurrentValue = $this->usuario_aprovador->FormValue;
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
        $this->idrevisao_documento->setDbValue($row['idrevisao_documento']);
        $this->documento_interno_iddocumento_interno->setDbValue($row['documento_interno_iddocumento_interno']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->qual_alteracao->setDbValue($row['qual_alteracao']);
        $this->status_documento_idstatus_documento->setDbValue($row['status_documento_idstatus_documento']);
        $this->revisao_nr->setDbValue($row['revisao_nr']);
        $this->usuario_elaborador->setDbValue($row['usuario_elaborador']);
        $this->usuario_aprovador->setDbValue($row['usuario_aprovador']);
        $this->dt_aprovacao->setDbValue($row['dt_aprovacao']);
        $this->anexo->Upload->DbValue = $row['anexo'];
        $this->anexo->setDbValue($this->anexo->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idrevisao_documento'] = $this->idrevisao_documento->DefaultValue;
        $row['documento_interno_iddocumento_interno'] = $this->documento_interno_iddocumento_interno->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['qual_alteracao'] = $this->qual_alteracao->DefaultValue;
        $row['status_documento_idstatus_documento'] = $this->status_documento_idstatus_documento->DefaultValue;
        $row['revisao_nr'] = $this->revisao_nr->DefaultValue;
        $row['usuario_elaborador'] = $this->usuario_elaborador->DefaultValue;
        $row['usuario_aprovador'] = $this->usuario_aprovador->DefaultValue;
        $row['dt_aprovacao'] = $this->dt_aprovacao->DefaultValue;
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

        // idrevisao_documento
        $this->idrevisao_documento->RowCssClass = "row";

        // documento_interno_iddocumento_interno
        $this->documento_interno_iddocumento_interno->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // qual_alteracao
        $this->qual_alteracao->RowCssClass = "row";

        // status_documento_idstatus_documento
        $this->status_documento_idstatus_documento->RowCssClass = "row";

        // revisao_nr
        $this->revisao_nr->RowCssClass = "row";

        // usuario_elaborador
        $this->usuario_elaborador->RowCssClass = "row";

        // usuario_aprovador
        $this->usuario_aprovador->RowCssClass = "row";

        // dt_aprovacao
        $this->dt_aprovacao->RowCssClass = "row";

        // anexo
        $this->anexo->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idrevisao_documento
            $this->idrevisao_documento->ViewValue = $this->idrevisao_documento->CurrentValue;

            // documento_interno_iddocumento_interno
            $curVal = strval($this->documento_interno_iddocumento_interno->CurrentValue);
            if ($curVal != "") {
                $this->documento_interno_iddocumento_interno->ViewValue = $this->documento_interno_iddocumento_interno->lookupCacheOption($curVal);
                if ($this->documento_interno_iddocumento_interno->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchExpression(), "=", $curVal, $this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchDataType(), "");
                    $sqlWrk = $this->documento_interno_iddocumento_interno->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->documento_interno_iddocumento_interno->Lookup->renderViewRow($rswrk[0]);
                        $this->documento_interno_iddocumento_interno->ViewValue = $this->documento_interno_iddocumento_interno->displayValue($arwrk);
                    } else {
                        $this->documento_interno_iddocumento_interno->ViewValue = FormatNumber($this->documento_interno_iddocumento_interno->CurrentValue, $this->documento_interno_iddocumento_interno->formatPattern());
                    }
                }
            } else {
                $this->documento_interno_iddocumento_interno->ViewValue = null;
            }
            $this->documento_interno_iddocumento_interno->CssClass = "fw-bold";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // qual_alteracao
            $this->qual_alteracao->ViewValue = $this->qual_alteracao->CurrentValue;
            $this->qual_alteracao->CssClass = "fw-bold";

            // status_documento_idstatus_documento
            $curVal = strval($this->status_documento_idstatus_documento->CurrentValue);
            if ($curVal != "") {
                $this->status_documento_idstatus_documento->ViewValue = $this->status_documento_idstatus_documento->lookupCacheOption($curVal);
                if ($this->status_documento_idstatus_documento->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->status_documento_idstatus_documento->Lookup->getTable()->Fields["idstatus_documento"]->searchExpression(), "=", $curVal, $this->status_documento_idstatus_documento->Lookup->getTable()->Fields["idstatus_documento"]->searchDataType(), "");
                    $sqlWrk = $this->status_documento_idstatus_documento->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->status_documento_idstatus_documento->Lookup->renderViewRow($rswrk[0]);
                        $this->status_documento_idstatus_documento->ViewValue = $this->status_documento_idstatus_documento->displayValue($arwrk);
                    } else {
                        $this->status_documento_idstatus_documento->ViewValue = FormatNumber($this->status_documento_idstatus_documento->CurrentValue, $this->status_documento_idstatus_documento->formatPattern());
                    }
                }
            } else {
                $this->status_documento_idstatus_documento->ViewValue = null;
            }
            $this->status_documento_idstatus_documento->CssClass = "fw-bold";

            // revisao_nr
            $this->revisao_nr->ViewValue = $this->revisao_nr->CurrentValue;
            $this->revisao_nr->ViewValue = FormatNumber($this->revisao_nr->ViewValue, $this->revisao_nr->formatPattern());
            $this->revisao_nr->CssClass = "fw-bold";
            $this->revisao_nr->CellCssStyle .= "text-align: center;";

            // usuario_elaborador
            $curVal = strval($this->usuario_elaborador->CurrentValue);
            if ($curVal != "") {
                $this->usuario_elaborador->ViewValue = $this->usuario_elaborador->lookupCacheOption($curVal);
                if ($this->usuario_elaborador->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->usuario_elaborador->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->usuario_elaborador->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                    $sqlWrk = $this->usuario_elaborador->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->usuario_elaborador->Lookup->renderViewRow($rswrk[0]);
                        $this->usuario_elaborador->ViewValue = $this->usuario_elaborador->displayValue($arwrk);
                    } else {
                        $this->usuario_elaborador->ViewValue = FormatNumber($this->usuario_elaborador->CurrentValue, $this->usuario_elaborador->formatPattern());
                    }
                }
            } else {
                $this->usuario_elaborador->ViewValue = null;
            }
            $this->usuario_elaborador->CssClass = "fw-bold";

            // usuario_aprovador
            $curVal = strval($this->usuario_aprovador->CurrentValue);
            if ($curVal != "") {
                $this->usuario_aprovador->ViewValue = $this->usuario_aprovador->lookupCacheOption($curVal);
                if ($this->usuario_aprovador->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->usuario_aprovador->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->usuario_aprovador->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                    $sqlWrk = $this->usuario_aprovador->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->usuario_aprovador->Lookup->renderViewRow($rswrk[0]);
                        $this->usuario_aprovador->ViewValue = $this->usuario_aprovador->displayValue($arwrk);
                    } else {
                        $this->usuario_aprovador->ViewValue = FormatNumber($this->usuario_aprovador->CurrentValue, $this->usuario_aprovador->formatPattern());
                    }
                }
            } else {
                $this->usuario_aprovador->ViewValue = null;
            }
            $this->usuario_aprovador->CssClass = "fw-bold";

            // dt_aprovacao
            $this->dt_aprovacao->ViewValue = $this->dt_aprovacao->CurrentValue;
            $this->dt_aprovacao->ViewValue = FormatDateTime($this->dt_aprovacao->ViewValue, $this->dt_aprovacao->formatPattern());
            $this->dt_aprovacao->CssClass = "fw-bold";

            // anexo
            if (!EmptyValue($this->anexo->Upload->DbValue)) {
                $this->anexo->ViewValue = $this->anexo->Upload->DbValue;
            } else {
                $this->anexo->ViewValue = "";
            }
            $this->anexo->CssClass = "fw-bold";

            // documento_interno_iddocumento_interno
            $this->documento_interno_iddocumento_interno->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // qual_alteracao
            $this->qual_alteracao->HrefValue = "";

            // revisao_nr
            $this->revisao_nr->HrefValue = "";

            // usuario_elaborador
            $this->usuario_elaborador->HrefValue = "";

            // usuario_aprovador
            $this->usuario_aprovador->HrefValue = "";

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
        } elseif ($this->RowType == RowType::ADD) {
            // documento_interno_iddocumento_interno
            $this->documento_interno_iddocumento_interno->setupEditAttributes();
            if ($this->documento_interno_iddocumento_interno->getSessionValue() != "") {
                $this->documento_interno_iddocumento_interno->CurrentValue = GetForeignKeyValue($this->documento_interno_iddocumento_interno->getSessionValue());
                $curVal = strval($this->documento_interno_iddocumento_interno->CurrentValue);
                if ($curVal != "") {
                    $this->documento_interno_iddocumento_interno->ViewValue = $this->documento_interno_iddocumento_interno->lookupCacheOption($curVal);
                    if ($this->documento_interno_iddocumento_interno->ViewValue === null) { // Lookup from database
                        $filterWrk = SearchFilter($this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchExpression(), "=", $curVal, $this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchDataType(), "");
                        $sqlWrk = $this->documento_interno_iddocumento_interno->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCache($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->documento_interno_iddocumento_interno->Lookup->renderViewRow($rswrk[0]);
                            $this->documento_interno_iddocumento_interno->ViewValue = $this->documento_interno_iddocumento_interno->displayValue($arwrk);
                        } else {
                            $this->documento_interno_iddocumento_interno->ViewValue = FormatNumber($this->documento_interno_iddocumento_interno->CurrentValue, $this->documento_interno_iddocumento_interno->formatPattern());
                        }
                    }
                } else {
                    $this->documento_interno_iddocumento_interno->ViewValue = null;
                }
                $this->documento_interno_iddocumento_interno->CssClass = "fw-bold";
            } else {
                $curVal = trim(strval($this->documento_interno_iddocumento_interno->CurrentValue));
                if ($curVal != "") {
                    $this->documento_interno_iddocumento_interno->ViewValue = $this->documento_interno_iddocumento_interno->lookupCacheOption($curVal);
                } else {
                    $this->documento_interno_iddocumento_interno->ViewValue = $this->documento_interno_iddocumento_interno->Lookup !== null && is_array($this->documento_interno_iddocumento_interno->lookupOptions()) && count($this->documento_interno_iddocumento_interno->lookupOptions()) > 0 ? $curVal : null;
                }
                if ($this->documento_interno_iddocumento_interno->ViewValue !== null) { // Load from cache
                    $this->documento_interno_iddocumento_interno->EditValue = array_values($this->documento_interno_iddocumento_interno->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = SearchFilter($this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchExpression(), "=", $this->documento_interno_iddocumento_interno->CurrentValue, $this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchDataType(), "");
                    }
                    $sqlWrk = $this->documento_interno_iddocumento_interno->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->documento_interno_iddocumento_interno->EditValue = $arwrk;
                }
                $this->documento_interno_iddocumento_interno->PlaceHolder = RemoveHtml($this->documento_interno_iddocumento_interno->caption());
            }

            // dt_cadastro
            $this->dt_cadastro->setupEditAttributes();
            $this->dt_cadastro->EditValue = HtmlEncode(FormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern()));
            $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

            // qual_alteracao
            $this->qual_alteracao->setupEditAttributes();
            $this->qual_alteracao->EditValue = HtmlEncode($this->qual_alteracao->CurrentValue);
            $this->qual_alteracao->PlaceHolder = RemoveHtml($this->qual_alteracao->caption());

            // revisao_nr
            $this->revisao_nr->setupEditAttributes();
            $this->revisao_nr->EditValue = $this->revisao_nr->CurrentValue;
            $this->revisao_nr->PlaceHolder = RemoveHtml($this->revisao_nr->caption());
            if (strval($this->revisao_nr->EditValue) != "" && is_numeric($this->revisao_nr->EditValue)) {
                $this->revisao_nr->EditValue = FormatNumber($this->revisao_nr->EditValue, null);
            }

            // usuario_elaborador
            $this->usuario_elaborador->setupEditAttributes();
            $curVal = trim(strval($this->usuario_elaborador->CurrentValue));
            if ($curVal != "") {
                $this->usuario_elaborador->ViewValue = $this->usuario_elaborador->lookupCacheOption($curVal);
            } else {
                $this->usuario_elaborador->ViewValue = $this->usuario_elaborador->Lookup !== null && is_array($this->usuario_elaborador->lookupOptions()) && count($this->usuario_elaborador->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->usuario_elaborador->ViewValue !== null) { // Load from cache
                $this->usuario_elaborador->EditValue = array_values($this->usuario_elaborador->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->usuario_elaborador->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $this->usuario_elaborador->CurrentValue, $this->usuario_elaborador->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                }
                $sqlWrk = $this->usuario_elaborador->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->usuario_elaborador->EditValue = $arwrk;
            }
            $this->usuario_elaborador->PlaceHolder = RemoveHtml($this->usuario_elaborador->caption());

            // usuario_aprovador
            $this->usuario_aprovador->setupEditAttributes();
            $curVal = trim(strval($this->usuario_aprovador->CurrentValue));
            if ($curVal != "") {
                $this->usuario_aprovador->ViewValue = $this->usuario_aprovador->lookupCacheOption($curVal);
            } else {
                $this->usuario_aprovador->ViewValue = $this->usuario_aprovador->Lookup !== null && is_array($this->usuario_aprovador->lookupOptions()) && count($this->usuario_aprovador->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->usuario_aprovador->ViewValue !== null) { // Load from cache
                $this->usuario_aprovador->EditValue = array_values($this->usuario_aprovador->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->usuario_aprovador->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $this->usuario_aprovador->CurrentValue, $this->usuario_aprovador->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                }
                $sqlWrk = $this->usuario_aprovador->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->usuario_aprovador->EditValue = $arwrk;
            }
            $this->usuario_aprovador->PlaceHolder = RemoveHtml($this->usuario_aprovador->caption());

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
            if (!Config("CREATE_UPLOAD_FILE_ON_COPY")) {
                $this->anexo->Upload->DbValue = null;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->anexo);
            }

            // Add refer script

            // documento_interno_iddocumento_interno
            $this->documento_interno_iddocumento_interno->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // qual_alteracao
            $this->qual_alteracao->HrefValue = "";

            // revisao_nr
            $this->revisao_nr->HrefValue = "";

            // usuario_elaborador
            $this->usuario_elaborador->HrefValue = "";

            // usuario_aprovador
            $this->usuario_aprovador->HrefValue = "";

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
            if ($this->documento_interno_iddocumento_interno->Visible && $this->documento_interno_iddocumento_interno->Required) {
                if (!$this->documento_interno_iddocumento_interno->IsDetailKey && EmptyValue($this->documento_interno_iddocumento_interno->FormValue)) {
                    $this->documento_interno_iddocumento_interno->addErrorMessage(str_replace("%s", $this->documento_interno_iddocumento_interno->caption(), $this->documento_interno_iddocumento_interno->RequiredErrorMessage));
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
            if ($this->qual_alteracao->Visible && $this->qual_alteracao->Required) {
                if (!$this->qual_alteracao->IsDetailKey && EmptyValue($this->qual_alteracao->FormValue)) {
                    $this->qual_alteracao->addErrorMessage(str_replace("%s", $this->qual_alteracao->caption(), $this->qual_alteracao->RequiredErrorMessage));
                }
            }
            if ($this->revisao_nr->Visible && $this->revisao_nr->Required) {
                if (!$this->revisao_nr->IsDetailKey && EmptyValue($this->revisao_nr->FormValue)) {
                    $this->revisao_nr->addErrorMessage(str_replace("%s", $this->revisao_nr->caption(), $this->revisao_nr->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->revisao_nr->FormValue)) {
                $this->revisao_nr->addErrorMessage($this->revisao_nr->getErrorMessage(false));
            }
            if ($this->usuario_elaborador->Visible && $this->usuario_elaborador->Required) {
                if (!$this->usuario_elaborador->IsDetailKey && EmptyValue($this->usuario_elaborador->FormValue)) {
                    $this->usuario_elaborador->addErrorMessage(str_replace("%s", $this->usuario_elaborador->caption(), $this->usuario_elaborador->RequiredErrorMessage));
                }
            }
            if ($this->usuario_aprovador->Visible && $this->usuario_aprovador->Required) {
                if (!$this->usuario_aprovador->IsDetailKey && EmptyValue($this->usuario_aprovador->FormValue)) {
                    $this->usuario_aprovador->addErrorMessage(str_replace("%s", $this->usuario_aprovador->caption(), $this->usuario_aprovador->RequiredErrorMessage));
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();
        if ($this->anexo->Visible && !$this->anexo->Upload->KeepFile) {
            if (!EmptyValue($this->anexo->Upload->FileName)) {
                $this->anexo->Upload->DbValue = null;
                FixUploadFileNames($this->anexo);
                $this->anexo->setDbValueDef($rsnew, $this->anexo->Upload->FileName, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check referential integrity for master table 'revisao_documento'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["documento_interno_iddocumento_interno"] = $this->documento_interno_iddocumento_interno->CurrentValue;
        $masterTable = Container("documento_interno");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "documento_interno", $Language->phrase("RelatedRecordRequired"));
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
                if ($this->anexo->Visible && !$this->anexo->Upload->KeepFile) {
                    $this->anexo->Upload->DbValue = null;
                    if (!SaveUploadFiles($this->anexo, $rsnew['anexo'], false)) {
                        $this->setFailureMessage($Language->phrase("UploadError7"));
                        return false;
                    }
                }
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

        // documento_interno_iddocumento_interno
        $this->documento_interno_iddocumento_interno->setDbValueDef($rsnew, $this->documento_interno_iddocumento_interno->CurrentValue, false);

        // dt_cadastro
        $this->dt_cadastro->setDbValueDef($rsnew, UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern()), false);

        // qual_alteracao
        $this->qual_alteracao->setDbValueDef($rsnew, $this->qual_alteracao->CurrentValue, false);

        // revisao_nr
        $this->revisao_nr->setDbValueDef($rsnew, $this->revisao_nr->CurrentValue, strval($this->revisao_nr->CurrentValue) == "");

        // usuario_elaborador
        $this->usuario_elaborador->setDbValueDef($rsnew, $this->usuario_elaborador->CurrentValue, false);

        // usuario_aprovador
        $this->usuario_aprovador->setDbValueDef($rsnew, $this->usuario_aprovador->CurrentValue, false);

        // anexo
        if ($this->anexo->Visible && !$this->anexo->Upload->KeepFile) {
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
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['documento_interno_iddocumento_interno'])) { // documento_interno_iddocumento_interno
            $this->documento_interno_iddocumento_interno->setFormValue($row['documento_interno_iddocumento_interno']);
        }
        if (isset($row['dt_cadastro'])) { // dt_cadastro
            $this->dt_cadastro->setFormValue($row['dt_cadastro']);
        }
        if (isset($row['qual_alteracao'])) { // qual_alteracao
            $this->qual_alteracao->setFormValue($row['qual_alteracao']);
        }
        if (isset($row['revisao_nr'])) { // revisao_nr
            $this->revisao_nr->setFormValue($row['revisao_nr']);
        }
        if (isset($row['usuario_elaborador'])) { // usuario_elaborador
            $this->usuario_elaborador->setFormValue($row['usuario_elaborador']);
        }
        if (isset($row['usuario_aprovador'])) { // usuario_aprovador
            $this->usuario_aprovador->setFormValue($row['usuario_aprovador']);
        }
        if (isset($row['anexo'])) { // anexo
            $this->anexo->setFormValue($row['anexo']);
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
            if ($masterTblVar == "documento_interno") {
                $validMaster = true;
                $masterTbl = Container("documento_interno");
                if (($parm = Get("fk_iddocumento_interno", Get("documento_interno_iddocumento_interno"))) !== null) {
                    $masterTbl->iddocumento_interno->setQueryStringValue($parm);
                    $this->documento_interno_iddocumento_interno->QueryStringValue = $masterTbl->iddocumento_interno->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->documento_interno_iddocumento_interno->setSessionValue($this->documento_interno_iddocumento_interno->QueryStringValue);
                    $foreignKeys["documento_interno_iddocumento_interno"] = $this->documento_interno_iddocumento_interno->QueryStringValue;
                    if (!is_numeric($masterTbl->iddocumento_interno->QueryStringValue)) {
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
            if ($masterTblVar == "documento_interno") {
                $validMaster = true;
                $masterTbl = Container("documento_interno");
                if (($parm = Post("fk_iddocumento_interno", Post("documento_interno_iddocumento_interno"))) !== null) {
                    $masterTbl->iddocumento_interno->setFormValue($parm);
                    $this->documento_interno_iddocumento_interno->FormValue = $masterTbl->iddocumento_interno->FormValue;
                    $this->documento_interno_iddocumento_interno->setSessionValue($this->documento_interno_iddocumento_interno->FormValue);
                    $foreignKeys["documento_interno_iddocumento_interno"] = $this->documento_interno_iddocumento_interno->FormValue;
                    if (!is_numeric($masterTbl->iddocumento_interno->FormValue)) {
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
            if ($masterTblVar != "documento_interno") {
                if (!array_key_exists("documento_interno_iddocumento_interno", $foreignKeys)) { // Not current foreign key
                    $this->documento_interno_iddocumento_interno->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("RevisaoDocumentoList"), "", $this->TableVar, true);
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
                case "x_documento_interno_iddocumento_interno":
                    break;
                case "x_status_documento_idstatus_documento":
                    break;
                case "x_usuario_elaborador":
                    break;
                case "x_usuario_aprovador":
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
