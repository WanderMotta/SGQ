<?php

namespace PHPMaker2024\sgq;

// Page object
$RelAnaliseSwotSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_analise_swot: currentTable } });
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
<form name="frel_analise_swotsrch" id="frel_analise_swotsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_analise_swotsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_analise_swot: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_analise_swotsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_analise_swotsrch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["contexto_idcontexto", [], fields.contexto_idcontexto.isInvalid]
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
            "contexto_idcontexto": <?= $Page->contexto_idcontexto->toClientList($Page) ?>,
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
$Page->RowType = RowType::SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->contexto_idcontexto->Visible) { // contexto_idcontexto ?>
<?php
if (!$Page->contexto_idcontexto->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_contexto_idcontexto" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->contexto_idcontexto->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->contexto_idcontexto->caption() ?></label>
        </div>
        <div id="el_rel_analise_swot_contexto_idcontexto" class="ew-search-field">
<template id="tp_x_contexto_idcontexto">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="rel_analise_swot" data-field="x_contexto_idcontexto" name="x_contexto_idcontexto" id="x_contexto_idcontexto"<?= $Page->contexto_idcontexto->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_contexto_idcontexto" class="ew-item-list"></div>
<selection-list hidden
    id="x_contexto_idcontexto"
    name="x_contexto_idcontexto"
    value="<?= HtmlEncode($Page->contexto_idcontexto->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_contexto_idcontexto"
    data-target="dsl_x_contexto_idcontexto"
    data-repeatcolumn="5"
    class="form-control<?= $Page->contexto_idcontexto->isInvalidClass() ?>"
    data-table="rel_analise_swot"
    data-field="x_contexto_idcontexto"
    data-value-separator="<?= $Page->contexto_idcontexto->displayValueSeparatorAttribute() ?>"
    <?= $Page->contexto_idcontexto->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->contexto_idcontexto->getErrorMessage() ?></div>
<?= $Page->contexto_idcontexto->Lookup->getParamTag($Page, "p_x_contexto_idcontexto") ?>
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
<?php if (!$Page->isExport("pdf")) { ?>
<main class="report-summary<?= ($Page->TotalGroups == 0) ? " ew-no-record" : "" ?>">
<?php } ?>
<?php
while ($Page->GroupCount <= count($Page->GroupRecords) && $Page->GroupCount <= $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<?php if ($Page->GroupCount > 1) { ?>
</tbody>
</table>
<?php if (!$Page->isExport("pdf")) { ?>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php } ?>
<?php if ($Page->TotalGroups > 0) { ?>
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<?php } ?>
<?php if (!$Page->isExport("pdf")) { ?>
</div>
<!-- /.ew-grid -->
<?php } ?>
<?= $Page->PageBreakHtml ?>
<?php } ?>
<?php if (!$Page->isExport("pdf")) { ?>
<div class="<?= $Page->ReportContainerClass ?>">
<?php } ?>
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Top pager -->
<div class="card-header ew-grid-upper-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<?php if (!$Page->isExport("pdf")) { ?>
<!-- Report grid (begin) -->
<div id="gmp_rel_analise_swot" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->fatores->Visible) { ?>
    <?php if ($Page->fatores->ShowGroupHeaderAsRow) { ?>
    <th data-name="fatores"<?= $Page->fatores->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->fatores->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="fatores" class="<?= $Page->fatores->headerCellClass() ?>"><div class="rel_analise_swot_fatores"><?= $Page->renderFieldHeader($Page->fatores) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ponto->Visible) { ?>
    <?php if ($Page->ponto->ShowGroupHeaderAsRow) { ?>
    <th data-name="ponto">&nbsp;</th>
    <?php } else { ?>
    <th data-name="ponto" class="<?= $Page->ponto->headerCellClass() ?>"><div class="rel_analise_swot_ponto"><?= $Page->renderFieldHeader($Page->ponto) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->analise->Visible) { ?>
    <th data-name="analise" class="<?= $Page->analise->headerCellClass() ?>"><div class="rel_analise_swot_analise"><?= $Page->renderFieldHeader($Page->analise) ?></div></th>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { ?>
    <th data-name="impacto_idimpacto" class="<?= $Page->impacto_idimpacto->headerCellClass() ?>"><div class="rel_analise_swot_impacto_idimpacto"><?= $Page->renderFieldHeader($Page->impacto_idimpacto) ?></div></th>
<?php } ?>
<?php if ($Page->contexto_idcontexto->Visible) { ?>
    <th data-name="contexto_idcontexto" class="<?= $Page->contexto_idcontexto->headerCellClass() ?>"><div class="rel_analise_swot_contexto_idcontexto"><?= $Page->renderFieldHeader($Page->contexto_idcontexto) ?></div></th>
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

    // Build detail SQL
    $where = DetailFilterSql($Page->fatores, $Page->getSqlFirstGroupField(), $Page->fatores->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->fatores->Records = &$Page->DetailRecords;
    $Page->fatores->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->fatores->getCnt($Page->fatores->Records); // Get record count
?>
<?php if ($Page->fatores->Visible && $Page->fatores->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 1;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->fatores->Visible) { ?>
        <td data-field="fatores"<?= $Page->fatores->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->fatores->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="fatores" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->fatores->cellAttributes() ?>>
            <span class="ew-summary-caption rel_analise_swot_fatores"><?= $Page->renderFieldHeader($Page->fatores) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->fatores->viewAttributes() ?>><?= $Page->fatores->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->fatores->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->ponto->getDistinctValues($Page->fatores->Records, $Page->ponto->getSort());
    $Page->setGroupCount(count($Page->ponto->DistinctValues), $Page->GroupCounter[1]);
    $Page->GroupCounter[2] = 0; // Init group count index
    foreach ($Page->ponto->DistinctValues as $ponto) { // Load records for this distinct value
        $Page->ponto->setGroupValue($ponto); // Set group value
        $Page->ponto->getDistinctRecords($Page->fatores->Records, $Page->ponto->groupValue());
        $Page->ponto->LevelBreak = true; // Set field level break
        $Page->GroupCounter[2]++;
        $Page->ponto->getCnt($Page->ponto->Records); // Get record count
        $Page->setGroupCount($Page->ponto->Count, $Page->GroupCounter[1], $Page->GroupCounter[2]);
?>
<?php if ($Page->ponto->Visible && $Page->ponto->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->ponto->setDbValue($ponto); // Set current value for ponto
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 2;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->fatores->Visible) { ?>
        <td data-field="fatores"<?= $Page->fatores->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ponto->Visible) { ?>
        <td data-field="ponto"<?= $Page->ponto->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->ponto->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="ponto" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 2) ?>"<?= $Page->ponto->cellAttributes() ?>>
            <span class="ew-summary-caption rel_analise_swot_ponto"><?= $Page->renderFieldHeader($Page->ponto) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->ponto->viewAttributes() ?>><?= $Page->ponto->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->ponto->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->ponto->Records as $record) {
            $Page->RecordCount++;
            $Page->RecordIndex++;
            $Page->loadRowValues($record);
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = RowType::DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->fatores->Visible) { ?>
    <?php if ($Page->fatores->ShowGroupHeaderAsRow) { ?>
        <td data-field="fatores"<?= $Page->fatores->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="fatores"<?= $Page->fatores->cellAttributes() ?>><span<?= $Page->fatores->viewAttributes() ?>><?= $Page->fatores->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->ponto->Visible) { ?>
    <?php if ($Page->ponto->ShowGroupHeaderAsRow) { ?>
        <td data-field="ponto"<?= $Page->ponto->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="ponto"<?= $Page->ponto->cellAttributes() ?>><span<?= $Page->ponto->viewAttributes() ?>><?= $Page->ponto->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->analise->Visible) { ?>
        <td data-field="analise"<?= $Page->analise->cellAttributes() ?>>
<span<?= $Page->analise->viewAttributes() ?>>
<?= $Page->analise->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { ?>
        <td data-field="impacto_idimpacto"<?= $Page->impacto_idimpacto->cellAttributes() ?>>
<span<?= $Page->impacto_idimpacto->viewAttributes() ?>>
<?= $Page->impacto_idimpacto->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->contexto_idcontexto->Visible) { ?>
        <td data-field="contexto_idcontexto"<?= $Page->contexto_idcontexto->cellAttributes() ?>>
<span<?= $Page->contexto_idcontexto->viewAttributes() ?>>
<?= $Page->contexto_idcontexto->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
    }
    } // End group level 1
?>
<?php

    // Next group
    $Page->loadGroupRowValues();

    // Show header if page break
    if ($Page->isExport()) {
        $Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? false : ($Page->GroupCount % $Page->ExportPageBreakCount == 0);
    }

    // Page_Breaking server event
    if ($Page->ShowHeader) {
        $Page->pageBreaking($Page->ShowHeader, $Page->PageBreakHtml);
    }
    $Page->GroupCount++;
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
<?php
    $Page->resetAttributes();
    $Page->RowType = RowType::TOTAL;
    $Page->RowTotalType = RowSummary::GRAND;
    $Page->RowTotalSubType = RowTotal::FOOTER;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
<?php if ($Page->fatores->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"></td>
<?php } ?>
<?php if ($Page->analise->Visible) { ?>
        <td data-field="analise"<?= $Page->analise->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->analise->viewAttributes() ?>><?= $Page->analise->CntViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { ?>
        <td data-field="impacto_idimpacto"<?= $Page->impacto_idimpacto->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->contexto_idcontexto->Visible) { ?>
        <td data-field="contexto_idcontexto"<?= $Page->contexto_idcontexto->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"><?= $Language->phrase("RptCnt") ?></td>
<?php } ?>
<?php if ($Page->analise->Visible) { ?>
        <td data-field="analise"<?= $Page->analise->cellAttributes() ?>>
<span<?= $Page->analise->viewAttributes() ?>>
<?= $Page->analise->CntViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { ?>
        <td data-field="impacto_idimpacto"<?= $Page->impacto_idimpacto->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->contexto_idcontexto->Visible) { ?>
        <td data-field="contexto_idcontexto"<?= $Page->contexto_idcontexto->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } ?>
</tfoot>
</table>
<?php if (!$Page->isExport("pdf")) { ?>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php } ?>
<?php if ($Page->TotalGroups > 0) { ?>
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<?php } ?>
<?php if (!$Page->isExport("pdf")) { ?>
</div>
<!-- /.ew-grid -->
<?php } ?>
<?php } ?>
<?php if (!$Page->isExport("pdf")) { ?>
</main>
<!-- /.report-summary -->
<?php } ?>
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
