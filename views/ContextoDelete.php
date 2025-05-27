<?php

namespace PHPMaker2024\sgq;

// Page object
$ContextoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { contexto: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcontextodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcontextodelete")
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
<form name="fcontextodelete" id="fcontextodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="contexto">
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
<?php if ($Page->ano->Visible) { // ano ?>
        <th class="<?= $Page->ano->headerCellClass() ?>"><span id="elh_contexto_ano" class="contexto_ano"><?= $Page->ano->caption() ?></span></th>
<?php } ?>
<?php if ($Page->revisao->Visible) { // revisao ?>
        <th class="<?= $Page->revisao->headerCellClass() ?>"><span id="elh_contexto_revisao" class="contexto_revisao"><?= $Page->revisao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
        <th class="<?= $Page->data->headerCellClass() ?>"><span id="elh_contexto_data" class="contexto_data"><?= $Page->data->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><span id="elh_contexto_usuario_idusuario" class="contexto_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_idusuario1->Visible) { // usuario_idusuario1 ?>
        <th class="<?= $Page->usuario_idusuario1->headerCellClass() ?>"><span id="elh_contexto_usuario_idusuario1" class="contexto_usuario_idusuario1"><?= $Page->usuario_idusuario1->caption() ?></span></th>
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
<?php if ($Page->ano->Visible) { // ano ?>
        <td<?= $Page->ano->cellAttributes() ?>>
<span id="">
<span<?= $Page->ano->viewAttributes() ?>>
<?= $Page->ano->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->revisao->Visible) { // revisao ?>
        <td<?= $Page->revisao->cellAttributes() ?>>
<span id="">
<span<?= $Page->revisao->viewAttributes() ?>>
<?= $Page->revisao->getViewValue() ?></span>
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
<?php if ($Page->usuario_idusuario1->Visible) { // usuario_idusuario1 ?>
        <td<?= $Page->usuario_idusuario1->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuario_idusuario1->viewAttributes() ?>>
<?= $Page->usuario_idusuario1->getViewValue() ?></span>
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
