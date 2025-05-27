<?php

namespace PHPMaker2024\sgq;

// Set up and run Grid object
$Grid = Container("RelatorioAudIntGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var frelatorio_aud_intgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { relatorio_aud_int: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frelatorio_aud_intgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["plano_auditoria_int_idplano_auditoria_int", [fields.plano_auditoria_int_idplano_auditoria_int.visible && fields.plano_auditoria_int_idplano_auditoria_int.required ? ew.Validators.required(fields.plano_auditoria_int_idplano_auditoria_int.caption) : null], fields.plano_auditoria_int_idplano_auditoria_int.isInvalid],
            ["item_plano_aud_int_iditem_plano_aud_int", [fields.item_plano_aud_int_iditem_plano_aud_int.visible && fields.item_plano_aud_int_iditem_plano_aud_int.required ? ew.Validators.required(fields.item_plano_aud_int_iditem_plano_aud_int.caption) : null, ew.Validators.integer], fields.item_plano_aud_int_iditem_plano_aud_int.isInvalid],
            ["metodo", [fields.metodo.visible && fields.metodo.required ? ew.Validators.required(fields.metodo.caption) : null], fields.metodo.isInvalid],
            ["descricao", [fields.descricao.visible && fields.descricao.required ? ew.Validators.required(fields.descricao.caption) : null], fields.descricao.isInvalid],
            ["evidencia", [fields.evidencia.visible && fields.evidencia.required ? ew.Validators.required(fields.evidencia.caption) : null], fields.evidencia.isInvalid],
            ["nao_conformidade", [fields.nao_conformidade.visible && fields.nao_conformidade.required ? ew.Validators.required(fields.nao_conformidade.caption) : null], fields.nao_conformidade.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["plano_auditoria_int_idplano_auditoria_int",false],["item_plano_aud_int_iditem_plano_aud_int",false],["metodo",false],["descricao",false],["evidencia",false],["nao_conformidade",false]];
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
            "plano_auditoria_int_idplano_auditoria_int": <?= $Grid->plano_auditoria_int_idplano_auditoria_int->toClientList($Grid) ?>,
            "item_plano_aud_int_iditem_plano_aud_int": <?= $Grid->item_plano_aud_int_iditem_plano_aud_int->toClientList($Grid) ?>,
            "metodo": <?= $Grid->metodo->toClientList($Grid) ?>,
            "nao_conformidade": <?= $Grid->nao_conformidade->toClientList($Grid) ?>,
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
<div id="frelatorio_aud_intgrid" class="ew-form ew-list-form">
<div id="gmp_relatorio_aud_int" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_relatorio_aud_intgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->plano_auditoria_int_idplano_auditoria_int->Visible) { // plano_auditoria_int_idplano_auditoria_int ?>
        <th data-name="plano_auditoria_int_idplano_auditoria_int" class="<?= $Grid->plano_auditoria_int_idplano_auditoria_int->headerCellClass() ?>"><div id="elh_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int" class="relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int"><?= $Grid->renderFieldHeader($Grid->plano_auditoria_int_idplano_auditoria_int) ?></div></th>
<?php } ?>
<?php if ($Grid->item_plano_aud_int_iditem_plano_aud_int->Visible) { // item_plano_aud_int_iditem_plano_aud_int ?>
        <th data-name="item_plano_aud_int_iditem_plano_aud_int" class="<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->headerCellClass() ?>"><div id="elh_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int" class="relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int"><?= $Grid->renderFieldHeader($Grid->item_plano_aud_int_iditem_plano_aud_int) ?></div></th>
<?php } ?>
<?php if ($Grid->metodo->Visible) { // metodo ?>
        <th data-name="metodo" class="<?= $Grid->metodo->headerCellClass() ?>"><div id="elh_relatorio_aud_int_metodo" class="relatorio_aud_int_metodo"><?= $Grid->renderFieldHeader($Grid->metodo) ?></div></th>
<?php } ?>
<?php if ($Grid->descricao->Visible) { // descricao ?>
        <th data-name="descricao" class="<?= $Grid->descricao->headerCellClass() ?>"><div id="elh_relatorio_aud_int_descricao" class="relatorio_aud_int_descricao"><?= $Grid->renderFieldHeader($Grid->descricao) ?></div></th>
<?php } ?>
<?php if ($Grid->evidencia->Visible) { // evidencia ?>
        <th data-name="evidencia" class="<?= $Grid->evidencia->headerCellClass() ?>"><div id="elh_relatorio_aud_int_evidencia" class="relatorio_aud_int_evidencia"><?= $Grid->renderFieldHeader($Grid->evidencia) ?></div></th>
<?php } ?>
<?php if ($Grid->nao_conformidade->Visible) { // nao_conformidade ?>
        <th data-name="nao_conformidade" class="<?= $Grid->nao_conformidade->headerCellClass() ?>"><div id="elh_relatorio_aud_int_nao_conformidade" class="relatorio_aud_int_nao_conformidade"><?= $Grid->renderFieldHeader($Grid->nao_conformidade) ?></div></th>
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
    <?php if ($Grid->plano_auditoria_int_idplano_auditoria_int->Visible) { // plano_auditoria_int_idplano_auditoria_int ?>
        <td data-name="plano_auditoria_int_idplano_auditoria_int"<?= $Grid->plano_auditoria_int_idplano_auditoria_int->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int" class="el_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int">
    <select
        id="x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int"
        name="x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int"
        class="form-control ew-select<?= $Grid->plano_auditoria_int_idplano_auditoria_int->isInvalidClass() ?>"
        data-select2-id="frelatorio_aud_intgrid_x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int"
        data-table="relatorio_aud_int"
        data-field="x_plano_auditoria_int_idplano_auditoria_int"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->plano_auditoria_int_idplano_auditoria_int->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->plano_auditoria_int_idplano_auditoria_int->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->plano_auditoria_int_idplano_auditoria_int->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Grid->plano_auditoria_int_idplano_auditoria_int->editAttributes() ?>>
        <?= $Grid->plano_auditoria_int_idplano_auditoria_int->selectOptionListHtml("x{$Grid->RowIndex}_plano_auditoria_int_idplano_auditoria_int") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->plano_auditoria_int_idplano_auditoria_int->getErrorMessage() ?></div>
<?= $Grid->plano_auditoria_int_idplano_auditoria_int->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_plano_auditoria_int_idplano_auditoria_int") ?>
<script>
loadjs.ready("frelatorio_aud_intgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int", selectId: "frelatorio_aud_intgrid_x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int" };
    if (frelatorio_aud_intgrid.lists.plano_auditoria_int_idplano_auditoria_int?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int", form: "frelatorio_aud_intgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int", form: "frelatorio_aud_intgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.relatorio_aud_int.fields.plano_auditoria_int_idplano_auditoria_int.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_plano_auditoria_int_idplano_auditoria_int" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int" id="o<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int" value="<?= HtmlEncode($Grid->plano_auditoria_int_idplano_auditoria_int->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int" class="el_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int">
    <select
        id="x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int"
        name="x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int"
        class="form-control ew-select<?= $Grid->plano_auditoria_int_idplano_auditoria_int->isInvalidClass() ?>"
        data-select2-id="frelatorio_aud_intgrid_x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int"
        data-table="relatorio_aud_int"
        data-field="x_plano_auditoria_int_idplano_auditoria_int"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->plano_auditoria_int_idplano_auditoria_int->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->plano_auditoria_int_idplano_auditoria_int->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->plano_auditoria_int_idplano_auditoria_int->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Grid->plano_auditoria_int_idplano_auditoria_int->editAttributes() ?>>
        <?= $Grid->plano_auditoria_int_idplano_auditoria_int->selectOptionListHtml("x{$Grid->RowIndex}_plano_auditoria_int_idplano_auditoria_int") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->plano_auditoria_int_idplano_auditoria_int->getErrorMessage() ?></div>
<?= $Grid->plano_auditoria_int_idplano_auditoria_int->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_plano_auditoria_int_idplano_auditoria_int") ?>
<script>
loadjs.ready("frelatorio_aud_intgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int", selectId: "frelatorio_aud_intgrid_x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int" };
    if (frelatorio_aud_intgrid.lists.plano_auditoria_int_idplano_auditoria_int?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int", form: "frelatorio_aud_intgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int", form: "frelatorio_aud_intgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.relatorio_aud_int.fields.plano_auditoria_int_idplano_auditoria_int.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int" class="el_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int">
<span<?= $Grid->plano_auditoria_int_idplano_auditoria_int->viewAttributes() ?>>
<?= $Grid->plano_auditoria_int_idplano_auditoria_int->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_plano_auditoria_int_idplano_auditoria_int" data-hidden="1" name="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int" id="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int" value="<?= HtmlEncode($Grid->plano_auditoria_int_idplano_auditoria_int->FormValue) ?>">
<input type="hidden" data-table="relatorio_aud_int" data-field="x_plano_auditoria_int_idplano_auditoria_int" data-hidden="1" data-old name="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int" id="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_plano_auditoria_int_idplano_auditoria_int" value="<?= HtmlEncode($Grid->plano_auditoria_int_idplano_auditoria_int->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->item_plano_aud_int_iditem_plano_aud_int->Visible) { // item_plano_aud_int_iditem_plano_aud_int ?>
        <td data-name="item_plano_aud_int_iditem_plano_aud_int"<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->item_plano_aud_int_iditem_plano_aud_int->getSessionValue() != "") { ?>
<span<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->item_plano_aud_int_iditem_plano_aud_int->getDisplayValue($Grid->item_plano_aud_int_iditem_plano_aud_int->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" name="x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" value="<?= HtmlEncode($Grid->item_plano_aud_int_iditem_plano_aud_int->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int" class="el_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int">
    <select
        id="x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int"
        name="x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int"
        class="form-control ew-select<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->isInvalidClass() ?>"
        data-select2-id="frelatorio_aud_intgrid_x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int"
        data-table="relatorio_aud_int"
        data-field="x_item_plano_aud_int_iditem_plano_aud_int"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->item_plano_aud_int_iditem_plano_aud_int->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->item_plano_aud_int_iditem_plano_aud_int->getPlaceHolder()) ?>"
        <?= $Grid->item_plano_aud_int_iditem_plano_aud_int->editAttributes() ?>>
        <?= $Grid->item_plano_aud_int_iditem_plano_aud_int->selectOptionListHtml("x{$Grid->RowIndex}_item_plano_aud_int_iditem_plano_aud_int") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->item_plano_aud_int_iditem_plano_aud_int->getErrorMessage() ?></div>
<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_item_plano_aud_int_iditem_plano_aud_int") ?>
<script>
loadjs.ready("frelatorio_aud_intgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int", selectId: "frelatorio_aud_intgrid_x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" };
    if (frelatorio_aud_intgrid.lists.item_plano_aud_int_iditem_plano_aud_int?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int", form: "frelatorio_aud_intgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int", form: "frelatorio_aud_intgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.relatorio_aud_int.fields.item_plano_aud_int_iditem_plano_aud_int.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_item_plano_aud_int_iditem_plano_aud_int" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" id="o<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" value="<?= HtmlEncode($Grid->item_plano_aud_int_iditem_plano_aud_int->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->item_plano_aud_int_iditem_plano_aud_int->getSessionValue() != "") { ?>
<span<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->item_plano_aud_int_iditem_plano_aud_int->getDisplayValue($Grid->item_plano_aud_int_iditem_plano_aud_int->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" name="x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" value="<?= HtmlEncode($Grid->item_plano_aud_int_iditem_plano_aud_int->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int" class="el_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int">
    <select
        id="x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int"
        name="x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int"
        class="form-control ew-select<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->isInvalidClass() ?>"
        data-select2-id="frelatorio_aud_intgrid_x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int"
        data-table="relatorio_aud_int"
        data-field="x_item_plano_aud_int_iditem_plano_aud_int"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->item_plano_aud_int_iditem_plano_aud_int->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->item_plano_aud_int_iditem_plano_aud_int->getPlaceHolder()) ?>"
        <?= $Grid->item_plano_aud_int_iditem_plano_aud_int->editAttributes() ?>>
        <?= $Grid->item_plano_aud_int_iditem_plano_aud_int->selectOptionListHtml("x{$Grid->RowIndex}_item_plano_aud_int_iditem_plano_aud_int") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->item_plano_aud_int_iditem_plano_aud_int->getErrorMessage() ?></div>
<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_item_plano_aud_int_iditem_plano_aud_int") ?>
<script>
loadjs.ready("frelatorio_aud_intgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int", selectId: "frelatorio_aud_intgrid_x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" };
    if (frelatorio_aud_intgrid.lists.item_plano_aud_int_iditem_plano_aud_int?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int", form: "frelatorio_aud_intgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int", form: "frelatorio_aud_intgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.relatorio_aud_int.fields.item_plano_aud_int_iditem_plano_aud_int.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int" class="el_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int">
<span<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->viewAttributes() ?>>
<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_item_plano_aud_int_iditem_plano_aud_int" data-hidden="1" name="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" id="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" value="<?= HtmlEncode($Grid->item_plano_aud_int_iditem_plano_aud_int->FormValue) ?>">
<input type="hidden" data-table="relatorio_aud_int" data-field="x_item_plano_aud_int_iditem_plano_aud_int" data-hidden="1" data-old name="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" id="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_item_plano_aud_int_iditem_plano_aud_int" value="<?= HtmlEncode($Grid->item_plano_aud_int_iditem_plano_aud_int->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->metodo->Visible) { // metodo ?>
        <td data-name="metodo"<?= $Grid->metodo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_metodo" class="el_relatorio_aud_int_metodo">
<template id="tp_x<?= $Grid->RowIndex ?>_metodo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="relatorio_aud_int" data-field="x_metodo" name="x<?= $Grid->RowIndex ?>_metodo" id="x<?= $Grid->RowIndex ?>_metodo"<?= $Grid->metodo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_metodo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_metodo"
    name="x<?= $Grid->RowIndex ?>_metodo"
    value="<?= HtmlEncode($Grid->metodo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_metodo"
    data-target="dsl_x<?= $Grid->RowIndex ?>_metodo"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->metodo->isInvalidClass() ?>"
    data-table="relatorio_aud_int"
    data-field="x_metodo"
    data-value-separator="<?= $Grid->metodo->displayValueSeparatorAttribute() ?>"
    <?= $Grid->metodo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->metodo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_metodo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_metodo" id="o<?= $Grid->RowIndex ?>_metodo" value="<?= HtmlEncode($Grid->metodo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_metodo" class="el_relatorio_aud_int_metodo">
<template id="tp_x<?= $Grid->RowIndex ?>_metodo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="relatorio_aud_int" data-field="x_metodo" name="x<?= $Grid->RowIndex ?>_metodo" id="x<?= $Grid->RowIndex ?>_metodo"<?= $Grid->metodo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_metodo" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_metodo"
    name="x<?= $Grid->RowIndex ?>_metodo"
    value="<?= HtmlEncode($Grid->metodo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_metodo"
    data-target="dsl_x<?= $Grid->RowIndex ?>_metodo"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->metodo->isInvalidClass() ?>"
    data-table="relatorio_aud_int"
    data-field="x_metodo"
    data-value-separator="<?= $Grid->metodo->displayValueSeparatorAttribute() ?>"
    <?= $Grid->metodo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->metodo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_metodo" class="el_relatorio_aud_int_metodo">
<span<?= $Grid->metodo->viewAttributes() ?>>
<?= $Grid->metodo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_metodo" data-hidden="1" name="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_metodo" id="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_metodo" value="<?= HtmlEncode($Grid->metodo->FormValue) ?>">
<input type="hidden" data-table="relatorio_aud_int" data-field="x_metodo" data-hidden="1" data-old name="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_metodo" id="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_metodo" value="<?= HtmlEncode($Grid->metodo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->descricao->Visible) { // descricao ?>
        <td data-name="descricao"<?= $Grid->descricao->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_descricao" class="el_relatorio_aud_int_descricao">
<textarea data-table="relatorio_aud_int" data-field="x_descricao" name="x<?= $Grid->RowIndex ?>_descricao" id="x<?= $Grid->RowIndex ?>_descricao" cols="50" rows="2" placeholder="<?= HtmlEncode($Grid->descricao->getPlaceHolder()) ?>"<?= $Grid->descricao->editAttributes() ?>><?= $Grid->descricao->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->descricao->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_descricao" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_descricao" id="o<?= $Grid->RowIndex ?>_descricao" value="<?= HtmlEncode($Grid->descricao->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_descricao" class="el_relatorio_aud_int_descricao">
<textarea data-table="relatorio_aud_int" data-field="x_descricao" name="x<?= $Grid->RowIndex ?>_descricao" id="x<?= $Grid->RowIndex ?>_descricao" cols="50" rows="2" placeholder="<?= HtmlEncode($Grid->descricao->getPlaceHolder()) ?>"<?= $Grid->descricao->editAttributes() ?>><?= $Grid->descricao->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->descricao->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_descricao" class="el_relatorio_aud_int_descricao">
<span<?= $Grid->descricao->viewAttributes() ?>>
<?= $Grid->descricao->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_descricao" data-hidden="1" name="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_descricao" id="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_descricao" value="<?= HtmlEncode($Grid->descricao->FormValue) ?>">
<input type="hidden" data-table="relatorio_aud_int" data-field="x_descricao" data-hidden="1" data-old name="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_descricao" id="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_descricao" value="<?= HtmlEncode($Grid->descricao->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->evidencia->Visible) { // evidencia ?>
        <td data-name="evidencia"<?= $Grid->evidencia->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_evidencia" class="el_relatorio_aud_int_evidencia">
<textarea data-table="relatorio_aud_int" data-field="x_evidencia" name="x<?= $Grid->RowIndex ?>_evidencia" id="x<?= $Grid->RowIndex ?>_evidencia" cols="50" rows="2" placeholder="<?= HtmlEncode($Grid->evidencia->getPlaceHolder()) ?>"<?= $Grid->evidencia->editAttributes() ?>><?= $Grid->evidencia->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->evidencia->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_evidencia" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_evidencia" id="o<?= $Grid->RowIndex ?>_evidencia" value="<?= HtmlEncode($Grid->evidencia->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_evidencia" class="el_relatorio_aud_int_evidencia">
<textarea data-table="relatorio_aud_int" data-field="x_evidencia" name="x<?= $Grid->RowIndex ?>_evidencia" id="x<?= $Grid->RowIndex ?>_evidencia" cols="50" rows="2" placeholder="<?= HtmlEncode($Grid->evidencia->getPlaceHolder()) ?>"<?= $Grid->evidencia->editAttributes() ?>><?= $Grid->evidencia->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->evidencia->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_evidencia" class="el_relatorio_aud_int_evidencia">
<span<?= $Grid->evidencia->viewAttributes() ?>>
<?= $Grid->evidencia->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_evidencia" data-hidden="1" name="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_evidencia" id="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_evidencia" value="<?= HtmlEncode($Grid->evidencia->FormValue) ?>">
<input type="hidden" data-table="relatorio_aud_int" data-field="x_evidencia" data-hidden="1" data-old name="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_evidencia" id="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_evidencia" value="<?= HtmlEncode($Grid->evidencia->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nao_conformidade->Visible) { // nao_conformidade ?>
        <td data-name="nao_conformidade"<?= $Grid->nao_conformidade->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_nao_conformidade" class="el_relatorio_aud_int_nao_conformidade">
<template id="tp_x<?= $Grid->RowIndex ?>_nao_conformidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="relatorio_aud_int" data-field="x_nao_conformidade" name="x<?= $Grid->RowIndex ?>_nao_conformidade" id="x<?= $Grid->RowIndex ?>_nao_conformidade"<?= $Grid->nao_conformidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_nao_conformidade" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_nao_conformidade"
    name="x<?= $Grid->RowIndex ?>_nao_conformidade"
    value="<?= HtmlEncode($Grid->nao_conformidade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_nao_conformidade"
    data-target="dsl_x<?= $Grid->RowIndex ?>_nao_conformidade"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->nao_conformidade->isInvalidClass() ?>"
    data-table="relatorio_aud_int"
    data-field="x_nao_conformidade"
    data-value-separator="<?= $Grid->nao_conformidade->displayValueSeparatorAttribute() ?>"
    <?= $Grid->nao_conformidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->nao_conformidade->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_nao_conformidade" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nao_conformidade" id="o<?= $Grid->RowIndex ?>_nao_conformidade" value="<?= HtmlEncode($Grid->nao_conformidade->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_nao_conformidade" class="el_relatorio_aud_int_nao_conformidade">
<template id="tp_x<?= $Grid->RowIndex ?>_nao_conformidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="relatorio_aud_int" data-field="x_nao_conformidade" name="x<?= $Grid->RowIndex ?>_nao_conformidade" id="x<?= $Grid->RowIndex ?>_nao_conformidade"<?= $Grid->nao_conformidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_nao_conformidade" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_nao_conformidade"
    name="x<?= $Grid->RowIndex ?>_nao_conformidade"
    value="<?= HtmlEncode($Grid->nao_conformidade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_nao_conformidade"
    data-target="dsl_x<?= $Grid->RowIndex ?>_nao_conformidade"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->nao_conformidade->isInvalidClass() ?>"
    data-table="relatorio_aud_int"
    data-field="x_nao_conformidade"
    data-value-separator="<?= $Grid->nao_conformidade->displayValueSeparatorAttribute() ?>"
    <?= $Grid->nao_conformidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->nao_conformidade->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_relatorio_aud_int_nao_conformidade" class="el_relatorio_aud_int_nao_conformidade">
<span<?= $Grid->nao_conformidade->viewAttributes() ?>>
<?= $Grid->nao_conformidade->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="relatorio_aud_int" data-field="x_nao_conformidade" data-hidden="1" name="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_nao_conformidade" id="frelatorio_aud_intgrid$x<?= $Grid->RowIndex ?>_nao_conformidade" value="<?= HtmlEncode($Grid->nao_conformidade->FormValue) ?>">
<input type="hidden" data-table="relatorio_aud_int" data-field="x_nao_conformidade" data-hidden="1" data-old name="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_nao_conformidade" id="frelatorio_aud_intgrid$o<?= $Grid->RowIndex ?>_nao_conformidade" value="<?= HtmlEncode($Grid->nao_conformidade->OldValue) ?>">
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
loadjs.ready(["frelatorio_aud_intgrid","load"], () => frelatorio_aud_intgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
    <?php if ($Grid->plano_auditoria_int_idplano_auditoria_int->Visible) { // plano_auditoria_int_idplano_auditoria_int ?>
        <td data-name="plano_auditoria_int_idplano_auditoria_int" class="<?= $Grid->plano_auditoria_int_idplano_auditoria_int->footerCellClass() ?>"><span id="elf_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int" class="relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int">
        </span></td>
    <?php } ?>
    <?php if ($Grid->item_plano_aud_int_iditem_plano_aud_int->Visible) { // item_plano_aud_int_iditem_plano_aud_int ?>
        <td data-name="item_plano_aud_int_iditem_plano_aud_int" class="<?= $Grid->item_plano_aud_int_iditem_plano_aud_int->footerCellClass() ?>"><span id="elf_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int" class="relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int">
        </span></td>
    <?php } ?>
    <?php if ($Grid->metodo->Visible) { // metodo ?>
        <td data-name="metodo" class="<?= $Grid->metodo->footerCellClass() ?>"><span id="elf_relatorio_aud_int_metodo" class="relatorio_aud_int_metodo">
        </span></td>
    <?php } ?>
    <?php if ($Grid->descricao->Visible) { // descricao ?>
        <td data-name="descricao" class="<?= $Grid->descricao->footerCellClass() ?>"><span id="elf_relatorio_aud_int_descricao" class="relatorio_aud_int_descricao">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Grid->descricao->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->evidencia->Visible) { // evidencia ?>
        <td data-name="evidencia" class="<?= $Grid->evidencia->footerCellClass() ?>"><span id="elf_relatorio_aud_int_evidencia" class="relatorio_aud_int_evidencia">
        </span></td>
    <?php } ?>
    <?php if ($Grid->nao_conformidade->Visible) { // nao_conformidade ?>
        <td data-name="nao_conformidade" class="<?= $Grid->nao_conformidade->footerCellClass() ?>"><span id="elf_relatorio_aud_int_nao_conformidade" class="relatorio_aud_int_nao_conformidade">
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
<input type="hidden" name="detailpage" value="frelatorio_aud_intgrid">
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
    ew.addEventHandlers("relatorio_aud_int");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
