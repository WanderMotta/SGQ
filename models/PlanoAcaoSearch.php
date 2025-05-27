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
class PlanoAcaoSearch extends PlanoAcao
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "PlanoAcaoSearch";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "PlanoAcaoSearch";

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
        $this->idplano_acao->setVisibility();
        $this->risco_oportunidade_idrisco_oportunidade->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->o_q_sera_feito->setVisibility();
        $this->efeito_esperado->setVisibility();
        $this->departamentos_iddepartamentos->setVisibility();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setVisibility();
        $this->recursos_nec->setVisibility();
        $this->dt_limite->setVisibility();
        $this->implementado->setVisibility();
        $this->periodicidade_idperiodicidade->setVisibility();
        $this->eficaz->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'plano_acao';
        $this->TableName = 'plano_acao';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-search-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (plano_acao)
        if (!isset($GLOBALS["plano_acao"]) || $GLOBALS["plano_acao"]::class == PROJECT_NAMESPACE . "plano_acao") {
            $GLOBALS["plano_acao"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'plano_acao');
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
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "PlanoAcaoView"); // If View page, no primary button
                } else { // List page
                    $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                    $this->clearFailureMessage();
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
            $key .= @$ar['idplano_acao'];
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
            $this->idplano_acao->Visible = false;
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
    public $FormClassName = "ew-form ew-search-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

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
        $this->setupLookupOptions($this->risco_oportunidade_idrisco_oportunidade);
        $this->setupLookupOptions($this->departamentos_iddepartamentos);
        $this->setupLookupOptions($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
        $this->setupLookupOptions($this->implementado);
        $this->setupLookupOptions($this->periodicidade_idperiodicidade);
        $this->setupLookupOptions($this->eficaz);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;

        // Get action
        $this->CurrentAction = Post("action");
        if ($this->isSearch()) {
            // Build search string for advanced search, remove blank field
            $this->loadSearchValues(); // Get search values
            $srchStr = $this->validateSearch() ? $this->buildAdvancedSearch() : "";
            if ($srchStr != "") {
                $srchStr = "PlanoAcaoList" . "?" . $srchStr;
                // Do not return Json for UseAjaxActions
                if ($this->IsModal && $this->UseAjaxActions) {
                    $this->IsModal = false;
                }
                $this->terminate($srchStr); // Go to list page
                return;
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Render row for search
        $this->RowType = RowType::SEARCH;
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

    // Build advanced search
    protected function buildAdvancedSearch()
    {
        $srchUrl = "";
        $this->buildSearchUrl($srchUrl, $this->idplano_acao); // idplano_acao
        $this->buildSearchUrl($srchUrl, $this->risco_oportunidade_idrisco_oportunidade); // risco_oportunidade_idrisco_oportunidade
        $this->buildSearchUrl($srchUrl, $this->dt_cadastro); // dt_cadastro
        $this->buildSearchUrl($srchUrl, $this->o_q_sera_feito); // o_q_sera_feito
        $this->buildSearchUrl($srchUrl, $this->efeito_esperado); // efeito_esperado
        $this->buildSearchUrl($srchUrl, $this->departamentos_iddepartamentos); // departamentos_iddepartamentos
        $this->buildSearchUrl($srchUrl, $this->origem_risco_oportunidade_idorigem_risco_oportunidade); // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->buildSearchUrl($srchUrl, $this->recursos_nec); // recursos_nec
        $this->buildSearchUrl($srchUrl, $this->dt_limite); // dt_limite
        $this->buildSearchUrl($srchUrl, $this->implementado); // implementado
        $this->buildSearchUrl($srchUrl, $this->periodicidade_idperiodicidade); // periodicidade_idperiodicidade
        $this->buildSearchUrl($srchUrl, $this->eficaz); // eficaz
        if ($srchUrl != "") {
            $srchUrl .= "&";
        }
        $srchUrl .= "cmd=search";
        return $srchUrl;
    }

    // Build search URL
    protected function buildSearchUrl(&$url, $fld, $oprOnly = false)
    {
        global $CurrentForm;
        $wrk = "";
        $fldParm = $fld->Param;
        [
            "value" => $fldVal,
            "operator" => $fldOpr,
            "condition" => $fldCond,
            "value2" => $fldVal2,
            "operator2" => $fldOpr2
        ] = $CurrentForm->getSearchValues($fldParm);
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldDataType = $fld->DataType;
        $value = ConvertSearchValue($fldVal, $fldOpr, $fld); // For testing if numeric only
        $value2 = ConvertSearchValue($fldVal2, $fldOpr2, $fld); // For testing if numeric only
        $fldOpr = ConvertSearchOperator($fldOpr, $fld, $value);
        $fldOpr2 = ConvertSearchOperator($fldOpr2, $fld, $value2);
        if (in_array($fldOpr, ["BETWEEN", "NOT BETWEEN"])) {
            $isValidValue = $fldDataType != DataType::NUMBER || $fld->VirtualSearch || IsNumericSearchValue($value, $fldOpr, $fld) && IsNumericSearchValue($value2, $fldOpr2, $fld);
            if ($fldVal != "" && $fldVal2 != "" && $isValidValue) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) . "&y_" . $fldParm . "=" . urlencode($fldVal2) . "&z_" . $fldParm . "=" . urlencode($fldOpr);
            }
        } else {
            $isValidValue = $fldDataType != DataType::NUMBER || $fld->VirtualSearch || IsNumericSearchValue($value, $fldOpr, $fld);
            if ($fldVal != "" && $isValidValue && IsValidOperator($fldOpr)) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) . "&z_" . $fldParm . "=" . urlencode($fldOpr);
            } elseif (in_array($fldOpr, ["IS NULL", "IS NOT NULL", "IS EMPTY", "IS NOT EMPTY"]) || ($fldOpr != "" && $oprOnly && IsValidOperator($fldOpr))) {
                $wrk = "z_" . $fldParm . "=" . urlencode($fldOpr);
            }
            $isValidValue = $fldDataType != DataType::NUMBER || $fld->VirtualSearch || IsNumericSearchValue($value2, $fldOpr2, $fld);
            if ($fldVal2 != "" && $isValidValue && IsValidOperator($fldOpr2)) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "y_" . $fldParm . "=" . urlencode($fldVal2) . "&w_" . $fldParm . "=" . urlencode($fldOpr2);
            } elseif (in_array($fldOpr2, ["IS NULL", "IS NOT NULL", "IS EMPTY", "IS NOT EMPTY"]) || ($fldOpr2 != "" && $oprOnly && IsValidOperator($fldOpr2))) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "w_" . $fldParm . "=" . urlencode($fldOpr2);
            }
        }
        if ($wrk != "") {
            if ($url != "") {
                $url .= "&";
            }
            $url .= $wrk;
        }
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // idplano_acao
        if ($this->idplano_acao->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // risco_oportunidade_idrisco_oportunidade
        if ($this->risco_oportunidade_idrisco_oportunidade->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // dt_cadastro
        if ($this->dt_cadastro->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // o_q_sera_feito
        if ($this->o_q_sera_feito->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // efeito_esperado
        if ($this->efeito_esperado->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // departamentos_iddepartamentos
        if ($this->departamentos_iddepartamentos->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // recursos_nec
        if ($this->recursos_nec->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // dt_limite
        if ($this->dt_limite->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // implementado
        if ($this->implementado->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // periodicidade_idperiodicidade
        if ($this->periodicidade_idperiodicidade->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // eficaz
        if ($this->eficaz->AdvancedSearch->get()) {
            $hasValue = true;
        }
        return $hasValue;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // idplano_acao
        $this->idplano_acao->RowCssClass = "row";

        // risco_oportunidade_idrisco_oportunidade
        $this->risco_oportunidade_idrisco_oportunidade->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // o_q_sera_feito
        $this->o_q_sera_feito->RowCssClass = "row";

        // efeito_esperado
        $this->efeito_esperado->RowCssClass = "row";

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->RowCssClass = "row";

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->RowCssClass = "row";

        // recursos_nec
        $this->recursos_nec->RowCssClass = "row";

        // dt_limite
        $this->dt_limite->RowCssClass = "row";

        // implementado
        $this->implementado->RowCssClass = "row";

        // periodicidade_idperiodicidade
        $this->periodicidade_idperiodicidade->RowCssClass = "row";

        // eficaz
        $this->eficaz->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idplano_acao
            $this->idplano_acao->ViewValue = $this->idplano_acao->CurrentValue;

            // risco_oportunidade_idrisco_oportunidade
            $curVal = strval($this->risco_oportunidade_idrisco_oportunidade->CurrentValue);
            if ($curVal != "") {
                $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->lookupCacheOption($curVal);
                if ($this->risco_oportunidade_idrisco_oportunidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchExpression(), "=", $curVal, $this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchDataType(), "");
                    $sqlWrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->renderViewRow($rswrk[0]);
                        $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->displayValue($arwrk);
                    } else {
                        $this->risco_oportunidade_idrisco_oportunidade->ViewValue = FormatNumber($this->risco_oportunidade_idrisco_oportunidade->CurrentValue, $this->risco_oportunidade_idrisco_oportunidade->formatPattern());
                    }
                }
            } else {
                $this->risco_oportunidade_idrisco_oportunidade->ViewValue = null;
            }
            $this->risco_oportunidade_idrisco_oportunidade->CssClass = "fw-bold";
            $this->risco_oportunidade_idrisco_oportunidade->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

            // o_q_sera_feito
            $this->o_q_sera_feito->ViewValue = $this->o_q_sera_feito->CurrentValue;
            $this->o_q_sera_feito->CssClass = "fw-bold";

            // efeito_esperado
            $this->efeito_esperado->ViewValue = $this->efeito_esperado->CurrentValue;
            $this->efeito_esperado->CssClass = "fw-bold";

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

            // periodicidade_idperiodicidade
            $curVal = strval($this->periodicidade_idperiodicidade->CurrentValue);
            if ($curVal != "") {
                $this->periodicidade_idperiodicidade->ViewValue = $this->periodicidade_idperiodicidade->lookupCacheOption($curVal);
                if ($this->periodicidade_idperiodicidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchExpression(), "=", $curVal, $this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchDataType(), "");
                    $sqlWrk = $this->periodicidade_idperiodicidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->periodicidade_idperiodicidade->Lookup->renderViewRow($rswrk[0]);
                        $this->periodicidade_idperiodicidade->ViewValue = $this->periodicidade_idperiodicidade->displayValue($arwrk);
                    } else {
                        $this->periodicidade_idperiodicidade->ViewValue = FormatNumber($this->periodicidade_idperiodicidade->CurrentValue, $this->periodicidade_idperiodicidade->formatPattern());
                    }
                }
            } else {
                $this->periodicidade_idperiodicidade->ViewValue = null;
            }
            $this->periodicidade_idperiodicidade->CssClass = "fw-bold";

            // eficaz
            if (strval($this->eficaz->CurrentValue) != "") {
                $this->eficaz->ViewValue = $this->eficaz->optionCaption($this->eficaz->CurrentValue);
            } else {
                $this->eficaz->ViewValue = null;
            }
            $this->eficaz->CssClass = "fw-bold";
            $this->eficaz->CellCssStyle .= "text-align: center;";

            // idplano_acao
            $this->idplano_acao->HrefValue = "";
            $this->idplano_acao->TooltipValue = "";

            // risco_oportunidade_idrisco_oportunidade
            $this->risco_oportunidade_idrisco_oportunidade->HrefValue = "";
            $this->risco_oportunidade_idrisco_oportunidade->TooltipValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";
            $this->dt_cadastro->TooltipValue = "";

            // o_q_sera_feito
            $this->o_q_sera_feito->HrefValue = "";
            $this->o_q_sera_feito->TooltipValue = "";

            // efeito_esperado
            $this->efeito_esperado->HrefValue = "";
            $this->efeito_esperado->TooltipValue = "";

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->HrefValue = "";
            $this->departamentos_iddepartamentos->TooltipValue = "";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->TooltipValue = "";

            // recursos_nec
            $this->recursos_nec->HrefValue = "";
            $this->recursos_nec->TooltipValue = "";

            // dt_limite
            $this->dt_limite->HrefValue = "";
            $this->dt_limite->TooltipValue = "";

            // implementado
            $this->implementado->HrefValue = "";
            $this->implementado->TooltipValue = "";

            // periodicidade_idperiodicidade
            $this->periodicidade_idperiodicidade->HrefValue = "";
            $this->periodicidade_idperiodicidade->TooltipValue = "";

            // eficaz
            $this->eficaz->HrefValue = "";
            $this->eficaz->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // idplano_acao
            $this->idplano_acao->setupEditAttributes();
            $this->idplano_acao->EditValue = $this->idplano_acao->AdvancedSearch->SearchValue;
            $this->idplano_acao->PlaceHolder = RemoveHtml($this->idplano_acao->caption());

            // risco_oportunidade_idrisco_oportunidade
            $this->risco_oportunidade_idrisco_oportunidade->setupEditAttributes();
            $curVal = trim(strval($this->risco_oportunidade_idrisco_oportunidade->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->risco_oportunidade_idrisco_oportunidade->AdvancedSearch->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->lookupCacheOption($curVal);
            } else {
                $this->risco_oportunidade_idrisco_oportunidade->AdvancedSearch->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->Lookup !== null && is_array($this->risco_oportunidade_idrisco_oportunidade->lookupOptions()) && count($this->risco_oportunidade_idrisco_oportunidade->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->risco_oportunidade_idrisco_oportunidade->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->risco_oportunidade_idrisco_oportunidade->EditValue = array_values($this->risco_oportunidade_idrisco_oportunidade->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchExpression(), "=", $this->risco_oportunidade_idrisco_oportunidade->AdvancedSearch->SearchValue, $this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchDataType(), "");
                }
                $sqlWrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->risco_oportunidade_idrisco_oportunidade->EditValue = $arwrk;
            }
            $this->risco_oportunidade_idrisco_oportunidade->PlaceHolder = RemoveHtml($this->risco_oportunidade_idrisco_oportunidade->caption());

            // dt_cadastro
            $this->dt_cadastro->setupEditAttributes();
            $this->dt_cadastro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->formatPattern()));
            $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

            // o_q_sera_feito
            $this->o_q_sera_feito->setupEditAttributes();
            $this->o_q_sera_feito->EditValue = HtmlEncode($this->o_q_sera_feito->AdvancedSearch->SearchValue);
            $this->o_q_sera_feito->PlaceHolder = RemoveHtml($this->o_q_sera_feito->caption());

            // efeito_esperado
            $this->efeito_esperado->setupEditAttributes();
            $this->efeito_esperado->EditValue = HtmlEncode($this->efeito_esperado->AdvancedSearch->SearchValue);
            $this->efeito_esperado->PlaceHolder = RemoveHtml($this->efeito_esperado->caption());

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->setupEditAttributes();
            $curVal = trim(strval($this->departamentos_iddepartamentos->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->departamentos_iddepartamentos->AdvancedSearch->ViewValue = $this->departamentos_iddepartamentos->lookupCacheOption($curVal);
            } else {
                $this->departamentos_iddepartamentos->AdvancedSearch->ViewValue = $this->departamentos_iddepartamentos->Lookup !== null && is_array($this->departamentos_iddepartamentos->lookupOptions()) && count($this->departamentos_iddepartamentos->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->departamentos_iddepartamentos->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->departamentos_iddepartamentos->EditValue = array_values($this->departamentos_iddepartamentos->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->departamentos_iddepartamentos->Lookup->getTable()->Fields["iddepartamentos"]->searchExpression(), "=", $this->departamentos_iddepartamentos->AdvancedSearch->SearchValue, $this->departamentos_iddepartamentos->Lookup->getTable()->Fields["iddepartamentos"]->searchDataType(), "");
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

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setupEditAttributes();
            $curVal = trim(strval($this->origem_risco_oportunidade_idorigem_risco_oportunidade->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->AdvancedSearch->ViewValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupCacheOption($curVal);
            } else {
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->AdvancedSearch->ViewValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup !== null && is_array($this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupOptions()) && count($this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->EditValue = array_values($this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getTable()->Fields["idorigem_risco_oportunidade"]->searchExpression(), "=", $this->origem_risco_oportunidade_idorigem_risco_oportunidade->AdvancedSearch->SearchValue, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getTable()->Fields["idorigem_risco_oportunidade"]->searchDataType(), "");
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

            // recursos_nec
            $this->recursos_nec->setupEditAttributes();
            $this->recursos_nec->EditValue = $this->recursos_nec->AdvancedSearch->SearchValue;
            $this->recursos_nec->PlaceHolder = RemoveHtml($this->recursos_nec->caption());

            // dt_limite
            $this->dt_limite->setupEditAttributes();
            $this->dt_limite->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dt_limite->AdvancedSearch->SearchValue, $this->dt_limite->formatPattern()), $this->dt_limite->formatPattern()));
            $this->dt_limite->PlaceHolder = RemoveHtml($this->dt_limite->caption());

            // implementado
            $this->implementado->EditValue = $this->implementado->options(false);
            $this->implementado->PlaceHolder = RemoveHtml($this->implementado->caption());

            // periodicidade_idperiodicidade
            $curVal = trim(strval($this->periodicidade_idperiodicidade->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->periodicidade_idperiodicidade->AdvancedSearch->ViewValue = $this->periodicidade_idperiodicidade->lookupCacheOption($curVal);
            } else {
                $this->periodicidade_idperiodicidade->AdvancedSearch->ViewValue = $this->periodicidade_idperiodicidade->Lookup !== null && is_array($this->periodicidade_idperiodicidade->lookupOptions()) && count($this->periodicidade_idperiodicidade->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->periodicidade_idperiodicidade->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->periodicidade_idperiodicidade->EditValue = array_values($this->periodicidade_idperiodicidade->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchExpression(), "=", $this->periodicidade_idperiodicidade->AdvancedSearch->SearchValue, $this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchDataType(), "");
                }
                $sqlWrk = $this->periodicidade_idperiodicidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->periodicidade_idperiodicidade->EditValue = $arwrk;
            }
            $this->periodicidade_idperiodicidade->PlaceHolder = RemoveHtml($this->periodicidade_idperiodicidade->caption());

            // eficaz
            $this->eficaz->EditValue = $this->eficaz->options(false);
            $this->eficaz->PlaceHolder = RemoveHtml($this->eficaz->caption());
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckInteger($this->idplano_acao->AdvancedSearch->SearchValue)) {
            $this->idplano_acao->addErrorMessage($this->idplano_acao->getErrorMessage(false));
        }
        if (!CheckDate($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern())) {
            $this->dt_cadastro->addErrorMessage($this->dt_cadastro->getErrorMessage(false));
        }
        if (!CheckNumber($this->recursos_nec->AdvancedSearch->SearchValue)) {
            $this->recursos_nec->addErrorMessage($this->recursos_nec->getErrorMessage(false));
        }
        if (!CheckDate($this->dt_limite->AdvancedSearch->SearchValue, $this->dt_limite->formatPattern())) {
            $this->dt_limite->addErrorMessage($this->dt_limite->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->idplano_acao->AdvancedSearch->load();
        $this->risco_oportunidade_idrisco_oportunidade->AdvancedSearch->load();
        $this->dt_cadastro->AdvancedSearch->load();
        $this->o_q_sera_feito->AdvancedSearch->load();
        $this->efeito_esperado->AdvancedSearch->load();
        $this->departamentos_iddepartamentos->AdvancedSearch->load();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->AdvancedSearch->load();
        $this->recursos_nec->AdvancedSearch->load();
        $this->dt_limite->AdvancedSearch->load();
        $this->implementado->AdvancedSearch->load();
        $this->periodicidade_idperiodicidade->AdvancedSearch->load();
        $this->eficaz->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PlanoAcaoList"), "", $this->TableVar, true);
        $pageId = "search";
        $Breadcrumb->add("search", $pageId, $url);
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
                case "x_risco_oportunidade_idrisco_oportunidade":
                    break;
                case "x_departamentos_iddepartamentos":
                    break;
                case "x_origem_risco_oportunidade_idorigem_risco_oportunidade":
                    break;
                case "x_implementado":
                    break;
                case "x_periodicidade_idperiodicidade":
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
