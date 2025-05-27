<?php

namespace PHPMaker2024\sgq;

// Page object
$GraficosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { graficos: currentTable } });
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
            ["competencia_idcompetencia", [fields.competencia_idcompetencia.visible && fields.competencia_idcompetencia.required ? ew.Validators.required(fields.competencia_idcompetencia.caption) : null], fields.competencia_idcompetencia.isInvalid],
            ["indicadores_idindicadores", [fields.indicadores_idindicadores.visible && fields.indicadores_idindicadores.required ? ew.Validators.required(fields.indicadores_idindicadores.caption) : null], fields.indicadores_idindicadores.isInvalid],
            ["valor", [fields.valor.visible && fields.valor.required ? ew.Validators.required(fields.valor.caption) : null, ew.Validators.float], fields.valor.isInvalid],
            ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["competencia_idcompetencia",false],["indicadores_idindicadores",false],["valor",false],["obs",false]];
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
            "competencia_idcompetencia": <?= $Page->competencia_idcompetencia->toClientList($Page) ?>,
            "indicadores_idindicadores": <?= $Page->indicadores_idindicadores->toClientList($Page) ?>,
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "indicadores") {
    if ($Page->MasterRecordExists) {
        include_once "views/IndicadoresMaster.php";
    }
}
?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fgraficossrch" id="fgraficossrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fgraficossrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { graficos: currentTable } });
var currentForm;
var fgraficossrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fgraficossrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
            "indicadores_idindicadores": <?= $Page->indicadores_idindicadores->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="graficos">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "indicadores" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="indicadores">
