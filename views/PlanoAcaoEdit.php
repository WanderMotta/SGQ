<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAcaoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fplano_acaoedit" id="fplano_acaoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_acao: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fplano_acaoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplano_acaoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idplano_acao", [fields.idplano_acao.visible && fields.idplano_acao.required ? ew.Validators.required(fields.idplano_acao.caption) : null], fields.idplano_acao.isInvalid],
            ["risco_oportunidade_idrisco_oportunidade", [fields.risco_oportunidade_idrisco_oportunidade.visible && fields.risco_oportunidade_idrisco_oportunidade.required ? ew.Validators.required(fields.risco_oportunidade_idrisco_oportunidade.caption) : null], fields.risco_oportunidade_idrisco_oportunidade.isInvalid],
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["o_q_sera_feito", [fields.o_q_sera_feito.visible && fields.o_q_sera_feito.required ? ew.Validators.required(fields.o_q_sera_feito.caption) : null], fields.o_q_sera_feito.isInvalid],
            ["efeito_esperado", [fields.efeito_esperado.visible && fields.efeito_esperado.required ? ew.Validators.required(fields.efeito_esperado.caption) : null], fields.efeito_esperado.isInvalid],
            ["departamentos_iddepartamentos", [fields.departamentos_iddepartamentos.visible && fields.departamentos_iddepartamentos.required ? ew.Validators.required(fields.departamentos_iddepartamentos.caption) : null], fields.departamentos_iddepartamentos.isInvalid],
            ["origem_risco_oportunidade_idorigem_risco_oportunidade", [fields.origem_risco_oportunidade_idorigem_risco_oportunidade.visible && fields.origem_risco_oportunidade_idorigem_risco_oportunidade.required ? ew.Validators.required(fields.origem_risco_oportunidade_idorigem_risco_oportunidade.caption) : null], fields.origem_risco_oportunidade_idorigem_risco_oportunidade.isInvalid],
            ["recursos_nec", [fields.recursos_nec.visible && fields.recursos_nec.required ? ew.Validators.required(fields.recursos_nec.caption) : null, ew.Validators.float], fields.recursos_nec.isInvalid],
            ["dt_limite", [fields.dt_limite.visible && fields.dt_limite.required ? ew.Validators.required(fields.dt_limite.caption) : null, ew.Validators.datetime(fields.dt_limite.clientFormatPattern)], fields.dt_limite.isInvalid],
            ["implementado", [fields.implementado.visible && fields.implementado.required ? ew.Validators.required(fields.implementado.caption) : null], fields.implementado.isInvalid],
            ["periodicidade_idperiodicidade", [fields.periodicidade_idperiodicidade.visible && fields.periodicidade_idperiodicidade.required ? ew.Validators.required(fields.periodicidade_idperiodicidade.caption) : null], fields.periodicidade_idperiodicidade.isInvalid],
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
            "risco_oportunidade_idrisco_oportunidade": <?= $Page->risco_oportunidade_idrisco_oportunidade->toClientList($Page) ?>,
            "departamentos_iddepartamentos": <?= $Page->departamentos_iddepartamentos->toClientList($Page) ?>,
            "origem_risco_oportunidade_idorigem_risco_oportunidade": <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->toClientList($Page) ?>,
            "implementado": <?= $Page->implementado->toClientList($Page) ?>,
            "periodicidade_idperiodicidade": <?= $Page->periodicidade_idperiodicidade->toClientList($Page) ?>,
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="plano_acao">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "risco_oportunidade") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="risco_oportunidade">
<input type="hidden" name="fk_idrisco_oportunidade" value="<?= HtmlEncode($Page->risco_oportunidade_idrisco_oportunidade->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idplano_acao->Visible) { // idplano_acao ?>
    <div id="r_idplano_acao"<?= $Page->idplano_acao->rowAttributes() ?>>
        <label id="elh_plano_acao_idplano_acao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idplano_acao->caption() ?><?= $Page->idplano_acao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idplano_acao->cellAttributes() ?>>
