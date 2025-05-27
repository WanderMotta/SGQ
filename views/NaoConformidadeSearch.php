<?php

namespace PHPMaker2024\sgq;

// Page object
$NaoConformidadeSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { nao_conformidade: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fnao_conformidadesearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fnao_conformidadesearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idnao_conformidade", [ew.Validators.integer], fields.idnao_conformidade.isInvalid],
            ["dt_ocorrencia", [ew.Validators.datetime(fields.dt_ocorrencia.clientFormatPattern)], fields.dt_ocorrencia.isInvalid],
            ["tipo", [], fields.tipo.isInvalid],
            ["titulo", [], fields.titulo.isInvalid],
            ["processo_idprocesso", [], fields.processo_idprocesso.isInvalid],
            ["ocorrencia", [], fields.ocorrencia.isInvalid],
            ["origem_risco_oportunidade_idorigem_risco_oportunidade", [], fields.origem_risco_oportunidade_idorigem_risco_oportunidade.isInvalid],
            ["acao_imediata", [], fields.acao_imediata.isInvalid],
            ["causa_raiz", [], fields.causa_raiz.isInvalid],
            ["departamentos_iddepartamentos", [], fields.departamentos_iddepartamentos.isInvalid],
            ["anexo", [], fields.anexo.isInvalid],
            ["status_nc", [], fields.status_nc.isInvalid],
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
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
            "processo_idprocesso": <?= $Page->processo_idprocesso->toClientList($Page) ?>,
            "origem_risco_oportunidade_idorigem_risco_oportunidade": <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->toClientList($Page) ?>,
            "departamentos_iddepartamentos": <?= $Page->departamentos_iddepartamentos->toClientList($Page) ?>,
            "status_nc": <?= $Page->status_nc->toClientList($Page) ?>,
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
<form name="fnao_conformidadesearch" id="fnao_conformidadesearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="nao_conformidade">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idnao_conformidade->Visible) { // idnao_conformidade ?>
    <div id="r_idnao_conformidade" class="row"<?= $Page->idnao_conformidade->rowAttributes() ?>>
        <label for="x_idnao_conformidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_idnao_conformidade"><?= $Page->idnao_conformidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idnao_conformidade" id="z_idnao_conformidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idnao_conformidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_idnao_conformidade" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idnao_conformidade->getInputTextType() ?>" name="x_idnao_conformidade" id="x_idnao_conformidade" data-table="nao_conformidade" data-field="x_idnao_conformidade" value="<?= $Page->idnao_conformidade->EditValue ?>" placeholder="<?= HtmlEncode($Page->idnao_conformidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idnao_conformidade->formatPattern()) ?>"<?= $Page->idnao_conformidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idnao_conformidade->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_ocorrencia->Visible) { // dt_ocorrencia ?>
    <div id="r_dt_ocorrencia" class="row"<?= $Page->dt_ocorrencia->rowAttributes() ?>>
        <label for="x_dt_ocorrencia" class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_dt_ocorrencia"><?= $Page->dt_ocorrencia->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_ocorrencia" id="z_dt_ocorrencia" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_ocorrencia->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_dt_ocorrencia" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_ocorrencia->getInputTextType() ?>" name="x_dt_ocorrencia" id="x_dt_ocorrencia" data-table="nao_conformidade" data-field="x_dt_ocorrencia" value="<?= $Page->dt_ocorrencia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_ocorrencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_ocorrencia->formatPattern()) ?>"<?= $Page->dt_ocorrencia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_ocorrencia->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_ocorrencia->ReadOnly && !$Page->dt_ocorrencia->Disabled && !isset($Page->dt_ocorrencia->EditAttrs["readonly"]) && !isset($Page->dt_ocorrencia->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnao_conformidadesearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fnao_conformidadesearch", "x_dt_ocorrencia", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo" class="row"<?= $Page->tipo->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_tipo"><?= $Page->tipo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_tipo" id="z_tipo" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->tipo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_tipo" class="ew-search-field ew-search-field-single">
<template id="tp_x_tipo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="nao_conformidade" data-field="x_tipo" name="x_tipo" id="x_tipo"<?= $Page->tipo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tipo" class="ew-item-list"></div>
<selection-list hidden
    id="x_tipo"
    name="x_tipo"
    value="<?= HtmlEncode($Page->tipo->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo"
    data-target="dsl_x_tipo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo->isInvalidClass() ?>"
    data-table="nao_conformidade"
    data-field="x_tipo"
    data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->tipo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <div id="r_titulo" class="row"<?= $Page->titulo->rowAttributes() ?>>
        <label for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_titulo"><?= $Page->titulo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_titulo" id="z_titulo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->titulo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_titulo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->titulo->getInputTextType() ?>" name="x_titulo" id="x_titulo" data-table="nao_conformidade" data-field="x_titulo" value="<?= $Page->titulo->EditValue ?>" size="45" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo->formatPattern()) ?>"<?= $Page->titulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <div id="r_processo_idprocesso" class="row"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <label for="x_processo_idprocesso" class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_processo_idprocesso" id="z_processo_idprocesso" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->processo_idprocesso->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_processo_idprocesso" class="ew-search-field ew-search-field-single">
    <select
        id="x_processo_idprocesso"
        name="x_processo_idprocesso"
        class="form-control ew-select<?= $Page->processo_idprocesso->isInvalidClass() ?>"
        data-select2-id="fnao_conformidadesearch_x_processo_idprocesso"
        data-table="nao_conformidade"
        data-field="x_processo_idprocesso"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->processo_idprocesso->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->processo_idprocesso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->processo_idprocesso->getPlaceHolder()) ?>"
        <?= $Page->processo_idprocesso->editAttributes() ?>>
        <?= $Page->processo_idprocesso->selectOptionListHtml("x_processo_idprocesso") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->processo_idprocesso->getErrorMessage(false) ?></div>
