<?php

namespace PHPMaker2024\sgq;

// Page object
$ObjetivoQualidadeDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { objetivo_qualidade: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fobjetivo_qualidadedelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fobjetivo_qualidadedelete")
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
<form name="fobjetivo_qualidadedelete" id="fobjetivo_qualidadedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="objetivo_qualidade">
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
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <th class="<?= $Page->processo_idprocesso->headerCellClass() ?>"><span id="elh_objetivo_qualidade_processo_idprocesso" class="objetivo_qualidade_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span></th>
<?php } ?>
<?php if ($Page->objetivo->Visible) { // objetivo ?>
        <th class="<?= $Page->objetivo->headerCellClass() ?>"><span id="elh_objetivo_qualidade_objetivo" class="objetivo_qualidade_objetivo"><?= $Page->objetivo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->como_medir->Visible) { // como_medir ?>
        <th class="<?= $Page->como_medir->headerCellClass() ?>"><span id="elh_objetivo_qualidade_como_medir" class="objetivo_qualidade_como_medir"><?= $Page->como_medir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <th class="<?= $Page->o_q_sera_feito->headerCellClass() ?>"><span id="elh_objetivo_qualidade_o_q_sera_feito" class="objetivo_qualidade_o_q_sera_feito"><?= $Page->o_q_sera_feito->caption() ?></span></th>
<?php } ?>
<?php if ($Page->como_avaliar->Visible) { // como_avaliar ?>
        <th class="<?= $Page->como_avaliar->headerCellClass() ?>"><span id="elh_objetivo_qualidade_como_avaliar" class="objetivo_qualidade_como_avaliar"><?= $Page->como_avaliar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <th class="<?= $Page->departamentos_iddepartamentos->headerCellClass() ?>"><span id="elh_objetivo_qualidade_departamentos_iddepartamentos" class="objetivo_qualidade_departamentos_iddepartamentos"><?= $Page->departamentos_iddepartamentos->caption() ?></span></th>
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
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <td<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="">
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->objetivo->Visible) { // objetivo ?>
        <td<?= $Page->objetivo->cellAttributes() ?>>
<span id="">
<span<?= $Page->objetivo->viewAttributes() ?>>
<?= $Page->objetivo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->como_medir->Visible) { // como_medir ?>
        <td<?= $Page->como_medir->cellAttributes() ?>>
<span id="">
<span<?= $Page->como_medir->viewAttributes() ?>>
<?= $Page->como_medir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <td<?= $Page->o_q_sera_feito->cellAttributes() ?>>
<span id="">
<span<?= $Page->o_q_sera_feito->viewAttributes() ?>>
<?= $Page->o_q_sera_feito->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->como_avaliar->Visible) { // como_avaliar ?>
        <td<?= $Page->como_avaliar->cellAttributes() ?>>
<span id="">
<span<?= $Page->como_avaliar->viewAttributes() ?>>
<?= $Page->como_avaliar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <td<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="">
<span<?= $Page->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Page->departamentos_iddepartamentos->getViewValue() ?></span>
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
