<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseCriticaDirecaoView = &$Page;
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
<form name="fanalise_critica_direcaoview" id="fanalise_critica_direcaoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_critica_direcao: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fanalise_critica_direcaoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fanalise_critica_direcaoview")
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
<input type="hidden" name="t" value="analise_critica_direcao">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (!$Page->isExport()) { ?>
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_AnaliseCriticaDirecaoView"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_analise_critica_direcao1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_analise_critica_direcao1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_analise_critica_direcao2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_analise_critica_direcao2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(3) ?>" data-bs-target="#tab_analise_critica_direcao3" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_analise_critica_direcao3" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(3)) ?>"><?= $Page->pageCaption(3) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(4) ?>" data-bs-target="#tab_analise_critica_direcao4" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_analise_critica_direcao4" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(4)) ?>"><?= $Page->pageCaption(4) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>">
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_analise_critica_direcao1" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idanalise_critica_direcao->Visible) { // idanalise_critica_direcao ?>
    <tr id="r_idanalise_critica_direcao"<?= $Page->idanalise_critica_direcao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_idanalise_critica_direcao"><?= $Page->idanalise_critica_direcao->caption() ?></span></td>
        <td data-name="idanalise_critica_direcao"<?= $Page->idanalise_critica_direcao->cellAttributes() ?>>
<span id="el_analise_critica_direcao_idanalise_critica_direcao" data-page="1">
<span<?= $Page->idanalise_critica_direcao->viewAttributes() ?>>
<?= $Page->idanalise_critica_direcao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
    <tr id="r_data"<?= $Page->data->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_data"><?= $Page->data->caption() ?></span></td>
        <td data-name="data"<?= $Page->data->cellAttributes() ?>>
<span id="el_analise_critica_direcao_data" data-page="1">
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->participantes->Visible) { // participantes ?>
    <tr id="r_participantes"<?= $Page->participantes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_participantes"><?= $Page->participantes->caption() ?></span></td>
        <td data-name="participantes"<?= $Page->participantes->cellAttributes() ?>>
<span id="el_analise_critica_direcao_participantes" data-page="1">
<span<?= $Page->participantes->viewAttributes() ?>>
<?= $Page->participantes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <tr id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></td>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_analise_critica_direcao_usuario_idusuario" data-page="1">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_analise_critica_direcao2" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->situacao_anterior->Visible) { // situacao_anterior ?>
    <tr id="r_situacao_anterior"<?= $Page->situacao_anterior->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_situacao_anterior"><?= $Page->situacao_anterior->caption() ?></span></td>
        <td data-name="situacao_anterior"<?= $Page->situacao_anterior->cellAttributes() ?>>
<span id="el_analise_critica_direcao_situacao_anterior" data-page="2">
<span<?= $Page->situacao_anterior->viewAttributes() ?>>
<?= $Page->situacao_anterior->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mudanca_sqg->Visible) { // mudanca_sqg ?>
    <tr id="r_mudanca_sqg"<?= $Page->mudanca_sqg->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_mudanca_sqg"><?= $Page->mudanca_sqg->caption() ?></span></td>
        <td data-name="mudanca_sqg"<?= $Page->mudanca_sqg->cellAttributes() ?>>
<span id="el_analise_critica_direcao_mudanca_sqg" data-page="2">
<span<?= $Page->mudanca_sqg->viewAttributes() ?>>
<?= $Page->mudanca_sqg->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desempenho_eficacia->Visible) { // desempenho_eficacia ?>
    <tr id="r_desempenho_eficacia"<?= $Page->desempenho_eficacia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_desempenho_eficacia"><?= $Page->desempenho_eficacia->caption() ?></span></td>
        <td data-name="desempenho_eficacia"<?= $Page->desempenho_eficacia->cellAttributes() ?>>
<span id="el_analise_critica_direcao_desempenho_eficacia" data-page="2">
<span<?= $Page->desempenho_eficacia->viewAttributes() ?>>
<?= $Page->desempenho_eficacia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->satisfacao_cliente->Visible) { // satisfacao_cliente ?>
    <tr id="r_satisfacao_cliente"<?= $Page->satisfacao_cliente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_satisfacao_cliente"><?= $Page->satisfacao_cliente->caption() ?></span></td>
        <td data-name="satisfacao_cliente"<?= $Page->satisfacao_cliente->cellAttributes() ?>>
<span id="el_analise_critica_direcao_satisfacao_cliente" data-page="2">
<span<?= $Page->satisfacao_cliente->viewAttributes() ?>>
<?= $Page->satisfacao_cliente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->objetivos_alcancados->Visible) { // objetivos_alcançados ?>
    <tr id="r_objetivos_alcancados"<?= $Page->objetivos_alcancados->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_objetivos_alcancados"><?= $Page->objetivos_alcancados->caption() ?></span></td>
        <td data-name="objetivos_alcancados"<?= $Page->objetivos_alcancados->cellAttributes() ?>>
<span id="el_analise_critica_direcao_objetivos_alcancados" data-page="2">
<span<?= $Page->objetivos_alcancados->viewAttributes() ?>>
<?= $Page->objetivos_alcancados->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desempenho_processo->Visible) { // desempenho_processo ?>
    <tr id="r_desempenho_processo"<?= $Page->desempenho_processo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_desempenho_processo"><?= $Page->desempenho_processo->caption() ?></span></td>
        <td data-name="desempenho_processo"<?= $Page->desempenho_processo->cellAttributes() ?>>
<span id="el_analise_critica_direcao_desempenho_processo" data-page="2">
<span<?= $Page->desempenho_processo->viewAttributes() ?>>
<?= $Page->desempenho_processo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nao_confomidade_acoes_corretivas->Visible) { // nao_confomidade_acoes_corretivas ?>
    <tr id="r_nao_confomidade_acoes_corretivas"<?= $Page->nao_confomidade_acoes_corretivas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_nao_confomidade_acoes_corretivas"><?= $Page->nao_confomidade_acoes_corretivas->caption() ?></span></td>
        <td data-name="nao_confomidade_acoes_corretivas"<?= $Page->nao_confomidade_acoes_corretivas->cellAttributes() ?>>
<span id="el_analise_critica_direcao_nao_confomidade_acoes_corretivas" data-page="2">
<span<?= $Page->nao_confomidade_acoes_corretivas->viewAttributes() ?>>
<?= $Page->nao_confomidade_acoes_corretivas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monitoramento_medicao->Visible) { // monitoramento_medicao ?>
    <tr id="r_monitoramento_medicao"<?= $Page->monitoramento_medicao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_monitoramento_medicao"><?= $Page->monitoramento_medicao->caption() ?></span></td>
        <td data-name="monitoramento_medicao"<?= $Page->monitoramento_medicao->cellAttributes() ?>>
<span id="el_analise_critica_direcao_monitoramento_medicao" data-page="2">
<span<?= $Page->monitoramento_medicao->viewAttributes() ?>>
<?= $Page->monitoramento_medicao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->resultado_auditoria->Visible) { // resultado_auditoria ?>
    <tr id="r_resultado_auditoria"<?= $Page->resultado_auditoria->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_resultado_auditoria"><?= $Page->resultado_auditoria->caption() ?></span></td>
        <td data-name="resultado_auditoria"<?= $Page->resultado_auditoria->cellAttributes() ?>>
<span id="el_analise_critica_direcao_resultado_auditoria" data-page="2">
<span<?= $Page->resultado_auditoria->viewAttributes() ?>>
<?= $Page->resultado_auditoria->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desempenho_provedores_ext->Visible) { // desempenho_provedores_ext ?>
    <tr id="r_desempenho_provedores_ext"<?= $Page->desempenho_provedores_ext->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_desempenho_provedores_ext"><?= $Page->desempenho_provedores_ext->caption() ?></span></td>
        <td data-name="desempenho_provedores_ext"<?= $Page->desempenho_provedores_ext->cellAttributes() ?>>
<span id="el_analise_critica_direcao_desempenho_provedores_ext" data-page="2">
<span<?= $Page->desempenho_provedores_ext->viewAttributes() ?>>
<?= $Page->desempenho_provedores_ext->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->suficiencia_recursos->Visible) { // suficiencia_recursos ?>
    <tr id="r_suficiencia_recursos"<?= $Page->suficiencia_recursos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_suficiencia_recursos"><?= $Page->suficiencia_recursos->caption() ?></span></td>
        <td data-name="suficiencia_recursos"<?= $Page->suficiencia_recursos->cellAttributes() ?>>
<span id="el_analise_critica_direcao_suficiencia_recursos" data-page="2">
<span<?= $Page->suficiencia_recursos->viewAttributes() ?>>
<?= $Page->suficiencia_recursos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->acoes_risco_oportunidades->Visible) { // acoes_risco_oportunidades ?>
    <tr id="r_acoes_risco_oportunidades"<?= $Page->acoes_risco_oportunidades->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_acoes_risco_oportunidades"><?= $Page->acoes_risco_oportunidades->caption() ?></span></td>
        <td data-name="acoes_risco_oportunidades"<?= $Page->acoes_risco_oportunidades->cellAttributes() ?>>
<span id="el_analise_critica_direcao_acoes_risco_oportunidades" data-page="2">
<span<?= $Page->acoes_risco_oportunidades->viewAttributes() ?>>
<?= $Page->acoes_risco_oportunidades->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->oportunidade_melhora_entrada->Visible) { // oportunidade_melhora_entrada ?>
    <tr id="r_oportunidade_melhora_entrada"<?= $Page->oportunidade_melhora_entrada->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_oportunidade_melhora_entrada"><?= $Page->oportunidade_melhora_entrada->caption() ?></span></td>
        <td data-name="oportunidade_melhora_entrada"<?= $Page->oportunidade_melhora_entrada->cellAttributes() ?>>
<span id="el_analise_critica_direcao_oportunidade_melhora_entrada" data-page="2">
<span<?= $Page->oportunidade_melhora_entrada->viewAttributes() ?>>
<?= $Page->oportunidade_melhora_entrada->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(3) ?>" id="tab_analise_critica_direcao3" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->oportunidade_melhora_saida->Visible) { // oportunidade_melhora_saida ?>
    <tr id="r_oportunidade_melhora_saida"<?= $Page->oportunidade_melhora_saida->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_oportunidade_melhora_saida"><?= $Page->oportunidade_melhora_saida->caption() ?></span></td>
        <td data-name="oportunidade_melhora_saida"<?= $Page->oportunidade_melhora_saida->cellAttributes() ?>>
<span id="el_analise_critica_direcao_oportunidade_melhora_saida" data-page="3">
<span<?= $Page->oportunidade_melhora_saida->viewAttributes() ?>>
<?= $Page->oportunidade_melhora_saida->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->qualquer_mudanca_sgq->Visible) { // qualquer_mudanca_sgq ?>
    <tr id="r_qualquer_mudanca_sgq"<?= $Page->qualquer_mudanca_sgq->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_qualquer_mudanca_sgq"><?= $Page->qualquer_mudanca_sgq->caption() ?></span></td>
        <td data-name="qualquer_mudanca_sgq"<?= $Page->qualquer_mudanca_sgq->cellAttributes() ?>>
<span id="el_analise_critica_direcao_qualquer_mudanca_sgq" data-page="3">
<span<?= $Page->qualquer_mudanca_sgq->viewAttributes() ?>>
<?= $Page->qualquer_mudanca_sgq->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nec_recurso->Visible) { // nec_recurso ?>
    <tr id="r_nec_recurso"<?= $Page->nec_recurso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_nec_recurso"><?= $Page->nec_recurso->caption() ?></span></td>
        <td data-name="nec_recurso"<?= $Page->nec_recurso->cellAttributes() ?>>
<span id="el_analise_critica_direcao_nec_recurso" data-page="3">
<span<?= $Page->nec_recurso->viewAttributes() ?>>
<?= $Page->nec_recurso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(4) ?>" id="tab_analise_critica_direcao4" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->anexo->Visible) { // anexo ?>
    <tr id="r_anexo"<?= $Page->anexo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_critica_direcao_anexo"><?= $Page->anexo->caption() ?></span></td>
        <td data-name="anexo"<?= $Page->anexo->cellAttributes() ?>>
<span id="el_analise_critica_direcao_anexo" data-page="4">
<span<?= $Page->anexo->viewAttributes() ?>>
<?= GetFileViewTag($Page->anexo, $Page->anexo->getViewValue(), false) ?>
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
