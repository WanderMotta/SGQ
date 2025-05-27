<?php

namespace PHPMaker2024\sgq;

// Page object
$UnidadeMedidaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="funidade_medidaedit" id="funidade_medidaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { unidade_medida: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var funidade_medidaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("funidade_medidaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idunidade_medida", [fields.idunidade_medida.visible && fields.idunidade_medida.required ? ew.Validators.required(fields.idunidade_medida.caption) : null], fields.idunidade_medida.isInvalid],
            ["unidade", [fields.unidade.visible && fields.unidade.required ? ew.Validators.required(fields.unidade.caption) : null], fields.unidade.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
        })
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="unidade_medida">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idunidade_medida->Visible) { // idunidade_medida ?>
    <div id="r_idunidade_medida"<?= $Page->idunidade_medida->rowAttributes() ?>>
        <label id="elh_unidade_medida_idunidade_medida" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idunidade_medida->caption() ?><?= $Page->idunidade_medida->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idunidade_medida->cellAttributes() ?>>
<span id="el_unidade_medida_idunidade_medida">
<span<?= $Page->idunidade_medida->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idunidade_medida->getDisplayValue($Page->idunidade_medida->EditValue))) ?>"></span>
<input type="hidden" data-table="unidade_medida" data-field="x_idunidade_medida" data-hidden="1" name="x_idunidade_medida" id="x_idunidade_medida" value="<?= HtmlEncode($Page->idunidade_medida->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unidade->Visible) { // unidade ?>
    <div id="r_unidade"<?= $Page->unidade->rowAttributes() ?>>
        <label id="elh_unidade_medida_unidade" for="x_unidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unidade->caption() ?><?= $Page->unidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->unidade->cellAttributes() ?>>
<span id="el_unidade_medida_unidade">
<input type="<?= $Page->unidade->getInputTextType() ?>" name="x_unidade" id="x_unidade" data-table="unidade_medida" data-field="x_unidade" value="<?= $Page->unidade->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->unidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->unidade->formatPattern()) ?>"<?= $Page->unidade->editAttributes() ?> aria-describedby="x_unidade_help">
<?= $Page->unidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->unidade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="funidade_medidaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="funidade_medidaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("unidade_medida");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
