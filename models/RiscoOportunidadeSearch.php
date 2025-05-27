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
class RiscoOportunidadeSearch extends RiscoOportunidade
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RiscoOportunidadeSearch";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "RiscoOportunidadeSearch";

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
        $this->idrisco_oportunidade->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setVisibility();
        $this->titulo->setVisibility();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setVisibility();
        $this->descricao->setVisibility();
        $this->consequencia->setVisibility();
        $this->frequencia_idfrequencia->setVisibility();
        $this->impacto_idimpacto->setVisibility();
        $this->grau_atencao->setVisibility();
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setVisibility();
        $this->plano_acao->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'risco_oportunidade';
        $this->TableName = 'risco_oportunidade';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-search-table";

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
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "RiscoOportunidadeView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->tipo_risco_oportunidade_idtipo_risco_oportunidade);
        $this->setupLookupOptions($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
        $this->setupLookupOptions($this->frequencia_idfrequencia);
        $this->setupLookupOptions($this->impacto_idimpacto);
        $this->setupLookupOptions($this->acao_risco_oportunidade_idacao_risco_oportunidade);
        $this->setupLookupOptions($this->plano_acao);

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
                $srchStr = "RiscoOportunidadeList" . "?" . $srchStr;
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
        $this->buildSearchUrl($srchUrl, $this->idrisco_oportunidade); // idrisco_oportunidade
        $this->buildSearchUrl($srchUrl, $this->dt_cadastro); // dt_cadastro
        $this->buildSearchUrl($srchUrl, $this->tipo_risco_oportunidade_idtipo_risco_oportunidade); // tipo_risco_oportunidade_idtipo_risco_oportunidade
        $this->buildSearchUrl($srchUrl, $this->titulo); // titulo
        $this->buildSearchUrl($srchUrl, $this->origem_risco_oportunidade_idorigem_risco_oportunidade); // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->buildSearchUrl($srchUrl, $this->descricao); // descricao
        $this->buildSearchUrl($srchUrl, $this->consequencia); // consequencia
        $this->buildSearchUrl($srchUrl, $this->frequencia_idfrequencia); // frequencia_idfrequencia
        $this->buildSearchUrl($srchUrl, $this->impacto_idimpacto); // impacto_idimpacto
        $this->buildSearchUrl($srchUrl, $this->grau_atencao); // grau_atencao
        $this->buildSearchUrl($srchUrl, $this->acao_risco_oportunidade_idacao_risco_oportunidade); // acao_risco_oportunidade_idacao_risco_oportunidade
        $this->buildSearchUrl($srchUrl, $this->plano_acao); // plano_acao
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

        // idrisco_oportunidade
        if ($this->idrisco_oportunidade->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // dt_cadastro
        if ($this->dt_cadastro->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // tipo_risco_oportunidade_idtipo_risco_oportunidade
        if ($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // titulo
        if ($this->titulo->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // descricao
        if ($this->descricao->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // consequencia
        if ($this->consequencia->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // frequencia_idfrequencia
        if ($this->frequencia_idfrequencia->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // impacto_idimpacto
        if ($this->impacto_idimpacto->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // grau_atencao
        if ($this->grau_atencao->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // acao_risco_oportunidade_idacao_risco_oportunidade
        if ($this->acao_risco_oportunidade_idacao_risco_oportunidade->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // plano_acao
        if ($this->plano_acao->AdvancedSearch->get()) {
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

            // idrisco_oportunidade
            $this->idrisco_oportunidade->HrefValue = "";
            $this->idrisco_oportunidade->TooltipValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";
            $this->dt_cadastro->TooltipValue = "";

            // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->HrefValue = "";
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->TooltipValue = "";

            // titulo
            $this->titulo->HrefValue = "";
            $this->titulo->TooltipValue = "";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->TooltipValue = "";

            // descricao
            $this->descricao->HrefValue = "";
            $this->descricao->TooltipValue = "";

            // consequencia
            $this->consequencia->HrefValue = "";
            $this->consequencia->TooltipValue = "";

            // frequencia_idfrequencia
            $this->frequencia_idfrequencia->HrefValue = "";
            $this->frequencia_idfrequencia->TooltipValue = "";

            // impacto_idimpacto
            $this->impacto_idimpacto->HrefValue = "";
            $this->impacto_idimpacto->TooltipValue = "";

            // grau_atencao
            $this->grau_atencao->HrefValue = "";
            $this->grau_atencao->TooltipValue = "";

            // acao_risco_oportunidade_idacao_risco_oportunidade
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->HrefValue = "";
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->TooltipValue = "";

            // plano_acao
            $this->plano_acao->HrefValue = "";
            $this->plano_acao->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // idrisco_oportunidade
            $this->idrisco_oportunidade->setupEditAttributes();
            $this->idrisco_oportunidade->EditValue = $this->idrisco_oportunidade->AdvancedSearch->SearchValue;
            $this->idrisco_oportunidade->PlaceHolder = RemoveHtml($this->idrisco_oportunidade->caption());

            // dt_cadastro
            $this->dt_cadastro->setupEditAttributes();
            $this->dt_cadastro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->formatPattern()));
            $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

            // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $curVal = trim(strval($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->ViewValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->lookupCacheOption($curVal);
            } else {
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->ViewValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup !== null && is_array($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->lookupOptions()) && count($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->EditValue = array_values($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getTable()->Fields["idtipo_risco_oportunidade"]->searchExpression(), "=", $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->SearchValue, $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getTable()->Fields["idtipo_risco_oportunidade"]->searchDataType(), "");
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
                $this->titulo->AdvancedSearch->SearchValue = HtmlDecode($this->titulo->AdvancedSearch->SearchValue);
            }
            $this->titulo->EditValue = HtmlEncode($this->titulo->AdvancedSearch->SearchValue);
            $this->titulo->PlaceHolder = RemoveHtml($this->titulo->caption());

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

            // descricao
            $this->descricao->setupEditAttributes();
            $this->descricao->EditValue = HtmlEncode($this->descricao->AdvancedSearch->SearchValue);
            $this->descricao->PlaceHolder = RemoveHtml($this->descricao->caption());

            // consequencia
            $this->consequencia->setupEditAttributes();
            $this->consequencia->EditValue = HtmlEncode($this->consequencia->AdvancedSearch->SearchValue);
            $this->consequencia->PlaceHolder = RemoveHtml($this->consequencia->caption());

            // frequencia_idfrequencia
            $this->frequencia_idfrequencia->setupEditAttributes();
            $curVal = trim(strval($this->frequencia_idfrequencia->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->frequencia_idfrequencia->AdvancedSearch->ViewValue = $this->frequencia_idfrequencia->lookupCacheOption($curVal);
            } else {
                $this->frequencia_idfrequencia->AdvancedSearch->ViewValue = $this->frequencia_idfrequencia->Lookup !== null && is_array($this->frequencia_idfrequencia->lookupOptions()) && count($this->frequencia_idfrequencia->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->frequencia_idfrequencia->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->frequencia_idfrequencia->EditValue = array_values($this->frequencia_idfrequencia->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->frequencia_idfrequencia->Lookup->getTable()->Fields["idfrequencia"]->searchExpression(), "=", $this->frequencia_idfrequencia->AdvancedSearch->SearchValue, $this->frequencia_idfrequencia->Lookup->getTable()->Fields["idfrequencia"]->searchDataType(), "");
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
            $this->frequencia_idfrequencia->setupEditAttributes();
            $curVal = trim(strval($this->frequencia_idfrequencia->AdvancedSearch->SearchValue2));
            if ($curVal != "") {
                $this->frequencia_idfrequencia->AdvancedSearch->ViewValue2 = $this->frequencia_idfrequencia->lookupCacheOption($curVal);
            } else {
                $this->frequencia_idfrequencia->AdvancedSearch->ViewValue2 = $this->frequencia_idfrequencia->Lookup !== null && is_array($this->frequencia_idfrequencia->lookupOptions()) && count($this->frequencia_idfrequencia->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->frequencia_idfrequencia->AdvancedSearch->ViewValue2 !== null) { // Load from cache
                $this->frequencia_idfrequencia->EditValue2 = array_values($this->frequencia_idfrequencia->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->frequencia_idfrequencia->Lookup->getTable()->Fields["idfrequencia"]->searchExpression(), "=", $this->frequencia_idfrequencia->AdvancedSearch->SearchValue2, $this->frequencia_idfrequencia->Lookup->getTable()->Fields["idfrequencia"]->searchDataType(), "");
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
                $this->frequencia_idfrequencia->EditValue2 = $arwrk;
            }
            $this->frequencia_idfrequencia->PlaceHolder = RemoveHtml($this->frequencia_idfrequencia->caption());

            // impacto_idimpacto
            $this->impacto_idimpacto->setupEditAttributes();
            $curVal = trim(strval($this->impacto_idimpacto->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->impacto_idimpacto->AdvancedSearch->ViewValue = $this->impacto_idimpacto->lookupCacheOption($curVal);
            } else {
                $this->impacto_idimpacto->AdvancedSearch->ViewValue = $this->impacto_idimpacto->Lookup !== null && is_array($this->impacto_idimpacto->lookupOptions()) && count($this->impacto_idimpacto->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->impacto_idimpacto->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->impacto_idimpacto->EditValue = array_values($this->impacto_idimpacto->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchExpression(), "=", $this->impacto_idimpacto->AdvancedSearch->SearchValue, $this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchDataType(), "");
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
            $this->impacto_idimpacto->setupEditAttributes();
            $curVal = trim(strval($this->impacto_idimpacto->AdvancedSearch->SearchValue2));
            if ($curVal != "") {
                $this->impacto_idimpacto->AdvancedSearch->ViewValue2 = $this->impacto_idimpacto->lookupCacheOption($curVal);
            } else {
                $this->impacto_idimpacto->AdvancedSearch->ViewValue2 = $this->impacto_idimpacto->Lookup !== null && is_array($this->impacto_idimpacto->lookupOptions()) && count($this->impacto_idimpacto->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->impacto_idimpacto->AdvancedSearch->ViewValue2 !== null) { // Load from cache
                $this->impacto_idimpacto->EditValue2 = array_values($this->impacto_idimpacto->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchExpression(), "=", $this->impacto_idimpacto->AdvancedSearch->SearchValue2, $this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchDataType(), "");
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
                $this->impacto_idimpacto->EditValue2 = $arwrk;
            }
            $this->impacto_idimpacto->PlaceHolder = RemoveHtml($this->impacto_idimpacto->caption());

            // grau_atencao
            $this->grau_atencao->setupEditAttributes();
            $this->grau_atencao->EditValue = $this->grau_atencao->AdvancedSearch->SearchValue;
            $this->grau_atencao->PlaceHolder = RemoveHtml($this->grau_atencao->caption());
            $this->grau_atencao->setupEditAttributes();
            $this->grau_atencao->EditValue2 = $this->grau_atencao->AdvancedSearch->SearchValue2;
            $this->grau_atencao->PlaceHolder = RemoveHtml($this->grau_atencao->caption());

            // acao_risco_oportunidade_idacao_risco_oportunidade
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->setupEditAttributes();
            $curVal = trim(strval($this->acao_risco_oportunidade_idacao_risco_oportunidade->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->AdvancedSearch->ViewValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->lookupCacheOption($curVal);
            } else {
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->AdvancedSearch->ViewValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup !== null && is_array($this->acao_risco_oportunidade_idacao_risco_oportunidade->lookupOptions()) && count($this->acao_risco_oportunidade_idacao_risco_oportunidade->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->acao_risco_oportunidade_idacao_risco_oportunidade->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->EditValue = array_values($this->acao_risco_oportunidade_idacao_risco_oportunidade->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getTable()->Fields["idacao_risco_oportunidade"]->searchExpression(), "=", $this->acao_risco_oportunidade_idacao_risco_oportunidade->AdvancedSearch->SearchValue, $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getTable()->Fields["idacao_risco_oportunidade"]->searchDataType(), "");
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

            // plano_acao
            $this->plano_acao->EditValue = $this->plano_acao->options(false);
            $this->plano_acao->PlaceHolder = RemoveHtml($this->plano_acao->caption());
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
        if (!CheckInteger($this->idrisco_oportunidade->AdvancedSearch->SearchValue)) {
            $this->idrisco_oportunidade->addErrorMessage($this->idrisco_oportunidade->getErrorMessage(false));
        }
        if (!CheckDate($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern())) {
            $this->dt_cadastro->addErrorMessage($this->dt_cadastro->getErrorMessage(false));
        }
        if (!CheckInteger($this->grau_atencao->AdvancedSearch->SearchValue)) {
            $this->grau_atencao->addErrorMessage($this->grau_atencao->getErrorMessage(false));
        }
        if (!CheckInteger($this->grau_atencao->AdvancedSearch->SearchValue2)) {
            $this->grau_atencao->addErrorMessage($this->grau_atencao->getErrorMessage(false));
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
        $this->idrisco_oportunidade->AdvancedSearch->load();
        $this->dt_cadastro->AdvancedSearch->load();
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->load();
        $this->titulo->AdvancedSearch->load();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->AdvancedSearch->load();
        $this->descricao->AdvancedSearch->load();
        $this->consequencia->AdvancedSearch->load();
        $this->frequencia_idfrequencia->AdvancedSearch->load();
        $this->impacto_idimpacto->AdvancedSearch->load();
        $this->grau_atencao->AdvancedSearch->load();
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->AdvancedSearch->load();
        $this->plano_acao->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("RiscoOportunidadeList"), "", $this->TableVar, true);
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
