<?php

namespace PHPMaker2024\sgq;

// Page object
$GestaoMudancaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { gestao_mudanca: currentTable } });
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

        // Dynamic selection lists
        .setLists({
            "departamentos_iddepartamentos": <?= $Page->departamentos_iddepartamentos->toClientList($Page) ?>,
            "usuario_idusuario": <?= $Page->usuario_idusuario->toClientList($Page) ?>,
            "implementado": <?= $Page->implementado->toClientList($Page) ?>,
            "status": <?= $Page->status->toClientList($Page) ?>,
        })
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
<form name="fgestao_mudancasrch" id="fgestao_mudancasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fgestao_mudancasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { gestao_mudanca: currentTable } });
var currentForm;
var fgestao_mudancasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fgestao_mudancasrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["status", [], fields.status.isInvalid]
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
            "departamentos_iddepartamentos": <?= $Page->departamentos_iddepartamentos->toClientList($Page) ?>,
            "status": <?= $Page->status->toClientList($Page) ?>,
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
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
<?php
if (!$Page->departamentos_iddepartamentos->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_departamentos_iddepartamentos" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->departamentos_iddepartamentos->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_departamentos_iddepartamentos"
            name="x_departamentos_iddepartamentos[]"
            class="form-control ew-select<?= $Page->departamentos_iddepartamentos->isInvalidClass() ?>"
            data-select2-id="fgestao_mudancasrch_x_departamentos_iddepartamentos"
            data-table="gestao_mudanca"
            data-field="x_departamentos_iddepartamentos"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->departamentos_iddepartamentos->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->departamentos_iddepartamentos->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->departamentos_iddepartamentos->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->departamentos_iddepartamentos->editAttributes() ?>>
            <?= $Page->departamentos_iddepartamentos->selectOptionListHtml("x_departamentos_iddepartamentos", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->departamentos_iddepartamentos->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fgestao_mudancasrch", function() {
            var options = {
                name: "x_departamentos_iddepartamentos",
                selectId: "fgestao_mudancasrch_x_departamentos_iddepartamentos",
                ajax: { id: "x_departamentos_iddepartamentos", form: "fgestao_mudancasrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.gestao_mudanca.fields.departamentos_iddepartamentos.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
<?php
if (!$Page->status->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_status" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->status->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->status->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status" id="z_status" value="=">
</div>
        </div>
        <div id="el_gestao_mudanca_status" class="ew-search-field">
<template id="tp_x_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="gestao_mudanca" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_status"
    name="x_status"
    value="<?= HtmlEncode($Page->status->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_status"
    data-target="dsl_x_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status->isInvalidClass() ?>"
    data-table="gestao_mudanca"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage(false) ?></div>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fgestao_mudancasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fgestao_mudancasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fgestao_mudancasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fgestao_mudancasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="gestao_mudanca">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_gestao_mudanca" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_gestao_mudancalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->titulo->Visible) { // titulo ?>
        <th data-name="titulo" class="<?= $Page->titulo->headerCellClass() ?>"><div id="elh_gestao_mudanca_titulo" class="gestao_mudanca_titulo"><?= $Page->renderFieldHeader($Page->titulo) ?></div></th>
<?php } ?>
<?php if ($Page->detalhamento->Visible) { // detalhamento ?>
        <th data-name="detalhamento" class="<?= $Page->detalhamento->headerCellClass() ?>"><div id="elh_gestao_mudanca_detalhamento" class="gestao_mudanca_detalhamento"><?= $Page->renderFieldHeader($Page->detalhamento) ?></div></th>
<?php } ?>
<?php if ($Page->prazo_ate->Visible) { // prazo_ate ?>
        <th data-name="prazo_ate" class="<?= $Page->prazo_ate->headerCellClass() ?>"><div id="elh_gestao_mudanca_prazo_ate" class="gestao_mudanca_prazo_ate"><?= $Page->renderFieldHeader($Page->prazo_ate) ?></div></th>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <th data-name="departamentos_iddepartamentos" class="<?= $Page->departamentos_iddepartamentos->headerCellClass() ?>"><div id="elh_gestao_mudanca_departamentos_iddepartamentos" class="gestao_mudanca_departamentos_iddepartamentos"><?= $Page->renderFieldHeader($Page->departamentos_iddepartamentos) ?></div></th>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th data-name="usuario_idusuario" class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><div id="elh_gestao_mudanca_usuario_idusuario" class="gestao_mudanca_usuario_idusuario"><?= $Page->renderFieldHeader($Page->usuario_idusuario) ?></div></th>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
        <th data-name="implementado" class="<?= $Page->implementado->headerCellClass() ?>"><div id="elh_gestao_mudanca_implementado" class="gestao_mudanca_implementado"><?= $Page->renderFieldHeader($Page->implementado) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_gestao_mudanca_status" class="gestao_mudanca_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
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
    <?php if ($Page->titulo->Visible) { // titulo ?>
        <td data-name="titulo"<?= $Page->titulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_gestao_mudanca_titulo" class="el_gestao_mudanca_titulo">
<span<?= $Page->titulo->viewAttributes() ?>>
<?= $Page->titulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->detalhamento->Visible) { // detalhamento ?>
        <td data-name="detalhamento"<?= $Page->detalhamento->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_gestao_mudanca_detalhamento" class="el_gestao_mudanca_detalhamento">
<span<?= $Page->detalhamento->viewAttributes() ?>>
<?= $Page->detalhamento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->prazo_ate->Visible) { // prazo_ate ?>
        <td data-name="prazo_ate"<?= $Page->prazo_ate->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_gestao_mudanca_prazo_ate" class="el_gestao_mudanca_prazo_ate">
<span<?= $Page->prazo_ate->viewAttributes() ?>>
<?= $Page->prazo_ate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <td data-name="departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_gestao_mudanca_departamentos_iddepartamentos" class="el_gestao_mudanca_departamentos_iddepartamentos">
<span<?= $Page->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Page->departamentos_iddepartamentos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_gestao_mudanca_usuario_idusuario" class="el_gestao_mudanca_usuario_idusuario">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->implementado->Visible) { // implementado ?>
        <td data-name="implementado"<?= $Page->implementado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_gestao_mudanca_implementado" class="el_gestao_mudanca_implementado">
<span<?= $Page->implementado->viewAttributes() ?>>
<?= $Page->implementado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_gestao_mudanca_status" class="el_gestao_mudanca_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
    <?php if ($Page->titulo->Visible) { // titulo ?>
        <td data-name="titulo" class="<?= $Page->titulo->footerCellClass() ?>"><span id="elf_gestao_mudanca_titulo" class="gestao_mudanca_titulo">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->titulo->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->detalhamento->Visible) { // detalhamento ?>
        <td data-name="detalhamento" class="<?= $Page->detalhamento->footerCellClass() ?>"><span id="elf_gestao_mudanca_detalhamento" class="gestao_mudanca_detalhamento">
        </span></td>
    <?php } ?>
    <?php if ($Page->prazo_ate->Visible) { // prazo_ate ?>
        <td data-name="prazo_ate" class="<?= $Page->prazo_ate->footerCellClass() ?>"><span id="elf_gestao_mudanca_prazo_ate" class="gestao_mudanca_prazo_ate">
        </span></td>
    <?php } ?>
    <?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <td data-name="departamentos_iddepartamentos" class="<?= $Page->departamentos_iddepartamentos->footerCellClass() ?>"><span id="elf_gestao_mudanca_departamentos_iddepartamentos" class="gestao_mudanca_departamentos_iddepartamentos">
        </span></td>
    <?php } ?>
    <?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td data-name="usuario_idusuario" class="<?= $Page->usuario_idusuario->footerCellClass() ?>"><span id="elf_gestao_mudanca_usuario_idusuario" class="gestao_mudanca_usuario_idusuario">
        </span></td>
    <?php } ?>
    <?php if ($Page->implementado->Visible) { // implementado ?>
        <td data-name="implementado" class="<?= $Page->implementado->footerCellClass() ?>"><span id="elf_gestao_mudanca_implementado" class="gestao_mudanca_implementado">
        </span></td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status" class="<?= $Page->status->footerCellClass() ?>"><span id="elf_gestao_mudanca_status" class="gestao_mudanca_status">
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
    ew.addEventHandlers("gestao_mudanca");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
