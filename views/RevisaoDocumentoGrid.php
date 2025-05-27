<?php

namespace PHPMaker2024\sgq;

// Set up and run Grid object
$Grid = Container("RevisaoDocumentoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var frevisao_documentogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { revisao_documento: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frevisao_documentogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null, ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["qual_alteracao", [fields.qual_alteracao.visible && fields.qual_alteracao.required ? ew.Validators.required(fields.qual_alteracao.caption) : null], fields.qual_alteracao.isInvalid],
            ["status_documento_idstatus_documento", [fields.status_documento_idstatus_documento.visible && fields.status_documento_idstatus_documento.required ? ew.Validators.required(fields.status_documento_idstatus_documento.caption) : null], fields.status_documento_idstatus_documento.isInvalid],
            ["revisao_nr", [fields.revisao_nr.visible && fields.revisao_nr.required ? ew.Validators.required(fields.revisao_nr.caption) : null, ew.Validators.integer], fields.revisao_nr.isInvalid],
            ["usuario_elaborador", [fields.usuario_elaborador.visible && fields.usuario_elaborador.required ? ew.Validators.required(fields.usuario_elaborador.caption) : null], fields.usuario_elaborador.isInvalid],
            ["usuario_aprovador", [fields.usuario_aprovador.visible && fields.usuario_aprovador.required ? ew.Validators.required(fields.usuario_aprovador.caption) : null], fields.usuario_aprovador.isInvalid],
            ["dt_aprovacao", [fields.dt_aprovacao.visible && fields.dt_aprovacao.required ? ew.Validators.required(fields.dt_aprovacao.caption) : null], fields.dt_aprovacao.isInvalid],
            ["anexo", [fields.anexo.visible && fields.anexo.required ? ew.Validators.fileRequired(fields.anexo.caption) : null], fields.anexo.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["dt_cadastro",false],["qual_alteracao",false],["status_documento_idstatus_documento",false],["revisao_nr",false],["usuario_elaborador",false],["usuario_aprovador",false],["dt_aprovacao",false],["anexo",false]];
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
            "status_documento_idstatus_documento": <?= $Grid->status_documento_idstatus_documento->toClientList($Grid) ?>,
            "usuario_elaborador": <?= $Grid->usuario_elaborador->toClientList($Grid) ?>,
            "usuario_aprovador": <?= $Grid->usuario_aprovador->toClientList($Grid) ?>,
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
<div id="frevisao_documentogrid" class="ew-form ew-list-form">
<div id="gmp_revisao_documento" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_revisao_documentogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->dt_cadastro->Visible) { // dt_cadastro ?>
        <th data-name="dt_cadastro" class="<?= $Grid->dt_cadastro->headerCellClass() ?>"><div id="elh_revisao_documento_dt_cadastro" class="revisao_documento_dt_cadastro"><?= $Grid->renderFieldHeader($Grid->dt_cadastro) ?></div></th>
<?php } ?>
<?php if ($Grid->qual_alteracao->Visible) { // qual_alteracao ?>
        <th data-name="qual_alteracao" class="<?= $Grid->qual_alteracao->headerCellClass() ?>"><div id="elh_revisao_documento_qual_alteracao" class="revisao_documento_qual_alteracao"><?= $Grid->renderFieldHeader($Grid->qual_alteracao) ?></div></th>
<?php } ?>
<?php if ($Grid->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
        <th data-name="status_documento_idstatus_documento" class="<?= $Grid->status_documento_idstatus_documento->headerCellClass() ?>"><div id="elh_revisao_documento_status_documento_idstatus_documento" class="revisao_documento_status_documento_idstatus_documento"><?= $Grid->renderFieldHeader($Grid->status_documento_idstatus_documento) ?></div></th>
<?php } ?>
<?php if ($Grid->revisao_nr->Visible) { // revisao_nr ?>
        <th data-name="revisao_nr" class="<?= $Grid->revisao_nr->headerCellClass() ?>"><div id="elh_revisao_documento_revisao_nr" class="revisao_documento_revisao_nr"><?= $Grid->renderFieldHeader($Grid->revisao_nr) ?></div></th>
<?php } ?>
<?php if ($Grid->usuario_elaborador->Visible) { // usuario_elaborador ?>
        <th data-name="usuario_elaborador" class="<?= $Grid->usuario_elaborador->headerCellClass() ?>"><div id="elh_revisao_documento_usuario_elaborador" class="revisao_documento_usuario_elaborador"><?= $Grid->renderFieldHeader($Grid->usuario_elaborador) ?></div></th>
<?php } ?>
<?php if ($Grid->usuario_aprovador->Visible) { // usuario_aprovador ?>
        <th data-name="usuario_aprovador" class="<?= $Grid->usuario_aprovador->headerCellClass() ?>"><div id="elh_revisao_documento_usuario_aprovador" class="revisao_documento_usuario_aprovador"><?= $Grid->renderFieldHeader($Grid->usuario_aprovador) ?></div></th>
<?php } ?>
<?php if ($Grid->dt_aprovacao->Visible) { // dt_aprovacao ?>
        <th data-name="dt_aprovacao" class="<?= $Grid->dt_aprovacao->headerCellClass() ?>"><div id="elh_revisao_documento_dt_aprovacao" class="revisao_documento_dt_aprovacao"><?= $Grid->renderFieldHeader($Grid->dt_aprovacao) ?></div></th>
<?php } ?>
<?php if ($Grid->anexo->Visible) { // anexo ?>
        <th data-name="anexo" class="<?= $Grid->anexo->headerCellClass() ?>"><div id="elh_revisao_documento_anexo" class="revisao_documento_anexo"><?= $Grid->renderFieldHeader($Grid->anexo) ?></div></th>
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
    <?php if ($Grid->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro"<?= $Grid->dt_cadastro->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_dt_cadastro" class="el_revisao_documento_dt_cadastro">
<input type="<?= $Grid->dt_cadastro->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dt_cadastro" id="x<?= $Grid->RowIndex ?>_dt_cadastro" data-table="revisao_documento" data-field="x_dt_cadastro" value="<?= $Grid->dt_cadastro->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->dt_cadastro->formatPattern()) ?>"<?= $Grid->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dt_cadastro->getErrorMessage() ?></div>
<?php if (!$Grid->dt_cadastro->ReadOnly && !$Grid->dt_cadastro->Disabled && !isset($Grid->dt_cadastro->EditAttrs["readonly"]) && !isset($Grid->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frevisao_documentogrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frevisao_documentogrid", "x<?= $Grid->RowIndex ?>_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="revisao_documento" data-field="x_dt_cadastro" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_dt_cadastro" id="o<?= $Grid->RowIndex ?>_dt_cadastro" value="<?= HtmlEncode($Grid->dt_cadastro->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_dt_cadastro" class="el_revisao_documento_dt_cadastro">
<input type="<?= $Grid->dt_cadastro->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dt_cadastro" id="x<?= $Grid->RowIndex ?>_dt_cadastro" data-table="revisao_documento" data-field="x_dt_cadastro" value="<?= $Grid->dt_cadastro->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->dt_cadastro->formatPattern()) ?>"<?= $Grid->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dt_cadastro->getErrorMessage() ?></div>
<?php if (!$Grid->dt_cadastro->ReadOnly && !$Grid->dt_cadastro->Disabled && !isset($Grid->dt_cadastro->EditAttrs["readonly"]) && !isset($Grid->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frevisao_documentogrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frevisao_documentogrid", "x<?= $Grid->RowIndex ?>_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_dt_cadastro" class="el_revisao_documento_dt_cadastro">
<span<?= $Grid->dt_cadastro->viewAttributes() ?>>
<?= $Grid->dt_cadastro->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="revisao_documento" data-field="x_dt_cadastro" data-hidden="1" name="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_dt_cadastro" id="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_dt_cadastro" value="<?= HtmlEncode($Grid->dt_cadastro->FormValue) ?>">
<input type="hidden" data-table="revisao_documento" data-field="x_dt_cadastro" data-hidden="1" data-old name="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_dt_cadastro" id="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_dt_cadastro" value="<?= HtmlEncode($Grid->dt_cadastro->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->qual_alteracao->Visible) { // qual_alteracao ?>
        <td data-name="qual_alteracao"<?= $Grid->qual_alteracao->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_qual_alteracao" class="el_revisao_documento_qual_alteracao">
<textarea data-table="revisao_documento" data-field="x_qual_alteracao" name="x<?= $Grid->RowIndex ?>_qual_alteracao" id="x<?= $Grid->RowIndex ?>_qual_alteracao" cols="50" rows="4" placeholder="<?= HtmlEncode($Grid->qual_alteracao->getPlaceHolder()) ?>"<?= $Grid->qual_alteracao->editAttributes() ?>><?= $Grid->qual_alteracao->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->qual_alteracao->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="revisao_documento" data-field="x_qual_alteracao" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_qual_alteracao" id="o<?= $Grid->RowIndex ?>_qual_alteracao" value="<?= HtmlEncode($Grid->qual_alteracao->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_qual_alteracao" class="el_revisao_documento_qual_alteracao">
<textarea data-table="revisao_documento" data-field="x_qual_alteracao" name="x<?= $Grid->RowIndex ?>_qual_alteracao" id="x<?= $Grid->RowIndex ?>_qual_alteracao" cols="50" rows="4" placeholder="<?= HtmlEncode($Grid->qual_alteracao->getPlaceHolder()) ?>"<?= $Grid->qual_alteracao->editAttributes() ?>><?= $Grid->qual_alteracao->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->qual_alteracao->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_qual_alteracao" class="el_revisao_documento_qual_alteracao">
<span<?= $Grid->qual_alteracao->viewAttributes() ?>>
<?= $Grid->qual_alteracao->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="revisao_documento" data-field="x_qual_alteracao" data-hidden="1" name="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_qual_alteracao" id="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_qual_alteracao" value="<?= HtmlEncode($Grid->qual_alteracao->FormValue) ?>">
<input type="hidden" data-table="revisao_documento" data-field="x_qual_alteracao" data-hidden="1" data-old name="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_qual_alteracao" id="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_qual_alteracao" value="<?= HtmlEncode($Grid->qual_alteracao->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
        <td data-name="status_documento_idstatus_documento"<?= $Grid->status_documento_idstatus_documento->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_status_documento_idstatus_documento" class="el_revisao_documento_status_documento_idstatus_documento">
<template id="tp_x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="revisao_documento" data-field="x_status_documento_idstatus_documento" name="x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento" id="x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento"<?= $Grid->status_documento_idstatus_documento->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento"
    name="x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento"
    value="<?= HtmlEncode($Grid->status_documento_idstatus_documento->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status_documento_idstatus_documento->isInvalidClass() ?>"
    data-table="revisao_documento"
    data-field="x_status_documento_idstatus_documento"
    data-value-separator="<?= $Grid->status_documento_idstatus_documento->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status_documento_idstatus_documento->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->status_documento_idstatus_documento->getErrorMessage() ?></div>
<?= $Grid->status_documento_idstatus_documento->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_status_documento_idstatus_documento") ?>
</span>
<input type="hidden" data-table="revisao_documento" data-field="x_status_documento_idstatus_documento" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_status_documento_idstatus_documento" id="o<?= $Grid->RowIndex ?>_status_documento_idstatus_documento" value="<?= HtmlEncode($Grid->status_documento_idstatus_documento->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_status_documento_idstatus_documento" class="el_revisao_documento_status_documento_idstatus_documento">
<span<?= $Grid->status_documento_idstatus_documento->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->status_documento_idstatus_documento->getDisplayValue($Grid->status_documento_idstatus_documento->EditValue) ?></span></span>
<input type="hidden" data-table="revisao_documento" data-field="x_status_documento_idstatus_documento" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento" id="x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento" value="<?= HtmlEncode($Grid->status_documento_idstatus_documento->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_status_documento_idstatus_documento" class="el_revisao_documento_status_documento_idstatus_documento">
<span<?= $Grid->status_documento_idstatus_documento->viewAttributes() ?>>
<?= $Grid->status_documento_idstatus_documento->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="revisao_documento" data-field="x_status_documento_idstatus_documento" data-hidden="1" name="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento" id="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_status_documento_idstatus_documento" value="<?= HtmlEncode($Grid->status_documento_idstatus_documento->FormValue) ?>">
<input type="hidden" data-table="revisao_documento" data-field="x_status_documento_idstatus_documento" data-hidden="1" data-old name="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_status_documento_idstatus_documento" id="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_status_documento_idstatus_documento" value="<?= HtmlEncode($Grid->status_documento_idstatus_documento->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->revisao_nr->Visible) { // revisao_nr ?>
        <td data-name="revisao_nr"<?= $Grid->revisao_nr->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_revisao_nr" class="el_revisao_documento_revisao_nr">
<input type="<?= $Grid->revisao_nr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_revisao_nr" id="x<?= $Grid->RowIndex ?>_revisao_nr" data-table="revisao_documento" data-field="x_revisao_nr" value="<?= $Grid->revisao_nr->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Grid->revisao_nr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->revisao_nr->formatPattern()) ?>"<?= $Grid->revisao_nr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->revisao_nr->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="revisao_documento" data-field="x_revisao_nr" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_revisao_nr" id="o<?= $Grid->RowIndex ?>_revisao_nr" value="<?= HtmlEncode($Grid->revisao_nr->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_revisao_nr" class="el_revisao_documento_revisao_nr">
<input type="<?= $Grid->revisao_nr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_revisao_nr" id="x<?= $Grid->RowIndex ?>_revisao_nr" data-table="revisao_documento" data-field="x_revisao_nr" value="<?= $Grid->revisao_nr->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Grid->revisao_nr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->revisao_nr->formatPattern()) ?>"<?= $Grid->revisao_nr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->revisao_nr->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_revisao_nr" class="el_revisao_documento_revisao_nr">
<span<?= $Grid->revisao_nr->viewAttributes() ?>>
<?= $Grid->revisao_nr->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="revisao_documento" data-field="x_revisao_nr" data-hidden="1" name="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_revisao_nr" id="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_revisao_nr" value="<?= HtmlEncode($Grid->revisao_nr->FormValue) ?>">
<input type="hidden" data-table="revisao_documento" data-field="x_revisao_nr" data-hidden="1" data-old name="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_revisao_nr" id="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_revisao_nr" value="<?= HtmlEncode($Grid->revisao_nr->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->usuario_elaborador->Visible) { // usuario_elaborador ?>
        <td data-name="usuario_elaborador"<?= $Grid->usuario_elaborador->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_usuario_elaborador" class="el_revisao_documento_usuario_elaborador">
    <select
        id="x<?= $Grid->RowIndex ?>_usuario_elaborador"
        name="x<?= $Grid->RowIndex ?>_usuario_elaborador"
        class="form-select ew-select<?= $Grid->usuario_elaborador->isInvalidClass() ?>"
        <?php if (!$Grid->usuario_elaborador->IsNativeSelect) { ?>
        data-select2-id="frevisao_documentogrid_x<?= $Grid->RowIndex ?>_usuario_elaborador"
        <?php } ?>
        data-table="revisao_documento"
        data-field="x_usuario_elaborador"
        data-value-separator="<?= $Grid->usuario_elaborador->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->usuario_elaborador->getPlaceHolder()) ?>"
        <?= $Grid->usuario_elaborador->editAttributes() ?>>
        <?= $Grid->usuario_elaborador->selectOptionListHtml("x{$Grid->RowIndex}_usuario_elaborador") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->usuario_elaborador->getErrorMessage() ?></div>
<?= $Grid->usuario_elaborador->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_usuario_elaborador") ?>
<?php if (!$Grid->usuario_elaborador->IsNativeSelect) { ?>
<script>
loadjs.ready("frevisao_documentogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_usuario_elaborador", selectId: "frevisao_documentogrid_x<?= $Grid->RowIndex ?>_usuario_elaborador" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frevisao_documentogrid.lists.usuario_elaborador?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_usuario_elaborador", form: "frevisao_documentogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_usuario_elaborador", form: "frevisao_documentogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.revisao_documento.fields.usuario_elaborador.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="revisao_documento" data-field="x_usuario_elaborador" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_usuario_elaborador" id="o<?= $Grid->RowIndex ?>_usuario_elaborador" value="<?= HtmlEncode($Grid->usuario_elaborador->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_usuario_elaborador" class="el_revisao_documento_usuario_elaborador">
    <select
        id="x<?= $Grid->RowIndex ?>_usuario_elaborador"
        name="x<?= $Grid->RowIndex ?>_usuario_elaborador"
        class="form-select ew-select<?= $Grid->usuario_elaborador->isInvalidClass() ?>"
        <?php if (!$Grid->usuario_elaborador->IsNativeSelect) { ?>
        data-select2-id="frevisao_documentogrid_x<?= $Grid->RowIndex ?>_usuario_elaborador"
        <?php } ?>
        data-table="revisao_documento"
        data-field="x_usuario_elaborador"
        data-value-separator="<?= $Grid->usuario_elaborador->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->usuario_elaborador->getPlaceHolder()) ?>"
        <?= $Grid->usuario_elaborador->editAttributes() ?>>
        <?= $Grid->usuario_elaborador->selectOptionListHtml("x{$Grid->RowIndex}_usuario_elaborador") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->usuario_elaborador->getErrorMessage() ?></div>
<?= $Grid->usuario_elaborador->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_usuario_elaborador") ?>
<?php if (!$Grid->usuario_elaborador->IsNativeSelect) { ?>
<script>
loadjs.ready("frevisao_documentogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_usuario_elaborador", selectId: "frevisao_documentogrid_x<?= $Grid->RowIndex ?>_usuario_elaborador" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frevisao_documentogrid.lists.usuario_elaborador?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_usuario_elaborador", form: "frevisao_documentogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_usuario_elaborador", form: "frevisao_documentogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.revisao_documento.fields.usuario_elaborador.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_usuario_elaborador" class="el_revisao_documento_usuario_elaborador">
<span<?= $Grid->usuario_elaborador->viewAttributes() ?>>
<?= $Grid->usuario_elaborador->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="revisao_documento" data-field="x_usuario_elaborador" data-hidden="1" name="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_usuario_elaborador" id="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_usuario_elaborador" value="<?= HtmlEncode($Grid->usuario_elaborador->FormValue) ?>">
<input type="hidden" data-table="revisao_documento" data-field="x_usuario_elaborador" data-hidden="1" data-old name="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_usuario_elaborador" id="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_usuario_elaborador" value="<?= HtmlEncode($Grid->usuario_elaborador->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->usuario_aprovador->Visible) { // usuario_aprovador ?>
        <td data-name="usuario_aprovador"<?= $Grid->usuario_aprovador->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_usuario_aprovador" class="el_revisao_documento_usuario_aprovador">
    <select
        id="x<?= $Grid->RowIndex ?>_usuario_aprovador"
        name="x<?= $Grid->RowIndex ?>_usuario_aprovador"
        class="form-select ew-select<?= $Grid->usuario_aprovador->isInvalidClass() ?>"
        <?php if (!$Grid->usuario_aprovador->IsNativeSelect) { ?>
        data-select2-id="frevisao_documentogrid_x<?= $Grid->RowIndex ?>_usuario_aprovador"
        <?php } ?>
        data-table="revisao_documento"
        data-field="x_usuario_aprovador"
        data-value-separator="<?= $Grid->usuario_aprovador->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->usuario_aprovador->getPlaceHolder()) ?>"
        <?= $Grid->usuario_aprovador->editAttributes() ?>>
        <?= $Grid->usuario_aprovador->selectOptionListHtml("x{$Grid->RowIndex}_usuario_aprovador") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->usuario_aprovador->getErrorMessage() ?></div>
<?= $Grid->usuario_aprovador->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_usuario_aprovador") ?>
<?php if (!$Grid->usuario_aprovador->IsNativeSelect) { ?>
<script>
loadjs.ready("frevisao_documentogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_usuario_aprovador", selectId: "frevisao_documentogrid_x<?= $Grid->RowIndex ?>_usuario_aprovador" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frevisao_documentogrid.lists.usuario_aprovador?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_usuario_aprovador", form: "frevisao_documentogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_usuario_aprovador", form: "frevisao_documentogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.revisao_documento.fields.usuario_aprovador.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="revisao_documento" data-field="x_usuario_aprovador" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_usuario_aprovador" id="o<?= $Grid->RowIndex ?>_usuario_aprovador" value="<?= HtmlEncode($Grid->usuario_aprovador->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_usuario_aprovador" class="el_revisao_documento_usuario_aprovador">
    <select
        id="x<?= $Grid->RowIndex ?>_usuario_aprovador"
        name="x<?= $Grid->RowIndex ?>_usuario_aprovador"
        class="form-select ew-select<?= $Grid->usuario_aprovador->isInvalidClass() ?>"
        <?php if (!$Grid->usuario_aprovador->IsNativeSelect) { ?>
        data-select2-id="frevisao_documentogrid_x<?= $Grid->RowIndex ?>_usuario_aprovador"
        <?php } ?>
        data-table="revisao_documento"
        data-field="x_usuario_aprovador"
        data-value-separator="<?= $Grid->usuario_aprovador->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->usuario_aprovador->getPlaceHolder()) ?>"
        <?= $Grid->usuario_aprovador->editAttributes() ?>>
        <?= $Grid->usuario_aprovador->selectOptionListHtml("x{$Grid->RowIndex}_usuario_aprovador") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->usuario_aprovador->getErrorMessage() ?></div>
<?= $Grid->usuario_aprovador->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_usuario_aprovador") ?>
<?php if (!$Grid->usuario_aprovador->IsNativeSelect) { ?>
<script>
loadjs.ready("frevisao_documentogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_usuario_aprovador", selectId: "frevisao_documentogrid_x<?= $Grid->RowIndex ?>_usuario_aprovador" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frevisao_documentogrid.lists.usuario_aprovador?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_usuario_aprovador", form: "frevisao_documentogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_usuario_aprovador", form: "frevisao_documentogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.revisao_documento.fields.usuario_aprovador.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_usuario_aprovador" class="el_revisao_documento_usuario_aprovador">
<span<?= $Grid->usuario_aprovador->viewAttributes() ?>>
<?= $Grid->usuario_aprovador->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="revisao_documento" data-field="x_usuario_aprovador" data-hidden="1" name="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_usuario_aprovador" id="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_usuario_aprovador" value="<?= HtmlEncode($Grid->usuario_aprovador->FormValue) ?>">
<input type="hidden" data-table="revisao_documento" data-field="x_usuario_aprovador" data-hidden="1" data-old name="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_usuario_aprovador" id="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_usuario_aprovador" value="<?= HtmlEncode($Grid->usuario_aprovador->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dt_aprovacao->Visible) { // dt_aprovacao ?>
        <td data-name="dt_aprovacao"<?= $Grid->dt_aprovacao->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_dt_aprovacao" class="el_revisao_documento_dt_aprovacao">
<input type="<?= $Grid->dt_aprovacao->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dt_aprovacao" id="x<?= $Grid->RowIndex ?>_dt_aprovacao" data-table="revisao_documento" data-field="x_dt_aprovacao" value="<?= $Grid->dt_aprovacao->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->dt_aprovacao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->dt_aprovacao->formatPattern()) ?>"<?= $Grid->dt_aprovacao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dt_aprovacao->getErrorMessage() ?></div>
<?php if (!$Grid->dt_aprovacao->ReadOnly && !$Grid->dt_aprovacao->Disabled && !isset($Grid->dt_aprovacao->EditAttrs["readonly"]) && !isset($Grid->dt_aprovacao->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frevisao_documentogrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frevisao_documentogrid", "x<?= $Grid->RowIndex ?>_dt_aprovacao", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="revisao_documento" data-field="x_dt_aprovacao" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_dt_aprovacao" id="o<?= $Grid->RowIndex ?>_dt_aprovacao" value="<?= HtmlEncode($Grid->dt_aprovacao->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_dt_aprovacao" class="el_revisao_documento_dt_aprovacao">
<span<?= $Grid->dt_aprovacao->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->dt_aprovacao->getDisplayValue($Grid->dt_aprovacao->EditValue))) ?>"></span>
<input type="hidden" data-table="revisao_documento" data-field="x_dt_aprovacao" data-hidden="1" name="x<?= $Grid->RowIndex ?>_dt_aprovacao" id="x<?= $Grid->RowIndex ?>_dt_aprovacao" value="<?= HtmlEncode($Grid->dt_aprovacao->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_dt_aprovacao" class="el_revisao_documento_dt_aprovacao">
<span<?= $Grid->dt_aprovacao->viewAttributes() ?>>
<?= $Grid->dt_aprovacao->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="revisao_documento" data-field="x_dt_aprovacao" data-hidden="1" name="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_dt_aprovacao" id="frevisao_documentogrid$x<?= $Grid->RowIndex ?>_dt_aprovacao" value="<?= HtmlEncode($Grid->dt_aprovacao->FormValue) ?>">
<input type="hidden" data-table="revisao_documento" data-field="x_dt_aprovacao" data-hidden="1" data-old name="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_dt_aprovacao" id="frevisao_documentogrid$o<?= $Grid->RowIndex ?>_dt_aprovacao" value="<?= HtmlEncode($Grid->dt_aprovacao->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->anexo->Visible) { // anexo ?>
        <td data-name="anexo"<?= $Grid->anexo->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex ?>_revisao_documento_anexo" class="el_revisao_documento_anexo">
<div id="fd_x<?= $Grid->RowIndex ?>_anexo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_anexo"
        name="x<?= $Grid->RowIndex ?>_anexo"
        class="form-control ew-file-input"
        title="<?= $Grid->anexo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="revisao_documento"
        data-field="x_anexo"
        data-size="120"
        data-accept-file-types="<?= $Grid->anexo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->anexo->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->anexo->ImageCropper ? 0 : 1 ?>"
        <?= ($Grid->anexo->ReadOnly || $Grid->anexo->Disabled) ? " disabled" : "" ?>
        <?= $Grid->anexo->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Grid->anexo->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_anexo" id= "fn_x<?= $Grid->RowIndex ?>_anexo" value="<?= $Grid->anexo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_anexo" id= "fa_x<?= $Grid->RowIndex ?>_anexo" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_anexo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex ?>_revisao_documento_anexo" class="el_revisao_documento_anexo">
<div id="fd_x<?= $Grid->RowIndex ?>_anexo">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_anexo"
        name="x<?= $Grid->RowIndex ?>_anexo"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->anexo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="revisao_documento"
        data-field="x_anexo"
        data-size="120"
        data-accept-file-types="<?= $Grid->anexo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->anexo->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->anexo->ImageCropper ? 0 : 1 ?>"
        <?= $Grid->anexo->editAttributes() ?>
    >
    <div class="invalid-feedback"><?= $Grid->anexo->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_anexo" id= "fn_x<?= $Grid->RowIndex ?>_anexo" value="<?= $Grid->anexo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_anexo" id= "fa_x<?= $Grid->RowIndex ?>_anexo" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_anexo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="revisao_documento" data-field="x_anexo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_anexo" id="o<?= $Grid->RowIndex ?>_anexo" value="<?= HtmlEncode($Grid->anexo->OldValue) ?>">
<?php } elseif ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_anexo" class="el_revisao_documento_anexo">
<span<?= $Grid->anexo->viewAttributes() ?>>
<?= GetFileViewTag($Grid->anexo, $Grid->anexo->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_anexo" class="el_revisao_documento_anexo">
<div id="fd_x<?= $Grid->RowIndex ?>_anexo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_anexo"
        name="x<?= $Grid->RowIndex ?>_anexo"
        class="form-control ew-file-input"
        title="<?= $Grid->anexo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="revisao_documento"
        data-field="x_anexo"
        data-size="120"
        data-accept-file-types="<?= $Grid->anexo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->anexo->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->anexo->ImageCropper ? 0 : 1 ?>"
        <?= ($Grid->anexo->ReadOnly || $Grid->anexo->Disabled) ? " disabled" : "" ?>
        <?= $Grid->anexo->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Grid->anexo->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_anexo" id= "fn_x<?= $Grid->RowIndex ?>_anexo" value="<?= $Grid->anexo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_anexo" id= "fa_x<?= $Grid->RowIndex ?>_anexo" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_anexo") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_anexo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_revisao_documento_anexo" class="el_revisao_documento_anexo">
<div id="fd_x<?= $Grid->RowIndex ?>_anexo">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_anexo"
        name="x<?= $Grid->RowIndex ?>_anexo"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->anexo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="revisao_documento"
        data-field="x_anexo"
        data-size="120"
        data-accept-file-types="<?= $Grid->anexo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->anexo->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->anexo->ImageCropper ? 0 : 1 ?>"
        <?= $Grid->anexo->editAttributes() ?>
    >
    <div class="invalid-feedback"><?= $Grid->anexo->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_anexo" id= "fn_x<?= $Grid->RowIndex ?>_anexo" value="<?= $Grid->anexo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_anexo" id= "fa_x<?= $Grid->RowIndex ?>_anexo" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_anexo") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_anexo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
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
loadjs.ready(["frevisao_documentogrid","load"], () => frevisao_documentogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
    <?php if ($Grid->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro" class="<?= $Grid->dt_cadastro->footerCellClass() ?>"><span id="elf_revisao_documento_dt_cadastro" class="revisao_documento_dt_cadastro">
        </span></td>
    <?php } ?>
    <?php if ($Grid->qual_alteracao->Visible) { // qual_alteracao ?>
        <td data-name="qual_alteracao" class="<?= $Grid->qual_alteracao->footerCellClass() ?>"><span id="elf_revisao_documento_qual_alteracao" class="revisao_documento_qual_alteracao">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Grid->qual_alteracao->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
        <td data-name="status_documento_idstatus_documento" class="<?= $Grid->status_documento_idstatus_documento->footerCellClass() ?>"><span id="elf_revisao_documento_status_documento_idstatus_documento" class="revisao_documento_status_documento_idstatus_documento">
        </span></td>
    <?php } ?>
    <?php if ($Grid->revisao_nr->Visible) { // revisao_nr ?>
        <td data-name="revisao_nr" class="<?= $Grid->revisao_nr->footerCellClass() ?>"><span id="elf_revisao_documento_revisao_nr" class="revisao_documento_revisao_nr">
        </span></td>
    <?php } ?>
    <?php if ($Grid->usuario_elaborador->Visible) { // usuario_elaborador ?>
        <td data-name="usuario_elaborador" class="<?= $Grid->usuario_elaborador->footerCellClass() ?>"><span id="elf_revisao_documento_usuario_elaborador" class="revisao_documento_usuario_elaborador">
        </span></td>
    <?php } ?>
    <?php if ($Grid->usuario_aprovador->Visible) { // usuario_aprovador ?>
        <td data-name="usuario_aprovador" class="<?= $Grid->usuario_aprovador->footerCellClass() ?>"><span id="elf_revisao_documento_usuario_aprovador" class="revisao_documento_usuario_aprovador">
        </span></td>
    <?php } ?>
    <?php if ($Grid->dt_aprovacao->Visible) { // dt_aprovacao ?>
        <td data-name="dt_aprovacao" class="<?= $Grid->dt_aprovacao->footerCellClass() ?>"><span id="elf_revisao_documento_dt_aprovacao" class="revisao_documento_dt_aprovacao">
        </span></td>
    <?php } ?>
    <?php if ($Grid->anexo->Visible) { // anexo ?>
        <td data-name="anexo" class="<?= $Grid->anexo->footerCellClass() ?>"><span id="elf_revisao_documento_anexo" class="revisao_documento_anexo">
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
<input type="hidden" name="detailpage" value="frevisao_documentogrid">
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
    ew.addEventHandlers("revisao_documento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
