<?php

namespace PHPMaker2024\sgq;

// Page object
$DocumentoExternoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_externo: currentTable } });
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
<?php if (!$Page->IsModal) { ?>
<form name="fdocumento_externosrch" id="fdocumento_externosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fdocumento_externosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_externo: currentTable } });
var currentForm;
var fdocumento_externosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fdocumento_externosrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fdocumento_externosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fdocumento_externosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fdocumento_externosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fdocumento_externosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="documento_externo">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_documento_externo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_documento_externolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->iddocumento_externo->Visible) { // iddocumento_externo ?>
        <th data-name="iddocumento_externo" class="<?= $Page->iddocumento_externo->headerCellClass() ?>"><div id="elh_documento_externo_iddocumento_externo" class="documento_externo_iddocumento_externo"><?= $Page->renderFieldHeader($Page->iddocumento_externo) ?></div></th>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th data-name="dt_cadastro" class="<?= $Page->dt_cadastro->headerCellClass() ?>"><div id="elh_documento_externo_dt_cadastro" class="documento_externo_dt_cadastro"><?= $Page->renderFieldHeader($Page->dt_cadastro) ?></div></th>
<?php } ?>
<?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
        <th data-name="titulo_documento" class="<?= $Page->titulo_documento->headerCellClass() ?>"><div id="elh_documento_externo_titulo_documento" class="documento_externo_titulo_documento"><?= $Page->renderFieldHeader($Page->titulo_documento) ?></div></th>
<?php } ?>
<?php if ($Page->distribuicao->Visible) { // distribuicao ?>
        <th data-name="distribuicao" class="<?= $Page->distribuicao->headerCellClass() ?>"><div id="elh_documento_externo_distribuicao" class="documento_externo_distribuicao"><?= $Page->renderFieldHeader($Page->distribuicao) ?></div></th>
<?php } ?>
<?php if ($Page->tem_validade->Visible) { // tem_validade ?>
        <th data-name="tem_validade" class="<?= $Page->tem_validade->headerCellClass() ?>"><div id="elh_documento_externo_tem_validade" class="documento_externo_tem_validade"><?= $Page->renderFieldHeader($Page->tem_validade) ?></div></th>
<?php } ?>
<?php if ($Page->valido_ate->Visible) { // valido_ate ?>
        <th data-name="valido_ate" class="<?= $Page->valido_ate->headerCellClass() ?>"><div id="elh_documento_externo_valido_ate" class="documento_externo_valido_ate"><?= $Page->renderFieldHeader($Page->valido_ate) ?></div></th>
<?php } ?>
<?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
        <th data-name="restringir_acesso" class="<?= $Page->restringir_acesso->headerCellClass() ?>"><div id="elh_documento_externo_restringir_acesso" class="documento_externo_restringir_acesso"><?= $Page->renderFieldHeader($Page->restringir_acesso) ?></div></th>
