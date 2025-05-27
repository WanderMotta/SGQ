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
class AnaliseCriticaDirecaoDelete extends AnaliseCriticaDirecao
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "AnaliseCriticaDirecaoDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "AnaliseCriticaDirecaoDelete";

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
        $this->idanalise_critica_direcao->setVisibility();
        $this->data->setVisibility();
        $this->participantes->setVisibility();
        $this->usuario_idusuario->setVisibility();
        $this->situacao_anterior->setVisibility();
        $this->mudanca_sqg->Visible = false;
        $this->desempenho_eficacia->Visible = false;
        $this->satisfacao_cliente->Visible = false;
        $this->objetivos_alcancados->Visible = false;
        $this->desempenho_processo->Visible = false;
        $this->nao_confomidade_acoes_corretivas->Visible = false;
        $this->monitoramento_medicao->Visible = false;
        $this->resultado_auditoria->Visible = false;
        $this->desempenho_provedores_ext->Visible = false;
        $this->suficiencia_recursos->Visible = false;
        $this->acoes_risco_oportunidades->Visible = false;
        $this->oportunidade_melhora_entrada->Visible = false;
        $this->oportunidade_melhora_saida->setVisibility();
        $this->qualquer_mudanca_sgq->Visible = false;
        $this->nec_recurso->Visible = false;
        $this->anexo->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'analise_critica_direcao';
        $this->TableName = 'analise_critica_direcao';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (analise_critica_direcao)
        if (!isset($GLOBALS["analise_critica_direcao"]) || $GLOBALS["analise_critica_direcao"]::class == PROJECT_NAMESPACE . "analise_critica_direcao") {
            $GLOBALS["analise_critica_direcao"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'analise_critica_direcao');
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
            $key .= @$ar['idanalise_critica_direcao'];
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
            $this->idanalise_critica_direcao->Visible = false;
        }
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }
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
        $this->setupLookupOptions($this->participantes);
        $this->setupLookupOptions($this->usuario_idusuario);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("AnaliseCriticaDirecaoList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Param("action") !== null) {
            $this->CurrentAction = Param("action") == "delete" ? "delete" : "show";
        } else {
            $this->CurrentAction = $this->InlineDelete ?
                "delete" : // Delete record directly
                "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsJsonResponse()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsJsonResponse()) {
                    $this->terminate();
                    return;
                }
                // Return JSON error message if UseAjaxActions
                if ($this->UseAjaxActions) {
                    WriteJson(["success" => false, "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                }
                if ($this->InlineDelete) {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                } else {
                    $this->CurrentAction = "show"; // Display record
                }
            }
        }
        if ($this->isShow()) { // Load records for display
            $this->Recordset = $this->loadRecordset();
            if ($this->TotalRecords <= 0) { // No record found, exit
                $this->Recordset?->free();
                $this->terminate("AnaliseCriticaDirecaoList"); // Return to list
                return;
            }
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

    /**
     * Load result set
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return Doctrine\DBAL\Result Result
     */
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        if (property_exists($this, "TotalRecords") && $rowcnt < 0) {
            $this->TotalRecords = $result->rowCount();
            if ($this->TotalRecords <= 0) { // Handle database drivers that does not return rowCount()
                $this->TotalRecords = $this->getRecordCount($this->getListSql());
            }
        }

        // Call Recordset Selected event
        $this->recordsetSelected($result);
        return $result;
    }

    /**
     * Load records as associative array
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return void
     */
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        return $result->fetchAllAssociative();
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
        $this->idanalise_critica_direcao->setDbValue($row['idanalise_critica_direcao']);
        $this->data->setDbValue($row['data']);
        $this->participantes->setDbValue($row['participantes']);
        $this->usuario_idusuario->setDbValue($row['usuario_idusuario']);
        $this->situacao_anterior->setDbValue($row['situacao_anterior']);
        $this->mudanca_sqg->setDbValue($row['mudanca_sqg']);
        $this->desempenho_eficacia->setDbValue($row['desempenho_eficacia']);
        $this->satisfacao_cliente->setDbValue($row['satisfacao_cliente']);
        $this->objetivos_alcancados->setDbValue($row['objetivos_alcançados']);
        $this->desempenho_processo->setDbValue($row['desempenho_processo']);
        $this->nao_confomidade_acoes_corretivas->setDbValue($row['nao_confomidade_acoes_corretivas']);
        $this->monitoramento_medicao->setDbValue($row['monitoramento_medicao']);
        $this->resultado_auditoria->setDbValue($row['resultado_auditoria']);
        $this->desempenho_provedores_ext->setDbValue($row['desempenho_provedores_ext']);
        $this->suficiencia_recursos->setDbValue($row['suficiencia_recursos']);
        $this->acoes_risco_oportunidades->setDbValue($row['acoes_risco_oportunidades']);
        $this->oportunidade_melhora_entrada->setDbValue($row['oportunidade_melhora_entrada']);
        $this->oportunidade_melhora_saida->setDbValue($row['oportunidade_melhora_saida']);
        $this->qualquer_mudanca_sgq->setDbValue($row['qualquer_mudanca_sgq']);
        $this->nec_recurso->setDbValue($row['nec_recurso']);
        $this->anexo->Upload->DbValue = $row['anexo'];
        $this->anexo->setDbValue($this->anexo->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idanalise_critica_direcao'] = $this->idanalise_critica_direcao->DefaultValue;
        $row['data'] = $this->data->DefaultValue;
        $row['participantes'] = $this->participantes->DefaultValue;
        $row['usuario_idusuario'] = $this->usuario_idusuario->DefaultValue;
        $row['situacao_anterior'] = $this->situacao_anterior->DefaultValue;
        $row['mudanca_sqg'] = $this->mudanca_sqg->DefaultValue;
        $row['desempenho_eficacia'] = $this->desempenho_eficacia->DefaultValue;
        $row['satisfacao_cliente'] = $this->satisfacao_cliente->DefaultValue;
        $row['objetivos_alcançados'] = $this->objetivos_alcancados->DefaultValue;
        $row['desempenho_processo'] = $this->desempenho_processo->DefaultValue;
        $row['nao_confomidade_acoes_corretivas'] = $this->nao_confomidade_acoes_corretivas->DefaultValue;
        $row['monitoramento_medicao'] = $this->monitoramento_medicao->DefaultValue;
        $row['resultado_auditoria'] = $this->resultado_auditoria->DefaultValue;
        $row['desempenho_provedores_ext'] = $this->desempenho_provedores_ext->DefaultValue;
        $row['suficiencia_recursos'] = $this->suficiencia_recursos->DefaultValue;
        $row['acoes_risco_oportunidades'] = $this->acoes_risco_oportunidades->DefaultValue;
        $row['oportunidade_melhora_entrada'] = $this->oportunidade_melhora_entrada->DefaultValue;
        $row['oportunidade_melhora_saida'] = $this->oportunidade_melhora_saida->DefaultValue;
        $row['qualquer_mudanca_sgq'] = $this->qualquer_mudanca_sgq->DefaultValue;
        $row['nec_recurso'] = $this->nec_recurso->DefaultValue;
        $row['anexo'] = $this->anexo->DefaultValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // idanalise_critica_direcao

        // data

        // participantes

        // usuario_idusuario

        // situacao_anterior

        // mudanca_sqg

        // desempenho_eficacia

        // satisfacao_cliente

        // objetivos_alcançados

        // desempenho_processo

        // nao_confomidade_acoes_corretivas

        // monitoramento_medicao

        // resultado_auditoria

        // desempenho_provedores_ext

        // suficiencia_recursos

        // acoes_risco_oportunidades

        // oportunidade_melhora_entrada

        // oportunidade_melhora_saida

        // qualquer_mudanca_sgq

        // nec_recurso

        // anexo

        // View row
        if ($this->RowType == RowType::VIEW) {
            // idanalise_critica_direcao
            $this->idanalise_critica_direcao->ViewValue = $this->idanalise_critica_direcao->CurrentValue;
            $this->idanalise_critica_direcao->CssClass = "fw-bold";
            $this->idanalise_critica_direcao->CellCssStyle .= "text-align: center;";

            // data
            $this->data->ViewValue = $this->data->CurrentValue;
            $this->data->ViewValue = FormatDateTime($this->data->ViewValue, $this->data->formatPattern());
            $this->data->CssClass = "fw-bold";

            // participantes
            $curVal = strval($this->participantes->CurrentValue);
            if ($curVal != "") {
                $this->participantes->ViewValue = $this->participantes->lookupCacheOption($curVal);
                if ($this->participantes->ViewValue === null) { // Lookup from database
                    $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        AddFilter($filterWrk, SearchFilter($this->participantes->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", trim($wrk), $this->participantes->Lookup->getTable()->Fields["idusuario"]->searchDataType(), ""), "OR");
                    }
                    $lookupFilter = $this->participantes->getSelectFilter($this); // PHP
                    $sqlWrk = $this->participantes->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->participantes->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->participantes->Lookup->renderViewRow($row);
                            $this->participantes->ViewValue->add($this->participantes->displayValue($arwrk));
                        }
                    } else {
                        $this->participantes->ViewValue = $this->participantes->CurrentValue;
                    }
                }
            } else {
                $this->participantes->ViewValue = null;
            }
            $this->participantes->CssClass = "fw-bold";

            // usuario_idusuario
            $curVal = strval($this->usuario_idusuario->CurrentValue);
            if ($curVal != "") {
                $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->lookupCacheOption($curVal);
                if ($this->usuario_idusuario->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->usuario_idusuario->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->usuario_idusuario->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                    $sqlWrk = $this->usuario_idusuario->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->usuario_idusuario->Lookup->renderViewRow($rswrk[0]);
                        $this->usuario_idusuario->ViewValue = $this->usuario_idusuario->displayValue($arwrk);
                    } else {
                        $this->usuario_idusuario->ViewValue = FormatNumber($this->usuario_idusuario->CurrentValue, $this->usuario_idusuario->formatPattern());
                    }
                }
            } else {
                $this->usuario_idusuario->ViewValue = null;
            }
            $this->usuario_idusuario->CssClass = "fw-bold";

            // situacao_anterior
            $this->situacao_anterior->ViewValue = $this->situacao_anterior->CurrentValue;
            $this->situacao_anterior->CssClass = "fw-bold";

            // mudanca_sqg
            $this->mudanca_sqg->ViewValue = $this->mudanca_sqg->CurrentValue;
            $this->mudanca_sqg->CssClass = "fw-bold";

            // desempenho_eficacia
            $this->desempenho_eficacia->ViewValue = $this->desempenho_eficacia->CurrentValue;
            $this->desempenho_eficacia->CssClass = "fw-bold";

            // satisfacao_cliente
            $this->satisfacao_cliente->ViewValue = $this->satisfacao_cliente->CurrentValue;
            $this->satisfacao_cliente->CssClass = "fw-bold";

            // objetivos_alcançados
            $this->objetivos_alcancados->ViewValue = $this->objetivos_alcancados->CurrentValue;
            $this->objetivos_alcancados->CssClass = "fw-bold";

            // desempenho_processo
            $this->desempenho_processo->ViewValue = $this->desempenho_processo->CurrentValue;
            $this->desempenho_processo->CssClass = "fw-bold";

            // nao_confomidade_acoes_corretivas
            $this->nao_confomidade_acoes_corretivas->ViewValue = $this->nao_confomidade_acoes_corretivas->CurrentValue;
            $this->nao_confomidade_acoes_corretivas->CssClass = "fw-bold";

            // monitoramento_medicao
            $this->monitoramento_medicao->ViewValue = $this->monitoramento_medicao->CurrentValue;
            $this->monitoramento_medicao->CssClass = "fw-bold";

            // resultado_auditoria
            $this->resultado_auditoria->ViewValue = $this->resultado_auditoria->CurrentValue;
            $this->resultado_auditoria->CssClass = "fw-bold";

            // desempenho_provedores_ext
            $this->desempenho_provedores_ext->ViewValue = $this->desempenho_provedores_ext->CurrentValue;
            $this->desempenho_provedores_ext->CssClass = "fw-bold";

            // suficiencia_recursos
            $this->suficiencia_recursos->ViewValue = $this->suficiencia_recursos->CurrentValue;
            $this->suficiencia_recursos->CssClass = "fw-bold";

            // acoes_risco_oportunidades
            $this->acoes_risco_oportunidades->ViewValue = $this->acoes_risco_oportunidades->CurrentValue;
            $this->acoes_risco_oportunidades->CssClass = "fw-bold";

            // oportunidade_melhora_entrada
            $this->oportunidade_melhora_entrada->ViewValue = $this->oportunidade_melhora_entrada->CurrentValue;
            $this->oportunidade_melhora_entrada->CssClass = "fw-bold";

            // oportunidade_melhora_saida
            $this->oportunidade_melhora_saida->ViewValue = $this->oportunidade_melhora_saida->CurrentValue;
            $this->oportunidade_melhora_saida->CssClass = "fw-bold";

            // qualquer_mudanca_sgq
            $this->qualquer_mudanca_sgq->ViewValue = $this->qualquer_mudanca_sgq->CurrentValue;
            $this->qualquer_mudanca_sgq->CssClass = "fw-bold";

            // nec_recurso
            $this->nec_recurso->ViewValue = $this->nec_recurso->CurrentValue;
            $this->nec_recurso->CssClass = "fw-bold";

            // idanalise_critica_direcao
            $this->idanalise_critica_direcao->HrefValue = "";
            $this->idanalise_critica_direcao->TooltipValue = "";

            // data
            $this->data->HrefValue = "";
            $this->data->TooltipValue = "";

            // participantes
            $this->participantes->HrefValue = "";
            $this->participantes->TooltipValue = "";

            // usuario_idusuario
            $this->usuario_idusuario->HrefValue = "";
            $this->usuario_idusuario->TooltipValue = "";

            // situacao_anterior
            $this->situacao_anterior->HrefValue = "";
            $this->situacao_anterior->TooltipValue = "";

            // oportunidade_melhora_saida
            $this->oportunidade_melhora_saida->HrefValue = "";
            $this->oportunidade_melhora_saida->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['idanalise_critica_direcao'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
                if (!$deleteRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                if ($conn->isTransactionActive()) {
                    $conn->commit();
                }
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(str_replace("%k", explode(", ", $failKeys), $Language->phrase("DeleteRecordsFailed")));
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                if ($conn->isTransactionActive()) {
                    $conn->rollback();
                }
            }
        }

        // Write JSON response
        if ((IsJsonResponse() || ConvertToBool(Param("infinitescroll"))) && $deleteRows) {
            $rows = $this->getRecordsFromRecordset($rsold);
            $table = $this->TableVar;
            if (Param("key_m") === null) { // Single delete
                $rows = $rows[0]; // Return object
            }
            WriteJson(["success" => true, "action" => Config("API_DELETE_ACTION"), $table => $rows]);
        }
        return $deleteRows;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("AnaliseCriticaDirecaoList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
                case "x_participantes":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_usuario_idusuario":
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
}
