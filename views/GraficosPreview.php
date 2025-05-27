<?php

namespace PHPMaker2024\sgq;

// Page object
$GraficosPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { graficos: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->competencia_idcompetencia->Visible) { // competencia_idcompetencia ?>
    <?php if (!$Page->competencia_idcompetencia->Sortable || !$Page->sortUrl($Page->competencia_idcompetencia)) { ?>
        <th class="<?= $Page->competencia_idcompetencia->headerCellClass() ?>"><?= $Page->competencia_idcompetencia->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->competencia_idcompetencia->headerCellClass() ?>"><div role="button" data-table="graficos" data-sort="<?= HtmlEncode($Page->competencia_idcompetencia->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->competencia_idcompetencia->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->competencia_idcompetencia->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->competencia_idcompetencia->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
    <?php if (!$Page->indicadores_idindicadores->Sortable || !$Page->sortUrl($Page->indicadores_idindicadores)) { ?>
        <th class="<?= $Page->indicadores_idindicadores->headerCellClass() ?>"><?= $Page->indicadores_idindicadores->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->indicadores_idindicadores->headerCellClass() ?>"><div role="button" data-table="graficos" data-sort="<?= HtmlEncode($Page->indicadores_idindicadores->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->indicadores_idindicadores->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->indicadores_idindicadores->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->indicadores_idindicadores->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
    <?php if (!$Page->valor->Sortable || !$Page->sortUrl($Page->valor)) { ?>
        <th class="<?= $Page->valor->headerCellClass() ?>"><?= $Page->valor->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->valor->headerCellClass() ?>"><div role="button" data-table="graficos" data-sort="<?= HtmlEncode($Page->valor->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->valor->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->valor->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->valor->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <?php if (!$Page->obs->Sortable || !$Page->sortUrl($Page->obs)) { ?>
        <th class="<?= $Page->obs->headerCellClass() ?>"><?= $Page->obs->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->obs->headerCellClass() ?>"><div role="button" data-table="graficos" data-sort="<?= HtmlEncode($Page->obs->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->obs->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->obs->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->obs->getSortIcon() ?></span>
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
<?php if ($Page->competencia_idcompetencia->Visible) { // competencia_idcompetencia ?>
        <!-- competencia_idcompetencia -->
        <td<?= $Page->competencia_idcompetencia->cellAttributes() ?>>
<span<?= $Page->competencia_idcompetencia->viewAttributes() ?>>
<?= $Page->competencia_idcompetencia->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
        <!-- indicadores_idindicadores -->
        <td<?= $Page->indicadores_idindicadores->cellAttributes() ?>>
<span<?= $Page->indicadores_idindicadores->viewAttributes() ?>>
<?= $Page->indicadores_idindicadores->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
        <!-- valor -->
        <td<?= $Page->valor->cellAttributes() ?>>
<span<?= $Page->valor->viewAttributes() ?>>
<?= $Page->valor->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
        <!-- obs -->
        <td<?= $Page->obs->cellAttributes() ?>>
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
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
