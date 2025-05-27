<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAcaoNcAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_acao_nc: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fplano_acao_ncadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplano_acao_ncadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["nao_conformidade_idnao_conformidade", [fields.nao_conformidade_idnao_conformidade.visible && fields.nao_conformidade_idnao_conformidade.required ? ew.Validators.required(fields.nao_conformidade_idnao_conformidade.caption) : null], fields.nao_conformidade_idnao_conformidade.isInvalid],
            ["o_q_sera_feito", [fields.o_q_sera_feito.visible && fields.o_q_sera_feito.required ? ew.Validators.required(fields.o_q_sera_feito.caption) : null], fields.o_q_sera_feito.isInvalid],
            ["efeito_esperado", [fields.efeito_esperado.visible && fields.efeito_esperado.required ? ew.Validators.required(fields.efeito_esperado.caption) : null], fields.efeito_esperado.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid],
            ["recursos_nec", [fields.recursos_nec.visible && fields.recursos_nec.required ? ew.Validators.required(fields.recursos_nec.caption) : null, ew.Validators.float], fields.recursos_nec.isInvalid],
            ["dt_limite", [fields.dt_limite.visible && fields.dt_limite.required ? ew.Validators.required(fields.dt_limite.caption) : null, ew.Validators.datetime(fields.dt_limite.clientFormatPattern)], fields.dt_limite.isInvalid],
            ["implementado", [fields.implementado.visible && fields.implementado.required ? ew.Validators.required(fields.implementado.caption) : null], fields.implementado.isInvalid],
            ["eficaz", [fields.eficaz.visible && fields.eficaz.required ? ew.Validators.required(fields.eficaz.caption) : null], fields.eficaz.isInvalid],
            ["evidencia", [fields.evidencia.visible && fields.evidencia.required ? ew.Validators.required(fields.evidencia.caption) : null], fields.evidencia.isInvalid]
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
            "nao_conformidade_idnao_conformidade": <?= $Page->nao_conformidade_idnao_conformidade->toClientList($Page) ?>,
            "usuario_idusuario": <?= $Page->usuario_idusuario->toClientList($Page) ?>,
            "implementado": <?= $Page->implementado->toClientList($Page) ?>,
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
<form name="fplano_acao_ncadd" id="fplano_acao_ncadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="plano_acao_nc">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "nao_conformidade") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="nao_conformidade">
<input type="hidden" name="fk_idnao_conformidade" value="<?= HtmlEncode($Page->nao_conformidade_idnao_conformidade->getSessionValue()) ?>">
<?php } ?>
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_PlanoAcaoNcAdd"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_plano_acao_nc1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_plano_acao_nc1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_plano_acao_nc2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_plano_acao_nc2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_plano_acao_nc1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->nao_conformidade_idnao_conformidade->Visible) { // nao_conformidade_idnao_conformidade ?>
    <div id="r_nao_conformidade_idnao_conformidade"<?= $Page->nao_conformidade_idnao_conformidade->rowAttributes() ?>>
        <label id="elh_plano_acao_nc_nao_conformidade_idnao_conformidade" for="x_nao_conformidade_idnao_conformidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nao_conformidade_idnao_conformidade->caption() ?><?= $Page->nao_conformidade_idnao_conformidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nao_conformidade_idnao_conformidade->cellAttributes() ?>>
