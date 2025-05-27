<?php

namespace PHPMaker2024\sgq;

// Page object
$CategoriaDocumentoView = &$Page;
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
<form name="fcategoria_documentoview" id="fcategoria_documentoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { categoria_documento: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcategoria_documentoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcategoria_documentoview")
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
<input type="hidden" name="t" value="categoria_documento">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idcategoria_documento->Visible) { // idcategoria_documento ?>
    <tr id="r_idcategoria_documento"<?= $Page->idcategoria_documento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_categoria_documento_idcategoria_documento"><?= $Page->idcategoria_documento->caption() ?></span></td>
        <td data-name="idcategoria_documento"<?= $Page->idcategoria_documento->cellAttributes() ?>>
<span id="el_categoria_documento_idcategoria_documento">
<span<?= $Page->idcategoria_documento->viewAttributes() ?>>
<?= $Page->idcategoria_documento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->categoria->Visible) { // categoria ?>
    <tr id="r_categoria"<?= $Page->categoria->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_categoria_documento_categoria"><?= $Page->categoria->caption() ?></span></td>
        <td data-name="categoria"<?= $Page->categoria->cellAttributes() ?>>
<span id="el_categoria_documento_categoria">
<span<?= $Page->categoria->viewAttributes() ?>>
<?= $Page->categoria->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sigla->Visible) { // sigla ?>
    <tr id="r_sigla"<?= $Page->sigla->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_categoria_documento_sigla"><?= $Page->sigla->caption() ?></span></td>
        <td data-name="sigla"<?= $Page->sigla->cellAttributes() ?>>
<span id="el_categoria_documento_sigla">
<span<?= $Page->sigla->viewAttributes() ?>>
<?= $Page->sigla->getViewValue() ?></span>
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
