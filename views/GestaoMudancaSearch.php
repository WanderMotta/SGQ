<?php

namespace PHPMaker2024\sgq;

// Page object
$GestaoMudancaSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { gestao_mudanca: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fgestao_mudancasearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fgestao_mudancasearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idgestao_mudanca", [ew.Validators.integer], fields.idgestao_mudanca.isInvalid],
            ["dt_cadastro", [ew.Validators.datetime(fields.dt_cadastro.clientFormatPattern)], fields.dt_cadastro.isInvalid],
            ["titulo", [], fields.titulo.isInvalid],
            ["dt_inicio", [ew.Validators.datetime(fields.dt_inicio.clientFormatPattern)], fields.dt_inicio.isInvalid],
            ["detalhamento", [], fields.detalhamento.isInvalid],
            ["impacto", [], fields.impacto.isInvalid],
            ["motivo", [], fields.motivo.isInvalid],
            ["recursos", [ew.Validators.float], fields.recursos.isInvalid],
            ["prazo_ate", [ew.Validators.datetime(fields.prazo_ate.clientFormatPattern)], fields.prazo_ate.isInvalid],
            ["departamentos_iddepartamentos", [], fields.departamentos_iddepartamentos.isInvalid],
            ["usuario_idusuario", [], fields.usuario_idusuario.isInvalid],
            ["implementado", [], fields.implementado.isInvalid],
            ["status", [], fields.status.isInvalid],
            ["eficaz", [], fields.eficaz.isInvalid]
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
            "departamentos_iddepartamentos": <?= $Page->departamentos_iddepartamentos->toClientList($Page) ?>,
            "usuario_idusuario": <?= $Page->usuario_idusuario->toClientList($Page) ?>,
            "implementado": <?= $Page->implementado->toClientList($Page) ?>,
            "status": <?= $Page->status->toClientList($Page) ?>,
            "eficaz": <?= $Page->eficaz->toClientList($Page) ?>,
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
<form name="fgestao_mudancasearch" id="fgestao_mudancasearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="gestao_mudanca">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idgestao_mudanca->Visible) { // idgestao_mudanca ?>
    <div id="r_idgestao_mudanca" class="row"<?= $Page->idgestao_mudanca->rowAttributes() ?>>
        <label for="x_idgestao_mudanca" class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_idgestao_mudanca"><?= $Page->idgestao_mudanca->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idgestao_mudanca" id="z_idgestao_mudanca" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idgestao_mudanca->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_idgestao_mudanca" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idgestao_mudanca->getInputTextType() ?>" name="x_idgestao_mudanca" id="x_idgestao_mudanca" data-table="gestao_mudanca" data-field="x_idgestao_mudanca" value="<?= $Page->idgestao_mudanca->EditValue ?>" placeholder="<?= HtmlEncode($Page->idgestao_mudanca->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idgestao_mudanca->formatPattern()) ?>"<?= $Page->idgestao_mudanca->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idgestao_mudanca->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <div id="r_dt_cadastro" class="row"<?= $Page->dt_cadastro->rowAttributes() ?>>
        <label for="x_dt_cadastro" class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_cadastro" id="z_dt_cadastro" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_cadastro->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_dt_cadastro" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_cadastro->getInputTextType() ?>" name="x_dt_cadastro" id="x_dt_cadastro" data-table="gestao_mudanca" data-field="x_dt_cadastro" value="<?= $Page->dt_cadastro->EditValue ?>" placeholder="<?= HtmlEncode($Page->dt_cadastro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_cadastro->formatPattern()) ?>"<?= $Page->dt_cadastro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_cadastro->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_cadastro->ReadOnly && !$Page->dt_cadastro->Disabled && !isset($Page->dt_cadastro->EditAttrs["readonly"]) && !isset($Page->dt_cadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fgestao_mudancasearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fgestao_mudancasearch", "x_dt_cadastro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
        <label for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_titulo"><?= $Page->titulo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_titulo" id="z_titulo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->titulo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_titulo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->titulo->getInputTextType() ?>" name="x_titulo" id="x_titulo" data-table="gestao_mudanca" data-field="x_titulo" value="<?= $Page->titulo->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo->formatPattern()) ?>"<?= $Page->titulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->dt_inicio->Visible) { // dt_inicio ?>
    <div id="r_dt_inicio" class="row"<?= $Page->dt_inicio->rowAttributes() ?>>
        <label for="x_dt_inicio" class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_dt_inicio"><?= $Page->dt_inicio->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_dt_inicio" id="z_dt_inicio" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->dt_inicio->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_dt_inicio" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->dt_inicio->getInputTextType() ?>" name="x_dt_inicio" id="x_dt_inicio" data-table="gestao_mudanca" data-field="x_dt_inicio" value="<?= $Page->dt_inicio->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->dt_inicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dt_inicio->formatPattern()) ?>"<?= $Page->dt_inicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dt_inicio->getErrorMessage(false) ?></div>
<?php if (!$Page->dt_inicio->ReadOnly && !$Page->dt_inicio->Disabled && !isset($Page->dt_inicio->EditAttrs["readonly"]) && !isset($Page->dt_inicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fgestao_mudancasearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fgestao_mudancasearch", "x_dt_inicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->detalhamento->Visible) { // detalhamento ?>
    <div id="r_detalhamento" class="row"<?= $Page->detalhamento->rowAttributes() ?>>
        <label for="x_detalhamento" class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_detalhamento"><?= $Page->detalhamento->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_detalhamento" id="z_detalhamento" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->detalhamento->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_detalhamento" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->detalhamento->getInputTextType() ?>" name="x_detalhamento" id="x_detalhamento" data-table="gestao_mudanca" data-field="x_detalhamento" value="<?= $Page->detalhamento->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->detalhamento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->detalhamento->formatPattern()) ?>"<?= $Page->detalhamento->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->detalhamento->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->impacto->Visible) { // impacto ?>
    <div id="r_impacto" class="row"<?= $Page->impacto->rowAttributes() ?>>
        <label for="x_impacto" class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_impacto"><?= $Page->impacto->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_impacto" id="z_impacto" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->impacto->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_impacto" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->impacto->getInputTextType() ?>" name="x_impacto" id="x_impacto" data-table="gestao_mudanca" data-field="x_impacto" value="<?= $Page->impacto->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->impacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->impacto->formatPattern()) ?>"<?= $Page->impacto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->impacto->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
    <div id="r_motivo" class="row"<?= $Page->motivo->rowAttributes() ?>>
        <label for="x_motivo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_motivo"><?= $Page->motivo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_motivo" id="z_motivo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->motivo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_motivo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->motivo->getInputTextType() ?>" name="x_motivo" id="x_motivo" data-table="gestao_mudanca" data-field="x_motivo" value="<?= $Page->motivo->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->motivo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->motivo->formatPattern()) ?>"<?= $Page->motivo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->motivo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->recursos->Visible) { // recursos ?>
    <div id="r_recursos" class="row"<?= $Page->recursos->rowAttributes() ?>>
        <label for="x_recursos" class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_recursos"><?= $Page->recursos->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_recursos" id="z_recursos" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->recursos->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_recursos" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->recursos->getInputTextType() ?>" name="x_recursos" id="x_recursos" data-table="gestao_mudanca" data-field="x_recursos" value="<?= $Page->recursos->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->recursos->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->recursos->formatPattern()) ?>"<?= $Page->recursos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->recursos->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->prazo_ate->Visible) { // prazo_ate ?>
    <div id="r_prazo_ate" class="row"<?= $Page->prazo_ate->rowAttributes() ?>>
        <label for="x_prazo_ate" class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_prazo_ate"><?= $Page->prazo_ate->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_prazo_ate" id="z_prazo_ate" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->prazo_ate->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_prazo_ate" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->prazo_ate->getInputTextType() ?>" name="x_prazo_ate" id="x_prazo_ate" data-table="gestao_mudanca" data-field="x_prazo_ate" value="<?= $Page->prazo_ate->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->prazo_ate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->prazo_ate->formatPattern()) ?>"<?= $Page->prazo_ate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->prazo_ate->getErrorMessage(false) ?></div>
<?php if (!$Page->prazo_ate->ReadOnly && !$Page->prazo_ate->Disabled && !isset($Page->prazo_ate->EditAttrs["readonly"]) && !isset($Page->prazo_ate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fgestao_mudancasearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fgestao_mudancasearch", "x_prazo_ate", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <div id="r_departamentos_iddepartamentos" class="row"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <label for="x_departamentos_iddepartamentos" class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_departamentos_iddepartamentos"><?= $Page->departamentos_iddepartamentos->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_departamentos_iddepartamentos" id="z_departamentos_iddepartamentos" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_departamentos_iddepartamentos" class="ew-search-field ew-search-field-single">
    <select
        id="x_departamentos_iddepartamentos"
        name="x_departamentos_iddepartamentos"
        class="form-control ew-select<?= $Page->departamentos_iddepartamentos->isInvalidClass() ?>"
        data-select2-id="fgestao_mudancasearch_x_departamentos_iddepartamentos"
        data-table="gestao_mudanca"
        data-field="x_departamentos_iddepartamentos"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->departamentos_iddepartamentos->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->departamentos_iddepartamentos->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->departamentos_iddepartamentos->getPlaceHolder()) ?>"
        <?= $Page->departamentos_iddepartamentos->editAttributes() ?>>
        <?= $Page->departamentos_iddepartamentos->selectOptionListHtml("x_departamentos_iddepartamentos") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->departamentos_iddepartamentos->getErrorMessage(false) ?></div>
<?= $Page->departamentos_iddepartamentos->Lookup->getParamTag($Page, "p_x_departamentos_iddepartamentos") ?>
<script>
loadjs.ready("fgestao_mudancasearch", function() {
    var options = { name: "x_departamentos_iddepartamentos", selectId: "fgestao_mudancasearch_x_departamentos_iddepartamentos" };
    if (fgestao_mudancasearch.lists.departamentos_iddepartamentos?.lookupOptions.length) {
        options.data = { id: "x_departamentos_iddepartamentos", form: "fgestao_mudancasearch" };
    } else {
        options.ajax = { id: "x_departamentos_iddepartamentos", form: "fgestao_mudancasearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.gestao_mudanca.fields.departamentos_iddepartamentos.modalLookupOptions);
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
        <label for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_usuario_idusuario" id="z_usuario_idusuario" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->usuario_idusuario->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_usuario_idusuario" class="ew-search-field ew-search-field-single">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-select ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        <?php if (!$Page->usuario_idusuario->IsNativeSelect) { ?>
        data-select2-id="fgestao_mudancasearch_x_usuario_idusuario"
        <?php } ?>
        data-table="gestao_mudanca"
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
loadjs.ready("fgestao_mudancasearch", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fgestao_mudancasearch_x_usuario_idusuario" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fgestao_mudancasearch.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fgestao_mudancasearch" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fgestao_mudancasearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.gestao_mudanca.fields.usuario_idusuario.selectOptions);
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
<?php if ($Page->implementado->Visible) { // implementado ?>
    <div id="r_implementado" class="row"<?= $Page->implementado->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_implementado"><?= $Page->implementado->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_implementado" id="z_implementado" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->implementado->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_implementado" class="ew-search-field ew-search-field-single">
<template id="tp_x_implementado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="gestao_mudanca" data-field="x_implementado" name="x_implementado" id="x_implementado"<?= $Page->implementado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_implementado" class="ew-item-list"></div>
<selection-list hidden
    id="x_implementado"
    name="x_implementado"
    value="<?= HtmlEncode($Page->implementado->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_implementado"
    data-target="dsl_x_implementado"
    data-repeatcolumn="5"
    class="form-control<?= $Page->implementado->isInvalidClass() ?>"
    data-table="gestao_mudanca"
    data-field="x_implementado"
    data-value-separator="<?= $Page->implementado->displayValueSeparatorAttribute() ?>"
    <?= $Page->implementado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->implementado->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="row"<?= $Page->status->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_status"><?= $Page->status->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status" id="z_status" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->status->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_status" class="ew-search-field ew-search-field-single">
<template id="tp_x_status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="gestao_mudanca" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status" class="ew-item-list"></div>
<selection-list hidden
    id="x_status"
    name="x_status"
    value="<?= HtmlEncode($Page->status->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_status"
    data-target="dsl_x_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status->isInvalidClass() ?>"
    data-table="gestao_mudanca"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
    <div id="r_eficaz" class="row"<?= $Page->eficaz->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_gestao_mudanca_eficaz"><?= $Page->eficaz->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_eficaz" id="z_eficaz" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->eficaz->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_gestao_mudanca_eficaz" class="ew-search-field ew-search-field-single">
<template id="tp_x_eficaz">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="gestao_mudanca" data-field="x_eficaz" name="x_eficaz" id="x_eficaz"<?= $Page->eficaz->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_eficaz" class="ew-item-list"></div>
<selection-list hidden
    id="x_eficaz"
    name="x_eficaz"
    value="<?= HtmlEncode($Page->eficaz->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_eficaz"
    data-target="dsl_x_eficaz"
    data-repeatcolumn="5"
    class="form-control<?= $Page->eficaz->isInvalidClass() ?>"
    data-table="gestao_mudanca"
    data-field="x_eficaz"
    data-value-separator="<?= $Page->eficaz->displayValueSeparatorAttribute() ?>"
    <?= $Page->eficaz->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->eficaz->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fgestao_mudancasearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fgestao_mudancasearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fgestao_mudancasearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("gestao_mudanca");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
