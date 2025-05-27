<?php

namespace PHPMaker2024\sgq;

// Set up and run Grid object
$Grid = Container("ItemPlanoAudIntGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fitem_plano_aud_intgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { item_plano_aud_int: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fitem_plano_aud_intgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["iditem_plano_aud_int", [fields.iditem_plano_aud_int.visible && fields.iditem_plano_aud_int.required ? ew.Validators.required(fields.iditem_plano_aud_int.caption) : null], fields.iditem_plano_aud_int.isInvalid],
            ["data", [fields.data.visible && fields.data.required ? ew.Validators.required(fields.data.caption) : null, ew.Validators.datetime(fields.data.clientFormatPattern)], fields.data.isInvalid],
            ["processo_idprocesso", [fields.processo_idprocesso.visible && fields.processo_idprocesso.required ? ew.Validators.required(fields.processo_idprocesso.caption) : null], fields.processo_idprocesso.isInvalid],
            ["escopo", [fields.escopo.visible && fields.escopo.required ? ew.Validators.required(fields.escopo.caption) : null], fields.escopo.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["data",false],["processo_idprocesso",false],["escopo",false],["usuario_idusuario",false]];
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
            "processo_idprocesso": <?= $Grid->processo_idprocesso->toClientList($Grid) ?>,
            "usuario_idusuario": <?= $Grid->usuario_idusuario->toClientList($Grid) ?>,
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
<div id="fitem_plano_aud_intgrid" class="ew-form ew-list-form">
<div id="gmp_item_plano_aud_int" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_item_plano_aud_intgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->iditem_plano_aud_int->Visible) { // iditem_plano_aud_int ?>
        <th data-name="iditem_plano_aud_int" class="<?= $Grid->iditem_plano_aud_int->headerCellClass() ?>"><div id="elh_item_plano_aud_int_iditem_plano_aud_int" class="item_plano_aud_int_iditem_plano_aud_int"><?= $Grid->renderFieldHeader($Grid->iditem_plano_aud_int) ?></div></th>
<?php } ?>
<?php if ($Grid->data->Visible) { // data ?>
        <th data-name="data" class="<?= $Grid->data->headerCellClass() ?>"><div id="elh_item_plano_aud_int_data" class="item_plano_aud_int_data"><?= $Grid->renderFieldHeader($Grid->data) ?></div></th>
<?php } ?>
<?php if ($Grid->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <th data-name="processo_idprocesso" class="<?= $Grid->processo_idprocesso->headerCellClass() ?>"><div id="elh_item_plano_aud_int_processo_idprocesso" class="item_plano_aud_int_processo_idprocesso"><?= $Grid->renderFieldHeader($Grid->processo_idprocesso) ?></div></th>
<?php } ?>
<?php if ($Grid->escopo->Visible) { // escopo ?>
        <th data-name="escopo" class="<?= $Grid->escopo->headerCellClass() ?>"><div id="elh_item_plano_aud_int_escopo" class="item_plano_aud_int_escopo"><?= $Grid->renderFieldHeader($Grid->escopo) ?></div></th>
<?php } ?>
<?php if ($Grid->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th data-name="usuario_idusuario" class="<?= $Grid->usuario_idusuario->headerCellClass() ?>"><div id="elh_item_plano_aud_int_usuario_idusuario" class="item_plano_aud_int_usuario_idusuario"><?= $Grid->renderFieldHeader($Grid->usuario_idusuario) ?></div></th>
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
    <?php if ($Grid->iditem_plano_aud_int->Visible) { // iditem_plano_aud_int ?>
        <td data-name="iditem_plano_aud_int"<?= $Grid->iditem_plano_aud_int->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_iditem_plano_aud_int" class="el_item_plano_aud_int_iditem_plano_aud_int"></span>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_iditem_plano_aud_int" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_iditem_plano_aud_int" id="o<?= $Grid->RowIndex ?>_iditem_plano_aud_int" value="<?= HtmlEncode($Grid->iditem_plano_aud_int->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_iditem_plano_aud_int" class="el_item_plano_aud_int_iditem_plano_aud_int">
<span<?= $Grid->iditem_plano_aud_int->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->iditem_plano_aud_int->getDisplayValue($Grid->iditem_plano_aud_int->EditValue))) ?>"></span>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_iditem_plano_aud_int" data-hidden="1" name="x<?= $Grid->RowIndex ?>_iditem_plano_aud_int" id="x<?= $Grid->RowIndex ?>_iditem_plano_aud_int" value="<?= HtmlEncode($Grid->iditem_plano_aud_int->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_iditem_plano_aud_int" class="el_item_plano_aud_int_iditem_plano_aud_int">
<span<?= $Grid->iditem_plano_aud_int->viewAttributes() ?>>
<?= $Grid->iditem_plano_aud_int->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_iditem_plano_aud_int" data-hidden="1" name="fitem_plano_aud_intgrid$x<?= $Grid->RowIndex ?>_iditem_plano_aud_int" id="fitem_plano_aud_intgrid$x<?= $Grid->RowIndex ?>_iditem_plano_aud_int" value="<?= HtmlEncode($Grid->iditem_plano_aud_int->FormValue) ?>">
<input type="hidden" data-table="item_plano_aud_int" data-field="x_iditem_plano_aud_int" data-hidden="1" data-old name="fitem_plano_aud_intgrid$o<?= $Grid->RowIndex ?>_iditem_plano_aud_int" id="fitem_plano_aud_intgrid$o<?= $Grid->RowIndex ?>_iditem_plano_aud_int" value="<?= HtmlEncode($Grid->iditem_plano_aud_int->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="item_plano_aud_int" data-field="x_iditem_plano_aud_int" data-hidden="1" name="x<?= $Grid->RowIndex ?>_iditem_plano_aud_int" id="x<?= $Grid->RowIndex ?>_iditem_plano_aud_int" value="<?= HtmlEncode($Grid->iditem_plano_aud_int->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->data->Visible) { // data ?>
        <td data-name="data"<?= $Grid->data->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_data" class="el_item_plano_aud_int_data">
<input type="<?= $Grid->data->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_data" id="x<?= $Grid->RowIndex ?>_data" data-table="item_plano_aud_int" data-field="x_data" value="<?= $Grid->data->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->data->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->data->formatPattern()) ?>"<?= $Grid->data->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->data->getErrorMessage() ?></div>
<?php if (!$Grid->data->ReadOnly && !$Grid->data->Disabled && !isset($Grid->data->EditAttrs["readonly"]) && !isset($Grid->data->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fitem_plano_aud_intgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fitem_plano_aud_intgrid", "x<?= $Grid->RowIndex ?>_data", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_data" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_data" id="o<?= $Grid->RowIndex ?>_data" value="<?= HtmlEncode($Grid->data->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_data" class="el_item_plano_aud_int_data">
<input type="<?= $Grid->data->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_data" id="x<?= $Grid->RowIndex ?>_data" data-table="item_plano_aud_int" data-field="x_data" value="<?= $Grid->data->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Grid->data->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->data->formatPattern()) ?>"<?= $Grid->data->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->data->getErrorMessage() ?></div>
<?php if (!$Grid->data->ReadOnly && !$Grid->data->Disabled && !isset($Grid->data->EditAttrs["readonly"]) && !isset($Grid->data->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fitem_plano_aud_intgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fitem_plano_aud_intgrid", "x<?= $Grid->RowIndex ?>_data", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_data" class="el_item_plano_aud_int_data">
<span<?= $Grid->data->viewAttributes() ?>>
<?= $Grid->data->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_data" data-hidden="1" name="fitem_plano_aud_intgrid$x<?= $Grid->RowIndex ?>_data" id="fitem_plano_aud_intgrid$x<?= $Grid->RowIndex ?>_data" value="<?= HtmlEncode($Grid->data->FormValue) ?>">
<input type="hidden" data-table="item_plano_aud_int" data-field="x_data" data-hidden="1" data-old name="fitem_plano_aud_intgrid$o<?= $Grid->RowIndex ?>_data" id="fitem_plano_aud_intgrid$o<?= $Grid->RowIndex ?>_data" value="<?= HtmlEncode($Grid->data->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <td data-name="processo_idprocesso"<?= $Grid->processo_idprocesso->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_processo_idprocesso" class="el_item_plano_aud_int_processo_idprocesso">
    <select
        id="x<?= $Grid->RowIndex ?>_processo_idprocesso"
        name="x<?= $Grid->RowIndex ?>_processo_idprocesso"
        class="form-control ew-select<?= $Grid->processo_idprocesso->isInvalidClass() ?>"
        data-select2-id="fitem_plano_aud_intgrid_x<?= $Grid->RowIndex ?>_processo_idprocesso"
        data-table="item_plano_aud_int"
        data-field="x_processo_idprocesso"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->processo_idprocesso->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->processo_idprocesso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->processo_idprocesso->getPlaceHolder()) ?>"
        <?= $Grid->processo_idprocesso->editAttributes() ?>>
        <?= $Grid->processo_idprocesso->selectOptionListHtml("x{$Grid->RowIndex}_processo_idprocesso") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->processo_idprocesso->getErrorMessage() ?></div>
<?= $Grid->processo_idprocesso->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_processo_idprocesso") ?>
<script>
loadjs.ready("fitem_plano_aud_intgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_processo_idprocesso", selectId: "fitem_plano_aud_intgrid_x<?= $Grid->RowIndex ?>_processo_idprocesso" };
    if (fitem_plano_aud_intgrid.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_processo_idprocesso", form: "fitem_plano_aud_intgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_processo_idprocesso", form: "fitem_plano_aud_intgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.item_plano_aud_int.fields.processo_idprocesso.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_processo_idprocesso" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_processo_idprocesso" id="o<?= $Grid->RowIndex ?>_processo_idprocesso" value="<?= HtmlEncode($Grid->processo_idprocesso->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_processo_idprocesso" class="el_item_plano_aud_int_processo_idprocesso">
    <select
        id="x<?= $Grid->RowIndex ?>_processo_idprocesso"
        name="x<?= $Grid->RowIndex ?>_processo_idprocesso"
        class="form-control ew-select<?= $Grid->processo_idprocesso->isInvalidClass() ?>"
        data-select2-id="fitem_plano_aud_intgrid_x<?= $Grid->RowIndex ?>_processo_idprocesso"
        data-table="item_plano_aud_int"
        data-field="x_processo_idprocesso"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->processo_idprocesso->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->processo_idprocesso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->processo_idprocesso->getPlaceHolder()) ?>"
        <?= $Grid->processo_idprocesso->editAttributes() ?>>
        <?= $Grid->processo_idprocesso->selectOptionListHtml("x{$Grid->RowIndex}_processo_idprocesso") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->processo_idprocesso->getErrorMessage() ?></div>
<?= $Grid->processo_idprocesso->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_processo_idprocesso") ?>
<script>
loadjs.ready("fitem_plano_aud_intgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_processo_idprocesso", selectId: "fitem_plano_aud_intgrid_x<?= $Grid->RowIndex ?>_processo_idprocesso" };
    if (fitem_plano_aud_intgrid.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_processo_idprocesso", form: "fitem_plano_aud_intgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_processo_idprocesso", form: "fitem_plano_aud_intgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.item_plano_aud_int.fields.processo_idprocesso.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_processo_idprocesso" class="el_item_plano_aud_int_processo_idprocesso">
<span<?= $Grid->processo_idprocesso->viewAttributes() ?>>
<?= $Grid->processo_idprocesso->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_processo_idprocesso" data-hidden="1" name="fitem_plano_aud_intgrid$x<?= $Grid->RowIndex ?>_processo_idprocesso" id="fitem_plano_aud_intgrid$x<?= $Grid->RowIndex ?>_processo_idprocesso" value="<?= HtmlEncode($Grid->processo_idprocesso->FormValue) ?>">
<input type="hidden" data-table="item_plano_aud_int" data-field="x_processo_idprocesso" data-hidden="1" data-old name="fitem_plano_aud_intgrid$o<?= $Grid->RowIndex ?>_processo_idprocesso" id="fitem_plano_aud_intgrid$o<?= $Grid->RowIndex ?>_processo_idprocesso" value="<?= HtmlEncode($Grid->processo_idprocesso->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->escopo->Visible) { // escopo ?>
        <td data-name="escopo"<?= $Grid->escopo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_escopo" class="el_item_plano_aud_int_escopo">
<textarea data-table="item_plano_aud_int" data-field="x_escopo" name="x<?= $Grid->RowIndex ?>_escopo" id="x<?= $Grid->RowIndex ?>_escopo" cols="50" rows="2" placeholder="<?= HtmlEncode($Grid->escopo->getPlaceHolder()) ?>"<?= $Grid->escopo->editAttributes() ?>><?= $Grid->escopo->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->escopo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_escopo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_escopo" id="o<?= $Grid->RowIndex ?>_escopo" value="<?= HtmlEncode($Grid->escopo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_escopo" class="el_item_plano_aud_int_escopo">
<textarea data-table="item_plano_aud_int" data-field="x_escopo" name="x<?= $Grid->RowIndex ?>_escopo" id="x<?= $Grid->RowIndex ?>_escopo" cols="50" rows="2" placeholder="<?= HtmlEncode($Grid->escopo->getPlaceHolder()) ?>"<?= $Grid->escopo->editAttributes() ?>><?= $Grid->escopo->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->escopo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_escopo" class="el_item_plano_aud_int_escopo">
<span<?= $Grid->escopo->viewAttributes() ?>>
<?= $Grid->escopo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_escopo" data-hidden="1" name="fitem_plano_aud_intgrid$x<?= $Grid->RowIndex ?>_escopo" id="fitem_plano_aud_intgrid$x<?= $Grid->RowIndex ?>_escopo" value="<?= HtmlEncode($Grid->escopo->FormValue) ?>">
<input type="hidden" data-table="item_plano_aud_int" data-field="x_escopo" data-hidden="1" data-old name="fitem_plano_aud_intgrid$o<?= $Grid->RowIndex ?>_escopo" id="fitem_plano_aud_intgrid$o<?= $Grid->RowIndex ?>_escopo" value="<?= HtmlEncode($Grid->escopo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td data-name="usuario_idusuario"<?= $Grid->usuario_idusuario->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_usuario_idusuario" class="el_item_plano_aud_int_usuario_idusuario">
    <select
        id="x<?= $Grid->RowIndex ?>_usuario_idusuario"
        name="x<?= $Grid->RowIndex ?>_usuario_idusuario"
        class="form-control ew-select<?= $Grid->usuario_idusuario->isInvalidClass() ?>"
        data-select2-id="fitem_plano_aud_intgrid_x<?= $Grid->RowIndex ?>_usuario_idusuario"
        data-table="item_plano_aud_int"
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
loadjs.ready("fitem_plano_aud_intgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_usuario_idusuario", selectId: "fitem_plano_aud_intgrid_x<?= $Grid->RowIndex ?>_usuario_idusuario" };
    if (fitem_plano_aud_intgrid.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_usuario_idusuario", form: "fitem_plano_aud_intgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_usuario_idusuario", form: "fitem_plano_aud_intgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.item_plano_aud_int.fields.usuario_idusuario.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_usuario_idusuario" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_usuario_idusuario" id="o<?= $Grid->RowIndex ?>_usuario_idusuario" value="<?= HtmlEncode($Grid->usuario_idusuario->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_usuario_idusuario" class="el_item_plano_aud_int_usuario_idusuario">
    <select
        id="x<?= $Grid->RowIndex ?>_usuario_idusuario"
        name="x<?= $Grid->RowIndex ?>_usuario_idusuario"
        class="form-control ew-select<?= $Grid->usuario_idusuario->isInvalidClass() ?>"
        data-select2-id="fitem_plano_aud_intgrid_x<?= $Grid->RowIndex ?>_usuario_idusuario"
        data-table="item_plano_aud_int"
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
loadjs.ready("fitem_plano_aud_intgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_usuario_idusuario", selectId: "fitem_plano_aud_intgrid_x<?= $Grid->RowIndex ?>_usuario_idusuario" };
    if (fitem_plano_aud_intgrid.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_usuario_idusuario", form: "fitem_plano_aud_intgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_usuario_idusuario", form: "fitem_plano_aud_intgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.item_plano_aud_int.fields.usuario_idusuario.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_plano_aud_int_usuario_idusuario" class="el_item_plano_aud_int_usuario_idusuario">
<span<?= $Grid->usuario_idusuario->viewAttributes() ?>>
<?= $Grid->usuario_idusuario->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_usuario_idusuario" data-hidden="1" name="fitem_plano_aud_intgrid$x<?= $Grid->RowIndex ?>_usuario_idusuario" id="fitem_plano_aud_intgrid$x<?= $Grid->RowIndex ?>_usuario_idusuario" value="<?= HtmlEncode($Grid->usuario_idusuario->FormValue) ?>">
<input type="hidden" data-table="item_plano_aud_int" data-field="x_usuario_idusuario" data-hidden="1" data-old name="fitem_plano_aud_intgrid$o<?= $Grid->RowIndex ?>_usuario_idusuario" id="fitem_plano_aud_intgrid$o<?= $Grid->RowIndex ?>_usuario_idusuario" value="<?= HtmlEncode($Grid->usuario_idusuario->OldValue) ?>">
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
loadjs.ready(["fitem_plano_aud_intgrid","load"], () => fitem_plano_aud_intgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fitem_plano_aud_intgrid">
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
    ew.addEventHandlers("item_plano_aud_int");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
