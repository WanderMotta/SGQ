<?php

namespace PHPMaker2024\sgq;

// Page object
$ProcessoSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { processo: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fprocessosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fprocessosearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idprocesso", [ew.Validators.integer], fields.idprocesso.isInvalid],
            ["dt_cadastro", [ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["revisao", [], fields.revisao.isInvalid],
            ["tipo_idtipo", [], fields.tipo_idtipo.isInvalid],
            ["processo", [], fields.processo.isInvalid],
            ["responsaveis", [], fields.responsaveis.isInvalid],
            ["objetivo", [], fields.objetivo.isInvalid],
            ["proc_antes", [], fields.proc_antes.isInvalid],
            ["proc_depois", [], fields.proc_depois.isInvalid],
            ["eqpto_recursos", [], fields.eqpto_recursos.isInvalid],
            ["entradas", [], fields.entradas.isInvalid],
            ["atividade_principal", [], fields.atividade_principal.isInvalid],
            ["saidas_resultados", [], fields.saidas_resultados.isInvalid],
            ["requsito_saidas", [], fields.requsito_saidas.isInvalid],
            ["riscos", [], fields.riscos.isInvalid],
            ["oportunidades", [], fields.oportunidades.isInvalid],
            ["propriedade_externa", [], fields.propriedade_externa.isInvalid],
            ["conhecimentos", [], fields.conhecimentos.isInvalid],
            ["documentos_aplicados", [], fields.documentos_aplicados.isInvalid],
            ["proced_int_trabalho", [], fields.proced_int_trabalho.isInvalid],
            ["mapa", [], fields.mapa.isInvalid],
            ["formulario", [], fields.formulario.isInvalid]
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
            "tipo_idtipo": <?= $Page->tipo_idtipo->toClientList($Page) ?>,
            "responsaveis": <?= $Page->responsaveis->toClientList($Page) ?>,
            "proc_antes": <?= $Page->proc_antes->toClientList($Page) ?>,
            "proc_depois": <?= $Page->proc_depois->toClientList($Page) ?>,
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
<form name="fprocessosearch" id="fprocessosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="processo">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idprocesso->Visible) { // idprocesso ?>
    <div id="r_idprocesso" class="row"<?= $Page->idprocesso->rowAttributes() ?>>
        <label for="x_idprocesso" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_idprocesso"><?= $Page->idprocesso->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idprocesso" id="z_idprocesso" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idprocesso->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_idprocesso" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idprocesso->getInputTextType() ?>" name="x_idprocesso" id="x_idprocesso" data-table="processo" data-field="x_idprocesso" value="<?= $Page->idprocesso->EditValue ?>" placeholder="<?= HtmlEncode($Page->idprocesso->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idprocesso->formatPattern()) ?>"<?= $Page->idprocesso->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idprocesso->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro" class="row"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_cadastro" id="z_dt_cadastro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_cadastro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_dt_cadastro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="processo" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fprocessosearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fprocessosearch", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->revisao->Visible) { // revisao ?>
    <div id="r_revisao" class="row"<?= $Page->revisao->rowAttributes() ?>>
        <label for="x_revisao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_revisao"><?= $Page->revisao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_revisao" id="z_revisao" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->revisao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_revisao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->revisao->getInputTextType() ?>" name="x_revisao" id="x_revisao" data-table="processo" data-field="x_revisao" value="<?= $Page->revisao->EditValue ?>" size="5" maxlength="15" placeholder="<?= HtmlEncode($Page->revisao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->revisao->formatPattern()) ?>"<?= $Page->revisao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->revisao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->tipo_idtipo->Visible) { // tipo_idtipo ?>
    <div id="r_tipo_idtipo" class="row"<?= $Page->tipo_idtipo->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_tipo_idtipo"><?= $Page->tipo_idtipo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_tipo_idtipo" id="z_tipo_idtipo" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->tipo_idtipo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_tipo_idtipo" class="ew-search-field ew-search-field-single">
<template id="tp_x_tipo_idtipo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="processo" data-field="x_tipo_idtipo" name="x_tipo_idtipo" id="x_tipo_idtipo"<?= $Page->tipo_idtipo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tipo_idtipo" class="ew-item-list"></div>
<selection-list hidden
    id="x_tipo_idtipo"
    name="x_tipo_idtipo"
    value="<?= HtmlEncode($Page->tipo_idtipo->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_idtipo"
    data-target="dsl_x_tipo_idtipo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo_idtipo->isInvalidClass() ?>"
    data-table="processo"
    data-field="x_tipo_idtipo"
    data-value-separator="<?= $Page->tipo_idtipo->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_idtipo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->tipo_idtipo->getErrorMessage(false) ?></div>
<?= $Page->tipo_idtipo->Lookup->getParamTag($Page, "p_x_tipo_idtipo") ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->processo->Visible) { // processo ?>
    <div id="r_processo" class="row"<?= $Page->processo->rowAttributes() ?>>
        <label for="x_processo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_processo"><?= $Page->processo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_processo" id="z_processo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->processo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_processo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->processo->getInputTextType() ?>" name="x_processo" id="x_processo" data-table="processo" data-field="x_processo" value="<?= $Page->processo->EditValue ?>" size="35" maxlength="80" placeholder="<?= HtmlEncode($Page->processo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->processo->formatPattern()) ?>"<?= $Page->processo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->processo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->responsaveis->Visible) { // responsaveis ?>
    <div id="r_responsaveis" class="row"<?= $Page->responsaveis->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_responsaveis"><?= $Page->responsaveis->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_responsaveis" id="z_responsaveis" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->responsaveis->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_responsaveis" class="ew-search-field ew-search-field-single">
<template id="tp_x_responsaveis">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="processo" data-field="x_responsaveis" name="x_responsaveis" id="x_responsaveis"<?= $Page->responsaveis->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_responsaveis" class="ew-item-list"></div>
<selection-list hidden
    id="x_responsaveis[]"
    name="x_responsaveis[]"
    value="<?= HtmlEncode($Page->responsaveis->AdvancedSearch->SearchValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_responsaveis"
    data-target="dsl_x_responsaveis"
    data-repeatcolumn="6"
    class="form-control<?= $Page->responsaveis->isInvalidClass() ?>"
    data-table="processo"
    data-field="x_responsaveis"
    data-value-separator="<?= $Page->responsaveis->displayValueSeparatorAttribute() ?>"
    <?= $Page->responsaveis->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->responsaveis->getErrorMessage(false) ?></div>
<?= $Page->responsaveis->Lookup->getParamTag($Page, "p_x_responsaveis") ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->objetivo->Visible) { // objetivo ?>
    <div id="r_objetivo" class="row"<?= $Page->objetivo->rowAttributes() ?>>
        <label for="x_objetivo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_objetivo"><?= $Page->objetivo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_objetivo" id="z_objetivo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->objetivo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_objetivo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->objetivo->getInputTextType() ?>" name="x_objetivo" id="x_objetivo" data-table="processo" data-field="x_objetivo" value="<?= $Page->objetivo->EditValue ?>" size="50" maxlength="65535" placeholder="<?= HtmlEncode($Page->objetivo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->objetivo->formatPattern()) ?>"<?= $Page->objetivo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->objetivo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->proc_antes->Visible) { // proc_antes ?>
    <div id="r_proc_antes" class="row"<?= $Page->proc_antes->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_proc_antes"><?= $Page->proc_antes->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_proc_antes" id="z_proc_antes" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->proc_antes->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_proc_antes" class="ew-search-field ew-search-field-single">
<template id="tp_x_proc_antes">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="processo" data-field="x_proc_antes" name="x_proc_antes" id="x_proc_antes"<?= $Page->proc_antes->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_proc_antes" class="ew-item-list"></div>
<selection-list hidden
    id="x_proc_antes"
    name="x_proc_antes"
    value="<?= HtmlEncode($Page->proc_antes->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_proc_antes"
    data-target="dsl_x_proc_antes"
    data-repeatcolumn="5"
    class="form-control<?= $Page->proc_antes->isInvalidClass() ?>"
    data-table="processo"
    data-field="x_proc_antes"
    data-value-separator="<?= $Page->proc_antes->displayValueSeparatorAttribute() ?>"
    <?= $Page->proc_antes->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->proc_antes->getErrorMessage(false) ?></div>
<?= $Page->proc_antes->Lookup->getParamTag($Page, "p_x_proc_antes") ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->proc_depois->Visible) { // proc_depois ?>
    <div id="r_proc_depois" class="row"<?= $Page->proc_depois->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_proc_depois"><?= $Page->proc_depois->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_proc_depois" id="z_proc_depois" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->proc_depois->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_proc_depois" class="ew-search-field ew-search-field-single">
<template id="tp_x_proc_depois">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="processo" data-field="x_proc_depois" name="x_proc_depois" id="x_proc_depois"<?= $Page->proc_depois->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_proc_depois" class="ew-item-list"></div>
<selection-list hidden
    id="x_proc_depois"
    name="x_proc_depois"
    value="<?= HtmlEncode($Page->proc_depois->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_proc_depois"
    data-target="dsl_x_proc_depois"
    data-repeatcolumn="5"
    class="form-control<?= $Page->proc_depois->isInvalidClass() ?>"
    data-table="processo"
    data-field="x_proc_depois"
    data-value-separator="<?= $Page->proc_depois->displayValueSeparatorAttribute() ?>"
    <?= $Page->proc_depois->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->proc_depois->getErrorMessage(false) ?></div>
<?= $Page->proc_depois->Lookup->getParamTag($Page, "p_x_proc_depois") ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->eqpto_recursos->Visible) { // eqpto_recursos ?>
    <div id="r_eqpto_recursos" class="row"<?= $Page->eqpto_recursos->rowAttributes() ?>>
        <label for="x_eqpto_recursos" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_eqpto_recursos"><?= $Page->eqpto_recursos->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_eqpto_recursos" id="z_eqpto_recursos" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->eqpto_recursos->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_eqpto_recursos" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->eqpto_recursos->getInputTextType() ?>" name="x_eqpto_recursos" id="x_eqpto_recursos" data-table="processo" data-field="x_eqpto_recursos" value="<?= $Page->eqpto_recursos->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->eqpto_recursos->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->eqpto_recursos->formatPattern()) ?>"<?= $Page->eqpto_recursos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->eqpto_recursos->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->entradas->Visible) { // entradas ?>
    <div id="r_entradas" class="row"<?= $Page->entradas->rowAttributes() ?>>
        <label for="x_entradas" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_entradas"><?= $Page->entradas->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_entradas" id="z_entradas" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->entradas->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_entradas" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->entradas->getInputTextType() ?>" name="x_entradas" id="x_entradas" data-table="processo" data-field="x_entradas" value="<?= $Page->entradas->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->entradas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->entradas->formatPattern()) ?>"<?= $Page->entradas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->entradas->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->atividade_principal->Visible) { // atividade_principal ?>
    <div id="r_atividade_principal" class="row"<?= $Page->atividade_principal->rowAttributes() ?>>
        <label for="x_atividade_principal" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_atividade_principal"><?= $Page->atividade_principal->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_atividade_principal" id="z_atividade_principal" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->atividade_principal->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_atividade_principal" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->atividade_principal->getInputTextType() ?>" name="x_atividade_principal" id="x_atividade_principal" data-table="processo" data-field="x_atividade_principal" value="<?= $Page->atividade_principal->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->atividade_principal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->atividade_principal->formatPattern()) ?>"<?= $Page->atividade_principal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->atividade_principal->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->saidas_resultados->Visible) { // saidas_resultados ?>
    <div id="r_saidas_resultados" class="row"<?= $Page->saidas_resultados->rowAttributes() ?>>
        <label for="x_saidas_resultados" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_saidas_resultados"><?= $Page->saidas_resultados->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_saidas_resultados" id="z_saidas_resultados" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->saidas_resultados->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_saidas_resultados" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->saidas_resultados->getInputTextType() ?>" name="x_saidas_resultados" id="x_saidas_resultados" data-table="processo" data-field="x_saidas_resultados" value="<?= $Page->saidas_resultados->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->saidas_resultados->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->saidas_resultados->formatPattern()) ?>"<?= $Page->saidas_resultados->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->saidas_resultados->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->requsito_saidas->Visible) { // requsito_saidas ?>
    <div id="r_requsito_saidas" class="row"<?= $Page->requsito_saidas->rowAttributes() ?>>
        <label for="x_requsito_saidas" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_requsito_saidas"><?= $Page->requsito_saidas->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_requsito_saidas" id="z_requsito_saidas" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->requsito_saidas->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_requsito_saidas" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->requsito_saidas->getInputTextType() ?>" name="x_requsito_saidas" id="x_requsito_saidas" data-table="processo" data-field="x_requsito_saidas" value="<?= $Page->requsito_saidas->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->requsito_saidas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->requsito_saidas->formatPattern()) ?>"<?= $Page->requsito_saidas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->requsito_saidas->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->riscos->Visible) { // riscos ?>
    <div id="r_riscos" class="row"<?= $Page->riscos->rowAttributes() ?>>
        <label for="x_riscos" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_riscos"><?= $Page->riscos->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_riscos" id="z_riscos" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->riscos->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_riscos" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->riscos->getInputTextType() ?>" name="x_riscos" id="x_riscos" data-table="processo" data-field="x_riscos" value="<?= $Page->riscos->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->riscos->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->riscos->formatPattern()) ?>"<?= $Page->riscos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->riscos->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->oportunidades->Visible) { // oportunidades ?>
    <div id="r_oportunidades" class="row"<?= $Page->oportunidades->rowAttributes() ?>>
        <label for="x_oportunidades" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_oportunidades"><?= $Page->oportunidades->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_oportunidades" id="z_oportunidades" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->oportunidades->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_oportunidades" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->oportunidades->getInputTextType() ?>" name="x_oportunidades" id="x_oportunidades" data-table="processo" data-field="x_oportunidades" value="<?= $Page->oportunidades->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->oportunidades->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->oportunidades->formatPattern()) ?>"<?= $Page->oportunidades->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->oportunidades->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->propriedade_externa->Visible) { // propriedade_externa ?>
    <div id="r_propriedade_externa" class="row"<?= $Page->propriedade_externa->rowAttributes() ?>>
        <label for="x_propriedade_externa" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_propriedade_externa"><?= $Page->propriedade_externa->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_propriedade_externa" id="z_propriedade_externa" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->propriedade_externa->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_propriedade_externa" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->propriedade_externa->getInputTextType() ?>" name="x_propriedade_externa" id="x_propriedade_externa" data-table="processo" data-field="x_propriedade_externa" value="<?= $Page->propriedade_externa->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->propriedade_externa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->propriedade_externa->formatPattern()) ?>"<?= $Page->propriedade_externa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->propriedade_externa->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->conhecimentos->Visible) { // conhecimentos ?>
    <div id="r_conhecimentos" class="row"<?= $Page->conhecimentos->rowAttributes() ?>>
        <label for="x_conhecimentos" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_conhecimentos"><?= $Page->conhecimentos->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_conhecimentos" id="z_conhecimentos" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->conhecimentos->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_conhecimentos" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->conhecimentos->getInputTextType() ?>" name="x_conhecimentos" id="x_conhecimentos" data-table="processo" data-field="x_conhecimentos" value="<?= $Page->conhecimentos->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->conhecimentos->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->conhecimentos->formatPattern()) ?>"<?= $Page->conhecimentos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->conhecimentos->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->documentos_aplicados->Visible) { // documentos_aplicados ?>
    <div id="r_documentos_aplicados" class="row"<?= $Page->documentos_aplicados->rowAttributes() ?>>
        <label for="x_documentos_aplicados" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_documentos_aplicados"><?= $Page->documentos_aplicados->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_documentos_aplicados" id="z_documentos_aplicados" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->documentos_aplicados->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_documentos_aplicados" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->documentos_aplicados->getInputTextType() ?>" name="x_documentos_aplicados" id="x_documentos_aplicados" data-table="processo" data-field="x_documentos_aplicados" value="<?= $Page->documentos_aplicados->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->documentos_aplicados->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->documentos_aplicados->formatPattern()) ?>"<?= $Page->documentos_aplicados->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->documentos_aplicados->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->proced_int_trabalho->Visible) { // proced_int_trabalho ?>
    <div id="r_proced_int_trabalho" class="row"<?= $Page->proced_int_trabalho->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_proced_int_trabalho"><?= $Page->proced_int_trabalho->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_proced_int_trabalho" id="z_proced_int_trabalho" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->proced_int_trabalho->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_proced_int_trabalho" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->proced_int_trabalho->getInputTextType() ?>" name="x_proced_int_trabalho" id="x_proced_int_trabalho" data-table="processo" data-field="x_proced_int_trabalho" value="<?= $Page->proced_int_trabalho->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->proced_int_trabalho->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->proced_int_trabalho->formatPattern()) ?>"<?= $Page->proced_int_trabalho->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->proced_int_trabalho->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->mapa->Visible) { // mapa ?>
    <div id="r_mapa" class="row"<?= $Page->mapa->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_mapa"><?= $Page->mapa->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_mapa" id="z_mapa" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->mapa->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_mapa" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->mapa->getInputTextType() ?>" name="x_mapa" id="x_mapa" data-table="processo" data-field="x_mapa" value="<?= $Page->mapa->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->mapa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->mapa->formatPattern()) ?>"<?= $Page->mapa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->mapa->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->formulario->Visible) { // formulario ?>
    <div id="r_formulario" class="row"<?= $Page->formulario->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_formulario"><?= $Page->formulario->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_formulario" id="z_formulario" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->formulario->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_formulario" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->formulario->getInputTextType() ?>" name="x_formulario" id="x_formulario" data-table="processo" data-field="x_formulario" value="<?= $Page->formulario->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->formulario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->formulario->formatPattern()) ?>"<?= $Page->formulario->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->formulario->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fprocessosearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fprocessosearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fprocessosearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("processo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
