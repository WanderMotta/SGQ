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
class NaoConformidadeSearch extends NaoConformidade
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "NaoConformidadeSearch";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "NaoConformidadeSearch";

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
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-search-table";

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
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "NaoConformidadeView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->tipo);
        $this->setupLookupOptions($this->processo_idprocesso);
        $this->setupLookupOptions($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
        $this->setupLookupOptions($this->departamentos_iddepartamentos);
        $this->setupLookupOptions($this->status_nc);
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
                $srchStr = "NaoConformidadeList" . "?" . $srchStr;
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
        $this->buildSearchUrl($srchUrl, $this->idnao_conformidade); // idnao_conformidade
        $this->buildSearchUrl($srchUrl, $this->dt_ocorrencia); // dt_ocorrencia
        $this->buildSearchUrl($srchUrl, $this->tipo); // tipo
        $this->buildSearchUrl($srchUrl, $this->titulo); // titulo
        $this->buildSearchUrl($srchUrl, $this->processo_idprocesso); // processo_idprocesso
        $this->buildSearchUrl($srchUrl, $this->ocorrencia); // ocorrencia
        $this->buildSearchUrl($srchUrl, $this->origem_risco_oportunidade_idorigem_risco_oportunidade); // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->buildSearchUrl($srchUrl, $this->acao_imediata); // acao_imediata
        $this->buildSearchUrl($srchUrl, $this->causa_raiz); // causa_raiz
        $this->buildSearchUrl($srchUrl, $this->departamentos_iddepartamentos); // departamentos_iddepartamentos
        $this->buildSearchUrl($srchUrl, $this->anexo); // anexo
        $this->buildSearchUrl($srchUrl, $this->status_nc); // status_nc
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

        // idnao_conformidade
        if ($this->idnao_conformidade->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // dt_ocorrencia
        if ($this->dt_ocorrencia->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // tipo
        if ($this->tipo->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // titulo
        if ($this->titulo->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // processo_idprocesso
        if ($this->processo_idprocesso->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // ocorrencia
        if ($this->ocorrencia->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // acao_imediata
        if ($this->acao_imediata->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // causa_raiz
        if ($this->causa_raiz->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // departamentos_iddepartamentos
        if ($this->departamentos_iddepartamentos->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // anexo
        if ($this->anexo->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // status_nc
        if ($this->status_nc->AdvancedSearch->get()) {
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
            $this->idnao_conformidade->TooltipValue = "";

            // dt_ocorrencia
            $this->dt_ocorrencia->HrefValue = "";
            $this->dt_ocorrencia->TooltipValue = "";

            // tipo
            $this->tipo->HrefValue = "";
            $this->tipo->TooltipValue = "";

            // titulo
            $this->titulo->HrefValue = "";
            $this->titulo->TooltipValue = "";

            // processo_idprocesso
            $this->processo_idprocesso->HrefValue = "";
            $this->processo_idprocesso->TooltipValue = "";

            // ocorrencia
            $this->ocorrencia->HrefValue = "";
            $this->ocorrencia->TooltipValue = "";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->TooltipValue = "";

            // acao_imediata
            $this->acao_imediata->HrefValue = "";
            $this->acao_imediata->TooltipValue = "";

            // causa_raiz
            $this->causa_raiz->HrefValue = "";
            $this->causa_raiz->TooltipValue = "";

            // departamentos_iddepartamentos
            $this->departamentos_iddepartamentos->HrefValue = "";
            $this->departamentos_iddepartamentos->TooltipValue = "";

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
            $this->anexo->TooltipValue = "";

            // status_nc
            $this->status_nc->HrefValue = "";
            $this->status_nc->TooltipValue = "";

            // plano_acao
            $this->plano_acao->HrefValue = "";
            $this->plano_acao->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // idnao_conformidade
            $this->idnao_conformidade->setupEditAttributes();
            $this->idnao_conformidade->EditValue = $this->idnao_conformidade->AdvancedSearch->SearchValue;
            $this->idnao_conformidade->PlaceHolder = RemoveHtml($this->idnao_conformidade->caption());

            // dt_ocorrencia
            $this->dt_ocorrencia->setupEditAttributes();
            $this->dt_ocorrencia->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dt_ocorrencia->AdvancedSearch->SearchValue, $this->dt_ocorrencia->formatPattern()), $this->dt_ocorrencia->formatPattern()));
            $this->dt_ocorrencia->PlaceHolder = RemoveHtml($this->dt_ocorrencia->caption());

            // tipo
            $this->tipo->EditValue = $this->tipo->options(false);
            $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

            // titulo
            $this->titulo->setupEditAttributes();
            if (!$this->titulo->Raw) {
                $this->titulo->AdvancedSearch->SearchValue = HtmlDecode($this->titulo->AdvancedSearch->SearchValue);
            }
            $this->titulo->EditValue = HtmlEncode($this->titulo->AdvancedSearch->SearchValue);
            $this->titulo->PlaceHolder = RemoveHtml($this->titulo->caption());

            // processo_idprocesso
            $curVal = trim(strval($this->processo_idprocesso->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->processo_idprocesso->AdvancedSearch->ViewValue = $this->processo_idprocesso->lookupCacheOption($curVal);
            } else {
                $this->processo_idprocesso->AdvancedSearch->ViewValue = $this->processo_idprocesso->Lookup !== null && is_array($this->processo_idprocesso->lookupOptions()) && count($this->processo_idprocesso->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->processo_idprocesso->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->processo_idprocesso->EditValue = array_values($this->processo_idprocesso->lookupOptions());
                if ($this->processo_idprocesso->AdvancedSearch->ViewValue == "") {
                    $this->processo_idprocesso->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
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
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->processo_idprocesso->Lookup->renderViewRow($rswrk[0]);
                    $this->processo_idprocesso->AdvancedSearch->ViewValue = $this->processo_idprocesso->displayValue($arwrk);
                } else {
                    $this->processo_idprocesso->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->processo_idprocesso->EditValue = $arwrk;
            }
            $this->processo_idprocesso->PlaceHolder = RemoveHtml($this->processo_idprocesso->caption());

            // ocorrencia
            $this->ocorrencia->setupEditAttributes();
            $this->ocorrencia->EditValue = HtmlEncode($this->ocorrencia->AdvancedSearch->SearchValue);
            $this->ocorrencia->PlaceHolder = RemoveHtml($this->ocorrencia->caption());

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

            // acao_imediata
            $this->acao_imediata->setupEditAttributes();
            $this->acao_imediata->EditValue = HtmlEncode($this->acao_imediata->AdvancedSearch->SearchValue);
            $this->acao_imediata->PlaceHolder = RemoveHtml($this->acao_imediata->caption());

            // causa_raiz
            $this->causa_raiz->setupEditAttributes();
            $this->causa_raiz->EditValue = HtmlEncode($this->causa_raiz->AdvancedSearch->SearchValue);
            $this->causa_raiz->PlaceHolder = RemoveHtml($this->causa_raiz->caption());

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

            // anexo
            $this->anexo->setupEditAttributes();
            if (!$this->anexo->Raw) {
                $this->anexo->AdvancedSearch->SearchValue = HtmlDecode($this->anexo->AdvancedSearch->SearchValue);
            }
            $this->anexo->EditValue = HtmlEncode($this->anexo->AdvancedSearch->SearchValue);
            $this->anexo->PlaceHolder = RemoveHtml($this->anexo->caption());

            // status_nc
            $this->status_nc->EditValue = $this->status_nc->options(false);
            $this->status_nc->PlaceHolder = RemoveHtml($this->status_nc->caption());

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
        if (!CheckInteger($this->idnao_conformidade->AdvancedSearch->SearchValue)) {
            $this->idnao_conformidade->addErrorMessage($this->idnao_conformidade->getErrorMessage(false));
        }
        if (!CheckDate($this->dt_ocorrencia->AdvancedSearch->SearchValue, $this->dt_ocorrencia->formatPattern())) {
            $this->dt_ocorrencia->addErrorMessage($this->dt_ocorrencia->getErrorMessage(false));
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
        $this->idnao_conformidade->AdvancedSearch->load();
        $this->dt_ocorrencia->AdvancedSearch->load();
        $this->tipo->AdvancedSearch->load();
        $this->titulo->AdvancedSearch->load();
        $this->processo_idprocesso->AdvancedSearch->load();
        $this->ocorrencia->AdvancedSearch->load();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->AdvancedSearch->load();
        $this->acao_imediata->AdvancedSearch->load();
        $this->causa_raiz->AdvancedSearch->load();
        $this->departamentos_iddepartamentos->AdvancedSearch->load();
        $this->anexo->AdvancedSearch->load();
        $this->status_nc->AdvancedSearch->load();
        $this->plano_acao->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NaoConformidadeList"), "", $this->TableVar, true);
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
