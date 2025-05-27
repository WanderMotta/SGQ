<?php

namespace PHPMaker2024\sgq;

// Set up and run Grid object
$Grid = Container("ItemRelAudInternaGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fitem_rel_aud_internagrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { item_rel_aud_interna: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fitem_rel_aud_internagrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["iditem_rel_aud_interna", [fields.iditem_rel_aud_interna.visible && fields.iditem_rel_aud_interna.required ? ew.Validators.required(fields.iditem_rel_aud_interna.caption) : null], fields.iditem_rel_aud_interna.isInvalid],
            ["processo_idprocesso", [fields.processo_idprocesso.visible && fields.processo_idprocesso.required ? ew.Validators.required(fields.processo_idprocesso.caption) : null], fields.processo_idprocesso.isInvalid],
            ["descricao", [fields.descricao.visible && fields.descricao.required ? ew.Validators.required(fields.descricao.caption) : null], fields.descricao.isInvalid],
            ["acao_imediata", [fields.acao_imediata.visible && fields.acao_imediata.required ? ew.Validators.required(fields.acao_imediata.caption) : null], fields.acao_imediata.isInvalid],
            ["acao_contecao", [fields.acao_contecao.visible && fields.acao_contecao.required ? ew.Validators.required(fields.acao_contecao.caption) : null], fields.acao_contecao.isInvalid],
            ["abrir_nc", [fields.abrir_nc.visible && fields.abrir_nc.required ? ew.Validators.required(fields.abrir_nc.caption) : null], fields.abrir_nc.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["processo_idprocesso",false],["descricao",false],["acao_imediata",false],["acao_contecao",false],["abrir_nc",false]];
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
            "abrir_nc": <?= $Grid->abrir_nc->toClientList($Grid) ?>,
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
<div id="fitem_rel_aud_internagrid" class="ew-form ew-list-form">
<div id="gmp_item_rel_aud_interna" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_item_rel_aud_internagrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->iditem_rel_aud_interna->Visible) { // iditem_rel_aud_interna ?>
        <th data-name="iditem_rel_aud_interna" class="<?= $Grid->iditem_rel_aud_interna->headerCellClass() ?>"><div id="elh_item_rel_aud_interna_iditem_rel_aud_interna" class="item_rel_aud_interna_iditem_rel_aud_interna"><?= $Grid->renderFieldHeader($Grid->iditem_rel_aud_interna) ?></div></th>
<?php } ?>
<?php if ($Grid->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <th data-name="processo_idprocesso" class="<?= $Grid->processo_idprocesso->headerCellClass() ?>"><div id="elh_item_rel_aud_interna_processo_idprocesso" class="item_rel_aud_interna_processo_idprocesso"><?= $Grid->renderFieldHeader($Grid->processo_idprocesso) ?></div></th>
<?php } ?>
<?php if ($Grid->descricao->Visible) { // descricao ?>
        <th data-name="descricao" class="<?= $Grid->descricao->headerCellClass() ?>"><div id="elh_item_rel_aud_interna_descricao" class="item_rel_aud_interna_descricao"><?= $Grid->renderFieldHeader($Grid->descricao) ?></div></th>
<?php } ?>
<?php if ($Grid->acao_imediata->Visible) { // acao_imediata ?>
        <th data-name="acao_imediata" class="<?= $Grid->acao_imediata->headerCellClass() ?>"><div id="elh_item_rel_aud_interna_acao_imediata" class="item_rel_aud_interna_acao_imediata"><?= $Grid->renderFieldHeader($Grid->acao_imediata) ?></div></th>
<?php } ?>
<?php if ($Grid->acao_contecao->Visible) { // acao_contecao ?>
        <th data-name="acao_contecao" class="<?= $Grid->acao_contecao->headerCellClass() ?>"><div id="elh_item_rel_aud_interna_acao_contecao" class="item_rel_aud_interna_acao_contecao"><?= $Grid->renderFieldHeader($Grid->acao_contecao) ?></div></th>
<?php } ?>
<?php if ($Grid->abrir_nc->Visible) { // abrir_nc ?>
        <th data-name="abrir_nc" class="<?= $Grid->abrir_nc->headerCellClass() ?>"><div id="elh_item_rel_aud_interna_abrir_nc" class="item_rel_aud_interna_abrir_nc"><?= $Grid->renderFieldHeader($Grid->abrir_nc) ?></div></th>
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
    <?php if ($Grid->iditem_rel_aud_interna->Visible) { // iditem_rel_aud_interna ?>
        <td data-name="iditem_rel_aud_interna"<?= $Grid->iditem_rel_aud_interna->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_iditem_rel_aud_interna" class="el_item_rel_aud_interna_iditem_rel_aud_interna"></span>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_iditem_rel_aud_interna" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_iditem_rel_aud_interna" id="o<?= $Grid->RowIndex ?>_iditem_rel_aud_interna" value="<?= HtmlEncode($Grid->iditem_rel_aud_interna->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_iditem_rel_aud_interna" class="el_item_rel_aud_interna_iditem_rel_aud_interna">
<span<?= $Grid->iditem_rel_aud_interna->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->iditem_rel_aud_interna->getDisplayValue($Grid->iditem_rel_aud_interna->EditValue))) ?>"></span>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_iditem_rel_aud_interna" data-hidden="1" name="x<?= $Grid->RowIndex ?>_iditem_rel_aud_interna" id="x<?= $Grid->RowIndex ?>_iditem_rel_aud_interna" value="<?= HtmlEncode($Grid->iditem_rel_aud_interna->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_iditem_rel_aud_interna" class="el_item_rel_aud_interna_iditem_rel_aud_interna">
<span<?= $Grid->iditem_rel_aud_interna->viewAttributes() ?>>
<?= $Grid->iditem_rel_aud_interna->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_iditem_rel_aud_interna" data-hidden="1" name="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_iditem_rel_aud_interna" id="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_iditem_rel_aud_interna" value="<?= HtmlEncode($Grid->iditem_rel_aud_interna->FormValue) ?>">
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_iditem_rel_aud_interna" data-hidden="1" data-old name="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_iditem_rel_aud_interna" id="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_iditem_rel_aud_interna" value="<?= HtmlEncode($Grid->iditem_rel_aud_interna->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="item_rel_aud_interna" data-field="x_iditem_rel_aud_interna" data-hidden="1" name="x<?= $Grid->RowIndex ?>_iditem_rel_aud_interna" id="x<?= $Grid->RowIndex ?>_iditem_rel_aud_interna" value="<?= HtmlEncode($Grid->iditem_rel_aud_interna->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <td data-name="processo_idprocesso"<?= $Grid->processo_idprocesso->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_processo_idprocesso" class="el_item_rel_aud_interna_processo_idprocesso">
    <select
        id="x<?= $Grid->RowIndex ?>_processo_idprocesso"
        name="x<?= $Grid->RowIndex ?>_processo_idprocesso"
        class="form-control ew-select<?= $Grid->processo_idprocesso->isInvalidClass() ?>"
        data-select2-id="fitem_rel_aud_internagrid_x<?= $Grid->RowIndex ?>_processo_idprocesso"
        data-table="item_rel_aud_interna"
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
loadjs.ready("fitem_rel_aud_internagrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_processo_idprocesso", selectId: "fitem_rel_aud_internagrid_x<?= $Grid->RowIndex ?>_processo_idprocesso" };
    if (fitem_rel_aud_internagrid.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_processo_idprocesso", form: "fitem_rel_aud_internagrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_processo_idprocesso", form: "fitem_rel_aud_internagrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.item_rel_aud_interna.fields.processo_idprocesso.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_processo_idprocesso" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_processo_idprocesso" id="o<?= $Grid->RowIndex ?>_processo_idprocesso" value="<?= HtmlEncode($Grid->processo_idprocesso->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_processo_idprocesso" class="el_item_rel_aud_interna_processo_idprocesso">
    <select
        id="x<?= $Grid->RowIndex ?>_processo_idprocesso"
        name="x<?= $Grid->RowIndex ?>_processo_idprocesso"
        class="form-control ew-select<?= $Grid->processo_idprocesso->isInvalidClass() ?>"
        data-select2-id="fitem_rel_aud_internagrid_x<?= $Grid->RowIndex ?>_processo_idprocesso"
        data-table="item_rel_aud_interna"
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
loadjs.ready("fitem_rel_aud_internagrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_processo_idprocesso", selectId: "fitem_rel_aud_internagrid_x<?= $Grid->RowIndex ?>_processo_idprocesso" };
    if (fitem_rel_aud_internagrid.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_processo_idprocesso", form: "fitem_rel_aud_internagrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_processo_idprocesso", form: "fitem_rel_aud_internagrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.item_rel_aud_interna.fields.processo_idprocesso.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_processo_idprocesso" class="el_item_rel_aud_interna_processo_idprocesso">
<span<?= $Grid->processo_idprocesso->viewAttributes() ?>>
<?= $Grid->processo_idprocesso->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_processo_idprocesso" data-hidden="1" name="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_processo_idprocesso" id="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_processo_idprocesso" value="<?= HtmlEncode($Grid->processo_idprocesso->FormValue) ?>">
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_processo_idprocesso" data-hidden="1" data-old name="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_processo_idprocesso" id="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_processo_idprocesso" value="<?= HtmlEncode($Grid->processo_idprocesso->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->descricao->Visible) { // descricao ?>
        <td data-name="descricao"<?= $Grid->descricao->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_descricao" class="el_item_rel_aud_interna_descricao">
<textarea data-table="item_rel_aud_interna" data-field="x_descricao" name="x<?= $Grid->RowIndex ?>_descricao" id="x<?= $Grid->RowIndex ?>_descricao" cols="50" rows="4" placeholder="<?= HtmlEncode($Grid->descricao->getPlaceHolder()) ?>"<?= $Grid->descricao->editAttributes() ?>><?= $Grid->descricao->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->descricao->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_descricao" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_descricao" id="o<?= $Grid->RowIndex ?>_descricao" value="<?= HtmlEncode($Grid->descricao->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_descricao" class="el_item_rel_aud_interna_descricao">
<textarea data-table="item_rel_aud_interna" data-field="x_descricao" name="x<?= $Grid->RowIndex ?>_descricao" id="x<?= $Grid->RowIndex ?>_descricao" cols="50" rows="4" placeholder="<?= HtmlEncode($Grid->descricao->getPlaceHolder()) ?>"<?= $Grid->descricao->editAttributes() ?>><?= $Grid->descricao->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->descricao->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_descricao" class="el_item_rel_aud_interna_descricao">
<span<?= $Grid->descricao->viewAttributes() ?>>
<?= $Grid->descricao->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_descricao" data-hidden="1" name="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_descricao" id="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_descricao" value="<?= HtmlEncode($Grid->descricao->FormValue) ?>">
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_descricao" data-hidden="1" data-old name="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_descricao" id="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_descricao" value="<?= HtmlEncode($Grid->descricao->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->acao_imediata->Visible) { // acao_imediata ?>
        <td data-name="acao_imediata"<?= $Grid->acao_imediata->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_acao_imediata" class="el_item_rel_aud_interna_acao_imediata">
<textarea data-table="item_rel_aud_interna" data-field="x_acao_imediata" name="x<?= $Grid->RowIndex ?>_acao_imediata" id="x<?= $Grid->RowIndex ?>_acao_imediata" cols="50" rows="3" placeholder="<?= HtmlEncode($Grid->acao_imediata->getPlaceHolder()) ?>"<?= $Grid->acao_imediata->editAttributes() ?>><?= $Grid->acao_imediata->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->acao_imediata->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_acao_imediata" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_acao_imediata" id="o<?= $Grid->RowIndex ?>_acao_imediata" value="<?= HtmlEncode($Grid->acao_imediata->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_acao_imediata" class="el_item_rel_aud_interna_acao_imediata">
<textarea data-table="item_rel_aud_interna" data-field="x_acao_imediata" name="x<?= $Grid->RowIndex ?>_acao_imediata" id="x<?= $Grid->RowIndex ?>_acao_imediata" cols="50" rows="3" placeholder="<?= HtmlEncode($Grid->acao_imediata->getPlaceHolder()) ?>"<?= $Grid->acao_imediata->editAttributes() ?>><?= $Grid->acao_imediata->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->acao_imediata->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_acao_imediata" class="el_item_rel_aud_interna_acao_imediata">
<span<?= $Grid->acao_imediata->viewAttributes() ?>>
<?= $Grid->acao_imediata->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_acao_imediata" data-hidden="1" name="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_acao_imediata" id="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_acao_imediata" value="<?= HtmlEncode($Grid->acao_imediata->FormValue) ?>">
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_acao_imediata" data-hidden="1" data-old name="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_acao_imediata" id="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_acao_imediata" value="<?= HtmlEncode($Grid->acao_imediata->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->acao_contecao->Visible) { // acao_contecao ?>
        <td data-name="acao_contecao"<?= $Grid->acao_contecao->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_acao_contecao" class="el_item_rel_aud_interna_acao_contecao">
<textarea data-table="item_rel_aud_interna" data-field="x_acao_contecao" name="x<?= $Grid->RowIndex ?>_acao_contecao" id="x<?= $Grid->RowIndex ?>_acao_contecao" cols="50" rows="3" placeholder="<?= HtmlEncode($Grid->acao_contecao->getPlaceHolder()) ?>"<?= $Grid->acao_contecao->editAttributes() ?>><?= $Grid->acao_contecao->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->acao_contecao->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_acao_contecao" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_acao_contecao" id="o<?= $Grid->RowIndex ?>_acao_contecao" value="<?= HtmlEncode($Grid->acao_contecao->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_acao_contecao" class="el_item_rel_aud_interna_acao_contecao">
<textarea data-table="item_rel_aud_interna" data-field="x_acao_contecao" name="x<?= $Grid->RowIndex ?>_acao_contecao" id="x<?= $Grid->RowIndex ?>_acao_contecao" cols="50" rows="3" placeholder="<?= HtmlEncode($Grid->acao_contecao->getPlaceHolder()) ?>"<?= $Grid->acao_contecao->editAttributes() ?>><?= $Grid->acao_contecao->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->acao_contecao->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_acao_contecao" class="el_item_rel_aud_interna_acao_contecao">
<span<?= $Grid->acao_contecao->viewAttributes() ?>>
<?= $Grid->acao_contecao->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_acao_contecao" data-hidden="1" name="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_acao_contecao" id="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_acao_contecao" value="<?= HtmlEncode($Grid->acao_contecao->FormValue) ?>">
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_acao_contecao" data-hidden="1" data-old name="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_acao_contecao" id="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_acao_contecao" value="<?= HtmlEncode($Grid->acao_contecao->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->abrir_nc->Visible) { // abrir_nc ?>
        <td data-name="abrir_nc"<?= $Grid->abrir_nc->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_abrir_nc" class="el_item_rel_aud_interna_abrir_nc">
<template id="tp_x<?= $Grid->RowIndex ?>_abrir_nc">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="item_rel_aud_interna" data-field="x_abrir_nc" name="x<?= $Grid->RowIndex ?>_abrir_nc" id="x<?= $Grid->RowIndex ?>_abrir_nc"<?= $Grid->abrir_nc->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_abrir_nc" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_abrir_nc"
    name="x<?= $Grid->RowIndex ?>_abrir_nc"
    value="<?= HtmlEncode($Grid->abrir_nc->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_abrir_nc"
    data-target="dsl_x<?= $Grid->RowIndex ?>_abrir_nc"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->abrir_nc->isInvalidClass() ?>"
    data-table="item_rel_aud_interna"
    data-field="x_abrir_nc"
    data-value-separator="<?= $Grid->abrir_nc->displayValueSeparatorAttribute() ?>"
    <?= $Grid->abrir_nc->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->abrir_nc->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_abrir_nc" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_abrir_nc" id="o<?= $Grid->RowIndex ?>_abrir_nc" value="<?= HtmlEncode($Grid->abrir_nc->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_abrir_nc" class="el_item_rel_aud_interna_abrir_nc">
<template id="tp_x<?= $Grid->RowIndex ?>_abrir_nc">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="item_rel_aud_interna" data-field="x_abrir_nc" name="x<?= $Grid->RowIndex ?>_abrir_nc" id="x<?= $Grid->RowIndex ?>_abrir_nc"<?= $Grid->abrir_nc->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_abrir_nc" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_abrir_nc"
    name="x<?= $Grid->RowIndex ?>_abrir_nc"
    value="<?= HtmlEncode($Grid->abrir_nc->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_abrir_nc"
    data-target="dsl_x<?= $Grid->RowIndex ?>_abrir_nc"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->abrir_nc->isInvalidClass() ?>"
    data-table="item_rel_aud_interna"
    data-field="x_abrir_nc"
    data-value-separator="<?= $Grid->abrir_nc->displayValueSeparatorAttribute() ?>"
    <?= $Grid->abrir_nc->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->abrir_nc->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_item_rel_aud_interna_abrir_nc" class="el_item_rel_aud_interna_abrir_nc">
<span<?= $Grid->abrir_nc->viewAttributes() ?>>
<?= $Grid->abrir_nc->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_abrir_nc" data-hidden="1" name="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_abrir_nc" id="fitem_rel_aud_internagrid$x<?= $Grid->RowIndex ?>_abrir_nc" value="<?= HtmlEncode($Grid->abrir_nc->FormValue) ?>">
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_abrir_nc" data-hidden="1" data-old name="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_abrir_nc" id="fitem_rel_aud_internagrid$o<?= $Grid->RowIndex ?>_abrir_nc" value="<?= HtmlEncode($Grid->abrir_nc->OldValue) ?>">
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
loadjs.ready(["fitem_rel_aud_internagrid","load"], () => fitem_rel_aud_internagrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fitem_rel_aud_internagrid">
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
    ew.addEventHandlers("item_rel_aud_interna");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
