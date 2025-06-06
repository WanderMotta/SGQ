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
 * Table class for relatorio_auditoria_interna
 */
class RelatorioAuditoriaInterna extends DbTable
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
    public $idrelatorio_auditoria_interna;
    public $data;
    public $origem_risco_oportunidade_idorigem_risco_oportunidade;
    public $auditor;
    public $aprovador;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "relatorio_auditoria_interna";
        $this->TableName = 'relatorio_auditoria_interna';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "relatorio_auditoria_interna";
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
        $this->ExportWordPageOrientation = "landscape"; // Page orientation (PHPWord only)
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

        // idrelatorio_auditoria_interna
        $this->idrelatorio_auditoria_interna = new DbField(
            $this, // Table
            'x_idrelatorio_auditoria_interna', // Variable name
            'idrelatorio_auditoria_interna', // Name
            '`idrelatorio_auditoria_interna`', // Expression
            '`idrelatorio_auditoria_interna`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idrelatorio_auditoria_interna`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idrelatorio_auditoria_interna->InputTextType = "text";
        $this->idrelatorio_auditoria_interna->Raw = true;
        $this->idrelatorio_auditoria_interna->IsAutoIncrement = true; // Autoincrement field
        $this->idrelatorio_auditoria_interna->IsPrimaryKey = true; // Primary key field
        $this->idrelatorio_auditoria_interna->IsForeignKey = true; // Foreign key field
        $this->idrelatorio_auditoria_interna->Nullable = false; // NOT NULL field
        $this->idrelatorio_auditoria_interna->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idrelatorio_auditoria_interna->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idrelatorio_auditoria_interna'] = &$this->idrelatorio_auditoria_interna;

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
        $this->data->Nullable = false; // NOT NULL field
        $this->data->Required = true; // Required field
        $this->data->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->data->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['data'] = &$this->data;

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade = new DbField(
            $this, // Table
            'x_origem_risco_oportunidade_idorigem_risco_oportunidade', // Variable name
            'origem_risco_oportunidade_idorigem_risco_oportunidade', // Name
            '`origem_risco_oportunidade_idorigem_risco_oportunidade`', // Expression
            '`origem_risco_oportunidade_idorigem_risco_oportunidade`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`origem_risco_oportunidade_idorigem_risco_oportunidade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->InputTextType = "text";
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Raw = true;
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Nullable = false; // NOT NULL field
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Required = true; // Required field
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setSelectMultiple(false); // Select one
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup = new Lookup($this->origem_risco_oportunidade_idorigem_risco_oportunidade, 'origem_risco_oportunidade', false, 'idorigem_risco_oportunidade', ["origem","","",""], '', '', [], [], [], [], [], [], false, '`origem` ASC', '', "`origem`");
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['origem_risco_oportunidade_idorigem_risco_oportunidade'] = &$this->origem_risco_oportunidade_idorigem_risco_oportunidade;

        // auditor
        $this->auditor = new DbField(
            $this, // Table
            'x_auditor', // Variable name
            'auditor', // Name
            '`auditor`', // Expression
            '`auditor`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`auditor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->auditor->InputTextType = "text";
        $this->auditor->Raw = true;
        $this->auditor->Nullable = false; // NOT NULL field
        $this->auditor->Required = true; // Required field
        $this->auditor->setSelectMultiple(false); // Select one
        $this->auditor->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->auditor->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->auditor->Lookup = new Lookup($this->auditor, 'usuario', false, 'idusuario', ["nome","","",""], '', '', [], [], [], [], [], [], false, '`nome` ASC', '', "`nome`");
        $this->auditor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->auditor->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['auditor'] = &$this->auditor;

        // aprovador
        $this->aprovador = new DbField(
            $this, // Table
            'x_aprovador', // Variable name
            'aprovador', // Name
            '`aprovador`', // Expression
            '`aprovador`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`aprovador`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->aprovador->InputTextType = "text";
        $this->aprovador->Raw = true;
        $this->aprovador->Nullable = false; // NOT NULL field
        $this->aprovador->Required = true; // Required field
        $this->aprovador->setSelectMultiple(false); // Select one
        $this->aprovador->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->aprovador->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->aprovador->Lookup = new Lookup($this->aprovador, 'usuario', false, 'idusuario', ["nome","","",""], '', '', [], [], [], [], [], [], false, '`nome` ASC', '', "`nome`");
        $this->aprovador->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->aprovador->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['aprovador'] = &$this->aprovador;

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

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")) ?? "";
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "item_rel_aud_interna") {
            $detailUrl = Container("item_rel_aud_interna")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idrelatorio_auditoria_interna", $this->idrelatorio_auditoria_interna->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "RelatorioAuditoriaInternaList";
        }
        return $detailUrl;
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "relatorio_auditoria_interna";
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
            $this->idrelatorio_auditoria_interna->setDbValue($conn->lastInsertId());
            $rs['idrelatorio_auditoria_interna'] = $this->idrelatorio_auditoria_interna->DbValue;
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
        // Cascade Update detail table 'item_rel_aud_interna'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['idrelatorio_auditoria_interna']) && $rsold['idrelatorio_auditoria_interna'] != $rs['idrelatorio_auditoria_interna'])) { // Update detail field 'relatorio_auditoria_interna_idrelatorio_auditoria_interna'
            $cascadeUpdate = true;
            $rscascade['relatorio_auditoria_interna_idrelatorio_auditoria_interna'] = $rs['idrelatorio_auditoria_interna'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("item_rel_aud_interna")->loadRs("`relatorio_auditoria_interna_idrelatorio_auditoria_interna` = " . QuotedValue($rsold['idrelatorio_auditoria_interna'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'iditem_rel_aud_interna';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("item_rel_aud_interna")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("item_rel_aud_interna")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("item_rel_aud_interna")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

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
            if (!isset($rs['idrelatorio_auditoria_interna']) && !EmptyValue($this->idrelatorio_auditoria_interna->CurrentValue)) {
                $rs['idrelatorio_auditoria_interna'] = $this->idrelatorio_auditoria_interna->CurrentValue;
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
            if (array_key_exists('idrelatorio_auditoria_interna', $rs)) {
                AddFilter($where, QuotedName('idrelatorio_auditoria_interna', $this->Dbid) . '=' . QuotedValue($rs['idrelatorio_auditoria_interna'], $this->idrelatorio_auditoria_interna->DataType, $this->Dbid));
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

        // Cascade delete detail table 'item_rel_aud_interna'
        $dtlrows = Container("item_rel_aud_interna")->loadRs("`relatorio_auditoria_interna_idrelatorio_auditoria_interna` = " . QuotedValue($rs['idrelatorio_auditoria_interna'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("item_rel_aud_interna")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("item_rel_aud_interna")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("item_rel_aud_interna")->rowDeleted($dtlrow);
            }
        }
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
        $this->idrelatorio_auditoria_interna->DbValue = $row['idrelatorio_auditoria_interna'];
        $this->data->DbValue = $row['data'];
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->DbValue = $row['origem_risco_oportunidade_idorigem_risco_oportunidade'];
        $this->auditor->DbValue = $row['auditor'];
        $this->aprovador->DbValue = $row['aprovador'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idrelatorio_auditoria_interna` = @idrelatorio_auditoria_interna@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idrelatorio_auditoria_interna->CurrentValue : $this->idrelatorio_auditoria_interna->OldValue;
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
                $this->idrelatorio_auditoria_interna->CurrentValue = $keys[0];
            } else {
                $this->idrelatorio_auditoria_interna->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idrelatorio_auditoria_interna', $row) ? $row['idrelatorio_auditoria_interna'] : null;
        } else {
            $val = !EmptyValue($this->idrelatorio_auditoria_interna->OldValue) && !$current ? $this->idrelatorio_auditoria_interna->OldValue : $this->idrelatorio_auditoria_interna->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idrelatorio_auditoria_interna@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("RelatorioAuditoriaInternaList");
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
            "RelatorioAuditoriaInternaView" => $Language->phrase("View"),
            "RelatorioAuditoriaInternaEdit" => $Language->phrase("Edit"),
            "RelatorioAuditoriaInternaAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "RelatorioAuditoriaInternaList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "RelatorioAuditoriaInternaView",
            Config("API_ADD_ACTION") => "RelatorioAuditoriaInternaAdd",
            Config("API_EDIT_ACTION") => "RelatorioAuditoriaInternaEdit",
            Config("API_DELETE_ACTION") => "RelatorioAuditoriaInternaDelete",
            Config("API_LIST_ACTION") => "RelatorioAuditoriaInternaList",
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
        return "RelatorioAuditoriaInternaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("RelatorioAuditoriaInternaView", $parm);
        } else {
            $url = $this->keyUrl("RelatorioAuditoriaInternaView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "RelatorioAuditoriaInternaAdd?" . $parm;
        } else {
            $url = "RelatorioAuditoriaInternaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("RelatorioAuditoriaInternaEdit", $parm);
        } else {
            $url = $this->keyUrl("RelatorioAuditoriaInternaEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("RelatorioAuditoriaInternaList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("RelatorioAuditoriaInternaAdd", $parm);
        } else {
            $url = $this->keyUrl("RelatorioAuditoriaInternaAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("RelatorioAuditoriaInternaList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("RelatorioAuditoriaInternaDelete", $parm);
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
        $json .= "\"idrelatorio_auditoria_interna\":" . VarToJson($this->idrelatorio_auditoria_interna->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idrelatorio_auditoria_interna->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idrelatorio_auditoria_interna->CurrentValue);
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
            if (($keyValue = Param("idrelatorio_auditoria_interna") ?? Route("idrelatorio_auditoria_interna")) !== null) {
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
                $this->idrelatorio_auditoria_interna->CurrentValue = $key;
            } else {
                $this->idrelatorio_auditoria_interna->OldValue = $key;
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
        $this->idrelatorio_auditoria_interna->setDbValue($row['idrelatorio_auditoria_interna']);
        $this->data->setDbValue($row['data']);
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValue($row['origem_risco_oportunidade_idorigem_risco_oportunidade']);
        $this->auditor->setDbValue($row['auditor']);
        $this->aprovador->setDbValue($row['aprovador']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "RelatorioAuditoriaInternaList";
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

        // idrelatorio_auditoria_interna

        // data

        // origem_risco_oportunidade_idorigem_risco_oportunidade

        // auditor

        // aprovador

        // idrelatorio_auditoria_interna
        $this->idrelatorio_auditoria_interna->ViewValue = $this->idrelatorio_auditoria_interna->CurrentValue;
        $this->idrelatorio_auditoria_interna->CssClass = "fw-bold";
        $this->idrelatorio_auditoria_interna->CellCssStyle .= "text-align: center;";

        // data
        $this->data->ViewValue = $this->data->CurrentValue;
        $this->data->ViewValue = FormatDateTime($this->data->ViewValue, $this->data->formatPattern());
        $this->data->CssClass = "fw-bold";

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $curVal = strval($this->origem_risco_oportunidade_idorigem_risco_oportunidade->CurrentValue);
        if ($curVal != "") {
            $this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->lookupCacheOption($curVal);
            if ($this->origem_risco_oportunidade_idorigem_risco_oportunidade->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getTable()->Fields["idorigem_risco_oportunidade"]->searchExpression(), "=", $curVal, $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getTable()->Fields["idorigem_risco_oportunidade"]->searchDataType(), "");
                $sqlWrk = $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
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

        // auditor
        $curVal = strval($this->auditor->CurrentValue);
        if ($curVal != "") {
            $this->auditor->ViewValue = $this->auditor->lookupCacheOption($curVal);
            if ($this->auditor->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->auditor->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->auditor->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                $sqlWrk = $this->auditor->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->auditor->Lookup->renderViewRow($rswrk[0]);
                    $this->auditor->ViewValue = $this->auditor->displayValue($arwrk);
                } else {
                    $this->auditor->ViewValue = FormatNumber($this->auditor->CurrentValue, $this->auditor->formatPattern());
                }
            }
        } else {
            $this->auditor->ViewValue = null;
        }
        $this->auditor->CssClass = "fw-bold";

        // aprovador
        $curVal = strval($this->aprovador->CurrentValue);
        if ($curVal != "") {
            $this->aprovador->ViewValue = $this->aprovador->lookupCacheOption($curVal);
            if ($this->aprovador->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->aprovador->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->aprovador->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                $sqlWrk = $this->aprovador->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->aprovador->Lookup->renderViewRow($rswrk[0]);
                    $this->aprovador->ViewValue = $this->aprovador->displayValue($arwrk);
                } else {
                    $this->aprovador->ViewValue = FormatNumber($this->aprovador->CurrentValue, $this->aprovador->formatPattern());
                }
            }
        } else {
            $this->aprovador->ViewValue = null;
        }
        $this->aprovador->CssClass = "fw-bold";

        // idrelatorio_auditoria_interna
        $this->idrelatorio_auditoria_interna->HrefValue = "";
        $this->idrelatorio_auditoria_interna->TooltipValue = "";

        // data
        $this->data->HrefValue = "";
        $this->data->TooltipValue = "";

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->TooltipValue = "";

        // auditor
        $this->auditor->HrefValue = "";
        $this->auditor->TooltipValue = "";

        // aprovador
        $this->aprovador->HrefValue = "";
        $this->aprovador->TooltipValue = "";

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

        // idrelatorio_auditoria_interna
        $this->idrelatorio_auditoria_interna->setupEditAttributes();
        $this->idrelatorio_auditoria_interna->EditValue = $this->idrelatorio_auditoria_interna->CurrentValue;
        $this->idrelatorio_auditoria_interna->CssClass = "fw-bold";
        $this->idrelatorio_auditoria_interna->CellCssStyle .= "text-align: center;";

        // data
        $this->data->setupEditAttributes();
        $this->data->EditValue = FormatDateTime($this->data->CurrentValue, $this->data->formatPattern());
        $this->data->PlaceHolder = RemoveHtml($this->data->caption());

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setupEditAttributes();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->PlaceHolder = RemoveHtml($this->origem_risco_oportunidade_idorigem_risco_oportunidade->caption());

        // auditor
        $this->auditor->setupEditAttributes();
        $this->auditor->PlaceHolder = RemoveHtml($this->auditor->caption());

        // aprovador
        $this->aprovador->setupEditAttributes();
        $this->aprovador->PlaceHolder = RemoveHtml($this->aprovador->caption());

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
                    $doc->exportCaption($this->idrelatorio_auditoria_interna);
                    $doc->exportCaption($this->data);
                    $doc->exportCaption($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                    $doc->exportCaption($this->auditor);
                    $doc->exportCaption($this->aprovador);
                } else {
                    $doc->exportCaption($this->idrelatorio_auditoria_interna);
                    $doc->exportCaption($this->data);
                    $doc->exportCaption($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                    $doc->exportCaption($this->auditor);
                    $doc->exportCaption($this->aprovador);
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
                        $doc->exportField($this->idrelatorio_auditoria_interna);
                        $doc->exportField($this->data);
                        $doc->exportField($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                        $doc->exportField($this->auditor);
                        $doc->exportField($this->aprovador);
                    } else {
                        $doc->exportField($this->idrelatorio_auditoria_interna);
                        $doc->exportField($this->data);
                        $doc->exportField($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                        $doc->exportField($this->auditor);
                        $doc->exportField($this->aprovador);
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