<input type="hidden" name="fk_idindicadores" value="<?= HtmlEncode($Page->indicadores_idindicadores->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_graficos" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_graficoslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->competencia_idcompetencia->Visible) { // competencia_idcompetencia ?>
        <th data-name="competencia_idcompetencia" class="<?= $Page->competencia_idcompetencia->headerCellClass() ?>"><div id="elh_graficos_competencia_idcompetencia" class="graficos_competencia_idcompetencia"><?= $Page->renderFieldHeader($Page->competencia_idcompetencia) ?></div></th>
<?php } ?>
<?php if ($Page->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
        <th data-name="indicadores_idindicadores" class="<?= $Page->indicadores_idindicadores->headerCellClass() ?>"><div id="elh_graficos_indicadores_idindicadores" class="graficos_indicadores_idindicadores"><?= $Page->renderFieldHeader($Page->indicadores_idindicadores) ?></div></th>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <th data-name="valor" class="<?= $Page->valor->headerCellClass() ?>"><div id="elh_graficos_valor" class="graficos_valor"><?= $Page->renderFieldHeader($Page->valor) ?></div></th>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
        <th data-name="obs" class="<?= $Page->obs->headerCellClass() ?>"><div id="elh_graficos_obs" class="graficos_obs"><?= $Page->renderFieldHeader($Page->obs) ?></div></th>
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
    <?php if ($Page->competencia_idcompetencia->Visible) { // competencia_idcompetencia ?>
        <td data-name="competencia_idcompetencia"<?= $Page->competencia_idcompetencia->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_competencia_idcompetencia" class="el_graficos_competencia_idcompetencia">
    <select
        id="x<?= $Page->RowIndex ?>_competencia_idcompetencia"
        name="x<?= $Page->RowIndex ?>_competencia_idcompetencia"
        class="form-select ew-select<?= $Page->competencia_idcompetencia->isInvalidClass() ?>"
        <?php if (!$Page->competencia_idcompetencia->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_competencia_idcompetencia"
        <?php } ?>
        data-table="graficos"
        data-field="x_competencia_idcompetencia"
        data-value-separator="<?= $Page->competencia_idcompetencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->competencia_idcompetencia->getPlaceHolder()) ?>"
        <?= $Page->competencia_idcompetencia->editAttributes() ?>>
        <?= $Page->competencia_idcompetencia->selectOptionListHtml("x{$Page->RowIndex}_competencia_idcompetencia") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->competencia_idcompetencia->getErrorMessage() ?></div>
<?= $Page->competencia_idcompetencia->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_competencia_idcompetencia") ?>
<?php if (!$Page->competencia_idcompetencia->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_competencia_idcompetencia", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_competencia_idcompetencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.competencia_idcompetencia?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_competencia_idcompetencia", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_competencia_idcompetencia", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.competencia_idcompetencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="graficos" data-field="x_competencia_idcompetencia" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_competencia_idcompetencia" id="o<?= $Page->RowIndex ?>_competencia_idcompetencia" value="<?= HtmlEncode($Page->competencia_idcompetencia->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_competencia_idcompetencia" class="el_graficos_competencia_idcompetencia">
    <select
        id="x<?= $Page->RowIndex ?>_competencia_idcompetencia"
        name="x<?= $Page->RowIndex ?>_competencia_idcompetencia"
        class="form-select ew-select<?= $Page->competencia_idcompetencia->isInvalidClass() ?>"
        <?php if (!$Page->competencia_idcompetencia->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_competencia_idcompetencia"
        <?php } ?>
        data-table="graficos"
        data-field="x_competencia_idcompetencia"
        data-value-separator="<?= $Page->competencia_idcompetencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->competencia_idcompetencia->getPlaceHolder()) ?>"
        <?= $Page->competencia_idcompetencia->editAttributes() ?>>
        <?= $Page->competencia_idcompetencia->selectOptionListHtml("x{$Page->RowIndex}_competencia_idcompetencia") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->competencia_idcompetencia->getErrorMessage() ?></div>
<?= $Page->competencia_idcompetencia->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_competencia_idcompetencia") ?>
<?php if (!$Page->competencia_idcompetencia->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_competencia_idcompetencia", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_competencia_idcompetencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.competencia_idcompetencia?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_competencia_idcompetencia", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_competencia_idcompetencia", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.competencia_idcompetencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_competencia_idcompetencia" class="el_graficos_competencia_idcompetencia">
<span<?= $Page->competencia_idcompetencia->viewAttributes() ?>>
<?= $Page->competencia_idcompetencia->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
        <td data-name="indicadores_idindicadores"<?= $Page->indicadores_idindicadores->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<?php if ($Page->indicadores_idindicadores->getSessionValue() != "") { ?>
<span<?= $Page->indicadores_idindicadores->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->indicadores_idindicadores->getDisplayValue($Page->indicadores_idindicadores->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_indicadores_idindicadores" name="x<?= $Page->RowIndex ?>_indicadores_idindicadores" value="<?= HtmlEncode($Page->indicadores_idindicadores->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_indicadores_idindicadores" class="el_graficos_indicadores_idindicadores">
    <select
        id="x<?= $Page->RowIndex ?>_indicadores_idindicadores"
        name="x<?= $Page->RowIndex ?>_indicadores_idindicadores"
        class="form-select ew-select<?= $Page->indicadores_idindicadores->isInvalidClass() ?>"
        <?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_indicadores_idindicadores"
        <?php } ?>
        data-table="graficos"
        data-field="x_indicadores_idindicadores"
        data-value-separator="<?= $Page->indicadores_idindicadores->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->indicadores_idindicadores->getPlaceHolder()) ?>"
        <?= $Page->indicadores_idindicadores->editAttributes() ?>>
        <?= $Page->indicadores_idindicadores->selectOptionListHtml("x{$Page->RowIndex}_indicadores_idindicadores") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->indicadores_idindicadores->getErrorMessage() ?></div>
<?= $Page->indicadores_idindicadores->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_indicadores_idindicadores") ?>
<?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_indicadores_idindicadores", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_indicadores_idindicadores" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.indicadores_idindicadores?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_indicadores_idindicadores", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_indicadores_idindicadores", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.indicadores_idindicadores.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<input type="hidden" data-table="graficos" data-field="x_indicadores_idindicadores" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_indicadores_idindicadores" id="o<?= $Page->RowIndex ?>_indicadores_idindicadores" value="<?= HtmlEncode($Page->indicadores_idindicadores->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Page->indicadores_idindicadores->getSessionValue() != "") { ?>
<span<?= $Page->indicadores_idindicadores->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->indicadores_idindicadores->getDisplayValue($Page->indicadores_idindicadores->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_indicadores_idindicadores" name="x<?= $Page->RowIndex ?>_indicadores_idindicadores" value="<?= HtmlEncode($Page->indicadores_idindicadores->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_indicadores_idindicadores" class="el_graficos_indicadores_idindicadores">
    <select
        id="x<?= $Page->RowIndex ?>_indicadores_idindicadores"
        name="x<?= $Page->RowIndex ?>_indicadores_idindicadores"
        class="form-select ew-select<?= $Page->indicadores_idindicadores->isInvalidClass() ?>"
        <?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_indicadores_idindicadores"
        <?php } ?>
        data-table="graficos"
        data-field="x_indicadores_idindicadores"
        data-value-separator="<?= $Page->indicadores_idindicadores->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->indicadores_idindicadores->getPlaceHolder()) ?>"
        <?= $Page->indicadores_idindicadores->editAttributes() ?>>
        <?= $Page->indicadores_idindicadores->selectOptionListHtml("x{$Page->RowIndex}_indicadores_idindicadores") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->indicadores_idindicadores->getErrorMessage() ?></div>
<?= $Page->indicadores_idindicadores->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_indicadores_idindicadores") ?>
<?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_indicadores_idindicadores", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_indicadores_idindicadores" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.indicadores_idindicadores?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_indicadores_idindicadores", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_indicadores_idindicadores", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.indicadores_idindicadores.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_indicadores_idindicadores" class="el_graficos_indicadores_idindicadores">
<span<?= $Page->indicadores_idindicadores->viewAttributes() ?>>
<?= $Page->indicadores_idindicadores->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->valor->Visible) { // valor ?>
        <td data-name="valor"<?= $Page->valor->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_valor" class="el_graficos_valor">
<input type="<?= $Page->valor->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_valor" id="x<?= $Page->RowIndex ?>_valor" data-table="graficos" data-field="x_valor" value="<?= $Page->valor->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->valor->formatPattern()) ?>"<?= $Page->valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->valor->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="graficos" data-field="x_valor" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_valor" id="o<?= $Page->RowIndex ?>_valor" value="<?= HtmlEncode($Page->valor->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_valor" class="el_graficos_valor">
<input type="<?= $Page->valor->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_valor" id="x<?= $Page->RowIndex ?>_valor" data-table="graficos" data-field="x_valor" value="<?= $Page->valor->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->valor->formatPattern()) ?>"<?= $Page->valor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->valor->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_valor" class="el_graficos_valor">
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->obs->Visible) { // obs ?>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_obs" class="el_graficos_obs">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_obs" id="x<?= $Page->RowIndex ?>_obs" data-table="graficos" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="25" maxlength="100" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="graficos" data-field="x_obs" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_obs" id="o<?= $Page->RowIndex ?>_obs" value="<?= HtmlEncode($Page->obs->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_obs" class="el_graficos_obs">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_obs" id="x<?= $Page->RowIndex ?>_obs" data-table="graficos" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="25" maxlength="100" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_graficos_obs" class="el_graficos_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
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
    $Page->EvidenciasxMes->DrillDownInPanel = $Page->DrillDownInPanel;
    echo $Page->EvidenciasxMes->render("ew-chart-bottom");
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
    ew.addEventHandlers("graficos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
