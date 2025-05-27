<?php

namespace PHPMaker2023\sgq;

// Page object
$RelSemPlAcaoRiscoOpSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_sem_pl_acao_risco_op: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<a id="top"></a>
<!-- Content Container -->
<div id="ew-report" class="ew-report container-fluid">
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$Page->DrillDownInPanel) {
    $Page->ExportOptions->render("body");
    $Page->SearchOptions->render("body");
    $Page->FilterOptions->render("body");
}
?>
</div>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<form name="frel_sem_pl_acao_risco_opsrch" id="frel_sem_pl_acao_risco_opsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="on">
<div id="frel_sem_pl_acao_risco_opsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_sem_pl_acao_risco_op: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_sem_pl_acao_risco_opsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_sem_pl_acao_risco_opsrch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idrisco_oportunidade", [], fields.idrisco_oportunidade.isInvalid],
            ["dt_cadastro", [], fields.dt_cadastro.isInvalid],
            ["tipo_risco_oportunidade_idtipo_risco_oportunidade", [], fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.isInvalid],
            ["titulo", [], fields.titulo.isInvalid],
            ["origem_risco_oportunidade_idorigem_risco_oportunidade", [], fields.origem_risco_oportunidade_idorigem_risco_oportunidade.isInvalid],
            ["frequencia_idfrequencia", [], fields.frequencia_idfrequencia.isInvalid],
            ["y_frequencia_idfrequencia", [ew.Validators.between], false],
            ["impacto_idimpacto", [], fields.impacto_idimpacto.isInvalid],
            ["y_impacto_idimpacto", [ew.Validators.between], false],
            ["grau_atencao", [], fields.grau_atencao.isInvalid],
            ["y_grau_atencao", [ew.Validators.between], false],
            ["acao_risco_oportunidade_idacao_risco_oportunidade", [], fields.acao_risco_oportunidade_idacao_risco_oportunidade.isInvalid],
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
            "titulo": <?= $Page->titulo->toClientList($Page) ?>,
            "plano_acao": <?= $Page->plano_acao->toClientList($Page) ?>,
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
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
$Page->RowType = ROWTYPE_SEARCH;
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
        </div>
        <div id="el_rel_sem_pl_acao_risco_op_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="ew-search-field">
<template id="tp_x_tipo_risco_oportunidade_idtipo_risco_oportunidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="rel_sem_pl_acao_risco_op" data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" name="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" id="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>>
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
    data-table="rel_sem_pl_acao_risco_op"
    data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-value-separator="<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->displayValueSeparatorAttribute() ?>"
    data-ew-action="update-options"
    <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getErrorMessage() ?></div>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getParamTag($Page, "p_x_tipo_risco_oportunidade_idtipo_risco_oportunidade") ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
