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
class RevisaoDocumentoDelete extends RevisaoDocumento
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "RevisaoDocumentoDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "RevisaoDocumentoDelete";

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
        $this->idrevisao_documento->Visible = false;
        $this->documento_interno_iddocumento_interno->Visible = false;
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
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

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
        $this->setupLookupOptions($this->documento_interno_iddocumento_interno);
        $this->setupLookupOptions($this->status_documento_idstatus_documento);
        $this->setupLookupOptions($this->usuario_elaborador);
        $this->setupLookupOptions($this->usuario_aprovador);

        // Set up master/detail parameters
        $this->setupMasterParms();

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("RevisaoDocumentoList"); // Prevent SQL injection, return to list
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
                $this->terminate("RevisaoDocumentoList"); // Return to list
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
        $this->idrevisao_documento->setDbValue($row['idrevisao_documento']);
        $this->documento_interno_iddocumento_interno->setDbValue($row['documento_interno_iddocumento_interno']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->qual_alteracao->setDbValue($row['qual_alteracao']);
        $this->status_documento_idstatus_documento->setDbValue($row['status_documento_idstatus_documento']);
        $this->revisao_nr->setDbValue($row['revisao_nr']);
        $this->usuario_elaborador->setDbValue($row['usuario_elaborador']);
        $this->usuario_aprovador->setDbValue($row['usuario_aprovador']);
        $this->dt_aprovacao->setDbValue($row['dt_aprovacao']);
        $this->anexo->Upload->DbValue = $row['anexo'];
        $this->anexo->setDbValue($this->anexo->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['idrevisao_documento'] = $this->idrevisao_documento->DefaultValue;
        $row['documento_interno_iddocumento_interno'] = $this->documento_interno_iddocumento_interno->DefaultValue;
        $row['dt_cadastro'] = $this->dt_cadastro->DefaultValue;
        $row['qual_alteracao'] = $this->qual_alteracao->DefaultValue;
        $row['status_documento_idstatus_documento'] = $this->status_documento_idstatus_documento->DefaultValue;
        $row['revisao_nr'] = $this->revisao_nr->DefaultValue;
        $row['usuario_elaborador'] = $this->usuario_elaborador->DefaultValue;
        $row['usuario_aprovador'] = $this->usuario_aprovador->DefaultValue;
        $row['dt_aprovacao'] = $this->dt_aprovacao->DefaultValue;
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

        // idrevisao_documento

        // documento_interno_iddocumento_interno

        // dt_cadastro

        // qual_alteracao

        // status_documento_idstatus_documento

        // revisao_nr

        // usuario_elaborador

        // usuario_aprovador

        // dt_aprovacao

        // anexo

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
            $thisKey .= $row['idrevisao_documento'];

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

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        $foreignKeys = [];
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "documento_interno") {
                $validMaster = true;
                $masterTbl = Container("documento_interno");
                if (($parm = Get("fk_iddocumento_interno", Get("documento_interno_iddocumento_interno"))) !== null) {
                    $masterTbl->iddocumento_interno->setQueryStringValue($parm);
                    $this->documento_interno_iddocumento_interno->QueryStringValue = $masterTbl->iddocumento_interno->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->documento_interno_iddocumento_interno->setSessionValue($this->documento_interno_iddocumento_interno->QueryStringValue);
                    $foreignKeys["documento_interno_iddocumento_interno"] = $this->documento_interno_iddocumento_interno->QueryStringValue;
                    if (!is_numeric($masterTbl->iddocumento_interno->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "documento_interno") {
                $validMaster = true;
                $masterTbl = Container("documento_interno");
                if (($parm = Post("fk_iddocumento_interno", Post("documento_interno_iddocumento_interno"))) !== null) {
                    $masterTbl->iddocumento_interno->setFormValue($parm);
                    $this->documento_interno_iddocumento_interno->FormValue = $masterTbl->iddocumento_interno->FormValue;
                    $this->documento_interno_iddocumento_interno->setSessionValue($this->documento_interno_iddocumento_interno->FormValue);
                    $foreignKeys["documento_interno_iddocumento_interno"] = $this->documento_interno_iddocumento_interno->FormValue;
                    if (!is_numeric($masterTbl->iddocumento_interno->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);
            $this->setSessionWhere($this->getDetailFilterFromSession());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "documento_interno") {
                if (!array_key_exists("documento_interno_iddocumento_interno", $foreignKeys)) { // Not current foreign key
                    $this->documento_interno_iddocumento_interno->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("RevisaoDocumentoList"), "", $this->TableVar, true);
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
}
