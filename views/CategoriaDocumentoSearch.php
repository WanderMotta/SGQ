<?php

namespace PHPMaker2024\sgq;

// Page object
$CategoriaDocumentoSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { categoria_documento: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fcategoria_documentosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fcategoria_documentosearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idcategoria_documento", [ew.Validators.integer], fields.idcategoria_documento.isInvalid],
            ["categoria", [], fields.categoria.isInvalid],
            ["sigla", [], fields.sigla.isInvalid]
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
<form name="fcategoria_documentosearch" id="fcategoria_documentosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="categoria_documento">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idcategoria_documento->Visible) { // idcategoria_documento ?>
    <div id="r_idcategoria_documento" class="row"<?= $Page->idcategoria_documento->rowAttributes() ?>>
        <label for="x_idcategoria_documento" class="<?= $Page->LeftColumnClass ?>"><span id="elh_categoria_documento_idcategoria_documento"><?= $Page->idcategoria_documento->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idcategoria_documento" id="z_idcategoria_documento" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idcategoria_documento->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_categoria_documento_idcategoria_documento" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idcategoria_documento->getInputTextType() ?>" name="x_idcategoria_documento" id="x_idcategoria_documento" data-table="categoria_documento" data-field="x_idcategoria_documento" value="<?= $Page->idcategoria_documento->EditValue ?>" placeholder="<?= HtmlEncode($Page->idcategoria_documento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idcategoria_documento->formatPattern()) ?>"<?= $Page->idcategoria_documento->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idcategoria_documento->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->categoria->Visible) { // categoria ?>
    <div id="r_categoria" class="row"<?= $Page->categoria->rowAttributes() ?>>
        <label for="x_categoria" class="<?= $Page->LeftColumnClass ?>"><span id="elh_categoria_documento_categoria"><?= $Page->categoria->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_categoria" id="z_categoria" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->categoria->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_categoria_documento_categoria" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->categoria->getInputTextType() ?>" name="x_categoria" id="x_categoria" data-table="categoria_documento" data-field="x_categoria" value="<?= $Page->categoria->EditValue ?>" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->categoria->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->categoria->formatPattern()) ?>"<?= $Page->categoria->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->categoria->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->sigla->Visible) { // sigla ?>
    <div id="r_sigla" class="row"<?= $Page->sigla->rowAttributes() ?>>
        <label for="x_sigla" class="<?= $Page->LeftColumnClass ?>"><span id="elh_categoria_documento_sigla"><?= $Page->sigla->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_sigla" id="z_sigla" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->sigla->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_categoria_documento_sigla" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->sigla->getInputTextType() ?>" name="x_sigla" id="x_sigla" data-table="categoria_documento" data-field="x_sigla" value="<?= $Page->sigla->EditValue ?>" size="15" maxlength="10" placeholder="<?= HtmlEncode($Page->sigla->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sigla->formatPattern()) ?>"<?= $Page->sigla->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->sigla->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcategoria_documentosearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcategoria_documentosearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fcategoria_documentosearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
