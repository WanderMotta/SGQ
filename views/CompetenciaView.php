<?php

namespace PHPMaker2024\sgq;

// Page object
$CompetenciaView = &$Page;
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
<form name="fcompetenciaview" id="fcompetenciaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { competencia: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcompetenciaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcompetenciaview")
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
<input type="hidden" name="t" value="competencia">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idcompetencia->Visible) { // idcompetencia ?>
    <tr id="r_idcompetencia"<?= $Page->idcompetencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_competencia_idcompetencia"><?= $Page->idcompetencia->caption() ?></span></td>
        <td data-name="idcompetencia"<?= $Page->idcompetencia->cellAttributes() ?>>
<span id="el_competencia_idcompetencia">
<span<?= $Page->idcompetencia->viewAttributes() ?>>
<?= $Page->idcompetencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mes->Visible) { // mes ?>
    <tr id="r_mes"<?= $Page->mes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_competencia_mes"><?= $Page->mes->caption() ?></span></td>
        <td data-name="mes"<?= $Page->mes->cellAttributes() ?>>
<span id="el_competencia_mes">
<span<?= $Page->mes->viewAttributes() ?>>
<?= $Page->mes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ano->Visible) { // ano ?>
    <tr id="r_ano"<?= $Page->ano->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_competencia_ano"><?= $Page->ano->caption() ?></span></td>
        <td data-name="ano"<?= $Page->ano->cellAttributes() ?>>
<span id="el_competencia_ano">
<span<?= $Page->ano->viewAttributes() ?>>
<?= $Page->ano->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->data_base->Visible) { // data_base ?>
    <tr id="r_data_base"<?= $Page->data_base->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_competencia_data_base"><?= $Page->data_base->caption() ?></span></td>
        <td data-name="data_base"<?= $Page->data_base->cellAttributes() ?>>
<span id="el_competencia_data_base">
<span<?= $Page->data_base->viewAttributes() ?>>
<?= $Page->data_base->getViewValue() ?></span>
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
