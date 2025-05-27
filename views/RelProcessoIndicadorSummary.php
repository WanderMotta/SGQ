<?php

namespace PHPMaker2024\sgq;

// Page object
$RelProcessoIndicadorSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_processo_indicador: currentTable } });
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
<div id="gmp_rel_processo_indicador" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->processo->Visible) { ?>
    <?php if ($Page->processo->ShowGroupHeaderAsRow) { ?>
    <th data-name="processo"<?= $Page->processo->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->processo->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="processo" class="<?= $Page->processo->headerCellClass() ?>"><div class="rel_processo_indicador_processo"><?= $Page->renderFieldHeader($Page->processo) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->indicador->Visible) { ?>
    <th data-name="indicador" class="<?= $Page->indicador->headerCellClass() ?>"><div class="rel_processo_indicador_indicador"><?= $Page->renderFieldHeader($Page->indicador) ?></div></th>
<?php } ?>
<?php if ($Page->periodicidade->Visible) { ?>
    <th data-name="periodicidade" class="<?= $Page->periodicidade->headerCellClass() ?>"><div class="rel_processo_indicador_periodicidade"><?= $Page->renderFieldHeader($Page->periodicidade) ?></div></th>
<?php } ?>
<?php if ($Page->unidade->Visible) { ?>
    <th data-name="unidade" class="<?= $Page->unidade->headerCellClass() ?>"><div class="rel_processo_indicador_unidade"><?= $Page->renderFieldHeader($Page->unidade) ?></div></th>
<?php } ?>
<?php if ($Page->meta->Visible) { ?>
    <th data-name="meta" class="<?= $Page->meta->headerCellClass() ?>"><div class="rel_processo_indicador_meta"><?= $Page->renderFieldHeader($Page->meta) ?></div></th>
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
    $where = DetailFilterSql($Page->processo, $Page->getSqlFirstGroupField(), $Page->processo->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);
    $Page->setGroupCount($Page->DetailRecordCount, $Page->GroupCount);

    // Load detail records
    $Page->processo->Records = &$Page->DetailRecords;
    $Page->processo->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->processo->getCnt($Page->processo->Records); // Get record count
        $Page->setGroupCount($Page->processo->Count, $Page->GroupCounter[1]);
?>
<?php if ($Page->processo->Visible && $Page->processo->ShowGroupHeaderAsRow) { ?>
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
<?php if ($Page->processo->Visible) { ?>
        <td data-field="processo"<?= $Page->processo->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->processo->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="processo" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->processo->cellAttributes() ?>>
            <span class="ew-summary-caption rel_processo_indicador_processo"><?= $Page->renderFieldHeader($Page->processo) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->processo->viewAttributes() ?>><?= $Page->processo->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->processo->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->processo->Records as $record) {
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
<?php if ($Page->processo->Visible) { ?>
    <?php if ($Page->processo->ShowGroupHeaderAsRow) { ?>
        <td data-field="processo"<?= $Page->processo->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="processo"<?= $Page->processo->cellAttributes() ?>><span<?= $Page->processo->viewAttributes() ?>><?= $Page->processo->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->indicador->Visible) { ?>
        <td data-field="indicador"<?= $Page->indicador->cellAttributes() ?>>
<span<?= $Page->indicador->viewAttributes() ?>>
<?= $Page->indicador->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->periodicidade->Visible) { ?>
        <td data-field="periodicidade"<?= $Page->periodicidade->cellAttributes() ?>>
<span<?= $Page->periodicidade->viewAttributes() ?>>
<?= $Page->periodicidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->unidade->Visible) { ?>
        <td data-field="unidade"<?= $Page->unidade->cellAttributes() ?>>
<span<?= $Page->unidade->viewAttributes() ?>>
<?= $Page->unidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->meta->Visible) { ?>
        <td data-field="meta"<?= $Page->meta->cellAttributes() ?>>
<span<?= $Page->meta->viewAttributes() ?>>
<?= $Page->meta->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
    }
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
<?php if ($Page->processo->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
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
