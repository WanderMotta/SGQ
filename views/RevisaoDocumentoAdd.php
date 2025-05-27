<?php

namespace PHPMaker2024\sgq;

// Page object
$RevisaoDocumentoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { revisao_documento: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var frevisao_documentoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frevisao_documentoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["documento_interno_iddocumento_interno", [fields.documento_interno_iddocumento_interno.visible && fields.documento_interno_iddocumento_interno.required ? ew.Validators.required(fields.documento_interno_iddocumento_interno.caption) : null], fields.documento_interno_iddocumento_interno.isInvalid],
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null, ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["qual_alteracao", [fields.qual_alteracao.visible && fields.qual_alteracao.required ? ew.Validators.required(fields.qual_alteracao.caption) : null], fields.qual_alteracao.isInvalid],
            ["revisao_nr", [fields.revisao_nr.visible && fields.revisao_nr.required ? ew.Validators.required(fields.revisao_nr.caption) : null, ew.Validators.integer], fields.revisao_nr.isInvalid],
            ["usuario_elaborador", [fields.usuario_elaborador.visible && fields.usuario_elaborador.required ? ew.Validators.required(fields.usuario_elaborador.caption) : null], fields.usuario_elaborador.isInvalid],
            ["usuario_aprovador", [fields.usuario_aprovador.visible && fields.usuario_aprovador.required ? ew.Validators.required(fields.usuario_aprovador.caption) : null], fields.usuario_aprovador.isInvalid],
            ["anexo", [fields.anexo.visible && fields.anexo.required ? ew.Validators.fileRequired(fields.anexo.caption) : null], fields.anexo.isInvalid]
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
            "documento_interno_iddocumento_interno": <?= $Page->documento_interno_iddocumento_interno->toClientList($Page) ?>,
            "usuario_elaborador": <?= $Page->usuario_elaborador->toClientList($Page) ?>,
            "usuario_aprovador": <?= $Page->usuario_aprovador->toClientList($Page) ?>,
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
<form name="frevisao_documentoadd" id="frevisao_documentoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="revisao_documento">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "documento_interno") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="documento_interno">
<input type="hidden" name="fk_iddocumento_interno" value="<?= HtmlEncode($Page->documento_interno_iddocumento_interno->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->documento_interno_iddocumento_interno->Visible) { // documento_interno_iddocumento_interno ?>
    <div id="r_documento_interno_iddocumento_interno"<?= $Page->documento_interno_iddocumento_interno->rowAttributes() ?>>
        <label id="elh_revisao_documento_documento_interno_iddocumento_interno" for="x_documento_interno_iddocumento_interno" class="<?= $Page->LeftColumnClass ?>"><?= $Page->documento_interno_iddocumento_interno->caption() ?><?= $Page->documento_interno_iddocumento_interno->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->documento_interno_iddocumento_interno->cellAttributes() ?>>
<?php if ($Page->documento_interno_iddocumento_interno->getSessionValue() != "") { ?>
<span<?= $Page->documento_interno_iddocumento_interno->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->documento_interno_iddocumento_interno->getDisplayValue($Page->documento_interno_iddocumento_interno->ViewValue) ?></span></span>
<input type="hidden" id="x_documento_interno_iddocumento_interno" name="x_documento_interno_iddocumento_interno" value="<?= HtmlEncode($Page->documento_interno_iddocumento_interno->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_revisao_documento_documento_interno_iddocumento_interno">
    <select
        id="x_documento_interno_iddocumento_interno"
        name="x_documento_interno_iddocumento_interno"
        class="form-select ew-select<?= $Page->documento_interno_iddocumento_interno->isInvalidClass() ?>"
        <?php if (!$Page->documento_interno_iddocumento_interno->IsNativeSelect) { ?>
        data-select2-id="frevisao_documentoadd_x_documento_interno_iddocumento_interno"
        <?php } ?>
        data-table="revisao_documento"
        data-field="x_documento_interno_iddocumento_interno"
        data-value-separator="<?= $Page->documento_interno_iddocumento_interno->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->documento_interno_iddocumento_interno->getPlaceHolder()) ?>"
        <?= $Page->documento_interno_iddocumento_interno->editAttributes() ?>>
        <?= $Page->documento_interno_iddocumento_interno->selectOptionListHtml("x_documento_interno_iddocumento_interno") ?>
    </select>
    <?= $Page->documento_interno_iddocumento_interno->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->documento_interno_iddocumento_interno->getErrorMessage() ?></div>
<?= $Page->documento_interno_iddocumento_interno->Lookup->getParamTag($Page, "p_x_documento_interno_iddocumento_interno") ?>
<?php if (!$Page->documento_interno_iddocumento_interno->IsNativeSelect) { ?>
<script>
loadjs.ready("frevisao_documentoadd", function() {
    var options = { name: "x_documento_interno_iddocumento_interno", selectId: "frevisao_documentoadd_x_documento_interno_iddocumento_interno" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frevisao_documentoadd.lists.documento_interno_iddocumento_interno?.lookupOptions.length) {
        options.data = { id: "x_documento_interno_iddocumento_interno", form: "frevisao_documentoadd" };
    } else {
        options.ajax = { id: "x_documento_interno_iddocumento_interno", form: "frevisao_documentoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.revisao_documento.fields.documento_interno_iddocumento_interno.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label id="elh_revisao_documento_dt_cadastro" for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dt_cadastro->caption() ?><?= $Page->dt_cadastro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el_revisao_documento_dt_cadastro">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="revisao_documento" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?> aria-describedby="x_dt_cadastro_help">
<?= $Page->dt_cadastro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage() ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frevisao_documentoadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frevisao_documentoadd", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->qual_alteracao->Visible) { // qual_alteracao ?>
    <div id="r_qual_alteracao"<?= $Page->qual_alteracao->rowAttributes() ?>>
        <label id="elh_revisao_documento_qual_alteracao" for="x_qual_alteracao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->qual_alteracao->caption() ?><?= $Page->qual_alteracao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->qual_alteracao->cellAttributes() ?>>
<span id="el_revisao_documento_qual_alteracao">
<textarea data-table="revisao_documento" data-field="x_qual_alteracao" name="x_qual_alteracao" id="x_qual_alteracao" cols="50" rows="4" placeholder="<?= HtmlEncode($Page->qual_alteracao->getPlaceHolder()) ?>"<?= $Page->qual_alteracao->editAttributes() ?> aria-describedby="x_qual_alteracao_help"><?= $Page->qual_alteracao->EditValue ?></textarea>
<?= $Page->qual_alteracao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->qual_alteracao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->revisao_nr->Visible) { // revisao_nr ?>
    <div id="r_revisao_nr"<?= $Page->revisao_nr->rowAttributes() ?>>
        <label id="elh_revisao_documento_revisao_nr" for="x_revisao_nr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->revisao_nr->caption() ?><?= $Page->revisao_nr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->revisao_nr->cellAttributes() ?>>
<span id="el_revisao_documento_revisao_nr">
<input type="<?= $Page->revisao_nr->getInputTextType() ?>" name="x_revisao_nr" id="x_revisao_nr" data-table="revisao_documento" data-field="x_revisao_nr" value="<?= $Page->revisao_nr->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->revisao_nr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->revisao_nr->formatPattern()) ?>"<?= $Page->revisao_nr->editAttributes() ?> aria-describedby="x_revisao_nr_help">
<?= $Page->revisao_nr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->revisao_nr->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_elaborador->Visible) { // usuario_elaborador ?>
    <div id="r_usuario_elaborador"<?= $Page->usuario_elaborador->rowAttributes() ?>>
        <label id="elh_revisao_documento_usuario_elaborador" for="x_usuario_elaborador" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_elaborador->caption() ?><?= $Page->usuario_elaborador->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_elaborador->cellAttributes() ?>>
<span id="el_revisao_documento_usuario_elaborador">
    <select
        id="x_usuario_elaborador"
        name="x_usuario_elaborador"
        class="form-select ew-select<?= $Page->usuario_elaborador->isInvalidClass() ?>"
        <?php if (!$Page->usuario_elaborador->IsNativeSelect) { ?>
        data-select2-id="frevisao_documentoadd_x_usuario_elaborador"
        <?php } ?>
        data-table="revisao_documento"
        data-field="x_usuario_elaborador"
        data-value-separator="<?= $Page->usuario_elaborador->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_elaborador->getPlaceHolder()) ?>"
        <?= $Page->usuario_elaborador->editAttributes() ?>>
        <?= $Page->usuario_elaborador->selectOptionListHtml("x_usuario_elaborador") ?>
    </select>
    <?= $Page->usuario_elaborador->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->usuario_elaborador->getErrorMessage() ?></div>
<?= $Page->usuario_elaborador->Lookup->getParamTag($Page, "p_x_usuario_elaborador") ?>
<?php if (!$Page->usuario_elaborador->IsNativeSelect) { ?>
<script>
loadjs.ready("frevisao_documentoadd", function() {
    var options = { name: "x_usuario_elaborador", selectId: "frevisao_documentoadd_x_usuario_elaborador" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frevisao_documentoadd.lists.usuario_elaborador?.lookupOptions.length) {
        options.data = { id: "x_usuario_elaborador", form: "frevisao_documentoadd" };
    } else {
        options.ajax = { id: "x_usuario_elaborador", form: "frevisao_documentoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.revisao_documento.fields.usuario_elaborador.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_aprovador->Visible) { // usuario_aprovador ?>
    <div id="r_usuario_aprovador"<?= $Page->usuario_aprovador->rowAttributes() ?>>
        <label id="elh_revisao_documento_usuario_aprovador" for="x_usuario_aprovador" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_aprovador->caption() ?><?= $Page->usuario_aprovador->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_aprovador->cellAttributes() ?>>
<span id="el_revisao_documento_usuario_aprovador">
    <select
        id="x_usuario_aprovador"
        name="x_usuario_aprovador"
        class="form-select ew-select<?= $Page->usuario_aprovador->isInvalidClass() ?>"
        <?php if (!$Page->usuario_aprovador->IsNativeSelect) { ?>
        data-select2-id="frevisao_documentoadd_x_usuario_aprovador"
        <?php } ?>
        data-table="revisao_documento"
        data-field="x_usuario_aprovador"
        data-value-separator="<?= $Page->usuario_aprovador->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_aprovador->getPlaceHolder()) ?>"
        <?= $Page->usuario_aprovador->editAttributes() ?>>
        <?= $Page->usuario_aprovador->selectOptionListHtml("x_usuario_aprovador") ?>
    </select>
    <?= $Page->usuario_aprovador->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->usuario_aprovador->getErrorMessage() ?></div>
<?= $Page->usuario_aprovador->Lookup->getParamTag($Page, "p_x_usuario_aprovador") ?>
<?php if (!$Page->usuario_aprovador->IsNativeSelect) { ?>
<script>
loadjs.ready("frevisao_documentoadd", function() {
    var options = { name: "x_usuario_aprovador", selectId: "frevisao_documentoadd_x_usuario_aprovador" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frevisao_documentoadd.lists.usuario_aprovador?.lookupOptions.length) {
        options.data = { id: "x_usuario_aprovador", form: "frevisao_documentoadd" };
    } else {
        options.ajax = { id: "x_usuario_aprovador", form: "frevisao_documentoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.revisao_documento.fields.usuario_aprovador.selectOptions);
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
        <label id="elh_revisao_documento_anexo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->anexo->caption() ?><?= $Page->anexo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->anexo->cellAttributes() ?>>
<span id="el_revisao_documento_anexo">
<div id="fd_x_anexo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_anexo"
        name="x_anexo"
        class="form-control ew-file-input"
        title="<?= $Page->anexo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="revisao_documento"
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
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="frevisao_documentoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="frevisao_documentoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("revisao_documento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
