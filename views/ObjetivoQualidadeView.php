<?php

namespace PHPMaker2024\sgq;

// Page object
$ObjetivoQualidadeView = &$Page;
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
<form name="fobjetivo_qualidadeview" id="fobjetivo_qualidadeview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { objetivo_qualidade: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fobjetivo_qualidadeview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fobjetivo_qualidadeview")
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
<input type="hidden" name="t" value="objetivo_qualidade">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idobjetivo_qualidade->Visible) { // idobjetivo_qualidade ?>
    <tr id="r_idobjetivo_qualidade"<?= $Page->idobjetivo_qualidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_objetivo_qualidade_idobjetivo_qualidade"><?= $Page->idobjetivo_qualidade->caption() ?></span></td>
        <td data-name="idobjetivo_qualidade"<?= $Page->idobjetivo_qualidade->cellAttributes() ?>>
<span id="el_objetivo_qualidade_idobjetivo_qualidade">
<span<?= $Page->idobjetivo_qualidade->viewAttributes() ?>>
<?= $Page->idobjetivo_qualidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <tr id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_objetivo_qualidade_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></td>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_objetivo_qualidade_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <tr id="r_processo_idprocesso"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_objetivo_qualidade_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span></td>
        <td data-name="processo_idprocesso"<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el_objetivo_qualidade_processo_idprocesso">
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->objetivo->Visible) { // objetivo ?>
    <tr id="r_objetivo"<?= $Page->objetivo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_objetivo_qualidade_objetivo"><?= $Page->objetivo->caption() ?></span></td>
        <td data-name="objetivo"<?= $Page->objetivo->cellAttributes() ?>>
<span id="el_objetivo_qualidade_objetivo">
<span<?= $Page->objetivo->viewAttributes() ?>>
<?= $Page->objetivo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->como_medir->Visible) { // como_medir ?>
    <tr id="r_como_medir"<?= $Page->como_medir->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_objetivo_qualidade_como_medir"><?= $Page->como_medir->caption() ?></span></td>
        <td data-name="como_medir"<?= $Page->como_medir->cellAttributes() ?>>
<span id="el_objetivo_qualidade_como_medir">
<span<?= $Page->como_medir->viewAttributes() ?>>
<?= $Page->como_medir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
    <tr id="r_o_q_sera_feito"<?= $Page->o_q_sera_feito->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_objetivo_qualidade_o_q_sera_feito"><?= $Page->o_q_sera_feito->caption() ?></span></td>
        <td data-name="o_q_sera_feito"<?= $Page->o_q_sera_feito->cellAttributes() ?>>
<span id="el_objetivo_qualidade_o_q_sera_feito">
<span<?= $Page->o_q_sera_feito->viewAttributes() ?>>
<?= $Page->o_q_sera_feito->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->como_avaliar->Visible) { // como_avaliar ?>
    <tr id="r_como_avaliar"<?= $Page->como_avaliar->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_objetivo_qualidade_como_avaliar"><?= $Page->como_avaliar->caption() ?></span></td>
        <td data-name="como_avaliar"<?= $Page->como_avaliar->cellAttributes() ?>>
<span id="el_objetivo_qualidade_como_avaliar">
<span<?= $Page->como_avaliar->viewAttributes() ?>>
<?= $Page->como_avaliar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <tr id="r_departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_objetivo_qualidade_departamentos_iddepartamentos"><?= $Page->departamentos_iddepartamentos->caption() ?></span></td>
        <td data-name="departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el_objetivo_qualidade_departamentos_iddepartamentos">
<span<?= $Page->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Page->departamentos_iddepartamentos->getViewValue() ?></span>
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
