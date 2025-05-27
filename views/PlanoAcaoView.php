<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAcaoView = &$Page;
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
<form name="fplano_acaoview" id="fplano_acaoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_acao: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fplano_acaoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplano_acaoview")
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
<input type="hidden" name="t" value="plano_acao">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idplano_acao->Visible) { // idplano_acao ?>
    <tr id="r_idplano_acao"<?= $Page->idplano_acao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_idplano_acao"><?= $Page->idplano_acao->caption() ?></span></td>
        <td data-name="idplano_acao"<?= $Page->idplano_acao->cellAttributes() ?>>
<span id="el_plano_acao_idplano_acao">
<span<?= $Page->idplano_acao->viewAttributes() ?>>
<?= $Page->idplano_acao->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
    <tr id="r_risco_oportunidade_idrisco_oportunidade"<?= $Page->risco_oportunidade_idrisco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_risco_oportunidade_idrisco_oportunidade"><?= $Page->risco_oportunidade_idrisco_oportunidade->caption() ?></span></td>
        <td data-name="risco_oportunidade_idrisco_oportunidade"<?= $Page->risco_oportunidade_idrisco_oportunidade->cellAttributes() ?>>
<span id="el_plano_acao_risco_oportunidade_idrisco_oportunidade">
<span<?= $Page->risco_oportunidade_idrisco_oportunidade->viewAttributes() ?>>
<?= $Page->risco_oportunidade_idrisco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_plano_acao_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
    <tr id="r_o_q_sera_feito"<?= $Page->o_q_sera_feito->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_o_q_sera_feito"><?= $Page->o_q_sera_feito->caption() ?></span></td>
        <td data-name="o_q_sera_feito"<?= $Page->o_q_sera_feito->cellAttributes() ?>>
<span id="el_plano_acao_o_q_sera_feito">
<span<?= $Page->o_q_sera_feito->viewAttributes() ?>>
<?= $Page->o_q_sera_feito->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
    <tr id="r_efeito_esperado"<?= $Page->efeito_esperado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_efeito_esperado"><?= $Page->efeito_esperado->caption() ?></span></td>
        <td data-name="efeito_esperado"<?= $Page->efeito_esperado->cellAttributes() ?>>
<span id="el_plano_acao_efeito_esperado">
<span<?= $Page->efeito_esperado->viewAttributes() ?>>
<?= $Page->efeito_esperado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <tr id="r_departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_departamentos_iddepartamentos"><?= $Page->departamentos_iddepartamentos->caption() ?></span></td>
        <td data-name="departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el_plano_acao_departamentos_iddepartamentos">
<span<?= $Page->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Page->departamentos_iddepartamentos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <tr id="r_origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?></span></td>
        <td data-name="origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade">
<span<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
    <tr id="r_recursos_nec"<?= $Page->recursos_nec->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_recursos_nec"><?= $Page->recursos_nec->caption() ?></span></td>
        <td data-name="recursos_nec"<?= $Page->recursos_nec->cellAttributes() ?>>
<span id="el_plano_acao_recursos_nec">
<span<?= $Page->recursos_nec->viewAttributes() ?>>
<?= $Page->recursos_nec->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
    <tr id="r_dt_limite"<?= $Page->dt_limite->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_dt_limite"><?= $Page->dt_limite->caption() ?></span></td>
        <td data-name="dt_limite"<?= $Page->dt_limite->cellAttributes() ?>>
<span id="el_plano_acao_dt_limite">
<span<?= $Page->dt_limite->viewAttributes() ?>>
<?= $Page->dt_limite->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
    <tr id="r_implementado"<?= $Page->implementado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_implementado"><?= $Page->implementado->caption() ?></span></td>
        <td data-name="implementado"<?= $Page->implementado->cellAttributes() ?>>
<span id="el_plano_acao_implementado">
<span<?= $Page->implementado->viewAttributes() ?>>
<?= $Page->implementado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
    <tr id="r_periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_periodicidade_idperiodicidade"><?= $Page->periodicidade_idperiodicidade->caption() ?></span></td>
        <td data-name="periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->cellAttributes() ?>>
<span id="el_plano_acao_periodicidade_idperiodicidade">
<span<?= $Page->periodicidade_idperiodicidade->viewAttributes() ?>>
<?= $Page->periodicidade_idperiodicidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
    <tr id="r_eficaz"<?= $Page->eficaz->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_plano_acao_eficaz"><?= $Page->eficaz->caption() ?></span></td>
        <td data-name="eficaz"<?= $Page->eficaz->cellAttributes() ?>>
<span id="el_plano_acao_eficaz">
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