<span id="el_plano_acao_idplano_acao">
<span<?= $Page->idplano_acao->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idplano_acao->getDisplayValue($Page->idplano_acao->EditValue))) ?>"></span>
<input type="hidden" data-table="plano_acao" data-field="x_idplano_acao" data-hidden="1" name="x_idplano_acao" id="x_idplano_acao" value="<?= HtmlEncode($Page->idplano_acao->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
    <div id="r_risco_oportunidade_idrisco_oportunidade"<?= $Page->risco_oportunidade_idrisco_oportunidade->rowAttributes() ?>>
        <label id="elh_plano_acao_risco_oportunidade_idrisco_oportunidade" for="x_risco_oportunidade_idrisco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->risco_oportunidade_idrisco_oportunidade->caption() ?><?= $Page->risco_oportunidade_idrisco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->risco_oportunidade_idrisco_oportunidade->cellAttributes() ?>>
<?php if ($Page->risco_oportunidade_idrisco_oportunidade->getSessionValue() != "") { ?>
<span<?= $Page->risco_oportunidade_idrisco_oportunidade->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->risco_oportunidade_idrisco_oportunidade->getDisplayValue($Page->risco_oportunidade_idrisco_oportunidade->ViewValue) ?></span></span>
<input type="hidden" id="x_risco_oportunidade_idrisco_oportunidade" name="x_risco_oportunidade_idrisco_oportunidade" value="<?= HtmlEncode($Page->risco_oportunidade_idrisco_oportunidade->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_plano_acao_risco_oportunidade_idrisco_oportunidade">
    <select
        id="x_risco_oportunidade_idrisco_oportunidade"
        name="x_risco_oportunidade_idrisco_oportunidade"
        class="form-select ew-select<?= $Page->risco_oportunidade_idrisco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Page->risco_oportunidade_idrisco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="fplano_acaoedit_x_risco_oportunidade_idrisco_oportunidade"
        <?php } ?>
        data-table="plano_acao"
        data-field="x_risco_oportunidade_idrisco_oportunidade"
        data-value-separator="<?= $Page->risco_oportunidade_idrisco_oportunidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->risco_oportunidade_idrisco_oportunidade->getPlaceHolder()) ?>"
        <?= $Page->risco_oportunidade_idrisco_oportunidade->editAttributes() ?>>
        <?= $Page->risco_oportunidade_idrisco_oportunidade->selectOptionListHtml("x_risco_oportunidade_idrisco_oportunidade") ?>
    </select>
    <?= $Page->risco_oportunidade_idrisco_oportunidade->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->risco_oportunidade_idrisco_oportunidade->getErrorMessage() ?></div>
