<?php

namespace PHPMaker2024\sgq;

// Page object
$OrigemRiscoOportunidadeView = &$Page;
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
<form name="forigem_risco_oportunidadeview" id="forigem_risco_oportunidadeview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { origem_risco_oportunidade: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var forigem_risco_oportunidadeview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("forigem_risco_oportunidadeview")
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
<input type="hidden" name="t" value="origem_risco_oportunidade">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idorigem_risco_oportunidade->Visible) { // idorigem_risco_oportunidade ?>
    <tr id="r_idorigem_risco_oportunidade"<?= $Page->idorigem_risco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->idorigem_risco_oportunidade->caption() ?></span></td>
        <td data-name="idorigem_risco_oportunidade"<?= $Page->idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el_origem_risco_oportunidade_idorigem_risco_oportunidade">
<span<?= $Page->idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $Page->idorigem_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->origem->Visible) { // origem ?>
    <tr id="r_origem"<?= $Page->origem->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_origem_risco_oportunidade_origem"><?= $Page->origem->caption() ?></span></td>
        <td data-name="origem"<?= $Page->origem->cellAttributes() ?>>
<span id="el_origem_risco_oportunidade_origem">
<span<?= $Page->origem->viewAttributes() ?>>
<?= $Page->origem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_origem_risco_oportunidade_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_origem_risco_oportunidade_obs">
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
