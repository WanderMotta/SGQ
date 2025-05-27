<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseSwotList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_swot: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["fatores", [fields.fatores.visible && fields.fatores.required ? ew.Validators.required(fields.fatores.caption) : null], fields.fatores.isInvalid],
            ["ponto", [fields.ponto.visible && fields.ponto.required ? ew.Validators.required(fields.ponto.caption) : null], fields.ponto.isInvalid],
            ["analise", [fields.analise.visible && fields.analise.required ? ew.Validators.required(fields.analise.caption) : null], fields.analise.isInvalid],
            ["impacto_idimpacto", [fields.impacto_idimpacto.visible && fields.impacto_idimpacto.required ? ew.Validators.required(fields.impacto_idimpacto.caption) : null], fields.impacto_idimpacto.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["fatores",false],["ponto",false],["analise",false],["impacto_idimpacto",false]];
                if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
                    return false;
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
            "fatores": <?= $Page->fatores->toClientList($Page) ?>,
            "ponto": <?= $Page->ponto->toClientList($Page) ?>,
            "impacto_idimpacto": <?= $Page->impacto_idimpacto->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
ew.PREVIEW_SELECTOR ??= ".ew-preview-btn";
ew.PREVIEW_TYPE ??= "row";
ew.PREVIEW_NAV_STYLE ??= "tabs"; // tabs/pills/underline
ew.PREVIEW_MODAL_CLASS ??= "modal modal-fullscreen-sm-down";
ew.PREVIEW_ROW ??= true;
ew.PREVIEW_SINGLE_ROW ??= false;
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.min.js?v=24.12.0", "preview");
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "contexto") {
    if ($Page->MasterRecordExists) {
        include_once "views/ContextoMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fanalise_swotsrch" id="fanalise_swotsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fanalise_swotsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_swot: currentTable } });
var currentForm;
var fanalise_swotsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fanalise_swotsrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fanalise_swotsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fanalise_swotsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fanalise_swotsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fanalise_swotsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="analise_swot">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "contexto" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="contexto">
<input type="hidden" name="fk_idcontexto" value="<?= HtmlEncode($Page->contexto_idcontexto->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_analise_swot" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_analise_swotlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->fatores->Visible) { // fatores ?>
        <th data-name="fatores" class="<?= $Page->fatores->headerCellClass() ?>"><div id="elh_analise_swot_fatores" class="analise_swot_fatores"><?= $Page->renderFieldHeader($Page->fatores) ?></div></th>
<?php } ?>
<?php if ($Page->ponto->Visible) { // ponto ?>
        <th data-name="ponto" class="<?= $Page->ponto->headerCellClass() ?>"><div id="elh_analise_swot_ponto" class="analise_swot_ponto"><?= $Page->renderFieldHeader($Page->ponto) ?></div></th>
<?php } ?>
<?php if ($Page->analise->Visible) { // analise ?>
        <th data-name="analise" class="<?= $Page->analise->headerCellClass() ?>"><div id="elh_analise_swot_analise" class="analise_swot_analise"><?= $Page->renderFieldHeader($Page->analise) ?></div></th>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <th data-name="impacto_idimpacto" class="<?= $Page->impacto_idimpacto->headerCellClass() ?>"><div id="elh_analise_swot_impacto_idimpacto" class="analise_swot_impacto_idimpacto"><?= $Page->renderFieldHeader($Page->impacto_idimpacto) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$') {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        (!(($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0))
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow()) &&
            $Page->RowAction != "hide"
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->fatores->Visible) { // fatores ?>
        <td data-name="fatores"<?= $Page->fatores->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_fatores" class="el_analise_swot_fatores">
<template id="tp_x<?= $Page->RowIndex ?>_fatores">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_fatores" name="x<?= $Page->RowIndex ?>_fatores" id="x<?= $Page->RowIndex ?>_fatores"<?= $Page->fatores->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_fatores" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_fatores"
    name="x<?= $Page->RowIndex ?>_fatores"
    value="<?= HtmlEncode($Page->fatores->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_fatores"
    data-target="dsl_x<?= $Page->RowIndex ?>_fatores"
    data-repeatcolumn="5"
    class="form-control<?= $Page->fatores->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_fatores"
    data-value-separator="<?= $Page->fatores->displayValueSeparatorAttribute() ?>"
    <?= $Page->fatores->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->fatores->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="analise_swot" data-field="x_fatores" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_fatores" id="o<?= $Page->RowIndex ?>_fatores" value="<?= HtmlEncode($Page->fatores->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_fatores" class="el_analise_swot_fatores">
<template id="tp_x<?= $Page->RowIndex ?>_fatores">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_fatores" name="x<?= $Page->RowIndex ?>_fatores" id="x<?= $Page->RowIndex ?>_fatores"<?= $Page->fatores->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_fatores" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_fatores"
    name="x<?= $Page->RowIndex ?>_fatores"
    value="<?= HtmlEncode($Page->fatores->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_fatores"
    data-target="dsl_x<?= $Page->RowIndex ?>_fatores"
    data-repeatcolumn="5"
    class="form-control<?= $Page->fatores->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_fatores"
    data-value-separator="<?= $Page->fatores->displayValueSeparatorAttribute() ?>"
    <?= $Page->fatores->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->fatores->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_fatores" class="el_analise_swot_fatores">
<span<?= $Page->fatores->viewAttributes() ?>>
<?= $Page->fatores->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ponto->Visible) { // ponto ?>
        <td data-name="ponto"<?= $Page->ponto->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_ponto" class="el_analise_swot_ponto">
<template id="tp_x<?= $Page->RowIndex ?>_ponto">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_ponto" name="x<?= $Page->RowIndex ?>_ponto" id="x<?= $Page->RowIndex ?>_ponto"<?= $Page->ponto->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_ponto" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_ponto"
    name="x<?= $Page->RowIndex ?>_ponto"
    value="<?= HtmlEncode($Page->ponto->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_ponto"
    data-target="dsl_x<?= $Page->RowIndex ?>_ponto"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ponto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_ponto"
    data-value-separator="<?= $Page->ponto->displayValueSeparatorAttribute() ?>"
    <?= $Page->ponto->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ponto->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="analise_swot" data-field="x_ponto" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_ponto" id="o<?= $Page->RowIndex ?>_ponto" value="<?= HtmlEncode($Page->ponto->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_ponto" class="el_analise_swot_ponto">
<template id="tp_x<?= $Page->RowIndex ?>_ponto">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_ponto" name="x<?= $Page->RowIndex ?>_ponto" id="x<?= $Page->RowIndex ?>_ponto"<?= $Page->ponto->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_ponto" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_ponto"
    name="x<?= $Page->RowIndex ?>_ponto"
    value="<?= HtmlEncode($Page->ponto->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_ponto"
    data-target="dsl_x<?= $Page->RowIndex ?>_ponto"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ponto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_ponto"
    data-value-separator="<?= $Page->ponto->displayValueSeparatorAttribute() ?>"
    <?= $Page->ponto->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ponto->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_ponto" class="el_analise_swot_ponto">
<span<?= $Page->ponto->viewAttributes() ?>>
<?= $Page->ponto->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->analise->Visible) { // analise ?>
        <td data-name="analise"<?= $Page->analise->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_analise" class="el_analise_swot_analise">
<textarea data-table="analise_swot" data-field="x_analise" name="x<?= $Page->RowIndex ?>_analise" id="x<?= $Page->RowIndex ?>_analise" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->analise->getPlaceHolder()) ?>"<?= $Page->analise->editAttributes() ?>><?= $Page->analise->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->analise->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="analise_swot" data-field="x_analise" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_analise" id="o<?= $Page->RowIndex ?>_analise" value="<?= HtmlEncode($Page->analise->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_analise" class="el_analise_swot_analise">
<textarea data-table="analise_swot" data-field="x_analise" name="x<?= $Page->RowIndex ?>_analise" id="x<?= $Page->RowIndex ?>_analise" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->analise->getPlaceHolder()) ?>"<?= $Page->analise->editAttributes() ?>><?= $Page->analise->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->analise->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_analise" class="el_analise_swot_analise">
<span<?= $Page->analise->viewAttributes() ?>>
<?= $Page->analise->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <td data-name="impacto_idimpacto"<?= $Page->impacto_idimpacto->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_impacto_idimpacto" class="el_analise_swot_impacto_idimpacto">
<template id="tp_x<?= $Page->RowIndex ?>_impacto_idimpacto">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_impacto_idimpacto" name="x<?= $Page->RowIndex ?>_impacto_idimpacto" id="x<?= $Page->RowIndex ?>_impacto_idimpacto"<?= $Page->impacto_idimpacto->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_impacto_idimpacto" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_impacto_idimpacto"
    name="x<?= $Page->RowIndex ?>_impacto_idimpacto"
    value="<?= HtmlEncode($Page->impacto_idimpacto->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_impacto_idimpacto"
    data-target="dsl_x<?= $Page->RowIndex ?>_impacto_idimpacto"
    data-repeatcolumn="5"
    class="form-control<?= $Page->impacto_idimpacto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_impacto_idimpacto"
    data-value-separator="<?= $Page->impacto_idimpacto->displayValueSeparatorAttribute() ?>"
    <?= $Page->impacto_idimpacto->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->impacto_idimpacto->getErrorMessage() ?></div>
<?= $Page->impacto_idimpacto->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_impacto_idimpacto") ?>
</span>
<input type="hidden" data-table="analise_swot" data-field="x_impacto_idimpacto" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_impacto_idimpacto" id="o<?= $Page->RowIndex ?>_impacto_idimpacto" value="<?= HtmlEncode($Page->impacto_idimpacto->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_impacto_idimpacto" class="el_analise_swot_impacto_idimpacto">
<template id="tp_x<?= $Page->RowIndex ?>_impacto_idimpacto">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="analise_swot" data-field="x_impacto_idimpacto" name="x<?= $Page->RowIndex ?>_impacto_idimpacto" id="x<?= $Page->RowIndex ?>_impacto_idimpacto"<?= $Page->impacto_idimpacto->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_impacto_idimpacto" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_impacto_idimpacto"
    name="x<?= $Page->RowIndex ?>_impacto_idimpacto"
    value="<?= HtmlEncode($Page->impacto_idimpacto->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_impacto_idimpacto"
    data-target="dsl_x<?= $Page->RowIndex ?>_impacto_idimpacto"
    data-repeatcolumn="5"
    class="form-control<?= $Page->impacto_idimpacto->isInvalidClass() ?>"
    data-table="analise_swot"
    data-field="x_impacto_idimpacto"
    data-value-separator="<?= $Page->impacto_idimpacto->displayValueSeparatorAttribute() ?>"
    <?= $Page->impacto_idimpacto->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->impacto_idimpacto->getErrorMessage() ?></div>
<?= $Page->impacto_idimpacto->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_impacto_idimpacto") ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_analise_swot_impacto_idimpacto" class="el_analise_swot_impacto_idimpacto">
<span<?= $Page->impacto_idimpacto->viewAttributes() ?>>
<?= $Page->impacto_idimpacto->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == RowType::ADD || $Page->RowType == RowType::EDIT) { ?>
<script data-rowindex="<?= $Page->RowIndex ?>">
loadjs.ready(["<?= $Page->FormName ?>","load"], () => <?= $Page->FormName ?>.updateLists(<?= $Page->RowIndex ?><?= $Page->isAdd() || $Page->isEdit() || $Page->isCopy() || $Page->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
<?php
// Render aggregate row
$Page->RowType = RowType::AGGREGATE;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->TotalRecords > 0 && !$Page->isGridAdd() && !$Page->isGridEdit() && !$Page->isMultiEdit()) { ?>
<tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (footer, left)
$Page->ListOptions->render("footer", "left");
?>
    <?php if ($Page->fatores->Visible) { // fatores ?>
        <td data-name="fatores" class="<?= $Page->fatores->footerCellClass() ?>"><span id="elf_analise_swot_fatores" class="analise_swot_fatores">
        </span></td>
    <?php } ?>
    <?php if ($Page->ponto->Visible) { // ponto ?>
        <td data-name="ponto" class="<?= $Page->ponto->footerCellClass() ?>"><span id="elf_analise_swot_ponto" class="analise_swot_ponto">
        </span></td>
    <?php } ?>
    <?php if ($Page->analise->Visible) { // analise ?>
        <td data-name="analise" class="<?= $Page->analise->footerCellClass() ?>"><span id="elf_analise_swot_analise" class="analise_swot_analise">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->analise->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <td data-name="impacto_idimpacto" class="<?= $Page->impacto_idimpacto->footerCellClass() ?>"><span id="elf_analise_swot_impacto_idimpacto" class="analise_swot_impacto_idimpacto">
        </span></td>
    <?php } ?>
<?php
// Render list options (footer, right)
$Page->ListOptions->render("footer", "right");
?>
    </tr>
</tfoot>
<?php } ?>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } elseif ($Page->isMultiEdit()) { ?>
<input type="hidden" name="action" id="action" value="multiupdate">
<?php } ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Recordset?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("analise_swot");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
