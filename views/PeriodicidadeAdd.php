<?php

namespace PHPMaker2024\sgq;

// Page object
$PeriodicidadeAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { periodicidade: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fperiodicidadeadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fperiodicidadeadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["periodicidade", [fields.periodicidade.visible && fields.periodicidade.required ? ew.Validators.required(fields.periodicidade.caption) : null], fields.periodicidade.isInvalid]
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fperiodicidadeadd" id="fperiodicidadeadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="periodicidade">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->periodicidade->Visible) { // periodicidade ?>
    <div id="r_periodicidade"<?= $Page->periodicidade->rowAttributes() ?>>
        <label id="elh_periodicidade_periodicidade" for="x_periodicidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periodicidade->caption() ?><?= $Page->periodicidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periodicidade->cellAttributes() ?>>
<span id="el_periodicidade_periodicidade">
<input type="<?= $Page->periodicidade->getInputTextType() ?>" name="x_periodicidade" id="x_periodicidade" data-table="periodicidade" data-field="x_periodicidade" value="<?= $Page->periodicidade->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->periodicidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->periodicidade->formatPattern()) ?>"<?= $Page->periodicidade->editAttributes() ?> aria-describedby="x_periodicidade_help">
<?= $Page->periodicidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->periodicidade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fperiodicidadeadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fperiodicidadeadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("periodicidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
