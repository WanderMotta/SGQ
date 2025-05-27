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
 * Table class for documento_externo
 */
class DocumentoExterno extends DbTable
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
    public $iddocumento_externo;
    public $dt_cadastro;
    public $titulo_documento;
    public $distribuicao;
    public $tem_validade;
    public $valido_ate;
    public $restringir_acesso;
    public $localizacao_idlocalizacao;
    public $usuario_responsavel;
    public $anexo;
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
        $this->TableVar = "documento_externo";
        $this->TableName = 'documento_externo';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "documento_externo";
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
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // iddocumento_externo
        $this->iddocumento_externo = new DbField(
            $this, // Table
            'x_iddocumento_externo', // Variable name
            'iddocumento_externo', // Name
            '`iddocumento_externo`', // Expression
            '`iddocumento_externo`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`iddocumento_externo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->iddocumento_externo->InputTextType = "text";
        $this->iddocumento_externo->Raw = true;
        $this->iddocumento_externo->IsAutoIncrement = true; // Autoincrement field
        $this->iddocumento_externo->IsPrimaryKey = true; // Primary key field
        $this->iddocumento_externo->Nullable = false; // NOT NULL field
        $this->iddocumento_externo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->iddocumento_externo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['iddocumento_externo'] = &$this->iddocumento_externo;

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

        // titulo_documento
        $this->titulo_documento = new DbField(
            $this, // Table
            'x_titulo_documento', // Variable name
            'titulo_documento', // Name
            '`titulo_documento`', // Expression
            '`titulo_documento`', // Basic search expression
            200, // Type
            120, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`titulo_documento`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->titulo_documento->InputTextType = "text";
        $this->titulo_documento->Nullable = false; // NOT NULL field
        $this->titulo_documento->Required = true; // Required field
        $this->titulo_documento->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['titulo_documento'] = &$this->titulo_documento;

        // distribuicao
        $this->distribuicao = new DbField(
            $this, // Table
            'x_distribuicao', // Variable name
            'distribuicao', // Name
            '`distribuicao`', // Expression
            '`distribuicao`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`distribuicao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->distribuicao->addMethod("getDefault", fn() => "Eletronica");
        $this->distribuicao->InputTextType = "text";
        $this->distribuicao->Raw = true;
        $this->distribuicao->Nullable = false; // NOT NULL field
        $this->distribuicao->Required = true; // Required field
        $this->distribuicao->Lookup = new Lookup($this->distribuicao, 'documento_externo', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->distribuicao->OptionCount = 2;
        $this->distribuicao->SearchOperators = ["=", "<>"];
        $this->Fields['distribuicao'] = &$this->distribuicao;

        // tem_validade
        $this->tem_validade = new DbField(
            $this, // Table
            'x_tem_validade', // Variable name
            'tem_validade', // Name
            '`tem_validade`', // Expression
            '`tem_validade`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tem_validade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->tem_validade->addMethod("getDefault", fn() => "Nao");
        $this->tem_validade->InputTextType = "text";
        $this->tem_validade->Raw = true;
        $this->tem_validade->Nullable = false; // NOT NULL field
        $this->tem_validade->Required = true; // Required field
        $this->tem_validade->Lookup = new Lookup($this->tem_validade, 'documento_externo', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->tem_validade->OptionCount = 2;
        $this->tem_validade->SearchOperators = ["=", "<>"];
        $this->Fields['tem_validade'] = &$this->tem_validade;

        // valido_ate
        $this->valido_ate = new DbField(
            $this, // Table
            'x_valido_ate', // Variable name
            'valido_ate', // Name
            '`valido_ate`', // Expression
            CastDateFieldForLike("`valido_ate`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`valido_ate`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->valido_ate->InputTextType = "text";
        $this->valido_ate->Raw = true;
        $this->valido_ate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->valido_ate->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['valido_ate'] = &$this->valido_ate;

        // restringir_acesso
        $this->restringir_acesso = new DbField(
            $this, // Table
            'x_restringir_acesso', // Variable name
            'restringir_acesso', // Name
            '`restringir_acesso`', // Expression
            '`restringir_acesso`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`restringir_acesso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->restringir_acesso->addMethod("getDefault", fn() => "Sim");
        $this->restringir_acesso->InputTextType = "text";
        $this->restringir_acesso->Raw = true;
        $this->restringir_acesso->Nullable = false; // NOT NULL field
        $this->restringir_acesso->Required = true; // Required field
        $this->restringir_acesso->Lookup = new Lookup($this->restringir_acesso, 'documento_externo', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->restringir_acesso->OptionCount = 2;
        $this->restringir_acesso->SearchOperators = ["=", "<>"];
        $this->Fields['restringir_acesso'] = &$this->restringir_acesso;

        // localizacao_idlocalizacao
        $this->localizacao_idlocalizacao = new DbField(
            $this, // Table
            'x_localizacao_idlocalizacao', // Variable name
            'localizacao_idlocalizacao', // Name
            '`localizacao_idlocalizacao`', // Expression
            '`localizacao_idlocalizacao`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`localizacao_idlocalizacao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->localizacao_idlocalizacao->InputTextType = "text";
        $this->localizacao_idlocalizacao->Raw = true;
        $this->localizacao_idlocalizacao->Nullable = false; // NOT NULL field
        $this->localizacao_idlocalizacao->Required = true; // Required field
        $this->localizacao_idlocalizacao->Lookup = new Lookup($this->localizacao_idlocalizacao, 'localizacao', false, 'idlocalizacao', ["localizacao","","",""], '', '', [], [], [], [], [], [], false, '', '', "`localizacao`");
        $this->localizacao_idlocalizacao->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->localizacao_idlocalizacao->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['localizacao_idlocalizacao'] = &$this->localizacao_idlocalizacao;

        // usuario_responsavel
        $this->usuario_responsavel = new DbField(
            $this, // Table
            'x_usuario_responsavel', // Variable name
            'usuario_responsavel', // Name
            '`usuario_responsavel`', // Expression
            '`usuario_responsavel`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`usuario_responsavel`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->usuario_responsavel->InputTextType = "text";
        $this->usuario_responsavel->Raw = true;
        $this->usuario_responsavel->Nullable = false; // NOT NULL field
        $this->usuario_responsavel->Required = true; // Required field
        $this->usuario_responsavel->setSelectMultiple(false); // Select one
        $this->usuario_responsavel->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->usuario_responsavel->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->usuario_responsavel->Lookup = new Lookup($this->usuario_responsavel, 'usuario', false, 'idusuario', ["login","","",""], '', '', [], [], [], [], [], [], false, '', '', "`login`");
        $this->usuario_responsavel->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuario_responsavel->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['usuario_responsavel'] = &$this->usuario_responsavel;

        // anexo
        $this->anexo = new DbField(
            $this, // Table
            'x_anexo', // Variable name
            'anexo', // Name
            '`anexo`', // Expression
            '`anexo`', // Basic search expression
            200, // Type
            120, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`anexo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'FILE' // Edit Tag
        );
        $this->anexo->addMethod("getLinkPrefix", fn() => "file:///");
        $this->anexo->InputTextType = "text";
        $this->anexo->Nullable = false; // NOT NULL field
        $this->anexo->Required = true; // Required field
        $this->anexo->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['anexo'] = &$this->anexo;

        // obs
        $this->obs = new DbField(
            $this, // Table
            'x_obs', // Variable name
            'obs', // Name
            '`obs`', // Expression
            '`obs`', // Basic search expression
            200, // Type
            120, // Size
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "documento_externo";
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
            $this->iddocumento_externo->setDbValue($conn->lastInsertId());
            $rs['iddocumento_externo'] = $this->iddocumento_externo->DbValue;
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
            if (!isset($rs['iddocumento_externo']) && !EmptyValue($this->iddocumento_externo->CurrentValue)) {
                $rs['iddocumento_externo'] = $this->iddocumento_externo->CurrentValue;
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
            if (array_key_exists('iddocumento_externo', $rs)) {
                AddFilter($where, QuotedName('iddocumento_externo', $this->Dbid) . '=' . QuotedValue($rs['iddocumento_externo'], $this->iddocumento_externo->DataType, $this->Dbid));
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
        $this->iddocumento_externo->DbValue = $row['iddocumento_externo'];
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->titulo_documento->DbValue = $row['titulo_documento'];
        $this->distribuicao->DbValue = $row['distribuicao'];
        $this->tem_validade->DbValue = $row['tem_validade'];
        $this->valido_ate->DbValue = $row['valido_ate'];
        $this->restringir_acesso->DbValue = $row['restringir_acesso'];
        $this->localizacao_idlocalizacao->DbValue = $row['localizacao_idlocalizacao'];
        $this->usuario_responsavel->DbValue = $row['usuario_responsavel'];
        $this->anexo->Upload->DbValue = $row['anexo'];
        $this->obs->DbValue = $row['obs'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['anexo']) ? [] : [$row['anexo']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->anexo->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->anexo->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`iddocumento_externo` = @iddocumento_externo@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->iddocumento_externo->CurrentValue : $this->iddocumento_externo->OldValue;
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
                $this->iddocumento_externo->CurrentValue = $keys[0];
            } else {
                $this->iddocumento_externo->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('iddocumento_externo', $row) ? $row['iddocumento_externo'] : null;
        } else {
            $val = !EmptyValue($this->iddocumento_externo->OldValue) && !$current ? $this->iddocumento_externo->OldValue : $this->iddocumento_externo->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@iddocumento_externo@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("DocumentoExternoList");
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
            "DocumentoExternoView" => $Language->phrase("View"),
            "DocumentoExternoEdit" => $Language->phrase("Edit"),
            "DocumentoExternoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "DocumentoExternoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "DocumentoExternoView",
            Config("API_ADD_ACTION") => "DocumentoExternoAdd",
            Config("API_EDIT_ACTION") => "DocumentoExternoEdit",
            Config("API_DELETE_ACTION") => "DocumentoExternoDelete",
            Config("API_LIST_ACTION") => "DocumentoExternoList",
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
        return "DocumentoExternoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("DocumentoExternoView", $parm);
        } else {
            $url = $this->keyUrl("DocumentoExternoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "DocumentoExternoAdd?" . $parm;
        } else {
            $url = "DocumentoExternoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("DocumentoExternoEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("DocumentoExternoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("DocumentoExternoAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("DocumentoExternoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("DocumentoExternoDelete", $parm);
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
        $json .= "\"iddocumento_externo\":" . VarToJson($this->iddocumento_externo->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->iddocumento_externo->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->iddocumento_externo->CurrentValue);
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
            if (($keyValue = Param("iddocumento_externo") ?? Route("iddocumento_externo")) !== null) {
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
                $this->iddocumento_externo->CurrentValue = $key;
            } else {
                $this->iddocumento_externo->OldValue = $key;
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
        $this->iddocumento_externo->setDbValue($row['iddocumento_externo']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->titulo_documento->setDbValue($row['titulo_documento']);
        $this->distribuicao->setDbValue($row['distribuicao']);
        $this->tem_validade->setDbValue($row['tem_validade']);
        $this->valido_ate->setDbValue($row['valido_ate']);
        $this->restringir_acesso->setDbValue($row['restringir_acesso']);
        $this->localizacao_idlocalizacao->setDbValue($row['localizacao_idlocalizacao']);
        $this->usuario_responsavel->setDbValue($row['usuario_responsavel']);
        $this->anexo->Upload->DbValue = $row['anexo'];
        $this->obs->setDbValue($row['obs']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "DocumentoExternoList";
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

        // iddocumento_externo

        // dt_cadastro

        // titulo_documento

        // distribuicao

        // tem_validade

        // valido_ate

        // restringir_acesso

        // localizacao_idlocalizacao

        // usuario_responsavel

        // anexo

        // obs

        // iddocumento_externo
        $this->iddocumento_externo->ViewValue = $this->iddocumento_externo->CurrentValue;
        $this->iddocumento_externo->CssClass = "fw-bold";
        $this->iddocumento_externo->CellCssStyle .= "text-align: center;";

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->CssClass = "fw-bold";

        // titulo_documento
        $this->titulo_documento->ViewValue = $this->titulo_documento->CurrentValue;
        $this->titulo_documento->CssClass = "fw-bold";

        // distribuicao
        if (strval($this->distribuicao->CurrentValue) != "") {
            $this->distribuicao->ViewValue = $this->distribuicao->optionCaption($this->distribuicao->CurrentValue);
        } else {
            $this->distribuicao->ViewValue = null;
        }
        $this->distribuicao->CssClass = "fw-bold";

        // tem_validade
        if (strval($this->tem_validade->CurrentValue) != "") {
            $this->tem_validade->ViewValue = $this->tem_validade->optionCaption($this->tem_validade->CurrentValue);
        } else {
            $this->tem_validade->ViewValue = null;
        }
        $this->tem_validade->CssClass = "fw-bold";
        $this->tem_validade->CellCssStyle .= "text-align: center;";

        // valido_ate
        $this->valido_ate->ViewValue = $this->valido_ate->CurrentValue;
        $this->valido_ate->ViewValue = FormatDateTime($this->valido_ate->ViewValue, $this->valido_ate->formatPattern());
        $this->valido_ate->CssClass = "fw-bold";

        // restringir_acesso
        if (strval($this->restringir_acesso->CurrentValue) != "") {
            $this->restringir_acesso->ViewValue = $this->restringir_acesso->optionCaption($this->restringir_acesso->CurrentValue);
        } else {
            $this->restringir_acesso->ViewValue = null;
        }
        $this->restringir_acesso->CssClass = "fw-bold";
        $this->restringir_acesso->CellCssStyle .= "text-align: center;";

        // localizacao_idlocalizacao
        $curVal = strval($this->localizacao_idlocalizacao->CurrentValue);
        if ($curVal != "") {
            $this->localizacao_idlocalizacao->ViewValue = $this->localizacao_idlocalizacao->lookupCacheOption($curVal);
            if ($this->localizacao_idlocalizacao->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->localizacao_idlocalizacao->Lookup->getTable()->Fields["idlocalizacao"]->searchExpression(), "=", $curVal, $this->localizacao_idlocalizacao->Lookup->getTable()->Fields["idlocalizacao"]->searchDataType(), "");
                $sqlWrk = $this->localizacao_idlocalizacao->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->localizacao_idlocalizacao->Lookup->renderViewRow($rswrk[0]);
                    $this->localizacao_idlocalizacao->ViewValue = $this->localizacao_idlocalizacao->displayValue($arwrk);
                } else {
                    $this->localizacao_idlocalizacao->ViewValue = FormatNumber($this->localizacao_idlocalizacao->CurrentValue, $this->localizacao_idlocalizacao->formatPattern());
                }
            }
        } else {
            $this->localizacao_idlocalizacao->ViewValue = null;
        }
        $this->localizacao_idlocalizacao->CssClass = "fw-bold";

        // usuario_responsavel
        $curVal = strval($this->usuario_responsavel->CurrentValue);
        if ($curVal != "") {
            $this->usuario_responsavel->ViewValue = $this->usuario_responsavel->lookupCacheOption($curVal);
            if ($this->usuario_responsavel->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->usuario_responsavel->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->usuario_responsavel->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                $sqlWrk = $this->usuario_responsavel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->usuario_responsavel->Lookup->renderViewRow($rswrk[0]);
                    $this->usuario_responsavel->ViewValue = $this->usuario_responsavel->displayValue($arwrk);
                } else {
                    $this->usuario_responsavel->ViewValue = FormatNumber($this->usuario_responsavel->CurrentValue, $this->usuario_responsavel->formatPattern());
                }
            }
        } else {
            $this->usuario_responsavel->ViewValue = null;
        }
        $this->usuario_responsavel->CssClass = "fw-bold";

        // anexo
        if (!EmptyValue($this->anexo->Upload->DbValue)) {
            $this->anexo->ViewValue = $this->anexo->Upload->DbValue;
        } else {
            $this->anexo->ViewValue = "";
        }
        $this->anexo->CssClass = "fw-bold";

        // obs
        $this->obs->ViewValue = $this->obs->CurrentValue;
        $this->obs->CssClass = "fw-bold";

        // iddocumento_externo
        $this->iddocumento_externo->HrefValue = "";
        $this->iddocumento_externo->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // titulo_documento
        $this->titulo_documento->HrefValue = "";
        $this->titulo_documento->TooltipValue = "";

        // distribuicao
        $this->distribuicao->HrefValue = "";
        $this->distribuicao->TooltipValue = "";

        // tem_validade
        $this->tem_validade->HrefValue = "";
        $this->tem_validade->TooltipValue = "";

        // valido_ate
        $this->valido_ate->HrefValue = "";
        $this->valido_ate->TooltipValue = "";

        // restringir_acesso
        $this->restringir_acesso->HrefValue = "";
        $this->restringir_acesso->TooltipValue = "";

        // localizacao_idlocalizacao
        $this->localizacao_idlocalizacao->HrefValue = "";
        $this->localizacao_idlocalizacao->TooltipValue = "";

        // usuario_responsavel
        $this->usuario_responsavel->HrefValue = "";
        $this->usuario_responsavel->TooltipValue = "";

        // anexo
        if (!EmptyValue($this->anexo->Upload->DbValue)) {
            $this->anexo->HrefValue = $this->anexo->getLinkPrefix() . GetFileUploadUrl($this->anexo, $this->anexo->htmlDecode($this->anexo->Upload->DbValue)); // Add prefix/suffix
            $this->anexo->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->anexo->HrefValue = FullUrl($this->anexo->HrefValue, "href");
            }
        } else {
            $this->anexo->HrefValue = "";
        }
        $this->anexo->ExportHrefValue = $this->anexo->UploadPath . $this->anexo->Upload->DbValue;
        $this->anexo->TooltipValue = "";

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

        // iddocumento_externo
        $this->iddocumento_externo->setupEditAttributes();
        $this->iddocumento_externo->EditValue = $this->iddocumento_externo->CurrentValue;
        $this->iddocumento_externo->CssClass = "fw-bold";
        $this->iddocumento_externo->CellCssStyle .= "text-align: center;";

        // dt_cadastro

        // titulo_documento
        $this->titulo_documento->setupEditAttributes();
        if (!$this->titulo_documento->Raw) {
            $this->titulo_documento->CurrentValue = HtmlDecode($this->titulo_documento->CurrentValue);
        }
        $this->titulo_documento->EditValue = $this->titulo_documento->CurrentValue;
        $this->titulo_documento->PlaceHolder = RemoveHtml($this->titulo_documento->caption());

        // distribuicao
        $this->distribuicao->EditValue = $this->distribuicao->options(false);
        $this->distribuicao->PlaceHolder = RemoveHtml($this->distribuicao->caption());

        // tem_validade
        $this->tem_validade->EditValue = $this->tem_validade->options(false);
        $this->tem_validade->PlaceHolder = RemoveHtml($this->tem_validade->caption());

        // valido_ate
        $this->valido_ate->setupEditAttributes();
        $this->valido_ate->EditValue = FormatDateTime($this->valido_ate->CurrentValue, $this->valido_ate->formatPattern());
        $this->valido_ate->PlaceHolder = RemoveHtml($this->valido_ate->caption());

        // restringir_acesso
        $this->restringir_acesso->EditValue = $this->restringir_acesso->options(false);
        $this->restringir_acesso->PlaceHolder = RemoveHtml($this->restringir_acesso->caption());

        // localizacao_idlocalizacao
        $this->localizacao_idlocalizacao->PlaceHolder = RemoveHtml($this->localizacao_idlocalizacao->caption());

        // usuario_responsavel
        $this->usuario_responsavel->setupEditAttributes();
        $this->usuario_responsavel->PlaceHolder = RemoveHtml($this->usuario_responsavel->caption());

        // anexo
        $this->anexo->setupEditAttributes();
        if (!EmptyValue($this->anexo->Upload->DbValue)) {
            $this->anexo->EditValue = $this->anexo->Upload->DbValue;
        } else {
            $this->anexo->EditValue = "";
        }
        if (!EmptyValue($this->anexo->CurrentValue)) {
            $this->anexo->Upload->FileName = $this->anexo->CurrentValue;
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
            $this->titulo_documento->Count++; // Increment count
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->titulo_documento->CurrentValue = $this->titulo_documento->Count;
            $this->titulo_documento->ViewValue = $this->titulo_documento->CurrentValue;
            $this->titulo_documento->CssClass = "fw-bold";
            $this->titulo_documento->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->iddocumento_externo);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->titulo_documento);
                    $doc->exportCaption($this->distribuicao);
                    $doc->exportCaption($this->tem_validade);
                    $doc->exportCaption($this->valido_ate);
                    $doc->exportCaption($this->restringir_acesso);
                    $doc->exportCaption($this->localizacao_idlocalizacao);
                    $doc->exportCaption($this->usuario_responsavel);
                    $doc->exportCaption($this->anexo);
                    $doc->exportCaption($this->obs);
                } else {
                    $doc->exportCaption($this->iddocumento_externo);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->titulo_documento);
                    $doc->exportCaption($this->distribuicao);
                    $doc->exportCaption($this->tem_validade);
                    $doc->exportCaption($this->valido_ate);
                    $doc->exportCaption($this->restringir_acesso);
                    $doc->exportCaption($this->localizacao_idlocalizacao);
                    $doc->exportCaption($this->usuario_responsavel);
                    $doc->exportCaption($this->anexo);
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
                $this->aggregateListRowValues(); // Aggregate row values

                // Render row
                $this->RowType = RowType::VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->iddocumento_externo);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->titulo_documento);
                        $doc->exportField($this->distribuicao);
                        $doc->exportField($this->tem_validade);
                        $doc->exportField($this->valido_ate);
                        $doc->exportField($this->restringir_acesso);
                        $doc->exportField($this->localizacao_idlocalizacao);
                        $doc->exportField($this->usuario_responsavel);
                        $doc->exportField($this->anexo);
                        $doc->exportField($this->obs);
                    } else {
                        $doc->exportField($this->iddocumento_externo);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->titulo_documento);
                        $doc->exportField($this->distribuicao);
                        $doc->exportField($this->tem_validade);
                        $doc->exportField($this->valido_ate);
                        $doc->exportField($this->restringir_acesso);
                        $doc->exportField($this->localizacao_idlocalizacao);
                        $doc->exportField($this->usuario_responsavel);
                        $doc->exportField($this->anexo);
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

        // Export aggregates (horizontal format only)
        if ($doc->Horizontal) {
            $this->RowType = RowType::AGGREGATE;
            $this->resetAttributes();
            $this->aggregateListRow();
            if (!$doc->ExportCustom) {
                $doc->beginExportRow(-1);
                $doc->exportAggregate($this->iddocumento_externo, '');
                $doc->exportAggregate($this->dt_cadastro, '');
                $doc->exportAggregate($this->titulo_documento, 'COUNT');
                $doc->exportAggregate($this->distribuicao, '');
                $doc->exportAggregate($this->tem_validade, '');
                $doc->exportAggregate($this->valido_ate, '');
                $doc->exportAggregate($this->restringir_acesso, '');
                $doc->exportAggregate($this->localizacao_idlocalizacao, '');
                $doc->exportAggregate($this->usuario_responsavel, '');
                $doc->exportAggregate($this->anexo, '');
                $doc->exportAggregate($this->obs, '');
                $doc->endExportRow();
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
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'anexo') {
            $fldName = "anexo";
            $fileNameFld = "anexo";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->iddocumento_externo->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssociative($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DataType::BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower($pathinfo["extension"] ?? "");
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment" . ($DownloadFileName ? "; filename=\"" . $DownloadFileName . "\"" : ""));
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    if ($fld->hasMethod("getUploadPath")) { // Check field level upload path
                        $fld->UploadPath = $fld->getUploadPath();
                    }
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
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
