<?php

namespace PHPMaker2024\sgq;

// Page object
$ItemRelAudInternaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { item_rel_aud_interna: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fitem_rel_aud_internadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fitem_rel_aud_internadelete")
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
<form name="fitem_rel_aud_internadelete" id="fitem_rel_aud_internadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="item_rel_aud_interna">
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
<?php if ($Page->iditem_rel_aud_interna->Visible) { // iditem_rel_aud_interna ?>
        <th class="<?= $Page->iditem_rel_aud_interna->headerCellClass() ?>"><span id="elh_item_rel_aud_interna_iditem_rel_aud_interna" class="item_rel_aud_interna_iditem_rel_aud_interna"><?= $Page->iditem_rel_aud_interna->caption() ?></span></th>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <th class="<?= $Page->processo_idprocesso->headerCellClass() ?>"><span id="elh_item_rel_aud_interna_processo_idprocesso" class="item_rel_aud_interna_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
        <th class="<?= $Page->descricao->headerCellClass() ?>"><span id="elh_item_rel_aud_interna_descricao" class="item_rel_aud_interna_descricao"><?= $Page->descricao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->acao_imediata->Visible) { // acao_imediata ?>
        <th class="<?= $Page->acao_imediata->headerCellClass() ?>"><span id="elh_item_rel_aud_interna_acao_imediata" class="item_rel_aud_interna_acao_imediata"><?= $Page->acao_imediata->caption() ?></span></th>
<?php } ?>
<?php if ($Page->acao_contecao->Visible) { // acao_contecao ?>
        <th class="<?= $Page->acao_contecao->headerCellClass() ?>"><span id="elh_item_rel_aud_interna_acao_contecao" class="item_rel_aud_interna_acao_contecao"><?= $Page->acao_contecao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->abrir_nc->Visible) { // abrir_nc ?>
        <th class="<?= $Page->abrir_nc->headerCellClass() ?>"><span id="elh_item_rel_aud_interna_abrir_nc" class="item_rel_aud_interna_abrir_nc"><?= $Page->abrir_nc->caption() ?></span></th>
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
<?php if ($Page->iditem_rel_aud_interna->Visible) { // iditem_rel_aud_interna ?>
        <td<?= $Page->iditem_rel_aud_interna->cellAttributes() ?>>
<span id="">
<span<?= $Page->iditem_rel_aud_interna->viewAttributes() ?>>
<?= $Page->iditem_rel_aud_interna->getViewValue() ?></span>
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
<?php if ($Page->descricao->Visible) { // descricao ?>
        <td<?= $Page->descricao->cellAttributes() ?>>
<span id="">
<span<?= $Page->descricao->viewAttributes() ?>>
<?= $Page->descricao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->acao_imediata->Visible) { // acao_imediata ?>
        <td<?= $Page->acao_imediata->cellAttributes() ?>>
<span id="">
<span<?= $Page->acao_imediata->viewAttributes() ?>>
<?= $Page->acao_imediata->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->acao_contecao->Visible) { // acao_contecao ?>
        <td<?= $Page->acao_contecao->cellAttributes() ?>>
<span id="">
<span<?= $Page->acao_contecao->viewAttributes() ?>>
<?= $Page->acao_contecao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->abrir_nc->Visible) { // abrir_nc ?>
        <td<?= $Page->abrir_nc->cellAttributes() ?>>
<span id="">
<span<?= $Page->abrir_nc->viewAttributes() ?>>
<?= $Page->abrir_nc->getViewValue() ?></span>
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
