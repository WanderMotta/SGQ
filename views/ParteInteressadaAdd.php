<?php

namespace PHPMaker2023\sgq;

// Page object
$ParteInteressadaAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { parte_interessada: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fparte_interessadaadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fparte_interessadaadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["parte_interessada", [fields.parte_interessada.visible && fields.parte_interessada.required ? ew.Validators.required(fields.parte_interessada.caption) : null], fields.parte_interessada.isInvalid],
            ["necessidades", [fields.necessidades.visible && fields.necessidades.required ? ew.Validators.required(fields.necessidades.caption) : null], fields.necessidades.isInvalid],
            ["expectativas", [fields.expectativas.visible && fields.expectativas.required ? ew.Validators.required(fields.expectativas.caption) : null], fields.expectativas.isInvalid],
            ["monitor", [fields.monitor.visible && fields.monitor.required ? ew.Validators.required(fields.monitor.caption) : null], fields.monitor.isInvalid]
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fparte_interessadaadd" id="fparte_interessadaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="parte_interessada">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->parte_interessada->Visible) { // parte_interessada ?>
    <div id="r_parte_interessada"<?= $Page->parte_interessada->rowAttributes() ?>>
        <label id="elh_parte_interessada_parte_interessada" for="x_parte_interessada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parte_interessada->caption() ?><?= $Page->parte_interessada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parte_interessada->cellAttributes() ?>>
<span id="el_parte_interessada_parte_interessada">
<input type="<?= $Page->parte_interessada->getInputTextType() ?>" name="x_parte_interessada" id="x_parte_interessada" data-table="parte_interessada" data-field="x_parte_interessada" value="<?= $Page->parte_interessada->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->parte_interessada->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->parte_interessada->formatPattern()) ?>"<?= $Page->parte_interessada->editAttributes() ?> aria-describedby="x_parte_interessada_help">
<?= $Page->parte_interessada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parte_interessada->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->necessidades->Visible) { // necessidades ?>
    <div id="r_necessidades"<?= $Page->necessidades->rowAttributes() ?>>
        <label id="elh_parte_interessada_necessidades" for="x_necessidades" class="<?= $Page->LeftColumnClass ?>"><?= $Page->necessidades->caption() ?><?= $Page->necessidades->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->necessidades->cellAttributes() ?>>
<span id="el_parte_interessada_necessidades">
<input type="<?= $Page->necessidades->getInputTextType() ?>" name="x_necessidades" id="x_necessidades" data-table="parte_interessada" data-field="x_necessidades" value="<?= $Page->necessidades->EditValue ?>" size="45" maxlength="120" placeholder="<?= HtmlEncode($Page->necessidades->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->necessidades->formatPattern()) ?>"<?= $Page->necessidades->editAttributes() ?> aria-describedby="x_necessidades_help">
<?= $Page->necessidades->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->necessidades->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expectativas->Visible) { // expectativas ?>
    <div id="r_expectativas"<?= $Page->expectativas->rowAttributes() ?>>
        <label id="elh_parte_interessada_expectativas" for="x_expectativas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expectativas->caption() ?><?= $Page->expectativas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expectativas->cellAttributes() ?>>
<span id="el_parte_interessada_expectativas">
<input type="<?= $Page->expectativas->getInputTextType() ?>" name="x_expectativas" id="x_expectativas" data-table="parte_interessada" data-field="x_expectativas" value="<?= $Page->expectativas->EditValue ?>" size="45" maxlength="120" placeholder="<?= HtmlEncode($Page->expectativas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->expectativas->formatPattern()) ?>"<?= $Page->expectativas->editAttributes() ?> aria-describedby="x_expectativas_help">
<?= $Page->expectativas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->expectativas->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monitor->Visible) { // monitor ?>
    <div id="r_monitor"<?= $Page->monitor->rowAttributes() ?>>
        <label id="elh_parte_interessada_monitor" for="x_monitor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monitor->caption() ?><?= $Page->monitor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monitor->cellAttributes() ?>>
<span id="el_parte_interessada_monitor">
<input type="<?= $Page->monitor->getInputTextType() ?>" name="x_monitor" id="x_monitor" data-table="parte_interessada" data-field="x_monitor" value="<?= $Page->monitor->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->monitor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monitor->formatPattern()) ?>"<?= $Page->monitor->editAttributes() ?> aria-describedby="x_monitor_help">
<?= $Page->monitor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monitor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fparte_interessadaadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fparte_interessadaadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("parte_interessada");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
