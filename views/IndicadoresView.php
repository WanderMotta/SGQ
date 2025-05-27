<?php

namespace PHPMaker2024\sgq;

// Page object
$IndicadoresView = &$Page;
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
<form name="findicadoresview" id="findicadoresview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { indicadores: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var findicadoresview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("findicadoresview")
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
<input type="hidden" name="t" value="indicadores">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idindicadores->Visible) { // idindicadores ?>
    <tr id="r_idindicadores"<?= $Page->idindicadores->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_indicadores_idindicadores"><?= $Page->idindicadores->caption() ?></span></td>
        <td data-name="idindicadores"<?= $Page->idindicadores->cellAttributes() ?>>
<span id="el_indicadores_idindicadores">
<span<?= $Page->idindicadores->viewAttributes() ?>>
<?= $Page->idindicadores->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_indicadores_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_indicadores_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->indicador->Visible) { // indicador ?>
    <tr id="r_indicador"<?= $Page->indicador->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_indicadores_indicador"><?= $Page->indicador->caption() ?></span></td>
        <td data-name="indicador"<?= $Page->indicador->cellAttributes() ?>>
<span id="el_indicadores_indicador">
<span<?= $Page->indicador->viewAttributes() ?>>
<?= $Page->indicador->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
    <tr id="r_periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_indicadores_periodicidade_idperiodicidade"><?= $Page->periodicidade_idperiodicidade->caption() ?></span></td>
        <td data-name="periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->cellAttributes() ?>>
<span id="el_indicadores_periodicidade_idperiodicidade">
<span<?= $Page->periodicidade_idperiodicidade->viewAttributes() ?>>
<?= $Page->periodicidade_idperiodicidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unidade_medida_idunidade_medida->Visible) { // unidade_medida_idunidade_medida ?>
    <tr id="r_unidade_medida_idunidade_medida"<?= $Page->unidade_medida_idunidade_medida->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_indicadores_unidade_medida_idunidade_medida"><?= $Page->unidade_medida_idunidade_medida->caption() ?></span></td>
        <td data-name="unidade_medida_idunidade_medida"<?= $Page->unidade_medida_idunidade_medida->cellAttributes() ?>>
<span id="el_indicadores_unidade_medida_idunidade_medida">
<span<?= $Page->unidade_medida_idunidade_medida->viewAttributes() ?>>
<?= $Page->unidade_medida_idunidade_medida->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->meta->Visible) { // meta ?>
    <tr id="r_meta"<?= $Page->meta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_indicadores_meta"><?= $Page->meta->caption() ?></span></td>
        <td data-name="meta"<?= $Page->meta->cellAttributes() ?>>
<span id="el_indicadores_meta">
<span<?= $Page->meta->viewAttributes() ?>>
<?= $Page->meta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("graficos", explode(",", $Page->getCurrentDetailTable())) && $graficos->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("graficos", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "GraficosGrid.php" ?>
<?php } ?>
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