<?php if ($Page->nao_conformidade_idnao_conformidade->getSessionValue() != "") { ?>
<span<?= $Page->nao_conformidade_idnao_conformidade->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->nao_conformidade_idnao_conformidade->getDisplayValue($Page->nao_conformidade_idnao_conformidade->ViewValue) ?></span></span>
<input type="hidden" id="x_nao_conformidade_idnao_conformidade" name="x_nao_conformidade_idnao_conformidade" value="<?= HtmlEncode($Page->nao_conformidade_idnao_conformidade->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_plano_acao_nc_nao_conformidade_idnao_conformidade">
    <select
        id="x_nao_conformidade_idnao_conformidade"
        name="x_nao_conformidade_idnao_conformidade"
        class="form-select ew-select<?= $Page->nao_conformidade_idnao_conformidade->isInvalidClass() ?>"
        <?php if (!$Page->nao_conformidade_idnao_conformidade->IsNativeSelect) { ?>
        data-select2-id="fplano_acao_ncadd_x_nao_conformidade_idnao_conformidade"
        <?php } ?>
        data-table="plano_acao_nc"
        data-field="x_nao_conformidade_idnao_conformidade"
        data-page="1"
        data-value-separator="<?= $Page->nao_conformidade_idnao_conformidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nao_conformidade_idnao_conformidade->getPlaceHolder()) ?>"
        <?= $Page->nao_conformidade_idnao_conformidade->editAttributes() ?>>
        <?= $Page->nao_conformidade_idnao_conformidade->selectOptionListHtml("x_nao_conformidade_idnao_conformidade") ?>
    </select>
    <?= $Page->nao_conformidade_idnao_conformidade->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->nao_conformidade_idnao_conformidade->getErrorMessage() ?></div>
<?= $Page->nao_conformidade_idnao_conformidade->Lookup->getParamTag($Page, "p_x_nao_conformidade_idnao_conformidade") ?>
<?php if (!$Page->nao_conformidade_idnao_conformidade->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acao_ncadd", function() {
    var options = { name: "x_nao_conformidade_idnao_conformidade", selectId: "fplano_acao_ncadd_x_nao_conformidade_idnao_conformidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acao_ncadd.lists.nao_conformidade_idnao_conformidade?.lookupOptions.length) {
        options.data = { id: "x_nao_conformidade_idnao_conformidade", form: "fplano_acao_ncadd" };
    } else {
        options.ajax = { id: "x_nao_conformidade_idnao_conformidade", form: "fplano_acao_ncadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao_nc.fields.nao_conformidade_idnao_conformidade.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
    <div id="r_o_q_sera_feito"<?= $Page->o_q_sera_feito->rowAttributes() ?>>
        <label id="elh_plano_acao_nc_o_q_sera_feito" for="x_o_q_sera_feito" class="<?= $Page->LeftColumnClass ?>"><?= $Page->o_q_sera_feito->caption() ?><?= $Page->o_q_sera_feito->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->o_q_sera_feito->cellAttributes() ?>>
<span id="el_plano_acao_nc_o_q_sera_feito">
<textarea data-table="plano_acao_nc" data-field="x_o_q_sera_feito" data-page="1" name="x_o_q_sera_feito" id="x_o_q_sera_feito" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->o_q_sera_feito->getPlaceHolder()) ?>"<?= $Page->o_q_sera_feito->editAttributes() ?> aria-describedby="x_o_q_sera_feito_help"><?= $Page->o_q_sera_feito->EditValue ?></textarea>
<?= $Page->o_q_sera_feito->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->o_q_sera_feito->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
    <div id="r_efeito_esperado"<?= $Page->efeito_esperado->rowAttributes() ?>>
        <label id="elh_plano_acao_nc_efeito_esperado" for="x_efeito_esperado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->efeito_esperado->caption() ?><?= $Page->efeito_esperado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->efeito_esperado->cellAttributes() ?>>
<span id="el_plano_acao_nc_efeito_esperado">
<textarea data-table="plano_acao_nc" data-field="x_efeito_esperado" data-page="1" name="x_efeito_esperado" id="x_efeito_esperado" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->efeito_esperado->getPlaceHolder()) ?>"<?= $Page->efeito_esperado->editAttributes() ?> aria-describedby="x_efeito_esperado_help"><?= $Page->efeito_esperado->EditValue ?></textarea>
<?= $Page->efeito_esperado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->efeito_esperado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label id="elh_plano_acao_nc_usuario_idusuario" for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_idusuario->caption() ?><?= $Page->usuario_idusuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_plano_acao_nc_usuario_idusuario">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-control ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        data-select2-id="fplano_acao_ncadd_x_usuario_idusuario"
        data-table="plano_acao_nc"
        data-field="x_usuario_idusuario"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->usuario_idusuario->caption())) ?>"
        data-modal-lookup="true"
        data-page="1"
        data-value-separator="<?= $Page->usuario_idusuario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_idusuario->getPlaceHolder()) ?>"
        <?= $Page->usuario_idusuario->editAttributes() ?>>
        <?= $Page->usuario_idusuario->selectOptionListHtml("x_usuario_idusuario") ?>
    </select>
    <?= $Page->usuario_idusuario->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->usuario_idusuario->getErrorMessage() ?></div>
