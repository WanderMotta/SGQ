<?php

namespace PHPMaker2024\sgq;

// Page object
$ImpactoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { impacto: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fimpactodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fimpactodelete")
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
<form name="fimpactodelete" id="fimpactodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="impacto">
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
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
        <th class="<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->headerCellClass() ?>"><span id="elh_impacto_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="impacto_tipo_risco_oportunidade_idtipo_risco_oportunidade"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() ?></span></th>
<?php } ?>
<?php if ($Page->impacto->Visible) { // impacto ?>
        <th class="<?= $Page->impacto->headerCellClass() ?>"><span id="elh_impacto_impacto" class="impacto_impacto"><?= $Page->impacto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->grau->Visible) { // grau ?>
        <th class="<?= $Page->grau->headerCellClass() ?>"><span id="elh_impacto_grau" class="impacto_grau"><?= $Page->grau->caption() ?></span></th>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
        <th class="<?= $Page->obs->headerCellClass() ?>"><span id="elh_impacto_obs" class="impacto_obs"><?= $Page->obs->caption() ?></span></th>
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
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
        <td<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->viewAttributes() ?>>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->impacto->Visible) { // impacto ?>
        <td<?= $Page->impacto->cellAttributes() ?>>
<span id="">
<span<?= $Page->impacto->viewAttributes() ?>>
<?= $Page->impacto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->grau->Visible) { // grau ?>
        <td<?= $Page->grau->cellAttributes() ?>>
<span id="">
<span<?= $Page->grau->viewAttributes() ?>>
<?= $Page->grau->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
        <td<?= $Page->obs->cellAttributes() ?>>
<span id="">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
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
