<?php

namespace PHPMaker2024\sgq;

// Page object
$ItemRelAudInternaPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { item_rel_aud_interna: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->iditem_rel_aud_interna->Visible) { // iditem_rel_aud_interna ?>
    <?php if (!$Page->iditem_rel_aud_interna->Sortable || !$Page->sortUrl($Page->iditem_rel_aud_interna)) { ?>
        <th class="<?= $Page->iditem_rel_aud_interna->headerCellClass() ?>"><?= $Page->iditem_rel_aud_interna->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->iditem_rel_aud_interna->headerCellClass() ?>"><div role="button" data-table="item_rel_aud_interna" data-sort="<?= HtmlEncode($Page->iditem_rel_aud_interna->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->iditem_rel_aud_interna->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->iditem_rel_aud_interna->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->iditem_rel_aud_interna->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <?php if (!$Page->processo_idprocesso->Sortable || !$Page->sortUrl($Page->processo_idprocesso)) { ?>
        <th class="<?= $Page->processo_idprocesso->headerCellClass() ?>"><?= $Page->processo_idprocesso->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->processo_idprocesso->headerCellClass() ?>"><div role="button" data-table="item_rel_aud_interna" data-sort="<?= HtmlEncode($Page->processo_idprocesso->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->processo_idprocesso->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->processo_idprocesso->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->processo_idprocesso->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
    <?php if (!$Page->descricao->Sortable || !$Page->sortUrl($Page->descricao)) { ?>
        <th class="<?= $Page->descricao->headerCellClass() ?>"><?= $Page->descricao->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->descricao->headerCellClass() ?>"><div role="button" data-table="item_rel_aud_interna" data-sort="<?= HtmlEncode($Page->descricao->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->descricao->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->descricao->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->descricao->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->acao_imediata->Visible) { // acao_imediata ?>
    <?php if (!$Page->acao_imediata->Sortable || !$Page->sortUrl($Page->acao_imediata)) { ?>
        <th class="<?= $Page->acao_imediata->headerCellClass() ?>"><?= $Page->acao_imediata->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->acao_imediata->headerCellClass() ?>"><div role="button" data-table="item_rel_aud_interna" data-sort="<?= HtmlEncode($Page->acao_imediata->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->acao_imediata->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->acao_imediata->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->acao_imediata->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->acao_contecao->Visible) { // acao_contecao ?>
    <?php if (!$Page->acao_contecao->Sortable || !$Page->sortUrl($Page->acao_contecao)) { ?>
        <th class="<?= $Page->acao_contecao->headerCellClass() ?>"><?= $Page->acao_contecao->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->acao_contecao->headerCellClass() ?>"><div role="button" data-table="item_rel_aud_interna" data-sort="<?= HtmlEncode($Page->acao_contecao->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->acao_contecao->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->acao_contecao->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->acao_contecao->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->abrir_nc->Visible) { // abrir_nc ?>
    <?php if (!$Page->abrir_nc->Sortable || !$Page->sortUrl($Page->abrir_nc)) { ?>
        <th class="<?= $Page->abrir_nc->headerCellClass() ?>"><?= $Page->abrir_nc->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->abrir_nc->headerCellClass() ?>"><div role="button" data-table="item_rel_aud_interna" data-sort="<?= HtmlEncode($Page->abrir_nc->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->abrir_nc->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->abrir_nc->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->abrir_nc->getSortIcon() ?></span>
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
<?php if ($Page->iditem_rel_aud_interna->Visible) { // iditem_rel_aud_interna ?>
        <!-- iditem_rel_aud_interna -->
        <td<?= $Page->iditem_rel_aud_interna->cellAttributes() ?>>
<span<?= $Page->iditem_rel_aud_interna->viewAttributes() ?>>
<?= $Page->iditem_rel_aud_interna->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <!-- processo_idprocesso -->
        <td<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
        <!-- descricao -->
        <td<?= $Page->descricao->cellAttributes() ?>>
<span<?= $Page->descricao->viewAttributes() ?>>
<?= $Page->descricao->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->acao_imediata->Visible) { // acao_imediata ?>
        <!-- acao_imediata -->
        <td<?= $Page->acao_imediata->cellAttributes() ?>>
<span<?= $Page->acao_imediata->viewAttributes() ?>>
<?= $Page->acao_imediata->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->acao_contecao->Visible) { // acao_contecao ?>
        <!-- acao_contecao -->
        <td<?= $Page->acao_contecao->cellAttributes() ?>>
<span<?= $Page->acao_contecao->viewAttributes() ?>>
<?= $Page->acao_contecao->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->abrir_nc->Visible) { // abrir_nc ?>
        <!-- abrir_nc -->
        <td<?= $Page->abrir_nc->cellAttributes() ?>>
<span<?= $Page->abrir_nc->viewAttributes() ?>>
<?= $Page->abrir_nc->getViewValue() ?></span>
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
