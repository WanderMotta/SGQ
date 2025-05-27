<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseSwotView = &$Page;
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
<form name="fanalise_swotview" id="fanalise_swotview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_swot: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fanalise_swotview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fanalise_swotview")
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
<input type="hidden" name="t" value="analise_swot">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idanalise_swot->Visible) { // idanalise_swot ?>
    <tr id="r_idanalise_swot"<?= $Page->idanalise_swot->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_swot_idanalise_swot"><?= $Page->idanalise_swot->caption() ?></span></td>
        <td data-name="idanalise_swot"<?= $Page->idanalise_swot->cellAttributes() ?>>
<span id="el_analise_swot_idanalise_swot">
<span<?= $Page->idanalise_swot->viewAttributes() ?>>
<?= $Page->idanalise_swot->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_swot_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_analise_swot_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fatores->Visible) { // fatores ?>
    <tr id="r_fatores"<?= $Page->fatores->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_swot_fatores"><?= $Page->fatores->caption() ?></span></td>
        <td data-name="fatores"<?= $Page->fatores->cellAttributes() ?>>
<span id="el_analise_swot_fatores">
<span<?= $Page->fatores->viewAttributes() ?>>
<?= $Page->fatores->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ponto->Visible) { // ponto ?>
    <tr id="r_ponto"<?= $Page->ponto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_swot_ponto"><?= $Page->ponto->caption() ?></span></td>
        <td data-name="ponto"<?= $Page->ponto->cellAttributes() ?>>
<span id="el_analise_swot_ponto">
<span<?= $Page->ponto->viewAttributes() ?>>
<?= $Page->ponto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->analise->Visible) { // analise ?>
    <tr id="r_analise"<?= $Page->analise->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_swot_analise"><?= $Page->analise->caption() ?></span></td>
        <td data-name="analise"<?= $Page->analise->cellAttributes() ?>>
<span id="el_analise_swot_analise">
<span<?= $Page->analise->viewAttributes() ?>>
<?= $Page->analise->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
    <tr id="r_impacto_idimpacto"<?= $Page->impacto_idimpacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_swot_impacto_idimpacto"><?= $Page->impacto_idimpacto->caption() ?></span></td>
        <td data-name="impacto_idimpacto"<?= $Page->impacto_idimpacto->cellAttributes() ?>>
<span id="el_analise_swot_impacto_idimpacto">
<span<?= $Page->impacto_idimpacto->viewAttributes() ?>>
<?= $Page->impacto_idimpacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contexto_idcontexto->Visible) { // contexto_idcontexto ?>
    <tr id="r_contexto_idcontexto"<?= $Page->contexto_idcontexto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_swot_contexto_idcontexto"><?= $Page->contexto_idcontexto->caption() ?></span></td>
        <td data-name="contexto_idcontexto"<?= $Page->contexto_idcontexto->cellAttributes() ?>>
<span id="el_analise_swot_contexto_idcontexto">
<span<?= $Page->contexto_idcontexto->viewAttributes() ?>>
<?= $Page->contexto_idcontexto->getViewValue() ?></span>
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
