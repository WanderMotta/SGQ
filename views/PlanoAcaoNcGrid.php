<?php

namespace PHPMaker2024\sgq;

// Set up and run Grid object
$Grid = Container("PlanoAcaoNcGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fplano_acao_ncgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { plano_acao_nc: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplano_acao_ncgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["o_q_sera_feito", [fields.o_q_sera_feito.visible && fields.o_q_sera_feito.required ? ew.Validators.required(fields.o_q_sera_feito.caption) : null], fields.o_q_sera_feito.isInvalid],
            ["efeito_esperado", [fields.efeito_esperado.visible && fields.efeito_esperado.required ? ew.Validators.required(fields.efeito_esperado.caption) : null], fields.efeito_esperado.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid],
            ["recursos_nec", [fields.recursos_nec.visible && fields.recursos_nec.required ? ew.Validators.required(fields.recursos_nec.caption) : null, ew.Validators.float], fields.recursos_nec.isInvalid],
            ["dt_limite", [fields.dt_limite.visible && fields.dt_limite.required ? ew.Validators.required(fields.dt_limite.caption) : null, ew.Validators.datetime(fields.dt_limite.clientFormatPattern)], fields.dt_limite.isInvalid],
            ["implementado", [fields.implementado.visible && fields.implementado.required ? ew.Validators.required(fields.implementado.caption) : null], fields.implementado.isInvalid],
            ["eficaz", [fields.eficaz.visible && fields.eficaz.required ? ew.Validators.required(fields.eficaz.caption) : null], fields.eficaz.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["o_q_sera_feito",false],["efeito_esperado",false],["usuario_idusuario",false],["recursos_nec",false],["dt_limite",false],["implementado",false],["eficaz",false]];
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
            "usuario_idusuario": <?= $Grid->usuario_idusuario->toClientList($Grid) ?>,
            "implementado": <?= $Grid->implementado->toClientList($Grid) ?>,
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
<div id="fplano_acao_ncgrid" class="ew-form ew-list-form">
<div id="gmp_plano_acao_nc" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_plano_acao_ncgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <th data-name="o_q_sera_feito" class="<?= $Grid->o_q_sera_feito->headerCellClass() ?>"><div id="elh_plano_acao_nc_o_q_sera_feito" class="plano_acao_nc_o_q_sera_feito"><?= $Grid->renderFieldHeader($Grid->o_q_sera_feito) ?></div></th>
<?php } ?>
<?php if ($Grid->efeito_esperado->Visible) { // efeito_esperado ?>
        <th data-name="efeito_esperado" class="<?= $Grid->efeito_esperado->headerCellClass() ?>"><div id="elh_plano_acao_nc_efeito_esperado" class="plano_acao_nc_efeito_esperado"><?= $Grid->renderFieldHeader($Grid->efeito_esperado) ?></div></th>
<?php } ?>
<?php if ($Grid->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th data-name="usuario_idusuario" class="<?= $Grid->usuario_idusuario->headerCellClass() ?>"><div id="elh_plano_acao_nc_usuario_idusuario" class="plano_acao_nc_usuario_idusuario"><?= $Grid->renderFieldHeader($Grid->usuario_idusuario) ?></div></th>
<?php } ?>
<?php if ($Grid->recursos_nec->Visible) { // recursos_nec ?>
        <th data-name="recursos_nec" class="<?= $Grid->recursos_nec->headerCellClass() ?>"><div id="elh_plano_acao_nc_recursos_nec" class="plano_acao_nc_recursos_nec"><?= $Grid->renderFieldHeader($Grid->recursos_nec) ?></div></th>
<?php } ?>
<?php if ($Grid->dt_limite->Visible) { // dt_limite ?>
        <th data-name="dt_limite" class="<?= $Grid->dt_limite->headerCellClass() ?>"><div id="elh_plano_acao_nc_dt_limite" class="plano_acao_nc_dt_limite"><?= $Grid->renderFieldHeader($Grid->dt_limite) ?></div></th>
<?php } ?>
<?php if ($Grid->implementado->Visible) { // implementado ?>
        <th data-name="implementado" class="<?= $Grid->implementado->headerCellClass() ?>"><div id="elh_plano_acao_nc_implementado" class="plano_acao_nc_implementado"><?= $Grid->renderFieldHeader($Grid->implementado) ?></div></th>
<?php } ?>
<?php if ($Grid->eficaz->Visible) { // eficaz ?>
        <th data-name="eficaz" class="<?= $Grid->eficaz->headerCellClass() ?>"><div id="elh_plano_acao_nc_eficaz" class="plano_acao_nc_eficaz"><?= $Grid->renderFieldHeader($Grid->eficaz) ?></div></th>
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
    <?php if ($Grid->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <td data-name="o_q_sera_feito"<?= $Grid->o_q_sera_feito->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_o_q_sera_feito" class="el_plano_acao_nc_o_q_sera_feito">
<textarea data-table="plano_acao_nc" data-field="x_o_q_sera_feito" name="x<?= $Grid->RowIndex ?>_o_q_sera_feito" id="x<?= $Grid->RowIndex ?>_o_q_sera_feito" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->o_q_sera_feito->getPlaceHolder()) ?>"<?= $Grid->o_q_sera_feito->editAttributes() ?>><?= $Grid->o_q_sera_feito->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->o_q_sera_feito->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="plano_acao_nc" data-field="x_o_q_sera_feito" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_o_q_sera_feito" id="o<?= $Grid->RowIndex ?>_o_q_sera_feito" value="<?= HtmlEncode($Grid->o_q_sera_feito->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_o_q_sera_feito" class="el_plano_acao_nc_o_q_sera_feito">
<textarea data-table="plano_acao_nc" data-field="x_o_q_sera_feito" name="x<?= $Grid->RowIndex ?>_o_q_sera_feito" id="x<?= $Grid->RowIndex ?>_o_q_sera_feito" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->o_q_sera_feito->getPlaceHolder()) ?>"<?= $Grid->o_q_sera_feito->editAttributes() ?>><?= $Grid->o_q_sera_feito->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->o_q_sera_feito->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_o_q_sera_feito" class="el_plano_acao_nc_o_q_sera_feito">
<span<?= $Grid->o_q_sera_feito->viewAttributes() ?>>
<?= $Grid->o_q_sera_feito->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao_nc" data-field="x_o_q_sera_feito" data-hidden="1" name="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_o_q_sera_feito" id="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_o_q_sera_feito" value="<?= HtmlEncode($Grid->o_q_sera_feito->FormValue) ?>">
<input type="hidden" data-table="plano_acao_nc" data-field="x_o_q_sera_feito" data-hidden="1" data-old name="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_o_q_sera_feito" id="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_o_q_sera_feito" value="<?= HtmlEncode($Grid->o_q_sera_feito->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->efeito_esperado->Visible) { // efeito_esperado ?>
        <td data-name="efeito_esperado"<?= $Grid->efeito_esperado->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_efeito_esperado" class="el_plano_acao_nc_efeito_esperado">
