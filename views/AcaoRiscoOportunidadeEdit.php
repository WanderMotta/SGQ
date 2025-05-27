<?php

namespace PHPMaker2024\sgq;

// Page object
$AcaoRiscoOportunidadeEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="facao_risco_oportunidadeedit" id="facao_risco_oportunidadeedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { acao_risco_oportunidade: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var facao_risco_oportunidadeedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("facao_risco_oportunidadeedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idacao_risco_oportunidade", [fields.idacao_risco_oportunidade.visible && fields.idacao_risco_oportunidade.required ? ew.Validators.required(fields.idacao_risco_oportunidade.caption) : null], fields.idacao_risco_oportunidade.isInvalid],
            ["tipo_risco_oportunidade_idtipo_risco_oportunidade", [fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.visible && fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.required ? ew.Validators.required(fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.caption) : null], fields.tipo_risco_oportunidade_idtipo_risco_oportunidade.isInvalid],
            ["acao", [fields.acao.visible && fields.acao.required ? ew.Validators.required(fields.acao.caption) : null], fields.acao.isInvalid],
            ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "tipo_risco_oportunidade_idtipo_risco_oportunidade": <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->toClientList($Page) ?>,
        })
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="acao_risco_oportunidade">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idacao_risco_oportunidade->Visible) { // idacao_risco_oportunidade ?>
    <div id="r_idacao_risco_oportunidade"<?= $Page->idacao_risco_oportunidade->rowAttributes() ?>>
        <label id="elh_acao_risco_oportunidade_idacao_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idacao_risco_oportunidade->caption() ?><?= $Page->idacao_risco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idacao_risco_oportunidade->cellAttributes() ?>>
<span id="el_acao_risco_oportunidade_idacao_risco_oportunidade">
<span<?= $Page->idacao_risco_oportunidade->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idacao_risco_oportunidade->getDisplayValue($Page->idacao_risco_oportunidade->EditValue))) ?>"></span>
<input type="hidden" data-table="acao_risco_oportunidade" data-field="x_idacao_risco_oportunidade" data-hidden="1" name="x_idacao_risco_oportunidade" id="x_idacao_risco_oportunidade" value="<?= HtmlEncode($Page->idacao_risco_oportunidade->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
    <div id="r_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->rowAttributes() ?>>
        <label id="elh_acao_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() ?><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
<span id="el_acao_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade">
<template id="tp_x_tipo_risco_oportunidade_idtipo_risco_oportunidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="acao_risco_oportunidade" data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" name="x_tipo_risco_oportunidade_idtipo_risco_oportunidade" id="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="ew-item-list"></div>
<selection-list hidden
    id="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    name="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    value="<?= HtmlEncode($Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-target="dsl_x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->isInvalidClass() ?>"
    data-table="acao_risco_oportunidade"
    data-field="x_tipo_risco_oportunidade_idtipo_risco_oportunidade"
    data-value-separator="<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->editAttributes() ?>></selection-list>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->getErrorMessage() ?></div>
<?= $Page->tipo_risco_oportunidade_idtipo_risco_oportunidade->Lookup->getParamTag($Page, "p_x_tipo_risco_oportunidade_idtipo_risco_oportunidade") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->acao->Visible) { // acao ?>
    <div id="r_acao"<?= $Page->acao->rowAttributes() ?>>
        <label id="elh_acao_risco_oportunidade_acao" for="x_acao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->acao->caption() ?><?= $Page->acao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->acao->cellAttributes() ?>>
<span id="el_acao_risco_oportunidade_acao">
<input type="<?= $Page->acao->getInputTextType() ?>" name="x_acao" id="x_acao" data-table="acao_risco_oportunidade" data-field="x_acao" value="<?= $Page->acao->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->acao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->acao->formatPattern()) ?>"<?= $Page->acao->editAttributes() ?> aria-describedby="x_acao_help">
<?= $Page->acao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->acao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_acao_risco_oportunidade_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_acao_risco_oportunidade_obs">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="acao_risco_oportunidade" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help">
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="facao_risco_oportunidadeedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="facao_risco_oportunidadeedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("acao_risco_oportunidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
