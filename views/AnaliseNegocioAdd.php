<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseNegocioAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_negocio: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fanalise_negocioadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fanalise_negocioadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["item", [fields.item.visible && fields.item.required ? ew.Validators.required(fields.item.caption) : null], fields.item.isInvalid],
            ["descrever", [fields.descrever.visible && fields.descrever.required ? ew.Validators.required(fields.descrever.caption) : null], fields.descrever.isInvalid],
            ["posicao", [fields.posicao.visible && fields.posicao.required ? ew.Validators.required(fields.posicao.caption) : null, ew.Validators.integer], fields.posicao.isInvalid]
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
<form name="fanalise_negocioadd" id="fanalise_negocioadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="analise_negocio">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->item->Visible) { // item ?>
    <div id="r_item"<?= $Page->item->rowAttributes() ?>>
        <label id="elh_analise_negocio_item" for="x_item" class="<?= $Page->LeftColumnClass ?>"><?= $Page->item->caption() ?><?= $Page->item->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->item->cellAttributes() ?>>
<span id="el_analise_negocio_item">
<input type="<?= $Page->item->getInputTextType() ?>" name="x_item" id="x_item" data-table="analise_negocio" data-field="x_item" value="<?= $Page->item->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->item->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->item->formatPattern()) ?>"<?= $Page->item->editAttributes() ?> aria-describedby="x_item_help">
<?= $Page->item->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->item->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descrever->Visible) { // descrever ?>
    <div id="r_descrever"<?= $Page->descrever->rowAttributes() ?>>
        <label id="elh_analise_negocio_descrever" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descrever->caption() ?><?= $Page->descrever->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descrever->cellAttributes() ?>>
<span id="el_analise_negocio_descrever">
<?php $Page->descrever->EditAttrs->appendClass("editor"); ?>
<textarea data-table="analise_negocio" data-field="x_descrever" name="x_descrever" id="x_descrever" cols="50" rows="4" placeholder="<?= HtmlEncode($Page->descrever->getPlaceHolder()) ?>"<?= $Page->descrever->editAttributes() ?> aria-describedby="x_descrever_help"><?= $Page->descrever->EditValue ?></textarea>
<?= $Page->descrever->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descrever->getErrorMessage() ?></div>
<script>
loadjs.ready(["fanalise_negocioadd", "editor"], function() {
    ew.createEditor("fanalise_negocioadd", "x_descrever", 50, 4, <?= $Page->descrever->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->posicao->Visible) { // posicao ?>
    <div id="r_posicao"<?= $Page->posicao->rowAttributes() ?>>
        <label id="elh_analise_negocio_posicao" for="x_posicao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->posicao->caption() ?><?= $Page->posicao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->posicao->cellAttributes() ?>>
<span id="el_analise_negocio_posicao">
<input type="<?= $Page->posicao->getInputTextType() ?>" name="x_posicao" id="x_posicao" data-table="analise_negocio" data-field="x_posicao" value="<?= $Page->posicao->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->posicao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->posicao->formatPattern()) ?>"<?= $Page->posicao->editAttributes() ?> aria-describedby="x_posicao_help">
<?= $Page->posicao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->posicao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fanalise_negocioadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fanalise_negocioadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("analise_negocio");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
