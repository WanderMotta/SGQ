<?php

namespace PHPMaker2024\sgq;

// Page object
$ImpactoSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { impacto: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fimpactosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fimpactosearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idimpacto", [ew.Validators.integer], fields.idimpacto.isInvalid],
            ["tipo_risco_oportunidade_idtipo_risco_oportunidade", [], fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.isInvalid],
            ["impacto", [], fields.impacto.isInvalid],
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
            "tipo_risco_oportunidade_idtipo_risco_oportunidade": <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->toClientList($Page) ?>,
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
<form name="fimpactosearch" id="fimpactosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="impacto">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idimpacto->Visible) { // idimpacto ?>
    <div id="r_idimpacto" class="row"<?= $Page->idimpacto->rowAttributes() ?>>
        <label for="x_idimpacto" class="<?= $Page->LeftColumnClass ?>"><span id="elh_impacto_idimpacto"><?= $Page->idimpacto->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idimpacto" id="z_idimpacto" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idimpacto->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_impacto_idimpacto" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idimpacto->getInputTextType() ?>" name="x_idimpacto" id="x_idimpacto" data-table="impacto" data-field="x_idimpacto" value="<?= $Page->idimpacto->EditValue ?>" placeholder="<?= HtmlEncode($Page->idimpacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idimpacto->formatPattern()) ?>"<?= $Page->idimpacto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idimpacto->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
    <div id="r_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="row"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_impacto_tipo_risco_oportunidade_idtipo_risco_oportunidade"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_tipo_risco_oportunidade_idtipo_risco_oportunidade" id="z_tipo_risco_oportunidade_idtipo_risco_oportunidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_impacto_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="ew-search-field ew-search-field-single">
<template id="tp_x_tipo_risco_oportunidade_idtipo_risco_oportunidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="impacto" data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" name="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" id="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="ew-item-list"></div>
<selection-list hidden
    id="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    name="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    value="<?= HtmlEncode($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-target="dsl_x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->isInvalidClass() ?>"
    data-table="impacto"
    data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-value-separator="<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getErrorMessage(false) ?></div>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getParamTag($Page, "p_x_tipo_risco_oportunidade_idtipo_risco_oportunidade") ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->impacto->Visible) { // impacto ?>
    <div id="r_impacto" class="row"<?= $Page->impacto->rowAttributes() ?>>
        <label for="x_impacto" class="<?= $Page->LeftColumnClass ?>"><span id="elh_impacto_impacto"><?= $Page->impacto->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_impacto" id="z_impacto" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->impacto->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_impacto_impacto" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->impacto->getInputTextType() ?>" name="x_impacto" id="x_impacto" data-table="impacto" data-field="x_impacto" value="<?= $Page->impacto->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->impacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->impacto->formatPattern()) ?>"<?= $Page->impacto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->impacto->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->grau->Visible) { // grau ?>
    <div id="r_grau" class="row"<?= $Page->grau->rowAttributes() ?>>
        <label for="x_grau" class="<?= $Page->LeftColumnClass ?>"><span id="elh_impacto_grau"><?= $Page->grau->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_grau" id="z_grau" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->grau->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_impacto_grau" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->grau->getInputTextType() ?>" name="x_grau" id="x_grau" data-table="impacto" data-field="x_grau" value="<?= $Page->grau->EditValue ?>" size="3" maxlength="1" placeholder="<?= HtmlEncode($Page->grau->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->grau->formatPattern()) ?>"<?= $Page->grau->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->grau->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs" class="row"<?= $Page->obs->rowAttributes() ?>>
        <label for="x_obs" class="<?= $Page->LeftColumnClass ?>"><span id="elh_impacto_obs"><?= $Page->obs->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_obs" id="z_obs" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->obs->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_impacto_obs" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="impacto" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?>>
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
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fimpactosearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fimpactosearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fimpactosearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("impacto");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
