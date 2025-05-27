<?php

namespace PHPMaker2024\sgq;

// Page object
$IndicadoresAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { indicadores: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var findicadoresadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("findicadoresadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["indicador", [fields.indicador.visible && fields.indicador.required ? ew.Validators.required(fields.indicador.caption) : null], fields.indicador.isInvalid],
            ["periodicidade_idperiodicidade", [fields.periodicidade_idperiodicidade.visible && fields.periodicidade_idperiodicidade.required ? ew.Validators.required(fields.periodicidade_idperiodicidade.caption) : null], fields.periodicidade_idperiodicidade.isInvalid],
            ["unidade_medida_idunidade_medida", [fields.unidade_medida_idunidade_medida.visible && fields.unidade_medida_idunidade_medida.required ? ew.Validators.required(fields.unidade_medida_idunidade_medida.caption) : null], fields.unidade_medida_idunidade_medida.isInvalid],
            ["meta", [fields.meta.visible && fields.meta.required ? ew.Validators.required(fields.meta.caption) : null, ew.Validators.float], fields.meta.isInvalid]
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
            "periodicidade_idperiodicidade": <?= $Page->periodicidade_idperiodicidade->toClientList($Page) ?>,
            "unidade_medida_idunidade_medida": <?= $Page->unidade_medida_idunidade_medida->toClientList($Page) ?>,
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
<form name="findicadoresadd" id="findicadoresadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="indicadores">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->indicador->Visible) { // indicador ?>
    <div id="r_indicador"<?= $Page->indicador->rowAttributes() ?>>
        <label id="elh_indicadores_indicador" for="x_indicador" class="<?= $Page->LeftColumnClass ?>"><?= $Page->indicador->caption() ?><?= $Page->indicador->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->indicador->cellAttributes() ?>>
<span id="el_indicadores_indicador">
<input type="<?= $Page->indicador->getInputTextType() ?>" name="x_indicador" id="x_indicador" data-table="indicadores" data-field="x_indicador" value="<?= $Page->indicador->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->indicador->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->indicador->formatPattern()) ?>"<?= $Page->indicador->editAttributes() ?> aria-describedby="x_indicador_help">
<?= $Page->indicador->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->indicador->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
    <div id="r_periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->rowAttributes() ?>>
        <label id="elh_indicadores_periodicidade_idperiodicidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periodicidade_idperiodicidade->caption() ?><?= $Page->periodicidade_idperiodicidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periodicidade_idperiodicidade->cellAttributes() ?>>
<span id="el_indicadores_periodicidade_idperiodicidade">
<template id="tp_x_periodicidade_idperiodicidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="indicadores" data-field="x_periodicidade_idperiodicidade" name="x_periodicidade_idperiodicidade" id="x_periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_periodicidade_idperiodicidade" class="ew-item-list"></div>
<selection-list hidden
    id="x_periodicidade_idperiodicidade"
    name="x_periodicidade_idperiodicidade"
    value="<?= HtmlEncode($Page->periodicidade_idperiodicidade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_periodicidade_idperiodicidade"
    data-target="dsl_x_periodicidade_idperiodicidade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodicidade_idperiodicidade->isInvalidClass() ?>"
    data-table="indicadores"
    data-field="x_periodicidade_idperiodicidade"
    data-value-separator="<?= $Page->periodicidade_idperiodicidade->displayValueSeparatorAttribute() ?>"
    <?= $Page->periodicidade_idperiodicidade->editAttributes() ?>></selection-list>
<?= $Page->periodicidade_idperiodicidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->periodicidade_idperiodicidade->getErrorMessage() ?></div>
<?= $Page->periodicidade_idperiodicidade->Lookup->getParamTag($Page, "p_x_periodicidade_idperiodicidade") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unidade_medida_idunidade_medida->Visible) { // unidade_medida_idunidade_medida ?>
    <div id="r_unidade_medida_idunidade_medida"<?= $Page->unidade_medida_idunidade_medida->rowAttributes() ?>>
        <label id="elh_indicadores_unidade_medida_idunidade_medida" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unidade_medida_idunidade_medida->caption() ?><?= $Page->unidade_medida_idunidade_medida->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->unidade_medida_idunidade_medida->cellAttributes() ?>>
<span id="el_indicadores_unidade_medida_idunidade_medida">
<template id="tp_x_unidade_medida_idunidade_medida">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="indicadores" data-field="x_unidade_medida_idunidade_medida" name="x_unidade_medida_idunidade_medida" id="x_unidade_medida_idunidade_medida"<?= $Page->unidade_medida_idunidade_medida->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_unidade_medida_idunidade_medida" class="ew-item-list"></div>
<selection-list hidden
    id="x_unidade_medida_idunidade_medida"
    name="x_unidade_medida_idunidade_medida"
    value="<?= HtmlEncode($Page->unidade_medida_idunidade_medida->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_unidade_medida_idunidade_medida"
    data-target="dsl_x_unidade_medida_idunidade_medida"
    data-repeatcolumn="5"
    class="form-control<?= $Page->unidade_medida_idunidade_medida->isInvalidClass() ?>"
    data-table="indicadores"
    data-field="x_unidade_medida_idunidade_medida"
    data-value-separator="<?= $Page->unidade_medida_idunidade_medida->displayValueSeparatorAttribute() ?>"
    <?= $Page->unidade_medida_idunidade_medida->editAttributes() ?>></selection-list>
<?= $Page->unidade_medida_idunidade_medida->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->unidade_medida_idunidade_medida->getErrorMessage() ?></div>
<?= $Page->unidade_medida_idunidade_medida->Lookup->getParamTag($Page, "p_x_unidade_medida_idunidade_medida") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->meta->Visible) { // meta ?>
    <div id="r_meta"<?= $Page->meta->rowAttributes() ?>>
        <label id="elh_indicadores_meta" for="x_meta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->meta->caption() ?><?= $Page->meta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->meta->cellAttributes() ?>>
<span id="el_indicadores_meta">
<input type="<?= $Page->meta->getInputTextType() ?>" name="x_meta" id="x_meta" data-table="indicadores" data-field="x_meta" value="<?= $Page->meta->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->meta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->meta->formatPattern()) ?>"<?= $Page->meta->editAttributes() ?> aria-describedby="x_meta_help">
<?= $Page->meta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->meta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("graficos", explode(",", $Page->getCurrentDetailTable())) && $graficos->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("graficos", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "GraficosGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="findicadoresadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="findicadoresadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("indicadores");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
