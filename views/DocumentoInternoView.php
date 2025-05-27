<?php

namespace PHPMaker2024\sgq;

// Page object
$DocumentoInternoView = &$Page;
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
<form name="fdocumento_internoview" id="fdocumento_internoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_interno: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fdocumento_internoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdocumento_internoview")
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
<input type="hidden" name="t" value="documento_interno">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->iddocumento_interno->Visible) { // iddocumento_interno ?>
    <tr id="r_iddocumento_interno"<?= $Page->iddocumento_interno->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_interno_iddocumento_interno"><?= $Page->iddocumento_interno->caption() ?></span></td>
        <td data-name="iddocumento_interno"<?= $Page->iddocumento_interno->cellAttributes() ?>>
<span id="el_documento_interno_iddocumento_interno">
<span<?= $Page->iddocumento_interno->viewAttributes() ?>>
<?= $Page->iddocumento_interno->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
    <tr id="r_titulo_documento"<?= $Page->titulo_documento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_interno_titulo_documento"><?= $Page->titulo_documento->caption() ?></span></td>
        <td data-name="titulo_documento"<?= $Page->titulo_documento->cellAttributes() ?>>
<span id="el_documento_interno_titulo_documento">
<span<?= $Page->titulo_documento->viewAttributes() ?>>
<?= $Page->titulo_documento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_interno_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_documento_interno_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
    <tr id="r_restringir_acesso"<?= $Page->restringir_acesso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_interno_restringir_acesso"><?= $Page->restringir_acesso->caption() ?></span></td>
        <td data-name="restringir_acesso"<?= $Page->restringir_acesso->cellAttributes() ?>>
<span id="el_documento_interno_restringir_acesso">
<span<?= $Page->restringir_acesso->viewAttributes() ?>>
<?= $Page->restringir_acesso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
    <tr id="r_categoria_documento_idcategoria_documento"<?= $Page->categoria_documento_idcategoria_documento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_interno_categoria_documento_idcategoria_documento"><?= $Page->categoria_documento_idcategoria_documento->caption() ?></span></td>
        <td data-name="categoria_documento_idcategoria_documento"<?= $Page->categoria_documento_idcategoria_documento->cellAttributes() ?>>
<span id="el_documento_interno_categoria_documento_idcategoria_documento">
<span<?= $Page->categoria_documento_idcategoria_documento->viewAttributes() ?>>
<?= $Page->categoria_documento_idcategoria_documento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <tr id="r_processo_idprocesso"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_interno_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span></td>
        <td data-name="processo_idprocesso"<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el_documento_interno_processo_idprocesso">
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <tr id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_interno_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></td>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_documento_interno_usuario_idusuario">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("revisao_documento", explode(",", $Page->getCurrentDetailTable())) && $revisao_documento->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("revisao_documento", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "RevisaoDocumentoGrid.php" ?>
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
