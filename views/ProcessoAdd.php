<?php

namespace PHPMaker2024\sgq;

// Page object
$ProcessoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { processo: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fprocessoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fprocessoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null, ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["revisao", [fields.revisao.visible && fields.revisao.required ? ew.Validators.required(fields.revisao.caption) : null], fields.revisao.isInvalid],
            ["tipo_idtipo", [fields.tipo_idtipo.visible && fields.tipo_idtipo.required ? ew.Validators.required(fields.tipo_idtipo.caption) : null], fields.tipo_idtipo.isInvalid],
            ["processo", [fields.processo.visible && fields.processo.required ? ew.Validators.required(fields.processo.caption) : null], fields.processo.isInvalid],
            ["responsaveis", [fields.responsaveis.visible && fields.responsaveis.required ? ew.Validators.required(fields.responsaveis.caption) : null], fields.responsaveis.isInvalid],
            ["objetivo", [fields.objetivo.visible && fields.objetivo.required ? ew.Validators.required(fields.objetivo.caption) : null], fields.objetivo.isInvalid],
            ["proc_antes", [fields.proc_antes.visible && fields.proc_antes.required ? ew.Validators.required(fields.proc_antes.caption) : null], fields.proc_antes.isInvalid],
            ["proc_depois", [fields.proc_depois.visible && fields.proc_depois.required ? ew.Validators.required(fields.proc_depois.caption) : null], fields.proc_depois.isInvalid],
            ["eqpto_recursos", [fields.eqpto_recursos.visible && fields.eqpto_recursos.required ? ew.Validators.required(fields.eqpto_recursos.caption) : null], fields.eqpto_recursos.isInvalid],
            ["entradas", [fields.entradas.visible && fields.entradas.required ? ew.Validators.required(fields.entradas.caption) : null], fields.entradas.isInvalid],
            ["atividade_principal", [fields.atividade_principal.visible && fields.atividade_principal.required ? ew.Validators.required(fields.atividade_principal.caption) : null], fields.atividade_principal.isInvalid],
            ["saidas_resultados", [fields.saidas_resultados.visible && fields.saidas_resultados.required ? ew.Validators.required(fields.saidas_resultados.caption) : null], fields.saidas_resultados.isInvalid],
            ["requsito_saidas", [fields.requsito_saidas.visible && fields.requsito_saidas.required ? ew.Validators.required(fields.requsito_saidas.caption) : null], fields.requsito_saidas.isInvalid],
            ["riscos", [fields.riscos.visible && fields.riscos.required ? ew.Validators.required(fields.riscos.caption) : null], fields.riscos.isInvalid],
            ["oportunidades", [fields.oportunidades.visible && fields.oportunidades.required ? ew.Validators.required(fields.oportunidades.caption) : null], fields.oportunidades.isInvalid],
            ["propriedade_externa", [fields.propriedade_externa.visible && fields.propriedade_externa.required ? ew.Validators.required(fields.propriedade_externa.caption) : null], fields.propriedade_externa.isInvalid],
            ["conhecimentos", [fields.conhecimentos.visible && fields.conhecimentos.required ? ew.Validators.required(fields.conhecimentos.caption) : null], fields.conhecimentos.isInvalid],
            ["documentos_aplicados", [fields.documentos_aplicados.visible && fields.documentos_aplicados.required ? ew.Validators.required(fields.documentos_aplicados.caption) : null], fields.documentos_aplicados.isInvalid],
            ["proced_int_trabalho", [fields.proced_int_trabalho.visible && fields.proced_int_trabalho.required ? ew.Validators.fileRequired(fields.proced_int_trabalho.caption) : null], fields.proced_int_trabalho.isInvalid],
            ["mapa", [fields.mapa.visible && fields.mapa.required ? ew.Validators.fileRequired(fields.mapa.caption) : null], fields.mapa.isInvalid],
            ["formulario", [fields.formulario.visible && fields.formulario.required ? ew.Validators.fileRequired(fields.formulario.caption) : null], fields.formulario.isInvalid]
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

        // Multi-Page
        .setMultiPage(true)

        // Dynamic selection lists
        .setLists({
            "tipo_idtipo": <?= $Page->tipo_idtipo->toClientList($Page) ?>,
            "responsaveis": <?= $Page->responsaveis->toClientList($Page) ?>,
            "proc_antes": <?= $Page->proc_antes->toClientList($Page) ?>,
            "proc_depois": <?= $Page->proc_depois->toClientList($Page) ?>,
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
<form name="fprocessoadd" id="fprocessoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="processo">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_ProcessoAdd"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_processo1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_processo2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(3) ?>" data-bs-target="#tab_processo3" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo3" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(3)) ?>"><?= $Page->pageCaption(3) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(4) ?>" data-bs-target="#tab_processo4" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo4" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(4)) ?>"><?= $Page->pageCaption(4) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(5) ?>" data-bs-target="#tab_processo5" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo5" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(5)) ?>"><?= $Page->pageCaption(5) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(6) ?>" data-bs-target="#tab_processo6" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_processo6" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(6)) ?>"><?= $Page->pageCaption(6) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_processo1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label id="elh_processo_dt_cadastro" for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dt_cadastro->caption() ?><?= $Page->dt_cadastro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_processo_dt_cadastro">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="processo" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" data-page="1" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?> aria-describedby="x_dt_cadastro_help">
<?= $Page->dt_cadastro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage() ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fprocessoadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fprocessoadd", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->revisao->Visible) { // revisao ?>
    <div id="r_revisao"<?= $Page->revisao->rowAttributes() ?>>
        <label id="elh_processo_revisao" for="x_revisao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->revisao->caption() ?><?= $Page->revisao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->revisao->cellAttributes() ?>>
<span id="el_processo_revisao">
<input type="<?= $Page->revisao->getInputTextType() ?>" name="x_revisao" id="x_revisao" data-table="processo" data-field="x_revisao" value="<?= $Page->revisao->EditValue ?>" data-page="1" size="5" maxlength="15" placeholder="<?= HtmlEncode($Page->revisao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->revisao->formatPattern()) ?>"<?= $Page->revisao->editAttributes() ?> aria-describedby="x_revisao_help">
<?= $Page->revisao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->revisao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_idtipo->Visible) { // tipo_idtipo ?>
    <div id="r_tipo_idtipo"<?= $Page->tipo_idtipo->rowAttributes() ?>>
        <label id="elh_processo_tipo_idtipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_idtipo->caption() ?><?= $Page->tipo_idtipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_idtipo->cellAttributes() ?>>
<span id="el_processo_tipo_idtipo">
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
    value="<?= HtmlEncode($Page->tipo_idtipo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_idtipo"
    data-target="dsl_x_tipo_idtipo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo_idtipo->isInvalidClass() ?>"
    data-table="processo"
    data-field="x_tipo_idtipo"
    data-page="1"
    data-value-separator="<?= $Page->tipo_idtipo->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_idtipo->editAttributes() ?>></selection-list>
<?= $Page->tipo_idtipo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_idtipo->getErrorMessage() ?></div>
<?= $Page->tipo_idtipo->Lookup->getParamTag($Page, "p_x_tipo_idtipo") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->processo->Visible) { // processo ?>
    <div id="r_processo"<?= $Page->processo->rowAttributes() ?>>
        <label id="elh_processo_processo" for="x_processo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->processo->caption() ?><?= $Page->processo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->processo->cellAttributes() ?>>
<span id="el_processo_processo">
<input type="<?= $Page->processo->getInputTextType() ?>" name="x_processo" id="x_processo" data-table="processo" data-field="x_processo" value="<?= $Page->processo->EditValue ?>" data-page="1" size="35" maxlength="80" placeholder="<?= HtmlEncode($Page->processo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->processo->formatPattern()) ?>"<?= $Page->processo->editAttributes() ?> aria-describedby="x_processo_help">
<?= $Page->processo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->processo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->responsaveis->Visible) { // responsaveis ?>
    <div id="r_responsaveis"<?= $Page->responsaveis->rowAttributes() ?>>
        <label id="elh_processo_responsaveis" class="<?= $Page->LeftColumnClass ?>"><?= $Page->responsaveis->caption() ?><?= $Page->responsaveis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->responsaveis->cellAttributes() ?>>
<span id="el_processo_responsaveis">
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
    value="<?= HtmlEncode($Page->responsaveis->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_responsaveis"
    data-target="dsl_x_responsaveis"
    data-repeatcolumn="6"
    class="form-control<?= $Page->responsaveis->isInvalidClass() ?>"
    data-table="processo"
    data-field="x_responsaveis"
    data-page="1"
    data-value-separator="<?= $Page->responsaveis->displayValueSeparatorAttribute() ?>"
    <?= $Page->responsaveis->editAttributes() ?>></selection-list>
<?= $Page->responsaveis->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->responsaveis->getErrorMessage() ?></div>
<?= $Page->responsaveis->Lookup->getParamTag($Page, "p_x_responsaveis") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->objetivo->Visible) { // objetivo ?>
    <div id="r_objetivo"<?= $Page->objetivo->rowAttributes() ?>>
        <label id="elh_processo_objetivo" for="x_objetivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->objetivo->caption() ?><?= $Page->objetivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->objetivo->cellAttributes() ?>>
<span id="el_processo_objetivo">
<textarea data-table="processo" data-field="x_objetivo" data-page="1" name="x_objetivo" id="x_objetivo" cols="50" rows="3" placeholder="<?= HtmlEncode($Page->objetivo->getPlaceHolder()) ?>"<?= $Page->objetivo->editAttributes() ?> aria-describedby="x_objetivo_help"><?= $Page->objetivo->EditValue ?></textarea>
<?= $Page->objetivo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->objetivo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->proc_antes->Visible) { // proc_antes ?>
    <div id="r_proc_antes"<?= $Page->proc_antes->rowAttributes() ?>>
        <label id="elh_processo_proc_antes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->proc_antes->caption() ?><?= $Page->proc_antes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->proc_antes->cellAttributes() ?>>
<span id="el_processo_proc_antes">
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
    value="<?= HtmlEncode($Page->proc_antes->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_proc_antes"
    data-target="dsl_x_proc_antes"
    data-repeatcolumn="5"
    class="form-control<?= $Page->proc_antes->isInvalidClass() ?>"
    data-table="processo"
    data-field="x_proc_antes"
    data-page="1"
    data-value-separator="<?= $Page->proc_antes->displayValueSeparatorAttribute() ?>"
    <?= $Page->proc_antes->editAttributes() ?>></selection-list>
<?= $Page->proc_antes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->proc_antes->getErrorMessage() ?></div>
<?= $Page->proc_antes->Lookup->getParamTag($Page, "p_x_proc_antes") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->proc_depois->Visible) { // proc_depois ?>
    <div id="r_proc_depois"<?= $Page->proc_depois->rowAttributes() ?>>
        <label id="elh_processo_proc_depois" class="<?= $Page->LeftColumnClass ?>"><?= $Page->proc_depois->caption() ?><?= $Page->proc_depois->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->proc_depois->cellAttributes() ?>>
<span id="el_processo_proc_depois">
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
    value="<?= HtmlEncode($Page->proc_depois->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_proc_depois"
    data-target="dsl_x_proc_depois"
    data-repeatcolumn="5"
    class="form-control<?= $Page->proc_depois->isInvalidClass() ?>"
    data-table="processo"
    data-field="x_proc_depois"
    data-page="1"
    data-value-separator="<?= $Page->proc_depois->displayValueSeparatorAttribute() ?>"
    <?= $Page->proc_depois->editAttributes() ?>></selection-list>
<?= $Page->proc_depois->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->proc_depois->getErrorMessage() ?></div>
<?= $Page->proc_depois->Lookup->getParamTag($Page, "p_x_proc_depois") ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_processo2" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->eqpto_recursos->Visible) { // eqpto_recursos ?>
    <div id="r_eqpto_recursos"<?= $Page->eqpto_recursos->rowAttributes() ?>>
        <label id="elh_processo_eqpto_recursos" for="x_eqpto_recursos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->eqpto_recursos->caption() ?><?= $Page->eqpto_recursos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->eqpto_recursos->cellAttributes() ?>>
<span id="el_processo_eqpto_recursos">
<textarea data-table="processo" data-field="x_eqpto_recursos" data-page="2" name="x_eqpto_recursos" id="x_eqpto_recursos" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->eqpto_recursos->getPlaceHolder()) ?>"<?= $Page->eqpto_recursos->editAttributes() ?> aria-describedby="x_eqpto_recursos_help"><?= $Page->eqpto_recursos->EditValue ?></textarea>
<?= $Page->eqpto_recursos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->eqpto_recursos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->entradas->Visible) { // entradas ?>
    <div id="r_entradas"<?= $Page->entradas->rowAttributes() ?>>
        <label id="elh_processo_entradas" for="x_entradas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->entradas->caption() ?><?= $Page->entradas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->entradas->cellAttributes() ?>>
<span id="el_processo_entradas">
<textarea data-table="processo" data-field="x_entradas" data-page="2" name="x_entradas" id="x_entradas" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->entradas->getPlaceHolder()) ?>"<?= $Page->entradas->editAttributes() ?> aria-describedby="x_entradas_help"><?= $Page->entradas->EditValue ?></textarea>
<?= $Page->entradas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->entradas->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(3) ?>" id="tab_processo3" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->atividade_principal->Visible) { // atividade_principal ?>
    <div id="r_atividade_principal"<?= $Page->atividade_principal->rowAttributes() ?>>
        <label id="elh_processo_atividade_principal" for="x_atividade_principal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->atividade_principal->caption() ?><?= $Page->atividade_principal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->atividade_principal->cellAttributes() ?>>
<span id="el_processo_atividade_principal">
<textarea data-table="processo" data-field="x_atividade_principal" data-page="3" name="x_atividade_principal" id="x_atividade_principal" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->atividade_principal->getPlaceHolder()) ?>"<?= $Page->atividade_principal->editAttributes() ?> aria-describedby="x_atividade_principal_help"><?= $Page->atividade_principal->EditValue ?></textarea>
<?= $Page->atividade_principal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->atividade_principal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->saidas_resultados->Visible) { // saidas_resultados ?>
    <div id="r_saidas_resultados"<?= $Page->saidas_resultados->rowAttributes() ?>>
        <label id="elh_processo_saidas_resultados" for="x_saidas_resultados" class="<?= $Page->LeftColumnClass ?>"><?= $Page->saidas_resultados->caption() ?><?= $Page->saidas_resultados->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->saidas_resultados->cellAttributes() ?>>
<span id="el_processo_saidas_resultados">
<textarea data-table="processo" data-field="x_saidas_resultados" data-page="3" name="x_saidas_resultados" id="x_saidas_resultados" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->saidas_resultados->getPlaceHolder()) ?>"<?= $Page->saidas_resultados->editAttributes() ?> aria-describedby="x_saidas_resultados_help"><?= $Page->saidas_resultados->EditValue ?></textarea>
<?= $Page->saidas_resultados->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->saidas_resultados->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->requsito_saidas->Visible) { // requsito_saidas ?>
    <div id="r_requsito_saidas"<?= $Page->requsito_saidas->rowAttributes() ?>>
        <label id="elh_processo_requsito_saidas" for="x_requsito_saidas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->requsito_saidas->caption() ?><?= $Page->requsito_saidas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->requsito_saidas->cellAttributes() ?>>
<span id="el_processo_requsito_saidas">
<textarea data-table="processo" data-field="x_requsito_saidas" data-page="3" name="x_requsito_saidas" id="x_requsito_saidas" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->requsito_saidas->getPlaceHolder()) ?>"<?= $Page->requsito_saidas->editAttributes() ?> aria-describedby="x_requsito_saidas_help"><?= $Page->requsito_saidas->EditValue ?></textarea>
<?= $Page->requsito_saidas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->requsito_saidas->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(4) ?>" id="tab_processo4" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->riscos->Visible) { // riscos ?>
    <div id="r_riscos"<?= $Page->riscos->rowAttributes() ?>>
        <label id="elh_processo_riscos" for="x_riscos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->riscos->caption() ?><?= $Page->riscos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->riscos->cellAttributes() ?>>
