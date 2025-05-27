<?php

namespace PHPMaker2024\sgq;

// Page object
$NaoConformidadeEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fnao_conformidadeedit" id="fnao_conformidadeedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { nao_conformidade: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fnao_conformidadeedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fnao_conformidadeedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idnao_conformidade", [fields.idnao_conformidade.visible && fields.idnao_conformidade.required ? ew.Validators.required(fields.idnao_conformidade.caption) : null], fields.idnao_conformidade.isInvalid],
            ["dt_ocorrencia", [fields.dt_ocorrencia.visible && fields.dt_ocorrencia.required ? ew.Validators.required(fields.dt_ocorrencia.caption) : null, ew.Validators.datetime(fields.dt_ocorrencia.clientFormatPattern)], fields.dt_ocorrencia.isInvalid],
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["titulo", [fields.titulo.visible && fields.titulo.required ? ew.Validators.required(fields.titulo.caption) : null], fields.titulo.isInvalid],
            ["processo_idprocesso", [fields.processo_idprocesso.visible && fields.processo_idprocesso.required ? ew.Validators.required(fields.processo_idprocesso.caption) : null], fields.processo_idprocesso.isInvalid],
            ["ocorrencia", [fields.ocorrencia.visible && fields.ocorrencia.required ? ew.Validators.required(fields.ocorrencia.caption) : null], fields.ocorrencia.isInvalid],
            ["origem_risco_oportunidade_idorigem_risco_oportunidade", [fields.origem_risco_oportunidade_idorigem_risco_oportunidade.visible && fields.origem_risco_oportunidade_idorigem_risco_oportunidade.required ? ew.Validators.required(fields.origem_risco_oportunidade_idorigem_risco_oportunidade.caption) : null], fields.origem_risco_oportunidade_idorigem_risco_oportunidade.isInvalid],
            ["acao_imediata", [fields.acao_imediata.visible && fields.acao_imediata.required ? ew.Validators.required(fields.acao_imediata.caption) : null], fields.acao_imediata.isInvalid],
            ["causa_raiz", [fields.causa_raiz.visible && fields.causa_raiz.required ? ew.Validators.required(fields.causa_raiz.caption) : null], fields.causa_raiz.isInvalid],
            ["departamentos_iddepartamentos", [fields.departamentos_iddepartamentos.visible && fields.departamentos_iddepartamentos.required ? ew.Validators.required(fields.departamentos_iddepartamentos.caption) : null], fields.departamentos_iddepartamentos.isInvalid],
            ["anexo", [fields.anexo.visible && fields.anexo.required ? ew.Validators.fileRequired(fields.anexo.caption) : null], fields.anexo.isInvalid],
            ["status_nc", [fields.status_nc.visible && fields.status_nc.required ? ew.Validators.required(fields.status_nc.caption) : null], fields.status_nc.isInvalid],
            ["plano_acao", [fields.plano_acao.visible && fields.plano_acao.required ? ew.Validators.required(fields.plano_acao.caption) : null], fields.plano_acao.isInvalid]
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
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
            "processo_idprocesso": <?= $Page->processo_idprocesso->toClientList($Page) ?>,
            "origem_risco_oportunidade_idorigem_risco_oportunidade": <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->toClientList($Page) ?>,
            "departamentos_iddepartamentos": <?= $Page->departamentos_iddepartamentos->toClientList($Page) ?>,
            "status_nc": <?= $Page->status_nc->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="nao_conformidade">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idnao_conformidade->Visible) { // idnao_conformidade ?>
    <div id="r_idnao_conformidade"<?= $Page->idnao_conformidade->rowAttributes() ?>>
        <label id="elh_nao_conformidade_idnao_conformidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnao_conformidade->caption() ?><?= $Page->idnao_conformidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idnao_conformidade->cellAttributes() ?>>
<span id="el_nao_conformidade_idnao_conformidade">
<span<?= $Page->idnao_conformidade->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idnao_conformidade->getDisplayValue($Page->idnao_conformidade->EditValue))) ?>"></span>
<input type="hidden" data-table="nao_conformidade" data-field="x_idnao_conformidade" data-hidden="1" name="x_idnao_conformidade" id="x_idnao_conformidade" value="<?= HtmlEncode($Page->idnao_conformidade->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dt_ocorrencia->Visible) { // dt_ocorrencia ?>
    <div id="r_dt_ocorrencia"<?= $Page->dt_ocorrencia->rowAttributes() ?>>
        <label id="elh_nao_conformidade_dt_ocorrencia" for="x_dt_ocorrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dt_ocorrencia->caption() ?><?= $Page->dt_ocorrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dt_ocorrencia->cellAttributes() ?>>
