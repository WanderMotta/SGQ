<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAuditoriaIntDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_auditoria_int: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fplano_auditoria_intdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplano_auditoria_intdelete")
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
<form name="fplano_auditoria_intdelete" id="fplano_auditoria_intdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="plano_auditoria_int">
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
<?php if ($Page->idplano_auditoria_int->Visible) { // idplano_auditoria_int ?>
        <th class="<?= $Page->idplano_auditoria_int->headerCellClass() ?>"><span id="elh_plano_auditoria_int_idplano_auditoria_int" class="plano_auditoria_int_idplano_auditoria_int"><?= $Page->idplano_auditoria_int->caption() ?></span></th>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
        <th class="<?= $Page->data->headerCellClass() ?>"><span id="elh_plano_auditoria_int_data" class="plano_auditoria_int_data"><?= $Page->data->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><span id="elh_plano_auditoria_int_usuario_idusuario" class="plano_auditoria_int_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->criterio->Visible) { // criterio ?>
        <th class="<?= $Page->criterio->headerCellClass() ?>"><span id="elh_plano_auditoria_int_criterio" class="plano_auditoria_int_criterio"><?= $Page->criterio->caption() ?></span></th>
<?php } ?>
<?php if ($Page->arquivo->Visible) { // arquivo ?>
        <th class="<?= $Page->arquivo->headerCellClass() ?>"><span id="elh_plano_auditoria_int_arquivo" class="plano_auditoria_int_arquivo"><?= $Page->arquivo->caption() ?></span></th>
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
<?php if ($Page->idplano_auditoria_int->Visible) { // idplano_auditoria_int ?>
        <td<?= $Page->idplano_auditoria_int->cellAttributes() ?>>
<span id="">
<span<?= $Page->idplano_auditoria_int->viewAttributes() ?>>
<?= $Page->idplano_auditoria_int->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
        <td<?= $Page->data->cellAttributes() ?>>
<span id="">
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->criterio->Visible) { // criterio ?>
        <td<?= $Page->criterio->cellAttributes() ?>>
<span id="">
<span<?= $Page->criterio->viewAttributes() ?>>
<?= $Page->criterio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->arquivo->Visible) { // arquivo ?>
        <td<?= $Page->arquivo->cellAttributes() ?>>
<span id="">
<span<?= $Page->arquivo->viewAttributes() ?>>
<?= GetFileViewTag($Page->arquivo, $Page->arquivo->getViewValue(), false) ?>
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
