<?php

namespace PHPMaker2024\sgq;

// Page object
$LocalizacaoSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { localizacao: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var flocalizacaosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("flocalizacaosearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idlocalizacao", [ew.Validators.integer], fields.idlocalizacao.isInvalid],
            ["localizacao", [], fields.localizacao.isInvalid],
            ["ativo", [], fields.ativo.isInvalid]
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
            "ativo": <?= $Page->ativo->toClientList($Page) ?>,
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
<form name="flocalizacaosearch" id="flocalizacaosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="localizacao">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idlocalizacao->Visible) { // idlocalizacao ?>
    <div id="r_idlocalizacao" class="row"<?= $Page->idlocalizacao->rowAttributes() ?>>
        <label for="x_idlocalizacao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_localizacao_idlocalizacao"><?= $Page->idlocalizacao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idlocalizacao" id="z_idlocalizacao" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idlocalizacao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_localizacao_idlocalizacao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idlocalizacao->getInputTextType() ?>" name="x_idlocalizacao" id="x_idlocalizacao" data-table="localizacao" data-field="x_idlocalizacao" value="<?= $Page->idlocalizacao->EditValue ?>" placeholder="<?= HtmlEncode($Page->idlocalizacao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idlocalizacao->formatPattern()) ?>"<?= $Page->idlocalizacao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idlocalizacao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->localizacao->Visible) { // localizacao ?>
    <div id="r_localizacao" class="row"<?= $Page->localizacao->rowAttributes() ?>>
        <label for="x_localizacao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_localizacao_localizacao"><?= $Page->localizacao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_localizacao" id="z_localizacao" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->localizacao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_localizacao_localizacao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->localizacao->getInputTextType() ?>" name="x_localizacao" id="x_localizacao" data-table="localizacao" data-field="x_localizacao" value="<?= $Page->localizacao->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->localizacao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->localizacao->formatPattern()) ?>"<?= $Page->localizacao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->localizacao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
    <div id="r_ativo" class="row"<?= $Page->ativo->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_localizacao_ativo"><?= $Page->ativo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ativo" id="z_ativo" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->ativo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_localizacao_ativo" class="ew-search-field ew-search-field-single">
<template id="tp_x_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="localizacao" data-field="x_ativo" name="x_ativo" id="x_ativo"<?= $Page->ativo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_ativo" class="ew-item-list"></div>
<selection-list hidden
    id="x_ativo"
    name="x_ativo"
    value="<?= HtmlEncode($Page->ativo->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_ativo"
    data-target="dsl_x_ativo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ativo->isInvalidClass() ?>"
    data-table="localizacao"
    data-field="x_ativo"
    data-value-separator="<?= $Page->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Page->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ativo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="flocalizacaosearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="flocalizacaosearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="flocalizacaosearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("localizacao");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
