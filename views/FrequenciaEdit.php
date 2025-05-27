<?php

namespace PHPMaker2024\sgq;

// Page object
$FrequenciaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ffrequenciaedit" id="ffrequenciaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { frequencia: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ffrequenciaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffrequenciaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idfrequencia", [fields.idfrequencia.visible && fields.idfrequencia.required ? ew.Validators.required(fields.idfrequencia.caption) : null], fields.idfrequencia.isInvalid],
            ["frequencia", [fields.frequencia.visible && fields.frequencia.required ? ew.Validators.required(fields.frequencia.caption) : null], fields.frequencia.isInvalid],
            ["grau", [fields.grau.visible && fields.grau.required ? ew.Validators.required(fields.grau.caption) : null, ew.Validators.integer], fields.grau.isInvalid],
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
<input type="hidden" name="t" value="frequencia">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idfrequencia->Visible) { // idfrequencia ?>
    <div id="r_idfrequencia"<?= $Page->idfrequencia->rowAttributes() ?>>
        <label id="elh_frequencia_idfrequencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idfrequencia->caption() ?><?= $Page->idfrequencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idfrequencia->cellAttributes() ?>>
<span id="el_frequencia_idfrequencia">
<span<?= $Page->idfrequencia->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idfrequencia->getDisplayValue($Page->idfrequencia->EditValue))) ?>"></span>
<input type="hidden" data-table="frequencia" data-field="x_idfrequencia" data-hidden="1" name="x_idfrequencia" id="x_idfrequencia" value="<?= HtmlEncode($Page->idfrequencia->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->frequencia->Visible) { // frequencia ?>
    <div id="r_frequencia"<?= $Page->frequencia->rowAttributes() ?>>
        <label id="elh_frequencia_frequencia" for="x_frequencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->frequencia->caption() ?><?= $Page->frequencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->frequencia->cellAttributes() ?>>
<span id="el_frequencia_frequencia">
<input type="<?= $Page->frequencia->getInputTextType() ?>" name="x_frequencia" id="x_frequencia" data-table="frequencia" data-field="x_frequencia" value="<?= $Page->frequencia->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->frequencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->frequencia->formatPattern()) ?>"<?= $Page->frequencia->editAttributes() ?> aria-describedby="x_frequencia_help">
<?= $Page->frequencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->frequencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->grau->Visible) { // grau ?>
    <div id="r_grau"<?= $Page->grau->rowAttributes() ?>>
        <label id="elh_frequencia_grau" for="x_grau" class="<?= $Page->LeftColumnClass ?>"><?= $Page->grau->caption() ?><?= $Page->grau->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->grau->cellAttributes() ?>>
<span id="el_frequencia_grau">
<input type="<?= $Page->grau->getInputTextType() ?>" name="x_grau" id="x_grau" data-table="frequencia" data-field="x_grau" value="<?= $Page->grau->EditValue ?>" size="3" maxlength="1" placeholder="<?= HtmlEncode($Page->grau->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->grau->formatPattern()) ?>"<?= $Page->grau->editAttributes() ?> aria-describedby="x_grau_help">
<?= $Page->grau->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->grau->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_frequencia_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_frequencia_obs">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="frequencia" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help">
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffrequenciaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ffrequenciaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("frequencia");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
