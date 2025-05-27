<?php

namespace PHPMaker2024\sgq;

// Page object
$DocumentoRegistroSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_registro: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fdocumento_registrosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fdocumento_registrosearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["iddocumento_registro", [ew.Validators.integer], fields.iddocumento_registro.isInvalid],
            ["dt_cadastro", [ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["titulo", [], fields.titulo.isInvalid],
            ["categoria_documento_idcategoria_documento", [], fields.categoria_documento_idcategoria_documento.isInvalid],
            ["usuario_idusuario", [], fields.usuario_idusuario.isInvalid],
            ["anexo", [], fields.anexo.isInvalid]
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
            "categoria_documento_idcategoria_documento": <?= $Page->categoria_documento_idcategoria_documento->toClientList($Page) ?>,
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
<form name="fdocumento_registrosearch" id="fdocumento_registrosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="documento_registro">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->iddocumento_registro->Visible) { // iddocumento_registro ?>
    <div id="r_iddocumento_registro" class="row"<?= $Page->iddocumento_registro->rowAttributes() ?>>
        <label for="x_iddocumento_registro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_registro_iddocumento_registro"><?= $Page->iddocumento_registro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_iddocumento_registro" id="z_iddocumento_registro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->iddocumento_registro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_registro_iddocumento_registro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->iddocumento_registro->getInputTextType() ?>" name="x_iddocumento_registro" id="x_iddocumento_registro" data-table="documento_registro" data-field="x_iddocumento_registro" value="<?= $Page->iddocumento_registro->EditValue ?>" placeholder="<?= HtmlEncode($Page->iddocumento_registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->iddocumento_registro->formatPattern()) ?>"<?= $Page->iddocumento_registro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->iddocumento_registro->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro" class="row"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_registro_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_cadastro" id="z_dt_cadastro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_cadastro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_registro_dt_cadastro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="documento_registro" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdocumento_registrosearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdocumento_registrosearch", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <div id="r_titulo" class="row"<?= $Page->titulo->rowAttributes() ?>>
        <label for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_registro_titulo"><?= $Page->titulo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_titulo" id="z_titulo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->titulo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_registro_titulo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->titulo->getInputTextType() ?>" name="x_titulo" id="x_titulo" data-table="documento_registro" data-field="x_titulo" value="<?= $Page->titulo->EditValue ?>" size="80" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo->formatPattern()) ?>"<?= $Page->titulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
    <div id="r_categoria_documento_idcategoria_documento" class="row"<?= $Page->categoria_documento_idcategoria_documento->rowAttributes() ?>>
        <label for="x_categoria_documento_idcategoria_documento" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_registro_categoria_documento_idcategoria_documento"><?= $Page->categoria_documento_idcategoria_documento->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_categoria_documento_idcategoria_documento" id="z_categoria_documento_idcategoria_documento" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->categoria_documento_idcategoria_documento->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_registro_categoria_documento_idcategoria_documento" class="ew-search-field ew-search-field-single">
    <select
        id="x_categoria_documento_idcategoria_documento"
        name="x_categoria_documento_idcategoria_documento"
        class="form-control ew-select<?= $Page->categoria_documento_idcategoria_documento->isInvalidClass() ?>"
        data-select2-id="fdocumento_registrosearch_x_categoria_documento_idcategoria_documento"
        data-table="documento_registro"
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
loadjs.ready("fdocumento_registrosearch", function() {
    var options = { name: "x_categoria_documento_idcategoria_documento", selectId: "fdocumento_registrosearch_x_categoria_documento_idcategoria_documento" };
    if (fdocumento_registrosearch.lists.categoria_documento_idcategoria_documento?.lookupOptions.length) {
        options.data = { id: "x_categoria_documento_idcategoria_documento", form: "fdocumento_registrosearch" };
    } else {
        options.ajax = { id: "x_categoria_documento_idcategoria_documento", form: "fdocumento_registrosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.documento_registro.fields.categoria_documento_idcategoria_documento.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario" class="row"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_registro_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_usuario_idusuario" id="z_usuario_idusuario" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->usuario_idusuario->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_registro_usuario_idusuario" class="ew-search-field ew-search-field-single">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-select ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        <?php if (!$Page->usuario_idusuario->IsNativeSelect) { ?>
        data-select2-id="fdocumento_registrosearch_x_usuario_idusuario"
        <?php } ?>
        data-table="documento_registro"
        data-field="x_usuario_idusuario"
        data-value-separator="<?= $Page->usuario_idusuario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_idusuario->getPlaceHolder()) ?>"
        <?= $Page->usuario_idusuario->editAttributes() ?>>
        <?= $Page->usuario_idusuario->selectOptionListHtml("x_usuario_idusuario") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->usuario_idusuario->getErrorMessage(false) ?></div>
<?= $Page->usuario_idusuario->Lookup->getParamTag($Page, "p_x_usuario_idusuario") ?>
<?php if (!$Page->usuario_idusuario->IsNativeSelect) { ?>
<script>
loadjs.ready("fdocumento_registrosearch", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fdocumento_registrosearch_x_usuario_idusuario" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdocumento_registrosearch.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fdocumento_registrosearch" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fdocumento_registrosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.documento_registro.fields.usuario_idusuario.selectOptions);
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
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_documento_registro_anexo"><?= $Page->anexo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_anexo" id="z_anexo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->anexo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_documento_registro_anexo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->anexo->getInputTextType() ?>" name="x_anexo" id="x_anexo" data-table="documento_registro" data-field="x_anexo" value="<?= $Page->anexo->EditValue ?>" size="80" maxlength="120" placeholder="<?= HtmlEncode($Page->anexo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->anexo->formatPattern()) ?>"<?= $Page->anexo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->anexo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdocumento_registrosearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdocumento_registrosearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fdocumento_registrosearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
