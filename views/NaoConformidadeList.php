<?php

namespace PHPMaker2024\sgq;

// Page object
$NaoConformidadeList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { nao_conformidade: currentTable } });
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
<form name="fnao_conformidadesrch" id="fnao_conformidadesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fnao_conformidadesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { nao_conformidade: currentTable } });
var currentForm;
var fnao_conformidadesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fnao_conformidadesrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["status_nc", [], fields.status_nc.isInvalid],
            ["plano_acao", [], fields.plano_acao.isInvalid]
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
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
            "origem_risco_oportunidade_idorigem_risco_oportunidade": <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->toClientList($Page) ?>,
            "status_nc": <?= $Page->status_nc->toClientList($Page) ?>,
            "plano_acao": <?= $Page->plano_acao->toClientList($Page) ?>,
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
<?php if ($Page->tipo->Visible) { // tipo ?>
<?php
if (!$Page->tipo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_tipo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->tipo->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_tipo"
            name="x_tipo[]"
            class="form-control ew-select<?= $Page->tipo->isInvalidClass() ?>"
            data-select2-id="fnao_conformidadesrch_x_tipo"
            data-table="nao_conformidade"
            data-field="x_tipo"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->tipo->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->tipo->editAttributes() ?>>
            <?= $Page->tipo->selectOptionListHtml("x_tipo", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fnao_conformidadesrch", function() {
            var options = {
                name: "x_tipo",
                selectId: "fnao_conformidadesrch_x_tipo",
                ajax: { id: "x_tipo", form: "fnao_conformidadesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.nao_conformidade.fields.tipo.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
<?php
if (!$Page->origem_risco_oportunidade_idorigem_risco_oportunidade->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_origem_risco_oportunidade_idorigem_risco_oportunidade" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
            name="x_origem_risco_oportunidade_idorigem_risco_oportunidade[]"
            class="form-control ew-select<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->isInvalidClass() ?>"
            data-select2-id="fnao_conformidadesrch_x_origem_risco_oportunidade_idorigem_risco_oportunidade"
            data-table="nao_conformidade"
            data-field="x_origem_risco_oportunidade_idorigem_risco_oportunidade"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->editAttributes() ?>>
            <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->selectOptionListHtml("x_origem_risco_oportunidade_idorigem_risco_oportunidade", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fnao_conformidadesrch", function() {
            var options = {
                name: "x_origem_risco_oportunidade_idorigem_risco_oportunidade",
                selectId: "fnao_conformidadesrch_x_origem_risco_oportunidade_idorigem_risco_oportunidade",
                ajax: { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "fnao_conformidadesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.nao_conformidade.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->status_nc->Visible) { // status_nc ?>
<?php
if (!$Page->status_nc->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_status_nc" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->status_nc->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->status_nc->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status_nc" id="z_status_nc" value="=">
</div>
        </div>
        <div id="el_nao_conformidade_status_nc" class="ew-search-field">
<template id="tp_x_status_nc">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="nao_conformidade" data-field="x_status_nc" name="x_status_nc" id="x_status_nc"<?= $Page->status_nc->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_status_nc" class="ew-item-list"></div>
<selection-list hidden
    id="x_status_nc"
    name="x_status_nc"
    value="<?= HtmlEncode($Page->status_nc->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_status_nc"
    data-target="dsl_x_status_nc"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status_nc->isInvalidClass() ?>"
    data-table="nao_conformidade"
    data-field="x_status_nc"
    data-value-separator="<?= $Page->status_nc->displayValueSeparatorAttribute() ?>"
    <?= $Page->status_nc->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->status_nc->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->plano_acao->Visible) { // plano_acao ?>
<?php
if (!$Page->plano_acao->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_plano_acao" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->plano_acao->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->plano_acao->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_plano_acao" id="z_plano_acao" value="=">
</div>
        </div>
        <div id="el_nao_conformidade_plano_acao" class="ew-search-field">
<template id="tp_x_plano_acao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="nao_conformidade" data-field="x_plano_acao" name="x_plano_acao" id="x_plano_acao"<?= $Page->plano_acao->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_plano_acao" class="ew-item-list"></div>
<selection-list hidden
    id="x_plano_acao"
    name="x_plano_acao"
    value="<?= HtmlEncode($Page->plano_acao->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_plano_acao"
    data-target="dsl_x_plano_acao"
    data-repeatcolumn="5"
    class="form-control<?= $Page->plano_acao->isInvalidClass() ?>"
    data-table="nao_conformidade"
    data-field="x_plano_acao"
    data-value-separator="<?= $Page->plano_acao->displayValueSeparatorAttribute() ?>"
    <?= $Page->plano_acao->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->plano_acao->getErrorMessage(false) ?></div>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fnao_conformidadesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fnao_conformidadesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fnao_conformidadesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fnao_conformidadesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="nao_conformidade">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_nao_conformidade" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_nao_conformidadelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->idnao_conformidade->Visible) { // idnao_conformidade ?>
        <th data-name="idnao_conformidade" class="<?= $Page->idnao_conformidade->headerCellClass() ?>"><div id="elh_nao_conformidade_idnao_conformidade" class="nao_conformidade_idnao_conformidade"><?= $Page->renderFieldHeader($Page->idnao_conformidade) ?></div></th>
<?php } ?>
<?php if ($Page->dt_ocorrencia->Visible) { // dt_ocorrencia ?>
        <th data-name="dt_ocorrencia" class="<?= $Page->dt_ocorrencia->headerCellClass() ?>"><div id="elh_nao_conformidade_dt_ocorrencia" class="nao_conformidade_dt_ocorrencia"><?= $Page->renderFieldHeader($Page->dt_ocorrencia) ?></div></th>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
        <th data-name="titulo" class="<?= $Page->titulo->headerCellClass() ?>"><div id="elh_nao_conformidade_titulo" class="nao_conformidade_titulo"><?= $Page->renderFieldHeader($Page->titulo) ?></div></th>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <th data-name="processo_idprocesso" class="<?= $Page->processo_idprocesso->headerCellClass() ?>"><div id="elh_nao_conformidade_processo_idprocesso" class="nao_conformidade_processo_idprocesso"><?= $Page->renderFieldHeader($Page->processo_idprocesso) ?></div></th>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <th data-name="departamentos_iddepartamentos" class="<?= $Page->departamentos_iddepartamentos->headerCellClass() ?>"><div id="elh_nao_conformidade_departamentos_iddepartamentos" class="nao_conformidade_departamentos_iddepartamentos"><?= $Page->renderFieldHeader($Page->departamentos_iddepartamentos) ?></div></th>
<?php } ?>
<?php if ($Page->status_nc->Visible) { // status_nc ?>
        <th data-name="status_nc" class="<?= $Page->status_nc->headerCellClass() ?>"><div id="elh_nao_conformidade_status_nc" class="nao_conformidade_status_nc"><?= $Page->renderFieldHeader($Page->status_nc) ?></div></th>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { // plano_acao ?>
        <th data-name="plano_acao" class="<?= $Page->plano_acao->headerCellClass() ?>"><div id="elh_nao_conformidade_plano_acao" class="nao_conformidade_plano_acao"><?= $Page->renderFieldHeader($Page->plano_acao) ?></div></th>
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
    <?php if ($Page->idnao_conformidade->Visible) { // idnao_conformidade ?>
        <td data-name="idnao_conformidade"<?= $Page->idnao_conformidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_nao_conformidade_idnao_conformidade" class="el_nao_conformidade_idnao_conformidade">
<span<?= $Page->idnao_conformidade->viewAttributes() ?>>
<?= $Page->idnao_conformidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dt_ocorrencia->Visible) { // dt_ocorrencia ?>
        <td data-name="dt_ocorrencia"<?= $Page->dt_ocorrencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_nao_conformidade_dt_ocorrencia" class="el_nao_conformidade_dt_ocorrencia">
<span<?= $Page->dt_ocorrencia->viewAttributes() ?>>
<?= $Page->dt_ocorrencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->titulo->Visible) { // titulo ?>
        <td data-name="titulo"<?= $Page->titulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_nao_conformidade_titulo" class="el_nao_conformidade_titulo">
<span<?= $Page->titulo->viewAttributes() ?>>
<?= $Page->titulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <td data-name="processo_idprocesso"<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_nao_conformidade_processo_idprocesso" class="el_nao_conformidade_processo_idprocesso">
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <td data-name="departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_nao_conformidade_departamentos_iddepartamentos" class="el_nao_conformidade_departamentos_iddepartamentos">
<span<?= $Page->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Page->departamentos_iddepartamentos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_nc->Visible) { // status_nc ?>
        <td data-name="status_nc"<?= $Page->status_nc->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_nao_conformidade_status_nc" class="el_nao_conformidade_status_nc">
<span<?= $Page->status_nc->viewAttributes() ?>>
<?= $Page->status_nc->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->plano_acao->Visible) { // plano_acao ?>
        <td data-name="plano_acao"<?= $Page->plano_acao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_nao_conformidade_plano_acao" class="el_nao_conformidade_plano_acao">
<span<?= $Page->plano_acao->viewAttributes() ?>>
<?= $Page->plano_acao->getViewValue() ?></span>
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
    ew.addEventHandlers("nao_conformidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
