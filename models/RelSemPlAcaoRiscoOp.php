<?php

namespace PHPMaker2023\sgq;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for rel_sem_pl_acao_risco_op
 */
class RelSemPlAcaoRiscoOp extends ReportTable
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
    public $ShowGroupHeaderAsRow = false;
    public $ShowCompactSummaryFooter = true;

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
        $Language = Container("language");
        $this->TableVar = "rel_sem_pl_acao_risco_op";
        $this->TableName = 'rel_sem_pl_acao_risco_op';
        $this->TableType = "REPORT";
        $this->ReportSourceTable = 'risco_oportunidade'; // Report source table
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (report only)

        // PDF
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = ""; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = ""; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions

        // idrisco_oportunidade
        $this->idrisco_oportunidade = new ReportField(
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
        $this->idrisco_oportunidade->IsAutoIncrement = true; // Autoincrement field
        $this->idrisco_oportunidade->IsPrimaryKey = true; // Primary key field
        $this->idrisco_oportunidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idrisco_oportunidade->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->idrisco_oportunidade->SourceTableVar = 'risco_oportunidade';
        $this->Fields['idrisco_oportunidade'] = &$this->idrisco_oportunidade;

        // dt_cadastro
        $this->dt_cadastro = new ReportField(
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
        $this->dt_cadastro->Nullable = false; // NOT NULL field
        $this->dt_cadastro->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dt_cadastro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->dt_cadastro->SourceTableVar = 'risco_oportunidade';
        $this->Fields['dt_cadastro'] = &$this->dt_cadastro;

        // tipo_risco_oportunidade_idtipo_risco_oportunidade
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade = new ReportField(
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
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->addMethod("getSearchDefault", fn() => Config("INIT_VALUE"));
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->InputTextType = "text";
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Nullable = false; // NOT NULL field
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Required = true; // Required field
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup = new Lookup('tipo_risco_oportunidade_idtipo_risco_oportunidade', 'tipo_risco_oportunidade', false, 'idtipo_risco_oportunidade', ["tipo_risco_oportunidade","","",""], '', '', [], ["x_impacto_idimpacto","x_acao_risco_oportunidade_idacao_risco_oportunidade"], [], [], [], [], '', '', "`tipo_risco_oportunidade`");
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->SearchValueDefault = $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->getSearchDefault();
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->SourceTableVar = 'risco_oportunidade';
        $this->Fields['tipo_risco_oportunidade_idtipo_risco_oportunidade'] = &$this->tipo_risco_oportunidade_idtipo_risco_oportunidade;

        // titulo
        $this->titulo = new ReportField(
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
        $this->titulo->UseFilter = true; // Table header filter
        $this->titulo->Lookup = new Lookup('titulo', 'rel_sem_pl_acao_risco_op', true, 'titulo', ["titulo","","",""], '', '', [], [], [], [], [], [], '', '', "");
        $this->titulo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->titulo->SourceTableVar = 'risco_oportunidade';
        $this->Fields['titulo'] = &$this->titulo;

        // origem_risco_oportunidade_idorigem_risco_oportunidade
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade = new ReportField(
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
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Nullable = false; // NOT NULL field
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Required = true; // Required field
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->setSelectMultiple(false); // Select one
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup = new Lookup('origem_risco_oportunidade_idorigem_risco_oportunidade', 'origem_risco_oportunidade', false, 'idorigem_risco_oportunidade', ["origem","","",""], '', '', [], [], [], [], [], [], '`origem` ASC', '', "`origem`");
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->origem_risco_oportunidade_idorigem_risco_oportunidade->SourceTableVar = 'risco_oportunidade';
        $this->Fields['origem_risco_oportunidade_idorigem_risco_oportunidade'] = &$this->origem_risco_oportunidade_idorigem_risco_oportunidade;

        // descricao
        $this->descricao = new ReportField(
            $this, // Table
            'x_descricao', // Variable name
            'descricao', // Name
            '`descricao`', // Expression
            '`descricao`', // Basic search expression
            201, // Type
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
        $this->descricao->SourceTableVar = 'risco_oportunidade';
        $this->Fields['descricao'] = &$this->descricao;

        // consequencia
        $this->consequencia = new ReportField(
            $this, // Table
            'x_consequencia', // Variable name
            'consequencia', // Name
            '`consequencia`', // Expression
            '`consequencia`', // Basic search expression
            201, // Type
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
        $this->consequencia->SourceTableVar = 'risco_oportunidade';
        $this->Fields['consequencia'] = &$this->consequencia;

        // frequencia_idfrequencia
        $this->frequencia_idfrequencia = new ReportField(
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
        $this->frequencia_idfrequencia->Nullable = false; // NOT NULL field
        $this->frequencia_idfrequencia->Required = true; // Required field
        $this->frequencia_idfrequencia->setSelectMultiple(false); // Select one
        $this->frequencia_idfrequencia->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->frequencia_idfrequencia->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->frequencia_idfrequencia->Lookup = new Lookup('frequencia_idfrequencia', 'frequencia', false, 'idfrequencia', ["grau","frequencia","",""], '', '', [], [], [], [], [], [], '`grau` ASC', '', "CONCAT(COALESCE(`grau`, ''),'" . ValueSeparator(1, $this->frequencia_idfrequencia) . "',COALESCE(`frequencia`,''))");
        $this->frequencia_idfrequencia->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->frequencia_idfrequencia->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->frequencia_idfrequencia->SourceTableVar = 'risco_oportunidade';
        $this->Fields['frequencia_idfrequencia'] = &$this->frequencia_idfrequencia;

        // impacto_idimpacto
        $this->impacto_idimpacto = new ReportField(
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
        $this->impacto_idimpacto->Nullable = false; // NOT NULL field
        $this->impacto_idimpacto->Required = true; // Required field
        $this->impacto_idimpacto->setSelectMultiple(false); // Select one
        $this->impacto_idimpacto->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->impacto_idimpacto->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->impacto_idimpacto->Lookup = new Lookup('impacto_idimpacto', 'impacto', false, 'idimpacto', ["grau","impacto","",""], '', '', ["x_tipo_risco_oportunidade_idtipo_risco_oportunidade"], [], ["tipo_risco_oportunidade_idtipo_risco_oportunidade"], ["x_tipo_risco_oportunidade_idtipo_risco_oportunidade"], [], [], '`grau` ASC', '', "CONCAT(COALESCE(`grau`, ''),'" . ValueSeparator(1, $this->impacto_idimpacto) . "',COALESCE(`impacto`,''))");
        $this->impacto_idimpacto->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->impacto_idimpacto->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->impacto_idimpacto->SourceTableVar = 'risco_oportunidade';
        $this->Fields['impacto_idimpacto'] = &$this->impacto_idimpacto;

        // grau_atencao
        $this->grau_atencao = new ReportField(
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
        $this->grau_atencao->Nullable = false; // NOT NULL field
        $this->grau_atencao->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->grau_atencao->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->grau_atencao->SourceTableVar = 'risco_oportunidade';
        $this->Fields['grau_atencao'] = &$this->grau_atencao;

        // acao_risco_oportunidade_idacao_risco_oportunidade
        $this->acao_risco_oportunidade_idacao_risco_oportunidade = new ReportField(
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
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->Nullable = false; // NOT NULL field
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->Required = true; // Required field
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->setSelectMultiple(false); // Select one
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup = new Lookup('acao_risco_oportunidade_idacao_risco_oportunidade', 'acao_risco_oportunidade', false, 'idacao_risco_oportunidade', ["acao","","",""], '', '', ["x_tipo_risco_oportunidade_idtipo_risco_oportunidade"], [], ["tipo_risco_oportunidade_idtipo_risco_oportunidade"], ["x_tipo_risco_oportunidade_idtipo_risco_oportunidade"], [], [], '`acao` ASC', '', "`acao`");
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->acao_risco_oportunidade_idacao_risco_oportunidade->SourceTableVar = 'risco_oportunidade';
        $this->Fields['acao_risco_oportunidade_idacao_risco_oportunidade'] = &$this->acao_risco_oportunidade_idacao_risco_oportunidade;

        // plano_acao
        $this->plano_acao = new ReportField(
            $this, // Table
            'x_plano_acao', // Variable name
            'plano_acao', // Name
            '`plano_acao`', // Expression
            '`plano_acao`', // Basic search expression
            129, // Type
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
        $this->plano_acao->addMethod("getSearchDefault", fn() => Config("INIT_VALUE"));
        $this->plano_acao->addMethod("getDefault", fn() => "Nao");
        $this->plano_acao->InputTextType = "text";
        $this->plano_acao->Nullable = false; // NOT NULL field
        $this->plano_acao->Lookup = new Lookup('plano_acao', 'rel_sem_pl_acao_risco_op', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
        $this->plano_acao->OptionCount = 2;
        $this->plano_acao->SearchOperators = ["=", "<>"];
        $this->plano_acao->AdvancedSearch->SearchValueDefault = $this->plano_acao->getSearchDefault();
        $this->plano_acao->SourceTableVar = 'risco_oportunidade';
        $this->Fields['plano_acao'] = &$this->plano_acao;

        // Add Doctrine Cache
        $this->Cache = new ArrayCache();
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

    // Multiple column sort
    protected function updateSort(&$fld, $ctrl)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($fld->GroupingFieldId == 0) {
                if ($ctrl) {
                    $orderBy = $this->getDetailOrderBy();
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
                    $this->setDetailOrderBy($orderBy); // Save to Session
                } else {
                    $this->setDetailOrderBy($curOrderBy); // Save to Session
                }
            }
        } else {
            if ($fld->GroupingFieldId == 0 && !$ctrl) {
                $fld->setSort("");
            }
        }
    }

    // Get Sort SQL
    protected function sortSql()
    {
        $dtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
        $argrps = [];
        foreach ($this->Fields as $fld) {
            if (in_array($fld->getSort(), ["ASC", "DESC"])) {
                $fldsql = $fld->Expression;
                if ($fld->GroupingFieldId > 0) {
                    if ($fld->GroupSql != "") {
                        $argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->GroupSql) . " " . $fld->getSort();
                    } else {
                        $argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
                    }
                }
            }
        }
        $sortSql = "";
        foreach ($argrps as $grp) {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $grp;
        }
        if ($dtlSortSql != "") {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $dtlSortSql;
        }
        return $sortSql;
    }

    // Summary properties
    private $sqlSelectAggregate = null;
    private $sqlAggregatePrefix = "";
    private $sqlAggregateSuffix = "";
    private $sqlSelectCount = null;

    // Select Aggregate
    public function getSqlSelectAggregate()
    {
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select("*");
    }

    public function setSqlSelectAggregate($v)
    {
        $this->sqlSelectAggregate = $v;
    }

    // Aggregate Prefix
    public function getSqlAggregatePrefix()
    {
        return ($this->sqlAggregatePrefix != "") ? $this->sqlAggregatePrefix : "";
    }

    public function setSqlAggregatePrefix($v)
    {
        $this->sqlAggregatePrefix = $v;
    }

    // Aggregate Suffix
    public function getSqlAggregateSuffix()
    {
        return ($this->sqlAggregateSuffix != "") ? $this->sqlAggregateSuffix : "";
    }

    public function setSqlAggregateSuffix($v)
    {
        $this->sqlAggregateSuffix = $v;
    }

    // Select Count
    public function getSqlSelectCount()
    {
        return $this->sqlSelectCount ?? $this->getQueryBuilder()->select("COUNT(*)");
    }

    public function setSqlSelectCount($v)
    {
        $this->sqlSelectCount = $v;
    }

    // Render for lookup
    public function renderLookup()
    {
        $this->tipo_risco_oportunidade_idtipo_risco_oportunidade->ViewValue = GetDropDownDisplayValue($this->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue, "", 0);
        $this->plano_acao->ViewValue = GetDropDownDisplayValue($this->plano_acao->CurrentValue, "", 0);
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "risco_oportunidade";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        if ($this->SqlSelect) {
            return $this->SqlSelect;
        }
        $select = $this->getQueryBuilder()->select("*");
        return $select;
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

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
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            case "lookup":
                return (($allow & 256) == 256);
            default:
                return (($allow & 8) == 8);
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
        $rs = null;
        if ($sql instanceof QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlwrk);
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idrisco_oportunidade` = @idrisco_oportunidade@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->idrisco_oportunidade->CurrentValue : $this->idrisco_oportunidade->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
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
        return $_SESSION[$name] ?? GetUrl("");
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
        if ($pageName == "") {
            return $Language->phrase("View");
        } elseif ($pageName == "") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "") {
            return $Language->phrase("Add");
        }
        return "";
    }

    // API page name
    public function getApiPageName($action)
    {
        return "RelSemPlAcaoRiscoOpSummary";
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
        return "";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("", $parm);
        } else {
            $url = $this->keyUrl("", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "?" . $parm;
        } else {
            $url = "";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("");
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
        $json .= "\"idrisco_oportunidade\":" . JsonEncode($this->idrisco_oportunidade->CurrentValue, "number");
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
        global $Security, $Language, $Page;
        $sortUrl = "";
        $attrs = "";
        if ($fld->Sortable) {
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
        if ($fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") . '</div></div>';
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
            $this->DrillDown ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;dashboard=true";
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
            if (($keyValue = Param("idrisco_oportunidade") ?? Route("idrisco_oportunidade")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
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

    // Load recordset based on filter / sort
    public function loadRs($filter, $sort = "")
    {
        $sql = $this->getSql($filter, $sort); // Set up filter (WHERE Clause) / sort (ORDER BY Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
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

    // Email Sending event
    public function emailSending($email, &$args)
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
