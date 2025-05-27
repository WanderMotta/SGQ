<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseNegocioView = &$Page;
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
<form name="fanalise_negocioview" id="fanalise_negocioview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_negocio: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fanalise_negocioview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fanalise_negocioview")
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
<input type="hidden" name="t" value="analise_negocio">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idanalise_negocio->Visible) { // idanalise_negocio ?>
    <tr id="r_idanalise_negocio"<?= $Page->idanalise_negocio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_negocio_idanalise_negocio"><?= $Page->idanalise_negocio->caption() ?></span></td>
        <td data-name="idanalise_negocio"<?= $Page->idanalise_negocio->cellAttributes() ?>>
<span id="el_analise_negocio_idanalise_negocio">
<span<?= $Page->idanalise_negocio->viewAttributes() ?>>
<?= $Page->idanalise_negocio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->item->Visible) { // item ?>
    <tr id="r_item"<?= $Page->item->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_negocio_item"><?= $Page->item->caption() ?></span></td>
        <td data-name="item"<?= $Page->item->cellAttributes() ?>>
<span id="el_analise_negocio_item">
<span<?= $Page->item->viewAttributes() ?>>
<?= $Page->item->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descrever->Visible) { // descrever ?>
    <tr id="r_descrever"<?= $Page->descrever->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_negocio_descrever"><?= $Page->descrever->caption() ?></span></td>
        <td data-name="descrever"<?= $Page->descrever->cellAttributes() ?>>
<span id="el_analise_negocio_descrever">
<span<?= $Page->descrever->viewAttributes() ?>>
<?= $Page->descrever->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->posicao->Visible) { // posicao ?>
    <tr id="r_posicao"<?= $Page->posicao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_analise_negocio_posicao"><?= $Page->posicao->caption() ?></span></td>
        <td data-name="posicao"<?= $Page->posicao->cellAttributes() ?>>
<span id="el_analise_negocio_posicao">
<span<?= $Page->posicao->viewAttributes() ?>>
<?= $Page->posicao->getViewValue() ?></span>
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
