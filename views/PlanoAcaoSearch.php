<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAcaoSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_acao: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fplano_acaosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fplano_acaosearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idplano_acao", [ew.Validators.integer], fields.idplano_acao.isInvalid],
            ["risco_oportunidade_idrisco_oportunidade", [], fields.risco_oportunidade_idrisco_oportunidade.isInvalid],
            ["dt_cadastro", [ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["o_q_sera_feito", [], fields.o_q_sera_feito.isInvalid],
            ["efeito_esperado", [], fields.efeito_esperado.isInvalid],
            ["departamentos_iddepartamentos", [], fields.departamentos_iddepartamentos.isInvalid],
            ["origem_risco_oportunidade_idorigem_risco_oportunidade", [], fields.origem_risco_oportunidade_idorigem_risco_oportunidade.isInvalid],
            ["recursos_nec", [ew.Validators.float], fields.recursos_nec.isInvalid],
            ["dt_limite", [ew.Validators.datetime(fields.dt_limite.clientFormatPattern)], fields.dt_limite.isInvalid],
            ["implementado", [], fields.implementado.isInvalid],
            ["periodicidade_idperiodicidade", [], fields.periodicidade_idperiodicidade.isInvalid],
            ["eficaz", [], fields.eficaz.isInvalid]
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
            "risco_oportunidade_idrisco_oportunidade": <?= $Page->risco_oportunidade_idrisco_oportunidade->toClientList($Page) ?>,
            "departamentos_iddepartamentos": <?= $Page->departamentos_iddepartamentos->toClientList($Page) ?>,
            "origem_risco_oportunidade_idorigem_risco_oportunidade": <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->toClientList($Page) ?>,
            "implementado": <?= $Page->implementado->toClientList($Page) ?>,
            "periodicidade_idperiodicidade": <?= $Page->periodicidade_idperiodicidade->toClientList($Page) ?>,
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
<form name="fplano_acaosearch" id="fplano_acaosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="plano_acao">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idplano_acao->Visible) { // idplano_acao ?>
    <div id="r_idplano_acao" class="row"<?= $Page->idplano_acao->rowAttributes() ?>>
        <label for="x_idplano_acao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_idplano_acao"><?= $Page->idplano_acao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idplano_acao" id="z_idplano_acao" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idplano_acao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_idplano_acao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idplano_acao->getInputTextType() ?>" name="x_idplano_acao" id="x_idplano_acao" data-table="plano_acao" data-field="x_idplano_acao" value="<?= $Page->idplano_acao->EditValue ?>" placeholder="<?= HtmlEncode($Page->idplano_acao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idplano_acao->formatPattern()) ?>"<?= $Page->idplano_acao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idplano_acao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
    <div id="r_risco_oportunidade_idrisco_oportunidade" class="row"<?= $Page->risco_oportunidade_idrisco_oportunidade->rowAttributes() ?>>
        <label for="x_risco_oportunidade_idrisco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_risco_oportunidade_idrisco_oportunidade"><?= $Page->risco_oportunidade_idrisco_oportunidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_risco_oportunidade_idrisco_oportunidade" id="z_risco_oportunidade_idrisco_oportunidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->risco_oportunidade_idrisco_oportunidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_risco_oportunidade_idrisco_oportunidade" class="ew-search-field ew-search-field-single">
    <select
        id="x_risco_oportunidade_idrisco_oportunidade"
        name="x_risco_oportunidade_idrisco_oportunidade"
        class="form-select ew-select<?= $Page->risco_oportunidade_idrisco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Page->risco_oportunidade_idrisco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="fplano_acaosearch_x_risco_oportunidade_idrisco_oportunidade"
        <?php } ?>
        data-table="plano_acao"
        data-field="x_risco_oportunidade_idrisco_oportunidade"
        data-value-separator="<?= $Page->risco_oportunidade_idrisco_oportunidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->risco_oportunidade_idrisco_oportunidade->getPlaceHolder()) ?>"
        <?= $Page->risco_oportunidade_idrisco_oportunidade->editAttributes() ?>>
        <?= $Page->risco_oportunidade_idrisco_oportunidade->selectOptionListHtml("x_risco_oportunidade_idrisco_oportunidade") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->risco_oportunidade_idrisco_oportunidade->getErrorMessage(false) ?></div>
<?= $Page->risco_oportunidade_idrisco_oportunidade->Lookup->getParamTag($Page, "p_x_risco_oportunidade_idrisco_oportunidade") ?>
<?php if (!$Page->risco_oportunidade_idrisco_oportunidade->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acaosearch", function() {
    var options = { name: "x_risco_oportunidade_idrisco_oportunidade", selectId: "fplano_acaosearch_x_risco_oportunidade_idrisco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaosearch.lists.risco_oportunidade_idrisco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x_risco_oportunidade_idrisco_oportunidade", form: "fplano_acaosearch" };
    } else {
        options.ajax = { id: "x_risco_oportunidade_idrisco_oportunidade", form: "fplano_acaosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.risco_oportunidade_idrisco_oportunidade.selectOptions);
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
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro" class="row"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_cadastro" id="z_dt_cadastro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_cadastro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_dt_cadastro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="plano_acao" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplano_acaosearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fplano_acaosearch", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
        <label for="x_o_q_sera_feito" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_o_q_sera_feito"><?= $Page->o_q_sera_feito->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_o_q_sera_feito" id="z_o_q_sera_feito" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->o_q_sera_feito->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_o_q_sera_feito" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->o_q_sera_feito->getInputTextType() ?>" name="x_o_q_sera_feito" id="x_o_q_sera_feito" data-table="plano_acao" data-field="x_o_q_sera_feito" value="<?= $Page->o_q_sera_feito->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->o_q_sera_feito->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->o_q_sera_feito->formatPattern()) ?>"<?= $Page->o_q_sera_feito->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->o_q_sera_feito->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
    <div id="r_efeito_esperado" class="row"<?= $Page->efeito_esperado->rowAttributes() ?>>
        <label for="x_efeito_esperado" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_efeito_esperado"><?= $Page->efeito_esperado->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_efeito_esperado" id="z_efeito_esperado" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->efeito_esperado->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_efeito_esperado" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->efeito_esperado->getInputTextType() ?>" name="x_efeito_esperado" id="x_efeito_esperado" data-table="plano_acao" data-field="x_efeito_esperado" value="<?= $Page->efeito_esperado->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->efeito_esperado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->efeito_esperado->formatPattern()) ?>"<?= $Page->efeito_esperado->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->efeito_esperado->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <div id="r_departamentos_iddepartamentos" class="row"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <label for="x_departamentos_iddepartamentos" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_departamentos_iddepartamentos"><?= $Page->departamentos_iddepartamentos->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_departamentos_iddepartamentos" id="z_departamentos_iddepartamentos" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_departamentos_iddepartamentos" class="ew-search-field ew-search-field-single">
    <select
        id="x_departamentos_iddepartamentos"
        name="x_departamentos_iddepartamentos"
        class="form-select ew-select<?= $Page->departamentos_iddepartamentos->isInvalidClass() ?>"
        <?php if (!$Page->departamentos_iddepartamentos->IsNativeSelect) { ?>
        data-select2-id="fplano_acaosearch_x_departamentos_iddepartamentos"
        <?php } ?>
        data-table="plano_acao"
        data-field="x_departamentos_iddepartamentos"
        data-value-separator="<?= $Page->departamentos_iddepartamentos->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->departamentos_iddepartamentos->getPlaceHolder()) ?>"
        <?= $Page->departamentos_iddepartamentos->editAttributes() ?>>
        <?= $Page->departamentos_iddepartamentos->selectOptionListHtml("x_departamentos_iddepartamentos") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->departamentos_iddepartamentos->getErrorMessage(false) ?></div>
<?= $Page->departamentos_iddepartamentos->Lookup->getParamTag($Page, "p_x_departamentos_iddepartamentos") ?>
<?php if (!$Page->departamentos_iddepartamentos->IsNativeSelect) { ?>
<script>
loadjs.ready("fplano_acaosearch", function() {
    var options = { name: "x_departamentos_iddepartamentos", selectId: "fplano_acaosearch_x_departamentos_iddepartamentos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaosearch.lists.departamentos_iddepartamentos?.lookupOptions.length) {
        options.data = { id: "x_departamentos_iddepartamentos", form: "fplano_acaosearch" };
    } else {
        options.ajax = { id: "x_departamentos_iddepartamentos", form: "fplano_acaosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.departamentos_iddepartamentos.selectOptions);
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
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <div id="r_origem_risco_oportunidade_idorigem_risco_oportunidade" class="row"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
        <label for="x_origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_origem_risco_oportunidade_idorigem_risco_oportunidade" id="z_origem_risco_oportunidade_idorigem_risco_oportunidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_origem_risco_oportunidade_idorigem_risco_oportunidade" class="ew-search-field ew-search-field-single">
    <select
        id="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        name="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        class="form-select ew-select<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Page->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="fplano_acaosearch_x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        <?php } ?>
        data-table="plano_acao"
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
loadjs.ready("fplano_acaosearch", function() {
    var options = { name: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", selectId: "fplano_acaosearch_x_origem_risco_oportunidade_idorigem_risco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fplano_acaosearch.lists.origem_risco_oportunidade_idorigem_risco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fplano_acaosearch" };
    } else {
        options.ajax = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fplano_acaosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.plano_acao.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.selectOptions);
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
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
    <div id="r_recursos_nec" class="row"<?= $Page->recursos_nec->rowAttributes() ?>>
        <label for="x_recursos_nec" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_recursos_nec"><?= $Page->recursos_nec->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_recursos_nec" id="z_recursos_nec" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->recursos_nec->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_recursos_nec" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->recursos_nec->getInputTextType() ?>" name="x_recursos_nec" id="x_recursos_nec" data-table="plano_acao" data-field="x_recursos_nec" value="<?= $Page->recursos_nec->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->recursos_nec->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->recursos_nec->formatPattern()) ?>"<?= $Page->recursos_nec->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->recursos_nec->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
    <div id="r_dt_limite" class="row"<?= $Page->dt_limite->rowAttributes() ?>>
        <label for="x_dt_limite" class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_dt_limite"><?= $Page->dt_limite->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_limite" id="z_dt_limite" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_limite->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_dt_limite" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_limite->getInputTextType() ?>" name="x_dt_limite" id="x_dt_limite" data-table="plano_acao" data-field="x_dt_limite" value="<?= $Page->dt_limite->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_limite->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_limite->formatPattern()) ?>"<?= $Page->dt_limite->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_limite->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_limite->ReadOnly && !$Page->dt_limite->Disabled && !isset($Page->dt_limite->EditAttrs["readonly"]) && !isset($Page->dt_limite->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplano_acaosearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fplano_acaosearch", "x_dt_limite", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_implementado"><?= $Page->implementado->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_implementado" id="z_implementado" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->implementado->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_implementado" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->implementado->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_implementado"
    data-target="dsl_x_implementado"
    data-repeatcolumn="5"
    class="form-control<?= $Page->implementado->isInvalidClass() ?>"
    data-table="plano_acao"
    data-field="x_implementado"
    data-value-separator="<?= $Page->implementado->displayValueSeparatorAttribute() ?>"
    <?= $Page->implementado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->implementado->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
    <div id="r_periodicidade_idperiodicidade" class="row"<?= $Page->periodicidade_idperiodicidade->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_periodicidade_idperiodicidade"><?= $Page->periodicidade_idperiodicidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_periodicidade_idperiodicidade" id="z_periodicidade_idperiodicidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->periodicidade_idperiodicidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_periodicidade_idperiodicidade" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->periodicidade_idperiodicidade->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_periodicidade_idperiodicidade"
    data-target="dsl_x_periodicidade_idperiodicidade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodicidade_idperiodicidade->isInvalidClass() ?>"
    data-table="plano_acao"
    data-field="x_periodicidade_idperiodicidade"
    data-value-separator="<?= $Page->periodicidade_idperiodicidade->displayValueSeparatorAttribute() ?>"
    <?= $Page->periodicidade_idperiodicidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->periodicidade_idperiodicidade->getErrorMessage(false) ?></div>
<?= $Page->periodicidade_idperiodicidade->Lookup->getParamTag($Page, "p_x_periodicidade_idperiodicidade") ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
    <div id="r_eficaz" class="row"<?= $Page->eficaz->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_plano_acao_eficaz"><?= $Page->eficaz->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_eficaz" id="z_eficaz" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->eficaz->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_plano_acao_eficaz" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->eficaz->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_eficaz"
    data-target="dsl_x_eficaz"
    data-repeatcolumn="5"
    class="form-control<?= $Page->eficaz->isInvalidClass() ?>"
    data-table="plano_acao"
    data-field="x_eficaz"
    data-value-separator="<?= $Page->eficaz->displayValueSeparatorAttribute() ?>"
    <?= $Page->eficaz->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->eficaz->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fplano_acaosearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fplano_acaosearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fplano_acaosearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("plano_acao");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
