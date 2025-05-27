<?php

namespace PHPMaker2024\sgq;

// Page object
$RiscoOportunidadeEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="frisco_oportunidadeedit" id="frisco_oportunidadeedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { risco_oportunidade: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var frisco_oportunidadeedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frisco_oportunidadeedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idrisco_oportunidade", [fields.idrisco_oportunidade.visible && fields.idrisco_oportunidade.required ? ew.Validators.required(fields.idrisco_oportunidade.caption) : null], fields.idrisco_oportunidade.isInvalid],
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["tipo_risco_oportunidade_idtipo_risco_oportunidade", [fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.visible && fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.required ? ew.Validators.required(fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.caption) : null], fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.isInvalid],
            ["titulo", [fields.titulo.visible && fields.titulo.required ? ew.Validators.required(fields.titulo.caption) : null], fields.titulo.isInvalid],
            ["origem_risco_oportunidade_idorigem_risco_oportunidade", [fields.origem_risco_oportunidade_idorigem_risco_oportunidade.visible && fields.origem_risco_oportunidade_idorigem_risco_oportunidade.required ? ew.Validators.required(fields.origem_risco_oportunidade_idorigem_risco_oportunidade.caption) : null], fields.origem_risco_oportunidade_idorigem_risco_oportunidade.isInvalid],
            ["descricao", [fields.descricao.visible && fields.descricao.required ? ew.Validators.required(fields.descricao.caption) : null], fields.descricao.isInvalid],
            ["consequencia", [fields.consequencia.visible && fields.consequencia.required ? ew.Validators.required(fields.consequencia.caption) : null], fields.consequencia.isInvalid],
            ["frequencia_idfrequencia", [fields.frequencia_idfrequencia.visible && fields.frequencia_idfrequencia.required ? ew.Validators.required(fields.frequencia_idfrequencia.caption) : null], fields.frequencia_idfrequencia.isInvalid],
            ["impacto_idimpacto", [fields.impacto_idimpacto.visible && fields.impacto_idimpacto.required ? ew.Validators.required(fields.impacto_idimpacto.caption) : null], fields.impacto_idimpacto.isInvalid],
            ["grau_atencao", [fields.grau_atencao.visible && fields.grau_atencao.required ? ew.Validators.required(fields.grau_atencao.caption) : null], fields.grau_atencao.isInvalid],
            ["acao_risco_oportunidade_idacao_risco_oportunidade", [fields.acao_risco_oportunidade_idacao_risco_oportunidade.visible && fields.acao_risco_oportunidade_idacao_risco_oportunidade.required ? ew.Validators.required(fields.acao_risco_oportunidade_idacao_risco_oportunidade.caption) : null], fields.acao_risco_oportunidade_idacao_risco_oportunidade.isInvalid],
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
            "tipo_risco_oportunidade_idtipo_risco_oportunidade": <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->toClientList($Page) ?>,
            "origem_risco_oportunidade_idorigem_risco_oportunidade": <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->toClientList($Page) ?>,
            "frequencia_idfrequencia": <?= $Page->frequencia_idfrequencia->toClientList($Page) ?>,
            "impacto_idimpacto": <?= $Page->impacto_idimpacto->toClientList($Page) ?>,
            "acao_risco_oportunidade_idacao_risco_oportunidade": <?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="risco_oportunidade">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idrisco_oportunidade->Visible) { // idrisco_oportunidade ?>
    <div id="r_idrisco_oportunidade"<?= $Page->idrisco_oportunidade->rowAttributes() ?>>
        <label id="elh_risco_oportunidade_idrisco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idrisco_oportunidade->caption() ?><?= $Page->idrisco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idrisco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_idrisco_oportunidade">
<span<?= $Page->idrisco_oportunidade->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idrisco_oportunidade->getDisplayValue($Page->idrisco_oportunidade->EditValue))) ?>"></span>
<input type="hidden" data-table="risco_oportunidade" data-field="x_idrisco_oportunidade" data-hidden="1" name="x_idrisco_oportunidade" id="x_idrisco_oportunidade" value="<?= HtmlEncode($Page->idrisco_oportunidade->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
    <div id="r_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->rowAttributes() ?>>
        <label id="elh_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() ?><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade">
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
    value="<?= HtmlEncode($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue) ?>"
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
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getErrorMessage() ?></div>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getParamTag($Page, "p_x_tipo_risco_oportunidade_idtipo_risco_oportunidade") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <div id="r_titulo"<?= $Page->titulo->rowAttributes() ?>>
        <label id="elh_risco_oportunidade_titulo" for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titulo->caption() ?><?= $Page->titulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titulo->cellAttributes() ?>>
