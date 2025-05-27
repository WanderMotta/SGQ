<?php

namespace PHPMaker2024\sgq;

// Page object
$RelatorioAuditoriaInternaView = &$Page;
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
<form name="frelatorio_auditoria_internaview" id="frelatorio_auditoria_internaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { relatorio_auditoria_interna: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var frelatorio_auditoria_internaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frelatorio_auditoria_internaview")
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
<input type="hidden" name="t" value="relatorio_auditoria_interna">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idrelatorio_auditoria_interna->Visible) { // idrelatorio_auditoria_interna ?>
    <tr id="r_idrelatorio_auditoria_interna"<?= $Page->idrelatorio_auditoria_interna->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_auditoria_interna_idrelatorio_auditoria_interna"><?= $Page->idrelatorio_auditoria_interna->caption() ?></span></td>
        <td data-name="idrelatorio_auditoria_interna"<?= $Page->idrelatorio_auditoria_interna->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_idrelatorio_auditoria_interna">
<span<?= $Page->idrelatorio_auditoria_interna->viewAttributes() ?>>
<?= $Page->idrelatorio_auditoria_interna->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
    <tr id="r_data"<?= $Page->data->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_auditoria_interna_data"><?= $Page->data->caption() ?></span></td>
        <td data-name="data"<?= $Page->data->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_data">
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <tr id="r_origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_auditoria_interna_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?></span></td>
        <td data-name="origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_origem_risco_oportunidade_idorigem_risco_oportunidade">
<span<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->auditor->Visible) { // auditor ?>
    <tr id="r_auditor"<?= $Page->auditor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_auditoria_interna_auditor"><?= $Page->auditor->caption() ?></span></td>
        <td data-name="auditor"<?= $Page->auditor->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_auditor">
<span<?= $Page->auditor->viewAttributes() ?>>
<?= $Page->auditor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aprovador->Visible) { // aprovador ?>
    <tr id="r_aprovador"<?= $Page->aprovador->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_relatorio_auditoria_interna_aprovador"><?= $Page->aprovador->caption() ?></span></td>
        <td data-name="aprovador"<?= $Page->aprovador->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_aprovador">
<span<?= $Page->aprovador->viewAttributes() ?>>
<?= $Page->aprovador->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("item_rel_aud_interna", explode(",", $Page->getCurrentDetailTable())) && $item_rel_aud_interna->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("item_rel_aud_interna", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ItemRelAudInternaGrid.php" ?>
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
