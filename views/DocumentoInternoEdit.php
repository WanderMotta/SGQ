<?php

namespace PHPMaker2024\sgq;

// Page object
$DocumentoInternoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fdocumento_internoedit" id="fdocumento_internoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_interno: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fdocumento_internoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdocumento_internoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["iddocumento_interno", [fields.iddocumento_interno.visible && fields.iddocumento_interno.required ? ew.Validators.required(fields.iddocumento_interno.caption) : null], fields.iddocumento_interno.isInvalid],
            ["titulo_documento", [fields.titulo_documento.visible && fields.titulo_documento.required ? ew.Validators.required(fields.titulo_documento.caption) : null], fields.titulo_documento.isInvalid],
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["restringir_acesso", [fields.restringir_acesso.visible && fields.restringir_acesso.required ? ew.Validators.required(fields.restringir_acesso.caption) : null], fields.restringir_acesso.isInvalid],
            ["categoria_documento_idcategoria_documento", [fields.categoria_documento_idcategoria_documento.visible && fields.categoria_documento_idcategoria_documento.required ? ew.Validators.required(fields.categoria_documento_idcategoria_documento.caption) : null], fields.categoria_documento_idcategoria_documento.isInvalid],
            ["processo_idprocesso", [fields.processo_idprocesso.visible && fields.processo_idprocesso.required ? ew.Validators.required(fields.processo_idprocesso.caption) : null], fields.processo_idprocesso.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid]
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
            "restringir_acesso": <?= $Page->restringir_acesso->toClientList($Page) ?>,
            "categoria_documento_idcategoria_documento": <?= $Page->categoria_documento_idcategoria_documento->toClientList($Page) ?>,
            "processo_idprocesso": <?= $Page->processo_idprocesso->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="documento_interno">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->iddocumento_interno->Visible) { // iddocumento_interno ?>
    <div id="r_iddocumento_interno"<?= $Page->iddocumento_interno->rowAttributes() ?>>
        <label id="elh_documento_interno_iddocumento_interno" class="<?= $Page->LeftColumnClass ?>"><?= $Page->iddocumento_interno->caption() ?><?= $Page->iddocumento_interno->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->iddocumento_interno->cellAttributes() ?>>
<span id="el_documento_interno_iddocumento_interno">
<span<?= $Page->iddocumento_interno->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->iddocumento_interno->getDisplayValue($Page->iddocumento_interno->EditValue))) ?>"></span>
<input type="hidden" data-table="documento_interno" data-field="x_iddocumento_interno" data-hidden="1" name="x_iddocumento_interno" id="x_iddocumento_interno" value="<?= HtmlEncode($Page->iddocumento_interno->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
    <div id="r_titulo_documento"<?= $Page->titulo_documento->rowAttributes() ?>>
        <label id="elh_documento_interno_titulo_documento" for="x_titulo_documento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titulo_documento->caption() ?><?= $Page->titulo_documento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titulo_documento->cellAttributes() ?>>
<span id="el_documento_interno_titulo_documento">
<input type="<?= $Page->titulo_documento->getInputTextType() ?>" name="x_titulo_documento" id="x_titulo_documento" data-table="documento_interno" data-field="x_titulo_documento" value="<?= $Page->titulo_documento->EditValue ?>" size="80" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo_documento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo_documento->formatPattern()) ?>"<?= $Page->titulo_documento->editAttributes() ?> aria-describedby="x_titulo_documento_help">
<?= $Page->titulo_documento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titulo_documento->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
    <div id="r_restringir_acesso"<?= $Page->restringir_acesso->rowAttributes() ?>>
        <label id="elh_documento_interno_restringir_acesso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->restringir_acesso->caption() ?><?= $Page->restringir_acesso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->restringir_acesso->cellAttributes() ?>>
<span id="el_documento_interno_restringir_acesso">
<template id="tp_x_restringir_acesso">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="documento_interno" data-field="x_restringir_acesso" name="x_restringir_acesso" id="x_restringir_acesso"<?= $Page->restringir_acesso->editAttributes() ?>>
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
    data-table="documento_interno"
    data-field="x_restringir_acesso"
    data-value-separator="<?= $Page->restringir_acesso->displayValueSeparatorAttribute() ?>"
    <?= $Page->restringir_acesso->editAttributes() ?>></selection-list>
