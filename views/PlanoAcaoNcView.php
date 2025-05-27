<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAcaoNcView = &$Page;
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
<form name="fplano_acao_ncview" id="fplano_acao_ncview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_acao_nc: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fplano_acao_ncview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplano_acao_ncview")
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
<input type="hidden" name="t" value="plano_acao_nc">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (!$Page->isExport()) { ?>
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_PlanoAcaoNcView"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_plano_acao_nc1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_plano_acao_nc1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_plano_acao_nc2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_plano_acao_nc2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>">
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_plano_acao_nc1" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idplano_acao_nc->Visible) { // idplano_acao_nc ?>
    <tr id="r_idplano_acao_nc"<?= $Page->idplano_acao_nc->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_nc_idplano_acao_nc"><?= $Page->idplano_acao_nc->caption() ?></span></td>
        <td data-name="idplano_acao_nc"<?= $Page->idplano_acao_nc->cellAttributes() ?>>
<span id="el_plano_acao_nc_idplano_acao_nc" data-page="1">
<span<?= $Page->idplano_acao_nc->viewAttributes() ?>>
<?= $Page->idplano_acao_nc->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_nc_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_plano_acao_nc_dt_cadastro" data-page="1">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nao_conformidade_idnao_conformidade->Visible) { // nao_conformidade_idnao_conformidade ?>
    <tr id="r_nao_conformidade_idnao_conformidade"<?= $Page->nao_conformidade_idnao_conformidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_nc_nao_conformidade_idnao_conformidade"><?= $Page->nao_conformidade_idnao_conformidade->caption() ?></span></td>
        <td data-name="nao_conformidade_idnao_conformidade"<?= $Page->nao_conformidade_idnao_conformidade->cellAttributes() ?>>
<span id="el_plano_acao_nc_nao_conformidade_idnao_conformidade" data-page="1">
<span<?= $Page->nao_conformidade_idnao_conformidade->viewAttributes() ?>>
<?= $Page->nao_conformidade_idnao_conformidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
    <tr id="r_o_q_sera_feito"<?= $Page->o_q_sera_feito->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_nc_o_q_sera_feito"><?= $Page->o_q_sera_feito->caption() ?></span></td>
        <td data-name="o_q_sera_feito"<?= $Page->o_q_sera_feito->cellAttributes() ?>>
<span id="el_plano_acao_nc_o_q_sera_feito" data-page="1">
<span<?= $Page->o_q_sera_feito->viewAttributes() ?>>
<?= $Page->o_q_sera_feito->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
    <tr id="r_efeito_esperado"<?= $Page->efeito_esperado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_nc_efeito_esperado"><?= $Page->efeito_esperado->caption() ?></span></td>
        <td data-name="efeito_esperado"<?= $Page->efeito_esperado->cellAttributes() ?>>
<span id="el_plano_acao_nc_efeito_esperado" data-page="1">
<span<?= $Page->efeito_esperado->viewAttributes() ?>>
<?= $Page->efeito_esperado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <tr id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_nc_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></td>
        <td data-name="usuario_idusuario"<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_plano_acao_nc_usuario_idusuario" data-page="1">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
    <tr id="r_recursos_nec"<?= $Page->recursos_nec->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_nc_recursos_nec"><?= $Page->recursos_nec->caption() ?></span></td>
        <td data-name="recursos_nec"<?= $Page->recursos_nec->cellAttributes() ?>>
<span id="el_plano_acao_nc_recursos_nec" data-page="1">
<span<?= $Page->recursos_nec->viewAttributes() ?>>
<?= $Page->recursos_nec->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
    <tr id="r_dt_limite"<?= $Page->dt_limite->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_nc_dt_limite"><?= $Page->dt_limite->caption() ?></span></td>
        <td data-name="dt_limite"<?= $Page->dt_limite->cellAttributes() ?>>
<span id="el_plano_acao_nc_dt_limite" data-page="1">
<span<?= $Page->dt_limite->viewAttributes() ?>>
<?= $Page->dt_limite->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
    <tr id="r_implementado"<?= $Page->implementado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_nc_implementado"><?= $Page->implementado->caption() ?></span></td>
        <td data-name="implementado"<?= $Page->implementado->cellAttributes() ?>>
<span id="el_plano_acao_nc_implementado" data-page="1">
<span<?= $Page->implementado->viewAttributes() ?>>
<?= $Page->implementado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_plano_acao_nc2" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->eficaz->Visible) { // eficaz ?>
    <tr id="r_eficaz"<?= $Page->eficaz->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_nc_eficaz"><?= $Page->eficaz->caption() ?></span></td>
        <td data-name="eficaz"<?= $Page->eficaz->cellAttributes() ?>>
<span id="el_plano_acao_nc_eficaz" data-page="2">
<span<?= $Page->eficaz->viewAttributes() ?>>
<?= $Page->eficaz->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->evidencia->Visible) { // evidencia ?>
    <tr id="r_evidencia"<?= $Page->evidencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_nc_evidencia"><?= $Page->evidencia->caption() ?></span></td>
        <td data-name="evidencia"<?= $Page->evidencia->cellAttributes() ?>>
<span id="el_plano_acao_nc_evidencia" data-page="2">
<span<?= $Page->evidencia->viewAttributes() ?>>
<?= $Page->evidencia->getViewValue() ?></span>
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
