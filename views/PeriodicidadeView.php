<?php

namespace PHPMaker2024\sgq;

// Page object
$PeriodicidadeView = &$Page;
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
<form name="fperiodicidadeview" id="fperiodicidadeview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { periodicidade: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fperiodicidadeview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fperiodicidadeview")
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
<input type="hidden" name="t" value="periodicidade">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->idperiodicidade->Visible) { // idperiodicidade ?>
    <tr id="r_idperiodicidade"<?= $Page->idperiodicidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_periodicidade_idperiodicidade"><?= $Page->idperiodicidade->caption() ?></span></td>
        <td data-name="idperiodicidade"<?= $Page->idperiodicidade->cellAttributes() ?>>
<span id="el_periodicidade_idperiodicidade">
<span<?= $Page->idperiodicidade->viewAttributes() ?>>
<?= $Page->idperiodicidade->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->periodicidade->Visible) { // periodicidade ?>
    <tr id="r_periodicidade"<?= $Page->periodicidade->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_periodicidade_periodicidade"><?= $Page->periodicidade->caption() ?></span></td>
        <td data-name="periodicidade"<?= $Page->periodicidade->cellAttributes() ?>>
<span id="el_periodicidade_periodicidade">
<span<?= $Page->periodicidade->viewAttributes() ?>>
<?= $Page->periodicidade->getViewValue() ?></span>
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
