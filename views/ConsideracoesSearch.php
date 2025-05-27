<?php

namespace PHPMaker2024\sgq;

// Page object
$ConsideracoesSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { consideracoes: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fconsideracoessearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fconsideracoessearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idconsideracoes", [ew.Validators.integer], fields.idconsideracoes.isInvalid],
            ["titulo", [], fields.titulo.isInvalid],
            ["consideracao", [], fields.consideracao.isInvalid]
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
<form name="fconsideracoessearch" id="fconsideracoessearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="consideracoes">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idconsideracoes->Visible) { // idconsideracoes ?>
    <div id="r_idconsideracoes" class="row"<?= $Page->idconsideracoes->rowAttributes() ?>>
        <label for="x_idconsideracoes" class="<?= $Page->LeftColumnClass ?>"><span id="elh_consideracoes_idconsideracoes"><?= $Page->idconsideracoes->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idconsideracoes" id="z_idconsideracoes" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idconsideracoes->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_consideracoes_idconsideracoes" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idconsideracoes->getInputTextType() ?>" name="x_idconsideracoes" id="x_idconsideracoes" data-table="consideracoes" data-field="x_idconsideracoes" value="<?= $Page->idconsideracoes->EditValue ?>" placeholder="<?= HtmlEncode($Page->idconsideracoes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idconsideracoes->formatPattern()) ?>"<?= $Page->idconsideracoes->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idconsideracoes->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <div id="r_titulo" class="row"<?= $Page->titulo->rowAttributes() ?>>
        <label for="x_titulo" class="<?= $Page->LeftColumnClass ?>"><span id="elh_consideracoes_titulo"><?= $Page->titulo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_titulo" id="z_titulo" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->titulo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_consideracoes_titulo" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->titulo->getInputTextType() ?>" name="x_titulo" id="x_titulo" data-table="consideracoes" data-field="x_titulo" value="<?= $Page->titulo->EditValue ?>" size="45" maxlength="60" placeholder="<?= HtmlEncode($Page->titulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titulo->formatPattern()) ?>"<?= $Page->titulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->titulo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->consideracao->Visible) { // consideracao ?>
    <div id="r_consideracao" class="row"<?= $Page->consideracao->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_consideracoes_consideracao"><?= $Page->consideracao->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_consideracao" id="z_consideracao" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->consideracao->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_consideracoes_consideracao" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->consideracao->getInputTextType() ?>" name="x_consideracao" id="x_consideracao" data-table="consideracoes" data-field="x_consideracao" value="<?= $Page->consideracao->EditValue ?>" size="60" maxlength="65535" placeholder="<?= HtmlEncode($Page->consideracao->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->consideracao->formatPattern()) ?>"<?= $Page->consideracao->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->consideracao->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fconsideracoessearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fconsideracoessearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fconsideracoessearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
