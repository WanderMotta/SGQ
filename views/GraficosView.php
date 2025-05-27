<?php

namespace PHPMaker2024\sgq;

// Page object
$GraficosView = &$Page;
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
<form name="fgraficosview" id="fgraficosview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { graficos: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fgraficosview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fgraficosview")
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
<input type="hidden" name="t" value="graficos">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idgraficos->Visible) { // idgraficos ?>
    <tr id="r_idgraficos"<?= $Page->idgraficos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_graficos_idgraficos"><?= $Page->idgraficos->caption() ?></span></td>
        <td data-name="idgraficos"<?= $Page->idgraficos->cellAttributes() ?>>
<span id="el_graficos_idgraficos">
<span<?= $Page->idgraficos->viewAttributes() ?>>
<?= $Page->idgraficos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->competencia_idcompetencia->Visible) { // competencia_idcompetencia ?>
    <tr id="r_competencia_idcompetencia"<?= $Page->competencia_idcompetencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_graficos_competencia_idcompetencia"><?= $Page->competencia_idcompetencia->caption() ?></span></td>
        <td data-name="competencia_idcompetencia"<?= $Page->competencia_idcompetencia->cellAttributes() ?>>
<span id="el_graficos_competencia_idcompetencia">
<span<?= $Page->competencia_idcompetencia->viewAttributes() ?>>
<?= $Page->competencia_idcompetencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
    <tr id="r_indicadores_idindicadores"<?= $Page->indicadores_idindicadores->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_graficos_indicadores_idindicadores"><?= $Page->indicadores_idindicadores->caption() ?></span></td>
        <td data-name="indicadores_idindicadores"<?= $Page->indicadores_idindicadores->cellAttributes() ?>>
<span id="el_graficos_indicadores_idindicadores">
<span<?= $Page->indicadores_idindicadores->viewAttributes() ?>>
<?= $Page->indicadores_idindicadores->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->data_base->Visible) { // data_base ?>
    <tr id="r_data_base"<?= $Page->data_base->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_graficos_data_base"><?= $Page->data_base->caption() ?></span></td>
        <td data-name="data_base"<?= $Page->data_base->cellAttributes() ?>>
<span id="el_graficos_data_base">
<span<?= $Page->data_base->viewAttributes() ?>>
<?= $Page->data_base->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
    <tr id="r_valor"<?= $Page->valor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_graficos_valor"><?= $Page->valor->caption() ?></span></td>
        <td data-name="valor"<?= $Page->valor->cellAttributes() ?>>
<span id="el_graficos_valor">
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_graficos_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_graficos_obs">
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
