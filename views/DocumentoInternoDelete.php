<?php

namespace PHPMaker2024\sgq;

// Page object
$DocumentoInternoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_interno: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fdocumento_internodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdocumento_internodelete")
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
<form name="fdocumento_internodelete" id="fdocumento_internodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="documento_interno">
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
<?php if ($Page->iddocumento_interno->Visible) { // iddocumento_interno ?>
        <th class="<?= $Page->iddocumento_interno->headerCellClass() ?>"><span id="elh_documento_interno_iddocumento_interno" class="documento_interno_iddocumento_interno"><?= $Page->iddocumento_interno->caption() ?></span></th>
<?php } ?>
<?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
        <th class="<?= $Page->titulo_documento->headerCellClass() ?>"><span id="elh_documento_interno_titulo_documento" class="documento_interno_titulo_documento"><?= $Page->titulo_documento->caption() ?></span></th>
<?php } ?>
<?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
        <th class="<?= $Page->restringir_acesso->headerCellClass() ?>"><span id="elh_documento_interno_restringir_acesso" class="documento_interno_restringir_acesso"><?= $Page->restringir_acesso->caption() ?></span></th>
<?php } ?>
<?php if ($Page->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
        <th class="<?= $Page->categoria_documento_idcategoria_documento->headerCellClass() ?>"><span id="elh_documento_interno_categoria_documento_idcategoria_documento" class="documento_interno_categoria_documento_idcategoria_documento"><?= $Page->categoria_documento_idcategoria_documento->caption() ?></span></th>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <th class="<?= $Page->processo_idprocesso->headerCellClass() ?>"><span id="elh_documento_interno_processo_idprocesso" class="documento_interno_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><span id="elh_documento_interno_usuario_idusuario" class="documento_interno_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></th>
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
<?php if ($Page->iddocumento_interno->Visible) { // iddocumento_interno ?>
        <td<?= $Page->iddocumento_interno->cellAttributes() ?>>
<span id="">
<span<?= $Page->iddocumento_interno->viewAttributes() ?>>
<?= $Page->iddocumento_interno->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
        <td<?= $Page->titulo_documento->cellAttributes() ?>>
<span id="">
<span<?= $Page->titulo_documento->viewAttributes() ?>>
<?= $Page->titulo_documento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
        <td<?= $Page->restringir_acesso->cellAttributes() ?>>
<span id="">
<span<?= $Page->restringir_acesso->viewAttributes() ?>>
<?= $Page->restringir_acesso->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
        <td<?= $Page->categoria_documento_idcategoria_documento->cellAttributes() ?>>
<span id="">
<span<?= $Page->categoria_documento_idcategoria_documento->viewAttributes() ?>>
<?= $Page->categoria_documento_idcategoria_documento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <td<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="">
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
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
