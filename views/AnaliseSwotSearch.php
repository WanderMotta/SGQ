<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseSwotSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_swot: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fanalise_swotsearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fanalise_swotsearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idanalise_swot", [ew.Validators.integer], fields.idanalise_swot.isInvalid],
            ["dt_cadastro", [ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["fatores", [], fields.fatores.isInvalid],
            ["ponto", [], fields.ponto.isInvalid],
            ["analise", [], fields.analise.isInvalid],
            ["impacto_idimpacto", [], fields.impacto_idimpacto.isInvalid],
            ["contexto_idcontexto", [ew.Validators.integer], fields.contexto_idcontexto.isInvalid]
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
            "fatores": <?= $Page->fatores->toClientList($Page) ?>,
            "ponto": <?= $Page->ponto->toClientList($Page) ?>,
            "impacto_idimpacto": <?= $Page->impacto_idimpacto->toClientList($Page) ?>,
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
<form name="fanalise_swotsearch" id="fanalise_swotsearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="analise_swot">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idanalise_swot->Visible) { // idanalise_swot ?>
    <div id="r_idanalise_swot" class="row"<?= $Page->idanalise_swot->rowAttributes() ?>>
        <label for="x_idanalise_swot" class="<?= $Page->LeftColumnClass ?>"><span id="elh_analise_swot_idanalise_swot"><?= $Page->idanalise_swot->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idanalise_swot" id="z_idanalise_swot" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idanalise_swot->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_analise_swot_idanalise_swot" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idanalise_swot->getInputTextType() ?>" name="x_idanalise_swot" id="x_idanalise_swot" data-table="analise_swot" data-field="x_idanalise_swot" value="<?= $Page->idanalise_swot->EditValue ?>" placeholder="<?= HtmlEncode($Page->idanalise_swot->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idanalise_swot->formatPattern()) ?>"<?= $Page->idanalise_swot->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idanalise_swot->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro" class="row"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_analise_swot_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_cadastro" id="z_dt_cadastro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_cadastro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_analise_swot_dt_cadastro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="analise_swot" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fanalise_swotsearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fanalise_swotsearch", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->fatores->Visible) { // fatores ?>
    <div id="r_fatores" class="row"<?= $Page->fatores->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_analise_swot_fatores"><?= $Page->fatores->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_fatores" id="z_fatores" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->fatores->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_analise_swot_fatores" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->fatores->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_fatores"
    data-target="dsl_x_fatores"
    data-repeatcolumn="5"
    class="form-control<?= $Page->fatores->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_fatores"
    data-value-separator="<?= $Page->fatores->displayValueSeparatorAttribute() ?>"
    <?= $Page->fatores->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->fatores->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->ponto->Visible) { // ponto ?>
    <div id="r_ponto" class="row"<?= $Page->ponto->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_analise_swot_ponto"><?= $Page->ponto->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ponto" id="z_ponto" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->ponto->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_analise_swot_ponto" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->ponto->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_ponto"
    data-target="dsl_x_ponto"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ponto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_ponto"
    data-value-separator="<?= $Page->ponto->displayValueSeparatorAttribute() ?>"
    <?= $Page->ponto->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ponto->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->analise->Visible) { // analise ?>
    <div id="r_analise" class="row"<?= $Page->analise->rowAttributes() ?>>
        <label for="x_analise" class="<?= $Page->LeftColumnClass ?>"><span id="elh_analise_swot_analise"><?= $Page->analise->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_analise" id="z_analise" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->analise->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_analise_swot_analise" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->analise->getInputTextType() ?>" name="x_analise" id="x_analise" data-table="analise_swot" data-field="x_analise" value="<?= $Page->analise->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->analise->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->analise->formatPattern()) ?>"<?= $Page->analise->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->analise->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
    <div id="r_impacto_idimpacto" class="row"<?= $Page->impacto_idimpacto->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_analise_swot_impacto_idimpacto"><?= $Page->impacto_idimpacto->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_impacto_idimpacto" id="z_impacto_idimpacto" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->impacto_idimpacto->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_analise_swot_impacto_idimpacto" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->impacto_idimpacto->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_impacto_idimpacto"
    data-target="dsl_x_impacto_idimpacto"
    data-repeatcolumn="5"
    class="form-control<?= $Page->impacto_idimpacto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_impacto_idimpacto"
    data-value-separator="<?= $Page->impacto_idimpacto->displayValueSeparatorAttribute() ?>"
    <?= $Page->impacto_idimpacto->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->impacto_idimpacto->getErrorMessage(false) ?></div>
<?= $Page->impacto_idimpacto->Lookup->getParamTag($Page, "p_x_impacto_idimpacto") ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->contexto_idcontexto->Visible) { // contexto_idcontexto ?>
    <div id="r_contexto_idcontexto" class="row"<?= $Page->contexto_idcontexto->rowAttributes() ?>>
        <label for="x_contexto_idcontexto" class="<?= $Page->LeftColumnClass ?>"><span id="elh_analise_swot_contexto_idcontexto"><?= $Page->contexto_idcontexto->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_contexto_idcontexto" id="z_contexto_idcontexto" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->contexto_idcontexto->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_analise_swot_contexto_idcontexto" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->contexto_idcontexto->getInputTextType() ?>" name="x_contexto_idcontexto" id="x_contexto_idcontexto" data-table="analise_swot" data-field="x_contexto_idcontexto" value="<?= $Page->contexto_idcontexto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->contexto_idcontexto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contexto_idcontexto->formatPattern()) ?>"<?= $Page->contexto_idcontexto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->contexto_idcontexto->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fanalise_swotsearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fanalise_swotsearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fanalise_swotsearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
