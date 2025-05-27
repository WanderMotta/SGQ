<?php

namespace PHPMaker2024\sgq;

// Page object
$ContextoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fcontextoedit" id="fcontextoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { contexto: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fcontextoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcontextoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idcontexto", [fields.idcontexto.visible && fields.idcontexto.required ? ew.Validators.required(fields.idcontexto.caption) : null], fields.idcontexto.isInvalid],
            ["ano", [fields.ano.visible && fields.ano.required ? ew.Validators.required(fields.ano.caption) : null], fields.ano.isInvalid],
            ["revisao", [fields.revisao.visible && fields.revisao.required ? ew.Validators.required(fields.revisao.caption) : null, ew.Validators.integer], fields.revisao.isInvalid],
            ["data", [fields.data.visible && fields.data.required ? ew.Validators.required(fields.data.caption) : null, ew.Validators.datetime(fields.data.clientFormatPattern)], fields.data.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid],
            ["usuario_idusuario1", [fields.usuario_idusuario1.visible && fields.usuario_idusuario1.required ? ew.Validators.required(fields.usuario_idusuario1.caption) : null], fields.usuario_idusuario1.isInvalid],
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
            "ano": <?= $Page->ano->toClientList($Page) ?>,
            "revisao": <?= $Page->revisao->toClientList($Page) ?>,
            "usuario_idusuario": <?= $Page->usuario_idusuario->toClientList($Page) ?>,
            "usuario_idusuario1": <?= $Page->usuario_idusuario1->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="contexto">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idcontexto->Visible) { // idcontexto ?>
    <div id="r_idcontexto"<?= $Page->idcontexto->rowAttributes() ?>>
        <label id="elh_contexto_idcontexto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcontexto->caption() ?><?= $Page->idcontexto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idcontexto->cellAttributes() ?>>
<span id="el_contexto_idcontexto">
<span<?= $Page->idcontexto->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idcontexto->getDisplayValue($Page->idcontexto->EditValue))) ?>"></span>
<input type="hidden" data-table="contexto" data-field="x_idcontexto" data-hidden="1" name="x_idcontexto" id="x_idcontexto" value="<?= HtmlEncode($Page->idcontexto->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ano->Visible) { // ano ?>
    <div id="r_ano"<?= $Page->ano->rowAttributes() ?>>
        <label id="elh_contexto_ano" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ano->caption() ?><?= $Page->ano->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ano->cellAttributes() ?>>
<span id="el_contexto_ano">
<template id="tp_x_ano">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="contexto" data-field="x_ano" name="x_ano" id="x_ano"<?= $Page->ano->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_ano" class="ew-item-list"></div>
<selection-list hidden
    id="x_ano"
    name="x_ano"
    value="<?= HtmlEncode($Page->ano->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_ano"
    data-target="dsl_x_ano"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ano->isInvalidClass() ?>"
    data-table="contexto"
    data-field="x_ano"
    data-value-separator="<?= $Page->ano->displayValueSeparatorAttribute() ?>"
    <?= $Page->ano->editAttributes() ?>></selection-list>
