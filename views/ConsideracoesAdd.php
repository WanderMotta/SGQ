<?php

namespace PHPMaker2024\sgq;

// Page object
$ConsideracoesAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { consideracoes: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fconsideracoesadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fconsideracoesadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["titulo", [fields.titulo.visible && fields.titulo.required ? ew.Validators.required(fields.titulo.caption) : null], fields.titulo.isInvalid],
            ["consideracao", [fields.consideracao.visible && fields.consideracao.required ? ew.Validators.required(fields.consideracao.caption) : null], fields.consideracao.isInvalid]
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
<form name="fconsideracoesadd" id="fconsideracoesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="consideracoes">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->titulo->Visible) { // titulo ?>
    <div id="r_titulo"<?= $Page->titulo->rowAttributes() ?>>
        <label id="elh_consideracoes_titulo" for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titulo->caption() ?><?= $Page->titulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titulo->cellAttributes() ?>>
<span id="el_consideracoes_titulo">
<input type="<?= $Page->titulo->getInputTextType() ?>" name="x_titulo" id="x_titulo" data-table="consideracoes" data-field="x_titulo" value="<?= $Page->titulo->EditValue ?>" size="45" maxlength="60" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo->formatPattern()) ?>"<?= $Page->titulo->editAttributes() ?> aria-describedby="x_titulo_help">
<?= $Page->titulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->consideracao->Visible) { // consideracao ?>
    <div id="r_consideracao"<?= $Page->consideracao->rowAttributes() ?>>
        <label id="elh_consideracoes_consideracao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->consideracao->caption() ?><?= $Page->consideracao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->consideracao->cellAttributes() ?>>
<span id="el_consideracoes_consideracao">
<?php $Page->consideracao->EditAttrs->appendClass("editor"); ?>
<textarea data-table="consideracoes" data-field="x_consideracao" name="x_consideracao" id="x_consideracao" cols="60" rows="4" placeholder="<?= HtmlEncode($Page->consideracao->getPlaceHolder()) ?>"<?= $Page->consideracao->editAttributes() ?> aria-describedby="x_consideracao_help"><?= $Page->consideracao->EditValue ?></textarea>
<?= $Page->consideracao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->consideracao->getErrorMessage() ?></div>
<script>
loadjs.ready(["fconsideracoesadd", "editor"], function() {
    ew.createEditor("fconsideracoesadd", "x_consideracao", 60, 4, <?= $Page->consideracao->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fconsideracoesadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fconsideracoesadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("consideracoes");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
