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
 * Table class for nao_conformidade
 */
class NaoConformidade extends DbTable
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
    public $idnao_conformidade;
    public $dt_ocorrencia;
    public $tipo;
    public $titulo;
    public $processo_idprocesso;
    public $ocorrencia;
    public $origem_risco_oportunidade_idorigem_risco_oportunidade;
    public $acao_imediata;
    public $causa_raiz;
    public $departamentos_iddepartamentos;
    public $anexo;
    public $status_nc;
    public $plano_acao;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "nao_conformidade";
        $this->TableName = 'nao_conformidade';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "nao_conformidade";
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

        // idnao_conformidade
        $this->idnao_conformidade = new DbField(
            $this, // Table
            'x_idnao_conformidade', // Variable name
            'idnao_conformidade', // Name
            '`idnao_conformidade`', // Expression
            '`idnao_conformidade`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idnao_conformidade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idnao_conformidade->InputTextType = "text";
        $this->idnao_conformidade->Raw = true;
        $this->idnao_conformidade->IsAutoIncrement = true; // Autoincrement field
        $this->idnao_conformidade->IsPrimaryKey = true; // Primary key field
        $this->idnao_conformidade->IsForeignKey = true; // Foreign key field
        $this->idnao_conformidade->Nullable = false; // NOT NULL field
        $this->idnao_conformidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnao_conformidade->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idnao_conformidade'] = &$this->idnao_conformidade;

        // dt_ocorrencia
        $this->dt_ocorrencia = new DbField(
            $this, // Table
            'x_dt_ocorrencia', // Variable name
            'dt_ocorrencia', // Name
            '`dt_ocorrencia`', // Expression
            CastDateFieldForLike("`dt_ocorrencia`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`dt_ocorrencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dt_ocorrencia->addMethod("getDefault", fn() => date('d/m/Y'));
        $this->dt_ocorrencia->InputTextType = "text";
        $this->dt_ocorrencia->Raw = true;
        $this->dt_ocorrencia->Nullable = false; // NOT NULL field
        $this->dt_ocorrencia->Required = true; // Required field
        $this->dt_ocorrencia->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dt_ocorrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dt_ocorrencia'] = &$this->dt_ocorrencia;

        // tipo
        $this->tipo = new DbField(
            $this, // Table
            'x_tipo', // Variable name
            'tipo', // Name
            '`tipo`', // Expression
            '`tipo`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->tipo->addMethod("getDefault", fn() => 1);
        $this->tipo->InputTextType = "text";
        $this->tipo->Raw = true;
        $this->tipo->Nullable = false; // NOT NULL field
        $this->tipo->UseFilter = true; // Table header filter
        $this->tipo->Lookup = new Lookup($this->tipo, 'nao_conformidade', true, 'tipo', ["tipo","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->tipo->OptionCount = 3;
        $this->tipo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipo->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['tipo'] = &$this->tipo;

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

        // ocorrencia
        $this->ocorrencia = new DbField(
            $this, // Table
            'x_ocorrencia', // Variable name
            'ocorrencia', // Name
            '`ocorrencia`', // Expression
            '`ocorrencia`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ocorrencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->ocorrencia->InputTextType = "text";
        $this->ocorrencia->Nullable = false; // NOT NULL field
        $this->ocorrencia->Required = true; // Required field
        $this->ocorrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['ocorrencia'] = &$this->ocorrencia;

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
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->UseFilter = true; // Table header filter
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup = new Lookup($this->origem_risco_oportunidade_idorigem_risco_oportunidade, 'origem_risco_oportunidade', true, 'idorigem_risco_oportunidade', ["origem","","",""], '', '', [], [], [], [], [], [], false, '`origem` ASC', '', "`origem`");
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['origem_risco_oportunidade_idorigem_risco_oportunidade'] = &$this->origem_risco_oportunidade_idorigem_risco_oportunidade;

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
        $this->acao_imediata->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['acao_imediata'] = &$this->acao_imediata;

        // causa_raiz
        $this->causa_raiz = new DbField(
            $this, // Table
            'x_causa_raiz', // Variable name
            'causa_raiz', // Name
            '`causa_raiz`', // Expression
            '`causa_raiz`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`causa_raiz`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->causa_raiz->InputTextType = "text";
        $this->causa_raiz->Nullable = false; // NOT NULL field
        $this->causa_raiz->Required = true; // Required field
        $this->causa_raiz->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['causa_raiz'] = &$this->causa_raiz;

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
        $this->departamentos_iddepartamentos->Lookup = new Lookup($this->departamentos_iddepartamentos, 'departamentos', false, 'iddepartamentos', ["departamento","","",""], '', '', [], [], [], [], [], [], false, '`departamento` ASC', '', "`departamento`");
        $this->departamentos_iddepartamentos->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->departamentos_iddepartamentos->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['departamentos_iddepartamentos'] = &$this->departamentos_iddepartamentos;

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
        $this->anexo->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['anexo'] = &$this->anexo;

        // status_nc
        $this->status_nc = new DbField(
            $this, // Table
            'x_status_nc', // Variable name
            'status_nc', // Name
            '`status_nc`', // Expression
            '`status_nc`', // Basic search expression
            3, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`status_nc`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->status_nc->addMethod("getDefault", fn() => 1);
        $this->status_nc->InputTextType = "text";
        $this->status_nc->Raw = true;
        $this->status_nc->Nullable = false; // NOT NULL field
        $this->status_nc->Lookup = new Lookup($this->status_nc, 'nao_conformidade', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->status_nc->OptionCount = 3;
        $this->status_nc->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->status_nc->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['status_nc'] = &$this->status_nc;

        // plano_acao
        $this->plano_acao = new DbField(
            $this, // Table
            'x_plano_acao', // Variable name
            'plano_acao', // Name
            '`plano_acao`', // Expression
            '`plano_acao`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`plano_acao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->plano_acao->addMethod("getDefault", fn() => "Nao");
        $this->plano_acao->InputTextType = "text";
        $this->plano_acao->Raw = true;
        $this->plano_acao->Nullable = false; // NOT NULL field
        $this->plano_acao->Lookup = new Lookup($this->plano_acao, 'nao_conformidade', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->plano_acao->OptionCount = 2;
        $this->plano_acao->SearchOperators = ["=", "<>"];
        $this->Fields['plano_acao'] = &$this->plano_acao;

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
        if ($this->getCurrentDetailTable() == "plano_acao_nc") {
            $detailUrl = Container("plano_acao_nc")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idnao_conformidade", $this->idnao_conformidade->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "NaoConformidadeList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "nao_conformidade";
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
            $this->idnao_conformidade->setDbValue($conn->lastInsertId());
            $rs['idnao_conformidade'] = $this->idnao_conformidade->DbValue;
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
        // Cascade Update detail table 'plano_acao_nc'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['idnao_conformidade']) && $rsold['idnao_conformidade'] != $rs['idnao_conformidade'])) { // Update detail field 'nao_conformidade_idnao_conformidade'
            $cascadeUpdate = true;
            $rscascade['nao_conformidade_idnao_conformidade'] = $rs['idnao_conformidade'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("plano_acao_nc")->loadRs("`nao_conformidade_idnao_conformidade` = " . QuotedValue($rsold['idnao_conformidade'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'idplano_acao_nc';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("plano_acao_nc")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("plano_acao_nc")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("plano_acao_nc")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['idnao_conformidade']) && !EmptyValue($this->idnao_conformidade->CurrentValue)) {
                $rs['idnao_conformidade'] = $this->idnao_conformidade->CurrentValue;
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
            if (array_key_exists('idnao_conformidade', $rs)) {
                AddFilter($where, QuotedName('idnao_conformidade', $this->Dbid) . '=' . QuotedValue($rs['idnao_conformidade'], $this->idnao_conformidade->DataType, $this->Dbid));
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

        // Cascade delete detail table 'plano_acao_nc'
        $dtlrows = Container("plano_acao_nc")->loadRs("`nao_conformidade_idnao_conformidade` = " . QuotedValue($rs['idnao_conformidade'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("plano_acao_nc")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("plano_acao_nc")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("plano_acao_nc")->rowDeleted($dtlrow);
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
        $this->idnao_conformidade->DbValue = $row['idnao_conformidade'];
        $this->dt_ocorrencia->DbValue = $row['dt_ocorrencia'];
        $this->tipo->DbValue = $row['tipo'];
        $this->titulo->DbValue = $row['titulo'];
        $this->processo_idprocesso->DbValue = $row['processo_idprocesso'];
        $this->ocorrencia->DbValue = $row['ocorrencia'];
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->DbValue = $row['origem_risco_oportunidade_idorigem_risco_oportunidade'];
        $this->acao_imediata->DbValue = $row['acao_imediata'];
        $this->causa_raiz->DbValue = $row['causa_raiz'];
        $this->departamentos_iddepartamentos->DbValue = $row['departamentos_iddepartamentos'];
        $this->anexo->Upload->DbValue = $row['anexo'];
        $this->status_nc->DbValue = $row['status_nc'];
        $this->plano_acao->DbValue = $row['plano_acao'];
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
        return "`idnao_conformidade` = @idnao_conformidade@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idnao_conformidade->CurrentValue : $this->idnao_conformidade->OldValue;
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
                $this->idnao_conformidade->CurrentValue = $keys[0];
            } else {
                $this->idnao_conformidade->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idnao_conformidade', $row) ? $row['idnao_conformidade'] : null;
        } else {
            $val = !EmptyValue($this->idnao_conformidade->OldValue) && !$current ? $this->idnao_conformidade->OldValue : $this->idnao_conformidade->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idnao_conformidade@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("NaoConformidadeList");
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
            "NaoConformidadeView" => $Language->phrase("View"),
            "NaoConformidadeEdit" => $Language->phrase("Edit"),
            "NaoConformidadeAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "NaoConformidadeList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "NaoConformidadeView",
            Config("API_ADD_ACTION") => "NaoConformidadeAdd",
            Config("API_EDIT_ACTION") => "NaoConformidadeEdit",
            Config("API_DELETE_ACTION") => "NaoConformidadeDelete",
            Config("API_LIST_ACTION") => "NaoConformidadeList",
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
        return "NaoConformidadeList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NaoConformidadeView", $parm);
        } else {
            $url = $this->keyUrl("NaoConformidadeView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "NaoConformidadeAdd?" . $parm;
        } else {
            $url = "NaoConformidadeAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NaoConformidadeEdit", $parm);
        } else {
            $url = $this->keyUrl("NaoConformidadeEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("NaoConformidadeList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NaoConformidadeAdd", $parm);
        } else {
            $url = $this->keyUrl("NaoConformidadeAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("NaoConformidadeList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("NaoConformidadeDelete", $parm);
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
        $json .= "\"idnao_conformidade\":" . VarToJson($this->idnao_conformidade->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idnao_conformidade->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idnao_conformidade->CurrentValue);
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
            if (($keyValue = Param("idnao_conformidade") ?? Route("idnao_conformidade")) !== null) {
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
                $this->idnao_conformidade->CurrentValue = $key;
            } else {
                $this->idnao_conformidade->OldValue = $key;
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
        $this->idnao_conformidade->setDbValue($row['idnao_conformidade']);
        $this->dt_ocorrencia->setDbValue($row['dt_ocorrencia']);
        $this->tipo->setDbValue($row['tipo']);
        $this->titulo->setDbValue($row['titulo']);
        $this->processo_idprocesso->setDbValue($row['processo_idprocesso']);
        $this->ocorrencia->setDbValue($row['ocorrencia']);
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValue($row['origem_risco_oportunidade_idorigem_risco_oportunidade']);
        $this->acao_imediata->setDbValue($row['acao_imediata']);
        $this->causa_raiz->setDbValue($row['causa_raiz']);
        $this->departamentos_iddepartamentos->setDbValue($row['departamentos_iddepartamentos']);
        $this->anexo->Upload->DbValue = $row['anexo'];
        $this->status_nc->setDbValue($row['status_nc']);
        $this->plano_acao->setDbValue($row['plano_acao']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "NaoConformidadeList";
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

        // idnao_conformidade

        // dt_ocorrencia

        // tipo

        // titulo

        // processo_idprocesso

        // ocorrencia

        // origem_risco_oportunidade_idorigem_risco_oportunidade

        // acao_imediata

        // causa_raiz

        // departamentos_iddepartamentos

        // anexo

        // status_nc

        // plano_acao

        // idnao_conformidade
        $this->idnao_conformidade->ViewValue = $this->idnao_conformidade->CurrentValue;
        $this->idnao_conformidade->CssClass = "fw-bold";
        $this->idnao_conformidade->CellCssStyle .= "text-align: center;";

        // dt_ocorrencia
        $this->dt_ocorrencia->ViewValue = $this->dt_ocorrencia->CurrentValue;
        $this->dt_ocorrencia->ViewValue = FormatDateTime($this->dt_ocorrencia->ViewValue, $this->dt_ocorrencia->formatPattern());
        $this->dt_ocorrencia->CssClass = "fw-bold";
        $this->dt_ocorrencia->CellCssStyle .= "text-align: center;";

        // tipo
        if (strval($this->tipo->CurrentValue) != "") {
            $this->tipo->ViewValue = $this->tipo->optionCaption($this->tipo->CurrentValue);
        } else {
            $this->tipo->ViewValue = null;
        }
        $this->tipo->CssClass = "fw-bold";

        // titulo
        $this->titulo->ViewValue = $this->titulo->CurrentValue;
        $this->titulo->CssClass = "fw-bold";

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

        // ocorrencia
        $this->ocorrencia->ViewValue = $this->ocorrencia->CurrentValue;
        $this->ocorrencia->CssClass = "fw-bold";

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

        // acao_imediata
        $this->acao_imediata->ViewValue = $this->acao_imediata->CurrentValue;
        $this->acao_imediata->CssClass = "fw-bold";

        // causa_raiz
        $this->causa_raiz->ViewValue = $this->causa_raiz->CurrentValue;
        $this->causa_raiz->CssClass = "fw-bold";

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

        // anexo
        if (!EmptyValue($this->anexo->Upload->DbValue)) {
            $this->anexo->ViewValue = $this->anexo->Upload->DbValue;
        } else {
            $this->anexo->ViewValue = "";
        }
        $this->anexo->CssClass = "fw-bold";

        // status_nc
        if (strval($this->status_nc->CurrentValue) != "") {
            $this->status_nc->ViewValue = $this->status_nc->optionCaption($this->status_nc->CurrentValue);
        } else {
            $this->status_nc->ViewValue = null;
        }
        $this->status_nc->CssClass = "fw-bold";

        // plano_acao
        if (strval($this->plano_acao->CurrentValue) != "") {
            $this->plano_acao->ViewValue = $this->plano_acao->optionCaption($this->plano_acao->CurrentValue);
        } else {
            $this->plano_acao->ViewValue = null;
        }
        $this->plano_acao->CssClass = "fw-bold";
        $this->plano_acao->CellCssStyle .= "text-align: center;";

        // idnao_conformidade
        $this->idnao_conformidade->HrefValue = "";
        $this->idnao_conformidade->TooltipValue = "";

        // dt_ocorrencia
        $this->dt_ocorrencia->HrefValue = "";
        $this->dt_ocorrencia->TooltipValue = "";

        // tipo
        $this->tipo->HrefValue = "";
        $this->tipo->TooltipValue = "";

        // titulo
        $this->titulo->HrefValue = "";
        $this->titulo->TooltipValue = "";

        // processo_idprocesso
        $this->processo_idprocesso->HrefValue = "";
        $this->processo_idprocesso->TooltipValue = "";

        // ocorrencia
        $this->ocorrencia->HrefValue = "";
        $this->ocorrencia->TooltipValue = "";

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->TooltipValue = "";

        // acao_imediata
        $this->acao_imediata->HrefValue = "";
        $this->acao_imediata->TooltipValue = "";

        // causa_raiz
        $this->causa_raiz->HrefValue = "";
        $this->causa_raiz->TooltipValue = "";

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->HrefValue = "";
        $this->departamentos_iddepartamentos->TooltipValue = "";

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

        // status_nc
        $this->status_nc->HrefValue = "";
        $this->status_nc->TooltipValue = "";

        // plano_acao
        $this->plano_acao->HrefValue = "";
        $this->plano_acao->TooltipValue = "";

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

        // idnao_conformidade
        $this->idnao_conformidade->setupEditAttributes();
        $this->idnao_conformidade->EditValue = $this->idnao_conformidade->CurrentValue;
        $this->idnao_conformidade->CssClass = "fw-bold";
        $this->idnao_conformidade->CellCssStyle .= "text-align: center;";

        // dt_ocorrencia
        $this->dt_ocorrencia->setupEditAttributes();
        $this->dt_ocorrencia->EditValue = FormatDateTime($this->dt_ocorrencia->CurrentValue, $this->dt_ocorrencia->formatPattern());
        $this->dt_ocorrencia->PlaceHolder = RemoveHtml($this->dt_ocorrencia->caption());

        // tipo
        $this->tipo->EditValue = $this->tipo->options(false);
        $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

        // titulo
        $this->titulo->setupEditAttributes();
        if (!$this->titulo->Raw) {
            $this->titulo->CurrentValue = HtmlDecode($this->titulo->CurrentValue);
        }
        $this->titulo->EditValue = $this->titulo->CurrentValue;
        $this->titulo->PlaceHolder = RemoveHtml($this->titulo->caption());

        // processo_idprocesso
        $this->processo_idprocesso->setupEditAttributes();
        $this->processo_idprocesso->PlaceHolder = RemoveHtml($this->processo_idprocesso->caption());

        // ocorrencia
        $this->ocorrencia->setupEditAttributes();
        $this->ocorrencia->EditValue = $this->ocorrencia->CurrentValue;
        $this->ocorrencia->PlaceHolder = RemoveHtml($this->ocorrencia->caption());

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setupEditAttributes();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->PlaceHolder = RemoveHtml($this->origem_risco_oportunidade_idorigem_risco_oportunidade->caption());

        // acao_imediata
        $this->acao_imediata->setupEditAttributes();
        $this->acao_imediata->EditValue = $this->acao_imediata->CurrentValue;
        $this->acao_imediata->PlaceHolder = RemoveHtml($this->acao_imediata->caption());

        // causa_raiz
        $this->causa_raiz->setupEditAttributes();
        $this->causa_raiz->EditValue = $this->causa_raiz->CurrentValue;
        $this->causa_raiz->PlaceHolder = RemoveHtml($this->causa_raiz->caption());

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->setupEditAttributes();
        $this->departamentos_iddepartamentos->PlaceHolder = RemoveHtml($this->departamentos_iddepartamentos->caption());

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

        // status_nc
        $this->status_nc->EditValue = $this->status_nc->options(false);
        $this->status_nc->PlaceHolder = RemoveHtml($this->status_nc->caption());

        // plano_acao
        $this->plano_acao->setupEditAttributes();
        if (strval($this->plano_acao->CurrentValue) != "") {
            $this->plano_acao->EditValue = $this->plano_acao->optionCaption($this->plano_acao->CurrentValue);
        } else {
            $this->plano_acao->EditValue = null;
        }
        $this->plano_acao->CssClass = "fw-bold";
        $this->plano_acao->CellCssStyle .= "text-align: center;";

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            $this->ocorrencia->Count++; // Increment count
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->ocorrencia->CurrentValue = $this->ocorrencia->Count;
            $this->ocorrencia->ViewValue = $this->ocorrencia->CurrentValue;
            $this->ocorrencia->CssClass = "fw-bold";
            $this->ocorrencia->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->idnao_conformidade);
                    $doc->exportCaption($this->dt_ocorrencia);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->titulo);
                    $doc->exportCaption($this->processo_idprocesso);
                    $doc->exportCaption($this->ocorrencia);
                    $doc->exportCaption($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                    $doc->exportCaption($this->acao_imediata);
                    $doc->exportCaption($this->causa_raiz);
                    $doc->exportCaption($this->departamentos_iddepartamentos);
                    $doc->exportCaption($this->anexo);
                    $doc->exportCaption($this->status_nc);
                    $doc->exportCaption($this->plano_acao);
                } else {
                    $doc->exportCaption($this->idnao_conformidade);
                    $doc->exportCaption($this->dt_ocorrencia);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->titulo);
                    $doc->exportCaption($this->processo_idprocesso);
                    $doc->exportCaption($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                    $doc->exportCaption($this->departamentos_iddepartamentos);
                    $doc->exportCaption($this->anexo);
                    $doc->exportCaption($this->status_nc);
                    $doc->exportCaption($this->plano_acao);
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
                        $doc->exportField($this->idnao_conformidade);
                        $doc->exportField($this->dt_ocorrencia);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->titulo);
                        $doc->exportField($this->processo_idprocesso);
                        $doc->exportField($this->ocorrencia);
                        $doc->exportField($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                        $doc->exportField($this->acao_imediata);
                        $doc->exportField($this->causa_raiz);
                        $doc->exportField($this->departamentos_iddepartamentos);
                        $doc->exportField($this->anexo);
                        $doc->exportField($this->status_nc);
                        $doc->exportField($this->plano_acao);
                    } else {
                        $doc->exportField($this->idnao_conformidade);
                        $doc->exportField($this->dt_ocorrencia);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->titulo);
                        $doc->exportField($this->processo_idprocesso);
                        $doc->exportField($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                        $doc->exportField($this->departamentos_iddepartamentos);
                        $doc->exportField($this->anexo);
                        $doc->exportField($this->status_nc);
                        $doc->exportField($this->plano_acao);
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
            $this->idnao_conformidade->CurrentValue = $ar[0];
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
