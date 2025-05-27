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
 * Table class for graficos
 */
class Graficos extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $DbErrorMessage = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Ajax / Modal
    public $UseAjaxActions = false;
    public $ModalSearch = false;
    public $ModalView = false;
    public $ModalAdd = false;
    public $ModalEdit = false;
    public $ModalUpdate = false;
    public $InlineDelete = false;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;
    public $EvidenciasxMes;

    // Fields
    public $idgraficos;
    public $competencia_idcompetencia;
    public $indicadores_idindicadores;
    public $data_base;
    public $valor;
    public $obs;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "graficos";
        $this->TableName = 'graficos';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "graficos";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)

        // PDF
        $this->ExportPageOrientation = "landscape"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = "A4"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // idgraficos
        $this->idgraficos = new DbField(
            $this, // Table
            'x_idgraficos', // Variable name
            'idgraficos', // Name
            '`idgraficos`', // Expression
            '`idgraficos`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idgraficos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idgraficos->InputTextType = "text";
        $this->idgraficos->Raw = true;
        $this->idgraficos->IsAutoIncrement = true; // Autoincrement field
        $this->idgraficos->IsPrimaryKey = true; // Primary key field
        $this->idgraficos->Nullable = false; // NOT NULL field
        $this->idgraficos->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idgraficos->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idgraficos'] = &$this->idgraficos;

        // competencia_idcompetencia
        $this->competencia_idcompetencia = new DbField(
            $this, // Table
            'x_competencia_idcompetencia', // Variable name
            'competencia_idcompetencia', // Name
            '`competencia_idcompetencia`', // Expression
            '`competencia_idcompetencia`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`competencia_idcompetencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->competencia_idcompetencia->InputTextType = "text";
        $this->competencia_idcompetencia->Raw = true;
        $this->competencia_idcompetencia->Nullable = false; // NOT NULL field
        $this->competencia_idcompetencia->Required = true; // Required field
        $this->competencia_idcompetencia->setSelectMultiple(false); // Select one
        $this->competencia_idcompetencia->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->competencia_idcompetencia->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->competencia_idcompetencia->Lookup = new Lookup($this->competencia_idcompetencia, 'competencia', false, 'idcompetencia', ["mes","ano","",""], '', '', [], [], [], [], [], [], false, '`idcompetencia` ASC', '', "CONCAT(COALESCE(`mes`, ''),'" . ValueSeparator(1, $this->competencia_idcompetencia) . "',COALESCE(`ano`,''))");
        $this->competencia_idcompetencia->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->competencia_idcompetencia->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['competencia_idcompetencia'] = &$this->competencia_idcompetencia;

        // indicadores_idindicadores
        $this->indicadores_idindicadores = new DbField(
            $this, // Table
            'x_indicadores_idindicadores', // Variable name
            'indicadores_idindicadores', // Name
            '`indicadores_idindicadores`', // Expression
            '`indicadores_idindicadores`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`indicadores_idindicadores`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->indicadores_idindicadores->InputTextType = "text";
        $this->indicadores_idindicadores->Raw = true;
        $this->indicadores_idindicadores->IsForeignKey = true; // Foreign key field
        $this->indicadores_idindicadores->Nullable = false; // NOT NULL field
        $this->indicadores_idindicadores->Required = true; // Required field
        $this->indicadores_idindicadores->setSelectMultiple(false); // Select one
        $this->indicadores_idindicadores->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->indicadores_idindicadores->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->indicadores_idindicadores->Lookup = new Lookup($this->indicadores_idindicadores, 'indicadores', false, 'idindicadores', ["indicador","","",""], '', '', [], [], [], [], [], [], false, '`indicador` ASC', '', "`indicador`");
        $this->indicadores_idindicadores->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->indicadores_idindicadores->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['indicadores_idindicadores'] = &$this->indicadores_idindicadores;

        // data_base
        $this->data_base = new DbField(
            $this, // Table
            'x_data_base', // Variable name
            'data_base', // Name
            '`data_base`', // Expression
            CastDateFieldForLike("`data_base`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`data_base`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->data_base->InputTextType = "text";
        $this->data_base->Raw = true;
        $this->data_base->Nullable = false; // NOT NULL field
        $this->data_base->Required = true; // Required field
        $this->data_base->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->data_base->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['data_base'] = &$this->data_base;

        // valor
        $this->valor = new DbField(
            $this, // Table
            'x_valor', // Variable name
            'valor', // Name
            '`valor`', // Expression
            '`valor`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`valor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->valor->addMethod("getDefault", fn() => 0.00);
        $this->valor->InputTextType = "text";
        $this->valor->Raw = true;
        $this->valor->Nullable = false; // NOT NULL field
        $this->valor->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->valor->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['valor'] = &$this->valor;

        // obs
        $this->obs = new DbField(
            $this, // Table
            'x_obs', // Variable name
            'obs', // Name
            '`obs`', // Expression
            '`obs`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`obs`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->obs->InputTextType = "text";
        $this->obs->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['obs'] = &$this->obs;

        // Evidencias x Mes
        $this->EvidenciasxMes = new DbChart($this, 'EvidenciasxMes', 'Evidencias x Mes', 'competencia_idcompetencia', 'valor', 1001, '', 0, 'SUM', 600, 500);
        $this->EvidenciasxMes->Position = 4;
        $this->EvidenciasxMes->PageBreakType = "before";
        $this->EvidenciasxMes->YAxisFormat = ["Number"];
        $this->EvidenciasxMes->YFieldFormat = ["Number"];
        $this->EvidenciasxMes->SortType = 1;
        $this->EvidenciasxMes->SortSequence = "";
        $this->EvidenciasxMes->SqlSelect = $this->getQueryBuilder()->select("`competencia_idcompetencia`", "''", "SUM(`valor`)");
        $this->EvidenciasxMes->SqlGroupBy = "`competencia_idcompetencia`";
        $this->EvidenciasxMes->SqlOrderBy = "`competencia_idcompetencia` ASC";
        $this->EvidenciasxMes->SeriesDateType = "";
        $this->EvidenciasxMes->ID = "graficos_EvidenciasxMes"; // Chart ID
        $this->EvidenciasxMes->setParameters([
            ["type", "1001"],
            ["seriestype", "0"]
        ]); // Chart type / Chart series type
        $this->EvidenciasxMes->setParameters([
            ["caption", $this->EvidenciasxMes->caption()],
            ["xaxisname", $this->EvidenciasxMes->xAxisName()]
        ]); // Chart caption / X axis name
        $this->EvidenciasxMes->setParameter("yaxisname", $this->EvidenciasxMes->yAxisName()); // Y axis name
        $this->EvidenciasxMes->setParameters([
            ["shownames", "1"],
            ["showvalues", "1"],
            ["showhovercap", "1"]
        ]); // Show names / Show values / Show hover
        $this->EvidenciasxMes->setParameter("alpha", 50); // Chart alpha (datasets background color)
        $this->EvidenciasxMes->setParameters([["options.plugins.legend.display",false],["options.plugins.legend.fullWidth",false],["options.plugins.legend.reverse",false],["options.plugins.legend.rtl",false],["options.plugins.legend.labels.usePointStyle",false],["options.plugins.title.display",false],["options.plugins.tooltip.enabled",true],["options.plugins.tooltip.intersect",true],["options.plugins.tooltip.displayColors",false],["options.plugins.tooltip.rtl",false],["options.plugins.filler.propagate",false],["options.animation.animateRotate",false],["options.animation.animateScale",false],["dataset.showLine",false],["dataset.spanGaps",false],["dataset.steppedLine",false],["scale.offset",false],["scale.gridLines.offsetGridLines",false],["options.plugins.datalabels.clamp",false],["options.plugins.datalabels.clip",false],["options.plugins.datalabels.display",false],["annotation1.show",false],["annotation1.secondaryYAxis",false],["annotation2.show",false],["annotation2.secondaryYAxis",false],["annotation3.show",false],["annotation3.secondaryYAxis",false],["annotation4.show",false],["annotation4.secondaryYAxis",false],["options.scales.r.angleLines.display",false],["options.plugins.stacked100.enable",false],["dataset.circular",false]]);
        $this->Charts[$this->EvidenciasxMes->ID] = &$this->EvidenciasxMes;

        // Add Doctrine Cache
        $this->Cache = new \Symfony\Component\Cache\Adapter\ArrayAdapter();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);

        // Call Table Load event
        $this->tableLoad();
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Multiple column sort
    public function updateSort(&$fld, $ctrl)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($ctrl) {
                $orderBy = $this->getSessionOrderBy();
                $arOrderBy = !empty($orderBy) ? explode(", ", $orderBy) : [];
                if ($lastOrderBy != "" && in_array($lastOrderBy, $arOrderBy)) {
                    foreach ($arOrderBy as $key => $val) {
                        if ($val == $lastOrderBy) {
                            if ($curOrderBy == "") {
                                unset($arOrderBy[$key]);
                            } else {
                                $arOrderBy[$key] = $curOrderBy;
                            }
                        }
                    }
                } elseif ($curOrderBy != "") {
                    $arOrderBy[] = $curOrderBy;
                }
                $orderBy = implode(", ", $arOrderBy);
                $this->setSessionOrderBy($orderBy); // Save to Session
            } else {
                $this->setSessionOrderBy($curOrderBy); // Save to Session
            }
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        $flds = GetSortFields($orderBy);
        foreach ($this->Fields as $field) {
            $fldSort = "";
            foreach ($flds as $fld) {
                if ($fld[0] == $field->Expression || $fld[0] == $field->VirtualExpression) {
                    $fldSort = $fld[1];
                }
            }
            $field->setSort($fldSort);
        }
    }

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Get master WHERE clause from session values
    public function getMasterFilterFromSession()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "indicadores") {
            $masterTable = Container("indicadores");
            if ($this->indicadores_idindicadores->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->idindicadores, $this->indicadores_idindicadores->getSessionValue(), $masterTable->idindicadores->DataType, $masterTable->Dbid);
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Get detail WHERE clause from session values
    public function getDetailFilterFromSession()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "indicadores") {
            $masterTable = Container("indicadores");
            if ($this->indicadores_idindicadores->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->indicadores_idindicadores, $this->indicadores_idindicadores->getSessionValue(), $masterTable->idindicadores->DataType, $this->Dbid);
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    /**
     * Get master filter
     *
     * @param object $masterTable Master Table
     * @param array $keys Detail Keys
     * @return mixed NULL is returned if all keys are empty, Empty string is returned if some keys are empty and is required
     */
    public function getMasterFilter($masterTable, $keys)
    {
        $validKeys = true;
        switch ($masterTable->TableVar) {
            case "indicadores":
                $key = $keys["indicadores_idindicadores"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->idindicadores->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->idindicadores, $keys["indicadores_idindicadores"], $this->indicadores_idindicadores->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "indicadores":
                return GetKeyFilter($this->indicadores_idindicadores, $masterTable->idindicadores->DbValue, $masterTable->idindicadores->DataType, $masterTable->Dbid);
        }
        return "";
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        if ($chartVar == "EvidenciasxMes") {
            $this->competencia_idcompetencia->CurrentValue = $chartRow[0];
            $curVal = strval($this->competencia_idcompetencia->CurrentValue);
            if ($curVal != "") {
                $this->competencia_idcompetencia->ViewValue = $this->competencia_idcompetencia->lookupCacheOption($curVal);
                if ($this->competencia_idcompetencia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->competencia_idcompetencia->Lookup->getTable()->Fields["idcompetencia"]->searchExpression(), "=", $curVal, $this->competencia_idcompetencia->Lookup->getTable()->Fields["idcompetencia"]->searchDataType(), "");
                    $sqlWrk = $this->competencia_idcompetencia->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->competencia_idcompetencia->Lookup->renderViewRow($rswrk[0]);
                        $this->competencia_idcompetencia->ViewValue = $this->competencia_idcompetencia->displayValue($arwrk);
                    } else {
                        $this->competencia_idcompetencia->ViewValue = FormatNumber($this->competencia_idcompetencia->CurrentValue, $this->competencia_idcompetencia->formatPattern());
                    }
                }
            } else {
                $this->competencia_idcompetencia->ViewValue = null;
            }
            $this->competencia_idcompetencia->CssClass = "fw-bold";
            $chartRow[0] = is_object($this->competencia_idcompetencia->ViewValue) ? $this->competencia_idcompetencia->ViewValue->__toString() : $this->competencia_idcompetencia->ViewValue;
        }
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "graficos";
    }

    // Get FROM clause (for backward compatibility)
    public function sqlFrom()
    {
        return $this->getSqlFrom();
    }

    // Set FROM clause
    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    // Get SELECT clause
    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select($this->sqlSelectFields());
    }

    // Get list of fields
    private function sqlSelectFields()
    {
        $useFieldNames = false;
        $fieldNames = [];
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($this->Fields as $field) {
            $expr = $field->Expression;
            $customExpr = $field->CustomDataType?->convertToPHPValueSQL($expr, $platform) ?? $expr;
            if ($customExpr != $expr) {
                $fieldNames[] = $customExpr . " AS " . QuotedName($field->Name, $this->Dbid);
                $useFieldNames = true;
            } else {
                $fieldNames[] = $expr;
            }
        }
        return $useFieldNames ? implode(", ", $fieldNames) : "*";
    }

    // Get SELECT clause (for backward compatibility)
    public function sqlSelect()
    {
        return $this->getSqlSelect();
    }

    // Set SELECT clause
    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    // Get WHERE clause
    public function getSqlWhere()
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    // Get WHERE clause (for backward compatibility)
    public function sqlWhere()
    {
        return $this->getSqlWhere();
    }

    // Set WHERE clause
    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    // Get GROUP BY clause
    public function getSqlGroupBy()
    {
        return $this->SqlGroupBy != "" ? $this->SqlGroupBy : "";
    }

    // Get GROUP BY clause (for backward compatibility)
    public function sqlGroupBy()
    {
        return $this->getSqlGroupBy();
    }

    // set GROUP BY clause
    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    // Get HAVING clause
    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    // Get HAVING clause (for backward compatibility)
    public function sqlHaving()
    {
        return $this->getSqlHaving();
    }

    // Set HAVING clause
    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    // Get ORDER BY clause
    public function getSqlOrderBy()
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    // Get ORDER BY clause (for backward compatibility)
    public function sqlOrderBy()
    {
        return $this->getSqlOrderBy();
    }

    // set ORDER BY clause
    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter, $id = "")
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return ($allow & Allow::ADD->value) == Allow::ADD->value;
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return ($allow & Allow::EDIT->value) == Allow::EDIT->value;
            case "delete":
                return ($allow & Allow::DELETE->value) == Allow::DELETE->value;
            case "view":
                return ($allow & Allow::VIEW->value) == Allow::VIEW->value;
            case "search":
                return ($allow & Allow::SEARCH->value) == Allow::SEARCH->value;
            case "lookup":
                return ($allow & Allow::LOOKUP->value) == Allow::LOOKUP->value;
            default:
                return ($allow & Allow::LIST->value) == Allow::LIST->value;
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $sqlwrk = $sql instanceof QueryBuilder // Query builder
            ? (clone $sql)->resetQueryPart("orderBy")->getSQL()
            : $sql;
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            in_array($this->TableType, ["TABLE", "VIEW", "LINKTABLE"]) &&
            preg_match($pattern, $sqlwrk) &&
            !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*SELECT\s+DISTINCT\s+/i', $sqlwrk) &&
            !preg_match('/\s+ORDER\s+BY\s+/i', $sqlwrk)
        ) {
            $sqlcnt = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlcnt = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlcnt);
        if ($cnt !== false) {
            return (int)$cnt;
        }
        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        $result = $conn->executeQuery($sqlwrk);
        $cnt = $result->rowCount();
        if ($cnt == 0) { // Unable to get record count, count directly
            while ($result->fetch()) {
                $cnt++;
            }
        }
        return $cnt;
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->getSqlAsQueryBuilder($where, $orderBy)->getSQL();
    }

    // Get QueryBuilder
    public function getSqlAsQueryBuilder($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        );
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->setValue($field->Expression, $parm);
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        try {
            $queryBuilder = $this->insertSql($rs);
            $result = $queryBuilder->executeStatement();
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $result = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        if ($result) {
            $this->idgraficos->setDbValue($conn->lastInsertId());
            $rs['idgraficos'] = $this->idgraficos->DbValue;
        }
        return $result;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->set($field->Expression, $parm);
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        try {
            $success = $this->updateSql($rs, $where, $curfilter)->executeStatement();
            $success = $success > 0 ? $success : true;
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }

        // Return auto increment field
        if ($success) {
            if (!isset($rs['idgraficos']) && !EmptyValue($this->idgraficos->CurrentValue)) {
                $rs['idgraficos'] = $this->idgraficos->CurrentValue;
            }
        }
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('idgraficos', $rs)) {
                AddFilter($where, QuotedName('idgraficos', $this->Dbid) . '=' . QuotedValue($rs['idgraficos'], $this->idgraficos->DataType, $this->Dbid));
            }
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            try {
                $success = $this->deleteSql($rs, $where, $curfilter)->executeStatement();
                $this->DbErrorMessage = "";
            } catch (\Exception $e) {
                $success = false;
                $this->DbErrorMessage = $e->getMessage();
            }
        }
        return $success;
    }

    // Load DbValue from result set or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->idgraficos->DbValue = $row['idgraficos'];
        $this->competencia_idcompetencia->DbValue = $row['competencia_idcompetencia'];
        $this->indicadores_idindicadores->DbValue = $row['indicadores_idindicadores'];
        $this->data_base->DbValue = $row['data_base'];
        $this->valor->DbValue = $row['valor'];
        $this->obs->DbValue = $row['obs'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idgraficos` = @idgraficos@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idgraficos->CurrentValue : $this->idgraficos->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        return implode($keySeparator, $keys);
    }

    // Set Key
    public function setKey($key, $current = false, $keySeparator = null)
    {
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        $this->OldKey = strval($key);
        $keys = explode($keySeparator, $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->idgraficos->CurrentValue = $keys[0];
            } else {
                $this->idgraficos->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idgraficos', $row) ? $row['idgraficos'] : null;
        } else {
            $val = !EmptyValue($this->idgraficos->OldValue) && !$current ? $this->idgraficos->OldValue : $this->idgraficos->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idgraficos@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("GraficosList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        return match ($pageName) {
            "GraficosView" => $Language->phrase("View"),
            "GraficosEdit" => $Language->phrase("Edit"),
            "GraficosAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "GraficosList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "GraficosView",
            Config("API_ADD_ACTION") => "GraficosAdd",
            Config("API_EDIT_ACTION") => "GraficosEdit",
            Config("API_DELETE_ACTION") => "GraficosDelete",
            Config("API_LIST_ACTION") => "GraficosList",
            default => ""
        };
    }

    // Current URL
    public function getCurrentUrl($parm = "")
    {
        $url = CurrentPageUrl(false);
        if ($parm != "") {
            $url = $this->keyUrl($url, $parm);
        } else {
            $url = $this->keyUrl($url, Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // List URL
    public function getListUrl()
    {
        return "GraficosList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("GraficosView", $parm);
        } else {
            $url = $this->keyUrl("GraficosView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "GraficosAdd?" . $parm;
        } else {
            $url = "GraficosAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("GraficosEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("GraficosList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("GraficosAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("GraficosList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("GraficosDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "indicadores" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_idindicadores", $this->indicadores_idindicadores->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"idgraficos\":" . VarToJson($this->idgraficos->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idgraficos->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idgraficos->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($this->PageID != "grid" && $fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-ew-action="sort" data-ajax="' . ($this->UseAjaxActions ? "true" : "false") . '" data-sort-url="' . $sortUrl . '" data-sort-type="2"';
            if ($this->ContextClass) { // Add context
                $attrs .= ' data-context="' . HtmlEncode($this->ContextClass) . '"';
            }
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($this->PageID != "grid" && !$this->isExport() && $fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") .
                (is_array($fld->EditValue) ? str_replace("%c", count($fld->EditValue), $Language->phrase("FilterCount")) : '') .
                '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport;
            }
            return $this->addMasterUrl($this->CurrentPageName . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            $isApi = IsApi();
            $keyValues = $isApi
                ? (Route(0) == "export"
                    ? array_map(fn ($i) => Route($i + 3), range(0, 0))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, 0))) // Other API
                : []; // Non-API
            if (($keyValue = Param("idgraficos") ?? Route("idgraficos")) !== null) {
                $arKeys[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(0) ?? $keyValues[0] ?? null) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from records
    public function getFilterFromRecords($rows)
    {
        $keyFilter = "";
        foreach ($rows as $row) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            $keyFilter .= "(" . $this->getRecordFilter($row) . ")";
        }
        return $keyFilter;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->idgraficos->CurrentValue = $key;
            } else {
                $this->idgraficos->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load result set based on filter/sort
    public function loadRs($filter, $sort = "")
    {
        $sql = $this->getSql($filter, $sort); // Set up filter (WHERE Clause) / sort (ORDER BY Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->idgraficos->setDbValue($row['idgraficos']);
        $this->competencia_idcompetencia->setDbValue($row['competencia_idcompetencia']);
        $this->indicadores_idindicadores->setDbValue($row['indicadores_idindicadores']);
        $this->data_base->setDbValue($row['data_base']);
        $this->valor->setDbValue($row['valor']);
        $this->obs->setDbValue($row['obs']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "GraficosList";
        $listClass = PROJECT_NAMESPACE . $listPage;
        $page = new $listClass();
        $page->loadRecordsetFromFilter($filter);
        $view = Container("app.view");
        $template = $listPage . ".php"; // View
        $GLOBALS["Title"] ??= $page->Title; // Title
        try {
            $Response = $view->render($Response, $template, $GLOBALS);
        } finally {
            $page->terminate(); // Terminate page and clean up
        }
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // idgraficos

        // competencia_idcompetencia

        // indicadores_idindicadores

        // data_base

        // valor

        // obs

        // idgraficos
        $this->idgraficos->ViewValue = $this->idgraficos->CurrentValue;

        // competencia_idcompetencia
        $curVal = strval($this->competencia_idcompetencia->CurrentValue);
        if ($curVal != "") {
            $this->competencia_idcompetencia->ViewValue = $this->competencia_idcompetencia->lookupCacheOption($curVal);
            if ($this->competencia_idcompetencia->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->competencia_idcompetencia->Lookup->getTable()->Fields["idcompetencia"]->searchExpression(), "=", $curVal, $this->competencia_idcompetencia->Lookup->getTable()->Fields["idcompetencia"]->searchDataType(), "");
                $sqlWrk = $this->competencia_idcompetencia->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->competencia_idcompetencia->Lookup->renderViewRow($rswrk[0]);
                    $this->competencia_idcompetencia->ViewValue = $this->competencia_idcompetencia->displayValue($arwrk);
                } else {
                    $this->competencia_idcompetencia->ViewValue = FormatNumber($this->competencia_idcompetencia->CurrentValue, $this->competencia_idcompetencia->formatPattern());
                }
            }
        } else {
            $this->competencia_idcompetencia->ViewValue = null;
        }
        $this->competencia_idcompetencia->CssClass = "fw-bold";

        // indicadores_idindicadores
        $curVal = strval($this->indicadores_idindicadores->CurrentValue);
        if ($curVal != "") {
            $this->indicadores_idindicadores->ViewValue = $this->indicadores_idindicadores->lookupCacheOption($curVal);
            if ($this->indicadores_idindicadores->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->indicadores_idindicadores->Lookup->getTable()->Fields["idindicadores"]->searchExpression(), "=", $curVal, $this->indicadores_idindicadores->Lookup->getTable()->Fields["idindicadores"]->searchDataType(), "");
                $sqlWrk = $this->indicadores_idindicadores->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->indicadores_idindicadores->Lookup->renderViewRow($rswrk[0]);
                    $this->indicadores_idindicadores->ViewValue = $this->indicadores_idindicadores->displayValue($arwrk);
                } else {
                    $this->indicadores_idindicadores->ViewValue = FormatNumber($this->indicadores_idindicadores->CurrentValue, $this->indicadores_idindicadores->formatPattern());
                }
            }
        } else {
            $this->indicadores_idindicadores->ViewValue = null;
        }
        $this->indicadores_idindicadores->CssClass = "fw-bold";
        $this->indicadores_idindicadores->CellCssStyle .= "text-align: center;";

        // data_base
        $this->data_base->ViewValue = $this->data_base->CurrentValue;
        $this->data_base->ViewValue = FormatDateTime($this->data_base->ViewValue, $this->data_base->formatPattern());
        $this->data_base->CssClass = "fw-bold";

        // valor
        $this->valor->ViewValue = $this->valor->CurrentValue;
        $this->valor->ViewValue = FormatNumber($this->valor->ViewValue, $this->valor->formatPattern());
        $this->valor->CssClass = "fw-bold";
        $this->valor->CellCssStyle .= "text-align: right;";

        // obs
        $this->obs->ViewValue = $this->obs->CurrentValue;
        $this->obs->CssClass = "fw-bold";

        // idgraficos
        $this->idgraficos->HrefValue = "";
        $this->idgraficos->TooltipValue = "";

        // competencia_idcompetencia
        $this->competencia_idcompetencia->HrefValue = "";
        $this->competencia_idcompetencia->TooltipValue = "";

        // indicadores_idindicadores
        $this->indicadores_idindicadores->HrefValue = "";
        $this->indicadores_idindicadores->TooltipValue = "";

        // data_base
        $this->data_base->HrefValue = "";
        $this->data_base->TooltipValue = "";

        // valor
        $this->valor->HrefValue = "";
        $this->valor->TooltipValue = "";

        // obs
        $this->obs->HrefValue = "";
        $this->obs->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // idgraficos
        $this->idgraficos->setupEditAttributes();
        $this->idgraficos->EditValue = $this->idgraficos->CurrentValue;

        // competencia_idcompetencia
        $this->competencia_idcompetencia->setupEditAttributes();
        $this->competencia_idcompetencia->PlaceHolder = RemoveHtml($this->competencia_idcompetencia->caption());

        // indicadores_idindicadores
        $this->indicadores_idindicadores->setupEditAttributes();
        if ($this->indicadores_idindicadores->getSessionValue() != "") {
            $this->indicadores_idindicadores->CurrentValue = GetForeignKeyValue($this->indicadores_idindicadores->getSessionValue());
            $curVal = strval($this->indicadores_idindicadores->CurrentValue);
            if ($curVal != "") {
                $this->indicadores_idindicadores->ViewValue = $this->indicadores_idindicadores->lookupCacheOption($curVal);
                if ($this->indicadores_idindicadores->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->indicadores_idindicadores->Lookup->getTable()->Fields["idindicadores"]->searchExpression(), "=", $curVal, $this->indicadores_idindicadores->Lookup->getTable()->Fields["idindicadores"]->searchDataType(), "");
                    $sqlWrk = $this->indicadores_idindicadores->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->indicadores_idindicadores->Lookup->renderViewRow($rswrk[0]);
                        $this->indicadores_idindicadores->ViewValue = $this->indicadores_idindicadores->displayValue($arwrk);
                    } else {
                        $this->indicadores_idindicadores->ViewValue = FormatNumber($this->indicadores_idindicadores->CurrentValue, $this->indicadores_idindicadores->formatPattern());
                    }
                }
            } else {
                $this->indicadores_idindicadores->ViewValue = null;
            }
            $this->indicadores_idindicadores->CssClass = "fw-bold";
            $this->indicadores_idindicadores->CellCssStyle .= "text-align: center;";
        } else {
            $this->indicadores_idindicadores->PlaceHolder = RemoveHtml($this->indicadores_idindicadores->caption());
        }

        // data_base
        $this->data_base->setupEditAttributes();
        $this->data_base->EditValue = $this->data_base->CurrentValue;
        $this->data_base->EditValue = FormatDateTime($this->data_base->EditValue, $this->data_base->formatPattern());
        $this->data_base->CssClass = "fw-bold";

        // valor
        $this->valor->setupEditAttributes();
        $this->valor->EditValue = $this->valor->CurrentValue;
        $this->valor->PlaceHolder = RemoveHtml($this->valor->caption());
        if (strval($this->valor->EditValue) != "" && is_numeric($this->valor->EditValue)) {
            $this->valor->EditValue = FormatNumber($this->valor->EditValue, null);
        }

        // obs
        $this->obs->setupEditAttributes();
        if (!$this->obs->Raw) {
            $this->obs->CurrentValue = HtmlDecode($this->obs->CurrentValue);
        }
        $this->obs->EditValue = $this->obs->CurrentValue;
        $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $result, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$result || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->idgraficos);
                    $doc->exportCaption($this->competencia_idcompetencia);
                    $doc->exportCaption($this->indicadores_idindicadores);
                    $doc->exportCaption($this->data_base);
                    $doc->exportCaption($this->valor);
                    $doc->exportCaption($this->obs);
                } else {
                    $doc->exportCaption($this->idgraficos);
                    $doc->exportCaption($this->competencia_idcompetencia);
                    $doc->exportCaption($this->indicadores_idindicadores);
                    $doc->exportCaption($this->data_base);
                    $doc->exportCaption($this->valor);
                    $doc->exportCaption($this->obs);
                }
                $doc->endExportRow();
            }
        }
        $recCnt = $startRec - 1;
        $stopRec = $stopRec > 0 ? $stopRec : PHP_INT_MAX;
        while (($row = $result->fetch()) && $recCnt < $stopRec) {
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = RowType::VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->idgraficos);
                        $doc->exportField($this->competencia_idcompetencia);
                        $doc->exportField($this->indicadores_idindicadores);
                        $doc->exportField($this->data_base);
                        $doc->exportField($this->valor);
                        $doc->exportField($this->obs);
                    } else {
                        $doc->exportField($this->idgraficos);
                        $doc->exportField($this->competencia_idcompetencia);
                        $doc->exportField($this->indicadores_idindicadores);
                        $doc->exportField($this->data_base);
                        $doc->exportField($this->valor);
                        $doc->exportField($this->obs);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($doc, $row);
            }
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;

        // No binary fields
        return false;
    }

    // Table level events

    // Table Load event
    public function tableLoad()
    {
        // Enter your code here
    }

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected($rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        $idcompetencia = $rsnew[('competencia_idcompetencia')];
        $dt_base = ExecuteScalar("SELECT data_base from competencia where idcompetencia = $idcompetencia");
        $rsnew[('data_base')] = $dt_base;
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, $rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted($rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, $args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
