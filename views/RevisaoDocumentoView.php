<?php

namespace PHPMaker2024\sgq;

// Page object
$RevisaoDocumentoView = &$Page;
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
<form name="frevisao_documentoview" id="frevisao_documentoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { revisao_documento: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var frevisao_documentoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frevisao_documentoview")
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
<input type="hidden" name="t" value="revisao_documento">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idrevisao_documento->Visible) { // idrevisao_documento ?>
    <tr id="r_idrevisao_documento"<?= $Page->idrevisao_documento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_revisao_documento_idrevisao_documento"><?= $Page->idrevisao_documento->caption() ?></span></td>
        <td data-name="idrevisao_documento"<?= $Page->idrevisao_documento->cellAttributes() ?>>
<span id="el_revisao_documento_idrevisao_documento">
<span<?= $Page->idrevisao_documento->viewAttributes() ?>>
<?= $Page->idrevisao_documento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->documento_interno_iddocumento_interno->Visible) { // documento_interno_iddocumento_interno ?>
    <tr id="r_documento_interno_iddocumento_interno"<?= $Page->documento_interno_iddocumento_interno->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_revisao_documento_documento_interno_iddocumento_interno"><?= $Page->documento_interno_iddocumento_interno->caption() ?></span></td>
        <td data-name="documento_interno_iddocumento_interno"<?= $Page->documento_interno_iddocumento_interno->cellAttributes() ?>>
<span id="el_revisao_documento_documento_interno_iddocumento_interno">
<span<?= $Page->documento_interno_iddocumento_interno->viewAttributes() ?>>
<?= $Page->documento_interno_iddocumento_interno->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_revisao_documento_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_revisao_documento_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->qual_alteracao->Visible) { // qual_alteracao ?>
    <tr id="r_qual_alteracao"<?= $Page->qual_alteracao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_revisao_documento_qual_alteracao"><?= $Page->qual_alteracao->caption() ?></span></td>
        <td data-name="qual_alteracao"<?= $Page->qual_alteracao->cellAttributes() ?>>
<span id="el_revisao_documento_qual_alteracao">
<span<?= $Page->qual_alteracao->viewAttributes() ?>>
<?= $Page->qual_alteracao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
    <tr id="r_status_documento_idstatus_documento"<?= $Page->status_documento_idstatus_documento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_revisao_documento_status_documento_idstatus_documento"><?= $Page->status_documento_idstatus_documento->caption() ?></span></td>
        <td data-name="status_documento_idstatus_documento"<?= $Page->status_documento_idstatus_documento->cellAttributes() ?>>
<span id="el_revisao_documento_status_documento_idstatus_documento">
<span<?= $Page->status_documento_idstatus_documento->viewAttributes() ?>>
<?= $Page->status_documento_idstatus_documento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->revisao_nr->Visible) { // revisao_nr ?>
    <tr id="r_revisao_nr"<?= $Page->revisao_nr->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_revisao_documento_revisao_nr"><?= $Page->revisao_nr->caption() ?></span></td>
        <td data-name="revisao_nr"<?= $Page->revisao_nr->cellAttributes() ?>>
<span id="el_revisao_documento_revisao_nr">
<span<?= $Page->revisao_nr->viewAttributes() ?>>
<?= $Page->revisao_nr->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_elaborador->Visible) { // usuario_elaborador ?>
    <tr id="r_usuario_elaborador"<?= $Page->usuario_elaborador->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_revisao_documento_usuario_elaborador"><?= $Page->usuario_elaborador->caption() ?></span></td>
        <td data-name="usuario_elaborador"<?= $Page->usuario_elaborador->cellAttributes() ?>>
<span id="el_revisao_documento_usuario_elaborador">
<span<?= $Page->usuario_elaborador->viewAttributes() ?>>
<?= $Page->usuario_elaborador->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_aprovador->Visible) { // usuario_aprovador ?>
    <tr id="r_usuario_aprovador"<?= $Page->usuario_aprovador->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_revisao_documento_usuario_aprovador"><?= $Page->usuario_aprovador->caption() ?></span></td>
        <td data-name="usuario_aprovador"<?= $Page->usuario_aprovador->cellAttributes() ?>>
<span id="el_revisao_documento_usuario_aprovador">
<span<?= $Page->usuario_aprovador->viewAttributes() ?>>
<?= $Page->usuario_aprovador->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_aprovacao->Visible) { // dt_aprovacao ?>
    <tr id="r_dt_aprovacao"<?= $Page->dt_aprovacao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_revisao_documento_dt_aprovacao"><?= $Page->dt_aprovacao->caption() ?></span></td>
        <td data-name="dt_aprovacao"<?= $Page->dt_aprovacao->cellAttributes() ?>>
<span id="el_revisao_documento_dt_aprovacao">
<span<?= $Page->dt_aprovacao->viewAttributes() ?>>
<?= $Page->dt_aprovacao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
    <tr id="r_anexo"<?= $Page->anexo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_revisao_documento_anexo"><?= $Page->anexo->caption() ?></span></td>
        <td data-name="anexo"<?= $Page->anexo->cellAttributes() ?>>
<span id="el_revisao_documento_anexo">
<span<?= $Page->anexo->viewAttributes() ?>>
<?= GetFileViewTag($Page->anexo, $Page->anexo->getViewValue(), false) ?>
</span>
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
