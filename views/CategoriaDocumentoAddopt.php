<?php

namespace PHPMaker2024\sgq;

// Page object
$CategoriaDocumentoAddopt = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { categoria_documento: currentTable } });
var currentPageID = ew.PAGE_ID = "addopt";
var currentForm;
var fcategoria_documentoaddopt;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcategoria_documentoaddopt")
        .setPageId("addopt")

        // Add fields
        .setFields([
            ["categoria", [fields.categoria.visible && fields.categoria.required ? ew.Validators.required(fields.categoria.caption) : null], fields.categoria.isInvalid],
            ["sigla", [fields.sigla.visible && fields.sigla.required ? ew.Validators.required(fields.sigla.caption) : null], fields.sigla.isInvalid]
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
<form name="fcategoria_documentoaddopt" id="fcategoria_documentoaddopt" class="ew-form" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="categoria_documento">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->categoria->Visible) { // categoria ?>
    <div id="r_categoria"<?= $Page->categoria->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_categoria"><?= $Page->categoria->caption() ?><?= $Page->categoria->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->categoria->cellAttributes() ?>>
<input type="<?= $Page->categoria->getInputTextType() ?>" name="x_categoria" id="x_categoria" data-table="categoria_documento" data-field="x_categoria" value="<?= $Page->categoria->EditValue ?>" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->categoria->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->categoria->formatPattern()) ?>"<?= $Page->categoria->editAttributes() ?> aria-describedby="x_categoria_help">
<?= $Page->categoria->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->categoria->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sigla->Visible) { // sigla ?>
    <div id="r_sigla"<?= $Page->sigla->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_sigla"><?= $Page->sigla->caption() ?><?= $Page->sigla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->sigla->cellAttributes() ?>>
<input type="<?= $Page->sigla->getInputTextType() ?>" name="x_sigla" id="x_sigla" data-table="categoria_documento" data-field="x_sigla" value="<?= $Page->sigla->EditValue ?>" size="15" maxlength="10" placeholder="<?= HtmlEncode($Page->sigla->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sigla->formatPattern()) ?>"<?= $Page->sigla->editAttributes() ?> aria-describedby="x_sigla_help">
<?= $Page->sigla->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sigla->getErrorMessage() ?></div>
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
    ew.addEventHandlers("categoria_documento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
