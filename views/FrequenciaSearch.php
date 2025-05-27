<?php

namespace PHPMaker2024\sgq;

// Page object
$FrequenciaSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { frequencia: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var ffrequenciasearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("ffrequenciasearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idfrequencia", [ew.Validators.integer], fields.idfrequencia.isInvalid],
            ["frequencia", [], fields.frequencia.isInvalid],
            ["grau", [ew.Validators.integer], fields.grau.isInvalid],
            ["obs", [], fields.obs.isInvalid]
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
<form name="ffrequenciasearch" id="ffrequenciasearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="frequencia">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idfrequencia->Visible) { // idfrequencia ?>
    <div id="r_idfrequencia" class="row"<?= $Page->idfrequencia->rowAttributes() ?>>
        <label for="x_idfrequencia" class="<?= $Page->LeftColumnClass ?>"><span id="elh_frequencia_idfrequencia"><?= $Page->idfrequencia->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idfrequencia" id="z_idfrequencia" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idfrequencia->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_frequencia_idfrequencia" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idfrequencia->getInputTextType() ?>" name="x_idfrequencia" id="x_idfrequencia" data-table="frequencia" data-field="x_idfrequencia" value="<?= $Page->idfrequencia->EditValue ?>" placeholder="<?= HtmlEncode($Page->idfrequencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idfrequencia->formatPattern()) ?>"<?= $Page->idfrequencia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idfrequencia->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
    <div id="r_frequencia" class="row"<?= $Page->frequencia->rowAttributes() ?>>
        <label for="x_frequencia" class="<?= $Page->LeftColumnClass ?>"><span id="elh_frequencia_frequencia"><?= $Page->frequencia->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_frequencia" id="z_frequencia" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->frequencia->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_frequencia_frequencia" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->frequencia->getInputTextType() ?>" name="x_frequencia" id="x_frequencia" data-table="frequencia" data-field="x_frequencia" value="<?= $Page->frequencia->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->frequencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->frequencia->formatPattern()) ?>"<?= $Page->frequencia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->frequencia->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->grau->Visible) { // grau ?>
    <div id="r_grau" class="row"<?= $Page->grau->rowAttributes() ?>>
        <label for="x_grau" class="<?= $Page->LeftColumnClass ?>"><span id="elh_frequencia_grau"><?= $Page->grau->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_grau" id="z_grau" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->grau->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_frequencia_grau" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->grau->getInputTextType() ?>" name="x_grau" id="x_grau" data-table="frequencia" data-field="x_grau" value="<?= $Page->grau->EditValue ?>" size="3" maxlength="1" placeholder="<?= HtmlEncode($Page->grau->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->grau->formatPattern()) ?>"<?= $Page->grau->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->grau->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs" class="row"<?= $Page->obs->rowAttributes() ?>>
        <label for="x_obs" class="<?= $Page->LeftColumnClass ?>"><span id="elh_frequencia_obs"><?= $Page->obs->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_obs" id="z_obs" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->obs->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_frequencia_obs" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="frequencia" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffrequenciasearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ffrequenciasearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="ffrequenciasearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("frequencia");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
