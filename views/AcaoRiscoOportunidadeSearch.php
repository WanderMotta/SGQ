<?php

namespace PHPMaker2024\sgq;

// Page object
$AcaoRiscoOportunidadeSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { acao_risco_oportunidade: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var facao_risco_oportunidadesearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("facao_risco_oportunidadesearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idacao_risco_oportunidade", [ew.Validators.integer], fields.idacao_risco_oportunidade.isInvalid],
            ["tipo_risco_oportunidade_idtipo_risco_oportunidade", [], fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.isInvalid],
            ["acao", [], fields.acao.isInvalid],
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
<form name="facao_risco_oportunidadesearch" id="facao_risco_oportunidadesearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="acao_risco_oportunidade">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idacao_risco_oportunidade->Visible) { // idacao_risco_oportunidade ?>
    <div id="r_idacao_risco_oportunidade" class="row"<?= $Page->idacao_risco_oportunidade->rowAttributes() ?>>
        <label for="x_idacao_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_acao_risco_oportunidade_idacao_risco_oportunidade"><?= $Page->idacao_risco_oportunidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idacao_risco_oportunidade" id="z_idacao_risco_oportunidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idacao_risco_oportunidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_acao_risco_oportunidade_idacao_risco_oportunidade" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idacao_risco_oportunidade->getInputTextType() ?>" name="x_idacao_risco_oportunidade" id="x_idacao_risco_oportunidade" data-table="acao_risco_oportunidade" data-field="x_idacao_risco_oportunidade" value="<?= $Page->idacao_risco_oportunidade->EditValue ?>" placeholder="<?= HtmlEncode($Page->idacao_risco_oportunidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idacao_risco_oportunidade->formatPattern()) ?>"<?= $Page->idacao_risco_oportunidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idacao_risco_oportunidade->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
    <div id="r_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="row"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_acao_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_tipo_risco_oportunidade_idtipo_risco_oportunidade" id="z_tipo_risco_oportunidade_idtipo_risco_oportunidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_acao_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="ew-search-field ew-search-field-single">
<template id="tp_x_tipo_risco_oportunidade_idtipo_risco_oportunidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="acao_risco_oportunidade" data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" name="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" id="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>>
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
    data-table="acao_risco_oportunidade"
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
<?php if ($Page->acao->Visible) { // acao ?>
    <div id="r_acao" class="row"<?= $Page->acao->rowAttributes() ?>>
        <label for="x_acao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_acao_risco_oportunidade_acao"><?= $Page->acao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_acao" id="z_acao" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->acao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_acao_risco_oportunidade_acao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->acao->getInputTextType() ?>" name="x_acao" id="x_acao" data-table="acao_risco_oportunidade" data-field="x_acao" value="<?= $Page->acao->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->acao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->acao->formatPattern()) ?>"<?= $Page->acao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->acao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs" class="row"<?= $Page->obs->rowAttributes() ?>>
        <label for="x_obs" class="<?= $Page->LeftColumnClass ?>"><span id="elh_acao_risco_oportunidade_obs"><?= $Page->obs->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_obs" id="z_obs" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->obs->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_acao_risco_oportunidade_obs" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="acao_risco_oportunidade" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?>>
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
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="facao_risco_oportunidadesearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="facao_risco_oportunidadesearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="facao_risco_oportunidadesearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("acao_risco_oportunidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
