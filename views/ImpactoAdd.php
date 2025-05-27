<?php

namespace PHPMaker2024\sgq;

// Page object
$ImpactoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { impacto: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fimpactoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fimpactoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tipo_risco_oportunidade_idtipo_risco_oportunidade", [fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.visible && fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.required ? ew.Validators.required(fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.caption) : null], fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.isInvalid],
            ["impacto", [fields.impacto.visible && fields.impacto.required ? ew.Validators.required(fields.impacto.caption) : null], fields.impacto.isInvalid],
            ["grau", [fields.grau.visible && fields.grau.required ? ew.Validators.required(fields.grau.caption) : null, ew.Validators.integer], fields.grau.isInvalid],
            ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid]
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
            "tipo_risco_oportunidade_idtipo_risco_oportunidade": <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->toClientList($Page) ?>,
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fimpactoadd" id="fimpactoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="impacto">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
    <div id="r_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->rowAttributes() ?>>
        <label id="elh_impacto_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() ?><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
<span id="el_impacto_tipo_risco_oportunidade_idtipo_risco_oportunidade">
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
    value="<?= HtmlEncode($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-target="dsl_x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->isInvalidClass() ?>"
    data-table="impacto"
    data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-value-separator="<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>></selection-list>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getErrorMessage() ?></div>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getParamTag($Page, "p_x_tipo_risco_oportunidade_idtipo_risco_oportunidade") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->impacto->Visible) { // impacto ?>
    <div id="r_impacto"<?= $Page->impacto->rowAttributes() ?>>
        <label id="elh_impacto_impacto" for="x_impacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->impacto->caption() ?><?= $Page->impacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->impacto->cellAttributes() ?>>
<span id="el_impacto_impacto">
<input type="<?= $Page->impacto->getInputTextType() ?>" name="x_impacto" id="x_impacto" data-table="impacto" data-field="x_impacto" value="<?= $Page->impacto->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->impacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->impacto->formatPattern()) ?>"<?= $Page->impacto->editAttributes() ?> aria-describedby="x_impacto_help">
<?= $Page->impacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->impacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->grau->Visible) { // grau ?>
    <div id="r_grau"<?= $Page->grau->rowAttributes() ?>>
        <label id="elh_impacto_grau" for="x_grau" class="<?= $Page->LeftColumnClass ?>"><?= $Page->grau->caption() ?><?= $Page->grau->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->grau->cellAttributes() ?>>
<span id="el_impacto_grau">
<input type="<?= $Page->grau->getInputTextType() ?>" name="x_grau" id="x_grau" data-table="impacto" data-field="x_grau" value="<?= $Page->grau->EditValue ?>" size="3" maxlength="1" placeholder="<?= HtmlEncode($Page->grau->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->grau->formatPattern()) ?>"<?= $Page->grau->editAttributes() ?> aria-describedby="x_grau_help">
<?= $Page->grau->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->grau->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_impacto_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_impacto_obs">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="impacto" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help">
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fimpactoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fimpactoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
