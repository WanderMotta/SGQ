<?php

namespace PHPMaker2024\sgq;

// Page object
$RiscoOportunidadeSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { risco_oportunidade: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var frisco_oportunidadesearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frisco_oportunidadesearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idrisco_oportunidade", [ew.Validators.integer], fields.idrisco_oportunidade.isInvalid],
            ["dt_cadastro", [ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["tipo_risco_oportunidade_idtipo_risco_oportunidade", [], fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.isInvalid],
            ["titulo", [], fields.titulo.isInvalid],
            ["origem_risco_oportunidade_idorigem_risco_oportunidade", [], fields.origem_risco_oportunidade_idorigem_risco_oportunidade.isInvalid],
            ["descricao", [], fields.descricao.isInvalid],
            ["consequencia", [], fields.consequencia.isInvalid],
            ["frequencia_idfrequencia", [], fields.frequencia_idfrequencia.isInvalid],
            ["y_frequencia_idfrequencia", [ew.Validators.between], false],
            ["impacto_idimpacto", [], fields.impacto_idimpacto.isInvalid],
            ["y_impacto_idimpacto", [ew.Validators.between], false],
            ["grau_atencao", [ew.Validators.integer], fields.grau_atencao.isInvalid],
            ["y_grau_atencao", [ew.Validators.between], false],
            ["acao_risco_oportunidade_idacao_risco_oportunidade", [], fields.acao_risco_oportunidade_idacao_risco_oportunidade.isInvalid],
            ["plano_acao", [], fields.plano_acao.isInvalid]
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
            "tipo_risco_oportunidade_idtipo_risco_oportunidade": <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->toClientList($Page) ?>,
            "origem_risco_oportunidade_idorigem_risco_oportunidade": <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->toClientList($Page) ?>,
            "frequencia_idfrequencia": <?= $Page->frequencia_idfrequencia->toClientList($Page) ?>,
            "impacto_idimpacto": <?= $Page->impacto_idimpacto->toClientList($Page) ?>,
            "acao_risco_oportunidade_idacao_risco_oportunidade": <?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->toClientList($Page) ?>,
            "plano_acao": <?= $Page->plano_acao->toClientList($Page) ?>,
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
<form name="frisco_oportunidadesearch" id="frisco_oportunidadesearch" class="<?= $Page->FormClassName ?>" action="<?= HtmlEncode(GetUrl("RiscoOportunidadeList")) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="risco_oportunidade">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<input type="hidden" name="rules" value="<?= HtmlEncode($Page->getSessionRules()) ?>">
<template id="tpx_risco_oportunidade_idrisco_oportunidade" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_idrisco_oportunidade" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idrisco_oportunidade->getInputTextType() ?>" name="x_idrisco_oportunidade" id="x_idrisco_oportunidade" data-table="risco_oportunidade" data-field="x_idrisco_oportunidade" value="<?= $Page->idrisco_oportunidade->EditValue ?>" placeholder="<?= HtmlEncode($Page->idrisco_oportunidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idrisco_oportunidade->formatPattern()) ?>"<?= $Page->idrisco_oportunidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idrisco_oportunidade->getErrorMessage(false) ?></div>
</span></template>
<template id="tpx_risco_oportunidade_dt_cadastro" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_dt_cadastro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="risco_oportunidade" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frisco_oportunidadesearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frisco_oportunidadesearch", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span></template>
<template id="tpx_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="ew-search-field ew-search-field-single">
<template id="tp_x_tipo_risco_oportunidade_idtipo_risco_oportunidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="risco_oportunidade" data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" name="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" id="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>>
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
    data-table="risco_oportunidade"
    data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-value-separator="<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->displayValueSeparatorAttribute() ?>"
    data-ew-action="update-options"
    <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getErrorMessage(false) ?></div>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getParamTag($Page, "p_x_tipo_risco_oportunidade_idtipo_risco_oportunidade") ?>
</span></template>
<template id="tpx_risco_oportunidade_titulo" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_titulo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->titulo->getInputTextType() ?>" name="x_titulo" id="x_titulo" data-table="risco_oportunidade" data-field="x_titulo" value="<?= $Page->titulo->EditValue ?>" size="45" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo->formatPattern()) ?>"<?= $Page->titulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage(false) ?></div>
</span></template>
<template id="tpx_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade" class="ew-search-field ew-search-field-single">
    <select
        id="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        name="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        class="form-select ew-select<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Page->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="frisco_oportunidadesearch_x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        <?php } ?>
        data-table="risco_oportunidade"
        data-field="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        data-value-separator="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getPlaceHolder()) ?>"
        <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->editAttributes() ?>>
        <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->selectOptionListHtml("x_origem_risco_oportunidade_idorigem_risco_oportunidade") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getErrorMessage(false) ?></div>
<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getParamTag($Page, "p_x_origem_risco_oportunidade_idorigem_risco_oportunidade") ?>
<?php if (!$Page->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
<script>
loadjs.ready("frisco_oportunidadesearch", function() {
    var options = { name: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", selectId: "frisco_oportunidadesearch_x_origem_risco_oportunidade_idorigem_risco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frisco_oportunidadesearch.lists.origem_risco_oportunidade_idorigem_risco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "frisco_oportunidadesearch" };
    } else {
        options.ajax = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "frisco_oportunidadesearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.risco_oportunidade.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span></template>
<template id="tpx_risco_oportunidade_descricao" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_descricao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->descricao->getInputTextType() ?>" name="x_descricao" id="x_descricao" data-table="risco_oportunidade" data-field="x_descricao" value="<?= $Page->descricao->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->descricao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descricao->formatPattern()) ?>"<?= $Page->descricao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->descricao->getErrorMessage(false) ?></div>
</span></template>
<template id="tpx_risco_oportunidade_consequencia" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_consequencia" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->consequencia->getInputTextType() ?>" name="x_consequencia" id="x_consequencia" data-table="risco_oportunidade" data-field="x_consequencia" value="<?= $Page->consequencia->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->consequencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->consequencia->formatPattern()) ?>"<?= $Page->consequencia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->consequencia->getErrorMessage(false) ?></div>
</span></template>
<template id="tpx_risco_oportunidade_frequencia_idfrequencia" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_frequencia_idfrequencia" class="ew-search-field ew-search-field-single">
    <select
        id="x_frequencia_idfrequencia"
        name="x_frequencia_idfrequencia"
        class="form-select ew-select<?= $Page->frequencia_idfrequencia->isInvalidClass() ?>"
        <?php if (!$Page->frequencia_idfrequencia->IsNativeSelect) { ?>
        data-select2-id="frisco_oportunidadesearch_x_frequencia_idfrequencia"
        <?php } ?>
        data-table="risco_oportunidade"
        data-field="x_frequencia_idfrequencia"
        data-value-separator="<?= $Page->frequencia_idfrequencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->frequencia_idfrequencia->getPlaceHolder()) ?>"
        <?= $Page->frequencia_idfrequencia->editAttributes() ?>>
        <?= $Page->frequencia_idfrequencia->selectOptionListHtml("x_frequencia_idfrequencia") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->frequencia_idfrequencia->getErrorMessage(false) ?></div>
<?= $Page->frequencia_idfrequencia->Lookup->getParamTag($Page, "p_x_frequencia_idfrequencia") ?>
<?php if (!$Page->frequencia_idfrequencia->IsNativeSelect) { ?>
<script>
loadjs.ready("frisco_oportunidadesearch", function() {
    var options = { name: "x_frequencia_idfrequencia", selectId: "frisco_oportunidadesearch_x_frequencia_idfrequencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frisco_oportunidadesearch.lists.frequencia_idfrequencia?.lookupOptions.length) {
        options.data = { id: "x_frequencia_idfrequencia", form: "frisco_oportunidadesearch" };
    } else {
        options.ajax = { id: "x_frequencia_idfrequencia", form: "frisco_oportunidadesearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.risco_oportunidade.fields.frequencia_idfrequencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span></template>
<template id="tpx_risco_oportunidade_impacto_idimpacto" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_impacto_idimpacto" class="ew-search-field ew-search-field-single">
    <select
        id="x_impacto_idimpacto"
        name="x_impacto_idimpacto"
        class="form-select ew-select<?= $Page->impacto_idimpacto->isInvalidClass() ?>"
        <?php if (!$Page->impacto_idimpacto->IsNativeSelect) { ?>
        data-select2-id="frisco_oportunidadesearch_x_impacto_idimpacto"
        <?php } ?>
        data-table="risco_oportunidade"
        data-field="x_impacto_idimpacto"
        data-value-separator="<?= $Page->impacto_idimpacto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->impacto_idimpacto->getPlaceHolder()) ?>"
        <?= $Page->impacto_idimpacto->editAttributes() ?>>
        <?= $Page->impacto_idimpacto->selectOptionListHtml("x_impacto_idimpacto") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->impacto_idimpacto->getErrorMessage(false) ?></div>
<?= $Page->impacto_idimpacto->Lookup->getParamTag($Page, "p_x_impacto_idimpacto") ?>
<?php if (!$Page->impacto_idimpacto->IsNativeSelect) { ?>
<script>
loadjs.ready("frisco_oportunidadesearch", function() {
    var options = { name: "x_impacto_idimpacto", selectId: "frisco_oportunidadesearch_x_impacto_idimpacto" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frisco_oportunidadesearch.lists.impacto_idimpacto?.lookupOptions.length) {
        options.data = { id: "x_impacto_idimpacto", form: "frisco_oportunidadesearch" };
    } else {
        options.ajax = { id: "x_impacto_idimpacto", form: "frisco_oportunidadesearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.risco_oportunidade.fields.impacto_idimpacto.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span></template>
<template id="tpx_risco_oportunidade_grau_atencao" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_grau_atencao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->grau_atencao->getInputTextType() ?>" name="x_grau_atencao" id="x_grau_atencao" data-table="risco_oportunidade" data-field="x_grau_atencao" value="<?= $Page->grau_atencao->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->grau_atencao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->grau_atencao->formatPattern()) ?>"<?= $Page->grau_atencao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->grau_atencao->getErrorMessage(false) ?></div>
</span></template>
<template id="tpx_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade" class="ew-search-field ew-search-field-single">
    <select
        id="x_acao_risco_oportunidade_idacao_risco_oportunidade"
        name="x_acao_risco_oportunidade_idacao_risco_oportunidade"
        class="form-select ew-select<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Page->acao_risco_oportunidade_idacao_risco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="frisco_oportunidadesearch_x_acao_risco_oportunidade_idacao_risco_oportunidade"
        <?php } ?>
        data-table="risco_oportunidade"
        data-field="x_acao_risco_oportunidade_idacao_risco_oportunidade"
        data-value-separator="<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->acao_risco_oportunidade_idacao_risco_oportunidade->getPlaceHolder()) ?>"
        <?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->editAttributes() ?>>
        <?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->selectOptionListHtml("x_acao_risco_oportunidade_idacao_risco_oportunidade") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->getErrorMessage(false) ?></div>
<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getParamTag($Page, "p_x_acao_risco_oportunidade_idacao_risco_oportunidade") ?>
<?php if (!$Page->acao_risco_oportunidade_idacao_risco_oportunidade->IsNativeSelect) { ?>
<script>
loadjs.ready("frisco_oportunidadesearch", function() {
    var options = { name: "x_acao_risco_oportunidade_idacao_risco_oportunidade", selectId: "frisco_oportunidadesearch_x_acao_risco_oportunidade_idacao_risco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frisco_oportunidadesearch.lists.acao_risco_oportunidade_idacao_risco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x_acao_risco_oportunidade_idacao_risco_oportunidade", form: "frisco_oportunidadesearch" };
    } else {
        options.ajax = { id: "x_acao_risco_oportunidade_idacao_risco_oportunidade", form: "frisco_oportunidadesearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.risco_oportunidade.fields.acao_risco_oportunidade_idacao_risco_oportunidade.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span></template>
<template id="tpx_risco_oportunidade_plano_acao" class="risco_oportunidadesearch"><span id="el_risco_oportunidade_plano_acao" class="ew-search-field ew-search-field-single">
<template id="tp_x_plano_acao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="risco_oportunidade" data-field="x_plano_acao" name="x_plano_acao" id="x_plano_acao"<?= $Page->plano_acao->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_plano_acao" class="ew-item-list"></div>
<selection-list hidden
    id="x_plano_acao"
    name="x_plano_acao"
    value="<?= HtmlEncode($Page->plano_acao->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_plano_acao"
    data-target="dsl_x_plano_acao"
    data-repeatcolumn="5"
    class="form-control<?= $Page->plano_acao->isInvalidClass() ?>"
    data-table="risco_oportunidade"
    data-field="x_plano_acao"
    data-value-separator="<?= $Page->plano_acao->displayValueSeparatorAttribute() ?>"
    <?= $Page->plano_acao->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->plano_acao->getErrorMessage(false) ?></div>
</span></template>
<div id="risco_oportunidade_query_builder" class="query-builder mb-3"></div>
<div class="btn-group mb-3 query-btn-group"></div>
<button type="button" id="btn-view-rules" class="btn btn-primary d-none disabled" title="<?= HtmlEncode($Language->phrase("View", true)) ?>"><i class="fa-solid fa-eye ew-icon"></i></button>
<button type="button" id="btn-clear-rules" class="btn btn-primary d-none disabled" title="<?= HtmlEncode($Language->phrase("Clear", true)) ?>"><i class="fa-solid fa-xmark ew-icon"></i></button>
<script>
// Filter builder
loadjs.ready(["wrapper", "head"], () => {
    let filters = [
            {
                id: "idrisco_oportunidade",
                type: "integer",
                label: currentTable.fields.idrisco_oportunidade.caption,
                operators: currentTable.fields.idrisco_oportunidade.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.idrisco_oportunidade.validators),
                data: {
                    format: currentTable.fields.idrisco_oportunidade.clientFormatPattern
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
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.dt_cadastro.validators),
                data: {
                    format: currentTable.fields.dt_cadastro.clientFormatPattern
                }
            },
            {
                id: "tipo_risco_oportunidade_idtipo_risco_oportunidade",
                type: "integer",
                label: currentTable.fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.caption,
                operators: currentTable.fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                valueSetter: ew.getQueryBuilderValueSetter(),
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.validators),
                data: {
                    format: currentTable.fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.clientFormatPattern
                }
            },
            {
                id: "titulo",
                type: "string",
                label: currentTable.fields.titulo.caption,
                operators: currentTable.fields.titulo.clientSearchOperators,
                input: ew.getQueryBuilderFilterInput(),
                value_separator: ew.IN_OPERATOR_VALUE_SEPARATOR,
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.titulo.validators),
                data: {
                    format: currentTable.fields.titulo.clientFormatPattern
                }
            },
            {
                id: "origem_risco_oportunidade_idorigem_risco_oportunidade",
                type: "integer",
                label: currentTable.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.caption,
                operators: currentTable.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                valueSetter: ew.getQueryBuilderValueSetter(),
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.validators),
                data: {
                    format: currentTable.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.clientFormatPattern
                }
            },
            {
                id: "descricao",
                type: "string",
                label: currentTable.fields.descricao.caption,
                operators: currentTable.fields.descricao.clientSearchOperators,
                input: ew.getQueryBuilderFilterInput(),
                value_separator: ew.IN_OPERATOR_VALUE_SEPARATOR,
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.descricao.validators),
                data: {
                    format: currentTable.fields.descricao.clientFormatPattern
                }
            },
            {
                id: "consequencia",
                type: "string",
                label: currentTable.fields.consequencia.caption,
                operators: currentTable.fields.consequencia.clientSearchOperators,
                input: ew.getQueryBuilderFilterInput(),
                value_separator: ew.IN_OPERATOR_VALUE_SEPARATOR,
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.consequencia.validators),
                data: {
                    format: currentTable.fields.consequencia.clientFormatPattern
                }
            },
            {
                id: "frequencia_idfrequencia",
                type: "integer",
                label: currentTable.fields.frequencia_idfrequencia.caption,
                operators: currentTable.fields.frequencia_idfrequencia.clientSearchOperators,
                input: ew.getQueryBuilderFilterInput(),
                valueSetter: ew.getQueryBuilderValueSetter(),
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.frequencia_idfrequencia.validators),
                data: {
                    format: currentTable.fields.frequencia_idfrequencia.clientFormatPattern
                }
            },
            {
                id: "impacto_idimpacto",
                type: "integer",
                label: currentTable.fields.impacto_idimpacto.caption,
                operators: currentTable.fields.impacto_idimpacto.clientSearchOperators,
                input: ew.getQueryBuilderFilterInput(),
                valueSetter: ew.getQueryBuilderValueSetter(),
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.impacto_idimpacto.validators),
                data: {
                    format: currentTable.fields.impacto_idimpacto.clientFormatPattern
                }
            },
            {
                id: "grau_atencao",
                type: "integer",
                label: currentTable.fields.grau_atencao.caption,
                operators: currentTable.fields.grau_atencao.clientSearchOperators,
                input: ew.getQueryBuilderFilterInput(),
                value_separator: ew.IN_OPERATOR_VALUE_SEPARATOR,
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.grau_atencao.validators),
                data: {
                    format: currentTable.fields.grau_atencao.clientFormatPattern
                }
            },
            {
                id: "acao_risco_oportunidade_idacao_risco_oportunidade",
                type: "integer",
                label: currentTable.fields.acao_risco_oportunidade_idacao_risco_oportunidade.caption,
                operators: currentTable.fields.acao_risco_oportunidade_idacao_risco_oportunidade.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                valueSetter: ew.getQueryBuilderValueSetter(),
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.acao_risco_oportunidade_idacao_risco_oportunidade.validators),
                data: {
                    format: currentTable.fields.acao_risco_oportunidade_idacao_risco_oportunidade.clientFormatPattern
                }
            },
            {
                id: "plano_acao",
                type: "string",
                label: currentTable.fields.plano_acao.caption,
                operators: currentTable.fields.plano_acao.clientSearchOperators,
                default_operator: "equal",
                input: ew.getQueryBuilderFilterInput(),
                valueSetter: ew.getQueryBuilderValueSetter(),
                validation: ew.getQueryBuilderFilterValidation(frisco_oportunidadesearch.fields.plano_acao.validators),
                data: {
                    format: currentTable.fields.plano_acao.clientFormatPattern
                }
            },
        ],
        $ = jQuery,
        $qb = $("#risco_oportunidade_query_builder"),
        args = {},
        rules = ew.parseJson($("#frisco_oportunidadesearch input[name=rules]").val()),
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
    $("#frisco_oportunidadesearch").on("beforesubmit", function () {
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
        <button class="btn btn-primary ew-btn d-none disabled" name="btn-action" id="btn-action" type="submit" form="frisco_oportunidadesearch" formaction="<?= HtmlEncode(GetUrl("RiscoOportunidadeList")) ?>" data-ajax="<?= $Page->UseAjaxActions ? "true" : "false" ?>"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="frisco_oportunidadesearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn d-none disabled" name="btn-reset" id="btn-reset" type="button" form="frisco_oportunidadesearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("risco_oportunidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
