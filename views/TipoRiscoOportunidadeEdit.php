<?php

namespace PHPMaker2024\sgq;

// Page object
$TipoRiscoOportunidadeEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ftipo_risco_oportunidadeedit" id="ftipo_risco_oportunidadeedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tipo_risco_oportunidade: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ftipo_risco_oportunidadeedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftipo_risco_oportunidadeedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idtipo_risco_oportunidade", [fields.idtipo_risco_oportunidade.visible && fields.idtipo_risco_oportunidade.required ? ew.Validators.required(fields.idtipo_risco_oportunidade.caption) : null], fields.idtipo_risco_oportunidade.isInvalid],
            ["tipo_risco_oportunidade", [fields.tipo_risco_oportunidade.visible && fields.tipo_risco_oportunidade.required ? ew.Validators.required(fields.tipo_risco_oportunidade.caption) : null], fields.tipo_risco_oportunidade.isInvalid]
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
<input type="hidden" name="t" value="tipo_risco_oportunidade">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idtipo_risco_oportunidade->Visible) { // idtipo_risco_oportunidade ?>
    <div id="r_idtipo_risco_oportunidade"<?= $Page->idtipo_risco_oportunidade->rowAttributes() ?>>
        <label id="elh_tipo_risco_oportunidade_idtipo_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idtipo_risco_oportunidade->caption() ?><?= $Page->idtipo_risco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idtipo_risco_oportunidade->cellAttributes() ?>>
<span id="el_tipo_risco_oportunidade_idtipo_risco_oportunidade">
<span<?= $Page->idtipo_risco_oportunidade->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idtipo_risco_oportunidade->getDisplayValue($Page->idtipo_risco_oportunidade->EditValue))) ?>"></span>
<input type="hidden" data-table="tipo_risco_oportunidade" data-field="x_idtipo_risco_oportunidade" data-hidden="1" name="x_idtipo_risco_oportunidade" id="x_idtipo_risco_oportunidade" value="<?= HtmlEncode($Page->idtipo_risco_oportunidade->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade ?>
    <div id="r_tipo_risco_oportunidade"<?= $Page->tipo_risco_oportunidade->rowAttributes() ?>>
        <label id="elh_tipo_risco_oportunidade_tipo_risco_oportunidade" for="x_tipo_risco_oportunidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_risco_oportunidade->caption() ?><?= $Page->tipo_risco_oportunidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_risco_oportunidade->cellAttributes() ?>>
<span id="el_tipo_risco_oportunidade_tipo_risco_oportunidade">
<input type="<?= $Page->tipo_risco_oportunidade->getInputTextType() ?>" name="x_tipo_risco_oportunidade" id="x_tipo_risco_oportunidade" data-table="tipo_risco_oportunidade" data-field="x_tipo_risco_oportunidade" value="<?= $Page->tipo_risco_oportunidade->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->tipo_risco_oportunidade->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipo_risco_oportunidade->formatPattern()) ?>"<?= $Page->tipo_risco_oportunidade->editAttributes() ?> aria-describedby="x_tipo_risco_oportunidade_help">
<?= $Page->tipo_risco_oportunidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_risco_oportunidade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ftipo_risco_oportunidadeedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ftipo_risco_oportunidadeedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("tipo_risco_oportunidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
