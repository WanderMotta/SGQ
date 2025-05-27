<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAcaoPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { plano_acao: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid <?= $Page->TableGridClass ?>"><!-- .card -->
<div class="card-header ew-grid-upper-panel ew-preview-upper-panel"><!-- .card-header -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-header -->
<div class="card-body ew-preview-middle-panel ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>"><!-- .card-body -->
<table class="<?= $Page->TableClass ?>"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
    <?php if (!$Page->risco_oportunidade_idrisco_oportunidade->Sortable || !$Page->sortUrl($Page->risco_oportunidade_idrisco_oportunidade)) { ?>
        <th class="<?= $Page->risco_oportunidade_idrisco_oportunidade->headerCellClass() ?>"><?= $Page->risco_oportunidade_idrisco_oportunidade->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->risco_oportunidade_idrisco_oportunidade->headerCellClass() ?>"><div role="button" data-table="plano_acao" data-sort="<?= HtmlEncode($Page->risco_oportunidade_idrisco_oportunidade->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->risco_oportunidade_idrisco_oportunidade->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->risco_oportunidade_idrisco_oportunidade->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->risco_oportunidade_idrisco_oportunidade->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
    <?php if (!$Page->o_q_sera_feito->Sortable || !$Page->sortUrl($Page->o_q_sera_feito)) { ?>
        <th class="<?= $Page->o_q_sera_feito->headerCellClass() ?>"><?= $Page->o_q_sera_feito->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->o_q_sera_feito->headerCellClass() ?>"><div role="button" data-table="plano_acao" data-sort="<?= HtmlEncode($Page->o_q_sera_feito->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->o_q_sera_feito->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->o_q_sera_feito->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->o_q_sera_feito->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
    <?php if (!$Page->efeito_esperado->Sortable || !$Page->sortUrl($Page->efeito_esperado)) { ?>
        <th class="<?= $Page->efeito_esperado->headerCellClass() ?>"><?= $Page->efeito_esperado->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->efeito_esperado->headerCellClass() ?>"><div role="button" data-table="plano_acao" data-sort="<?= HtmlEncode($Page->efeito_esperado->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->efeito_esperado->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->efeito_esperado->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->efeito_esperado->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <?php if (!$Page->departamentos_iddepartamentos->Sortable || !$Page->sortUrl($Page->departamentos_iddepartamentos)) { ?>
        <th class="<?= $Page->departamentos_iddepartamentos->headerCellClass() ?>"><?= $Page->departamentos_iddepartamentos->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->departamentos_iddepartamentos->headerCellClass() ?>"><div role="button" data-table="plano_acao" data-sort="<?= HtmlEncode($Page->departamentos_iddepartamentos->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->departamentos_iddepartamentos->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->departamentos_iddepartamentos->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->departamentos_iddepartamentos->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
    <?php if (!$Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Sortable || !$Page->sortUrl($Page->origem_risco_oportunidade_idorigem_risco_oportunidade)) { ?>
        <th class="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->headerCellClass() ?>"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->headerCellClass() ?>"><div role="button" data-table="plano_acao" data-sort="<?= HtmlEncode($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
    <?php if (!$Page->recursos_nec->Sortable || !$Page->sortUrl($Page->recursos_nec)) { ?>
        <th class="<?= $Page->recursos_nec->headerCellClass() ?>"><?= $Page->recursos_nec->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->recursos_nec->headerCellClass() ?>"><div role="button" data-table="plano_acao" data-sort="<?= HtmlEncode($Page->recursos_nec->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->recursos_nec->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->recursos_nec->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->recursos_nec->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
    <?php if (!$Page->dt_limite->Sortable || !$Page->sortUrl($Page->dt_limite)) { ?>
        <th class="<?= $Page->dt_limite->headerCellClass() ?>"><?= $Page->dt_limite->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->dt_limite->headerCellClass() ?>"><div role="button" data-table="plano_acao" data-sort="<?= HtmlEncode($Page->dt_limite->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->dt_limite->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->dt_limite->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->dt_limite->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
    <?php if (!$Page->implementado->Sortable || !$Page->sortUrl($Page->implementado)) { ?>
        <th class="<?= $Page->implementado->headerCellClass() ?>"><?= $Page->implementado->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->implementado->headerCellClass() ?>"><div role="button" data-table="plano_acao" data-sort="<?= HtmlEncode($Page->implementado->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->implementado->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->implementado->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->implementado->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
    <?php if (!$Page->periodicidade_idperiodicidade->Sortable || !$Page->sortUrl($Page->periodicidade_idperiodicidade)) { ?>
        <th class="<?= $Page->periodicidade_idperiodicidade->headerCellClass() ?>"><?= $Page->periodicidade_idperiodicidade->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->periodicidade_idperiodicidade->headerCellClass() ?>"><div role="button" data-table="plano_acao" data-sort="<?= HtmlEncode($Page->periodicidade_idperiodicidade->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->periodicidade_idperiodicidade->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->periodicidade_idperiodicidade->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->periodicidade_idperiodicidade->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
    <?php if (!$Page->eficaz->Sortable || !$Page->sortUrl($Page->eficaz)) { ?>
        <th class="<?= $Page->eficaz->headerCellClass() ?>"><?= $Page->eficaz->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->eficaz->headerCellClass() ?>"><div role="button" data-table="plano_acao" data-sort="<?= HtmlEncode($Page->eficaz->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->eficaz->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->eficaz->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->eficaz->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecordCount = 0;
$Page->RowCount = 0;
while ($Page->fetch()) {
    // Init row class and style
    $Page->RecordCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->CurrentRow);
    $Page->aggregateListRowValues(); // Aggregate row values

    // Render row
    $Page->RowType = RowType::PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Set up row attributes
    $Page->RowAttrs->merge([
        "data-rowindex" => $Page->RowCount,
        "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",

        // Add row attributes for expandable row
        "data-widget" => "expandable-table",
        "aria-expanded" => "false",
    ]);

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
        <!-- risco_oportunidade_idrisco_oportunidade -->
        <td<?= $Page->risco_oportunidade_idrisco_oportunidade->cellAttributes() ?>>
<span<?= $Page->risco_oportunidade_idrisco_oportunidade->viewAttributes() ?>>
<?= $Page->risco_oportunidade_idrisco_oportunidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <!-- o_q_sera_feito -->
        <td<?= $Page->o_q_sera_feito->cellAttributes() ?>>
<span<?= $Page->o_q_sera_feito->viewAttributes() ?>>
<?= $Page->o_q_sera_feito->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
        <!-- efeito_esperado -->
        <td<?= $Page->efeito_esperado->cellAttributes() ?>>
<span<?= $Page->efeito_esperado->viewAttributes() ?>>
<?= $Page->efeito_esperado->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <!-- departamentos_iddepartamentos -->
        <td<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span<?= $Page->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Page->departamentos_iddepartamentos->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <!-- origem_risco_oportunidade_idorigem_risco_oportunidade -->
        <td<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
        <!-- recursos_nec -->
        <td<?= $Page->recursos_nec->cellAttributes() ?>>
<span<?= $Page->recursos_nec->viewAttributes() ?>>
<?= $Page->recursos_nec->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
        <!-- dt_limite -->
        <td<?= $Page->dt_limite->cellAttributes() ?>>
<span<?= $Page->dt_limite->viewAttributes() ?>>
<?= $Page->dt_limite->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
        <!-- implementado -->
        <td<?= $Page->implementado->cellAttributes() ?>>
<span<?= $Page->implementado->viewAttributes() ?>>
<?= $Page->implementado->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <!-- periodicidade_idperiodicidade -->
        <td<?= $Page->periodicidade_idperiodicidade->cellAttributes() ?>>
<span<?= $Page->periodicidade_idperiodicidade->viewAttributes() ?>>
<?= $Page->periodicidade_idperiodicidade->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
        <!-- eficaz -->
        <td<?= $Page->eficaz->cellAttributes() ?>>
<span<?= $Page->eficaz->viewAttributes() ?>>
<?= $Page->eficaz->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
} // while
?>
    </tbody>
<?php
    // Render aggregate row
    $Page->RowType = RowType::AGGREGATE; // Aggregate
    $Page->aggregateListRow(); // Prepare aggregate row

    // Render list options
    $Page->renderListOptions();
?>
    <tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options (footer, left)
$Page->ListOptions->render("footer", "left");
?>
<?php if ($Page->risco_oportunidade_idrisco_oportunidade->Visible) { // risco_oportunidade_idrisco_oportunidade ?>
        <!-- risco_oportunidade_idrisco_oportunidade -->
        <td class="<?= $Page->risco_oportunidade_idrisco_oportunidade->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
        <!-- o_q_sera_feito -->
        <td class="<?= $Page->o_q_sera_feito->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->efeito_esperado->Visible) { // efeito_esperado ?>
        <!-- efeito_esperado -->
        <td class="<?= $Page->efeito_esperado->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <!-- departamentos_iddepartamentos -->
        <td class="<?= $Page->departamentos_iddepartamentos->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <!-- origem_risco_oportunidade_idorigem_risco_oportunidade -->
        <td class="<?= $Page->origem_risco_oportunidade_idorigem_risco_oportunidade->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
        <!-- recursos_nec -->
        <td class="<?= $Page->recursos_nec->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->recursos_nec->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->dt_limite->Visible) { // dt_limite ?>
        <!-- dt_limite -->
        <td class="<?= $Page->dt_limite->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
        <!-- implementado -->
        <td class="<?= $Page->implementado->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <!-- periodicidade_idperiodicidade -->
        <td class="<?= $Page->periodicidade_idperiodicidade->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
        <!-- eficaz -->
        <td class="<?= $Page->eficaz->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php
// Render list options (footer, right)
$Page->ListOptions->render("footer", "right");
?>
    </tr>
    </tfoot>
</table><!-- /.table -->
</div><!-- /.card-body -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-footer -->
</div><!-- /.card -->
<?php } else { // No record ?>
<div class="card border-0"><!-- .card -->
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card -->
<?php } ?>
<?php
foreach ($Page->DetailCounts as $detailTblVar => $detailCount) {
?>
<div class="ew-detail-count d-none" data-table="<?= $detailTblVar ?>" data-count="<?= $detailCount ?>"><?= FormatInteger($detailCount) ?></div>
<?php
}
?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
$Page->Recordset?->free();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
