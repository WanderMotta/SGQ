<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseSwotDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_swot: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fanalise_swotdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fanalise_swotdelete")
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
<form name="fanalise_swotdelete" id="fanalise_swotdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="analise_swot">
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
<?php if ($Page->fatores->Visible) { // fatores ?>
        <th class="<?= $Page->fatores->headerCellClass() ?>"><span id="elh_analise_swot_fatores" class="analise_swot_fatores"><?= $Page->fatores->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ponto->Visible) { // ponto ?>
        <th class="<?= $Page->ponto->headerCellClass() ?>"><span id="elh_analise_swot_ponto" class="analise_swot_ponto"><?= $Page->ponto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->analise->Visible) { // analise ?>
        <th class="<?= $Page->analise->headerCellClass() ?>"><span id="elh_analise_swot_analise" class="analise_swot_analise"><?= $Page->analise->caption() ?></span></th>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <th class="<?= $Page->impacto_idimpacto->headerCellClass() ?>"><span id="elh_analise_swot_impacto_idimpacto" class="analise_swot_impacto_idimpacto"><?= $Page->impacto_idimpacto->caption() ?></span></th>
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
<?php if ($Page->fatores->Visible) { // fatores ?>
        <td<?= $Page->fatores->cellAttributes() ?>>
<span id="">
<span<?= $Page->fatores->viewAttributes() ?>>
<?= $Page->fatores->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ponto->Visible) { // ponto ?>
        <td<?= $Page->ponto->cellAttributes() ?>>
<span id="">
<span<?= $Page->ponto->viewAttributes() ?>>
<?= $Page->ponto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->analise->Visible) { // analise ?>
        <td<?= $Page->analise->cellAttributes() ?>>
<span id="">
<span<?= $Page->analise->viewAttributes() ?>>
<?= $Page->analise->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <td<?= $Page->impacto_idimpacto->cellAttributes() ?>>
<span id="">
<span<?= $Page->impacto_idimpacto->viewAttributes() ?>>
<?= $Page->impacto_idimpacto->getViewValue() ?></span>
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
