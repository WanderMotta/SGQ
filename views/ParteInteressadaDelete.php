<?php

namespace PHPMaker2023\sgq;

// Page object
$ParteInteressadaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { parte_interessada: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fparte_interessadadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fparte_interessadadelete")
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
<form name="fparte_interessadadelete" id="fparte_interessadadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="parte_interessada">
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
<?php if ($Page->parte_interessada->Visible) { // parte_interessada ?>
        <th class="<?= $Page->parte_interessada->headerCellClass() ?>"><span id="elh_parte_interessada_parte_interessada" class="parte_interessada_parte_interessada"><?= $Page->parte_interessada->caption() ?></span></th>
<?php } ?>
<?php if ($Page->necessidades->Visible) { // necessidades ?>
        <th class="<?= $Page->necessidades->headerCellClass() ?>"><span id="elh_parte_interessada_necessidades" class="parte_interessada_necessidades"><?= $Page->necessidades->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expectativas->Visible) { // expectativas ?>
        <th class="<?= $Page->expectativas->headerCellClass() ?>"><span id="elh_parte_interessada_expectativas" class="parte_interessada_expectativas"><?= $Page->expectativas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->monitor->Visible) { // monitor ?>
        <th class="<?= $Page->monitor->headerCellClass() ?>"><span id="elh_parte_interessada_monitor" class="parte_interessada_monitor"><?= $Page->monitor->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->parte_interessada->Visible) { // parte_interessada ?>
        <td<?= $Page->parte_interessada->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_parte_interessada_parte_interessada" class="el_parte_interessada_parte_interessada">
<span<?= $Page->parte_interessada->viewAttributes() ?>>
<?= $Page->parte_interessada->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->necessidades->Visible) { // necessidades ?>
        <td<?= $Page->necessidades->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_parte_interessada_necessidades" class="el_parte_interessada_necessidades">
<span<?= $Page->necessidades->viewAttributes() ?>>
<?= $Page->necessidades->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->expectativas->Visible) { // expectativas ?>
        <td<?= $Page->expectativas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_parte_interessada_expectativas" class="el_parte_interessada_expectativas">
<span<?= $Page->expectativas->viewAttributes() ?>>
<?= $Page->expectativas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->monitor->Visible) { // monitor ?>
        <td<?= $Page->monitor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_parte_interessada_monitor" class="el_parte_interessada_monitor">
<span<?= $Page->monitor->viewAttributes() ?>>
<?= $Page->monitor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
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