<span id="el_processo_riscos">
<textarea data-table="processo" data-field="x_riscos" data-page="4" name="x_riscos" id="x_riscos" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->riscos->getPlaceHolder()) ?>"<?= $Page->riscos->editAttributes() ?> aria-describedby="x_riscos_help"><?= $Page->riscos->EditValue ?></textarea>
<?= $Page->riscos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->riscos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->oportunidades->Visible) { // oportunidades ?>
    <div id="r_oportunidades"<?= $Page->oportunidades->rowAttributes() ?>>
        <label id="elh_processo_oportunidades" for="x_oportunidades" class="<?= $Page->LeftColumnClass ?>"><?= $Page->oportunidades->caption() ?><?= $Page->oportunidades->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->oportunidades->cellAttributes() ?>>
<span id="el_processo_oportunidades">
<textarea data-table="processo" data-field="x_oportunidades" data-page="4" name="x_oportunidades" id="x_oportunidades" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->oportunidades->getPlaceHolder()) ?>"<?= $Page->oportunidades->editAttributes() ?> aria-describedby="x_oportunidades_help"><?= $Page->oportunidades->EditValue ?></textarea>
<?= $Page->oportunidades->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->oportunidades->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(5) ?>" id="tab_processo5" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->propriedade_externa->Visible) { // propriedade_externa ?>
    <div id="r_propriedade_externa"<?= $Page->propriedade_externa->rowAttributes() ?>>
        <label id="elh_processo_propriedade_externa" for="x_propriedade_externa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->propriedade_externa->caption() ?><?= $Page->propriedade_externa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->propriedade_externa->cellAttributes() ?>>