<?= $Page->usuario_idusuario->Lookup->getParamTag($Page, "p_x_usuario_idusuario") ?>
<script>
loadjs.ready("fplano_acao_ncadd", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fplano_acao_ncadd_x_usuario_idusuario" };
    if (fplano_acao_ncadd.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fplano_acao_ncadd" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fplano_acao_ncadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.plano_acao_nc.fields.usuario_idusuario.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
    <div id="r_recursos_nec"<?= $Page->recursos_nec->rowAttributes() ?>>
        <label id="elh_plano_acao_nc_recursos_nec" for="x_recursos_nec" class="<?= $Page->LeftColumnClass ?>"><?= $Page->recursos_nec->caption() ?><?= $Page->recursos_nec->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->recursos_nec->cellAttributes() ?>>
<span id="el_plano_acao_nc_recursos_nec">
<input type="<?= $Page->recursos_nec->getInputTextType() ?>" name="x_recursos_nec" id="x_recursos_nec" data-table="plano_acao_nc" data-field="x_recursos_nec" value="<?= $Page->recursos_nec->EditValue ?>" data-page="1" size="10" placeholder="<?= HtmlEncode($Page->recursos_nec->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->recursos_nec->formatPattern()) ?>"<?= $Page->recursos_nec->editAttributes() ?> aria-describedby="x_recursos_nec_help">
<?= $Page->recursos_nec->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->recursos_nec->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
    <div id="r_dt_limite"<?= $Page->dt_limite->rowAttributes() ?>>
        <label id="elh_plano_acao_nc_dt_limite" for="x_dt_limite" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dt_limite->caption() ?><?= $Page->dt_limite->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dt_limite->cellAttributes() ?>>
<span id="el_plano_acao_nc_dt_limite">
<input type="<?= $Page->dt_limite->getInputTextType() ?>" name="x_dt_limite" id="x_dt_limite" data-table="plano_acao_nc" data-field="x_dt_limite" value="<?= $Page->dt_limite->EditValue ?>" data-page="1" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_limite->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_limite->formatPattern()) ?>"<?= $Page->dt_limite->editAttributes() ?> aria-describedby="x_dt_limite_help">
<?= $Page->dt_limite->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dt_limite->getErrorMessage() ?></div>
<?php if (!$Page->dt_limite->ReadOnly && !$Page->dt_limite->Disabled && !isset($Page->dt_limite->EditAttrs["readonly"]) && !isset($Page->dt_limite->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplano_acao_ncadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fplano_acao_ncadd", "x_dt_limite", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
    <div id="r_implementado"<?= $Page->implementado->rowAttributes() ?>>
        <label id="elh_plano_acao_nc_implementado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->implementado->caption() ?><?= $Page->implementado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->implementado->cellAttributes() ?>>
<span id="el_plano_acao_nc_implementado">
<template id="tp_x_implementado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao_nc" data-field="x_implementado" name="x_implementado" id="x_implementado"<?= $Page->implementado->editAttributes() ?>>
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
    data-table="plano_acao_nc"
    data-field="x_implementado"
    data-page="1"
    data-value-separator="<?= $Page->implementado->displayValueSeparatorAttribute() ?>"
    <?= $Page->implementado->editAttributes() ?>></selection-list>
<?= $Page->implementado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->implementado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_plano_acao_nc2" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->eficaz->Visible) { // eficaz ?>
    <div id="r_eficaz"<?= $Page->eficaz->rowAttributes() ?>>
        <label id="elh_plano_acao_nc_eficaz" class="<?= $Page->LeftColumnClass ?>"><?= $Page->eficaz->caption() ?><?= $Page->eficaz->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->eficaz->cellAttributes() ?>>
<span id="el_plano_acao_nc_eficaz">
<template id="tp_x_eficaz">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao_nc" data-field="x_eficaz" name="x_eficaz" id="x_eficaz"<?= $Page->eficaz->editAttributes() ?>>
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
    data-table="plano_acao_nc"
    data-field="x_eficaz"
    data-page="2"
    data-value-separator="<?= $Page->eficaz->displayValueSeparatorAttribute() ?>"
    <?= $Page->eficaz->editAttributes() ?>></selection-list>
<?= $Page->eficaz->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->eficaz->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->evidencia->Visible) { // evidencia ?>
    <div id="r_evidencia"<?= $Page->evidencia->rowAttributes() ?>>
        <label id="elh_plano_acao_nc_evidencia" for="x_evidencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->evidencia->caption() ?><?= $Page->evidencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->evidencia->cellAttributes() ?>>
<span id="el_plano_acao_nc_evidencia">
<textarea data-table="plano_acao_nc" data-field="x_evidencia" data-page="2" name="x_evidencia" id="x_evidencia" cols="35" rows="2" placeholder="<?= HtmlEncode($Page->evidencia->getPlaceHolder()) ?>"<?= $Page->evidencia->editAttributes() ?> aria-describedby="x_evidencia_help"><?= $Page->evidencia->EditValue ?></textarea>
<?= $Page->evidencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->evidencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fplano_acao_ncadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fplano_acao_ncadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("plano_acao_nc");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
