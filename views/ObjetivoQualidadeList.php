<?php

namespace PHPMaker2024\sgq;

// Page object
$ObjetivoQualidadeList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { objetivo_qualidade: currentTable } });
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
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fobjetivo_qualidadesrch" id="fobjetivo_qualidadesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fobjetivo_qualidadesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { objetivo_qualidade: currentTable } });
var currentForm;
var fobjetivo_qualidadesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fobjetivo_qualidadesrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["processo_idprocesso", [], fields.processo_idprocesso.isInvalid]
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
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = RowType::SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
<?php
if (!$Page->processo_idprocesso->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_processo_idprocesso" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->processo_idprocesso->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_processo_idprocesso" class="ew-search-caption ew-label"><?= $Page->processo_idprocesso->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_processo_idprocesso" id="z_processo_idprocesso" value="=">
</div>
        </div>
        <div id="el_objetivo_qualidade_processo_idprocesso" class="ew-search-field">
    <select
        id="x_processo_idprocesso"
        name="x_processo_idprocesso"
        class="form-select ew-select<?= $Page->processo_idprocesso->isInvalidClass() ?>"
        <?php if (!$Page->processo_idprocesso->IsNativeSelect) { ?>
        data-select2-id="fobjetivo_qualidadesrch_x_processo_idprocesso"
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
loadjs.ready("fobjetivo_qualidadesrch", function() {
    var options = { name: "x_processo_idprocesso", selectId: "fobjetivo_qualidadesrch_x_processo_idprocesso" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fobjetivo_qualidadesrch.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x_processo_idprocesso", form: "fobjetivo_qualidadesrch" };
    } else {
        options.ajax = { id: "x_processo_idprocesso", form: "fobjetivo_qualidadesrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.objetivo_qualidade.fields.processo_idprocesso.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fobjetivo_qualidadesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fobjetivo_qualidadesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fobjetivo_qualidadesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fobjetivo_qualidadesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="objetivo_qualidade">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_objetivo_qualidade" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_objetivo_qualidadelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <th data-name="processo_idprocesso" class="<?= $Page->processo_idprocesso->headerCellClass() ?>"><div id="elh_objetivo_qualidade_processo_idprocesso" class="objetivo_qualidade_processo_idprocesso"><?= $Page->renderFieldHeader($Page->processo_idprocesso) ?></div></th>
<?php } ?>
<?php if ($Page->objetivo->Visible) { // objetivo ?>
        <th data-name="objetivo" class="<?= $Page->objetivo->headerCellClass() ?>"><div id="elh_objetivo_qualidade_objetivo" class="objetivo_qualidade_objetivo"><?= $Page->renderFieldHeader($Page->objetivo) ?></div></th>
<?php } ?>
<?php if ($Page->como_medir->Visible) { // como_medir ?>
        <th data-name="como_medir" class="<?= $Page->como_medir->headerCellClass() ?>"><div id="elh_objetivo_qualidade_como_medir" class="objetivo_qualidade_como_medir"><?= $Page->renderFieldHeader($Page->como_medir) ?></div></th>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <th data-name="o_q_sera_feito" class="<?= $Page->o_q_sera_feito->headerCellClass() ?>"><div id="elh_objetivo_qualidade_o_q_sera_feito" class="objetivo_qualidade_o_q_sera_feito"><?= $Page->renderFieldHeader($Page->o_q_sera_feito) ?></div></th>
<?php } ?>
<?php if ($Page->como_avaliar->Visible) { // como_avaliar ?>
        <th data-name="como_avaliar" class="<?= $Page->como_avaliar->headerCellClass() ?>"><div id="elh_objetivo_qualidade_como_avaliar" class="objetivo_qualidade_como_avaliar"><?= $Page->renderFieldHeader($Page->como_avaliar) ?></div></th>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <th data-name="departamentos_iddepartamentos" class="<?= $Page->departamentos_iddepartamentos->headerCellClass() ?>"><div id="elh_objetivo_qualidade_departamentos_iddepartamentos" class="objetivo_qualidade_departamentos_iddepartamentos"><?= $Page->renderFieldHeader($Page->departamentos_iddepartamentos) ?></div></th>
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
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <td data-name="processo_idprocesso"<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_objetivo_qualidade_processo_idprocesso" class="el_objetivo_qualidade_processo_idprocesso">
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->objetivo->Visible) { // objetivo ?>
        <td data-name="objetivo"<?= $Page->objetivo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_objetivo_qualidade_objetivo" class="el_objetivo_qualidade_objetivo">
<span<?= $Page->objetivo->viewAttributes() ?>>
<?= $Page->objetivo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->como_medir->Visible) { // como_medir ?>
        <td data-name="como_medir"<?= $Page->como_medir->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_objetivo_qualidade_como_medir" class="el_objetivo_qualidade_como_medir">
<span<?= $Page->como_medir->viewAttributes() ?>>
<?= $Page->como_medir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <td data-name="o_q_sera_feito"<?= $Page->o_q_sera_feito->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_objetivo_qualidade_o_q_sera_feito" class="el_objetivo_qualidade_o_q_sera_feito">
<span<?= $Page->o_q_sera_feito->viewAttributes() ?>>
<?= $Page->o_q_sera_feito->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->como_avaliar->Visible) { // como_avaliar ?>
        <td data-name="como_avaliar"<?= $Page->como_avaliar->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_objetivo_qualidade_como_avaliar" class="el_objetivo_qualidade_como_avaliar">
<span<?= $Page->como_avaliar->viewAttributes() ?>>
<?= $Page->como_avaliar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <td data-name="departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_objetivo_qualidade_departamentos_iddepartamentos" class="el_objetivo_qualidade_departamentos_iddepartamentos">
<span<?= $Page->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Page->departamentos_iddepartamentos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

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
    <?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <td data-name="processo_idprocesso" class="<?= $Page->processo_idprocesso->footerCellClass() ?>"><span id="elf_objetivo_qualidade_processo_idprocesso" class="objetivo_qualidade_processo_idprocesso">
        </span></td>
    <?php } ?>
    <?php if ($Page->objetivo->Visible) { // objetivo ?>
        <td data-name="objetivo" class="<?= $Page->objetivo->footerCellClass() ?>"><span id="elf_objetivo_qualidade_objetivo" class="objetivo_qualidade_objetivo">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->objetivo->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->como_medir->Visible) { // como_medir ?>
        <td data-name="como_medir" class="<?= $Page->como_medir->footerCellClass() ?>"><span id="elf_objetivo_qualidade_como_medir" class="objetivo_qualidade_como_medir">
        </span></td>
    <?php } ?>
    <?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <td data-name="o_q_sera_feito" class="<?= $Page->o_q_sera_feito->footerCellClass() ?>"><span id="elf_objetivo_qualidade_o_q_sera_feito" class="objetivo_qualidade_o_q_sera_feito">
        </span></td>
    <?php } ?>
    <?php if ($Page->como_avaliar->Visible) { // como_avaliar ?>
        <td data-name="como_avaliar" class="<?= $Page->como_avaliar->footerCellClass() ?>"><span id="elf_objetivo_qualidade_como_avaliar" class="objetivo_qualidade_como_avaliar">
        </span></td>
    <?php } ?>
    <?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <td data-name="departamentos_iddepartamentos" class="<?= $Page->departamentos_iddepartamentos->footerCellClass() ?>"><span id="elf_objetivo_qualidade_departamentos_iddepartamentos" class="objetivo_qualidade_departamentos_iddepartamentos">
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
    ew.addEventHandlers("objetivo_qualidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
