<?php

namespace PHPMaker2024\sgq;

// Page object
$StatusAcaoSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { status_acao: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fstatus_acaosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fstatus_acaosearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idstatus_acao", [ew.Validators.integer], fields.idstatus_acao.isInvalid],
            ["status_acao", [], fields.status_acao.isInvalid]
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
<form name="fstatus_acaosearch" id="fstatus_acaosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="status_acao">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idstatus_acao->Visible) { // idstatus_acao ?>
    <div id="r_idstatus_acao" class="row"<?= $Page->idstatus_acao->rowAttributes() ?>>
        <label for="x_idstatus_acao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_status_acao_idstatus_acao"><?= $Page->idstatus_acao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idstatus_acao" id="z_idstatus_acao" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idstatus_acao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_status_acao_idstatus_acao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idstatus_acao->getInputTextType() ?>" name="x_idstatus_acao" id="x_idstatus_acao" data-table="status_acao" data-field="x_idstatus_acao" value="<?= $Page->idstatus_acao->EditValue ?>" placeholder="<?= HtmlEncode($Page->idstatus_acao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idstatus_acao->formatPattern()) ?>"<?= $Page->idstatus_acao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idstatus_acao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->status_acao->Visible) { // status_acao ?>
    <div id="r_status_acao" class="row"<?= $Page->status_acao->rowAttributes() ?>>
        <label for="x_status_acao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_status_acao_status_acao"><?= $Page->status_acao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_status_acao" id="z_status_acao" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->status_acao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_status_acao_status_acao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->status_acao->getInputTextType() ?>" name="x_status_acao" id="x_status_acao" data-table="status_acao" data-field="x_status_acao" value="<?= $Page->status_acao->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->status_acao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->status_acao->formatPattern()) ?>"<?= $Page->status_acao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->status_acao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fstatus_acaosearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fstatus_acaosearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fstatus_acaosearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("status_acao");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
