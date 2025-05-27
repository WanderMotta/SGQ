<?php

namespace PHPMaker2024\sgq;

// Page object
$DocumentoInternoSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_interno: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fdocumento_internosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fdocumento_internosearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["iddocumento_interno", [ew.Validators.integer], fields.iddocumento_interno.isInvalid],
            ["titulo_documento", [], fields.titulo_documento.isInvalid],
            ["dt_cadastro", [ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["restringir_acesso", [], fields.restringir_acesso.isInvalid],
            ["categoria_documento_idcategoria_documento", [], fields.categoria_documento_idcategoria_documento.isInvalid],
            ["processo_idprocesso", [], fields.processo_idprocesso.isInvalid],
            ["usuario_idusuario", [], fields.usuario_idusuario.isInvalid]
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
            "restringir_acesso": <?= $Page->restringir_acesso->toClientList($Page) ?>,
            "categoria_documento_idcategoria_documento": <?= $Page->categoria_documento_idcategoria_documento->toClientList($Page) ?>,
            "processo_idprocesso": <?= $Page->processo_idprocesso->toClientList($Page) ?>,
            "usuario_idusuario": <?= $Page->usuario_idusuario->toClientList($Page) ?>,
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
<form name="fdocumento_internosearch" id="fdocumento_internosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="documento_interno">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->iddocumento_interno->Visible) { // iddocumento_interno ?>
    <div id="r_iddocumento_interno" class="row"<?= $Page->iddocumento_interno->rowAttributes() ?>>
        <label for="x_iddocumento_interno" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_interno_iddocumento_interno"><?= $Page->iddocumento_interno->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_iddocumento_interno" id="z_iddocumento_interno" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->iddocumento_interno->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_interno_iddocumento_interno" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->iddocumento_interno->getInputTextType() ?>" name="x_iddocumento_interno" id="x_iddocumento_interno" data-table="documento_interno" data-field="x_iddocumento_interno" value="<?= $Page->iddocumento_interno->EditValue ?>" placeholder="<?= HtmlEncode($Page->iddocumento_interno->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->iddocumento_interno->formatPattern()) ?>"<?= $Page->iddocumento_interno->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->iddocumento_interno->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
    <div id="r_titulo_documento" class="row"<?= $Page->titulo_documento->rowAttributes() ?>>
        <label for="x_titulo_documento" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_interno_titulo_documento"><?= $Page->titulo_documento->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_titulo_documento" id="z_titulo_documento" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->titulo_documento->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_interno_titulo_documento" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->titulo_documento->getInputTextType() ?>" name="x_titulo_documento" id="x_titulo_documento" data-table="documento_interno" data-field="x_titulo_documento" value="<?= $Page->titulo_documento->EditValue ?>" size="80" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo_documento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo_documento->formatPattern()) ?>"<?= $Page->titulo_documento->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->titulo_documento->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro" class="row"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_interno_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_cadastro" id="z_dt_cadastro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_cadastro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_interno_dt_cadastro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="documento_interno" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdocumento_internosearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdocumento_internosearch", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
    <div id="r_restringir_acesso" class="row"<?= $Page->restringir_acesso->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_interno_restringir_acesso"><?= $Page->restringir_acesso->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_restringir_acesso" id="z_restringir_acesso" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->restringir_acesso->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_interno_restringir_acesso" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->restringir_acesso->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_restringir_acesso"
    data-target="dsl_x_restringir_acesso"
    data-repeatcolumn="5"
    class="form-control<?= $Page->restringir_acesso->isInvalidClass() ?>"
    data-table="documento_interno"
    data-field="x_restringir_acesso"
    data-value-separator="<?= $Page->restringir_acesso->displayValueSeparatorAttribute() ?>"
    <?= $Page->restringir_acesso->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->restringir_acesso->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
    <div id="r_categoria_documento_idcategoria_documento" class="row"<?= $Page->categoria_documento_idcategoria_documento->rowAttributes() ?>>
        <label for="x_categoria_documento_idcategoria_documento" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_interno_categoria_documento_idcategoria_documento"><?= $Page->categoria_documento_idcategoria_documento->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_categoria_documento_idcategoria_documento" id="z_categoria_documento_idcategoria_documento" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->categoria_documento_idcategoria_documento->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_interno_categoria_documento_idcategoria_documento" class="ew-search-field ew-search-field-single">
    <select
        id="x_categoria_documento_idcategoria_documento"
        name="x_categoria_documento_idcategoria_documento"
        class="form-control ew-select<?= $Page->categoria_documento_idcategoria_documento->isInvalidClass() ?>"
        data-select2-id="fdocumento_internosearch_x_categoria_documento_idcategoria_documento"
        data-table="documento_interno"
        data-field="x_categoria_documento_idcategoria_documento"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->categoria_documento_idcategoria_documento->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->categoria_documento_idcategoria_documento->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->categoria_documento_idcategoria_documento->getPlaceHolder()) ?>"
        <?= $Page->categoria_documento_idcategoria_documento->editAttributes() ?>>
        <?= $Page->categoria_documento_idcategoria_documento->selectOptionListHtml("x_categoria_documento_idcategoria_documento") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->categoria_documento_idcategoria_documento->getErrorMessage(false) ?></div>
