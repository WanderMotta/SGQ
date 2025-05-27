<?php

namespace PHPMaker2024\sgq;

// Page object
$OrigemRiscoOportunidadeSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { origem_risco_oportunidade: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var forigem_risco_oportunidadesearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("forigem_risco_oportunidadesearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idorigem_risco_oportunidade", [ew.Validators.integer], fields.idorigem_risco_oportunidade.isInvalid],
            ["origem", [], fields.origem.isInvalid],
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
<form name="forigem_risco_oportunidadesearch" id="forigem_risco_oportunidadesearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="origem_risco_oportunidade">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idorigem_risco_oportunidade->Visible) { // idorigem_risco_oportunidade ?>
    <div id="r_idorigem_risco_oportunidade" class="row"<?= $Page->idorigem_risco_oportunidade->rowAttributes() ?>>
        <label for="x_idorigem_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->idorigem_risco_oportunidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idorigem_risco_oportunidade" id="z_idorigem_risco_oportunidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idorigem_risco_oportunidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_origem_risco_oportunidade_idorigem_risco_oportunidade" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idorigem_risco_oportunidade->getInputTextType() ?>" name="x_idorigem_risco_oportunidade" id="x_idorigem_risco_oportunidade" data-table="origem_risco_oportunidade" data-field="x_idorigem_risco_oportunidade" value="<?= $Page->idorigem_risco_oportunidade->EditValue ?>" placeholder="<?= HtmlEncode($Page->idorigem_risco_oportunidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idorigem_risco_oportunidade->formatPattern()) ?>"<?= $Page->idorigem_risco_oportunidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idorigem_risco_oportunidade->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->origem->Visible) { // origem ?>
    <div id="r_origem" class="row"<?= $Page->origem->rowAttributes() ?>>
        <label for="x_origem" class="<?= $Page->LeftColumnClass ?>"><span id="elh_origem_risco_oportunidade_origem"><?= $Page->origem->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_origem" id="z_origem" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->origem->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_origem_risco_oportunidade_origem" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->origem->getInputTextType() ?>" name="x_origem" id="x_origem" data-table="origem_risco_oportunidade" data-field="x_origem" value="<?= $Page->origem->EditValue ?>" size="50" maxlength="60" placeholder="<?= HtmlEncode($Page->origem->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->origem->formatPattern()) ?>"<?= $Page->origem->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->origem->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs" class="row"<?= $Page->obs->rowAttributes() ?>>
        <label for="x_obs" class="<?= $Page->LeftColumnClass ?>"><span id="elh_origem_risco_oportunidade_obs"><?= $Page->obs->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_obs" id="z_obs" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->obs->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_origem_risco_oportunidade_obs" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="origem_risco_oportunidade" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?>>
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
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="forigem_risco_oportunidadesearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="forigem_risco_oportunidadesearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="forigem_risco_oportunidadesearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("origem_risco_oportunidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