<?= $Page->risco_oportunidade_idrisco_oportunidade->Lookup->getParamTag($Page, "p_x_risco_oportunidade_idrisco_oportunidade") ?>
<?php if (!$Page->risco_oportunidade_idrisco_oportunidade->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acaoedit", function() {
    var options = { name: "x_risco_oportunidade_idrisco_oportunidade", selectId: "fplano_acaoedit_x_risco_oportunidade_idrisco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaoedit.lists.risco_oportunidade_idrisco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x_risco_oportunidade_idrisco_oportunidade", form: "fplano_acaoedit" };
    } else {
        options.ajax = { id: "x_risco_oportunidade_idrisco_oportunidade", form: "fplano_acaoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.risco_oportunidade_idrisco_oportunidade.selectOptions);
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
        <label id="elh_plano_acao_o_q_sera_feito" for="x_o_q_sera_feito" class="<?= $Page->LeftColumnClass ?>"><?= $Page->o_q_sera_feito->caption() ?><?= $Page->o_q_sera_feito->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->o_q_sera_feito->cellAttributes() ?>>
<span id="el_plano_acao_o_q_sera_feito">
<textarea data-table="plano_acao" data-field="x_o_q_sera_feito" name="x_o_q_sera_feito" id="x_o_q_sera_feito" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->o_q_sera_feito->getPlaceHolder()) ?>"<?= $Page->o_q_sera_feito->editAttributes() ?> aria-describedby="x_o_q_sera_feito_help"><?= $Page->o_q_sera_feito->EditValue ?></textarea>
<?= $Page->o_q_sera_feito->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->o_q_sera_feito->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
    <div id="r_efeito_esperado"<?= $Page->efeito_esperado->rowAttributes() ?>>
        <label id="elh_plano_acao_efeito_esperado" for="x_efeito_esperado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->efeito_esperado->caption() ?><?= $Page->efeito_esperado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->efeito_esperado->cellAttributes() ?>>
<span id="el_plano_acao_efeito_esperado">
<textarea data-table="plano_acao" data-field="x_efeito_esperado" name="x_efeito_esperado" id="x_efeito_esperado" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->efeito_esperado->getPlaceHolder()) ?>"<?= $Page->efeito_esperado->editAttributes() ?> aria-describedby="x_efeito_esperado_help"><?= $Page->efeito_esperado->EditValue ?></textarea>
<?= $Page->efeito_esperado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->efeito_esperado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <div id="r_departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <label id="elh_plano_acao_departamentos_iddepartamentos" for="x_departamentos_iddepartamentos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->departamentos_iddepartamentos->caption() ?><?= $Page->departamentos_iddepartamentos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el_plano_acao_departamentos_iddepartamentos">
    <select
        id="x_departamentos_iddepartamentos"
        name="x_departamentos_iddepartamentos"
        class="form-select ew-select<?= $Page->departamentos_iddepartamentos->isInvalidClass() ?>"
        <?php if (!$Page->departamentos_iddepartamentos->IsNativeSelect) { ?>
        data-select2-id="fplano_acaoedit_x_departamentos_iddepartamentos"
        <?php } ?>
        data-table="plano_acao"
        data-field="x_departamentos_iddepartamentos"
        data-value-separator="<?= $Page->departamentos_iddepartamentos->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->departamentos_iddepartamentos->getPlaceHolder()) ?>"
        <?= $Page->departamentos_iddepartamentos->editAttributes() ?>>
        <?= $Page->departamentos_iddepartamentos->selectOptionListHtml("x_departamentos_iddepartamentos") ?>
    </select>
    <?= $Page->departamentos_iddepartamentos->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->departamentos_iddepartamentos->getErrorMessage() ?></div>
