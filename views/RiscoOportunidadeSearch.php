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
        .setLists({
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
<form name="frisco_oportunidadesearch" id="frisco_oportunidadesearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="risco_oportunidade">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idrisco_oportunidade->Visible) { // idrisco_oportunidade ?>
    <div id="r_idrisco_oportunidade" class="row"<?= $Page->idrisco_oportunidade->rowAttributes() ?>>
        <label for="x_idrisco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_idrisco_oportunidade"><?= $Page->idrisco_oportunidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idrisco_oportunidade" id="z_idrisco_oportunidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idrisco_oportunidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_risco_oportunidade_idrisco_oportunidade" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idrisco_oportunidade->getInputTextType() ?>" name="x_idrisco_oportunidade" id="x_idrisco_oportunidade" data-table="risco_oportunidade" data-field="x_idrisco_oportunidade" value="<?= $Page->idrisco_oportunidade->EditValue ?>" placeholder="<?= HtmlEncode($Page->idrisco_oportunidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idrisco_oportunidade->formatPattern()) ?>"<?= $Page->idrisco_oportunidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idrisco_oportunidade->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro" class="row"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_cadastro" id="z_dt_cadastro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_cadastro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_risco_oportunidade_dt_cadastro" class="ew-search-field ew-search-field-single">
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
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
    <div id="r_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="row"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_tipo_risco_oportunidade_idtipo_risco_oportunidade" id="z_tipo_risco_oportunidade_idtipo_risco_oportunidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="ew-search-field ew-search-field-single">
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
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <div id="r_titulo" class="row"<?= $Page->titulo->rowAttributes() ?>>
        <label for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_titulo"><?= $Page->titulo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_titulo" id="z_titulo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->titulo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_risco_oportunidade_titulo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->titulo->getInputTextType() ?>" name="x_titulo" id="x_titulo" data-table="risco_oportunidade" data-field="x_titulo" value="<?= $Page->titulo->EditValue ?>" size="45" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo->formatPattern()) ?>"<?= $Page->titulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <div id="r_origem_risco_oportunidade_idorigem_risco_oportunidade" class="row"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
        <label for="x_origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_origem_risco_oportunidade_idorigem_risco_oportunidade" id="z_origem_risco_oportunidade_idorigem_risco_oportunidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade" class="ew-search-field ew-search-field-single">
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
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
    <div id="r_descricao" class="row"<?= $Page->descricao->rowAttributes() ?>>
        <label for="x_descricao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_descricao"><?= $Page->descricao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_descricao" id="z_descricao" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->descricao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_risco_oportunidade_descricao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->descricao->getInputTextType() ?>" name="x_descricao" id="x_descricao" data-table="risco_oportunidade" data-field="x_descricao" value="<?= $Page->descricao->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->descricao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descricao->formatPattern()) ?>"<?= $Page->descricao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->descricao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->consequencia->Visible) { // consequencia ?>
    <div id="r_consequencia" class="row"<?= $Page->consequencia->rowAttributes() ?>>
        <label for="x_consequencia" class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_consequencia"><?= $Page->consequencia->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_consequencia" id="z_consequencia" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->consequencia->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_risco_oportunidade_consequencia" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->consequencia->getInputTextType() ?>" name="x_consequencia" id="x_consequencia" data-table="risco_oportunidade" data-field="x_consequencia" value="<?= $Page->consequencia->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->consequencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->consequencia->formatPattern()) ?>"<?= $Page->consequencia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->consequencia->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->frequencia_idfrequencia->Visible) { // frequencia_idfrequencia ?>
    <div id="r_frequencia_idfrequencia" class="row"<?= $Page->frequencia_idfrequencia->rowAttributes() ?>>
        <label for="x_frequencia_idfrequencia" class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_frequencia_idfrequencia"><?= $Page->frequencia_idfrequencia->caption() ?></span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->frequencia_idfrequencia->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                    <span class="ew-search-operator">
<select name="z_frequencia_idfrequencia" id="z_frequencia_idfrequencia" class="form-select ew-operator-select" data-ew-action="search-operator">
<?php foreach ($Page->frequencia_idfrequencia->SearchOperators as $opr) { ?>
<option value="<?= HtmlEncode($opr) ?>"<?= $Page->frequencia_idfrequencia->AdvancedSearch->SearchOperator == $opr ? " selected" : "" ?>><?= $Language->phrase($opr == "=" ? "EQUAL" : $opr) ?></option>
<?php } ?>
</select>
</span>
                <span id="el_risco_oportunidade_frequencia_idfrequencia" class="ew-search-field">
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
</span>
                    <span class="ew-search-and d-none"><label><?= $Language->phrase("AND") ?></label></span>
                    <span id="el2_risco_oportunidade_frequencia_idfrequencia" class="ew-search-field2 d-none">
    <select
        id="y_frequencia_idfrequencia"
        name="y_frequencia_idfrequencia"
        class="form-select ew-select<?= $Page->frequencia_idfrequencia->isInvalidClass() ?>"
        <?php if (!$Page->frequencia_idfrequencia->IsNativeSelect) { ?>
        data-select2-id="frisco_oportunidadesearch_y_frequencia_idfrequencia"
        <?php } ?>
        data-table="risco_oportunidade"
        data-field="x_frequencia_idfrequencia"
        data-value-separator="<?= $Page->frequencia_idfrequencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->frequencia_idfrequencia->getPlaceHolder()) ?>"
        <?= $Page->frequencia_idfrequencia->editAttributes() ?>>
        <?= $Page->frequencia_idfrequencia->selectOptionListHtml("y_frequencia_idfrequencia") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->frequencia_idfrequencia->getErrorMessage(false) ?></div>
<?= $Page->frequencia_idfrequencia->Lookup->getParamTag($Page, "p_y_frequencia_idfrequencia") ?>
<?php if (!$Page->frequencia_idfrequencia->IsNativeSelect) { ?>
<script>
loadjs.ready("frisco_oportunidadesearch", function() {
    var options = { name: "y_frequencia_idfrequencia", selectId: "frisco_oportunidadesearch_y_frequencia_idfrequencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frisco_oportunidadesearch.lists.frequencia_idfrequencia?.lookupOptions.length) {
        options.data = { id: "y_frequencia_idfrequencia", form: "frisco_oportunidadesearch" };
    } else {
        options.ajax = { id: "y_frequencia_idfrequencia", form: "frisco_oportunidadesearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.risco_oportunidade.fields.frequencia_idfrequencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
    <div id="r_impacto_idimpacto" class="row"<?= $Page->impacto_idimpacto->rowAttributes() ?>>
        <label for="x_impacto_idimpacto" class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_impacto_idimpacto"><?= $Page->impacto_idimpacto->caption() ?></span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->impacto_idimpacto->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                    <span class="ew-search-operator">
<select name="z_impacto_idimpacto" id="z_impacto_idimpacto" class="form-select ew-operator-select" data-ew-action="search-operator">
<?php foreach ($Page->impacto_idimpacto->SearchOperators as $opr) { ?>
<option value="<?= HtmlEncode($opr) ?>"<?= $Page->impacto_idimpacto->AdvancedSearch->SearchOperator == $opr ? " selected" : "" ?>><?= $Language->phrase($opr == "=" ? "EQUAL" : $opr) ?></option>
<?php } ?>
</select>
</span>
                <span id="el_risco_oportunidade_impacto_idimpacto" class="ew-search-field">
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
</span>
                    <span class="ew-search-and d-none"><label><?= $Language->phrase("AND") ?></label></span>
                    <span id="el2_risco_oportunidade_impacto_idimpacto" class="ew-search-field2 d-none">
    <select
        id="y_impacto_idimpacto"
        name="y_impacto_idimpacto"
        class="form-select ew-select<?= $Page->impacto_idimpacto->isInvalidClass() ?>"
        <?php if (!$Page->impacto_idimpacto->IsNativeSelect) { ?>
        data-select2-id="frisco_oportunidadesearch_y_impacto_idimpacto"
        <?php } ?>
        data-table="risco_oportunidade"
        data-field="x_impacto_idimpacto"
        data-value-separator="<?= $Page->impacto_idimpacto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->impacto_idimpacto->getPlaceHolder()) ?>"
        <?= $Page->impacto_idimpacto->editAttributes() ?>>
        <?= $Page->impacto_idimpacto->selectOptionListHtml("y_impacto_idimpacto") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->impacto_idimpacto->getErrorMessage(false) ?></div>
<?= $Page->impacto_idimpacto->Lookup->getParamTag($Page, "p_y_impacto_idimpacto") ?>
<?php if (!$Page->impacto_idimpacto->IsNativeSelect) { ?>
<script>
loadjs.ready("frisco_oportunidadesearch", function() {
    var options = { name: "y_impacto_idimpacto", selectId: "frisco_oportunidadesearch_y_impacto_idimpacto" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frisco_oportunidadesearch.lists.impacto_idimpacto?.lookupOptions.length) {
        options.data = { id: "y_impacto_idimpacto", form: "frisco_oportunidadesearch" };
    } else {
        options.ajax = { id: "y_impacto_idimpacto", form: "frisco_oportunidadesearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.risco_oportunidade.fields.impacto_idimpacto.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->grau_atencao->Visible) { // grau_atencao ?>
    <div id="r_grau_atencao" class="row"<?= $Page->grau_atencao->rowAttributes() ?>>
        <label for="x_grau_atencao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_grau_atencao"><?= $Page->grau_atencao->caption() ?></span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->grau_atencao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                    <span class="ew-search-operator">
<select name="z_grau_atencao" id="z_grau_atencao" class="form-select ew-operator-select" data-ew-action="search-operator">
<?php foreach ($Page->grau_atencao->SearchOperators as $opr) { ?>
<option value="<?= HtmlEncode($opr) ?>"<?= $Page->grau_atencao->AdvancedSearch->SearchOperator == $opr ? " selected" : "" ?>><?= $Language->phrase($opr == "=" ? "EQUAL" : $opr) ?></option>
<?php } ?>
</select>
</span>
                <span id="el_risco_oportunidade_grau_atencao" class="ew-search-field">
<input type="<?= $Page->grau_atencao->getInputTextType() ?>" name="x_grau_atencao" id="x_grau_atencao" data-table="risco_oportunidade" data-field="x_grau_atencao" value="<?= $Page->grau_atencao->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->grau_atencao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->grau_atencao->formatPattern()) ?>"<?= $Page->grau_atencao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->grau_atencao->getErrorMessage(false) ?></div>
</span>
                    <span class="ew-search-and d-none"><label><?= $Language->phrase("AND") ?></label></span>
                    <span id="el2_risco_oportunidade_grau_atencao" class="ew-search-field2 d-none">
<input type="<?= $Page->grau_atencao->getInputTextType() ?>" name="y_grau_atencao" id="y_grau_atencao" data-table="risco_oportunidade" data-field="x_grau_atencao" value="<?= $Page->grau_atencao->EditValue2 ?>" size="30" placeholder="<?= HtmlEncode($Page->grau_atencao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->grau_atencao->formatPattern()) ?>"<?= $Page->grau_atencao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->grau_atencao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->acao_risco_oportunidade_idacao_risco_oportunidade->Visible) { // acao_risco_oportunidade_idacao_risco_oportunidade ?>
    <div id="r_acao_risco_oportunidade_idacao_risco_oportunidade" class="row"<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->rowAttributes() ?>>
        <label for="x_acao_risco_oportunidade_idacao_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade"><?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_acao_risco_oportunidade_idacao_risco_oportunidade" id="z_acao_risco_oportunidade_idacao_risco_oportunidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade" class="ew-search-field ew-search-field-single">
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
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { // plano_acao ?>
    <div id="r_plano_acao" class="row"<?= $Page->plano_acao->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_risco_oportunidade_plano_acao"><?= $Page->plano_acao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_plano_acao" id="z_plano_acao" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->plano_acao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_risco_oportunidade_plano_acao" class="ew-search-field ew-search-field-single">
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
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="frisco_oportunidadesearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="frisco_oportunidadesearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="frisco_oportunidadesearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
