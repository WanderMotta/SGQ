<?php

namespace PHPMaker2024\sgq;

// Page object
$RelViewPlanoAuditoriaSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_plano_auditoria: currentTable } });
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
<form name="frel_view_plano_auditoriasrch" id="frel_view_plano_auditoriasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_view_plano_auditoriasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_plano_auditoria: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_view_plano_auditoriasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_view_plano_auditoriasrch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idplano_auditoria_int", [], fields.idplano_auditoria_int.isInvalid]
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
            "idplano_auditoria_int": <?= $Page->idplano_auditoria_int->toClientList($Page) ?>,
            "processo": <?= $Page->processo->toClientList($Page) ?>,
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
<?php if ($Page->idplano_auditoria_int->Visible) { // idplano_auditoria_int ?>
<?php
if (!$Page->idplano_auditoria_int->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_idplano_auditoria_int" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->idplano_auditoria_int->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_idplano_auditoria_int" class="ew-search-caption ew-label"><?= $Page->idplano_auditoria_int->caption() ?></label>
        </div>
        <div id="el_rel_view_plano_auditoria_idplano_auditoria_int" class="ew-search-field">
    <select
        id="x_idplano_auditoria_int"
        name="x_idplano_auditoria_int"
        class="form-select ew-select<?= $Page->idplano_auditoria_int->isInvalidClass() ?>"
        <?php if (!$Page->idplano_auditoria_int->IsNativeSelect) { ?>
        data-select2-id="frel_view_plano_auditoriasrch_x_idplano_auditoria_int"
        <?php } ?>
        data-table="rel_view_plano_auditoria"
        data-field="x_idplano_auditoria_int"
        data-value-separator="<?= $Page->idplano_auditoria_int->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idplano_auditoria_int->getPlaceHolder()) ?>"
        <?= $Page->idplano_auditoria_int->editAttributes() ?>>
        <?= $Page->idplano_auditoria_int->selectOptionListHtml("x_idplano_auditoria_int") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->idplano_auditoria_int->getErrorMessage() ?></div>
<?= $Page->idplano_auditoria_int->Lookup->getParamTag($Page, "p_x_idplano_auditoria_int") ?>
<?php if (!$Page->idplano_auditoria_int->IsNativeSelect) { ?>
<script>
loadjs.ready("frel_view_plano_auditoriasrch", function() {
    var options = { name: "x_idplano_auditoria_int", selectId: "frel_view_plano_auditoriasrch_x_idplano_auditoria_int" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frel_view_plano_auditoriasrch.lists.idplano_auditoria_int?.lookupOptions.length) {
        options.data = { id: "x_idplano_auditoria_int", form: "frel_view_plano_auditoriasrch" };
    } else {
        options.ajax = { id: "x_idplano_auditoria_int", form: "frel_view_plano_auditoriasrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.rel_view_plano_auditoria.fields.idplano_auditoria_int.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
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
            data-select2-id="frel_view_plano_auditoriasrch_x_processo"
            data-table="rel_view_plano_auditoria"
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
        <div class="invalid-feedback"><?= $Page->processo->getErrorMessage() ?></div>
        <script>
        loadjs.ready("frel_view_plano_auditoriasrch", function() {
            var options = {
                name: "x_processo",
                selectId: "frel_view_plano_auditoriasrch_x_processo",
                ajax: { id: "x_processo", form: "frel_view_plano_auditoriasrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.rel_view_plano_auditoria.fields.processo.filterOptions);
            ew.createFilter(options);
        });
        </script>
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
while ($Page->GroupCount <= count($Page->GroupRecords) && $Page->GroupCount <= $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<?php if ($Page->GroupCount > 1) { ?>
</tbody>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if ($Page->TotalGroups > 0) { ?>
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?= $Page->PageBreakHtml ?>
<?php } ?>
<div class="<?= $Page->ReportContainerClass ?>">
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
<!-- Top pager -->
<div class="card-header ew-grid-upper-panel">
<?= $Page->Pager->render() ?>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_rel_view_plano_auditoria" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->idplano_auditoria_int->Visible) { ?>
    <?php if ($Page->idplano_auditoria_int->ShowGroupHeaderAsRow) { ?>
    <th data-name="idplano_auditoria_int"<?= $Page->idplano_auditoria_int->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->idplano_auditoria_int->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="idplano_auditoria_int" class="<?= $Page->idplano_auditoria_int->headerCellClass() ?>"><div class="rel_view_plano_auditoria_idplano_auditoria_int"><?= $Page->renderFieldHeader($Page->idplano_auditoria_int) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->audlider->Visible) { ?>
    <?php if ($Page->audlider->ShowGroupHeaderAsRow) { ?>
    <th data-name="audlider">&nbsp;</th>
    <?php } else { ?>
    <th data-name="audlider" class="<?= $Page->audlider->headerCellClass() ?>"><div class="rel_view_plano_auditoria_audlider"><?= $Page->renderFieldHeader($Page->audlider) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->processo->Visible) { ?>
    <th data-name="processo" class="<?= $Page->processo->headerCellClass() ?>"><div class="rel_view_plano_auditoria_processo"><?= $Page->renderFieldHeader($Page->processo) ?></div></th>
<?php } ?>
<?php if ($Page->auditor->Visible) { ?>
    <th data-name="auditor" class="<?= $Page->auditor->headerCellClass() ?>"><div class="rel_view_plano_auditoria_auditor"><?= $Page->renderFieldHeader($Page->auditor) ?></div></th>
<?php } ?>
<?php if ($Page->data->Visible) { ?>
    <th data-name="data" class="<?= $Page->data->headerCellClass() ?>"><div class="rel_view_plano_auditoria_data"><?= $Page->renderFieldHeader($Page->data) ?></div></th>
<?php } ?>
<?php if ($Page->escopo->Visible) { ?>
    <th data-name="escopo" class="<?= $Page->escopo->headerCellClass() ?>"><div class="rel_view_plano_auditoria_escopo"><?= $Page->renderFieldHeader($Page->escopo) ?></div></th>
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
    $where = DetailFilterSql($Page->idplano_auditoria_int, $Page->getSqlFirstGroupField(), $Page->idplano_auditoria_int->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->idplano_auditoria_int->Records = &$Page->DetailRecords;
    $Page->idplano_auditoria_int->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->idplano_auditoria_int->getCnt($Page->idplano_auditoria_int->Records); // Get record count
?>
<?php if ($Page->idplano_auditoria_int->Visible && $Page->idplano_auditoria_int->ShowGroupHeaderAsRow) { ?>
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
<?php if ($Page->idplano_auditoria_int->Visible) { ?>
        <td data-field="idplano_auditoria_int"<?= $Page->idplano_auditoria_int->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->idplano_auditoria_int->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="idplano_auditoria_int" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->idplano_auditoria_int->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_plano_auditoria_idplano_auditoria_int"><?= $Page->renderFieldHeader($Page->idplano_auditoria_int) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->idplano_auditoria_int->viewAttributes() ?>><?= $Page->idplano_auditoria_int->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->idplano_auditoria_int->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->audlider->getDistinctValues($Page->idplano_auditoria_int->Records, $Page->audlider->getSort());
    $Page->setGroupCount(count($Page->audlider->DistinctValues), $Page->GroupCounter[1]);
    $Page->GroupCounter[2] = 0; // Init group count index
    foreach ($Page->audlider->DistinctValues as $audlider) { // Load records for this distinct value
        $Page->audlider->setGroupValue($audlider); // Set group value
        $Page->audlider->getDistinctRecords($Page->idplano_auditoria_int->Records, $Page->audlider->groupValue());
        $Page->audlider->LevelBreak = true; // Set field level break
        $Page->GroupCounter[2]++;
        $Page->audlider->getCnt($Page->audlider->Records); // Get record count
        $Page->setGroupCount($Page->audlider->Count, $Page->GroupCounter[1], $Page->GroupCounter[2]);
?>
<?php if ($Page->audlider->Visible && $Page->audlider->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->audlider->setDbValue($audlider); // Set current value for aud lider
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 2;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idplano_auditoria_int->Visible) { ?>
        <td data-field="idplano_auditoria_int"<?= $Page->idplano_auditoria_int->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->audlider->Visible) { ?>
        <td data-field="audlider"<?= $Page->audlider->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->audlider->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="audlider" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 2) ?>"<?= $Page->audlider->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_plano_auditoria_audlider"><?= $Page->renderFieldHeader($Page->audlider) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->audlider->viewAttributes() ?>><?= $Page->audlider->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->audlider->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->audlider->Records as $record) {
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
<?php if ($Page->idplano_auditoria_int->Visible) { ?>
    <?php if ($Page->idplano_auditoria_int->ShowGroupHeaderAsRow) { ?>
        <td data-field="idplano_auditoria_int"<?= $Page->idplano_auditoria_int->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="idplano_auditoria_int"<?= $Page->idplano_auditoria_int->cellAttributes() ?>><span<?= $Page->idplano_auditoria_int->viewAttributes() ?>><?= $Page->idplano_auditoria_int->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->audlider->Visible) { ?>
    <?php if ($Page->audlider->ShowGroupHeaderAsRow) { ?>
        <td data-field="audlider"<?= $Page->audlider->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="audlider"<?= $Page->audlider->cellAttributes() ?>><span<?= $Page->audlider->viewAttributes() ?>><?= $Page->audlider->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->processo->Visible) { ?>
        <td data-field="processo"<?= $Page->processo->cellAttributes() ?>>
<span<?= $Page->processo->viewAttributes() ?>>
<?= $Page->processo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->auditor->Visible) { ?>
        <td data-field="auditor"<?= $Page->auditor->cellAttributes() ?>>
<span<?= $Page->auditor->viewAttributes() ?>>
<?= $Page->auditor->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->data->Visible) { ?>
        <td data-field="data"<?= $Page->data->cellAttributes() ?>>
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->escopo->Visible) { ?>
        <td data-field="escopo"<?= $Page->escopo->cellAttributes() ?>>
<span<?= $Page->escopo->viewAttributes() ?>>
<?= $Page->escopo->getViewValue() ?></span>
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
<?php if ($Page->idplano_auditoria_int->ShowCompactSummaryFooter) { ?>
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
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0) && $Page->Pager->Visible) { ?>
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
