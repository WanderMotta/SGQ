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
 * Table class for analise_critica_direcao
 */
class AnaliseCriticaDirecao extends DbTable
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
    public $idanalise_critica_direcao;
    public $data;
    public $participantes;
    public $usuario_idusuario;
    public $situacao_anterior;
    public $mudanca_sqg;
    public $desempenho_eficacia;
    public $satisfacao_cliente;
    public $objetivos_alcancados;
    public $desempenho_processo;
    public $nao_confomidade_acoes_corretivas;
    public $monitoramento_medicao;
    public $resultado_auditoria;
    public $desempenho_provedores_ext;
    public $suficiencia_recursos;
    public $acoes_risco_oportunidades;
    public $oportunidade_melhora_entrada;
    public $oportunidade_melhora_saida;
    public $qualquer_mudanca_sgq;
    public $nec_recurso;
    public $anexo;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "analise_critica_direcao";
        $this->TableName = 'analise_critica_direcao';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "analise_critica_direcao";
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

        // idanalise_critica_direcao
        $this->idanalise_critica_direcao = new DbField(
            $this, // Table
            'x_idanalise_critica_direcao', // Variable name
            'idanalise_critica_direcao', // Name
            '`idanalise_critica_direcao`', // Expression
            '`idanalise_critica_direcao`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idanalise_critica_direcao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idanalise_critica_direcao->InputTextType = "text";
        $this->idanalise_critica_direcao->Raw = true;
        $this->idanalise_critica_direcao->IsAutoIncrement = true; // Autoincrement field
        $this->idanalise_critica_direcao->IsPrimaryKey = true; // Primary key field
        $this->idanalise_critica_direcao->Nullable = false; // NOT NULL field
        $this->idanalise_critica_direcao->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idanalise_critica_direcao->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idanalise_critica_direcao'] = &$this->idanalise_critica_direcao;

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

        // participantes
        $this->participantes = new DbField(
            $this, // Table
            'x_participantes', // Variable name
            'participantes', // Name
            '`participantes`', // Expression
            '`participantes`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`participantes`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->participantes->addMethod("getSelectFilter", fn() => "`ativo`='Sim'");
        $this->participantes->InputTextType = "text";
        $this->participantes->Nullable = false; // NOT NULL field
        $this->participantes->Required = true; // Required field
        $this->participantes->Lookup = new Lookup($this->participantes, 'usuario', false, 'idusuario', ["login","","",""], '', '', [], [], [], [], [], [], false, '`login` ASC', '', "`login`");
        $this->participantes->SearchOperators = ["=", "<>"];
        $this->Fields['participantes'] = &$this->participantes;

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

        // situacao_anterior
        $this->situacao_anterior = new DbField(
            $this, // Table
            'x_situacao_anterior', // Variable name
            'situacao_anterior', // Name
            '`situacao_anterior`', // Expression
            '`situacao_anterior`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`situacao_anterior`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->situacao_anterior->InputTextType = "text";
        $this->situacao_anterior->Nullable = false; // NOT NULL field
        $this->situacao_anterior->Required = true; // Required field
        $this->situacao_anterior->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['situacao_anterior'] = &$this->situacao_anterior;

        // mudanca_sqg
        $this->mudanca_sqg = new DbField(
            $this, // Table
            'x_mudanca_sqg', // Variable name
            'mudanca_sqg', // Name
            '`mudanca_sqg`', // Expression
            '`mudanca_sqg`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`mudanca_sqg`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->mudanca_sqg->InputTextType = "text";
        $this->mudanca_sqg->Nullable = false; // NOT NULL field
        $this->mudanca_sqg->Required = true; // Required field
        $this->mudanca_sqg->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['mudanca_sqg'] = &$this->mudanca_sqg;

        // desempenho_eficacia
        $this->desempenho_eficacia = new DbField(
            $this, // Table
            'x_desempenho_eficacia', // Variable name
            'desempenho_eficacia', // Name
            '`desempenho_eficacia`', // Expression
            '`desempenho_eficacia`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`desempenho_eficacia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->desempenho_eficacia->InputTextType = "text";
        $this->desempenho_eficacia->Nullable = false; // NOT NULL field
        $this->desempenho_eficacia->Required = true; // Required field
        $this->desempenho_eficacia->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['desempenho_eficacia'] = &$this->desempenho_eficacia;

        // satisfacao_cliente
        $this->satisfacao_cliente = new DbField(
            $this, // Table
            'x_satisfacao_cliente', // Variable name
            'satisfacao_cliente', // Name
            '`satisfacao_cliente`', // Expression
            '`satisfacao_cliente`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`satisfacao_cliente`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->satisfacao_cliente->InputTextType = "text";
        $this->satisfacao_cliente->Nullable = false; // NOT NULL field
        $this->satisfacao_cliente->Required = true; // Required field
        $this->satisfacao_cliente->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['satisfacao_cliente'] = &$this->satisfacao_cliente;

        // objetivos_alcançados
        $this->objetivos_alcancados = new DbField(
            $this, // Table
            'x_objetivos_alcancados', // Variable name
            'objetivos_alcançados', // Name
            '`objetivos_alcançados`', // Expression
            '`objetivos_alcançados`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`objetivos_alcançados`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->objetivos_alcancados->InputTextType = "text";
        $this->objetivos_alcancados->Nullable = false; // NOT NULL field
        $this->objetivos_alcancados->Required = true; // Required field
        $this->objetivos_alcancados->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['objetivos_alcançados'] = &$this->objetivos_alcancados;

        // desempenho_processo
        $this->desempenho_processo = new DbField(
            $this, // Table
            'x_desempenho_processo', // Variable name
            'desempenho_processo', // Name
            '`desempenho_processo`', // Expression
            '`desempenho_processo`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`desempenho_processo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->desempenho_processo->InputTextType = "text";
        $this->desempenho_processo->Nullable = false; // NOT NULL field
        $this->desempenho_processo->Required = true; // Required field
        $this->desempenho_processo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['desempenho_processo'] = &$this->desempenho_processo;

        // nao_confomidade_acoes_corretivas
        $this->nao_confomidade_acoes_corretivas = new DbField(
            $this, // Table
            'x_nao_confomidade_acoes_corretivas', // Variable name
            'nao_confomidade_acoes_corretivas', // Name
            '`nao_confomidade_acoes_corretivas`', // Expression
            '`nao_confomidade_acoes_corretivas`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nao_confomidade_acoes_corretivas`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->nao_confomidade_acoes_corretivas->InputTextType = "text";
        $this->nao_confomidade_acoes_corretivas->Nullable = false; // NOT NULL field
        $this->nao_confomidade_acoes_corretivas->Required = true; // Required field
        $this->nao_confomidade_acoes_corretivas->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['nao_confomidade_acoes_corretivas'] = &$this->nao_confomidade_acoes_corretivas;

        // monitoramento_medicao
        $this->monitoramento_medicao = new DbField(
            $this, // Table
            'x_monitoramento_medicao', // Variable name
            'monitoramento_medicao', // Name
            '`monitoramento_medicao`', // Expression
            '`monitoramento_medicao`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`monitoramento_medicao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->monitoramento_medicao->InputTextType = "text";
        $this->monitoramento_medicao->Nullable = false; // NOT NULL field
        $this->monitoramento_medicao->Required = true; // Required field
        $this->monitoramento_medicao->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['monitoramento_medicao'] = &$this->monitoramento_medicao;

        // resultado_auditoria
        $this->resultado_auditoria = new DbField(
            $this, // Table
            'x_resultado_auditoria', // Variable name
            'resultado_auditoria', // Name
            '`resultado_auditoria`', // Expression
            '`resultado_auditoria`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`resultado_auditoria`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->resultado_auditoria->InputTextType = "text";
        $this->resultado_auditoria->Nullable = false; // NOT NULL field
        $this->resultado_auditoria->Required = true; // Required field
        $this->resultado_auditoria->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['resultado_auditoria'] = &$this->resultado_auditoria;

        // desempenho_provedores_ext
        $this->desempenho_provedores_ext = new DbField(
            $this, // Table
            'x_desempenho_provedores_ext', // Variable name
            'desempenho_provedores_ext', // Name
            '`desempenho_provedores_ext`', // Expression
            '`desempenho_provedores_ext`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`desempenho_provedores_ext`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->desempenho_provedores_ext->InputTextType = "text";
        $this->desempenho_provedores_ext->Nullable = false; // NOT NULL field
        $this->desempenho_provedores_ext->Required = true; // Required field
        $this->desempenho_provedores_ext->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['desempenho_provedores_ext'] = &$this->desempenho_provedores_ext;

        // suficiencia_recursos
        $this->suficiencia_recursos = new DbField(
            $this, // Table
            'x_suficiencia_recursos', // Variable name
            'suficiencia_recursos', // Name
            '`suficiencia_recursos`', // Expression
            '`suficiencia_recursos`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`suficiencia_recursos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->suficiencia_recursos->InputTextType = "text";
        $this->suficiencia_recursos->Nullable = false; // NOT NULL field
        $this->suficiencia_recursos->Required = true; // Required field
        $this->suficiencia_recursos->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['suficiencia_recursos'] = &$this->suficiencia_recursos;

        // acoes_risco_oportunidades
        $this->acoes_risco_oportunidades = new DbField(
            $this, // Table
            'x_acoes_risco_oportunidades', // Variable name
            'acoes_risco_oportunidades', // Name
            '`acoes_risco_oportunidades`', // Expression
            '`acoes_risco_oportunidades`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`acoes_risco_oportunidades`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->acoes_risco_oportunidades->InputTextType = "text";
        $this->acoes_risco_oportunidades->Nullable = false; // NOT NULL field
        $this->acoes_risco_oportunidades->Required = true; // Required field
        $this->acoes_risco_oportunidades->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['acoes_risco_oportunidades'] = &$this->acoes_risco_oportunidades;

        // oportunidade_melhora_entrada
        $this->oportunidade_melhora_entrada = new DbField(
            $this, // Table
            'x_oportunidade_melhora_entrada', // Variable name
            'oportunidade_melhora_entrada', // Name
            '`oportunidade_melhora_entrada`', // Expression
            '`oportunidade_melhora_entrada`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`oportunidade_melhora_entrada`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->oportunidade_melhora_entrada->InputTextType = "text";
        $this->oportunidade_melhora_entrada->Nullable = false; // NOT NULL field
        $this->oportunidade_melhora_entrada->Required = true; // Required field
        $this->oportunidade_melhora_entrada->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['oportunidade_melhora_entrada'] = &$this->oportunidade_melhora_entrada;

        // oportunidade_melhora_saida
        $this->oportunidade_melhora_saida = new DbField(
            $this, // Table
            'x_oportunidade_melhora_saida', // Variable name
            'oportunidade_melhora_saida', // Name
            '`oportunidade_melhora_saida`', // Expression
            '`oportunidade_melhora_saida`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`oportunidade_melhora_saida`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->oportunidade_melhora_saida->InputTextType = "text";
        $this->oportunidade_melhora_saida->Nullable = false; // NOT NULL field
        $this->oportunidade_melhora_saida->Required = true; // Required field
        $this->oportunidade_melhora_saida->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['oportunidade_melhora_saida'] = &$this->oportunidade_melhora_saida;

        // qualquer_mudanca_sgq
        $this->qualquer_mudanca_sgq = new DbField(
            $this, // Table
            'x_qualquer_mudanca_sgq', // Variable name
            'qualquer_mudanca_sgq', // Name
            '`qualquer_mudanca_sgq`', // Expression
            '`qualquer_mudanca_sgq`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`qualquer_mudanca_sgq`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->qualquer_mudanca_sgq->InputTextType = "text";
        $this->qualquer_mudanca_sgq->Nullable = false; // NOT NULL field
        $this->qualquer_mudanca_sgq->Required = true; // Required field
        $this->qualquer_mudanca_sgq->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['qualquer_mudanca_sgq'] = &$this->qualquer_mudanca_sgq;

        // nec_recurso
        $this->nec_recurso = new DbField(
            $this, // Table
            'x_nec_recurso', // Variable name
            'nec_recurso', // Name
            '`nec_recurso`', // Expression
            '`nec_recurso`', // Basic search expression
            200, // Type
            45, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nec_recurso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nec_recurso->InputTextType = "text";
        $this->nec_recurso->Nullable = false; // NOT NULL field
        $this->nec_recurso->Required = true; // Required field
        $this->nec_recurso->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['nec_recurso'] = &$this->nec_recurso;

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
        $this->anexo->UploadMultiple = true;
        $this->anexo->Upload->UploadMultiple = true;
        $this->anexo->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['anexo'] = &$this->anexo;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "analise_critica_direcao";
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
            $this->idanalise_critica_direcao->setDbValue($conn->lastInsertId());
            $rs['idanalise_critica_direcao'] = $this->idanalise_critica_direcao->DbValue;
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
            if (!isset($rs['idanalise_critica_direcao']) && !EmptyValue($this->idanalise_critica_direcao->CurrentValue)) {
                $rs['idanalise_critica_direcao'] = $this->idanalise_critica_direcao->CurrentValue;
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
            if (array_key_exists('idanalise_critica_direcao', $rs)) {
                AddFilter($where, QuotedName('idanalise_critica_direcao', $this->Dbid) . '=' . QuotedValue($rs['idanalise_critica_direcao'], $this->idanalise_critica_direcao->DataType, $this->Dbid));
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
        $this->idanalise_critica_direcao->DbValue = $row['idanalise_critica_direcao'];
        $this->data->DbValue = $row['data'];
        $this->participantes->DbValue = $row['participantes'];
        $this->usuario_idusuario->DbValue = $row['usuario_idusuario'];
        $this->situacao_anterior->DbValue = $row['situacao_anterior'];
        $this->mudanca_sqg->DbValue = $row['mudanca_sqg'];
        $this->desempenho_eficacia->DbValue = $row['desempenho_eficacia'];
        $this->satisfacao_cliente->DbValue = $row['satisfacao_cliente'];
        $this->objetivos_alcancados->DbValue = $row['objetivos_alcançados'];
        $this->desempenho_processo->DbValue = $row['desempenho_processo'];
        $this->nao_confomidade_acoes_corretivas->DbValue = $row['nao_confomidade_acoes_corretivas'];
        $this->monitoramento_medicao->DbValue = $row['monitoramento_medicao'];
        $this->resultado_auditoria->DbValue = $row['resultado_auditoria'];
        $this->desempenho_provedores_ext->DbValue = $row['desempenho_provedores_ext'];
        $this->suficiencia_recursos->DbValue = $row['suficiencia_recursos'];
        $this->acoes_risco_oportunidades->DbValue = $row['acoes_risco_oportunidades'];
        $this->oportunidade_melhora_entrada->DbValue = $row['oportunidade_melhora_entrada'];
        $this->oportunidade_melhora_saida->DbValue = $row['oportunidade_melhora_saida'];
        $this->qualquer_mudanca_sgq->DbValue = $row['qualquer_mudanca_sgq'];
        $this->nec_recurso->DbValue = $row['nec_recurso'];
        $this->anexo->Upload->DbValue = $row['anexo'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['anexo']) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $row['anexo']);
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->anexo->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->anexo->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idanalise_critica_direcao` = @idanalise_critica_direcao@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idanalise_critica_direcao->CurrentValue : $this->idanalise_critica_direcao->OldValue;
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
                $this->idanalise_critica_direcao->CurrentValue = $keys[0];
            } else {
                $this->idanalise_critica_direcao->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idanalise_critica_direcao', $row) ? $row['idanalise_critica_direcao'] : null;
        } else {
            $val = !EmptyValue($this->idanalise_critica_direcao->OldValue) && !$current ? $this->idanalise_critica_direcao->OldValue : $this->idanalise_critica_direcao->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idanalise_critica_direcao@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("AnaliseCriticaDirecaoList");
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
            "AnaliseCriticaDirecaoView" => $Language->phrase("View"),
            "AnaliseCriticaDirecaoEdit" => $Language->phrase("Edit"),
            "AnaliseCriticaDirecaoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "AnaliseCriticaDirecaoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "AnaliseCriticaDirecaoView",
            Config("API_ADD_ACTION") => "AnaliseCriticaDirecaoAdd",
            Config("API_EDIT_ACTION") => "AnaliseCriticaDirecaoEdit",
            Config("API_DELETE_ACTION") => "AnaliseCriticaDirecaoDelete",
            Config("API_LIST_ACTION") => "AnaliseCriticaDirecaoList",
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
        return "AnaliseCriticaDirecaoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("AnaliseCriticaDirecaoView", $parm);
        } else {
            $url = $this->keyUrl("AnaliseCriticaDirecaoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "AnaliseCriticaDirecaoAdd?" . $parm;
        } else {
            $url = "AnaliseCriticaDirecaoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("AnaliseCriticaDirecaoEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("AnaliseCriticaDirecaoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("AnaliseCriticaDirecaoAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("AnaliseCriticaDirecaoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("AnaliseCriticaDirecaoDelete", $parm);
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
        $json .= "\"idanalise_critica_direcao\":" . VarToJson($this->idanalise_critica_direcao->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idanalise_critica_direcao->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idanalise_critica_direcao->CurrentValue);
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
            if (($keyValue = Param("idanalise_critica_direcao") ?? Route("idanalise_critica_direcao")) !== null) {
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
                $this->idanalise_critica_direcao->CurrentValue = $key;
            } else {
                $this->idanalise_critica_direcao->OldValue = $key;
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
        $this->idanalise_critica_direcao->setDbValue($row['idanalise_critica_direcao']);
        $this->data->setDbValue($row['data']);
        $this->participantes->setDbValue($row['participantes']);
        $this->usuario_idusuario->setDbValue($row['usuario_idusuario']);
        $this->situacao_anterior->setDbValue($row['situacao_anterior']);
        $this->mudanca_sqg->setDbValue($row['mudanca_sqg']);
        $this->desempenho_eficacia->setDbValue($row['desempenho_eficacia']);
        $this->satisfacao_cliente->setDbValue($row['satisfacao_cliente']);
        $this->objetivos_alcancados->setDbValue($row['objetivos_alcançados']);
        $this->desempenho_processo->setDbValue($row['desempenho_processo']);
        $this->nao_confomidade_acoes_corretivas->setDbValue($row['nao_confomidade_acoes_corretivas']);
        $this->monitoramento_medicao->setDbValue($row['monitoramento_medicao']);
        $this->resultado_auditoria->setDbValue($row['resultado_auditoria']);
        $this->desempenho_provedores_ext->setDbValue($row['desempenho_provedores_ext']);
        $this->suficiencia_recursos->setDbValue($row['suficiencia_recursos']);
        $this->acoes_risco_oportunidades->setDbValue($row['acoes_risco_oportunidades']);
        $this->oportunidade_melhora_entrada->setDbValue($row['oportunidade_melhora_entrada']);
        $this->oportunidade_melhora_saida->setDbValue($row['oportunidade_melhora_saida']);
        $this->qualquer_mudanca_sgq->setDbValue($row['qualquer_mudanca_sgq']);
        $this->nec_recurso->setDbValue($row['nec_recurso']);
        $this->anexo->Upload->DbValue = $row['anexo'];
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "AnaliseCriticaDirecaoList";
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

        // idanalise_critica_direcao

        // data

        // participantes

        // usuario_idusuario

        // situacao_anterior

        // mudanca_sqg

        // desempenho_eficacia

        // satisfacao_cliente

        // objetivos_alcançados

        // desempenho_processo

        // nao_confomidade_acoes_corretivas

        // monitoramento_medicao

        // resultado_auditoria

        // desempenho_provedores_ext

        // suficiencia_recursos

        // acoes_risco_oportunidades

        // oportunidade_melhora_entrada

        // oportunidade_melhora_saida

        // qualquer_mudanca_sgq

        // nec_recurso

        // anexo

        // idanalise_critica_direcao
        $this->idanalise_critica_direcao->ViewValue = $this->idanalise_critica_direcao->CurrentValue;
        $this->idanalise_critica_direcao->CssClass = "fw-bold";
        $this->idanalise_critica_direcao->CellCssStyle .= "text-align: center;";

        // data
        $this->data->ViewValue = $this->data->CurrentValue;
        $this->data->ViewValue = FormatDateTime($this->data->ViewValue, $this->data->formatPattern());
        $this->data->CssClass = "fw-bold";

        // participantes
        $curVal = strval($this->participantes->CurrentValue);
        if ($curVal != "") {
            $this->participantes->ViewValue = $this->participantes->lookupCacheOption($curVal);
            if ($this->participantes->ViewValue === null) { // Lookup from database
                $arwrk = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    AddFilter($filterWrk, SearchFilter($this->participantes->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", trim($wrk), $this->participantes->Lookup->getTable()->Fields["idusuario"]->searchDataType(), ""), "OR");
                }
                $lookupFilter = $this->participantes->getSelectFilter($this); // PHP
                $sqlWrk = $this->participantes->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->participantes->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->participantes->Lookup->renderViewRow($row);
                        $this->participantes->ViewValue->add($this->participantes->displayValue($arwrk));
                    }
                } else {
                    $this->participantes->ViewValue = $this->participantes->CurrentValue;
                }
            }
        } else {
            $this->participantes->ViewValue = null;
        }
        $this->participantes->CssClass = "fw-bold";

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

        // situacao_anterior
        $this->situacao_anterior->ViewValue = $this->situacao_anterior->CurrentValue;
        $this->situacao_anterior->CssClass = "fw-bold";

        // mudanca_sqg
        $this->mudanca_sqg->ViewValue = $this->mudanca_sqg->CurrentValue;
        $this->mudanca_sqg->CssClass = "fw-bold";

        // desempenho_eficacia
        $this->desempenho_eficacia->ViewValue = $this->desempenho_eficacia->CurrentValue;
        $this->desempenho_eficacia->CssClass = "fw-bold";

        // satisfacao_cliente
        $this->satisfacao_cliente->ViewValue = $this->satisfacao_cliente->CurrentValue;
        $this->satisfacao_cliente->CssClass = "fw-bold";

        // objetivos_alcançados
        $this->objetivos_alcancados->ViewValue = $this->objetivos_alcancados->CurrentValue;
        $this->objetivos_alcancados->CssClass = "fw-bold";

        // desempenho_processo
        $this->desempenho_processo->ViewValue = $this->desempenho_processo->CurrentValue;
        $this->desempenho_processo->CssClass = "fw-bold";

        // nao_confomidade_acoes_corretivas
        $this->nao_confomidade_acoes_corretivas->ViewValue = $this->nao_confomidade_acoes_corretivas->CurrentValue;
        $this->nao_confomidade_acoes_corretivas->CssClass = "fw-bold";

        // monitoramento_medicao
        $this->monitoramento_medicao->ViewValue = $this->monitoramento_medicao->CurrentValue;
        $this->monitoramento_medicao->CssClass = "fw-bold";

        // resultado_auditoria
        $this->resultado_auditoria->ViewValue = $this->resultado_auditoria->CurrentValue;
        $this->resultado_auditoria->CssClass = "fw-bold";

        // desempenho_provedores_ext
        $this->desempenho_provedores_ext->ViewValue = $this->desempenho_provedores_ext->CurrentValue;
        $this->desempenho_provedores_ext->CssClass = "fw-bold";

        // suficiencia_recursos
        $this->suficiencia_recursos->ViewValue = $this->suficiencia_recursos->CurrentValue;
        $this->suficiencia_recursos->CssClass = "fw-bold";

        // acoes_risco_oportunidades
        $this->acoes_risco_oportunidades->ViewValue = $this->acoes_risco_oportunidades->CurrentValue;
        $this->acoes_risco_oportunidades->CssClass = "fw-bold";

        // oportunidade_melhora_entrada
        $this->oportunidade_melhora_entrada->ViewValue = $this->oportunidade_melhora_entrada->CurrentValue;
        $this->oportunidade_melhora_entrada->CssClass = "fw-bold";

        // oportunidade_melhora_saida
        $this->oportunidade_melhora_saida->ViewValue = $this->oportunidade_melhora_saida->CurrentValue;
        $this->oportunidade_melhora_saida->CssClass = "fw-bold";

        // qualquer_mudanca_sgq
        $this->qualquer_mudanca_sgq->ViewValue = $this->qualquer_mudanca_sgq->CurrentValue;
        $this->qualquer_mudanca_sgq->CssClass = "fw-bold";

        // nec_recurso
        $this->nec_recurso->ViewValue = $this->nec_recurso->CurrentValue;
        $this->nec_recurso->CssClass = "fw-bold";

        // anexo
        if (!EmptyValue($this->anexo->Upload->DbValue)) {
            $this->anexo->ViewValue = $this->anexo->Upload->DbValue;
        } else {
            $this->anexo->ViewValue = "";
        }
        $this->anexo->CssClass = "fw-bold";

        // idanalise_critica_direcao
        $this->idanalise_critica_direcao->HrefValue = "";
        $this->idanalise_critica_direcao->TooltipValue = "";

        // data
        $this->data->HrefValue = "";
        $this->data->TooltipValue = "";

        // participantes
        $this->participantes->HrefValue = "";
        $this->participantes->TooltipValue = "";

        // usuario_idusuario
        $this->usuario_idusuario->HrefValue = "";
        $this->usuario_idusuario->TooltipValue = "";

        // situacao_anterior
        $this->situacao_anterior->HrefValue = "";
        $this->situacao_anterior->TooltipValue = "";

        // mudanca_sqg
        $this->mudanca_sqg->HrefValue = "";
        $this->mudanca_sqg->TooltipValue = "";

        // desempenho_eficacia
        $this->desempenho_eficacia->HrefValue = "";
        $this->desempenho_eficacia->TooltipValue = "";

        // satisfacao_cliente
        $this->satisfacao_cliente->HrefValue = "";
        $this->satisfacao_cliente->TooltipValue = "";

        // objetivos_alcançados
        $this->objetivos_alcancados->HrefValue = "";
        $this->objetivos_alcancados->TooltipValue = "";

        // desempenho_processo
        $this->desempenho_processo->HrefValue = "";
        $this->desempenho_processo->TooltipValue = "";

        // nao_confomidade_acoes_corretivas
        $this->nao_confomidade_acoes_corretivas->HrefValue = "";
        $this->nao_confomidade_acoes_corretivas->TooltipValue = "";

        // monitoramento_medicao
        $this->monitoramento_medicao->HrefValue = "";
        $this->monitoramento_medicao->TooltipValue = "";

        // resultado_auditoria
        $this->resultado_auditoria->HrefValue = "";
        $this->resultado_auditoria->TooltipValue = "";

        // desempenho_provedores_ext
        $this->desempenho_provedores_ext->HrefValue = "";
        $this->desempenho_provedores_ext->TooltipValue = "";

        // suficiencia_recursos
        $this->suficiencia_recursos->HrefValue = "";
        $this->suficiencia_recursos->TooltipValue = "";

        // acoes_risco_oportunidades
        $this->acoes_risco_oportunidades->HrefValue = "";
        $this->acoes_risco_oportunidades->TooltipValue = "";

        // oportunidade_melhora_entrada
        $this->oportunidade_melhora_entrada->HrefValue = "";
        $this->oportunidade_melhora_entrada->TooltipValue = "";

        // oportunidade_melhora_saida
        $this->oportunidade_melhora_saida->HrefValue = "";
        $this->oportunidade_melhora_saida->TooltipValue = "";

        // qualquer_mudanca_sgq
        $this->qualquer_mudanca_sgq->HrefValue = "";
        $this->qualquer_mudanca_sgq->TooltipValue = "";

        // nec_recurso
        $this->nec_recurso->HrefValue = "";
        $this->nec_recurso->TooltipValue = "";

        // anexo
        if (!EmptyValue($this->anexo->Upload->DbValue)) {
            $this->anexo->HrefValue = $this->anexo->getLinkPrefix() . "%u"; // Add prefix/suffix
            $this->anexo->LinkAttrs["target"] = "_blank"; // Add target
            if ($this->isExport()) {
                $this->anexo->HrefValue = FullUrl($this->anexo->HrefValue, "href");
            }
        } else {
            $this->anexo->HrefValue = "";
        }
        $this->anexo->ExportHrefValue = $this->anexo->UploadPath . $this->anexo->Upload->DbValue;
        $this->anexo->TooltipValue = "";

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

        // idanalise_critica_direcao
        $this->idanalise_critica_direcao->setupEditAttributes();
        $this->idanalise_critica_direcao->EditValue = $this->idanalise_critica_direcao->CurrentValue;
        $this->idanalise_critica_direcao->CssClass = "fw-bold";
        $this->idanalise_critica_direcao->CellCssStyle .= "text-align: center;";

        // data
        $this->data->setupEditAttributes();
        $this->data->EditValue = FormatDateTime($this->data->CurrentValue, $this->data->formatPattern());
        $this->data->PlaceHolder = RemoveHtml($this->data->caption());

        // participantes
        $this->participantes->PlaceHolder = RemoveHtml($this->participantes->caption());

        // usuario_idusuario
        $this->usuario_idusuario->setupEditAttributes();
        $this->usuario_idusuario->PlaceHolder = RemoveHtml($this->usuario_idusuario->caption());

        // situacao_anterior
        $this->situacao_anterior->setupEditAttributes();
        $this->situacao_anterior->EditValue = $this->situacao_anterior->CurrentValue;
        $this->situacao_anterior->PlaceHolder = RemoveHtml($this->situacao_anterior->caption());

        // mudanca_sqg
        $this->mudanca_sqg->setupEditAttributes();
        $this->mudanca_sqg->EditValue = $this->mudanca_sqg->CurrentValue;
        $this->mudanca_sqg->PlaceHolder = RemoveHtml($this->mudanca_sqg->caption());

        // desempenho_eficacia
        $this->desempenho_eficacia->setupEditAttributes();
        $this->desempenho_eficacia->EditValue = $this->desempenho_eficacia->CurrentValue;
        $this->desempenho_eficacia->PlaceHolder = RemoveHtml($this->desempenho_eficacia->caption());

        // satisfacao_cliente
        $this->satisfacao_cliente->setupEditAttributes();
        $this->satisfacao_cliente->EditValue = $this->satisfacao_cliente->CurrentValue;
        $this->satisfacao_cliente->PlaceHolder = RemoveHtml($this->satisfacao_cliente->caption());

        // objetivos_alcançados
        $this->objetivos_alcancados->setupEditAttributes();
        $this->objetivos_alcancados->EditValue = $this->objetivos_alcancados->CurrentValue;
        $this->objetivos_alcancados->PlaceHolder = RemoveHtml($this->objetivos_alcancados->caption());

        // desempenho_processo
        $this->desempenho_processo->setupEditAttributes();
        $this->desempenho_processo->EditValue = $this->desempenho_processo->CurrentValue;
        $this->desempenho_processo->PlaceHolder = RemoveHtml($this->desempenho_processo->caption());

        // nao_confomidade_acoes_corretivas
        $this->nao_confomidade_acoes_corretivas->setupEditAttributes();
        $this->nao_confomidade_acoes_corretivas->EditValue = $this->nao_confomidade_acoes_corretivas->CurrentValue;
        $this->nao_confomidade_acoes_corretivas->PlaceHolder = RemoveHtml($this->nao_confomidade_acoes_corretivas->caption());

        // monitoramento_medicao
        $this->monitoramento_medicao->setupEditAttributes();
        $this->monitoramento_medicao->EditValue = $this->monitoramento_medicao->CurrentValue;
        $this->monitoramento_medicao->PlaceHolder = RemoveHtml($this->monitoramento_medicao->caption());

        // resultado_auditoria
        $this->resultado_auditoria->setupEditAttributes();
        $this->resultado_auditoria->EditValue = $this->resultado_auditoria->CurrentValue;
        $this->resultado_auditoria->PlaceHolder = RemoveHtml($this->resultado_auditoria->caption());

        // desempenho_provedores_ext
        $this->desempenho_provedores_ext->setupEditAttributes();
        $this->desempenho_provedores_ext->EditValue = $this->desempenho_provedores_ext->CurrentValue;
        $this->desempenho_provedores_ext->PlaceHolder = RemoveHtml($this->desempenho_provedores_ext->caption());

        // suficiencia_recursos
        $this->suficiencia_recursos->setupEditAttributes();
        $this->suficiencia_recursos->EditValue = $this->suficiencia_recursos->CurrentValue;
        $this->suficiencia_recursos->PlaceHolder = RemoveHtml($this->suficiencia_recursos->caption());

        // acoes_risco_oportunidades
        $this->acoes_risco_oportunidades->setupEditAttributes();
        $this->acoes_risco_oportunidades->EditValue = $this->acoes_risco_oportunidades->CurrentValue;
        $this->acoes_risco_oportunidades->PlaceHolder = RemoveHtml($this->acoes_risco_oportunidades->caption());

        // oportunidade_melhora_entrada
        $this->oportunidade_melhora_entrada->setupEditAttributes();
        $this->oportunidade_melhora_entrada->EditValue = $this->oportunidade_melhora_entrada->CurrentValue;
        $this->oportunidade_melhora_entrada->PlaceHolder = RemoveHtml($this->oportunidade_melhora_entrada->caption());

        // oportunidade_melhora_saida
        $this->oportunidade_melhora_saida->setupEditAttributes();
        $this->oportunidade_melhora_saida->EditValue = $this->oportunidade_melhora_saida->CurrentValue;
        $this->oportunidade_melhora_saida->PlaceHolder = RemoveHtml($this->oportunidade_melhora_saida->caption());

        // qualquer_mudanca_sgq
        $this->qualquer_mudanca_sgq->setupEditAttributes();
        $this->qualquer_mudanca_sgq->EditValue = $this->qualquer_mudanca_sgq->CurrentValue;
        $this->qualquer_mudanca_sgq->PlaceHolder = RemoveHtml($this->qualquer_mudanca_sgq->caption());

        // nec_recurso
        $this->nec_recurso->setupEditAttributes();
        if (!$this->nec_recurso->Raw) {
            $this->nec_recurso->CurrentValue = HtmlDecode($this->nec_recurso->CurrentValue);
        }
        $this->nec_recurso->EditValue = $this->nec_recurso->CurrentValue;
        $this->nec_recurso->PlaceHolder = RemoveHtml($this->nec_recurso->caption());

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
                    $doc->exportCaption($this->idanalise_critica_direcao);
                    $doc->exportCaption($this->data);
                    $doc->exportCaption($this->participantes);
                    $doc->exportCaption($this->usuario_idusuario);
                    $doc->exportCaption($this->situacao_anterior);
                    $doc->exportCaption($this->mudanca_sqg);
                    $doc->exportCaption($this->desempenho_eficacia);
                    $doc->exportCaption($this->satisfacao_cliente);
                    $doc->exportCaption($this->objetivos_alcancados);
                    $doc->exportCaption($this->desempenho_processo);
                    $doc->exportCaption($this->nao_confomidade_acoes_corretivas);
                    $doc->exportCaption($this->monitoramento_medicao);
                    $doc->exportCaption($this->resultado_auditoria);
                    $doc->exportCaption($this->desempenho_provedores_ext);
                    $doc->exportCaption($this->suficiencia_recursos);
                    $doc->exportCaption($this->acoes_risco_oportunidades);
                    $doc->exportCaption($this->oportunidade_melhora_entrada);
                    $doc->exportCaption($this->oportunidade_melhora_saida);
                    $doc->exportCaption($this->qualquer_mudanca_sgq);
                    $doc->exportCaption($this->nec_recurso);
                    $doc->exportCaption($this->anexo);
                } else {
                    $doc->exportCaption($this->idanalise_critica_direcao);
                    $doc->exportCaption($this->data);
                    $doc->exportCaption($this->participantes);
                    $doc->exportCaption($this->usuario_idusuario);
                    $doc->exportCaption($this->situacao_anterior);
                    $doc->exportCaption($this->mudanca_sqg);
                    $doc->exportCaption($this->desempenho_eficacia);
                    $doc->exportCaption($this->satisfacao_cliente);
                    $doc->exportCaption($this->objetivos_alcancados);
                    $doc->exportCaption($this->desempenho_processo);
                    $doc->exportCaption($this->nao_confomidade_acoes_corretivas);
                    $doc->exportCaption($this->monitoramento_medicao);
                    $doc->exportCaption($this->resultado_auditoria);
                    $doc->exportCaption($this->desempenho_provedores_ext);
                    $doc->exportCaption($this->suficiencia_recursos);
                    $doc->exportCaption($this->acoes_risco_oportunidades);
                    $doc->exportCaption($this->oportunidade_melhora_entrada);
                    $doc->exportCaption($this->oportunidade_melhora_saida);
                    $doc->exportCaption($this->qualquer_mudanca_sgq);
                    $doc->exportCaption($this->nec_recurso);
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
                        $doc->exportField($this->idanalise_critica_direcao);
                        $doc->exportField($this->data);
                        $doc->exportField($this->participantes);
                        $doc->exportField($this->usuario_idusuario);
                        $doc->exportField($this->situacao_anterior);
                        $doc->exportField($this->mudanca_sqg);
                        $doc->exportField($this->desempenho_eficacia);
                        $doc->exportField($this->satisfacao_cliente);
                        $doc->exportField($this->objetivos_alcancados);
                        $doc->exportField($this->desempenho_processo);
                        $doc->exportField($this->nao_confomidade_acoes_corretivas);
                        $doc->exportField($this->monitoramento_medicao);
                        $doc->exportField($this->resultado_auditoria);
                        $doc->exportField($this->desempenho_provedores_ext);
                        $doc->exportField($this->suficiencia_recursos);
                        $doc->exportField($this->acoes_risco_oportunidades);
                        $doc->exportField($this->oportunidade_melhora_entrada);
                        $doc->exportField($this->oportunidade_melhora_saida);
                        $doc->exportField($this->qualquer_mudanca_sgq);
                        $doc->exportField($this->nec_recurso);
                        $doc->exportField($this->anexo);
                    } else {
                        $doc->exportField($this->idanalise_critica_direcao);
                        $doc->exportField($this->data);
                        $doc->exportField($this->participantes);
                        $doc->exportField($this->usuario_idusuario);
                        $doc->exportField($this->situacao_anterior);
                        $doc->exportField($this->mudanca_sqg);
                        $doc->exportField($this->desempenho_eficacia);
                        $doc->exportField($this->satisfacao_cliente);
                        $doc->exportField($this->objetivos_alcancados);
                        $doc->exportField($this->desempenho_processo);
                        $doc->exportField($this->nao_confomidade_acoes_corretivas);
                        $doc->exportField($this->monitoramento_medicao);
                        $doc->exportField($this->resultado_auditoria);
                        $doc->exportField($this->desempenho_provedores_ext);
                        $doc->exportField($this->suficiencia_recursos);
                        $doc->exportField($this->acoes_risco_oportunidades);
                        $doc->exportField($this->oportunidade_melhora_entrada);
                        $doc->exportField($this->oportunidade_melhora_saida);
                        $doc->exportField($this->qualquer_mudanca_sgq);
                        $doc->exportField($this->nec_recurso);
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
            $this->idanalise_critica_direcao->CurrentValue = $ar[0];
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