<span id="el_nao_conformidade_dt_ocorrencia">
<input type="<?= $Page->dt_ocorrencia->getInputTextType() ?>" name="x_dt_ocorrencia" id="x_dt_ocorrencia" data-table="nao_conformidade" data-field="x_dt_ocorrencia" value="<?= $Page->dt_ocorrencia->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_ocorrencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_ocorrencia->formatPattern()) ?>"<?= $Page->dt_ocorrencia->editAttributes() ?> aria-describedby="x_dt_ocorrencia_help">
<?= $Page->dt_ocorrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dt_ocorrencia->getErrorMessage() ?></div>
<?php if (!$Page->dt_ocorrencia->ReadOnly && !$Page->dt_ocorrencia->Disabled && !isset($Page->dt_ocorrencia->EditAttrs["readonly"]) && !isset($Page->dt_ocorrencia->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnao_conformidadeedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fnao_conformidadeedit", "x_dt_ocorrencia", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_nao_conformidade_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_nao_conformidade_tipo">
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
    value="<?= HtmlEncode($Page->tipo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo"
    data-target="dsl_x_tipo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo->isInvalidClass() ?>"
    data-table="nao_conformidade"
    data-field="x_tipo"
    data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo->editAttributes() ?>></selection-list>
<?= $Page->tipo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <div id="r_titulo"<?= $Page->titulo->rowAttributes() ?>>
        <label id="elh_nao_conformidade_titulo" for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titulo->caption() ?><?= $Page->titulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titulo->cellAttributes() ?>>
<span id="el_nao_conformidade_titulo">
<input type="<?= $Page->titulo->getInputTextType() ?>" name="x_titulo" id="x_titulo" data-table="nao_conformidade" data-field="x_titulo" value="<?= $Page->titulo->EditValue ?>" size="45" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo->formatPattern()) ?>"<?= $Page->titulo->editAttributes() ?> aria-describedby="x_titulo_help">
<?= $Page->titulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <div id="r_processo_idprocesso"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <label id="elh_nao_conformidade_processo_idprocesso" for="x_processo_idprocesso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->processo_idprocesso->caption() ?><?= $Page->processo_idprocesso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el_nao_conformidade_processo_idprocesso">
    <select
        id="x_processo_idprocesso"
        name="x_processo_idprocesso"
        class="form-control ew-select<?= $Page->processo_idprocesso->isInvalidClass() ?>"
        data-select2-id="fnao_conformidadeedit_x_processo_idprocesso"
        data-table="nao_conformidade"
        data-field="x_processo_idprocesso"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->processo_idprocesso->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->processo_idprocesso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->processo_idprocesso->getPlaceHolder()) ?>"
        <?= $Page->processo_idprocesso->editAttributes() ?>>
        <?= $Page->processo_idprocesso->selectOptionListHtml("x_processo_idprocesso") ?>
    </select>
    <?= $Page->processo_idprocesso->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->processo_idprocesso->getErrorMessage() ?></div>
