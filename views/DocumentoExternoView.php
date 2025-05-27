<?php

namespace PHPMaker2024\sgq;

// Page object
$DocumentoExternoView = &$Page;
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
<form name="fdocumento_externoview" id="fdocumento_externoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_externo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fdocumento_externoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdocumento_externoview")
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
<input type="hidden" name="t" value="documento_externo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->iddocumento_externo->Visible) { // iddocumento_externo ?>
    <tr id="r_iddocumento_externo"<?= $Page->iddocumento_externo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_externo_iddocumento_externo"><?= $Page->iddocumento_externo->caption() ?></span></td>
        <td data-name="iddocumento_externo"<?= $Page->iddocumento_externo->cellAttributes() ?>>
<span id="el_documento_externo_iddocumento_externo">
<span<?= $Page->iddocumento_externo->viewAttributes() ?>>
<?= $Page->iddocumento_externo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_externo_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_documento_externo_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
    <tr id="r_titulo_documento"<?= $Page->titulo_documento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_externo_titulo_documento"><?= $Page->titulo_documento->caption() ?></span></td>
        <td data-name="titulo_documento"<?= $Page->titulo_documento->cellAttributes() ?>>
<span id="el_documento_externo_titulo_documento">
<span<?= $Page->titulo_documento->viewAttributes() ?>>
<?= $Page->titulo_documento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->distribuicao->Visible) { // distribuicao ?>
    <tr id="r_distribuicao"<?= $Page->distribuicao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_externo_distribuicao"><?= $Page->distribuicao->caption() ?></span></td>
        <td data-name="distribuicao"<?= $Page->distribuicao->cellAttributes() ?>>
<span id="el_documento_externo_distribuicao">
<span<?= $Page->distribuicao->viewAttributes() ?>>
<?= $Page->distribuicao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tem_validade->Visible) { // tem_validade ?>
    <tr id="r_tem_validade"<?= $Page->tem_validade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_externo_tem_validade"><?= $Page->tem_validade->caption() ?></span></td>
        <td data-name="tem_validade"<?= $Page->tem_validade->cellAttributes() ?>>
<span id="el_documento_externo_tem_validade">
<span<?= $Page->tem_validade->viewAttributes() ?>>
<?= $Page->tem_validade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->valido_ate->Visible) { // valido_ate ?>
    <tr id="r_valido_ate"<?= $Page->valido_ate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_externo_valido_ate"><?= $Page->valido_ate->caption() ?></span></td>
        <td data-name="valido_ate"<?= $Page->valido_ate->cellAttributes() ?>>
<span id="el_documento_externo_valido_ate">
<span<?= $Page->valido_ate->viewAttributes() ?>>
<?= $Page->valido_ate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
    <tr id="r_restringir_acesso"<?= $Page->restringir_acesso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_externo_restringir_acesso"><?= $Page->restringir_acesso->caption() ?></span></td>
        <td data-name="restringir_acesso"<?= $Page->restringir_acesso->cellAttributes() ?>>
<span id="el_documento_externo_restringir_acesso">
<span<?= $Page->restringir_acesso->viewAttributes() ?>>
<?= $Page->restringir_acesso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->localizacao_idlocalizacao->Visible) { // localizacao_idlocalizacao ?>
    <tr id="r_localizacao_idlocalizacao"<?= $Page->localizacao_idlocalizacao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_externo_localizacao_idlocalizacao"><?= $Page->localizacao_idlocalizacao->caption() ?></span></td>
        <td data-name="localizacao_idlocalizacao"<?= $Page->localizacao_idlocalizacao->cellAttributes() ?>>
<span id="el_documento_externo_localizacao_idlocalizacao">
<span<?= $Page->localizacao_idlocalizacao->viewAttributes() ?>>
<?= $Page->localizacao_idlocalizacao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_responsavel->Visible) { // usuario_responsavel ?>
    <tr id="r_usuario_responsavel"<?= $Page->usuario_responsavel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_externo_usuario_responsavel"><?= $Page->usuario_responsavel->caption() ?></span></td>
        <td data-name="usuario_responsavel"<?= $Page->usuario_responsavel->cellAttributes() ?>>
<span id="el_documento_externo_usuario_responsavel">
<span<?= $Page->usuario_responsavel->viewAttributes() ?>>
<?= $Page->usuario_responsavel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
    <tr id="r_anexo"<?= $Page->anexo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_externo_anexo"><?= $Page->anexo->caption() ?></span></td>
        <td data-name="anexo"<?= $Page->anexo->cellAttributes() ?>>
<span id="el_documento_externo_anexo">
<span<?= $Page->anexo->viewAttributes() ?>>
<?= GetFileViewTag($Page->anexo, $Page->anexo->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_documento_externo_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_documento_externo_obs">
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
