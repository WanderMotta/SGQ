<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseNegocioSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_negocio: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fanalise_negociosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fanalise_negociosearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idanalise_negocio", [ew.Validators.integer], fields.idanalise_negocio.isInvalid],
            ["item", [], fields.item.isInvalid],
            ["descrever", [], fields.descrever.isInvalid],
            ["posicao", [ew.Validators.integer], fields.posicao.isInvalid]
        ])
        // Validate form
        .setValidate(
            async function () {
                if (!this.validateRequired)
                    return true; // Ignore validation
                let fobj = this.getForm();

                // Validate fields
                if (!this.validateFields())
                    return false;

                // Call Form_CustomValidate event
                if (!(await this.customValidate?.(fobj) ?? true)) {
                    this.focus();
                    return false;
                }
                return true;
            }
        )

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
<?php if ($Page->IsModal) { ?>
    currentAdvancedSearchForm = form;
<?php } else { ?>
    currentForm = form;
<?php } ?>
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
<form name="fanalise_negociosearch" id="fanalise_negociosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="analise_negocio">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idanalise_negocio->Visible) { // idanalise_negocio ?>
    <div id="r_idanalise_negocio" class="row"<?= $Page->idanalise_negocio->rowAttributes() ?>>
        <label for="x_idanalise_negocio" class="<?= $Page->LeftColumnClass ?>"><span id="elh_analise_negocio_idanalise_negocio"><?= $Page->idanalise_negocio->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idanalise_negocio" id="z_idanalise_negocio" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idanalise_negocio->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_analise_negocio_idanalise_negocio" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idanalise_negocio->getInputTextType() ?>" name="x_idanalise_negocio" id="x_idanalise_negocio" data-table="analise_negocio" data-field="x_idanalise_negocio" value="<?= $Page->idanalise_negocio->EditValue ?>" placeholder="<?= HtmlEncode($Page->idanalise_negocio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idanalise_negocio->formatPattern()) ?>"<?= $Page->idanalise_negocio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idanalise_negocio->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->item->Visible) { // item ?>
    <div id="r_item" class="row"<?= $Page->item->rowAttributes() ?>>
        <label for="x_item" class="<?= $Page->LeftColumnClass ?>"><span id="elh_analise_negocio_item"><?= $Page->item->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_item" id="z_item" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->item->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_analise_negocio_item" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->item->getInputTextType() ?>" name="x_item" id="x_item" data-table="analise_negocio" data-field="x_item" value="<?= $Page->item->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->item->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->item->formatPattern()) ?>"<?= $Page->item->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->item->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->descrever->Visible) { // descrever ?>
    <div id="r_descrever" class="row"<?= $Page->descrever->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_analise_negocio_descrever"><?= $Page->descrever->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_descrever" id="z_descrever" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->descrever->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_analise_negocio_descrever" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->descrever->getInputTextType() ?>" name="x_descrever" id="x_descrever" data-table="analise_negocio" data-field="x_descrever" value="<?= $Page->descrever->EditValue ?>" size="50" placeholder="<?= HtmlEncode($Page->descrever->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descrever->formatPattern()) ?>"<?= $Page->descrever->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->descrever->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->posicao->Visible) { // posicao ?>
    <div id="r_posicao" class="row"<?= $Page->posicao->rowAttributes() ?>>
        <label for="x_posicao" class="<?= $Page->LeftColumnClass ?>"><span id="elh_analise_negocio_posicao"><?= $Page->posicao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_posicao" id="z_posicao" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->posicao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_analise_negocio_posicao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->posicao->getInputTextType() ?>" name="x_posicao" id="x_posicao" data-table="analise_negocio" data-field="x_posicao" value="<?= $Page->posicao->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->posicao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->posicao->formatPattern()) ?>"<?= $Page->posicao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->posicao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fanalise_negociosearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fanalise_negociosearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fanalise_negociosearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
