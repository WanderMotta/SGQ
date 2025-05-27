<?php

namespace PHPMaker2024\sgq;

// Page object
$ObjetivoQualidadeSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { objetivo_qualidade: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fobjetivo_qualidadesearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fobjetivo_qualidadesearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idobjetivo_qualidade", [ew.Validators.integer], fields.idobjetivo_qualidade.isInvalid],
            ["dt_cadastro", [ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["processo_idprocesso", [], fields.processo_idprocesso.isInvalid],
            ["objetivo", [], fields.objetivo.isInvalid],
            ["como_medir", [], fields.como_medir.isInvalid],
            ["o_q_sera_feito", [], fields.o_q_sera_feito.isInvalid],
            ["como_avaliar", [], fields.como_avaliar.isInvalid],
            ["departamentos_iddepartamentos", [], fields.departamentos_iddepartamentos.isInvalid]
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
            "processo_idprocesso": <?= $Page->processo_idprocesso->toClientList($Page) ?>,
            "departamentos_iddepartamentos": <?= $Page->departamentos_iddepartamentos->toClientList($Page) ?>,
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
<form name="fobjetivo_qualidadesearch" id="fobjetivo_qualidadesearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="objetivo_qualidade">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idobjetivo_qualidade->Visible) { // idobjetivo_qualidade ?>
    <div id="r_idobjetivo_qualidade" class="row"<?= $Page->idobjetivo_qualidade->rowAttributes() ?>>
        <label for="x_idobjetivo_qualidade" class="<?= $Page->LeftColumnClass ?>"><span id="elh_objetivo_qualidade_idobjetivo_qualidade"><?= $Page->idobjetivo_qualidade->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idobjetivo_qualidade" id="z_idobjetivo_qualidade" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idobjetivo_qualidade->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_objetivo_qualidade_idobjetivo_qualidade" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idobjetivo_qualidade->getInputTextType() ?>" name="x_idobjetivo_qualidade" id="x_idobjetivo_qualidade" data-table="objetivo_qualidade" data-field="x_idobjetivo_qualidade" value="<?= $Page->idobjetivo_qualidade->EditValue ?>" placeholder="<?= HtmlEncode($Page->idobjetivo_qualidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idobjetivo_qualidade->formatPattern()) ?>"<?= $Page->idobjetivo_qualidade->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idobjetivo_qualidade->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro" class="row"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_objetivo_qualidade_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_cadastro" id="z_dt_cadastro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_cadastro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_objetivo_qualidade_dt_cadastro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="objetivo_qualidade" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fobjetivo_qualidadesearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fobjetivo_qualidadesearch", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <div id="r_processo_idprocesso" class="row"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <label for="x_processo_idprocesso" class="<?= $Page->LeftColumnClass ?>"><span id="elh_objetivo_qualidade_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_processo_idprocesso" id="z_processo_idprocesso" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->processo_idprocesso->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_objetivo_qualidade_processo_idprocesso" class="ew-search-field ew-search-field-single">
    <select
        id="x_processo_idprocesso"
        name="x_processo_idprocesso"
        class="form-select ew-select<?= $Page->processo_idprocesso->isInvalidClass() ?>"
        <?php if (!$Page->processo_idprocesso->IsNativeSelect) { ?>
        data-select2-id="fobjetivo_qualidadesearch_x_processo_idprocesso"
        <?php } ?>
        data-table="objetivo_qualidade"
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
loadjs.ready("fobjetivo_qualidadesearch", function() {
    var options = { name: "x_processo_idprocesso", selectId: "fobjetivo_qualidadesearch_x_processo_idprocesso" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fobjetivo_qualidadesearch.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x_processo_idprocesso", form: "fobjetivo_qualidadesearch" };
    } else {
        options.ajax = { id: "x_processo_idprocesso", form: "fobjetivo_qualidadesearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.objetivo_qualidade.fields.processo_idprocesso.selectOptions);
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
<?php if ($Page->objetivo->Visible) { // objetivo ?>
    <div id="r_objetivo" class="row"<?= $Page->objetivo->rowAttributes() ?>>
        <label for="x_objetivo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_objetivo_qualidade_objetivo"><?= $Page->objetivo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_objetivo" id="z_objetivo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->objetivo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_objetivo_qualidade_objetivo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->objetivo->getInputTextType() ?>" name="x_objetivo" id="x_objetivo" data-table="objetivo_qualidade" data-field="x_objetivo" value="<?= $Page->objetivo->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->objetivo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->objetivo->formatPattern()) ?>"<?= $Page->objetivo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->objetivo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->como_medir->Visible) { // como_medir ?>
    <div id="r_como_medir" class="row"<?= $Page->como_medir->rowAttributes() ?>>
        <label for="x_como_medir" class="<?= $Page->LeftColumnClass ?>"><span id="elh_objetivo_qualidade_como_medir"><?= $Page->como_medir->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_como_medir" id="z_como_medir" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->como_medir->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_objetivo_qualidade_como_medir" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->como_medir->getInputTextType() ?>" name="x_como_medir" id="x_como_medir" data-table="objetivo_qualidade" data-field="x_como_medir" value="<?= $Page->como_medir->EditValue ?>" size="20" maxlength="255" placeholder="<?= HtmlEncode($Page->como_medir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->como_medir->formatPattern()) ?>"<?= $Page->como_medir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->como_medir->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
    <div id="r_o_q_sera_feito" class="row"<?= $Page->o_q_sera_feito->rowAttributes() ?>>
        <label for="x_o_q_sera_feito" class="<?= $Page->LeftColumnClass ?>"><span id="elh_objetivo_qualidade_o_q_sera_feito"><?= $Page->o_q_sera_feito->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_o_q_sera_feito" id="z_o_q_sera_feito" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->o_q_sera_feito->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_objetivo_qualidade_o_q_sera_feito" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->o_q_sera_feito->getInputTextType() ?>" name="x_o_q_sera_feito" id="x_o_q_sera_feito" data-table="objetivo_qualidade" data-field="x_o_q_sera_feito" value="<?= $Page->o_q_sera_feito->EditValue ?>" size="20" maxlength="255" placeholder="<?= HtmlEncode($Page->o_q_sera_feito->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->o_q_sera_feito->formatPattern()) ?>"<?= $Page->o_q_sera_feito->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->o_q_sera_feito->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->como_avaliar->Visible) { // como_avaliar ?>
    <div id="r_como_avaliar" class="row"<?= $Page->como_avaliar->rowAttributes() ?>>
        <label for="x_como_avaliar" class="<?= $Page->LeftColumnClass ?>"><span id="elh_objetivo_qualidade_como_avaliar"><?= $Page->como_avaliar->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_como_avaliar" id="z_como_avaliar" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->como_avaliar->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_objetivo_qualidade_como_avaliar" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->como_avaliar->getInputTextType() ?>" name="x_como_avaliar" id="x_como_avaliar" data-table="objetivo_qualidade" data-field="x_como_avaliar" value="<?= $Page->como_avaliar->EditValue ?>" size="20" maxlength="255" placeholder="<?= HtmlEncode($Page->como_avaliar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->como_avaliar->formatPattern()) ?>"<?= $Page->como_avaliar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->como_avaliar->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <div id="r_departamentos_iddepartamentos" class="row"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <label for="x_departamentos_iddepartamentos" class="<?= $Page->LeftColumnClass ?>"><span id="elh_objetivo_qualidade_departamentos_iddepartamentos"><?= $Page->departamentos_iddepartamentos->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_departamentos_iddepartamentos" id="z_departamentos_iddepartamentos" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_objetivo_qualidade_departamentos_iddepartamentos" class="ew-search-field ew-search-field-single">
    <select
        id="x_departamentos_iddepartamentos"
        name="x_departamentos_iddepartamentos"
        class="form-select ew-select<?= $Page->departamentos_iddepartamentos->isInvalidClass() ?>"
        <?php if (!$Page->departamentos_iddepartamentos->IsNativeSelect) { ?>
        data-select2-id="fobjetivo_qualidadesearch_x_departamentos_iddepartamentos"
        <?php } ?>
        data-table="objetivo_qualidade"
        data-field="x_departamentos_iddepartamentos"
        data-value-separator="<?= $Page->departamentos_iddepartamentos->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->departamentos_iddepartamentos->getPlaceHolder()) ?>"
        <?= $Page->departamentos_iddepartamentos->editAttributes() ?>>
        <?= $Page->departamentos_iddepartamentos->selectOptionListHtml("x_departamentos_iddepartamentos") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->departamentos_iddepartamentos->getErrorMessage(false) ?></div>
<?= $Page->departamentos_iddepartamentos->Lookup->getParamTag($Page, "p_x_departamentos_iddepartamentos") ?>
<?php if (!$Page->departamentos_iddepartamentos->IsNativeSelect) { ?>
<script>
loadjs.ready("fobjetivo_qualidadesearch", function() {
    var options = { name: "x_departamentos_iddepartamentos", selectId: "fobjetivo_qualidadesearch_x_departamentos_iddepartamentos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fobjetivo_qualidadesearch.lists.departamentos_iddepartamentos?.lookupOptions.length) {
        options.data = { id: "x_departamentos_iddepartamentos", form: "fobjetivo_qualidadesearch" };
    } else {
        options.ajax = { id: "x_departamentos_iddepartamentos", form: "fobjetivo_qualidadesearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.objetivo_qualidade.fields.departamentos_iddepartamentos.selectOptions);
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
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fobjetivo_qualidadesearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fobjetivo_qualidadesearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fobjetivo_qualidadesearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("objetivo_qualidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