<?= $Page->departamentos_iddepartamentos->Lookup->getParamTag($Page, "p_x_departamentos_iddepartamentos") ?>
<?php if (!$Page->departamentos_iddepartamentos->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acaoedit", function() {
    var options = { name: "x_departamentos_iddepartamentos", selectId: "fplano_acaoedit_x_departamentos_iddepartamentos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaoedit.lists.departamentos_iddepartamentos?.lookupOptions.length) {
        options.data = { id: "x_departamentos_iddepartamentos", form: "fplano_acaoedit" };
    } else {
        options.ajax = { id: "x_departamentos_iddepartamentos", form: "fplano_acaoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.departamentos_iddepartamentos.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <div id="r_origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
        <label id="elh_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade" for="x_origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade">
    <select
        id="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        name="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        class="form-select ew-select<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Page->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="fplano_acaoedit_x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        <?php } ?>
        data-table="plano_acao"
        data-field="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        data-value-separator="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getPlaceHolder()) ?>"
        <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->editAttributes() ?>>
        <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->selectOptionListHtml("x_origem_risco_oportunidade_idorigem_risco_oportunidade") ?>
    </select>
    <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getErrorMessage() ?></div>
<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getParamTag($Page, "p_x_origem_risco_oportunidade_idorigem_risco_oportunidade") ?>
<?php if (!$Page->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acaoedit", function() {
    var options = { name: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", selectId: "fplano_acaoedit_x_origem_risco_oportunidade_idorigem_risco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaoedit.lists.origem_risco_oportunidade_idorigem_risco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fplano_acaoedit" };
    } else {
        options.ajax = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fplano_acaoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
    <div id="r_recursos_nec"<?= $Page->recursos_nec->rowAttributes() ?>>
        <label id="elh_plano_acao_recursos_nec" for="x_recursos_nec" class="<?= $Page->LeftColumnClass ?>"><?= $Page->recursos_nec->caption() ?><?= $Page->recursos_nec->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->recursos_nec->cellAttributes() ?>>
<span id="el_plano_acao_recursos_nec">
<input type="<?= $Page->recursos_nec->getInputTextType() ?>" name="x_recursos_nec" id="x_recursos_nec" data-table="plano_acao" data-field="x_recursos_nec" value="<?= $Page->recursos_nec->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->recursos_nec->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->recursos_nec->formatPattern()) ?>"<?= $Page->recursos_nec->editAttributes() ?> aria-describedby="x_recursos_nec_help">
<?= $Page->recursos_nec->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->recursos_nec->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
    <div id="r_dt_limite"<?= $Page->dt_limite->rowAttributes() ?>>
        <label id="elh_plano_acao_dt_limite" for="x_dt_limite" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dt_limite->caption() ?><?= $Page->dt_limite->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dt_limite->cellAttributes() ?>>
<span id="el_plano_acao_dt_limite">
<input type="<?= $Page->dt_limite->getInputTextType() ?>" name="x_dt_limite" id="x_dt_limite" data-table="plano_acao" data-field="x_dt_limite" value="<?= $Page->dt_limite->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_limite->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_limite->formatPattern()) ?>"<?= $Page->dt_limite->editAttributes() ?> aria-describedby="x_dt_limite_help">
<?= $Page->dt_limite->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dt_limite->getErrorMessage() ?></div>
<?php if (!$Page->dt_limite->ReadOnly && !$Page->dt_limite->Disabled && !isset($Page->dt_limite->EditAttrs["readonly"]) && !isset($Page->dt_limite->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplano_acaoedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fplano_acaoedit", "x_dt_limite", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
    <div id="r_implementado"<?= $Page->implementado->rowAttributes() ?>>
        <label id="elh_plano_acao_implementado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->implementado->caption() ?><?= $Page->implementado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->implementado->cellAttributes() ?>>
<span id="el_plano_acao_implementado">
<template id="tp_x_implementado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao" data-field="x_implementado" name="x_implementado" id="x_implementado"<?= $Page->implementado->editAttributes() ?>>
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
    data-table="plano_acao"
    data-field="x_implementado"
    data-value-separator="<?= $Page->implementado->displayValueSeparatorAttribute() ?>"
    <?= $Page->implementado->editAttributes() ?>></selection-list>
<?= $Page->implementado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->implementado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
    <div id="r_periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->rowAttributes() ?>>
        <label id="elh_plano_acao_periodicidade_idperiodicidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periodicidade_idperiodicidade->caption() ?><?= $Page->periodicidade_idperiodicidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periodicidade_idperiodicidade->cellAttributes() ?>>
<span id="el_plano_acao_periodicidade_idperiodicidade">
<template id="tp_x_periodicidade_idperiodicidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao" data-field="x_periodicidade_idperiodicidade" name="x_periodicidade_idperiodicidade" id="x_periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_periodicidade_idperiodicidade" class="ew-item-list"></div>
<selection-list hidden
    id="x_periodicidade_idperiodicidade"
    name="x_periodicidade_idperiodicidade"
    value="<?= HtmlEncode($Page->periodicidade_idperiodicidade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_periodicidade_idperiodicidade"
    data-target="dsl_x_periodicidade_idperiodicidade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodicidade_idperiodicidade->isInvalidClass() ?>"
    data-table="plano_acao"
    data-field="x_periodicidade_idperiodicidade"
    data-value-separator="<?= $Page->periodicidade_idperiodicidade->displayValueSeparatorAttribute() ?>"
    <?= $Page->periodicidade_idperiodicidade->editAttributes() ?>></selection-list>
<?= $Page->periodicidade_idperiodicidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->periodicidade_idperiodicidade->getErrorMessage() ?></div>
<?= $Page->periodicidade_idperiodicidade->Lookup->getParamTag($Page, "p_x_periodicidade_idperiodicidade") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
    <div id="r_eficaz"<?= $Page->eficaz->rowAttributes() ?>>
        <label id="elh_plano_acao_eficaz" class="<?= $Page->LeftColumnClass ?>"><?= $Page->eficaz->caption() ?><?= $Page->eficaz->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->eficaz->cellAttributes() ?>>
<span id="el_plano_acao_eficaz">
<template id="tp_x_eficaz">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="plano_acao" data-field="x_eficaz" name="x_eficaz" id="x_eficaz"<?= $Page->eficaz->editAttributes() ?>>
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
    data-table="plano_acao"
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fplano_acaoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fplano_acaoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("plano_acao");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
