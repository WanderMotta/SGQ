<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseCriticaDirecaoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_critica_direcao: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fanalise_critica_direcaodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fanalise_critica_direcaodelete")
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
<form name="fanalise_critica_direcaodelete" id="fanalise_critica_direcaodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="analise_critica_direcao">
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
<?php if ($Page->idanalise_critica_direcao->Visible) { // idanalise_critica_direcao ?>
        <th class="<?= $Page->idanalise_critica_direcao->headerCellClass() ?>"><span id="elh_analise_critica_direcao_idanalise_critica_direcao" class="analise_critica_direcao_idanalise_critica_direcao"><?= $Page->idanalise_critica_direcao->caption() ?></span></th>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
        <th class="<?= $Page->data->headerCellClass() ?>"><span id="elh_analise_critica_direcao_data" class="analise_critica_direcao_data"><?= $Page->data->caption() ?></span></th>
<?php } ?>
<?php if ($Page->participantes->Visible) { // participantes ?>
        <th class="<?= $Page->participantes->headerCellClass() ?>"><span id="elh_analise_critica_direcao_participantes" class="analise_critica_direcao_participantes"><?= $Page->participantes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <th class="<?= $Page->usuario_idusuario->headerCellClass() ?>"><span id="elh_analise_critica_direcao_usuario_idusuario" class="analise_critica_direcao_usuario_idusuario"><?= $Page->usuario_idusuario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->situacao_anterior->Visible) { // situacao_anterior ?>
        <th class="<?= $Page->situacao_anterior->headerCellClass() ?>"><span id="elh_analise_critica_direcao_situacao_anterior" class="analise_critica_direcao_situacao_anterior"><?= $Page->situacao_anterior->caption() ?></span></th>
<?php } ?>
<?php if ($Page->oportunidade_melhora_saida->Visible) { // oportunidade_melhora_saida ?>
        <th class="<?= $Page->oportunidade_melhora_saida->headerCellClass() ?>"><span id="elh_analise_critica_direcao_oportunidade_melhora_saida" class="analise_critica_direcao_oportunidade_melhora_saida"><?= $Page->oportunidade_melhora_saida->caption() ?></span></th>
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
<?php if ($Page->idanalise_critica_direcao->Visible) { // idanalise_critica_direcao ?>
        <td<?= $Page->idanalise_critica_direcao->cellAttributes() ?>>
<span id="">
<span<?= $Page->idanalise_critica_direcao->viewAttributes() ?>>
<?= $Page->idanalise_critica_direcao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->data->Visible) { // data ?>
        <td<?= $Page->data->cellAttributes() ?>>
<span id="">
<span<?= $Page->data->viewAttributes() ?>>
<?= $Page->data->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->participantes->Visible) { // participantes ?>
        <td<?= $Page->participantes->cellAttributes() ?>>
<span id="">
<span<?= $Page->participantes->viewAttributes() ?>>
<?= $Page->participantes->getViewValue() ?></span>
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
<?php if ($Page->situacao_anterior->Visible) { // situacao_anterior ?>
        <td<?= $Page->situacao_anterior->cellAttributes() ?>>
<span id="">
<span<?= $Page->situacao_anterior->viewAttributes() ?>>
<?= $Page->situacao_anterior->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->oportunidade_melhora_saida->Visible) { // oportunidade_melhora_saida ?>
        <td<?= $Page->oportunidade_melhora_saida->cellAttributes() ?>>
<span id="">
<span<?= $Page->oportunidade_melhora_saida->viewAttributes() ?>>
<?= $Page->oportunidade_melhora_saida->getViewValue() ?></span>
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
