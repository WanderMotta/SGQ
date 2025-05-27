<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAcaoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_acao: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
ew.PREVIEW_SELECTOR ??= ".ew-preview-btn";
ew.PREVIEW_TYPE ??= "row";
ew.PREVIEW_NAV_STYLE ??= "tabs"; // tabs/pills/underline
ew.PREVIEW_MODAL_CLASS ??= "modal modal-fullscreen-sm-down";
ew.PREVIEW_ROW ??= true;
ew.PREVIEW_SINGLE_ROW ??= false;
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.min.js?v=24.12.0", "preview");
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "risco_oportunidade") {
    if ($Page->MasterRecordExists) {
        include_once "views/RiscoOportunidadeMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fplano_acaosrch" id="fplano_acaosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fplano_acaosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_acao: currentTable } });
var currentForm;
var fplano_acaosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fplano_acaosrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fplano_acaosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fplano_acaosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fplano_acaosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fplano_acaosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="plano_acao">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "risco_oportunidade" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="risco_oportunidade">
<input type="hidden" name="fk_idrisco_oportunidade" value="<?= HtmlEncode($Page->risco_oportunidade_idrisco_oportunidade->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_plano_acao" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_plano_acaolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
        <th data-name="risco_oportunidade_idrisco_oportunidade" class="<?= $Page->risco_oportunidade_idrisco_oportunidade->headerCellClass() ?>"><div id="elh_plano_acao_risco_oportunidade_idrisco_oportunidade" class="plano_acao_risco_oportunidade_idrisco_oportunidade"><?= $Page->renderFieldHeader($Page->risco_oportunidade_idrisco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <th data-name="o_q_sera_feito" class="<?= $Page->o_q_sera_feito->headerCellClass() ?>"><div id="elh_plano_acao_o_q_sera_feito" class="plano_acao_o_q_sera_feito"><?= $Page->renderFieldHeader($Page->o_q_sera_feito) ?></div></th>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
        <th data-name="efeito_esperado" class="<?= $Page->efeito_esperado->headerCellClass() ?>"><div id="elh_plano_acao_efeito_esperado" class="plano_acao_efeito_esperado"><?= $Page->renderFieldHeader($Page->efeito_esperado) ?></div></th>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <th data-name="departamentos_iddepartamentos" class="<?= $Page->departamentos_iddepartamentos->headerCellClass() ?>"><div id="elh_plano_acao_departamentos_iddepartamentos" class="plano_acao_departamentos_iddepartamentos"><?= $Page->renderFieldHeader($Page->departamentos_iddepartamentos) ?></div></th>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <th data-name="origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->headerCellClass() ?>"><div id="elh_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade" class="plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->renderFieldHeader($Page->origem_risco_oportunidade_idorigem_risco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
        <th data-name="recursos_nec" class="<?= $Page->recursos_nec->headerCellClass() ?>"><div id="elh_plano_acao_recursos_nec" class="plano_acao_recursos_nec"><?= $Page->renderFieldHeader($Page->recursos_nec) ?></div></th>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
        <th data-name="dt_limite" class="<?= $Page->dt_limite->headerCellClass() ?>"><div id="elh_plano_acao_dt_limite" class="plano_acao_dt_limite"><?= $Page->renderFieldHeader($Page->dt_limite) ?></div></th>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
        <th data-name="implementado" class="<?= $Page->implementado->headerCellClass() ?>"><div id="elh_plano_acao_implementado" class="plano_acao_implementado"><?= $Page->renderFieldHeader($Page->implementado) ?></div></th>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <th data-name="periodicidade_idperiodicidade" class="<?= $Page->periodicidade_idperiodicidade->headerCellClass() ?>"><div id="elh_plano_acao_periodicidade_idperiodicidade" class="plano_acao_periodicidade_idperiodicidade"><?= $Page->renderFieldHeader($Page->periodicidade_idperiodicidade) ?></div></th>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
        <th data-name="eficaz" class="<?= $Page->eficaz->headerCellClass() ?>"><div id="elh_plano_acao_eficaz" class="plano_acao_eficaz"><?= $Page->renderFieldHeader($Page->eficaz) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$') {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        (!(($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0))
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
        <td data-name="risco_oportunidade_idrisco_oportunidade"<?= $Page->risco_oportunidade_idrisco_oportunidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_plano_acao_risco_oportunidade_idrisco_oportunidade" class="el_plano_acao_risco_oportunidade_idrisco_oportunidade">
<span<?= $Page->risco_oportunidade_idrisco_oportunidade->viewAttributes() ?>>
<?= $Page->risco_oportunidade_idrisco_oportunidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <td data-name="o_q_sera_feito"<?= $Page->o_q_sera_feito->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_plano_acao_o_q_sera_feito" class="el_plano_acao_o_q_sera_feito">
<span<?= $Page->o_q_sera_feito->viewAttributes() ?>>
<?= $Page->o_q_sera_feito->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
        <td data-name="efeito_esperado"<?= $Page->efeito_esperado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_plano_acao_efeito_esperado" class="el_plano_acao_efeito_esperado">
<span<?= $Page->efeito_esperado->viewAttributes() ?>>
<?= $Page->efeito_esperado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <td data-name="departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_plano_acao_departamentos_iddepartamentos" class="el_plano_acao_departamentos_iddepartamentos">
<span<?= $Page->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Page->departamentos_iddepartamentos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <td data-name="origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade" class="el_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade">
<span<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
        <td data-name="recursos_nec"<?= $Page->recursos_nec->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_plano_acao_recursos_nec" class="el_plano_acao_recursos_nec">
<span<?= $Page->recursos_nec->viewAttributes() ?>>
<?= $Page->recursos_nec->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dt_limite->Visible) { // dt_limite ?>
        <td data-name="dt_limite"<?= $Page->dt_limite->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_plano_acao_dt_limite" class="el_plano_acao_dt_limite">
<span<?= $Page->dt_limite->viewAttributes() ?>>
<?= $Page->dt_limite->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->implementado->Visible) { // implementado ?>
        <td data-name="implementado"<?= $Page->implementado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_plano_acao_implementado" class="el_plano_acao_implementado">
<span<?= $Page->implementado->viewAttributes() ?>>
<?= $Page->implementado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <td data-name="periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_plano_acao_periodicidade_idperiodicidade" class="el_plano_acao_periodicidade_idperiodicidade">
<span<?= $Page->periodicidade_idperiodicidade->viewAttributes() ?>>
<?= $Page->periodicidade_idperiodicidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->eficaz->Visible) { // eficaz ?>
        <td data-name="eficaz"<?= $Page->eficaz->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_plano_acao_eficaz" class="el_plano_acao_eficaz">
<span<?= $Page->eficaz->viewAttributes() ?>>
<?= $Page->eficaz->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
<?php
// Render aggregate row
$Page->RowType = RowType::AGGREGATE;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->TotalRecords > 0 && !$Page->isGridAdd() && !$Page->isGridEdit() && !$Page->isMultiEdit()) { ?>
<tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (footer, left)
$Page->ListOptions->render("footer", "left");
?>
    <?php if ($Page->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
        <td data-name="risco_oportunidade_idrisco_oportunidade" class="<?= $Page->risco_oportunidade_idrisco_oportunidade->footerCellClass() ?>"><span id="elf_plano_acao_risco_oportunidade_idrisco_oportunidade" class="plano_acao_risco_oportunidade_idrisco_oportunidade">
        </span></td>
    <?php } ?>
    <?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <td data-name="o_q_sera_feito" class="<?= $Page->o_q_sera_feito->footerCellClass() ?>"><span id="elf_plano_acao_o_q_sera_feito" class="plano_acao_o_q_sera_feito">
        </span></td>
    <?php } ?>
    <?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
        <td data-name="efeito_esperado" class="<?= $Page->efeito_esperado->footerCellClass() ?>"><span id="elf_plano_acao_efeito_esperado" class="plano_acao_efeito_esperado">
        </span></td>
    <?php } ?>
    <?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <td data-name="departamentos_iddepartamentos" class="<?= $Page->departamentos_iddepartamentos->footerCellClass() ?>"><span id="elf_plano_acao_departamentos_iddepartamentos" class="plano_acao_departamentos_iddepartamentos">
        </span></td>
    <?php } ?>
    <?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <td data-name="origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->footerCellClass() ?>"><span id="elf_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade" class="plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade">
        </span></td>
    <?php } ?>
    <?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
        <td data-name="recursos_nec" class="<?= $Page->recursos_nec->footerCellClass() ?>"><span id="elf_plano_acao_recursos_nec" class="plano_acao_recursos_nec">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->recursos_nec->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->dt_limite->Visible) { // dt_limite ?>
        <td data-name="dt_limite" class="<?= $Page->dt_limite->footerCellClass() ?>"><span id="elf_plano_acao_dt_limite" class="plano_acao_dt_limite">
        </span></td>
    <?php } ?>
    <?php if ($Page->implementado->Visible) { // implementado ?>
        <td data-name="implementado" class="<?= $Page->implementado->footerCellClass() ?>"><span id="elf_plano_acao_implementado" class="plano_acao_implementado">
        </span></td>
    <?php } ?>
    <?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <td data-name="periodicidade_idperiodicidade" class="<?= $Page->periodicidade_idperiodicidade->footerCellClass() ?>"><span id="elf_plano_acao_periodicidade_idperiodicidade" class="plano_acao_periodicidade_idperiodicidade">
        </span></td>
    <?php } ?>
    <?php if ($Page->eficaz->Visible) { // eficaz ?>
        <td data-name="eficaz" class="<?= $Page->eficaz->footerCellClass() ?>"><span id="elf_plano_acao_eficaz" class="plano_acao_eficaz">
        </span></td>
    <?php } ?>
<?php
// Render list options (footer, right)
$Page->ListOptions->render("footer", "right");
?>
    </tr>
</tfoot>
<?php } ?>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Recordset?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("plano_acao");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
