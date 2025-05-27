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
 * Table class for processo
 */
class Processo extends DbTable
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
    public $idprocesso;
    public $dt_cadastro;
    public $revisao;
    public $tipo_idtipo;
    public $processo;
    public $responsaveis;
    public $objetivo;
    public $proc_antes;
    public $proc_depois;
    public $eqpto_recursos;
    public $entradas;
    public $atividade_principal;
    public $saidas_resultados;
    public $requsito_saidas;
    public $riscos;
    public $oportunidades;
    public $propriedade_externa;
    public $conhecimentos;
    public $documentos_aplicados;
    public $proced_int_trabalho;
    public $mapa;
    public $formulario;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "processo";
        $this->TableName = 'processo';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "processo";
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

        // idprocesso
        $this->idprocesso = new DbField(
            $this, // Table
            'x_idprocesso', // Variable name
            'idprocesso', // Name
            '`idprocesso`', // Expression
            '`idprocesso`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idprocesso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idprocesso->InputTextType = "text";
        $this->idprocesso->Raw = true;
        $this->idprocesso->IsAutoIncrement = true; // Autoincrement field
        $this->idprocesso->IsPrimaryKey = true; // Primary key field
        $this->idprocesso->IsForeignKey = true; // Foreign key field
        $this->idprocesso->Nullable = false; // NOT NULL field
        $this->idprocesso->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idprocesso->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idprocesso'] = &$this->idprocesso;

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
        $this->dt_cadastro->InputTextType = "text";
        $this->dt_cadastro->Raw = true;
        $this->dt_cadastro->Nullable = false; // NOT NULL field
        $this->dt_cadastro->Required = true; // Required field
        $this->dt_cadastro->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dt_cadastro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dt_cadastro'] = &$this->dt_cadastro;

        // revisao
        $this->revisao = new DbField(
            $this, // Table
            'x_revisao', // Variable name
            'revisao', // Name
            '`revisao`', // Expression
            '`revisao`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`revisao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->revisao->InputTextType = "text";
        $this->revisao->Nullable = false; // NOT NULL field
        $this->revisao->Required = true; // Required field
        $this->revisao->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['revisao'] = &$this->revisao;

        // tipo_idtipo
        $this->tipo_idtipo = new DbField(
            $this, // Table
            'x_tipo_idtipo', // Variable name
            'tipo_idtipo', // Name
            '`tipo_idtipo`', // Expression
            '`tipo_idtipo`', // Basic search expression
            19, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_idtipo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->tipo_idtipo->addMethod("getDefault", fn() => 1);
        $this->tipo_idtipo->InputTextType = "text";
        $this->tipo_idtipo->Raw = true;
        $this->tipo_idtipo->Nullable = false; // NOT NULL field
        $this->tipo_idtipo->Lookup = new Lookup($this->tipo_idtipo, 'tipo', false, 'idtipo', ["tipo","","",""], '', '', [], [], [], [], [], [], false, '', '', "`tipo`");
        $this->tipo_idtipo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipo_idtipo->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['tipo_idtipo'] = &$this->tipo_idtipo;

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
        $this->processo->Nullable = false; // NOT NULL field
        $this->processo->Required = true; // Required field
        $this->processo->UseFilter = true; // Table header filter
        $this->processo->Lookup = new Lookup($this->processo, 'processo', true, 'processo', ["processo","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->processo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['processo'] = &$this->processo;

        // responsaveis
        $this->responsaveis = new DbField(
            $this, // Table
            'x_responsaveis', // Variable name
            'responsaveis', // Name
            '`responsaveis`', // Expression
            '`responsaveis`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`responsaveis`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->responsaveis->InputTextType = "text";
        $this->responsaveis->Nullable = false; // NOT NULL field
        $this->responsaveis->Required = true; // Required field
        $this->responsaveis->Lookup = new Lookup($this->responsaveis, 'departamentos', false, 'iddepartamentos', ["departamento","","",""], '', '', [], [], [], [], [], [], false, '`departamento` ASC', '', "`departamento`");
        $this->responsaveis->SearchOperators = ["=", "<>"];
        $this->Fields['responsaveis'] = &$this->responsaveis;

        // objetivo
        $this->objetivo = new DbField(
            $this, // Table
            'x_objetivo', // Variable name
            'objetivo', // Name
            '`objetivo`', // Expression
            '`objetivo`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`objetivo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->objetivo->InputTextType = "text";
        $this->objetivo->Nullable = false; // NOT NULL field
        $this->objetivo->Required = true; // Required field
        $this->objetivo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['objetivo'] = &$this->objetivo;

        // proc_antes
        $this->proc_antes = new DbField(
            $this, // Table
            'x_proc_antes', // Variable name
            'proc_antes', // Name
            '`proc_antes`', // Expression
            '`proc_antes`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`proc_antes`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->proc_antes->addMethod("getSelectFilter", fn() => "`tipo_idtipo`=1");
        $this->proc_antes->InputTextType = "text";
        $this->proc_antes->Raw = true;
        $this->proc_antes->Nullable = false; // NOT NULL field
        $this->proc_antes->Required = true; // Required field
        $this->proc_antes->Lookup = new Lookup($this->proc_antes, 'processo', false, 'idprocesso', ["processo","","",""], '', '', [], [], [], [], [], [], false, '`processo` ASC', '', "`processo`");
        $this->proc_antes->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proc_antes->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['proc_antes'] = &$this->proc_antes;

        // proc_depois
        $this->proc_depois = new DbField(
            $this, // Table
            'x_proc_depois', // Variable name
            'proc_depois', // Name
            '`proc_depois`', // Expression
            '`proc_depois`', // Basic search expression
            3, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`proc_depois`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->proc_depois->addMethod("getSelectFilter", fn() => "`tipo_idtipo`=1");
        $this->proc_depois->InputTextType = "text";
        $this->proc_depois->Raw = true;
        $this->proc_depois->Nullable = false; // NOT NULL field
        $this->proc_depois->Required = true; // Required field
        $this->proc_depois->Lookup = new Lookup($this->proc_depois, 'processo', false, 'idprocesso', ["processo","","",""], '', '', [], [], [], [], [], [], false, '`processo` ASC', '', "`processo`");
        $this->proc_depois->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proc_depois->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['proc_depois'] = &$this->proc_depois;

        // eqpto_recursos
        $this->eqpto_recursos = new DbField(
            $this, // Table
            'x_eqpto_recursos', // Variable name
            'eqpto_recursos', // Name
            '`eqpto_recursos`', // Expression
            '`eqpto_recursos`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`eqpto_recursos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->eqpto_recursos->InputTextType = "text";
        $this->eqpto_recursos->Nullable = false; // NOT NULL field
        $this->eqpto_recursos->Required = true; // Required field
        $this->eqpto_recursos->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['eqpto_recursos'] = &$this->eqpto_recursos;

        // entradas
        $this->entradas = new DbField(
            $this, // Table
            'x_entradas', // Variable name
            'entradas', // Name
            '`entradas`', // Expression
            '`entradas`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`entradas`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->entradas->InputTextType = "text";
        $this->entradas->Nullable = false; // NOT NULL field
        $this->entradas->Required = true; // Required field
        $this->entradas->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['entradas'] = &$this->entradas;

        // atividade_principal
        $this->atividade_principal = new DbField(
            $this, // Table
            'x_atividade_principal', // Variable name
            'atividade_principal', // Name
            '`atividade_principal`', // Expression
            '`atividade_principal`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`atividade_principal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->atividade_principal->InputTextType = "text";
        $this->atividade_principal->Nullable = false; // NOT NULL field
        $this->atividade_principal->Required = true; // Required field
        $this->atividade_principal->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['atividade_principal'] = &$this->atividade_principal;

        // saidas_resultados
        $this->saidas_resultados = new DbField(
            $this, // Table
            'x_saidas_resultados', // Variable name
            'saidas_resultados', // Name
            '`saidas_resultados`', // Expression
            '`saidas_resultados`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`saidas_resultados`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->saidas_resultados->InputTextType = "text";
        $this->saidas_resultados->Nullable = false; // NOT NULL field
        $this->saidas_resultados->Required = true; // Required field
        $this->saidas_resultados->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['saidas_resultados'] = &$this->saidas_resultados;

        // requsito_saidas
        $this->requsito_saidas = new DbField(
            $this, // Table
            'x_requsito_saidas', // Variable name
            'requsito_saidas', // Name
            '`requsito_saidas`', // Expression
            '`requsito_saidas`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`requsito_saidas`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->requsito_saidas->InputTextType = "text";
        $this->requsito_saidas->Nullable = false; // NOT NULL field
        $this->requsito_saidas->Required = true; // Required field
        $this->requsito_saidas->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['requsito_saidas'] = &$this->requsito_saidas;

        // riscos
        $this->riscos = new DbField(
            $this, // Table
            'x_riscos', // Variable name
            'riscos', // Name
            '`riscos`', // Expression
            '`riscos`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`riscos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->riscos->InputTextType = "text";
        $this->riscos->Nullable = false; // NOT NULL field
        $this->riscos->Required = true; // Required field
        $this->riscos->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['riscos'] = &$this->riscos;

        // oportunidades
        $this->oportunidades = new DbField(
            $this, // Table
            'x_oportunidades', // Variable name
            'oportunidades', // Name
            '`oportunidades`', // Expression
            '`oportunidades`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`oportunidades`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->oportunidades->InputTextType = "text";
        $this->oportunidades->Nullable = false; // NOT NULL field
        $this->oportunidades->Required = true; // Required field
        $this->oportunidades->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['oportunidades'] = &$this->oportunidades;

        // propriedade_externa
        $this->propriedade_externa = new DbField(
            $this, // Table
            'x_propriedade_externa', // Variable name
            'propriedade_externa', // Name
            '`propriedade_externa`', // Expression
            '`propriedade_externa`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`propriedade_externa`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->propriedade_externa->InputTextType = "text";
        $this->propriedade_externa->Nullable = false; // NOT NULL field
        $this->propriedade_externa->Required = true; // Required field
        $this->propriedade_externa->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['propriedade_externa'] = &$this->propriedade_externa;

        // conhecimentos
        $this->conhecimentos = new DbField(
            $this, // Table
            'x_conhecimentos', // Variable name
            'conhecimentos', // Name
            '`conhecimentos`', // Expression
            '`conhecimentos`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`conhecimentos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->conhecimentos->InputTextType = "text";
        $this->conhecimentos->Nullable = false; // NOT NULL field
        $this->conhecimentos->Required = true; // Required field
        $this->conhecimentos->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['conhecimentos'] = &$this->conhecimentos;

        // documentos_aplicados
        $this->documentos_aplicados = new DbField(
            $this, // Table
            'x_documentos_aplicados', // Variable name
            'documentos_aplicados', // Name
            '`documentos_aplicados`', // Expression
            '`documentos_aplicados`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`documentos_aplicados`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->documentos_aplicados->InputTextType = "text";
        $this->documentos_aplicados->Nullable = false; // NOT NULL field
        $this->documentos_aplicados->Required = true; // Required field
        $this->documentos_aplicados->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['documentos_aplicados'] = &$this->documentos_aplicados;

        // proced_int_trabalho
        $this->proced_int_trabalho = new DbField(
            $this, // Table
            'x_proced_int_trabalho', // Variable name
            'proced_int_trabalho', // Name
            '`proced_int_trabalho`', // Expression
            '`proced_int_trabalho`', // Basic search expression
            200, // Type
            120, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`proced_int_trabalho`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'FILE' // Edit Tag
        );
        $this->proced_int_trabalho->InputTextType = "text";
        $this->proced_int_trabalho->Nullable = false; // NOT NULL field
        $this->proced_int_trabalho->Required = true; // Required field
        $this->proced_int_trabalho->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['proced_int_trabalho'] = &$this->proced_int_trabalho;

        // mapa
        $this->mapa = new DbField(
            $this, // Table
            'x_mapa', // Variable name
            'mapa', // Name
            '`mapa`', // Expression
            '`mapa`', // Basic search expression
            200, // Type
            120, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`mapa`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'FILE' // Edit Tag
        );
        $this->mapa->InputTextType = "text";
        $this->mapa->Nullable = false; // NOT NULL field
        $this->mapa->Required = true; // Required field
        $this->mapa->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['mapa'] = &$this->mapa;

        // formulario
        $this->formulario = new DbField(
            $this, // Table
            'x_formulario', // Variable name
            'formulario', // Name
            '`formulario`', // Expression
            '`formulario`', // Basic search expression
            200, // Type
            120, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`formulario`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'FILE' // Edit Tag
        );
        $this->formulario->InputTextType = "text";
        $this->formulario->UploadMultiple = true;
        $this->formulario->Upload->UploadMultiple = true;
        $this->formulario->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['formulario'] = &$this->formulario;

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
        if ($this->getCurrentDetailTable() == "processo_indicadores") {
            $detailUrl = Container("processo_indicadores")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idprocesso", $this->idprocesso->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ProcessoList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "processo";
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
            $this->idprocesso->setDbValue($conn->lastInsertId());
            $rs['idprocesso'] = $this->idprocesso->DbValue;
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
        // Cascade Update detail table 'processo_indicadores'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['idprocesso']) && $rsold['idprocesso'] != $rs['idprocesso'])) { // Update detail field 'processo_idprocesso'
            $cascadeUpdate = true;
            $rscascade['processo_idprocesso'] = $rs['idprocesso'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("processo_indicadores")->loadRs("`processo_idprocesso` = " . QuotedValue($rsold['idprocesso'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'idprocesso_indicadores';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("processo_indicadores")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("processo_indicadores")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("processo_indicadores")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['idprocesso']) && !EmptyValue($this->idprocesso->CurrentValue)) {
                $rs['idprocesso'] = $this->idprocesso->CurrentValue;
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
            if (array_key_exists('idprocesso', $rs)) {
                AddFilter($where, QuotedName('idprocesso', $this->Dbid) . '=' . QuotedValue($rs['idprocesso'], $this->idprocesso->DataType, $this->Dbid));
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

        // Cascade delete detail table 'processo_indicadores'
        $dtlrows = Container("processo_indicadores")->loadRs("`processo_idprocesso` = " . QuotedValue($rs['idprocesso'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("processo_indicadores")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("processo_indicadores")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("processo_indicadores")->rowDeleted($dtlrow);
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
        $this->idprocesso->DbValue = $row['idprocesso'];
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->revisao->DbValue = $row['revisao'];
        $this->tipo_idtipo->DbValue = $row['tipo_idtipo'];
        $this->processo->DbValue = $row['processo'];
        $this->responsaveis->DbValue = $row['responsaveis'];
        $this->objetivo->DbValue = $row['objetivo'];
        $this->proc_antes->DbValue = $row['proc_antes'];
        $this->proc_depois->DbValue = $row['proc_depois'];
        $this->eqpto_recursos->DbValue = $row['eqpto_recursos'];
        $this->entradas->DbValue = $row['entradas'];
        $this->atividade_principal->DbValue = $row['atividade_principal'];
        $this->saidas_resultados->DbValue = $row['saidas_resultados'];
        $this->requsito_saidas->DbValue = $row['requsito_saidas'];
        $this->riscos->DbValue = $row['riscos'];
        $this->oportunidades->DbValue = $row['oportunidades'];
        $this->propriedade_externa->DbValue = $row['propriedade_externa'];
        $this->conhecimentos->DbValue = $row['conhecimentos'];
        $this->documentos_aplicados->DbValue = $row['documentos_aplicados'];
        $this->proced_int_trabalho->Upload->DbValue = $row['proced_int_trabalho'];
        $this->mapa->Upload->DbValue = $row['mapa'];
        $this->formulario->Upload->DbValue = $row['formulario'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['proced_int_trabalho']) ? [] : [$row['proced_int_trabalho']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->proced_int_trabalho->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->proced_int_trabalho->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['mapa']) ? [] : [$row['mapa']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->mapa->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->mapa->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['formulario']) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $row['formulario']);
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->formulario->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->formulario->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idprocesso` = @idprocesso@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idprocesso->CurrentValue : $this->idprocesso->OldValue;
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
                $this->idprocesso->CurrentValue = $keys[0];
            } else {
                $this->idprocesso->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idprocesso', $row) ? $row['idprocesso'] : null;
        } else {
            $val = !EmptyValue($this->idprocesso->OldValue) && !$current ? $this->idprocesso->OldValue : $this->idprocesso->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idprocesso@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ProcessoList");
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
            "ProcessoView" => $Language->phrase("View"),
            "ProcessoEdit" => $Language->phrase("Edit"),
            "ProcessoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ProcessoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ProcessoView",
            Config("API_ADD_ACTION") => "ProcessoAdd",
            Config("API_EDIT_ACTION") => "ProcessoEdit",
            Config("API_DELETE_ACTION") => "ProcessoDelete",
            Config("API_LIST_ACTION") => "ProcessoList",
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
        return "ProcessoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ProcessoView", $parm);
        } else {
            $url = $this->keyUrl("ProcessoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ProcessoAdd?" . $parm;
        } else {
            $url = "ProcessoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ProcessoEdit", $parm);
        } else {
            $url = $this->keyUrl("ProcessoEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ProcessoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ProcessoAdd", $parm);
        } else {
            $url = $this->keyUrl("ProcessoAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ProcessoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ProcessoDelete", $parm);
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
        $json .= "\"idprocesso\":" . VarToJson($this->idprocesso->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idprocesso->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idprocesso->CurrentValue);
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
            if (($keyValue = Param("idprocesso") ?? Route("idprocesso")) !== null) {
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
                $this->idprocesso->CurrentValue = $key;
            } else {
                $this->idprocesso->OldValue = $key;
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
        $this->idprocesso->setDbValue($row['idprocesso']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->revisao->setDbValue($row['revisao']);
        $this->tipo_idtipo->setDbValue($row['tipo_idtipo']);
        $this->processo->setDbValue($row['processo']);
        $this->responsaveis->setDbValue($row['responsaveis']);
        $this->objetivo->setDbValue($row['objetivo']);
        $this->proc_antes->setDbValue($row['proc_antes']);
        $this->proc_depois->setDbValue($row['proc_depois']);
        $this->eqpto_recursos->setDbValue($row['eqpto_recursos']);
        $this->entradas->setDbValue($row['entradas']);
        $this->atividade_principal->setDbValue($row['atividade_principal']);
        $this->saidas_resultados->setDbValue($row['saidas_resultados']);
        $this->requsito_saidas->setDbValue($row['requsito_saidas']);
        $this->riscos->setDbValue($row['riscos']);
        $this->oportunidades->setDbValue($row['oportunidades']);
        $this->propriedade_externa->setDbValue($row['propriedade_externa']);
        $this->conhecimentos->setDbValue($row['conhecimentos']);
        $this->documentos_aplicados->setDbValue($row['documentos_aplicados']);
        $this->proced_int_trabalho->Upload->DbValue = $row['proced_int_trabalho'];
        $this->mapa->Upload->DbValue = $row['mapa'];
        $this->formulario->Upload->DbValue = $row['formulario'];
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ProcessoList";
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

        // idprocesso

        // dt_cadastro

        // revisao

        // tipo_idtipo

        // processo

        // responsaveis

        // objetivo

        // proc_antes

        // proc_depois

        // eqpto_recursos

        // entradas

        // atividade_principal

        // saidas_resultados

        // requsito_saidas

        // riscos

        // oportunidades

        // propriedade_externa

        // conhecimentos

        // documentos_aplicados

        // proced_int_trabalho

        // mapa

        // formulario

        // idprocesso
        $this->idprocesso->ViewValue = $this->idprocesso->CurrentValue;

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->CssClass = "fw-bold";

        // revisao
        $this->revisao->ViewValue = $this->revisao->CurrentValue;
        $this->revisao->CssClass = "fw-bold";
        $this->revisao->CellCssStyle .= "text-align: center;";

        // tipo_idtipo
        $curVal = strval($this->tipo_idtipo->CurrentValue);
        if ($curVal != "") {
            $this->tipo_idtipo->ViewValue = $this->tipo_idtipo->lookupCacheOption($curVal);
            if ($this->tipo_idtipo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchExpression(), "=", $curVal, $this->tipo_idtipo->Lookup->getTable()->Fields["idtipo"]->searchDataType(), "");
                $sqlWrk = $this->tipo_idtipo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo_idtipo->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo_idtipo->ViewValue = $this->tipo_idtipo->displayValue($arwrk);
                } else {
                    $this->tipo_idtipo->ViewValue = FormatNumber($this->tipo_idtipo->CurrentValue, $this->tipo_idtipo->formatPattern());
                }
            }
        } else {
            $this->tipo_idtipo->ViewValue = null;
        }
        $this->tipo_idtipo->CssClass = "fw-bold";

        // processo
        $this->processo->ViewValue = $this->processo->CurrentValue;
        $this->processo->CssClass = "fw-bold";

        // responsaveis
        $curVal = strval($this->responsaveis->CurrentValue);
        if ($curVal != "") {
            $this->responsaveis->ViewValue = $this->responsaveis->lookupCacheOption($curVal);
            if ($this->responsaveis->ViewValue === null) { // Lookup from database
                $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    AddFilter($filterWrk, SearchFilter($this->responsaveis->Lookup->getTable()->Fields["iddepartamentos"]->searchExpression(), "=", trim($wrk), $this->responsaveis->Lookup->getTable()->Fields["iddepartamentos"]->searchDataType(), ""), "OR");
                }
                $sqlWrk = $this->responsaveis->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->responsaveis->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->responsaveis->Lookup->renderViewRow($row);
                        $this->responsaveis->ViewValue->add($this->responsaveis->displayValue($arwrk));
                    }
                } else {
                    $this->responsaveis->ViewValue = $this->responsaveis->CurrentValue;
                }
            }
        } else {
            $this->responsaveis->ViewValue = null;
        }
        $this->responsaveis->CssClass = "fw-bold";

        // objetivo
        $this->objetivo->ViewValue = $this->objetivo->CurrentValue;
        $this->objetivo->CssClass = "fw-bold";

        // proc_antes
        $curVal = strval($this->proc_antes->CurrentValue);
        if ($curVal != "") {
            $this->proc_antes->ViewValue = $this->proc_antes->lookupCacheOption($curVal);
            if ($this->proc_antes->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->proc_antes->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $curVal, $this->proc_antes->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                $lookupFilter = $this->proc_antes->getSelectFilter($this); // PHP
                $sqlWrk = $this->proc_antes->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->proc_antes->Lookup->renderViewRow($rswrk[0]);
                    $this->proc_antes->ViewValue = $this->proc_antes->displayValue($arwrk);
                } else {
                    $this->proc_antes->ViewValue = FormatNumber($this->proc_antes->CurrentValue, $this->proc_antes->formatPattern());
                }
            }
        } else {
            $this->proc_antes->ViewValue = null;
        }
        $this->proc_antes->CssClass = "fw-bold";

        // proc_depois
        $curVal = strval($this->proc_depois->CurrentValue);
        if ($curVal != "") {
            $this->proc_depois->ViewValue = $this->proc_depois->lookupCacheOption($curVal);
            if ($this->proc_depois->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->proc_depois->Lookup->getTable()->Fields["idprocesso"]->searchExpression(), "=", $curVal, $this->proc_depois->Lookup->getTable()->Fields["idprocesso"]->searchDataType(), "");
                $lookupFilter = $this->proc_depois->getSelectFilter($this); // PHP
                $sqlWrk = $this->proc_depois->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->proc_depois->Lookup->renderViewRow($rswrk[0]);
                    $this->proc_depois->ViewValue = $this->proc_depois->displayValue($arwrk);
                } else {
                    $this->proc_depois->ViewValue = FormatNumber($this->proc_depois->CurrentValue, $this->proc_depois->formatPattern());
                }
            }
        } else {
            $this->proc_depois->ViewValue = null;
        }
        $this->proc_depois->CssClass = "fw-bold";

        // eqpto_recursos
        $this->eqpto_recursos->ViewValue = $this->eqpto_recursos->CurrentValue;
        $this->eqpto_recursos->CssClass = "fw-bold";

        // entradas
        $this->entradas->ViewValue = $this->entradas->CurrentValue;
        $this->entradas->CssClass = "fw-bold";

        // atividade_principal
        $this->atividade_principal->ViewValue = $this->atividade_principal->CurrentValue;
        $this->atividade_principal->CssClass = "fw-bold";

        // saidas_resultados
        $this->saidas_resultados->ViewValue = $this->saidas_resultados->CurrentValue;
        $this->saidas_resultados->CssClass = "fw-bold";

        // requsito_saidas
        $this->requsito_saidas->ViewValue = $this->requsito_saidas->CurrentValue;
        $this->requsito_saidas->CssClass = "fw-bold";

        // riscos
        $this->riscos->ViewValue = $this->riscos->CurrentValue;
        $this->riscos->CssClass = "fw-bold";

        // oportunidades
        $this->oportunidades->ViewValue = $this->oportunidades->CurrentValue;
        $this->oportunidades->CssClass = "fw-bold";

        // propriedade_externa
        $this->propriedade_externa->ViewValue = $this->propriedade_externa->CurrentValue;
        $this->propriedade_externa->CssClass = "fw-bold";

        // conhecimentos
        $this->conhecimentos->ViewValue = $this->conhecimentos->CurrentValue;
        $this->conhecimentos->CssClass = "fw-bold";

        // documentos_aplicados
        $this->documentos_aplicados->ViewValue = $this->documentos_aplicados->CurrentValue;
        $this->documentos_aplicados->CssClass = "fw-bold";

        // proced_int_trabalho
        if (!EmptyValue($this->proced_int_trabalho->Upload->DbValue)) {
            $this->proced_int_trabalho->ViewValue = $this->proced_int_trabalho->Upload->DbValue;
        } else {
            $this->proced_int_trabalho->ViewValue = "";
        }
        $this->proced_int_trabalho->CssClass = "fw-bold";

        // mapa
        if (!EmptyValue($this->mapa->Upload->DbValue)) {
            $this->mapa->ViewValue = $this->mapa->Upload->DbValue;
        } else {
            $this->mapa->ViewValue = "";
        }
        $this->mapa->CssClass = "fw-bold";

        // formulario
        if (!EmptyValue($this->formulario->Upload->DbValue)) {
            $this->formulario->ViewValue = $this->formulario->Upload->DbValue;
        } else {
            $this->formulario->ViewValue = "";
        }
        $this->formulario->CssClass = "fw-bold";

        // idprocesso
        $this->idprocesso->HrefValue = "";
        $this->idprocesso->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // revisao
        $this->revisao->HrefValue = "";
        $this->revisao->TooltipValue = "";

        // tipo_idtipo
        $this->tipo_idtipo->HrefValue = "";
        $this->tipo_idtipo->TooltipValue = "";

        // processo
        $this->processo->HrefValue = "";
        $this->processo->TooltipValue = "";

        // responsaveis
        $this->responsaveis->HrefValue = "";
        $this->responsaveis->TooltipValue = "";

        // objetivo
        $this->objetivo->HrefValue = "";
        $this->objetivo->TooltipValue = "";

        // proc_antes
        $this->proc_antes->HrefValue = "";
        $this->proc_antes->TooltipValue = "";

        // proc_depois
        $this->proc_depois->HrefValue = "";
        $this->proc_depois->TooltipValue = "";

        // eqpto_recursos
        $this->eqpto_recursos->HrefValue = "";
        $this->eqpto_recursos->TooltipValue = "";

        // entradas
        $this->entradas->HrefValue = "";
        $this->entradas->TooltipValue = "";

        // atividade_principal
        $this->atividade_principal->HrefValue = "";
        $this->atividade_principal->TooltipValue = "";

        // saidas_resultados
        $this->saidas_resultados->HrefValue = "";
        $this->saidas_resultados->TooltipValue = "";

        // requsito_saidas
        $this->requsito_saidas->HrefValue = "";
        $this->requsito_saidas->TooltipValue = "";

        // riscos
        $this->riscos->HrefValue = "";
        $this->riscos->TooltipValue = "";

        // oportunidades
        $this->oportunidades->HrefValue = "";
        $this->oportunidades->TooltipValue = "";

        // propriedade_externa
        $this->propriedade_externa->HrefValue = "";
        $this->propriedade_externa->TooltipValue = "";

        // conhecimentos
        $this->conhecimentos->HrefValue = "";
        $this->conhecimentos->TooltipValue = "";

        // documentos_aplicados
        $this->documentos_aplicados->HrefValue = "";
        $this->documentos_aplicados->TooltipValue = "";

        // proced_int_trabalho
        $this->proced_int_trabalho->HrefValue = "";
        $this->proced_int_trabalho->ExportHrefValue = $this->proced_int_trabalho->UploadPath . $this->proced_int_trabalho->Upload->DbValue;
        $this->proced_int_trabalho->TooltipValue = "";

        // mapa
        $this->mapa->HrefValue = "";
        $this->mapa->ExportHrefValue = $this->mapa->UploadPath . $this->mapa->Upload->DbValue;
        $this->mapa->TooltipValue = "";

        // formulario
        $this->formulario->HrefValue = "";
        $this->formulario->ExportHrefValue = $this->formulario->UploadPath . $this->formulario->Upload->DbValue;
        $this->formulario->TooltipValue = "";

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

        // idprocesso
        $this->idprocesso->setupEditAttributes();
        $this->idprocesso->EditValue = $this->idprocesso->CurrentValue;

        // dt_cadastro
        $this->dt_cadastro->setupEditAttributes();
        $this->dt_cadastro->EditValue = FormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

        // revisao
        $this->revisao->setupEditAttributes();
        if (!$this->revisao->Raw) {
            $this->revisao->CurrentValue = HtmlDecode($this->revisao->CurrentValue);
        }
        $this->revisao->EditValue = $this->revisao->CurrentValue;
        $this->revisao->PlaceHolder = RemoveHtml($this->revisao->caption());

        // tipo_idtipo
        $this->tipo_idtipo->PlaceHolder = RemoveHtml($this->tipo_idtipo->caption());

        // processo
        $this->processo->setupEditAttributes();
        if (!$this->processo->Raw) {
            $this->processo->CurrentValue = HtmlDecode($this->processo->CurrentValue);
        }
        $this->processo->EditValue = $this->processo->CurrentValue;
        $this->processo->PlaceHolder = RemoveHtml($this->processo->caption());

        // responsaveis
        $this->responsaveis->PlaceHolder = RemoveHtml($this->responsaveis->caption());

        // objetivo
        $this->objetivo->setupEditAttributes();
        $this->objetivo->EditValue = $this->objetivo->CurrentValue;
        $this->objetivo->PlaceHolder = RemoveHtml($this->objetivo->caption());

        // proc_antes
        $this->proc_antes->PlaceHolder = RemoveHtml($this->proc_antes->caption());

        // proc_depois
        $this->proc_depois->PlaceHolder = RemoveHtml($this->proc_depois->caption());

        // eqpto_recursos
        $this->eqpto_recursos->setupEditAttributes();
        $this->eqpto_recursos->EditValue = $this->eqpto_recursos->CurrentValue;
        $this->eqpto_recursos->PlaceHolder = RemoveHtml($this->eqpto_recursos->caption());

        // entradas
        $this->entradas->setupEditAttributes();
        $this->entradas->EditValue = $this->entradas->CurrentValue;
        $this->entradas->PlaceHolder = RemoveHtml($this->entradas->caption());

        // atividade_principal
        $this->atividade_principal->setupEditAttributes();
        $this->atividade_principal->EditValue = $this->atividade_principal->CurrentValue;
        $this->atividade_principal->PlaceHolder = RemoveHtml($this->atividade_principal->caption());

        // saidas_resultados
        $this->saidas_resultados->setupEditAttributes();
        $this->saidas_resultados->EditValue = $this->saidas_resultados->CurrentValue;
        $this->saidas_resultados->PlaceHolder = RemoveHtml($this->saidas_resultados->caption());

        // requsito_saidas
        $this->requsito_saidas->setupEditAttributes();
        $this->requsito_saidas->EditValue = $this->requsito_saidas->CurrentValue;
        $this->requsito_saidas->PlaceHolder = RemoveHtml($this->requsito_saidas->caption());

        // riscos
        $this->riscos->setupEditAttributes();
        $this->riscos->EditValue = $this->riscos->CurrentValue;
        $this->riscos->PlaceHolder = RemoveHtml($this->riscos->caption());

        // oportunidades
        $this->oportunidades->setupEditAttributes();
        $this->oportunidades->EditValue = $this->oportunidades->CurrentValue;
        $this->oportunidades->PlaceHolder = RemoveHtml($this->oportunidades->caption());

        // propriedade_externa
        $this->propriedade_externa->setupEditAttributes();
        $this->propriedade_externa->EditValue = $this->propriedade_externa->CurrentValue;
        $this->propriedade_externa->PlaceHolder = RemoveHtml($this->propriedade_externa->caption());

        // conhecimentos
        $this->conhecimentos->setupEditAttributes();
        $this->conhecimentos->EditValue = $this->conhecimentos->CurrentValue;
        $this->conhecimentos->PlaceHolder = RemoveHtml($this->conhecimentos->caption());

        // documentos_aplicados
        $this->documentos_aplicados->setupEditAttributes();
        $this->documentos_aplicados->EditValue = $this->documentos_aplicados->CurrentValue;
        $this->documentos_aplicados->PlaceHolder = RemoveHtml($this->documentos_aplicados->caption());

        // proced_int_trabalho
        $this->proced_int_trabalho->setupEditAttributes();
        if (!EmptyValue($this->proced_int_trabalho->Upload->DbValue)) {
            $this->proced_int_trabalho->EditValue = $this->proced_int_trabalho->Upload->DbValue;
        } else {
            $this->proced_int_trabalho->EditValue = "";
        }
        if (!EmptyValue($this->proced_int_trabalho->CurrentValue)) {
            $this->proced_int_trabalho->Upload->FileName = $this->proced_int_trabalho->CurrentValue;
        }

        // mapa
        $this->mapa->setupEditAttributes();
        if (!EmptyValue($this->mapa->Upload->DbValue)) {
            $this->mapa->EditValue = $this->mapa->Upload->DbValue;
        } else {
            $this->mapa->EditValue = "";
        }
        if (!EmptyValue($this->mapa->CurrentValue)) {
            $this->mapa->Upload->FileName = $this->mapa->CurrentValue;
        }

        // formulario
        $this->formulario->setupEditAttributes();
        if (!EmptyValue($this->formulario->Upload->DbValue)) {
            $this->formulario->EditValue = $this->formulario->Upload->DbValue;
        } else {
            $this->formulario->EditValue = "";
        }
        if (!EmptyValue($this->formulario->CurrentValue)) {
            $this->formulario->Upload->FileName = $this->formulario->CurrentValue;
        }

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            $this->atividade_principal->Count++; // Increment count
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->atividade_principal->CurrentValue = $this->atividade_principal->Count;
            $this->atividade_principal->ViewValue = $this->atividade_principal->CurrentValue;
            $this->atividade_principal->CssClass = "fw-bold";
            $this->atividade_principal->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->idprocesso);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->revisao);
                    $doc->exportCaption($this->tipo_idtipo);
                    $doc->exportCaption($this->processo);
                    $doc->exportCaption($this->responsaveis);
                    $doc->exportCaption($this->objetivo);
                    $doc->exportCaption($this->proc_antes);
                    $doc->exportCaption($this->proc_depois);
                    $doc->exportCaption($this->eqpto_recursos);
                    $doc->exportCaption($this->entradas);
                    $doc->exportCaption($this->atividade_principal);
                    $doc->exportCaption($this->saidas_resultados);
                    $doc->exportCaption($this->requsito_saidas);
                    $doc->exportCaption($this->riscos);
                    $doc->exportCaption($this->oportunidades);
                    $doc->exportCaption($this->propriedade_externa);
                    $doc->exportCaption($this->conhecimentos);
                    $doc->exportCaption($this->documentos_aplicados);
                    $doc->exportCaption($this->proced_int_trabalho);
                    $doc->exportCaption($this->mapa);
                    $doc->exportCaption($this->formulario);
                } else {
                    $doc->exportCaption($this->idprocesso);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->revisao);
                    $doc->exportCaption($this->tipo_idtipo);
                    $doc->exportCaption($this->processo);
                    $doc->exportCaption($this->responsaveis);
                    $doc->exportCaption($this->proc_antes);
                    $doc->exportCaption($this->proc_depois);
                    $doc->exportCaption($this->proced_int_trabalho);
                    $doc->exportCaption($this->mapa);
                    $doc->exportCaption($this->formulario);
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
                        $doc->exportField($this->idprocesso);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->revisao);
                        $doc->exportField($this->tipo_idtipo);
                        $doc->exportField($this->processo);
                        $doc->exportField($this->responsaveis);
                        $doc->exportField($this->objetivo);
                        $doc->exportField($this->proc_antes);
                        $doc->exportField($this->proc_depois);
                        $doc->exportField($this->eqpto_recursos);
                        $doc->exportField($this->entradas);
                        $doc->exportField($this->atividade_principal);
                        $doc->exportField($this->saidas_resultados);
                        $doc->exportField($this->requsito_saidas);
                        $doc->exportField($this->riscos);
                        $doc->exportField($this->oportunidades);
                        $doc->exportField($this->propriedade_externa);
                        $doc->exportField($this->conhecimentos);
                        $doc->exportField($this->documentos_aplicados);
                        $doc->exportField($this->proced_int_trabalho);
                        $doc->exportField($this->mapa);
                        $doc->exportField($this->formulario);
                    } else {
                        $doc->exportField($this->idprocesso);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->revisao);
                        $doc->exportField($this->tipo_idtipo);
                        $doc->exportField($this->processo);
                        $doc->exportField($this->responsaveis);
                        $doc->exportField($this->proc_antes);
                        $doc->exportField($this->proc_depois);
                        $doc->exportField($this->proced_int_trabalho);
                        $doc->exportField($this->mapa);
                        $doc->exportField($this->formulario);
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
                $doc->exportAggregate($this->idprocesso, '');
                $doc->exportAggregate($this->dt_cadastro, '');
                $doc->exportAggregate($this->revisao, '');
                $doc->exportAggregate($this->tipo_idtipo, '');
                $doc->exportAggregate($this->processo, '');
                $doc->exportAggregate($this->responsaveis, '');
                $doc->exportAggregate($this->proc_antes, '');
                $doc->exportAggregate($this->proc_depois, '');
                $doc->exportAggregate($this->proced_int_trabalho, '');
                $doc->exportAggregate($this->mapa, '');
                $doc->exportAggregate($this->formulario, '');
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
        if ($fldparm == 'proced_int_trabalho') {
            $fldName = "proced_int_trabalho";
            $fileNameFld = "proced_int_trabalho";
        } elseif ($fldparm == 'mapa') {
            $fldName = "mapa";
            $fileNameFld = "mapa";
        } elseif ($fldparm == 'formulario') {
            $fldName = "formulario";
            $fileNameFld = "formulario";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->idprocesso->CurrentValue = $ar[0];
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
