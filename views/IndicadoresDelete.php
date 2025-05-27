<?php

namespace PHPMaker2024\sgq;

// Page object
$IndicadoresDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { indicadores: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var findicadoresdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("findicadoresdelete")
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
<form name="findicadoresdelete" id="findicadoresdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="indicadores">
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
<?php if ($Page->indicador->Visible) { // indicador ?>
        <th class="<?= $Page->indicador->headerCellClass() ?>"><span id="elh_indicadores_indicador" class="indicadores_indicador"><?= $Page->indicador->caption() ?></span></th>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <th class="<?= $Page->periodicidade_idperiodicidade->headerCellClass() ?>"><span id="elh_indicadores_periodicidade_idperiodicidade" class="indicadores_periodicidade_idperiodicidade"><?= $Page->periodicidade_idperiodicidade->caption() ?></span></th>
<?php } ?>
<?php if ($Page->unidade_medida_idunidade_medida->Visible) { // unidade_medida_idunidade_medida ?>
        <th class="<?= $Page->unidade_medida_idunidade_medida->headerCellClass() ?>"><span id="elh_indicadores_unidade_medida_idunidade_medida" class="indicadores_unidade_medida_idunidade_medida"><?= $Page->unidade_medida_idunidade_medida->caption() ?></span></th>
<?php } ?>
<?php if ($Page->meta->Visible) { // meta ?>
        <th class="<?= $Page->meta->headerCellClass() ?>"><span id="elh_indicadores_meta" class="indicadores_meta"><?= $Page->meta->caption() ?></span></th>
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
<?php if ($Page->indicador->Visible) { // indicador ?>
        <td<?= $Page->indicador->cellAttributes() ?>>
<span id="">
<span<?= $Page->indicador->viewAttributes() ?>>
<?= $Page->indicador->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <td<?= $Page->periodicidade_idperiodicidade->cellAttributes() ?>>
<span id="">
<span<?= $Page->periodicidade_idperiodicidade->viewAttributes() ?>>
<?= $Page->periodicidade_idperiodicidade->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->unidade_medida_idunidade_medida->Visible) { // unidade_medida_idunidade_medida ?>
        <td<?= $Page->unidade_medida_idunidade_medida->cellAttributes() ?>>
<span id="">
<span<?= $Page->unidade_medida_idunidade_medida->viewAttributes() ?>>
<?= $Page->unidade_medida_idunidade_medida->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->meta->Visible) { // meta ?>
        <td<?= $Page->meta->cellAttributes() ?>>
<span id="">
<span<?= $Page->meta->viewAttributes() ?>>
<?= $Page->meta->getViewValue() ?></span>
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
