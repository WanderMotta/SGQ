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
class DocumentoExternoSearch extends DocumentoExterno
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "DocumentoExternoSearch";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "DocumentoExternoSearch";

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
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-search-table";

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
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "DocumentoExternoView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->distribuicao);
        $this->setupLookupOptions($this->tem_validade);
        $this->setupLookupOptions($this->restringir_acesso);
        $this->setupLookupOptions($this->localizacao_idlocalizacao);
        $this->setupLookupOptions($this->usuario_responsavel);

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
                $srchStr = "DocumentoExternoList" . "?" . $srchStr;
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
        $this->buildSearchUrl($srchUrl, $this->iddocumento_externo); // iddocumento_externo
        $this->buildSearchUrl($srchUrl, $this->dt_cadastro); // dt_cadastro
        $this->buildSearchUrl($srchUrl, $this->titulo_documento); // titulo_documento
        $this->buildSearchUrl($srchUrl, $this->distribuicao); // distribuicao
        $this->buildSearchUrl($srchUrl, $this->tem_validade); // tem_validade
        $this->buildSearchUrl($srchUrl, $this->valido_ate); // valido_ate
        $this->buildSearchUrl($srchUrl, $this->restringir_acesso); // restringir_acesso
        $this->buildSearchUrl($srchUrl, $this->localizacao_idlocalizacao); // localizacao_idlocalizacao
        $this->buildSearchUrl($srchUrl, $this->usuario_responsavel); // usuario_responsavel
        $this->buildSearchUrl($srchUrl, $this->anexo); // anexo
        $this->buildSearchUrl($srchUrl, $this->obs); // obs
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

        // iddocumento_externo
        if ($this->iddocumento_externo->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // dt_cadastro
        if ($this->dt_cadastro->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // titulo_documento
        if ($this->titulo_documento->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // distribuicao
        if ($this->distribuicao->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // tem_validade
        if ($this->tem_validade->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // valido_ate
        if ($this->valido_ate->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // restringir_acesso
        if ($this->restringir_acesso->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // localizacao_idlocalizacao
        if ($this->localizacao_idlocalizacao->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // usuario_responsavel
        if ($this->usuario_responsavel->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // anexo
        if ($this->anexo->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // obs
        if ($this->obs->AdvancedSearch->get()) {
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
            $this->iddocumento_externo->TooltipValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";
            $this->dt_cadastro->TooltipValue = "";

            // titulo_documento
            $this->titulo_documento->HrefValue = "";
            $this->titulo_documento->TooltipValue = "";

            // distribuicao
            $this->distribuicao->HrefValue = "";
            $this->distribuicao->TooltipValue = "";

            // tem_validade
            $this->tem_validade->HrefValue = "";
            $this->tem_validade->TooltipValue = "";

            // valido_ate
            $this->valido_ate->HrefValue = "";
            $this->valido_ate->TooltipValue = "";

            // restringir_acesso
            $this->restringir_acesso->HrefValue = "";
            $this->restringir_acesso->TooltipValue = "";

            // localizacao_idlocalizacao
            $this->localizacao_idlocalizacao->HrefValue = "";
            $this->localizacao_idlocalizacao->TooltipValue = "";

            // usuario_responsavel
            $this->usuario_responsavel->HrefValue = "";
            $this->usuario_responsavel->TooltipValue = "";

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
            $this->anexo->TooltipValue = "";

            // obs
            $this->obs->HrefValue = "";
            $this->obs->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // iddocumento_externo
            $this->iddocumento_externo->setupEditAttributes();
            $this->iddocumento_externo->EditValue = $this->iddocumento_externo->AdvancedSearch->SearchValue;
            $this->iddocumento_externo->PlaceHolder = RemoveHtml($this->iddocumento_externo->caption());

            // dt_cadastro
            $this->dt_cadastro->setupEditAttributes();
            $this->dt_cadastro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->formatPattern()));
            $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

            // titulo_documento
            $this->titulo_documento->setupEditAttributes();
            if (!$this->titulo_documento->Raw) {
                $this->titulo_documento->AdvancedSearch->SearchValue = HtmlDecode($this->titulo_documento->AdvancedSearch->SearchValue);
            }
            $this->titulo_documento->EditValue = HtmlEncode($this->titulo_documento->AdvancedSearch->SearchValue);
            $this->titulo_documento->PlaceHolder = RemoveHtml($this->titulo_documento->caption());

            // distribuicao
            $this->distribuicao->EditValue = $this->distribuicao->options(false);
            $this->distribuicao->PlaceHolder = RemoveHtml($this->distribuicao->caption());

            // tem_validade
            $this->tem_validade->EditValue = $this->tem_validade->options(false);
            $this->tem_validade->PlaceHolder = RemoveHtml($this->tem_validade->caption());

            // valido_ate
            $this->valido_ate->setupEditAttributes();
            $this->valido_ate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->valido_ate->AdvancedSearch->SearchValue, $this->valido_ate->formatPattern()), $this->valido_ate->formatPattern()));
            $this->valido_ate->PlaceHolder = RemoveHtml($this->valido_ate->caption());

            // restringir_acesso
            $this->restringir_acesso->EditValue = $this->restringir_acesso->options(false);
            $this->restringir_acesso->PlaceHolder = RemoveHtml($this->restringir_acesso->caption());

            // localizacao_idlocalizacao
            $curVal = trim(strval($this->localizacao_idlocalizacao->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->localizacao_idlocalizacao->AdvancedSearch->ViewValue = $this->localizacao_idlocalizacao->lookupCacheOption($curVal);
            } else {
                $this->localizacao_idlocalizacao->AdvancedSearch->ViewValue = $this->localizacao_idlocalizacao->Lookup !== null && is_array($this->localizacao_idlocalizacao->lookupOptions()) && count($this->localizacao_idlocalizacao->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->localizacao_idlocalizacao->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->localizacao_idlocalizacao->EditValue = array_values($this->localizacao_idlocalizacao->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->localizacao_idlocalizacao->Lookup->getTable()->Fields["idlocalizacao"]->searchExpression(), "=", $this->localizacao_idlocalizacao->AdvancedSearch->SearchValue, $this->localizacao_idlocalizacao->Lookup->getTable()->Fields["idlocalizacao"]->searchDataType(), "");
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
            $curVal = trim(strval($this->usuario_responsavel->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->usuario_responsavel->AdvancedSearch->ViewValue = $this->usuario_responsavel->lookupCacheOption($curVal);
            } else {
                $this->usuario_responsavel->AdvancedSearch->ViewValue = $this->usuario_responsavel->Lookup !== null && is_array($this->usuario_responsavel->lookupOptions()) && count($this->usuario_responsavel->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->usuario_responsavel->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->usuario_responsavel->EditValue = array_values($this->usuario_responsavel->lookupOptions());
                if ($this->usuario_responsavel->AdvancedSearch->ViewValue == "") {
                    $this->usuario_responsavel->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->usuario_responsavel->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $this->usuario_responsavel->AdvancedSearch->SearchValue, $this->usuario_responsavel->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                }
                $sqlWrk = $this->usuario_responsavel->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->usuario_responsavel->Lookup->renderViewRow($rswrk[0]);
                    $this->usuario_responsavel->AdvancedSearch->ViewValue = $this->usuario_responsavel->displayValue($arwrk);
                } else {
                    $this->usuario_responsavel->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->usuario_responsavel->EditValue = $arwrk;
            }
            $this->usuario_responsavel->PlaceHolder = RemoveHtml($this->usuario_responsavel->caption());

            // anexo
            $this->anexo->setupEditAttributes();
            if (!$this->anexo->Raw) {
                $this->anexo->AdvancedSearch->SearchValue = HtmlDecode($this->anexo->AdvancedSearch->SearchValue);
            }
            $this->anexo->EditValue = HtmlEncode($this->anexo->AdvancedSearch->SearchValue);
            $this->anexo->PlaceHolder = RemoveHtml($this->anexo->caption());

            // obs
            $this->obs->setupEditAttributes();
            if (!$this->obs->Raw) {
                $this->obs->AdvancedSearch->SearchValue = HtmlDecode($this->obs->AdvancedSearch->SearchValue);
            }
            $this->obs->EditValue = HtmlEncode($this->obs->AdvancedSearch->SearchValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());
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
        if (!CheckInteger($this->iddocumento_externo->AdvancedSearch->SearchValue)) {
            $this->iddocumento_externo->addErrorMessage($this->iddocumento_externo->getErrorMessage(false));
        }
        if (!CheckDate($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern())) {
            $this->dt_cadastro->addErrorMessage($this->dt_cadastro->getErrorMessage(false));
        }
        if (!CheckDate($this->valido_ate->AdvancedSearch->SearchValue, $this->valido_ate->formatPattern())) {
            $this->valido_ate->addErrorMessage($this->valido_ate->getErrorMessage(false));
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
        $this->iddocumento_externo->AdvancedSearch->load();
        $this->dt_cadastro->AdvancedSearch->load();
        $this->titulo_documento->AdvancedSearch->load();
        $this->distribuicao->AdvancedSearch->load();
        $this->tem_validade->AdvancedSearch->load();
        $this->valido_ate->AdvancedSearch->load();
        $this->restringir_acesso->AdvancedSearch->load();
        $this->localizacao_idlocalizacao->AdvancedSearch->load();
        $this->usuario_responsavel->AdvancedSearch->load();
        $this->anexo->AdvancedSearch->load();
        $this->obs->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("DocumentoExternoList"), "", $this->TableVar, true);
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
