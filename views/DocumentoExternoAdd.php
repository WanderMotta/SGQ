<?php

namespace PHPMaker2024\sgq;

// Page object
$DocumentoExternoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_externo: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fdocumento_externoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdocumento_externoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["titulo_documento", [fields.titulo_documento.visible && fields.titulo_documento.required ? ew.Validators.required(fields.titulo_documento.caption) : null], fields.titulo_documento.isInvalid],
            ["distribuicao", [fields.distribuicao.visible && fields.distribuicao.required ? ew.Validators.required(fields.distribuicao.caption) : null], fields.distribuicao.isInvalid],
            ["tem_validade", [fields.tem_validade.visible && fields.tem_validade.required ? ew.Validators.required(fields.tem_validade.caption) : null], fields.tem_validade.isInvalid],
            ["valido_ate", [fields.valido_ate.visible && fields.valido_ate.required ? ew.Validators.required(fields.valido_ate.caption) : null, ew.Validators.datetime(fields.valido_ate.clientFormatPattern)], fields.valido_ate.isInvalid],
            ["restringir_acesso", [fields.restringir_acesso.visible && fields.restringir_acesso.required ? ew.Validators.required(fields.restringir_acesso.caption) : null], fields.restringir_acesso.isInvalid],
            ["localizacao_idlocalizacao", [fields.localizacao_idlocalizacao.visible && fields.localizacao_idlocalizacao.required ? ew.Validators.required(fields.localizacao_idlocalizacao.caption) : null], fields.localizacao_idlocalizacao.isInvalid],
            ["usuario_responsavel", [fields.usuario_responsavel.visible && fields.usuario_responsavel.required ? ew.Validators.required(fields.usuario_responsavel.caption) : null], fields.usuario_responsavel.isInvalid],
            ["anexo", [fields.anexo.visible && fields.anexo.required ? ew.Validators.fileRequired(fields.anexo.caption) : null], fields.anexo.isInvalid],
            ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid]
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
            "distribuicao": <?= $Page->distribuicao->toClientList($Page) ?>,
            "tem_validade": <?= $Page->tem_validade->toClientList($Page) ?>,
            "restringir_acesso": <?= $Page->restringir_acesso->toClientList($Page) ?>,
            "localizacao_idlocalizacao": <?= $Page->localizacao_idlocalizacao->toClientList($Page) ?>,
            "usuario_responsavel": <?= $Page->usuario_responsavel->toClientList($Page) ?>,
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
<form name="fdocumento_externoadd" id="fdocumento_externoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="documento_externo">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
    <div id="r_titulo_documento"<?= $Page->titulo_documento->rowAttributes() ?>>
        <label id="elh_documento_externo_titulo_documento" for="x_titulo_documento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titulo_documento->caption() ?><?= $Page->titulo_documento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titulo_documento->cellAttributes() ?>>
