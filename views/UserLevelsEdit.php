<?php

namespace PHPMaker2024\sgq;

// Page object
$UserLevelsEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fUserLevelsedit" id="fUserLevelsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { UserLevels: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fUserLevelsedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fUserLevelsedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["UserLevelID", [fields.UserLevelID.visible && fields.UserLevelID.required ? ew.Validators.required(fields.UserLevelID.caption) : null, ew.Validators.userLevelId, ew.Validators.integer], fields.UserLevelID.isInvalid],
            ["UserLevelName", [fields.UserLevelName.visible && fields.UserLevelName.required ? ew.Validators.required(fields.UserLevelName.caption) : null, ew.Validators.userLevelName('UserLevelID')], fields.UserLevelName.isInvalid]
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
<input type="hidden" name="t" value="UserLevels">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->UserLevelID->Visible) { // UserLevelID ?>
    <div id="r_UserLevelID"<?= $Page->UserLevelID->rowAttributes() ?>>
        <label id="elh_UserLevels_UserLevelID" for="x_UserLevelID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UserLevelID->caption() ?><?= $Page->UserLevelID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UserLevelID->cellAttributes() ?>>
<span id="el_UserLevels_UserLevelID">
<input type="<?= $Page->UserLevelID->getInputTextType() ?>" name="x_UserLevelID" id="x_UserLevelID" data-table="UserLevels" data-field="x_UserLevelID" value="<?= $Page->UserLevelID->EditValue ?>" size="3" maxlength="3" placeholder="<?= HtmlEncode($Page->UserLevelID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UserLevelID->formatPattern()) ?>"<?= $Page->UserLevelID->editAttributes() ?> aria-describedby="x_UserLevelID_help">
<?= $Page->UserLevelID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UserLevelID->getErrorMessage() ?></div>
<input type="hidden" data-table="UserLevels" data-field="x_UserLevelID" data-hidden="1" data-old name="o_UserLevelID" id="o_UserLevelID" value="<?= HtmlEncode($Page->UserLevelID->OldValue ?? $Page->UserLevelID->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UserLevelName->Visible) { // UserLevelName ?>
    <div id="r_UserLevelName"<?= $Page->UserLevelName->rowAttributes() ?>>
        <label id="elh_UserLevels_UserLevelName" for="x_UserLevelName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UserLevelName->caption() ?><?= $Page->UserLevelName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UserLevelName->cellAttributes() ?>>
<span id="el_UserLevels_UserLevelName">
<input type="<?= $Page->UserLevelName->getInputTextType() ?>" name="x_UserLevelName" id="x_UserLevelName" data-table="UserLevels" data-field="x_UserLevelName" value="<?= $Page->UserLevelName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->UserLevelName->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UserLevelName->formatPattern()) ?>"<?= $Page->UserLevelName->editAttributes() ?> aria-describedby="x_UserLevelName_help">
<?= $Page->UserLevelName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UserLevelName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fUserLevelsedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fUserLevelsedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("UserLevels");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
