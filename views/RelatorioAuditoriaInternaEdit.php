<?php

namespace PHPMaker2024\sgq;

// Page object
$RelatorioAuditoriaInternaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="frelatorio_auditoria_internaedit" id="frelatorio_auditoria_internaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { relatorio_auditoria_interna: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var frelatorio_auditoria_internaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frelatorio_auditoria_internaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idrelatorio_auditoria_interna", [fields.idrelatorio_auditoria_interna.visible && fields.idrelatorio_auditoria_interna.required ? ew.Validators.required(fields.idrelatorio_auditoria_interna.caption) : null], fields.idrelatorio_auditoria_interna.isInvalid],
            ["data", [fields.data.visible && fields.data.required ? ew.Validators.required(fields.data.caption) : null, ew.Validators.datetime(fields.data.clientFormatPattern)], fields.data.isInvalid],
            ["origem_risco_oportunidade_idorigem_risco_oportunidade", [fields.origem_risco_oportunidade_idorigem_risco_oportunidade.visible && fields.origem_risco_oportunidade_idorigem_risco_oportunidade.required ? ew.Validators.required(fields.origem_risco_oportunidade_idorigem_risco_oportunidade.caption) : null], fields.origem_risco_oportunidade_idorigem_risco_oportunidade.isInvalid],
            ["auditor", [fields.auditor.visible && fields.auditor.required ? ew.Validators.required(fields.auditor.caption) : null], fields.auditor.isInvalid],
            ["aprovador", [fields.aprovador.visible && fields.aprovador.required ? ew.Validators.required(fields.aprovador.caption) : null], fields.aprovador.isInvalid]
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
            "origem_risco_oportunidade_idorigem_risco_oportunidade": <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->toClientList($Page) ?>,
            "auditor": <?= $Page->auditor->toClientList($Page) ?>,
            "aprovador": <?= $Page->aprovador->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="relatorio_auditoria_interna">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idrelatorio_auditoria_interna->Visible) { // idrelatorio_auditoria_interna ?>
    <div id="r_idrelatorio_auditoria_interna"<?= $Page->idrelatorio_auditoria_interna->rowAttributes() ?>>
        <label id="elh_relatorio_auditoria_interna_idrelatorio_auditoria_interna" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idrelatorio_auditoria_interna->caption() ?><?= $Page->idrelatorio_auditoria_interna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idrelatorio_auditoria_interna->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_idrelatorio_auditoria_interna">
<span<?= $Page->idrelatorio_auditoria_interna->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idrelatorio_auditoria_interna->getDisplayValue($Page->idrelatorio_auditoria_interna->EditValue))) ?>"></span>
<input type="hidden" data-table="relatorio_auditoria_interna" data-field="x_idrelatorio_auditoria_interna" data-hidden="1" name="x_idrelatorio_auditoria_interna" id="x_idrelatorio_auditoria_interna" value="<?= HtmlEncode($Page->idrelatorio_auditoria_interna->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
    <div id="r_data"<?= $Page->data->rowAttributes() ?>>
        <label id="elh_relatorio_auditoria_interna_data" for="x_data" class="<?= $Page->LeftColumnClass ?>"><?= $Page->data->caption() ?><?= $Page->data->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->data->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_data">