<span id="el_documento_externo_titulo_documento">
<input type="<?= $Page->titulo_documento->getInputTextType() ?>" name="x_titulo_documento" id="x_titulo_documento" data-table="documento_externo" data-field="x_titulo_documento" value="<?= $Page->titulo_documento->EditValue ?>" size="80" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo_documento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo_documento->formatPattern()) ?>"<?= $Page->titulo_documento->editAttributes() ?> aria-describedby="x_titulo_documento_help">
<?= $Page->titulo_documento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titulo_documento->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->distribuicao->Visible) { // distribuicao ?>
    <div id="r_distribuicao"<?= $Page->distribuicao->rowAttributes() ?>>
        <label id="elh_documento_externo_distribuicao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->distribuicao->caption() ?><?= $Page->distribuicao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->distribuicao->cellAttributes() ?>>
<span id="el_documento_externo_distribuicao">
<template id="tp_x_distribuicao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="documento_externo" data-field="x_distribuicao" name="x_distribuicao" id="x_distribuicao"<?= $Page->distribuicao->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_distribuicao" class="ew-item-list"></div>
<selection-list hidden
    id="x_distribuicao"
    name="x_distribuicao"
    value="<?= HtmlEncode($Page->distribuicao->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_distribuicao"
    data-target="dsl_x_distribuicao"
    data-repeatcolumn="5"
    class="form-control<?= $Page->distribuicao->isInvalidClass() ?>"
    data-table="documento_externo"
    data-field="x_distribuicao"
    data-value-separator="<?= $Page->distribuicao->displayValueSeparatorAttribute() ?>"
    <?= $Page->distribuicao->editAttributes() ?>></selection-list>
<?= $Page->distribuicao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->distribuicao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tem_validade->Visible) { // tem_validade ?>
    <div id="r_tem_validade"<?= $Page->tem_validade->rowAttributes() ?>>
        <label id="elh_documento_externo_tem_validade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tem_validade->caption() ?><?= $Page->tem_validade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tem_validade->cellAttributes() ?>>
<span id="el_documento_externo_tem_validade">
<template id="tp_x_tem_validade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="documento_externo" data-field="x_tem_validade" name="x_tem_validade" id="x_tem_validade"<?= $Page->tem_validade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tem_validade" class="ew-item-list"></div>
<selection-list hidden
    id="x_tem_validade"
    name="x_tem_validade"
    value="<?= HtmlEncode($Page->tem_validade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tem_validade"
    data-target="dsl_x_tem_validade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tem_validade->isInvalidClass() ?>"
    data-table="documento_externo"
    data-field="x_tem_validade"
    data-value-separator="<?= $Page->tem_validade->displayValueSeparatorAttribute() ?>"
    <?= $Page->tem_validade->editAttributes() ?>></selection-list>
<?= $Page->tem_validade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tem_validade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valido_ate->Visible) { // valido_ate ?>
    <div id="r_valido_ate"<?= $Page->valido_ate->rowAttributes() ?>>
        <label id="elh_documento_externo_valido_ate" for="x_valido_ate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valido_ate->caption() ?><?= $Page->valido_ate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->valido_ate->cellAttributes() ?>>
<span id="el_documento_externo_valido_ate">
<input type="<?= $Page->valido_ate->getInputTextType() ?>" name="x_valido_ate" id="x_valido_ate" data-table="documento_externo" data-field="x_valido_ate" value="<?= $Page->valido_ate->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->valido_ate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->valido_ate->formatPattern()) ?>"<?= $Page->valido_ate->editAttributes() ?> aria-describedby="x_valido_ate_help">
<?= $Page->valido_ate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valido_ate->getErrorMessage() ?></div>
<?php if (!$Page->valido_ate->ReadOnly && !$Page->valido_ate->Disabled && !isset($Page->valido_ate->EditAttrs["readonly"]) && !isset($Page->valido_ate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdocumento_externoadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdocumento_externoadd", "x_valido_ate", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
    <div id="r_restringir_acesso"<?= $Page->restringir_acesso->rowAttributes() ?>>
        <label id="elh_documento_externo_restringir_acesso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->restringir_acesso->caption() ?><?= $Page->restringir_acesso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->restringir_acesso->cellAttributes() ?>>
<span id="el_documento_externo_restringir_acesso">
<template id="tp_x_restringir_acesso">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="documento_externo" data-field="x_restringir_acesso" name="x_restringir_acesso" id="x_restringir_acesso"<?= $Page->restringir_acesso->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_restringir_acesso" class="ew-item-list"></div>
<selection-list hidden
    id="x_restringir_acesso"
    name="x_restringir_acesso"
    value="<?= HtmlEncode($Page->restringir_acesso->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_restringir_acesso"
    data-target="dsl_x_restringir_acesso"
    data-repeatcolumn="5"
    class="form-control<?= $Page->restringir_acesso->isInvalidClass() ?>"
    data-table="documento_externo"
    data-field="x_restringir_acesso"
    data-value-separator="<?= $Page->restringir_acesso->displayValueSeparatorAttribute() ?>"
    <?= $Page->restringir_acesso->editAttributes() ?>></selection-list>
<?= $Page->restringir_acesso->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->restringir_acesso->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->localizacao_idlocalizacao->Visible) { // localizacao_idlocalizacao ?>
    <div id="r_localizacao_idlocalizacao"<?= $Page->localizacao_idlocalizacao->rowAttributes() ?>>
        <label id="elh_documento_externo_localizacao_idlocalizacao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->localizacao_idlocalizacao->caption() ?><?= $Page->localizacao_idlocalizacao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->localizacao_idlocalizacao->cellAttributes() ?>>
<span id="el_documento_externo_localizacao_idlocalizacao">
<template id="tp_x_localizacao_idlocalizacao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="documento_externo" data-field="x_localizacao_idlocalizacao" name="x_localizacao_idlocalizacao" id="x_localizacao_idlocalizacao"<?= $Page->localizacao_idlocalizacao->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_localizacao_idlocalizacao" class="ew-item-list"></div>
<selection-list hidden
    id="x_localizacao_idlocalizacao"
    name="x_localizacao_idlocalizacao"
    value="<?= HtmlEncode($Page->localizacao_idlocalizacao->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_localizacao_idlocalizacao"
    data-target="dsl_x_localizacao_idlocalizacao"
    data-repeatcolumn="5"
    class="form-control<?= $Page->localizacao_idlocalizacao->isInvalidClass() ?>"
    data-table="documento_externo"
    data-field="x_localizacao_idlocalizacao"
    data-value-separator="<?= $Page->localizacao_idlocalizacao->displayValueSeparatorAttribute() ?>"
    <?= $Page->localizacao_idlocalizacao->editAttributes() ?>></selection-list>
<?= $Page->localizacao_idlocalizacao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->localizacao_idlocalizacao->getErrorMessage() ?></div>
<?php if (AllowAdd(CurrentProjectID() . "localizacao") && !$Page->localizacao_idlocalizacao->ReadOnly) { ?>
<button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_localizacao_idlocalizacao" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->localizacao_idlocalizacao->caption() ?>" data-title="<?= $Page->localizacao_idlocalizacao->caption() ?>" data-ew-action="add-option" data-el="x_localizacao_idlocalizacao" data-url="<?= GetUrl("LocalizacaoAddopt") ?>"><i class="fa-solid fa-plus ew-icon"></i></button>
<?php } ?>
<?= $Page->localizacao_idlocalizacao->Lookup->getParamTag($Page, "p_x_localizacao_idlocalizacao") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_responsavel->Visible) { // usuario_responsavel ?>
    <div id="r_usuario_responsavel"<?= $Page->usuario_responsavel->rowAttributes() ?>>
        <label id="elh_documento_externo_usuario_responsavel" for="x_usuario_responsavel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_responsavel->caption() ?><?= $Page->usuario_responsavel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_responsavel->cellAttributes() ?>>
<span id="el_documento_externo_usuario_responsavel">
    <select
        id="x_usuario_responsavel"
        name="x_usuario_responsavel"
        class="form-control ew-select<?= $Page->usuario_responsavel->isInvalidClass() ?>"
        data-select2-id="fdocumento_externoadd_x_usuario_responsavel"
        data-table="documento_externo"
        data-field="x_usuario_responsavel"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->usuario_responsavel->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->usuario_responsavel->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_responsavel->getPlaceHolder()) ?>"
        <?= $Page->usuario_responsavel->editAttributes() ?>>
        <?= $Page->usuario_responsavel->selectOptionListHtml("x_usuario_responsavel") ?>
    </select>
    <?= $Page->usuario_responsavel->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->usuario_responsavel->getErrorMessage() ?></div>
<?= $Page->usuario_responsavel->Lookup->getParamTag($Page, "p_x_usuario_responsavel") ?>
<script>
loadjs.ready("fdocumento_externoadd", function() {
    var options = { name: "x_usuario_responsavel", selectId: "fdocumento_externoadd_x_usuario_responsavel" };
    if (fdocumento_externoadd.lists.usuario_responsavel?.lookupOptions.length) {
        options.data = { id: "x_usuario_responsavel", form: "fdocumento_externoadd" };
    } else {
        options.ajax = { id: "x_usuario_responsavel", form: "fdocumento_externoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.documento_externo.fields.usuario_responsavel.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
    <div id="r_anexo"<?= $Page->anexo->rowAttributes() ?>>
        <label id="elh_documento_externo_anexo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->anexo->caption() ?><?= $Page->anexo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->anexo->cellAttributes() ?>>
<span id="el_documento_externo_anexo">
<div id="fd_x_anexo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_anexo"
        name="x_anexo"
        class="form-control ew-file-input"
        title="<?= $Page->anexo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="documento_externo"
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
<input type="hidden" name="fa_x_anexo" id= "fa_x_anexo" value="0">
<table id="ft_x_anexo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_documento_externo_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_documento_externo_obs">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="documento_externo" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help">
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdocumento_externoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdocumento_externoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("documento_externo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
