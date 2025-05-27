<?php

namespace PHPMaker2024\sgq;

// Page object
$GraficosDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { graficos: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fgraficosdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fgraficosdelete")
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
<form name="fgraficosdelete" id="fgraficosdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="graficos">
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
<?php if ($Page->competencia_idcompetencia->Visible) { // competencia_idcompetencia ?>
        <th class="<?= $Page->competencia_idcompetencia->headerCellClass() ?>"><span id="elh_graficos_competencia_idcompetencia" class="graficos_competencia_idcompetencia"><?= $Page->competencia_idcompetencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
        <th class="<?= $Page->indicadores_idindicadores->headerCellClass() ?>"><span id="elh_graficos_indicadores_idindicadores" class="graficos_indicadores_idindicadores"><?= $Page->indicadores_idindicadores->caption() ?></span></th>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <th class="<?= $Page->valor->headerCellClass() ?>"><span id="elh_graficos_valor" class="graficos_valor"><?= $Page->valor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
        <th class="<?= $Page->obs->headerCellClass() ?>"><span id="elh_graficos_obs" class="graficos_obs"><?= $Page->obs->caption() ?></span></th>
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
<?php if ($Page->competencia_idcompetencia->Visible) { // competencia_idcompetencia ?>
        <td<?= $Page->competencia_idcompetencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->competencia_idcompetencia->viewAttributes() ?>>
<?= $Page->competencia_idcompetencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
        <td<?= $Page->indicadores_idindicadores->cellAttributes() ?>>
<span id="">
<span<?= $Page->indicadores_idindicadores->viewAttributes() ?>>
<?= $Page->indicadores_idindicadores->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <td<?= $Page->valor->cellAttributes() ?>>
<span id="">
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
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