<?php
if (!$Page->titulo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_titulo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->titulo->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_titulo"
            name="x_titulo[]"
            class="form-control ew-select<?= $Page->titulo->isInvalidClass() ?>"
            data-select2-id="frel_sem_pl_acao_risco_opsrch_x_titulo"
            data-table="rel_sem_pl_acao_risco_op"
            data-field="x_titulo"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->titulo->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->titulo->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>"
            data-ew-action="update-options"
            <?= $Page->titulo->editAttributes() ?>>
            <?= $Page->titulo->selectOptionListHtml("x_titulo", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->titulo->getErrorMessage() ?></div>
        <script>
        loadjs.ready("frel_sem_pl_acao_risco_opsrch", function() {
            var options = {
                name: "x_titulo",
                selectId: "frel_sem_pl_acao_risco_opsrch_x_titulo",
                ajax: { id: "x_titulo", form: "frel_sem_pl_acao_risco_opsrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_sem_pl_acao_risco_op.fields.titulo.filterOptions);
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
        </div>
        <div id="el_rel_sem_pl_acao_risco_op_plano_acao" class="ew-search-field">
<template id="tp_x_plano_acao">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="rel_sem_pl_acao_risco_op" data-field="x_plano_acao" name="x_plano_acao" id="x_plano_acao"<?= $Page->plano_acao->editAttributes() ?>>
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
    data-table="rel_sem_pl_acao_risco_op"
    data-field="x_plano_acao"
    data-value-separator="<?= $Page->plano_acao->displayValueSeparatorAttribute() ?>"
    <?= $Page->plano_acao->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->plano_acao->getErrorMessage() ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
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
<?php if ($Page->ShowReport) { ?>
<!-- Summary report (begin) -->
<main class="report-summary<?= ($Page->TotalGroups == 0) ? " ew-no-record" : "" ?>">
<?php
while ($Page->RecordCount < count($Page->DetailRecords) && $Page->RecordCount < $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<div class="<?= $Page->ReportContainerClass ?>">
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<!-- Top pager -->
<div class="card-header ew-grid-upper-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_rel_sem_pl_acao_risco_op" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->idrisco_oportunidade->Visible) { ?>
    <th data-name="idrisco_oportunidade" class="<?= $Page->idrisco_oportunidade->headerCellClass() ?>"><div class="rel_sem_pl_acao_risco_op_idrisco_oportunidade"><?= $Page->renderFieldHeader($Page->idrisco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
    <th data-name="dt_cadastro" class="<?= $Page->dt_cadastro->headerCellClass() ?>"><div class="rel_sem_pl_acao_risco_op_dt_cadastro"><?= $Page->renderFieldHeader($Page->dt_cadastro) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { ?>
    <th data-name="tipo_risco_oportunidade_idtipo_risco_oportunidade" class="<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->headerCellClass() ?>"><div class="rel_sem_pl_acao_risco_op_tipo_risco_oportunidade_idtipo_risco_oportunidade"><?= $Page->renderFieldHeader($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Page->titulo->Visible) { ?>
    <th data-name="titulo" class="<?= $Page->titulo->headerCellClass() ?>"><div class="rel_sem_pl_acao_risco_op_titulo"><?= $Page->renderFieldHeader($Page->titulo) ?></div></th>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { ?>
    <th data-name="origem_risco_oportunidade_idorigem_risco_oportunidade" class="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->headerCellClass() ?>"><div class="rel_sem_pl_acao_risco_op_origem_risco_oportunidade_idorigem_risco_oportunidade"><?= $Page->renderFieldHeader($Page->origem_risco_oportunidade_idorigem_risco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Page->frequencia_idfrequencia->Visible) { ?>
    <th data-name="frequencia_idfrequencia" class="<?= $Page->frequencia_idfrequencia->headerCellClass() ?>"><div class="rel_sem_pl_acao_risco_op_frequencia_idfrequencia"><?= $Page->renderFieldHeader($Page->frequencia_idfrequencia) ?></div></th>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { ?>
    <th data-name="impacto_idimpacto" class="<?= $Page->impacto_idimpacto->headerCellClass() ?>"><div class="rel_sem_pl_acao_risco_op_impacto_idimpacto"><?= $Page->renderFieldHeader($Page->impacto_idimpacto) ?></div></th>
<?php } ?>
<?php if ($Page->grau_atencao->Visible) { ?>
    <th data-name="grau_atencao" class="<?= $Page->grau_atencao->headerCellClass() ?>"><div class="rel_sem_pl_acao_risco_op_grau_atencao"><?= $Page->renderFieldHeader($Page->grau_atencao) ?></div></th>
<?php } ?>
<?php if ($Page->acao_risco_oportunidade_idacao_risco_oportunidade->Visible) { ?>
    <th data-name="acao_risco_oportunidade_idacao_risco_oportunidade" class="<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->headerCellClass() ?>"><div class="rel_sem_pl_acao_risco_op_acao_risco_oportunidade_idacao_risco_oportunidade"><?= $Page->renderFieldHeader($Page->acao_risco_oportunidade_idacao_risco_oportunidade) ?></div></th>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { ?>
    <th data-name="plano_acao" class="<?= $Page->plano_acao->headerCellClass() ?>"><div class="rel_sem_pl_acao_risco_op_plano_acao"><?= $Page->renderFieldHeader($Page->plano_acao) ?></div></th>
<?php } ?>
    </tr>
</thead>
<tbody>
<?php
        if ($Page->TotalGroups == 0) {
            break; // Show header only
        }
        $Page->ShowHeader = false;
    } // End show header
?>
<?php
    $Page->loadRowValues($Page->DetailRecords[$Page->RecordCount]);
    $Page->RecordCount++;
    $Page->RecordIndex++;
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idrisco_oportunidade->Visible) { ?>
        <td data-field="idrisco_oportunidade"<?= $Page->idrisco_oportunidade->cellAttributes() ?>>
<span<?= $Page->idrisco_oportunidade->viewAttributes() ?>>
<?= $Page->idrisco_oportunidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { ?>
        <td data-field="dt_cadastro"<?= $Page->dt_cadastro->cellAttributes() ?>>
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { ?>
        <td data-field="tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
<span<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->viewAttributes() ?>>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->titulo->Visible) { ?>
        <td data-field="titulo"<?= $Page->titulo->cellAttributes() ?>>
<span<?= $Page->titulo->viewAttributes() ?>>
<?= $Page->titulo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { ?>
        <td data-field="origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->frequencia_idfrequencia->Visible) { ?>
        <td data-field="frequencia_idfrequencia"<?= $Page->frequencia_idfrequencia->cellAttributes() ?>>
<span<?= $Page->frequencia_idfrequencia->viewAttributes() ?>>
<?= $Page->frequencia_idfrequencia->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { ?>
        <td data-field="impacto_idimpacto"<?= $Page->impacto_idimpacto->cellAttributes() ?>>
<span<?= $Page->impacto_idimpacto->viewAttributes() ?>>
<?= $Page->impacto_idimpacto->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->grau_atencao->Visible) { ?>
        <td data-field="grau_atencao"<?= $Page->grau_atencao->cellAttributes() ?>>
<span<?= $Page->grau_atencao->viewAttributes() ?>>
<?= $Page->grau_atencao->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->acao_risco_oportunidade_idacao_risco_oportunidade->Visible) { ?>
        <td data-field="acao_risco_oportunidade_idacao_risco_oportunidade"<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->cellAttributes() ?>>
<span<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->viewAttributes() ?>>
<?= $Page->acao_risco_oportunidade_idacao_risco_oportunidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { ?>
        <td data-field="plano_acao"<?= $Page->plano_acao->cellAttributes() ?>>
<span<?= $Page->plano_acao->viewAttributes() ?>>
<?= $Page->plano_acao->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
<?php
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_TOTAL;
    $Page->RowTotalType = ROWTOTAL_GRAND;
    $Page->RowTotalSubType = ROWTOTAL_FOOTER;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
<?php if ($Page->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
<?php } ?>
</tfoot>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if ($Page->TotalGroups > 0) { ?>
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?php } ?>
</main>
<!-- /.report-summary -->
<!-- Summary report (end) -->
<?php } ?>
</div>
<!-- /.ew-report -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
