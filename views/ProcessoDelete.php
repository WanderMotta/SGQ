<?php

namespace PHPMaker2024\sgq;

// Page object
$ProcessoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { processo: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fprocessodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fprocessodelete")
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
<form name="fprocessodelete" id="fprocessodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="processo">
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
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th class="<?= $Page->dt_cadastro->headerCellClass() ?>"><span id="elh_processo_dt_cadastro" class="processo_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->revisao->Visible) { // revisao ?>
        <th class="<?= $Page->revisao->headerCellClass() ?>"><span id="elh_processo_revisao" class="processo_revisao"><?= $Page->revisao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_idtipo->Visible) { // tipo_idtipo ?>
        <th class="<?= $Page->tipo_idtipo->headerCellClass() ?>"><span id="elh_processo_tipo_idtipo" class="processo_tipo_idtipo"><?= $Page->tipo_idtipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->processo->Visible) { // processo ?>
        <th class="<?= $Page->processo->headerCellClass() ?>"><span id="elh_processo_processo" class="processo_processo"><?= $Page->processo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->responsaveis->Visible) { // responsaveis ?>
        <th class="<?= $Page->responsaveis->headerCellClass() ?>"><span id="elh_processo_responsaveis" class="processo_responsaveis"><?= $Page->responsaveis->caption() ?></span></th>
<?php } ?>
<?php if ($Page->entradas->Visible) { // entradas ?>
        <th class="<?= $Page->entradas->headerCellClass() ?>"><span id="elh_processo_entradas" class="processo_entradas"><?= $Page->entradas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->atividade_principal->Visible) { // atividade_principal ?>
        <th class="<?= $Page->atividade_principal->headerCellClass() ?>"><span id="elh_processo_atividade_principal" class="processo_atividade_principal"><?= $Page->atividade_principal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->saidas_resultados->Visible) { // saidas_resultados ?>
        <th class="<?= $Page->saidas_resultados->headerCellClass() ?>"><span id="elh_processo_saidas_resultados" class="processo_saidas_resultados"><?= $Page->saidas_resultados->caption() ?></span></th>
<?php } ?>
<?php if ($Page->formulario->Visible) { // formulario ?>
        <th class="<?= $Page->formulario->headerCellClass() ?>"><span id="elh_processo_formulario" class="processo_formulario"><?= $Page->formulario->caption() ?></span></th>
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
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->revisao->Visible) { // revisao ?>
        <td<?= $Page->revisao->cellAttributes() ?>>
<span id="">
<span<?= $Page->revisao->viewAttributes() ?>>
<?= $Page->revisao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_idtipo->Visible) { // tipo_idtipo ?>
        <td<?= $Page->tipo_idtipo->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_idtipo->viewAttributes() ?>>
<?= $Page->tipo_idtipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->processo->Visible) { // processo ?>
        <td<?= $Page->processo->cellAttributes() ?>>
<span id="">
<span<?= $Page->processo->viewAttributes() ?>>
<?= $Page->processo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->responsaveis->Visible) { // responsaveis ?>
        <td<?= $Page->responsaveis->cellAttributes() ?>>
<span id="">
<span<?= $Page->responsaveis->viewAttributes() ?>>
<?= $Page->responsaveis->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->entradas->Visible) { // entradas ?>
        <td<?= $Page->entradas->cellAttributes() ?>>
<span id="">
<span<?= $Page->entradas->viewAttributes() ?>>
<?= $Page->entradas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->atividade_principal->Visible) { // atividade_principal ?>
        <td<?= $Page->atividade_principal->cellAttributes() ?>>
<span id="">
<span<?= $Page->atividade_principal->viewAttributes() ?>>
<?= $Page->atividade_principal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->saidas_resultados->Visible) { // saidas_resultados ?>
        <td<?= $Page->saidas_resultados->cellAttributes() ?>>
<span id="">
<span<?= $Page->saidas_resultados->viewAttributes() ?>>
<?= $Page->saidas_resultados->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->formulario->Visible) { // formulario ?>
        <td<?= $Page->formulario->cellAttributes() ?>>
<span id="">
<span<?= $Page->formulario->viewAttributes() ?>>
<?= GetFileViewTag($Page->formulario, $Page->formulario->getViewValue(), false) ?>
</span>
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
