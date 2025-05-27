<?php

namespace PHPMaker2024\sgq;

// Page object
$GraficosSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { graficos: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fgraficossearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fgraficossearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idgraficos", [ew.Validators.integer], fields.idgraficos.isInvalid],
            ["competencia_idcompetencia", [], fields.competencia_idcompetencia.isInvalid],
            ["indicadores_idindicadores", [], fields.indicadores_idindicadores.isInvalid],
            ["data_base", [ew.Validators.datetime(fields.data_base.clientFormatPattern)], fields.data_base.isInvalid],
            ["valor", [ew.Validators.float], fields.valor.isInvalid],
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
        .setQueryBuilderLists({
            "competencia_idcompetencia": <?= $Page->competencia_idcompetencia->toClientList($Page) ?>,
            "indicadores_idindicadores": <?= $Page->indicadores_idindicadores->toClientList($Page) ?>,
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
<form name="fgraficossearch" id="fgraficossearch" class="<?= $Page->FormClassName ?>" action="<?= HtmlEncode(GetUrl("GraficosList")) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="graficos">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<input type="hidden" name="rules" value="<?= HtmlEncode($Page->getSessionRules()) ?>">
<template id="tpx_graficos_idgraficos" class="graficossearch"><span id="el_graficos_idgraficos" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idgraficos->getInputTextType() ?>" name="x_idgraficos" id="x_idgraficos" data-table="graficos" data-field="x_idgraficos" value="<?= $Page->idgraficos->EditValue ?>" placeholder="<?= HtmlEncode($Page->idgraficos->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idgraficos->formatPattern()) ?>"<?= $Page->idgraficos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idgraficos->getErrorMessage(false) ?></div>
</span></template>
<template id="tpx_graficos_competencia_idcompetencia" class="graficossearch"><span id="el_graficos_competencia_idcompetencia" class="ew-search-field ew-search-field-single">
    <select
        id="x_competencia_idcompetencia"
        name="x_competencia_idcompetencia"
        class="form-select ew-select<?= $Page->competencia_idcompetencia->isInvalidClass() ?>"
        <?php if (!$Page->competencia_idcompetencia->IsNativeSelect) { ?>
        data-select2-id="fgraficossearch_x_competencia_idcompetencia"
        <?php } ?>
        data-table="graficos"
        data-field="x_competencia_idcompetencia"
        data-value-separator="<?= $Page->competencia_idcompetencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->competencia_idcompetencia->getPlaceHolder()) ?>"
        <?= $Page->competencia_idcompetencia->editAttributes() ?>>
        <?= $Page->competencia_idcompetencia->selectOptionListHtml("x_competencia_idcompetencia") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->competencia_idcompetencia->getErrorMessage(false) ?></div>
<?= $Page->competencia_idcompetencia->Lookup->getParamTag($Page, "p_x_competencia_idcompetencia") ?>
<?php if (!$Page->competencia_idcompetencia->IsNativeSelect) { ?>
<script>
loadjs.ready("fgraficossearch", function() {
    var options = { name: "x_competencia_idcompetencia", selectId: "fgraficossearch_x_competencia_idcompetencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fgraficossearch.lists.competencia_idcompetencia?.lookupOptions.length) {
        options.data = { id: "x_competencia_idcompetencia", form: "fgraficossearch" };
    } else {
        options.ajax = { id: "x_competencia_idcompetencia", form: "fgraficossearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.competencia_idcompetencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span></template>
<template id="tpx_graficos_indicadores_idindicadores" class="graficossearch"><span id="el_graficos_indicadores_idindicadores" class="ew-search-field ew-search-field-single">
    <select
        id="x_indicadores_idindicadores"
        name="x_indicadores_idindicadores"
        class="form-select ew-select<?= $Page->indicadores_idindicadores->isInvalidClass() ?>"
        <?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
        data-select2-id="fgraficossearch_x_indicadores_idindicadores"
        <?php } ?>
        data-table="graficos"
        data-field="x_indicadores_idindicadores"
        data-value-separator="<?= $Page->indicadores_idindicadores->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->indicadores_idindicadores->getPlaceHolder()) ?>"
        <?= $Page->indicadores_idindicadores->editAttributes() ?>>
        <?= $Page->indicadores_idindicadores->selectOptionListHtml("x_indicadores_idindicadores") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->indicadores_idindicadores->getErrorMessage(false) ?></div>
<?= $Page->indicadores_idindicadores->Lookup->getParamTag($Page, "p_x_indicadores_idindicadores") ?>
<?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
<script>
loadjs.ready("fgraficossearch", function() {
    var options = { name: "x_indicadores_idindicadores", selectId: "fgraficossearch_x_indicadores_idindicadores" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fgraficossearch.lists.indicadores_idindicadores?.lookupOptions.length) {
        options.data = { id: "x_indicadores_idindicadores", form: "fgraficossearch" };
    } else {
        options.ajax = { id: "x_indicadores_idindicadores", form: "fgraficossearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.indicadores_idindicadores.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span></template>
<template id="tpx_graficos_data_base" class="graficossearch"><span id="el_graficos_data_base" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->data_base->getInputTextType() ?>" name="x_data_base" id="x_data_base" data-table="graficos" data-field="x_data_base" value="<?= $Page->data_base->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->data_base->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->data_base->formatPattern()) ?>"<?= $Page->data_base->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->data_base->getErrorMessage(false) ?></div>
<?php if (!$Page->data_base->ReadOnly && !$Page->data_base->Disabled && !isset($Page->data_base->EditAttrs["readonly"]) && !isset($Page->data_base->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fgraficossearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fgraficossearch", "x_data_base", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span></template>
<template id="tpx_graficos_valor" class="graficossearch"><span id="el_graficos_valor" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->valor->getInputTextType() ?>" name="x_valor" id="x_valor" data-table="graficos" data-field="x_valor" value="<?= $Page->valor->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->valor->formatPattern()) ?>"<?= $Page->valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->valor->getErrorMessage(false) ?></div>
</span></template>
<template id="tpx_graficos_obs" class="graficossearch"><span id="el_graficos_obs" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="graficos" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="25" maxlength="100" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage(false) ?></div>
</span></template>
<div id="graficos_query_builder" class="query-builder mb-3"></div>
<div class="btn-group mb-3 query-btn-group"></div>
<button type="button" id="btn-view-rules" class="btn btn-primary d-none disabled" title="<?= HtmlEncode($Language->phrase("View", true)) ?>"><i class="fa-solid fa-eye ew-icon"></i></button>
<button type="button" id="btn-clear-rules" class="btn btn-primary d-none disabled" title="<?= HtmlEncode($Language->phrase("Clear", true)) ?>"><i class="fa-solid fa-xmark ew-icon"></i></button>
<script>
// Filter builder
loadjs.ready(["wrapper", "head"], () => {
    let filters = [
            {
                id: "idgraficos",
                type: "integer",
                label: currentTable.fields.idgraficos.caption,
                operators: currentTable.fields.idgraficos.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                validation: ew.getQueryBuilderFilterValidation(fgraficossearch.fields.idgraficos.validators),
                data: {
                    format: currentTable.fields.idgraficos.clientFormatPattern
                }
            },
            {
                id: "competencia_idcompetencia",
                type: "integer",
                label: currentTable.fields.competencia_idcompetencia.caption,
                operators: currentTable.fields.competencia_idcompetencia.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                valueSetter: ew.getQueryBuilderValueSetter(),
                validation: ew.getQueryBuilderFilterValidation(fgraficossearch.fields.competencia_idcompetencia.validators),
                data: {
                    format: currentTable.fields.competencia_idcompetencia.clientFormatPattern
                }
            },
            {
                id: "indicadores_idindicadores",
                type: "integer",
                label: currentTable.fields.indicadores_idindicadores.caption,
                operators: currentTable.fields.indicadores_idindicadores.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                valueSetter: ew.getQueryBuilderValueSetter(),
                validation: ew.getQueryBuilderFilterValidation(fgraficossearch.fields.indicadores_idindicadores.validators),
                data: {
                    format: currentTable.fields.indicadores_idindicadores.clientFormatPattern
                }
            },
            {
                id: "data_base",
                type: "datetime",
                label: currentTable.fields.data_base.caption,
                operators: currentTable.fields.data_base.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                value_separator: ew.IN_OPERATOR_VALUE_SEPARATOR,
                validation: ew.getQueryBuilderFilterValidation(fgraficossearch.fields.data_base.validators),
                data: {
                    format: currentTable.fields.data_base.clientFormatPattern
                }
            },
            {
                id: "valor",
                type: "double",
                label: currentTable.fields.valor.caption,
                operators: currentTable.fields.valor.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                value_separator: ew.IN_OPERATOR_VALUE_SEPARATOR,
                validation: ew.getQueryBuilderFilterValidation(fgraficossearch.fields.valor.validators),
                data: {
                    format: currentTable.fields.valor.clientFormatPattern
                }
            },
            {
                id: "obs",
                type: "string",
                label: currentTable.fields.obs.caption,
                operators: currentTable.fields.obs.clientSearchOperators,
                default_operator: "contains",
                input: ew.getQueryBuilderFilterInput(),
                value_separator: ew.IN_OPERATOR_VALUE_SEPARATOR,
                validation: ew.getQueryBuilderFilterValidation(fgraficossearch.fields.obs.validators),
                data: {
                    format: currentTable.fields.obs.clientFormatPattern
                }
            },
        ],
        $ = jQuery,
        $qb = $("#graficos_query_builder"),
        args = {},
        rules = ew.parseJson($("#fgraficossearch input[name=rules]").val()),
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
    $("#fgraficossearch").on("beforesubmit", function () {
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
        <button class="btn btn-primary ew-btn d-none disabled" name="btn-action" id="btn-action" type="submit" form="fgraficossearch" formaction="<?= HtmlEncode(GetUrl("GraficosList")) ?>" data-ajax="<?= $Page->UseAjaxActions ? "true" : "false" ?>"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fgraficossearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn d-none disabled" name="btn-reset" id="btn-reset" type="button" form="fgraficossearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("graficos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
