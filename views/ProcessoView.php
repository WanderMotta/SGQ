<?php

namespace PHPMaker2024\sgq;

// Page object
$ProcessoView = &$Page;
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
<form name="fprocessoview" id="fprocessoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { processo: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fprocessoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fprocessoview")
        .setPageId("view")

        // Multi-Page
        .setMultiPage(true)
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
<input type="hidden" name="t" value="processo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (!$Page->isExport()) { ?>
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_ProcessoView"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_processo1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_processo2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(3) ?>" data-bs-target="#tab_processo3" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo3" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(3)) ?>"><?= $Page->pageCaption(3) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(4) ?>" data-bs-target="#tab_processo4" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo4" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(4)) ?>"><?= $Page->pageCaption(4) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(5) ?>" data-bs-target="#tab_processo5" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo5" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(5)) ?>"><?= $Page->pageCaption(5) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(6) ?>" data-bs-target="#tab_processo6" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo6" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(6)) ?>"><?= $Page->pageCaption(6) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>">
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_processo1" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idprocesso->Visible) { // idprocesso ?>
    <tr id="r_idprocesso"<?= $Page->idprocesso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_idprocesso"><?= $Page->idprocesso->caption() ?></span></td>
        <td data-name="idprocesso"<?= $Page->idprocesso->cellAttributes() ?>>
<span id="el_processo_idprocesso" data-page="1">
<span<?= $Page->idprocesso->viewAttributes() ?>>
<?= $Page->idprocesso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_processo_dt_cadastro" data-page="1">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->revisao->Visible) { // revisao ?>
    <tr id="r_revisao"<?= $Page->revisao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_revisao"><?= $Page->revisao->caption() ?></span></td>
        <td data-name="revisao"<?= $Page->revisao->cellAttributes() ?>>
