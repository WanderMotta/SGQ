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
 * Table class for plano_acao
 */
class PlanoAcao extends DbTable
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
    public $idplano_acao;
    public $risco_oportunidade_idrisco_oportunidade;
    public $dt_cadastro;
    public $o_q_sera_feito;
    public $efeito_esperado;
    public $departamentos_iddepartamentos;
    public $origem_risco_oportunidade_idorigem_risco_oportunidade;
    public $recursos_nec;
    public $dt_limite;
    public $implementado;
    public $periodicidade_idperiodicidade;
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
        $this->TableVar = "plano_acao";
        $this->TableName = 'plano_acao';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "plano_acao";
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

        // idplano_acao
        $this->idplano_acao = new DbField(
            $this, // Table
            'x_idplano_acao', // Variable name
            'idplano_acao', // Name
            '`idplano_acao`', // Expression
            '`idplano_acao`', // Basic search expression
            19, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idplano_acao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idplano_acao->InputTextType = "text";
        $this->idplano_acao->Raw = true;
        $this->idplano_acao->IsAutoIncrement = true; // Autoincrement field
        $this->idplano_acao->IsPrimaryKey = true; // Primary key field
        $this->idplano_acao->Nullable = false; // NOT NULL field
        $this->idplano_acao->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idplano_acao->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idplano_acao'] = &$this->idplano_acao;

        // risco_oportunidade_idrisco_oportunidade
        $this->risco_oportunidade_idrisco_oportunidade = new DbField(
            $this, // Table
            'x_risco_oportunidade_idrisco_oportunidade', // Variable name
            'risco_oportunidade_idrisco_oportunidade', // Name
            '`risco_oportunidade_idrisco_oportunidade`', // Expression
            '`risco_oportunidade_idrisco_oportunidade`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`risco_oportunidade_idrisco_oportunidade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->risco_oportunidade_idrisco_oportunidade->InputTextType = "text";
        $this->risco_oportunidade_idrisco_oportunidade->Raw = true;
        $this->risco_oportunidade_idrisco_oportunidade->IsForeignKey = true; // Foreign key field
        $this->risco_oportunidade_idrisco_oportunidade->Nullable = false; // NOT NULL field
        $this->risco_oportunidade_idrisco_oportunidade->Required = true; // Required field
        $this->risco_oportunidade_idrisco_oportunidade->setSelectMultiple(false); // Select one
        $this->risco_oportunidade_idrisco_oportunidade->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->risco_oportunidade_idrisco_oportunidade->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->risco_oportunidade_idrisco_oportunidade->Lookup = new Lookup($this->risco_oportunidade_idrisco_oportunidade, 'risco_oportunidade', false, 'idrisco_oportunidade', ["titulo","","",""], '', '', [], [], [], [], [], [], false, '`titulo` ASC', '', "`titulo`");
        $this->risco_oportunidade_idrisco_oportunidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->risco_oportunidade_idrisco_oportunidade->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['risco_oportunidade_idrisco_oportunidade'] = &$this->risco_oportunidade_idrisco_oportunidade;

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

        // o_q_sera_feito
        $this->o_q_sera_feito = new DbField(
            $this, // Table
            'x_o_q_sera_feito', // Variable name
            'o_q_sera_feito', // Name
            '`o_q_sera_feito`', // Expression
            '`o_q_sera_feito`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`o_q_sera_feito`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->o_q_sera_feito->InputTextType = "text";
        $this->o_q_sera_feito->Nullable = false; // NOT NULL field
        $this->o_q_sera_feito->Required = true; // Required field
        $this->o_q_sera_feito->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['o_q_sera_feito'] = &$this->o_q_sera_feito;

        // efeito_esperado
        $this->efeito_esperado = new DbField(
            $this, // Table
            'x_efeito_esperado', // Variable name
            'efeito_esperado', // Name
            '`efeito_esperado`', // Expression
            '`efeito_esperado`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`efeito_esperado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->efeito_esperado->InputTextType = "text";
        $this->efeito_esperado->Nullable = false; // NOT NULL field
        $this->efeito_esperado->Required = true; // Required field
        $this->efeito_esperado->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['efeito_esperado'] = &$this->efeito_esperado;

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

        // recursos_nec
        $this->recursos_nec = new DbField(
            $this, // Table
            'x_recursos_nec', // Variable name
            'recursos_nec', // Name
            '`recursos_nec`', // Expression
            '`recursos_nec`', // Basic search expression
            131, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`recursos_nec`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->recursos_nec->addMethod("getDefault", fn() => 0.00);
        $this->recursos_nec->InputTextType = "text";
        $this->recursos_nec->Raw = true;
        $this->recursos_nec->Nullable = false; // NOT NULL field
        $this->recursos_nec->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->recursos_nec->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['recursos_nec'] = &$this->recursos_nec;

        // dt_limite
        $this->dt_limite = new DbField(
            $this, // Table
            'x_dt_limite', // Variable name
            'dt_limite', // Name
            '`dt_limite`', // Expression
            CastDateFieldForLike("`dt_limite`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`dt_limite`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dt_limite->InputTextType = "text";
        $this->dt_limite->Raw = true;
        $this->dt_limite->Nullable = false; // NOT NULL field
        $this->dt_limite->Required = true; // Required field
        $this->dt_limite->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dt_limite->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dt_limite'] = &$this->dt_limite;

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
        $this->implementado->addMethod("getDefault", fn() => "Nao");
        $this->implementado->InputTextType = "text";
        $this->implementado->Raw = true;
        $this->implementado->Nullable = false; // NOT NULL field
        $this->implementado->Lookup = new Lookup($this->implementado, 'plano_acao', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->implementado->OptionCount = 2;
        $this->implementado->SearchOperators = ["=", "<>"];
        $this->Fields['implementado'] = &$this->implementado;

        // periodicidade_idperiodicidade
        $this->periodicidade_idperiodicidade = new DbField(
            $this, // Table
            'x_periodicidade_idperiodicidade', // Variable name
            'periodicidade_idperiodicidade', // Name
            '`periodicidade_idperiodicidade`', // Expression
            '`periodicidade_idperiodicidade`', // Basic search expression
            19, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`periodicidade_idperiodicidade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->periodicidade_idperiodicidade->InputTextType = "text";
        $this->periodicidade_idperiodicidade->Raw = true;
        $this->periodicidade_idperiodicidade->Nullable = false; // NOT NULL field
        $this->periodicidade_idperiodicidade->Required = true; // Required field
        $this->periodicidade_idperiodicidade->Lookup = new Lookup($this->periodicidade_idperiodicidade, 'periodicidade', false, 'idperiodicidade', ["periodicidade","","",""], '', '', [], [], [], [], [], [], false, '', '', "`periodicidade`");
        $this->periodicidade_idperiodicidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->periodicidade_idperiodicidade->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['periodicidade_idperiodicidade'] = &$this->periodicidade_idperiodicidade;

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
        $this->eficaz->addMethod("getDefault", fn() => "Nao");
        $this->eficaz->InputTextType = "text";
        $this->eficaz->Raw = true;
        $this->eficaz->Nullable = false; // NOT NULL field
        $this->eficaz->Lookup = new Lookup($this->eficaz, 'plano_acao', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
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
        if ($this->getCurrentMasterTable() == "risco_oportunidade") {
            $masterTable = Container("risco_oportunidade");
            if ($this->risco_oportunidade_idrisco_oportunidade->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->idrisco_oportunidade, $this->risco_oportunidade_idrisco_oportunidade->getSessionValue(), $masterTable->idrisco_oportunidade->DataType, $masterTable->Dbid);
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
        if ($this->getCurrentMasterTable() == "risco_oportunidade") {
            $masterTable = Container("risco_oportunidade");
            if ($this->risco_oportunidade_idrisco_oportunidade->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->risco_oportunidade_idrisco_oportunidade, $this->risco_oportunidade_idrisco_oportunidade->getSessionValue(), $masterTable->idrisco_oportunidade->DataType, $this->Dbid);
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
            case "risco_oportunidade":
                $key = $keys["risco_oportunidade_idrisco_oportunidade"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->idrisco_oportunidade->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->idrisco_oportunidade, $keys["risco_oportunidade_idrisco_oportunidade"], $this->risco_oportunidade_idrisco_oportunidade->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "risco_oportunidade":
                return GetKeyFilter($this->risco_oportunidade_idrisco_oportunidade, $masterTable->idrisco_oportunidade->DbValue, $masterTable->idrisco_oportunidade->DataType, $masterTable->Dbid);
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "plano_acao";
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
            $this->idplano_acao->setDbValue($conn->lastInsertId());
            $rs['idplano_acao'] = $this->idplano_acao->DbValue;
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
            if (!isset($rs['idplano_acao']) && !EmptyValue($this->idplano_acao->CurrentValue)) {
                $rs['idplano_acao'] = $this->idplano_acao->CurrentValue;
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
            if (array_key_exists('idplano_acao', $rs)) {
                AddFilter($where, QuotedName('idplano_acao', $this->Dbid) . '=' . QuotedValue($rs['idplano_acao'], $this->idplano_acao->DataType, $this->Dbid));
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
        $this->idplano_acao->DbValue = $row['idplano_acao'];
        $this->risco_oportunidade_idrisco_oportunidade->DbValue = $row['risco_oportunidade_idrisco_oportunidade'];
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->o_q_sera_feito->DbValue = $row['o_q_sera_feito'];
        $this->efeito_esperado->DbValue = $row['efeito_esperado'];
        $this->departamentos_iddepartamentos->DbValue = $row['departamentos_iddepartamentos'];
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->DbValue = $row['origem_risco_oportunidade_idorigem_risco_oportunidade'];
        $this->recursos_nec->DbValue = $row['recursos_nec'];
        $this->dt_limite->DbValue = $row['dt_limite'];
        $this->implementado->DbValue = $row['implementado'];
        $this->periodicidade_idperiodicidade->DbValue = $row['periodicidade_idperiodicidade'];
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
        return "`idplano_acao` = @idplano_acao@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idplano_acao->CurrentValue : $this->idplano_acao->OldValue;
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
                $this->idplano_acao->CurrentValue = $keys[0];
            } else {
                $this->idplano_acao->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idplano_acao', $row) ? $row['idplano_acao'] : null;
        } else {
            $val = !EmptyValue($this->idplano_acao->OldValue) && !$current ? $this->idplano_acao->OldValue : $this->idplano_acao->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idplano_acao@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("PlanoAcaoList");
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
            "PlanoAcaoView" => $Language->phrase("View"),
            "PlanoAcaoEdit" => $Language->phrase("Edit"),
            "PlanoAcaoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "PlanoAcaoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "PlanoAcaoView",
            Config("API_ADD_ACTION") => "PlanoAcaoAdd",
            Config("API_EDIT_ACTION") => "PlanoAcaoEdit",
            Config("API_DELETE_ACTION") => "PlanoAcaoDelete",
            Config("API_LIST_ACTION") => "PlanoAcaoList",
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
        return "PlanoAcaoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PlanoAcaoView", $parm);
        } else {
            $url = $this->keyUrl("PlanoAcaoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "PlanoAcaoAdd?" . $parm;
        } else {
            $url = "PlanoAcaoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("PlanoAcaoEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("PlanoAcaoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("PlanoAcaoAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("PlanoAcaoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("PlanoAcaoDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "risco_oportunidade" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_idrisco_oportunidade", $this->risco_oportunidade_idrisco_oportunidade->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"idplano_acao\":" . VarToJson($this->idplano_acao->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idplano_acao->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idplano_acao->CurrentValue);
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
            if (($keyValue = Param("idplano_acao") ?? Route("idplano_acao")) !== null) {
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
                $this->idplano_acao->CurrentValue = $key;
            } else {
                $this->idplano_acao->OldValue = $key;
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
        $this->idplano_acao->setDbValue($row['idplano_acao']);
        $this->risco_oportunidade_idrisco_oportunidade->setDbValue($row['risco_oportunidade_idrisco_oportunidade']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->o_q_sera_feito->setDbValue($row['o_q_sera_feito']);
        $this->efeito_esperado->setDbValue($row['efeito_esperado']);
        $this->departamentos_iddepartamentos->setDbValue($row['departamentos_iddepartamentos']);
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValue($row['origem_risco_oportunidade_idorigem_risco_oportunidade']);
        $this->recursos_nec->setDbValue($row['recursos_nec']);
        $this->dt_limite->setDbValue($row['dt_limite']);
        $this->implementado->setDbValue($row['implementado']);
        $this->periodicidade_idperiodicidade->setDbValue($row['periodicidade_idperiodicidade']);
        $this->eficaz->setDbValue($row['eficaz']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "PlanoAcaoList";
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

        // idplano_acao

        // risco_oportunidade_idrisco_oportunidade

        // dt_cadastro

        // o_q_sera_feito

        // efeito_esperado

        // departamentos_iddepartamentos

        // origem_risco_oportunidade_idorigem_risco_oportunidade

        // recursos_nec

        // dt_limite

        // implementado

        // periodicidade_idperiodicidade

        // eficaz

        // idplano_acao
        $this->idplano_acao->ViewValue = $this->idplano_acao->CurrentValue;

        // risco_oportunidade_idrisco_oportunidade
        $curVal = strval($this->risco_oportunidade_idrisco_oportunidade->CurrentValue);
        if ($curVal != "") {
            $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->lookupCacheOption($curVal);
            if ($this->risco_oportunidade_idrisco_oportunidade->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchExpression(), "=", $curVal, $this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchDataType(), "");
                $sqlWrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->renderViewRow($rswrk[0]);
                    $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->displayValue($arwrk);
                } else {
                    $this->risco_oportunidade_idrisco_oportunidade->ViewValue = FormatNumber($this->risco_oportunidade_idrisco_oportunidade->CurrentValue, $this->risco_oportunidade_idrisco_oportunidade->formatPattern());
                }
            }
        } else {
            $this->risco_oportunidade_idrisco_oportunidade->ViewValue = null;
        }
        $this->risco_oportunidade_idrisco_oportunidade->CssClass = "fw-bold";
        $this->risco_oportunidade_idrisco_oportunidade->CellCssStyle .= "text-align: center;";

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->CssClass = "fw-bold";

        // o_q_sera_feito
        $this->o_q_sera_feito->ViewValue = $this->o_q_sera_feito->CurrentValue;
        $this->o_q_sera_feito->CssClass = "fw-bold";

        // efeito_esperado
        $this->efeito_esperado->ViewValue = $this->efeito_esperado->CurrentValue;
        $this->efeito_esperado->CssClass = "fw-bold";

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

        // recursos_nec
        $this->recursos_nec->ViewValue = $this->recursos_nec->CurrentValue;
        $this->recursos_nec->ViewValue = FormatCurrency($this->recursos_nec->ViewValue, $this->recursos_nec->formatPattern());
        $this->recursos_nec->CssClass = "fw-bold";
        $this->recursos_nec->CellCssStyle .= "text-align: right;";

        // dt_limite
        $this->dt_limite->ViewValue = $this->dt_limite->CurrentValue;
        $this->dt_limite->ViewValue = FormatDateTime($this->dt_limite->ViewValue, $this->dt_limite->formatPattern());
        $this->dt_limite->CssClass = "fw-bold";

        // implementado
        if (strval($this->implementado->CurrentValue) != "") {
            $this->implementado->ViewValue = $this->implementado->optionCaption($this->implementado->CurrentValue);
        } else {
            $this->implementado->ViewValue = null;
        }
        $this->implementado->CssClass = "fw-bold";
        $this->implementado->CellCssStyle .= "text-align: center;";

        // periodicidade_idperiodicidade
        $curVal = strval($this->periodicidade_idperiodicidade->CurrentValue);
        if ($curVal != "") {
            $this->periodicidade_idperiodicidade->ViewValue = $this->periodicidade_idperiodicidade->lookupCacheOption($curVal);
            if ($this->periodicidade_idperiodicidade->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchExpression(), "=", $curVal, $this->periodicidade_idperiodicidade->Lookup->getTable()->Fields["idperiodicidade"]->searchDataType(), "");
                $sqlWrk = $this->periodicidade_idperiodicidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->periodicidade_idperiodicidade->Lookup->renderViewRow($rswrk[0]);
                    $this->periodicidade_idperiodicidade->ViewValue = $this->periodicidade_idperiodicidade->displayValue($arwrk);
                } else {
                    $this->periodicidade_idperiodicidade->ViewValue = FormatNumber($this->periodicidade_idperiodicidade->CurrentValue, $this->periodicidade_idperiodicidade->formatPattern());
                }
            }
        } else {
            $this->periodicidade_idperiodicidade->ViewValue = null;
        }
        $this->periodicidade_idperiodicidade->CssClass = "fw-bold";

        // eficaz
        if (strval($this->eficaz->CurrentValue) != "") {
            $this->eficaz->ViewValue = $this->eficaz->optionCaption($this->eficaz->CurrentValue);
        } else {
            $this->eficaz->ViewValue = null;
        }
        $this->eficaz->CssClass = "fw-bold";
        $this->eficaz->CellCssStyle .= "text-align: center;";

        // idplano_acao
        $this->idplano_acao->HrefValue = "";
        $this->idplano_acao->TooltipValue = "";

        // risco_oportunidade_idrisco_oportunidade
        $this->risco_oportunidade_idrisco_oportunidade->HrefValue = "";
        $this->risco_oportunidade_idrisco_oportunidade->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // o_q_sera_feito
        $this->o_q_sera_feito->HrefValue = "";
        $this->o_q_sera_feito->TooltipValue = "";

        // efeito_esperado
        $this->efeito_esperado->HrefValue = "";
        $this->efeito_esperado->TooltipValue = "";

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->HrefValue = "";
        $this->departamentos_iddepartamentos->TooltipValue = "";

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->TooltipValue = "";

        // recursos_nec
        $this->recursos_nec->HrefValue = "";
        $this->recursos_nec->TooltipValue = "";

        // dt_limite
        $this->dt_limite->HrefValue = "";
        $this->dt_limite->TooltipValue = "";

        // implementado
        $this->implementado->HrefValue = "";
        $this->implementado->TooltipValue = "";

        // periodicidade_idperiodicidade
        $this->periodicidade_idperiodicidade->HrefValue = "";
        $this->periodicidade_idperiodicidade->TooltipValue = "";

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

        // idplano_acao
        $this->idplano_acao->setupEditAttributes();
        $this->idplano_acao->EditValue = $this->idplano_acao->CurrentValue;

        // risco_oportunidade_idrisco_oportunidade
        $this->risco_oportunidade_idrisco_oportunidade->setupEditAttributes();
        if ($this->risco_oportunidade_idrisco_oportunidade->getSessionValue() != "") {
            $this->risco_oportunidade_idrisco_oportunidade->CurrentValue = GetForeignKeyValue($this->risco_oportunidade_idrisco_oportunidade->getSessionValue());
            $curVal = strval($this->risco_oportunidade_idrisco_oportunidade->CurrentValue);
            if ($curVal != "") {
                $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->lookupCacheOption($curVal);
                if ($this->risco_oportunidade_idrisco_oportunidade->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchExpression(), "=", $curVal, $this->risco_oportunidade_idrisco_oportunidade->Lookup->getTable()->Fields["idrisco_oportunidade"]->searchDataType(), "");
                    $sqlWrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->risco_oportunidade_idrisco_oportunidade->Lookup->renderViewRow($rswrk[0]);
                        $this->risco_oportunidade_idrisco_oportunidade->ViewValue = $this->risco_oportunidade_idrisco_oportunidade->displayValue($arwrk);
                    } else {
                        $this->risco_oportunidade_idrisco_oportunidade->ViewValue = FormatNumber($this->risco_oportunidade_idrisco_oportunidade->CurrentValue, $this->risco_oportunidade_idrisco_oportunidade->formatPattern());
                    }
                }
            } else {
                $this->risco_oportunidade_idrisco_oportunidade->ViewValue = null;
            }
            $this->risco_oportunidade_idrisco_oportunidade->CssClass = "fw-bold";
            $this->risco_oportunidade_idrisco_oportunidade->CellCssStyle .= "text-align: center;";
        } else {
            $this->risco_oportunidade_idrisco_oportunidade->PlaceHolder = RemoveHtml($this->risco_oportunidade_idrisco_oportunidade->caption());
        }

        // dt_cadastro

        // o_q_sera_feito
        $this->o_q_sera_feito->setupEditAttributes();
        $this->o_q_sera_feito->EditValue = $this->o_q_sera_feito->CurrentValue;
        $this->o_q_sera_feito->PlaceHolder = RemoveHtml($this->o_q_sera_feito->caption());

        // efeito_esperado
        $this->efeito_esperado->setupEditAttributes();
        $this->efeito_esperado->EditValue = $this->efeito_esperado->CurrentValue;
        $this->efeito_esperado->PlaceHolder = RemoveHtml($this->efeito_esperado->caption());

        // departamentos_iddepartamentos
        $this->departamentos_iddepartamentos->setupEditAttributes();
        $this->departamentos_iddepartamentos->PlaceHolder = RemoveHtml($this->departamentos_iddepartamentos->caption());

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setupEditAttributes();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->PlaceHolder = RemoveHtml($this->origem_risco_oportunidade_idorigem_risco_oportunidade->caption());

        // recursos_nec
        $this->recursos_nec->setupEditAttributes();
        $this->recursos_nec->EditValue = $this->recursos_nec->CurrentValue;
        $this->recursos_nec->PlaceHolder = RemoveHtml($this->recursos_nec->caption());
        if (strval($this->recursos_nec->EditValue) != "" && is_numeric($this->recursos_nec->EditValue)) {
            $this->recursos_nec->EditValue = FormatNumber($this->recursos_nec->EditValue, null);
        }

        // dt_limite
        $this->dt_limite->setupEditAttributes();
        $this->dt_limite->EditValue = FormatDateTime($this->dt_limite->CurrentValue, $this->dt_limite->formatPattern());
        $this->dt_limite->PlaceHolder = RemoveHtml($this->dt_limite->caption());

        // implementado
        $this->implementado->EditValue = $this->implementado->options(false);
        $this->implementado->PlaceHolder = RemoveHtml($this->implementado->caption());

        // periodicidade_idperiodicidade
        $this->periodicidade_idperiodicidade->PlaceHolder = RemoveHtml($this->periodicidade_idperiodicidade->caption());

        // eficaz
        $this->eficaz->EditValue = $this->eficaz->options(false);
        $this->eficaz->PlaceHolder = RemoveHtml($this->eficaz->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            if (is_numeric($this->recursos_nec->CurrentValue)) {
                $this->recursos_nec->Total += $this->recursos_nec->CurrentValue; // Accumulate total
            }
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->recursos_nec->CurrentValue = $this->recursos_nec->Total;
            $this->recursos_nec->ViewValue = $this->recursos_nec->CurrentValue;
            $this->recursos_nec->ViewValue = FormatCurrency($this->recursos_nec->ViewValue, $this->recursos_nec->formatPattern());
            $this->recursos_nec->CssClass = "fw-bold";
            $this->recursos_nec->CellCssStyle .= "text-align: right;";
            $this->recursos_nec->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->idplano_acao);
                    $doc->exportCaption($this->risco_oportunidade_idrisco_oportunidade);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->o_q_sera_feito);
                    $doc->exportCaption($this->efeito_esperado);
                    $doc->exportCaption($this->departamentos_iddepartamentos);
                    $doc->exportCaption($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                    $doc->exportCaption($this->recursos_nec);
                    $doc->exportCaption($this->dt_limite);
                    $doc->exportCaption($this->implementado);
                    $doc->exportCaption($this->periodicidade_idperiodicidade);
                    $doc->exportCaption($this->eficaz);
                } else {
                    $doc->exportCaption($this->idplano_acao);
                    $doc->exportCaption($this->risco_oportunidade_idrisco_oportunidade);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->departamentos_iddepartamentos);
                    $doc->exportCaption($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                    $doc->exportCaption($this->recursos_nec);
                    $doc->exportCaption($this->dt_limite);
                    $doc->exportCaption($this->implementado);
                    $doc->exportCaption($this->periodicidade_idperiodicidade);
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
                        $doc->exportField($this->idplano_acao);
                        $doc->exportField($this->risco_oportunidade_idrisco_oportunidade);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->o_q_sera_feito);
                        $doc->exportField($this->efeito_esperado);
                        $doc->exportField($this->departamentos_iddepartamentos);
                        $doc->exportField($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                        $doc->exportField($this->recursos_nec);
                        $doc->exportField($this->dt_limite);
                        $doc->exportField($this->implementado);
                        $doc->exportField($this->periodicidade_idperiodicidade);
                        $doc->exportField($this->eficaz);
                    } else {
                        $doc->exportField($this->idplano_acao);
                        $doc->exportField($this->risco_oportunidade_idrisco_oportunidade);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->departamentos_iddepartamentos);
                        $doc->exportField($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                        $doc->exportField($this->recursos_nec);
                        $doc->exportField($this->dt_limite);
                        $doc->exportField($this->implementado);
                        $doc->exportField($this->periodicidade_idperiodicidade);
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
                $doc->exportAggregate($this->idplano_acao, '');
                $doc->exportAggregate($this->risco_oportunidade_idrisco_oportunidade, '');
                $doc->exportAggregate($this->dt_cadastro, '');
                $doc->exportAggregate($this->departamentos_iddepartamentos, '');
                $doc->exportAggregate($this->origem_risco_oportunidade_idorigem_risco_oportunidade, '');
                $doc->exportAggregate($this->recursos_nec, 'TOTAL');
                $doc->exportAggregate($this->dt_limite, '');
                $doc->exportAggregate($this->implementado, '');
                $doc->exportAggregate($this->periodicidade_idperiodicidade, '');
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