<textarea data-table="plano_acao_nc" data-field="x_efeito_esperado" name="x<?= $Grid->RowIndex ?>_efeito_esperado" id="x<?= $Grid->RowIndex ?>_efeito_esperado" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->efeito_esperado->getPlaceHolder()) ?>"<?= $Grid->efeito_esperado->editAttributes() ?>><?= $Grid->efeito_esperado->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->efeito_esperado->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="plano_acao_nc" data-field="x_efeito_esperado" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_efeito_esperado" id="o<?= $Grid->RowIndex ?>_efeito_esperado" value="<?= HtmlEncode($Grid->efeito_esperado->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_efeito_esperado" class="el_plano_acao_nc_efeito_esperado">
<textarea data-table="plano_acao_nc" data-field="x_efeito_esperado" name="x<?= $Grid->RowIndex ?>_efeito_esperado" id="x<?= $Grid->RowIndex ?>_efeito_esperado" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->efeito_esperado->getPlaceHolder()) ?>"<?= $Grid->efeito_esperado->editAttributes() ?>><?= $Grid->efeito_esperado->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->efeito_esperado->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_efeito_esperado" class="el_plano_acao_nc_efeito_esperado">
<span<?= $Grid->efeito_esperado->viewAttributes() ?>>
<?= $Grid->efeito_esperado->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao_nc" data-field="x_efeito_esperado" data-hidden="1" name="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_efeito_esperado" id="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_efeito_esperado" value="<?= HtmlEncode($Grid->efeito_esperado->FormValue) ?>">
<input type="hidden" data-table="plano_acao_nc" data-field="x_efeito_esperado" data-hidden="1" data-old name="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_efeito_esperado" id="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_efeito_esperado" value="<?= HtmlEncode($Grid->efeito_esperado->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td data-name="usuario_idusuario"<?= $Grid->usuario_idusuario->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_usuario_idusuario" class="el_plano_acao_nc_usuario_idusuario">
    <select
        id="x<?= $Grid->RowIndex ?>_usuario_idusuario"
        name="x<?= $Grid->RowIndex ?>_usuario_idusuario"
        class="form-control ew-select<?= $Grid->usuario_idusuario->isInvalidClass() ?>"
        data-select2-id="fplano_acao_ncgrid_x<?= $Grid->RowIndex ?>_usuario_idusuario"
        data-table="plano_acao_nc"
        data-field="x_usuario_idusuario"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->usuario_idusuario->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->usuario_idusuario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->usuario_idusuario->getPlaceHolder()) ?>"
        <?= $Grid->usuario_idusuario->editAttributes() ?>>
        <?= $Grid->usuario_idusuario->selectOptionListHtml("x{$Grid->RowIndex}_usuario_idusuario") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->usuario_idusuario->getErrorMessage() ?></div>
