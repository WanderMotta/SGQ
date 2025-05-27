<?php

namespace PHPMaker2024\sgq;

// Page object
$TipoRiscoOportunidadeView = &$Page;
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
<form name="ftipo_risco_oportunidadeview" id="ftipo_risco_oportunidadeview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipo_risco_oportunidade: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var ftipo_risco_oportunidadeview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipo_risco_oportunidadeview")
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
<input type="hidden" name="t" value="tipo_risco_oportunidade">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idtipo_risco_oportunidade->Visible) { // idtipo_risco_oportunidade ?>
    <tr id="r_idtipo_risco_oportunidade"<?= $Page->idtipo_risco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipo_risco_oportunidade_idtipo_risco_oportunidade"><?= $Page->idtipo_risco_oportunidade->caption() ?></span></td>
        <td data-name="idtipo_risco_oportunidade"<?= $Page->idtipo_risco_oportunidade->cellAttributes() ?>>
<span id="el_tipo_risco_oportunidade_idtipo_risco_oportunidade">
<span<?= $Page->idtipo_risco_oportunidade->viewAttributes() ?>>
<?= $Page->idtipo_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade ?>
    <tr id="r_tipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipo_risco_oportunidade_tipo_risco_oportunidade"><?= $Page->tipo_risco_oportunidade->caption() ?></span></td>
        <td data-name="tipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade->cellAttributes() ?>>
<span id="el_tipo_risco_oportunidade_tipo_risco_oportunidade">
<span<?= $Page->tipo_risco_oportunidade->viewAttributes() ?>>
<?= $Page->tipo_risco_oportunidade->getViewValue() ?></span>
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
