<?php

namespace PHPMaker2024\sgq;

// Page object
$DocumentoRegistroList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_registro: currentTable } });
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
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fdocumento_registrosrch" id="fdocumento_registrosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fdocumento_registrosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_registro: currentTable } });
var currentForm;
var fdocumento_registrosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fdocumento_registrosrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["categoria_documento_idcategoria_documento", [], fields.categoria_documento_idcategoria_documento.isInvalid]
        ])
        // Validate form
        .setValidate(
            async function () {
                if (!this.validateRequired)
                    return true; // Ignore validation
                let fobj = this.getForm();

                // Validate fields
                if (!this.validateFields())
                    return false;

                // Call Form_CustomValidate event
                if (!(await this.customValidate?.(fobj) ?? true)) {
                    this.focus();
                    return false;
                }
                return true;
            }
        )

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "categoria_documento_idcategoria_documento": <?= $Page->categoria_documento_idcategoria_documento->toClientList($Page) ?>,
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
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = RowType::SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
<?php
if (!$Page->categoria_documento_idcategoria_documento->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_categoria_documento_idcategoria_documento" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->categoria_documento_idcategoria_documento->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_categoria_documento_idcategoria_documento" class="ew-search-caption ew-label"><?= $Page->categoria_documento_idcategoria_documento->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_categoria_documento_idcategoria_documento" id="z_categoria_documento_idcategoria_documento" value="=">
</div>
        </div>
        <div id="el_documento_registro_categoria_documento_idcategoria_documento" class="ew-search-field">
    <select
        id="x_categoria_documento_idcategoria_documento"
        name="x_categoria_documento_idcategoria_documento"
        class="form-control ew-select<?= $Page->categoria_documento_idcategoria_documento->isInvalidClass() ?>"
        data-select2-id="fdocumento_registrosrch_x_categoria_documento_idcategoria_documento"
        data-table="documento_registro"
        data-field="x_categoria_documento_idcategoria_documento"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->categoria_documento_idcategoria_documento->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->categoria_documento_idcategoria_documento->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->categoria_documento_idcategoria_documento->getPlaceHolder()) ?>"
        <?= $Page->categoria_documento_idcategoria_documento->editAttributes() ?>>
        <?= $Page->categoria_documento_idcategoria_documento->selectOptionListHtml("x_categoria_documento_idcategoria_documento") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->categoria_documento_idcategoria_documento->getErrorMessage(false) ?></div>
