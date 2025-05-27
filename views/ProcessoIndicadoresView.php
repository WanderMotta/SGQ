<?php

namespace PHPMaker2024\sgq;

// Page object
$ProcessoIndicadoresView = &$Page;
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
<form name="fprocesso_indicadoresview" id="fprocesso_indicadoresview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { processo_indicadores: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fprocesso_indicadoresview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fprocesso_indicadoresview")
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
<input type="hidden" name="t" value="processo_indicadores">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idprocesso_indicadores->Visible) { // idprocesso_indicadores ?>
    <tr id="r_idprocesso_indicadores"<?= $Page->idprocesso_indicadores->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_indicadores_idprocesso_indicadores"><?= $Page->idprocesso_indicadores->caption() ?></span></td>
        <td data-name="idprocesso_indicadores"<?= $Page->idprocesso_indicadores->cellAttributes() ?>>
<span id="el_processo_indicadores_idprocesso_indicadores">
<span<?= $Page->idprocesso_indicadores->viewAttributes() ?>>
<?= $Page->idprocesso_indicadores->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <tr id="r_processo_idprocesso"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_indicadores_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span></td>
        <td data-name="processo_idprocesso"<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el_processo_indicadores_processo_idprocesso">
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
    <tr id="r_indicadores_idindicadores"<?= $Page->indicadores_idindicadores->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_processo_indicadores_indicadores_idindicadores"><?= $Page->indicadores_idindicadores->caption() ?></span></td>
        <td data-name="indicadores_idindicadores"<?= $Page->indicadores_idindicadores->cellAttributes() ?>>
<span id="el_processo_indicadores_indicadores_idindicadores">
<span<?= $Page->indicadores_idindicadores->viewAttributes() ?>>
<?= $Page->indicadores_idindicadores->getViewValue() ?></span>
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