<?= $Page->categoria_documento_idcategoria_documento->Lookup->getParamTag($Page, "p_x_categoria_documento_idcategoria_documento") ?>
<script>
loadjs.ready("fdocumento_internosearch", function() {
    var options = { name: "x_categoria_documento_idcategoria_documento", selectId: "fdocumento_internosearch_x_categoria_documento_idcategoria_documento" };
    if (fdocumento_internosearch.lists.categoria_documento_idcategoria_documento?.lookupOptions.length) {
        options.data = { id: "x_categoria_documento_idcategoria_documento", form: "fdocumento_internosearch" };
    } else {
        options.ajax = { id: "x_categoria_documento_idcategoria_documento", form: "fdocumento_internosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.documento_interno.fields.categoria_documento_idcategoria_documento.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <div id="r_processo_idprocesso" class="row"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <label for="x_processo_idprocesso" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_interno_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_processo_idprocesso" id="z_processo_idprocesso" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->processo_idprocesso->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_interno_processo_idprocesso" class="ew-search-field ew-search-field-single">
    <select
        id="x_processo_idprocesso"
        name="x_processo_idprocesso"
        class="form-select ew-select<?= $Page->processo_idprocesso->isInvalidClass() ?>"
        <?php if (!$Page->processo_idprocesso->IsNativeSelect) { ?>
        data-select2-id="fdocumento_internosearch_x_processo_idprocesso"
        <?php } ?>
        data-table="documento_interno"
        data-field="x_processo_idprocesso"
        data-value-separator="<?= $Page->processo_idprocesso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->processo_idprocesso->getPlaceHolder()) ?>"
        <?= $Page->processo_idprocesso->editAttributes() ?>>
        <?= $Page->processo_idprocesso->selectOptionListHtml("x_processo_idprocesso") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->processo_idprocesso->getErrorMessage(false) ?></div>
<?= $Page->processo_idprocesso->Lookup->getParamTag($Page, "p_x_processo_idprocesso") ?>
<?php if (!$Page->processo_idprocesso->IsNativeSelect) { ?>
<script>
loadjs.ready("fdocumento_internosearch", function() {
    var options = { name: "x_processo_idprocesso", selectId: "fdocumento_internosearch_x_processo_idprocesso" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdocumento_internosearch.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x_processo_idprocesso", form: "fdocumento_internosearch" };
    } else {
        options.ajax = { id: "x_processo_idprocesso", form: "fdocumento_internosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.documento_interno.fields.processo_idprocesso.selectOptions);
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
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario" class="row"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_interno_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_usuario_idusuario" id="z_usuario_idusuario" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->usuario_idusuario->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_interno_usuario_idusuario" class="ew-search-field ew-search-field-single">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-control ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        data-select2-id="fdocumento_internosearch_x_usuario_idusuario"
        data-table="documento_interno"
        data-field="x_usuario_idusuario"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->usuario_idusuario->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->usuario_idusuario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_idusuario->getPlaceHolder()) ?>"
        <?= $Page->usuario_idusuario->editAttributes() ?>>
        <?= $Page->usuario_idusuario->selectOptionListHtml("x_usuario_idusuario") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->usuario_idusuario->getErrorMessage(false) ?></div>
<?= $Page->usuario_idusuario->Lookup->getParamTag($Page, "p_x_usuario_idusuario") ?>
<script>
loadjs.ready("fdocumento_internosearch", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fdocumento_internosearch_x_usuario_idusuario" };
    if (fdocumento_internosearch.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fdocumento_internosearch" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fdocumento_internosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.documento_interno.fields.usuario_idusuario.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdocumento_internosearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdocumento_internosearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fdocumento_internosearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("documento_interno");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
