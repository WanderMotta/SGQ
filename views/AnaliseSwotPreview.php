<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseSwotPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { analise_swot: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->fatores->Visible) { // fatores ?>
    <?php if (!$Page->fatores->Sortable || !$Page->sortUrl($Page->fatores)) { ?>
        <th class="<?= $Page->fatores->headerCellClass() ?>"><?= $Page->fatores->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fatores->headerCellClass() ?>"><div role="button" data-table="analise_swot" data-sort="<?= HtmlEncode($Page->fatores->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->fatores->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fatores->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fatores->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ponto->Visible) { // ponto ?>
    <?php if (!$Page->ponto->Sortable || !$Page->sortUrl($Page->ponto)) { ?>
        <th class="<?= $Page->ponto->headerCellClass() ?>"><?= $Page->ponto->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ponto->headerCellClass() ?>"><div role="button" data-table="analise_swot" data-sort="<?= HtmlEncode($Page->ponto->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->ponto->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->ponto->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->ponto->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->analise->Visible) { // analise ?>
    <?php if (!$Page->analise->Sortable || !$Page->sortUrl($Page->analise)) { ?>
        <th class="<?= $Page->analise->headerCellClass() ?>"><?= $Page->analise->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->analise->headerCellClass() ?>"><div role="button" data-table="analise_swot" data-sort="<?= HtmlEncode($Page->analise->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->analise->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->analise->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->analise->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
    <?php if (!$Page->impacto_idimpacto->Sortable || !$Page->sortUrl($Page->impacto_idimpacto)) { ?>
        <th class="<?= $Page->impacto_idimpacto->headerCellClass() ?>"><?= $Page->impacto_idimpacto->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->impacto_idimpacto->headerCellClass() ?>"><div role="button" data-table="analise_swot" data-sort="<?= HtmlEncode($Page->impacto_idimpacto->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->impacto_idimpacto->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->impacto_idimpacto->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->impacto_idimpacto->getSortIcon() ?></span>
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
<?php if ($Page->fatores->Visible) { // fatores ?>
        <!-- fatores -->
        <td<?= $Page->fatores->cellAttributes() ?>>
<span<?= $Page->fatores->viewAttributes() ?>>
<?= $Page->fatores->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ponto->Visible) { // ponto ?>
        <!-- ponto -->
        <td<?= $Page->ponto->cellAttributes() ?>>
<span<?= $Page->ponto->viewAttributes() ?>>
<?= $Page->ponto->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->analise->Visible) { // analise ?>
        <!-- analise -->
        <td<?= $Page->analise->cellAttributes() ?>>
<span<?= $Page->analise->viewAttributes() ?>>
<?= $Page->analise->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <!-- impacto_idimpacto -->
        <td<?= $Page->impacto_idimpacto->cellAttributes() ?>>
<span<?= $Page->impacto_idimpacto->viewAttributes() ?>>
<?= $Page->impacto_idimpacto->getViewValue() ?></span>
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
<?php if ($Page->fatores->Visible) { // fatores ?>
        <!-- fatores -->
        <td class="<?= $Page->fatores->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->ponto->Visible) { // ponto ?>
        <!-- ponto -->
        <td class="<?= $Page->ponto->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->analise->Visible) { // analise ?>
        <!-- analise -->
        <td class="<?= $Page->analise->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->analise->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <!-- impacto_idimpacto -->
        <td class="<?= $Page->impacto_idimpacto->footerCellClass() ?>">
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
