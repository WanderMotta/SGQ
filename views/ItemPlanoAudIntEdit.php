<?php

namespace PHPMaker2024\sgq;

// Page object
$ItemPlanoAudIntEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fitem_plano_aud_intedit" id="fitem_plano_aud_intedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { item_plano_aud_int: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fitem_plano_aud_intedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fitem_plano_aud_intedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["iditem_plano_aud_int", [fields.iditem_plano_aud_int.visible && fields.iditem_plano_aud_int.required ? ew.Validators.required(fields.iditem_plano_aud_int.caption) : null], fields.iditem_plano_aud_int.isInvalid],
            ["data", [fields.data.visible && fields.data.required ? ew.Validators.required(fields.data.caption) : null, ew.Validators.datetime(fields.data.clientFormatPattern)], fields.data.isInvalid],
            ["processo_idprocesso", [fields.processo_idprocesso.visible && fields.processo_idprocesso.required ? ew.Validators.required(fields.processo_idprocesso.caption) : null], fields.processo_idprocesso.isInvalid],
            ["escopo", [fields.escopo.visible && fields.escopo.required ? ew.Validators.required(fields.escopo.caption) : null], fields.escopo.isInvalid],
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
<input type="hidden" name="t" value="item_plano_aud_int">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "plano_auditoria_int") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="plano_auditoria_int">
<input type="hidden" name="fk_idplano_auditoria_int" value="<?= HtmlEncode($Page->plano_auditoria_int_idplano_auditoria_int->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->iditem_plano_aud_int->Visible) { // iditem_plano_aud_int ?>
    <div id="r_iditem_plano_aud_int"<?= $Page->iditem_plano_aud_int->rowAttributes() ?>>
        <label id="elh_item_plano_aud_int_iditem_plano_aud_int" class="<?= $Page->LeftColumnClass ?>"><?= $Page->iditem_plano_aud_int->caption() ?><?= $Page->iditem_plano_aud_int->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->iditem_plano_aud_int->cellAttributes() ?>>
<span id="el_item_plano_aud_int_iditem_plano_aud_int">
<span<?= $Page->iditem_plano_aud_int->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->iditem_plano_aud_int->getDisplayValue($Page->iditem_plano_aud_int->EditValue))) ?>"></span>
<input type="hidden" data-table="item_plano_aud_int" data-field="x_iditem_plano_aud_int" data-hidden="1" name="x_iditem_plano_aud_int" id="x_iditem_plano_aud_int" value="<?= HtmlEncode($Page->iditem_plano_aud_int->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
    <div id="r_data"<?= $Page->data->rowAttributes() ?>>
        <label id="elh_item_plano_aud_int_data" for="x_data" class="<?= $Page->LeftColumnClass ?>"><?= $Page->data->caption() ?><?= $Page->data->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->data->cellAttributes() ?>>
<span id="el_item_plano_aud_int_data">
<input type="<?= $Page->data->getInputTextType() ?>" name="x_data" id="x_data" data-table="item_plano_aud_int" data-field="x_data" value="<?= $Page->data->EditValue ?>" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->data->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->data->formatPattern()) ?>"<?= $Page->data->editAttributes() ?> aria-describedby="x_data_help">
<?= $Page->data->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->data->getErrorMessage() ?></div>
<?php if (!$Page->data->ReadOnly && !$Page->data->Disabled && !isset($Page->data->EditAttrs["readonly"]) && !isset($Page->data->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fitem_plano_aud_intedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fitem_plano_aud_intedit", "x_data", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <div id="r_processo_idprocesso"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <label id="elh_item_plano_aud_int_processo_idprocesso" for="x_processo_idprocesso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->processo_idprocesso->caption() ?><?= $Page->processo_idprocesso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el_item_plano_aud_int_processo_idprocesso">
    <select
        id="x_processo_idprocesso"
        name="x_processo_idprocesso"
        class="form-control ew-select<?= $Page->processo_idprocesso->isInvalidClass() ?>"
        data-select2-id="fitem_plano_aud_intedit_x_processo_idprocesso"
        data-table="item_plano_aud_int"
        data-field="x_processo_idprocesso"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->processo_idprocesso->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->processo_idprocesso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->processo_idprocesso->getPlaceHolder()) ?>"
        <?= $Page->processo_idprocesso->editAttributes() ?>>
        <?= $Page->processo_idprocesso->selectOptionListHtml("x_processo_idprocesso") ?>
    </select>
    <?= $Page->processo_idprocesso->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->processo_idprocesso->getErrorMessage() ?></div>
<?= $Page->processo_idprocesso->Lookup->getParamTag($Page, "p_x_processo_idprocesso") ?>
<script>
loadjs.ready("fitem_plano_aud_intedit", function() {
    var options = { name: "x_processo_idprocesso", selectId: "fitem_plano_aud_intedit_x_processo_idprocesso" };
    if (fitem_plano_aud_intedit.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x_processo_idprocesso", form: "fitem_plano_aud_intedit" };
    } else {
        options.ajax = { id: "x_processo_idprocesso", form: "fitem_plano_aud_intedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.item_plano_aud_int.fields.processo_idprocesso.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->escopo->Visible) { // escopo ?>
    <div id="r_escopo"<?= $Page->escopo->rowAttributes() ?>>
        <label id="elh_item_plano_aud_int_escopo" for="x_escopo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->escopo->caption() ?><?= $Page->escopo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->escopo->cellAttributes() ?>>
<span id="el_item_plano_aud_int_escopo">
<textarea data-table="item_plano_aud_int" data-field="x_escopo" name="x_escopo" id="x_escopo" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->escopo->getPlaceHolder()) ?>"<?= $Page->escopo->editAttributes() ?> aria-describedby="x_escopo_help"><?= $Page->escopo->EditValue ?></textarea>
<?= $Page->escopo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->escopo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label id="elh_item_plano_aud_int_usuario_idusuario" for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_idusuario->caption() ?><?= $Page->usuario_idusuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_item_plano_aud_int_usuario_idusuario">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-control ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        data-select2-id="fitem_plano_aud_intedit_x_usuario_idusuario"
        data-table="item_plano_aud_int"
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
loadjs.ready("fitem_plano_aud_intedit", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fitem_plano_aud_intedit_x_usuario_idusuario" };
    if (fitem_plano_aud_intedit.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fitem_plano_aud_intedit" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fitem_plano_aud_intedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.item_plano_aud_int.fields.usuario_idusuario.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("relatorio_aud_int", explode(",", $Page->getCurrentDetailTable())) && $relatorio_aud_int->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("relatorio_aud_int", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "RelatorioAudIntGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fitem_plano_aud_intedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fitem_plano_aud_intedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("item_plano_aud_int");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
