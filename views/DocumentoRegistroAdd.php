<?php

namespace PHPMaker2024\sgq;

// Page object
$DocumentoRegistroAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_registro: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fdocumento_registroadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdocumento_registroadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["titulo", [fields.titulo.visible && fields.titulo.required ? ew.Validators.required(fields.titulo.caption) : null], fields.titulo.isInvalid],
            ["categoria_documento_idcategoria_documento", [fields.categoria_documento_idcategoria_documento.visible && fields.categoria_documento_idcategoria_documento.required ? ew.Validators.required(fields.categoria_documento_idcategoria_documento.caption) : null], fields.categoria_documento_idcategoria_documento.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid],
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
            "categoria_documento_idcategoria_documento": <?= $Page->categoria_documento_idcategoria_documento->toClientList($Page) ?>,
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fdocumento_registroadd" id="fdocumento_registroadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="documento_registro">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->titulo->Visible) { // titulo ?>
    <div id="r_titulo"<?= $Page->titulo->rowAttributes() ?>>
        <label id="elh_documento_registro_titulo" for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titulo->caption() ?><?= $Page->titulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titulo->cellAttributes() ?>>
<span id="el_documento_registro_titulo">
<input type="<?= $Page->titulo->getInputTextType() ?>" name="x_titulo" id="x_titulo" data-table="documento_registro" data-field="x_titulo" value="<?= $Page->titulo->EditValue ?>" size="80" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo->formatPattern()) ?>"<?= $Page->titulo->editAttributes() ?> aria-describedby="x_titulo_help">
<?= $Page->titulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
    <div id="r_categoria_documento_idcategoria_documento"<?= $Page->categoria_documento_idcategoria_documento->rowAttributes() ?>>
        <label id="elh_documento_registro_categoria_documento_idcategoria_documento" for="x_categoria_documento_idcategoria_documento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->categoria_documento_idcategoria_documento->caption() ?><?= $Page->categoria_documento_idcategoria_documento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->categoria_documento_idcategoria_documento->cellAttributes() ?>>
<span id="el_documento_registro_categoria_documento_idcategoria_documento">
<div class="input-group flex-nowrap">
    <select
        id="x_categoria_documento_idcategoria_documento"
        name="x_categoria_documento_idcategoria_documento"
        class="form-control ew-select<?= $Page->categoria_documento_idcategoria_documento->isInvalidClass() ?>"
        data-select2-id="fdocumento_registroadd_x_categoria_documento_idcategoria_documento"
        data-table="documento_registro"
        data-field="x_categoria_documento_idcategoria_documento"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->categoria_documento_idcategoria_documento->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->categoria_documento_idcategoria_documento->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->categoria_documento_idcategoria_documento->getPlaceHolder()) ?>"
        <?= $Page->categoria_documento_idcategoria_documento->editAttributes() ?>>
        <?= $Page->categoria_documento_idcategoria_documento->selectOptionListHtml("x_categoria_documento_idcategoria_documento") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "categoria_documento") && !$Page->categoria_documento_idcategoria_documento->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_categoria_documento_idcategoria_documento" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->categoria_documento_idcategoria_documento->caption() ?>" data-title="<?= $Page->categoria_documento_idcategoria_documento->caption() ?>" data-ew-action="add-option" data-el="x_categoria_documento_idcategoria_documento" data-url="<?= GetUrl("CategoriaDocumentoAddopt") ?>"><i class="fa-solid fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<?= $Page->categoria_documento_idcategoria_documento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->categoria_documento_idcategoria_documento->getErrorMessage() ?></div>
<?= $Page->categoria_documento_idcategoria_documento->Lookup->getParamTag($Page, "p_x_categoria_documento_idcategoria_documento") ?>
<script>
loadjs.ready("fdocumento_registroadd", function() {
    var options = { name: "x_categoria_documento_idcategoria_documento", selectId: "fdocumento_registroadd_x_categoria_documento_idcategoria_documento" };
    if (fdocumento_registroadd.lists.categoria_documento_idcategoria_documento?.lookupOptions.length) {
        options.data = { id: "x_categoria_documento_idcategoria_documento", form: "fdocumento_registroadd" };
    } else {
        options.ajax = { id: "x_categoria_documento_idcategoria_documento", form: "fdocumento_registroadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.documento_registro.fields.categoria_documento_idcategoria_documento.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label id="elh_documento_registro_usuario_idusuario" for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_idusuario->caption() ?><?= $Page->usuario_idusuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_documento_registro_usuario_idusuario">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-select ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        <?php if (!$Page->usuario_idusuario->IsNativeSelect) { ?>
        data-select2-id="fdocumento_registroadd_x_usuario_idusuario"
        <?php } ?>
        data-table="documento_registro"
        data-field="x_usuario_idusuario"
        data-value-separator="<?= $Page->usuario_idusuario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_idusuario->getPlaceHolder()) ?>"
        <?= $Page->usuario_idusuario->editAttributes() ?>>
        <?= $Page->usuario_idusuario->selectOptionListHtml("x_usuario_idusuario") ?>
    </select>
    <?= $Page->usuario_idusuario->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->usuario_idusuario->getErrorMessage() ?></div>
<?= $Page->usuario_idusuario->Lookup->getParamTag($Page, "p_x_usuario_idusuario") ?>
<?php if (!$Page->usuario_idusuario->IsNativeSelect) { ?>
<script>
loadjs.ready("fdocumento_registroadd", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fdocumento_registroadd_x_usuario_idusuario" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdocumento_registroadd.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fdocumento_registroadd" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fdocumento_registroadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.documento_registro.fields.usuario_idusuario.selectOptions);
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
        <label id="elh_documento_registro_anexo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->anexo->caption() ?><?= $Page->anexo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->anexo->cellAttributes() ?>>
<span id="el_documento_registro_anexo">
<div id="fd_x_anexo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_anexo"
        name="x_anexo"
        class="form-control ew-file-input"
        title="<?= $Page->anexo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="documento_registro"
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdocumento_registroadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdocumento_registroadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("documento_registro");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
