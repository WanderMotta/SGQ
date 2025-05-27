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
        .setQueryBuilderLists({
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
<form name="findicadoressearch" id="findicadoressearch" class="<?= $Page->FormClassName ?>" action="<?= HtmlEncode(GetUrl("IndicadoresList")) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="indicadores">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<input type="hidden" name="rules" value="<?= HtmlEncode($Page->getSessionRules()) ?>">
<template id="tpx_indicadores_idindicadores" class="indicadoressearch"><span id="el_indicadores_idindicadores" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idindicadores->getInputTextType() ?>" name="x_idindicadores" id="x_idindicadores" data-table="indicadores" data-field="x_idindicadores" value="<?= $Page->idindicadores->EditValue ?>" placeholder="<?= HtmlEncode($Page->idindicadores->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idindicadores->formatPattern()) ?>"<?= $Page->idindicadores->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idindicadores->getErrorMessage(false) ?></div>
</span></template>
<template id="tpx_indicadores_dt_cadastro" class="indicadoressearch"><span id="el_indicadores_dt_cadastro" class="ew-search-field ew-search-field-single">
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
</span></template>
<template id="tpx_indicadores_indicador" class="indicadoressearch"><span id="el_indicadores_indicador" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->indicador->getInputTextType() ?>" name="x_indicador" id="x_indicador" data-table="indicadores" data-field="x_indicador" value="<?= $Page->indicador->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->indicador->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->indicador->formatPattern()) ?>"<?= $Page->indicador->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->indicador->getErrorMessage(false) ?></div>
</span></template>
<template id="tpx_indicadores_periodicidade_idperiodicidade" class="indicadoressearch"><span id="el_indicadores_periodicidade_idperiodicidade" class="ew-search-field ew-search-field-single">
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
</span></template>
<template id="tpx_indicadores_unidade_medida_idunidade_medida" class="indicadoressearch"><span id="el_indicadores_unidade_medida_idunidade_medida" class="ew-search-field ew-search-field-single">
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
</span></template>
<template id="tpx_indicadores_meta" class="indicadoressearch"><span id="el_indicadores_meta" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->meta->getInputTextType() ?>" name="x_meta" id="x_meta" data-table="indicadores" data-field="x_meta" value="<?= $Page->meta->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->meta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->meta->formatPattern()) ?>"<?= $Page->meta->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->meta->getErrorMessage(false) ?></div>
</span></template>
<div id="indicadores_query_builder" class="query-builder mb-3"></div>
<div class="btn-group mb-3 query-btn-group"></div>
<button type="button" id="btn-view-rules" class="btn btn-primary d-none disabled" title="<?= HtmlEncode($Language->phrase("View", true)) ?>"><i class="fa-solid fa-eye ew-icon"></i></button>
<button type="button" id="btn-clear-rules" class="btn btn-primary d-none disabled" title="<?= HtmlEncode($Language->phrase("Clear", true)) ?>"><i class="fa-solid fa-xmark ew-icon"></i></button>
<script>
// Filter builder
loadjs.ready(["wrapper", "head"], () => {
    let filters = [
            {
                id: "idindicadores",
                type: "integer",
                label: currentTable.fields.idindicadores.caption,
                operators: currentTable.fields.idindicadores.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                validation: ew.getQueryBuilderFilterValidation(findicadoressearch.fields.idindicadores.validators),
                data: {
                    format: currentTable.fields.idindicadores.clientFormatPattern
                }
            },
            {
                id: "dt_cadastro",
                type: "datetime",
                label: currentTable.fields.dt_cadastro.caption,
                operators: currentTable.fields.dt_cadastro.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                value_separator: ew.IN_OPERATOR_VALUE_SEPARATOR,
                validation: ew.getQueryBuilderFilterValidation(findicadoressearch.fields.dt_cadastro.validators),
                data: {
                    format: currentTable.fields.dt_cadastro.clientFormatPattern
                }
            },
            {
                id: "indicador",
                type: "string",
                label: currentTable.fields.indicador.caption,
                operators: currentTable.fields.indicador.clientSearchOperators,
                input: ew.getQueryBuilderFilterInput(),
                value_separator: ew.IN_OPERATOR_VALUE_SEPARATOR,
                validation: ew.getQueryBuilderFilterValidation(findicadoressearch.fields.indicador.validators),
                data: {
                    format: currentTable.fields.indicador.clientFormatPattern
                }
            },
            {
                id: "periodicidade_idperiodicidade",
                type: "integer",
                label: currentTable.fields.periodicidade_idperiodicidade.caption,
                operators: currentTable.fields.periodicidade_idperiodicidade.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                valueSetter: ew.getQueryBuilderValueSetter(),
                validation: ew.getQueryBuilderFilterValidation(findicadoressearch.fields.periodicidade_idperiodicidade.validators),
                data: {
                    format: currentTable.fields.periodicidade_idperiodicidade.clientFormatPattern
                }
            },
            {
                id: "unidade_medida_idunidade_medida",
                type: "integer",
                label: currentTable.fields.unidade_medida_idunidade_medida.caption,
                operators: currentTable.fields.unidade_medida_idunidade_medida.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                valueSetter: ew.getQueryBuilderValueSetter(),
                validation: ew.getQueryBuilderFilterValidation(findicadoressearch.fields.unidade_medida_idunidade_medida.validators),
                data: {
                    format: currentTable.fields.unidade_medida_idunidade_medida.clientFormatPattern
                }
            },
            {
                id: "meta",
                type: "double",
                label: currentTable.fields.meta.caption,
                operators: currentTable.fields.meta.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                value_separator: ew.IN_OPERATOR_VALUE_SEPARATOR,
                validation: ew.getQueryBuilderFilterValidation(findicadoressearch.fields.meta.validators),
                data: {
                    format: currentTable.fields.meta.clientFormatPattern
                }
            },
        ],
        $ = jQuery,
        $qb = $("#indicadores_query_builder"),
        args = {},
        rules = ew.parseJson($("#findicadoressearch input[name=rules]").val()),
        queryBuilderOptions = Object.assign({}, ew.queryBuilderOptions),
        allowViewRules = queryBuilderOptions.allowViewRules,
        allowClearRules = queryBuilderOptions.allowClearRules,
        hasRules = group => Array.isArray(group?.rules) && group.rules.length > 0,
        getRules = () => $qb.queryBuilder("getRules", { skip_empty: true }),
        getSql = () => $qb.queryBuilder("getSQL", false, false, rules)?.sql;
    delete queryBuilderOptions.allowViewRules;
    delete queryBuilderOptions.allowClearRules;
    args.options = ew.deepAssign({
        plugins: Object.assign({}, ew.queryBuilderPlugins),
        lang: ew.language.phrase("querybuilderjs"),
        select_placeholder: ew.language.phrase("PleaseSelect"),
        inputs_separator: `<div class="d-inline-flex ms-2 me-2">${ew.language.phrase("AND")}</div>`, // For "between"
        filters,
        rules
    }, queryBuilderOptions);
    $qb.trigger("querybuilder", [args]);
    $qb.queryBuilder(args.options).on("rulesChanged.queryBuilder", () => {
        let rules = getRules();
        !ew.DEBUG || console.log(rules, getSql());
        $("#btn-reset, #btn-action, #btn-clear-rules, #btn-view-rules").toggleClass("disabled", !rules);
    }).on("afterCreateRuleInput.queryBuilder", function(e, rule) {
        let select = rule.$el.find(".rule-value-container").find("selection-list, select")[0];
        if (select) { // Selection list
            let id = select.dataset.field.replace("^x_", ""),
                form = ew.forms.get(select);
            form.updateList(select, undefined, undefined, true); // Update immediately
        }
    });
    $("#findicadoressearch").on("beforesubmit", function () {
        this.rules.value = JSON.stringify(getRules());
    });
    $("#btn-reset").toggleClass("d-none", false).on("click", () => {
        hasRules(rules) ? $qb.queryBuilder("setRules", rules) : $qb.queryBuilder("reset");
        return false;
    });
    $("#btn-action").toggleClass("d-none", false);
    if (allowClearRules) {
        $("#btn-clear-rules").appendTo(".query-btn-group").removeClass("d-none").on("click", () => $qb.queryBuilder("reset"));
    }
    if (allowViewRules) {
        $("#btn-view-rules").appendTo(".query-btn-group").removeClass("d-none").on("click", () => {
            let rules = getRules();
            if (hasRules(rules)) {
                let sql = getSql();
                ew.alert(sql ? '<pre class="text-start fs-6">' + sql + '</pre>' : '', "dark");
                !ew.DEBUG || console.log(rules, sql);
            } else {
                ew.alert(ew.language.phrase("EmptyLabel"));
            }
        });
    }
    $(".query-btn-group").toggleClass(".mb-3", $(".query-btn-group").find(".btn:not(.d-none)").length);
    if (hasRules(rules)) { // Enable buttons if rules exist initially
        $("#btn-reset, #btn-action, #btn-clear-rules, #btn-view-rules").removeClass("disabled");
    }
});
</script>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn d-none disabled" name="btn-action" id="btn-action" type="submit" form="findicadoressearch" formaction="<?= HtmlEncode(GetUrl("IndicadoresList")) ?>" data-ajax="<?= $Page->UseAjaxActions ? "true" : "false" ?>"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="findicadoressearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn d-none disabled" name="btn-reset" id="btn-reset" type="button" form="findicadoressearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
