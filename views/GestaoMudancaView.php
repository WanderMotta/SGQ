<?php

namespace PHPMaker2024\sgq;

// Page object
$GestaoMudancaView = &$Page;
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
<form name="fgestao_mudancaview" id="fgestao_mudancaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { gestao_mudanca: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fgestao_mudancaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fgestao_mudancaview")
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
<input type="hidden" name="t" value="gestao_mudanca">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idgestao_mudanca->Visible) { // idgestao_mudanca ?>
    <tr id="r_idgestao_mudanca"<?= $Page->idgestao_mudanca->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_idgestao_mudanca"><?= $Page->idgestao_mudanca->caption() ?></span></td>
        <td data-name="idgestao_mudanca"<?= $Page->idgestao_mudanca->cellAttributes() ?>>
<span id="el_gestao_mudanca_idgestao_mudanca">
<span<?= $Page->idgestao_mudanca->viewAttributes() ?>>
<?= $Page->idgestao_mudanca->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_gestao_mudanca_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <tr id="r_titulo"<?= $Page->titulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_titulo"><?= $Page->titulo->caption() ?></span></td>
        <td data-name="titulo"<?= $Page->titulo->cellAttributes() ?>>
<span id="el_gestao_mudanca_titulo">
<span<?= $Page->titulo->viewAttributes() ?>>
<?= $Page->titulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_inicio->Visible) { // dt_inicio ?>
    <tr id="r_dt_inicio"<?= $Page->dt_inicio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_dt_inicio"><?= $Page->dt_inicio->caption() ?></span></td>
        <td data-name="dt_inicio"<?= $Page->dt_inicio->cellAttributes() ?>>
<span id="el_gestao_mudanca_dt_inicio">
<span<?= $Page->dt_inicio->viewAttributes() ?>>
<?= $Page->dt_inicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->detalhamento->Visible) { // detalhamento ?>
    <tr id="r_detalhamento"<?= $Page->detalhamento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_detalhamento"><?= $Page->detalhamento->caption() ?></span></td>
        <td data-name="detalhamento"<?= $Page->detalhamento->cellAttributes() ?>>
<span id="el_gestao_mudanca_detalhamento">
<span<?= $Page->detalhamento->viewAttributes() ?>>
<?= $Page->detalhamento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->impacto->Visible) { // impacto ?>
    <tr id="r_impacto"<?= $Page->impacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_impacto"><?= $Page->impacto->caption() ?></span></td>
        <td data-name="impacto"<?= $Page->impacto->cellAttributes() ?>>
<span id="el_gestao_mudanca_impacto">
<span<?= $Page->impacto->viewAttributes() ?>>
<?= $Page->impacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
    <tr id="r_motivo"<?= $Page->motivo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_motivo"><?= $Page->motivo->caption() ?></span></td>
        <td data-name="motivo"<?= $Page->motivo->cellAttributes() ?>>
<span id="el_gestao_mudanca_motivo">
<span<?= $Page->motivo->viewAttributes() ?>>
<?= $Page->motivo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->recursos->Visible) { // recursos ?>
    <tr id="r_recursos"<?= $Page->recursos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_recursos"><?= $Page->recursos->caption() ?></span></td>
        <td data-name="recursos"<?= $Page->recursos->cellAttributes() ?>>
<span id="el_gestao_mudanca_recursos">
<span<?= $Page->recursos->viewAttributes() ?>>
<?= $Page->recursos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->prazo_ate->Visible) { // prazo_ate ?>
    <tr id="r_prazo_ate"<?= $Page->prazo_ate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_prazo_ate"><?= $Page->prazo_ate->caption() ?></span></td>
        <td data-name="prazo_ate"<?= $Page->prazo_ate->cellAttributes() ?>>
<span id="el_gestao_mudanca_prazo_ate">
<span<?= $Page->prazo_ate->viewAttributes() ?>>
<?= $Page->prazo_ate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <tr id="r_departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_departamentos_iddepartamentos"><?= $Page->departamentos_iddepartamentos->caption() ?></span></td>
        <td data-name="departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el_gestao_mudanca_departamentos_iddepartamentos">
<span<?= $Page->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Page->departamentos_iddepartamentos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <tr id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></td>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_gestao_mudanca_usuario_idusuario">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
    <tr id="r_implementado"<?= $Page->implementado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_implementado"><?= $Page->implementado->caption() ?></span></td>
        <td data-name="implementado"<?= $Page->implementado->cellAttributes() ?>>
<span id="el_gestao_mudanca_implementado">
<span<?= $Page->implementado->viewAttributes() ?>>
<?= $Page->implementado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_gestao_mudanca_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
    <tr id="r_eficaz"<?= $Page->eficaz->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_gestao_mudanca_eficaz"><?= $Page->eficaz->caption() ?></span></td>
        <td data-name="eficaz"<?= $Page->eficaz->cellAttributes() ?>>
<span id="el_gestao_mudanca_eficaz">
<span<?= $Page->eficaz->viewAttributes() ?>>
<?= $Page->eficaz->getViewValue() ?></span>
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