<input type="<?= $Page->data->getInputTextType() ?>" name="x_data" id="x_data" data-table="relatorio_auditoria_interna" data-field="x_data" value="<?= $Page->data->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->data->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->data->formatPattern()) ?>"<?= $Page->data->editAttributes() ?> aria-describedby="x_data_help">
<?= $Page->data->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->data->getErrorMessage() ?></div>
<?php if (!$Page->data->ReadOnly && !$Page->data->Disabled && !isset($Page->data->EditAttrs["readonly"]) && !isset($Page->data->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frelatorio_auditoria_internaedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frelatorio_auditoria_internaedit", "x_data", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <div id="r_origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
        <label id="elh_relatorio_auditoria_interna_origem_risco_oportunidade_idorigem_risco_oportunidade" for="x_origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_origem_risco_oportunidade_idorigem_risco_oportunidade">
    <select
        id="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        name="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        class="form-control ew-select<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->isInvalidClass() ?>"
        data-select2-id="frelatorio_auditoria_internaedit_x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        data-table="relatorio_auditoria_interna"
        data-field="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getPlaceHolder()) ?>"
        <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->editAttributes() ?>>
        <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->selectOptionListHtml("x_origem_risco_oportunidade_idorigem_risco_oportunidade") ?>
    </select>
    <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getErrorMessage() ?></div>
<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Lookup->getParamTag($Page, "p_x_origem_risco_oportunidade_idorigem_risco_oportunidade") ?>
<script>
loadjs.ready("frelatorio_auditoria_internaedit", function() {
    var options = { name: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", selectId: "frelatorio_auditoria_internaedit_x_origem_risco_oportunidade_idorigem_risco_oportunidade" };
    if (frelatorio_auditoria_internaedit.lists.origem_risco_oportunidade_idorigem_risco_oportunidade?.lookupOptions.length) {
        options.data = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "frelatorio_auditoria_internaedit" };
    } else {
        options.ajax = { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "frelatorio_auditoria_internaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.relatorio_auditoria_interna.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->auditor->Visible) { // auditor ?>
    <div id="r_auditor"<?= $Page->auditor->rowAttributes() ?>>
        <label id="elh_relatorio_auditoria_interna_auditor" for="x_auditor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->auditor->caption() ?><?= $Page->auditor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->auditor->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_auditor">
    <select
        id="x_auditor"
        name="x_auditor"
        class="form-control ew-select<?= $Page->auditor->isInvalidClass() ?>"
        data-select2-id="frelatorio_auditoria_internaedit_x_auditor"
        data-table="relatorio_auditoria_interna"
        data-field="x_auditor"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->auditor->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->auditor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->auditor->getPlaceHolder()) ?>"
        <?= $Page->auditor->editAttributes() ?>>
        <?= $Page->auditor->selectOptionListHtml("x_auditor") ?>
    </select>
    <?= $Page->auditor->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->auditor->getErrorMessage() ?></div>
<?= $Page->auditor->Lookup->getParamTag($Page, "p_x_auditor") ?>
<script>
loadjs.ready("frelatorio_auditoria_internaedit", function() {
    var options = { name: "x_auditor", selectId: "frelatorio_auditoria_internaedit_x_auditor" };
    if (frelatorio_auditoria_internaedit.lists.auditor?.lookupOptions.length) {
        options.data = { id: "x_auditor", form: "frelatorio_auditoria_internaedit" };
    } else {
        options.ajax = { id: "x_auditor", form: "frelatorio_auditoria_internaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.relatorio_auditoria_interna.fields.auditor.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aprovador->Visible) { // aprovador ?>
    <div id="r_aprovador"<?= $Page->aprovador->rowAttributes() ?>>
        <label id="elh_relatorio_auditoria_interna_aprovador" for="x_aprovador" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aprovador->caption() ?><?= $Page->aprovador->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->aprovador->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_aprovador">
    <select
        id="x_aprovador"
        name="x_aprovador"
        class="form-control ew-select<?= $Page->aprovador->isInvalidClass() ?>"
        data-select2-id="frelatorio_auditoria_internaedit_x_aprovador"
        data-table="relatorio_auditoria_interna"
        data-field="x_aprovador"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->aprovador->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->aprovador->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->aprovador->getPlaceHolder()) ?>"
        <?= $Page->aprovador->editAttributes() ?>>
        <?= $Page->aprovador->selectOptionListHtml("x_aprovador") ?>
    </select>
    <?= $Page->aprovador->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->aprovador->getErrorMessage() ?></div>
<?= $Page->aprovador->Lookup->getParamTag($Page, "p_x_aprovador") ?>
<script>
loadjs.ready("frelatorio_auditoria_internaedit", function() {
    var options = { name: "x_aprovador", selectId: "frelatorio_auditoria_internaedit_x_aprovador" };
    if (frelatorio_auditoria_internaedit.lists.aprovador?.lookupOptions.length) {
        options.data = { id: "x_aprovador", form: "frelatorio_auditoria_internaedit" };
    } else {
        options.ajax = { id: "x_aprovador", form: "frelatorio_auditoria_internaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.relatorio_auditoria_interna.fields.aprovador.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("item_rel_aud_interna", explode(",", $Page->getCurrentDetailTable())) && $item_rel_aud_interna->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("item_rel_aud_interna", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ItemRelAudInternaGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="frelatorio_auditoria_internaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="frelatorio_auditoria_internaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("relatorio_auditoria_interna");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
