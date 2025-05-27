<?php

namespace PHPMaker2024\sgq;

// Page object
$GestaoMudancaAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { gestao_mudanca: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fgestao_mudancaadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fgestao_mudancaadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["titulo", [fields.titulo.visible && fields.titulo.required ? ew.Validators.required(fields.titulo.caption) : null], fields.titulo.isInvalid],
            ["dt_inicio", [fields.dt_inicio.visible && fields.dt_inicio.required ? ew.Validators.required(fields.dt_inicio.caption) : null, ew.Validators.datetime(fields.dt_inicio.clientFormatPattern)], fields.dt_inicio.isInvalid],
            ["detalhamento", [fields.detalhamento.visible && fields.detalhamento.required ? ew.Validators.required(fields.detalhamento.caption) : null], fields.detalhamento.isInvalid],
            ["impacto", [fields.impacto.visible && fields.impacto.required ? ew.Validators.required(fields.impacto.caption) : null], fields.impacto.isInvalid],
            ["motivo", [fields.motivo.visible && fields.motivo.required ? ew.Validators.required(fields.motivo.caption) : null], fields.motivo.isInvalid],
            ["recursos", [fields.recursos.visible && fields.recursos.required ? ew.Validators.required(fields.recursos.caption) : null, ew.Validators.float], fields.recursos.isInvalid],
            ["prazo_ate", [fields.prazo_ate.visible && fields.prazo_ate.required ? ew.Validators.required(fields.prazo_ate.caption) : null, ew.Validators.datetime(fields.prazo_ate.clientFormatPattern)], fields.prazo_ate.isInvalid],
            ["departamentos_iddepartamentos", [fields.departamentos_iddepartamentos.visible && fields.departamentos_iddepartamentos.required ? ew.Validators.required(fields.departamentos_iddepartamentos.caption) : null], fields.departamentos_iddepartamentos.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid],
            ["implementado", [fields.implementado.visible && fields.implementado.required ? ew.Validators.required(fields.implementado.caption) : null], fields.implementado.isInvalid],
            ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
            ["eficaz", [fields.eficaz.visible && fields.eficaz.required ? ew.Validators.required(fields.eficaz.caption) : null], fields.eficaz.isInvalid]
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
            "departamentos_iddepartamentos": <?= $Page->departamentos_iddepartamentos->toClientList($Page) ?>,
            "usuario_idusuario": <?= $Page->usuario_idusuario->toClientList($Page) ?>,
            "implementado": <?= $Page->implementado->toClientList($Page) ?>,
            "status": <?= $Page->status->toClientList($Page) ?>,
            "eficaz": <?= $Page->eficaz->toClientList($Page) ?>,
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
<form name="fgestao_mudancaadd" id="fgestao_mudancaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="gestao_mudanca">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->titulo->Visible) { // titulo ?>
    <div id="r_titulo"<?= $Page->titulo->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_titulo" for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titulo->caption() ?><?= $Page->titulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titulo->cellAttributes() ?>>
<span id="el_gestao_mudanca_titulo">
<input type="<?= $Page->titulo->getInputTextType() ?>" name="x_titulo" id="x_titulo" data-table="gestao_mudanca" data-field="x_titulo" value="<?= $Page->titulo->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo->formatPattern()) ?>"<?= $Page->titulo->editAttributes() ?> aria-describedby="x_titulo_help">
<?= $Page->titulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dt_inicio->Visible) { // dt_inicio ?>
    <div id="r_dt_inicio"<?= $Page->dt_inicio->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_dt_inicio" for="x_dt_inicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dt_inicio->caption() ?><?= $Page->dt_inicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dt_inicio->cellAttributes() ?>>
<span id="el_gestao_mudanca_dt_inicio">
<input type="<?= $Page->dt_inicio->getInputTextType() ?>" name="x_dt_inicio" id="x_dt_inicio" data-table="gestao_mudanca" data-field="x_dt_inicio" value="<?= $Page->dt_inicio->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_inicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_inicio->formatPattern()) ?>"<?= $Page->dt_inicio->editAttributes() ?> aria-describedby="x_dt_inicio_help">
<?= $Page->dt_inicio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dt_inicio->getErrorMessage() ?></div>
<?php if (!$Page->dt_inicio->ReadOnly && !$Page->dt_inicio->Disabled && !isset($Page->dt_inicio->EditAttrs["readonly"]) && !isset($Page->dt_inicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fgestao_mudancaadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fgestao_mudancaadd", "x_dt_inicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->detalhamento->Visible) { // detalhamento ?>
    <div id="r_detalhamento"<?= $Page->detalhamento->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_detalhamento" for="x_detalhamento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->detalhamento->caption() ?><?= $Page->detalhamento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->detalhamento->cellAttributes() ?>>
<span id="el_gestao_mudanca_detalhamento">
<textarea data-table="gestao_mudanca" data-field="x_detalhamento" name="x_detalhamento" id="x_detalhamento" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->detalhamento->getPlaceHolder()) ?>"<?= $Page->detalhamento->editAttributes() ?> aria-describedby="x_detalhamento_help"><?= $Page->detalhamento->EditValue ?></textarea>
<?= $Page->detalhamento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->detalhamento->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->impacto->Visible) { // impacto ?>
    <div id="r_impacto"<?= $Page->impacto->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_impacto" for="x_impacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->impacto->caption() ?><?= $Page->impacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->impacto->cellAttributes() ?>>
<span id="el_gestao_mudanca_impacto">
<textarea data-table="gestao_mudanca" data-field="x_impacto" name="x_impacto" id="x_impacto" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->impacto->getPlaceHolder()) ?>"<?= $Page->impacto->editAttributes() ?> aria-describedby="x_impacto_help"><?= $Page->impacto->EditValue ?></textarea>
<?= $Page->impacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->impacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
    <div id="r_motivo"<?= $Page->motivo->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_motivo" for="x_motivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->motivo->caption() ?><?= $Page->motivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->motivo->cellAttributes() ?>>
<span id="el_gestao_mudanca_motivo">
<textarea data-table="gestao_mudanca" data-field="x_motivo" name="x_motivo" id="x_motivo" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->motivo->getPlaceHolder()) ?>"<?= $Page->motivo->editAttributes() ?> aria-describedby="x_motivo_help"><?= $Page->motivo->EditValue ?></textarea>
<?= $Page->motivo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->motivo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->recursos->Visible) { // recursos ?>
    <div id="r_recursos"<?= $Page->recursos->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_recursos" for="x_recursos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->recursos->caption() ?><?= $Page->recursos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->recursos->cellAttributes() ?>>
<span id="el_gestao_mudanca_recursos">
<input type="<?= $Page->recursos->getInputTextType() ?>" name="x_recursos" id="x_recursos" data-table="gestao_mudanca" data-field="x_recursos" value="<?= $Page->recursos->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->recursos->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->recursos->formatPattern()) ?>"<?= $Page->recursos->editAttributes() ?> aria-describedby="x_recursos_help">
<?= $Page->recursos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->recursos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->prazo_ate->Visible) { // prazo_ate ?>
    <div id="r_prazo_ate"<?= $Page->prazo_ate->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_prazo_ate" for="x_prazo_ate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->prazo_ate->caption() ?><?= $Page->prazo_ate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->prazo_ate->cellAttributes() ?>>
<span id="el_gestao_mudanca_prazo_ate">
<input type="<?= $Page->prazo_ate->getInputTextType() ?>" name="x_prazo_ate" id="x_prazo_ate" data-table="gestao_mudanca" data-field="x_prazo_ate" value="<?= $Page->prazo_ate->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->prazo_ate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->prazo_ate->formatPattern()) ?>"<?= $Page->prazo_ate->editAttributes() ?> aria-describedby="x_prazo_ate_help">
<?= $Page->prazo_ate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->prazo_ate->getErrorMessage() ?></div>
<?php if (!$Page->prazo_ate->ReadOnly && !$Page->prazo_ate->Disabled && !isset($Page->prazo_ate->EditAttrs["readonly"]) && !isset($Page->prazo_ate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fgestao_mudancaadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fgestao_mudancaadd", "x_prazo_ate", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <div id="r_departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_departamentos_iddepartamentos" for="x_departamentos_iddepartamentos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->departamentos_iddepartamentos->caption() ?><?= $Page->departamentos_iddepartamentos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el_gestao_mudanca_departamentos_iddepartamentos">
    <select
        id="x_departamentos_iddepartamentos"
        name="x_departamentos_iddepartamentos"
        class="form-control ew-select<?= $Page->departamentos_iddepartamentos->isInvalidClass() ?>"
        data-select2-id="fgestao_mudancaadd_x_departamentos_iddepartamentos"
        data-table="gestao_mudanca"
        data-field="x_departamentos_iddepartamentos"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->departamentos_iddepartamentos->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->departamentos_iddepartamentos->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->departamentos_iddepartamentos->getPlaceHolder()) ?>"
        <?= $Page->departamentos_iddepartamentos->editAttributes() ?>>
        <?= $Page->departamentos_iddepartamentos->selectOptionListHtml("x_departamentos_iddepartamentos") ?>
    </select>
    <?= $Page->departamentos_iddepartamentos->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->departamentos_iddepartamentos->getErrorMessage() ?></div>
<?= $Page->departamentos_iddepartamentos->Lookup->getParamTag($Page, "p_x_departamentos_iddepartamentos") ?>
<script>
loadjs.ready("fgestao_mudancaadd", function() {
    var options = { name: "x_departamentos_iddepartamentos", selectId: "fgestao_mudancaadd_x_departamentos_iddepartamentos" };
    if (fgestao_mudancaadd.lists.departamentos_iddepartamentos?.lookupOptions.length) {
        options.data = { id: "x_departamentos_iddepartamentos", form: "fgestao_mudancaadd" };
    } else {
        options.ajax = { id: "x_departamentos_iddepartamentos", form: "fgestao_mudancaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.gestao_mudanca.fields.departamentos_iddepartamentos.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_usuario_idusuario" for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_idusuario->caption() ?><?= $Page->usuario_idusuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_gestao_mudanca_usuario_idusuario">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-select ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        <?php if (!$Page->usuario_idusuario->IsNativeSelect) { ?>
        data-select2-id="fgestao_mudancaadd_x_usuario_idusuario"
        <?php } ?>
        data-table="gestao_mudanca"
        data-field="x_usuario_idusuario"
        data-value-separator="<?= $Page->usuario_idusuario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_idusuario->getPlaceHolder()) ?>"
        <?= $Page->usuario_idusuario->editAttributes() ?>>
        <?= $Page->usuario_idusuario->selectOptionListHtml("x_usuario_idusuario") ?>
    </select>
    <?= $Page->usuario_idusuario->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->usuario_idusuario->getErrorMessage() ?></div>
<?= $Page->usuario_idusuario->Lookup->getParamTag($Page, "p_x_usuario_idusuario") ?>
<?php if (!$Page->usuario_idusuario->IsNativeSelect) { ?>
<script>
loadjs.ready("fgestao_mudancaadd", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fgestao_mudancaadd_x_usuario_idusuario" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fgestao_mudancaadd.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fgestao_mudancaadd" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fgestao_mudancaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.gestao_mudanca.fields.usuario_idusuario.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
    <div id="r_implementado"<?= $Page->implementado->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_implementado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->implementado->caption() ?><?= $Page->implementado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->implementado->cellAttributes() ?>>
<span id="el_gestao_mudanca_implementado">
<template id="tp_x_implementado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="gestao_mudanca" data-field="x_implementado" name="x_implementado" id="x_implementado"<?= $Page->implementado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_implementado" class="ew-item-list"></div>
<selection-list hidden
    id="x_implementado"
    name="x_implementado"
    value="<?= HtmlEncode($Page->implementado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_implementado"
    data-target="dsl_x_implementado"
    data-repeatcolumn="5"
    class="form-control<?= $Page->implementado->isInvalidClass() ?>"
    data-table="gestao_mudanca"
    data-field="x_implementado"
    data-value-separator="<?= $Page->implementado->displayValueSeparatorAttribute() ?>"
    <?= $Page->implementado->editAttributes() ?>></selection-list>
<?= $Page->implementado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->implementado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_gestao_mudanca_status">
<template id="tp_x_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="gestao_mudanca" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_status"
    name="x_status"
    value="<?= HtmlEncode($Page->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status"
    data-target="dsl_x_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status->isInvalidClass() ?>"
    data-table="gestao_mudanca"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>></selection-list>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
    <div id="r_eficaz"<?= $Page->eficaz->rowAttributes() ?>>
        <label id="elh_gestao_mudanca_eficaz" class="<?= $Page->LeftColumnClass ?>"><?= $Page->eficaz->caption() ?><?= $Page->eficaz->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->eficaz->cellAttributes() ?>>
<span id="el_gestao_mudanca_eficaz">
<template id="tp_x_eficaz">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="gestao_mudanca" data-field="x_eficaz" name="x_eficaz" id="x_eficaz"<?= $Page->eficaz->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_eficaz" class="ew-item-list"></div>
<selection-list hidden
    id="x_eficaz"
    name="x_eficaz"
    value="<?= HtmlEncode($Page->eficaz->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_eficaz"
    data-target="dsl_x_eficaz"
    data-repeatcolumn="5"
    class="form-control<?= $Page->eficaz->isInvalidClass() ?>"
    data-table="gestao_mudanca"
    data-field="x_eficaz"
    data-value-separator="<?= $Page->eficaz->displayValueSeparatorAttribute() ?>"
    <?= $Page->eficaz->editAttributes() ?>></selection-list>
<?= $Page->eficaz->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->eficaz->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fgestao_mudancaadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fgestao_mudancaadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("gestao_mudanca");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
