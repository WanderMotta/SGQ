<?php

namespace PHPMaker2024\sgq;

// Page object
$RiscoOportunidadeView = &$Page;
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
<form name="frisco_oportunidadeview" id="frisco_oportunidadeview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { risco_oportunidade: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var frisco_oportunidadeview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frisco_oportunidadeview")
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
<input type="hidden" name="t" value="risco_oportunidade">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idrisco_oportunidade->Visible) { // idrisco_oportunidade ?>
    <tr id="r_idrisco_oportunidade"<?= $Page->idrisco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_idrisco_oportunidade"><?= $Page->idrisco_oportunidade->caption() ?></span></td>
        <td data-name="idrisco_oportunidade"<?= $Page->idrisco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_idrisco_oportunidade">
<span<?= $Page->idrisco_oportunidade->viewAttributes() ?>>
<?= $Page->idrisco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_risco_oportunidade_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
    <tr id="r_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() ?></span></td>
        <td data-name="tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade">
<span<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->viewAttributes() ?>>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <tr id="r_titulo"<?= $Page->titulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_titulo"><?= $Page->titulo->caption() ?></span></td>
        <td data-name="titulo"<?= $Page->titulo->cellAttributes() ?>>
<span id="el_risco_oportunidade_titulo">
<span<?= $Page->titulo->viewAttributes() ?>>
<?= $Page->titulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <tr id="r_origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?></span></td>
        <td data-name="origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade">
<span<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
    <tr id="r_descricao"<?= $Page->descricao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_descricao"><?= $Page->descricao->caption() ?></span></td>
        <td data-name="descricao"<?= $Page->descricao->cellAttributes() ?>>
<span id="el_risco_oportunidade_descricao">
<span<?= $Page->descricao->viewAttributes() ?>>
<?= $Page->descricao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->consequencia->Visible) { // consequencia ?>
    <tr id="r_consequencia"<?= $Page->consequencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_consequencia"><?= $Page->consequencia->caption() ?></span></td>
        <td data-name="consequencia"<?= $Page->consequencia->cellAttributes() ?>>
<span id="el_risco_oportunidade_consequencia">
<span<?= $Page->consequencia->viewAttributes() ?>>
<?= $Page->consequencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->frequencia_idfrequencia->Visible) { // frequencia_idfrequencia ?>
    <tr id="r_frequencia_idfrequencia"<?= $Page->frequencia_idfrequencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_frequencia_idfrequencia"><?= $Page->frequencia_idfrequencia->caption() ?></span></td>
        <td data-name="frequencia_idfrequencia"<?= $Page->frequencia_idfrequencia->cellAttributes() ?>>
<span id="el_risco_oportunidade_frequencia_idfrequencia">
<span<?= $Page->frequencia_idfrequencia->viewAttributes() ?>>
<?= $Page->frequencia_idfrequencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
    <tr id="r_impacto_idimpacto"<?= $Page->impacto_idimpacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_impacto_idimpacto"><?= $Page->impacto_idimpacto->caption() ?></span></td>
        <td data-name="impacto_idimpacto"<?= $Page->impacto_idimpacto->cellAttributes() ?>>
<span id="el_risco_oportunidade_impacto_idimpacto">
<span<?= $Page->impacto_idimpacto->viewAttributes() ?>>
<?= $Page->impacto_idimpacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->grau_atencao->Visible) { // grau_atencao ?>
    <tr id="r_grau_atencao"<?= $Page->grau_atencao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_grau_atencao"><?= $Page->grau_atencao->caption() ?></span></td>
        <td data-name="grau_atencao"<?= $Page->grau_atencao->cellAttributes() ?>>
<span id="el_risco_oportunidade_grau_atencao">
<span<?= $Page->grau_atencao->viewAttributes() ?>>
<?= $Page->grau_atencao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->acao_risco_oportunidade_idacao_risco_oportunidade->Visible) { // acao_risco_oportunidade_idacao_risco_oportunidade ?>
    <tr id="r_acao_risco_oportunidade_idacao_risco_oportunidade"<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade"><?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->caption() ?></span></td>
        <td data-name="acao_risco_oportunidade_idacao_risco_oportunidade"<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade">
<span<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->viewAttributes() ?>>
<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { // plano_acao ?>
    <tr id="r_plano_acao"<?= $Page->plano_acao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_risco_oportunidade_plano_acao"><?= $Page->plano_acao->caption() ?></span></td>
        <td data-name="plano_acao"<?= $Page->plano_acao->cellAttributes() ?>>
<span id="el_risco_oportunidade_plano_acao">
<span<?= $Page->plano_acao->viewAttributes() ?>>
<?= $Page->plano_acao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("plano_acao", explode(",", $Page->getCurrentDetailTable())) && $plano_acao->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("plano_acao", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PlanoAcaoGrid.php" ?>
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
