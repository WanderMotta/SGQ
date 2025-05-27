<?php

namespace PHPMaker2023\sgq;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for rel_cross_graficos
 */
class RelCrossGraficos extends CrosstabTable
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
    public $YEAR__data_base;

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
        $Language = Container("language");
        $this->TableVar = "rel_cross_graficos";
        $this->TableName = 'rel_cross_graficos';
        $this->TableType = "REPORT";
        $this->ReportSourceTable = 'graficos'; // Report source table
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (report only)

        // PDF
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = ""; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = ""; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions

        // idgraficos
        $this->idgraficos = new ReportField(
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
        $this->idgraficos->IsAutoIncrement = true; // Autoincrement field
        $this->idgraficos->IsPrimaryKey = true; // Primary key field
        $this->idgraficos->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idgraficos->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->idgraficos->SourceTableVar = 'graficos';
        $this->Fields['idgraficos'] = &$this->idgraficos;

        // competencia_idcompetencia
        $this->competencia_idcompetencia = new ReportField(
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
        $this->competencia_idcompetencia->Nullable = false; // NOT NULL field
        $this->competencia_idcompetencia->Required = true; // Required field
        $this->competencia_idcompetencia->setSelectMultiple(false); // Select one
        $this->competencia_idcompetencia->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->competencia_idcompetencia->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->competencia_idcompetencia->Lookup = new Lookup('competencia_idcompetencia', 'competencia', false, 'idcompetencia', ["mes","ano","",""], '', '', [], [], [], [], [], [], '`idcompetencia` ASC', '', "CONCAT(COALESCE(`mes`, ''),'" . ValueSeparator(1, $this->competencia_idcompetencia) . "',COALESCE(`ano`,''))");
        $this->competencia_idcompetencia->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->competencia_idcompetencia->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->competencia_idcompetencia->SourceTableVar = 'graficos';
        $this->Fields['competencia_idcompetencia'] = &$this->competencia_idcompetencia;

        // indicadores_idindicadores
        $this->indicadores_idindicadores = new ReportField(
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
        $this->indicadores_idindicadores->addMethod("getSearchDefault", fn() => Config("INIT_VALUE"));
        $this->indicadores_idindicadores->InputTextType = "text";
        $this->indicadores_idindicadores->GroupingFieldId = 1;
        $this->indicadores_idindicadores->Nullable = false; // NOT NULL field
        $this->indicadores_idindicadores->Required = true; // Required field
        $this->indicadores_idindicadores->setSelectMultiple(false); // Select one
        $this->indicadores_idindicadores->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->indicadores_idindicadores->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->indicadores_idindicadores->Lookup = new Lookup('indicadores_idindicadores', 'indicadores', false, 'idindicadores', ["indicador","","",""], '', '', [], [], [], [], [], [], '`indicador` ASC', '', "`indicador`");
        $this->indicadores_idindicadores->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->indicadores_idindicadores->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->indicadores_idindicadores->AdvancedSearch->SearchValueDefault = $this->indicadores_idindicadores->getSearchDefault();
        $this->indicadores_idindicadores->SourceTableVar = 'graficos';
        $this->Fields['indicadores_idindicadores'] = &$this->indicadores_idindicadores;

        // data_base
        $this->data_base = new ReportField(
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
        $this->data_base->Nullable = false; // NOT NULL field
        $this->data_base->Required = true; // Required field
        $this->data_base->LookupExpression = "YEAR(`data_base`)";
        $this->data_base->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->data_base->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->data_base->SourceTableVar = 'graficos';
        $this->Fields['data_base'] = &$this->data_base;

        // valor
        $this->valor = new ReportField(
            $this, // Table
            'x_valor', // Variable name
            'valor', // Name
            '`valor`', // Expression
            '`valor`', // Basic search expression
            131, // Type
            10, // Size
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
        $this->valor->Nullable = false; // NOT NULL field
        $this->valor->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->valor->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->valor->SourceTableVar = 'graficos';
        $this->Fields['valor'] = &$this->valor;

        // obs
        $this->obs = new ReportField(
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
        $this->obs->SourceTableVar = 'graficos';
        $this->Fields['obs'] = &$this->obs;

        // YEAR__data_base
        $this->YEAR__data_base = new ReportField($this, 'x_YEAR__data_base', 'YEAR__data_base', 'YEAR(`data_base`)', '', 3, -1, -1, false, '', false, false, false);
        $this->YEAR__data_base->Sortable = false;
        $this->YEAR__data_base->Caption = $Language->phrase("Year");
        $this->Fields['YEAR__data_base'] = &$this->YEAR__data_base;

        // Evidencias x M e s
        $this->EvidenciasxMes = new DbChart($this, 'EvidenciasxMes', 'Evidencias x M e s', 'data_base', 'valor', 1001, '', 0, 'SUM', 600, 500);
        $this->EvidenciasxMes->Position = 4;
        $this->EvidenciasxMes->PageBreakType = "before";
        $this->EvidenciasxMes->YAxisFormat = ["Number"];
        $this->EvidenciasxMes->YFieldFormat = ["Number"];
        $this->EvidenciasxMes->SortType = 1;
        $this->EvidenciasxMes->SortSequence = "";
        $this->EvidenciasxMes->SqlSelect = $this->getQueryBuilder()->select("MONTH(`data_base`)", "''", "SUM(`valor`)");
        $this->EvidenciasxMes->SqlGroupBy = "MONTH(`data_base`)";
        $this->EvidenciasxMes->SqlOrderBy = "MONTH(`data_base`) ASC";
        $this->EvidenciasxMes->SeriesDateType = "xm";
        $this->EvidenciasxMes->XAxisDateFormat = 0;
        $this->EvidenciasxMes->ID = "rel_cross_graficos_EvidenciasxMes"; // Chart ID
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
        $this->EvidenciasxMes->setParameter("alpha", "50"); // Chart alpha
        $this->EvidenciasxMes->setParameter("colorpalette", "#5899DA,#E8743B,#19A979,#ED4A7B,#945ECF,#13A4B4,#525DF4,#BF399E,#6C8893,#EE6868,#2F6497"); // Chart color palette
        $this->EvidenciasxMes->setParameters([["options.plugins.legend.display",true],["options.plugins.legend.fullWidth",true],["options.plugins.legend.reverse",true],["options.plugins.legend.rtl",true],["options.plugins.legend.labels.usePointStyle",true],["options.plugins.title.display",true],["options.plugins.tooltip.enabled",true],["options.plugins.tooltip.intersect",true]]);
        $this->Charts[$this->EvidenciasxMes->ID] = &$this->EvidenciasxMes;

        // Add Doctrine Cache
        $this->Cache = new ArrayCache();
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

    // Multiple column sort
    protected function updateSort(&$fld, $ctrl)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($fld->GroupingFieldId == 0) {
                if ($ctrl) {
                    $orderBy = $this->getDetailOrderBy();
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
                    $this->setDetailOrderBy($orderBy); // Save to Session
                } else {
                    $this->setDetailOrderBy($curOrderBy); // Save to Session
                }
            }
        } else {
            if ($fld->GroupingFieldId == 0 && !$ctrl) {
                $fld->setSort("");
            }
        }
    }

    // Get Sort SQL
    protected function sortSql()
    {
        $dtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
        $argrps = [];
        foreach ($this->Fields as $fld) {
            if (in_array($fld->getSort(), ["ASC", "DESC"])) {
                $fldsql = $fld->Expression;
                if ($fld->GroupingFieldId > 0) {
                    if ($fld->GroupSql != "") {
                        $argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->GroupSql) . " " . $fld->getSort();
                    } else {
                        $argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
                    }
                }
            }
        }
        $sortSql = "";
        foreach ($argrps as $grp) {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $grp;
        }
        if ($dtlSortSql != "") {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $dtlSortSql;
        }
        return $sortSql;
    }

    // Table Level Group SQL
    private $sqlFirstGroupField = "";
    private $sqlSelectGroup = null;
    private $sqlOrderByGroup = "";

    // First Group Field
    public function getSqlFirstGroupField($alias = false)
    {
        if ($this->sqlFirstGroupField != "") {
            return $this->sqlFirstGroupField;
        }
        $firstGroupField = &$this->indicadores_idindicadores;
        $expr = $firstGroupField->Expression;
        if ($firstGroupField->GroupSql != "") {
            $expr = str_replace("%s", $firstGroupField->Expression, $firstGroupField->GroupSql);
            if ($alias) {
                $expr .= " AS " . QuotedName($firstGroupField->getGroupName(), $this->Dbid);
            }
        }
        return $expr;
    }

    public function setSqlFirstGroupField($v)
    {
        $this->sqlFirstGroupField = $v;
    }

    // Select Group
    public function getSqlSelectGroup()
    {
        return $this->sqlSelectGroup ?? $this->getQueryBuilder()->select($this->getSqlFirstGroupField(true))->distinct();
    }

    public function setSqlSelectGroup($v)
    {
        $this->sqlSelectGroup = $v;
    }

    // Order By Group
    public function getSqlOrderByGroup()
    {
        if ($this->sqlOrderByGroup != "") {
            return $this->sqlOrderByGroup;
        }
        return $this->getSqlFirstGroupField() . " ASC";
    }

    public function setSqlOrderByGroup($v)
    {
        $this->sqlOrderByGroup = $v;
    }

    // Crosstab properties
    private $sqlSelectAggregate = null;
    private $sqlGroupByAggregate = "";

    // Select Aggregate
    public function getSqlSelectAggregate()
    {
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select("YEAR(`data_base`) AS YEAR__data_base");
    }

    public function setSqlSelectAggregate($v)
    {
        $this->sqlSelectAggregate = $v;
    }

    // Group By Aggregate
    public function getSqlGroupByAggregate()
    {
        return ($this->sqlGroupByAggregate != "") ? $this->sqlGroupByAggregate : "YEAR(`data_base`)";
    }

    public function setSqlGroupByAggregate($v)
    {
        $this->sqlGroupByAggregate = $v;
    }

    // Table level SQL
    private $columnField = "";
    private $columnDateType = "";
    private $columnValues = "";
    private $sqlCrosstabYear = "";
    public $Columns;
    public $ColumnCount;
    public $Col;
    public $DistinctColumnFields = "";
    private $columnLoaded = false;

    // Column field
    public function getColumnField()
    {
        return ($this->columnField != "") ? $this->columnField : "`data_base`";
    }

    public function setColumnField($v)
    {
        $this->columnField = $v;
    }

    // Column date type
    public function getColumnDateType()
    {
        return ($this->columnDateType != "") ? $this->columnDateType : "m";
    }

    public function setColumnDateType($v)
    {
        $this->columnDateType = $v;
    }

    // Column values
    public function getColumnValues()
    {
        return ($this->columnValues != "") ? $this->columnValues : "1,2,3,4,5,6,7,8,9,10,11,12";
    }

    public function setColumnValues($v)
    {
        $this->columnValues = $v;
    }

    // Crosstab Year
    public function getSqlCrosstabYear()
    {
        return ($this->sqlCrosstabYear != "") ? $this->sqlCrosstabYear : "SELECT DISTINCT YEAR(`data_base`) AS YEAR__data_base FROM graficos ORDER BY YEAR(`data_base`)";
    }

    public function setSqlCrosstabYear($v)
    {
        $this->sqlCrosstabYear = $v;
    }

    // Load column values
    public function loadColumnValues($filter = "")
    {
        global $Language;

        // Data already loaded, return
        if ($this->columnLoaded) {
            return;
        }
        $conn = $this->getConnection();
        $arColumnValues = explode(",", $this->getColumnValues());

        // Get distinct column count
        $this->ColumnCount = count($arColumnValues);
        $this->Columns = Init2DArray($this->ColumnCount + 1, 2, null);
        for ($colcnt = 1; $colcnt <= $this->ColumnCount; $colcnt++)
            $this->Columns[$colcnt] = new CrosstabColumn($arColumnValues[$colcnt - 1], MonthName($arColumnValues[$colcnt - 1]), true);

        // 1st dimension = no of groups (level 0 used for grand total)
        // 2nd dimension = no of distinct values
        $groupCount = 1;
        $this->SummaryFields[0] = new SummaryField('x_valor', 'valor', '`valor`', 'SUM');
        $this->SummaryFields[0]->SummaryCaption = $Language->phrase("RptSum");
        $this->SummaryFields[0]->SummaryValues = InitArray($this->ColumnCount + 1, null);
        $this->SummaryFields[0]->SummaryValueCounts = InitArray($this->ColumnCount + 1, null);
        $this->SummaryFields[0]->SummaryInitValue = 0;

        // Update crosstab SQL
        $sqlFlds = "";
        $cnt = count($this->SummaryFields);
        for ($is = 0; $is < $cnt; $is++) {
            $smry = &$this->SummaryFields[$is];
            for ($i = 0; $i < $this->ColumnCount; $i++) {
                $fld = CrosstabFieldExpression($smry->SummaryType, $smry->Expression,
                    $this->getColumnField(), $this->getColumnDateType(), $arColumnValues[$i], "", "C" . $arColumnValues[$i] . "F" . $is, $this->Dbid);
                if ($sqlFlds != "") {
                    $sqlFlds .= ", ";
                }
                $sqlFlds .= $fld;
            }
        }
        $this->DistinctColumnFields = $sqlFlds ?: "NULL"; // In case ColumnCount = 0
        $this->columnLoaded = true;
    }

    // Render for lookup
    public function renderLookup()
    {
        $this->indicadores_idindicadores->ViewValue = GetDropDownDisplayValue($this->indicadores_idindicadores->CurrentValue, "", 0);
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "graficos";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("`indicadores_idindicadores`, YEAR(`data_base`) AS YEAR__data_base");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "`indicadores_idindicadores`, YEAR(`data_base`)";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

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
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            case "lookup":
                return (($allow & 256) == 256);
            default:
                return (($allow & 8) == 8);
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
        $rs = null;
        if ($sql instanceof QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlwrk);
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idgraficos` = @idgraficos@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->idgraficos->CurrentValue : $this->idgraficos->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
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
        return $_SESSION[$name] ?? GetUrl("");
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
        if ($pageName == "") {
            return $Language->phrase("View");
        } elseif ($pageName == "") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "") {
            return $Language->phrase("Add");
        }
        return "";
    }

    // API page name
    public function getApiPageName($action)
    {
        return "RelCrossGraficosCrosstab";
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
        return "";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("", $parm);
        } else {
            $url = $this->keyUrl("", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "?" . $parm;
        } else {
            $url = "";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("");
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"idgraficos\":" . JsonEncode($this->idgraficos->CurrentValue, "number");
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
        global $Security, $Language, $Page;
        $sortUrl = "";
        $attrs = "";
        if ($fld->Sortable) {
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
        if ($fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") . '</div></div>';
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
            $this->DrillDown ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;dashboard=true";
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
            if (($keyValue = Param("idgraficos") ?? Route("idgraficos")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
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

    // Load recordset based on filter / sort
    public function loadRs($filter, $sort = "")
    {
        $sql = $this->getSql($filter, $sort); // Set up filter (WHERE Clause) / sort (ORDER BY Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
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

    // Email Sending event
    public function emailSending($email, &$args)
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
