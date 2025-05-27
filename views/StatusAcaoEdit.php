<?php

namespace PHPMaker2024\sgq;

// Page object
$StatusAcaoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fstatus_acaoedit" id="fstatus_acaoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { status_acao: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fstatus_acaoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fstatus_acaoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idstatus_acao", [fields.idstatus_acao.visible && fields.idstatus_acao.required ? ew.Validators.required(fields.idstatus_acao.caption) : null], fields.idstatus_acao.isInvalid],
            ["status_acao", [fields.status_acao.visible && fields.status_acao.required ? ew.Validators.required(fields.status_acao.caption) : null], fields.status_acao.isInvalid]
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
<input type="hidden" name="t" value="status_acao">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idstatus_acao->Visible) { // idstatus_acao ?>
    <div id="r_idstatus_acao"<?= $Page->idstatus_acao->rowAttributes() ?>>
        <label id="elh_status_acao_idstatus_acao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idstatus_acao->caption() ?><?= $Page->idstatus_acao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idstatus_acao->cellAttributes() ?>>
<span id="el_status_acao_idstatus_acao">
<span<?= $Page->idstatus_acao->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idstatus_acao->getDisplayValue($Page->idstatus_acao->EditValue))) ?>"></span>
<input type="hidden" data-table="status_acao" data-field="x_idstatus_acao" data-hidden="1" name="x_idstatus_acao" id="x_idstatus_acao" value="<?= HtmlEncode($Page->idstatus_acao->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_acao->Visible) { // status_acao ?>
    <div id="r_status_acao"<?= $Page->status_acao->rowAttributes() ?>>
        <label id="elh_status_acao_status_acao" for="x_status_acao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_acao->caption() ?><?= $Page->status_acao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status_acao->cellAttributes() ?>>
<span id="el_status_acao_status_acao">
<input type="<?= $Page->status_acao->getInputTextType() ?>" name="x_status_acao" id="x_status_acao" data-table="status_acao" data-field="x_status_acao" value="<?= $Page->status_acao->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->status_acao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->status_acao->formatPattern()) ?>"<?= $Page->status_acao->editAttributes() ?> aria-describedby="x_status_acao_help">
<?= $Page->status_acao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_acao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fstatus_acaoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fstatus_acaoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("status_acao");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
