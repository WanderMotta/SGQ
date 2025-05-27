<?php

namespace PHPMaker2024\sgq;

// Page object
$DepartamentosSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { departamentos: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fdepartamentossearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fdepartamentossearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["iddepartamentos", [ew.Validators.integer], fields.iddepartamentos.isInvalid],
            ["departamento", [], fields.departamento.isInvalid]
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
<form name="fdepartamentossearch" id="fdepartamentossearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="departamentos">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->iddepartamentos->Visible) { // iddepartamentos ?>
    <div id="r_iddepartamentos" class="row"<?= $Page->iddepartamentos->rowAttributes() ?>>
        <label for="x_iddepartamentos" class="<?= $Page->LeftColumnClass ?>"><span id="elh_departamentos_iddepartamentos"><?= $Page->iddepartamentos->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_iddepartamentos" id="z_iddepartamentos" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->iddepartamentos->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_departamentos_iddepartamentos" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->iddepartamentos->getInputTextType() ?>" name="x_iddepartamentos" id="x_iddepartamentos" data-table="departamentos" data-field="x_iddepartamentos" value="<?= $Page->iddepartamentos->EditValue ?>" placeholder="<?= HtmlEncode($Page->iddepartamentos->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->iddepartamentos->formatPattern()) ?>"<?= $Page->iddepartamentos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->iddepartamentos->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->departamento->Visible) { // departamento ?>
    <div id="r_departamento" class="row"<?= $Page->departamento->rowAttributes() ?>>
        <label for="x_departamento" class="<?= $Page->LeftColumnClass ?>"><span id="elh_departamentos_departamento"><?= $Page->departamento->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_departamento" id="z_departamento" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->departamento->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_departamentos_departamento" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->departamento->getInputTextType() ?>" name="x_departamento" id="x_departamento" data-table="departamentos" data-field="x_departamento" value="<?= $Page->departamento->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->departamento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->departamento->formatPattern()) ?>"<?= $Page->departamento->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->departamento->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdepartamentossearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdepartamentossearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fdepartamentossearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("departamentos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
