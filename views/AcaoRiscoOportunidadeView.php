<?php

namespace PHPMaker2024\sgq;

// Page object
$AcaoRiscoOportunidadeView = &$Page;
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
<form name="facao_risco_oportunidadeview" id="facao_risco_oportunidadeview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { acao_risco_oportunidade: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var facao_risco_oportunidadeview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("facao_risco_oportunidadeview")
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
<input type="hidden" name="t" value="acao_risco_oportunidade">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idacao_risco_oportunidade->Visible) { // idacao_risco_oportunidade ?>
    <tr id="r_idacao_risco_oportunidade"<?= $Page->idacao_risco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_acao_risco_oportunidade_idacao_risco_oportunidade"><?= $Page->idacao_risco_oportunidade->caption() ?></span></td>
        <td data-name="idacao_risco_oportunidade"<?= $Page->idacao_risco_oportunidade->cellAttributes() ?>>
<span id="el_acao_risco_oportunidade_idacao_risco_oportunidade">
<span<?= $Page->idacao_risco_oportunidade->viewAttributes() ?>>
<?= $Page->idacao_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
    <tr id="r_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_acao_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() ?></span></td>
        <td data-name="tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
<span id="el_acao_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade">
<span<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->viewAttributes() ?>>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->acao->Visible) { // acao ?>
    <tr id="r_acao"<?= $Page->acao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_acao_risco_oportunidade_acao"><?= $Page->acao->caption() ?></span></td>
        <td data-name="acao"<?= $Page->acao->cellAttributes() ?>>
<span id="el_acao_risco_oportunidade_acao">
<span<?= $Page->acao->viewAttributes() ?>>
<?= $Page->acao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_acao_risco_oportunidade_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_acao_risco_oportunidade_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
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
