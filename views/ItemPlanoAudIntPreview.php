<?php

namespace PHPMaker2024\sgq;

// Page object
$ItemPlanoAudIntPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { item_plano_aud_int: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->iditem_plano_aud_int->Visible) { // iditem_plano_aud_int ?>
    <?php if (!$Page->iditem_plano_aud_int->Sortable || !$Page->sortUrl($Page->iditem_plano_aud_int)) { ?>
        <th class="<?= $Page->iditem_plano_aud_int->headerCellClass() ?>"><?= $Page->iditem_plano_aud_int->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->iditem_plano_aud_int->headerCellClass() ?>"><div role="button" data-table="item_plano_aud_int" data-sort="<?= HtmlEncode($Page->iditem_plano_aud_int->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->iditem_plano_aud_int->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->iditem_plano_aud_int->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->iditem_plano_aud_int->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
    <?php if (!$Page->data->Sortable || !$Page->sortUrl($Page->data)) { ?>
        <th class="<?= $Page->data->headerCellClass() ?>"><?= $Page->data->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->data->headerCellClass() ?>"><div role="button" data-table="item_plano_aud_int" data-sort="<?= HtmlEncode($Page->data->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->data->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->data->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->data->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <?php if (!$Page->processo_idprocesso->Sortable || !$Page->sortUrl($Page->processo_idprocesso)) { ?>
        <th class="<?= $Page->processo_idprocesso->headerCellClass() ?>"><?= $Page->processo_idprocesso->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->processo_idprocesso->headerCellClass() ?>"><div role="button" data-table="item_plano_aud_int" data-sort="<?= HtmlEncode($Page->processo_idprocesso->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->processo_idprocesso->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->processo_idprocesso->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->processo_idprocesso->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->escopo->Visible) { // escopo ?>
    <?php if (!$Page->escopo->Sortable || !$Page->sortUrl($Page->escopo)) { ?>
        <th class="<?= $Page->escopo->headerCellClass() ?>"><?= $Page->escopo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->escopo->headerCellClass() ?>"><div role="button" data-table="item_plano_aud_int" data-sort="<?= HtmlEncode($Page->escopo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->escopo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->escopo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->escopo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <?php if (!$Page->usuario_idusuario->Sortable || !$Page->sortUrl($Page->usuario_idusuario)) { ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><?= $Page->usuario_idusuario->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><div role="button" data-table="item_plano_aud_int" data-sort="<?= HtmlEncode($Page->usuario_idusuario->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->usuario_idusuario->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->usuario_idusuario->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->usuario_idusuario->getSortIcon() ?></span>
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
<?php if ($Page->iditem_plano_aud_int->Visible) { // iditem_plano_aud_int ?>
        <!-- iditem_plano_aud_int -->
        <td<?= $Page->iditem_plano_aud_int->cellAttributes() ?>>
<span<?= $Page->iditem_plano_aud_int->viewAttributes() ?>>
<?= $Page->iditem_plano_aud_int->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
        <!-- data -->
        <td<?= $Page->data->cellAttributes() ?>>
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <!-- processo_idprocesso -->
        <td<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->escopo->Visible) { // escopo ?>
        <!-- escopo -->
        <td<?= $Page->escopo->cellAttributes() ?>>
<span<?= $Page->escopo->viewAttributes() ?>>
<?= $Page->escopo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <!-- usuario_idusuario -->
        <td<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
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
