<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAuditoriaIntEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fplano_auditoria_intedit" id="fplano_auditoria_intedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { plano_auditoria_int: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fplano_auditoria_intedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fplano_auditoria_intedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idplano_auditoria_int", [fields.idplano_auditoria_int.visible && fields.idplano_auditoria_int.required ? ew.Validators.required(fields.idplano_auditoria_int.caption) : null], fields.idplano_auditoria_int.isInvalid],
            ["data", [fields.data.visible && fields.data.required ? ew.Validators.required(fields.data.caption) : null, ew.Validators.datetime(fields.data.clientFormatPattern)], fields.data.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid],
            ["criterio", [fields.criterio.visible && fields.criterio.required ? ew.Validators.required(fields.criterio.caption) : null], fields.criterio.isInvalid],
            ["arquivo", [fields.arquivo.visible && fields.arquivo.required ? ew.Validators.fileRequired(fields.arquivo.caption) : null], fields.arquivo.isInvalid]
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
            "usuario_idusuario": <?= $Page->usuario_idusuario->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="plano_auditoria_int">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idplano_auditoria_int->Visible) { // idplano_auditoria_int ?>
    <div id="r_idplano_auditoria_int"<?= $Page->idplano_auditoria_int->rowAttributes() ?>>
        <label id="elh_plano_auditoria_int_idplano_auditoria_int" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idplano_auditoria_int->caption() ?><?= $Page->idplano_auditoria_int->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idplano_auditoria_int->cellAttributes() ?>>
<span id="el_plano_auditoria_int_idplano_auditoria_int">
<span<?= $Page->idplano_auditoria_int->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idplano_auditoria_int->getDisplayValue($Page->idplano_auditoria_int->EditValue))) ?>"></span>
<input type="hidden" data-table="plano_auditoria_int" data-field="x_idplano_auditoria_int" data-hidden="1" name="x_idplano_auditoria_int" id="x_idplano_auditoria_int" value="<?= HtmlEncode($Page->idplano_auditoria_int->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
    <div id="r_data"<?= $Page->data->rowAttributes() ?>>
        <label id="elh_plano_auditoria_int_data" for="x_data" class="<?= $Page->LeftColumnClass ?>"><?= $Page->data->caption() ?><?= $Page->data->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->data->cellAttributes() ?>>
<span id="el_plano_auditoria_int_data">
<input type="<?= $Page->data->getInputTextType() ?>" name="x_data" id="x_data" data-table="plano_auditoria_int" data-field="x_data" value="<?= $Page->data->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->data->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->data->formatPattern()) ?>"<?= $Page->data->editAttributes() ?> aria-describedby="x_data_help">
<?= $Page->data->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->data->getErrorMessage() ?></div>
<?php if (!$Page->data->ReadOnly && !$Page->data->Disabled && !isset($Page->data->EditAttrs["readonly"]) && !isset($Page->data->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fplano_auditoria_intedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fplano_auditoria_intedit", "x_data", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label id="elh_plano_auditoria_int_usuario_idusuario" for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_idusuario->caption() ?><?= $Page->usuario_idusuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_plano_auditoria_int_usuario_idusuario">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-control ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        data-select2-id="fplano_auditoria_intedit_x_usuario_idusuario"
        data-table="plano_auditoria_int"
        data-field="x_usuario_idusuario"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->usuario_idusuario->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->usuario_idusuario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_idusuario->getPlaceHolder()) ?>"
        <?= $Page->usuario_idusuario->editAttributes() ?>>
        <?= $Page->usuario_idusuario->selectOptionListHtml("x_usuario_idusuario") ?>
    </select>
    <?= $Page->usuario_idusuario->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->usuario_idusuario->getErrorMessage() ?></div>
<?= $Page->usuario_idusuario->Lookup->getParamTag($Page, "p_x_usuario_idusuario") ?>
<script>
loadjs.ready("fplano_auditoria_intedit", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fplano_auditoria_intedit_x_usuario_idusuario" };
    if (fplano_auditoria_intedit.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fplano_auditoria_intedit" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fplano_auditoria_intedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.plano_auditoria_int.fields.usuario_idusuario.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->criterio->Visible) { // criterio ?>
    <div id="r_criterio"<?= $Page->criterio->rowAttributes() ?>>
        <label id="elh_plano_auditoria_int_criterio" for="x_criterio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->criterio->caption() ?><?= $Page->criterio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->criterio->cellAttributes() ?>>
<span id="el_plano_auditoria_int_criterio">
<textarea data-table="plano_auditoria_int" data-field="x_criterio" name="x_criterio" id="x_criterio" cols="35" rows="2" placeholder="<?= HtmlEncode($Page->criterio->getPlaceHolder()) ?>"<?= $Page->criterio->editAttributes() ?> aria-describedby="x_criterio_help"><?= $Page->criterio->EditValue ?></textarea>
<?= $Page->criterio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->criterio->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->arquivo->Visible) { // arquivo ?>
    <div id="r_arquivo"<?= $Page->arquivo->rowAttributes() ?>>
        <label id="elh_plano_auditoria_int_arquivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->arquivo->caption() ?><?= $Page->arquivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->arquivo->cellAttributes() ?>>
<span id="el_plano_auditoria_int_arquivo">
<div id="fd_x_arquivo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_arquivo"
        name="x_arquivo"
        class="form-control ew-file-input"
        title="<?= $Page->arquivo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="plano_auditoria_int"
        data-field="x_arquivo"
        data-size="120"
        data-accept-file-types="<?= $Page->arquivo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->arquivo->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->arquivo->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_arquivo_help"
        <?= ($Page->arquivo->ReadOnly || $Page->arquivo->Disabled) ? " disabled" : "" ?>
        <?= $Page->arquivo->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <?= $Page->arquivo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->arquivo->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_arquivo" id= "fn_x_arquivo" value="<?= $Page->arquivo->Upload->FileName ?>">
<input type="hidden" name="fa_x_arquivo" id= "fa_x_arquivo" value="<?= (Post("fa_x_arquivo") == "0") ? "0" : "1" ?>">
<table id="ft_x_arquivo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("item_plano_aud_int", explode(",", $Page->getCurrentDetailTable())) && $item_plano_aud_int->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("item_plano_aud_int", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ItemPlanoAudIntGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fplano_auditoria_intedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fplano_auditoria_intedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("plano_auditoria_int");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