<?= $Grid->usuario_idusuario->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_usuario_idusuario") ?>
<script>
loadjs.ready("fplano_acao_ncgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_usuario_idusuario", selectId: "fplano_acao_ncgrid_x<?= $Grid->RowIndex ?>_usuario_idusuario" };
    if (fplano_acao_ncgrid.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_usuario_idusuario", form: "fplano_acao_ncgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_usuario_idusuario", form: "fplano_acao_ncgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.plano_acao_nc.fields.usuario_idusuario.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="plano_acao_nc" data-field="x_usuario_idusuario" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_usuario_idusuario" id="o<?= $Grid->RowIndex ?>_usuario_idusuario" value="<?= HtmlEncode($Grid->usuario_idusuario->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_usuario_idusuario" class="el_plano_acao_nc_usuario_idusuario">
    <select
        id="x<?= $Grid->RowIndex ?>_usuario_idusuario"
        name="x<?= $Grid->RowIndex ?>_usuario_idusuario"
        class="form-control ew-select<?= $Grid->usuario_idusuario->isInvalidClass() ?>"
        data-select2-id="fplano_acao_ncgrid_x<?= $Grid->RowIndex ?>_usuario_idusuario"
        data-table="plano_acao_nc"
        data-field="x_usuario_idusuario"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->usuario_idusuario->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->usuario_idusuario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->usuario_idusuario->getPlaceHolder()) ?>"
        <?= $Grid->usuario_idusuario->editAttributes() ?>>
        <?= $Grid->usuario_idusuario->selectOptionListHtml("x{$Grid->RowIndex}_usuario_idusuario") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->usuario_idusuario->getErrorMessage() ?></div>
<?= $Grid->usuario_idusuario->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_usuario_idusuario") ?>
<script>
loadjs.ready("fplano_acao_ncgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_usuario_idusuario", selectId: "fplano_acao_ncgrid_x<?= $Grid->RowIndex ?>_usuario_idusuario" };
    if (fplano_acao_ncgrid.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_usuario_idusuario", form: "fplano_acao_ncgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_usuario_idusuario", form: "fplano_acao_ncgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.plano_acao_nc.fields.usuario_idusuario.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_usuario_idusuario" class="el_plano_acao_nc_usuario_idusuario">
<span<?= $Grid->usuario_idusuario->viewAttributes() ?>>
<?= $Grid->usuario_idusuario->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao_nc" data-field="x_usuario_idusuario" data-hidden="1" name="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_usuario_idusuario" id="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_usuario_idusuario" value="<?= HtmlEncode($Grid->usuario_idusuario->FormValue) ?>">
<input type="hidden" data-table="plano_acao_nc" data-field="x_usuario_idusuario" data-hidden="1" data-old name="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_usuario_idusuario" id="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_usuario_idusuario" value="<?= HtmlEncode($Grid->usuario_idusuario->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->recursos_nec->Visible) { // recursos_nec ?>
        <td data-name="recursos_nec"<?= $Grid->recursos_nec->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_recursos_nec" class="el_plano_acao_nc_recursos_nec">
<input type="<?= $Grid->recursos_nec->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_recursos_nec" id="x<?= $Grid->RowIndex ?>_recursos_nec" data-table="plano_acao_nc" data-field="x_recursos_nec" value="<?= $Grid->recursos_nec->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->recursos_nec->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->recursos_nec->formatPattern()) ?>"<?= $Grid->recursos_nec->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->recursos_nec->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="plano_acao_nc" data-field="x_recursos_nec" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_recursos_nec" id="o<?= $Grid->RowIndex ?>_recursos_nec" value="<?= HtmlEncode($Grid->recursos_nec->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_recursos_nec" class="el_plano_acao_nc_recursos_nec">
<input type="<?= $Grid->recursos_nec->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_recursos_nec" id="x<?= $Grid->RowIndex ?>_recursos_nec" data-table="plano_acao_nc" data-field="x_recursos_nec" value="<?= $Grid->recursos_nec->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->recursos_nec->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->recursos_nec->formatPattern()) ?>"<?= $Grid->recursos_nec->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->recursos_nec->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_recursos_nec" class="el_plano_acao_nc_recursos_nec">
<span<?= $Grid->recursos_nec->viewAttributes() ?>>
<?= $Grid->recursos_nec->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao_nc" data-field="x_recursos_nec" data-hidden="1" name="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_recursos_nec" id="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_recursos_nec" value="<?= HtmlEncode($Grid->recursos_nec->FormValue) ?>">
<input type="hidden" data-table="plano_acao_nc" data-field="x_recursos_nec" data-hidden="1" data-old name="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_recursos_nec" id="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_recursos_nec" value="<?= HtmlEncode($Grid->recursos_nec->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dt_limite->Visible) { // dt_limite ?>
        <td data-name="dt_limite"<?= $Grid->dt_limite->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_dt_limite" class="el_plano_acao_nc_dt_limite">
<input type="<?= $Grid->dt_limite->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dt_limite" id="x<?= $Grid->RowIndex ?>_dt_limite" data-table="plano_acao_nc" data-field="x_dt_limite" value="<?= $Grid->dt_limite->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->dt_limite->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->dt_limite->formatPattern()) ?>"<?= $Grid->dt_limite->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dt_limite->getErrorMessage() ?></div>
<?php if (!$Grid->dt_limite->ReadOnly && !$Grid->dt_limite->Disabled && !isset($Grid->dt_limite->EditAttrs["readonly"]) && !isset($Grid->dt_limite->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplano_acao_ncgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fplano_acao_ncgrid", "x<?= $Grid->RowIndex ?>_dt_limite", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="plano_acao_nc" data-field="x_dt_limite" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_dt_limite" id="o<?= $Grid->RowIndex ?>_dt_limite" value="<?= HtmlEncode($Grid->dt_limite->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_dt_limite" class="el_plano_acao_nc_dt_limite">
<input type="<?= $Grid->dt_limite->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dt_limite" id="x<?= $Grid->RowIndex ?>_dt_limite" data-table="plano_acao_nc" data-field="x_dt_limite" value="<?= $Grid->dt_limite->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->dt_limite->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->dt_limite->formatPattern()) ?>"<?= $Grid->dt_limite->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dt_limite->getErrorMessage() ?></div>
<?php if (!$Grid->dt_limite->ReadOnly && !$Grid->dt_limite->Disabled && !isset($Grid->dt_limite->EditAttrs["readonly"]) && !isset($Grid->dt_limite->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplano_acao_ncgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fplano_acao_ncgrid", "x<?= $Grid->RowIndex ?>_dt_limite", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_dt_limite" class="el_plano_acao_nc_dt_limite">
<span<?= $Grid->dt_limite->viewAttributes() ?>>
<?= $Grid->dt_limite->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao_nc" data-field="x_dt_limite" data-hidden="1" name="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_dt_limite" id="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_dt_limite" value="<?= HtmlEncode($Grid->dt_limite->FormValue) ?>">
<input type="hidden" data-table="plano_acao_nc" data-field="x_dt_limite" data-hidden="1" data-old name="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_dt_limite" id="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_dt_limite" value="<?= HtmlEncode($Grid->dt_limite->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->implementado->Visible) { // implementado ?>
        <td data-name="implementado"<?= $Grid->implementado->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_implementado" class="el_plano_acao_nc_implementado">
<template id="tp_x<?= $Grid->RowIndex ?>_implementado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao_nc" data-field="x_implementado" name="x<?= $Grid->RowIndex ?>_implementado" id="x<?= $Grid->RowIndex ?>_implementado"<?= $Grid->implementado->editAttributes() ?>>
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
    data-table="plano_acao_nc"
    data-field="x_implementado"
    data-value-separator="<?= $Grid->implementado->displayValueSeparatorAttribute() ?>"
    <?= $Grid->implementado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->implementado->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="plano_acao_nc" data-field="x_implementado" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_implementado" id="o<?= $Grid->RowIndex ?>_implementado" value="<?= HtmlEncode($Grid->implementado->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_implementado" class="el_plano_acao_nc_implementado">
<template id="tp_x<?= $Grid->RowIndex ?>_implementado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao_nc" data-field="x_implementado" name="x<?= $Grid->RowIndex ?>_implementado" id="x<?= $Grid->RowIndex ?>_implementado"<?= $Grid->implementado->editAttributes() ?>>
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
    data-table="plano_acao_nc"
    data-field="x_implementado"
    data-value-separator="<?= $Grid->implementado->displayValueSeparatorAttribute() ?>"
    <?= $Grid->implementado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->implementado->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_implementado" class="el_plano_acao_nc_implementado">
<span<?= $Grid->implementado->viewAttributes() ?>>
<?= $Grid->implementado->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao_nc" data-field="x_implementado" data-hidden="1" name="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_implementado" id="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_implementado" value="<?= HtmlEncode($Grid->implementado->FormValue) ?>">
<input type="hidden" data-table="plano_acao_nc" data-field="x_implementado" data-hidden="1" data-old name="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_implementado" id="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_implementado" value="<?= HtmlEncode($Grid->implementado->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->eficaz->Visible) { // eficaz ?>
        <td data-name="eficaz"<?= $Grid->eficaz->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_eficaz" class="el_plano_acao_nc_eficaz">
<template id="tp_x<?= $Grid->RowIndex ?>_eficaz">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao_nc" data-field="x_eficaz" name="x<?= $Grid->RowIndex ?>_eficaz" id="x<?= $Grid->RowIndex ?>_eficaz"<?= $Grid->eficaz->editAttributes() ?>>
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
    data-table="plano_acao_nc"
    data-field="x_eficaz"
    data-value-separator="<?= $Grid->eficaz->displayValueSeparatorAttribute() ?>"
    <?= $Grid->eficaz->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->eficaz->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="plano_acao_nc" data-field="x_eficaz" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_eficaz" id="o<?= $Grid->RowIndex ?>_eficaz" value="<?= HtmlEncode($Grid->eficaz->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_eficaz" class="el_plano_acao_nc_eficaz">
<template id="tp_x<?= $Grid->RowIndex ?>_eficaz">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao_nc" data-field="x_eficaz" name="x<?= $Grid->RowIndex ?>_eficaz" id="x<?= $Grid->RowIndex ?>_eficaz"<?= $Grid->eficaz->editAttributes() ?>>
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
    data-table="plano_acao_nc"
    data-field="x_eficaz"
    data-value-separator="<?= $Grid->eficaz->displayValueSeparatorAttribute() ?>"
    <?= $Grid->eficaz->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->eficaz->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_plano_acao_nc_eficaz" class="el_plano_acao_nc_eficaz">
<span<?= $Grid->eficaz->viewAttributes() ?>>
<?= $Grid->eficaz->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="plano_acao_nc" data-field="x_eficaz" data-hidden="1" name="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_eficaz" id="fplano_acao_ncgrid$x<?= $Grid->RowIndex ?>_eficaz" value="<?= HtmlEncode($Grid->eficaz->FormValue) ?>">
<input type="hidden" data-table="plano_acao_nc" data-field="x_eficaz" data-hidden="1" data-old name="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_eficaz" id="fplano_acao_ncgrid$o<?= $Grid->RowIndex ?>_eficaz" value="<?= HtmlEncode($Grid->eficaz->OldValue) ?>">
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
loadjs.ready(["fplano_acao_ncgrid","load"], () => fplano_acao_ncgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
    <?php if ($Grid->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <td data-name="o_q_sera_feito" class="<?= $Grid->o_q_sera_feito->footerCellClass() ?>"><span id="elf_plano_acao_nc_o_q_sera_feito" class="plano_acao_nc_o_q_sera_feito">
        </span></td>
    <?php } ?>
    <?php if ($Grid->efeito_esperado->Visible) { // efeito_esperado ?>
        <td data-name="efeito_esperado" class="<?= $Grid->efeito_esperado->footerCellClass() ?>"><span id="elf_plano_acao_nc_efeito_esperado" class="plano_acao_nc_efeito_esperado">
        </span></td>
    <?php } ?>
    <?php if ($Grid->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td data-name="usuario_idusuario" class="<?= $Grid->usuario_idusuario->footerCellClass() ?>"><span id="elf_plano_acao_nc_usuario_idusuario" class="plano_acao_nc_usuario_idusuario">
        </span></td>
    <?php } ?>
    <?php if ($Grid->recursos_nec->Visible) { // recursos_nec ?>
        <td data-name="recursos_nec" class="<?= $Grid->recursos_nec->footerCellClass() ?>"><span id="elf_plano_acao_nc_recursos_nec" class="plano_acao_nc_recursos_nec">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->recursos_nec->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->dt_limite->Visible) { // dt_limite ?>
        <td data-name="dt_limite" class="<?= $Grid->dt_limite->footerCellClass() ?>"><span id="elf_plano_acao_nc_dt_limite" class="plano_acao_nc_dt_limite">
        </span></td>
    <?php } ?>
    <?php if ($Grid->implementado->Visible) { // implementado ?>
        <td data-name="implementado" class="<?= $Grid->implementado->footerCellClass() ?>"><span id="elf_plano_acao_nc_implementado" class="plano_acao_nc_implementado">
        </span></td>
    <?php } ?>
    <?php if ($Grid->eficaz->Visible) { // eficaz ?>
        <td data-name="eficaz" class="<?= $Grid->eficaz->footerCellClass() ?>"><span id="elf_plano_acao_nc_eficaz" class="plano_acao_nc_eficaz">
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
<input type="hidden" name="detailpage" value="fplano_acao_ncgrid">
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
    ew.addEventHandlers("plano_acao_nc");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
