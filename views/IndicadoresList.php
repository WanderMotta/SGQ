<?php

namespace PHPMaker2024\sgq;

// Page object
$IndicadoresList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { indicadores: currentTable } });
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
            ["indicador", [fields.indicador.visible && fields.indicador.required ? ew.Validators.required(fields.indicador.caption) : null], fields.indicador.isInvalid],
            ["periodicidade_idperiodicidade", [fields.periodicidade_idperiodicidade.visible && fields.periodicidade_idperiodicidade.required ? ew.Validators.required(fields.periodicidade_idperiodicidade.caption) : null], fields.periodicidade_idperiodicidade.isInvalid],
            ["unidade_medida_idunidade_medida", [fields.unidade_medida_idunidade_medida.visible && fields.unidade_medida_idunidade_medida.required ? ew.Validators.required(fields.unidade_medida_idunidade_medida.caption) : null], fields.unidade_medida_idunidade_medida.isInvalid],
            ["meta", [fields.meta.visible && fields.meta.required ? ew.Validators.required(fields.meta.caption) : null, ew.Validators.float], fields.meta.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["indicador",false],["periodicidade_idperiodicidade",false],["unidade_medida_idunidade_medida",false],["meta",false]];
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
            "periodicidade_idperiodicidade": <?= $Page->periodicidade_idperiodicidade->toClientList($Page) ?>,
            "unidade_medida_idunidade_medida": <?= $Page->unidade_medida_idunidade_medida->toClientList($Page) ?>,
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
<?php if (!$Page->IsModal) { ?>
<form name="findicadoressrch" id="findicadoressrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="findicadoressrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { indicadores: currentTable } });
var currentForm;
var findicadoressrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("findicadoressrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="findicadoressrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="findicadoressrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="findicadoressrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="findicadoressrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
<!-- Middle Container -->
<div id="ew-middle" class="<?= $Page->MiddleContentClass ?>">
<?php } ?>
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
<!-- Content Container -->
<div id="ew-content" class="<?= $Page->ContainerClass ?>">
<?php } ?>
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
<input type="hidden" name="t" value="indicadores">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_indicadores" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_indicadoreslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->indicador->Visible) { // indicador ?>
        <th data-name="indicador" class="<?= $Page->indicador->headerCellClass() ?>"><div id="elh_indicadores_indicador" class="indicadores_indicador"><?= $Page->renderFieldHeader($Page->indicador) ?></div></th>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <th data-name="periodicidade_idperiodicidade" class="<?= $Page->periodicidade_idperiodicidade->headerCellClass() ?>"><div id="elh_indicadores_periodicidade_idperiodicidade" class="indicadores_periodicidade_idperiodicidade"><?= $Page->renderFieldHeader($Page->periodicidade_idperiodicidade) ?></div></th>
