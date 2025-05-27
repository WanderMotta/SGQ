<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAuditoriaIntView = &$Page;
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
<form name="fplano_auditoria_intview" id="fplano_auditoria_intview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_auditoria_int: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fplano_auditoria_intview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplano_auditoria_intview")
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
<input type="hidden" name="t" value="plano_auditoria_int">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idplano_auditoria_int->Visible) { // idplano_auditoria_int ?>
    <tr id="r_idplano_auditoria_int"<?= $Page->idplano_auditoria_int->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_auditoria_int_idplano_auditoria_int"><?= $Page->idplano_auditoria_int->caption() ?></span></td>
        <td data-name="idplano_auditoria_int"<?= $Page->idplano_auditoria_int->cellAttributes() ?>>
<span id="el_plano_auditoria_int_idplano_auditoria_int">
<span<?= $Page->idplano_auditoria_int->viewAttributes() ?>>
<?= $Page->idplano_auditoria_int->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
    <tr id="r_data"<?= $Page->data->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_auditoria_int_data"><?= $Page->data->caption() ?></span></td>
        <td data-name="data"<?= $Page->data->cellAttributes() ?>>
<span id="el_plano_auditoria_int_data">
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <tr id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_auditoria_int_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></td>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_plano_auditoria_int_usuario_idusuario">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->criterio->Visible) { // criterio ?>
    <tr id="r_criterio"<?= $Page->criterio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_auditoria_int_criterio"><?= $Page->criterio->caption() ?></span></td>
        <td data-name="criterio"<?= $Page->criterio->cellAttributes() ?>>
<span id="el_plano_auditoria_int_criterio">
<span<?= $Page->criterio->viewAttributes() ?>>
<?= $Page->criterio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->arquivo->Visible) { // arquivo ?>
    <tr id="r_arquivo"<?= $Page->arquivo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_auditoria_int_arquivo"><?= $Page->arquivo->caption() ?></span></td>
        <td data-name="arquivo"<?= $Page->arquivo->cellAttributes() ?>>
<span id="el_plano_auditoria_int_arquivo">
<span<?= $Page->arquivo->viewAttributes() ?>>
<?= GetFileViewTag($Page->arquivo, $Page->arquivo->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("item_plano_aud_int", explode(",", $Page->getCurrentDetailTable())) && $item_plano_aud_int->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("item_plano_aud_int", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ItemPlanoAudIntGrid.php" ?>
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
