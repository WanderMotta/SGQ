<?php

namespace PHPMaker2024\sgq;

// Page object
$RelatorioAudIntDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { relatorio_aud_int: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var frelatorio_aud_intdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frelatorio_aud_intdelete")
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
<form name="frelatorio_aud_intdelete" id="frelatorio_aud_intdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="relatorio_aud_int">
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
<?php if ($Page->plano_auditoria_int_idplano_auditoria_int->Visible) { // plano_auditoria_int_idplano_auditoria_int ?>
        <th class="<?= $Page->plano_auditoria_int_idplano_auditoria_int->headerCellClass() ?>"><span id="elh_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int" class="relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int"><?= $Page->plano_auditoria_int_idplano_auditoria_int->caption() ?></span></th>
<?php } ?>
<?php if ($Page->item_plano_aud_int_iditem_plano_aud_int->Visible) { // item_plano_aud_int_iditem_plano_aud_int ?>
        <th class="<?= $Page->item_plano_aud_int_iditem_plano_aud_int->headerCellClass() ?>"><span id="elh_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int" class="relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int"><?= $Page->item_plano_aud_int_iditem_plano_aud_int->caption() ?></span></th>
<?php } ?>
<?php if ($Page->metodo->Visible) { // metodo ?>
        <th class="<?= $Page->metodo->headerCellClass() ?>"><span id="elh_relatorio_aud_int_metodo" class="relatorio_aud_int_metodo"><?= $Page->metodo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
        <th class="<?= $Page->descricao->headerCellClass() ?>"><span id="elh_relatorio_aud_int_descricao" class="relatorio_aud_int_descricao"><?= $Page->descricao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->evidencia->Visible) { // evidencia ?>
        <th class="<?= $Page->evidencia->headerCellClass() ?>"><span id="elh_relatorio_aud_int_evidencia" class="relatorio_aud_int_evidencia"><?= $Page->evidencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nao_conformidade->Visible) { // nao_conformidade ?>
        <th class="<?= $Page->nao_conformidade->headerCellClass() ?>"><span id="elh_relatorio_aud_int_nao_conformidade" class="relatorio_aud_int_nao_conformidade"><?= $Page->nao_conformidade->caption() ?></span></th>
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
<?php if ($Page->plano_auditoria_int_idplano_auditoria_int->Visible) { // plano_auditoria_int_idplano_auditoria_int ?>
        <td<?= $Page->plano_auditoria_int_idplano_auditoria_int->cellAttributes() ?>>
<span id="">
<span<?= $Page->plano_auditoria_int_idplano_auditoria_int->viewAttributes() ?>>
<?= $Page->plano_auditoria_int_idplano_auditoria_int->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->item_plano_aud_int_iditem_plano_aud_int->Visible) { // item_plano_aud_int_iditem_plano_aud_int ?>
        <td<?= $Page->item_plano_aud_int_iditem_plano_aud_int->cellAttributes() ?>>
<span id="">
<span<?= $Page->item_plano_aud_int_iditem_plano_aud_int->viewAttributes() ?>>
<?= $Page->item_plano_aud_int_iditem_plano_aud_int->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->metodo->Visible) { // metodo ?>
        <td<?= $Page->metodo->cellAttributes() ?>>
<span id="">
<span<?= $Page->metodo->viewAttributes() ?>>
<?= $Page->metodo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
        <td<?= $Page->descricao->cellAttributes() ?>>
<span id="">
<span<?= $Page->descricao->viewAttributes() ?>>
<?= $Page->descricao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->evidencia->Visible) { // evidencia ?>
        <td<?= $Page->evidencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->evidencia->viewAttributes() ?>>
<?= $Page->evidencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nao_conformidade->Visible) { // nao_conformidade ?>
        <td<?= $Page->nao_conformidade->cellAttributes() ?>>
<span id="">
<span<?= $Page->nao_conformidade->viewAttributes() ?>>
<?= $Page->nao_conformidade->getViewValue() ?></span>
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
