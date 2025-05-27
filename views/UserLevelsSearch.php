<?php

namespace PHPMaker2024\sgq;

// Page object
$UserLevelsSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { UserLevels: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fUserLevelssearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fUserLevelssearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["UserLevelID", [ew.Validators.userLevelId, ew.Validators.integer], fields.UserLevelID.isInvalid],
            ["UserLevelName", [ew.Validators.userLevelName('UserLevelID')], fields.UserLevelName.isInvalid]
        ])
        // Validate form
        .setValidate(
            async function () {
                if (!this.validateRequired)
                    return true; // Ignore validation
                let fobj = this.getForm();

                // Validate fields
                if (!this.validateFields())
                    return false;

                // Call Form_CustomValidate event
                if (!(await this.customValidate?.(fobj) ?? true)) {
                    this.focus();
                    return false;
                }
                return true;
            }
        )

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
<?php if ($Page->IsModal) { ?>
    currentAdvancedSearchForm = form;
<?php } else { ?>
    currentForm = form;
<?php } ?>
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
<form name="fUserLevelssearch" id="fUserLevelssearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="UserLevels">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->UserLevelID->Visible) { // UserLevelID ?>
    <div id="r_UserLevelID" class="row"<?= $Page->UserLevelID->rowAttributes() ?>>
        <label for="x_UserLevelID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_UserLevels_UserLevelID"><?= $Page->UserLevelID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_UserLevelID" id="z_UserLevelID" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->UserLevelID->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_UserLevels_UserLevelID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->UserLevelID->getInputTextType() ?>" name="x_UserLevelID" id="x_UserLevelID" data-table="UserLevels" data-field="x_UserLevelID" value="<?= $Page->UserLevelID->EditValue ?>" size="3" maxlength="3" placeholder="<?= HtmlEncode($Page->UserLevelID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UserLevelID->formatPattern()) ?>"<?= $Page->UserLevelID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->UserLevelID->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->UserLevelName->Visible) { // UserLevelName ?>
    <div id="r_UserLevelName" class="row"<?= $Page->UserLevelName->rowAttributes() ?>>
        <label for="x_UserLevelName" class="<?= $Page->LeftColumnClass ?>"><span id="elh_UserLevels_UserLevelName"><?= $Page->UserLevelName->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_UserLevelName" id="z_UserLevelName" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->UserLevelName->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_UserLevels_UserLevelName" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->UserLevelName->getInputTextType() ?>" name="x_UserLevelName" id="x_UserLevelName" data-table="UserLevels" data-field="x_UserLevelName" value="<?= $Page->UserLevelName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->UserLevelName->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->UserLevelName->formatPattern()) ?>"<?= $Page->UserLevelName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->UserLevelName->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fUserLevelssearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fUserLevelssearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fUserLevelssearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("UserLevels");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
