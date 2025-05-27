<?php

namespace PHPMaker2024\sgq;

// Page object
$RevisaoDocumentoSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { revisao_documento: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var frevisao_documentosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frevisao_documentosearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idrevisao_documento", [ew.Validators.integer], fields.idrevisao_documento.isInvalid],
            ["documento_interno_iddocumento_interno", [], fields.documento_interno_iddocumento_interno.isInvalid],
            ["dt_cadastro", [ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["qual_alteracao", [], fields.qual_alteracao.isInvalid],
            ["status_documento_idstatus_documento", [], fields.status_documento_idstatus_documento.isInvalid],
            ["revisao_nr", [ew.Validators.integer], fields.revisao_nr.isInvalid],
            ["usuario_elaborador", [], fields.usuario_elaborador.isInvalid],
            ["usuario_aprovador", [], fields.usuario_aprovador.isInvalid],
            ["dt_aprovacao", [ew.Validators.datetime(fields.dt_aprovacao.clientFormatPattern)], fields.dt_aprovacao.isInvalid],
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
            "documento_interno_iddocumento_interno": <?= $Page->documento_interno_iddocumento_interno->toClientList($Page) ?>,
            "status_documento_idstatus_documento": <?= $Page->status_documento_idstatus_documento->toClientList($Page) ?>,
            "usuario_elaborador": <?= $Page->usuario_elaborador->toClientList($Page) ?>,
            "usuario_aprovador": <?= $Page->usuario_aprovador->toClientList($Page) ?>,
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
<form name="frevisao_documentosearch" id="frevisao_documentosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="revisao_documento">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idrevisao_documento->Visible) { // idrevisao_documento ?>
    <div id="r_idrevisao_documento" class="row"<?= $Page->idrevisao_documento->rowAttributes() ?>>
        <label for="x_idrevisao_documento" class="<?= $Page->LeftColumnClass ?>"><span id="elh_revisao_documento_idrevisao_documento"><?= $Page->idrevisao_documento->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idrevisao_documento" id="z_idrevisao_documento" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idrevisao_documento->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_revisao_documento_idrevisao_documento" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idrevisao_documento->getInputTextType() ?>" name="x_idrevisao_documento" id="x_idrevisao_documento" data-table="revisao_documento" data-field="x_idrevisao_documento" value="<?= $Page->idrevisao_documento->EditValue ?>" placeholder="<?= HtmlEncode($Page->idrevisao_documento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idrevisao_documento->formatPattern()) ?>"<?= $Page->idrevisao_documento->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idrevisao_documento->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->documento_interno_iddocumento_interno->Visible) { // documento_interno_iddocumento_interno ?>
    <div id="r_documento_interno_iddocumento_interno" class="row"<?= $Page->documento_interno_iddocumento_interno->rowAttributes() ?>>
        <label for="x_documento_interno_iddocumento_interno" class="<?= $Page->LeftColumnClass ?>"><span id="elh_revisao_documento_documento_interno_iddocumento_interno"><?= $Page->documento_interno_iddocumento_interno->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_documento_interno_iddocumento_interno" id="z_documento_interno_iddocumento_interno" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->documento_interno_iddocumento_interno->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_revisao_documento_documento_interno_iddocumento_interno" class="ew-search-field ew-search-field-single">
    <select
        id="x_documento_interno_iddocumento_interno"
        name="x_documento_interno_iddocumento_interno"
        class="form-select ew-select<?= $Page->documento_interno_iddocumento_interno->isInvalidClass() ?>"
        <?php if (!$Page->documento_interno_iddocumento_interno->IsNativeSelect) { ?>
        data-select2-id="frevisao_documentosearch_x_documento_interno_iddocumento_interno"
        <?php } ?>
        data-table="revisao_documento"
        data-field="x_documento_interno_iddocumento_interno"
        data-value-separator="<?= $Page->documento_interno_iddocumento_interno->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->documento_interno_iddocumento_interno->getPlaceHolder()) ?>"
        <?= $Page->documento_interno_iddocumento_interno->editAttributes() ?>>
        <?= $Page->documento_interno_iddocumento_interno->selectOptionListHtml("x_documento_interno_iddocumento_interno") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->documento_interno_iddocumento_interno->getErrorMessage(false) ?></div>
<?= $Page->documento_interno_iddocumento_interno->Lookup->getParamTag($Page, "p_x_documento_interno_iddocumento_interno") ?>
<?php if (!$Page->documento_interno_iddocumento_interno->IsNativeSelect) { ?>
<script>
loadjs.ready("frevisao_documentosearch", function() {
    var options = { name: "x_documento_interno_iddocumento_interno", selectId: "frevisao_documentosearch_x_documento_interno_iddocumento_interno" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frevisao_documentosearch.lists.documento_interno_iddocumento_interno?.lookupOptions.length) {
        options.data = { id: "x_documento_interno_iddocumento_interno", form: "frevisao_documentosearch" };
    } else {
        options.ajax = { id: "x_documento_interno_iddocumento_interno", form: "frevisao_documentosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.revisao_documento.fields.documento_interno_iddocumento_interno.selectOptions);
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
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro" class="row"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_revisao_documento_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_cadastro" id="z_dt_cadastro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_cadastro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_revisao_documento_dt_cadastro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="revisao_documento" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frevisao_documentosearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frevisao_documentosearch", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->qual_alteracao->Visible) { // qual_alteracao ?>
    <div id="r_qual_alteracao" class="row"<?= $Page->qual_alteracao->rowAttributes() ?>>
        <label for="x_qual_alteracao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_revisao_documento_qual_alteracao"><?= $Page->qual_alteracao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_qual_alteracao" id="z_qual_alteracao" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->qual_alteracao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_revisao_documento_qual_alteracao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->qual_alteracao->getInputTextType() ?>" name="x_qual_alteracao" id="x_qual_alteracao" data-table="revisao_documento" data-field="x_qual_alteracao" value="<?= $Page->qual_alteracao->EditValue ?>" size="50" maxlength="65535" placeholder="<?= HtmlEncode($Page->qual_alteracao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->qual_alteracao->formatPattern()) ?>"<?= $Page->qual_alteracao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->qual_alteracao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
    <div id="r_status_documento_idstatus_documento" class="row"<?= $Page->status_documento_idstatus_documento->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_revisao_documento_status_documento_idstatus_documento"><?= $Page->status_documento_idstatus_documento->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status_documento_idstatus_documento" id="z_status_documento_idstatus_documento" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->status_documento_idstatus_documento->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_revisao_documento_status_documento_idstatus_documento" class="ew-search-field ew-search-field-single">
<template id="tp_x_status_documento_idstatus_documento">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="revisao_documento" data-field="x_status_documento_idstatus_documento" name="x_status_documento_idstatus_documento" id="x_status_documento_idstatus_documento"<?= $Page->status_documento_idstatus_documento->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status_documento_idstatus_documento" class="ew-item-list"></div>
<selection-list hidden
    id="x_status_documento_idstatus_documento"
    name="x_status_documento_idstatus_documento"
    value="<?= HtmlEncode($Page->status_documento_idstatus_documento->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_status_documento_idstatus_documento"
    data-target="dsl_x_status_documento_idstatus_documento"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status_documento_idstatus_documento->isInvalidClass() ?>"
    data-table="revisao_documento"
    data-field="x_status_documento_idstatus_documento"
    data-value-separator="<?= $Page->status_documento_idstatus_documento->displayValueSeparatorAttribute() ?>"
    <?= $Page->status_documento_idstatus_documento->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->status_documento_idstatus_documento->getErrorMessage(false) ?></div>
<?= $Page->status_documento_idstatus_documento->Lookup->getParamTag($Page, "p_x_status_documento_idstatus_documento") ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->revisao_nr->Visible) { // revisao_nr ?>
    <div id="r_revisao_nr" class="row"<?= $Page->revisao_nr->rowAttributes() ?>>
        <label for="x_revisao_nr" class="<?= $Page->LeftColumnClass ?>"><span id="elh_revisao_documento_revisao_nr"><?= $Page->revisao_nr->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_revisao_nr" id="z_revisao_nr" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->revisao_nr->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_revisao_documento_revisao_nr" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->revisao_nr->getInputTextType() ?>" name="x_revisao_nr" id="x_revisao_nr" data-table="revisao_documento" data-field="x_revisao_nr" value="<?= $Page->revisao_nr->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->revisao_nr->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->revisao_nr->formatPattern()) ?>"<?= $Page->revisao_nr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->revisao_nr->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->usuario_elaborador->Visible) { // usuario_elaborador ?>
    <div id="r_usuario_elaborador" class="row"<?= $Page->usuario_elaborador->rowAttributes() ?>>
        <label for="x_usuario_elaborador" class="<?= $Page->LeftColumnClass ?>"><span id="elh_revisao_documento_usuario_elaborador"><?= $Page->usuario_elaborador->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_usuario_elaborador" id="z_usuario_elaborador" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->usuario_elaborador->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_revisao_documento_usuario_elaborador" class="ew-search-field ew-search-field-single">
    <select
        id="x_usuario_elaborador"
        name="x_usuario_elaborador"
        class="form-select ew-select<?= $Page->usuario_elaborador->isInvalidClass() ?>"
        <?php if (!$Page->usuario_elaborador->IsNativeSelect) { ?>
        data-select2-id="frevisao_documentosearch_x_usuario_elaborador"
        <?php } ?>
        data-table="revisao_documento"
        data-field="x_usuario_elaborador"
        data-value-separator="<?= $Page->usuario_elaborador->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_elaborador->getPlaceHolder()) ?>"
        <?= $Page->usuario_elaborador->editAttributes() ?>>
        <?= $Page->usuario_elaborador->selectOptionListHtml("x_usuario_elaborador") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->usuario_elaborador->getErrorMessage(false) ?></div>
<?= $Page->usuario_elaborador->Lookup->getParamTag($Page, "p_x_usuario_elaborador") ?>
<?php if (!$Page->usuario_elaborador->IsNativeSelect) { ?>
<script>
loadjs.ready("frevisao_documentosearch", function() {
    var options = { name: "x_usuario_elaborador", selectId: "frevisao_documentosearch_x_usuario_elaborador" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frevisao_documentosearch.lists.usuario_elaborador?.lookupOptions.length) {
        options.data = { id: "x_usuario_elaborador", form: "frevisao_documentosearch" };
    } else {
        options.ajax = { id: "x_usuario_elaborador", form: "frevisao_documentosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.revisao_documento.fields.usuario_elaborador.selectOptions);
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
<?php if ($Page->usuario_aprovador->Visible) { // usuario_aprovador ?>
    <div id="r_usuario_aprovador" class="row"<?= $Page->usuario_aprovador->rowAttributes() ?>>
        <label for="x_usuario_aprovador" class="<?= $Page->LeftColumnClass ?>"><span id="elh_revisao_documento_usuario_aprovador"><?= $Page->usuario_aprovador->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_usuario_aprovador" id="z_usuario_aprovador" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->usuario_aprovador->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_revisao_documento_usuario_aprovador" class="ew-search-field ew-search-field-single">
    <select
        id="x_usuario_aprovador"
        name="x_usuario_aprovador"
        class="form-select ew-select<?= $Page->usuario_aprovador->isInvalidClass() ?>"
        <?php if (!$Page->usuario_aprovador->IsNativeSelect) { ?>
        data-select2-id="frevisao_documentosearch_x_usuario_aprovador"
        <?php } ?>
        data-table="revisao_documento"
        data-field="x_usuario_aprovador"
        data-value-separator="<?= $Page->usuario_aprovador->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_aprovador->getPlaceHolder()) ?>"
        <?= $Page->usuario_aprovador->editAttributes() ?>>
        <?= $Page->usuario_aprovador->selectOptionListHtml("x_usuario_aprovador") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->usuario_aprovador->getErrorMessage(false) ?></div>
<?= $Page->usuario_aprovador->Lookup->getParamTag($Page, "p_x_usuario_aprovador") ?>
<?php if (!$Page->usuario_aprovador->IsNativeSelect) { ?>
<script>
loadjs.ready("frevisao_documentosearch", function() {
    var options = { name: "x_usuario_aprovador", selectId: "frevisao_documentosearch_x_usuario_aprovador" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frevisao_documentosearch.lists.usuario_aprovador?.lookupOptions.length) {
        options.data = { id: "x_usuario_aprovador", form: "frevisao_documentosearch" };
    } else {
        options.ajax = { id: "x_usuario_aprovador", form: "frevisao_documentosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.revisao_documento.fields.usuario_aprovador.selectOptions);
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
<?php if ($Page->dt_aprovacao->Visible) { // dt_aprovacao ?>
    <div id="r_dt_aprovacao" class="row"<?= $Page->dt_aprovacao->rowAttributes() ?>>
        <label for="x_dt_aprovacao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_revisao_documento_dt_aprovacao"><?= $Page->dt_aprovacao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_aprovacao" id="z_dt_aprovacao" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_aprovacao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_revisao_documento_dt_aprovacao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_aprovacao->getInputTextType() ?>" name="x_dt_aprovacao" id="x_dt_aprovacao" data-table="revisao_documento" data-field="x_dt_aprovacao" value="<?= $Page->dt_aprovacao->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_aprovacao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_aprovacao->formatPattern()) ?>"<?= $Page->dt_aprovacao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_aprovacao->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_aprovacao->ReadOnly && !$Page->dt_aprovacao->Disabled && !isset($Page->dt_aprovacao->EditAttrs["readonly"]) && !isset($Page->dt_aprovacao->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frevisao_documentosearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frevisao_documentosearch", "x_dt_aprovacao", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_revisao_documento_anexo"><?= $Page->anexo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_anexo" id="z_anexo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->anexo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_revisao_documento_anexo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->anexo->getInputTextType() ?>" name="x_anexo" id="x_anexo" data-table="revisao_documento" data-field="x_anexo" value="<?= $Page->anexo->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->anexo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->anexo->formatPattern()) ?>"<?= $Page->anexo->editAttributes() ?>>
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
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="frevisao_documentosearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="frevisao_documentosearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="frevisao_documentosearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