<span id="el_processo_propriedade_externa">
<textarea data-table="processo" data-field="x_propriedade_externa" data-page="5" name="x_propriedade_externa" id="x_propriedade_externa" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->propriedade_externa->getPlaceHolder()) ?>"<?= $Page->propriedade_externa->editAttributes() ?> aria-describedby="x_propriedade_externa_help"><?= $Page->propriedade_externa->EditValue ?></textarea>
<?= $Page->propriedade_externa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->propriedade_externa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->conhecimentos->Visible) { // conhecimentos ?>
    <div id="r_conhecimentos"<?= $Page->conhecimentos->rowAttributes() ?>>
        <label id="elh_processo_conhecimentos" for="x_conhecimentos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->conhecimentos->caption() ?><?= $Page->conhecimentos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->conhecimentos->cellAttributes() ?>>
<span id="el_processo_conhecimentos">
<textarea data-table="processo" data-field="x_conhecimentos" data-page="5" name="x_conhecimentos" id="x_conhecimentos" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->conhecimentos->getPlaceHolder()) ?>"<?= $Page->conhecimentos->editAttributes() ?> aria-describedby="x_conhecimentos_help"><?= $Page->conhecimentos->EditValue ?></textarea>
<?= $Page->conhecimentos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->conhecimentos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->documentos_aplicados->Visible) { // documentos_aplicados ?>
    <div id="r_documentos_aplicados"<?= $Page->documentos_aplicados->rowAttributes() ?>>
        <label id="elh_processo_documentos_aplicados" for="x_documentos_aplicados" class="<?= $Page->LeftColumnClass ?>"><?= $Page->documentos_aplicados->caption() ?><?= $Page->documentos_aplicados->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->documentos_aplicados->cellAttributes() ?>>
<span id="el_processo_documentos_aplicados">
<textarea data-table="processo" data-field="x_documentos_aplicados" data-page="5" name="x_documentos_aplicados" id="x_documentos_aplicados" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->documentos_aplicados->getPlaceHolder()) ?>"<?= $Page->documentos_aplicados->editAttributes() ?> aria-describedby="x_documentos_aplicados_help"><?= $Page->documentos_aplicados->EditValue ?></textarea>
<?= $Page->documentos_aplicados->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->documentos_aplicados->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(6) ?>" id="tab_processo6" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->proced_int_trabalho->Visible) { // proced_int_trabalho ?>
    <div id="r_proced_int_trabalho"<?= $Page->proced_int_trabalho->rowAttributes() ?>>
        <label id="elh_processo_proced_int_trabalho" class="<?= $Page->LeftColumnClass ?>"><?= $Page->proced_int_trabalho->caption() ?><?= $Page->proced_int_trabalho->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->proced_int_trabalho->cellAttributes() ?>>
