<?php

namespace PHPMaker2024\sgq;

// Page object
$LocalizacaoAddopt = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { localizacao: currentTable } });
var currentPageID = ew.PAGE_ID = "addopt";
var currentForm;
var flocalizacaoaddopt;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("flocalizacaoaddopt")
        .setPageId("addopt")

        // Add fields
        .setFields([
            ["localizacao", [fields.localizacao.visible && fields.localizacao.required ? ew.Validators.required(fields.localizacao.caption) : null], fields.localizacao.isInvalid]
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
<form name="flocalizacaoaddopt" id="flocalizacaoaddopt" class="ew-form" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="localizacao">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->localizacao->Visible) { // localizacao ?>
    <div id="r_localizacao"<?= $Page->localizacao->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_localizacao"><?= $Page->localizacao->caption() ?><?= $Page->localizacao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->localizacao->cellAttributes() ?>>
<input type="<?= $Page->localizacao->getInputTextType() ?>" name="x_localizacao" id="x_localizacao" data-table="localizacao" data-field="x_localizacao" value="<?= $Page->localizacao->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->localizacao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->localizacao->formatPattern()) ?>"<?= $Page->localizacao->editAttributes() ?> aria-describedby="x_localizacao_help">
<?= $Page->localizacao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->localizacao->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("localizacao");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