<?= $Page->categoria_documento_idcategoria_documento->Lookup->getParamTag($Page, "p_x_categoria_documento_idcategoria_documento") ?>
<script>
loadjs.ready("fdocumento_registrosrch", function() {
    var options = { name: "x_categoria_documento_idcategoria_documento", selectId: "fdocumento_registrosrch_x_categoria_documento_idcategoria_documento" };
    if (fdocumento_registrosrch.lists.categoria_documento_idcategoria_documento?.lookupOptions.length) {
        options.data = { id: "x_categoria_documento_idcategoria_documento", form: "fdocumento_registrosrch" };
    } else {
        options.ajax = { id: "x_categoria_documento_idcategoria_documento", form: "fdocumento_registrosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.documento_registro.fields.categoria_documento_idcategoria_documento.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fdocumento_registrosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fdocumento_registrosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fdocumento_registrosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fdocumento_registrosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="documento_registro">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_documento_registro" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_documento_registrolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->iddocumento_registro->Visible) { // iddocumento_registro ?>
        <th data-name="iddocumento_registro" class="<?= $Page->iddocumento_registro->headerCellClass() ?>"><div id="elh_documento_registro_iddocumento_registro" class="documento_registro_iddocumento_registro"><?= $Page->renderFieldHeader($Page->iddocumento_registro) ?></div></th>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th data-name="dt_cadastro" class="<?= $Page->dt_cadastro->headerCellClass() ?>"><div id="elh_documento_registro_dt_cadastro" class="documento_registro_dt_cadastro"><?= $Page->renderFieldHeader($Page->dt_cadastro) ?></div></th>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
        <th data-name="titulo" class="<?= $Page->titulo->headerCellClass() ?>"><div id="elh_documento_registro_titulo" class="documento_registro_titulo"><?= $Page->renderFieldHeader($Page->titulo) ?></div></th>
<?php } ?>
<?php if ($Page->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
        <th data-name="categoria_documento_idcategoria_documento" class="<?= $Page->categoria_documento_idcategoria_documento->headerCellClass() ?>"><div id="elh_documento_registro_categoria_documento_idcategoria_documento" class="documento_registro_categoria_documento_idcategoria_documento"><?= $Page->renderFieldHeader($Page->categoria_documento_idcategoria_documento) ?></div></th>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th data-name="usuario_idusuario" class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><div id="elh_documento_registro_usuario_idusuario" class="documento_registro_usuario_idusuario"><?= $Page->renderFieldHeader($Page->usuario_idusuario) ?></div></th>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
        <th data-name="anexo" class="<?= $Page->anexo->headerCellClass() ?>"><div id="elh_documento_registro_anexo" class="documento_registro_anexo"><?= $Page->renderFieldHeader($Page->anexo) ?></div></th>
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
    <?php if ($Page->iddocumento_registro->Visible) { // iddocumento_registro ?>
        <td data-name="iddocumento_registro"<?= $Page->iddocumento_registro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_registro_iddocumento_registro" class="el_documento_registro_iddocumento_registro">
<span<?= $Page->iddocumento_registro->viewAttributes() ?>>
<?= $Page->iddocumento_registro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_registro_dt_cadastro" class="el_documento_registro_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->titulo->Visible) { // titulo ?>
        <td data-name="titulo"<?= $Page->titulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_registro_titulo" class="el_documento_registro_titulo">
<span<?= $Page->titulo->viewAttributes() ?>>
<?= $Page->titulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
        <td data-name="categoria_documento_idcategoria_documento"<?= $Page->categoria_documento_idcategoria_documento->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_registro_categoria_documento_idcategoria_documento" class="el_documento_registro_categoria_documento_idcategoria_documento">
<span<?= $Page->categoria_documento_idcategoria_documento->viewAttributes() ?>>
<?= $Page->categoria_documento_idcategoria_documento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_registro_usuario_idusuario" class="el_documento_registro_usuario_idusuario">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->anexo->Visible) { // anexo ?>
        <td data-name="anexo"<?= $Page->anexo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_documento_registro_anexo" class="el_documento_registro_anexo">
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
    <?php if ($Page->iddocumento_registro->Visible) { // iddocumento_registro ?>
        <td data-name="iddocumento_registro" class="<?= $Page->iddocumento_registro->footerCellClass() ?>"><span id="elf_documento_registro_iddocumento_registro" class="documento_registro_iddocumento_registro">
        </span></td>
    <?php } ?>
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro" class="<?= $Page->dt_cadastro->footerCellClass() ?>"><span id="elf_documento_registro_dt_cadastro" class="documento_registro_dt_cadastro">
        </span></td>
    <?php } ?>
    <?php if ($Page->titulo->Visible) { // titulo ?>
        <td data-name="titulo" class="<?= $Page->titulo->footerCellClass() ?>"><span id="elf_documento_registro_titulo" class="documento_registro_titulo">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->titulo->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
        <td data-name="categoria_documento_idcategoria_documento" class="<?= $Page->categoria_documento_idcategoria_documento->footerCellClass() ?>"><span id="elf_documento_registro_categoria_documento_idcategoria_documento" class="documento_registro_categoria_documento_idcategoria_documento">
        </span></td>
    <?php } ?>
    <?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td data-name="usuario_idusuario" class="<?= $Page->usuario_idusuario->footerCellClass() ?>"><span id="elf_documento_registro_usuario_idusuario" class="documento_registro_usuario_idusuario">
        </span></td>
    <?php } ?>
    <?php if ($Page->anexo->Visible) { // anexo ?>
        <td data-name="anexo" class="<?= $Page->anexo->footerCellClass() ?>"><span id="elf_documento_registro_anexo" class="documento_registro_anexo">
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
    ew.addEventHandlers("documento_registro");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