<?= $Page->processo_idprocesso->Lookup->getParamTag($Page, "p_x_processo_idprocesso") ?>
<script>
loadjs.ready("fnao_conformidadesearch", function() {
    var options = { name: "x_processo_idprocesso", selectId: "fnao_conformidadesearch_x_processo_idprocesso" };
    if (fnao_conformidadesearch.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x_processo_idprocesso", form: "fnao_conformidadesearch" };
    } else {
        options.ajax = { id: "x_processo_idprocesso", form: "fnao_conformidadesearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.nao_conformidade.fields.processo_idprocesso.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->ocorrencia->Visible) { // ocorrencia ?>
    <div id="r_ocorrencia" class="row"<?= $Page->ocorrencia->rowAttributes() ?>>
        <label for="x_ocorrencia" class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_ocorrencia"><?= $Page->ocorrencia->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_ocorrencia" id="z_ocorrencia" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->ocorrencia->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_ocorrencia" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ocorrencia->getInputTextType() ?>" name="x_ocorrencia" id="x_ocorrencia" data-table="nao_conformidade" data-field="x_ocorrencia" value="<?= $Page->ocorrencia->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->ocorrencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ocorrencia->formatPattern()) ?>"<?= $Page->ocorrencia->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ocorrencia->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <div id="r_origem_risco_oportunidade_idorigem_risco_oportunidade" class="row"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
        <label for="x_origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_origem_risco_oportunidade_idorigem_risco_oportunidade" id="z_origem_risco_oportunidade_idorigem_risco_oportunidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_origem_risco_oportunidade_idorigem_risco_oportunidade" class="ew-search-field ew-search-field-single">
    <select
        id="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        name="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        class="form-select ew-select<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Page->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="fnao_conformidadesearch_x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        <?php } ?>
        data-table="nao_conformidade"
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
loadjs.ready("fnao_conformidadesearch", function() {
    var options = { name: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", selectId: "fnao_conformidadesearch_x_origem_risco_oportunidade_idorigem_risco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fnao_conformidadesearch.lists.origem_risco_oportunidade_idorigem_risco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fnao_conformidadesearch" };
    } else {
        options.ajax = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fnao_conformidadesearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.nao_conformidade.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.selectOptions);
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
<?php if ($Page->acao_imediata->Visible) { // acao_imediata ?>
    <div id="r_acao_imediata" class="row"<?= $Page->acao_imediata->rowAttributes() ?>>
        <label for="x_acao_imediata" class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_acao_imediata"><?= $Page->acao_imediata->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_acao_imediata" id="z_acao_imediata" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->acao_imediata->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_acao_imediata" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->acao_imediata->getInputTextType() ?>" name="x_acao_imediata" id="x_acao_imediata" data-table="nao_conformidade" data-field="x_acao_imediata" value="<?= $Page->acao_imediata->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->acao_imediata->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->acao_imediata->formatPattern()) ?>"<?= $Page->acao_imediata->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->acao_imediata->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->causa_raiz->Visible) { // causa_raiz ?>
    <div id="r_causa_raiz" class="row"<?= $Page->causa_raiz->rowAttributes() ?>>
        <label for="x_causa_raiz" class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_causa_raiz"><?= $Page->causa_raiz->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_causa_raiz" id="z_causa_raiz" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->causa_raiz->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_causa_raiz" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->causa_raiz->getInputTextType() ?>" name="x_causa_raiz" id="x_causa_raiz" data-table="nao_conformidade" data-field="x_causa_raiz" value="<?= $Page->causa_raiz->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->causa_raiz->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->causa_raiz->formatPattern()) ?>"<?= $Page->causa_raiz->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->causa_raiz->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <div id="r_departamentos_iddepartamentos" class="row"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <label for="x_departamentos_iddepartamentos" class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_departamentos_iddepartamentos"><?= $Page->departamentos_iddepartamentos->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_departamentos_iddepartamentos" id="z_departamentos_iddepartamentos" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_departamentos_iddepartamentos" class="ew-search-field ew-search-field-single">
    <select
        id="x_departamentos_iddepartamentos"
        name="x_departamentos_iddepartamentos"
        class="form-select ew-select<?= $Page->departamentos_iddepartamentos->isInvalidClass() ?>"
        <?php if (!$Page->departamentos_iddepartamentos->IsNativeSelect) { ?>
        data-select2-id="fnao_conformidadesearch_x_departamentos_iddepartamentos"
        <?php } ?>
        data-table="nao_conformidade"
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
loadjs.ready("fnao_conformidadesearch", function() {
    var options = { name: "x_departamentos_iddepartamentos", selectId: "fnao_conformidadesearch_x_departamentos_iddepartamentos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fnao_conformidadesearch.lists.departamentos_iddepartamentos?.lookupOptions.length) {
        options.data = { id: "x_departamentos_iddepartamentos", form: "fnao_conformidadesearch" };
    } else {
        options.ajax = { id: "x_departamentos_iddepartamentos", form: "fnao_conformidadesearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.nao_conformidade.fields.departamentos_iddepartamentos.selectOptions);
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
<?php if ($Page->anexo->Visible) { // anexo ?>
    <div id="r_anexo" class="row"<?= $Page->anexo->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_anexo"><?= $Page->anexo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_anexo" id="z_anexo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->anexo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_anexo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->anexo->getInputTextType() ?>" name="x_anexo" id="x_anexo" data-table="nao_conformidade" data-field="x_anexo" value="<?= $Page->anexo->EditValue ?>" size="50" maxlength="120" placeholder="<?= HtmlEncode($Page->anexo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->anexo->formatPattern()) ?>"<?= $Page->anexo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->anexo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->status_nc->Visible) { // status_nc ?>
    <div id="r_status_nc" class="row"<?= $Page->status_nc->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_status_nc"><?= $Page->status_nc->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status_nc" id="z_status_nc" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->status_nc->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_status_nc" class="ew-search-field ew-search-field-single">
<template id="tp_x_status_nc">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="nao_conformidade" data-field="x_status_nc" name="x_status_nc" id="x_status_nc"<?= $Page->status_nc->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status_nc" class="ew-item-list"></div>
<selection-list hidden
    id="x_status_nc"
    name="x_status_nc"
    value="<?= HtmlEncode($Page->status_nc->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_status_nc"
    data-target="dsl_x_status_nc"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status_nc->isInvalidClass() ?>"
    data-table="nao_conformidade"
    data-field="x_status_nc"
    data-value-separator="<?= $Page->status_nc->displayValueSeparatorAttribute() ?>"
    <?= $Page->status_nc->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->status_nc->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { // plano_acao ?>
    <div id="r_plano_acao" class="row"<?= $Page->plano_acao->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_nao_conformidade_plano_acao"><?= $Page->plano_acao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_plano_acao" id="z_plano_acao" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->plano_acao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_nao_conformidade_plano_acao" class="ew-search-field ew-search-field-single">
<template id="tp_x_plano_acao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="nao_conformidade" data-field="x_plano_acao" name="x_plano_acao" id="x_plano_acao"<?= $Page->plano_acao->editAttributes() ?>>
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
    data-table="nao_conformidade"
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
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fnao_conformidadesearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fnao_conformidadesearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fnao_conformidadesearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("nao_conformidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
