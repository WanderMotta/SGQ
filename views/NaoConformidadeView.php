<?php

namespace PHPMaker2024\sgq;

// Page object
$NaoConformidadeView = &$Page;
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
<form name="fnao_conformidadeview" id="fnao_conformidadeview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { nao_conformidade: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fnao_conformidadeview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fnao_conformidadeview")
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
<input type="hidden" name="t" value="nao_conformidade">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idnao_conformidade->Visible) { // idnao_conformidade ?>
    <tr id="r_idnao_conformidade"<?= $Page->idnao_conformidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_idnao_conformidade"><?= $Page->idnao_conformidade->caption() ?></span></td>
        <td data-name="idnao_conformidade"<?= $Page->idnao_conformidade->cellAttributes() ?>>
<span id="el_nao_conformidade_idnao_conformidade">
<span<?= $Page->idnao_conformidade->viewAttributes() ?>>
<?= $Page->idnao_conformidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_ocorrencia->Visible) { // dt_ocorrencia ?>
    <tr id="r_dt_ocorrencia"<?= $Page->dt_ocorrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_dt_ocorrencia"><?= $Page->dt_ocorrencia->caption() ?></span></td>
        <td data-name="dt_ocorrencia"<?= $Page->dt_ocorrencia->cellAttributes() ?>>
<span id="el_nao_conformidade_dt_ocorrencia">
<span<?= $Page->dt_ocorrencia->viewAttributes() ?>>
<?= $Page->dt_ocorrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <tr id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_tipo"><?= $Page->tipo->caption() ?></span></td>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el_nao_conformidade_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <tr id="r_titulo"<?= $Page->titulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_titulo"><?= $Page->titulo->caption() ?></span></td>
        <td data-name="titulo"<?= $Page->titulo->cellAttributes() ?>>
<span id="el_nao_conformidade_titulo">
<span<?= $Page->titulo->viewAttributes() ?>>
<?= $Page->titulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <tr id="r_processo_idprocesso"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span></td>
        <td data-name="processo_idprocesso"<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el_nao_conformidade_processo_idprocesso">
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ocorrencia->Visible) { // ocorrencia ?>
    <tr id="r_ocorrencia"<?= $Page->ocorrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_ocorrencia"><?= $Page->ocorrencia->caption() ?></span></td>
        <td data-name="ocorrencia"<?= $Page->ocorrencia->cellAttributes() ?>>
<span id="el_nao_conformidade_ocorrencia">
<span<?= $Page->ocorrencia->viewAttributes() ?>>
<?= $Page->ocorrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <tr id="r_origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?></span></td>
        <td data-name="origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el_nao_conformidade_origem_risco_oportunidade_idorigem_risco_oportunidade">
<span<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->acao_imediata->Visible) { // acao_imediata ?>
    <tr id="r_acao_imediata"<?= $Page->acao_imediata->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_acao_imediata"><?= $Page->acao_imediata->caption() ?></span></td>
        <td data-name="acao_imediata"<?= $Page->acao_imediata->cellAttributes() ?>>
<span id="el_nao_conformidade_acao_imediata">
<span<?= $Page->acao_imediata->viewAttributes() ?>>
<?= $Page->acao_imediata->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->causa_raiz->Visible) { // causa_raiz ?>
    <tr id="r_causa_raiz"<?= $Page->causa_raiz->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_causa_raiz"><?= $Page->causa_raiz->caption() ?></span></td>
        <td data-name="causa_raiz"<?= $Page->causa_raiz->cellAttributes() ?>>
<span id="el_nao_conformidade_causa_raiz">
<span<?= $Page->causa_raiz->viewAttributes() ?>>
<?= $Page->causa_raiz->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <tr id="r_departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_departamentos_iddepartamentos"><?= $Page->departamentos_iddepartamentos->caption() ?></span></td>
        <td data-name="departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el_nao_conformidade_departamentos_iddepartamentos">
<span<?= $Page->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Page->departamentos_iddepartamentos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
    <tr id="r_anexo"<?= $Page->anexo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_anexo"><?= $Page->anexo->caption() ?></span></td>
        <td data-name="anexo"<?= $Page->anexo->cellAttributes() ?>>
<span id="el_nao_conformidade_anexo">
<span<?= $Page->anexo->viewAttributes() ?>>
<?= GetFileViewTag($Page->anexo, $Page->anexo->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_nc->Visible) { // status_nc ?>
    <tr id="r_status_nc"<?= $Page->status_nc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_status_nc"><?= $Page->status_nc->caption() ?></span></td>
        <td data-name="status_nc"<?= $Page->status_nc->cellAttributes() ?>>
<span id="el_nao_conformidade_status_nc">
<span<?= $Page->status_nc->viewAttributes() ?>>
<?= $Page->status_nc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { // plano_acao ?>
    <tr id="r_plano_acao"<?= $Page->plano_acao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_nao_conformidade_plano_acao"><?= $Page->plano_acao->caption() ?></span></td>
        <td data-name="plano_acao"<?= $Page->plano_acao->cellAttributes() ?>>
<span id="el_nao_conformidade_plano_acao">
<span<?= $Page->plano_acao->viewAttributes() ?>>
<?= $Page->plano_acao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("plano_acao_nc", explode(",", $Page->getCurrentDetailTable())) && $plano_acao_nc->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("plano_acao_nc", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PlanoAcaoNcGrid.php" ?>
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
