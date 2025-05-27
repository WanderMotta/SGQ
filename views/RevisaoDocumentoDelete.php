<?php

namespace PHPMaker2024\sgq;

// Page object
$RevisaoDocumentoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { revisao_documento: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var frevisao_documentodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frevisao_documentodelete")
        .setPageId("delete")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="frevisao_documentodelete" id="frevisao_documentodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="revisao_documento">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th class="<?= $Page->dt_cadastro->headerCellClass() ?>"><span id="elh_revisao_documento_dt_cadastro" class="revisao_documento_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->qual_alteracao->Visible) { // qual_alteracao ?>
        <th class="<?= $Page->qual_alteracao->headerCellClass() ?>"><span id="elh_revisao_documento_qual_alteracao" class="revisao_documento_qual_alteracao"><?= $Page->qual_alteracao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
        <th class="<?= $Page->status_documento_idstatus_documento->headerCellClass() ?>"><span id="elh_revisao_documento_status_documento_idstatus_documento" class="revisao_documento_status_documento_idstatus_documento"><?= $Page->status_documento_idstatus_documento->caption() ?></span></th>
<?php } ?>
<?php if ($Page->revisao_nr->Visible) { // revisao_nr ?>
        <th class="<?= $Page->revisao_nr->headerCellClass() ?>"><span id="elh_revisao_documento_revisao_nr" class="revisao_documento_revisao_nr"><?= $Page->revisao_nr->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_elaborador->Visible) { // usuario_elaborador ?>
        <th class="<?= $Page->usuario_elaborador->headerCellClass() ?>"><span id="elh_revisao_documento_usuario_elaborador" class="revisao_documento_usuario_elaborador"><?= $Page->usuario_elaborador->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_aprovador->Visible) { // usuario_aprovador ?>
        <th class="<?= $Page->usuario_aprovador->headerCellClass() ?>"><span id="elh_revisao_documento_usuario_aprovador" class="revisao_documento_usuario_aprovador"><?= $Page->usuario_aprovador->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dt_aprovacao->Visible) { // dt_aprovacao ?>
        <th class="<?= $Page->dt_aprovacao->headerCellClass() ?>"><span id="elh_revisao_documento_dt_aprovacao" class="revisao_documento_dt_aprovacao"><?= $Page->dt_aprovacao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
        <th class="<?= $Page->anexo->headerCellClass() ?>"><span id="elh_revisao_documento_anexo" class="revisao_documento_anexo"><?= $Page->anexo->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->qual_alteracao->Visible) { // qual_alteracao ?>
        <td<?= $Page->qual_alteracao->cellAttributes() ?>>
<span id="">
<span<?= $Page->qual_alteracao->viewAttributes() ?>>
<?= $Page->qual_alteracao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
        <td<?= $Page->status_documento_idstatus_documento->cellAttributes() ?>>
<span id="">
<span<?= $Page->status_documento_idstatus_documento->viewAttributes() ?>>
<?= $Page->status_documento_idstatus_documento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->revisao_nr->Visible) { // revisao_nr ?>
        <td<?= $Page->revisao_nr->cellAttributes() ?>>
<span id="">
<span<?= $Page->revisao_nr->viewAttributes() ?>>
<?= $Page->revisao_nr->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuario_elaborador->Visible) { // usuario_elaborador ?>
        <td<?= $Page->usuario_elaborador->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuario_elaborador->viewAttributes() ?>>
<?= $Page->usuario_elaborador->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuario_aprovador->Visible) { // usuario_aprovador ?>
        <td<?= $Page->usuario_aprovador->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuario_aprovador->viewAttributes() ?>>
<?= $Page->usuario_aprovador->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dt_aprovacao->Visible) { // dt_aprovacao ?>
        <td<?= $Page->dt_aprovacao->cellAttributes() ?>>
<span id="">
<span<?= $Page->dt_aprovacao->viewAttributes() ?>>
<?= $Page->dt_aprovacao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
        <td<?= $Page->anexo->cellAttributes() ?>>
<span id="">
<span<?= $Page->anexo->viewAttributes() ?>>
<?= GetFileViewTag($Page->anexo, $Page->anexo->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