<span id="el_processo_revisao" data-page="1">
<span<?= $Page->revisao->viewAttributes() ?>>
<?= $Page->revisao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_idtipo->Visible) { // tipo_idtipo ?>
    <tr id="r_tipo_idtipo"<?= $Page->tipo_idtipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_tipo_idtipo"><?= $Page->tipo_idtipo->caption() ?></span></td>
        <td data-name="tipo_idtipo"<?= $Page->tipo_idtipo->cellAttributes() ?>>
<span id="el_processo_tipo_idtipo" data-page="1">
<span<?= $Page->tipo_idtipo->viewAttributes() ?>>
<?= $Page->tipo_idtipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->processo->Visible) { // processo ?>
    <tr id="r_processo"<?= $Page->processo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_processo"><?= $Page->processo->caption() ?></span></td>
        <td data-name="processo"<?= $Page->processo->cellAttributes() ?>>
<span id="el_processo_processo" data-page="1">
<span<?= $Page->processo->viewAttributes() ?>>
<?= $Page->processo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->responsaveis->Visible) { // responsaveis ?>
    <tr id="r_responsaveis"<?= $Page->responsaveis->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_responsaveis"><?= $Page->responsaveis->caption() ?></span></td>
        <td data-name="responsaveis"<?= $Page->responsaveis->cellAttributes() ?>>
<span id="el_processo_responsaveis" data-page="1">
<span<?= $Page->responsaveis->viewAttributes() ?>>
<?= $Page->responsaveis->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->objetivo->Visible) { // objetivo ?>
    <tr id="r_objetivo"<?= $Page->objetivo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_objetivo"><?= $Page->objetivo->caption() ?></span></td>
        <td data-name="objetivo"<?= $Page->objetivo->cellAttributes() ?>>
<span id="el_processo_objetivo" data-page="1">
<span<?= $Page->objetivo->viewAttributes() ?>>
<?= $Page->objetivo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->proc_antes->Visible) { // proc_antes ?>
    <tr id="r_proc_antes"<?= $Page->proc_antes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_proc_antes"><?= $Page->proc_antes->caption() ?></span></td>
        <td data-name="proc_antes"<?= $Page->proc_antes->cellAttributes() ?>>
<span id="el_processo_proc_antes" data-page="1">
<span<?= $Page->proc_antes->viewAttributes() ?>>
<?= $Page->proc_antes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->proc_depois->Visible) { // proc_depois ?>
    <tr id="r_proc_depois"<?= $Page->proc_depois->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_proc_depois"><?= $Page->proc_depois->caption() ?></span></td>
        <td data-name="proc_depois"<?= $Page->proc_depois->cellAttributes() ?>>
<span id="el_processo_proc_depois" data-page="1">
<span<?= $Page->proc_depois->viewAttributes() ?>>
<?= $Page->proc_depois->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_processo2" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->eqpto_recursos->Visible) { // eqpto_recursos ?>
    <tr id="r_eqpto_recursos"<?= $Page->eqpto_recursos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_eqpto_recursos"><?= $Page->eqpto_recursos->caption() ?></span></td>
        <td data-name="eqpto_recursos"<?= $Page->eqpto_recursos->cellAttributes() ?>>
<span id="el_processo_eqpto_recursos" data-page="2">
<span<?= $Page->eqpto_recursos->viewAttributes() ?>>
<?= $Page->eqpto_recursos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->entradas->Visible) { // entradas ?>
    <tr id="r_entradas"<?= $Page->entradas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_entradas"><?= $Page->entradas->caption() ?></span></td>
        <td data-name="entradas"<?= $Page->entradas->cellAttributes() ?>>
<span id="el_processo_entradas" data-page="2">
<span<?= $Page->entradas->viewAttributes() ?>>
<?= $Page->entradas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(3) ?>" id="tab_processo3" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->atividade_principal->Visible) { // atividade_principal ?>
    <tr id="r_atividade_principal"<?= $Page->atividade_principal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_atividade_principal"><?= $Page->atividade_principal->caption() ?></span></td>
        <td data-name="atividade_principal"<?= $Page->atividade_principal->cellAttributes() ?>>
<span id="el_processo_atividade_principal" data-page="3">
<span<?= $Page->atividade_principal->viewAttributes() ?>>
<?= $Page->atividade_principal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->saidas_resultados->Visible) { // saidas_resultados ?>
    <tr id="r_saidas_resultados"<?= $Page->saidas_resultados->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_saidas_resultados"><?= $Page->saidas_resultados->caption() ?></span></td>
        <td data-name="saidas_resultados"<?= $Page->saidas_resultados->cellAttributes() ?>>
<span id="el_processo_saidas_resultados" data-page="3">
<span<?= $Page->saidas_resultados->viewAttributes() ?>>
<?= $Page->saidas_resultados->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->requsito_saidas->Visible) { // requsito_saidas ?>
    <tr id="r_requsito_saidas"<?= $Page->requsito_saidas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_requsito_saidas"><?= $Page->requsito_saidas->caption() ?></span></td>
        <td data-name="requsito_saidas"<?= $Page->requsito_saidas->cellAttributes() ?>>
<span id="el_processo_requsito_saidas" data-page="3">
<span<?= $Page->requsito_saidas->viewAttributes() ?>>
<?= $Page->requsito_saidas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(4) ?>" id="tab_processo4" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->riscos->Visible) { // riscos ?>
    <tr id="r_riscos"<?= $Page->riscos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_riscos"><?= $Page->riscos->caption() ?></span></td>
        <td data-name="riscos"<?= $Page->riscos->cellAttributes() ?>>
<span id="el_processo_riscos" data-page="4">
<span<?= $Page->riscos->viewAttributes() ?>>
<?= $Page->riscos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->oportunidades->Visible) { // oportunidades ?>
    <tr id="r_oportunidades"<?= $Page->oportunidades->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_oportunidades"><?= $Page->oportunidades->caption() ?></span></td>
        <td data-name="oportunidades"<?= $Page->oportunidades->cellAttributes() ?>>
<span id="el_processo_oportunidades" data-page="4">
<span<?= $Page->oportunidades->viewAttributes() ?>>
<?= $Page->oportunidades->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(5) ?>" id="tab_processo5" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->propriedade_externa->Visible) { // propriedade_externa ?>
    <tr id="r_propriedade_externa"<?= $Page->propriedade_externa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_propriedade_externa"><?= $Page->propriedade_externa->caption() ?></span></td>
        <td data-name="propriedade_externa"<?= $Page->propriedade_externa->cellAttributes() ?>>
<span id="el_processo_propriedade_externa" data-page="5">
<span<?= $Page->propriedade_externa->viewAttributes() ?>>
<?= $Page->propriedade_externa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->conhecimentos->Visible) { // conhecimentos ?>
    <tr id="r_conhecimentos"<?= $Page->conhecimentos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_conhecimentos"><?= $Page->conhecimentos->caption() ?></span></td>
        <td data-name="conhecimentos"<?= $Page->conhecimentos->cellAttributes() ?>>
<span id="el_processo_conhecimentos" data-page="5">
<span<?= $Page->conhecimentos->viewAttributes() ?>>
<?= $Page->conhecimentos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->documentos_aplicados->Visible) { // documentos_aplicados ?>
    <tr id="r_documentos_aplicados"<?= $Page->documentos_aplicados->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_documentos_aplicados"><?= $Page->documentos_aplicados->caption() ?></span></td>
        <td data-name="documentos_aplicados"<?= $Page->documentos_aplicados->cellAttributes() ?>>
<span id="el_processo_documentos_aplicados" data-page="5">
<span<?= $Page->documentos_aplicados->viewAttributes() ?>>
<?= $Page->documentos_aplicados->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(6) ?>" id="tab_processo6" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->proced_int_trabalho->Visible) { // proced_int_trabalho ?>
    <tr id="r_proced_int_trabalho"<?= $Page->proced_int_trabalho->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_proced_int_trabalho"><?= $Page->proced_int_trabalho->caption() ?></span></td>
        <td data-name="proced_int_trabalho"<?= $Page->proced_int_trabalho->cellAttributes() ?>>
<span id="el_processo_proced_int_trabalho" data-page="6">
<span<?= $Page->proced_int_trabalho->viewAttributes() ?>>
<?= GetFileViewTag($Page->proced_int_trabalho, $Page->proced_int_trabalho->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mapa->Visible) { // mapa ?>
    <tr id="r_mapa"<?= $Page->mapa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_mapa"><?= $Page->mapa->caption() ?></span></td>
        <td data-name="mapa"<?= $Page->mapa->cellAttributes() ?>>
<span id="el_processo_mapa" data-page="6">
<span<?= $Page->mapa->viewAttributes() ?>>
<?= GetFileViewTag($Page->mapa, $Page->mapa->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->formulario->Visible) { // formulario ?>
    <tr id="r_formulario"<?= $Page->formulario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_formulario"><?= $Page->formulario->caption() ?></span></td>
        <td data-name="formulario"<?= $Page->formulario->cellAttributes() ?>>
<span id="el_processo_formulario" data-page="6">
<span<?= $Page->formulario->viewAttributes() ?>>
<?= GetFileViewTag($Page->formulario, $Page->formulario->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
    </div>
</div>
</div>
<?php } ?>
<?php
    if (in_array("processo_indicadores", explode(",", $Page->getCurrentDetailTable())) && $processo_indicadores->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("processo_indicadores", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ProcessoIndicadoresGrid.php" ?>
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