<?= $Page->ano->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ano->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->revisao->Visible) { // revisao ?>
    <div id="r_revisao"<?= $Page->revisao->rowAttributes() ?>>
        <label id="elh_contexto_revisao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->revisao->caption() ?><?= $Page->revisao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->revisao->cellAttributes() ?>>
<span id="el_contexto_revisao">
<?php
if (IsRTL()) {
    $Page->revisao->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_revisao" class="ew-auto-suggest">
    <input type="<?= $Page->revisao->getInputTextType() ?>" class="form-control" name="sv_x_revisao" id="sv_x_revisao" value="<?= RemoveHtml($Page->revisao->EditValue) ?>" autocomplete="off" size="3" placeholder="<?= HtmlEncode($Page->revisao->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->revisao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->revisao->formatPattern()) ?>"<?= $Page->revisao->editAttributes() ?> aria-describedby="x_revisao_help">
</span>
<selection-list hidden class="form-control" data-table="contexto" data-field="x_revisao" data-input="sv_x_revisao" data-value-separator="<?= $Page->revisao->displayValueSeparatorAttribute() ?>" name="x_revisao" id="x_revisao" value="<?= HtmlEncode($Page->revisao->CurrentValue) ?>"></selection-list>
<?= $Page->revisao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->revisao->getErrorMessage() ?></div>
<script>
loadjs.ready("fcontextoedit", function() {
    fcontextoedit.createAutoSuggest(Object.assign({"id":"x_revisao","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->revisao->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.contexto.fields.revisao.autoSuggestOptions));
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
    <div id="r_data"<?= $Page->data->rowAttributes() ?>>
        <label id="elh_contexto_data" for="x_data" class="<?= $Page->LeftColumnClass ?>"><?= $Page->data->caption() ?><?= $Page->data->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->data->cellAttributes() ?>>
<span id="el_contexto_data">
<input type="<?= $Page->data->getInputTextType() ?>" name="x_data" id="x_data" data-table="contexto" data-field="x_data" value="<?= $Page->data->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->data->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->data->formatPattern()) ?>"<?= $Page->data->editAttributes() ?> aria-describedby="x_data_help">
<?= $Page->data->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->data->getErrorMessage() ?></div>
<?php if (!$Page->data->ReadOnly && !$Page->data->Disabled && !isset($Page->data->EditAttrs["readonly"]) && !isset($Page->data->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcontextoedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcontextoedit", "x_data", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label id="elh_contexto_usuario_idusuario" for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_idusuario->caption() ?><?= $Page->usuario_idusuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_contexto_usuario_idusuario">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-select ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        <?php if (!$Page->usuario_idusuario->IsNativeSelect) { ?>
        data-select2-id="fcontextoedit_x_usuario_idusuario"
        <?php } ?>
        data-table="contexto"
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
loadjs.ready("fcontextoedit", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fcontextoedit_x_usuario_idusuario" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcontextoedit.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fcontextoedit" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fcontextoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.contexto.fields.usuario_idusuario.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario1->Visible) { // usuario_idusuario1 ?>
    <div id="r_usuario_idusuario1"<?= $Page->usuario_idusuario1->rowAttributes() ?>>
        <label id="elh_contexto_usuario_idusuario1" for="x_usuario_idusuario1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_idusuario1->caption() ?><?= $Page->usuario_idusuario1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_idusuario1->cellAttributes() ?>>
<span id="el_contexto_usuario_idusuario1">
    <select
        id="x_usuario_idusuario1"
        name="x_usuario_idusuario1"
        class="form-select ew-select<?= $Page->usuario_idusuario1->isInvalidClass() ?>"
        <?php if (!$Page->usuario_idusuario1->IsNativeSelect) { ?>
        data-select2-id="fcontextoedit_x_usuario_idusuario1"
        <?php } ?>
        data-table="contexto"
        data-field="x_usuario_idusuario1"
        data-value-separator="<?= $Page->usuario_idusuario1->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_idusuario1->getPlaceHolder()) ?>"
        <?= $Page->usuario_idusuario1->editAttributes() ?>>
        <?= $Page->usuario_idusuario1->selectOptionListHtml("x_usuario_idusuario1") ?>
    </select>
    <?= $Page->usuario_idusuario1->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->usuario_idusuario1->getErrorMessage() ?></div>
<?= $Page->usuario_idusuario1->Lookup->getParamTag($Page, "p_x_usuario_idusuario1") ?>
<?php if (!$Page->usuario_idusuario1->IsNativeSelect) { ?>
<script>
loadjs.ready("fcontextoedit", function() {
    var options = { name: "x_usuario_idusuario1", selectId: "fcontextoedit_x_usuario_idusuario1" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcontextoedit.lists.usuario_idusuario1?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario1", form: "fcontextoedit" };
    } else {
        options.ajax = { id: "x_usuario_idusuario1", form: "fcontextoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.contexto.fields.usuario_idusuario1.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_contexto_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_contexto_obs">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="contexto" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="45" maxlength="120" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help">
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("analise_swot", explode(",", $Page->getCurrentDetailTable())) && $analise_swot->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("analise_swot", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "AnaliseSwotGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcontextoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcontextoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("contexto");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
