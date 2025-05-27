<?php

namespace PHPMaker2024\sgq;

// Page object
$PlanoAcaoNcPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { plano_acao_nc: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
    <?php if (!$Page->o_q_sera_feito->Sortable || !$Page->sortUrl($Page->o_q_sera_feito)) { ?>
        <th class="<?= $Page->o_q_sera_feito->headerCellClass() ?>"><?= $Page->o_q_sera_feito->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->o_q_sera_feito->headerCellClass() ?>"><div role="button" data-table="plano_acao_nc" data-sort="<?= HtmlEncode($Page->o_q_sera_feito->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->o_q_sera_feito->getNextSort() ?>">
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
        <th class="<?= $Page->efeito_esperado->headerCellClass() ?>"><div role="button" data-table="plano_acao_nc" data-sort="<?= HtmlEncode($Page->efeito_esperado->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->efeito_esperado->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->efeito_esperado->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->efeito_esperado->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <?php if (!$Page->usuario_idusuario->Sortable || !$Page->sortUrl($Page->usuario_idusuario)) { ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><?= $Page->usuario_idusuario->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><div role="button" data-table="plano_acao_nc" data-sort="<?= HtmlEncode($Page->usuario_idusuario->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->usuario_idusuario->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->usuario_idusuario->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->usuario_idusuario->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->recursos_nec->Visible) { // recursos_nec ?>
    <?php if (!$Page->recursos_nec->Sortable || !$Page->sortUrl($Page->recursos_nec)) { ?>
        <th class="<?= $Page->recursos_nec->headerCellClass() ?>"><?= $Page->recursos_nec->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->recursos_nec->headerCellClass() ?>"><div role="button" data-table="plano_acao_nc" data-sort="<?= HtmlEncode($Page->recursos_nec->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->recursos_nec->getNextSort() ?>">
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
        <th class="<?= $Page->dt_limite->headerCellClass() ?>"><div role="button" data-table="plano_acao_nc" data-sort="<?= HtmlEncode($Page->dt_limite->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->dt_limite->getNextSort() ?>">
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
        <th class="<?= $Page->implementado->headerCellClass() ?>"><div role="button" data-table="plano_acao_nc" data-sort="<?= HtmlEncode($Page->implementado->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->implementado->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->implementado->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->implementado->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->eficaz->Visible) { // eficaz ?>
    <?php if (!$Page->eficaz->Sortable || !$Page->sortUrl($Page->eficaz)) { ?>
        <th class="<?= $Page->eficaz->headerCellClass() ?>"><?= $Page->eficaz->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->eficaz->headerCellClass() ?>"><div role="button" data-table="plano_acao_nc" data-sort="<?= HtmlEncode($Page->eficaz->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->eficaz->getNextSort() ?>">
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
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <!-- usuario_idusuario -->
        <td<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
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
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <!-- usuario_idusuario -->
        <td class="<?= $Page->usuario_idusuario->footerCellClass() ?>">
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