<span id="el_processo_proced_int_trabalho">
<div id="fd_x_proced_int_trabalho" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_proced_int_trabalho"
        name="x_proced_int_trabalho"
        class="form-control ew-file-input"
        title="<?= $Page->proced_int_trabalho->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="processo"
        data-field="x_proced_int_trabalho"
        data-size="120"
        data-accept-file-types="<?= $Page->proced_int_trabalho->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->proced_int_trabalho->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->proced_int_trabalho->ImageCropper ? 0 : 1 ?>"
        data-page="6"
        aria-describedby="x_proced_int_trabalho_help"
        <?= ($Page->proced_int_trabalho->ReadOnly || $Page->proced_int_trabalho->Disabled) ? " disabled" : "" ?>
        <?= $Page->proced_int_trabalho->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <?= $Page->proced_int_trabalho->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->proced_int_trabalho->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_proced_int_trabalho" id= "fn_x_proced_int_trabalho" value="<?= $Page->proced_int_trabalho->Upload->FileName ?>">
<input type="hidden" name="fa_x_proced_int_trabalho" id= "fa_x_proced_int_trabalho" value="0">
<table id="ft_x_proced_int_trabalho" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mapa->Visible) { // mapa ?>
    <div id="r_mapa"<?= $Page->mapa->rowAttributes() ?>>
        <label id="elh_processo_mapa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mapa->caption() ?><?= $Page->mapa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mapa->cellAttributes() ?>>
<span id="el_processo_mapa">
<div id="fd_x_mapa" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_mapa"
        name="x_mapa"
        class="form-control ew-file-input"
        title="<?= $Page->mapa->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="processo"
        data-field="x_mapa"
        data-size="120"
        data-accept-file-types="<?= $Page->mapa->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->mapa->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->mapa->ImageCropper ? 0 : 1 ?>"
        data-page="6"
        aria-describedby="x_mapa_help"
        <?= ($Page->mapa->ReadOnly || $Page->mapa->Disabled) ? " disabled" : "" ?>
        <?= $Page->mapa->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <?= $Page->mapa->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->mapa->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_mapa" id= "fn_x_mapa" value="<?= $Page->mapa->Upload->FileName ?>">
<input type="hidden" name="fa_x_mapa" id= "fa_x_mapa" value="0">
<table id="ft_x_mapa" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->formulario->Visible) { // formulario ?>
    <div id="r_formulario"<?= $Page->formulario->rowAttributes() ?>>
        <label id="elh_processo_formulario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->formulario->caption() ?><?= $Page->formulario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->formulario->cellAttributes() ?>>
<span id="el_processo_formulario">
<div id="fd_x_formulario" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_formulario"
        name="x_formulario"
        class="form-control ew-file-input"
        title="<?= $Page->formulario->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="processo"
        data-field="x_formulario"
        data-size="120"
        data-accept-file-types="<?= $Page->formulario->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->formulario->UploadMaxFileSize ?>"
        data-max-number-of-files="<?= $Page->formulario->UploadMaxFileCount ?>"
        data-disable-image-crop="<?= $Page->formulario->ImageCropper ? 0 : 1 ?>"
        data-page="6"
        multiple
        aria-describedby="x_formulario_help"
        <?= ($Page->formulario->ReadOnly || $Page->formulario->Disabled) ? " disabled" : "" ?>
        <?= $Page->formulario->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFiles") ?></div>
    <?= $Page->formulario->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->formulario->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_formulario" id= "fn_x_formulario" value="<?= $Page->formulario->Upload->FileName ?>">
<input type="hidden" name="fa_x_formulario" id= "fa_x_formulario" value="0">
<table id="ft_x_formulario" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<?php
    if (in_array("processo_indicadores", explode(",", $Page->getCurrentDetailTable())) && $processo_indicadores->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("processo_indicadores", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ProcessoIndicadoresGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fprocessoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fprocessoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
