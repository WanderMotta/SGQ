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
 * Table class for view_relatoria_auditoria
 */
class ViewRelatoriaAuditoria extends DbTable
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

    // Fields
    public $plano_nr;
    public $data;
    public $auditor_lider;
    public $processo;
    public $escopo;
    public $auditor;
    public $item;
    public $descricao;
    public $evidencia;
    public $nao_conformidade;
    public $metodo;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "view_relatoria_auditoria";
        $this->TableName = 'view_relatoria_auditoria';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_relatoria_auditoria";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)

        // PDF
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
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
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // plano_nr
        $this->plano_nr = new DbField(
            $this, // Table
            'x_plano_nr', // Variable name
            'plano_nr', // Name
            '`plano_nr`', // Expression
            '`plano_nr`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`plano_nr`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->plano_nr->InputTextType = "text";
        $this->plano_nr->Raw = true;
        $this->plano_nr->IsAutoIncrement = true; // Autoincrement field
        $this->plano_nr->IsPrimaryKey = true; // Primary key field
        $this->plano_nr->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->plano_nr->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['plano_nr'] = &$this->plano_nr;

        // data
        $this->data = new DbField(
            $this, // Table
            'x_data', // Variable name
            'data', // Name
            '`data`', // Expression
            CastDateFieldForLike("`data`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`data`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->data->InputTextType = "text";
        $this->data->Raw = true;
        $this->data->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->data->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['data'] = &$this->data;

        // auditor_lider
        $this->auditor_lider = new DbField(
            $this, // Table
            'x_auditor_lider', // Variable name
            'auditor_lider', // Name
            '`auditor_lider`', // Expression
            '`auditor_lider`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`auditor_lider`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->auditor_lider->InputTextType = "text";
        $this->auditor_lider->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['auditor_lider'] = &$this->auditor_lider;

        // processo
        $this->processo = new DbField(
            $this, // Table
            'x_processo', // Variable name
            'processo', // Name
            '`processo`', // Expression
            '`processo`', // Basic search expression
            200, // Type
            80, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`processo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->processo->InputTextType = "text";
        $this->processo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['processo'] = &$this->processo;

        // escopo
        $this->escopo = new DbField(
            $this, // Table
            'x_escopo', // Variable name
            'escopo', // Name
            '`escopo`', // Expression
            '`escopo`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`escopo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->escopo->InputTextType = "text";
        $this->escopo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['escopo'] = &$this->escopo;

        // auditor
        $this->auditor = new DbField(
            $this, // Table
            'x_auditor', // Variable name
            'auditor', // Name
            '`auditor`', // Expression
            '`auditor`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`auditor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->auditor->InputTextType = "text";
        $this->auditor->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['auditor'] = &$this->auditor;

        // item
        $this->item = new DbField(
            $this, // Table
            'x_item', // Variable name
            'item', // Name
            '`item`', // Expression
            '`item`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`item`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->item->InputTextType = "text";
        $this->item->Raw = true;
        $this->item->Nullable = false; // NOT NULL field
        $this->item->Required = true; // Required field
        $this->item->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->item->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['item'] = &$this->item;

        // descricao
        $this->descricao = new DbField(
            $this, // Table
            'x_descricao', // Variable name
            'descricao', // Name
            '`descricao`', // Expression
            '`descricao`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`descricao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->descricao->InputTextType = "text";
        $this->descricao->Nullable = false; // NOT NULL field
        $this->descricao->Required = true; // Required field
        $this->descricao->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['descricao'] = &$this->descricao;

        // evidencia
        $this->evidencia = new DbField(
            $this, // Table
            'x_evidencia', // Variable name
            'evidencia', // Name
            '`evidencia`', // Expression
            '`evidencia`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`evidencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->evidencia->InputTextType = "text";
        $this->evidencia->Nullable = false; // NOT NULL field
        $this->evidencia->Required = true; // Required field
        $this->evidencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['evidencia'] = &$this->evidencia;

        // nao_conformidade
        $this->nao_conformidade = new DbField(
            $this, // Table
            'x_nao_conformidade', // Variable name
            'nao_conformidade', // Name
            '`nao_conformidade`', // Expression
            '`nao_conformidade`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nao_conformidade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->nao_conformidade->addMethod("getDefault", fn() => "Nao");
        $this->nao_conformidade->InputTextType = "text";
        $this->nao_conformidade->Raw = true;
        $this->nao_conformidade->Nullable = false; // NOT NULL field
        $this->nao_conformidade->Lookup = new Lookup($this->nao_conformidade, 'view_relatoria_auditoria', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->nao_conformidade->OptionCount = 2;
        $this->nao_conformidade->SearchOperators = ["=", "<>"];
        $this->Fields['nao_conformidade'] = &$this->nao_conformidade;

        // metodo
        $this->metodo = new DbField(
            $this, // Table
            'x_metodo', // Variable name
            'metodo', // Name
            '`metodo`', // Expression
            '`metodo`', // Basic search expression
            200, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`metodo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->metodo->addMethod("getDefault", fn() => "Analise Doc");
        $this->metodo->InputTextType = "text";
        $this->metodo->Raw = true;
        $this->metodo->Nullable = false; // NOT NULL field
        $this->metodo->Lookup = new Lookup($this->metodo, 'view_relatoria_auditoria', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->metodo->OptionCount = 3;
        $this->metodo->SearchOperators = ["=", "<>"];
        $this->Fields['metodo'] = &$this->metodo;

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

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_relatoria_auditoria";
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
            $this->plano_nr->setDbValue($conn->lastInsertId());
            $rs['plano_nr'] = $this->plano_nr->DbValue;
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
            if (!isset($rs['plano_nr']) && !EmptyValue($this->plano_nr->CurrentValue)) {
                $rs['plano_nr'] = $this->plano_nr->CurrentValue;
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
            if (array_key_exists('plano_nr', $rs)) {
                AddFilter($where, QuotedName('plano_nr', $this->Dbid) . '=' . QuotedValue($rs['plano_nr'], $this->plano_nr->DataType, $this->Dbid));
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
        $this->plano_nr->DbValue = $row['plano_nr'];
        $this->data->DbValue = $row['data'];
        $this->auditor_lider->DbValue = $row['auditor_lider'];
        $this->processo->DbValue = $row['processo'];
        $this->escopo->DbValue = $row['escopo'];
        $this->auditor->DbValue = $row['auditor'];
        $this->item->DbValue = $row['item'];
        $this->descricao->DbValue = $row['descricao'];
        $this->evidencia->DbValue = $row['evidencia'];
        $this->nao_conformidade->DbValue = $row['nao_conformidade'];
        $this->metodo->DbValue = $row['metodo'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`plano_nr` = @plano_nr@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->plano_nr->CurrentValue : $this->plano_nr->OldValue;
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
                $this->plano_nr->CurrentValue = $keys[0];
            } else {
                $this->plano_nr->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('plano_nr', $row) ? $row['plano_nr'] : null;
        } else {
            $val = !EmptyValue($this->plano_nr->OldValue) && !$current ? $this->plano_nr->OldValue : $this->plano_nr->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@plano_nr@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ViewRelatoriaAuditoriaList");
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
            "ViewRelatoriaAuditoriaView" => $Language->phrase("View"),
            "ViewRelatoriaAuditoriaEdit" => $Language->phrase("Edit"),
            "ViewRelatoriaAuditoriaAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewRelatoriaAuditoriaList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewRelatoriaAuditoriaView",
            Config("API_ADD_ACTION") => "ViewRelatoriaAuditoriaAdd",
            Config("API_EDIT_ACTION") => "ViewRelatoriaAuditoriaEdit",
            Config("API_DELETE_ACTION") => "ViewRelatoriaAuditoriaDelete",
            Config("API_LIST_ACTION") => "ViewRelatoriaAuditoriaList",
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
        return "ViewRelatoriaAuditoriaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewRelatoriaAuditoriaView", $parm);
        } else {
            $url = $this->keyUrl("ViewRelatoriaAuditoriaView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewRelatoriaAuditoriaAdd?" . $parm;
        } else {
            $url = "ViewRelatoriaAuditoriaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewRelatoriaAuditoriaEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewRelatoriaAuditoriaList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewRelatoriaAuditoriaAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewRelatoriaAuditoriaList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewRelatoriaAuditoriaDelete", $parm);
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
        $json .= "\"plano_nr\":" . VarToJson($this->plano_nr->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->plano_nr->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->plano_nr->CurrentValue);
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
            if (($keyValue = Param("plano_nr") ?? Route("plano_nr")) !== null) {
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
                $this->plano_nr->CurrentValue = $key;
            } else {
                $this->plano_nr->OldValue = $key;
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
        $this->plano_nr->setDbValue($row['plano_nr']);
        $this->data->setDbValue($row['data']);
        $this->auditor_lider->setDbValue($row['auditor_lider']);
        $this->processo->setDbValue($row['processo']);
        $this->escopo->setDbValue($row['escopo']);
        $this->auditor->setDbValue($row['auditor']);
        $this->item->setDbValue($row['item']);
        $this->descricao->setDbValue($row['descricao']);
        $this->evidencia->setDbValue($row['evidencia']);
        $this->nao_conformidade->setDbValue($row['nao_conformidade']);
        $this->metodo->setDbValue($row['metodo']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewRelatoriaAuditoriaList";
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

        // plano_nr

        // data

        // auditor_lider

        // processo

        // escopo

        // auditor

        // item

        // descricao

        // evidencia

        // nao_conformidade

        // metodo

        // plano_nr
        $this->plano_nr->ViewValue = $this->plano_nr->CurrentValue;

        // data
        $this->data->ViewValue = $this->data->CurrentValue;
        $this->data->ViewValue = FormatDateTime($this->data->ViewValue, $this->data->formatPattern());

        // auditor_lider
        $this->auditor_lider->ViewValue = $this->auditor_lider->CurrentValue;

        // processo
        $this->processo->ViewValue = $this->processo->CurrentValue;

        // escopo
        $this->escopo->ViewValue = $this->escopo->CurrentValue;

        // auditor
        $this->auditor->ViewValue = $this->auditor->CurrentValue;

        // item
        $this->item->ViewValue = $this->item->CurrentValue;
        $this->item->ViewValue = FormatNumber($this->item->ViewValue, $this->item->formatPattern());

        // descricao
        $this->descricao->ViewValue = $this->descricao->CurrentValue;

        // evidencia
        $this->evidencia->ViewValue = $this->evidencia->CurrentValue;

        // nao_conformidade
        if (strval($this->nao_conformidade->CurrentValue) != "") {
            $this->nao_conformidade->ViewValue = $this->nao_conformidade->optionCaption($this->nao_conformidade->CurrentValue);
        } else {
            $this->nao_conformidade->ViewValue = null;
        }

        // metodo
        if (strval($this->metodo->CurrentValue) != "") {
            $this->metodo->ViewValue = $this->metodo->optionCaption($this->metodo->CurrentValue);
        } else {
            $this->metodo->ViewValue = null;
        }

        // plano_nr
        $this->plano_nr->HrefValue = "";
        $this->plano_nr->TooltipValue = "";

        // data
        $this->data->HrefValue = "";
        $this->data->TooltipValue = "";

        // auditor_lider
        $this->auditor_lider->HrefValue = "";
        $this->auditor_lider->TooltipValue = "";

        // processo
        $this->processo->HrefValue = "";
        $this->processo->TooltipValue = "";

        // escopo
        $this->escopo->HrefValue = "";
        $this->escopo->TooltipValue = "";

        // auditor
        $this->auditor->HrefValue = "";
        $this->auditor->TooltipValue = "";

        // item
        $this->item->HrefValue = "";
        $this->item->TooltipValue = "";

        // descricao
        $this->descricao->HrefValue = "";
        $this->descricao->TooltipValue = "";

        // evidencia
        $this->evidencia->HrefValue = "";
        $this->evidencia->TooltipValue = "";

        // nao_conformidade
        $this->nao_conformidade->HrefValue = "";
        $this->nao_conformidade->TooltipValue = "";

        // metodo
        $this->metodo->HrefValue = "";
        $this->metodo->TooltipValue = "";

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

        // plano_nr
        $this->plano_nr->setupEditAttributes();
        $this->plano_nr->EditValue = $this->plano_nr->CurrentValue;

        // data
        $this->data->setupEditAttributes();
        $this->data->EditValue = FormatDateTime($this->data->CurrentValue, $this->data->formatPattern());
        $this->data->PlaceHolder = RemoveHtml($this->data->caption());

        // auditor_lider
        $this->auditor_lider->setupEditAttributes();
        if (!$this->auditor_lider->Raw) {
            $this->auditor_lider->CurrentValue = HtmlDecode($this->auditor_lider->CurrentValue);
        }
        $this->auditor_lider->EditValue = $this->auditor_lider->CurrentValue;
        $this->auditor_lider->PlaceHolder = RemoveHtml($this->auditor_lider->caption());

        // processo
        $this->processo->setupEditAttributes();
        if (!$this->processo->Raw) {
            $this->processo->CurrentValue = HtmlDecode($this->processo->CurrentValue);
        }
        $this->processo->EditValue = $this->processo->CurrentValue;
        $this->processo->PlaceHolder = RemoveHtml($this->processo->caption());

        // escopo
        $this->escopo->setupEditAttributes();
        $this->escopo->EditValue = $this->escopo->CurrentValue;
        $this->escopo->PlaceHolder = RemoveHtml($this->escopo->caption());

        // auditor
        $this->auditor->setupEditAttributes();
        if (!$this->auditor->Raw) {
            $this->auditor->CurrentValue = HtmlDecode($this->auditor->CurrentValue);
        }
        $this->auditor->EditValue = $this->auditor->CurrentValue;
        $this->auditor->PlaceHolder = RemoveHtml($this->auditor->caption());

        // item
        $this->item->setupEditAttributes();
        $this->item->EditValue = $this->item->CurrentValue;
        $this->item->PlaceHolder = RemoveHtml($this->item->caption());
        if (strval($this->item->EditValue) != "" && is_numeric($this->item->EditValue)) {
            $this->item->EditValue = FormatNumber($this->item->EditValue, null);
        }

        // descricao
        $this->descricao->setupEditAttributes();
        $this->descricao->EditValue = $this->descricao->CurrentValue;
        $this->descricao->PlaceHolder = RemoveHtml($this->descricao->caption());

        // evidencia
        $this->evidencia->setupEditAttributes();
        $this->evidencia->EditValue = $this->evidencia->CurrentValue;
        $this->evidencia->PlaceHolder = RemoveHtml($this->evidencia->caption());

        // nao_conformidade
        $this->nao_conformidade->EditValue = $this->nao_conformidade->options(false);
        $this->nao_conformidade->PlaceHolder = RemoveHtml($this->nao_conformidade->caption());

        // metodo
        $this->metodo->EditValue = $this->metodo->options(false);
        $this->metodo->PlaceHolder = RemoveHtml($this->metodo->caption());

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
                    $doc->exportCaption($this->plano_nr);
                    $doc->exportCaption($this->data);
                    $doc->exportCaption($this->auditor_lider);
                    $doc->exportCaption($this->processo);
                    $doc->exportCaption($this->escopo);
                    $doc->exportCaption($this->auditor);
                    $doc->exportCaption($this->item);
                    $doc->exportCaption($this->descricao);
                    $doc->exportCaption($this->evidencia);
                    $doc->exportCaption($this->nao_conformidade);
                    $doc->exportCaption($this->metodo);
                } else {
                    $doc->exportCaption($this->plano_nr);
                    $doc->exportCaption($this->data);
                    $doc->exportCaption($this->auditor_lider);
                    $doc->exportCaption($this->processo);
                    $doc->exportCaption($this->auditor);
                    $doc->exportCaption($this->item);
                    $doc->exportCaption($this->nao_conformidade);
                    $doc->exportCaption($this->metodo);
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
                        $doc->exportField($this->plano_nr);
                        $doc->exportField($this->data);
                        $doc->exportField($this->auditor_lider);
                        $doc->exportField($this->processo);
                        $doc->exportField($this->escopo);
                        $doc->exportField($this->auditor);
                        $doc->exportField($this->item);
                        $doc->exportField($this->descricao);
                        $doc->exportField($this->evidencia);
                        $doc->exportField($this->nao_conformidade);
                        $doc->exportField($this->metodo);
                    } else {
                        $doc->exportField($this->plano_nr);
                        $doc->exportField($this->data);
                        $doc->exportField($this->auditor_lider);
                        $doc->exportField($this->processo);
                        $doc->exportField($this->auditor);
                        $doc->exportField($this->item);
                        $doc->exportField($this->nao_conformidade);
                        $doc->exportField($this->metodo);
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
