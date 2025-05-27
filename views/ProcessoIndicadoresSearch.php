<?php

namespace PHPMaker2024\sgq;

// Page object
$ProcessoIndicadoresSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { processo_indicadores: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fprocesso_indicadoressearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fprocesso_indicadoressearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idprocesso_indicadores", [ew.Validators.integer], fields.idprocesso_indicadores.isInvalid],
            ["processo_idprocesso", [], fields.processo_idprocesso.isInvalid],
            ["indicadores_idindicadores", [], fields.indicadores_idindicadores.isInvalid]
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
            "indicadores_idindicadores": <?= $Page->indicadores_idindicadores->toClientList($Page) ?>,
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
<form name="fprocesso_indicadoressearch" id="fprocesso_indicadoressearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="processo_indicadores">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idprocesso_indicadores->Visible) { // idprocesso_indicadores ?>
    <div id="r_idprocesso_indicadores" class="row"<?= $Page->idprocesso_indicadores->rowAttributes() ?>>
        <label for="x_idprocesso_indicadores" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_indicadores_idprocesso_indicadores"><?= $Page->idprocesso_indicadores->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idprocesso_indicadores" id="z_idprocesso_indicadores" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idprocesso_indicadores->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_indicadores_idprocesso_indicadores" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idprocesso_indicadores->getInputTextType() ?>" name="x_idprocesso_indicadores" id="x_idprocesso_indicadores" data-table="processo_indicadores" data-field="x_idprocesso_indicadores" value="<?= $Page->idprocesso_indicadores->EditValue ?>" placeholder="<?= HtmlEncode($Page->idprocesso_indicadores->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idprocesso_indicadores->formatPattern()) ?>"<?= $Page->idprocesso_indicadores->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idprocesso_indicadores->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <div id="r_processo_idprocesso" class="row"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <label for="x_processo_idprocesso" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_indicadores_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_processo_idprocesso" id="z_processo_idprocesso" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->processo_idprocesso->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_indicadores_processo_idprocesso" class="ew-search-field ew-search-field-single">
    <select
        id="x_processo_idprocesso"
        name="x_processo_idprocesso"
        class="form-select ew-select<?= $Page->processo_idprocesso->isInvalidClass() ?>"
        <?php if (!$Page->processo_idprocesso->IsNativeSelect) { ?>
        data-select2-id="fprocesso_indicadoressearch_x_processo_idprocesso"
        <?php } ?>
        data-table="processo_indicadores"
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
loadjs.ready("fprocesso_indicadoressearch", function() {
    var options = { name: "x_processo_idprocesso", selectId: "fprocesso_indicadoressearch_x_processo_idprocesso" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fprocesso_indicadoressearch.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x_processo_idprocesso", form: "fprocesso_indicadoressearch" };
    } else {
        options.ajax = { id: "x_processo_idprocesso", form: "fprocesso_indicadoressearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.processo_indicadores.fields.processo_idprocesso.selectOptions);
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
<?php if ($Page->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
    <div id="r_indicadores_idindicadores" class="row"<?= $Page->indicadores_idindicadores->rowAttributes() ?>>
        <label for="x_indicadores_idindicadores" class="<?= $Page->LeftColumnClass ?>"><span id="elh_processo_indicadores_indicadores_idindicadores"><?= $Page->indicadores_idindicadores->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_indicadores_idindicadores" id="z_indicadores_idindicadores" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->indicadores_idindicadores->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_processo_indicadores_indicadores_idindicadores" class="ew-search-field ew-search-field-single">
    <select
        id="x_indicadores_idindicadores"
        name="x_indicadores_idindicadores"
        class="form-select ew-select<?= $Page->indicadores_idindicadores->isInvalidClass() ?>"
        <?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
        data-select2-id="fprocesso_indicadoressearch_x_indicadores_idindicadores"
        <?php } ?>
        data-table="processo_indicadores"
        data-field="x_indicadores_idindicadores"
        data-value-separator="<?= $Page->indicadores_idindicadores->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->indicadores_idindicadores->getPlaceHolder()) ?>"
        <?= $Page->indicadores_idindicadores->editAttributes() ?>>
        <?= $Page->indicadores_idindicadores->selectOptionListHtml("x_indicadores_idindicadores") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->indicadores_idindicadores->getErrorMessage(false) ?></div>
<?= $Page->indicadores_idindicadores->Lookup->getParamTag($Page, "p_x_indicadores_idindicadores") ?>
<?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
<script>
loadjs.ready("fprocesso_indicadoressearch", function() {
    var options = { name: "x_indicadores_idindicadores", selectId: "fprocesso_indicadoressearch_x_indicadores_idindicadores" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fprocesso_indicadoressearch.lists.indicadores_idindicadores?.lookupOptions.length) {
        options.data = { id: "x_indicadores_idindicadores", form: "fprocesso_indicadoressearch" };
    } else {
        options.ajax = { id: "x_indicadores_idindicadores", form: "fprocesso_indicadoressearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.processo_indicadores.fields.indicadores_idindicadores.selectOptions);
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
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fprocesso_indicadoressearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fprocesso_indicadoressearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fprocesso_indicadoressearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("processo_indicadores");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
