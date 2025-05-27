<?php

namespace PHPMaker2024\sgq;

// Page object
$ConsideracoesView = &$Page;
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
<form name="fconsideracoesview" id="fconsideracoesview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { consideracoes: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fconsideracoesview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fconsideracoesview")
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
<input type="hidden" name="t" value="consideracoes">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idconsideracoes->Visible) { // idconsideracoes ?>
    <tr id="r_idconsideracoes"<?= $Page->idconsideracoes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_consideracoes_idconsideracoes"><?= $Page->idconsideracoes->caption() ?></span></td>
        <td data-name="idconsideracoes"<?= $Page->idconsideracoes->cellAttributes() ?>>
<span id="el_consideracoes_idconsideracoes">
<span<?= $Page->idconsideracoes->viewAttributes() ?>>
<?= $Page->idconsideracoes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <tr id="r_titulo"<?= $Page->titulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_consideracoes_titulo"><?= $Page->titulo->caption() ?></span></td>
        <td data-name="titulo"<?= $Page->titulo->cellAttributes() ?>>
<span id="el_consideracoes_titulo">
<span<?= $Page->titulo->viewAttributes() ?>>
<?= $Page->titulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->consideracao->Visible) { // consideracao ?>
    <tr id="r_consideracao"<?= $Page->consideracao->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_consideracoes_consideracao"><?= $Page->consideracao->caption() ?></span></td>
        <td data-name="consideracao"<?= $Page->consideracao->cellAttributes() ?>>
<span id="el_consideracoes_consideracao">
<span<?= $Page->consideracao->viewAttributes() ?>>
<?= $Page->consideracao->getViewValue() ?></span>
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
