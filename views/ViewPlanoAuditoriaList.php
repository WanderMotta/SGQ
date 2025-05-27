<?php

namespace PHPMaker2024\sgq;

// Page object
$ViewPlanoAuditoriaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_plano_auditoria: currentTable } });
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
            "processo": <?= $Page->processo->toClientList($Page) ?>,
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
<form name="fview_plano_auditoriasrch" id="fview_plano_auditoriasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_plano_auditoriasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_plano_auditoria: currentTable } });
var currentForm;
var fview_plano_auditoriasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_plano_auditoriasrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idplano_auditoria_int", [ew.Validators.integer], fields.idplano_auditoria_int.isInvalid]
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
            "processo": <?= $Page->processo->toClientList($Page) ?>,
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
<?php if ($Page->idplano_auditoria_int->Visible) { // idplano_auditoria_int ?>
<?php
if (!$Page->idplano_auditoria_int->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_idplano_auditoria_int" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->idplano_auditoria_int->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_idplano_auditoria_int" class="ew-search-caption ew-label"><?= $Page->idplano_auditoria_int->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idplano_auditoria_int" id="z_idplano_auditoria_int" value="=">
</div>
        </div>
        <div id="el_view_plano_auditoria_idplano_auditoria_int" class="ew-search-field">
<input type="<?= $Page->idplano_auditoria_int->getInputTextType() ?>" name="x_idplano_auditoria_int" id="x_idplano_auditoria_int" data-table="view_plano_auditoria" data-field="x_idplano_auditoria_int" value="<?= $Page->idplano_auditoria_int->EditValue ?>" placeholder="<?= HtmlEncode($Page->idplano_auditoria_int->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idplano_auditoria_int->formatPattern()) ?>"<?= $Page->idplano_auditoria_int->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idplano_auditoria_int->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->processo->Visible) { // processo ?>
<?php
if (!$Page->processo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_processo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->processo->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_processo"
            name="x_processo[]"
            class="form-control ew-select<?= $Page->processo->isInvalidClass() ?>"
            data-select2-id="fview_plano_auditoriasrch_x_processo"
            data-table="view_plano_auditoria"
            data-field="x_processo"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->processo->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->processo->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->processo->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->processo->editAttributes() ?>>
            <?= $Page->processo->selectOptionListHtml("x_processo", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->processo->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fview_plano_auditoriasrch", function() {
            var options = {
                name: "x_processo",
                selectId: "fview_plano_auditoriasrch_x_processo",
                ajax: { id: "x_processo", form: "fview_plano_auditoriasrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.view_plano_auditoria.fields.processo.filterOptions);
            ew.createFilter(options);
        });
        </script>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_plano_auditoriasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_plano_auditoriasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_plano_auditoriasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_plano_auditoriasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_plano_auditoria">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_plano_auditoria" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_plano_auditorialist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->idplano_auditoria_int->Visible) { // idplano_auditoria_int ?>
        <th data-name="idplano_auditoria_int" class="<?= $Page->idplano_auditoria_int->headerCellClass() ?>"><div id="elh_view_plano_auditoria_idplano_auditoria_int" class="view_plano_auditoria_idplano_auditoria_int"><?= $Page->renderFieldHeader($Page->idplano_auditoria_int) ?></div></th>
<?php } ?>
<?php if ($Page->audlider->Visible) { // aud lider ?>
        <th data-name="audlider" class="<?= $Page->audlider->headerCellClass() ?>"><div id="elh_view_plano_auditoria_audlider" class="view_plano_auditoria_audlider"><?= $Page->renderFieldHeader($Page->audlider) ?></div></th>
<?php } ?>
<?php if ($Page->criterio->Visible) { // criterio ?>
        <th data-name="criterio" class="<?= $Page->criterio->headerCellClass() ?>"><div id="elh_view_plano_auditoria_criterio" class="view_plano_auditoria_criterio"><?= $Page->renderFieldHeader($Page->criterio) ?></div></th>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
        <th data-name="data" class="<?= $Page->data->headerCellClass() ?>"><div id="elh_view_plano_auditoria_data" class="view_plano_auditoria_data"><?= $Page->renderFieldHeader($Page->data) ?></div></th>
<?php } ?>
<?php if ($Page->processo->Visible) { // processo ?>
        <th data-name="processo" class="<?= $Page->processo->headerCellClass() ?>"><div id="elh_view_plano_auditoria_processo" class="view_plano_auditoria_processo"><?= $Page->renderFieldHeader($Page->processo) ?></div></th>
<?php } ?>
<?php if ($Page->auditor->Visible) { // auditor ?>
        <th data-name="auditor" class="<?= $Page->auditor->headerCellClass() ?>"><div id="elh_view_plano_auditoria_auditor" class="view_plano_auditoria_auditor"><?= $Page->renderFieldHeader($Page->auditor) ?></div></th>
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
    <?php if ($Page->idplano_auditoria_int->Visible) { // idplano_auditoria_int ?>
        <td data-name="idplano_auditoria_int"<?= $Page->idplano_auditoria_int->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_plano_auditoria_idplano_auditoria_int" class="el_view_plano_auditoria_idplano_auditoria_int">
<span<?= $Page->idplano_auditoria_int->viewAttributes() ?>>
<?= $Page->idplano_auditoria_int->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->audlider->Visible) { // aud lider ?>
        <td data-name="audlider"<?= $Page->audlider->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_plano_auditoria_audlider" class="el_view_plano_auditoria_audlider">
<span<?= $Page->audlider->viewAttributes() ?>>
<?= $Page->audlider->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->criterio->Visible) { // criterio ?>
        <td data-name="criterio"<?= $Page->criterio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_plano_auditoria_criterio" class="el_view_plano_auditoria_criterio">
<span<?= $Page->criterio->viewAttributes() ?>>
<?= $Page->criterio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->data->Visible) { // data ?>
        <td data-name="data"<?= $Page->data->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_plano_auditoria_data" class="el_view_plano_auditoria_data">
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->processo->Visible) { // processo ?>
        <td data-name="processo"<?= $Page->processo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_plano_auditoria_processo" class="el_view_plano_auditoria_processo">
<span<?= $Page->processo->viewAttributes() ?>>
<?= $Page->processo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->auditor->Visible) { // auditor ?>
        <td data-name="auditor"<?= $Page->auditor->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_plano_auditoria_auditor" class="el_view_plano_auditoria_auditor">
<span<?= $Page->auditor->viewAttributes() ?>>
<?= $Page->auditor->getViewValue() ?></span>
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
    ew.addEventHandlers("view_plano_auditoria");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
