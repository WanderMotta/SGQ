<?php

namespace PHPMaker2024\sgq;

// Page object
$NaoConformidadeDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { nao_conformidade: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fnao_conformidadedelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fnao_conformidadedelete")
        .setPageId("delete")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnao_conformidadedelete" id="fnao_conformidadedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="nao_conformidade">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->idnao_conformidade->Visible) { // idnao_conformidade ?>
        <th class="<?= $Page->idnao_conformidade->headerCellClass() ?>"><span id="elh_nao_conformidade_idnao_conformidade" class="nao_conformidade_idnao_conformidade"><?= $Page->idnao_conformidade->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dt_ocorrencia->Visible) { // dt_ocorrencia ?>
        <th class="<?= $Page->dt_ocorrencia->headerCellClass() ?>"><span id="elh_nao_conformidade_dt_ocorrencia" class="nao_conformidade_dt_ocorrencia"><?= $Page->dt_ocorrencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
        <th class="<?= $Page->titulo->headerCellClass() ?>"><span id="elh_nao_conformidade_titulo" class="nao_conformidade_titulo"><?= $Page->titulo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <th class="<?= $Page->processo_idprocesso->headerCellClass() ?>"><span id="elh_nao_conformidade_processo_idprocesso" class="nao_conformidade_processo_idprocesso"><?= $Page->processo_idprocesso->caption() ?></span></th>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <th class="<?= $Page->departamentos_iddepartamentos->headerCellClass() ?>"><span id="elh_nao_conformidade_departamentos_iddepartamentos" class="nao_conformidade_departamentos_iddepartamentos"><?= $Page->departamentos_iddepartamentos->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_nc->Visible) { // status_nc ?>
        <th class="<?= $Page->status_nc->headerCellClass() ?>"><span id="elh_nao_conformidade_status_nc" class="nao_conformidade_status_nc"><?= $Page->status_nc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { // plano_acao ?>
        <th class="<?= $Page->plano_acao->headerCellClass() ?>"><span id="elh_nao_conformidade_plano_acao" class="nao_conformidade_plano_acao"><?= $Page->plano_acao->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->idnao_conformidade->Visible) { // idnao_conformidade ?>
        <td<?= $Page->idnao_conformidade->cellAttributes() ?>>
<span id="">
<span<?= $Page->idnao_conformidade->viewAttributes() ?>>
<?= $Page->idnao_conformidade->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dt_ocorrencia->Visible) { // dt_ocorrencia ?>
        <td<?= $Page->dt_ocorrencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->dt_ocorrencia->viewAttributes() ?>>
<?= $Page->dt_ocorrencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
        <td<?= $Page->titulo->cellAttributes() ?>>
<span id="">
<span<?= $Page->titulo->viewAttributes() ?>>
<?= $Page->titulo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <td<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="">
<span<?= $Page->processo_idprocesso->viewAttributes() ?>>
<?= $Page->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <td<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="">
<span<?= $Page->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $Page->departamentos_iddepartamentos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_nc->Visible) { // status_nc ?>
        <td<?= $Page->status_nc->cellAttributes() ?>>
<span id="">
<span<?= $Page->status_nc->viewAttributes() ?>>
<?= $Page->status_nc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->plano_acao->Visible) { // plano_acao ?>
        <td<?= $Page->plano_acao->cellAttributes() ?>>
<span id="">
<span<?= $Page->plano_acao->viewAttributes() ?>>
<?= $Page->plano_acao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
