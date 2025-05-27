<?php

namespace PHPMaker2024\sgq;

// Page object
$RelatorioAudIntView = &$Page;
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
<form name="frelatorio_aud_intview" id="frelatorio_aud_intview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { relatorio_aud_int: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var frelatorio_aud_intview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frelatorio_aud_intview")
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
<input type="hidden" name="t" value="relatorio_aud_int">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idrelatorio_aud_int->Visible) { // idrelatorio_aud_int ?>
    <tr id="r_idrelatorio_aud_int"<?= $Page->idrelatorio_aud_int->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_aud_int_idrelatorio_aud_int"><?= $Page->idrelatorio_aud_int->caption() ?></span></td>
        <td data-name="idrelatorio_aud_int"<?= $Page->idrelatorio_aud_int->cellAttributes() ?>>
<span id="el_relatorio_aud_int_idrelatorio_aud_int">
<span<?= $Page->idrelatorio_aud_int->viewAttributes() ?>>
<?= $Page->idrelatorio_aud_int->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_aud_int_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_relatorio_aud_int_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->plano_auditoria_int_idplano_auditoria_int->Visible) { // plano_auditoria_int_idplano_auditoria_int ?>
    <tr id="r_plano_auditoria_int_idplano_auditoria_int"<?= $Page->plano_auditoria_int_idplano_auditoria_int->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int"><?= $Page->plano_auditoria_int_idplano_auditoria_int->caption() ?></span></td>
        <td data-name="plano_auditoria_int_idplano_auditoria_int"<?= $Page->plano_auditoria_int_idplano_auditoria_int->cellAttributes() ?>>
<span id="el_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int">
<span<?= $Page->plano_auditoria_int_idplano_auditoria_int->viewAttributes() ?>>
<?= $Page->plano_auditoria_int_idplano_auditoria_int->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->item_plano_aud_int_iditem_plano_aud_int->Visible) { // item_plano_aud_int_iditem_plano_aud_int ?>
    <tr id="r_item_plano_aud_int_iditem_plano_aud_int"<?= $Page->item_plano_aud_int_iditem_plano_aud_int->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int"><?= $Page->item_plano_aud_int_iditem_plano_aud_int->caption() ?></span></td>
        <td data-name="item_plano_aud_int_iditem_plano_aud_int"<?= $Page->item_plano_aud_int_iditem_plano_aud_int->cellAttributes() ?>>
<span id="el_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int">
<span<?= $Page->item_plano_aud_int_iditem_plano_aud_int->viewAttributes() ?>>
<?= $Page->item_plano_aud_int_iditem_plano_aud_int->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->metodo->Visible) { // metodo ?>
    <tr id="r_metodo"<?= $Page->metodo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_aud_int_metodo"><?= $Page->metodo->caption() ?></span></td>
        <td data-name="metodo"<?= $Page->metodo->cellAttributes() ?>>
<span id="el_relatorio_aud_int_metodo">
<span<?= $Page->metodo->viewAttributes() ?>>
<?= $Page->metodo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
    <tr id="r_descricao"<?= $Page->descricao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_aud_int_descricao"><?= $Page->descricao->caption() ?></span></td>
        <td data-name="descricao"<?= $Page->descricao->cellAttributes() ?>>
<span id="el_relatorio_aud_int_descricao">
<span<?= $Page->descricao->viewAttributes() ?>>
<?= $Page->descricao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->evidencia->Visible) { // evidencia ?>
    <tr id="r_evidencia"<?= $Page->evidencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_aud_int_evidencia"><?= $Page->evidencia->caption() ?></span></td>
        <td data-name="evidencia"<?= $Page->evidencia->cellAttributes() ?>>
<span id="el_relatorio_aud_int_evidencia">
<span<?= $Page->evidencia->viewAttributes() ?>>
<?= $Page->evidencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nao_conformidade->Visible) { // nao_conformidade ?>
    <tr id="r_nao_conformidade"<?= $Page->nao_conformidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_aud_int_nao_conformidade"><?= $Page->nao_conformidade->caption() ?></span></td>
        <td data-name="nao_conformidade"<?= $Page->nao_conformidade->cellAttributes() ?>>
<span id="el_relatorio_aud_int_nao_conformidade">
<span<?= $Page->nao_conformidade->viewAttributes() ?>>
<?= $Page->nao_conformidade->getViewValue() ?></span>
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
