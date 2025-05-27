<?php

namespace PHPMaker2023\sgq;

// Page object
$ParteInteressadaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
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
<form name="fparte_interessadaview" id="fparte_interessadaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { parte_interessada: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fparte_interessadaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fparte_interessadaview")
        .setPageId("view")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="parte_interessada">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idparte_interessada->Visible) { // idparte_interessada ?>
    <tr id="r_idparte_interessada"<?= $Page->idparte_interessada->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_parte_interessada_idparte_interessada"><?= $Page->idparte_interessada->caption() ?></span></td>
        <td data-name="idparte_interessada"<?= $Page->idparte_interessada->cellAttributes() ?>>
<span id="el_parte_interessada_idparte_interessada">
<span<?= $Page->idparte_interessada->viewAttributes() ?>>
<?= $Page->idparte_interessada->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parte_interessada->Visible) { // parte_interessada ?>
    <tr id="r_parte_interessada"<?= $Page->parte_interessada->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_parte_interessada_parte_interessada"><?= $Page->parte_interessada->caption() ?></span></td>
        <td data-name="parte_interessada"<?= $Page->parte_interessada->cellAttributes() ?>>
<span id="el_parte_interessada_parte_interessada">
<span<?= $Page->parte_interessada->viewAttributes() ?>>
<?= $Page->parte_interessada->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->necessidades->Visible) { // necessidades ?>
    <tr id="r_necessidades"<?= $Page->necessidades->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_parte_interessada_necessidades"><?= $Page->necessidades->caption() ?></span></td>
        <td data-name="necessidades"<?= $Page->necessidades->cellAttributes() ?>>
<span id="el_parte_interessada_necessidades">
<span<?= $Page->necessidades->viewAttributes() ?>>
<?= $Page->necessidades->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->expectativas->Visible) { // expectativas ?>
    <tr id="r_expectativas"<?= $Page->expectativas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_parte_interessada_expectativas"><?= $Page->expectativas->caption() ?></span></td>
        <td data-name="expectativas"<?= $Page->expectativas->cellAttributes() ?>>
<span id="el_parte_interessada_expectativas">
<span<?= $Page->expectativas->viewAttributes() ?>>
<?= $Page->expectativas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monitor->Visible) { // monitor ?>
    <tr id="r_monitor"<?= $Page->monitor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_parte_interessada_monitor"><?= $Page->monitor->caption() ?></span></td>
        <td data-name="monitor"<?= $Page->monitor->cellAttributes() ?>>
<span id="el_parte_interessada_monitor">
<span<?= $Page->monitor->viewAttributes() ?>>
<?= $Page->monitor->getViewValue() ?></span>
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
