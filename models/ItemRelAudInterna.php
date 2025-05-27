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
 * Table class for item_rel_aud_interna
 */
class ItemRelAudInterna extends DbTable
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
    public $iditem_rel_aud_interna;
    public $dt_cadastro;
    public $processo_idprocesso;
    public $descricao;
    public $acao_imediata;
    public $acao_contecao;
    public $abrir_nc;
    public $relatorio_auditoria_interna_idrelatorio_auditoria_interna;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "item_rel_aud_interna";
        $this->TableName = 'item_rel_aud_interna';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "item_rel_aud_interna";
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

        // iditem_rel_aud_interna
        $this->iditem_rel_aud_interna = new DbField(
            $this, // Table
            'x_iditem_rel_aud_interna', // Variable name
            'iditem_rel_aud_interna', // Name
            '`iditem_rel_aud_interna`', // Expression
            '`iditem_rel_aud_interna`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`iditem_rel_aud_interna`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->iditem_rel_aud_interna->InputTextType = "text";
        $this->iditem_rel_aud_interna->Raw = true;
        $this->iditem_rel_aud_interna->IsAutoIncrement = true; // Autoincrement field
        $this->iditem_rel_aud_interna->IsPrimaryKey = true; // Primary key field
        $this->iditem_rel_aud_interna->Nullable = false; // NOT NULL field
        $this->iditem_rel_aud_interna->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->iditem_rel_aud_interna->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['iditem_rel_aud_interna'] = &$this->iditem_rel_aud_interna;

        // dt_cadastro
        $this->dt_cadastro = new DbField(
            $this, // Table
            'x_dt_cadastro', // Variable name
            'dt_cadastro', // Name
            '`dt_cadastro`', // Expression
            CastDateFieldForLike("`dt_cadastro`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`dt_cadastro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dt_cadastro->addMethod("getAutoUpdateValue", fn() => CurrentDate());
        $this->dt_cadastro->InputTextType = "text";
        $this->dt_cadastro->Raw = true;
        $this->dt_cadastro->Nullable = false; // NOT NULL field
        $this->dt_cadastro->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dt_cadastro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dt_cadastro'] = &$this->dt_cadastro;

        // processo_idprocesso
        $this->processo_idprocesso = new DbField(
            $this, // Table
            'x_processo_idprocesso', // Variable name
            'processo_idprocesso', // Name
            '`processo_idprocesso`', // Expression
            '`processo_idprocesso`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`processo_idprocesso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->processo_idprocesso->InputTextType = "text";
        $this->processo_idprocesso->Raw = true;
        $this->processo_idprocesso->Nullable = false; // NOT NULL field
        $this->processo_idprocesso->Required = true; // Required field
        $this->processo_idprocesso->setSelectMultiple(false); // Select one
        $this->processo_idprocesso->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->processo_idprocesso->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->processo_idprocesso->Lookup = new Lookup($this->processo_idprocesso, 'processo', false, 'idprocesso', ["processo","","",""], '', '', [], [], [], [], [], [], false, '`processo` ASC', '', "`processo`");
        $this->processo_idprocesso->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->processo_idprocesso->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['processo_idprocesso'] = &$this->processo_idprocesso;

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

        // acao_imediata
        $this->acao_imediata = new DbField(
            $this, // Table
            'x_acao_imediata', // Variable name
            'acao_imediata', // Name
            '`acao_imediata`', // Expression
            '`acao_imediata`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`acao_imediata`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->acao_imediata->InputTextType = "text";
        $this->acao_imediata->Nullable = false; // NOT NULL field
        $this->acao_imediata->Required = true; // Required field
        $this->acao_imediata->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['acao_imediata'] = &$this->acao_imediata;

        // acao_contecao
        $this->acao_contecao = new DbField(
            $this, // Table
            'x_acao_contecao', // Variable name
            'acao_contecao', // Name
            '`acao_contecao`', // Expression
            '`acao_contecao`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`acao_contecao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->acao_contecao->InputTextType = "text";
        $this->acao_contecao->Nullable = false; // NOT NULL field
        $this->acao_contecao->Required = true; // Required field
        $this->acao_contecao->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['acao_contecao'] = &$this->acao_contecao;

        // abrir_nc
        $this->abrir_nc = new DbField(
            $this, // Table
            'x_abrir_nc', // Variable name
            'abrir_nc', // Name
            '`abrir_nc`', // Expression
            '`abrir_nc`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`abrir_nc`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->abrir_nc->addMethod("getDefault", fn() => "Sim");
        $this->abrir_nc->InputTextType = "text";
        $this->abrir_nc->Raw = true;
        $this->abrir_nc->Nullable = false; // NOT NULL field
        $this->abrir_nc->Lookup = new Lookup($this->abrir_nc, 'item_rel_aud_interna', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->abrir_nc->OptionCount = 2;
        $this->abrir_nc->SearchOperators = ["=", "<>"];
        $this->Fields['abrir_nc'] = &$this->abrir_nc;

        // relatorio_auditoria_interna_idrelatorio_auditoria_interna
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna = new DbField(
            $this, // Table
            'x_relatorio_auditoria_interna_idrelatorio_auditoria_interna', // Variable name
            'relatorio_auditoria_interna_idrelatorio_auditoria_interna', // Name
            '`relatorio_auditoria_interna_idrelatorio_auditoria_interna`', // Expression
            '`relatorio_auditoria_interna_idrelatorio_auditoria_interna`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`relatorio_auditoria_interna_idrelatorio_auditoria_interna`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->InputTextType = "text";
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->Raw = true;
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->IsForeignKey = true; // Foreign key field
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->Nullable = false; // NOT NULL field
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->Required = true; // Required field
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['relatorio_auditoria_interna_idrelatorio_auditoria_interna'] = &$this->relatorio_auditoria_interna_idrelatorio_auditoria_interna;

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
        if ($this->getCurrentMasterTable() == "relatorio_auditoria_interna") {
            $masterTable = Container("relatorio_auditoria_interna");
            if ($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->idrelatorio_auditoria_interna, $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue(), $masterTable->idrelatorio_auditoria_interna->DataType, $masterTable->Dbid);
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
        if ($this->getCurrentMasterTable() == "relatorio_auditoria_interna") {
            $masterTable = Container("relatorio_auditoria_interna");
            if ($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna, $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue(), $masterTable->idrelatorio_auditoria_interna->DataType, $this->Dbid);
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
            case "relatorio_auditoria_interna":
                $key = $keys["relatorio_auditoria_interna_idrelatorio_auditoria_interna"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->idrelatorio_auditoria_interna->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->idrelatorio_auditoria_interna, $keys["relatorio_auditoria_interna_idrelatorio_auditoria_interna"], $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "relatorio_auditoria_interna":
                return GetKeyFilter($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna, $masterTable->idrelatorio_auditoria_interna->DbValue, $masterTable->idrelatorio_auditoria_interna->DataType, $masterTable->Dbid);
        }
        return "";
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "item_rel_aud_interna";
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
            $this->iditem_rel_aud_interna->setDbValue($conn->lastInsertId());
            $rs['iditem_rel_aud_interna'] = $this->iditem_rel_aud_interna->DbValue;
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
            if (!isset($rs['iditem_rel_aud_interna']) && !EmptyValue($this->iditem_rel_aud_interna->CurrentValue)) {
                $rs['iditem_rel_aud_interna'] = $this->iditem_rel_aud_interna->CurrentValue;
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
            if (array_key_exists('iditem_rel_aud_interna', $rs)) {
                AddFilter($where, QuotedName('iditem_rel_aud_interna', $this->Dbid) . '=' . QuotedValue($rs['iditem_rel_aud_interna'], $this->iditem_rel_aud_interna->DataType, $this->Dbid));
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
        $this->iditem_rel_aud_interna->DbValue = $row['iditem_rel_aud_interna'];
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->processo_idprocesso->DbValue = $row['processo_idprocesso'];
        $this->descricao->DbValue = $row['descricao'];
        $this->acao_imediata->DbValue = $row['acao_imediata'];
        $this->acao_contecao->DbValue = $row['acao_contecao'];
        $this->abrir_nc->DbValue = $row['abrir_nc'];
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->DbValue = $row['relatorio_auditoria_interna_idrelatorio_auditoria_interna'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`iditem_rel_aud_interna` = @iditem_rel_aud_interna@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->iditem_rel_aud_interna->CurrentValue : $this->iditem_rel_aud_interna->OldValue;
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
                $this->iditem_rel_aud_interna->CurrentValue = $keys[0];
            } else {
                $this->iditem_rel_aud_interna->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('iditem_rel_aud_interna', $row) ? $row['iditem_rel_aud_interna'] : null;
        } else {
            $val = !EmptyValue($this->iditem_rel_aud_interna->OldValue) && !$current ? $this->iditem_rel_aud_interna->OldValue : $this->iditem_rel_aud_interna->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@iditem_rel_aud_interna@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ItemRelAudInternaList");
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
            "ItemRelAudInternaView" => $Language->phrase("View"),
            "ItemRelAudInternaEdit" => $Language->phrase("Edit"),
            "ItemRelAudInternaAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ItemRelAudInternaList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ItemRelAudInternaView",
            Config("API_ADD_ACTION") => "ItemRelAudInternaAdd",
            Config("API_EDIT_ACTION") => "ItemRelAudInternaEdit",
            Config("API_DELETE_ACTION") => "ItemRelAudInternaDelete",
            Config("API_LIST_ACTION") => "ItemRelAudInternaList",
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
        return "ItemRelAudInternaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ItemRelAudInternaView", $parm);
        } else {
            $url = $this->keyUrl("ItemRelAudInternaView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ItemRelAudInternaAdd?" . $parm;
        } else {
            $url = "ItemRelAudInternaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ItemRelAudInternaEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ItemRelAudInternaList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ItemRelAudInternaAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ItemRelAudInternaList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ItemRelAudInternaDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "relatorio_auditoria_interna" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_idrelatorio_auditoria_interna", $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"iditem_rel_aud_interna\":" . VarToJson($this->iditem_rel_aud_interna->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->iditem_rel_aud_interna->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->iditem_rel_aud_interna->CurrentValue);
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
            if (($keyValue = Param("iditem_rel_aud_interna") ?? Route("iditem_rel_aud_interna")) !== null) {
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
                $this->iditem_rel_aud_interna->CurrentValue = $key;
            } else {
                $this->iditem_rel_aud_interna->OldValue = $key;
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
        $this->iditem_rel_aud_interna->setDbValue($row['iditem_rel_aud_interna']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->processo_idprocesso->setDbValue($row['processo_idprocesso']);
        $this->descricao->setDbValue($row['descricao']);
        $this->acao_imediata->setDbValue($row['acao_imediata']);
        $this->acao_contecao->setDbValue($row['acao_contecao']);
        $this->abrir_nc->setDbValue($row['abrir_nc']);
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->setDbValue($row['relatorio_auditoria_interna_idrelatorio_auditoria_interna']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ItemRelAudInternaList";
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

        // iditem_rel_aud_interna

        // dt_cadastro

        // processo_idprocesso

        // descricao

        // acao_imediata

        // acao_contecao

        // abrir_nc

        // relatorio_auditoria_interna_idrelatorio_auditoria_interna

        // iditem_rel_aud_interna
        $this->iditem_rel_aud_interna->ViewValue = $this->iditem_rel_aud_interna->CurrentValue;
        $this->iditem_rel_aud_interna->ViewValue = FormatNumber($this->iditem_rel_aud_interna->ViewValue, $this->iditem_rel_aud_interna->formatPattern());
        $this->iditem_rel_aud_interna->CssClass = "fw-bold";
        $this->iditem_rel_aud_interna->CellCssStyle .= "text-align: center;";

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->CssClass = "fw-bold";

        // processo_idprocesso
        $curVal = strval($this->processo_idprocesso->CurrentValue);
        if ($curVal != "") {
            $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->lookupCacheOption($curVal);
            if ($this->processo_idprocesso->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $curVal, $this->processo_idprocesso->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                $sqlWrk = $this->processo_idprocesso->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->processo_idprocesso->Lookup->renderViewRow($rswrk[0]);
                    $this->processo_idprocesso->ViewValue = $this->processo_idprocesso->displayValue($arwrk);
                } else {
                    $this->processo_idprocesso->ViewValue = FormatNumber($this->processo_idprocesso->CurrentValue, $this->processo_idprocesso->formatPattern());
                }
            }
        } else {
            $this->processo_idprocesso->ViewValue = null;
        }
        $this->processo_idprocesso->CssClass = "fw-bold";

        // descricao
        $this->descricao->ViewValue = $this->descricao->CurrentValue;
        $this->descricao->CssClass = "fw-bold";

        // acao_imediata
        $this->acao_imediata->ViewValue = $this->acao_imediata->CurrentValue;
        $this->acao_imediata->CssClass = "fw-bold";

        // acao_contecao
        $this->acao_contecao->ViewValue = $this->acao_contecao->CurrentValue;
        $this->acao_contecao->CssClass = "fw-bold";

        // abrir_nc
        if (strval($this->abrir_nc->CurrentValue) != "") {
            $this->abrir_nc->ViewValue = $this->abrir_nc->optionCaption($this->abrir_nc->CurrentValue);
        } else {
            $this->abrir_nc->ViewValue = null;
        }
        $this->abrir_nc->CssClass = "fw-bold";
        $this->abrir_nc->CellCssStyle .= "text-align: center;";

        // relatorio_auditoria_interna_idrelatorio_auditoria_interna
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->ViewValue = $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->CurrentValue;
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->ViewValue = FormatNumber($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->ViewValue, $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->formatPattern());
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->CssClass = "fw-bold";
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->CellCssStyle .= "text-align: center;";

        // iditem_rel_aud_interna
        $this->iditem_rel_aud_interna->HrefValue = "";
        $this->iditem_rel_aud_interna->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // processo_idprocesso
        $this->processo_idprocesso->HrefValue = "";
        $this->processo_idprocesso->TooltipValue = "";

        // descricao
        $this->descricao->HrefValue = "";
        $this->descricao->TooltipValue = "";

        // acao_imediata
        $this->acao_imediata->HrefValue = "";
        $this->acao_imediata->TooltipValue = "";

        // acao_contecao
        $this->acao_contecao->HrefValue = "";
        $this->acao_contecao->TooltipValue = "";

        // abrir_nc
        $this->abrir_nc->HrefValue = "";
        $this->abrir_nc->TooltipValue = "";

        // relatorio_auditoria_interna_idrelatorio_auditoria_interna
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->HrefValue = "";
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->TooltipValue = "";

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

        // iditem_rel_aud_interna
        $this->iditem_rel_aud_interna->setupEditAttributes();
        $this->iditem_rel_aud_interna->EditValue = $this->iditem_rel_aud_interna->CurrentValue;
        $this->iditem_rel_aud_interna->EditValue = FormatNumber($this->iditem_rel_aud_interna->EditValue, $this->iditem_rel_aud_interna->formatPattern());
        $this->iditem_rel_aud_interna->CssClass = "fw-bold";
        $this->iditem_rel_aud_interna->CellCssStyle .= "text-align: center;";

        // dt_cadastro

        // processo_idprocesso
        $this->processo_idprocesso->setupEditAttributes();
        $this->processo_idprocesso->PlaceHolder = RemoveHtml($this->processo_idprocesso->caption());

        // descricao
        $this->descricao->setupEditAttributes();
        $this->descricao->EditValue = $this->descricao->CurrentValue;
        $this->descricao->PlaceHolder = RemoveHtml($this->descricao->caption());

        // acao_imediata
        $this->acao_imediata->setupEditAttributes();
        $this->acao_imediata->EditValue = $this->acao_imediata->CurrentValue;
        $this->acao_imediata->PlaceHolder = RemoveHtml($this->acao_imediata->caption());

        // acao_contecao
        $this->acao_contecao->setupEditAttributes();
        $this->acao_contecao->EditValue = $this->acao_contecao->CurrentValue;
        $this->acao_contecao->PlaceHolder = RemoveHtml($this->acao_contecao->caption());

        // abrir_nc
        $this->abrir_nc->EditValue = $this->abrir_nc->options(false);
        $this->abrir_nc->PlaceHolder = RemoveHtml($this->abrir_nc->caption());

        // relatorio_auditoria_interna_idrelatorio_auditoria_interna
        $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->setupEditAttributes();
        if ($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue() != "") {
            $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->CurrentValue = GetForeignKeyValue($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue());
            $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->ViewValue = $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->CurrentValue;
            $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->ViewValue = FormatNumber($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->ViewValue, $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->formatPattern());
            $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->CssClass = "fw-bold";
            $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->CellCssStyle .= "text-align: center;";
        } else {
            $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->EditValue = $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->CurrentValue;
            $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->PlaceHolder = RemoveHtml($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->caption());
            if (strval($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->EditValue) != "" && is_numeric($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->EditValue)) {
                $this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->EditValue = FormatNumber($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna->EditValue, null);
            }
        }

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
                    $doc->exportCaption($this->iditem_rel_aud_interna);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->processo_idprocesso);
                    $doc->exportCaption($this->descricao);
                    $doc->exportCaption($this->acao_imediata);
                    $doc->exportCaption($this->acao_contecao);
                    $doc->exportCaption($this->abrir_nc);
                    $doc->exportCaption($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna);
                } else {
                    $doc->exportCaption($this->processo_idprocesso);
                    $doc->exportCaption($this->descricao);
                    $doc->exportCaption($this->acao_imediata);
                    $doc->exportCaption($this->acao_contecao);
                    $doc->exportCaption($this->abrir_nc);
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
                        $doc->exportField($this->iditem_rel_aud_interna);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->processo_idprocesso);
                        $doc->exportField($this->descricao);
                        $doc->exportField($this->acao_imediata);
                        $doc->exportField($this->acao_contecao);
                        $doc->exportField($this->abrir_nc);
                        $doc->exportField($this->relatorio_auditoria_interna_idrelatorio_auditoria_interna);
                    } else {
                        $doc->exportField($this->processo_idprocesso);
                        $doc->exportField($this->descricao);
                        $doc->exportField($this->acao_imediata);
                        $doc->exportField($this->acao_contecao);
                        $doc->exportField($this->abrir_nc);
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
