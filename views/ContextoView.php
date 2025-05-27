<?php

namespace PHPMaker2024\sgq;

// Page object
$ContextoView = &$Page;
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
<form name="fcontextoview" id="fcontextoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { contexto: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcontextoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcontextoview")
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
<input type="hidden" name="t" value="contexto">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idcontexto->Visible) { // idcontexto ?>
    <tr id="r_idcontexto"<?= $Page->idcontexto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contexto_idcontexto"><?= $Page->idcontexto->caption() ?></span></td>
        <td data-name="idcontexto"<?= $Page->idcontexto->cellAttributes() ?>>
<span id="el_contexto_idcontexto">
<span<?= $Page->idcontexto->viewAttributes() ?>>
<?= $Page->idcontexto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ano->Visible) { // ano ?>
    <tr id="r_ano"<?= $Page->ano->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contexto_ano"><?= $Page->ano->caption() ?></span></td>
        <td data-name="ano"<?= $Page->ano->cellAttributes() ?>>
<span id="el_contexto_ano">
<span<?= $Page->ano->viewAttributes() ?>>
<?= $Page->ano->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->revisao->Visible) { // revisao ?>
    <tr id="r_revisao"<?= $Page->revisao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contexto_revisao"><?= $Page->revisao->caption() ?></span></td>
        <td data-name="revisao"<?= $Page->revisao->cellAttributes() ?>>
<span id="el_contexto_revisao">
<span<?= $Page->revisao->viewAttributes() ?>>
<?= $Page->revisao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
    <tr id="r_data"<?= $Page->data->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contexto_data"><?= $Page->data->caption() ?></span></td>
        <td data-name="data"<?= $Page->data->cellAttributes() ?>>
<span id="el_contexto_data">
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <tr id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contexto_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></td>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_contexto_usuario_idusuario">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_idusuario1->Visible) { // usuario_idusuario1 ?>
    <tr id="r_usuario_idusuario1"<?= $Page->usuario_idusuario1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contexto_usuario_idusuario1"><?= $Page->usuario_idusuario1->caption() ?></span></td>
        <td data-name="usuario_idusuario1"<?= $Page->usuario_idusuario1->cellAttributes() ?>>
<span id="el_contexto_usuario_idusuario1">
<span<?= $Page->usuario_idusuario1->viewAttributes() ?>>
<?= $Page->usuario_idusuario1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_contexto_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_contexto_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("analise_swot", explode(",", $Page->getCurrentDetailTable())) && $analise_swot->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("analise_swot", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AnaliseSwotGrid.php" ?>
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