<span id="el_risco_oportunidade_titulo">
<input type="<?= $Page->titulo->getInputTextType() ?>" name="x_titulo" id="x_titulo" data-table="risco_oportunidade" data-field="x_titulo" value="<?= $Page->titulo->EditValue ?>" size="45" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo->formatPattern()) ?>"<?= $Page->titulo->editAttributes() ?> aria-describedby="x_titulo_help">
<?= $Page->titulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <div id="r_origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
        <label id="elh_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade" for="x_origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade">
    <select
        id="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        name="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        class="form-select ew-select<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Page->origem_risco_oportunidade_idorigem_risco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="frisco_oportunidadeedit_x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        <?php } ?>
        data-table="risco_oportunidade"
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
loadjs.ready("frisco_oportunidadeedit", function() {
    var options = { name: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", selectId: "frisco_oportunidadeedit_x_origem_risco_oportunidade_idorigem_risco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frisco_oportunidadeedit.lists.origem_risco_oportunidade_idorigem_risco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "frisco_oportunidadeedit" };
    } else {
        options.ajax = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "frisco_oportunidadeedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.risco_oportunidade.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
    <div id="r_descricao"<?= $Page->descricao->rowAttributes() ?>>
        <label id="elh_risco_oportunidade_descricao" for="x_descricao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descricao->caption() ?><?= $Page->descricao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descricao->cellAttributes() ?>>
<span id="el_risco_oportunidade_descricao">
<textarea data-table="risco_oportunidade" data-field="x_descricao" name="x_descricao" id="x_descricao" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->descricao->getPlaceHolder()) ?>"<?= $Page->descricao->editAttributes() ?> aria-describedby="x_descricao_help"><?= $Page->descricao->EditValue ?></textarea>
<?= $Page->descricao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descricao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->consequencia->Visible) { // consequencia ?>
    <div id="r_consequencia"<?= $Page->consequencia->rowAttributes() ?>>
        <label id="elh_risco_oportunidade_consequencia" for="x_consequencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->consequencia->caption() ?><?= $Page->consequencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->consequencia->cellAttributes() ?>>
<span id="el_risco_oportunidade_consequencia">
<textarea data-table="risco_oportunidade" data-field="x_consequencia" name="x_consequencia" id="x_consequencia" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->consequencia->getPlaceHolder()) ?>"<?= $Page->consequencia->editAttributes() ?> aria-describedby="x_consequencia_help"><?= $Page->consequencia->EditValue ?></textarea>
<?= $Page->consequencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->consequencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->frequencia_idfrequencia->Visible) { // frequencia_idfrequencia ?>
    <div id="r_frequencia_idfrequencia"<?= $Page->frequencia_idfrequencia->rowAttributes() ?>>
        <label id="elh_risco_oportunidade_frequencia_idfrequencia" for="x_frequencia_idfrequencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->frequencia_idfrequencia->caption() ?><?= $Page->frequencia_idfrequencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->frequencia_idfrequencia->cellAttributes() ?>>
<span id="el_risco_oportunidade_frequencia_idfrequencia">
    <select
        id="x_frequencia_idfrequencia"
        name="x_frequencia_idfrequencia"
        class="form-select ew-select<?= $Page->frequencia_idfrequencia->isInvalidClass() ?>"
        <?php if (!$Page->frequencia_idfrequencia->IsNativeSelect) { ?>
        data-select2-id="frisco_oportunidadeedit_x_frequencia_idfrequencia"
        <?php } ?>
        data-table="risco_oportunidade"
        data-field="x_frequencia_idfrequencia"
        data-value-separator="<?= $Page->frequencia_idfrequencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->frequencia_idfrequencia->getPlaceHolder()) ?>"
        <?= $Page->frequencia_idfrequencia->editAttributes() ?>>
        <?= $Page->frequencia_idfrequencia->selectOptionListHtml("x_frequencia_idfrequencia") ?>
    </select>
    <?= $Page->frequencia_idfrequencia->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->frequencia_idfrequencia->getErrorMessage() ?></div>
<?= $Page->frequencia_idfrequencia->Lookup->getParamTag($Page, "p_x_frequencia_idfrequencia") ?>
<?php if (!$Page->frequencia_idfrequencia->IsNativeSelect) { ?>
<script>
loadjs.ready("frisco_oportunidadeedit", function() {
    var options = { name: "x_frequencia_idfrequencia", selectId: "frisco_oportunidadeedit_x_frequencia_idfrequencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frisco_oportunidadeedit.lists.frequencia_idfrequencia?.lookupOptions.length) {
        options.data = { id: "x_frequencia_idfrequencia", form: "frisco_oportunidadeedit" };
    } else {
        options.ajax = { id: "x_frequencia_idfrequencia", form: "frisco_oportunidadeedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.risco_oportunidade.fields.frequencia_idfrequencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
    <div id="r_impacto_idimpacto"<?= $Page->impacto_idimpacto->rowAttributes() ?>>
        <label id="elh_risco_oportunidade_impacto_idimpacto" for="x_impacto_idimpacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->impacto_idimpacto->caption() ?><?= $Page->impacto_idimpacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->impacto_idimpacto->cellAttributes() ?>>
<span id="el_risco_oportunidade_impacto_idimpacto">
    <select
        id="x_impacto_idimpacto"
        name="x_impacto_idimpacto"
        class="form-select ew-select<?= $Page->impacto_idimpacto->isInvalidClass() ?>"
        <?php if (!$Page->impacto_idimpacto->IsNativeSelect) { ?>
        data-select2-id="frisco_oportunidadeedit_x_impacto_idimpacto"
        <?php } ?>
        data-table="risco_oportunidade"
        data-field="x_impacto_idimpacto"
        data-value-separator="<?= $Page->impacto_idimpacto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->impacto_idimpacto->getPlaceHolder()) ?>"
        <?= $Page->impacto_idimpacto->editAttributes() ?>>
        <?= $Page->impacto_idimpacto->selectOptionListHtml("x_impacto_idimpacto") ?>
    </select>
    <?= $Page->impacto_idimpacto->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->impacto_idimpacto->getErrorMessage() ?></div>
<?= $Page->impacto_idimpacto->Lookup->getParamTag($Page, "p_x_impacto_idimpacto") ?>
<?php if (!$Page->impacto_idimpacto->IsNativeSelect) { ?>
<script>
loadjs.ready("frisco_oportunidadeedit", function() {
    var options = { name: "x_impacto_idimpacto", selectId: "frisco_oportunidadeedit_x_impacto_idimpacto" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frisco_oportunidadeedit.lists.impacto_idimpacto?.lookupOptions.length) {
        options.data = { id: "x_impacto_idimpacto", form: "frisco_oportunidadeedit" };
    } else {
        options.ajax = { id: "x_impacto_idimpacto", form: "frisco_oportunidadeedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.risco_oportunidade.fields.impacto_idimpacto.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->grau_atencao->Visible) { // grau_atencao ?>
    <div id="r_grau_atencao"<?= $Page->grau_atencao->rowAttributes() ?>>
        <label id="elh_risco_oportunidade_grau_atencao" for="x_grau_atencao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->grau_atencao->caption() ?><?= $Page->grau_atencao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->grau_atencao->cellAttributes() ?>>
<span id="el_risco_oportunidade_grau_atencao">
<span<?= $Page->grau_atencao->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->grau_atencao->getDisplayValue($Page->grau_atencao->EditValue))) ?>"></span>
<input type="hidden" data-table="risco_oportunidade" data-field="x_grau_atencao" data-hidden="1" name="x_grau_atencao" id="x_grau_atencao" value="<?= HtmlEncode($Page->grau_atencao->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->acao_risco_oportunidade_idacao_risco_oportunidade->Visible) { // acao_risco_oportunidade_idacao_risco_oportunidade ?>
    <div id="r_acao_risco_oportunidade_idacao_risco_oportunidade"<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->rowAttributes() ?>>
        <label id="elh_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade" for="x_acao_risco_oportunidade_idacao_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->caption() ?><?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade">
    <select
        id="x_acao_risco_oportunidade_idacao_risco_oportunidade"
        name="x_acao_risco_oportunidade_idacao_risco_oportunidade"
        class="form-select ew-select<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->isInvalidClass() ?>"
        <?php if (!$Page->acao_risco_oportunidade_idacao_risco_oportunidade->IsNativeSelect) { ?>
        data-select2-id="frisco_oportunidadeedit_x_acao_risco_oportunidade_idacao_risco_oportunidade"
        <?php } ?>
        data-table="risco_oportunidade"
        data-field="x_acao_risco_oportunidade_idacao_risco_oportunidade"
        data-value-separator="<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->acao_risco_oportunidade_idacao_risco_oportunidade->getPlaceHolder()) ?>"
        <?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->editAttributes() ?>>
        <?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->selectOptionListHtml("x_acao_risco_oportunidade_idacao_risco_oportunidade") ?>
    </select>
    <?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->getErrorMessage() ?></div>
<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->Lookup->getParamTag($Page, "p_x_acao_risco_oportunidade_idacao_risco_oportunidade") ?>
<?php if (!$Page->acao_risco_oportunidade_idacao_risco_oportunidade->IsNativeSelect) { ?>
<script>
loadjs.ready("frisco_oportunidadeedit", function() {
    var options = { name: "x_acao_risco_oportunidade_idacao_risco_oportunidade", selectId: "frisco_oportunidadeedit_x_acao_risco_oportunidade_idacao_risco_oportunidade" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frisco_oportunidadeedit.lists.acao_risco_oportunidade_idacao_risco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x_acao_risco_oportunidade_idacao_risco_oportunidade", form: "frisco_oportunidadeedit" };
    } else {
        options.ajax = { id: "x_acao_risco_oportunidade_idacao_risco_oportunidade", form: "frisco_oportunidadeedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.risco_oportunidade.fields.acao_risco_oportunidade_idacao_risco_oportunidade.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { // plano_acao ?>
    <div id="r_plano_acao"<?= $Page->plano_acao->rowAttributes() ?>>
        <label id="elh_risco_oportunidade_plano_acao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->plano_acao->caption() ?><?= $Page->plano_acao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->plano_acao->cellAttributes() ?>>
<span id="el_risco_oportunidade_plano_acao">
<span<?= $Page->plano_acao->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->plano_acao->getDisplayValue($Page->plano_acao->EditValue) ?></span></span>
<input type="hidden" data-table="risco_oportunidade" data-field="x_plano_acao" data-hidden="1" name="x_plano_acao" id="x_plano_acao" value="<?= HtmlEncode($Page->plano_acao->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("plano_acao", explode(",", $Page->getCurrentDetailTable())) && $plano_acao->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("plano_acao", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PlanoAcaoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="frisco_oportunidadeedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="frisco_oportunidadeedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("risco_oportunidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
