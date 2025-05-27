<?php

namespace PHPMaker2024\sgq;

// Page object
$DocumentoExternoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { documento_externo: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fdocumento_externodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdocumento_externodelete")
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
<form name="fdocumento_externodelete" id="fdocumento_externodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="documento_externo">
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
<?php if ($Page->iddocumento_externo->Visible) { // iddocumento_externo ?>
        <th class="<?= $Page->iddocumento_externo->headerCellClass() ?>"><span id="elh_documento_externo_iddocumento_externo" class="documento_externo_iddocumento_externo"><?= $Page->iddocumento_externo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <th class="<?= $Page->dt_cadastro->headerCellClass() ?>"><span id="elh_documento_externo_dt_cadastro" class="documento_externo_dt_cadastro"><?= $Page->dt_cadastro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
        <th class="<?= $Page->titulo_documento->headerCellClass() ?>"><span id="elh_documento_externo_titulo_documento" class="documento_externo_titulo_documento"><?= $Page->titulo_documento->caption() ?></span></th>
<?php } ?>
<?php if ($Page->distribuicao->Visible) { // distribuicao ?>
        <th class="<?= $Page->distribuicao->headerCellClass() ?>"><span id="elh_documento_externo_distribuicao" class="documento_externo_distribuicao"><?= $Page->distribuicao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tem_validade->Visible) { // tem_validade ?>
        <th class="<?= $Page->tem_validade->headerCellClass() ?>"><span id="elh_documento_externo_tem_validade" class="documento_externo_tem_validade"><?= $Page->tem_validade->caption() ?></span></th>
<?php } ?>
<?php if ($Page->valido_ate->Visible) { // valido_ate ?>
        <th class="<?= $Page->valido_ate->headerCellClass() ?>"><span id="elh_documento_externo_valido_ate" class="documento_externo_valido_ate"><?= $Page->valido_ate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
        <th class="<?= $Page->restringir_acesso->headerCellClass() ?>"><span id="elh_documento_externo_restringir_acesso" class="documento_externo_restringir_acesso"><?= $Page->restringir_acesso->caption() ?></span></th>
<?php } ?>
<?php if ($Page->localizacao_idlocalizacao->Visible) { // localizacao_idlocalizacao ?>
        <th class="<?= $Page->localizacao_idlocalizacao->headerCellClass() ?>"><span id="elh_documento_externo_localizacao_idlocalizacao" class="documento_externo_localizacao_idlocalizacao"><?= $Page->localizacao_idlocalizacao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_responsavel->Visible) { // usuario_responsavel ?>
        <th class="<?= $Page->usuario_responsavel->headerCellClass() ?>"><span id="elh_documento_externo_usuario_responsavel" class="documento_externo_usuario_responsavel"><?= $Page->usuario_responsavel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
        <th class="<?= $Page->anexo->headerCellClass() ?>"><span id="elh_documento_externo_anexo" class="documento_externo_anexo"><?= $Page->anexo->caption() ?></span></th>
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
<?php if ($Page->iddocumento_externo->Visible) { // iddocumento_externo ?>
        <td<?= $Page->iddocumento_externo->cellAttributes() ?>>
<span id="">
<span<?= $Page->iddocumento_externo->viewAttributes() ?>>
<?= $Page->iddocumento_externo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dt_cadastro->Visible) { // dt_cadastro ?>
        <td<?= $Page->dt_cadastro->cellAttributes() ?>>
<span id="">
<span<?= $Page->dt_cadastro->viewAttributes() ?>>
<?= $Page->dt_cadastro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->titulo_documento->Visible) { // titulo_documento ?>
        <td<?= $Page->titulo_documento->cellAttributes() ?>>
<span id="">
<span<?= $Page->titulo_documento->viewAttributes() ?>>
<?= $Page->titulo_documento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->distribuicao->Visible) { // distribuicao ?>
        <td<?= $Page->distribuicao->cellAttributes() ?>>
<span id="">
<span<?= $Page->distribuicao->viewAttributes() ?>>
<?= $Page->distribuicao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tem_validade->Visible) { // tem_validade ?>
        <td<?= $Page->tem_validade->cellAttributes() ?>>
<span id="">
<span<?= $Page->tem_validade->viewAttributes() ?>>
<?= $Page->tem_validade->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->valido_ate->Visible) { // valido_ate ?>
        <td<?= $Page->valido_ate->cellAttributes() ?>>
<span id="">
<span<?= $Page->valido_ate->viewAttributes() ?>>
<?= $Page->valido_ate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->restringir_acesso->Visible) { // restringir_acesso ?>
        <td<?= $Page->restringir_acesso->cellAttributes() ?>>
<span id="">
<span<?= $Page->restringir_acesso->viewAttributes() ?>>
<?= $Page->restringir_acesso->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->localizacao_idlocalizacao->Visible) { // localizacao_idlocalizacao ?>
        <td<?= $Page->localizacao_idlocalizacao->cellAttributes() ?>>
<span id="">
<span<?= $Page->localizacao_idlocalizacao->viewAttributes() ?>>
<?= $Page->localizacao_idlocalizacao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuario_responsavel->Visible) { // usuario_responsavel ?>
        <td<?= $Page->usuario_responsavel->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuario_responsavel->viewAttributes() ?>>
<?= $Page->usuario_responsavel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->anexo->Visible) { // anexo ?>
        <td<?= $Page->anexo->cellAttributes() ?>>
<span id="">
<span<?= $Page->anexo->viewAttributes() ?>>
<?= GetFileViewTag($Page->anexo, $Page->anexo->getViewValue(), false) ?>
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
