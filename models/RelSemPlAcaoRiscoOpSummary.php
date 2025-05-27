<?php

namespace PHPMaker2023\sgq;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class RelSemPlAcaoRiscoOpSummary extends RelSemPlAcaoRiscoOp
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RelSemPlAcaoRiscoOpSummary";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $ReportContainerClass = "ew-grid";
    public $CurrentPageName = "RelSemPlAcaoRiscoOp";

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
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'rel_sem_pl_acao_risco_op';
        $this->TableName = 'rel_sem_pl_acao_risco_op';

        // CSS class name as context
        $this->ContextClass = CheckClassName($this->TableVar);
        AppendClass($this->ReportContainerClass, $this->ContextClass);

        // Fixed header table
        if (!$this->UseCustomTemplate) {
            $this->setFixedHeaderTable(Config("USE_FIXED_HEADER_TABLE"), Config("FIXED_HEADER_TABLE_HEIGHT"));
        }

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (rel_sem_pl_acao_risco_op)
        if (!isset($GLOBALS["rel_sem_pl_acao_risco_op"]) || get_class($GLOBALS["rel_sem_pl_acao_risco_op"]) == PROJECT_NAMESPACE . "rel_sem_pl_acao_risco_op") {
            $GLOBALS["rel_sem_pl_acao_risco_op"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'rel_sem_pl_acao_risco_op');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // Export options
        $this->ExportOptions = new ListOptions(["TagClassName" => "ew-export-option"]);

        // Filter options
        $this->FilterOptions = new ListOptions(["TagClassName" => "ew-filter-option"]);
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
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

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection if not in dashboard
        if (!$DashboardReport) {
            CloseConnections();
        }

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
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Lookup data
    public function lookup($ar = null)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $ar["field"] ?? Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;
        $name = $ar["name"] ?? Post("name");
        $isQuery = ContainsString($name, "query_builder_rule");
        if ($isQuery) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }
        if ($lookup->LinkTable == $this->TableVar || property_exists($this, "ReportSourceTable") && $lookup->LinkTable == $this->ReportSourceTable) {
            $lookup->RenderViewFunc = "renderLookup"; // Set up view renderer
        }
        $lookup->RenderEditFunc = ""; // Set up edit renderer

        // Get lookup parameters
        $lookupType = $ar["ajax"] ?? Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $ar["q"] ?? Param("q") ?? $ar["sv"] ?? Post("sv", "");
            $pageSize = $ar["n"] ?? Param("n") ?? $ar["recperpage"] ?? Post("recperpage", 10);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $ar["q"] ?? Param("q", "");
            $pageSize = $ar["n"] ?? Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $ar["start"] ?? Param("start", -1);
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $ar["page"] ?? Param("page", -1);
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($ar["s"] ?? Post("s", ""));
        $userFilter = Decrypt($ar["f"] ?? Post("f", ""));
        $userOrderBy = Decrypt($ar["o"] ?? Post("o", ""));
        $keys = $ar["keys"] ?? Post("keys");
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
            $lookup->FilterValues[] = $ar["v0"] ?? $ar["lookupValue"] ?? Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $ar["v" . $i] ?? Post("v" . $i, "");
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
        return $lookup->toJson($this, !is_array($ar)); // Use settings from current page
    }

    // Options
    public $HideOptions = false;
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $FilterOptions; // Filter options

    // Records
    public $GroupRecords = [];
    public $DetailRecords = [];
    public $DetailRecordCount = 0;

    // Paging variables
    public $RecordIndex = 0; // Record index
    public $RecordCount = 0; // Record count (start from 1 for each group)
    public $StartGroup = 0; // Start group
    public $StopGroup = 0; // Stop group
    public $TotalGroups = 0; // Total groups
    public $GroupCount = 0; // Group count
    public $GroupCounter = []; // Group counter
    public $DisplayGroups = 10; // Groups per page
    public $GroupRange = 10;
    public $PageSizes = "10,25,50,-1"; // Page sizes (comma separated)
    public $PageFirstGroupFilter = "";
    public $UserIDFilter = "";
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = "";
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $DrillDownList = "";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $SearchCommand = false;
    public $ShowHeader = true;
    public $GroupColumnCount = 0;
    public $SubGroupColumnCount = 0;
    public $DetailColumnCount = 0;
    public $TotalCount;
    public $PageTotalCount;
    public $TopContentClass = "ew-top";
    public $MiddleContentClass = "ew-middle";
    public $BottomContentClass = "ew-bottom";

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $UserProfile,
            $Security, $DrillDownInPanel, $Breadcrumb,
            $DashboardReport;

        // Set up dashboard report
        $DashboardReport = $DashboardReport || ConvertToBool(Param(Config("PAGE_DASHBOARD"), false));
        if ($DashboardReport) {
            $this->UseAjaxActions = true;
        }

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        }
        $ExportType = $this->Export; // Get export parameter, used in header
        if ($ExportType != "") {
            global $SkipHeaderFooter;
            $SkipHeaderFooter = true;
        }
        $this->CurrentAction = Param("action"); // Set up current action

        // Setup export options
        $this->setupExportOptions();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up table class
        if ($this->isExport("word") || $this->isExport("excel") || $this->isExport("pdf")) {
            $this->TableClass = "ew-table table-bordered table-sm";
        } else {
            PrependClass($this->TableClass, "table ew-table table-bordered table-sm");
        }

        // Set up report container class
        if (!$this->isExport("word") && !$this->isExport("excel")) {
            $this->ReportContainerClass .= " card ew-card";
        }

        // Set field visibility for detail fields
        $this->idrisco_oportunidade->setVisibility();
        $this->dt_cadastro->setVisibility();
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setVisibility();
        $this->titulo->setVisibility();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setVisibility();
        $this->frequencia_idfrequencia->setVisibility();
        $this->impacto_idimpacto->setVisibility();
        $this->grau_atencao->setVisibility();
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setVisibility();
        $this->plano_acao->setVisibility();

        // Set up groups per page dynamically
        $this->setupDisplayGroups();

        // Set up Breadcrumb
        if (!$this->isExport() && !$DashboardReport) {
            $this->setupBreadcrumb();
        }

        // Check if search command
        $this->SearchCommand = (Get("cmd", "") == "search");

        // Load custom filters
        $this->pageFilterLoad();

        // Extended filter
        $extendedFilter = "";

        // Restore filter list
        $this->restoreFilterList();

        // Build extended filter
        $extendedFilter = $this->getExtendedFilter();
        AddFilter($this->SearchWhere, $extendedFilter);

        // Call Page Selecting event
        $this->pageSelecting($this->SearchWhere);

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Get sort
        $this->Sort = $this->getSort();

        // Search options
        $this->setupSearchOptions();

        // Update filter
        AddFilter($this->Filter, $this->SearchWhere);

        // Get total count
        $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
        $this->TotalGroups = $this->getRecordCount($sql);
        if ($this->DisplayGroups <= 0 || $this->DrillDown) { // Display all groups
            $this->DisplayGroups = $this->TotalGroups;
        }
        $this->StartGroup = 1;

        // Set up start position if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->DisplayGroups = $this->TotalGroups;
        } else {
            $this->setupStartGroup();
        }

        // Set no record found message
        if ($this->TotalGroups == 0) {
            $this->ShowHeader = false;
            if ($Security->canList()) {
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            } else {
                $this->setWarningMessage(DeniedMessage());
            }
        }

        // Hide export options if export/dashboard report/hide options
        if ($this->isExport() || $DashboardReport || $this->HideOptions) {
            $this->ExportOptions->hideAllOptions();
        }

        // Hide search/filter options if export/drilldown/dashboard report/hide options
        if ($this->isExport() || $this->DrillDown || $DashboardReport || $this->HideOptions) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }

        // Get current page records
        if ($this->TotalGroups > 0) {
            $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, $this->Sort);
            $rs = $sql->setFirstResult(max($this->StartGroup - 1, 0))->setMaxResults($this->DisplayGroups)->execute();
            $this->DetailRecords = $rs->fetchAll(); // Get records
            $this->GroupCount = 1;
        }
        $this->setupFieldCount();

        // Set the last group to display if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->StopGroup = $this->TotalGroups;
        } else {
            $this->StopGroup = $this->StartGroup + $this->DisplayGroups - 1;
        }

        // Stop group <= total number of groups
        if (intval($this->StopGroup) > intval($this->TotalGroups)) {
            $this->StopGroup = $this->TotalGroups;
        }
        $this->RecordCount = 0;
        $this->RecordIndex = 0;
        $this->setGroupCount($this->StopGroup - $this->StartGroup + 1, 1);

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartGroup, $this->DisplayGroups, $this->TotalGroups, $this->PageSizes, $this->GroupRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Check if no records
        if ($this->TotalGroups == 0) {
            $this->ReportContainerClass .= " ew-no-record";
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

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

    // Load row values
    public function loadRowValues($record)
    {
        $data = [];
        $data["idrisco_oportunidade"] = $record['idrisco_oportunidade'];
        $data["dt_cadastro"] = $record['dt_cadastro'];
        $data["tipo_risco_oportunidade_idtipo_risco_oportunidade"] = $record['tipo_risco_oportunidade_idtipo_risco_oportunidade'];
        $data["titulo"] = $record['titulo'];
        $data["origem_risco_oportunidade_idorigem_risco_oportunidade"] = $record['origem_risco_oportunidade_idorigem_risco_oportunidade'];
        $data["frequencia_idfrequencia"] = $record['frequencia_idfrequencia'];
        $data["impacto_idimpacto"] = $record['impacto_idimpacto'];
        $data["grau_atencao"] = $record['grau_atencao'];
        $data["acao_risco_oportunidade_idacao_risco_oportunidade"] = $record['acao_risco_oportunidade_idacao_risco_oportunidade'];
        $data["plano_acao"] = $record['plano_acao'];
        $this->Rows[] = $data;
        $this->idrisco_oportunidade->setDbValue($record['idrisco_oportunidade']);
        $this->dt_cadastro->setDbValue($record['dt_cadastro']);
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setDbValue($record['tipo_risco_oportunidade_idtipo_risco_oportunidade']);
        $this->titulo->setDbValue($record['titulo']);
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValue($record['origem_risco_oportunidade_idorigem_risco_oportunidade']);
        $this->descricao->setDbValue($record['descricao']);
        $this->consequencia->setDbValue($record['consequencia']);
        $this->frequencia_idfrequencia->setDbValue($record['frequencia_idfrequencia']);
        $this->impacto_idimpacto->setDbValue($record['impacto_idimpacto']);
        $this->grau_atencao->setDbValue($record['grau_atencao']);
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setDbValue($record['acao_risco_oportunidade_idacao_risco_oportunidade']);
        $this->plano_acao->setDbValue($record['plano_acao']);
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language, $Language;
        $conn = $this->getConnection();
        if ($this->RowType == ROWTYPE_TOTAL && $this->RowTotalSubType == ROWTOTAL_FOOTER && $this->RowTotalType == ROWTOTAL_PAGE) { // Get Page total
            $records = &$this->DetailRecords;
            $this->PageTotalCount = count($records);
        } elseif ($this->RowType == ROWTYPE_TOTAL && $this->RowTotalSubType == ROWTOTAL_FOOTER && $this->RowTotalType == ROWTOTAL_GRAND) { // Get Grand total
            $hasCount = false;
            $hasSummary = false;

            // Get total count from SQL directly
            $sql = $this->buildReportSql($this->getSqlSelectCount(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
            $rstot = $conn->executeQuery($sql);
            if ($rstot && $cnt = $rstot->fetchOne()) {
                $hasCount = true;
            } else {
                $cnt = 0;
            }
            $this->TotalCount = $cnt;
            $hasSummary = true;

            // Accumulate grand summary from detail records
            if (!$hasCount || !$hasSummary) {
                $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
                $rs = $sql->execute();
                $this->DetailRecords = $rs ? $rs->fetchAll() : [];
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // idrisco_oportunidade

        // dt_cadastro

        // tipo_risco_oportunidade_idtipo_risco_oportunidade

        // titulo

        // origem_risco_oportunidade_idorigem_risco_oportunidade

        // frequencia_idfrequencia

        // impacto_idimpacto

        // grau_atencao

        // acao_risco_oportunidade_idacao_risco_oportunidade

        // plano_acao
        if ($this->RowType == ROWTYPE_SEARCH) {
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
                    $filterWrk = SearchFilter("`idtipo_risco_oportunidade`", "=", $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->EditValue = $arwrk;
            }
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->PlaceHolder = RemoveHtml($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption());

            // titulo
            if ($this->titulo->UseFilter && !EmptyValue($this->titulo->AdvancedSearch->SearchValue)) {
                if (is_array($this->titulo->AdvancedSearch->SearchValue)) {
                    $this->titulo->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->titulo->AdvancedSearch->SearchValue);
                }
                $this->titulo->EditValue = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->titulo->AdvancedSearch->SearchValue);
            }

            // plano_acao
            $this->plano_acao->EditValue = $this->plano_acao->options(false);
            $this->plano_acao->PlaceHolder = RemoveHtml($this->plano_acao->caption());
        } elseif ($this->RowType == ROWTYPE_TOTAL && !($this->RowTotalType == ROWTOTAL_GROUP && $this->RowTotalSubType == ROWTOTAL_HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == ROWTOTAL_PAGE || $this->RowTotalType == ROWTOTAL_GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class

            // idrisco_oportunidade
            $this->idrisco_oportunidade->HrefValue = "";

            // dt_cadastro
            $this->dt_cadastro->HrefValue = "";

            // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->HrefValue = "";

            // titulo
            $this->titulo->HrefValue = "";

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";

            // frequencia_idfrequencia
            $this->frequencia_idfrequencia->HrefValue = "";

            // impacto_idimpacto
            $this->impacto_idimpacto->HrefValue = "";

            // grau_atencao
            $this->grau_atencao->HrefValue = "";

            // acao_risco_oportunidade_idacao_risco_oportunidade
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->HrefValue = "";

            // plano_acao
            $this->plano_acao->HrefValue = "";
        } else {
            if ($this->RowTotalType == ROWTOTAL_GROUP && $this->RowTotalSubType == ROWTOTAL_HEADER) {
            } else {
            }

            // idrisco_oportunidade
            $this->idrisco_oportunidade->ViewValue = $this->idrisco_oportunidade->CurrentValue;
            $this->idrisco_oportunidade->CssClass = "fw-bold";
            $this->idrisco_oportunidade->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->idrisco_oportunidade->CellCssStyle .= "text-align: center;";

            // dt_cadastro
            $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
            $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
            $this->dt_cadastro->CssClass = "fw-bold";
            $this->dt_cadastro->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $curVal = strval($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue);
            if ($curVal != "") {
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->lookupCacheOption($curVal);
                if ($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`idtipo_risco_oportunidade`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
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
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // titulo
            $this->titulo->ViewValue = $this->titulo->CurrentValue;
            $this->titulo->CssClass = "fw-bold";
            $this->titulo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $curVal = strval($this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue);
            if ($curVal != "") {
                $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupCacheOption($curVal);
                if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`idorigem_risco_oportunidade`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
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
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // frequencia_idfrequencia
            $curVal = strval($this->frequencia_idfrequencia->CurrentValue);
            if ($curVal != "") {
                $this->frequencia_idfrequencia->ViewValue = $this->frequencia_idfrequencia->lookupCacheOption($curVal);
                if ($this->frequencia_idfrequencia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`idfrequencia`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->frequencia_idfrequencia->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
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
            $this->frequencia_idfrequencia->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // impacto_idimpacto
            $curVal = strval($this->impacto_idimpacto->CurrentValue);
            if ($curVal != "") {
                $this->impacto_idimpacto->ViewValue = $this->impacto_idimpacto->lookupCacheOption($curVal);
                if ($this->impacto_idimpacto->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`idimpacto`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->impacto_idimpacto->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
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
            $this->impacto_idimpacto->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // grau_atencao
            $this->grau_atencao->ViewValue = $this->grau_atencao->CurrentValue;
            $this->grau_atencao->ViewValue = FormatNumber($this->grau_atencao->ViewValue, $this->grau_atencao->formatPattern());
            $this->grau_atencao->CssClass = "fw-bold";
            $this->grau_atencao->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->grau_atencao->CellCssStyle .= "text-align: center;";

            // acao_risco_oportunidade_idacao_risco_oportunidade
            $curVal = strval($this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue);
            if ($curVal != "") {
                $this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->lookupCacheOption($curVal);
                if ($this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`idacao_risco_oportunidade`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
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
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // plano_acao
            if (strval($this->plano_acao->CurrentValue) != "") {
                $this->plano_acao->ViewValue = $this->plano_acao->optionCaption($this->plano_acao->CurrentValue);
            } else {
                $this->plano_acao->ViewValue = null;
            }
            $this->plano_acao->CssClass = "fw-bold";
            $this->plano_acao->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
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
        }

        // Call Cell_Rendered event
        if ($this->RowType == ROWTYPE_TOTAL) { // Summary row
        } else {
            // idrisco_oportunidade
            $currentValue = $this->idrisco_oportunidade->CurrentValue;
            $viewValue = &$this->idrisco_oportunidade->ViewValue;
            $viewAttrs = &$this->idrisco_oportunidade->ViewAttrs;
            $cellAttrs = &$this->idrisco_oportunidade->CellAttrs;
            $hrefValue = &$this->idrisco_oportunidade->HrefValue;
            $linkAttrs = &$this->idrisco_oportunidade->LinkAttrs;
            $this->cellRendered($this->idrisco_oportunidade, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // dt_cadastro
            $currentValue = $this->dt_cadastro->CurrentValue;
            $viewValue = &$this->dt_cadastro->ViewValue;
            $viewAttrs = &$this->dt_cadastro->ViewAttrs;
            $cellAttrs = &$this->dt_cadastro->CellAttrs;
            $hrefValue = &$this->dt_cadastro->HrefValue;
            $linkAttrs = &$this->dt_cadastro->LinkAttrs;
            $this->cellRendered($this->dt_cadastro, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $currentValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue;
            $viewValue = &$this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue;
            $viewAttrs = &$this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewAttrs;
            $cellAttrs = &$this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CellAttrs;
            $hrefValue = &$this->tipo_risco_oportunidade_idtipo_risco_oportunidade->HrefValue;
            $linkAttrs = &$this->tipo_risco_oportunidade_idtipo_risco_oportunidade->LinkAttrs;
            $this->cellRendered($this->tipo_risco_oportunidade_idtipo_risco_oportunidade, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // titulo
            $currentValue = $this->titulo->CurrentValue;
            $viewValue = &$this->titulo->ViewValue;
            $viewAttrs = &$this->titulo->ViewAttrs;
            $cellAttrs = &$this->titulo->CellAttrs;
            $hrefValue = &$this->titulo->HrefValue;
            $linkAttrs = &$this->titulo->LinkAttrs;
            $this->cellRendered($this->titulo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // origem_risco_oportunidade_idorigem_risco_oportunidade
            $currentValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue;
            $viewValue = &$this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue;
            $viewAttrs = &$this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewAttrs;
            $cellAttrs = &$this->origem_risco_oportunidade_idorigem_risco_oportunidade->CellAttrs;
            $hrefValue = &$this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue;
            $linkAttrs = &$this->origem_risco_oportunidade_idorigem_risco_oportunidade->LinkAttrs;
            $this->cellRendered($this->origem_risco_oportunidade_idorigem_risco_oportunidade, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // frequencia_idfrequencia
            $currentValue = $this->frequencia_idfrequencia->CurrentValue;
            $viewValue = &$this->frequencia_idfrequencia->ViewValue;
            $viewAttrs = &$this->frequencia_idfrequencia->ViewAttrs;
            $cellAttrs = &$this->frequencia_idfrequencia->CellAttrs;
            $hrefValue = &$this->frequencia_idfrequencia->HrefValue;
            $linkAttrs = &$this->frequencia_idfrequencia->LinkAttrs;
            $this->cellRendered($this->frequencia_idfrequencia, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // impacto_idimpacto
            $currentValue = $this->impacto_idimpacto->CurrentValue;
            $viewValue = &$this->impacto_idimpacto->ViewValue;
            $viewAttrs = &$this->impacto_idimpacto->ViewAttrs;
            $cellAttrs = &$this->impacto_idimpacto->CellAttrs;
            $hrefValue = &$this->impacto_idimpacto->HrefValue;
            $linkAttrs = &$this->impacto_idimpacto->LinkAttrs;
            $this->cellRendered($this->impacto_idimpacto, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // grau_atencao
            $currentValue = $this->grau_atencao->CurrentValue;
            $viewValue = &$this->grau_atencao->ViewValue;
            $viewAttrs = &$this->grau_atencao->ViewAttrs;
            $cellAttrs = &$this->grau_atencao->CellAttrs;
            $hrefValue = &$this->grau_atencao->HrefValue;
            $linkAttrs = &$this->grau_atencao->LinkAttrs;
            $this->cellRendered($this->grau_atencao, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // acao_risco_oportunidade_idacao_risco_oportunidade
            $currentValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue;
            $viewValue = &$this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue;
            $viewAttrs = &$this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewAttrs;
            $cellAttrs = &$this->acao_risco_oportunidade_idacao_risco_oportunidade->CellAttrs;
            $hrefValue = &$this->acao_risco_oportunidade_idacao_risco_oportunidade->HrefValue;
            $linkAttrs = &$this->acao_risco_oportunidade_idacao_risco_oportunidade->LinkAttrs;
            $this->cellRendered($this->acao_risco_oportunidade_idacao_risco_oportunidade, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // plano_acao
            $currentValue = $this->plano_acao->CurrentValue;
            $viewValue = &$this->plano_acao->ViewValue;
            $viewAttrs = &$this->plano_acao->ViewAttrs;
            $cellAttrs = &$this->plano_acao->CellAttrs;
            $hrefValue = &$this->plano_acao->HrefValue;
            $linkAttrs = &$this->plano_acao->LinkAttrs;
            $this->cellRendered($this->plano_acao, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        }

        // Call Row_Rendered event
        $this->rowRendered();
        $this->setupFieldCount();
    }
    private $groupCounts = [];

    // Get group count
    public function getGroupCount(...$args)
    {
        $key = "";
        foreach ($args as $arg) {
            if ($key != "") {
                $key .= "_";
            }
            $key .= strval($arg);
        }
        if ($key == "") {
            return -1;
        } elseif ($key == "0") { // Number of first level groups
            $i = 1;
            while (isset($this->groupCounts[strval($i)])) {
                $i++;
            }
            return $i - 1;
        }
        return isset($this->groupCounts[$key]) ? $this->groupCounts[$key] : -1;
    }

    // Set group count
    public function setGroupCount($value, ...$args)
    {
        $key = "";
        foreach ($args as $arg) {
            if ($key != "") {
                $key .= "_";
            }
            $key .= strval($arg);
        }
        if ($key == "") {
            return;
        }
        $this->groupCounts[$key] = $value;
    }

    // Setup field count
    protected function setupFieldCount()
    {
        $this->GroupColumnCount = 0;
        $this->SubGroupColumnCount = 0;
        $this->DetailColumnCount = 0;
        if ($this->idrisco_oportunidade->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->dt_cadastro->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->titulo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->frequencia_idfrequencia->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->impacto_idimpacto->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->grau_atencao->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->acao_risco_oportunidade_idacao_risco_oportunidade->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->plano_acao->Visible) {
            $this->DetailColumnCount += 1;
        }
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        if ($type == "print" || $custom) { // Printer friendly / custom export
            $pageUrl = $this->pageUrl(false);
            $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        } else { // Export API URL
            $exportUrl = GetApiUrl(Config("API_EXPORT_ACTION") . "/" . $type . "/" . $this->TableVar);
        }
        if (SameText($type, "excel")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-excel" title="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-ew-action="export" data-export="excel" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToExcel") . '</button>';
        } elseif (SameText($type, "word")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-word" title="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-ew-action="export" data-export="word" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToWord") . '</button>';
        } elseif (SameText($type, "pdf")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-pdf" title="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-ew-action="export" data-export="pdf" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToPdf") . '</button>';
        } elseif (SameText($type, "html")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-html" title="' . HtmlEncode($Language->phrase("ExportToHtml", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToHtml", true)) . '" data-ew-action="export" data-export="html" data-custom="false" data-export-selected="false" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToHtml") . '</button>';
        } elseif (SameText($type, "email")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-ew-action="email" data-custom="false" data-export-selected="false" data-hdr="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-url="' . $exportUrl . '">' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language, $Security;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = true;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = true;

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = false;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = true;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide options for export
        if ($this->isExport()) {
            $this->ExportOptions->hideAllOptions();
        }
        if (!$Security->canExport()) { // Export not allowed
            $this->ExportOptions->hideAllOptions();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl(false);
        $this->SearchOptions = new ListOptions(["TagClassName" => "ew-search-option"]);

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"frel_sem_pl_acao_risco_opsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        if ($this->UseCustomTemplate || !$this->UseAjaxActions) {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" data-ew-action=\"refresh\" data-url=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        }
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction && $this->CurrentAction != "search") {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible || $this->titulo->Visible || $this->plano_acao->Visible;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset(all)
        $Breadcrumb->add("summary", $this->TableVar, $url, "", $this->TableVar, true);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"frel_sem_pl_acao_risco_opsrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"frel_sem_pl_acao_risco_opsrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up starting group
    protected function setupStartGroup()
    {
        // Exit if no groups
        if ($this->DisplayGroups == 0) {
            return;
        }
        $startGrp = Param(Config("TABLE_START_GROUP"));
        $pageNo = Param(Config("TABLE_PAGE_NUMBER"));

        // Check for a 'start' parameter
        if ($startGrp !== null) {
            $this->StartGroup = $startGrp;
            $this->setStartGroup($this->StartGroup);
        } elseif ($pageNo !== null) {
            $pageNo = ParseInteger($pageNo);
            if (is_numeric($pageNo)) {
                $this->StartGroup = ($pageNo - 1) * $this->DisplayGroups + 1;
                if ($this->StartGroup <= 0) {
                    $this->StartGroup = 1;
                } elseif ($this->StartGroup >= intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1) {
                    $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1;
                }
                $this->setStartGroup($this->StartGroup);
            } else {
                $this->StartGroup = $this->getStartGroup();
            }
        } else {
            $this->StartGroup = $this->getStartGroup();
        }

        // Check if correct start group counter
        if (!is_numeric($this->StartGroup) || intval($this->StartGroup) <= 0) { // Avoid invalid start group counter
            $this->StartGroup = 1; // Reset start group counter
            $this->setStartGroup($this->StartGroup);
        } elseif (intval($this->StartGroup) > intval($this->TotalGroups)) { // Avoid starting group > total groups
            $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to last page first group
            $this->setStartGroup($this->StartGroup);
        } elseif (($this->StartGroup - 1) % $this->DisplayGroups != 0) {
            $this->StartGroup = intval(($this->StartGroup - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to page boundary
            $this->setStartGroup($this->StartGroup);
        }
    }

    // Reset pager
    protected function resetPager()
    {
        // Reset start position (reset command)
        $this->StartGroup = 1;
        $this->setStartGroup($this->StartGroup);
    }

    // Set up number of groups displayed per page
    protected function setupDisplayGroups()
    {
        if (Param(Config("TABLE_GROUP_PER_PAGE")) !== null) {
            $wrk = Param(Config("TABLE_GROUP_PER_PAGE"));
            if (is_numeric($wrk)) {
                $this->DisplayGroups = intval($wrk);
            } else {
                if (SameText($wrk, "ALL")) { // Display all groups
                    $this->DisplayGroups = -1;
                } else {
                    $this->DisplayGroups = 10; // Non-numeric, load default
                }
            }
            $this->setGroupPerPage($this->DisplayGroups); // Save to session

            // Reset start position (reset command)
            $this->StartGroup = 1;
            $this->setStartGroup($this->StartGroup);
        } else {
            if ($this->getGroupPerPage() != "") {
                $this->DisplayGroups = $this->getGroupPerPage(); // Restore from session
            } else {
                $this->DisplayGroups = 10; // Load default
            }
        }
    }

    // Get sort parameters based on sort links clicked
    protected function getSort()
    {
        if ($this->DrillDown) {
            return "idrisco_oportunidade DESC,titulo ASC";
        }
        $resetSort = Param("cmd") === "resetsort";
        $orderBy = Param("order", "");
        $orderType = Param("ordertype", "");

        // Check for Ctrl pressed
        $ctrl = (Param("ctrl") !== null);

        // Check for a resetsort command
        if ($resetSort) {
            $this->setOrderBy("");
            $this->setStartGroup(1);
            $this->idrisco_oportunidade->setSort("");
            $this->dt_cadastro->setSort("");
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setSort("");
            $this->titulo->setSort("");
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setSort("");
            $this->frequencia_idfrequencia->setSort("");
            $this->impacto_idimpacto->setSort("");
            $this->grau_atencao->setSort("");
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->setSort("");
            $this->plano_acao->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->idrisco_oportunidade, $ctrl); // idrisco_oportunidade
            $this->updateSort($this->dt_cadastro, $ctrl); // dt_cadastro
            $this->updateSort($this->tipo_risco_oportunidade_idtipo_risco_oportunidade, $ctrl); // tipo_risco_oportunidade_idtipo_risco_oportunidade
            $this->updateSort($this->titulo, $ctrl); // titulo
            $this->updateSort($this->origem_risco_oportunidade_idorigem_risco_oportunidade, $ctrl); // origem_risco_oportunidade_idorigem_risco_oportunidade
            $this->updateSort($this->frequencia_idfrequencia, $ctrl); // frequencia_idfrequencia
            $this->updateSort($this->impacto_idimpacto, $ctrl); // impacto_idimpacto
            $this->updateSort($this->grau_atencao, $ctrl); // grau_atencao
            $this->updateSort($this->acao_risco_oportunidade_idacao_risco_oportunidade, $ctrl); // acao_risco_oportunidade_idacao_risco_oportunidade
            $this->updateSort($this->plano_acao, $ctrl); // plano_acao
            $sortSql = $this->sortSql();
            $this->setOrderBy($sortSql);
            $this->setStartGroup(1);
        }

        // Set up default sort
        if ($this->getOrderBy() == "") {
            $useDefaultSort = true;
            if ($useDefaultSort) {
                $this->setOrderBy("idrisco_oportunidade DESC,titulo ASC");
            }
        }
        return $this->getOrderBy();
    }

    // Return extended filter
    protected function getExtendedFilter()
    {
        $filter = "";
        if ($this->DrillDown) {
            return "";
        }
        $restoreSession = false;
        $restoreDefault = false;
        // Reset search command
        if (Get("cmd") == "reset") {
            // Set default values
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->unsetSession();
            $this->titulo->AdvancedSearch->unsetSession();
            $this->plano_acao->AdvancedSearch->unsetSession();
            $restoreDefault = true;
        } else {
            $restoreSession = !$this->SearchCommand;

            // Field tipo_risco_oportunidade_idtipo_risco_oportunidade
            $this->getDropDownValue($this->tipo_risco_oportunidade_idtipo_risco_oportunidade);

            // Field titulo
            $this->getDropDownValue($this->titulo);

            // Field plano_acao
            $this->getDropDownValue($this->plano_acao);
            if (!$this->validateForm()) {
                return $filter;
            }
        }

        // Restore session
        if ($restoreSession) {
            $restoreDefault = true;
            if ($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->issetSession()) { // Field tipo_risco_oportunidade_idtipo_risco_oportunidade
                $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->titulo->AdvancedSearch->issetSession()) { // Field titulo
                $this->titulo->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->plano_acao->AdvancedSearch->issetSession()) { // Field plano_acao
                $this->plano_acao->AdvancedSearch->load();
                $restoreDefault = false;
            }
        }

        // Restore default
        if ($restoreDefault) {
            $this->loadDefaultFilters();
        }

        // Call page filter validated event
        $this->pageFilterValidated();

        // Build SQL and save to session
        $this->buildDropDownFilter($this->tipo_risco_oportunidade_idtipo_risco_oportunidade, $filter, false, true); // Field tipo_risco_oportunidade_idtipo_risco_oportunidade
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->save();
        $this->buildDropDownFilter($this->titulo, $filter, false, true); // Field titulo
        $this->titulo->AdvancedSearch->save();
        $this->buildDropDownFilter($this->plano_acao, $filter, false, true); // Field plano_acao
        $this->plano_acao->AdvancedSearch->save();

        // Field tipo_risco_oportunidade_idtipo_risco_oportunidade
        LoadDropDownList($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->EditValue, $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->SearchValue);

        // Field plano_acao
        $this->plano_acao->EditValue = ["Sim","Nao"];
        return $filter;
    }

    // Build dropdown filter
    protected function buildDropDownFilter(&$fld, &$filterClause, $default = false, $saveFilter = false)
    {
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        if (!EmptyValue($fld->DateFilter)) {
            $fldOpr = $fld->DateFilter;
            $fldVal2 = "";
        } elseif ($fld->UseFilter) {
            $fldOpr = "";
            $fldVal2 = "";
        }
        $sql = "";
        if (is_array($fldVal)) {
            foreach ($fldVal as $val) {
                $wrk = $this->getDropDownFilter($fld, $val, $fldOpr);
                if ($wrk != "") {
                    if ($sql != "") {
                        $sql .= " OR " . $wrk;
                    } else {
                        $sql = $wrk;
                    }
                }
            }
        } else {
            $sql = $this->getDropDownFilter($fld, $fldVal, $fldOpr, $fldVal2);
        }
        if ($sql != "") {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
            AddFilter($filterClause, $sql, $cond);
            if ($saveFilter) {
                $fld->CurrentFilter = $sql;
            }
        }
    }

    /**
     * Get dropdown filter
     *
     * @param ReportField $fld Report field object
     * @param string $fldVal Filter value
     * @param string $fldOpr Filter operator
     * @param string $fldVal2 Filter value 2
     * @return string WHERE clause
     */
    protected function getDropDownFilter($fld, $fldVal, $fldOpr, $fldVal2 = "")
    {
        $fldName = $fld->Name;
        $fldExpression = $fld->Expression;
        $fldDataType = $fld->DataType;
        $fldOpr = $fldOpr ?: "=";
        $fldVal = ConvertSearchValue($fldVal, $fldOpr, $fld);
        $wrk = "";
        if (SameString($fldVal, Config("NULL_VALUE"))) {
            $wrk = $fldExpression . " IS NULL";
        } elseif (SameString($fldVal, Config("NOT_NULL_VALUE"))) {
            $wrk = $fldExpression . " IS NOT NULL";
        } elseif (SameString($fldVal, Config("EMPTY_VALUE"))) {
            $wrk = $fldExpression . " = ''";
        } elseif (SameString($fldVal, Config("ALL_VALUE"))) {
            $wrk = "1 = 1";
        } else {
            if ($fld->GroupSql != "") { // Use grouping SQL for search if exists
                $fldExpression = str_replace("%s", $fldExpression, $fld->GroupSql);
            }
            if (StartsString("@@", $fldVal)) {
                $wrk = $this->getCustomFilter($fld, $fldVal, $this->Dbid);
            } elseif (($fld->isMultiSelect() || $fld->UseFilter) && IsMultiSearchOperator($fldOpr) && !EmptyValue($fldVal) && $fldVal != Config("INIT_VALUE")) {
                $wrk = GetMultiSearchSql($fld, $fldOpr, trim($fldVal), $this->Dbid);
            } elseif ($fldOpr == "BETWEEN" && !EmptyValue($fldVal) && $fldVal != Config("INIT_VALUE") && !EmptyValue($fldVal2) && $fldVal2 != Config("INIT_VALUE")) {
                $wrk = $fldExpression ." " . $fldOpr . " " . QuotedValue($fldVal, $fldDataType, $this->Dbid) . " AND " . QuotedValue($fldVal2, $fldDataType, $this->Dbid);
            } else {
                if ($fldVal != "" && $fldVal != Config("INIT_VALUE")) {
                    if ($fldDataType == DATATYPE_DATE && $fldOpr != "") {
                        $wrk = GetDateFilterSql($fld->Expression, $fldOpr, $fldVal, $fldDataType, $this->Dbid);
                    } else {
                        $wrk = SearchFilter($fldExpression, $fldOpr, $fldVal, $fldDataType, $this->Dbid);
                    }
                }
            }
        }

        // Call Page Filtering event
        if (!StartsString("@@", $fldVal)) {
            $this->pageFiltering($fld, $wrk, "dropdown", $fldOpr, $fldVal, "", "", $fldVal2);
        }
        return $wrk;
    }

    // Get custom filter
    protected function getCustomFilter(&$fld, $fldVal, $dbid = 0)
    {
        $wrk = "";
        if (is_array($fld->AdvancedFilters)) {
            foreach ($fld->AdvancedFilters as $filter) {
                if ($filter->ID == $fldVal && $filter->Enabled) {
                    $fldExpr = $fld->Expression;
                    $fn = $filter->FunctionName;
                    $wrkid = StartsString("@@", $filter->ID) ? substr($filter->ID, 2) : $filter->ID;
                    $fn = $fn != "" && !function_exists($fn) ? PROJECT_NAMESPACE . $fn : $fn;
                    if (function_exists($fn)) {
                        $wrk = $fn($fldExpr, $dbid);
                    } else {
                        $wrk = "";
                    }
                    $this->pageFiltering($fld, $wrk, "custom", $wrkid);
                    break;
                }
            }
        }
        return $wrk;
    }

    // Build extended filter
    protected function buildExtendedFilter(&$fld, &$filterClause, $default = false, $saveFilter = false)
    {
        $wrk = GetExtendedFilter($fld, $default, $this->Dbid);
        if (!$default) {
            $this->pageFiltering($fld, $wrk, "extended", $fld->AdvancedSearch->SearchOperator, $fld->AdvancedSearch->SearchValue, $fld->AdvancedSearch->SearchCondition, $fld->AdvancedSearch->SearchOperator2, $fld->AdvancedSearch->SearchValue2);
        }
        if ($wrk != "") {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
            AddFilter($filterClause, $wrk, $cond);
            if ($saveFilter) {
                $fld->CurrentFilter = $wrk;
            }
        }
    }

    // Get drop down value from querystring
    protected function getDropDownValue(&$fld)
    {
        if (IsPost()) {
            return false; // Skip post back
        }
        $res = false;
        $parm = $fld->Param;
        $opr = Get("z_$parm");
        if ($opr !== null) {
            $fld->AdvancedSearch->SearchOperator = $opr;
        }
        $val = Get("x_$parm");
        if ($val !== null) {
            if (is_array($val)) {
                $val = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $val);
            }
            $fld->AdvancedSearch->setSearchValue($val);
            $res = true;
        }
        $val2 = Get("y_$parm");
        if ($val2 !== null) {
            if (is_array($val2)) {
                $val2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $val2);
            }
            $fld->AdvancedSearch->setSearchValue2($val2);
            $res = true;
        }
        return $res;
    }

    // Dropdown filter exist
    protected function dropDownFilterExist(&$fld)
    {
        $wrk = "";
        $this->buildDropDownFilter($fld, $wrk);
        return ($wrk != "");
    }

    // Extended filter exist
    protected function extendedFilterExist(&$fld)
    {
        $extWrk = "";
        $this->buildExtendedFilter($fld, $extWrk);
        return ($extWrk != "");
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Load default value for filters
    protected function loadDefaultFilters()
    {
        // Field tipo_risco_oportunidade_idtipo_risco_oportunidade
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->loadDefault();

        // Field plano_acao
        $this->plano_acao->AdvancedSearch->loadDefault();
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Field tipo_risco_oportunidade_idtipo_risco_oportunidade
        $extWrk = "";
        $this->buildDropDownFilter($this->tipo_risco_oportunidade_idtipo_risco_oportunidade, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field plano_acao
        $extWrk = "";
        $this->buildDropDownFilter($this->plano_acao, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->plano_acao->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Show Filters
        if ($filterList != "") {
            $message = "<div id=\"ew-filter-list\" class=\"callout callout-info d-table\"><div id=\"ew-current-filters\">" .
                $Language->phrase("CurrentFilters") . "</div>" . $filterList . "</div>";
            $this->messageShowing($message, "");
            Write($message);
        } else { // Output empty tag
            Write("<div id=\"ew-filter-list\"></div>");
        }
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Field tipo_risco_oportunidade_idtipo_risco_oportunidade
        $wrk = "";
        $wrk = ($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->SearchValue != Config("INIT_VALUE")) ? $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->SearchValue : "";
        if (is_array($wrk)) {
            $wrk = implode("||", $wrk);
        }
        if ($wrk != "") {
            $wrk = "\"x_tipo_risco_oportunidade_idtipo_risco_oportunidade\":\"" . JsEncode($wrk) . "\"";
        }
        if ($wrk != "") {
            if ($filterList != "") {
                $filterList .= ",";
            }
            $filterList .= $wrk;
        }

        // Field plano_acao
        $wrk = "";
        $wrk = ($this->plano_acao->AdvancedSearch->SearchValue != Config("INIT_VALUE")) ? $this->plano_acao->AdvancedSearch->SearchValue : "";
        if (is_array($wrk)) {
            $wrk = implode("||", $wrk);
        }
        if ($wrk != "") {
            $wrk = "\"x_plano_acao\":\"" . JsEncode($wrk) . "\"";
        }
        if ($wrk != "") {
            if ($filterList != "") {
                $filterList .= ",";
            }
            $filterList .= $wrk;
        }

        // Return filter list in json
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd", "") != "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter", ""), true);
        return $this->setupFilterList($filter);
    }

    // Setup list of filters
    protected function setupFilterList($filter)
    {
        if (!is_array($filter)) {
            return false;
        }

        // Field tipo_risco_oportunidade_idtipo_risco_oportunidade
        if (!$this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->get($filter)) {
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->save();

        // Field plano_acao
        if (!$this->plano_acao->AdvancedSearch->get($filter)) {
            $this->plano_acao->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->plano_acao->AdvancedSearch->save();
        return true;
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
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
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

    // Page Selecting event
    public function pageSelecting(&$filter)
    {
        // Enter your code here
    }

    // Load Filters event
    public function pageFilterLoad()
    {
        // Enter your code here
        // Example: Register/Unregister Custom Extended Filter
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
        //UnregisterFilter($this-><Field>, 'StartsWithA');
    }

    // Page Filter Validated event
    public function pageFilterValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Page Filtering event
    public function pageFiltering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "")
    {
        // Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
        //if ($typ == "dropdown" && $fld->Name == "MyField") // Dropdown filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "extended" && $fld->Name == "MyField") // Extended filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "custom" && $opr == "..." && $fld->Name == "MyField") // Custom filter, $opr is the custom filter ID
        //    $filter = "..."; // Modify the filter
    }

    // Cell Rendered event
    public function cellRendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs)
    {
        //$ViewValue = "xxx";
        //$ViewAttrs["class"] = "xxx";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
