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
class ObjetivoQualidadeSearch extends ObjetivoQualidade
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ObjetivoQualidadeSearch";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ObjetivoQualidadeSearch";

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
        $this->idobjetivo_qualidade->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->processo_idprocesso->setVisibility();
        $this->objetivo->setVisibility();
        $this->como_medir->setVisibility();
        $this->o_q_sera_feito->setVisibility();
        $this->como_avaliar->setVisibility();
        $this->departamentos_iddepartamentos->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'objetivo_qualidade';
        $this->TableName = 'objetivo_qualidade';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-search-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (objetivo_qualidade)
        if (!isset($GLOBALS["objetivo_qualidade"]) || $GLOBALS["objetivo_qualidade"]::class == PROJECT_NAMESPACE . "objetivo_qualidade") {
            $GLOBALS["objetivo_qualidade"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'objetivo_qualidade');
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
                    $result["view"] = SameString($pageName, "ObjetivoQualidadeView"); // If View page, no primary button
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
            $key .= @$ar['idobjetivo_qualidade'];
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
            $this->idobjetivo_qualidade->Visible = false;
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
        $this->setupLookupOptions($this->processo_idprocesso);
        $this->setupLookupOptions($this->departamentos_iddepartamentos);

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
                $srchStr = "ObjetivoQualidadeList" . "?" . $srchStr;
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
        $this->buildSearchUrl($srchUrl, $this->idobjetivo_qualidade); // idobjetivo_qualidade
        $this->buildSearchUrl($srchUrl, $this->dt_cadastro); // dt_cadastro
        $this->buildSearchUrl($srchUrl, $this->processo_idprocesso); // processo_idprocesso
        $this->buildSearchUrl($srchUrl, $this->objetivo); // objetivo
        $this->buildSearchUrl($srchUrl, $this->como_medir); // como_medir
        $this->buildSearchUrl($srchUrl, $this->o_q_sera_feito); // o_q_sera_feito
        $this->buildSearchUrl($srchUrl, $this->como_avaliar); // como_avaliar
        $this->buildSearchUrl($srchUrl, $this->departamentos_iddepartamentos); // departamentos_iddepartamentos
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

        // idobjetivo_qualidade
        if ($this->idobjetivo_qualidade->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // dt_cadastro
        if ($this->dt_cadastro->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // processo_idprocesso
        if ($this->processo_idprocesso->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // objetivo
        if ($this->objetivo->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // como_medir
        if ($this->como_medir->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // o_q_sera_feito
        if ($this->o_q_sera_feito->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // como_avaliar
        if ($this->como_avaliar->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // departamentos_iddepartamentos
        if ($this->departamentos_iddepartamentos->AdvancedSearch->get()) {
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

        // idobjetivo_qualidade
        $this->idobjetivo_qualidade->RowCssClass = "row";

        // dt_cadastro
        $this->dt_cadastro->RowCssClass = "row";

        // processo_idprocesso
        $this->processo_idprocesso->RowCssClass = "row";

        // objetivo
        $this->objetivo->RowCssClass = "row";

        // como_medir
        $this->como_medir->RowCssClass = "row";

        // o_q_sera_feito
        $this->o_q_sera_feito->RowCssClass = "row";

        // como_avaliar
        $this->como_avaliar->RowCssClass = "row";

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idobjetivo_qualidade
            $this->idobjetivo_qualidade->ViewValue = $this->idobjetivo_qualidade->CurrentValue;

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";

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

            // objetivo
            $this->objetivo->ViewValue = $this->objetivo->CurrentValue;
            $this->objetivo->CssClass = "fw-bold";

            // como_medir
            $this->como_medir->ViewValue = $this->como_medir->CurrentValue;
            $this->como_medir->CssClass = "fw-bold";

            // o_q_sera_feito
            $this->o_q_sera_feito->ViewValue = $this->o_q_sera_feito->CurrentValue;
            $this->o_q_sera_feito->CssClass = "fw-bold";

            // como_avaliar
            $this->como_avaliar->ViewValue = $this->como_avaliar->CurrentValue;
            $this->como_avaliar->CssClass = "fw-bold";

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

            // idobjetivo_qualidade
            $this->idobjetivo_qualidade->HrefValue = "";
            $this->idobjetivo_qualidade->TooltipValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";
            $this->dt_cadastro->TooltipValue = "";

            // processo_idprocesso
            $this->processo_idprocesso->HrefValue = "";
            $this->processo_idprocesso->TooltipValue = "";

            // objetivo
            $this->objetivo->HrefValue = "";
            $this->objetivo->TooltipValue = "";

            // como_medir
            $this->como_medir->HrefValue = "";
            $this->como_medir->TooltipValue = "";

            // o_q_sera_feito
            $this->o_q_sera_feito->HrefValue = "";
            $this->o_q_sera_feito->TooltipValue = "";

            // como_avaliar
            $this->como_avaliar->HrefValue = "";
            $this->como_avaliar->TooltipValue = "";

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->HrefValue = "";
            $this->departamentos_iddepartamentos->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // idobjetivo_qualidade
            $this->idobjetivo_qualidade->setupEditAttributes();
            $this->idobjetivo_qualidade->EditValue = $this->idobjetivo_qualidade->AdvancedSearch->SearchValue;
            $this->idobjetivo_qualidade->PlaceHolder = RemoveHtml($this->idobjetivo_qualidade->caption());

            // dt_cadastro
            $this->dt_cadastro->setupEditAttributes();
            $this->dt_cadastro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->formatPattern()));
            $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

            // processo_idprocesso
            $this->processo_idprocesso->setupEditAttributes();
            $curVal = trim(strval($this->processo_idprocesso->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->processo_idprocesso->AdvancedSearch->ViewValue = $this->processo_idprocesso->lookupCacheOption($curVal);
            } else {
                $this->processo_idprocesso->AdvancedSearch->ViewValue = $this->processo_idprocesso->Lookup !== null && is_array($this->processo_idprocesso->lookupOptions()) && count($this->processo_idprocesso->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->processo_idprocesso->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->processo_idprocesso->EditValue = array_values($this->processo_idprocesso->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $this->processo_idprocesso->AdvancedSearch->SearchValue, $this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                }
                $sqlWrk = $this->processo_idprocesso->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->processo_idprocesso->EditValue = $arwrk;
            }
            $this->processo_idprocesso->PlaceHolder = RemoveHtml($this->processo_idprocesso->caption());

            // objetivo
            $this->objetivo->setupEditAttributes();
            $this->objetivo->EditValue = HtmlEncode($this->objetivo->AdvancedSearch->SearchValue);
            $this->objetivo->PlaceHolder = RemoveHtml($this->objetivo->caption());

            // como_medir
            $this->como_medir->setupEditAttributes();
            $this->como_medir->EditValue = HtmlEncode($this->como_medir->AdvancedSearch->SearchValue);
            $this->como_medir->PlaceHolder = RemoveHtml($this->como_medir->caption());

            // o_q_sera_feito
            $this->o_q_sera_feito->setupEditAttributes();
            $this->o_q_sera_feito->EditValue = HtmlEncode($this->o_q_sera_feito->AdvancedSearch->SearchValue);
            $this->o_q_sera_feito->PlaceHolder = RemoveHtml($this->o_q_sera_feito->caption());

            // como_avaliar
            $this->como_avaliar->setupEditAttributes();
            $this->como_avaliar->EditValue = HtmlEncode($this->como_avaliar->AdvancedSearch->SearchValue);
            $this->como_avaliar->PlaceHolder = RemoveHtml($this->como_avaliar->caption());

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
        if (!CheckInteger($this->idobjetivo_qualidade->AdvancedSearch->SearchValue)) {
            $this->idobjetivo_qualidade->addErrorMessage($this->idobjetivo_qualidade->getErrorMessage(false));
        }
        if (!CheckDate($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern())) {
            $this->dt_cadastro->addErrorMessage($this->dt_cadastro->getErrorMessage(false));
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
        $this->idobjetivo_qualidade->AdvancedSearch->load();
        $this->dt_cadastro->AdvancedSearch->load();
        $this->processo_idprocesso->AdvancedSearch->load();
        $this->objetivo->AdvancedSearch->load();
        $this->como_medir->AdvancedSearch->load();
        $this->o_q_sera_feito->AdvancedSearch->load();
        $this->como_avaliar->AdvancedSearch->load();
        $this->departamentos_iddepartamentos->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ObjetivoQualidadeList"), "", $this->TableVar, true);
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
                case "x_processo_idprocesso":
                    break;
                case "x_departamentos_iddepartamentos":
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
