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
class RelatorioAudIntAdd extends RelatorioAudInt
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RelatorioAudIntAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "RelatorioAudIntAdd";

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
        $this->idrelatorio_aud_int->Visible = false;
        $this->dt_cadastro->setVisibility();
        $this->plano_auditoria_int_idplano_auditoria_int->setVisibility();
        $this->item_plano_aud_int_iditem_plano_aud_int->setVisibility();
        $this->metodo->setVisibility();
        $this->descricao->setVisibility();
        $this->evidencia->setVisibility();
        $this->nao_conformidade->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'relatorio_aud_int';
        $this->TableName = 'relatorio_aud_int';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (relatorio_aud_int)
        if (!isset($GLOBALS["relatorio_aud_int"]) || $GLOBALS["relatorio_aud_int"]::class == PROJECT_NAMESPACE . "relatorio_aud_int") {
            $GLOBALS["relatorio_aud_int"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'relatorio_aud_int');
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
                        $result["view"] = SameString($pageName, "RelatorioAudIntView"); // If View page, no primary button
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
            $key .= @$ar['idrelatorio_aud_int'];
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
            $this->idrelatorio_aud_int->Visible = false;
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
        $this->setupLookupOptions($this->plano_auditoria_int_idplano_auditoria_int);
        $this->setupLookupOptions($this->item_plano_aud_int_iditem_plano_aud_int);
        $this->setupLookupOptions($this->metodo);
        $this->setupLookupOptions($this->nao_conformidade);

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
            if (($keyValue = Get("idrelatorio_aud_int") ?? Route("idrelatorio_aud_int")) !== null) {
                $this->idrelatorio_aud_int->setQueryStringValue($keyValue);
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
                    $this->terminate("RelatorioAudIntList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "RelatorioAudIntList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "RelatorioAudIntView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "RelatorioAudIntList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "RelatorioAudIntList"; // Return list page content
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
        $this->metodo->DefaultValue = $this->metodo->getDefault(); // PHP
        $this->metodo->OldValue = $this->metodo->DefaultValue;
        $this->nao_conformidade->DefaultValue = $this->nao_conformidade->getDefault(); // PHP
        $this->nao_conformidade->OldValue = $this->nao_conformidade->DefaultValue;
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

        // Check field name 'plano_auditoria_int_idplano_auditoria_int' first before field var 'x_plano_auditoria_int_idplano_auditoria_int'
        $val = $CurrentForm->hasValue("plano_auditoria_int_idplano_auditoria_int") ? $CurrentForm->getValue("plano_auditoria_int_idplano_auditoria_int") : $CurrentForm->getValue("x_plano_auditoria_int_idplano_auditoria_int");
        if (!$this->plano_auditoria_int_idplano_auditoria_int->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->plano_auditoria_int_idplano_auditoria_int->Visible = false; // Disable update for API request
            } else {
                $this->plano_auditoria_int_idplano_auditoria_int->setFormValue($val);
            }
        }

        // Check field name 'item_plano_aud_int_iditem_plano_aud_int' first before field var 'x_item_plano_aud_int_iditem_plano_aud_int'
        $val = $CurrentForm->hasValue("item_plano_aud_int_iditem_plano_aud_int") ? $CurrentForm->getValue("item_plano_aud_int_iditem_plano_aud_int") : $CurrentForm->getValue("x_item_plano_aud_int_iditem_plano_aud_int");
        if (!$this->item_plano_aud_int_iditem_plano_aud_int->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->item_plano_aud_int_iditem_plano_aud_int->Visible = false; // Disable update for API request
            } else {
                $this->item_plano_aud_int_iditem_plano_aud_int->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'metodo' first before field var 'x_metodo'
        $val = $CurrentForm->hasValue("metodo") ? $CurrentForm->getValue("metodo") : $CurrentForm->getValue("x_metodo");
        if (!$this->metodo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->metodo->Visible = false; // Disable update for API request
            } else {
                $this->metodo->setFormValue($val);
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

        // Check field name 'evidencia' first before field var 'x_evidencia'
        $val = $CurrentForm->hasValue("evidencia") ? $CurrentForm->getValue("evidencia") : $CurrentForm->getValue("x_evidencia");
        if (!$this->evidencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->evidencia->Visible = false; // Disable update for API request
            } else {
                $this->evidencia->setFormValue($val);
            }
        }

        // Check field name 'nao_conformidade' first before field var 'x_nao_conformidade'
        $val = $CurrentForm->hasValue("nao_conformidade") ? $CurrentForm->getValue("nao_conformidade") : $CurrentForm->getValue("x_nao_conformidade");
        if (!$this->nao_conformidade->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nao_conformidade->Visible = false; // Disable update for API request
            } else {
                $this->nao_conformidade->setFormValue($val);
            }
        }

        // Check field name 'idrelatorio_aud_int' first before field var 'x_idrelatorio_aud_int'
        $val = $CurrentForm->hasValue("idrelatorio_aud_int") ? $CurrentForm->getValue("idrelatorio_aud_int") : $CurrentForm->getValue("x_idrelatorio_aud_int");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->dt_cadastro->CurrentValue = $this->dt_cadastro->FormValue;
        $this->dt_cadastro->CurrentValue = UnFormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->plano_auditoria_int_idplano_auditoria_int->CurrentValue = $this->plano_auditoria_int_idplano_auditoria_int->FormValue;
        $this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue = $this->item_plano_aud_int_iditem_plano_aud_int->FormValue;
        $this->metodo->CurrentValue = $this->metodo->FormValue;
        $this->descricao->CurrentValue = $this->descricao->FormValue;
        $this->evidencia->CurrentValue = $this->evidencia->FormValue;
        $this->nao_conformidade->CurrentValue = $this->nao_conformidade->FormValue;
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
        $this->idrelatorio_aud_int->setDbValue($row['idrelatorio_aud_int']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->plano_auditoria_int_idplano_auditoria_int->setDbValue($row['plano_auditoria_int_idplano_auditoria_int']);
        $this->item_plano_aud_int_iditem_plano_aud_int->setDbValue($row['item_plano_aud_int_iditem_plano_aud_int']);
        $this->metodo->setDbValue($row['metodo']);
        $this->descricao->setDbValue($row['descricao']);
        $this->evidencia->setDbValue($row['evidencia']);
        $this->nao_conformidade->setDbValue($row['nao_conformidade']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idrelatorio_aud_int'] = $this->idrelatorio_aud_int->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['plano_auditoria_int_idplano_auditoria_int'] = $this->plano_auditoria_int_idplano_auditoria_int->DefaultValue;
        $row['item_plano_aud_int_iditem_plano_aud_int'] = $this->item_plano_aud_int_iditem_plano_aud_int->DefaultValue;
        $row['metodo'] = $this->metodo->DefaultValue;
        $row['descricao'] = $this->descricao->DefaultValue;
        $row['evidencia'] = $this->evidencia->DefaultValue;
        $row['nao_conformidade'] = $this->nao_conformidade->DefaultValue;
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

        // idrelatorio_aud_int
        $this->idrelatorio_aud_int->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // plano_auditoria_int_idplano_auditoria_int
        $this->plano_auditoria_int_idplano_auditoria_int->RowCssClass = "row";

        // item_plano_aud_int_iditem_plano_aud_int
        $this->item_plano_aud_int_iditem_plano_aud_int->RowCssClass = "row";

        // metodo
        $this->metodo->RowCssClass = "row";

        // descricao
        $this->descricao->RowCssClass = "row";

        // evidencia
        $this->evidencia->RowCssClass = "row";

        // nao_conformidade
        $this->nao_conformidade->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // plano_auditoria_int_idplano_auditoria_int
            $curVal = strval($this->plano_auditoria_int_idplano_auditoria_int->CurrentValue);
            if ($curVal != "") {
                $this->plano_auditoria_int_idplano_auditoria_int->ViewValue = $this->plano_auditoria_int_idplano_auditoria_int->lookupCacheOption($curVal);
                if ($this->plano_auditoria_int_idplano_auditoria_int->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->plano_auditoria_int_idplano_auditoria_int->Lookup->getTable()->Fields["idplano_auditoria_int"]->searchExpression(), "=", $curVal, $this->plano_auditoria_int_idplano_auditoria_int->Lookup->getTable()->Fields["idplano_auditoria_int"]->searchDataType(), "");
                    $sqlWrk = $this->plano_auditoria_int_idplano_auditoria_int->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->plano_auditoria_int_idplano_auditoria_int->Lookup->renderViewRow($rswrk[0]);
                        $this->plano_auditoria_int_idplano_auditoria_int->ViewValue = $this->plano_auditoria_int_idplano_auditoria_int->displayValue($arwrk);
                    } else {
                        $this->plano_auditoria_int_idplano_auditoria_int->ViewValue = FormatNumber($this->plano_auditoria_int_idplano_auditoria_int->CurrentValue, $this->plano_auditoria_int_idplano_auditoria_int->formatPattern());
                    }
                }
            } else {
                $this->plano_auditoria_int_idplano_auditoria_int->ViewValue = null;
            }
            $this->plano_auditoria_int_idplano_auditoria_int->CssClass = "fw-bold";

            // item_plano_aud_int_iditem_plano_aud_int
            $this->item_plano_aud_int_iditem_plano_aud_int->ViewValue = $this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue;
            $curVal = strval($this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue);
            if ($curVal != "") {
                $this->item_plano_aud_int_iditem_plano_aud_int->ViewValue = $this->item_plano_aud_int_iditem_plano_aud_int->lookupCacheOption($curVal);
                if ($this->item_plano_aud_int_iditem_plano_aud_int->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->item_plano_aud_int_iditem_plano_aud_int->Lookup->getTable()->Fields["iditem_plano_aud_int"]->searchExpression(), "=", $curVal, $this->item_plano_aud_int_iditem_plano_aud_int->Lookup->getTable()->Fields["iditem_plano_aud_int"]->searchDataType(), "");
                    $sqlWrk = $this->item_plano_aud_int_iditem_plano_aud_int->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->item_plano_aud_int_iditem_plano_aud_int->Lookup->renderViewRow($rswrk[0]);
                        $this->item_plano_aud_int_iditem_plano_aud_int->ViewValue = $this->item_plano_aud_int_iditem_plano_aud_int->displayValue($arwrk);
                    } else {
                        $this->item_plano_aud_int_iditem_plano_aud_int->ViewValue = FormatNumber($this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue, $this->item_plano_aud_int_iditem_plano_aud_int->formatPattern());
                    }
                }
            } else {
                $this->item_plano_aud_int_iditem_plano_aud_int->ViewValue = null;
            }
            $this->item_plano_aud_int_iditem_plano_aud_int->CssClass = "fw-bold";

            // metodo
            if (strval($this->metodo->CurrentValue) != "") {
                $this->metodo->ViewValue = $this->metodo->optionCaption($this->metodo->CurrentValue);
            } else {
                $this->metodo->ViewValue = null;
            }
            $this->metodo->CssClass = "fw-bold";

            // descricao
            $this->descricao->ViewValue = $this->descricao->CurrentValue;
            $this->descricao->CssClass = "fw-bold";

            // evidencia
            $this->evidencia->ViewValue = $this->evidencia->CurrentValue;
            $this->evidencia->CssClass = "fw-bold";

            // nao_conformidade
            if (strval($this->nao_conformidade->CurrentValue) != "") {
                $this->nao_conformidade->ViewValue = $this->nao_conformidade->optionCaption($this->nao_conformidade->CurrentValue);
            } else {
                $this->nao_conformidade->ViewValue = null;
            }
            $this->nao_conformidade->CssClass = "fw-bold";
            $this->nao_conformidade->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // plano_auditoria_int_idplano_auditoria_int
            $this->plano_auditoria_int_idplano_auditoria_int->HrefValue = "";

            // item_plano_aud_int_iditem_plano_aud_int
            $this->item_plano_aud_int_iditem_plano_aud_int->HrefValue = "";

            // metodo
            $this->metodo->HrefValue = "";

            // descricao
            $this->descricao->HrefValue = "";

            // evidencia
            $this->evidencia->HrefValue = "";

            // nao_conformidade
            $this->nao_conformidade->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // dt_cadastro

            // plano_auditoria_int_idplano_auditoria_int
            $curVal = trim(strval($this->plano_auditoria_int_idplano_auditoria_int->CurrentValue));
            if ($curVal != "") {
                $this->plano_auditoria_int_idplano_auditoria_int->ViewValue = $this->plano_auditoria_int_idplano_auditoria_int->lookupCacheOption($curVal);
            } else {
                $this->plano_auditoria_int_idplano_auditoria_int->ViewValue = $this->plano_auditoria_int_idplano_auditoria_int->Lookup !== null && is_array($this->plano_auditoria_int_idplano_auditoria_int->lookupOptions()) && count($this->plano_auditoria_int_idplano_auditoria_int->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->plano_auditoria_int_idplano_auditoria_int->ViewValue !== null) { // Load from cache
                $this->plano_auditoria_int_idplano_auditoria_int->EditValue = array_values($this->plano_auditoria_int_idplano_auditoria_int->lookupOptions());
                if ($this->plano_auditoria_int_idplano_auditoria_int->ViewValue == "") {
                    $this->plano_auditoria_int_idplano_auditoria_int->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->plano_auditoria_int_idplano_auditoria_int->Lookup->getTable()->Fields["idplano_auditoria_int"]->searchExpression(), "=", $this->plano_auditoria_int_idplano_auditoria_int->CurrentValue, $this->plano_auditoria_int_idplano_auditoria_int->Lookup->getTable()->Fields["idplano_auditoria_int"]->searchDataType(), "");
                }
                $sqlWrk = $this->plano_auditoria_int_idplano_auditoria_int->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->plano_auditoria_int_idplano_auditoria_int->Lookup->renderViewRow($rswrk[0]);
                    $this->plano_auditoria_int_idplano_auditoria_int->ViewValue = $this->plano_auditoria_int_idplano_auditoria_int->displayValue($arwrk);
                } else {
                    $this->plano_auditoria_int_idplano_auditoria_int->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->plano_auditoria_int_idplano_auditoria_int->Lookup->renderViewRow($row);
                }
                $this->plano_auditoria_int_idplano_auditoria_int->EditValue = $arwrk;
            }
            $this->plano_auditoria_int_idplano_auditoria_int->PlaceHolder = RemoveHtml($this->plano_auditoria_int_idplano_auditoria_int->caption());

            // item_plano_aud_int_iditem_plano_aud_int
            $this->item_plano_aud_int_iditem_plano_aud_int->setupEditAttributes();
            if ($this->item_plano_aud_int_iditem_plano_aud_int->getSessionValue() != "") {
                $this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue = GetForeignKeyValue($this->item_plano_aud_int_iditem_plano_aud_int->getSessionValue());
                $this->item_plano_aud_int_iditem_plano_aud_int->ViewValue = $this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue;
                $curVal = strval($this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue);
                if ($curVal != "") {
                    $this->item_plano_aud_int_iditem_plano_aud_int->ViewValue = $this->item_plano_aud_int_iditem_plano_aud_int->lookupCacheOption($curVal);
                    if ($this->item_plano_aud_int_iditem_plano_aud_int->ViewValue === null) { // Lookup from database
                        $filterWrk = SearchFilter($this->item_plano_aud_int_iditem_plano_aud_int->Lookup->getTable()->Fields["iditem_plano_aud_int"]->searchExpression(), "=", $curVal, $this->item_plano_aud_int_iditem_plano_aud_int->Lookup->getTable()->Fields["iditem_plano_aud_int"]->searchDataType(), "");
                        $sqlWrk = $this->item_plano_aud_int_iditem_plano_aud_int->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCache($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->item_plano_aud_int_iditem_plano_aud_int->Lookup->renderViewRow($rswrk[0]);
                            $this->item_plano_aud_int_iditem_plano_aud_int->ViewValue = $this->item_plano_aud_int_iditem_plano_aud_int->displayValue($arwrk);
                        } else {
                            $this->item_plano_aud_int_iditem_plano_aud_int->ViewValue = FormatNumber($this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue, $this->item_plano_aud_int_iditem_plano_aud_int->formatPattern());
                        }
                    }
                } else {
                    $this->item_plano_aud_int_iditem_plano_aud_int->ViewValue = null;
                }
                $this->item_plano_aud_int_iditem_plano_aud_int->CssClass = "fw-bold";
            } else {
                $this->item_plano_aud_int_iditem_plano_aud_int->EditValue = $this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue;
                $curVal = strval($this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue);
                if ($curVal != "") {
                    $this->item_plano_aud_int_iditem_plano_aud_int->EditValue = $this->item_plano_aud_int_iditem_plano_aud_int->lookupCacheOption($curVal);
                    if ($this->item_plano_aud_int_iditem_plano_aud_int->EditValue === null) { // Lookup from database
                        $filterWrk = SearchFilter($this->item_plano_aud_int_iditem_plano_aud_int->Lookup->getTable()->Fields["iditem_plano_aud_int"]->searchExpression(), "=", $curVal, $this->item_plano_aud_int_iditem_plano_aud_int->Lookup->getTable()->Fields["iditem_plano_aud_int"]->searchDataType(), "");
                        $sqlWrk = $this->item_plano_aud_int_iditem_plano_aud_int->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCache($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->item_plano_aud_int_iditem_plano_aud_int->Lookup->renderViewRow($rswrk[0]);
                            $this->item_plano_aud_int_iditem_plano_aud_int->EditValue = $this->item_plano_aud_int_iditem_plano_aud_int->displayValue($arwrk);
                        } else {
                            $this->item_plano_aud_int_iditem_plano_aud_int->EditValue = HtmlEncode(FormatNumber($this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue, $this->item_plano_aud_int_iditem_plano_aud_int->formatPattern()));
                        }
                    }
                } else {
                    $this->item_plano_aud_int_iditem_plano_aud_int->EditValue = null;
                }
                $this->item_plano_aud_int_iditem_plano_aud_int->PlaceHolder = RemoveHtml($this->item_plano_aud_int_iditem_plano_aud_int->caption());
            }

            // metodo
            $this->metodo->EditValue = $this->metodo->options(false);
            $this->metodo->PlaceHolder = RemoveHtml($this->metodo->caption());

            // descricao
            $this->descricao->setupEditAttributes();
            $this->descricao->EditValue = HtmlEncode($this->descricao->CurrentValue);
            $this->descricao->PlaceHolder = RemoveHtml($this->descricao->caption());

            // evidencia
            $this->evidencia->setupEditAttributes();
            $this->evidencia->EditValue = HtmlEncode($this->evidencia->CurrentValue);
            $this->evidencia->PlaceHolder = RemoveHtml($this->evidencia->caption());

            // nao_conformidade
            $this->nao_conformidade->EditValue = $this->nao_conformidade->options(false);
            $this->nao_conformidade->PlaceHolder = RemoveHtml($this->nao_conformidade->caption());

            // Add refer script

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // plano_auditoria_int_idplano_auditoria_int
            $this->plano_auditoria_int_idplano_auditoria_int->HrefValue = "";

            // item_plano_aud_int_iditem_plano_aud_int
            $this->item_plano_aud_int_iditem_plano_aud_int->HrefValue = "";

            // metodo
            $this->metodo->HrefValue = "";

            // descricao
            $this->descricao->HrefValue = "";

            // evidencia
            $this->evidencia->HrefValue = "";

            // nao_conformidade
            $this->nao_conformidade->HrefValue = "";
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
            if ($this->plano_auditoria_int_idplano_auditoria_int->Visible && $this->plano_auditoria_int_idplano_auditoria_int->Required) {
                if (!$this->plano_auditoria_int_idplano_auditoria_int->IsDetailKey && EmptyValue($this->plano_auditoria_int_idplano_auditoria_int->FormValue)) {
                    $this->plano_auditoria_int_idplano_auditoria_int->addErrorMessage(str_replace("%s", $this->plano_auditoria_int_idplano_auditoria_int->caption(), $this->plano_auditoria_int_idplano_auditoria_int->RequiredErrorMessage));
                }
            }
            if ($this->item_plano_aud_int_iditem_plano_aud_int->Visible && $this->item_plano_aud_int_iditem_plano_aud_int->Required) {
                if (!$this->item_plano_aud_int_iditem_plano_aud_int->IsDetailKey && EmptyValue($this->item_plano_aud_int_iditem_plano_aud_int->FormValue)) {
                    $this->item_plano_aud_int_iditem_plano_aud_int->addErrorMessage(str_replace("%s", $this->item_plano_aud_int_iditem_plano_aud_int->caption(), $this->item_plano_aud_int_iditem_plano_aud_int->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->item_plano_aud_int_iditem_plano_aud_int->FormValue)) {
                $this->item_plano_aud_int_iditem_plano_aud_int->addErrorMessage($this->item_plano_aud_int_iditem_plano_aud_int->getErrorMessage(false));
            }
            if ($this->metodo->Visible && $this->metodo->Required) {
                if ($this->metodo->FormValue == "") {
                    $this->metodo->addErrorMessage(str_replace("%s", $this->metodo->caption(), $this->metodo->RequiredErrorMessage));
                }
            }
            if ($this->descricao->Visible && $this->descricao->Required) {
                if (!$this->descricao->IsDetailKey && EmptyValue($this->descricao->FormValue)) {
                    $this->descricao->addErrorMessage(str_replace("%s", $this->descricao->caption(), $this->descricao->RequiredErrorMessage));
                }
            }
            if ($this->evidencia->Visible && $this->evidencia->Required) {
                if (!$this->evidencia->IsDetailKey && EmptyValue($this->evidencia->FormValue)) {
                    $this->evidencia->addErrorMessage(str_replace("%s", $this->evidencia->caption(), $this->evidencia->RequiredErrorMessage));
                }
            }
            if ($this->nao_conformidade->Visible && $this->nao_conformidade->Required) {
                if ($this->nao_conformidade->FormValue == "") {
                    $this->nao_conformidade->addErrorMessage(str_replace("%s", $this->nao_conformidade->caption(), $this->nao_conformidade->RequiredErrorMessage));
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
        if ($this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue != "") { // Check field with unique index
            $filter = "(`item_plano_aud_int_iditem_plano_aud_int` = " . AdjustSql($this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue, $this->Dbid) . ")";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->item_plano_aud_int_iditem_plano_aud_int->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }

        // Check referential integrity for master table 'relatorio_aud_int'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["item_plano_aud_int_iditem_plano_aud_int"] = $this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue;
        $masterTable = Container("item_plano_aud_int");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "item_plano_aud_int", $Language->phrase("RelatedRecordRequired"));
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

        // plano_auditoria_int_idplano_auditoria_int
        $this->plano_auditoria_int_idplano_auditoria_int->setDbValueDef($rsnew, $this->plano_auditoria_int_idplano_auditoria_int->CurrentValue, false);

        // item_plano_aud_int_iditem_plano_aud_int
        $this->item_plano_aud_int_iditem_plano_aud_int->setDbValueDef($rsnew, $this->item_plano_aud_int_iditem_plano_aud_int->CurrentValue, false);

        // metodo
        $this->metodo->setDbValueDef($rsnew, $this->metodo->CurrentValue, strval($this->metodo->CurrentValue) == "");

        // descricao
        $this->descricao->setDbValueDef($rsnew, $this->descricao->CurrentValue, false);

        // evidencia
        $this->evidencia->setDbValueDef($rsnew, $this->evidencia->CurrentValue, false);

        // nao_conformidade
        $this->nao_conformidade->setDbValueDef($rsnew, $this->nao_conformidade->CurrentValue, strval($this->nao_conformidade->CurrentValue) == "");
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
        if (isset($row['plano_auditoria_int_idplano_auditoria_int'])) { // plano_auditoria_int_idplano_auditoria_int
            $this->plano_auditoria_int_idplano_auditoria_int->setFormValue($row['plano_auditoria_int_idplano_auditoria_int']);
        }
        if (isset($row['item_plano_aud_int_iditem_plano_aud_int'])) { // item_plano_aud_int_iditem_plano_aud_int
            $this->item_plano_aud_int_iditem_plano_aud_int->setFormValue($row['item_plano_aud_int_iditem_plano_aud_int']);
        }
        if (isset($row['metodo'])) { // metodo
            $this->metodo->setFormValue($row['metodo']);
        }
        if (isset($row['descricao'])) { // descricao
            $this->descricao->setFormValue($row['descricao']);
        }
        if (isset($row['evidencia'])) { // evidencia
            $this->evidencia->setFormValue($row['evidencia']);
        }
        if (isset($row['nao_conformidade'])) { // nao_conformidade
            $this->nao_conformidade->setFormValue($row['nao_conformidade']);
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
            if ($masterTblVar == "item_plano_aud_int") {
                $validMaster = true;
                $masterTbl = Container("item_plano_aud_int");
                if (($parm = Get("fk_iditem_plano_aud_int", Get("item_plano_aud_int_iditem_plano_aud_int"))) !== null) {
                    $masterTbl->iditem_plano_aud_int->setQueryStringValue($parm);
                    $this->item_plano_aud_int_iditem_plano_aud_int->QueryStringValue = $masterTbl->iditem_plano_aud_int->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->item_plano_aud_int_iditem_plano_aud_int->setSessionValue($this->item_plano_aud_int_iditem_plano_aud_int->QueryStringValue);
                    $foreignKeys["item_plano_aud_int_iditem_plano_aud_int"] = $this->item_plano_aud_int_iditem_plano_aud_int->QueryStringValue;
                    if (!is_numeric($masterTbl->iditem_plano_aud_int->QueryStringValue)) {
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
            if ($masterTblVar == "item_plano_aud_int") {
                $validMaster = true;
                $masterTbl = Container("item_plano_aud_int");
                if (($parm = Post("fk_iditem_plano_aud_int", Post("item_plano_aud_int_iditem_plano_aud_int"))) !== null) {
                    $masterTbl->iditem_plano_aud_int->setFormValue($parm);
                    $this->item_plano_aud_int_iditem_plano_aud_int->FormValue = $masterTbl->iditem_plano_aud_int->FormValue;
                    $this->item_plano_aud_int_iditem_plano_aud_int->setSessionValue($this->item_plano_aud_int_iditem_plano_aud_int->FormValue);
                    $foreignKeys["item_plano_aud_int_iditem_plano_aud_int"] = $this->item_plano_aud_int_iditem_plano_aud_int->FormValue;
                    if (!is_numeric($masterTbl->iditem_plano_aud_int->FormValue)) {
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
            if ($masterTblVar != "item_plano_aud_int") {
                if (!array_key_exists("item_plano_aud_int_iditem_plano_aud_int", $foreignKeys)) { // Not current foreign key
                    $this->item_plano_aud_int_iditem_plano_aud_int->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("RelatorioAudIntList"), "", $this->TableVar, true);
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
                case "x_plano_auditoria_int_idplano_auditoria_int":
                    break;
                case "x_item_plano_aud_int_iditem_plano_aud_int":
                    break;
                case "x_metodo":
                    break;
                case "x_nao_conformidade":
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
