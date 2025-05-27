<?php

namespace PHPMaker2024\sgq;

// Page object
$DepartamentosEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fdepartamentosedit" id="fdepartamentosedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { departamentos: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fdepartamentosedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdepartamentosedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["iddepartamentos", [fields.iddepartamentos.visible && fields.iddepartamentos.required ? ew.Validators.required(fields.iddepartamentos.caption) : null], fields.iddepartamentos.isInvalid],
            ["departamento", [fields.departamento.visible && fields.departamento.required ? ew.Validators.required(fields.departamento.caption) : null], fields.departamento.isInvalid]
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
<input type="hidden" name="t" value="departamentos">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->iddepartamentos->Visible) { // iddepartamentos ?>
    <div id="r_iddepartamentos"<?= $Page->iddepartamentos->rowAttributes() ?>>
        <label id="elh_departamentos_iddepartamentos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->iddepartamentos->caption() ?><?= $Page->iddepartamentos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->iddepartamentos->cellAttributes() ?>>
<span id="el_departamentos_iddepartamentos">
<span<?= $Page->iddepartamentos->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->iddepartamentos->getDisplayValue($Page->iddepartamentos->EditValue))) ?>"></span>
<input type="hidden" data-table="departamentos" data-field="x_iddepartamentos" data-hidden="1" name="x_iddepartamentos" id="x_iddepartamentos" value="<?= HtmlEncode($Page->iddepartamentos->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->departamento->Visible) { // departamento ?>
    <div id="r_departamento"<?= $Page->departamento->rowAttributes() ?>>
        <label id="elh_departamentos_departamento" for="x_departamento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->departamento->caption() ?><?= $Page->departamento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->departamento->cellAttributes() ?>>
<span id="el_departamentos_departamento">
<input type="<?= $Page->departamento->getInputTextType() ?>" name="x_departamento" id="x_departamento" data-table="departamentos" data-field="x_departamento" value="<?= $Page->departamento->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->departamento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->departamento->formatPattern()) ?>"<?= $Page->departamento->editAttributes() ?> aria-describedby="x_departamento_help">
<?= $Page->departamento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->departamento->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdepartamentosedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdepartamentosedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("departamentos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
