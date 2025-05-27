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
class RelProcessosSummary extends RelProcessos
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RelProcessosSummary";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $ReportContainerClass = "ew-grid";
    public $CurrentPageName = "RelProcessos";

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

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'rel_processos';
        $this->TableName = 'rel_processos';

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
        $Language = Container("app.language");

        // Table object (rel_processos)
        if (!isset($GLOBALS["rel_processos"]) || $GLOBALS["rel_processos"]::class == PROJECT_NAMESPACE . "rel_processos") {
            $GLOBALS["rel_processos"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'rel_processos');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // Export options
        $this->ExportOptions = new ListOptions(TagClassName: "ew-export-option");

        // Filter options
        $this->FilterOptions = new ListOptions(TagClassName: "ew-filter-option");
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
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
        if ($fld instanceof ReportField) {
            $lookup->RenderViewFunc = "renderLookup"; // Set up view renderer
        }
        $lookup->RenderEditFunc = ""; // Set up edit renderer

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
        global $ExportType, $Language, $Security, $DrillDownInPanel, $Breadcrumb, $DashboardReport;

        // Set up dashboard report
        $DashboardReport ??= Param(Config("PAGE_DASHBOARD"));
        if ($DashboardReport) {
            $this->UseAjaxActions = true;
            AddFilter($this->Filter, $this->getDashboardFilter($DashboardReport, $this->TableVar)); // Set up Dashboard Filter
        }

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }

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
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

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
        $this->responsaveis->setVisibility();
        $this->objetivo->setVisibility();
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
        $this->tipo_idtipo->setVisibility();
        $this->proced_int_trabalho->setVisibility();
        $this->mapa->setVisibility();
        $this->revisao->setVisibility();
        $this->proc_antes->setVisibility();
        $this->proc_depois->setVisibility();

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

        // Get total group count
        $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
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

        // Get group records
        if ($this->TotalGroups > 0) {
            $grpSort = UpdateSortFields($this->getSqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
            $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderByGroup(), $this->Filter, $grpSort);
            $grpRs = $sql->setFirstResult(max($this->StartGroup - 1, 0))->setMaxResults($this->DisplayGroups)->executeQuery();
            $this->GroupRecords = $grpRs->fetchAll(); // Get records of first grouping field
            $this->loadGroupRowValues();
            $this->GroupCount = 1;
        }

        // Init detail records
        $this->DetailRecords = [];
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

    // Load group row values
    public function loadGroupRowValues()
    {
        $cnt = count($this->GroupRecords); // Get record count
        if ($this->GroupCount < $cnt) {
            $this->processo->setGroupValue(reset($this->GroupRecords[$this->GroupCount]));
        } else {
            $this->processo->setGroupValue("");
        }
    }

    // Load row values
    public function loadRowValues($record)
    {
        $data = [];
        $data["idprocesso"] = $record['idprocesso'];
        $data["dt_cadastro"] = $record['dt_cadastro'];
        $data["processo"] = $record['processo'];
        $data["responsaveis"] = $record['responsaveis'];
        $data["objetivo"] = $record['objetivo'];
        $data["eqpto_recursos"] = $record['eqpto_recursos'];
        $data["entradas"] = $record['entradas'];
        $data["atividade_principal"] = $record['atividade_principal'];
        $data["saidas_resultados"] = $record['saidas_resultados'];
        $data["requsito_saidas"] = $record['requsito_saidas'];
        $data["riscos"] = $record['riscos'];
        $data["oportunidades"] = $record['oportunidades'];
        $data["propriedade_externa"] = $record['propriedade_externa'];
        $data["conhecimentos"] = $record['conhecimentos'];
        $data["documentos_aplicados"] = $record['documentos_aplicados'];
        $data["tipo_idtipo"] = $record['tipo_idtipo'];
        $data["proced_int_trabalho"] = $record['proced_int_trabalho'];
        $data["mapa"] = $record['mapa'];
        $data["revisao"] = $record['revisao'];
        $data["proc_antes"] = $record['proc_antes'];
        $data["proc_depois"] = $record['proc_depois'];
        $this->Rows[] = $data;
        $this->idprocesso->setDbValue($record['idprocesso']);
        $this->dt_cadastro->setDbValue($record['dt_cadastro']);
        $this->processo->setDbValue(GroupValue($this->processo, $record['processo']));
        $this->responsaveis->setDbValue($record['responsaveis']);
        $this->objetivo->setDbValue($record['objetivo']);
        $this->eqpto_recursos->setDbValue($record['eqpto_recursos']);
        $this->entradas->setDbValue($record['entradas']);
        $this->atividade_principal->setDbValue($record['atividade_principal']);
        $this->saidas_resultados->setDbValue($record['saidas_resultados']);
        $this->requsito_saidas->setDbValue($record['requsito_saidas']);
        $this->riscos->setDbValue($record['riscos']);
        $this->oportunidades->setDbValue($record['oportunidades']);
        $this->propriedade_externa->setDbValue($record['propriedade_externa']);
        $this->conhecimentos->setDbValue($record['conhecimentos']);
        $this->documentos_aplicados->setDbValue($record['documentos_aplicados']);
        $this->tipo_idtipo->setDbValue($record['tipo_idtipo']);
        $this->proced_int_trabalho->setDbValue($record['proced_int_trabalho']);
        $this->mapa->setDbValue($record['mapa']);
        $this->revisao->setDbValue($record['revisao']);
        $this->proc_antes->setDbValue($record['proc_antes']);
        $this->proc_depois->setDbValue($record['proc_depois']);
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language, $Language;
        $conn = $this->getConnection();
        if ($this->RowType == RowType::TOTAL && $this->RowTotalSubType == RowTotal::FOOTER && $this->RowTotalType == RowSummary::PAGE) {
            // Build detail SQL
            $firstGrpFld = &$this->processo;
            $firstGrpFld->getDistinctValues($this->GroupRecords);
            $where = DetailFilterSql($firstGrpFld, $this->getSqlFirstGroupField(), $firstGrpFld->DistinctValues, $this->Dbid);
            AddFilter($where, $this->Filter);
            $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $where, $this->Sort);
            $rs = $sql->executeQuery();
            $records = $rs?->fetchAll() ?? [];
            $this->PageTotalCount = count($records);
        } elseif ($this->RowType == RowType::TOTAL && $this->RowTotalSubType == RowTotal::FOOTER && $this->RowTotalType == RowSummary::GRAND) { // Get Grand total
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
                $rs = $sql->executeQuery();
                $this->DetailRecords = $rs?->fetchAll() ?? [];
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // processo

        // responsaveis

        // objetivo

        // eqpto_recursos

        // entradas

        // atividade_principal

        // saidas_resultados

        // requsito_saidas

        // riscos

        // oportunidades

        // propriedade_externa

        // conhecimentos

        // documentos_aplicados

        // tipo_idtipo

        // proced_int_trabalho

        // mapa

        // revisao

        // proc_antes

        // proc_depois
        if ($this->RowType == RowType::SEARCH) {
            // processo
            $this->processo->setupEditAttributes();
            $curVal = trim(strval($this->processo->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->processo->AdvancedSearch->ViewValue = $this->processo->lookupCacheOption($curVal);
            } else {
                $this->processo->AdvancedSearch->ViewValue = $this->processo->Lookup !== null && is_array($this->processo->lookupOptions()) && count($this->processo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->processo->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->processo->EditValue = array_values($this->processo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->processo->Lookup->getTable()->Fields["processo"]->searchExpression(), "=", $this->processo->AdvancedSearch->SearchValue, $this->processo->Lookup->getTable()->Fields["processo"]->searchDataType(), "");
                }
                $sqlWrk = $this->processo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->processo->EditValue = $arwrk;
            }
            $this->processo->PlaceHolder = RemoveHtml($this->processo->caption());
        } elseif ($this->RowType == RowType::TOTAL && !($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == RowSummary::PAGE || $this->RowTotalType == RowSummary::GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class
            if ($this->RowTotalType == RowSummary::GROUP) {
                $this->RowAttrs["data-group"] = $this->processo->groupValue(); // Set up group attribute
            }

            // processo
            $arwrk = [];
            $arwrk["lf"] = $this->processo->CurrentValue;
            $arwrk["df"] = $this->processo->CurrentValue;
            $arwrk = $this->processo->Lookup->renderViewRow($arwrk, $this);
            $dispVal = $this->processo->displayValue($arwrk);
            if ($dispVal != "") {
                $this->processo->GroupViewValue = $dispVal;
            }
            $this->processo->CssClass = "fw-bold";
            $this->processo->CellCssClass = ($this->RowGroupLevel == 1 ? "ew-rpt-grp-summary-1" : "ew-rpt-grp-field-1");
            $this->processo->GroupViewValue = DisplayGroupValue($this->processo, $this->processo->GroupViewValue);

            // processo
            $this->processo->HrefValue = "";

            // responsaveis
            $this->responsaveis->HrefValue = "";

            // objetivo
            $this->objetivo->HrefValue = "";

            // eqpto_recursos
            $this->eqpto_recursos->HrefValue = "";

            // entradas
            $this->entradas->HrefValue = "";

            // atividade_principal
            $this->atividade_principal->HrefValue = "";

            // saidas_resultados
            $this->saidas_resultados->HrefValue = "";

            // requsito_saidas
            $this->requsito_saidas->HrefValue = "";

            // riscos
            $this->riscos->HrefValue = "";

            // oportunidades
            $this->oportunidades->HrefValue = "";

            // propriedade_externa
            $this->propriedade_externa->HrefValue = "";

            // conhecimentos
            $this->conhecimentos->HrefValue = "";

            // documentos_aplicados
            $this->documentos_aplicados->HrefValue = "";

            // tipo_idtipo
            $this->tipo_idtipo->HrefValue = "";

            // proced_int_trabalho
            $this->proced_int_trabalho->HrefValue = "";

            // mapa
            $this->mapa->HrefValue = "";

            // revisao
            $this->revisao->HrefValue = "";

            // proc_antes
            $this->proc_antes->HrefValue = "";

            // proc_depois
            $this->proc_depois->HrefValue = "";
        } else {
            if ($this->RowTotalType == RowSummary::GROUP && $this->RowTotalSubType == RowTotal::HEADER) {
                $this->RowAttrs["data-group"] = $this->processo->groupValue(); // Set up group attribute
            } else {
                $this->RowAttrs["data-group"] = $this->processo->groupValue(); // Set up group attribute
            }

            // processo
            $arwrk = [];
            $arwrk["lf"] = $this->processo->CurrentValue;
            $arwrk["df"] = $this->processo->CurrentValue;
            $arwrk = $this->processo->Lookup->renderViewRow($arwrk, $this);
            $dispVal = $this->processo->displayValue($arwrk);
            if ($dispVal != "") {
                $this->processo->GroupViewValue = $dispVal;
            }
            $this->processo->CssClass = "fw-bold";
            $this->processo->CellCssClass = "ew-rpt-grp-field-1";
            $this->processo->GroupViewValue = DisplayGroupValue($this->processo, $this->processo->GroupViewValue);
            if (!$this->processo->LevelBreak) {
                $this->processo->GroupViewValue = "";
            } else {
                $this->processo->LevelBreak = false;
            }

            // Increment RowCount
            if ($this->RowType == RowType::DETAIL) {
                $this->RowCount++;
            }

            // responsaveis
            $curVal = strval($this->responsaveis->CurrentValue);
            if ($curVal != "") {
                $this->responsaveis->ViewValue = $this->responsaveis->lookupCacheOption($curVal);
                if ($this->responsaveis->ViewValue === null) { // Lookup from database
                    $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        AddFilter($filterWrk, SearchFilter($this->responsaveis->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", trim($wrk), $this->responsaveis->Lookup->getTable()->Fields["idusuario"]->searchDataType(), ""), "OR");
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
            $this->responsaveis->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // objetivo
            $this->objetivo->ViewValue = $this->objetivo->CurrentValue;
            $this->objetivo->CssClass = "fw-bold";
            $this->objetivo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // eqpto_recursos
            $this->eqpto_recursos->ViewValue = $this->eqpto_recursos->CurrentValue;
            $this->eqpto_recursos->CssClass = "fw-bold";
            $this->eqpto_recursos->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // entradas
            $this->entradas->ViewValue = $this->entradas->CurrentValue;
            $this->entradas->CssClass = "fw-bold";
            $this->entradas->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // atividade_principal
            $this->atividade_principal->ViewValue = $this->atividade_principal->CurrentValue;
            $this->atividade_principal->CssClass = "fw-bold";
            $this->atividade_principal->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // saidas_resultados
            $this->saidas_resultados->ViewValue = $this->saidas_resultados->CurrentValue;
            $this->saidas_resultados->CssClass = "fw-bold";
            $this->saidas_resultados->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // requsito_saidas
            $this->requsito_saidas->ViewValue = $this->requsito_saidas->CurrentValue;
            $this->requsito_saidas->CssClass = "fw-bold";
            $this->requsito_saidas->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // riscos
            $this->riscos->ViewValue = $this->riscos->CurrentValue;
            $this->riscos->CssClass = "fw-bold";
            $this->riscos->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // oportunidades
            $this->oportunidades->ViewValue = $this->oportunidades->CurrentValue;
            $this->oportunidades->CssClass = "fw-bold";
            $this->oportunidades->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // propriedade_externa
            $this->propriedade_externa->ViewValue = $this->propriedade_externa->CurrentValue;
            $this->propriedade_externa->CssClass = "fw-bold";
            $this->propriedade_externa->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // conhecimentos
            $this->conhecimentos->ViewValue = $this->conhecimentos->CurrentValue;
            $this->conhecimentos->CssClass = "fw-bold";
            $this->conhecimentos->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // documentos_aplicados
            $this->documentos_aplicados->ViewValue = $this->documentos_aplicados->CurrentValue;
            $this->documentos_aplicados->CssClass = "fw-bold";
            $this->documentos_aplicados->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // tipo_idtipo
            $this->tipo_idtipo->ViewValue = $this->tipo_idtipo->CurrentValue;
            $this->tipo_idtipo->ViewValue = FormatNumber($this->tipo_idtipo->ViewValue, $this->tipo_idtipo->formatPattern());
            $this->tipo_idtipo->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // proced_int_trabalho
            $this->proced_int_trabalho->ViewValue = $this->proced_int_trabalho->CurrentValue;
            $this->proced_int_trabalho->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // mapa
            $this->mapa->ViewValue = $this->mapa->CurrentValue;
            $this->mapa->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // revisao
            $this->revisao->ViewValue = $this->revisao->CurrentValue;
            $this->revisao->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // proc_antes
            $this->proc_antes->ViewValue = $this->proc_antes->CurrentValue;
            $this->proc_antes->ViewValue = FormatNumber($this->proc_antes->ViewValue, $this->proc_antes->formatPattern());
            $this->proc_antes->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // proc_depois
            $this->proc_depois->ViewValue = $this->proc_depois->CurrentValue;
            $this->proc_depois->ViewValue = FormatNumber($this->proc_depois->ViewValue, $this->proc_depois->formatPattern());
            $this->proc_depois->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");

            // processo
            $this->processo->HrefValue = "";
            $this->processo->TooltipValue = "";

            // responsaveis
            $this->responsaveis->HrefValue = "";
            $this->responsaveis->TooltipValue = "";

            // objetivo
            $this->objetivo->HrefValue = "";
            $this->objetivo->TooltipValue = "";

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

            // tipo_idtipo
            $this->tipo_idtipo->HrefValue = "";
            $this->tipo_idtipo->TooltipValue = "";

            // proced_int_trabalho
            $this->proced_int_trabalho->HrefValue = "";
            $this->proced_int_trabalho->TooltipValue = "";

            // mapa
            $this->mapa->HrefValue = "";
            $this->mapa->TooltipValue = "";

            // revisao
            $this->revisao->HrefValue = "";
            $this->revisao->TooltipValue = "";

            // proc_antes
            $this->proc_antes->HrefValue = "";
            $this->proc_antes->TooltipValue = "";

            // proc_depois
            $this->proc_depois->HrefValue = "";
            $this->proc_depois->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == RowType::TOTAL) {
            // processo
            $currentValue = $this->processo->GroupViewValue;
            $viewValue = &$this->processo->GroupViewValue;
            $viewAttrs = &$this->processo->ViewAttrs;
            $cellAttrs = &$this->processo->CellAttrs;
            $hrefValue = &$this->processo->HrefValue;
            $linkAttrs = &$this->processo->LinkAttrs;
            $this->cellRendered($this->processo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        } else {
            // processo
            $currentValue = $this->processo->groupValue();
            $viewValue = &$this->processo->GroupViewValue;
            $viewAttrs = &$this->processo->ViewAttrs;
            $cellAttrs = &$this->processo->CellAttrs;
            $hrefValue = &$this->processo->HrefValue;
            $linkAttrs = &$this->processo->LinkAttrs;
            $this->cellRendered($this->processo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // responsaveis
            $currentValue = $this->responsaveis->CurrentValue;
            $viewValue = &$this->responsaveis->ViewValue;
            $viewAttrs = &$this->responsaveis->ViewAttrs;
            $cellAttrs = &$this->responsaveis->CellAttrs;
            $hrefValue = &$this->responsaveis->HrefValue;
            $linkAttrs = &$this->responsaveis->LinkAttrs;
            $this->cellRendered($this->responsaveis, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // objetivo
            $currentValue = $this->objetivo->CurrentValue;
            $viewValue = &$this->objetivo->ViewValue;
            $viewAttrs = &$this->objetivo->ViewAttrs;
            $cellAttrs = &$this->objetivo->CellAttrs;
            $hrefValue = &$this->objetivo->HrefValue;
            $linkAttrs = &$this->objetivo->LinkAttrs;
            $this->cellRendered($this->objetivo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // eqpto_recursos
            $currentValue = $this->eqpto_recursos->CurrentValue;
            $viewValue = &$this->eqpto_recursos->ViewValue;
            $viewAttrs = &$this->eqpto_recursos->ViewAttrs;
            $cellAttrs = &$this->eqpto_recursos->CellAttrs;
            $hrefValue = &$this->eqpto_recursos->HrefValue;
            $linkAttrs = &$this->eqpto_recursos->LinkAttrs;
            $this->cellRendered($this->eqpto_recursos, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // entradas
            $currentValue = $this->entradas->CurrentValue;
            $viewValue = &$this->entradas->ViewValue;
            $viewAttrs = &$this->entradas->ViewAttrs;
            $cellAttrs = &$this->entradas->CellAttrs;
            $hrefValue = &$this->entradas->HrefValue;
            $linkAttrs = &$this->entradas->LinkAttrs;
            $this->cellRendered($this->entradas, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // atividade_principal
            $currentValue = $this->atividade_principal->CurrentValue;
            $viewValue = &$this->atividade_principal->ViewValue;
            $viewAttrs = &$this->atividade_principal->ViewAttrs;
            $cellAttrs = &$this->atividade_principal->CellAttrs;
            $hrefValue = &$this->atividade_principal->HrefValue;
            $linkAttrs = &$this->atividade_principal->LinkAttrs;
            $this->cellRendered($this->atividade_principal, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // saidas_resultados
            $currentValue = $this->saidas_resultados->CurrentValue;
            $viewValue = &$this->saidas_resultados->ViewValue;
            $viewAttrs = &$this->saidas_resultados->ViewAttrs;
            $cellAttrs = &$this->saidas_resultados->CellAttrs;
            $hrefValue = &$this->saidas_resultados->HrefValue;
            $linkAttrs = &$this->saidas_resultados->LinkAttrs;
            $this->cellRendered($this->saidas_resultados, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // requsito_saidas
            $currentValue = $this->requsito_saidas->CurrentValue;
            $viewValue = &$this->requsito_saidas->ViewValue;
            $viewAttrs = &$this->requsito_saidas->ViewAttrs;
            $cellAttrs = &$this->requsito_saidas->CellAttrs;
            $hrefValue = &$this->requsito_saidas->HrefValue;
            $linkAttrs = &$this->requsito_saidas->LinkAttrs;
            $this->cellRendered($this->requsito_saidas, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // riscos
            $currentValue = $this->riscos->CurrentValue;
            $viewValue = &$this->riscos->ViewValue;
            $viewAttrs = &$this->riscos->ViewAttrs;
            $cellAttrs = &$this->riscos->CellAttrs;
            $hrefValue = &$this->riscos->HrefValue;
            $linkAttrs = &$this->riscos->LinkAttrs;
            $this->cellRendered($this->riscos, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // oportunidades
            $currentValue = $this->oportunidades->CurrentValue;
            $viewValue = &$this->oportunidades->ViewValue;
            $viewAttrs = &$this->oportunidades->ViewAttrs;
            $cellAttrs = &$this->oportunidades->CellAttrs;
            $hrefValue = &$this->oportunidades->HrefValue;
            $linkAttrs = &$this->oportunidades->LinkAttrs;
            $this->cellRendered($this->oportunidades, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // propriedade_externa
            $currentValue = $this->propriedade_externa->CurrentValue;
            $viewValue = &$this->propriedade_externa->ViewValue;
            $viewAttrs = &$this->propriedade_externa->ViewAttrs;
            $cellAttrs = &$this->propriedade_externa->CellAttrs;
            $hrefValue = &$this->propriedade_externa->HrefValue;
            $linkAttrs = &$this->propriedade_externa->LinkAttrs;
            $this->cellRendered($this->propriedade_externa, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // conhecimentos
            $currentValue = $this->conhecimentos->CurrentValue;
            $viewValue = &$this->conhecimentos->ViewValue;
            $viewAttrs = &$this->conhecimentos->ViewAttrs;
            $cellAttrs = &$this->conhecimentos->CellAttrs;
            $hrefValue = &$this->conhecimentos->HrefValue;
            $linkAttrs = &$this->conhecimentos->LinkAttrs;
            $this->cellRendered($this->conhecimentos, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // documentos_aplicados
            $currentValue = $this->documentos_aplicados->CurrentValue;
            $viewValue = &$this->documentos_aplicados->ViewValue;
            $viewAttrs = &$this->documentos_aplicados->ViewAttrs;
            $cellAttrs = &$this->documentos_aplicados->CellAttrs;
            $hrefValue = &$this->documentos_aplicados->HrefValue;
            $linkAttrs = &$this->documentos_aplicados->LinkAttrs;
            $this->cellRendered($this->documentos_aplicados, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // tipo_idtipo
            $currentValue = $this->tipo_idtipo->CurrentValue;
            $viewValue = &$this->tipo_idtipo->ViewValue;
            $viewAttrs = &$this->tipo_idtipo->ViewAttrs;
            $cellAttrs = &$this->tipo_idtipo->CellAttrs;
            $hrefValue = &$this->tipo_idtipo->HrefValue;
            $linkAttrs = &$this->tipo_idtipo->LinkAttrs;
            $this->cellRendered($this->tipo_idtipo, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // proced_int_trabalho
            $currentValue = $this->proced_int_trabalho->CurrentValue;
            $viewValue = &$this->proced_int_trabalho->ViewValue;
            $viewAttrs = &$this->proced_int_trabalho->ViewAttrs;
            $cellAttrs = &$this->proced_int_trabalho->CellAttrs;
            $hrefValue = &$this->proced_int_trabalho->HrefValue;
            $linkAttrs = &$this->proced_int_trabalho->LinkAttrs;
            $this->cellRendered($this->proced_int_trabalho, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // mapa
            $currentValue = $this->mapa->CurrentValue;
            $viewValue = &$this->mapa->ViewValue;
            $viewAttrs = &$this->mapa->ViewAttrs;
            $cellAttrs = &$this->mapa->CellAttrs;
            $hrefValue = &$this->mapa->HrefValue;
            $linkAttrs = &$this->mapa->LinkAttrs;
            $this->cellRendered($this->mapa, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // revisao
            $currentValue = $this->revisao->CurrentValue;
            $viewValue = &$this->revisao->ViewValue;
            $viewAttrs = &$this->revisao->ViewAttrs;
            $cellAttrs = &$this->revisao->CellAttrs;
            $hrefValue = &$this->revisao->HrefValue;
            $linkAttrs = &$this->revisao->LinkAttrs;
            $this->cellRendered($this->revisao, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // proc_antes
            $currentValue = $this->proc_antes->CurrentValue;
            $viewValue = &$this->proc_antes->ViewValue;
            $viewAttrs = &$this->proc_antes->ViewAttrs;
            $cellAttrs = &$this->proc_antes->CellAttrs;
            $hrefValue = &$this->proc_antes->HrefValue;
            $linkAttrs = &$this->proc_antes->LinkAttrs;
            $this->cellRendered($this->proc_antes, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // proc_depois
            $currentValue = $this->proc_depois->CurrentValue;
            $viewValue = &$this->proc_depois->ViewValue;
            $viewAttrs = &$this->proc_depois->ViewAttrs;
            $cellAttrs = &$this->proc_depois->CellAttrs;
            $hrefValue = &$this->proc_depois->HrefValue;
            $linkAttrs = &$this->proc_depois->LinkAttrs;
            $this->cellRendered($this->proc_depois, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
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
        if ($this->processo->Visible) {
            $this->GroupColumnCount += 1;
        }
        if ($this->responsaveis->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->objetivo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->eqpto_recursos->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->entradas->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->atividade_principal->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->saidas_resultados->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->requsito_saidas->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->riscos->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->oportunidades->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->propriedade_externa->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->conhecimentos->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->documentos_aplicados->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->tipo_idtipo->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->proced_int_trabalho->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->mapa->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->revisao->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->proc_antes->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->proc_depois->Visible) {
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
        $item->Visible = true;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = true;

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
        $this->SearchOptions = new ListOptions(TagClassName: "ew-search-option");

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"frel_processossrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
        return $this->processo->Visible;
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
        if ($fld->Lookup && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_processo":
                    break;
                case "x_responsaveis":
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"frel_processossrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"frel_processossrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
            return "processo ASC";
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
            $this->processo->setSort("");
            $this->responsaveis->setSort("");
            $this->objetivo->setSort("");
            $this->eqpto_recursos->setSort("");
            $this->entradas->setSort("");
            $this->atividade_principal->setSort("");
            $this->saidas_resultados->setSort("");
            $this->requsito_saidas->setSort("");
            $this->riscos->setSort("");
            $this->oportunidades->setSort("");
            $this->propriedade_externa->setSort("");
            $this->conhecimentos->setSort("");
            $this->documentos_aplicados->setSort("");
            $this->tipo_idtipo->setSort("");
            $this->proced_int_trabalho->setSort("");
            $this->mapa->setSort("");
            $this->revisao->setSort("");
            $this->proc_antes->setSort("");
            $this->proc_depois->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->processo, $ctrl); // processo
            $this->updateSort($this->responsaveis, $ctrl); // responsaveis
            $this->updateSort($this->objetivo, $ctrl); // objetivo
            $this->updateSort($this->eqpto_recursos, $ctrl); // eqpto_recursos
            $this->updateSort($this->entradas, $ctrl); // entradas
            $this->updateSort($this->atividade_principal, $ctrl); // atividade_principal
            $this->updateSort($this->saidas_resultados, $ctrl); // saidas_resultados
            $this->updateSort($this->requsito_saidas, $ctrl); // requsito_saidas
            $this->updateSort($this->riscos, $ctrl); // riscos
            $this->updateSort($this->oportunidades, $ctrl); // oportunidades
            $this->updateSort($this->propriedade_externa, $ctrl); // propriedade_externa
            $this->updateSort($this->conhecimentos, $ctrl); // conhecimentos
            $this->updateSort($this->documentos_aplicados, $ctrl); // documentos_aplicados
            $this->updateSort($this->tipo_idtipo, $ctrl); // tipo_idtipo
            $this->updateSort($this->proced_int_trabalho, $ctrl); // proced_int_trabalho
            $this->updateSort($this->mapa, $ctrl); // mapa
            $this->updateSort($this->revisao, $ctrl); // revisao
            $this->updateSort($this->proc_antes, $ctrl); // proc_antes
            $this->updateSort($this->proc_depois, $ctrl); // proc_depois
            $sortSql = $this->sortSql();
            $this->setOrderBy($sortSql);
            $this->setStartGroup(1);
        }

        // Set up default sort
        if ($this->getOrderBy() == "") {
            $useDefaultSort = true;
            if ($useDefaultSort) {
                $this->setOrderBy("processo ASC");
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
            $this->processo->AdvancedSearch->unsetSession();
            $restoreDefault = true;
        } else {
            $restoreSession = !$this->SearchCommand;

            // Field processo
            $this->getDropDownValue($this->processo);
            if (!$this->validateForm()) {
                return $filter;
            }
        }

        // Restore session
        if ($restoreSession) {
            $restoreDefault = true;
            if ($this->processo->AdvancedSearch->issetSession()) { // Field processo
                $this->processo->AdvancedSearch->load();
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
        $this->buildDropDownFilter($this->processo, $filter, false, true); // Field processo
        $this->processo->AdvancedSearch->save();

        // Field processo
        LoadDropDownList($this->processo->EditValue, $this->processo->AdvancedSearch->SearchValue);
        return $filter;
    }

    // Build dropdown filter
    protected function buildDropDownFilter(&$fld, &$filterClause, $default = false, $saveFilter = false)
    {
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        if (!EmptyValue($fld->DateFilter)) {
            $fldVal2 = "";
        } elseif ($fld->UseFilter) {
            $fldOpr = "";
            $fldVal2 = "";
        }
        $sql = "";
        if (is_array($fldVal)) {
            foreach ($fldVal as $val) {
                $wrk = DropDownFilter($fld, $val, $fldOpr, $this->Dbid);

                // Call Page Filtering event
                if (StartsString("@@", $val)) {
                    $this->pageFiltering($fld, $wrk, "custom", substr($val, 2));
                } else {
                    $this->pageFiltering($fld, $wrk, "dropdown", $fldOpr, $val);
                }
                AddFilter($sql, $wrk, "OR");
            }
        } else {
            $sql = DropDownFilter($fld, $fldVal, $fldOpr, $this->Dbid, $fldVal2);

            // Call Page Filtering event
            if (StartsString("@@", $fldVal)) {
                $this->pageFiltering($fld, $sql, "custom", substr($fldVal, 2));
            } else {
                $this->pageFiltering($fld, $sql, "dropdown", $fldOpr, $fldVal, "", "", $fldVal2);
            }
        }
        if ($sql != "") {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
            AddFilter($filterClause, $sql, $cond);
            if ($saveFilter) {
                $fld->CurrentFilter = $sql;
            }
        }
    }

    // Build extended filter
    protected function buildExtendedFilter(&$fld, &$filterClause, $default = false, $saveFilter = false)
    {
        $wrk = GetReportFilter($fld, $default, $this->Dbid);
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
        $sep = $fld->UseFilter ? Config("FILTER_OPTION_SEPARATOR") : Config("MULTIPLE_OPTION_SEPARATOR");
        $opr = Get("z_$parm");
        if ($opr !== null) {
            $fld->AdvancedSearch->SearchOperator = $opr;
        }
        $val = Get("x_$parm");
        if ($val !== null) {
            if (is_array($val)) {
                $val = implode($sep, $val);
            }
            $fld->AdvancedSearch->setSearchValue($val);
            $res = true;
        }
        $val2 = Get("y_$parm");
        if ($val2 !== null) {
            if (is_array($val2)) {
                $val2 = implode($sep, $val2);
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
        // Field processo
        $this->processo->AdvancedSearch->loadDefault();
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Field processo
        $extWrk = "";
        $this->buildDropDownFilter($this->processo, $extWrk);
        $filter = "";
        if ($extWrk != "") {
            $filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->processo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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
        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Field processo
        $wrk = "";
        $wrk = $this->processo->AdvancedSearch->SearchValue;
        if (is_array($wrk)) {
            $wrk = implode("||", $wrk);
        }
        if ($wrk != "") {
            $wrk = "\"x_processo\":\"" . JsEncode($wrk) . "\"";
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

        // Field processo
        if (!$this->processo->AdvancedSearch->get($filter)) {
            $this->processo->AdvancedSearch->loadDefault(); // Clear filter
        }
        $this->processo->AdvancedSearch->save();
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
