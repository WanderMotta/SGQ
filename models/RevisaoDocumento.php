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
 * Table class for revisao_documento
 */
class RevisaoDocumento extends DbTable
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
    public $idrevisao_documento;
    public $documento_interno_iddocumento_interno;
    public $dt_cadastro;
    public $qual_alteracao;
    public $status_documento_idstatus_documento;
    public $revisao_nr;
    public $usuario_elaborador;
    public $usuario_aprovador;
    public $dt_aprovacao;
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
        $this->TableVar = "revisao_documento";
        $this->TableName = 'revisao_documento';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "revisao_documento";
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

        // idrevisao_documento
        $this->idrevisao_documento = new DbField(
            $this, // Table
            'x_idrevisao_documento', // Variable name
            'idrevisao_documento', // Name
            '`idrevisao_documento`', // Expression
            '`idrevisao_documento`', // Basic search expression
            19, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`idrevisao_documento`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->idrevisao_documento->InputTextType = "text";
        $this->idrevisao_documento->Raw = true;
        $this->idrevisao_documento->IsAutoIncrement = true; // Autoincrement field
        $this->idrevisao_documento->IsPrimaryKey = true; // Primary key field
        $this->idrevisao_documento->Nullable = false; // NOT NULL field
        $this->idrevisao_documento->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idrevisao_documento->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['idrevisao_documento'] = &$this->idrevisao_documento;

        // documento_interno_iddocumento_interno
        $this->documento_interno_iddocumento_interno = new DbField(
            $this, // Table
            'x_documento_interno_iddocumento_interno', // Variable name
            'documento_interno_iddocumento_interno', // Name
            '`documento_interno_iddocumento_interno`', // Expression
            '`documento_interno_iddocumento_interno`', // Basic search expression
            19, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`documento_interno_iddocumento_interno`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->documento_interno_iddocumento_interno->InputTextType = "text";
        $this->documento_interno_iddocumento_interno->Raw = true;
        $this->documento_interno_iddocumento_interno->IsForeignKey = true; // Foreign key field
        $this->documento_interno_iddocumento_interno->Nullable = false; // NOT NULL field
        $this->documento_interno_iddocumento_interno->Required = true; // Required field
        $this->documento_interno_iddocumento_interno->setSelectMultiple(false); // Select one
        $this->documento_interno_iddocumento_interno->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->documento_interno_iddocumento_interno->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->documento_interno_iddocumento_interno->Lookup = new Lookup($this->documento_interno_iddocumento_interno, 'documento_interno', false, 'iddocumento_interno', ["titulo_documento","","",""], '', '', [], [], [], [], [], [], false, '', '', "`titulo_documento`");
        $this->documento_interno_iddocumento_interno->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->documento_interno_iddocumento_interno->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['documento_interno_iddocumento_interno'] = &$this->documento_interno_iddocumento_interno;

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
        $this->dt_cadastro->addMethod("getDefault", fn() => date('d/m/Y'));
        $this->dt_cadastro->InputTextType = "text";
        $this->dt_cadastro->Raw = true;
        $this->dt_cadastro->Nullable = false; // NOT NULL field
        $this->dt_cadastro->Required = true; // Required field
        $this->dt_cadastro->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dt_cadastro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['dt_cadastro'] = &$this->dt_cadastro;

        // qual_alteracao
        $this->qual_alteracao = new DbField(
            $this, // Table
            'x_qual_alteracao', // Variable name
            'qual_alteracao', // Name
            '`qual_alteracao`', // Expression
            '`qual_alteracao`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`qual_alteracao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->qual_alteracao->addMethod("getDefault", fn() => "Documento Inicial");
        $this->qual_alteracao->InputTextType = "text";
        $this->qual_alteracao->Nullable = false; // NOT NULL field
        $this->qual_alteracao->Required = true; // Required field
        $this->qual_alteracao->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['qual_alteracao'] = &$this->qual_alteracao;

        // status_documento_idstatus_documento
        $this->status_documento_idstatus_documento = new DbField(
            $this, // Table
            'x_status_documento_idstatus_documento', // Variable name
            'status_documento_idstatus_documento', // Name
            '`status_documento_idstatus_documento`', // Expression
            '`status_documento_idstatus_documento`', // Basic search expression
            19, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`status_documento_idstatus_documento`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->status_documento_idstatus_documento->addMethod("getDefault", fn() => "1");
        $this->status_documento_idstatus_documento->InputTextType = "text";
        $this->status_documento_idstatus_documento->Raw = true;
        $this->status_documento_idstatus_documento->Nullable = false; // NOT NULL field
        $this->status_documento_idstatus_documento->Required = true; // Required field
        $this->status_documento_idstatus_documento->Lookup = new Lookup($this->status_documento_idstatus_documento, 'status_documento', false, 'idstatus_documento', ["status","","",""], '', '', [], [], [], [], [], [], false, '', '', "`status`");
        $this->status_documento_idstatus_documento->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->status_documento_idstatus_documento->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['status_documento_idstatus_documento'] = &$this->status_documento_idstatus_documento;

        // revisao_nr
        $this->revisao_nr = new DbField(
            $this, // Table
            'x_revisao_nr', // Variable name
            'revisao_nr', // Name
            '`revisao_nr`', // Expression
            '`revisao_nr`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`revisao_nr`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->revisao_nr->addMethod("getDefault", fn() => 0);
        $this->revisao_nr->InputTextType = "text";
        $this->revisao_nr->Raw = true;
        $this->revisao_nr->Nullable = false; // NOT NULL field
        $this->revisao_nr->Required = true; // Required field
        $this->revisao_nr->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->revisao_nr->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['revisao_nr'] = &$this->revisao_nr;

        // usuario_elaborador
        $this->usuario_elaborador = new DbField(
            $this, // Table
            'x_usuario_elaborador', // Variable name
            'usuario_elaborador', // Name
            '`usuario_elaborador`', // Expression
            '`usuario_elaborador`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`usuario_elaborador`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->usuario_elaborador->InputTextType = "text";
        $this->usuario_elaborador->Raw = true;
        $this->usuario_elaborador->Nullable = false; // NOT NULL field
        $this->usuario_elaborador->Required = true; // Required field
        $this->usuario_elaborador->setSelectMultiple(false); // Select one
        $this->usuario_elaborador->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->usuario_elaborador->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->usuario_elaborador->Lookup = new Lookup($this->usuario_elaborador, 'usuario', false, 'idusuario', ["nome","","",""], '', '', [], [], [], [], [], [], false, '`nome` ASC', '', "`nome`");
        $this->usuario_elaborador->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuario_elaborador->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['usuario_elaborador'] = &$this->usuario_elaborador;

        // usuario_aprovador
        $this->usuario_aprovador = new DbField(
            $this, // Table
            'x_usuario_aprovador', // Variable name
            'usuario_aprovador', // Name
            '`usuario_aprovador`', // Expression
            '`usuario_aprovador`', // Basic search expression
            19, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`usuario_aprovador`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->usuario_aprovador->InputTextType = "text";
        $this->usuario_aprovador->Raw = true;
        $this->usuario_aprovador->Nullable = false; // NOT NULL field
        $this->usuario_aprovador->Required = true; // Required field
        $this->usuario_aprovador->setSelectMultiple(false); // Select one
        $this->usuario_aprovador->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->usuario_aprovador->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->usuario_aprovador->Lookup = new Lookup($this->usuario_aprovador, 'usuario', false, 'idusuario', ["nome","","",""], '', '', [], [], [], [], [], [], false, '`nome` ASC', '', "`nome`");
        $this->usuario_aprovador->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->usuario_aprovador->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['usuario_aprovador'] = &$this->usuario_aprovador;

        // dt_aprovacao
        $this->dt_aprovacao = new DbField(
            $this, // Table
            'x_dt_aprovacao', // Variable name
            'dt_aprovacao', // Name
            '`dt_aprovacao`', // Expression
            CastDateFieldForLike("`dt_aprovacao`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`dt_aprovacao`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dt_aprovacao->InputTextType = "text";
        $this->dt_aprovacao->Raw = true;
        $this->dt_aprovacao->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dt_aprovacao->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['dt_aprovacao'] = &$this->dt_aprovacao;

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
        if ($this->getCurrentMasterTable() == "documento_interno") {
            $masterTable = Container("documento_interno");
            if ($this->documento_interno_iddocumento_interno->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->iddocumento_interno, $this->documento_interno_iddocumento_interno->getSessionValue(), $masterTable->iddocumento_interno->DataType, $masterTable->Dbid);
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
        if ($this->getCurrentMasterTable() == "documento_interno") {
            $masterTable = Container("documento_interno");
            if ($this->documento_interno_iddocumento_interno->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->documento_interno_iddocumento_interno, $this->documento_interno_iddocumento_interno->getSessionValue(), $masterTable->iddocumento_interno->DataType, $this->Dbid);
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
            case "documento_interno":
                $key = $keys["documento_interno_iddocumento_interno"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->iddocumento_interno->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->iddocumento_interno, $keys["documento_interno_iddocumento_interno"], $this->documento_interno_iddocumento_interno->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "documento_interno":
                return GetKeyFilter($this->documento_interno_iddocumento_interno, $masterTable->iddocumento_interno->DbValue, $masterTable->iddocumento_interno->DataType, $masterTable->Dbid);
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "revisao_documento";
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
            $this->idrevisao_documento->setDbValue($conn->lastInsertId());
            $rs['idrevisao_documento'] = $this->idrevisao_documento->DbValue;
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
            if (!isset($rs['idrevisao_documento']) && !EmptyValue($this->idrevisao_documento->CurrentValue)) {
                $rs['idrevisao_documento'] = $this->idrevisao_documento->CurrentValue;
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
            if (array_key_exists('idrevisao_documento', $rs)) {
                AddFilter($where, QuotedName('idrevisao_documento', $this->Dbid) . '=' . QuotedValue($rs['idrevisao_documento'], $this->idrevisao_documento->DataType, $this->Dbid));
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
        $this->idrevisao_documento->DbValue = $row['idrevisao_documento'];
        $this->documento_interno_iddocumento_interno->DbValue = $row['documento_interno_iddocumento_interno'];
        $this->dt_cadastro->DbValue = $row['dt_cadastro'];
        $this->qual_alteracao->DbValue = $row['qual_alteracao'];
        $this->status_documento_idstatus_documento->DbValue = $row['status_documento_idstatus_documento'];
        $this->revisao_nr->DbValue = $row['revisao_nr'];
        $this->usuario_elaborador->DbValue = $row['usuario_elaborador'];
        $this->usuario_aprovador->DbValue = $row['usuario_aprovador'];
        $this->dt_aprovacao->DbValue = $row['dt_aprovacao'];
        $this->anexo->Upload->DbValue = $row['anexo'];
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
        return "`idrevisao_documento` = @idrevisao_documento@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->idrevisao_documento->CurrentValue : $this->idrevisao_documento->OldValue;
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
                $this->idrevisao_documento->CurrentValue = $keys[0];
            } else {
                $this->idrevisao_documento->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idrevisao_documento', $row) ? $row['idrevisao_documento'] : null;
        } else {
            $val = !EmptyValue($this->idrevisao_documento->OldValue) && !$current ? $this->idrevisao_documento->OldValue : $this->idrevisao_documento->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idrevisao_documento@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("RevisaoDocumentoList");
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
            "RevisaoDocumentoView" => $Language->phrase("View"),
            "RevisaoDocumentoEdit" => $Language->phrase("Edit"),
            "RevisaoDocumentoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "RevisaoDocumentoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "RevisaoDocumentoView",
            Config("API_ADD_ACTION") => "RevisaoDocumentoAdd",
            Config("API_EDIT_ACTION") => "RevisaoDocumentoEdit",
            Config("API_DELETE_ACTION") => "RevisaoDocumentoDelete",
            Config("API_LIST_ACTION") => "RevisaoDocumentoList",
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
        return "RevisaoDocumentoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("RevisaoDocumentoView", $parm);
        } else {
            $url = $this->keyUrl("RevisaoDocumentoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "RevisaoDocumentoAdd?" . $parm;
        } else {
            $url = "RevisaoDocumentoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("RevisaoDocumentoEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("RevisaoDocumentoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("RevisaoDocumentoAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("RevisaoDocumentoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("RevisaoDocumentoDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "documento_interno" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_iddocumento_interno", $this->documento_interno_iddocumento_interno->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"idrevisao_documento\":" . VarToJson($this->idrevisao_documento->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idrevisao_documento->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->idrevisao_documento->CurrentValue);
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
            if (($keyValue = Param("idrevisao_documento") ?? Route("idrevisao_documento")) !== null) {
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
                $this->idrevisao_documento->CurrentValue = $key;
            } else {
                $this->idrevisao_documento->OldValue = $key;
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
        $this->idrevisao_documento->setDbValue($row['idrevisao_documento']);
        $this->documento_interno_iddocumento_interno->setDbValue($row['documento_interno_iddocumento_interno']);
        $this->dt_cadastro->setDbValue($row['dt_cadastro']);
        $this->qual_alteracao->setDbValue($row['qual_alteracao']);
        $this->status_documento_idstatus_documento->setDbValue($row['status_documento_idstatus_documento']);
        $this->revisao_nr->setDbValue($row['revisao_nr']);
        $this->usuario_elaborador->setDbValue($row['usuario_elaborador']);
        $this->usuario_aprovador->setDbValue($row['usuario_aprovador']);
        $this->dt_aprovacao->setDbValue($row['dt_aprovacao']);
        $this->anexo->Upload->DbValue = $row['anexo'];
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "RevisaoDocumentoList";
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

        // idrevisao_documento

        // documento_interno_iddocumento_interno

        // dt_cadastro

        // qual_alteracao

        // status_documento_idstatus_documento

        // revisao_nr

        // usuario_elaborador

        // usuario_aprovador

        // dt_aprovacao

        // anexo

        // idrevisao_documento
        $this->idrevisao_documento->ViewValue = $this->idrevisao_documento->CurrentValue;

        // documento_interno_iddocumento_interno
        $curVal = strval($this->documento_interno_iddocumento_interno->CurrentValue);
        if ($curVal != "") {
            $this->documento_interno_iddocumento_interno->ViewValue = $this->documento_interno_iddocumento_interno->lookupCacheOption($curVal);
            if ($this->documento_interno_iddocumento_interno->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchExpression(), "=", $curVal, $this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchDataType(), "");
                $sqlWrk = $this->documento_interno_iddocumento_interno->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->documento_interno_iddocumento_interno->Lookup->renderViewRow($rswrk[0]);
                    $this->documento_interno_iddocumento_interno->ViewValue = $this->documento_interno_iddocumento_interno->displayValue($arwrk);
                } else {
                    $this->documento_interno_iddocumento_interno->ViewValue = FormatNumber($this->documento_interno_iddocumento_interno->CurrentValue, $this->documento_interno_iddocumento_interno->formatPattern());
                }
            }
        } else {
            $this->documento_interno_iddocumento_interno->ViewValue = null;
        }
        $this->documento_interno_iddocumento_interno->CssClass = "fw-bold";

        // dt_cadastro
        $this->dt_cadastro->ViewValue = $this->dt_cadastro->CurrentValue;
        $this->dt_cadastro->ViewValue = FormatDateTime($this->dt_cadastro->ViewValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->CssClass = "fw-bold";

        // qual_alteracao
        $this->qual_alteracao->ViewValue = $this->qual_alteracao->CurrentValue;
        $this->qual_alteracao->CssClass = "fw-bold";

        // status_documento_idstatus_documento
        $curVal = strval($this->status_documento_idstatus_documento->CurrentValue);
        if ($curVal != "") {
            $this->status_documento_idstatus_documento->ViewValue = $this->status_documento_idstatus_documento->lookupCacheOption($curVal);
            if ($this->status_documento_idstatus_documento->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->status_documento_idstatus_documento->Lookup->getTable()->Fields["idstatus_documento"]->searchExpression(), "=", $curVal, $this->status_documento_idstatus_documento->Lookup->getTable()->Fields["idstatus_documento"]->searchDataType(), "");
                $sqlWrk = $this->status_documento_idstatus_documento->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->status_documento_idstatus_documento->Lookup->renderViewRow($rswrk[0]);
                    $this->status_documento_idstatus_documento->ViewValue = $this->status_documento_idstatus_documento->displayValue($arwrk);
                } else {
                    $this->status_documento_idstatus_documento->ViewValue = FormatNumber($this->status_documento_idstatus_documento->CurrentValue, $this->status_documento_idstatus_documento->formatPattern());
                }
            }
        } else {
            $this->status_documento_idstatus_documento->ViewValue = null;
        }
        $this->status_documento_idstatus_documento->CssClass = "fw-bold";

        // revisao_nr
        $this->revisao_nr->ViewValue = $this->revisao_nr->CurrentValue;
        $this->revisao_nr->ViewValue = FormatNumber($this->revisao_nr->ViewValue, $this->revisao_nr->formatPattern());
        $this->revisao_nr->CssClass = "fw-bold";
        $this->revisao_nr->CellCssStyle .= "text-align: center;";

        // usuario_elaborador
        $curVal = strval($this->usuario_elaborador->CurrentValue);
        if ($curVal != "") {
            $this->usuario_elaborador->ViewValue = $this->usuario_elaborador->lookupCacheOption($curVal);
            if ($this->usuario_elaborador->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->usuario_elaborador->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->usuario_elaborador->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                $sqlWrk = $this->usuario_elaborador->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->usuario_elaborador->Lookup->renderViewRow($rswrk[0]);
                    $this->usuario_elaborador->ViewValue = $this->usuario_elaborador->displayValue($arwrk);
                } else {
                    $this->usuario_elaborador->ViewValue = FormatNumber($this->usuario_elaborador->CurrentValue, $this->usuario_elaborador->formatPattern());
                }
            }
        } else {
            $this->usuario_elaborador->ViewValue = null;
        }
        $this->usuario_elaborador->CssClass = "fw-bold";

        // usuario_aprovador
        $curVal = strval($this->usuario_aprovador->CurrentValue);
        if ($curVal != "") {
            $this->usuario_aprovador->ViewValue = $this->usuario_aprovador->lookupCacheOption($curVal);
            if ($this->usuario_aprovador->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->usuario_aprovador->Lookup->getTable()->Fields["idusuario"]->searchExpression(), "=", $curVal, $this->usuario_aprovador->Lookup->getTable()->Fields["idusuario"]->searchDataType(), "");
                $sqlWrk = $this->usuario_aprovador->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->usuario_aprovador->Lookup->renderViewRow($rswrk[0]);
                    $this->usuario_aprovador->ViewValue = $this->usuario_aprovador->displayValue($arwrk);
                } else {
                    $this->usuario_aprovador->ViewValue = FormatNumber($this->usuario_aprovador->CurrentValue, $this->usuario_aprovador->formatPattern());
                }
            }
        } else {
            $this->usuario_aprovador->ViewValue = null;
        }
        $this->usuario_aprovador->CssClass = "fw-bold";

        // dt_aprovacao
        $this->dt_aprovacao->ViewValue = $this->dt_aprovacao->CurrentValue;
        $this->dt_aprovacao->ViewValue = FormatDateTime($this->dt_aprovacao->ViewValue, $this->dt_aprovacao->formatPattern());
        $this->dt_aprovacao->CssClass = "fw-bold";

        // anexo
        if (!EmptyValue($this->anexo->Upload->DbValue)) {
            $this->anexo->ViewValue = $this->anexo->Upload->DbValue;
        } else {
            $this->anexo->ViewValue = "";
        }
        $this->anexo->CssClass = "fw-bold";

        // idrevisao_documento
        $this->idrevisao_documento->HrefValue = "";
        $this->idrevisao_documento->TooltipValue = "";

        // documento_interno_iddocumento_interno
        $this->documento_interno_iddocumento_interno->HrefValue = "";
        $this->documento_interno_iddocumento_interno->TooltipValue = "";

        // dt_cadastro
        $this->dt_cadastro->HrefValue = "";
        $this->dt_cadastro->TooltipValue = "";

        // qual_alteracao
        $this->qual_alteracao->HrefValue = "";
        $this->qual_alteracao->TooltipValue = "";

        // status_documento_idstatus_documento
        $this->status_documento_idstatus_documento->HrefValue = "";
        $this->status_documento_idstatus_documento->TooltipValue = "";

        // revisao_nr
        $this->revisao_nr->HrefValue = "";
        $this->revisao_nr->TooltipValue = "";

        // usuario_elaborador
        $this->usuario_elaborador->HrefValue = "";
        $this->usuario_elaborador->TooltipValue = "";

        // usuario_aprovador
        $this->usuario_aprovador->HrefValue = "";
        $this->usuario_aprovador->TooltipValue = "";

        // dt_aprovacao
        $this->dt_aprovacao->HrefValue = "";
        $this->dt_aprovacao->TooltipValue = "";

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

        // idrevisao_documento
        $this->idrevisao_documento->setupEditAttributes();
        $this->idrevisao_documento->EditValue = $this->idrevisao_documento->CurrentValue;

        // documento_interno_iddocumento_interno
        $this->documento_interno_iddocumento_interno->setupEditAttributes();
        if ($this->documento_interno_iddocumento_interno->getSessionValue() != "") {
            $this->documento_interno_iddocumento_interno->CurrentValue = GetForeignKeyValue($this->documento_interno_iddocumento_interno->getSessionValue());
            $curVal = strval($this->documento_interno_iddocumento_interno->CurrentValue);
            if ($curVal != "") {
                $this->documento_interno_iddocumento_interno->ViewValue = $this->documento_interno_iddocumento_interno->lookupCacheOption($curVal);
                if ($this->documento_interno_iddocumento_interno->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchExpression(), "=", $curVal, $this->documento_interno_iddocumento_interno->Lookup->getTable()->Fields["iddocumento_interno"]->searchDataType(), "");
                    $sqlWrk = $this->documento_interno_iddocumento_interno->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->documento_interno_iddocumento_interno->Lookup->renderViewRow($rswrk[0]);
                        $this->documento_interno_iddocumento_interno->ViewValue = $this->documento_interno_iddocumento_interno->displayValue($arwrk);
                    } else {
                        $this->documento_interno_iddocumento_interno->ViewValue = FormatNumber($this->documento_interno_iddocumento_interno->CurrentValue, $this->documento_interno_iddocumento_interno->formatPattern());
                    }
                }
            } else {
                $this->documento_interno_iddocumento_interno->ViewValue = null;
            }
            $this->documento_interno_iddocumento_interno->CssClass = "fw-bold";
        } else {
            $this->documento_interno_iddocumento_interno->PlaceHolder = RemoveHtml($this->documento_interno_iddocumento_interno->caption());
        }

        // dt_cadastro
        $this->dt_cadastro->setupEditAttributes();
        $this->dt_cadastro->EditValue = FormatDateTime($this->dt_cadastro->CurrentValue, $this->dt_cadastro->formatPattern());
        $this->dt_cadastro->PlaceHolder = RemoveHtml($this->dt_cadastro->caption());

        // qual_alteracao
        $this->qual_alteracao->setupEditAttributes();
        $this->qual_alteracao->EditValue = $this->qual_alteracao->CurrentValue;
        $this->qual_alteracao->PlaceHolder = RemoveHtml($this->qual_alteracao->caption());

        // status_documento_idstatus_documento
        $this->status_documento_idstatus_documento->setupEditAttributes();
        $curVal = strval($this->status_documento_idstatus_documento->CurrentValue);
        if ($curVal != "") {
            $this->status_documento_idstatus_documento->EditValue = $this->status_documento_idstatus_documento->lookupCacheOption($curVal);
            if ($this->status_documento_idstatus_documento->EditValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->status_documento_idstatus_documento->Lookup->getTable()->Fields["idstatus_documento"]->searchExpression(), "=", $curVal, $this->status_documento_idstatus_documento->Lookup->getTable()->Fields["idstatus_documento"]->searchDataType(), "");
                $sqlWrk = $this->status_documento_idstatus_documento->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->status_documento_idstatus_documento->Lookup->renderViewRow($rswrk[0]);
                    $this->status_documento_idstatus_documento->EditValue = $this->status_documento_idstatus_documento->displayValue($arwrk);
                } else {
                    $this->status_documento_idstatus_documento->EditValue = FormatNumber($this->status_documento_idstatus_documento->CurrentValue, $this->status_documento_idstatus_documento->formatPattern());
                }
            }
        } else {
            $this->status_documento_idstatus_documento->EditValue = null;
        }
        $this->status_documento_idstatus_documento->CssClass = "fw-bold";

        // revisao_nr
        $this->revisao_nr->setupEditAttributes();
        $this->revisao_nr->EditValue = $this->revisao_nr->CurrentValue;
        $this->revisao_nr->PlaceHolder = RemoveHtml($this->revisao_nr->caption());
        if (strval($this->revisao_nr->EditValue) != "" && is_numeric($this->revisao_nr->EditValue)) {
            $this->revisao_nr->EditValue = FormatNumber($this->revisao_nr->EditValue, null);
        }

        // usuario_elaborador
        $this->usuario_elaborador->setupEditAttributes();
        $this->usuario_elaborador->PlaceHolder = RemoveHtml($this->usuario_elaborador->caption());

        // usuario_aprovador
        $this->usuario_aprovador->setupEditAttributes();
        $this->usuario_aprovador->PlaceHolder = RemoveHtml($this->usuario_aprovador->caption());

        // dt_aprovacao
        $this->dt_aprovacao->setupEditAttributes();
        $this->dt_aprovacao->EditValue = $this->dt_aprovacao->CurrentValue;
        $this->dt_aprovacao->EditValue = FormatDateTime($this->dt_aprovacao->EditValue, $this->dt_aprovacao->formatPattern());
        $this->dt_aprovacao->CssClass = "fw-bold";

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
            $this->qual_alteracao->Count++; // Increment count
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->qual_alteracao->CurrentValue = $this->qual_alteracao->Count;
            $this->qual_alteracao->ViewValue = $this->qual_alteracao->CurrentValue;
            $this->qual_alteracao->CssClass = "fw-bold";
            $this->qual_alteracao->HrefValue = ""; // Clear href value

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
                    $doc->exportCaption($this->idrevisao_documento);
                    $doc->exportCaption($this->documento_interno_iddocumento_interno);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->qual_alteracao);
                    $doc->exportCaption($this->status_documento_idstatus_documento);
                    $doc->exportCaption($this->revisao_nr);
                    $doc->exportCaption($this->usuario_elaborador);
                    $doc->exportCaption($this->usuario_aprovador);
                    $doc->exportCaption($this->dt_aprovacao);
                    $doc->exportCaption($this->anexo);
                } else {
                    $doc->exportCaption($this->idrevisao_documento);
                    $doc->exportCaption($this->documento_interno_iddocumento_interno);
                    $doc->exportCaption($this->dt_cadastro);
                    $doc->exportCaption($this->status_documento_idstatus_documento);
                    $doc->exportCaption($this->revisao_nr);
                    $doc->exportCaption($this->usuario_elaborador);
                    $doc->exportCaption($this->usuario_aprovador);
                    $doc->exportCaption($this->dt_aprovacao);
                    $doc->exportCaption($this->anexo);
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
                        $doc->exportField($this->idrevisao_documento);
                        $doc->exportField($this->documento_interno_iddocumento_interno);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->qual_alteracao);
                        $doc->exportField($this->status_documento_idstatus_documento);
                        $doc->exportField($this->revisao_nr);
                        $doc->exportField($this->usuario_elaborador);
                        $doc->exportField($this->usuario_aprovador);
                        $doc->exportField($this->dt_aprovacao);
                        $doc->exportField($this->anexo);
                    } else {
                        $doc->exportField($this->idrevisao_documento);
                        $doc->exportField($this->documento_interno_iddocumento_interno);
                        $doc->exportField($this->dt_cadastro);
                        $doc->exportField($this->status_documento_idstatus_documento);
                        $doc->exportField($this->revisao_nr);
                        $doc->exportField($this->usuario_elaborador);
                        $doc->exportField($this->usuario_aprovador);
                        $doc->exportField($this->dt_aprovacao);
                        $doc->exportField($this->anexo);
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
                $doc->exportAggregate($this->idrevisao_documento, '');
                $doc->exportAggregate($this->documento_interno_iddocumento_interno, '');
                $doc->exportAggregate($this->dt_cadastro, '');
                $doc->exportAggregate($this->status_documento_idstatus_documento, '');
                $doc->exportAggregate($this->revisao_nr, '');
                $doc->exportAggregate($this->usuario_elaborador, '');
                $doc->exportAggregate($this->usuario_aprovador, '');
                $doc->exportAggregate($this->dt_aprovacao, '');
                $doc->exportAggregate($this->anexo, '');
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
            $this->idrevisao_documento->CurrentValue = $ar[0];
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
