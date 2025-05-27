<?php

namespace PHPMaker2024\sgq;

// Set up and run Grid object
$Grid = Container("GraficosGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fgraficosgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { graficos: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fgraficosgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["competencia_idcompetencia", [fields.competencia_idcompetencia.visible && fields.competencia_idcompetencia.required ? ew.Validators.required(fields.competencia_idcompetencia.caption) : null], fields.competencia_idcompetencia.isInvalid],
            ["indicadores_idindicadores", [fields.indicadores_idindicadores.visible && fields.indicadores_idindicadores.required ? ew.Validators.required(fields.indicadores_idindicadores.caption) : null], fields.indicadores_idindicadores.isInvalid],
            ["valor", [fields.valor.visible && fields.valor.required ? ew.Validators.required(fields.valor.caption) : null, ew.Validators.float], fields.valor.isInvalid],
            ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["competencia_idcompetencia",false],["indicadores_idindicadores",false],["valor",false],["obs",false]];
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
            "competencia_idcompetencia": <?= $Grid->competencia_idcompetencia->toClientList($Grid) ?>,
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
<div id="fgraficosgrid" class="ew-form ew-list-form">
<div id="gmp_graficos" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_graficosgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->competencia_idcompetencia->Visible) { // competencia_idcompetencia ?>
        <th data-name="competencia_idcompetencia" class="<?= $Grid->competencia_idcompetencia->headerCellClass() ?>"><div id="elh_graficos_competencia_idcompetencia" class="graficos_competencia_idcompetencia"><?= $Grid->renderFieldHeader($Grid->competencia_idcompetencia) ?></div></th>
<?php } ?>
<?php if ($Grid->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
        <th data-name="indicadores_idindicadores" class="<?= $Grid->indicadores_idindicadores->headerCellClass() ?>"><div id="elh_graficos_indicadores_idindicadores" class="graficos_indicadores_idindicadores"><?= $Grid->renderFieldHeader($Grid->indicadores_idindicadores) ?></div></th>
<?php } ?>
<?php if ($Grid->valor->Visible) { // valor ?>
        <th data-name="valor" class="<?= $Grid->valor->headerCellClass() ?>"><div id="elh_graficos_valor" class="graficos_valor"><?= $Grid->renderFieldHeader($Grid->valor) ?></div></th>
<?php } ?>
<?php if ($Grid->obs->Visible) { // obs ?>
        <th data-name="obs" class="<?= $Grid->obs->headerCellClass() ?>"><div id="elh_graficos_obs" class="graficos_obs"><?= $Grid->renderFieldHeader($Grid->obs) ?></div></th>
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
    <?php if ($Grid->competencia_idcompetencia->Visible) { // competencia_idcompetencia ?>
        <td data-name="competencia_idcompetencia"<?= $Grid->competencia_idcompetencia->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_competencia_idcompetencia" class="el_graficos_competencia_idcompetencia">
    <select
        id="x<?= $Grid->RowIndex ?>_competencia_idcompetencia"
        name="x<?= $Grid->RowIndex ?>_competencia_idcompetencia"
        class="form-select ew-select<?= $Grid->competencia_idcompetencia->isInvalidClass() ?>"
        <?php if (!$Grid->competencia_idcompetencia->IsNativeSelect) { ?>
        data-select2-id="fgraficosgrid_x<?= $Grid->RowIndex ?>_competencia_idcompetencia"
        <?php } ?>
        data-table="graficos"
        data-field="x_competencia_idcompetencia"
        data-value-separator="<?= $Grid->competencia_idcompetencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->competencia_idcompetencia->getPlaceHolder()) ?>"
        <?= $Grid->competencia_idcompetencia->editAttributes() ?>>
        <?= $Grid->competencia_idcompetencia->selectOptionListHtml("x{$Grid->RowIndex}_competencia_idcompetencia") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->competencia_idcompetencia->getErrorMessage() ?></div>
<?= $Grid->competencia_idcompetencia->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_competencia_idcompetencia") ?>
<?php if (!$Grid->competencia_idcompetencia->IsNativeSelect) { ?>
<script>
loadjs.ready("fgraficosgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_competencia_idcompetencia", selectId: "fgraficosgrid_x<?= $Grid->RowIndex ?>_competencia_idcompetencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fgraficosgrid.lists.competencia_idcompetencia?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_competencia_idcompetencia", form: "fgraficosgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_competencia_idcompetencia", form: "fgraficosgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.competencia_idcompetencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="graficos" data-field="x_competencia_idcompetencia" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_competencia_idcompetencia" id="o<?= $Grid->RowIndex ?>_competencia_idcompetencia" value="<?= HtmlEncode($Grid->competencia_idcompetencia->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_competencia_idcompetencia" class="el_graficos_competencia_idcompetencia">
    <select
        id="x<?= $Grid->RowIndex ?>_competencia_idcompetencia"
        name="x<?= $Grid->RowIndex ?>_competencia_idcompetencia"
        class="form-select ew-select<?= $Grid->competencia_idcompetencia->isInvalidClass() ?>"
        <?php if (!$Grid->competencia_idcompetencia->IsNativeSelect) { ?>
        data-select2-id="fgraficosgrid_x<?= $Grid->RowIndex ?>_competencia_idcompetencia"
        <?php } ?>
        data-table="graficos"
        data-field="x_competencia_idcompetencia"
        data-value-separator="<?= $Grid->competencia_idcompetencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->competencia_idcompetencia->getPlaceHolder()) ?>"
        <?= $Grid->competencia_idcompetencia->editAttributes() ?>>
        <?= $Grid->competencia_idcompetencia->selectOptionListHtml("x{$Grid->RowIndex}_competencia_idcompetencia") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->competencia_idcompetencia->getErrorMessage() ?></div>
<?= $Grid->competencia_idcompetencia->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_competencia_idcompetencia") ?>
<?php if (!$Grid->competencia_idcompetencia->IsNativeSelect) { ?>
<script>
loadjs.ready("fgraficosgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_competencia_idcompetencia", selectId: "fgraficosgrid_x<?= $Grid->RowIndex ?>_competencia_idcompetencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fgraficosgrid.lists.competencia_idcompetencia?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_competencia_idcompetencia", form: "fgraficosgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_competencia_idcompetencia", form: "fgraficosgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.competencia_idcompetencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_competencia_idcompetencia" class="el_graficos_competencia_idcompetencia">
<span<?= $Grid->competencia_idcompetencia->viewAttributes() ?>>
<?= $Grid->competencia_idcompetencia->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="graficos" data-field="x_competencia_idcompetencia" data-hidden="1" name="fgraficosgrid$x<?= $Grid->RowIndex ?>_competencia_idcompetencia" id="fgraficosgrid$x<?= $Grid->RowIndex ?>_competencia_idcompetencia" value="<?= HtmlEncode($Grid->competencia_idcompetencia->FormValue) ?>">
<input type="hidden" data-table="graficos" data-field="x_competencia_idcompetencia" data-hidden="1" data-old name="fgraficosgrid$o<?= $Grid->RowIndex ?>_competencia_idcompetencia" id="fgraficosgrid$o<?= $Grid->RowIndex ?>_competencia_idcompetencia" value="<?= HtmlEncode($Grid->competencia_idcompetencia->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
        <td data-name="indicadores_idindicadores"<?= $Grid->indicadores_idindicadores->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->indicadores_idindicadores->getSessionValue() != "") { ?>
<span<?= $Grid->indicadores_idindicadores->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->indicadores_idindicadores->getDisplayValue($Grid->indicadores_idindicadores->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_indicadores_idindicadores" name="x<?= $Grid->RowIndex ?>_indicadores_idindicadores" value="<?= HtmlEncode($Grid->indicadores_idindicadores->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_indicadores_idindicadores" class="el_graficos_indicadores_idindicadores">
    <select
        id="x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        name="x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        class="form-select ew-select<?= $Grid->indicadores_idindicadores->isInvalidClass() ?>"
        <?php if (!$Grid->indicadores_idindicadores->IsNativeSelect) { ?>
        data-select2-id="fgraficosgrid_x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        <?php } ?>
        data-table="graficos"
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
loadjs.ready("fgraficosgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", selectId: "fgraficosgrid_x<?= $Grid->RowIndex ?>_indicadores_idindicadores" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fgraficosgrid.lists.indicadores_idindicadores?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", form: "fgraficosgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", form: "fgraficosgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.indicadores_idindicadores.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<input type="hidden" data-table="graficos" data-field="x_indicadores_idindicadores" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_indicadores_idindicadores" id="o<?= $Grid->RowIndex ?>_indicadores_idindicadores" value="<?= HtmlEncode($Grid->indicadores_idindicadores->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->indicadores_idindicadores->getSessionValue() != "") { ?>
<span<?= $Grid->indicadores_idindicadores->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->indicadores_idindicadores->getDisplayValue($Grid->indicadores_idindicadores->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_indicadores_idindicadores" name="x<?= $Grid->RowIndex ?>_indicadores_idindicadores" value="<?= HtmlEncode($Grid->indicadores_idindicadores->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_indicadores_idindicadores" class="el_graficos_indicadores_idindicadores">
    <select
        id="x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        name="x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        class="form-select ew-select<?= $Grid->indicadores_idindicadores->isInvalidClass() ?>"
        <?php if (!$Grid->indicadores_idindicadores->IsNativeSelect) { ?>
        data-select2-id="fgraficosgrid_x<?= $Grid->RowIndex ?>_indicadores_idindicadores"
        <?php } ?>
        data-table="graficos"
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
loadjs.ready("fgraficosgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", selectId: "fgraficosgrid_x<?= $Grid->RowIndex ?>_indicadores_idindicadores" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fgraficosgrid.lists.indicadores_idindicadores?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", form: "fgraficosgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_indicadores_idindicadores", form: "fgraficosgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.indicadores_idindicadores.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_indicadores_idindicadores" class="el_graficos_indicadores_idindicadores">
<span<?= $Grid->indicadores_idindicadores->viewAttributes() ?>>
<?= $Grid->indicadores_idindicadores->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="graficos" data-field="x_indicadores_idindicadores" data-hidden="1" name="fgraficosgrid$x<?= $Grid->RowIndex ?>_indicadores_idindicadores" id="fgraficosgrid$x<?= $Grid->RowIndex ?>_indicadores_idindicadores" value="<?= HtmlEncode($Grid->indicadores_idindicadores->FormValue) ?>">
<input type="hidden" data-table="graficos" data-field="x_indicadores_idindicadores" data-hidden="1" data-old name="fgraficosgrid$o<?= $Grid->RowIndex ?>_indicadores_idindicadores" id="fgraficosgrid$o<?= $Grid->RowIndex ?>_indicadores_idindicadores" value="<?= HtmlEncode($Grid->indicadores_idindicadores->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->valor->Visible) { // valor ?>
        <td data-name="valor"<?= $Grid->valor->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_valor" class="el_graficos_valor">
<input type="<?= $Grid->valor->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_valor" id="x<?= $Grid->RowIndex ?>_valor" data-table="graficos" data-field="x_valor" value="<?= $Grid->valor->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->valor->formatPattern()) ?>"<?= $Grid->valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->valor->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="graficos" data-field="x_valor" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_valor" id="o<?= $Grid->RowIndex ?>_valor" value="<?= HtmlEncode($Grid->valor->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_valor" class="el_graficos_valor">
<input type="<?= $Grid->valor->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_valor" id="x<?= $Grid->RowIndex ?>_valor" data-table="graficos" data-field="x_valor" value="<?= $Grid->valor->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->valor->formatPattern()) ?>"<?= $Grid->valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->valor->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_valor" class="el_graficos_valor">
<span<?= $Grid->valor->viewAttributes() ?>>
<?= $Grid->valor->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="graficos" data-field="x_valor" data-hidden="1" name="fgraficosgrid$x<?= $Grid->RowIndex ?>_valor" id="fgraficosgrid$x<?= $Grid->RowIndex ?>_valor" value="<?= HtmlEncode($Grid->valor->FormValue) ?>">
<input type="hidden" data-table="graficos" data-field="x_valor" data-hidden="1" data-old name="fgraficosgrid$o<?= $Grid->RowIndex ?>_valor" id="fgraficosgrid$o<?= $Grid->RowIndex ?>_valor" value="<?= HtmlEncode($Grid->valor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->obs->Visible) { // obs ?>
        <td data-name="obs"<?= $Grid->obs->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_obs" class="el_graficos_obs">
<input type="<?= $Grid->obs->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_obs" id="x<?= $Grid->RowIndex ?>_obs" data-table="graficos" data-field="x_obs" value="<?= $Grid->obs->EditValue ?>" size="25" maxlength="100" placeholder="<?= HtmlEncode($Grid->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->obs->formatPattern()) ?>"<?= $Grid->obs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->obs->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="graficos" data-field="x_obs" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_obs" id="o<?= $Grid->RowIndex ?>_obs" value="<?= HtmlEncode($Grid->obs->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_obs" class="el_graficos_obs">
<input type="<?= $Grid->obs->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_obs" id="x<?= $Grid->RowIndex ?>_obs" data-table="graficos" data-field="x_obs" value="<?= $Grid->obs->EditValue ?>" size="25" maxlength="100" placeholder="<?= HtmlEncode($Grid->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->obs->formatPattern()) ?>"<?= $Grid->obs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->obs->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_graficos_obs" class="el_graficos_obs">
<span<?= $Grid->obs->viewAttributes() ?>>
<?= $Grid->obs->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="graficos" data-field="x_obs" data-hidden="1" name="fgraficosgrid$x<?= $Grid->RowIndex ?>_obs" id="fgraficosgrid$x<?= $Grid->RowIndex ?>_obs" value="<?= HtmlEncode($Grid->obs->FormValue) ?>">
<input type="hidden" data-table="graficos" data-field="x_obs" data-hidden="1" data-old name="fgraficosgrid$o<?= $Grid->RowIndex ?>_obs" id="fgraficosgrid$o<?= $Grid->RowIndex ?>_obs" value="<?= HtmlEncode($Grid->obs->OldValue) ?>">
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
loadjs.ready(["fgraficosgrid","load"], () => fgraficosgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fgraficosgrid">
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
    ew.addEventHandlers("graficos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