<?= $Page->restringir_acesso->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->restringir_acesso->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
    <div id="r_categoria_documento_idcategoria_documento"<?= $Page->categoria_documento_idcategoria_documento->rowAttributes() ?>>
        <label id="elh_documento_interno_categoria_documento_idcategoria_documento" for="x_categoria_documento_idcategoria_documento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->categoria_documento_idcategoria_documento->caption() ?><?= $Page->categoria_documento_idcategoria_documento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->categoria_documento_idcategoria_documento->cellAttributes() ?>>
<span id="el_documento_interno_categoria_documento_idcategoria_documento">
<div class="input-group flex-nowrap">
    <select
        id="x_categoria_documento_idcategoria_documento"
        name="x_categoria_documento_idcategoria_documento"
        class="form-control ew-select<?= $Page->categoria_documento_idcategoria_documento->isInvalidClass() ?>"
        data-select2-id="fdocumento_internoedit_x_categoria_documento_idcategoria_documento"
        data-table="documento_interno"
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
loadjs.ready("fdocumento_internoedit", function() {
    var options = { name: "x_categoria_documento_idcategoria_documento", selectId: "fdocumento_internoedit_x_categoria_documento_idcategoria_documento" };
    if (fdocumento_internoedit.lists.categoria_documento_idcategoria_documento?.lookupOptions.length) {
        options.data = { id: "x_categoria_documento_idcategoria_documento", form: "fdocumento_internoedit" };
    } else {
        options.ajax = { id: "x_categoria_documento_idcategoria_documento", form: "fdocumento_internoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.documento_interno.fields.categoria_documento_idcategoria_documento.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <div id="r_processo_idprocesso"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <label id="elh_documento_interno_processo_idprocesso" for="x_processo_idprocesso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->processo_idprocesso->caption() ?><?= $Page->processo_idprocesso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el_documento_interno_processo_idprocesso">
    <select
        id="x_processo_idprocesso"
        name="x_processo_idprocesso"
        class="form-select ew-select<?= $Page->processo_idprocesso->isInvalidClass() ?>"
        <?php if (!$Page->processo_idprocesso->IsNativeSelect) { ?>
        data-select2-id="fdocumento_internoedit_x_processo_idprocesso"
        <?php } ?>
        data-table="documento_interno"
        data-field="x_processo_idprocesso"
        data-value-separator="<?= $Page->processo_idprocesso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->processo_idprocesso->getPlaceHolder()) ?>"
        <?= $Page->processo_idprocesso->editAttributes() ?>>
        <?= $Page->processo_idprocesso->selectOptionListHtml("x_processo_idprocesso") ?>
    </select>
    <?= $Page->processo_idprocesso->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->processo_idprocesso->getErrorMessage() ?></div>
<?= $Page->processo_idprocesso->Lookup->getParamTag($Page, "p_x_processo_idprocesso") ?>
<?php if (!$Page->processo_idprocesso->IsNativeSelect) { ?>
<script>
loadjs.ready("fdocumento_internoedit", function() {
    var options = { name: "x_processo_idprocesso", selectId: "fdocumento_internoedit_x_processo_idprocesso" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdocumento_internoedit.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x_processo_idprocesso", form: "fdocumento_internoedit" };
    } else {
        options.ajax = { id: "x_processo_idprocesso", form: "fdocumento_internoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.documento_interno.fields.processo_idprocesso.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label id="elh_documento_interno_usuario_idusuario" for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_idusuario->caption() ?><?= $Page->usuario_idusuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_documento_interno_usuario_idusuario">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-control ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        data-select2-id="fdocumento_internoedit_x_usuario_idusuario"
        data-table="documento_interno"
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
loadjs.ready("fdocumento_internoedit", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fdocumento_internoedit_x_usuario_idusuario" };
    if (fdocumento_internoedit.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fdocumento_internoedit" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fdocumento_internoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.documento_interno.fields.usuario_idusuario.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("revisao_documento", explode(",", $Page->getCurrentDetailTable())) && $revisao_documento->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("revisao_documento", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "RevisaoDocumentoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdocumento_internoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdocumento_internoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("documento_interno");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