<?php } ?>
<?php if ($Page->unidade_medida_idunidade_medida->Visible) { // unidade_medida_idunidade_medida ?>
        <th data-name="unidade_medida_idunidade_medida" class="<?= $Page->unidade_medida_idunidade_medida->headerCellClass() ?>"><div id="elh_indicadores_unidade_medida_idunidade_medida" class="indicadores_unidade_medida_idunidade_medida"><?= $Page->renderFieldHeader($Page->unidade_medida_idunidade_medida) ?></div></th>
<?php } ?>
<?php if ($Page->meta->Visible) { // meta ?>
        <th data-name="meta" class="<?= $Page->meta->headerCellClass() ?>"><div id="elh_indicadores_meta" class="indicadores_meta"><?= $Page->renderFieldHeader($Page->meta) ?></div></th>
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
    <?php if ($Page->indicador->Visible) { // indicador ?>
        <td data-name="indicador"<?= $Page->indicador->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_indicador" class="el_indicadores_indicador">
<input type="<?= $Page->indicador->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_indicador" id="x<?= $Page->RowIndex ?>_indicador" data-table="indicadores" data-field="x_indicador" value="<?= $Page->indicador->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->indicador->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->indicador->formatPattern()) ?>"<?= $Page->indicador->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->indicador->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="indicadores" data-field="x_indicador" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_indicador" id="o<?= $Page->RowIndex ?>_indicador" value="<?= HtmlEncode($Page->indicador->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_indicador" class="el_indicadores_indicador">
<input type="<?= $Page->indicador->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_indicador" id="x<?= $Page->RowIndex ?>_indicador" data-table="indicadores" data-field="x_indicador" value="<?= $Page->indicador->EditValue ?>" size="60" maxlength="120" placeholder="<?= HtmlEncode($Page->indicador->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->indicador->formatPattern()) ?>"<?= $Page->indicador->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->indicador->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_indicador" class="el_indicadores_indicador">
<span<?= $Page->indicador->viewAttributes() ?>>
<?= $Page->indicador->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <td data-name="periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_periodicidade_idperiodicidade" class="el_indicadores_periodicidade_idperiodicidade">
<template id="tp_x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="indicadores" data-field="x_periodicidade_idperiodicidade" name="x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade" id="x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade"
    name="x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade"
    value="<?= HtmlEncode($Page->periodicidade_idperiodicidade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade"
    data-target="dsl_x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodicidade_idperiodicidade->isInvalidClass() ?>"
    data-table="indicadores"
    data-field="x_periodicidade_idperiodicidade"
    data-value-separator="<?= $Page->periodicidade_idperiodicidade->displayValueSeparatorAttribute() ?>"
    <?= $Page->periodicidade_idperiodicidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->periodicidade_idperiodicidade->getErrorMessage() ?></div>
<?= $Page->periodicidade_idperiodicidade->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_periodicidade_idperiodicidade") ?>
</span>
<input type="hidden" data-table="indicadores" data-field="x_periodicidade_idperiodicidade" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_periodicidade_idperiodicidade" id="o<?= $Page->RowIndex ?>_periodicidade_idperiodicidade" value="<?= HtmlEncode($Page->periodicidade_idperiodicidade->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_periodicidade_idperiodicidade" class="el_indicadores_periodicidade_idperiodicidade">
<template id="tp_x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="indicadores" data-field="x_periodicidade_idperiodicidade" name="x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade" id="x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade"<?= $Page->periodicidade_idperiodicidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade"
    name="x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade"
    value="<?= HtmlEncode($Page->periodicidade_idperiodicidade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade"
    data-target="dsl_x<?= $Page->RowIndex ?>_periodicidade_idperiodicidade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->periodicidade_idperiodicidade->isInvalidClass() ?>"
    data-table="indicadores"
    data-field="x_periodicidade_idperiodicidade"
    data-value-separator="<?= $Page->periodicidade_idperiodicidade->displayValueSeparatorAttribute() ?>"
    <?= $Page->periodicidade_idperiodicidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->periodicidade_idperiodicidade->getErrorMessage() ?></div>
<?= $Page->periodicidade_idperiodicidade->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_periodicidade_idperiodicidade") ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_periodicidade_idperiodicidade" class="el_indicadores_periodicidade_idperiodicidade">
<span<?= $Page->periodicidade_idperiodicidade->viewAttributes() ?>>
<?= $Page->periodicidade_idperiodicidade->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->unidade_medida_idunidade_medida->Visible) { // unidade_medida_idunidade_medida ?>
        <td data-name="unidade_medida_idunidade_medida"<?= $Page->unidade_medida_idunidade_medida->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_unidade_medida_idunidade_medida" class="el_indicadores_unidade_medida_idunidade_medida">
<template id="tp_x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="indicadores" data-field="x_unidade_medida_idunidade_medida" name="x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida" id="x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida"<?= $Page->unidade_medida_idunidade_medida->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida"
    name="x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida"
    value="<?= HtmlEncode($Page->unidade_medida_idunidade_medida->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida"
    data-target="dsl_x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida"
    data-repeatcolumn="5"
    class="form-control<?= $Page->unidade_medida_idunidade_medida->isInvalidClass() ?>"
    data-table="indicadores"
    data-field="x_unidade_medida_idunidade_medida"
    data-value-separator="<?= $Page->unidade_medida_idunidade_medida->displayValueSeparatorAttribute() ?>"
    <?= $Page->unidade_medida_idunidade_medida->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->unidade_medida_idunidade_medida->getErrorMessage() ?></div>
<?= $Page->unidade_medida_idunidade_medida->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_unidade_medida_idunidade_medida") ?>
</span>
<input type="hidden" data-table="indicadores" data-field="x_unidade_medida_idunidade_medida" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida" id="o<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida" value="<?= HtmlEncode($Page->unidade_medida_idunidade_medida->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_unidade_medida_idunidade_medida" class="el_indicadores_unidade_medida_idunidade_medida">
<template id="tp_x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="indicadores" data-field="x_unidade_medida_idunidade_medida" name="x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida" id="x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida"<?= $Page->unidade_medida_idunidade_medida->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida"
    name="x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida"
    value="<?= HtmlEncode($Page->unidade_medida_idunidade_medida->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida"
    data-target="dsl_x<?= $Page->RowIndex ?>_unidade_medida_idunidade_medida"
    data-repeatcolumn="5"
    class="form-control<?= $Page->unidade_medida_idunidade_medida->isInvalidClass() ?>"
    data-table="indicadores"
    data-field="x_unidade_medida_idunidade_medida"
    data-value-separator="<?= $Page->unidade_medida_idunidade_medida->displayValueSeparatorAttribute() ?>"
    <?= $Page->unidade_medida_idunidade_medida->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->unidade_medida_idunidade_medida->getErrorMessage() ?></div>
<?= $Page->unidade_medida_idunidade_medida->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_unidade_medida_idunidade_medida") ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_unidade_medida_idunidade_medida" class="el_indicadores_unidade_medida_idunidade_medida">
<span<?= $Page->unidade_medida_idunidade_medida->viewAttributes() ?>>
<?= $Page->unidade_medida_idunidade_medida->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->meta->Visible) { // meta ?>
        <td data-name="meta"<?= $Page->meta->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_meta" class="el_indicadores_meta">
<input type="<?= $Page->meta->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_meta" id="x<?= $Page->RowIndex ?>_meta" data-table="indicadores" data-field="x_meta" value="<?= $Page->meta->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->meta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->meta->formatPattern()) ?>"<?= $Page->meta->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->meta->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="indicadores" data-field="x_meta" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_meta" id="o<?= $Page->RowIndex ?>_meta" value="<?= HtmlEncode($Page->meta->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_meta" class="el_indicadores_meta">
<input type="<?= $Page->meta->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_meta" id="x<?= $Page->RowIndex ?>_meta" data-table="indicadores" data-field="x_meta" value="<?= $Page->meta->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->meta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->meta->formatPattern()) ?>"<?= $Page->meta->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->meta->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_indicadores_meta" class="el_indicadores_meta">
<span<?= $Page->meta->viewAttributes() ?>>
<?= $Page->meta->getViewValue() ?></span>
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
    <?php if ($Page->indicador->Visible) { // indicador ?>
        <td data-name="indicador" class="<?= $Page->indicador->footerCellClass() ?>"><span id="elf_indicadores_indicador" class="indicadores_indicador">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->indicador->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <td data-name="periodicidade_idperiodicidade" class="<?= $Page->periodicidade_idperiodicidade->footerCellClass() ?>"><span id="elf_indicadores_periodicidade_idperiodicidade" class="indicadores_periodicidade_idperiodicidade">
        </span></td>
    <?php } ?>
    <?php if ($Page->unidade_medida_idunidade_medida->Visible) { // unidade_medida_idunidade_medida ?>
        <td data-name="unidade_medida_idunidade_medida" class="<?= $Page->unidade_medida_idunidade_medida->footerCellClass() ?>"><span id="elf_indicadores_unidade_medida_idunidade_medida" class="indicadores_unidade_medida_idunidade_medida">
        </span></td>
    <?php } ?>
    <?php if ($Page->meta->Visible) { // meta ?>
        <td data-name="meta" class="<?= $Page->meta->footerCellClass() ?>"><span id="elf_indicadores_meta" class="indicadores_meta">
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
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
</div>
<!-- /#ew-content -->
<?php } ?>
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
</div>
<!-- /#ew-middle -->
<?php } ?>
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
<!-- Bottom Container -->
<div id="ew-bottom" class="<?= $Page->BottomContentClass ?>">
<?php } ?>
<?php
if (!$DashboardReport) {
    // Set up chart drilldown
    $Page->EvidenciaxMensal->DrillDownInPanel = $Page->DrillDownInPanel;
    echo $Page->EvidenciaxMensal->render("ew-chart-bottom");
}
?>
<?php if (!$Page->isExport() || $Page->isExport("print")) { ?>
</div>
<!-- /#ew-bottom -->
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
    ew.addEventHandlers("indicadores");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