<?php } ?>
<?php if ($Page->localizacao_idlocalizacao->Visible) { // localizacao_idlocalizacao ?>
        <th data-name="localizacao_idlocalizacao" class="<?= $Page->localizacao_idlocalizacao->headerCellClass() ?>"><div id="elh_documento_externo_localizacao_idlocalizacao" class="documento_externo_localizacao_idlocalizacao"><?= $Page->renderFieldHeader($Page->localizacao_idlocalizacao) ?></div></th>
<?php } ?>
<?php if ($Page->usuario_responsavel->Visible) { // usuario_responsavel ?>
        <th data-name="usuario_responsavel" class="<?= $Page->usuario_responsavel->headerCellClass() ?>"><div id="elh_documento_externo_usuario_responsavel" class="documento_externo_usuario_responsavel"><?= $Page->renderFieldHeader($Page->usuario_responsavel) ?></div></th>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
        <th data-name="anexo" class="<?= $Page->anexo->headerCellClass() ?>"><div id="elh_documento_externo_anexo" class="documento_externo_anexo"><?= $Page->renderFieldHeader($Page->anexo) ?></div></th>
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
    <?php if ($Page->iddocumento_externo->Visible) { // iddocumento_externo ?>
        <td data-name="iddocumento_externo"<?= $Page->iddocumento_externo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_externo_iddocumento_externo" class="el_documento_externo_iddocumento_externo">
<span<?= $Page->iddocumento_externo->viewAttributes() ?>>
<?= $Page->iddocumento_externo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_externo_dt_cadastro" class="el_documento_externo_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
        <td data-name="titulo_documento"<?= $Page->titulo_documento->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_externo_titulo_documento" class="el_documento_externo_titulo_documento">
<span<?= $Page->titulo_documento->viewAttributes() ?>>
<?= $Page->titulo_documento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->distribuicao->Visible) { // distribuicao ?>
        <td data-name="distribuicao"<?= $Page->distribuicao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_externo_distribuicao" class="el_documento_externo_distribuicao">
<span<?= $Page->distribuicao->viewAttributes() ?>>
<?= $Page->distribuicao->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tem_validade->Visible) { // tem_validade ?>
        <td data-name="tem_validade"<?= $Page->tem_validade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_externo_tem_validade" class="el_documento_externo_tem_validade">
<span<?= $Page->tem_validade->viewAttributes() ?>>
<?= $Page->tem_validade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->valido_ate->Visible) { // valido_ate ?>
        <td data-name="valido_ate"<?= $Page->valido_ate->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_externo_valido_ate" class="el_documento_externo_valido_ate">
<span<?= $Page->valido_ate->viewAttributes() ?>>
<?= $Page->valido_ate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
        <td data-name="restringir_acesso"<?= $Page->restringir_acesso->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_externo_restringir_acesso" class="el_documento_externo_restringir_acesso">
<span<?= $Page->restringir_acesso->viewAttributes() ?>>
<?= $Page->restringir_acesso->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->localizacao_idlocalizacao->Visible) { // localizacao_idlocalizacao ?>
        <td data-name="localizacao_idlocalizacao"<?= $Page->localizacao_idlocalizacao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_externo_localizacao_idlocalizacao" class="el_documento_externo_localizacao_idlocalizacao">
<span<?= $Page->localizacao_idlocalizacao->viewAttributes() ?>>
<?= $Page->localizacao_idlocalizacao->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario_responsavel->Visible) { // usuario_responsavel ?>
        <td data-name="usuario_responsavel"<?= $Page->usuario_responsavel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_externo_usuario_responsavel" class="el_documento_externo_usuario_responsavel">
<span<?= $Page->usuario_responsavel->viewAttributes() ?>>
<?= $Page->usuario_responsavel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->anexo->Visible) { // anexo ?>
        <td data-name="anexo"<?= $Page->anexo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_externo_anexo" class="el_documento_externo_anexo">
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
    <?php if ($Page->iddocumento_externo->Visible) { // iddocumento_externo ?>
        <td data-name="iddocumento_externo" class="<?= $Page->iddocumento_externo->footerCellClass() ?>"><span id="elf_documento_externo_iddocumento_externo" class="documento_externo_iddocumento_externo">
        </span></td>
    <?php } ?>
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro" class="<?= $Page->dt_cadastro->footerCellClass() ?>"><span id="elf_documento_externo_dt_cadastro" class="documento_externo_dt_cadastro">
        </span></td>
    <?php } ?>
    <?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
        <td data-name="titulo_documento" class="<?= $Page->titulo_documento->footerCellClass() ?>"><span id="elf_documento_externo_titulo_documento" class="documento_externo_titulo_documento">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->titulo_documento->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->distribuicao->Visible) { // distribuicao ?>
        <td data-name="distribuicao" class="<?= $Page->distribuicao->footerCellClass() ?>"><span id="elf_documento_externo_distribuicao" class="documento_externo_distribuicao">
        </span></td>
    <?php } ?>
    <?php if ($Page->tem_validade->Visible) { // tem_validade ?>
        <td data-name="tem_validade" class="<?= $Page->tem_validade->footerCellClass() ?>"><span id="elf_documento_externo_tem_validade" class="documento_externo_tem_validade">
        </span></td>
    <?php } ?>
    <?php if ($Page->valido_ate->Visible) { // valido_ate ?>
        <td data-name="valido_ate" class="<?= $Page->valido_ate->footerCellClass() ?>"><span id="elf_documento_externo_valido_ate" class="documento_externo_valido_ate">
        </span></td>
    <?php } ?>
    <?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
        <td data-name="restringir_acesso" class="<?= $Page->restringir_acesso->footerCellClass() ?>"><span id="elf_documento_externo_restringir_acesso" class="documento_externo_restringir_acesso">
        </span></td>
    <?php } ?>
    <?php if ($Page->localizacao_idlocalizacao->Visible) { // localizacao_idlocalizacao ?>
        <td data-name="localizacao_idlocalizacao" class="<?= $Page->localizacao_idlocalizacao->footerCellClass() ?>"><span id="elf_documento_externo_localizacao_idlocalizacao" class="documento_externo_localizacao_idlocalizacao">
        </span></td>
    <?php } ?>
    <?php if ($Page->usuario_responsavel->Visible) { // usuario_responsavel ?>
        <td data-name="usuario_responsavel" class="<?= $Page->usuario_responsavel->footerCellClass() ?>"><span id="elf_documento_externo_usuario_responsavel" class="documento_externo_usuario_responsavel">
        </span></td>
    <?php } ?>
    <?php if ($Page->anexo->Visible) { // anexo ?>
        <td data-name="anexo" class="<?= $Page->anexo->footerCellClass() ?>"><span id="elf_documento_externo_anexo" class="documento_externo_anexo">
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
    ew.addEventHandlers("documento_externo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
