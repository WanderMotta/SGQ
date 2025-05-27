<?php

namespace PHPMaker2024\sgq;

// Page object
$GestaoMudancaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { gestao_mudanca: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fgestao_mudancadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fgestao_mudancadelete")
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
<form name="fgestao_mudancadelete" id="fgestao_mudancadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="gestao_mudanca">
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
<?php if ($Page->titulo->Visible) { // titulo ?>
        <th class="<?= $Page->titulo->headerCellClass() ?>"><span id="elh_gestao_mudanca_titulo" class="gestao_mudanca_titulo"><?= $Page->titulo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->detalhamento->Visible) { // detalhamento ?>
        <th class="<?= $Page->detalhamento->headerCellClass() ?>"><span id="elh_gestao_mudanca_detalhamento" class="gestao_mudanca_detalhamento"><?= $Page->detalhamento->caption() ?></span></th>
<?php } ?>
<?php if ($Page->prazo_ate->Visible) { // prazo_ate ?>
        <th class="<?= $Page->prazo_ate->headerCellClass() ?>"><span id="elh_gestao_mudanca_prazo_ate" class="gestao_mudanca_prazo_ate"><?= $Page->prazo_ate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <th class="<?= $Page->departamentos_iddepartamentos->headerCellClass() ?>"><span id="elh_gestao_mudanca_departamentos_iddepartamentos" class="gestao_mudanca_departamentos_iddepartamentos"><?= $Page->departamentos_iddepartamentos->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><span id="elh_gestao_mudanca_usuario_idusuario" class="gestao_mudanca_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
        <th class="<?= $Page->implementado->headerCellClass() ?>"><span id="elh_gestao_mudanca_implementado" class="gestao_mudanca_implementado"><?= $Page->implementado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_gestao_mudanca_status" class="gestao_mudanca_status"><?= $Page->status->caption() ?></span></th>
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
<?php if ($Page->titulo->Visible) { // titulo ?>
        <td<?= $Page->titulo->cellAttributes() ?>>
<span id="">
<span<?= $Page->titulo->viewAttributes() ?>>
<?= $Page->titulo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->detalhamento->Visible) { // detalhamento ?>
        <td<?= $Page->detalhamento->cellAttributes() ?>>
<span id="">
<span<?= $Page->detalhamento->viewAttributes() ?>>
<?= $Page->detalhamento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->prazo_ate->Visible) { // prazo_ate ?>
        <td<?= $Page->prazo_ate->cellAttributes() ?>>
<span id="">
<span<?= $Page->prazo_ate->viewAttributes() ?>>
<?= $Page->prazo_ate->getViewValue() ?></span>
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
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <td<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuario_idusuario->viewAttributes() ?>>
<?= $Page->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->implementado->Visible) { // implementado ?>
        <td<?= $Page->implementado->cellAttributes() ?>>
<span id="">
<span<?= $Page->implementado->viewAttributes() ?>>
<?= $Page->implementado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
