<?php

namespace PHPMaker2024\sgq;

// Page object
$ItemRelAudInternaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<form name="fitem_rel_aud_internaview" id="fitem_rel_aud_internaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { item_rel_aud_interna: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fitem_rel_aud_internaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fitem_rel_aud_internaview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="item_rel_aud_interna">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->iditem_rel_aud_interna->Visible) { // iditem_rel_aud_interna ?>
    <tr id="r_iditem_rel_aud_interna"<?= $Page->iditem_rel_aud_interna->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_item_rel_aud_interna_iditem_rel_aud_interna"><?= $Page->iditem_rel_aud_interna->caption() ?></span></td>
        <td data-name="iditem_rel_aud_interna"<?= $Page->iditem_rel_aud_interna->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_iditem_rel_aud_interna">
<span<?= $Page->iditem_rel_aud_interna->viewAttributes() ?>>
<?= $Page->iditem_rel_aud_interna->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_item_rel_aud_interna_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <tr id="r_processo_idprocesso"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_item_rel_aud_interna_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span></td>
        <td data-name="processo_idprocesso"<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_processo_idprocesso">
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
    <tr id="r_descricao"<?= $Page->descricao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_item_rel_aud_interna_descricao"><?= $Page->descricao->caption() ?></span></td>
        <td data-name="descricao"<?= $Page->descricao->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_descricao">
<span<?= $Page->descricao->viewAttributes() ?>>
<?= $Page->descricao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->acao_imediata->Visible) { // acao_imediata ?>
    <tr id="r_acao_imediata"<?= $Page->acao_imediata->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_item_rel_aud_interna_acao_imediata"><?= $Page->acao_imediata->caption() ?></span></td>
        <td data-name="acao_imediata"<?= $Page->acao_imediata->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_acao_imediata">
<span<?= $Page->acao_imediata->viewAttributes() ?>>
<?= $Page->acao_imediata->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->acao_contecao->Visible) { // acao_contecao ?>
    <tr id="r_acao_contecao"<?= $Page->acao_contecao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_item_rel_aud_interna_acao_contecao"><?= $Page->acao_contecao->caption() ?></span></td>
        <td data-name="acao_contecao"<?= $Page->acao_contecao->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_acao_contecao">
<span<?= $Page->acao_contecao->viewAttributes() ?>>
<?= $Page->acao_contecao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->abrir_nc->Visible) { // abrir_nc ?>
    <tr id="r_abrir_nc"<?= $Page->abrir_nc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_item_rel_aud_interna_abrir_nc"><?= $Page->abrir_nc->caption() ?></span></td>
        <td data-name="abrir_nc"<?= $Page->abrir_nc->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_abrir_nc">
<span<?= $Page->abrir_nc->viewAttributes() ?>>
<?= $Page->abrir_nc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->Visible) { // relatorio_auditoria_interna_idrelatorio_auditoria_interna ?>
    <tr id="r_relatorio_auditoria_interna_idrelatorio_auditoria_interna"<?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_item_rel_aud_interna_relatorio_auditoria_interna_idrelatorio_auditoria_interna"><?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->caption() ?></span></td>
        <td data-name="relatorio_auditoria_interna_idrelatorio_auditoria_interna"<?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_relatorio_auditoria_interna_idrelatorio_auditoria_interna">
<span<?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->viewAttributes() ?>>
<?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
