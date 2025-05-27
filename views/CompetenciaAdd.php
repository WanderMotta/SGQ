<?php

namespace PHPMaker2024\sgq;

// Page object
$CompetenciaAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { competencia: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fcompetenciaadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcompetenciaadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["mes", [fields.mes.visible && fields.mes.required ? ew.Validators.required(fields.mes.caption) : null], fields.mes.isInvalid],
            ["ano", [fields.ano.visible && fields.ano.required ? ew.Validators.required(fields.ano.caption) : null], fields.ano.isInvalid],
            ["data_base", [fields.data_base.visible && fields.data_base.required ? ew.Validators.required(fields.data_base.caption) : null, ew.Validators.datetime(fields.data_base.clientFormatPattern)], fields.data_base.isInvalid]
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
            "mes": <?= $Page->mes->toClientList($Page) ?>,
            "ano": <?= $Page->ano->toClientList($Page) ?>,
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
<form name="fcompetenciaadd" id="fcompetenciaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="competencia">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->mes->Visible) { // mes ?>
    <div id="r_mes"<?= $Page->mes->rowAttributes() ?>>
        <label id="elh_competencia_mes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mes->caption() ?><?= $Page->mes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mes->cellAttributes() ?>>
<span id="el_competencia_mes">
<template id="tp_x_mes">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="competencia" data-field="x_mes" name="x_mes" id="x_mes"<?= $Page->mes->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_mes" class="ew-item-list"></div>
<selection-list hidden
    id="x_mes"
    name="x_mes"
    value="<?= HtmlEncode($Page->mes->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_mes"
    data-target="dsl_x_mes"
    data-repeatcolumn="6"
    class="form-control<?= $Page->mes->isInvalidClass() ?>"
    data-table="competencia"
    data-field="x_mes"
    data-value-separator="<?= $Page->mes->displayValueSeparatorAttribute() ?>"
    <?= $Page->mes->editAttributes() ?>></selection-list>
<?= $Page->mes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ano->Visible) { // ano ?>
    <div id="r_ano"<?= $Page->ano->rowAttributes() ?>>
        <label id="elh_competencia_ano" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ano->caption() ?><?= $Page->ano->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ano->cellAttributes() ?>>
<span id="el_competencia_ano">
<template id="tp_x_ano">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="competencia" data-field="x_ano" name="x_ano" id="x_ano"<?= $Page->ano->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_ano" class="ew-item-list"></div>
<selection-list hidden
    id="x_ano"
    name="x_ano"
    value="<?= HtmlEncode($Page->ano->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_ano"
    data-target="dsl_x_ano"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ano->isInvalidClass() ?>"
    data-table="competencia"
    data-field="x_ano"
    data-value-separator="<?= $Page->ano->displayValueSeparatorAttribute() ?>"
    <?= $Page->ano->editAttributes() ?>></selection-list>
<?= $Page->ano->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ano->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->data_base->Visible) { // data_base ?>
    <div id="r_data_base"<?= $Page->data_base->rowAttributes() ?>>
        <label id="elh_competencia_data_base" for="x_data_base" class="<?= $Page->LeftColumnClass ?>"><?= $Page->data_base->caption() ?><?= $Page->data_base->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->data_base->cellAttributes() ?>>
<span id="el_competencia_data_base">
<input type="<?= $Page->data_base->getInputTextType() ?>" name="x_data_base" id="x_data_base" data-table="competencia" data-field="x_data_base" value="<?= $Page->data_base->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->data_base->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->data_base->formatPattern()) ?>"<?= $Page->data_base->editAttributes() ?> aria-describedby="x_data_base_help">
<?= $Page->data_base->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->data_base->getErrorMessage() ?></div>
<?php if (!$Page->data_base->ReadOnly && !$Page->data_base->Disabled && !isset($Page->data_base->EditAttrs["readonly"]) && !isset($Page->data_base->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcompetenciaadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fcompetenciaadd", "x_data_base", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcompetenciaadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcompetenciaadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("competencia");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
