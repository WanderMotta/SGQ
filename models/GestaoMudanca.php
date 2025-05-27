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
 * Table class for gestao_mudanca
 */
class GestaoMudanca extends DbTable
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
    public $idgestao_mudanca;
    public $dt_cadastro;
    public $titulo;
    public $dt_inicio;
    public $detalhamento;
    public $impacto;
    public $motivo;
    public $recursos;
    public $prazo_ate;
    public $departamentos_iddepartamentos;
    public $usuario_idusuario;
    public $implementado;
    public $status;
    public $eficaz;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "gestao_mudanca";
        $this->TableName = 'gestao_mudanca';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "gestao_mudanca";
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

        // idgestao_mudanca
        $this->idgestao_mudanca = new DbField(
            $this, // Table
            'x_idgestao_mudanca', // Variable name
            'idgestao_mudanca', // Name
            '`idgestao_mudanca`', // Expression
            '`idgestao_mudanca`', // Basic search expression
            19, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idgestao_mudanca`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idgestao_mudanca->InputTextType = "text";
        $this->idgestao_mudanca->Raw = true;
        $this->idgestao_mudanca->IsAutoIncrement = true; // Autoincrement field
        $this->idgestao_mudanca->IsPrimaryKey = true; // Primary key field
        $this->idgestao_mudanca->Nullable = false; // NOT NULL field
        $this->idgestao_mudanca->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idgestao_mudanca->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idgestao_mudanca'] = &$this->idgestao_mudanca;

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

        // titulo
        $this->titulo = new DbField(
            $this, // Table
            'x_titulo', // Variable name
            'titulo', // Name
            '`titulo`', // Expression
            '`titulo`', // Basic search expression
            200, // Type
            120, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`titulo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->titulo->InputTextType = "text";
        $this->titulo->Nullable = false; // NOT NULL field
        $this->titulo->Required = true; // Required field
        $this->titulo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['titulo'] = &$this->titulo;

        // dt_inicio
        $this->dt_inicio = new DbField(
            $this, // Table
            'x_dt_inicio', // Variable name
            'dt_inicio', // Name
            '`dt_inicio`', // Expression
            CastDateFieldForLike("`dt_inicio`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`dt_inicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dt_inicio->InputTextType = "text";
        $this->dt_inicio->Raw = true;
        $this->dt_inicio->Nullable = false; // NOT NULL field
        $this->dt_inicio->Required = true; // Required field
        $this->dt_inicio->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dt_inicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dt_inicio'] = &$this->dt_inicio;

        // detalhamento
        $this->detalhamento = new DbField(
            $this, // Table
            'x_detalhamento', // Variable name
            'detalhamento', // Name
            '`detalhamento`', // Expression
            '`detalhamento`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`detalhamento`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->detalhamento->InputTextType = "text";
        $this->detalhamento->Nullable = false; // NOT NULL field
        $this->detalhamento->Required = true; // Required field
        $this->detalhamento->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['detalhamento'] = &$this->detalhamento;

        // impacto
        $this->impacto = new DbField(
            $this, // Table
            'x_impacto', // Variable name
            'impacto', // Name
            '`impacto`', // Expression
            '`impacto`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`impacto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->impacto->InputTextType = "text";
        $this->impacto->Nullable = false; // NOT NULL field
        $this->impacto->Required = true; // Required field
        $this->impacto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['impacto'] = &$this->impacto;

        // motivo
        $this->motivo = new DbField(
            $this, // Table
            'x_motivo', // Variable name
            'motivo', // Name
            '`motivo`', // Expression
            '`motivo`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`motivo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->motivo->InputTextType = "text";
        $this->motivo->Nullable = false; // NOT NULL field
        $this->motivo->Required = true; // Required field
        $this->motivo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['motivo'] = &$this->motivo;

        // recursos
        $this->recursos = new DbField(
            $this, // Table
            'x_recursos', // Variable name
            'recursos', // Name
            '`recursos`', // Expression
            '`recursos`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`recursos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->recursos->addMethod("getDefault", fn() => 0.00);
        $this->recursos->InputTextType = "text";
        $this->recursos->Raw = true;
        $this->recursos->Nullable = false; // NOT NULL field
        $this->recursos->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->recursos->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['recursos'] = &$this->recursos;

        // prazo_ate
        $this->prazo_ate = new DbField(
            $this, // Table
            'x_prazo_ate', // Variable name
            'prazo_ate', // Name
            '`prazo_ate`', // Expression
            CastDateFieldForLike("`prazo_ate`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`prazo_ate`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->prazo_ate->InputTextType = "text";
        $this->prazo_ate->Raw = true;
        $this->prazo_ate->Nullable = false; // NOT NULL field
        $this->prazo_ate->Required = true; // Required field
        $this->prazo_ate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->prazo_ate->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['prazo_ate'] = &$this->prazo_ate;

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos = new DbField(
            $this, // Table
            'x_departamentos_iddepartamentos', // Variable name
            'departamentos_iddepartamentos', // Name
            '`departamentos_iddepartamentos`', // Expression
            '`departamentos_iddepartamentos`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`departamentos_iddepartamentos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->departamentos_iddepartamentos->InputTextType = "text";
        $this->departamentos_iddepartamentos->Raw = true;
        $this->departamentos_iddepartamentos->Nullable = false; // NOT NULL field
        $this->departamentos_iddepartamentos->Required = true; // Required field
        $this->departamentos_iddepartamentos->setSelectMultiple(false); // Select one
        $this->departamentos_iddepartamentos->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->departamentos_iddepartamentos->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->departamentos_iddepartamentos->UseFilter = true; // Table header filter
        $this->departamentos_iddepartamentos->Lookup = new Lookup($this->departamentos_iddepartamentos, 'departamentos', true, 'iddepartamentos', ["departamento","","",""], '', '', [], [], [], [], [], [], false, '`departamento` ASC', '', "`departamento`");
        $this->departamentos_iddepartamentos->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->departamentos_iddepartamentos->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['departamentos_iddepartamentos'] = &$this->departamentos_iddepartamentos;

        // usuario_idusuario
        $this->usuario_idusuario = new DbField(
            $this, // Table
            'x_usuario_idusuario', // Variable name
            'usuario_idusuario', // Name
            '`usuario_idusuario`', // Expression
            '`usuario_idusuario`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`usuario_idusuario`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->usuario_idusuario->InputTextType = "text";
        $this->usuario_idusuario->Raw = true;
        $this->usuario_idusuario->Nullable = false; // NOT NULL field
        $this->usuario_idusuario->Required = true; // Required field
        $this->usuario_idusuario->setSelectMultiple(false); // Select one
        $this->usuario_idusuario->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->usuario_idusuario->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->usuario_idusuario->Lookup = new Lookup($this->usuario_idusuario, 'usuario', false, 'idusuario', ["nome","","",""], '', '', [], [], [], [], [], [], false, '`nome` ASC', '', "`nome`");
        $this->usuario_idusuario->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuario_idusuario->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['usuario_idusuario'] = &$this->usuario_idusuario;

        // implementado
        $this->implementado = new DbField(
            $this, // Table
            'x_implementado', // Variable name
            'implementado', // Name
            '`implementado`', // Expression
            '`implementado`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`implementado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->implementado->addMethod("getDefault", fn() => "Sim");
        $this->implementado->InputTextType = "text";
        $this->implementado->Raw = true;
        $this->implementado->Nullable = false; // NOT NULL field
        $this->implementado->Lookup = new Lookup($this->implementado, 'gestao_mudanca', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->implementado->OptionCount = 2;
        $this->implementado->SearchOperators = ["=", "<>"];
        $this->Fields['implementado'] = &$this->implementado;

        // status
        $this->status = new DbField(
            $this, // Table
            'x_status', // Variable name
            'status', // Name
            '`status`', // Expression
            '`status`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`status`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->status->addMethod("getDefault", fn() => 1);
        $this->status->InputTextType = "text";
        $this->status->Raw = true;
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Lookup = new Lookup($this->status, 'gestao_mudanca', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->status->OptionCount = 3;
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->status->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['status'] = &$this->status;

        // eficaz
        $this->eficaz = new DbField(
            $this, // Table
            'x_eficaz', // Variable name
            'eficaz', // Name
            '`eficaz`', // Expression
            '`eficaz`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`eficaz`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->eficaz->addMethod("getDefault", fn() => "Sim");
        $this->eficaz->InputTextType = "text";
        $this->eficaz->Raw = true;
        $this->eficaz->Nullable = false; // NOT NULL field
        $this->eficaz->Lookup = new Lookup($this->eficaz, 'gestao_mudanca', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->eficaz->OptionCount = 2;
        $this->eficaz->SearchOperators = ["=", "<>"];
        $this->Fields['eficaz'] = &$this->eficaz;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "gestao_mudanca";
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
            $this->idgestao_mudanca->setDbValue($conn->lastInsertId());
            $rs['idgestao_mudanca'] = $this->idgestao_mudanca->DbValue;
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
            if (!isset($rs['idgestao_mudanca']) && !EmptyValue($this->idgestao_mudanca->CurrentValue)) {
                $rs['idgestao_mudanca'] = $this->idgestao_mudanca->CurrentValue;
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
            if (array_key_exists('idgestao_mudanca', $rs)) {
                AddFilter($where, QuotedName('idgestao_mudanca', $this->Dbid) . '=' . QuotedValue($rs['idgestao_mudanca'], $this->idgestao_mudanca->DataType, $this->Dbid));
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
        $this->idgestao_mudanca->DbValue = $row['idgestao_mudanca'];
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->titulo->DbValue = $row['titulo'];
        $this->dt_inicio->DbValue = $row['dt_inicio'];
        $this->detalhamento->DbValue = $row['detalhamento'];
        $this->impacto->DbValue = $row['impacto'];
        $this->motivo->DbValue = $row['motivo'];
        $this->recursos->DbValue = $row['recursos'];
        $this->prazo_ate->DbValue = $row['prazo_ate'];
        $this->departamentos_iddepartamentos->DbValue = $row['departamentos_iddepartamentos'];
        $this->usuario_idusuario->DbValue = $row['usuario_idusuario'];
        $this->implementado->DbValue = $row['implementado'];
        $this->status->DbValue = $row['status'];
        $this->eficaz->DbValue = $row['eficaz'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idgestao_mudanca` = @idgestao_mudanca@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idgestao_mudanca->CurrentValue : $this->idgestao_mudanca->OldValue;
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
                $this->idgestao_mudanca->CurrentValue = $keys[0];
            } else {
                $this->idgestao_mudanca->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idgestao_mudanca', $row) ? $row['idgestao_mudanca'] : null;
        } else {
            $val = !EmptyValue($this->idgestao_mudanca->OldValue) && !$current ? $this->idgestao_mudanca->OldValue : $this->idgestao_mudanca->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idgestao_mudanca@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("GestaoMudancaList");
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
            "GestaoMudancaView" => $Language->phrase("View"),
            "GestaoMudancaEdit" => $Language->phrase("Edit"),
            "GestaoMudancaAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "GestaoMudancaList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "GestaoMudancaView",
            Config("API_ADD_ACTION") => "GestaoMudancaAdd",
            Config("API_EDIT_ACTION") => "GestaoMudancaEdit",
            Config("API_DELETE_ACTION") => "GestaoMudancaDelete",
            Config("API_LIST_ACTION") => "GestaoMudancaList",
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
        return "GestaoMudancaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("GestaoMudancaView", $parm);
        } else {
            $url = $this->keyUrl("GestaoMudancaView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "GestaoMudancaAdd?" . $parm;
        } else {
            $url = "GestaoMudancaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("GestaoMudancaEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("GestaoMudancaList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("GestaoMudancaAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("GestaoMudancaList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("GestaoMudancaDelete", $parm);
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
        $json .= "\"idgestao_mudanca\":" . VarToJson($this->idgestao_mudanca->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idgestao_mudanca->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idgestao_mudanca->CurrentValue);
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
            if (($keyValue = Param("idgestao_mudanca") ?? Route("idgestao_mudanca")) !== null) {
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
                $this->idgestao_mudanca->CurrentValue = $key;
            } else {
                $this->idgestao_mudanca->OldValue = $key;
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
        $this->idgestao_mudanca->setDbValue($row['idgestao_mudanca']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->titulo->setDbValue($row['titulo']);
        $this->dt_inicio->setDbValue($row['dt_inicio']);
        $this->detalhamento->setDbValue($row['detalhamento']);
        $this->impacto->setDbValue($row['impacto']);
        $this->motivo->setDbValue($row['motivo']);
        $this->recursos->setDbValue($row['recursos']);
        $this->prazo_ate->setDbValue($row['prazo_ate']);
        $this->departamentos_iddepartamentos->setDbValue($row['departamentos_iddepartamentos']);
        $this->usuario_idusuario->setDbValue($row['usuario_idusuario']);
        $this->implementado->setDbValue($row['implementado']);
        $this->status->setDbValue($row['status']);
        $this->eficaz->setDbValue($row['eficaz']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "GestaoMudancaList";
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

        // idgestao_mudanca

        // dt_cadastro

        // titulo

        // dt_inicio

        // detalhamento

        // impacto

        // motivo

        // recursos

        // prazo_ate

        // departamentos_iddepartamentos

        // usuario_idusuario

        // implementado

        // status

        // eficaz

        // idgestao_mudanca
        $this->idgestao_mudanca->ViewValue = $this->idgestao_mudanca->CurrentValue;
        $this->idgestao_mudanca->CssClass = "fw-bold";
        $this->idgestao_mudanca->CellCssStyle .= "text-align: center;";

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->CssClass = "fw-bold";

        // titulo
        $this->titulo->ViewValue = $this->titulo->CurrentValue;
        $this->titulo->CssClass = "fw-bold";

        // dt_inicio
        $this->dt_inicio->ViewValue = $this->dt_inicio->CurrentValue;
        $this->dt_inicio->ViewValue = FormatDateTime($this->dt_inicio->ViewValue, $this->dt_inicio->formatPattern());
        $this->dt_inicio->CssClass = "fw-bold";

        // detalhamento
        $this->detalhamento->ViewValue = $this->detalhamento->CurrentValue;
        $this->detalhamento->CssClass = "fw-bold";

        // impacto
        $this->impacto->ViewValue = $this->impacto->CurrentValue;
        $this->impacto->CssClass = "fw-bold";

        // motivo
        $this->motivo->ViewValue = $this->motivo->CurrentValue;
        $this->motivo->CssClass = "fw-bold";

        // recursos
        $this->recursos->ViewValue = $this->recursos->CurrentValue;
        $this->recursos->ViewValue = FormatCurrency($this->recursos->ViewValue, $this->recursos->formatPattern());
        $this->recursos->CssClass = "fw-bold";
        $this->recursos->CellCssStyle .= "text-align: right;";

        // prazo_ate
        $this->prazo_ate->ViewValue = $this->prazo_ate->CurrentValue;
        $this->prazo_ate->ViewValue = FormatDateTime($this->prazo_ate->ViewValue, $this->prazo_ate->formatPattern());
        $this->prazo_ate->CssClass = "fw-bold";

        // departamentos_iddepartamentos
        $curVal = strval($this->departamentos_iddepartamentos->CurrentValue);
        if ($curVal != "") {
            $this->departamentos_iddepartamentos->ViewValue = $this->departamentos_iddepartamentos->lookupCacheOption($curVal);
            if ($this->departamentos_iddepartamentos->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->departamentos_iddepartamentos->Lookup->getTable()->Fields["iddepartamentos"]->searchExpression(), "=", $curVal, $this->departamentos_iddepartamentos->Lookup->getTable()->Fields["iddepartamentos"]->searchDataType(), "");
                $sqlWrk = $this->departamentos_iddepartamentos->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->departamentos_iddepartamentos->Lookup->renderViewRow($rswrk[0]);
                    $this->departamentos_iddepartamentos->ViewValue = $this->departamentos_iddepartamentos->displayValue($arwrk);
                } else {
                    $this->departamentos_iddepartamentos->ViewValue = FormatNumber($this->departamentos_iddepartamentos->CurrentValue, $this->departamentos_iddepartamentos->formatPattern());
                }
            }
        } else {
            $this->departamentos_iddepartamentos->ViewValue = null;
        }
        $this->departamentos_iddepartamentos->CssClass = "fw-bold";

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

        // implementado
        if (strval($this->implementado->CurrentValue) != "") {
            $this->implementado->ViewValue = $this->implementado->optionCaption($this->implementado->CurrentValue);
        } else {
            $this->implementado->ViewValue = null;
        }
        $this->implementado->CssClass = "fw-bold";
        $this->implementado->CellCssStyle .= "text-align: center;";

        // status
        if (strval($this->status->CurrentValue) != "") {
            $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
        } else {
            $this->status->ViewValue = null;
        }
        $this->status->CssClass = "fw-bold";

        // eficaz
        if (strval($this->eficaz->CurrentValue) != "") {
            $this->eficaz->ViewValue = $this->eficaz->optionCaption($this->eficaz->CurrentValue);
        } else {
            $this->eficaz->ViewValue = null;
        }
        $this->eficaz->CssClass = "fw-bold";
        $this->eficaz->CellCssStyle .= "text-align: center;";

        // idgestao_mudanca
        $this->idgestao_mudanca->HrefValue = "";
        $this->idgestao_mudanca->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // titulo
        $this->titulo->HrefValue = "";
        $this->titulo->TooltipValue = "";

        // dt_inicio
        $this->dt_inicio->HrefValue = "";
        $this->dt_inicio->TooltipValue = "";

        // detalhamento
        $this->detalhamento->HrefValue = "";
        $this->detalhamento->TooltipValue = "";

        // impacto
        $this->impacto->HrefValue = "";
        $this->impacto->TooltipValue = "";

        // motivo
        $this->motivo->HrefValue = "";
        $this->motivo->TooltipValue = "";

        // recursos
        $this->recursos->HrefValue = "";
        $this->recursos->TooltipValue = "";

        // prazo_ate
        $this->prazo_ate->HrefValue = "";
        $this->prazo_ate->TooltipValue = "";

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->HrefValue = "";
        $this->departamentos_iddepartamentos->TooltipValue = "";

        // usuario_idusuario
        $this->usuario_idusuario->HrefValue = "";
        $this->usuario_idusuario->TooltipValue = "";

        // implementado
        $this->implementado->HrefValue = "";
        $this->implementado->TooltipValue = "";

        // status
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // eficaz
        $this->eficaz->HrefValue = "";
        $this->eficaz->TooltipValue = "";

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

        // idgestao_mudanca
        $this->idgestao_mudanca->setupEditAttributes();
        $this->idgestao_mudanca->EditValue = $this->idgestao_mudanca->CurrentValue;
        $this->idgestao_mudanca->CssClass = "fw-bold";
        $this->idgestao_mudanca->CellCssStyle .= "text-align: center;";

        // dt_cadastro

        // titulo
        $this->titulo->setupEditAttributes();
        if (!$this->titulo->Raw) {
            $this->titulo->CurrentValue = HtmlDecode($this->titulo->CurrentValue);
        }
        $this->titulo->EditValue = $this->titulo->CurrentValue;
        $this->titulo->PlaceHolder = RemoveHtml($this->titulo->caption());

        // dt_inicio
        $this->dt_inicio->setupEditAttributes();
        $this->dt_inicio->EditValue = FormatDateTime($this->dt_inicio->CurrentValue, $this->dt_inicio->formatPattern());
        $this->dt_inicio->PlaceHolder = RemoveHtml($this->dt_inicio->caption());

        // detalhamento
        $this->detalhamento->setupEditAttributes();
        $this->detalhamento->EditValue = $this->detalhamento->CurrentValue;
        $this->detalhamento->PlaceHolder = RemoveHtml($this->detalhamento->caption());

        // impacto
        $this->impacto->setupEditAttributes();
        $this->impacto->EditValue = $this->impacto->CurrentValue;
        $this->impacto->PlaceHolder = RemoveHtml($this->impacto->caption());

        // motivo
        $this->motivo->setupEditAttributes();
        $this->motivo->EditValue = $this->motivo->CurrentValue;
        $this->motivo->PlaceHolder = RemoveHtml($this->motivo->caption());

        // recursos
        $this->recursos->setupEditAttributes();
        $this->recursos->EditValue = $this->recursos->CurrentValue;
        $this->recursos->PlaceHolder = RemoveHtml($this->recursos->caption());
        if (strval($this->recursos->EditValue) != "" && is_numeric($this->recursos->EditValue)) {
            $this->recursos->EditValue = FormatNumber($this->recursos->EditValue, null);
        }

        // prazo_ate
        $this->prazo_ate->setupEditAttributes();
        $this->prazo_ate->EditValue = FormatDateTime($this->prazo_ate->CurrentValue, $this->prazo_ate->formatPattern());
        $this->prazo_ate->PlaceHolder = RemoveHtml($this->prazo_ate->caption());

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->setupEditAttributes();
        $this->departamentos_iddepartamentos->PlaceHolder = RemoveHtml($this->departamentos_iddepartamentos->caption());

        // usuario_idusuario
        $this->usuario_idusuario->setupEditAttributes();
        $this->usuario_idusuario->PlaceHolder = RemoveHtml($this->usuario_idusuario->caption());

        // implementado
        $this->implementado->EditValue = $this->implementado->options(false);
        $this->implementado->PlaceHolder = RemoveHtml($this->implementado->caption());

        // status
        $this->status->EditValue = $this->status->options(false);
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // eficaz
        $this->eficaz->EditValue = $this->eficaz->options(false);
        $this->eficaz->PlaceHolder = RemoveHtml($this->eficaz->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            $this->titulo->Count++; // Increment count
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->titulo->CurrentValue = $this->titulo->Count;
            $this->titulo->ViewValue = $this->titulo->CurrentValue;
            $this->titulo->CssClass = "fw-bold";
            $this->titulo->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->idgestao_mudanca);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->titulo);
                    $doc->exportCaption($this->dt_inicio);
                    $doc->exportCaption($this->detalhamento);
                    $doc->exportCaption($this->impacto);
                    $doc->exportCaption($this->motivo);
                    $doc->exportCaption($this->recursos);
                    $doc->exportCaption($this->prazo_ate);
                    $doc->exportCaption($this->departamentos_iddepartamentos);
                    $doc->exportCaption($this->usuario_idusuario);
                    $doc->exportCaption($this->implementado);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->eficaz);
                } else {
                    $doc->exportCaption($this->idgestao_mudanca);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->titulo);
                    $doc->exportCaption($this->dt_inicio);
                    $doc->exportCaption($this->recursos);
                    $doc->exportCaption($this->prazo_ate);
                    $doc->exportCaption($this->departamentos_iddepartamentos);
                    $doc->exportCaption($this->usuario_idusuario);
                    $doc->exportCaption($this->implementado);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->eficaz);
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
                        $doc->exportField($this->idgestao_mudanca);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->titulo);
                        $doc->exportField($this->dt_inicio);
                        $doc->exportField($this->detalhamento);
                        $doc->exportField($this->impacto);
                        $doc->exportField($this->motivo);
                        $doc->exportField($this->recursos);
                        $doc->exportField($this->prazo_ate);
                        $doc->exportField($this->departamentos_iddepartamentos);
                        $doc->exportField($this->usuario_idusuario);
                        $doc->exportField($this->implementado);
                        $doc->exportField($this->status);
                        $doc->exportField($this->eficaz);
                    } else {
                        $doc->exportField($this->idgestao_mudanca);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->titulo);
                        $doc->exportField($this->dt_inicio);
                        $doc->exportField($this->recursos);
                        $doc->exportField($this->prazo_ate);
                        $doc->exportField($this->departamentos_iddepartamentos);
                        $doc->exportField($this->usuario_idusuario);
                        $doc->exportField($this->implementado);
                        $doc->exportField($this->status);
                        $doc->exportField($this->eficaz);
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
                $doc->exportAggregate($this->idgestao_mudanca, '');
                $doc->exportAggregate($this->dt_cadastro, '');
                $doc->exportAggregate($this->titulo, 'COUNT');
                $doc->exportAggregate($this->dt_inicio, '');
                $doc->exportAggregate($this->recursos, '');
                $doc->exportAggregate($this->prazo_ate, '');
                $doc->exportAggregate($this->departamentos_iddepartamentos, '');
                $doc->exportAggregate($this->usuario_idusuario, '');
                $doc->exportAggregate($this->implementado, '');
                $doc->exportAggregate($this->status, '');
                $doc->exportAggregate($this->eficaz, '');
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
