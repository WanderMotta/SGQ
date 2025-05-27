<?php

namespace PHPMaker2024\sgq;

// Page object
$RelViewAudInternaSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_aud_interna: currentTable } });
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
<form name="frel_view_aud_internasrch" id="frel_view_aud_internasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_view_aud_internasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_view_aud_interna: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_view_aud_internasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_view_aud_internasrch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["plano_nr", [], fields.plano_nr.isInvalid]
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
            "plano_nr": <?= $Page->plano_nr->toClientList($Page) ?>,
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
<?php if ($Page->plano_nr->Visible) { // plano_nr ?>
<?php
if (!$Page->plano_nr->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_plano_nr" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->plano_nr->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_plano_nr" class="ew-search-caption ew-label"><?= $Page->plano_nr->caption() ?></label>
        </div>
        <div id="el_rel_view_aud_interna_plano_nr" class="ew-search-field">
    <select
        id="x_plano_nr"
        name="x_plano_nr"
        class="form-select ew-select<?= $Page->plano_nr->isInvalidClass() ?>"
        <?php if (!$Page->plano_nr->IsNativeSelect) { ?>
        data-select2-id="frel_view_aud_internasrch_x_plano_nr"
        <?php } ?>
        data-table="rel_view_aud_interna"
        data-field="x_plano_nr"
        data-value-separator="<?= $Page->plano_nr->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->plano_nr->getPlaceHolder()) ?>"
        <?= $Page->plano_nr->editAttributes() ?>>
        <?= $Page->plano_nr->selectOptionListHtml("x_plano_nr") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->plano_nr->getErrorMessage() ?></div>
<?= $Page->plano_nr->Lookup->getParamTag($Page, "p_x_plano_nr") ?>
<?php if (!$Page->plano_nr->IsNativeSelect) { ?>
<script>
loadjs.ready("frel_view_aud_internasrch", function() {
    var options = { name: "x_plano_nr", selectId: "frel_view_aud_internasrch_x_plano_nr" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frel_view_aud_internasrch.lists.plano_nr?.lookupOptions.length) {
        options.data = { id: "x_plano_nr", form: "frel_view_aud_internasrch" };
    } else {
        options.ajax = { id: "x_plano_nr", form: "frel_view_aud_internasrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.rel_view_aud_interna.fields.plano_nr.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
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
<div id="gmp_rel_view_aud_interna" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->plano_nr->Visible) { ?>
    <?php if ($Page->plano_nr->ShowGroupHeaderAsRow) { ?>
    <th data-name="plano_nr"<?= $Page->plano_nr->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->plano_nr->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="plano_nr" class="<?= $Page->plano_nr->headerCellClass() ?>"><div class="rel_view_aud_interna_plano_nr"><?= $Page->renderFieldHeader($Page->plano_nr) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->data->Visible) { ?>
    <?php if ($Page->data->ShowGroupHeaderAsRow) { ?>
    <th data-name="data">&nbsp;</th>
    <?php } else { ?>
    <th data-name="data" class="<?= $Page->data->headerCellClass() ?>"><div class="rel_view_aud_interna_data"><?= $Page->renderFieldHeader($Page->data) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->auditor_lider->Visible) { ?>
    <?php if ($Page->auditor_lider->ShowGroupHeaderAsRow) { ?>
    <th data-name="auditor_lider">&nbsp;</th>
    <?php } else { ?>
    <th data-name="auditor_lider" class="<?= $Page->auditor_lider->headerCellClass() ?>"><div class="rel_view_aud_interna_auditor_lider"><?= $Page->renderFieldHeader($Page->auditor_lider) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->processo->Visible) { ?>
    <th data-name="processo" class="<?= $Page->processo->headerCellClass() ?>"><div class="rel_view_aud_interna_processo"><?= $Page->renderFieldHeader($Page->processo) ?></div></th>
<?php } ?>
<?php if ($Page->auditor->Visible) { ?>
    <th data-name="auditor" class="<?= $Page->auditor->headerCellClass() ?>"><div class="rel_view_aud_interna_auditor"><?= $Page->renderFieldHeader($Page->auditor) ?></div></th>
<?php } ?>
<?php if ($Page->metodo->Visible) { ?>
    <th data-name="metodo" class="<?= $Page->metodo->headerCellClass() ?>"><div class="rel_view_aud_interna_metodo"><?= $Page->renderFieldHeader($Page->metodo) ?></div></th>
<?php } ?>
<?php if ($Page->escopo->Visible) { ?>
    <th data-name="escopo" class="<?= $Page->escopo->headerCellClass() ?>"><div class="rel_view_aud_interna_escopo"><?= $Page->renderFieldHeader($Page->escopo) ?></div></th>
<?php } ?>
<?php if ($Page->descricao->Visible) { ?>
    <th data-name="descricao" class="<?= $Page->descricao->headerCellClass() ?>"><div class="rel_view_aud_interna_descricao"><?= $Page->renderFieldHeader($Page->descricao) ?></div></th>
<?php } ?>
<?php if ($Page->evidencia->Visible) { ?>
    <th data-name="evidencia" class="<?= $Page->evidencia->headerCellClass() ?>"><div class="rel_view_aud_interna_evidencia"><?= $Page->renderFieldHeader($Page->evidencia) ?></div></th>
<?php } ?>
<?php if ($Page->nao_conformidade->Visible) { ?>
    <th data-name="nao_conformidade" class="<?= $Page->nao_conformidade->headerCellClass() ?>"><div class="rel_view_aud_interna_nao_conformidade"><?= $Page->renderFieldHeader($Page->nao_conformidade) ?></div></th>
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
    $where = DetailFilterSql($Page->plano_nr, $Page->getSqlFirstGroupField(), $Page->plano_nr->groupValue(), $Page->Dbid);
    AddFilter($Page->PageFirstGroupFilter, $where, "OR");
    AddFilter($where, $Page->Filter);
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->executeQuery();
    $Page->DetailRecords = $rs?->fetchAll() ?? [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->plano_nr->Records = &$Page->DetailRecords;
    $Page->plano_nr->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->plano_nr->getCnt($Page->plano_nr->Records); // Get record count
?>
<?php if ($Page->plano_nr->Visible && $Page->plano_nr->ShowGroupHeaderAsRow) { ?>
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
<?php if ($Page->plano_nr->Visible) { ?>
        <td data-field="plano_nr"<?= $Page->plano_nr->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->plano_nr->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="plano_nr" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->plano_nr->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_aud_interna_plano_nr"><?= $Page->renderFieldHeader($Page->plano_nr) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->plano_nr->viewAttributes() ?>><?= $Page->plano_nr->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->plano_nr->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->data->getDistinctValues($Page->plano_nr->Records, $Page->data->getSort());
    $Page->setGroupCount(count($Page->data->DistinctValues), $Page->GroupCounter[1]);
    $Page->GroupCounter[2] = 0; // Init group count index
    foreach ($Page->data->DistinctValues as $data) { // Load records for this distinct value
        $Page->data->setGroupValue($data); // Set group value
        $Page->data->getDistinctRecords($Page->plano_nr->Records, $Page->data->groupValue());
        $Page->data->LevelBreak = true; // Set field level break
        $Page->GroupCounter[2]++;
        $Page->data->getCnt($Page->data->Records); // Get record count
?>
<?php if ($Page->data->Visible && $Page->data->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->data->setDbValue($data); // Set current value for data
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 2;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->plano_nr->Visible) { ?>
        <td data-field="plano_nr"<?= $Page->plano_nr->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->data->Visible) { ?>
        <td data-field="data"<?= $Page->data->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->data->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="data" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 2) ?>"<?= $Page->data->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_aud_interna_data"><?= $Page->renderFieldHeader($Page->data) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->data->viewAttributes() ?>><?= $Page->data->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->data->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->auditor_lider->getDistinctValues($Page->data->Records, $Page->auditor_lider->getSort());
    $Page->setGroupCount(count($Page->auditor_lider->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2]);
    $Page->GroupCounter[3] = 0; // Init group count index
    foreach ($Page->auditor_lider->DistinctValues as $auditor_lider) { // Load records for this distinct value
        $Page->auditor_lider->setGroupValue($auditor_lider); // Set group value
        $Page->auditor_lider->getDistinctRecords($Page->data->Records, $Page->auditor_lider->groupValue());
        $Page->auditor_lider->LevelBreak = true; // Set field level break
        $Page->GroupCounter[3]++;
        $Page->auditor_lider->getCnt($Page->auditor_lider->Records); // Get record count
        $Page->setGroupCount($Page->auditor_lider->Count, $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3]);
?>
<?php if ($Page->auditor_lider->Visible && $Page->auditor_lider->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->auditor_lider->setDbValue($auditor_lider); // Set current value for auditor_lider
        $Page->resetAttributes();
        $Page->RowType = RowType::TOTAL;
        $Page->RowTotalType = RowSummary::GROUP;
        $Page->RowTotalSubType = RowTotal::HEADER;
        $Page->RowGroupLevel = 3;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->plano_nr->Visible) { ?>
        <td data-field="plano_nr"<?= $Page->plano_nr->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->data->Visible) { ?>
        <td data-field="data"<?= $Page->data->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->auditor_lider->Visible) { ?>
        <td data-field="auditor_lider"<?= $Page->auditor_lider->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->auditor_lider->groupToggleIcon() ?></td>
<?php } ?>
        <td data-field="auditor_lider" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 3) ?>"<?= $Page->auditor_lider->cellAttributes() ?>>
            <span class="ew-summary-caption rel_view_aud_interna_auditor_lider"><?= $Page->renderFieldHeader($Page->auditor_lider) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->auditor_lider->viewAttributes() ?>><?= $Page->auditor_lider->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->auditor_lider->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->auditor_lider->Records as $record) {
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
<?php if ($Page->plano_nr->Visible) { ?>
    <?php if ($Page->plano_nr->ShowGroupHeaderAsRow) { ?>
        <td data-field="plano_nr"<?= $Page->plano_nr->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="plano_nr"<?= $Page->plano_nr->cellAttributes() ?>><span<?= $Page->plano_nr->viewAttributes() ?>><?= $Page->plano_nr->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->data->Visible) { ?>
    <?php if ($Page->data->ShowGroupHeaderAsRow) { ?>
        <td data-field="data"<?= $Page->data->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="data"<?= $Page->data->cellAttributes() ?>><span<?= $Page->data->viewAttributes() ?>><?= $Page->data->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->auditor_lider->Visible) { ?>
    <?php if ($Page->auditor_lider->ShowGroupHeaderAsRow) { ?>
        <td data-field="auditor_lider"<?= $Page->auditor_lider->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="auditor_lider"<?= $Page->auditor_lider->cellAttributes() ?>><span<?= $Page->auditor_lider->viewAttributes() ?>><?= $Page->auditor_lider->GroupViewValue ?></span></td>
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
<?php if ($Page->metodo->Visible) { ?>
        <td data-field="metodo"<?= $Page->metodo->cellAttributes() ?>>
<span<?= $Page->metodo->viewAttributes() ?>>
<?= $Page->metodo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->escopo->Visible) { ?>
        <td data-field="escopo"<?= $Page->escopo->cellAttributes() ?>>
<span<?= $Page->escopo->viewAttributes() ?>>
<?= $Page->escopo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->descricao->Visible) { ?>
        <td data-field="descricao"<?= $Page->descricao->cellAttributes() ?>>
<span<?= $Page->descricao->viewAttributes() ?>>
<?= $Page->descricao->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->evidencia->Visible) { ?>
        <td data-field="evidencia"<?= $Page->evidencia->cellAttributes() ?>>
<span<?= $Page->evidencia->viewAttributes() ?>>
<?= $Page->evidencia->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nao_conformidade->Visible) { ?>
        <td data-field="nao_conformidade"<?= $Page->nao_conformidade->cellAttributes() ?>>
<span<?= $Page->nao_conformidade->viewAttributes() ?>>
<?= $Page->nao_conformidade->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
    }
    } // End group level 2
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
<?php if ($Page->plano_nr->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"></td>
<?php } ?>
<?php if ($Page->processo->Visible) { ?>
        <td data-field="processo"<?= $Page->processo->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><span class="ew-aggregate-equal"><?= $Language->phrase("AggregateEqual") ?></span><span class="ew-aggregate-value"><span<?= $Page->processo->viewAttributes() ?>><?= $Page->processo->CntViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->auditor->Visible) { ?>
        <td data-field="auditor"<?= $Page->auditor->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->metodo->Visible) { ?>
        <td data-field="metodo"<?= $Page->metodo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->escopo->Visible) { ?>
        <td data-field="escopo"<?= $Page->escopo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->descricao->Visible) { ?>
        <td data-field="descricao"<?= $Page->descricao->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->evidencia->Visible) { ?>
        <td data-field="evidencia"<?= $Page->evidencia->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->nao_conformidade->Visible) { ?>
        <td data-field="nao_conformidade"<?= $Page->nao_conformidade->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"><?= $Language->phrase("RptCnt") ?></td>
<?php } ?>
<?php if ($Page->processo->Visible) { ?>
        <td data-field="processo"<?= $Page->processo->cellAttributes() ?>>
<span<?= $Page->processo->viewAttributes() ?>>
<?= $Page->processo->CntViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->auditor->Visible) { ?>
        <td data-field="auditor"<?= $Page->auditor->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->metodo->Visible) { ?>
        <td data-field="metodo"<?= $Page->metodo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->escopo->Visible) { ?>
        <td data-field="escopo"<?= $Page->escopo->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->descricao->Visible) { ?>
        <td data-field="descricao"<?= $Page->descricao->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->evidencia->Visible) { ?>
        <td data-field="evidencia"<?= $Page->evidencia->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->nao_conformidade->Visible) { ?>
        <td data-field="nao_conformidade"<?= $Page->nao_conformidade->cellAttributes() ?>></td>
<?php } ?>
    </tr>
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
