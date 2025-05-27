<?php

namespace PHPMaker2024\sgq;

// Page object
$RelProcessosSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_processos: currentTable } });
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
<form name="frel_processossrch" id="frel_processossrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="frel_processossrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rel_processos: currentTable } });
var currentPageID = ew.PAGE_ID = "summary";
var currentForm;
var frel_processossrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("frel_processossrch")
        .setPageId("summary")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["processo", [], fields.processo.isInvalid]
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
<?php if ($Page->processo->Visible) { // processo ?>
<?php
if (!$Page->processo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_processo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->processo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_processo" class="ew-search-caption ew-label"><?= $Page->processo->caption() ?></label>
        </div>
        <div id="el_rel_processos_processo" class="ew-search-field">
    <select
        id="x_processo"
        name="x_processo"
        class="form-select ew-select<?= $Page->processo->isInvalidClass() ?>"
        <?php if (!$Page->processo->IsNativeSelect) { ?>
        data-select2-id="frel_processossrch_x_processo"
        <?php } ?>
        data-table="rel_processos"
        data-field="x_processo"
        data-value-separator="<?= $Page->processo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->processo->getPlaceHolder()) ?>"
        <?= $Page->processo->editAttributes() ?>>
        <?= $Page->processo->selectOptionListHtml("x_processo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->processo->getErrorMessage() ?></div>
<?= $Page->processo->Lookup->getParamTag($Page, "p_x_processo") ?>
<?php if (!$Page->processo->IsNativeSelect) { ?>
<script>
loadjs.ready("frel_processossrch", function() {
    var options = { name: "x_processo", selectId: "frel_processossrch_x_processo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (frel_processossrch.lists.processo?.lookupOptions.length) {
        options.data = { id: "x_processo", form: "frel_processossrch" };
    } else {
        options.ajax = { id: "x_processo", form: "frel_processossrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.rel_processos.fields.processo.selectOptions);
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
<div id="gmp_rel_processos" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>">
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->processo->Visible) { ?>
    <?php if ($Page->processo->ShowGroupHeaderAsRow) { ?>
    <th data-name="processo"<?= $Page->processo->cellAttributes("ew-rpt-grp-caret") ?>><?= $Page->processo->groupToggleIcon() ?></th>
    <?php } else { ?>
    <th data-name="processo" class="<?= $Page->processo->headerCellClass() ?>"><div class="rel_processos_processo"><?= $Page->renderFieldHeader($Page->processo) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->responsaveis->Visible) { ?>
    <th data-name="responsaveis" class="<?= $Page->responsaveis->headerCellClass() ?>"><div class="rel_processos_responsaveis"><?= $Page->renderFieldHeader($Page->responsaveis) ?></div></th>
<?php } ?>
<?php if ($Page->objetivo->Visible) { ?>
    <th data-name="objetivo" class="<?= $Page->objetivo->headerCellClass() ?>"><div class="rel_processos_objetivo"><?= $Page->renderFieldHeader($Page->objetivo) ?></div></th>
<?php } ?>
<?php if ($Page->eqpto_recursos->Visible) { ?>
    <th data-name="eqpto_recursos" class="<?= $Page->eqpto_recursos->headerCellClass() ?>"><div class="rel_processos_eqpto_recursos"><?= $Page->renderFieldHeader($Page->eqpto_recursos) ?></div></th>
<?php } ?>
<?php if ($Page->entradas->Visible) { ?>
    <th data-name="entradas" class="<?= $Page->entradas->headerCellClass() ?>"><div class="rel_processos_entradas"><?= $Page->renderFieldHeader($Page->entradas) ?></div></th>
<?php } ?>
<?php if ($Page->atividade_principal->Visible) { ?>
    <th data-name="atividade_principal" class="<?= $Page->atividade_principal->headerCellClass() ?>"><div class="rel_processos_atividade_principal"><?= $Page->renderFieldHeader($Page->atividade_principal) ?></div></th>
<?php } ?>
<?php if ($Page->saidas_resultados->Visible) { ?>
    <th data-name="saidas_resultados" class="<?= $Page->saidas_resultados->headerCellClass() ?>"><div class="rel_processos_saidas_resultados"><?= $Page->renderFieldHeader($Page->saidas_resultados) ?></div></th>
<?php } ?>
<?php if ($Page->requsito_saidas->Visible) { ?>
    <th data-name="requsito_saidas" class="<?= $Page->requsito_saidas->headerCellClass() ?>"><div class="rel_processos_requsito_saidas"><?= $Page->renderFieldHeader($Page->requsito_saidas) ?></div></th>
<?php } ?>
<?php if ($Page->riscos->Visible) { ?>
    <th data-name="riscos" class="<?= $Page->riscos->headerCellClass() ?>"><div class="rel_processos_riscos"><?= $Page->renderFieldHeader($Page->riscos) ?></div></th>
<?php } ?>
<?php if ($Page->oportunidades->Visible) { ?>
    <th data-name="oportunidades" class="<?= $Page->oportunidades->headerCellClass() ?>"><div class="rel_processos_oportunidades"><?= $Page->renderFieldHeader($Page->oportunidades) ?></div></th>
<?php } ?>
<?php if ($Page->propriedade_externa->Visible) { ?>
    <th data-name="propriedade_externa" class="<?= $Page->propriedade_externa->headerCellClass() ?>"><div class="rel_processos_propriedade_externa"><?= $Page->renderFieldHeader($Page->propriedade_externa) ?></div></th>
<?php } ?>
<?php if ($Page->conhecimentos->Visible) { ?>
    <th data-name="conhecimentos" class="<?= $Page->conhecimentos->headerCellClass() ?>"><div class="rel_processos_conhecimentos"><?= $Page->renderFieldHeader($Page->conhecimentos) ?></div></th>
<?php } ?>
<?php if ($Page->documentos_aplicados->Visible) { ?>
    <th data-name="documentos_aplicados" class="<?= $Page->documentos_aplicados->headerCellClass() ?>"><div class="rel_processos_documentos_aplicados"><?= $Page->renderFieldHeader($Page->documentos_aplicados) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_idtipo->Visible) { ?>
    <th data-name="tipo_idtipo" class="<?= $Page->tipo_idtipo->headerCellClass() ?>"><div class="rel_processos_tipo_idtipo"><?= $Page->renderFieldHeader($Page->tipo_idtipo) ?></div></th>
<?php } ?>
<?php if ($Page->proced_int_trabalho->Visible) { ?>
    <th data-name="proced_int_trabalho" class="<?= $Page->proced_int_trabalho->headerCellClass() ?>"><div class="rel_processos_proced_int_trabalho"><?= $Page->renderFieldHeader($Page->proced_int_trabalho) ?></div></th>
<?php } ?>
<?php if ($Page->mapa->Visible) { ?>
    <th data-name="mapa" class="<?= $Page->mapa->headerCellClass() ?>"><div class="rel_processos_mapa"><?= $Page->renderFieldHeader($Page->mapa) ?></div></th>
<?php } ?>
<?php if ($Page->revisao->Visible) { ?>
    <th data-name="revisao" class="<?= $Page->revisao->headerCellClass() ?>"><div class="rel_processos_revisao"><?= $Page->renderFieldHeader($Page->revisao) ?></div></th>
<?php } ?>
<?php if ($Page->proc_antes->Visible) { ?>
    <th data-name="proc_antes" class="<?= $Page->proc_antes->headerCellClass() ?>"><div class="rel_processos_proc_antes"><?= $Page->renderFieldHeader($Page->proc_antes) ?></div></th>
<?php } ?>
<?php if ($Page->proc_depois->Visible) { ?>
    <th data-name="proc_depois" class="<?= $Page->proc_depois->headerCellClass() ?>"><div class="rel_processos_proc_depois"><?= $Page->renderFieldHeader($Page->proc_depois) ?></div></th>
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
            <span class="ew-summary-caption rel_processos_processo"><?= $Page->renderFieldHeader($Page->processo) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->processo->viewAttributes() ?>><?= $Page->processo->GroupViewValue ?></span>
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
<?php if ($Page->responsaveis->Visible) { ?>
        <td data-field="responsaveis"<?= $Page->responsaveis->cellAttributes() ?>>
<span<?= $Page->responsaveis->viewAttributes() ?>>
<?= $Page->responsaveis->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->objetivo->Visible) { ?>
        <td data-field="objetivo"<?= $Page->objetivo->cellAttributes() ?>>
<span<?= $Page->objetivo->viewAttributes() ?>>
<?= $Page->objetivo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->eqpto_recursos->Visible) { ?>
        <td data-field="eqpto_recursos"<?= $Page->eqpto_recursos->cellAttributes() ?>>
<span<?= $Page->eqpto_recursos->viewAttributes() ?>>
<?= $Page->eqpto_recursos->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->entradas->Visible) { ?>
        <td data-field="entradas"<?= $Page->entradas->cellAttributes() ?>>
<span<?= $Page->entradas->viewAttributes() ?>>
<?= $Page->entradas->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->atividade_principal->Visible) { ?>
        <td data-field="atividade_principal"<?= $Page->atividade_principal->cellAttributes() ?>>
<span<?= $Page->atividade_principal->viewAttributes() ?>>
<?= $Page->atividade_principal->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->saidas_resultados->Visible) { ?>
        <td data-field="saidas_resultados"<?= $Page->saidas_resultados->cellAttributes() ?>>
<span<?= $Page->saidas_resultados->viewAttributes() ?>>
<?= $Page->saidas_resultados->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->requsito_saidas->Visible) { ?>
        <td data-field="requsito_saidas"<?= $Page->requsito_saidas->cellAttributes() ?>>
<span<?= $Page->requsito_saidas->viewAttributes() ?>>
<?= $Page->requsito_saidas->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->riscos->Visible) { ?>
        <td data-field="riscos"<?= $Page->riscos->cellAttributes() ?>>
<span<?= $Page->riscos->viewAttributes() ?>>
<?= $Page->riscos->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->oportunidades->Visible) { ?>
        <td data-field="oportunidades"<?= $Page->oportunidades->cellAttributes() ?>>
<span<?= $Page->oportunidades->viewAttributes() ?>>
<?= $Page->oportunidades->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->propriedade_externa->Visible) { ?>
        <td data-field="propriedade_externa"<?= $Page->propriedade_externa->cellAttributes() ?>>
<span<?= $Page->propriedade_externa->viewAttributes() ?>>
<?= $Page->propriedade_externa->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->conhecimentos->Visible) { ?>
        <td data-field="conhecimentos"<?= $Page->conhecimentos->cellAttributes() ?>>
<span<?= $Page->conhecimentos->viewAttributes() ?>>
<?= $Page->conhecimentos->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->documentos_aplicados->Visible) { ?>
        <td data-field="documentos_aplicados"<?= $Page->documentos_aplicados->cellAttributes() ?>>
<span<?= $Page->documentos_aplicados->viewAttributes() ?>>
<?= $Page->documentos_aplicados->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tipo_idtipo->Visible) { ?>
        <td data-field="tipo_idtipo"<?= $Page->tipo_idtipo->cellAttributes() ?>>
<span<?= $Page->tipo_idtipo->viewAttributes() ?>>
<?= $Page->tipo_idtipo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->proced_int_trabalho->Visible) { ?>
        <td data-field="proced_int_trabalho"<?= $Page->proced_int_trabalho->cellAttributes() ?>>
<span<?= $Page->proced_int_trabalho->viewAttributes() ?>>
<?= $Page->proced_int_trabalho->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->mapa->Visible) { ?>
        <td data-field="mapa"<?= $Page->mapa->cellAttributes() ?>>
<span<?= $Page->mapa->viewAttributes() ?>>
<?= $Page->mapa->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->revisao->Visible) { ?>
        <td data-field="revisao"<?= $Page->revisao->cellAttributes() ?>>
<span<?= $Page->revisao->viewAttributes() ?>>
<?= $Page->revisao->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->proc_antes->Visible) { ?>
        <td data-field="proc_antes"<?= $Page->proc_antes->cellAttributes() ?>>
<span<?= $Page->proc_antes->viewAttributes() ?>>
<?= $Page->proc_antes->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->proc_depois->Visible) { ?>
        <td data-field="proc_depois"<?= $Page->proc_depois->cellAttributes() ?>>
<span<?= $Page->proc_depois->viewAttributes() ?>>
<?= $Page->proc_depois->getViewValue() ?></span>
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