<?= $Page->processo_idprocesso->Lookup->getParamTag($Page, "p_x_processo_idprocesso") ?>
<script>
loadjs.ready("fnao_conformidadeedit", function() {
    var options = { name: "x_processo_idprocesso", selectId: "fnao_conformidadeedit_x_processo_idprocesso" };
    if (fnao_conformidadeedit.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x_processo_idprocesso", form: "fnao_conformidadeedit" };
    } else {
        options.ajax = { id: "x_processo_idprocesso", form: "fnao_conformidadeedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.nao_conformidade.fields.processo_idprocesso.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ocorrencia->Visible) { // ocorrencia ?>
    <div id="r_ocorrencia"<?= $Page->ocorrencia->rowAttributes() ?>>
        <label id="elh_nao_conformidade_ocorrencia" for="x_ocorrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ocorrencia->caption() ?><?= $Page->ocorrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ocorrencia->cellAttributes() ?>>
<span id="el_nao_conformidade_ocorrencia">
<textarea data-table="nao_conformidade" data-field="x_ocorrencia" name="x_ocorrencia" id="x_ocorrencia" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->ocorrencia->getPlaceHolder()) ?>"<?= $Page->ocorrencia->editAttributes() ?> aria-describedby="x_ocorrencia_help"><?= $Page->ocorrencia->EditValue ?></textarea>
<?= $Page->ocorrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ocorrencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <div id="r_origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
        <label id="elh_nao_conformidade_origem_risco_oportunidade_idorigem_risco_oportunidade" for="x_origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el_nao_conformidade_origem_risco_oportunidade_idorigem_risco_oportunidade">
    <select
        id="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        name="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        class="form-select ew-select<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Page->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="fnao_conformidadeedit_x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        <?php } ?>
        data-table="nao_conformidade"
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
loadjs.ready("fnao_conformidadeedit", function() {
    var options = { name: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", selectId: "fnao_conformidadeedit_x_origem_risco_oportunidade_idorigem_risco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fnao_conformidadeedit.lists.origem_risco_oportunidade_idorigem_risco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fnao_conformidadeedit" };
    } else {
        options.ajax = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fnao_conformidadeedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.nao_conformidade.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->acao_imediata->Visible) { // acao_imediata ?>
    <div id="r_acao_imediata"<?= $Page->acao_imediata->rowAttributes() ?>>
        <label id="elh_nao_conformidade_acao_imediata" for="x_acao_imediata" class="<?= $Page->LeftColumnClass ?>"><?= $Page->acao_imediata->caption() ?><?= $Page->acao_imediata->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->acao_imediata->cellAttributes() ?>>
<span id="el_nao_conformidade_acao_imediata">
<textarea data-table="nao_conformidade" data-field="x_acao_imediata" name="x_acao_imediata" id="x_acao_imediata" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->acao_imediata->getPlaceHolder()) ?>"<?= $Page->acao_imediata->editAttributes() ?> aria-describedby="x_acao_imediata_help"><?= $Page->acao_imediata->EditValue ?></textarea>
<?= $Page->acao_imediata->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->acao_imediata->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->causa_raiz->Visible) { // causa_raiz ?>
    <div id="r_causa_raiz"<?= $Page->causa_raiz->rowAttributes() ?>>
        <label id="elh_nao_conformidade_causa_raiz" for="x_causa_raiz" class="<?= $Page->LeftColumnClass ?>"><?= $Page->causa_raiz->caption() ?><?= $Page->causa_raiz->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->causa_raiz->cellAttributes() ?>>
<span id="el_nao_conformidade_causa_raiz">
<textarea data-table="nao_conformidade" data-field="x_causa_raiz" name="x_causa_raiz" id="x_causa_raiz" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->causa_raiz->getPlaceHolder()) ?>"<?= $Page->causa_raiz->editAttributes() ?> aria-describedby="x_causa_raiz_help"><?= $Page->causa_raiz->EditValue ?></textarea>
<?= $Page->causa_raiz->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->causa_raiz->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <div id="r_departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <label id="elh_nao_conformidade_departamentos_iddepartamentos" for="x_departamentos_iddepartamentos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->departamentos_iddepartamentos->caption() ?><?= $Page->departamentos_iddepartamentos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el_nao_conformidade_departamentos_iddepartamentos">
    <select
        id="x_departamentos_iddepartamentos"
        name="x_departamentos_iddepartamentos"
        class="form-select ew-select<?= $Page->departamentos_iddepartamentos->isInvalidClass() ?>"
        <?php if (!$Page->departamentos_iddepartamentos->IsNativeSelect) { ?>
        data-select2-id="fnao_conformidadeedit_x_departamentos_iddepartamentos"
        <?php } ?>
        data-table="nao_conformidade"
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
loadjs.ready("fnao_conformidadeedit", function() {
    var options = { name: "x_departamentos_iddepartamentos", selectId: "fnao_conformidadeedit_x_departamentos_iddepartamentos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fnao_conformidadeedit.lists.departamentos_iddepartamentos?.lookupOptions.length) {
        options.data = { id: "x_departamentos_iddepartamentos", form: "fnao_conformidadeedit" };
    } else {
        options.ajax = { id: "x_departamentos_iddepartamentos", form: "fnao_conformidadeedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.nao_conformidade.fields.departamentos_iddepartamentos.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
    <div id="r_anexo"<?= $Page->anexo->rowAttributes() ?>>
        <label id="elh_nao_conformidade_anexo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->anexo->caption() ?><?= $Page->anexo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->anexo->cellAttributes() ?>>
<span id="el_nao_conformidade_anexo">
<div id="fd_x_anexo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_anexo"
        name="x_anexo"
        class="form-control ew-file-input"
        title="<?= $Page->anexo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="nao_conformidade"
        data-field="x_anexo"
        data-size="120"
        data-accept-file-types="<?= $Page->anexo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->anexo->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->anexo->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_anexo_help"
        <?= ($Page->anexo->ReadOnly || $Page->anexo->Disabled) ? " disabled" : "" ?>
        <?= $Page->anexo->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <?= $Page->anexo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->anexo->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_anexo" id= "fn_x_anexo" value="<?= $Page->anexo->Upload->FileName ?>">
<input type="hidden" name="fa_x_anexo" id= "fa_x_anexo" value="<?= (Post("fa_x_anexo") == "0") ? "0" : "1" ?>">
<table id="ft_x_anexo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_nc->Visible) { // status_nc ?>
    <div id="r_status_nc"<?= $Page->status_nc->rowAttributes() ?>>
        <label id="elh_nao_conformidade_status_nc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_nc->caption() ?><?= $Page->status_nc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_nc->cellAttributes() ?>>
<span id="el_nao_conformidade_status_nc">
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
    value="<?= HtmlEncode($Page->status_nc->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status_nc"
    data-target="dsl_x_status_nc"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status_nc->isInvalidClass() ?>"
    data-table="nao_conformidade"
    data-field="x_status_nc"
    data-value-separator="<?= $Page->status_nc->displayValueSeparatorAttribute() ?>"
    <?= $Page->status_nc->editAttributes() ?>></selection-list>
<?= $Page->status_nc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_nc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { // plano_acao ?>
    <div id="r_plano_acao"<?= $Page->plano_acao->rowAttributes() ?>>
        <label id="elh_nao_conformidade_plano_acao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->plano_acao->caption() ?><?= $Page->plano_acao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->plano_acao->cellAttributes() ?>>
<span id="el_nao_conformidade_plano_acao">
<span<?= $Page->plano_acao->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->plano_acao->getDisplayValue($Page->plano_acao->EditValue) ?></span></span>
<input type="hidden" data-table="nao_conformidade" data-field="x_plano_acao" data-hidden="1" name="x_plano_acao" id="x_plano_acao" value="<?= HtmlEncode($Page->plano_acao->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("plano_acao_nc", explode(",", $Page->getCurrentDetailTable())) && $plano_acao_nc->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("plano_acao_nc", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PlanoAcaoNcGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fnao_conformidadeedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fnao_conformidadeedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("nao_conformidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
