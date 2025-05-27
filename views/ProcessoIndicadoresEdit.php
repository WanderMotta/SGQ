<?php

namespace PHPMaker2024\sgq;

// Page object
$ProcessoIndicadoresEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fprocesso_indicadoresedit" id="fprocesso_indicadoresedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { processo_indicadores: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fprocesso_indicadoresedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fprocesso_indicadoresedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idprocesso_indicadores", [fields.idprocesso_indicadores.visible && fields.idprocesso_indicadores.required ? ew.Validators.required(fields.idprocesso_indicadores.caption) : null], fields.idprocesso_indicadores.isInvalid],
            ["processo_idprocesso", [fields.processo_idprocesso.visible && fields.processo_idprocesso.required ? ew.Validators.required(fields.processo_idprocesso.caption) : null], fields.processo_idprocesso.isInvalid],
            ["indicadores_idindicadores", [fields.indicadores_idindicadores.visible && fields.indicadores_idindicadores.required ? ew.Validators.required(fields.indicadores_idindicadores.caption) : null], fields.indicadores_idindicadores.isInvalid]
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
            "indicadores_idindicadores": <?= $Page->indicadores_idindicadores->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="processo_indicadores">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "processo") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="processo">
<input type="hidden" name="fk_idprocesso" value="<?= HtmlEncode($Page->processo_idprocesso->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idprocesso_indicadores->Visible) { // idprocesso_indicadores ?>
    <div id="r_idprocesso_indicadores"<?= $Page->idprocesso_indicadores->rowAttributes() ?>>
        <label id="elh_processo_indicadores_idprocesso_indicadores" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idprocesso_indicadores->caption() ?><?= $Page->idprocesso_indicadores->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idprocesso_indicadores->cellAttributes() ?>>
<span id="el_processo_indicadores_idprocesso_indicadores">
<span<?= $Page->idprocesso_indicadores->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idprocesso_indicadores->getDisplayValue($Page->idprocesso_indicadores->EditValue))) ?>"></span>
<input type="hidden" data-table="processo_indicadores" data-field="x_idprocesso_indicadores" data-hidden="1" name="x_idprocesso_indicadores" id="x_idprocesso_indicadores" value="<?= HtmlEncode($Page->idprocesso_indicadores->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <div id="r_processo_idprocesso"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <label id="elh_processo_indicadores_processo_idprocesso" for="x_processo_idprocesso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->processo_idprocesso->caption() ?><?= $Page->processo_idprocesso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->processo_idprocesso->cellAttributes() ?>>
<?php if ($Page->processo_idprocesso->getSessionValue() != "") { ?>
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->processo_idprocesso->getDisplayValue($Page->processo_idprocesso->ViewValue) ?></span></span>
<input type="hidden" id="x_processo_idprocesso" name="x_processo_idprocesso" value="<?= HtmlEncode($Page->processo_idprocesso->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_processo_indicadores_processo_idprocesso">
    <select
        id="x_processo_idprocesso"
        name="x_processo_idprocesso"
        class="form-select ew-select<?= $Page->processo_idprocesso->isInvalidClass() ?>"
        <?php if (!$Page->processo_idprocesso->IsNativeSelect) { ?>
        data-select2-id="fprocesso_indicadoresedit_x_processo_idprocesso"
        <?php } ?>
        data-table="processo_indicadores"
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
loadjs.ready("fprocesso_indicadoresedit", function() {
    var options = { name: "x_processo_idprocesso", selectId: "fprocesso_indicadoresedit_x_processo_idprocesso" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fprocesso_indicadoresedit.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x_processo_idprocesso", form: "fprocesso_indicadoresedit" };
    } else {
        options.ajax = { id: "x_processo_idprocesso", form: "fprocesso_indicadoresedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.processo_indicadores.fields.processo_idprocesso.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
    <div id="r_indicadores_idindicadores"<?= $Page->indicadores_idindicadores->rowAttributes() ?>>
        <label id="elh_processo_indicadores_indicadores_idindicadores" for="x_indicadores_idindicadores" class="<?= $Page->LeftColumnClass ?>"><?= $Page->indicadores_idindicadores->caption() ?><?= $Page->indicadores_idindicadores->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->indicadores_idindicadores->cellAttributes() ?>>
<span id="el_processo_indicadores_indicadores_idindicadores">
    <select
        id="x_indicadores_idindicadores"
        name="x_indicadores_idindicadores"
        class="form-select ew-select<?= $Page->indicadores_idindicadores->isInvalidClass() ?>"
        <?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
        data-select2-id="fprocesso_indicadoresedit_x_indicadores_idindicadores"
        <?php } ?>
        data-table="processo_indicadores"
        data-field="x_indicadores_idindicadores"
        data-value-separator="<?= $Page->indicadores_idindicadores->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->indicadores_idindicadores->getPlaceHolder()) ?>"
        <?= $Page->indicadores_idindicadores->editAttributes() ?>>
        <?= $Page->indicadores_idindicadores->selectOptionListHtml("x_indicadores_idindicadores") ?>
    </select>
    <?= $Page->indicadores_idindicadores->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->indicadores_idindicadores->getErrorMessage() ?></div>
<?= $Page->indicadores_idindicadores->Lookup->getParamTag($Page, "p_x_indicadores_idindicadores") ?>
<?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
<script>
loadjs.ready("fprocesso_indicadoresedit", function() {
    var options = { name: "x_indicadores_idindicadores", selectId: "fprocesso_indicadoresedit_x_indicadores_idindicadores" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fprocesso_indicadoresedit.lists.indicadores_idindicadores?.lookupOptions.length) {
        options.data = { id: "x_indicadores_idindicadores", form: "fprocesso_indicadoresedit" };
    } else {
        options.ajax = { id: "x_indicadores_idindicadores", form: "fprocesso_indicadoresedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.processo_indicadores.fields.indicadores_idindicadores.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fprocesso_indicadoresedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fprocesso_indicadoresedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("processo_indicadores");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
