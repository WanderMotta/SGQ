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
class ProcessoSearch extends Processo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ProcessoSearch";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ProcessoSearch";

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
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-search-table";

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
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "ProcessoView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->tipo_idtipo);
        $this->setupLookupOptions($this->responsaveis);
        $this->setupLookupOptions($this->proc_antes);
        $this->setupLookupOptions($this->proc_depois);

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
                $srchStr = "ProcessoList" . "?" . $srchStr;
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
        $this->buildSearchUrl($srchUrl, $this->idprocesso); // idprocesso
        $this->buildSearchUrl($srchUrl, $this->dt_cadastro); // dt_cadastro
        $this->buildSearchUrl($srchUrl, $this->revisao); // revisao
        $this->buildSearchUrl($srchUrl, $this->tipo_idtipo); // tipo_idtipo
        $this->buildSearchUrl($srchUrl, $this->processo); // processo
        $this->buildSearchUrl($srchUrl, $this->responsaveis); // responsaveis
        $this->buildSearchUrl($srchUrl, $this->objetivo); // objetivo
        $this->buildSearchUrl($srchUrl, $this->proc_antes); // proc_antes
        $this->buildSearchUrl($srchUrl, $this->proc_depois); // proc_depois
        $this->buildSearchUrl($srchUrl, $this->eqpto_recursos); // eqpto_recursos
        $this->buildSearchUrl($srchUrl, $this->entradas); // entradas
        $this->buildSearchUrl($srchUrl, $this->atividade_principal); // atividade_principal
        $this->buildSearchUrl($srchUrl, $this->saidas_resultados); // saidas_resultados
        $this->buildSearchUrl($srchUrl, $this->requsito_saidas); // requsito_saidas
        $this->buildSearchUrl($srchUrl, $this->riscos); // riscos
        $this->buildSearchUrl($srchUrl, $this->oportunidades); // oportunidades
        $this->buildSearchUrl($srchUrl, $this->propriedade_externa); // propriedade_externa
        $this->buildSearchUrl($srchUrl, $this->conhecimentos); // conhecimentos
        $this->buildSearchUrl($srchUrl, $this->documentos_aplicados); // documentos_aplicados
        $this->buildSearchUrl($srchUrl, $this->proced_int_trabalho); // proced_int_trabalho
        $this->buildSearchUrl($srchUrl, $this->mapa); // mapa
        $this->buildSearchUrl($srchUrl, $this->formulario); // formulario
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

        // idprocesso
        if ($this->idprocesso->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // dt_cadastro
        if ($this->dt_cadastro->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // revisao
        if ($this->revisao->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // tipo_idtipo
        if ($this->tipo_idtipo->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // processo
        if ($this->processo->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // responsaveis
        if ($this->responsaveis->AdvancedSearch->get()) {
            $hasValue = true;
        }
        if (is_array($this->responsaveis->AdvancedSearch->SearchValue)) {
            $this->responsaveis->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->responsaveis->AdvancedSearch->SearchValue);
        }
        if (is_array($this->responsaveis->AdvancedSearch->SearchValue2)) {
            $this->responsaveis->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->responsaveis->AdvancedSearch->SearchValue2);
        }

        // objetivo
        if ($this->objetivo->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // proc_antes
        if ($this->proc_antes->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // proc_depois
        if ($this->proc_depois->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // eqpto_recursos
        if ($this->eqpto_recursos->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // entradas
        if ($this->entradas->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // atividade_principal
        if ($this->atividade_principal->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // saidas_resultados
        if ($this->saidas_resultados->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // requsito_saidas
        if ($this->requsito_saidas->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // riscos
        if ($this->riscos->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // oportunidades
        if ($this->oportunidades->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // propriedade_externa
        if ($this->propriedade_externa->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // conhecimentos
        if ($this->conhecimentos->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // documentos_aplicados
        if ($this->documentos_aplicados->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // proced_int_trabalho
        if ($this->proced_int_trabalho->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // mapa
        if ($this->mapa->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // formulario
        if ($this->formulario->AdvancedSearch->get()) {
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
            $this->idprocesso->TooltipValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";
            $this->dt_cadastro->TooltipValue = "";

            // revisao
            $this->revisao->HrefValue = "";
            $this->revisao->TooltipValue = "";

            // tipo_idtipo
            $this->tipo_idtipo->HrefValue = "";
            $this->tipo_idtipo->TooltipValue = "";

            // processo
            $this->processo->HrefValue = "";
            $this->processo->TooltipValue = "";

            // responsaveis
            $this->responsaveis->HrefValue = "";
            $this->responsaveis->TooltipValue = "";

            // objetivo
            $this->objetivo->HrefValue = "";
            $this->objetivo->TooltipValue = "";

            // proc_antes
            $this->proc_antes->HrefValue = "";
            $this->proc_antes->TooltipValue = "";

            // proc_depois
            $this->proc_depois->HrefValue = "";
            $this->proc_depois->TooltipValue = "";

            // eqpto_recursos
            $this->eqpto_recursos->HrefValue = "";
            $this->eqpto_recursos->TooltipValue = "";

            // entradas
            $this->entradas->HrefValue = "";
            $this->entradas->TooltipValue = "";

            // atividade_principal
            $this->atividade_principal->HrefValue = "";
            $this->atividade_principal->TooltipValue = "";

            // saidas_resultados
            $this->saidas_resultados->HrefValue = "";
            $this->saidas_resultados->TooltipValue = "";

            // requsito_saidas
            $this->requsito_saidas->HrefValue = "";
            $this->requsito_saidas->TooltipValue = "";

            // riscos
            $this->riscos->HrefValue = "";
            $this->riscos->TooltipValue = "";

            // oportunidades
            $this->oportunidades->HrefValue = "";
            $this->oportunidades->TooltipValue = "";

            // propriedade_externa
            $this->propriedade_externa->HrefValue = "";
            $this->propriedade_externa->TooltipValue = "";

            // conhecimentos
            $this->conhecimentos->HrefValue = "";
            $this->conhecimentos->TooltipValue = "";

            // documentos_aplicados
            $this->documentos_aplicados->HrefValue = "";
            $this->documentos_aplicados->TooltipValue = "";

            // proced_int_trabalho
            $this->proced_int_trabalho->HrefValue = "";
            $this->proced_int_trabalho->ExportHrefValue = $this->proced_int_trabalho->UploadPath . $this->proced_int_trabalho->Upload->DbValue;
            $this->proced_int_trabalho->TooltipValue = "";

            // mapa
            $this->mapa->HrefValue = "";
            $this->mapa->ExportHrefValue = $this->mapa->UploadPath . $this->mapa->Upload->DbValue;
            $this->mapa->TooltipValue = "";

            // formulario
            $this->formulario->HrefValue = "";
            $this->formulario->ExportHrefValue = $this->formulario->UploadPath . $this->formulario->Upload->DbValue;
            $this->formulario->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // idprocesso
            $this->idprocesso->setupEditAttributes();
            $this->idprocesso->EditValue = $this->idprocesso->AdvancedSearch->SearchValue;
            $this->idprocesso->PlaceHolder = RemoveHtml($this->idprocesso->caption());

            // dt_cadastro
            $this->dt_cadastro->setupEditAttributes();
            $this->dt_cadastro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dt_cadastro->AdvancedSearch->SearchValue, $this->dt_cadastro->formatPattern()), $this->dt_cadastro->formatPattern()));
            $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

            // revisao
            $this->revisao->setupEditAttributes();
            if (!$this->revisao->Raw) {
                $this->revisao->AdvancedSearch->SearchValue = HtmlDecode($this->revisao->AdvancedSearch->SearchValue);
            }
            $this->revisao->EditValue = HtmlEncode($this->revisao->AdvancedSearch->SearchValue);
            $this->revisao->PlaceHolder = RemoveHtml($this->revisao->caption());

            // tipo_idtipo
            $curVal = trim(strval($this->tipo_idtipo->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->tipo_idtipo->AdvancedSearch->ViewValue = $this->tipo_idtipo->lookupCacheOption($curVal);
            } else {
                $this->tipo_idtipo->AdvancedSearch->ViewValue = $this->tipo_idtipo->Lookup !== null && is_array($this->tipo_idtipo->lookupOptions()) && count($this->tipo_idtipo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_idtipo->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->tipo_idtipo->EditValue = array_values($this->tipo_idtipo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchExpression(), "=", $this->tipo_idtipo->AdvancedSearch->SearchValue, $this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchDataType(), "");
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
                $this->processo->AdvancedSearch->SearchValue = HtmlDecode($this->processo->AdvancedSearch->SearchValue);
            }
            $this->processo->EditValue = HtmlEncode($this->processo->AdvancedSearch->SearchValue);
            $this->processo->PlaceHolder = RemoveHtml($this->processo->caption());

            // responsaveis
            $curVal = trim(strval($this->responsaveis->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->responsaveis->AdvancedSearch->ViewValue = $this->responsaveis->lookupCacheOption($curVal);
            } else {
                $this->responsaveis->AdvancedSearch->ViewValue = $this->responsaveis->Lookup !== null && is_array($this->responsaveis->lookupOptions()) && count($this->responsaveis->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->responsaveis->AdvancedSearch->ViewValue !== null) { // Load from cache
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
            $this->objetivo->EditValue = HtmlEncode($this->objetivo->AdvancedSearch->SearchValue);
            $this->objetivo->PlaceHolder = RemoveHtml($this->objetivo->caption());

            // proc_antes
            $curVal = trim(strval($this->proc_antes->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->proc_antes->AdvancedSearch->ViewValue = $this->proc_antes->lookupCacheOption($curVal);
            } else {
                $this->proc_antes->AdvancedSearch->ViewValue = $this->proc_antes->Lookup !== null && is_array($this->proc_antes->lookupOptions()) && count($this->proc_antes->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->proc_antes->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->proc_antes->EditValue = array_values($this->proc_antes->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->proc_antes->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $this->proc_antes->AdvancedSearch->SearchValue, $this->proc_antes->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
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
            $curVal = trim(strval($this->proc_depois->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->proc_depois->AdvancedSearch->ViewValue = $this->proc_depois->lookupCacheOption($curVal);
            } else {
                $this->proc_depois->AdvancedSearch->ViewValue = $this->proc_depois->Lookup !== null && is_array($this->proc_depois->lookupOptions()) && count($this->proc_depois->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->proc_depois->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->proc_depois->EditValue = array_values($this->proc_depois->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->proc_depois->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $this->proc_depois->AdvancedSearch->SearchValue, $this->proc_depois->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
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
            $this->eqpto_recursos->EditValue = HtmlEncode($this->eqpto_recursos->AdvancedSearch->SearchValue);
            $this->eqpto_recursos->PlaceHolder = RemoveHtml($this->eqpto_recursos->caption());

            // entradas
            $this->entradas->setupEditAttributes();
            $this->entradas->EditValue = HtmlEncode($this->entradas->AdvancedSearch->SearchValue);
            $this->entradas->PlaceHolder = RemoveHtml($this->entradas->caption());

            // atividade_principal
            $this->atividade_principal->setupEditAttributes();
            $this->atividade_principal->EditValue = HtmlEncode($this->atividade_principal->AdvancedSearch->SearchValue);
            $this->atividade_principal->PlaceHolder = RemoveHtml($this->atividade_principal->caption());

            // saidas_resultados
            $this->saidas_resultados->setupEditAttributes();
            $this->saidas_resultados->EditValue = HtmlEncode($this->saidas_resultados->AdvancedSearch->SearchValue);
            $this->saidas_resultados->PlaceHolder = RemoveHtml($this->saidas_resultados->caption());

            // requsito_saidas
            $this->requsito_saidas->setupEditAttributes();
            $this->requsito_saidas->EditValue = HtmlEncode($this->requsito_saidas->AdvancedSearch->SearchValue);
            $this->requsito_saidas->PlaceHolder = RemoveHtml($this->requsito_saidas->caption());

            // riscos
            $this->riscos->setupEditAttributes();
            $this->riscos->EditValue = HtmlEncode($this->riscos->AdvancedSearch->SearchValue);
            $this->riscos->PlaceHolder = RemoveHtml($this->riscos->caption());

            // oportunidades
            $this->oportunidades->setupEditAttributes();
            $this->oportunidades->EditValue = HtmlEncode($this->oportunidades->AdvancedSearch->SearchValue);
            $this->oportunidades->PlaceHolder = RemoveHtml($this->oportunidades->caption());

            // propriedade_externa
            $this->propriedade_externa->setupEditAttributes();
            $this->propriedade_externa->EditValue = HtmlEncode($this->propriedade_externa->AdvancedSearch->SearchValue);
            $this->propriedade_externa->PlaceHolder = RemoveHtml($this->propriedade_externa->caption());

            // conhecimentos
            $this->conhecimentos->setupEditAttributes();
            $this->conhecimentos->EditValue = HtmlEncode($this->conhecimentos->AdvancedSearch->SearchValue);
            $this->conhecimentos->PlaceHolder = RemoveHtml($this->conhecimentos->caption());

            // documentos_aplicados
            $this->documentos_aplicados->setupEditAttributes();
            $this->documentos_aplicados->EditValue = HtmlEncode($this->documentos_aplicados->AdvancedSearch->SearchValue);
            $this->documentos_aplicados->PlaceHolder = RemoveHtml($this->documentos_aplicados->caption());

            // proced_int_trabalho
            $this->proced_int_trabalho->setupEditAttributes();
            if (!$this->proced_int_trabalho->Raw) {
                $this->proced_int_trabalho->AdvancedSearch->SearchValue = HtmlDecode($this->proced_int_trabalho->AdvancedSearch->SearchValue);
            }
            $this->proced_int_trabalho->EditValue = HtmlEncode($this->proced_int_trabalho->AdvancedSearch->SearchValue);
            $this->proced_int_trabalho->PlaceHolder = RemoveHtml($this->proced_int_trabalho->caption());

            // mapa
            $this->mapa->setupEditAttributes();
            if (!$this->mapa->Raw) {
                $this->mapa->AdvancedSearch->SearchValue = HtmlDecode($this->mapa->AdvancedSearch->SearchValue);
            }
            $this->mapa->EditValue = HtmlEncode($this->mapa->AdvancedSearch->SearchValue);
            $this->mapa->PlaceHolder = RemoveHtml($this->mapa->caption());

            // formulario
            $this->formulario->setupEditAttributes();
            if (!$this->formulario->Raw) {
                $this->formulario->AdvancedSearch->SearchValue = HtmlDecode($this->formulario->AdvancedSearch->SearchValue);
            }
            $this->formulario->EditValue = HtmlEncode($this->formulario->AdvancedSearch->SearchValue);
            $this->formulario->PlaceHolder = RemoveHtml($this->formulario->caption());
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
        if (!CheckInteger($this->idprocesso->AdvancedSearch->SearchValue)) {
            $this->idprocesso->addErrorMessage($this->idprocesso->getErrorMessage(false));
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
        $this->idprocesso->AdvancedSearch->load();
        $this->dt_cadastro->AdvancedSearch->load();
        $this->revisao->AdvancedSearch->load();
        $this->tipo_idtipo->AdvancedSearch->load();
        $this->processo->AdvancedSearch->load();
        $this->responsaveis->AdvancedSearch->load();
        $this->objetivo->AdvancedSearch->load();
        $this->proc_antes->AdvancedSearch->load();
        $this->proc_depois->AdvancedSearch->load();
        $this->eqpto_recursos->AdvancedSearch->load();
        $this->entradas->AdvancedSearch->load();
        $this->atividade_principal->AdvancedSearch->load();
        $this->saidas_resultados->AdvancedSearch->load();
        $this->requsito_saidas->AdvancedSearch->load();
        $this->riscos->AdvancedSearch->load();
        $this->oportunidades->AdvancedSearch->load();
        $this->propriedade_externa->AdvancedSearch->load();
        $this->conhecimentos->AdvancedSearch->load();
        $this->documentos_aplicados->AdvancedSearch->load();
        $this->proced_int_trabalho->AdvancedSearch->load();
        $this->mapa->AdvancedSearch->load();
        $this->formulario->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ProcessoList"), "", $this->TableVar, true);
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
