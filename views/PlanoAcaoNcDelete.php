<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAcaoNcDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_acao_nc: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fplano_acao_ncdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplano_acao_ncdelete")
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
<form name="fplano_acao_ncdelete" id="fplano_acao_ncdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="plano_acao_nc">
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
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <th class="<?= $Page->o_q_sera_feito->headerCellClass() ?>"><span id="elh_plano_acao_nc_o_q_sera_feito" class="plano_acao_nc_o_q_sera_feito"><?= $Page->o_q_sera_feito->caption() ?></span></th>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
        <th class="<?= $Page->efeito_esperado->headerCellClass() ?>"><span id="elh_plano_acao_nc_efeito_esperado" class="plano_acao_nc_efeito_esperado"><?= $Page->efeito_esperado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><span id="elh_plano_acao_nc_usuario_idusuario" class="plano_acao_nc_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
        <th class="<?= $Page->recursos_nec->headerCellClass() ?>"><span id="elh_plano_acao_nc_recursos_nec" class="plano_acao_nc_recursos_nec"><?= $Page->recursos_nec->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
        <th class="<?= $Page->dt_limite->headerCellClass() ?>"><span id="elh_plano_acao_nc_dt_limite" class="plano_acao_nc_dt_limite"><?= $Page->dt_limite->caption() ?></span></th>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
        <th class="<?= $Page->implementado->headerCellClass() ?>"><span id="elh_plano_acao_nc_implementado" class="plano_acao_nc_implementado"><?= $Page->implementado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
        <th class="<?= $Page->eficaz->headerCellClass() ?>"><span id="elh_plano_acao_nc_eficaz" class="plano_acao_nc_eficaz"><?= $Page->eficaz->caption() ?></span></th>
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
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <td<?= $Page->o_q_sera_feito->cellAttributes() ?>>
<span id="">
<span<?= $Page->o_q_sera_feito->viewAttributes() ?>>
<?= $Page->o_q_sera_feito->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
        <td<?= $Page->efeito_esperado->cellAttributes() ?>>
<span id="">
<span<?= $Page->efeito_esperado->viewAttributes() ?>>
<?= $Page->efeito_esperado->getViewValue() ?></span>
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
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
        <td<?= $Page->recursos_nec->cellAttributes() ?>>
<span id="">
<span<?= $Page->recursos_nec->viewAttributes() ?>>
<?= $Page->recursos_nec->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
        <td<?= $Page->dt_limite->cellAttributes() ?>>
<span id="">
<span<?= $Page->dt_limite->viewAttributes() ?>>
<?= $Page->dt_limite->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
        <td<?= $Page->implementado->cellAttributes() ?>>
<span id="">
<span<?= $Page->implementado->viewAttributes() ?>>
<?= $Page->implementado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
        <td<?= $Page->eficaz->cellAttributes() ?>>
<span id="">
<span<?= $Page->eficaz->viewAttributes() ?>>
<?= $Page->eficaz->getViewValue() ?></span>
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
