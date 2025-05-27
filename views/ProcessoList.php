<?php

namespace PHPMaker2024\sgq;

// Page object
$ProcessoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { processo: currentTable } });
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

        // Dynamic selection lists
        .setLists({
            "tipo_idtipo": <?= $Page->tipo_idtipo->toClientList($Page) ?>,
            "processo": <?= $Page->processo->toClientList($Page) ?>,
            "responsaveis": <?= $Page->responsaveis->toClientList($Page) ?>,
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
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fprocessosrch" id="fprocessosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fprocessosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { processo: currentTable } });
var currentForm;
var fprocessosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fprocessosrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["tipo_idtipo", [], fields.tipo_idtipo.isInvalid]
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
            "tipo_idtipo": <?= $Page->tipo_idtipo->toClientList($Page) ?>,
            "processo": <?= $Page->processo->toClientList($Page) ?>,
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
<?php if ($Page->tipo_idtipo->Visible) { // tipo_idtipo ?>
<?php
if (!$Page->tipo_idtipo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_tipo_idtipo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->tipo_idtipo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->tipo_idtipo->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_tipo_idtipo" id="z_tipo_idtipo" value="=">
</div>
        </div>
        <div id="el_processo_tipo_idtipo" class="ew-search-field">
<template id="tp_x_tipo_idtipo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="processo" data-field="x_tipo_idtipo" name="x_tipo_idtipo" id="x_tipo_idtipo"<?= $Page->tipo_idtipo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tipo_idtipo" class="ew-item-list"></div>
<selection-list hidden
    id="x_tipo_idtipo"
    name="x_tipo_idtipo"
    value="<?= HtmlEncode($Page->tipo_idtipo->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_idtipo"
    data-target="dsl_x_tipo_idtipo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo_idtipo->isInvalidClass() ?>"
    data-table="processo"
    data-field="x_tipo_idtipo"
    data-value-separator="<?= $Page->tipo_idtipo->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_idtipo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->tipo_idtipo->getErrorMessage(false) ?></div>
<?= $Page->tipo_idtipo->Lookup->getParamTag($Page, "p_x_tipo_idtipo") ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->processo->Visible) { // processo ?>
<?php
if (!$Page->processo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_processo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->processo->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_processo"
            name="x_processo[]"
            class="form-control ew-select<?= $Page->processo->isInvalidClass() ?>"
            data-select2-id="fprocessosrch_x_processo"
            data-table="processo"
            data-field="x_processo"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->processo->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->processo->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->processo->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->processo->editAttributes() ?>>
            <?= $Page->processo->selectOptionListHtml("x_processo", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->processo->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fprocessosrch", function() {
            var options = {
                name: "x_processo",
                selectId: "fprocessosrch_x_processo",
                ajax: { id: "x_processo", form: "fprocessosrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.processo.fields.processo.filterOptions);
            ew.createFilter(options);
        });
        </script>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fprocessosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fprocessosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fprocessosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fprocessosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="processo">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_processo" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_processolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th data-name="dt_cadastro" class="<?= $Page->dt_cadastro->headerCellClass() ?>"><div id="elh_processo_dt_cadastro" class="processo_dt_cadastro"><?= $Page->renderFieldHeader($Page->dt_cadastro) ?></div></th>
<?php } ?>
<?php if ($Page->revisao->Visible) { // revisao ?>
        <th data-name="revisao" class="<?= $Page->revisao->headerCellClass() ?>"><div id="elh_processo_revisao" class="processo_revisao"><?= $Page->renderFieldHeader($Page->revisao) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_idtipo->Visible) { // tipo_idtipo ?>
        <th data-name="tipo_idtipo" class="<?= $Page->tipo_idtipo->headerCellClass() ?>"><div id="elh_processo_tipo_idtipo" class="processo_tipo_idtipo"><?= $Page->renderFieldHeader($Page->tipo_idtipo) ?></div></th>
<?php } ?>
<?php if ($Page->processo->Visible) { // processo ?>
        <th data-name="processo" class="<?= $Page->processo->headerCellClass() ?>"><div id="elh_processo_processo" class="processo_processo"><?= $Page->renderFieldHeader($Page->processo) ?></div></th>
<?php } ?>
<?php if ($Page->responsaveis->Visible) { // responsaveis ?>
        <th data-name="responsaveis" class="<?= $Page->responsaveis->headerCellClass() ?>"><div id="elh_processo_responsaveis" class="processo_responsaveis"><?= $Page->renderFieldHeader($Page->responsaveis) ?></div></th>
<?php } ?>
<?php if ($Page->entradas->Visible) { // entradas ?>
        <th data-name="entradas" class="<?= $Page->entradas->headerCellClass() ?>"><div id="elh_processo_entradas" class="processo_entradas"><?= $Page->renderFieldHeader($Page->entradas) ?></div></th>
<?php } ?>
<?php if ($Page->atividade_principal->Visible) { // atividade_principal ?>
        <th data-name="atividade_principal" class="<?= $Page->atividade_principal->headerCellClass() ?>"><div id="elh_processo_atividade_principal" class="processo_atividade_principal"><?= $Page->renderFieldHeader($Page->atividade_principal) ?></div></th>
<?php } ?>
<?php if ($Page->saidas_resultados->Visible) { // saidas_resultados ?>
        <th data-name="saidas_resultados" class="<?= $Page->saidas_resultados->headerCellClass() ?>"><div id="elh_processo_saidas_resultados" class="processo_saidas_resultados"><?= $Page->renderFieldHeader($Page->saidas_resultados) ?></div></th>
<?php } ?>
<?php if ($Page->formulario->Visible) { // formulario ?>
        <th data-name="formulario" class="<?= $Page->formulario->headerCellClass() ?>"><div id="elh_processo_formulario" class="processo_formulario"><?= $Page->renderFieldHeader($Page->formulario) ?></div></th>
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
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_processo_dt_cadastro" class="el_processo_dt_cadastro">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->revisao->Visible) { // revisao ?>
        <td data-name="revisao"<?= $Page->revisao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_processo_revisao" class="el_processo_revisao">
<span<?= $Page->revisao->viewAttributes() ?>>
<?= $Page->revisao->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_idtipo->Visible) { // tipo_idtipo ?>
        <td data-name="tipo_idtipo"<?= $Page->tipo_idtipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_processo_tipo_idtipo" class="el_processo_tipo_idtipo">
<span<?= $Page->tipo_idtipo->viewAttributes() ?>>
<?= $Page->tipo_idtipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->processo->Visible) { // processo ?>
        <td data-name="processo"<?= $Page->processo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_processo_processo" class="el_processo_processo">
<span<?= $Page->processo->viewAttributes() ?>>
<?= $Page->processo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->responsaveis->Visible) { // responsaveis ?>
        <td data-name="responsaveis"<?= $Page->responsaveis->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_processo_responsaveis" class="el_processo_responsaveis">
<span<?= $Page->responsaveis->viewAttributes() ?>>
<?= $Page->responsaveis->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->entradas->Visible) { // entradas ?>
        <td data-name="entradas"<?= $Page->entradas->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_processo_entradas" class="el_processo_entradas">
<span<?= $Page->entradas->viewAttributes() ?>>
<?= $Page->entradas->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->atividade_principal->Visible) { // atividade_principal ?>
        <td data-name="atividade_principal"<?= $Page->atividade_principal->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_processo_atividade_principal" class="el_processo_atividade_principal">
<span<?= $Page->atividade_principal->viewAttributes() ?>>
<?= $Page->atividade_principal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->saidas_resultados->Visible) { // saidas_resultados ?>
        <td data-name="saidas_resultados"<?= $Page->saidas_resultados->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_processo_saidas_resultados" class="el_processo_saidas_resultados">
<span<?= $Page->saidas_resultados->viewAttributes() ?>>
<?= $Page->saidas_resultados->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->formulario->Visible) { // formulario ?>
        <td data-name="formulario"<?= $Page->formulario->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_processo_formulario" class="el_processo_formulario">
<span<?= $Page->formulario->viewAttributes() ?>>
<?= GetFileViewTag($Page->formulario, $Page->formulario->getViewValue(), false) ?>
</span>
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
    <?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td data-name="dt_cadastro" class="<?= $Page->dt_cadastro->footerCellClass() ?>"><span id="elf_processo_dt_cadastro" class="processo_dt_cadastro">
        </span></td>
    <?php } ?>
    <?php if ($Page->revisao->Visible) { // revisao ?>
        <td data-name="revisao" class="<?= $Page->revisao->footerCellClass() ?>"><span id="elf_processo_revisao" class="processo_revisao">
        </span></td>
    <?php } ?>
    <?php if ($Page->tipo_idtipo->Visible) { // tipo_idtipo ?>
        <td data-name="tipo_idtipo" class="<?= $Page->tipo_idtipo->footerCellClass() ?>"><span id="elf_processo_tipo_idtipo" class="processo_tipo_idtipo">
        </span></td>
    <?php } ?>
    <?php if ($Page->processo->Visible) { // processo ?>
        <td data-name="processo" class="<?= $Page->processo->footerCellClass() ?>"><span id="elf_processo_processo" class="processo_processo">
        </span></td>
    <?php } ?>
    <?php if ($Page->responsaveis->Visible) { // responsaveis ?>
        <td data-name="responsaveis" class="<?= $Page->responsaveis->footerCellClass() ?>"><span id="elf_processo_responsaveis" class="processo_responsaveis">
        </span></td>
    <?php } ?>
    <?php if ($Page->entradas->Visible) { // entradas ?>
        <td data-name="entradas" class="<?= $Page->entradas->footerCellClass() ?>"><span id="elf_processo_entradas" class="processo_entradas">
        </span></td>
    <?php } ?>
    <?php if ($Page->atividade_principal->Visible) { // atividade_principal ?>
        <td data-name="atividade_principal" class="<?= $Page->atividade_principal->footerCellClass() ?>"><span id="elf_processo_atividade_principal" class="processo_atividade_principal">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->atividade_principal->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->saidas_resultados->Visible) { // saidas_resultados ?>
        <td data-name="saidas_resultados" class="<?= $Page->saidas_resultados->footerCellClass() ?>"><span id="elf_processo_saidas_resultados" class="processo_saidas_resultados">
        </span></td>
    <?php } ?>
    <?php if ($Page->formulario->Visible) { // formulario ?>
        <td data-name="formulario" class="<?= $Page->formulario->footerCellClass() ?>"><span id="elf_processo_formulario" class="processo_formulario">
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
    ew.addEventHandlers("processo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
