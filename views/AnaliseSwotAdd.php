<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseSwotAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_swot: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fanalise_swotadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fanalise_swotadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["fatores", [fields.fatores.visible && fields.fatores.required ? ew.Validators.required(fields.fatores.caption) : null], fields.fatores.isInvalid],
            ["ponto", [fields.ponto.visible && fields.ponto.required ? ew.Validators.required(fields.ponto.caption) : null], fields.ponto.isInvalid],
            ["analise", [fields.analise.visible && fields.analise.required ? ew.Validators.required(fields.analise.caption) : null], fields.analise.isInvalid],
            ["impacto_idimpacto", [fields.impacto_idimpacto.visible && fields.impacto_idimpacto.required ? ew.Validators.required(fields.impacto_idimpacto.caption) : null], fields.impacto_idimpacto.isInvalid],
            ["contexto_idcontexto", [fields.contexto_idcontexto.visible && fields.contexto_idcontexto.required ? ew.Validators.required(fields.contexto_idcontexto.caption) : null, ew.Validators.integer], fields.contexto_idcontexto.isInvalid]
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
            "fatores": <?= $Page->fatores->toClientList($Page) ?>,
            "ponto": <?= $Page->ponto->toClientList($Page) ?>,
            "impacto_idimpacto": <?= $Page->impacto_idimpacto->toClientList($Page) ?>,
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
<form name="fanalise_swotadd" id="fanalise_swotadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="analise_swot">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "contexto") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="contexto">
<input type="hidden" name="fk_idcontexto" value="<?= HtmlEncode($Page->contexto_idcontexto->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->fatores->Visible) { // fatores ?>
    <div id="r_fatores"<?= $Page->fatores->rowAttributes() ?>>
        <label id="elh_analise_swot_fatores" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fatores->caption() ?><?= $Page->fatores->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fatores->cellAttributes() ?>>
<span id="el_analise_swot_fatores">
<template id="tp_x_fatores">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_fatores" name="x_fatores" id="x_fatores"<?= $Page->fatores->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_fatores" class="ew-item-list"></div>
<selection-list hidden
    id="x_fatores"
    name="x_fatores"
    value="<?= HtmlEncode($Page->fatores->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_fatores"
    data-target="dsl_x_fatores"
    data-repeatcolumn="5"
    class="form-control<?= $Page->fatores->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_fatores"
    data-value-separator="<?= $Page->fatores->displayValueSeparatorAttribute() ?>"
    <?= $Page->fatores->editAttributes() ?>></selection-list>
<?= $Page->fatores->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fatores->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ponto->Visible) { // ponto ?>
    <div id="r_ponto"<?= $Page->ponto->rowAttributes() ?>>
        <label id="elh_analise_swot_ponto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ponto->caption() ?><?= $Page->ponto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ponto->cellAttributes() ?>>
<span id="el_analise_swot_ponto">
<template id="tp_x_ponto">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_ponto" name="x_ponto" id="x_ponto"<?= $Page->ponto->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_ponto" class="ew-item-list"></div>
<selection-list hidden
    id="x_ponto"
    name="x_ponto"
    value="<?= HtmlEncode($Page->ponto->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_ponto"
    data-target="dsl_x_ponto"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ponto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_ponto"
    data-value-separator="<?= $Page->ponto->displayValueSeparatorAttribute() ?>"
    <?= $Page->ponto->editAttributes() ?>></selection-list>
<?= $Page->ponto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ponto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->analise->Visible) { // analise ?>
    <div id="r_analise"<?= $Page->analise->rowAttributes() ?>>
        <label id="elh_analise_swot_analise" for="x_analise" class="<?= $Page->LeftColumnClass ?>"><?= $Page->analise->caption() ?><?= $Page->analise->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->analise->cellAttributes() ?>>
<span id="el_analise_swot_analise">
<textarea data-table="analise_swot" data-field="x_analise" name="x_analise" id="x_analise" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->analise->getPlaceHolder()) ?>"<?= $Page->analise->editAttributes() ?> aria-describedby="x_analise_help"><?= $Page->analise->EditValue ?></textarea>
<?= $Page->analise->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->analise->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
    <div id="r_impacto_idimpacto"<?= $Page->impacto_idimpacto->rowAttributes() ?>>
        <label id="elh_analise_swot_impacto_idimpacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->impacto_idimpacto->caption() ?><?= $Page->impacto_idimpacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->impacto_idimpacto->cellAttributes() ?>>
<span id="el_analise_swot_impacto_idimpacto">
<template id="tp_x_impacto_idimpacto">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_impacto_idimpacto" name="x_impacto_idimpacto" id="x_impacto_idimpacto"<?= $Page->impacto_idimpacto->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_impacto_idimpacto" class="ew-item-list"></div>
<selection-list hidden
    id="x_impacto_idimpacto"
    name="x_impacto_idimpacto"
    value="<?= HtmlEncode($Page->impacto_idimpacto->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_impacto_idimpacto"
    data-target="dsl_x_impacto_idimpacto"
    data-repeatcolumn="5"
    class="form-control<?= $Page->impacto_idimpacto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_impacto_idimpacto"
    data-value-separator="<?= $Page->impacto_idimpacto->displayValueSeparatorAttribute() ?>"
    <?= $Page->impacto_idimpacto->editAttributes() ?>></selection-list>
<?= $Page->impacto_idimpacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->impacto_idimpacto->getErrorMessage() ?></div>
<?= $Page->impacto_idimpacto->Lookup->getParamTag($Page, "p_x_impacto_idimpacto") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contexto_idcontexto->Visible) { // contexto_idcontexto ?>
    <div id="r_contexto_idcontexto"<?= $Page->contexto_idcontexto->rowAttributes() ?>>
        <label id="elh_analise_swot_contexto_idcontexto" for="x_contexto_idcontexto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contexto_idcontexto->caption() ?><?= $Page->contexto_idcontexto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contexto_idcontexto->cellAttributes() ?>>
<?php if ($Page->contexto_idcontexto->getSessionValue() != "") { ?>
<span<?= $Page->contexto_idcontexto->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->contexto_idcontexto->getDisplayValue($Page->contexto_idcontexto->ViewValue))) ?>"></span>
<input type="hidden" id="x_contexto_idcontexto" name="x_contexto_idcontexto" value="<?= HtmlEncode($Page->contexto_idcontexto->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_analise_swot_contexto_idcontexto">
<input type="<?= $Page->contexto_idcontexto->getInputTextType() ?>" name="x_contexto_idcontexto" id="x_contexto_idcontexto" data-table="analise_swot" data-field="x_contexto_idcontexto" value="<?= $Page->contexto_idcontexto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->contexto_idcontexto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contexto_idcontexto->formatPattern()) ?>"<?= $Page->contexto_idcontexto->editAttributes() ?> aria-describedby="x_contexto_idcontexto_help">
<?= $Page->contexto_idcontexto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contexto_idcontexto->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fanalise_swotadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fanalise_swotadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("analise_swot");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
