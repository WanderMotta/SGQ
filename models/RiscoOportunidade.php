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
 * Table class for risco_oportunidade
 */
class RiscoOportunidade extends DbTable
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
    public $Severidade;
    public $GrauAtencao;

    // Fields
    public $idrisco_oportunidade;
    public $dt_cadastro;
    public $tipo_risco_oportunidade_idtipo_risco_oportunidade;
    public $titulo;
    public $origem_risco_oportunidade_idorigem_risco_oportunidade;
    public $descricao;
    public $consequencia;
    public $frequencia_idfrequencia;
    public $impacto_idimpacto;
    public $grau_atencao;
    public $acao_risco_oportunidade_idacao_risco_oportunidade;
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
        $this->TableVar = "risco_oportunidade";
        $this->TableName = 'risco_oportunidade';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "risco_oportunidade";
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

        // idrisco_oportunidade
        $this->idrisco_oportunidade = new DbField(
            $this, // Table
            'x_idrisco_oportunidade', // Variable name
            'idrisco_oportunidade', // Name
            '`idrisco_oportunidade`', // Expression
            '`idrisco_oportunidade`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idrisco_oportunidade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idrisco_oportunidade->InputTextType = "text";
        $this->idrisco_oportunidade->Raw = true;
        $this->idrisco_oportunidade->IsAutoIncrement = true; // Autoincrement field
        $this->idrisco_oportunidade->IsPrimaryKey = true; // Primary key field
        $this->idrisco_oportunidade->IsForeignKey = true; // Foreign key field
        $this->idrisco_oportunidade->Nullable = false; // NOT NULL field
        $this->idrisco_oportunidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idrisco_oportunidade->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idrisco_oportunidade'] = &$this->idrisco_oportunidade;

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

        // tipo_risco_oportunidade_idtipo_risco_oportunidade
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade = new DbField(
            $this, // Table
            'x_tipo_risco_oportunidade_idtipo_risco_oportunidade', // Variable name
            'tipo_risco_oportunidade_idtipo_risco_oportunidade', // Name
            '`tipo_risco_oportunidade_idtipo_risco_oportunidade`', // Expression
            '`tipo_risco_oportunidade_idtipo_risco_oportunidade`', // Basic search expression
            19, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_risco_oportunidade_idtipo_risco_oportunidade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->InputTextType = "text";
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Raw = true;
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Nullable = false; // NOT NULL field
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Required = true; // Required field
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup = new Lookup($this->tipo_risco_oportunidade_idtipo_risco_oportunidade, 'tipo_risco_oportunidade', false, 'idtipo_risco_oportunidade', ["tipo_risco_oportunidade","","",""], '', '', [], ["x_impacto_idimpacto","x_acao_risco_oportunidade_idacao_risco_oportunidade"], [], [], [], [], false, '', '', "`tipo_risco_oportunidade`");
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['tipo_risco_oportunidade_idtipo_risco_oportunidade'] = &$this->tipo_risco_oportunidade_idtipo_risco_oportunidade;

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

        // consequencia
        $this->consequencia = new DbField(
            $this, // Table
            'x_consequencia', // Variable name
            'consequencia', // Name
            '`consequencia`', // Expression
            '`consequencia`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`consequencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->consequencia->InputTextType = "text";
        $this->consequencia->Nullable = false; // NOT NULL field
        $this->consequencia->Required = true; // Required field
        $this->consequencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['consequencia'] = &$this->consequencia;

        // frequencia_idfrequencia
        $this->frequencia_idfrequencia = new DbField(
            $this, // Table
            'x_frequencia_idfrequencia', // Variable name
            'frequencia_idfrequencia', // Name
            '`frequencia_idfrequencia`', // Expression
            '`frequencia_idfrequencia`', // Basic search expression
            19, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`frequencia_idfrequencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->frequencia_idfrequencia->InputTextType = "text";
        $this->frequencia_idfrequencia->Raw = true;
        $this->frequencia_idfrequencia->Nullable = false; // NOT NULL field
        $this->frequencia_idfrequencia->Required = true; // Required field
        $this->frequencia_idfrequencia->setSelectMultiple(false); // Select one
        $this->frequencia_idfrequencia->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->frequencia_idfrequencia->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->frequencia_idfrequencia->UseFilter = true; // Table header filter
        $this->frequencia_idfrequencia->Lookup = new Lookup($this->frequencia_idfrequencia, 'frequencia', true, 'idfrequencia', ["grau","frequencia","",""], '', '', [], [], [], [], [], [], false, '`grau` ASC', '', "CONCAT(COALESCE(`grau`, ''),'" . ValueSeparator(1, $this->frequencia_idfrequencia) . "',COALESCE(`frequencia`,''))");
        $this->frequencia_idfrequencia->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->frequencia_idfrequencia->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['frequencia_idfrequencia'] = &$this->frequencia_idfrequencia;

        // impacto_idimpacto
        $this->impacto_idimpacto = new DbField(
            $this, // Table
            'x_impacto_idimpacto', // Variable name
            'impacto_idimpacto', // Name
            '`impacto_idimpacto`', // Expression
            '`impacto_idimpacto`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`impacto_idimpacto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->impacto_idimpacto->InputTextType = "text";
        $this->impacto_idimpacto->Raw = true;
        $this->impacto_idimpacto->Nullable = false; // NOT NULL field
        $this->impacto_idimpacto->Required = true; // Required field
        $this->impacto_idimpacto->setSelectMultiple(false); // Select one
        $this->impacto_idimpacto->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->impacto_idimpacto->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->impacto_idimpacto->UseFilter = true; // Table header filter
        $this->impacto_idimpacto->Lookup = new Lookup($this->impacto_idimpacto, 'impacto', true, 'idimpacto', ["grau","impacto","",""], '', '', ["x_tipo_risco_oportunidade_idtipo_risco_oportunidade"], [], ["tipo_risco_oportunidade_idtipo_risco_oportunidade"], ["x_tipo_risco_oportunidade_idtipo_risco_oportunidade"], [], [], false, '`grau` ASC', '', "CONCAT(COALESCE(`grau`, ''),'" . ValueSeparator(1, $this->impacto_idimpacto) . "',COALESCE(`impacto`,''))");
        $this->impacto_idimpacto->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->impacto_idimpacto->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['impacto_idimpacto'] = &$this->impacto_idimpacto;

        // grau_atencao
        $this->grau_atencao = new DbField(
            $this, // Table
            'x_grau_atencao', // Variable name
            'grau_atencao', // Name
            '`grau_atencao`', // Expression
            '`grau_atencao`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`grau_atencao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->grau_atencao->InputTextType = "text";
        $this->grau_atencao->Raw = true;
        $this->grau_atencao->Nullable = false; // NOT NULL field
        $this->grau_atencao->UseFilter = true; // Table header filter
        $this->grau_atencao->Lookup = new Lookup($this->grau_atencao, 'risco_oportunidade', true, 'grau_atencao', ["grau_atencao","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->grau_atencao->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->grau_atencao->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['grau_atencao'] = &$this->grau_atencao;

        // acao_risco_oportunidade_idacao_risco_oportunidade
        $this->acao_risco_oportunidade_idacao_risco_oportunidade = new DbField(
            $this, // Table
            'x_acao_risco_oportunidade_idacao_risco_oportunidade', // Variable name
            'acao_risco_oportunidade_idacao_risco_oportunidade', // Name
            '`acao_risco_oportunidade_idacao_risco_oportunidade`', // Expression
            '`acao_risco_oportunidade_idacao_risco_oportunidade`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`acao_risco_oportunidade_idacao_risco_oportunidade`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->InputTextType = "text";
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->Raw = true;
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->Nullable = false; // NOT NULL field
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->Required = true; // Required field
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setSelectMultiple(false); // Select one
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->UseFilter = true; // Table header filter
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup = new Lookup($this->acao_risco_oportunidade_idacao_risco_oportunidade, 'acao_risco_oportunidade', true, 'idacao_risco_oportunidade', ["acao","","",""], '', '', ["x_tipo_risco_oportunidade_idtipo_risco_oportunidade"], [], ["tipo_risco_oportunidade_idtipo_risco_oportunidade"], ["x_tipo_risco_oportunidade_idtipo_risco_oportunidade"], [], [], false, '`acao` ASC', '', "`acao`");
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['acao_risco_oportunidade_idacao_risco_oportunidade'] = &$this->acao_risco_oportunidade_idacao_risco_oportunidade;

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
        $this->plano_acao->Lookup = new Lookup($this->plano_acao, 'risco_oportunidade', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->plano_acao->OptionCount = 2;
        $this->plano_acao->SearchOperators = ["=", "<>"];
        $this->Fields['plano_acao'] = &$this->plano_acao;

        // Severidade
        $this->Severidade = new DbChart($this, 'Severidade', 'Severidade', 'impacto_idimpacto', 'impacto_idimpacto', 1001, '', 0, 'COUNT', 300, 250);
        $this->Severidade->Position = 4;
        $this->Severidade->PageBreakType = "before";
        $this->Severidade->YAxisFormat = ["Number"];
        $this->Severidade->YFieldFormat = ["Number"];
        $this->Severidade->SortType = 0;
        $this->Severidade->SortSequence = "";
        $this->Severidade->SqlSelect = $this->getQueryBuilder()->select("`impacto_idimpacto`", "''", "COUNT(`impacto_idimpacto`)");
        $this->Severidade->SqlGroupBy = "`impacto_idimpacto`";
        $this->Severidade->SqlOrderBy = "";
        $this->Severidade->SeriesDateType = "";
        $this->Severidade->ID = "risco_oportunidade_Severidade"; // Chart ID
        $this->Severidade->setParameters([
            ["type", "1001"],
            ["seriestype", "0"]
        ]); // Chart type / Chart series type
        $this->Severidade->setParameters([
            ["caption", $this->Severidade->caption()],
            ["xaxisname", $this->Severidade->xAxisName()]
        ]); // Chart caption / X axis name
        $this->Severidade->setParameter("yaxisname", $this->Severidade->yAxisName()); // Y axis name
        $this->Severidade->setParameters([
            ["shownames", "1"],
            ["showvalues", "1"],
            ["showhovercap", "1"]
        ]); // Show names / Show values / Show hover
        $this->Severidade->setParameter("alpha", 50); // Chart alpha (datasets background color)
        $this->Severidade->setParameters([["options.plugins.legend.display",false],["options.plugins.legend.fullWidth",false],["options.plugins.legend.reverse",false],["options.plugins.legend.rtl",false],["options.plugins.legend.labels.usePointStyle",false],["options.plugins.title.display",false],["options.plugins.tooltip.enabled",false],["options.plugins.tooltip.intersect",false],["options.plugins.tooltip.displayColors",false],["options.plugins.tooltip.rtl",false],["options.plugins.filler.propagate",false],["options.animation.animateRotate",false],["options.animation.animateScale",false],["dataset.showLine",false],["dataset.spanGaps",false],["dataset.steppedLine",false],["scale.offset",false],["scale.gridLines.offsetGridLines",false],["options.plugins.datalabels.clamp",false],["options.plugins.datalabels.clip",false],["options.plugins.datalabels.display",false],["annotation1.show",false],["annotation1.secondaryYAxis",false],["annotation2.show",false],["annotation2.secondaryYAxis",false],["annotation3.show",false],["annotation3.secondaryYAxis",false],["annotation4.show",false],["annotation4.secondaryYAxis",false],["options.scales.r.angleLines.display",false],["options.plugins.stacked100.enable",false],["dataset.circular",false]]);
        $this->Charts[$this->Severidade->ID] = &$this->Severidade;

        // Grau Atenção
        $this->GrauAtencao = new DbChart($this, 'GrauAtencao', 'Grau Atenção', 'grau_atencao', 'grau_atencao', 1001, '', 0, 'COUNT', 300, 250);
        $this->GrauAtencao->Position = 4;
        $this->GrauAtencao->PageBreakType = "before";
        $this->GrauAtencao->YAxisFormat = ["Number"];
        $this->GrauAtencao->YFieldFormat = ["Number"];
        $this->GrauAtencao->SortType = 3;
        $this->GrauAtencao->SortSequence = "";
        $this->GrauAtencao->SqlSelect = $this->getQueryBuilder()->select("`grau_atencao`", "''", "COUNT(`grau_atencao`)");
        $this->GrauAtencao->SqlGroupBy = "`grau_atencao`";
        $this->GrauAtencao->SqlOrderBy = "";
        $this->GrauAtencao->SeriesDateType = "";
        $this->GrauAtencao->ID = "risco_oportunidade_GrauAtencao"; // Chart ID
        $this->GrauAtencao->setParameters([
            ["type", "1001"],
            ["seriestype", "0"]
        ]); // Chart type / Chart series type
        $this->GrauAtencao->setParameters([
            ["caption", $this->GrauAtencao->caption()],
            ["xaxisname", $this->GrauAtencao->xAxisName()]
        ]); // Chart caption / X axis name
        $this->GrauAtencao->setParameter("yaxisname", $this->GrauAtencao->yAxisName()); // Y axis name
        $this->GrauAtencao->setParameters([
            ["shownames", "1"],
            ["showvalues", "1"],
            ["showhovercap", "1"]
        ]); // Show names / Show values / Show hover
        $this->GrauAtencao->setParameter("alpha", 50); // Chart alpha (datasets background color)
        $this->GrauAtencao->setParameters([["options.plugins.legend.display",false],["options.plugins.legend.fullWidth",false],["options.plugins.legend.reverse",false],["options.plugins.legend.rtl",false],["options.plugins.legend.labels.usePointStyle",false],["options.plugins.title.display",false],["options.plugins.tooltip.enabled",false],["options.plugins.tooltip.intersect",false],["options.plugins.tooltip.displayColors",false],["options.plugins.tooltip.rtl",false],["options.plugins.filler.propagate",false],["options.animation.animateRotate",false],["options.animation.animateScale",false],["dataset.showLine",false],["dataset.spanGaps",false],["dataset.steppedLine",false],["scale.offset",false],["scale.gridLines.offsetGridLines",false],["options.plugins.datalabels.clamp",false],["options.plugins.datalabels.clip",false],["options.plugins.datalabels.display",false],["annotation1.show",false],["annotation1.secondaryYAxis",false],["annotation2.show",false],["annotation2.secondaryYAxis",false],["annotation3.show",false],["annotation3.secondaryYAxis",false],["annotation4.show",false],["annotation4.secondaryYAxis",false],["options.scales.r.angleLines.display",false],["options.plugins.stacked100.enable",false],["dataset.circular",false]]);
        $this->Charts[$this->GrauAtencao->ID] = &$this->GrauAtencao;

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
        if ($this->getCurrentDetailTable() == "plano_acao") {
            $detailUrl = Container("plano_acao")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idrisco_oportunidade", $this->idrisco_oportunidade->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "RiscoOportunidadeList";
        }
        return $detailUrl;
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        if ($chartVar == "Severidade") {
            $this->impacto_idimpacto->CurrentValue = $chartRow[0];
            $curVal = strval($this->impacto_idimpacto->CurrentValue);
            if ($curVal != "") {
                $this->impacto_idimpacto->ViewValue = $this->impacto_idimpacto->lookupCacheOption($curVal);
                if ($this->impacto_idimpacto->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchExpression(), "=", $curVal, $this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchDataType(), "");
                    $sqlWrk = $this->impacto_idimpacto->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->impacto_idimpacto->Lookup->renderViewRow($rswrk[0]);
                        $this->impacto_idimpacto->ViewValue = $this->impacto_idimpacto->displayValue($arwrk);
                    } else {
                        $this->impacto_idimpacto->ViewValue = FormatNumber($this->impacto_idimpacto->CurrentValue, $this->impacto_idimpacto->formatPattern());
                    }
                }
            } else {
                $this->impacto_idimpacto->ViewValue = null;
            }
            $this->impacto_idimpacto->CssClass = "fw-bold";
            $chartRow[0] = is_object($this->impacto_idimpacto->ViewValue) ? $this->impacto_idimpacto->ViewValue->__toString() : $this->impacto_idimpacto->ViewValue;
        }
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "risco_oportunidade";
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
            $this->idrisco_oportunidade->setDbValue($conn->lastInsertId());
            $rs['idrisco_oportunidade'] = $this->idrisco_oportunidade->DbValue;
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
        // Cascade Update detail table 'plano_acao'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['idrisco_oportunidade']) && $rsold['idrisco_oportunidade'] != $rs['idrisco_oportunidade'])) { // Update detail field 'risco_oportunidade_idrisco_oportunidade'
            $cascadeUpdate = true;
            $rscascade['risco_oportunidade_idrisco_oportunidade'] = $rs['idrisco_oportunidade'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("plano_acao")->loadRs("`risco_oportunidade_idrisco_oportunidade` = " . QuotedValue($rsold['idrisco_oportunidade'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'idplano_acao';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("plano_acao")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("plano_acao")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("plano_acao")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['idrisco_oportunidade']) && !EmptyValue($this->idrisco_oportunidade->CurrentValue)) {
                $rs['idrisco_oportunidade'] = $this->idrisco_oportunidade->CurrentValue;
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
            if (array_key_exists('idrisco_oportunidade', $rs)) {
                AddFilter($where, QuotedName('idrisco_oportunidade', $this->Dbid) . '=' . QuotedValue($rs['idrisco_oportunidade'], $this->idrisco_oportunidade->DataType, $this->Dbid));
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

        // Cascade delete detail table 'plano_acao'
        $dtlrows = Container("plano_acao")->loadRs("`risco_oportunidade_idrisco_oportunidade` = " . QuotedValue($rs['idrisco_oportunidade'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("plano_acao")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("plano_acao")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("plano_acao")->rowDeleted($dtlrow);
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
        $this->idrisco_oportunidade->DbValue = $row['idrisco_oportunidade'];
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->DbValue = $row['tipo_risco_oportunidade_idtipo_risco_oportunidade'];
        $this->titulo->DbValue = $row['titulo'];
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->DbValue = $row['origem_risco_oportunidade_idorigem_risco_oportunidade'];
        $this->descricao->DbValue = $row['descricao'];
        $this->consequencia->DbValue = $row['consequencia'];
        $this->frequencia_idfrequencia->DbValue = $row['frequencia_idfrequencia'];
        $this->impacto_idimpacto->DbValue = $row['impacto_idimpacto'];
        $this->grau_atencao->DbValue = $row['grau_atencao'];
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->DbValue = $row['acao_risco_oportunidade_idacao_risco_oportunidade'];
        $this->plano_acao->DbValue = $row['plano_acao'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idrisco_oportunidade` = @idrisco_oportunidade@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idrisco_oportunidade->CurrentValue : $this->idrisco_oportunidade->OldValue;
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
                $this->idrisco_oportunidade->CurrentValue = $keys[0];
            } else {
                $this->idrisco_oportunidade->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idrisco_oportunidade', $row) ? $row['idrisco_oportunidade'] : null;
        } else {
            $val = !EmptyValue($this->idrisco_oportunidade->OldValue) && !$current ? $this->idrisco_oportunidade->OldValue : $this->idrisco_oportunidade->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idrisco_oportunidade@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("RiscoOportunidadeList");
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
            "RiscoOportunidadeView" => $Language->phrase("View"),
            "RiscoOportunidadeEdit" => $Language->phrase("Edit"),
            "RiscoOportunidadeAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "RiscoOportunidadeList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "RiscoOportunidadeView",
            Config("API_ADD_ACTION") => "RiscoOportunidadeAdd",
            Config("API_EDIT_ACTION") => "RiscoOportunidadeEdit",
            Config("API_DELETE_ACTION") => "RiscoOportunidadeDelete",
            Config("API_LIST_ACTION") => "RiscoOportunidadeList",
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
        return "RiscoOportunidadeList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("RiscoOportunidadeView", $parm);
        } else {
            $url = $this->keyUrl("RiscoOportunidadeView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "RiscoOportunidadeAdd?" . $parm;
        } else {
            $url = "RiscoOportunidadeAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("RiscoOportunidadeEdit", $parm);
        } else {
            $url = $this->keyUrl("RiscoOportunidadeEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("RiscoOportunidadeList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("RiscoOportunidadeAdd", $parm);
        } else {
            $url = $this->keyUrl("RiscoOportunidadeAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("RiscoOportunidadeList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("RiscoOportunidadeDelete", $parm);
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
        $json .= "\"idrisco_oportunidade\":" . VarToJson($this->idrisco_oportunidade->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idrisco_oportunidade->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idrisco_oportunidade->CurrentValue);
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
            if (($keyValue = Param("idrisco_oportunidade") ?? Route("idrisco_oportunidade")) !== null) {
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
                $this->idrisco_oportunidade->CurrentValue = $key;
            } else {
                $this->idrisco_oportunidade->OldValue = $key;
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
        $this->idrisco_oportunidade->setDbValue($row['idrisco_oportunidade']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->setDbValue($row['tipo_risco_oportunidade_idtipo_risco_oportunidade']);
        $this->titulo->setDbValue($row['titulo']);
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setDbValue($row['origem_risco_oportunidade_idorigem_risco_oportunidade']);
        $this->descricao->setDbValue($row['descricao']);
        $this->consequencia->setDbValue($row['consequencia']);
        $this->frequencia_idfrequencia->setDbValue($row['frequencia_idfrequencia']);
        $this->impacto_idimpacto->setDbValue($row['impacto_idimpacto']);
        $this->grau_atencao->setDbValue($row['grau_atencao']);
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setDbValue($row['acao_risco_oportunidade_idacao_risco_oportunidade']);
        $this->plano_acao->setDbValue($row['plano_acao']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "RiscoOportunidadeList";
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

        // idrisco_oportunidade

        // dt_cadastro

        // tipo_risco_oportunidade_idtipo_risco_oportunidade

        // titulo

        // origem_risco_oportunidade_idorigem_risco_oportunidade

        // descricao

        // consequencia

        // frequencia_idfrequencia

        // impacto_idimpacto

        // grau_atencao

        // acao_risco_oportunidade_idacao_risco_oportunidade

        // plano_acao

        // idrisco_oportunidade
        $this->idrisco_oportunidade->ViewValue = $this->idrisco_oportunidade->CurrentValue;
        $this->idrisco_oportunidade->CssClass = "fw-bold";
        $this->idrisco_oportunidade->CellCssStyle .= "text-align: center;";

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->CssClass = "fw-bold";

        // tipo_risco_oportunidade_idtipo_risco_oportunidade
        $curVal = strval($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue);
        if ($curVal != "") {
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->lookupCacheOption($curVal);
            if ($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getTable()->Fields["idtipo_risco_oportunidade"]->searchExpression(), "=", $curVal, $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getTable()->Fields["idtipo_risco_oportunidade"]->searchDataType(), "");
                $sqlWrk = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->displayValue($arwrk);
                } else {
                    $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = FormatNumber($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue, $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->formatPattern());
                }
            }
        } else {
            $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = null;
        }
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CssClass = "fw-bold";

        // titulo
        $this->titulo->ViewValue = $this->titulo->CurrentValue;
        $this->titulo->CssClass = "fw-bold";

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

        // descricao
        $this->descricao->ViewValue = $this->descricao->CurrentValue;
        $this->descricao->CssClass = "fw-bold";

        // consequencia
        $this->consequencia->ViewValue = $this->consequencia->CurrentValue;
        $this->consequencia->CssClass = "fw-bold";

        // frequencia_idfrequencia
        $curVal = strval($this->frequencia_idfrequencia->CurrentValue);
        if ($curVal != "") {
            $this->frequencia_idfrequencia->ViewValue = $this->frequencia_idfrequencia->lookupCacheOption($curVal);
            if ($this->frequencia_idfrequencia->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->frequencia_idfrequencia->Lookup->getTable()->Fields["idfrequencia"]->searchExpression(), "=", $curVal, $this->frequencia_idfrequencia->Lookup->getTable()->Fields["idfrequencia"]->searchDataType(), "");
                $sqlWrk = $this->frequencia_idfrequencia->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->frequencia_idfrequencia->Lookup->renderViewRow($rswrk[0]);
                    $this->frequencia_idfrequencia->ViewValue = $this->frequencia_idfrequencia->displayValue($arwrk);
                } else {
                    $this->frequencia_idfrequencia->ViewValue = FormatNumber($this->frequencia_idfrequencia->CurrentValue, $this->frequencia_idfrequencia->formatPattern());
                }
            }
        } else {
            $this->frequencia_idfrequencia->ViewValue = null;
        }
        $this->frequencia_idfrequencia->CssClass = "fw-bold";

        // impacto_idimpacto
        $curVal = strval($this->impacto_idimpacto->CurrentValue);
        if ($curVal != "") {
            $this->impacto_idimpacto->ViewValue = $this->impacto_idimpacto->lookupCacheOption($curVal);
            if ($this->impacto_idimpacto->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchExpression(), "=", $curVal, $this->impacto_idimpacto->Lookup->getTable()->Fields["idimpacto"]->searchDataType(), "");
                $sqlWrk = $this->impacto_idimpacto->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->impacto_idimpacto->Lookup->renderViewRow($rswrk[0]);
                    $this->impacto_idimpacto->ViewValue = $this->impacto_idimpacto->displayValue($arwrk);
                } else {
                    $this->impacto_idimpacto->ViewValue = FormatNumber($this->impacto_idimpacto->CurrentValue, $this->impacto_idimpacto->formatPattern());
                }
            }
        } else {
            $this->impacto_idimpacto->ViewValue = null;
        }
        $this->impacto_idimpacto->CssClass = "fw-bold";

        // grau_atencao
        $this->grau_atencao->ViewValue = $this->grau_atencao->CurrentValue;
        $this->grau_atencao->ViewValue = FormatNumber($this->grau_atencao->ViewValue, $this->grau_atencao->formatPattern());
        $this->grau_atencao->CssClass = "fw-bold";
        $this->grau_atencao->CellCssStyle .= "text-align: center;";

        // acao_risco_oportunidade_idacao_risco_oportunidade
        $curVal = strval($this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue);
        if ($curVal != "") {
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->lookupCacheOption($curVal);
            if ($this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getTable()->Fields["idacao_risco_oportunidade"]->searchExpression(), "=", $curVal, $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getTable()->Fields["idacao_risco_oportunidade"]->searchDataType(), "");
                $sqlWrk = $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->renderViewRow($rswrk[0]);
                    $this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue = $this->acao_risco_oportunidade_idacao_risco_oportunidade->displayValue($arwrk);
                } else {
                    $this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue = FormatNumber($this->acao_risco_oportunidade_idacao_risco_oportunidade->CurrentValue, $this->acao_risco_oportunidade_idacao_risco_oportunidade->formatPattern());
                }
            }
        } else {
            $this->acao_risco_oportunidade_idacao_risco_oportunidade->ViewValue = null;
        }
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->CssClass = "fw-bold";

        // plano_acao
        if (strval($this->plano_acao->CurrentValue) != "") {
            $this->plano_acao->ViewValue = $this->plano_acao->optionCaption($this->plano_acao->CurrentValue);
        } else {
            $this->plano_acao->ViewValue = null;
        }
        $this->plano_acao->CssClass = "fw-bold";
        $this->plano_acao->CellCssStyle .= "text-align: center;";

        // idrisco_oportunidade
        $this->idrisco_oportunidade->HrefValue = "";
        $this->idrisco_oportunidade->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // tipo_risco_oportunidade_idtipo_risco_oportunidade
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->HrefValue = "";
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->TooltipValue = "";

        // titulo
        $this->titulo->HrefValue = "";
        $this->titulo->TooltipValue = "";

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->HrefValue = "";
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->TooltipValue = "";

        // descricao
        $this->descricao->HrefValue = "";
        $this->descricao->TooltipValue = "";

        // consequencia
        $this->consequencia->HrefValue = "";
        $this->consequencia->TooltipValue = "";

        // frequencia_idfrequencia
        $this->frequencia_idfrequencia->HrefValue = "";
        $this->frequencia_idfrequencia->TooltipValue = "";

        // impacto_idimpacto
        $this->impacto_idimpacto->HrefValue = "";
        $this->impacto_idimpacto->TooltipValue = "";

        // grau_atencao
        $this->grau_atencao->HrefValue = "";
        $this->grau_atencao->TooltipValue = "";

        // acao_risco_oportunidade_idacao_risco_oportunidade
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->HrefValue = "";
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->TooltipValue = "";

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

        // idrisco_oportunidade
        $this->idrisco_oportunidade->setupEditAttributes();
        $this->idrisco_oportunidade->EditValue = $this->idrisco_oportunidade->CurrentValue;
        $this->idrisco_oportunidade->CssClass = "fw-bold";
        $this->idrisco_oportunidade->CellCssStyle .= "text-align: center;";

        // dt_cadastro

        // tipo_risco_oportunidade_idtipo_risco_oportunidade
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->PlaceHolder = RemoveHtml($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption());

        // titulo
        $this->titulo->setupEditAttributes();
        if (!$this->titulo->Raw) {
            $this->titulo->CurrentValue = HtmlDecode($this->titulo->CurrentValue);
        }
        $this->titulo->EditValue = $this->titulo->CurrentValue;
        $this->titulo->PlaceHolder = RemoveHtml($this->titulo->caption());

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setupEditAttributes();
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->PlaceHolder = RemoveHtml($this->origem_risco_oportunidade_idorigem_risco_oportunidade->caption());

        // descricao
        $this->descricao->setupEditAttributes();
        $this->descricao->EditValue = $this->descricao->CurrentValue;
        $this->descricao->PlaceHolder = RemoveHtml($this->descricao->caption());

        // consequencia
        $this->consequencia->setupEditAttributes();
        $this->consequencia->EditValue = $this->consequencia->CurrentValue;
        $this->consequencia->PlaceHolder = RemoveHtml($this->consequencia->caption());

        // frequencia_idfrequencia
        $this->frequencia_idfrequencia->setupEditAttributes();
        $this->frequencia_idfrequencia->PlaceHolder = RemoveHtml($this->frequencia_idfrequencia->caption());

        // impacto_idimpacto
        $this->impacto_idimpacto->setupEditAttributes();
        $this->impacto_idimpacto->PlaceHolder = RemoveHtml($this->impacto_idimpacto->caption());

        // grau_atencao
        $this->grau_atencao->setupEditAttributes();
        $this->grau_atencao->EditValue = $this->grau_atencao->CurrentValue;
        $this->grau_atencao->EditValue = FormatNumber($this->grau_atencao->EditValue, $this->grau_atencao->formatPattern());
        $this->grau_atencao->CssClass = "fw-bold";
        $this->grau_atencao->CellCssStyle .= "text-align: center;";

        // acao_risco_oportunidade_idacao_risco_oportunidade
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setupEditAttributes();
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->PlaceHolder = RemoveHtml($this->acao_risco_oportunidade_idacao_risco_oportunidade->caption());

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
            $this->descricao->Count++; // Increment count
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->descricao->CurrentValue = $this->descricao->Count;
            $this->descricao->ViewValue = $this->descricao->CurrentValue;
            $this->descricao->CssClass = "fw-bold";
            $this->descricao->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->idrisco_oportunidade);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->tipo_risco_oportunidade_idtipo_risco_oportunidade);
                    $doc->exportCaption($this->titulo);
                    $doc->exportCaption($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                    $doc->exportCaption($this->descricao);
                    $doc->exportCaption($this->consequencia);
                    $doc->exportCaption($this->frequencia_idfrequencia);
                    $doc->exportCaption($this->impacto_idimpacto);
                    $doc->exportCaption($this->grau_atencao);
                    $doc->exportCaption($this->acao_risco_oportunidade_idacao_risco_oportunidade);
                    $doc->exportCaption($this->plano_acao);
                } else {
                    $doc->exportCaption($this->idrisco_oportunidade);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->tipo_risco_oportunidade_idtipo_risco_oportunidade);
                    $doc->exportCaption($this->titulo);
                    $doc->exportCaption($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                    $doc->exportCaption($this->frequencia_idfrequencia);
                    $doc->exportCaption($this->impacto_idimpacto);
                    $doc->exportCaption($this->grau_atencao);
                    $doc->exportCaption($this->acao_risco_oportunidade_idacao_risco_oportunidade);
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
                        $doc->exportField($this->idrisco_oportunidade);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->tipo_risco_oportunidade_idtipo_risco_oportunidade);
                        $doc->exportField($this->titulo);
                        $doc->exportField($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                        $doc->exportField($this->descricao);
                        $doc->exportField($this->consequencia);
                        $doc->exportField($this->frequencia_idfrequencia);
                        $doc->exportField($this->impacto_idimpacto);
                        $doc->exportField($this->grau_atencao);
                        $doc->exportField($this->acao_risco_oportunidade_idacao_risco_oportunidade);
                        $doc->exportField($this->plano_acao);
                    } else {
                        $doc->exportField($this->idrisco_oportunidade);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->tipo_risco_oportunidade_idtipo_risco_oportunidade);
                        $doc->exportField($this->titulo);
                        $doc->exportField($this->origem_risco_oportunidade_idorigem_risco_oportunidade);
                        $doc->exportField($this->frequencia_idfrequencia);
                        $doc->exportField($this->impacto_idimpacto);
                        $doc->exportField($this->grau_atencao);
                        $doc->exportField($this->acao_risco_oportunidade_idacao_risco_oportunidade);
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

    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }
    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
    $idrisco_oportunidade = $rsnew[('idrisco_oportunidade')];    
    $idfrequencia = $rsnew[('frequencia_idfrequencia')];
    $idimpacto    = $rsnew[('impacto_idimpacto')];
    //////////////////////
    $grau_frequencia = ExecuteScalar("SELECT grau FROM frequencia WHERE idfrequencia = $idfrequencia");
    $grau_impacto    = ExecuteScalar("SELECT grau FROM impacto    WHERE idimpacto = $idimpacto");
    ///////////////////
    ExecuteStatement("UPDATE risco_oportunidade SET grau_atencao = ($grau_frequencia * $grau_impacto) WHERE idrisco_oportunidade = $idrisco_oportunidade");
        //Log("Row Inserted");
    }
    // Get a field value
    // NOTE: Modify your SQL here, replace the table name, field name and the condition

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
        $idrisco_oportunidade = $rsnew[('idrisco_oportunidade')];    
    $idfrequencia = $rsnew[('frequencia_idfrequencia')];
    $idimpacto    = $rsnew[('impacto_idimpacto')];
    //////////////////////
    $grau_frequencia = ExecuteScalar("SELECT grau FROM frequencia WHERE idfrequencia = $idfrequencia");
    $grau_impacto    = ExecuteScalar("SELECT grau FROM impacto    WHERE idimpacto = $idimpacto");
    ///////////////////
    ExecuteStatement("UPDATE risco_oportunidade SET grau_atencao = ($grau_frequencia * $grau_impacto) WHERE idrisco_oportunidade = $idrisco_oportunidade");
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
