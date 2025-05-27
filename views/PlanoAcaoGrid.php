<?php

namespace PHPMaker2024\sgq;

// Set up and run Grid object
$Grid = Container("PlanoAcaoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fplano_acaogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { plano_acao: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplano_acaogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["risco_oportunidade_idrisco_oportunidade", [fields.risco_oportunidade_idrisco_oportunidade.visible && fields.risco_oportunidade_idrisco_oportunidade.required ? ew.Validators.required(fields.risco_oportunidade_idrisco_oportunidade.caption) : null], fields.risco_oportunidade_idrisco_oportunidade.isInvalid],
            ["o_q_sera_feito", [fields.o_q_sera_feito.visible && fields.o_q_sera_feito.required ? ew.Validators.required(fields.o_q_sera_feito.caption) : null], fields.o_q_sera_feito.isInvalid],
            ["efeito_esperado", [fields.efeito_esperado.visible && fields.efeito_esperado.required ? ew.Validators.required(fields.efeito_esperado.caption) : null], fields.efeito_esperado.isInvalid],
            ["departamentos_iddepartamentos", [fields.departamentos_iddepartamentos.visible && fields.departamentos_iddepartamentos.required ? ew.Validators.required(fields.departamentos_iddepartamentos.caption) : null], fields.departamentos_iddepartamentos.isInvalid],
            ["origem_risco_oportunidade_idorigem_risco_oportunidade", [fields.origem_risco_oportunidade_idorigem_risco_oportunidade.visible && fields.origem_risco_oportunidade_idorigem_risco_oportunidade.required ? ew.Validators.required(fields.origem_risco_oportunidade_idorigem_risco_oportunidade.caption) : null], fields.origem_risco_oportunidade_idorigem_risco_oportunidade.isInvalid],
            ["recursos_nec", [fields.recursos_nec.visible && fields.recursos_nec.required ? ew.Validators.required(fields.recursos_nec.caption) : null, ew.Validators.float], fields.recursos_nec.isInvalid],
            ["dt_limite", [fields.dt_limite.visible && fields.dt_limite.required ? ew.Validators.required(fields.dt_limite.caption) : null, ew.Validators.datetime(fields.dt_limite.clientFormatPattern)], fields.dt_limite.isInvalid],
            ["implementado", [fields.implementado.visible && fields.implementado.required ? ew.Validators.required(fields.implementado.caption) : null], fields.implementado.isInvalid],
            ["periodicidade_idperiodicidade", [fields.periodicidade_idperiodicidade.visible && fields.periodicidade_idperiodicidade.required ? ew.Validators.required(fields.periodicidade_idperiodicidade.caption) : null], fields.periodicidade_idperiodicidade.isInvalid],
            ["eficaz", [fields.eficaz.visible && fields.eficaz.required ? ew.Validators.required(fields.eficaz.caption) : null], fields.eficaz.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["risco_oportunidade_idrisco_oportunidade",false],["o_q_sera_feito",false],["efeito_esperado",false],["departamentos_iddepartamentos",false],["origem_risco_oportunidade_idorigem_risco_oportunidade",false],["recursos_nec",false],["dt_limite",false],["implementado",false],["periodicidade_idperiodicidade",false],["eficaz",false]];
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
            "risco_oportunidade_idrisco_oportunidade": <?= $Grid->risco_oportunidade_idrisco_oportunidade->toClientList($Grid) ?>,
            "departamentos_iddepartamentos": <?= $Grid->departamentos_iddepartamentos->toClientList($Grid) ?>,
            "origem_risco_oportunidade_idorigem_risco_oportunidade": <?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->toClientList($Grid) ?>,
            "implementado": <?= $Grid->implementado->toClientList($Grid) ?>,
            "periodicidade_idperiodicidade": <?= $Grid->periodicidade_idperiodicidade->toClientList($Grid) ?>,
            "eficaz": <?= $Grid->eficaz->toClientList($Grid) ?>,
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
<div id="fplano_acaogrid" class="ew-form ew-list-form">
<div id="gmp_plano_acao" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_plano_acaogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
        <th data-name="risco_oportunidade_idrisco_oportunidade" class="<?= $Grid->risco_oportunidade_idrisco_oportunidade->headerCellClass() ?>"><div id="elh_plano_acao_risco_oportunidade_idrisco_oportunidade" class="plano_acao_risco_oportunidade_idrisco_oportunidade"><?= $Grid->renderFieldHeader($Grid->risco_oportunidade_idrisco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Grid->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <th data-name="o_q_sera_feito" class="<?= $Grid->o_q_sera_feito->headerCellClass() ?>"><div id="elh_plano_acao_o_q_sera_feito" class="plano_acao_o_q_sera_feito"><?= $Grid->renderFieldHeader($Grid->o_q_sera_feito) ?></div></th>
<?php } ?>
<?php if ($Grid->efeito_esperado->Visible) { // efeito_esperado ?>
        <th data-name="efeito_esperado" class="<?= $Grid->efeito_esperado->headerCellClass() ?>"><div id="elh_plano_acao_efeito_esperado" class="plano_acao_efeito_esperado"><?= $Grid->renderFieldHeader($Grid->efeito_esperado) ?></div></th>
<?php } ?>
<?php if ($Grid->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <th data-name="departamentos_iddepartamentos" class="<?= $Grid->departamentos_iddepartamentos->headerCellClass() ?>"><div id="elh_plano_acao_departamentos_iddepartamentos" class="plano_acao_departamentos_iddepartamentos"><?= $Grid->renderFieldHeader($Grid->departamentos_iddepartamentos) ?></div></th>
<?php } ?>
<?php if ($Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <th data-name="origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->headerCellClass() ?>"><div id="elh_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade" class="plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Grid->renderFieldHeader($Grid->origem_risco_oportunidade_idorigem_risco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Grid->recursos_nec->Visible) { // recursos_nec ?>
        <th data-name="recursos_nec" class="<?= $Grid->recursos_nec->headerCellClass() ?>"><div id="elh_plano_acao_recursos_nec" class="plano_acao_recursos_nec"><?= $Grid->renderFieldHeader($Grid->recursos_nec) ?></div></th>
<?php } ?>
<?php if ($Grid->dt_limite->Visible) { // dt_limite ?>
        <th data-name="dt_limite" class="<?= $Grid->dt_limite->headerCellClass() ?>"><div id="elh_plano_acao_dt_limite" class="plano_acao_dt_limite"><?= $Grid->renderFieldHeader($Grid->dt_limite) ?></div></th>
<?php } ?>
<?php if ($Grid->implementado->Visible) { // implementado ?>
        <th data-name="implementado" class="<?= $Grid->implementado->headerCellClass() ?>"><div id="elh_plano_acao_implementado" class="plano_acao_implementado"><?= $Grid->renderFieldHeader($Grid->implementado) ?></div></th>
<?php } ?>
<?php if ($Grid->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <th data-name="periodicidade_idperiodicidade" class="<?= $Grid->periodicidade_idperiodicidade->headerCellClass() ?>"><div id="elh_plano_acao_periodicidade_idperiodicidade" class="plano_acao_periodicidade_idperiodicidade"><?= $Grid->renderFieldHeader($Grid->periodicidade_idperiodicidade) ?></div></th>
<?php } ?>
<?php if ($Grid->eficaz->Visible) { // eficaz ?>
        <th data-name="eficaz" class="<?= $Grid->eficaz->headerCellClass() ?>"><div id="elh_plano_acao_eficaz" class="plano_acao_eficaz"><?= $Grid->renderFieldHeader($Grid->eficaz) ?></div></th>
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
    <?php if ($Grid->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
        <td data-name="risco_oportunidade_idrisco_oportunidade"<?= $Grid->risco_oportunidade_idrisco_oportunidade->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->risco_oportunidade_idrisco_oportunidade->getSessionValue() != "") { ?>
<span<?= $Grid->risco_oportunidade_idrisco_oportunidade->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->risco_oportunidade_idrisco_oportunidade->getDisplayValue($Grid->risco_oportunidade_idrisco_oportunidade->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" name="x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" value="<?= HtmlEncode($Grid->risco_oportunidade_idrisco_oportunidade->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_risco_oportunidade_idrisco_oportunidade" class="el_plano_acao_risco_oportunidade_idrisco_oportunidade">
    <select
        id="x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade"
        name="x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade"
        class="form-select ew-select<?= $Grid->risco_oportunidade_idrisco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Grid->risco_oportunidade_idrisco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="fplano_acaogrid_x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade"
        <?php } ?>
        data-table="plano_acao"
        data-field="x_risco_oportunidade_idrisco_oportunidade"
        data-value-separator="<?= $Grid->risco_oportunidade_idrisco_oportunidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->risco_oportunidade_idrisco_oportunidade->getPlaceHolder()) ?>"
        <?= $Grid->risco_oportunidade_idrisco_oportunidade->editAttributes() ?>>
        <?= $Grid->risco_oportunidade_idrisco_oportunidade->selectOptionListHtml("x{$Grid->RowIndex}_risco_oportunidade_idrisco_oportunidade") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->risco_oportunidade_idrisco_oportunidade->getErrorMessage() ?></div>
<?= $Grid->risco_oportunidade_idrisco_oportunidade->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_risco_oportunidade_idrisco_oportunidade") ?>
<?php if (!$Grid->risco_oportunidade_idrisco_oportunidade->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acaogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade", selectId: "fplano_acaogrid_x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaogrid.lists.risco_oportunidade_idrisco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade", form: "fplano_acaogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade", form: "fplano_acaogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.risco_oportunidade_idrisco_oportunidade.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<input type="hidden" data-table="plano_acao" data-field="x_risco_oportunidade_idrisco_oportunidade" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" id="o<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" value="<?= HtmlEncode($Grid->risco_oportunidade_idrisco_oportunidade->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->risco_oportunidade_idrisco_oportunidade->getSessionValue() != "") { ?>
<span<?= $Grid->risco_oportunidade_idrisco_oportunidade->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->risco_oportunidade_idrisco_oportunidade->getDisplayValue($Grid->risco_oportunidade_idrisco_oportunidade->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" name="x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" value="<?= HtmlEncode($Grid->risco_oportunidade_idrisco_oportunidade->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_risco_oportunidade_idrisco_oportunidade" class="el_plano_acao_risco_oportunidade_idrisco_oportunidade">
    <select
        id="x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade"
        name="x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade"
        class="form-select ew-select<?= $Grid->risco_oportunidade_idrisco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Grid->risco_oportunidade_idrisco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="fplano_acaogrid_x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade"
        <?php } ?>
        data-table="plano_acao"
        data-field="x_risco_oportunidade_idrisco_oportunidade"
        data-value-separator="<?= $Grid->risco_oportunidade_idrisco_oportunidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->risco_oportunidade_idrisco_oportunidade->getPlaceHolder()) ?>"
        <?= $Grid->risco_oportunidade_idrisco_oportunidade->editAttributes() ?>>
        <?= $Grid->risco_oportunidade_idrisco_oportunidade->selectOptionListHtml("x{$Grid->RowIndex}_risco_oportunidade_idrisco_oportunidade") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->risco_oportunidade_idrisco_oportunidade->getErrorMessage() ?></div>
<?= $Grid->risco_oportunidade_idrisco_oportunidade->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_risco_oportunidade_idrisco_oportunidade") ?>
<?php if (!$Grid->risco_oportunidade_idrisco_oportunidade->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acaogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade", selectId: "fplano_acaogrid_x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaogrid.lists.risco_oportunidade_idrisco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade", form: "fplano_acaogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade", form: "fplano_acaogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.risco_oportunidade_idrisco_oportunidade.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_risco_oportunidade_idrisco_oportunidade" class="el_plano_acao_risco_oportunidade_idrisco_oportunidade">
<span<?= $Grid->risco_oportunidade_idrisco_oportunidade->viewAttributes() ?>>
<?= $Grid->risco_oportunidade_idrisco_oportunidade->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao" data-field="x_risco_oportunidade_idrisco_oportunidade" data-hidden="1" name="fplano_acaogrid$x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" id="fplano_acaogrid$x<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" value="<?= HtmlEncode($Grid->risco_oportunidade_idrisco_oportunidade->FormValue) ?>">
<input type="hidden" data-table="plano_acao" data-field="x_risco_oportunidade_idrisco_oportunidade" data-hidden="1" data-old name="fplano_acaogrid$o<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" id="fplano_acaogrid$o<?= $Grid->RowIndex ?>_risco_oportunidade_idrisco_oportunidade" value="<?= HtmlEncode($Grid->risco_oportunidade_idrisco_oportunidade->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <td data-name="o_q_sera_feito"<?= $Grid->o_q_sera_feito->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_o_q_sera_feito" class="el_plano_acao_o_q_sera_feito">
<textarea data-table="plano_acao" data-field="x_o_q_sera_feito" name="x<?= $Grid->RowIndex ?>_o_q_sera_feito" id="x<?= $Grid->RowIndex ?>_o_q_sera_feito" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->o_q_sera_feito->getPlaceHolder()) ?>"<?= $Grid->o_q_sera_feito->editAttributes() ?>><?= $Grid->o_q_sera_feito->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->o_q_sera_feito->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="plano_acao" data-field="x_o_q_sera_feito" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_o_q_sera_feito" id="o<?= $Grid->RowIndex ?>_o_q_sera_feito" value="<?= HtmlEncode($Grid->o_q_sera_feito->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_o_q_sera_feito" class="el_plano_acao_o_q_sera_feito">
<textarea data-table="plano_acao" data-field="x_o_q_sera_feito" name="x<?= $Grid->RowIndex ?>_o_q_sera_feito" id="x<?= $Grid->RowIndex ?>_o_q_sera_feito" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->o_q_sera_feito->getPlaceHolder()) ?>"<?= $Grid->o_q_sera_feito->editAttributes() ?>><?= $Grid->o_q_sera_feito->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->o_q_sera_feito->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_o_q_sera_feito" class="el_plano_acao_o_q_sera_feito">
<span<?= $Grid->o_q_sera_feito->viewAttributes() ?>>
<?= $Grid->o_q_sera_feito->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao" data-field="x_o_q_sera_feito" data-hidden="1" name="fplano_acaogrid$x<?= $Grid->RowIndex ?>_o_q_sera_feito" id="fplano_acaogrid$x<?= $Grid->RowIndex ?>_o_q_sera_feito" value="<?= HtmlEncode($Grid->o_q_sera_feito->FormValue) ?>">
<input type="hidden" data-table="plano_acao" data-field="x_o_q_sera_feito" data-hidden="1" data-old name="fplano_acaogrid$o<?= $Grid->RowIndex ?>_o_q_sera_feito" id="fplano_acaogrid$o<?= $Grid->RowIndex ?>_o_q_sera_feito" value="<?= HtmlEncode($Grid->o_q_sera_feito->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->efeito_esperado->Visible) { // efeito_esperado ?>
        <td data-name="efeito_esperado"<?= $Grid->efeito_esperado->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_efeito_esperado" class="el_plano_acao_efeito_esperado">
<textarea data-table="plano_acao" data-field="x_efeito_esperado" name="x<?= $Grid->RowIndex ?>_efeito_esperado" id="x<?= $Grid->RowIndex ?>_efeito_esperado" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->efeito_esperado->getPlaceHolder()) ?>"<?= $Grid->efeito_esperado->editAttributes() ?>><?= $Grid->efeito_esperado->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->efeito_esperado->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="plano_acao" data-field="x_efeito_esperado" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_efeito_esperado" id="o<?= $Grid->RowIndex ?>_efeito_esperado" value="<?= HtmlEncode($Grid->efeito_esperado->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_efeito_esperado" class="el_plano_acao_efeito_esperado">
<textarea data-table="plano_acao" data-field="x_efeito_esperado" name="x<?= $Grid->RowIndex ?>_efeito_esperado" id="x<?= $Grid->RowIndex ?>_efeito_esperado" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->efeito_esperado->getPlaceHolder()) ?>"<?= $Grid->efeito_esperado->editAttributes() ?>><?= $Grid->efeito_esperado->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->efeito_esperado->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_efeito_esperado" class="el_plano_acao_efeito_esperado">
<span<?= $Grid->efeito_esperado->viewAttributes() ?>>
<?= $Grid->efeito_esperado->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao" data-field="x_efeito_esperado" data-hidden="1" name="fplano_acaogrid$x<?= $Grid->RowIndex ?>_efeito_esperado" id="fplano_acaogrid$x<?= $Grid->RowIndex ?>_efeito_esperado" value="<?= HtmlEncode($Grid->efeito_esperado->FormValue) ?>">
<input type="hidden" data-table="plano_acao" data-field="x_efeito_esperado" data-hidden="1" data-old name="fplano_acaogrid$o<?= $Grid->RowIndex ?>_efeito_esperado" id="fplano_acaogrid$o<?= $Grid->RowIndex ?>_efeito_esperado" value="<?= HtmlEncode($Grid->efeito_esperado->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <td data-name="departamentos_iddepartamentos"<?= $Grid->departamentos_iddepartamentos->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_departamentos_iddepartamentos" class="el_plano_acao_departamentos_iddepartamentos">
    <select
        id="x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos"
        name="x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos"
        class="form-select ew-select<?= $Grid->departamentos_iddepartamentos->isInvalidClass() ?>"
        <?php if (!$Grid->departamentos_iddepartamentos->IsNativeSelect) { ?>
        data-select2-id="fplano_acaogrid_x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos"
        <?php } ?>
        data-table="plano_acao"
        data-field="x_departamentos_iddepartamentos"
        data-value-separator="<?= $Grid->departamentos_iddepartamentos->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->departamentos_iddepartamentos->getPlaceHolder()) ?>"
        <?= $Grid->departamentos_iddepartamentos->editAttributes() ?>>
        <?= $Grid->departamentos_iddepartamentos->selectOptionListHtml("x{$Grid->RowIndex}_departamentos_iddepartamentos") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->departamentos_iddepartamentos->getErrorMessage() ?></div>
<?= $Grid->departamentos_iddepartamentos->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_departamentos_iddepartamentos") ?>
<?php if (!$Grid->departamentos_iddepartamentos->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acaogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos", selectId: "fplano_acaogrid_x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaogrid.lists.departamentos_iddepartamentos?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos", form: "fplano_acaogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos", form: "fplano_acaogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.departamentos_iddepartamentos.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="plano_acao" data-field="x_departamentos_iddepartamentos" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_departamentos_iddepartamentos" id="o<?= $Grid->RowIndex ?>_departamentos_iddepartamentos" value="<?= HtmlEncode($Grid->departamentos_iddepartamentos->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_departamentos_iddepartamentos" class="el_plano_acao_departamentos_iddepartamentos">
    <select
        id="x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos"
        name="x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos"
        class="form-select ew-select<?= $Grid->departamentos_iddepartamentos->isInvalidClass() ?>"
        <?php if (!$Grid->departamentos_iddepartamentos->IsNativeSelect) { ?>
        data-select2-id="fplano_acaogrid_x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos"
        <?php } ?>
        data-table="plano_acao"
        data-field="x_departamentos_iddepartamentos"
        data-value-separator="<?= $Grid->departamentos_iddepartamentos->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->departamentos_iddepartamentos->getPlaceHolder()) ?>"
        <?= $Grid->departamentos_iddepartamentos->editAttributes() ?>>
        <?= $Grid->departamentos_iddepartamentos->selectOptionListHtml("x{$Grid->RowIndex}_departamentos_iddepartamentos") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->departamentos_iddepartamentos->getErrorMessage() ?></div>
<?= $Grid->departamentos_iddepartamentos->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_departamentos_iddepartamentos") ?>
<?php if (!$Grid->departamentos_iddepartamentos->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acaogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos", selectId: "fplano_acaogrid_x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaogrid.lists.departamentos_iddepartamentos?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos", form: "fplano_acaogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos", form: "fplano_acaogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.departamentos_iddepartamentos.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_departamentos_iddepartamentos" class="el_plano_acao_departamentos_iddepartamentos">
<span<?= $Grid->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Grid->departamentos_iddepartamentos->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao" data-field="x_departamentos_iddepartamentos" data-hidden="1" name="fplano_acaogrid$x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos" id="fplano_acaogrid$x<?= $Grid->RowIndex ?>_departamentos_iddepartamentos" value="<?= HtmlEncode($Grid->departamentos_iddepartamentos->FormValue) ?>">
<input type="hidden" data-table="plano_acao" data-field="x_departamentos_iddepartamentos" data-hidden="1" data-old name="fplano_acaogrid$o<?= $Grid->RowIndex ?>_departamentos_iddepartamentos" id="fplano_acaogrid$o<?= $Grid->RowIndex ?>_departamentos_iddepartamentos" value="<?= HtmlEncode($Grid->departamentos_iddepartamentos->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <td data-name="origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade" class="el_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade">
    <select
        id="x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade"
        name="x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade"
        class="form-select ew-select<?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="fplano_acaogrid_x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade"
        <?php } ?>
        data-table="plano_acao"
        data-field="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        data-value-separator="<?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->getPlaceHolder()) ?>"
        <?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->editAttributes() ?>>
        <?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->selectOptionListHtml("x{$Grid->RowIndex}_origem_risco_oportunidade_idorigem_risco_oportunidade") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->getErrorMessage() ?></div>
<?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_origem_risco_oportunidade_idorigem_risco_oportunidade") ?>
<?php if (!$Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acaogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade", selectId: "fplano_acaogrid_x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaogrid.lists.origem_risco_oportunidade_idorigem_risco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fplano_acaogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fplano_acaogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="plano_acao" data-field="x_origem_risco_oportunidade_idorigem_risco_oportunidade" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade" id="o<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade" value="<?= HtmlEncode($Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade" class="el_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade">
    <select
        id="x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade"
        name="x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade"
        class="form-select ew-select<?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="fplano_acaogrid_x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade"
        <?php } ?>
        data-table="plano_acao"
        data-field="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        data-value-separator="<?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->getPlaceHolder()) ?>"
        <?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->editAttributes() ?>>
        <?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->selectOptionListHtml("x{$Grid->RowIndex}_origem_risco_oportunidade_idorigem_risco_oportunidade") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->getErrorMessage() ?></div>
<?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_origem_risco_oportunidade_idorigem_risco_oportunidade") ?>
<?php if (!$Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acaogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade", selectId: "fplano_acaogrid_x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaogrid.lists.origem_risco_oportunidade_idorigem_risco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fplano_acaogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fplano_acaogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade" class="el_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade">
<span<?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao" data-field="x_origem_risco_oportunidade_idorigem_risco_oportunidade" data-hidden="1" name="fplano_acaogrid$x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade" id="fplano_acaogrid$x<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade" value="<?= HtmlEncode($Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->FormValue) ?>">
<input type="hidden" data-table="plano_acao" data-field="x_origem_risco_oportunidade_idorigem_risco_oportunidade" data-hidden="1" data-old name="fplano_acaogrid$o<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade" id="fplano_acaogrid$o<?= $Grid->RowIndex ?>_origem_risco_oportunidade_idorigem_risco_oportunidade" value="<?= HtmlEncode($Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->recursos_nec->Visible) { // recursos_nec ?>
        <td data-name="recursos_nec"<?= $Grid->recursos_nec->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_recursos_nec" class="el_plano_acao_recursos_nec">
<input type="<?= $Grid->recursos_nec->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_recursos_nec" id="x<?= $Grid->RowIndex ?>_recursos_nec" data-table="plano_acao" data-field="x_recursos_nec" value="<?= $Grid->recursos_nec->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->recursos_nec->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->recursos_nec->formatPattern()) ?>"<?= $Grid->recursos_nec->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->recursos_nec->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="plano_acao" data-field="x_recursos_nec" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_recursos_nec" id="o<?= $Grid->RowIndex ?>_recursos_nec" value="<?= HtmlEncode($Grid->recursos_nec->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_recursos_nec" class="el_plano_acao_recursos_nec">
<input type="<?= $Grid->recursos_nec->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_recursos_nec" id="x<?= $Grid->RowIndex ?>_recursos_nec" data-table="plano_acao" data-field="x_recursos_nec" value="<?= $Grid->recursos_nec->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->recursos_nec->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->recursos_nec->formatPattern()) ?>"<?= $Grid->recursos_nec->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->recursos_nec->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_recursos_nec" class="el_plano_acao_recursos_nec">
<span<?= $Grid->recursos_nec->viewAttributes() ?>>
<?= $Grid->recursos_nec->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao" data-field="x_recursos_nec" data-hidden="1" name="fplano_acaogrid$x<?= $Grid->RowIndex ?>_recursos_nec" id="fplano_acaogrid$x<?= $Grid->RowIndex ?>_recursos_nec" value="<?= HtmlEncode($Grid->recursos_nec->FormValue) ?>">
<input type="hidden" data-table="plano_acao" data-field="x_recursos_nec" data-hidden="1" data-old name="fplano_acaogrid$o<?= $Grid->RowIndex ?>_recursos_nec" id="fplano_acaogrid$o<?= $Grid->RowIndex ?>_recursos_nec" value="<?= HtmlEncode($Grid->recursos_nec->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dt_limite->Visible) { // dt_limite ?>
        <td data-name="dt_limite"<?= $Grid->dt_limite->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_dt_limite" class="el_plano_acao_dt_limite">
<input type="<?= $Grid->dt_limite->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dt_limite" id="x<?= $Grid->RowIndex ?>_dt_limite" data-table="plano_acao" data-field="x_dt_limite" value="<?= $Grid->dt_limite->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->dt_limite->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->dt_limite->formatPattern()) ?>"<?= $Grid->dt_limite->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dt_limite->getErrorMessage() ?></div>
<?php if (!$Grid->dt_limite->ReadOnly && !$Grid->dt_limite->Disabled && !isset($Grid->dt_limite->EditAttrs["readonly"]) && !isset($Grid->dt_limite->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplano_acaogrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fplano_acaogrid", "x<?= $Grid->RowIndex ?>_dt_limite", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="plano_acao" data-field="x_dt_limite" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_dt_limite" id="o<?= $Grid->RowIndex ?>_dt_limite" value="<?= HtmlEncode($Grid->dt_limite->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_dt_limite" class="el_plano_acao_dt_limite">
<input type="<?= $Grid->dt_limite->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dt_limite" id="x<?= $Grid->RowIndex ?>_dt_limite" data-table="plano_acao" data-field="x_dt_limite" value="<?= $Grid->dt_limite->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->dt_limite->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->dt_limite->formatPattern()) ?>"<?= $Grid->dt_limite->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dt_limite->getErrorMessage() ?></div>
<?php if (!$Grid->dt_limite->ReadOnly && !$Grid->dt_limite->Disabled && !isset($Grid->dt_limite->EditAttrs["readonly"]) && !isset($Grid->dt_limite->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplano_acaogrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fplano_acaogrid", "x<?= $Grid->RowIndex ?>_dt_limite", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_dt_limite" class="el_plano_acao_dt_limite">
<span<?= $Grid->dt_limite->viewAttributes() ?>>
<?= $Grid->dt_limite->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao" data-field="x_dt_limite" data-hidden="1" name="fplano_acaogrid$x<?= $Grid->RowIndex ?>_dt_limite" id="fplano_acaogrid$x<?= $Grid->RowIndex ?>_dt_limite" value="<?= HtmlEncode($Grid->dt_limite->FormValue) ?>">
<input type="hidden" data-table="plano_acao" data-field="x_dt_limite" data-hidden="1" data-old name="fplano_acaogrid$o<?= $Grid->RowIndex ?>_dt_limite" id="fplano_acaogrid$o<?= $Grid->RowIndex ?>_dt_limite" value="<?= HtmlEncode($Grid->dt_limite->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->implementado->Visible) { // implementado ?>
        <td data-name="implementado"<?= $Grid->implementado->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_implementado" class="el_plano_acao_implementado">
<template id="tp_x<?= $Grid->RowIndex ?>_implementado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao" data-field="x_implementado" name="x<?= $Grid->RowIndex ?>_implementado" id="x<?= $Grid->RowIndex ?>_implementado"<?= $Grid->implementado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_implementado" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_implementado"
    name="x<?= $Grid->RowIndex ?>_implementado"
    value="<?= HtmlEncode($Grid->implementado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_implementado"
    data-target="dsl_x<?= $Grid->RowIndex ?>_implementado"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->implementado->isInvalidClass() ?>"
    data-table="plano_acao"
    data-field="x_implementado"
    data-value-separator="<?= $Grid->implementado->displayValueSeparatorAttribute() ?>"
    <?= $Grid->implementado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->implementado->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="plano_acao" data-field="x_implementado" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_implementado" id="o<?= $Grid->RowIndex ?>_implementado" value="<?= HtmlEncode($Grid->implementado->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_implementado" class="el_plano_acao_implementado">
<template id="tp_x<?= $Grid->RowIndex ?>_implementado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao" data-field="x_implementado" name="x<?= $Grid->RowIndex ?>_implementado" id="x<?= $Grid->RowIndex ?>_implementado"<?= $Grid->implementado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_implementado" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_implementado"
    name="x<?= $Grid->RowIndex ?>_implementado"
    value="<?= HtmlEncode($Grid->implementado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_implementado"
    data-target="dsl_x<?= $Grid->RowIndex ?>_implementado"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->implementado->isInvalidClass() ?>"
    data-table="plano_acao"
    data-field="x_implementado"
    data-value-separator="<?= $Grid->implementado->displayValueSeparatorAttribute() ?>"
    <?= $Grid->implementado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->implementado->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_implementado" class="el_plano_acao_implementado">
<span<?= $Grid->implementado->viewAttributes() ?>>
<?= $Grid->implementado->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao" data-field="x_implementado" data-hidden="1" name="fplano_acaogrid$x<?= $Grid->RowIndex ?>_implementado" id="fplano_acaogrid$x<?= $Grid->RowIndex ?>_implementado" value="<?= HtmlEncode($Grid->implementado->FormValue) ?>">
<input type="hidden" data-table="plano_acao" data-field="x_implementado" data-hidden="1" data-old name="fplano_acaogrid$o<?= $Grid->RowIndex ?>_implementado" id="fplano_acaogrid$o<?= $Grid->RowIndex ?>_implementado" value="<?= HtmlEncode($Grid->implementado->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <td data-name="periodicidade_idperiodicidade"<?= $Grid->periodicidade_idperiodicidade->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_periodicidade_idperiodicidade" class="el_plano_acao_periodicidade_idperiodicidade">
<template id="tp_x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao" data-field="x_periodicidade_idperiodicidade" name="x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade" id="x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade"<?= $Grid->periodicidade_idperiodicidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade"
    name="x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade"
    value="<?= HtmlEncode($Grid->periodicidade_idperiodicidade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade"
    data-target="dsl_x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->periodicidade_idperiodicidade->isInvalidClass() ?>"
    data-table="plano_acao"
    data-field="x_periodicidade_idperiodicidade"
    data-value-separator="<?= $Grid->periodicidade_idperiodicidade->displayValueSeparatorAttribute() ?>"
    <?= $Grid->periodicidade_idperiodicidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->periodicidade_idperiodicidade->getErrorMessage() ?></div>
<?= $Grid->periodicidade_idperiodicidade->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_periodicidade_idperiodicidade") ?>
</span>
<input type="hidden" data-table="plano_acao" data-field="x_periodicidade_idperiodicidade" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade" id="o<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade" value="<?= HtmlEncode($Grid->periodicidade_idperiodicidade->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_periodicidade_idperiodicidade" class="el_plano_acao_periodicidade_idperiodicidade">
<template id="tp_x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao" data-field="x_periodicidade_idperiodicidade" name="x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade" id="x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade"<?= $Grid->periodicidade_idperiodicidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade"
    name="x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade"
    value="<?= HtmlEncode($Grid->periodicidade_idperiodicidade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade"
    data-target="dsl_x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->periodicidade_idperiodicidade->isInvalidClass() ?>"
    data-table="plano_acao"
    data-field="x_periodicidade_idperiodicidade"
    data-value-separator="<?= $Grid->periodicidade_idperiodicidade->displayValueSeparatorAttribute() ?>"
    <?= $Grid->periodicidade_idperiodicidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->periodicidade_idperiodicidade->getErrorMessage() ?></div>
<?= $Grid->periodicidade_idperiodicidade->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_periodicidade_idperiodicidade") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_periodicidade_idperiodicidade" class="el_plano_acao_periodicidade_idperiodicidade">
<span<?= $Grid->periodicidade_idperiodicidade->viewAttributes() ?>>
<?= $Grid->periodicidade_idperiodicidade->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao" data-field="x_periodicidade_idperiodicidade" data-hidden="1" name="fplano_acaogrid$x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade" id="fplano_acaogrid$x<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade" value="<?= HtmlEncode($Grid->periodicidade_idperiodicidade->FormValue) ?>">
<input type="hidden" data-table="plano_acao" data-field="x_periodicidade_idperiodicidade" data-hidden="1" data-old name="fplano_acaogrid$o<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade" id="fplano_acaogrid$o<?= $Grid->RowIndex ?>_periodicidade_idperiodicidade" value="<?= HtmlEncode($Grid->periodicidade_idperiodicidade->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->eficaz->Visible) { // eficaz ?>
        <td data-name="eficaz"<?= $Grid->eficaz->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_eficaz" class="el_plano_acao_eficaz">
<template id="tp_x<?= $Grid->RowIndex ?>_eficaz">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao" data-field="x_eficaz" name="x<?= $Grid->RowIndex ?>_eficaz" id="x<?= $Grid->RowIndex ?>_eficaz"<?= $Grid->eficaz->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_eficaz" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_eficaz"
    name="x<?= $Grid->RowIndex ?>_eficaz"
    value="<?= HtmlEncode($Grid->eficaz->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_eficaz"
    data-target="dsl_x<?= $Grid->RowIndex ?>_eficaz"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->eficaz->isInvalidClass() ?>"
    data-table="plano_acao"
    data-field="x_eficaz"
    data-value-separator="<?= $Grid->eficaz->displayValueSeparatorAttribute() ?>"
    <?= $Grid->eficaz->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->eficaz->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="plano_acao" data-field="x_eficaz" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_eficaz" id="o<?= $Grid->RowIndex ?>_eficaz" value="<?= HtmlEncode($Grid->eficaz->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_eficaz" class="el_plano_acao_eficaz">
<template id="tp_x<?= $Grid->RowIndex ?>_eficaz">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao" data-field="x_eficaz" name="x<?= $Grid->RowIndex ?>_eficaz" id="x<?= $Grid->RowIndex ?>_eficaz"<?= $Grid->eficaz->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_eficaz" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_eficaz"
    name="x<?= $Grid->RowIndex ?>_eficaz"
    value="<?= HtmlEncode($Grid->eficaz->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_eficaz"
    data-target="dsl_x<?= $Grid->RowIndex ?>_eficaz"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->eficaz->isInvalidClass() ?>"
    data-table="plano_acao"
    data-field="x_eficaz"
    data-value-separator="<?= $Grid->eficaz->displayValueSeparatorAttribute() ?>"
    <?= $Grid->eficaz->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->eficaz->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_eficaz" class="el_plano_acao_eficaz">
<span<?= $Grid->eficaz->viewAttributes() ?>>
<?= $Grid->eficaz->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao" data-field="x_eficaz" data-hidden="1" name="fplano_acaogrid$x<?= $Grid->RowIndex ?>_eficaz" id="fplano_acaogrid$x<?= $Grid->RowIndex ?>_eficaz" value="<?= HtmlEncode($Grid->eficaz->FormValue) ?>">
<input type="hidden" data-table="plano_acao" data-field="x_eficaz" data-hidden="1" data-old name="fplano_acaogrid$o<?= $Grid->RowIndex ?>_eficaz" id="fplano_acaogrid$o<?= $Grid->RowIndex ?>_eficaz" value="<?= HtmlEncode($Grid->eficaz->OldValue) ?>">
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
loadjs.ready(["fplano_acaogrid","load"], () => fplano_acaogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
    <?php if ($Grid->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
        <td data-name="risco_oportunidade_idrisco_oportunidade" class="<?= $Grid->risco_oportunidade_idrisco_oportunidade->footerCellClass() ?>"><span id="elf_plano_acao_risco_oportunidade_idrisco_oportunidade" class="plano_acao_risco_oportunidade_idrisco_oportunidade">
        </span></td>
    <?php } ?>
    <?php if ($Grid->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <td data-name="o_q_sera_feito" class="<?= $Grid->o_q_sera_feito->footerCellClass() ?>"><span id="elf_plano_acao_o_q_sera_feito" class="plano_acao_o_q_sera_feito">
        </span></td>
    <?php } ?>
    <?php if ($Grid->efeito_esperado->Visible) { // efeito_esperado ?>
        <td data-name="efeito_esperado" class="<?= $Grid->efeito_esperado->footerCellClass() ?>"><span id="elf_plano_acao_efeito_esperado" class="plano_acao_efeito_esperado">
        </span></td>
    <?php } ?>
    <?php if ($Grid->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <td data-name="departamentos_iddepartamentos" class="<?= $Grid->departamentos_iddepartamentos->footerCellClass() ?>"><span id="elf_plano_acao_departamentos_iddepartamentos" class="plano_acao_departamentos_iddepartamentos">
        </span></td>
    <?php } ?>
    <?php if ($Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <td data-name="origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Grid->origem_risco_oportunidade_idorigem_risco_oportunidade->footerCellClass() ?>"><span id="elf_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade" class="plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade">
        </span></td>
    <?php } ?>
    <?php if ($Grid->recursos_nec->Visible) { // recursos_nec ?>
        <td data-name="recursos_nec" class="<?= $Grid->recursos_nec->footerCellClass() ?>"><span id="elf_plano_acao_recursos_nec" class="plano_acao_recursos_nec">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->recursos_nec->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->dt_limite->Visible) { // dt_limite ?>
        <td data-name="dt_limite" class="<?= $Grid->dt_limite->footerCellClass() ?>"><span id="elf_plano_acao_dt_limite" class="plano_acao_dt_limite">
        </span></td>
    <?php } ?>
    <?php if ($Grid->implementado->Visible) { // implementado ?>
        <td data-name="implementado" class="<?= $Grid->implementado->footerCellClass() ?>"><span id="elf_plano_acao_implementado" class="plano_acao_implementado">
        </span></td>
    <?php } ?>
    <?php if ($Grid->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <td data-name="periodicidade_idperiodicidade" class="<?= $Grid->periodicidade_idperiodicidade->footerCellClass() ?>"><span id="elf_plano_acao_periodicidade_idperiodicidade" class="plano_acao_periodicidade_idperiodicidade">
        </span></td>
    <?php } ?>
    <?php if ($Grid->eficaz->Visible) { // eficaz ?>
        <td data-name="eficaz" class="<?= $Grid->eficaz->footerCellClass() ?>"><span id="elf_plano_acao_eficaz" class="plano_acao_eficaz">
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
<input type="hidden" name="detailpage" value="fplano_acaogrid">
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
    ew.addEventHandlers("plano_acao");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
