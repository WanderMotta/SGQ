<?php

namespace PHPMaker2024\sgq;

// Page object
$CategoriaDocumentoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { categoria_documento: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fcategoria_documentoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcategoria_documentoadd")
        .setPageId("add")

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
<?php
$Page->showMessage();
?>
<form name="fcategoria_documentoadd" id="fcategoria_documentoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="categoria_documento">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->categoria->Visible) { // categoria ?>
    <div id="r_categoria"<?= $Page->categoria->rowAttributes() ?>>
        <label id="elh_categoria_documento_categoria" for="x_categoria" class="<?= $Page->LeftColumnClass ?>"><?= $Page->categoria->caption() ?><?= $Page->categoria->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->categoria->cellAttributes() ?>>
<span id="el_categoria_documento_categoria">
<input type="<?= $Page->categoria->getInputTextType() ?>" name="x_categoria" id="x_categoria" data-table="categoria_documento" data-field="x_categoria" value="<?= $Page->categoria->EditValue ?>" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->categoria->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->categoria->formatPattern()) ?>"<?= $Page->categoria->editAttributes() ?> aria-describedby="x_categoria_help">
<?= $Page->categoria->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->categoria->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sigla->Visible) { // sigla ?>
    <div id="r_sigla"<?= $Page->sigla->rowAttributes() ?>>
        <label id="elh_categoria_documento_sigla" for="x_sigla" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sigla->caption() ?><?= $Page->sigla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sigla->cellAttributes() ?>>
<span id="el_categoria_documento_sigla">
<input type="<?= $Page->sigla->getInputTextType() ?>" name="x_sigla" id="x_sigla" data-table="categoria_documento" data-field="x_sigla" value="<?= $Page->sigla->EditValue ?>" size="15" maxlength="10" placeholder="<?= HtmlEncode($Page->sigla->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sigla->formatPattern()) ?>"<?= $Page->sigla->editAttributes() ?> aria-describedby="x_sigla_help">
<?= $Page->sigla->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sigla->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcategoria_documentoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcategoria_documentoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("categoria_documento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
