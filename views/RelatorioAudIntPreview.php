<?php

namespace PHPMaker2024\sgq;

// Page object
$RelatorioAudIntPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { relatorio_aud_int: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->plano_auditoria_int_idplano_auditoria_int->Visible) { // plano_auditoria_int_idplano_auditoria_int ?>
    <?php if (!$Page->plano_auditoria_int_idplano_auditoria_int->Sortable || !$Page->sortUrl($Page->plano_auditoria_int_idplano_auditoria_int)) { ?>
        <th class="<?= $Page->plano_auditoria_int_idplano_auditoria_int->headerCellClass() ?>"><?= $Page->plano_auditoria_int_idplano_auditoria_int->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->plano_auditoria_int_idplano_auditoria_int->headerCellClass() ?>"><div role="button" data-table="relatorio_aud_int" data-sort="<?= HtmlEncode($Page->plano_auditoria_int_idplano_auditoria_int->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->plano_auditoria_int_idplano_auditoria_int->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->plano_auditoria_int_idplano_auditoria_int->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->plano_auditoria_int_idplano_auditoria_int->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->item_plano_aud_int_iditem_plano_aud_int->Visible) { // item_plano_aud_int_iditem_plano_aud_int ?>
    <?php if (!$Page->item_plano_aud_int_iditem_plano_aud_int->Sortable || !$Page->sortUrl($Page->item_plano_aud_int_iditem_plano_aud_int)) { ?>
        <th class="<?= $Page->item_plano_aud_int_iditem_plano_aud_int->headerCellClass() ?>"><?= $Page->item_plano_aud_int_iditem_plano_aud_int->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->item_plano_aud_int_iditem_plano_aud_int->headerCellClass() ?>"><div role="button" data-table="relatorio_aud_int" data-sort="<?= HtmlEncode($Page->item_plano_aud_int_iditem_plano_aud_int->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->item_plano_aud_int_iditem_plano_aud_int->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->item_plano_aud_int_iditem_plano_aud_int->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->item_plano_aud_int_iditem_plano_aud_int->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->metodo->Visible) { // metodo ?>
    <?php if (!$Page->metodo->Sortable || !$Page->sortUrl($Page->metodo)) { ?>
        <th class="<?= $Page->metodo->headerCellClass() ?>"><?= $Page->metodo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->metodo->headerCellClass() ?>"><div role="button" data-table="relatorio_aud_int" data-sort="<?= HtmlEncode($Page->metodo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->metodo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->metodo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->metodo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
    <?php if (!$Page->descricao->Sortable || !$Page->sortUrl($Page->descricao)) { ?>
        <th class="<?= $Page->descricao->headerCellClass() ?>"><?= $Page->descricao->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->descricao->headerCellClass() ?>"><div role="button" data-table="relatorio_aud_int" data-sort="<?= HtmlEncode($Page->descricao->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->descricao->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->descricao->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->descricao->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->evidencia->Visible) { // evidencia ?>
    <?php if (!$Page->evidencia->Sortable || !$Page->sortUrl($Page->evidencia)) { ?>
        <th class="<?= $Page->evidencia->headerCellClass() ?>"><?= $Page->evidencia->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->evidencia->headerCellClass() ?>"><div role="button" data-table="relatorio_aud_int" data-sort="<?= HtmlEncode($Page->evidencia->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->evidencia->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->evidencia->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->evidencia->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nao_conformidade->Visible) { // nao_conformidade ?>
    <?php if (!$Page->nao_conformidade->Sortable || !$Page->sortUrl($Page->nao_conformidade)) { ?>
        <th class="<?= $Page->nao_conformidade->headerCellClass() ?>"><?= $Page->nao_conformidade->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nao_conformidade->headerCellClass() ?>"><div role="button" data-table="relatorio_aud_int" data-sort="<?= HtmlEncode($Page->nao_conformidade->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->nao_conformidade->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nao_conformidade->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nao_conformidade->getSortIcon() ?></span>
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
<?php if ($Page->plano_auditoria_int_idplano_auditoria_int->Visible) { // plano_auditoria_int_idplano_auditoria_int ?>
        <!-- plano_auditoria_int_idplano_auditoria_int -->
        <td<?= $Page->plano_auditoria_int_idplano_auditoria_int->cellAttributes() ?>>
<span<?= $Page->plano_auditoria_int_idplano_auditoria_int->viewAttributes() ?>>
<?= $Page->plano_auditoria_int_idplano_auditoria_int->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->item_plano_aud_int_iditem_plano_aud_int->Visible) { // item_plano_aud_int_iditem_plano_aud_int ?>
        <!-- item_plano_aud_int_iditem_plano_aud_int -->
        <td<?= $Page->item_plano_aud_int_iditem_plano_aud_int->cellAttributes() ?>>
<span<?= $Page->item_plano_aud_int_iditem_plano_aud_int->viewAttributes() ?>>
<?= $Page->item_plano_aud_int_iditem_plano_aud_int->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->metodo->Visible) { // metodo ?>
        <!-- metodo -->
        <td<?= $Page->metodo->cellAttributes() ?>>
<span<?= $Page->metodo->viewAttributes() ?>>
<?= $Page->metodo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
        <!-- descricao -->
        <td<?= $Page->descricao->cellAttributes() ?>>
<span<?= $Page->descricao->viewAttributes() ?>>
<?= $Page->descricao->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->evidencia->Visible) { // evidencia ?>
        <!-- evidencia -->
        <td<?= $Page->evidencia->cellAttributes() ?>>
<span<?= $Page->evidencia->viewAttributes() ?>>
<?= $Page->evidencia->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nao_conformidade->Visible) { // nao_conformidade ?>
        <!-- nao_conformidade -->
        <td<?= $Page->nao_conformidade->cellAttributes() ?>>
<span<?= $Page->nao_conformidade->viewAttributes() ?>>
<?= $Page->nao_conformidade->getViewValue() ?></span>
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
<?php if ($Page->plano_auditoria_int_idplano_auditoria_int->Visible) { // plano_auditoria_int_idplano_auditoria_int ?>
        <!-- plano_auditoria_int_idplano_auditoria_int -->
        <td class="<?= $Page->plano_auditoria_int_idplano_auditoria_int->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->item_plano_aud_int_iditem_plano_aud_int->Visible) { // item_plano_aud_int_iditem_plano_aud_int ?>
        <!-- item_plano_aud_int_iditem_plano_aud_int -->
        <td class="<?= $Page->item_plano_aud_int_iditem_plano_aud_int->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->metodo->Visible) { // metodo ?>
        <!-- metodo -->
        <td class="<?= $Page->metodo->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
        <!-- descricao -->
        <td class="<?= $Page->descricao->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->descricao->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->evidencia->Visible) { // evidencia ?>
        <!-- evidencia -->
        <td class="<?= $Page->evidencia->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->nao_conformidade->Visible) { // nao_conformidade ?>
        <!-- nao_conformidade -->
        <td class="<?= $Page->nao_conformidade->footerCellClass() ?>">
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
