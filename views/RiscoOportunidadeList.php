<?php

namespace PHPMaker2024\sgq;

// Page object
$RiscoOportunidadeList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { risco_oportunidade: currentTable } });
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
            "tipo_risco_oportunidade_idtipo_risco_oportunidade": <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->toClientList($Page) ?>,
            "origem_risco_oportunidade_idorigem_risco_oportunidade": <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->toClientList($Page) ?>,
            "frequencia_idfrequencia": <?= $Page->frequencia_idfrequencia->toClientList($Page) ?>,
            "impacto_idimpacto": <?= $Page->impacto_idimpacto->toClientList($Page) ?>,
            "grau_atencao": <?= $Page->grau_atencao->toClientList($Page) ?>,
            "acao_risco_oportunidade_idacao_risco_oportunidade": <?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->toClientList($Page) ?>,
            "plano_acao": <?= $Page->plano_acao->toClientList($Page) ?>,
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
<form name="frisco_oportunidadesrch" id="frisco_oportunidadesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frisco_oportunidadesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { risco_oportunidade: currentTable } });
var currentForm;
var frisco_oportunidadesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frisco_oportunidadesrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["tipo_risco_oportunidade_idtipo_risco_oportunidade", [], fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.isInvalid],
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
            "tipo_risco_oportunidade_idtipo_risco_oportunidade": <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->toClientList($Page) ?>,
            "origem_risco_oportunidade_idorigem_risco_oportunidade": <?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->toClientList($Page) ?>,
            "frequencia_idfrequencia": <?= $Page->frequencia_idfrequencia->toClientList($Page) ?>,
            "impacto_idimpacto": <?= $Page->impacto_idimpacto->toClientList($Page) ?>,
            "grau_atencao": <?= $Page->grau_atencao->toClientList($Page) ?>,
            "acao_risco_oportunidade_idacao_risco_oportunidade": <?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->toClientList($Page) ?>,
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
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
<?php
if (!$Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_tipo_risco_oportunidade_idtipo_risco_oportunidade" id="z_tipo_risco_oportunidade_idtipo_risco_oportunidade" value="=">
</div>
        </div>
        <div id="el_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="ew-search-field">
<template id="tp_x_tipo_risco_oportunidade_idtipo_risco_oportunidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="risco_oportunidade" data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" name="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" id="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="ew-item-list"></div>
<selection-list hidden
    id="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    name="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    value="<?= HtmlEncode($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-target="dsl_x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->isInvalidClass() ?>"
    data-table="risco_oportunidade"
    data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-value-separator="<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getErrorMessage(false) ?></div>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getParamTag($Page, "p_x_tipo_risco_oportunidade_idtipo_risco_oportunidade") ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
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
            data-select2-id="frisco_oportunidadesrch_x_origem_risco_oportunidade_idorigem_risco_oportunidade"
            data-table="risco_oportunidade"
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
        loadjs.ready("frisco_oportunidadesrch", function() {
            var options = {
                name: "x_origem_risco_oportunidade_idorigem_risco_oportunidade",
                selectId: "frisco_oportunidadesrch_x_origem_risco_oportunidade_idorigem_risco_oportunidade",
                ajax: { id: "x_origem_risco_oportunidade_idorigem_risco_oportunidade", form: "frisco_oportunidadesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.risco_oportunidade.fields.origem_risco_oportunidade_idorigem_risco_oportunidade.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->frequencia_idfrequencia->Visible) { // frequencia_idfrequencia ?>
<?php
if (!$Page->frequencia_idfrequencia->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_frequencia_idfrequencia" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->frequencia_idfrequencia->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_frequencia_idfrequencia"
            name="x_frequencia_idfrequencia[]"
            class="form-control ew-select<?= $Page->frequencia_idfrequencia->isInvalidClass() ?>"
            data-select2-id="frisco_oportunidadesrch_x_frequencia_idfrequencia"
            data-table="risco_oportunidade"
            data-field="x_frequencia_idfrequencia"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->frequencia_idfrequencia->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->frequencia_idfrequencia->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->frequencia_idfrequencia->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->frequencia_idfrequencia->editAttributes() ?>>
            <?= $Page->frequencia_idfrequencia->selectOptionListHtml("x_frequencia_idfrequencia", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->frequencia_idfrequencia->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("frisco_oportunidadesrch", function() {
            var options = {
                name: "x_frequencia_idfrequencia",
                selectId: "frisco_oportunidadesrch_x_frequencia_idfrequencia",
                ajax: { id: "x_frequencia_idfrequencia", form: "frisco_oportunidadesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.risco_oportunidade.fields.frequencia_idfrequencia.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
<?php
if (!$Page->impacto_idimpacto->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_impacto_idimpacto" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->impacto_idimpacto->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_impacto_idimpacto"
            name="x_impacto_idimpacto[]"
            class="form-control ew-select<?= $Page->impacto_idimpacto->isInvalidClass() ?>"
            data-select2-id="frisco_oportunidadesrch_x_impacto_idimpacto"
            data-table="risco_oportunidade"
            data-field="x_impacto_idimpacto"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->impacto_idimpacto->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->impacto_idimpacto->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->impacto_idimpacto->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->impacto_idimpacto->editAttributes() ?>>
            <?= $Page->impacto_idimpacto->selectOptionListHtml("x_impacto_idimpacto", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->impacto_idimpacto->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("frisco_oportunidadesrch", function() {
            var options = {
                name: "x_impacto_idimpacto",
                selectId: "frisco_oportunidadesrch_x_impacto_idimpacto",
                ajax: { id: "x_impacto_idimpacto", form: "frisco_oportunidadesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.risco_oportunidade.fields.impacto_idimpacto.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->grau_atencao->Visible) { // grau_atencao ?>
<?php
if (!$Page->grau_atencao->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_grau_atencao" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->grau_atencao->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_grau_atencao"
            name="x_grau_atencao[]"
            class="form-control ew-select<?= $Page->grau_atencao->isInvalidClass() ?>"
            data-select2-id="frisco_oportunidadesrch_x_grau_atencao"
            data-table="risco_oportunidade"
            data-field="x_grau_atencao"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->grau_atencao->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->grau_atencao->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->grau_atencao->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->grau_atencao->editAttributes() ?>>
            <?= $Page->grau_atencao->selectOptionListHtml("x_grau_atencao", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->grau_atencao->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("frisco_oportunidadesrch", function() {
            var options = {
                name: "x_grau_atencao",
                selectId: "frisco_oportunidadesrch_x_grau_atencao",
                ajax: { id: "x_grau_atencao", form: "frisco_oportunidadesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.risco_oportunidade.fields.grau_atencao.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->acao_risco_oportunidade_idacao_risco_oportunidade->Visible) { // acao_risco_oportunidade_idacao_risco_oportunidade ?>
<?php
if (!$Page->acao_risco_oportunidade_idacao_risco_oportunidade->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_acao_risco_oportunidade_idacao_risco_oportunidade" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_acao_risco_oportunidade_idacao_risco_oportunidade"
            name="x_acao_risco_oportunidade_idacao_risco_oportunidade[]"
            class="form-control ew-select<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->isInvalidClass() ?>"
            data-select2-id="frisco_oportunidadesrch_x_acao_risco_oportunidade_idacao_risco_oportunidade"
            data-table="risco_oportunidade"
            data-field="x_acao_risco_oportunidade_idacao_risco_oportunidade"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->acao_risco_oportunidade_idacao_risco_oportunidade->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->acao_risco_oportunidade_idacao_risco_oportunidade->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->editAttributes() ?>>
            <?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->selectOptionListHtml("x_acao_risco_oportunidade_idacao_risco_oportunidade", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("frisco_oportunidadesrch", function() {
            var options = {
                name: "x_acao_risco_oportunidade_idacao_risco_oportunidade",
                selectId: "frisco_oportunidadesrch_x_acao_risco_oportunidade_idacao_risco_oportunidade",
                ajax: { id: "x_acao_risco_oportunidade_idacao_risco_oportunidade", form: "frisco_oportunidadesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.risco_oportunidade.fields.acao_risco_oportunidade_idacao_risco_oportunidade.filterOptions);
            ew.createFilter(options);
        });
        </script>
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
        <div id="el_risco_oportunidade_plano_acao" class="ew-search-field">
<template id="tp_x_plano_acao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="risco_oportunidade" data-field="x_plano_acao" name="x_plano_acao" id="x_plano_acao"<?= $Page->plano_acao->editAttributes() ?>>
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
    data-table="risco_oportunidade"
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="frisco_oportunidadesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="frisco_oportunidadesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="frisco_oportunidadesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="frisco_oportunidadesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="risco_oportunidade">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_risco_oportunidade" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_risco_oportunidadelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->idrisco_oportunidade->Visible) { // idrisco_oportunidade ?>
        <th data-name="idrisco_oportunidade" class="<?= $Page->idrisco_oportunidade->headerCellClass() ?>"><div id="elh_risco_oportunidade_idrisco_oportunidade" class="risco_oportunidade_idrisco_oportunidade"><?= $Page->renderFieldHeader($Page->idrisco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
        <th data-name="tipo_risco_oportunidade_idtipo_risco_oportunidade" class="<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->headerCellClass() ?>"><div id="elh_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade"><?= $Page->renderFieldHeader($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
        <th data-name="titulo" class="<?= $Page->titulo->headerCellClass() ?>"><div id="elh_risco_oportunidade_titulo" class="risco_oportunidade_titulo"><?= $Page->renderFieldHeader($Page->titulo) ?></div></th>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <th data-name="origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->headerCellClass() ?>"><div id="elh_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade" class="risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->renderFieldHeader($Page->origem_risco_oportunidade_idorigem_risco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Page->frequencia_idfrequencia->Visible) { // frequencia_idfrequencia ?>
        <th data-name="frequencia_idfrequencia" class="<?= $Page->frequencia_idfrequencia->headerCellClass() ?>"><div id="elh_risco_oportunidade_frequencia_idfrequencia" class="risco_oportunidade_frequencia_idfrequencia"><?= $Page->renderFieldHeader($Page->frequencia_idfrequencia) ?></div></th>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <th data-name="impacto_idimpacto" class="<?= $Page->impacto_idimpacto->headerCellClass() ?>"><div id="elh_risco_oportunidade_impacto_idimpacto" class="risco_oportunidade_impacto_idimpacto"><?= $Page->renderFieldHeader($Page->impacto_idimpacto) ?></div></th>
<?php } ?>
<?php if ($Page->grau_atencao->Visible) { // grau_atencao ?>
        <th data-name="grau_atencao" class="<?= $Page->grau_atencao->headerCellClass() ?>"><div id="elh_risco_oportunidade_grau_atencao" class="risco_oportunidade_grau_atencao"><?= $Page->renderFieldHeader($Page->grau_atencao) ?></div></th>
<?php } ?>
<?php if ($Page->acao_risco_oportunidade_idacao_risco_oportunidade->Visible) { // acao_risco_oportunidade_idacao_risco_oportunidade ?>
        <th data-name="acao_risco_oportunidade_idacao_risco_oportunidade" class="<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->headerCellClass() ?>"><div id="elh_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade" class="risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade"><?= $Page->renderFieldHeader($Page->acao_risco_oportunidade_idacao_risco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { // plano_acao ?>
        <th data-name="plano_acao" class="<?= $Page->plano_acao->headerCellClass() ?>"><div id="elh_risco_oportunidade_plano_acao" class="risco_oportunidade_plano_acao"><?= $Page->renderFieldHeader($Page->plano_acao) ?></div></th>
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
    <?php if ($Page->idrisco_oportunidade->Visible) { // idrisco_oportunidade ?>
        <td data-name="idrisco_oportunidade"<?= $Page->idrisco_oportunidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_risco_oportunidade_idrisco_oportunidade" class="el_risco_oportunidade_idrisco_oportunidade">
<span<?= $Page->idrisco_oportunidade->viewAttributes() ?>>
<?= $Page->idrisco_oportunidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
        <td data-name="tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="el_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade">
<span<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->viewAttributes() ?>>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->titulo->Visible) { // titulo ?>
        <td data-name="titulo"<?= $Page->titulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_risco_oportunidade_titulo" class="el_risco_oportunidade_titulo">
<span<?= $Page->titulo->viewAttributes() ?>>
<?= $Page->titulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <td data-name="origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade" class="el_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade">
<span<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->frequencia_idfrequencia->Visible) { // frequencia_idfrequencia ?>
        <td data-name="frequencia_idfrequencia"<?= $Page->frequencia_idfrequencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_risco_oportunidade_frequencia_idfrequencia" class="el_risco_oportunidade_frequencia_idfrequencia">
<span<?= $Page->frequencia_idfrequencia->viewAttributes() ?>>
<?= $Page->frequencia_idfrequencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <td data-name="impacto_idimpacto"<?= $Page->impacto_idimpacto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_risco_oportunidade_impacto_idimpacto" class="el_risco_oportunidade_impacto_idimpacto">
<span<?= $Page->impacto_idimpacto->viewAttributes() ?>>
<?= $Page->impacto_idimpacto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->grau_atencao->Visible) { // grau_atencao ?>
        <td data-name="grau_atencao"<?= $Page->grau_atencao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_risco_oportunidade_grau_atencao" class="el_risco_oportunidade_grau_atencao">
<span<?= $Page->grau_atencao->viewAttributes() ?>>
<?= $Page->grau_atencao->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->acao_risco_oportunidade_idacao_risco_oportunidade->Visible) { // acao_risco_oportunidade_idacao_risco_oportunidade ?>
        <td data-name="acao_risco_oportunidade_idacao_risco_oportunidade"<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade" class="el_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade">
<span<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->viewAttributes() ?>>
<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->plano_acao->Visible) { // plano_acao ?>
        <td data-name="plano_acao"<?= $Page->plano_acao->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_risco_oportunidade_plano_acao" class="el_risco_oportunidade_plano_acao">
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
    $Page->Severidade->DrillDownInPanel = $Page->DrillDownInPanel;
    echo $Page->Severidade->render("ew-chart-bottom");
}
?>
<?php
if (!$DashboardReport) {
    // Set up chart drilldown
    $Page->GrauAtencao->DrillDownInPanel = $Page->DrillDownInPanel;
    echo $Page->GrauAtencao->render("ew-chart-bottom");
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
    ew.addEventHandlers("risco_oportunidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
