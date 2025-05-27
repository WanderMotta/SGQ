<?php

namespace PHPMaker2024\sgq;

// Set up and run Grid object
$Grid = Container("AnaliseSwotGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fanalise_swotgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { analise_swot: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fanalise_swotgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["fatores", [fields.fatores.visible && fields.fatores.required ? ew.Validators.required(fields.fatores.caption) : null], fields.fatores.isInvalid],
            ["ponto", [fields.ponto.visible && fields.ponto.required ? ew.Validators.required(fields.ponto.caption) : null], fields.ponto.isInvalid],
            ["analise", [fields.analise.visible && fields.analise.required ? ew.Validators.required(fields.analise.caption) : null], fields.analise.isInvalid],
            ["impacto_idimpacto", [fields.impacto_idimpacto.visible && fields.impacto_idimpacto.required ? ew.Validators.required(fields.impacto_idimpacto.caption) : null], fields.impacto_idimpacto.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["fatores",false],["ponto",false],["analise",false],["impacto_idimpacto",false]];
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
            "fatores": <?= $Grid->fatores->toClientList($Grid) ?>,
            "ponto": <?= $Grid->ponto->toClientList($Grid) ?>,
            "impacto_idimpacto": <?= $Grid->impacto_idimpacto->toClientList($Grid) ?>,
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
<div id="fanalise_swotgrid" class="ew-form ew-list-form">
<div id="gmp_analise_swot" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_analise_swotgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->fatores->Visible) { // fatores ?>
        <th data-name="fatores" class="<?= $Grid->fatores->headerCellClass() ?>"><div id="elh_analise_swot_fatores" class="analise_swot_fatores"><?= $Grid->renderFieldHeader($Grid->fatores) ?></div></th>
<?php } ?>
<?php if ($Grid->ponto->Visible) { // ponto ?>
        <th data-name="ponto" class="<?= $Grid->ponto->headerCellClass() ?>"><div id="elh_analise_swot_ponto" class="analise_swot_ponto"><?= $Grid->renderFieldHeader($Grid->ponto) ?></div></th>
<?php } ?>
<?php if ($Grid->analise->Visible) { // analise ?>
        <th data-name="analise" class="<?= $Grid->analise->headerCellClass() ?>"><div id="elh_analise_swot_analise" class="analise_swot_analise"><?= $Grid->renderFieldHeader($Grid->analise) ?></div></th>
<?php } ?>
<?php if ($Grid->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <th data-name="impacto_idimpacto" class="<?= $Grid->impacto_idimpacto->headerCellClass() ?>"><div id="elh_analise_swot_impacto_idimpacto" class="analise_swot_impacto_idimpacto"><?= $Grid->renderFieldHeader($Grid->impacto_idimpacto) ?></div></th>
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
    <?php if ($Grid->fatores->Visible) { // fatores ?>
        <td data-name="fatores"<?= $Grid->fatores->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_fatores" class="el_analise_swot_fatores">
<template id="tp_x<?= $Grid->RowIndex ?>_fatores">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_fatores" name="x<?= $Grid->RowIndex ?>_fatores" id="x<?= $Grid->RowIndex ?>_fatores"<?= $Grid->fatores->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_fatores" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_fatores"
    name="x<?= $Grid->RowIndex ?>_fatores"
    value="<?= HtmlEncode($Grid->fatores->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_fatores"
    data-target="dsl_x<?= $Grid->RowIndex ?>_fatores"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->fatores->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_fatores"
    data-value-separator="<?= $Grid->fatores->displayValueSeparatorAttribute() ?>"
    <?= $Grid->fatores->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->fatores->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="analise_swot" data-field="x_fatores" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fatores" id="o<?= $Grid->RowIndex ?>_fatores" value="<?= HtmlEncode($Grid->fatores->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_fatores" class="el_analise_swot_fatores">
<template id="tp_x<?= $Grid->RowIndex ?>_fatores">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_fatores" name="x<?= $Grid->RowIndex ?>_fatores" id="x<?= $Grid->RowIndex ?>_fatores"<?= $Grid->fatores->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_fatores" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_fatores"
    name="x<?= $Grid->RowIndex ?>_fatores"
    value="<?= HtmlEncode($Grid->fatores->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_fatores"
    data-target="dsl_x<?= $Grid->RowIndex ?>_fatores"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->fatores->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_fatores"
    data-value-separator="<?= $Grid->fatores->displayValueSeparatorAttribute() ?>"
    <?= $Grid->fatores->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->fatores->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_fatores" class="el_analise_swot_fatores">
<span<?= $Grid->fatores->viewAttributes() ?>>
<?= $Grid->fatores->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="analise_swot" data-field="x_fatores" data-hidden="1" name="fanalise_swotgrid$x<?= $Grid->RowIndex ?>_fatores" id="fanalise_swotgrid$x<?= $Grid->RowIndex ?>_fatores" value="<?= HtmlEncode($Grid->fatores->FormValue) ?>">
<input type="hidden" data-table="analise_swot" data-field="x_fatores" data-hidden="1" data-old name="fanalise_swotgrid$o<?= $Grid->RowIndex ?>_fatores" id="fanalise_swotgrid$o<?= $Grid->RowIndex ?>_fatores" value="<?= HtmlEncode($Grid->fatores->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ponto->Visible) { // ponto ?>
        <td data-name="ponto"<?= $Grid->ponto->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_ponto" class="el_analise_swot_ponto">
<template id="tp_x<?= $Grid->RowIndex ?>_ponto">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_ponto" name="x<?= $Grid->RowIndex ?>_ponto" id="x<?= $Grid->RowIndex ?>_ponto"<?= $Grid->ponto->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ponto" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_ponto"
    name="x<?= $Grid->RowIndex ?>_ponto"
    value="<?= HtmlEncode($Grid->ponto->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_ponto"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ponto"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ponto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_ponto"
    data-value-separator="<?= $Grid->ponto->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ponto->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->ponto->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="analise_swot" data-field="x_ponto" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ponto" id="o<?= $Grid->RowIndex ?>_ponto" value="<?= HtmlEncode($Grid->ponto->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_ponto" class="el_analise_swot_ponto">
<template id="tp_x<?= $Grid->RowIndex ?>_ponto">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_ponto" name="x<?= $Grid->RowIndex ?>_ponto" id="x<?= $Grid->RowIndex ?>_ponto"<?= $Grid->ponto->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ponto" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_ponto"
    name="x<?= $Grid->RowIndex ?>_ponto"
    value="<?= HtmlEncode($Grid->ponto->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_ponto"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ponto"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ponto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_ponto"
    data-value-separator="<?= $Grid->ponto->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ponto->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->ponto->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_ponto" class="el_analise_swot_ponto">
<span<?= $Grid->ponto->viewAttributes() ?>>
<?= $Grid->ponto->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="analise_swot" data-field="x_ponto" data-hidden="1" name="fanalise_swotgrid$x<?= $Grid->RowIndex ?>_ponto" id="fanalise_swotgrid$x<?= $Grid->RowIndex ?>_ponto" value="<?= HtmlEncode($Grid->ponto->FormValue) ?>">
<input type="hidden" data-table="analise_swot" data-field="x_ponto" data-hidden="1" data-old name="fanalise_swotgrid$o<?= $Grid->RowIndex ?>_ponto" id="fanalise_swotgrid$o<?= $Grid->RowIndex ?>_ponto" value="<?= HtmlEncode($Grid->ponto->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->analise->Visible) { // analise ?>
        <td data-name="analise"<?= $Grid->analise->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_analise" class="el_analise_swot_analise">
<textarea data-table="analise_swot" data-field="x_analise" name="x<?= $Grid->RowIndex ?>_analise" id="x<?= $Grid->RowIndex ?>_analise" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->analise->getPlaceHolder()) ?>"<?= $Grid->analise->editAttributes() ?>><?= $Grid->analise->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->analise->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="analise_swot" data-field="x_analise" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_analise" id="o<?= $Grid->RowIndex ?>_analise" value="<?= HtmlEncode($Grid->analise->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_analise" class="el_analise_swot_analise">
<textarea data-table="analise_swot" data-field="x_analise" name="x<?= $Grid->RowIndex ?>_analise" id="x<?= $Grid->RowIndex ?>_analise" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->analise->getPlaceHolder()) ?>"<?= $Grid->analise->editAttributes() ?>><?= $Grid->analise->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->analise->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_analise" class="el_analise_swot_analise">
<span<?= $Grid->analise->viewAttributes() ?>>
<?= $Grid->analise->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="analise_swot" data-field="x_analise" data-hidden="1" name="fanalise_swotgrid$x<?= $Grid->RowIndex ?>_analise" id="fanalise_swotgrid$x<?= $Grid->RowIndex ?>_analise" value="<?= HtmlEncode($Grid->analise->FormValue) ?>">
<input type="hidden" data-table="analise_swot" data-field="x_analise" data-hidden="1" data-old name="fanalise_swotgrid$o<?= $Grid->RowIndex ?>_analise" id="fanalise_swotgrid$o<?= $Grid->RowIndex ?>_analise" value="<?= HtmlEncode($Grid->analise->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <td data-name="impacto_idimpacto"<?= $Grid->impacto_idimpacto->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_impacto_idimpacto" class="el_analise_swot_impacto_idimpacto">
<template id="tp_x<?= $Grid->RowIndex ?>_impacto_idimpacto">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_impacto_idimpacto" name="x<?= $Grid->RowIndex ?>_impacto_idimpacto" id="x<?= $Grid->RowIndex ?>_impacto_idimpacto"<?= $Grid->impacto_idimpacto->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_impacto_idimpacto" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_impacto_idimpacto"
    name="x<?= $Grid->RowIndex ?>_impacto_idimpacto"
    value="<?= HtmlEncode($Grid->impacto_idimpacto->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_impacto_idimpacto"
    data-target="dsl_x<?= $Grid->RowIndex ?>_impacto_idimpacto"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->impacto_idimpacto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_impacto_idimpacto"
    data-value-separator="<?= $Grid->impacto_idimpacto->displayValueSeparatorAttribute() ?>"
    <?= $Grid->impacto_idimpacto->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->impacto_idimpacto->getErrorMessage() ?></div>
<?= $Grid->impacto_idimpacto->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_impacto_idimpacto") ?>
</span>
<input type="hidden" data-table="analise_swot" data-field="x_impacto_idimpacto" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_impacto_idimpacto" id="o<?= $Grid->RowIndex ?>_impacto_idimpacto" value="<?= HtmlEncode($Grid->impacto_idimpacto->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_impacto_idimpacto" class="el_analise_swot_impacto_idimpacto">
<template id="tp_x<?= $Grid->RowIndex ?>_impacto_idimpacto">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_impacto_idimpacto" name="x<?= $Grid->RowIndex ?>_impacto_idimpacto" id="x<?= $Grid->RowIndex ?>_impacto_idimpacto"<?= $Grid->impacto_idimpacto->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_impacto_idimpacto" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_impacto_idimpacto"
    name="x<?= $Grid->RowIndex ?>_impacto_idimpacto"
    value="<?= HtmlEncode($Grid->impacto_idimpacto->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_impacto_idimpacto"
    data-target="dsl_x<?= $Grid->RowIndex ?>_impacto_idimpacto"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->impacto_idimpacto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_impacto_idimpacto"
    data-value-separator="<?= $Grid->impacto_idimpacto->displayValueSeparatorAttribute() ?>"
    <?= $Grid->impacto_idimpacto->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->impacto_idimpacto->getErrorMessage() ?></div>
<?= $Grid->impacto_idimpacto->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_impacto_idimpacto") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_analise_swot_impacto_idimpacto" class="el_analise_swot_impacto_idimpacto">
<span<?= $Grid->impacto_idimpacto->viewAttributes() ?>>
<?= $Grid->impacto_idimpacto->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="analise_swot" data-field="x_impacto_idimpacto" data-hidden="1" name="fanalise_swotgrid$x<?= $Grid->RowIndex ?>_impacto_idimpacto" id="fanalise_swotgrid$x<?= $Grid->RowIndex ?>_impacto_idimpacto" value="<?= HtmlEncode($Grid->impacto_idimpacto->FormValue) ?>">
<input type="hidden" data-table="analise_swot" data-field="x_impacto_idimpacto" data-hidden="1" data-old name="fanalise_swotgrid$o<?= $Grid->RowIndex ?>_impacto_idimpacto" id="fanalise_swotgrid$o<?= $Grid->RowIndex ?>_impacto_idimpacto" value="<?= HtmlEncode($Grid->impacto_idimpacto->OldValue) ?>">
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
loadjs.ready(["fanalise_swotgrid","load"], () => fanalise_swotgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<?php
// Render aggregate row
$Grid->RowType = RowType::AGGREGATE;
$Grid->resetAttributes();
$Grid->renderRow();
?>
<?php if ($Grid->TotalRecords > 0 && $Grid->CurrentMode == "view") { ?>
<tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options
$Grid->renderListOptions();

// Render list options (footer, left)
$Grid->ListOptions->render("footer", "left");
?>
    <?php if ($Grid->fatores->Visible) { // fatores ?>
        <td data-name="fatores" class="<?= $Grid->fatores->footerCellClass() ?>"><span id="elf_analise_swot_fatores" class="analise_swot_fatores">
        </span></td>
    <?php } ?>
    <?php if ($Grid->ponto->Visible) { // ponto ?>
        <td data-name="ponto" class="<?= $Grid->ponto->footerCellClass() ?>"><span id="elf_analise_swot_ponto" class="analise_swot_ponto">
        </span></td>
    <?php } ?>
    <?php if ($Grid->analise->Visible) { // analise ?>
        <td data-name="analise" class="<?= $Grid->analise->footerCellClass() ?>"><span id="elf_analise_swot_analise" class="analise_swot_analise">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Grid->analise->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <td data-name="impacto_idimpacto" class="<?= $Grid->impacto_idimpacto->footerCellClass() ?>"><span id="elf_analise_swot_impacto_idimpacto" class="analise_swot_impacto_idimpacto">
        </span></td>
    <?php } ?>
<?php
// Render list options (footer, right)
$Grid->ListOptions->render("footer", "right");
?>
    </tr>
</tfoot>
<?php } ?>
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
<input type="hidden" name="detailpage" value="fanalise_swotgrid">
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
    ew.addEventHandlers("analise_swot");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
