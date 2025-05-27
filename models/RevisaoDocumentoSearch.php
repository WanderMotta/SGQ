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
class RevisaoDocumentoSearch extends RevisaoDocumento
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RevisaoDocumentoSearch";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "RevisaoDocumentoSearch";

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
        $this->idrevisao_documento->setVisibility();
        $this->documento_interno_iddocumento_interno->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->qual_alteracao->setVisibility();
        $this->status_documento_idstatus_documento->setVisibility();
        $this->revisao_nr->setVisibility();
        $this->usuario_elaborador->setVisibility();
        $this->usuario_aprovador->setVisibility();
        $this->dt_aprovacao->setVisibility();
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
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-search-table";

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
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "RevisaoDocumentoView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->documento_interno_iddocumento_interno);
        $this->setupLookupOptions($this->status_documento_idstatus_documento);
        $this->setupLookupOptions($this->usuario_elaborador);
        $this->setupLookupOptions($this->usuario_aprovador);

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
                $srchStr = "RevisaoDocumentoList" . "?" . $srchStr;
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
        $this->buildSearchUrl($srchUrl, $this->idrevisao_documento); // idrevisao_documento
        $this->buildSearchUrl($srchUrl, $this->documento_interno_iddocumento_interno); // documento_interno_iddocumento_interno
        $this->buildSearchUrl($srchUrl, $this->dt_cadastro); // dt_cadastro
        $this->buildSearchUrl($srchUrl, $this->qual_alteracao); // qual_alteracao
        $this->buildSearchUrl($srchUrl, $this->status_documento_idstatus_documento); // status_documento_idstatus_documento
        $this->buildSearchUrl($srchUrl, $this->revisao_nr); // revisao_nr
        $this->buildSearchUrl($srchUrl, $this->usuario_elaborador); // usuario_elaborador
        $this->buildSearchUrl($srchUrl, $this->usuario_aprovador); // usuario_aprovador
        $this->buildSearchUrl($srchUrl, $this->dt_aprovacao); // dt_aprovacao
        $this->buildSearchUrl($srchUrl, $this->anexo); // anexo
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

        // idrevisao_documento
        if ($this->idrevisao_documento->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // documento_interno_iddocumento_interno
        if ($this->documento_interno_iddocumento_interno->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // dt_cadastro
        if ($this->dt_cadastro->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // qual_alteracao
        if ($this->qual_alteracao->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // status_documento_idstatus_documento
        if ($this->status_documento_idstatus_documento->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // revisao_nr
        if ($this->revisao_nr->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // usuario_elaborador
        if ($this->usuario_elaborador->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // usuario_aprovador
        if ($this->usuario_aprovador->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // dt_aprovacao
        if ($this->dt_aprovacao->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // anexo
        if ($this->anexo->AdvancedSearch->get()) {
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

            // idrevisao_documento
            $this->idrevisao_documento->HrefValue = "";
            $this->idrevisao_documento->TooltipValue = "";

            // documento_interno_iddocumento_interno
            $this->documento_interno_iddocumento_interno->HrefValue = "";
            $this->documento_interno_iddocumento_interno->TooltipValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";
            $this->dt_cadastro->TooltipValue = "";

            // qual_alteracao
            $this->qual_alteracao->HrefValue = "";
            $this->qual_alteracao->TooltipValue = "";

            // status_documento_idstatus_documento
            $this->status_documento_idstatus_documento->HrefValue = "";
            $this->status_documento_idstatus_documento->TooltipValue = "";

            // revisao_nr
            $this->revisao_nr->HrefValue = "";
            $this->revisao_nr->TooltipValue = "";

            // usuario_elaborador
            $this->usuario_elaborador->HrefValue = "";
            $this->usuario_elaborador->TooltipValue = "";

            // usuario_aprovador
            $this->usuario_aprovador->HrefValue = "";
            $this->usuario_aprovador->TooltipValue = "";

            // dt_aprovacao
            $this->dt_aprovacao->HrefValue = "";
            $this->dt_aprovacao->TooltipValue = "";

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
        } elseif ($this->RowType == RowType::SEARCH) {
            // idrevisao_documento
            $this->idrevisao_documento->setupEditAttributes();
            $this->idrevisao_documento->EditValue = $this->idrevisao_documento->AdvancedSearch->SearchValue;
            $this->idrevisao_documento->PlaceHolder = RemoveHtml($this->idrevisao_documento->caption());

            // documento_interno_iddocumento_interno
            $this->documento_interno_iddocumento_interno->setupEditAttributes();
            $curVal = trim(strval($this->documento_interno_iddocumento_interno->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->documento_interno_iddocumento_interno->AdvancedSearch->ViewValue = $this->documento_interno_iddocumento_interno->lookupCacheOption($curVal);
            } else {
                $this->documento_interno_iddocumento_interno->AdvancedSearch->ViewValue = $this->documento_interno_iddocumento_interno->Lookup !== null && is_array($this->documento_interno_iddocumento_interno->lookupOptions()) && count($this->documento_interno_iddocumento_interno->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->documento_interno_iddocumento_interno->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->documento_interno_iddocumento_interno->EditValue = array_values($this->documento_interno_iddocumento_interno->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchExpression(), "=", $this->documento_interno_iddocumento_interno->AdvancedSearch->SearchValue, $this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchDataType(), "");
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

            // dt_cadastro
            $this->dt_cadastro->setupEditAttributes();
            $this->dt_cadastro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->formatPattern()));
            $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

            // qual_alteracao
            $this->qual_alteracao->setupEditAttributes();
            $this->qual_alteracao->EditValue = HtmlEncode($this->qual_alteracao->AdvancedSearch->SearchValue);
            $this->qual_alteracao->PlaceHolder = RemoveHtml($this->qual_alteracao->caption());

            // status_documento_idstatus_documento
            $curVal = trim(strval($this->status_documento_idstatus_documento->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->status_documento_idstatus_documento->AdvancedSearch->ViewValue = $this->status_documento_idstatus_documento->lookupCacheOption($curVal);
            } else {
                $this->status_documento_idstatus_documento->AdvancedSearch->ViewValue = $this->status_documento_idstatus_documento->Lookup !== null && is_array($this->status_documento_idstatus_documento->lookupOptions()) && count($this->status_documento_idstatus_documento->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->status_documento_idstatus_documento->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->status_documento_idstatus_documento->EditValue = array_values($this->status_documento_idstatus_documento->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->status_documento_idstatus_documento->Lookup->getTable()->Fields["idstatus_documento"]->searchExpression(), "=", $this->status_documento_idstatus_documento->AdvancedSearch->SearchValue, $this->status_documento_idstatus_documento->Lookup->getTable()->Fields["idstatus_documento"]->searchDataType(), "");
                }
                $sqlWrk = $this->status_documento_idstatus_documento->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->status_documento_idstatus_documento->EditValue = $arwrk;
            }
            $this->status_documento_idstatus_documento->PlaceHolder = RemoveHtml($this->status_documento_idstatus_documento->caption());

            // revisao_nr
            $this->revisao_nr->setupEditAttributes();
            $this->revisao_nr->EditValue = $this->revisao_nr->AdvancedSearch->SearchValue;
            $this->revisao_nr->PlaceHolder = RemoveHtml($this->revisao_nr->caption());

            // usuario_elaborador
            $this->usuario_elaborador->setupEditAttributes();
            $curVal = trim(strval($this->usuario_elaborador->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->usuario_elaborador->AdvancedSearch->ViewValue = $this->usuario_elaborador->lookupCacheOption($curVal);
            } else {
                $this->usuario_elaborador->AdvancedSearch->ViewValue = $this->usuario_elaborador->Lookup !== null && is_array($this->usuario_elaborador->lookupOptions()) && count($this->usuario_elaborador->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->usuario_elaborador->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->usuario_elaborador->EditValue = array_values($this->usuario_elaborador->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->usuario_elaborador->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $this->usuario_elaborador->AdvancedSearch->SearchValue, $this->usuario_elaborador->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
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
            $curVal = trim(strval($this->usuario_aprovador->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->usuario_aprovador->AdvancedSearch->ViewValue = $this->usuario_aprovador->lookupCacheOption($curVal);
            } else {
                $this->usuario_aprovador->AdvancedSearch->ViewValue = $this->usuario_aprovador->Lookup !== null && is_array($this->usuario_aprovador->lookupOptions()) && count($this->usuario_aprovador->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->usuario_aprovador->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->usuario_aprovador->EditValue = array_values($this->usuario_aprovador->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->usuario_aprovador->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $this->usuario_aprovador->AdvancedSearch->SearchValue, $this->usuario_aprovador->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
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

            // dt_aprovacao
            $this->dt_aprovacao->setupEditAttributes();
            $this->dt_aprovacao->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dt_aprovacao->AdvancedSearch->SearchValue, $this->dt_aprovacao->formatPattern()), $this->dt_aprovacao->formatPattern()));
            $this->dt_aprovacao->PlaceHolder = RemoveHtml($this->dt_aprovacao->caption());

            // anexo
            $this->anexo->setupEditAttributes();
            if (!$this->anexo->Raw) {
                $this->anexo->AdvancedSearch->SearchValue = HtmlDecode($this->anexo->AdvancedSearch->SearchValue);
            }
            $this->anexo->EditValue = HtmlEncode($this->anexo->AdvancedSearch->SearchValue);
            $this->anexo->PlaceHolder = RemoveHtml($this->anexo->caption());
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
        if (!CheckInteger($this->idrevisao_documento->AdvancedSearch->SearchValue)) {
            $this->idrevisao_documento->addErrorMessage($this->idrevisao_documento->getErrorMessage(false));
        }
        if (!CheckDate($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern())) {
            $this->dt_cadastro->addErrorMessage($this->dt_cadastro->getErrorMessage(false));
        }
        if (!CheckInteger($this->revisao_nr->AdvancedSearch->SearchValue)) {
            $this->revisao_nr->addErrorMessage($this->revisao_nr->getErrorMessage(false));
        }
        if (!CheckDate($this->dt_aprovacao->AdvancedSearch->SearchValue, $this->dt_aprovacao->formatPattern())) {
            $this->dt_aprovacao->addErrorMessage($this->dt_aprovacao->getErrorMessage(false));
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
        $this->idrevisao_documento->AdvancedSearch->load();
        $this->documento_interno_iddocumento_interno->AdvancedSearch->load();
        $this->dt_cadastro->AdvancedSearch->load();
        $this->qual_alteracao->AdvancedSearch->load();
        $this->status_documento_idstatus_documento->AdvancedSearch->load();
        $this->revisao_nr->AdvancedSearch->load();
        $this->usuario_elaborador->AdvancedSearch->load();
        $this->usuario_aprovador->AdvancedSearch->load();
        $this->dt_aprovacao->AdvancedSearch->load();
        $this->anexo->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("RevisaoDocumentoList"), "", $this->TableVar, true);
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
