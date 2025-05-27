<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAcaoNcSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_acao_nc: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fplano_acao_ncsearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fplano_acao_ncsearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idplano_acao_nc", [ew.Validators.integer], fields.idplano_acao_nc.isInvalid],
            ["dt_cadastro", [ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["nao_conformidade_idnao_conformidade", [], fields.nao_conformidade_idnao_conformidade.isInvalid],
            ["o_q_sera_feito", [], fields.o_q_sera_feito.isInvalid],
            ["efeito_esperado", [], fields.efeito_esperado.isInvalid],
            ["usuario_idusuario", [], fields.usuario_idusuario.isInvalid],
            ["recursos_nec", [ew.Validators.float], fields.recursos_nec.isInvalid],
            ["dt_limite", [ew.Validators.datetime(fields.dt_limite.clientFormatPattern)], fields.dt_limite.isInvalid],
            ["implementado", [], fields.implementado.isInvalid],
            ["eficaz", [], fields.eficaz.isInvalid],
            ["evidencia", [], fields.evidencia.isInvalid]
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
            "nao_conformidade_idnao_conformidade": <?= $Page->nao_conformidade_idnao_conformidade->toClientList($Page) ?>,
            "usuario_idusuario": <?= $Page->usuario_idusuario->toClientList($Page) ?>,
            "implementado": <?= $Page->implementado->toClientList($Page) ?>,
            "eficaz": <?= $Page->eficaz->toClientList($Page) ?>,
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
<form name="fplano_acao_ncsearch" id="fplano_acao_ncsearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="plano_acao_nc">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_PlanoAcaoNcSearch"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_plano_acao_nc1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_plano_acao_nc1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_plano_acao_nc2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_plano_acao_nc2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_plano_acao_nc1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idplano_acao_nc->Visible) { // idplano_acao_nc ?>
    <div id="r_idplano_acao_nc" class="row"<?= $Page->idplano_acao_nc->rowAttributes() ?>>
        <label for="x_idplano_acao_nc" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_nc_idplano_acao_nc"><?= $Page->idplano_acao_nc->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idplano_acao_nc" id="z_idplano_acao_nc" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idplano_acao_nc->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_nc_idplano_acao_nc" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idplano_acao_nc->getInputTextType() ?>" name="x_idplano_acao_nc" id="x_idplano_acao_nc" data-table="plano_acao_nc" data-field="x_idplano_acao_nc" value="<?= $Page->idplano_acao_nc->EditValue ?>" data-page="1" size="30" placeholder="<?= HtmlEncode($Page->idplano_acao_nc->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idplano_acao_nc->formatPattern()) ?>"<?= $Page->idplano_acao_nc->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idplano_acao_nc->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro" class="row"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_nc_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_cadastro" id="z_dt_cadastro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_cadastro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_nc_dt_cadastro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="plano_acao_nc" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" data-page="1" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplano_acao_ncsearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fplano_acao_ncsearch", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->nao_conformidade_idnao_conformidade->Visible) { // nao_conformidade_idnao_conformidade ?>
    <div id="r_nao_conformidade_idnao_conformidade" class="row"<?= $Page->nao_conformidade_idnao_conformidade->rowAttributes() ?>>
        <label for="x_nao_conformidade_idnao_conformidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_nc_nao_conformidade_idnao_conformidade"><?= $Page->nao_conformidade_idnao_conformidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_nao_conformidade_idnao_conformidade" id="z_nao_conformidade_idnao_conformidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->nao_conformidade_idnao_conformidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_nc_nao_conformidade_idnao_conformidade" class="ew-search-field ew-search-field-single">
    <select
        id="x_nao_conformidade_idnao_conformidade"
        name="x_nao_conformidade_idnao_conformidade"
        class="form-select ew-select<?= $Page->nao_conformidade_idnao_conformidade->isInvalidClass() ?>"
        <?php if (!$Page->nao_conformidade_idnao_conformidade->IsNativeSelect) { ?>
        data-select2-id="fplano_acao_ncsearch_x_nao_conformidade_idnao_conformidade"
        <?php } ?>
        data-table="plano_acao_nc"
        data-field="x_nao_conformidade_idnao_conformidade"
        data-page="1"
        data-value-separator="<?= $Page->nao_conformidade_idnao_conformidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nao_conformidade_idnao_conformidade->getPlaceHolder()) ?>"
        <?= $Page->nao_conformidade_idnao_conformidade->editAttributes() ?>>
        <?= $Page->nao_conformidade_idnao_conformidade->selectOptionListHtml("x_nao_conformidade_idnao_conformidade") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->nao_conformidade_idnao_conformidade->getErrorMessage(false) ?></div>
<?= $Page->nao_conformidade_idnao_conformidade->Lookup->getParamTag($Page, "p_x_nao_conformidade_idnao_conformidade") ?>
<?php if (!$Page->nao_conformidade_idnao_conformidade->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acao_ncsearch", function() {
    var options = { name: "x_nao_conformidade_idnao_conformidade", selectId: "fplano_acao_ncsearch_x_nao_conformidade_idnao_conformidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acao_ncsearch.lists.nao_conformidade_idnao_conformidade?.lookupOptions.length) {
        options.data = { id: "x_nao_conformidade_idnao_conformidade", form: "fplano_acao_ncsearch" };
    } else {
        options.ajax = { id: "x_nao_conformidade_idnao_conformidade", form: "fplano_acao_ncsearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao_nc.fields.nao_conformidade_idnao_conformidade.selectOptions);
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
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
    <div id="r_o_q_sera_feito" class="row"<?= $Page->o_q_sera_feito->rowAttributes() ?>>
        <label for="x_o_q_sera_feito" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_nc_o_q_sera_feito"><?= $Page->o_q_sera_feito->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_o_q_sera_feito" id="z_o_q_sera_feito" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->o_q_sera_feito->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_nc_o_q_sera_feito" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->o_q_sera_feito->getInputTextType() ?>" name="x_o_q_sera_feito" id="x_o_q_sera_feito" data-table="plano_acao_nc" data-field="x_o_q_sera_feito" value="<?= $Page->o_q_sera_feito->EditValue ?>" data-page="1" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->o_q_sera_feito->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->o_q_sera_feito->formatPattern()) ?>"<?= $Page->o_q_sera_feito->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->o_q_sera_feito->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
    <div id="r_efeito_esperado" class="row"<?= $Page->efeito_esperado->rowAttributes() ?>>
        <label for="x_efeito_esperado" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_nc_efeito_esperado"><?= $Page->efeito_esperado->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_efeito_esperado" id="z_efeito_esperado" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->efeito_esperado->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_nc_efeito_esperado" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->efeito_esperado->getInputTextType() ?>" name="x_efeito_esperado" id="x_efeito_esperado" data-table="plano_acao_nc" data-field="x_efeito_esperado" value="<?= $Page->efeito_esperado->EditValue ?>" data-page="1" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->efeito_esperado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->efeito_esperado->formatPattern()) ?>"<?= $Page->efeito_esperado->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->efeito_esperado->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario" class="row"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_nc_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_usuario_idusuario" id="z_usuario_idusuario" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->usuario_idusuario->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_nc_usuario_idusuario" class="ew-search-field ew-search-field-single">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-control ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        data-select2-id="fplano_acao_ncsearch_x_usuario_idusuario"
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
    <div class="invalid-feedback"><?= $Page->usuario_idusuario->getErrorMessage(false) ?></div>
<?= $Page->usuario_idusuario->Lookup->getParamTag($Page, "p_x_usuario_idusuario") ?>
<script>
loadjs.ready("fplano_acao_ncsearch", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fplano_acao_ncsearch_x_usuario_idusuario" };
    if (fplano_acao_ncsearch.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fplano_acao_ncsearch" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fplano_acao_ncsearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.plano_acao_nc.fields.usuario_idusuario.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
    <div id="r_recursos_nec" class="row"<?= $Page->recursos_nec->rowAttributes() ?>>
        <label for="x_recursos_nec" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_nc_recursos_nec"><?= $Page->recursos_nec->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_recursos_nec" id="z_recursos_nec" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->recursos_nec->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_nc_recursos_nec" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->recursos_nec->getInputTextType() ?>" name="x_recursos_nec" id="x_recursos_nec" data-table="plano_acao_nc" data-field="x_recursos_nec" value="<?= $Page->recursos_nec->EditValue ?>" data-page="1" size="10" placeholder="<?= HtmlEncode($Page->recursos_nec->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->recursos_nec->formatPattern()) ?>"<?= $Page->recursos_nec->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->recursos_nec->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
    <div id="r_dt_limite" class="row"<?= $Page->dt_limite->rowAttributes() ?>>
        <label for="x_dt_limite" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_nc_dt_limite"><?= $Page->dt_limite->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_limite" id="z_dt_limite" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_limite->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_nc_dt_limite" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_limite->getInputTextType() ?>" name="x_dt_limite" id="x_dt_limite" data-table="plano_acao_nc" data-field="x_dt_limite" value="<?= $Page->dt_limite->EditValue ?>" data-page="1" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_limite->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_limite->formatPattern()) ?>"<?= $Page->dt_limite->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_limite->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_limite->ReadOnly && !$Page->dt_limite->Disabled && !isset($Page->dt_limite->EditAttrs["readonly"]) && !isset($Page->dt_limite->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplano_acao_ncsearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fplano_acao_ncsearch", "x_dt_limite", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
    <div id="r_implementado" class="row"<?= $Page->implementado->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_nc_implementado"><?= $Page->implementado->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_implementado" id="z_implementado" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->implementado->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_nc_implementado" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->implementado->AdvancedSearch->SearchValue) ?>"
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
<div class="invalid-feedback"><?= $Page->implementado->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_plano_acao_nc2" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->eficaz->Visible) { // eficaz ?>
    <div id="r_eficaz" class="row"<?= $Page->eficaz->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_nc_eficaz"><?= $Page->eficaz->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_eficaz" id="z_eficaz" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->eficaz->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_nc_eficaz" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->eficaz->AdvancedSearch->SearchValue) ?>"
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
<div class="invalid-feedback"><?= $Page->eficaz->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->evidencia->Visible) { // evidencia ?>
    <div id="r_evidencia" class="row"<?= $Page->evidencia->rowAttributes() ?>>
        <label for="x_evidencia" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_nc_evidencia"><?= $Page->evidencia->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_evidencia" id="z_evidencia" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->evidencia->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_nc_evidencia" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->evidencia->getInputTextType() ?>" name="x_evidencia" id="x_evidencia" data-table="plano_acao_nc" data-field="x_evidencia" value="<?= $Page->evidencia->EditValue ?>" data-page="2" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->evidencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->evidencia->formatPattern()) ?>"<?= $Page->evidencia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->evidencia->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fplano_acao_ncsearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fplano_acao_ncsearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fplano_acao_ncsearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
