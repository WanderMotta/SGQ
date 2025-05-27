<?php

namespace PHPMaker2024\sgq;

// Page object
$RevisaoDocumentoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { revisao_documento: currentTable } });
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "documento_interno") {
    if ($Page->MasterRecordExists) {
        include_once "views/DocumentoInternoMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="frevisao_documentosrch" id="frevisao_documentosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frevisao_documentosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { revisao_documento: currentTable } });
var currentForm;
var frevisao_documentosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frevisao_documentosrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="frevisao_documentosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="frevisao_documentosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="frevisao_documentosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="frevisao_documentosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="revisao_documento">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "documento_interno" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="documento_interno">
<input type="hidden" name="fk_iddocumento_interno" value="<?= HtmlEncode($Page->documento_interno_iddocumento_interno->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_revisao_documento" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_revisao_documentolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th data-name="dt_cadastro" class="<?= $Page->dt_cadastro->headerCellClass() ?>"><div id="elh_revisao_documento_dt_cadastro" class="revisao_documento_dt_cadastro"><?= $Page->renderFieldHeader($Page->dt_cadastro) ?></div></th>
<?php } ?>
<?php if ($Page->qual_alteracao->Visible) { // qual_alteracao ?>
        <th data-name="qual_alteracao" class="<?= $Page->qual_alteracao->headerCellClass() ?>"><div id="elh_revisao_documento_qual_alteracao" class="revisao_documento_qual_alteracao"><?= $Page->renderFieldHeader($Page->qual_alteracao) ?></div></th>
<?php } ?>
<?php if ($Page->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
        <th data-name="status_documento_idstatus_documento" class="<?= $Page->status_documento_idstatus_documento->headerCellClass() ?>"><div id="elh_revisao_documento_status_documento_idstatus_documento" class="revisao_documento_status_documento_idstatus_documento"><?= $Page->renderFieldHeader($Page->status_documento_idstatus_documento) ?></div></th>
<?php } ?>
<?php if ($Page->revisao_nr->Visible) { // revisao_nr ?>
        <th data-name="revisao_nr" class="<?= $Page->revisao_nr->headerCellClass() ?>"><div id="elh_revisao_documento_revisao_nr" class="revisao_documento_revisao_nr"><?= $Page->renderFieldHeader($Page->revisao_nr) ?></div></th>
<?php } ?>
<?php if ($Page->usuario_elaborador->Visible) { // usuario_elaborador ?>
        <th data-name="usuario_elaborador" class="<?= $Page->usuario_elaborador->headerCellClass() ?>"><div id="elh_revisao_documento_usuario_elaborador" class="revisao_documento_usuario_elaborador"><?= $Page->renderFieldHeader($Page->usuario_elaborador) ?></div></th>
<?php } ?>
<?php if ($Page->usuario_aprovador->Visible) { // usuario_aprovador ?>
        <th data-name="usuario_aprovador" class="<?= $Page->usuario_aprovador->headerCellClass() ?>"><div id="elh_revisao_documento_usuario_aprovador" class="revisao_documento_usuario_aprovador"><?= $Page->renderFieldHeader($Page->usuario_aprovador) ?></div></th>
<?php } ?>
<?php if ($Page->dt_aprovacao->Visible) { // dt_aprovacao ?>
        <th data-name="dt_aprovacao" class="<?= $Page->dt_aprovacao->headerCellClass() ?>"><div id="elh_revisao_documento_dt_aprovacao" class="revisao_documento_dt_aprovacao"><?= $Page->renderFieldHeader($Page->dt_aprovacao) ?></div></th>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
        <th data-name="anexo" class="<?= $Page->anexo->headerCellClass() ?>"><div id="elh_revisao_documento_anexo" class="revisao_documento_anexo"><?= $Page->renderFieldHeader($Page->anexo) ?></div></th>
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
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_revisao_documento_dt_cadastro" class="el_revisao_documento_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->qual_alteracao->Visible) { // qual_alteracao ?>
        <td data-name="qual_alteracao"<?= $Page->qual_alteracao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_revisao_documento_qual_alteracao" class="el_revisao_documento_qual_alteracao">
<span<?= $Page->qual_alteracao->viewAttributes() ?>>
<?= $Page->qual_alteracao->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
        <td data-name="status_documento_idstatus_documento"<?= $Page->status_documento_idstatus_documento->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_revisao_documento_status_documento_idstatus_documento" class="el_revisao_documento_status_documento_idstatus_documento">
<span<?= $Page->status_documento_idstatus_documento->viewAttributes() ?>>
<?= $Page->status_documento_idstatus_documento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->revisao_nr->Visible) { // revisao_nr ?>
        <td data-name="revisao_nr"<?= $Page->revisao_nr->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_revisao_documento_revisao_nr" class="el_revisao_documento_revisao_nr">
<span<?= $Page->revisao_nr->viewAttributes() ?>>
<?= $Page->revisao_nr->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario_elaborador->Visible) { // usuario_elaborador ?>
        <td data-name="usuario_elaborador"<?= $Page->usuario_elaborador->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_revisao_documento_usuario_elaborador" class="el_revisao_documento_usuario_elaborador">
<span<?= $Page->usuario_elaborador->viewAttributes() ?>>
<?= $Page->usuario_elaborador->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario_aprovador->Visible) { // usuario_aprovador ?>
        <td data-name="usuario_aprovador"<?= $Page->usuario_aprovador->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_revisao_documento_usuario_aprovador" class="el_revisao_documento_usuario_aprovador">
<span<?= $Page->usuario_aprovador->viewAttributes() ?>>
<?= $Page->usuario_aprovador->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dt_aprovacao->Visible) { // dt_aprovacao ?>
        <td data-name="dt_aprovacao"<?= $Page->dt_aprovacao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_revisao_documento_dt_aprovacao" class="el_revisao_documento_dt_aprovacao">
<span<?= $Page->dt_aprovacao->viewAttributes() ?>>
<?= $Page->dt_aprovacao->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->anexo->Visible) { // anexo ?>
        <td data-name="anexo"<?= $Page->anexo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_revisao_documento_anexo" class="el_revisao_documento_anexo">
<span<?= $Page->anexo->viewAttributes() ?>>
<?= GetFileViewTag($Page->anexo, $Page->anexo->getViewValue(), false) ?>
</span>
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
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro" class="<?= $Page->dt_cadastro->footerCellClass() ?>"><span id="elf_revisao_documento_dt_cadastro" class="revisao_documento_dt_cadastro">
        </span></td>
    <?php } ?>
    <?php if ($Page->qual_alteracao->Visible) { // qual_alteracao ?>
        <td data-name="qual_alteracao" class="<?= $Page->qual_alteracao->footerCellClass() ?>"><span id="elf_revisao_documento_qual_alteracao" class="revisao_documento_qual_alteracao">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->qual_alteracao->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
        <td data-name="status_documento_idstatus_documento" class="<?= $Page->status_documento_idstatus_documento->footerCellClass() ?>"><span id="elf_revisao_documento_status_documento_idstatus_documento" class="revisao_documento_status_documento_idstatus_documento">
        </span></td>
    <?php } ?>
    <?php if ($Page->revisao_nr->Visible) { // revisao_nr ?>
        <td data-name="revisao_nr" class="<?= $Page->revisao_nr->footerCellClass() ?>"><span id="elf_revisao_documento_revisao_nr" class="revisao_documento_revisao_nr">
        </span></td>
    <?php } ?>
    <?php if ($Page->usuario_elaborador->Visible) { // usuario_elaborador ?>
        <td data-name="usuario_elaborador" class="<?= $Page->usuario_elaborador->footerCellClass() ?>"><span id="elf_revisao_documento_usuario_elaborador" class="revisao_documento_usuario_elaborador">
        </span></td>
    <?php } ?>
    <?php if ($Page->usuario_aprovador->Visible) { // usuario_aprovador ?>
        <td data-name="usuario_aprovador" class="<?= $Page->usuario_aprovador->footerCellClass() ?>"><span id="elf_revisao_documento_usuario_aprovador" class="revisao_documento_usuario_aprovador">
        </span></td>
    <?php } ?>
    <?php if ($Page->dt_aprovacao->Visible) { // dt_aprovacao ?>
        <td data-name="dt_aprovacao" class="<?= $Page->dt_aprovacao->footerCellClass() ?>"><span id="elf_revisao_documento_dt_aprovacao" class="revisao_documento_dt_aprovacao">
        </span></td>
    <?php } ?>
    <?php if ($Page->anexo->Visible) { // anexo ?>
        <td data-name="anexo" class="<?= $Page->anexo->footerCellClass() ?>"><span id="elf_revisao_documento_anexo" class="revisao_documento_anexo">
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
    ew.addEventHandlers("revisao_documento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
