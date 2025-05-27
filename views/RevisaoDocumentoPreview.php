<?php

namespace PHPMaker2024\sgq;

// Page object
$RevisaoDocumentoPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { revisao_documento: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
    <?php if (!$Page->dt_cadastro->Sortable || !$Page->sortUrl($Page->dt_cadastro)) { ?>
        <th class="<?= $Page->dt_cadastro->headerCellClass() ?>"><?= $Page->dt_cadastro->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->dt_cadastro->headerCellClass() ?>"><div role="button" data-table="revisao_documento" data-sort="<?= HtmlEncode($Page->dt_cadastro->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->dt_cadastro->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->dt_cadastro->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->dt_cadastro->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->qual_alteracao->Visible) { // qual_alteracao ?>
    <?php if (!$Page->qual_alteracao->Sortable || !$Page->sortUrl($Page->qual_alteracao)) { ?>
        <th class="<?= $Page->qual_alteracao->headerCellClass() ?>"><?= $Page->qual_alteracao->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->qual_alteracao->headerCellClass() ?>"><div role="button" data-table="revisao_documento" data-sort="<?= HtmlEncode($Page->qual_alteracao->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->qual_alteracao->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->qual_alteracao->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->qual_alteracao->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
    <?php if (!$Page->status_documento_idstatus_documento->Sortable || !$Page->sortUrl($Page->status_documento_idstatus_documento)) { ?>
        <th class="<?= $Page->status_documento_idstatus_documento->headerCellClass() ?>"><?= $Page->status_documento_idstatus_documento->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status_documento_idstatus_documento->headerCellClass() ?>"><div role="button" data-table="revisao_documento" data-sort="<?= HtmlEncode($Page->status_documento_idstatus_documento->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->status_documento_idstatus_documento->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->status_documento_idstatus_documento->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->status_documento_idstatus_documento->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->revisao_nr->Visible) { // revisao_nr ?>
    <?php if (!$Page->revisao_nr->Sortable || !$Page->sortUrl($Page->revisao_nr)) { ?>
        <th class="<?= $Page->revisao_nr->headerCellClass() ?>"><?= $Page->revisao_nr->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->revisao_nr->headerCellClass() ?>"><div role="button" data-table="revisao_documento" data-sort="<?= HtmlEncode($Page->revisao_nr->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->revisao_nr->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->revisao_nr->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->revisao_nr->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->usuario_elaborador->Visible) { // usuario_elaborador ?>
    <?php if (!$Page->usuario_elaborador->Sortable || !$Page->sortUrl($Page->usuario_elaborador)) { ?>
        <th class="<?= $Page->usuario_elaborador->headerCellClass() ?>"><?= $Page->usuario_elaborador->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->usuario_elaborador->headerCellClass() ?>"><div role="button" data-table="revisao_documento" data-sort="<?= HtmlEncode($Page->usuario_elaborador->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->usuario_elaborador->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->usuario_elaborador->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->usuario_elaborador->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->usuario_aprovador->Visible) { // usuario_aprovador ?>
    <?php if (!$Page->usuario_aprovador->Sortable || !$Page->sortUrl($Page->usuario_aprovador)) { ?>
        <th class="<?= $Page->usuario_aprovador->headerCellClass() ?>"><?= $Page->usuario_aprovador->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->usuario_aprovador->headerCellClass() ?>"><div role="button" data-table="revisao_documento" data-sort="<?= HtmlEncode($Page->usuario_aprovador->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->usuario_aprovador->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->usuario_aprovador->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->usuario_aprovador->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dt_aprovacao->Visible) { // dt_aprovacao ?>
    <?php if (!$Page->dt_aprovacao->Sortable || !$Page->sortUrl($Page->dt_aprovacao)) { ?>
        <th class="<?= $Page->dt_aprovacao->headerCellClass() ?>"><?= $Page->dt_aprovacao->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->dt_aprovacao->headerCellClass() ?>"><div role="button" data-table="revisao_documento" data-sort="<?= HtmlEncode($Page->dt_aprovacao->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->dt_aprovacao->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->dt_aprovacao->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->dt_aprovacao->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
    <?php if (!$Page->anexo->Sortable || !$Page->sortUrl($Page->anexo)) { ?>
        <th class="<?= $Page->anexo->headerCellClass() ?>"><?= $Page->anexo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->anexo->headerCellClass() ?>"><div role="button" data-table="revisao_documento" data-sort="<?= HtmlEncode($Page->anexo->Name) ?>" data-sort-type="2" data-sort-order="<?= $Page->anexo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->anexo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->anexo->getSortIcon() ?></span>
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
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <!-- dt_cadastro -->
        <td<?= $Page->dt_cadastro->cellAttributes() ?>>
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->qual_alteracao->Visible) { // qual_alteracao ?>
        <!-- qual_alteracao -->
        <td<?= $Page->qual_alteracao->cellAttributes() ?>>
<span<?= $Page->qual_alteracao->viewAttributes() ?>>
<?= $Page->qual_alteracao->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
        <!-- status_documento_idstatus_documento -->
        <td<?= $Page->status_documento_idstatus_documento->cellAttributes() ?>>
<span<?= $Page->status_documento_idstatus_documento->viewAttributes() ?>>
<?= $Page->status_documento_idstatus_documento->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->revisao_nr->Visible) { // revisao_nr ?>
        <!-- revisao_nr -->
        <td<?= $Page->revisao_nr->cellAttributes() ?>>
<span<?= $Page->revisao_nr->viewAttributes() ?>>
<?= $Page->revisao_nr->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->usuario_elaborador->Visible) { // usuario_elaborador ?>
        <!-- usuario_elaborador -->
        <td<?= $Page->usuario_elaborador->cellAttributes() ?>>
<span<?= $Page->usuario_elaborador->viewAttributes() ?>>
<?= $Page->usuario_elaborador->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->usuario_aprovador->Visible) { // usuario_aprovador ?>
        <!-- usuario_aprovador -->
        <td<?= $Page->usuario_aprovador->cellAttributes() ?>>
<span<?= $Page->usuario_aprovador->viewAttributes() ?>>
<?= $Page->usuario_aprovador->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dt_aprovacao->Visible) { // dt_aprovacao ?>
        <!-- dt_aprovacao -->
        <td<?= $Page->dt_aprovacao->cellAttributes() ?>>
<span<?= $Page->dt_aprovacao->viewAttributes() ?>>
<?= $Page->dt_aprovacao->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
        <!-- anexo -->
        <td<?= $Page->anexo->cellAttributes() ?>>
<span<?= $Page->anexo->viewAttributes() ?>>
<?= GetFileViewTag($Page->anexo, $Page->anexo->getViewValue(), false) ?>
</span>
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
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <!-- dt_cadastro -->
        <td class="<?= $Page->dt_cadastro->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->qual_alteracao->Visible) { // qual_alteracao ?>
        <!-- qual_alteracao -->
        <td class="<?= $Page->qual_alteracao->footerCellClass() ?>">
        <span class="ew-aggregate"><?= $Language->phrase("COUNT") ?></span><span class="ew-aggregate-value">
        <?= $Page->qual_alteracao->ViewValue ?></span>
        </td>
<?php } ?>
<?php if ($Page->status_documento_idstatus_documento->Visible) { // status_documento_idstatus_documento ?>
        <!-- status_documento_idstatus_documento -->
        <td class="<?= $Page->status_documento_idstatus_documento->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->revisao_nr->Visible) { // revisao_nr ?>
        <!-- revisao_nr -->
        <td class="<?= $Page->revisao_nr->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->usuario_elaborador->Visible) { // usuario_elaborador ?>
        <!-- usuario_elaborador -->
        <td class="<?= $Page->usuario_elaborador->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->usuario_aprovador->Visible) { // usuario_aprovador ?>
        <!-- usuario_aprovador -->
        <td class="<?= $Page->usuario_aprovador->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->dt_aprovacao->Visible) { // dt_aprovacao ?>
        <!-- dt_aprovacao -->
        <td class="<?= $Page->dt_aprovacao->footerCellClass() ?>">
        &nbsp;
        </td>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
        <!-- anexo -->
        <td class="<?= $Page->anexo->footerCellClass() ?>">
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
