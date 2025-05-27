<?php

namespace PHPMaker2024\sgq;

// Page object
$IndicadoresSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { indicadores: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var findicadoressearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("findicadoressearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idindicadores", [ew.Validators.integer], fields.idindicadores.isInvalid],
            ["dt_cadastro", [ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["indicador", [], fields.indicador.isInvalid],
            ["periodicidade_idperiodicidade", [], fields.periodicidade_idperiodicidade.isInvalid],
            ["unidade_medida_idunidade_medida", [], fields.unidade_medida_idunidade_medida.isInvalid],
            ["meta", [ew.Validators.float], fields.meta.isInvalid]
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
            "periodicidade_idperiodicidade": <?= $Page->periodicidade_idperiodicidade->toClientList($Page) ?>,
            "unidade_medida_idunidade_medida": <?= $Page->unidade_medida_idunidade_medida->toClientList($Page) ?>,
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
<form name="findicadoressearch" id="findicadoressearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="indicadores">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idindicadores->Visible) { // idindicadores ?>
    <div id="r_idindicadores" class="row"<?= $Page->idindicadores->rowAttributes() ?>>
        <label for="x_idindicadores" class="<?= $Page->LeftColumnClass ?>"><span id="elh_indicadores_idindicadores"><?= $Page->idindicadores->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idindicadores" id="z_idindicadores" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idindicadores->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_indicadores_idindicadores" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idindicadores->getInputTextType() ?>" name="x_idindicadores" id="x_idindicadores" data-table="indicadores" data-field="x_idindicadores" value="<?= $Page->idindicadores->EditValue ?>" placeholder="<?= HtmlEncode($Page->idindicadores->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idindicadores->formatPattern()) ?>"<?= $Page->idindicadores->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idindicadores->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro" class="row"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_indicadores_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_cadastro" id="z_dt_cadastro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_cadastro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_indicadores_dt_cadastro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="indicadores" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["findicadoressearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("findicadoressearch", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->indicador->Visible) { // indicador ?>
    <div id="r_indicador" class="row"<?= $Page->indicador->rowAttributes() ?>>
        <label for="x_indicador" class="<?= $Page->LeftColumnClass ?>"><span id="elh_indicadores_indicador"><?= $Page->indicador->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_indicador" id="z_indicador" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->indicador->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_indicadores_indicador" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->indicador->getInputTextType() ?>" name="x_indicador" id="x_indicador" data-table="indicadores" data-field="x_indicador" value="<?= $Page->indicador->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->indicador->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->indicador->formatPattern()) ?>"<?= $Page->indicador->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->indicador->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
    <div id="r_periodicidade_idperiodicidade" class="row"<?= $Page->periodicidade_idperiodicidade->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_indicadores_periodicidade_idperiodicidade"><?= $Page->periodicidade_idperiodicidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_periodicidade_idperiodicidade" id="z_periodicidade_idperiodicidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->periodicidade_idperiodicidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_indicadores_periodicidade_idperiodicidade" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->periodicidade_idperiodicidade->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_periodicidade_idperiodicidade"
    data-target="dsl_x_periodicidade_idperiodicidade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodicidade_idperiodicidade->isInvalidClass() ?>"
    data-table="indicadores"
    data-field="x_periodicidade_idperiodicidade"
    data-value-separator="<?= $Page->periodicidade_idperiodicidade->displayValueSeparatorAttribute() ?>"
    <?= $Page->periodicidade_idperiodicidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->periodicidade_idperiodicidade->getErrorMessage(false) ?></div>
<?= $Page->periodicidade_idperiodicidade->Lookup->getParamTag($Page, "p_x_periodicidade_idperiodicidade") ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->unidade_medida_idunidade_medida->Visible) { // unidade_medida_idunidade_medida ?>
    <div id="r_unidade_medida_idunidade_medida" class="row"<?= $Page->unidade_medida_idunidade_medida->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_indicadores_unidade_medida_idunidade_medida"><?= $Page->unidade_medida_idunidade_medida->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_unidade_medida_idunidade_medida" id="z_unidade_medida_idunidade_medida" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->unidade_medida_idunidade_medida->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_indicadores_unidade_medida_idunidade_medida" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->unidade_medida_idunidade_medida->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_unidade_medida_idunidade_medida"
    data-target="dsl_x_unidade_medida_idunidade_medida"
    data-repeatcolumn="5"
    class="form-control<?= $Page->unidade_medida_idunidade_medida->isInvalidClass() ?>"
    data-table="indicadores"
    data-field="x_unidade_medida_idunidade_medida"
    data-value-separator="<?= $Page->unidade_medida_idunidade_medida->displayValueSeparatorAttribute() ?>"
    <?= $Page->unidade_medida_idunidade_medida->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->unidade_medida_idunidade_medida->getErrorMessage(false) ?></div>
<?= $Page->unidade_medida_idunidade_medida->Lookup->getParamTag($Page, "p_x_unidade_medida_idunidade_medida") ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->meta->Visible) { // meta ?>
    <div id="r_meta" class="row"<?= $Page->meta->rowAttributes() ?>>
        <label for="x_meta" class="<?= $Page->LeftColumnClass ?>"><span id="elh_indicadores_meta"><?= $Page->meta->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_meta" id="z_meta" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->meta->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_indicadores_meta" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->meta->getInputTextType() ?>" name="x_meta" id="x_meta" data-table="indicadores" data-field="x_meta" value="<?= $Page->meta->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->meta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->meta->formatPattern()) ?>"<?= $Page->meta->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->meta->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="findicadoressearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="findicadoressearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="findicadoressearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
