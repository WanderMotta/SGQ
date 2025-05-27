<?php

namespace PHPMaker2024\sgq;

// Page object
$PeriodicidadeSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { periodicidade: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fperiodicidadesearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fperiodicidadesearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idperiodicidade", [ew.Validators.integer], fields.idperiodicidade.isInvalid],
            ["periodicidade", [], fields.periodicidade.isInvalid]
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
<form name="fperiodicidadesearch" id="fperiodicidadesearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="periodicidade">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idperiodicidade->Visible) { // idperiodicidade ?>
    <div id="r_idperiodicidade" class="row"<?= $Page->idperiodicidade->rowAttributes() ?>>
        <label for="x_idperiodicidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_periodicidade_idperiodicidade"><?= $Page->idperiodicidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idperiodicidade" id="z_idperiodicidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idperiodicidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_periodicidade_idperiodicidade" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idperiodicidade->getInputTextType() ?>" name="x_idperiodicidade" id="x_idperiodicidade" data-table="periodicidade" data-field="x_idperiodicidade" value="<?= $Page->idperiodicidade->EditValue ?>" placeholder="<?= HtmlEncode($Page->idperiodicidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idperiodicidade->formatPattern()) ?>"<?= $Page->idperiodicidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idperiodicidade->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->periodicidade->Visible) { // periodicidade ?>
    <div id="r_periodicidade" class="row"<?= $Page->periodicidade->rowAttributes() ?>>
        <label for="x_periodicidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_periodicidade_periodicidade"><?= $Page->periodicidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_periodicidade" id="z_periodicidade" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->periodicidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_periodicidade_periodicidade" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->periodicidade->getInputTextType() ?>" name="x_periodicidade" id="x_periodicidade" data-table="periodicidade" data-field="x_periodicidade" value="<?= $Page->periodicidade->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->periodicidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->periodicidade->formatPattern()) ?>"<?= $Page->periodicidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->periodicidade->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fperiodicidadesearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fperiodicidadesearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fperiodicidadesearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
