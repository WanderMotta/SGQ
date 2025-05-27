<?php

namespace PHPMaker2024\sgq;

// Set up and run Grid object
$Grid = Container("ProcessoIndicadoresGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fprocesso_indicadoresgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { processo_indicadores: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fprocesso_indicadoresgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["indicadores_idindicadores", [fields.indicadores_idindicadores.visible && fields.indicadores_idindicadores.required ? ew.Validators.required(fields.indicadores_idindicadores.caption) : null], fields.indicadores_idindicadores.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["indicadores_idindicadores",false]];
                if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
                    return false;
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
            "indicadores_idindicadores": <?= $Grid->indicadores_idindicadores->toClientList($Grid) ?>,
        })
        .build();
    window[form.id] = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<main class="list">
<div id="ew-header-options">
<?php $Grid->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Grid->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Grid->TableGridClass ?>">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="fprocesso_indicadoresgrid" class="ew-form ew-list-form">
<div id="gmp_processo_indicadores" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_processo_indicadoresgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = RowType::HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
        <th data-name="indicadores_idindicadores" class="<?= $Grid->indicadores_idindicadores->headerCellClass() ?>"><div id="elh_processo_indicadores_indicadores_idindicadores" class="processo_indicadores_indicadores_idindicadores"><?= $Grid->renderFieldHeader($Grid->indicadores_idindicadores) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Grid->getPageNumber() ?>">
<?php
$Grid->setupGrid();
while ($Grid->RecordCount < $Grid->StopRecord || $Grid->RowIndex === '$rowindex$') {
    if (
        $Grid->CurrentRow !== false &&
        $Grid->RowIndex !== '$rowindex$' &&
        (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy") &&
        (!(($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0))
    ) {
        $Grid->fetch();
    }
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Grid->RowAction != "delete" &&
            $Grid->RowAction != "insertdelete" &&
            !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow()) &&
            $Grid->RowAction != "hide"
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
        <td data-name="indicadores_idindicadores"<?= $Grid->indicadores_idindicadores->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_processo_indicadores_indicadores_idindicadores" class="el_processo_indicadores_indicadores_idindicadores">
    <select
        id="x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        name="x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        class="form-select ew-select<?= $Grid->indicadores_idindicadores->isInvalidClass() ?>"
        <?php if (!$Grid->indicadores_idindicadores->IsNativeSelect) { ?>
        data-select2-id="fprocesso_indicadoresgrid_x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        <?php } ?>
        data-table="processo_indicadores"
        data-field="x_indicadores_idindicadores"
        data-value-separator="<?= $Grid->indicadores_idindicadores->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->indicadores_idindicadores->getPlaceHolder()) ?>"
        <?= $Grid->indicadores_idindicadores->editAttributes() ?>>
        <?= $Grid->indicadores_idindicadores->selectOptionListHtml("x{$Grid->RowIndex}_indicadores_idindicadores") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->indicadores_idindicadores->getErrorMessage() ?></div>
<?= $Grid->indicadores_idindicadores->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_indicadores_idindicadores") ?>
<?php if (!$Grid->indicadores_idindicadores->IsNativeSelect) { ?>
<script>
loadjs.ready("fprocesso_indicadoresgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", selectId: "fprocesso_indicadoresgrid_x<?= $Grid->RowIndex ?>_indicadores_idindicadores" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fprocesso_indicadoresgrid.lists.indicadores_idindicadores?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", form: "fprocesso_indicadoresgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", form: "fprocesso_indicadoresgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.processo_indicadores.fields.indicadores_idindicadores.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="processo_indicadores" data-field="x_indicadores_idindicadores" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_indicadores_idindicadores" id="o<?= $Grid->RowIndex ?>_indicadores_idindicadores" value="<?= HtmlEncode($Grid->indicadores_idindicadores->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_processo_indicadores_indicadores_idindicadores" class="el_processo_indicadores_indicadores_idindicadores">
    <select
        id="x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        name="x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        class="form-select ew-select<?= $Grid->indicadores_idindicadores->isInvalidClass() ?>"
        <?php if (!$Grid->indicadores_idindicadores->IsNativeSelect) { ?>
        data-select2-id="fprocesso_indicadoresgrid_x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        <?php } ?>
        data-table="processo_indicadores"
        data-field="x_indicadores_idindicadores"
        data-value-separator="<?= $Grid->indicadores_idindicadores->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->indicadores_idindicadores->getPlaceHolder()) ?>"
        <?= $Grid->indicadores_idindicadores->editAttributes() ?>>
        <?= $Grid->indicadores_idindicadores->selectOptionListHtml("x{$Grid->RowIndex}_indicadores_idindicadores") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->indicadores_idindicadores->getErrorMessage() ?></div>
<?= $Grid->indicadores_idindicadores->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_indicadores_idindicadores") ?>
<?php if (!$Grid->indicadores_idindicadores->IsNativeSelect) { ?>
<script>
loadjs.ready("fprocesso_indicadoresgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", selectId: "fprocesso_indicadoresgrid_x<?= $Grid->RowIndex ?>_indicadores_idindicadores" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fprocesso_indicadoresgrid.lists.indicadores_idindicadores?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", form: "fprocesso_indicadoresgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", form: "fprocesso_indicadoresgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.processo_indicadores.fields.indicadores_idindicadores.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_processo_indicadores_indicadores_idindicadores" class="el_processo_indicadores_indicadores_idindicadores">
<span<?= $Grid->indicadores_idindicadores->viewAttributes() ?>>
<?= $Grid->indicadores_idindicadores->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="processo_indicadores" data-field="x_indicadores_idindicadores" data-hidden="1" name="fprocesso_indicadoresgrid$x<?= $Grid->RowIndex ?>_indicadores_idindicadores" id="fprocesso_indicadoresgrid$x<?= $Grid->RowIndex ?>_indicadores_idindicadores" value="<?= HtmlEncode($Grid->indicadores_idindicadores->FormValue) ?>">
<input type="hidden" data-table="processo_indicadores" data-field="x_indicadores_idindicadores" data-hidden="1" data-old name="fprocesso_indicadoresgrid$o<?= $Grid->RowIndex ?>_indicadores_idindicadores" id="fprocesso_indicadoresgrid$o<?= $Grid->RowIndex ?>_indicadores_idindicadores" value="<?= HtmlEncode($Grid->indicadores_idindicadores->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == RowType::ADD || $Grid->RowType == RowType::EDIT) { ?>
<script data-rowindex="<?= $Grid->RowIndex ?>">
loadjs.ready(["fprocesso_indicadoresgrid","load"], () => fprocesso_indicadoresgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

    // Reset for template row
    if ($Grid->RowIndex === '$rowindex$') {
        $Grid->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0) {
        $Grid->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fprocesso_indicadoresgrid">
</div><!-- /.ew-list-form -->
<?php
// Close result set
$Grid->Recordset?->free();
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Grid->FooterOptions?->render("body") ?>
</div>
</main>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("processo_indicadores");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
