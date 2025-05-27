<?php

namespace PHPMaker2024\sgq;

// Page object
$UsuarioSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { usuario: currentTable } });
var currentPageID = ew.PAGE_ID = "search";
var currentForm;
var fusuariosearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fusuariosearch")
        .setPageId("search")
<?php if ($Page->IsModal && $Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["idusuario", [ew.Validators.integer], fields.idusuario.isInvalid],
            ["nome", [], fields.nome.isInvalid],
            ["_login", [], fields._login.isInvalid],
            ["senha", [], fields.senha.isInvalid],
            ["status", [], fields.status.isInvalid],
            ["ativo", [], fields.ativo.isInvalid]
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
            "status": <?= $Page->status->toClientList($Page) ?>,
            "ativo": <?= $Page->ativo->toClientList($Page) ?>,
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
<form name="fusuariosearch" id="fusuariosearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="usuario">
<input type="hidden" name="action" id="action" value="search">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idusuario->Visible) { // idusuario ?>
    <div id="r_idusuario" class="row"<?= $Page->idusuario->rowAttributes() ?>>
        <label for="x_idusuario" class="<?= $Page->LeftColumnClass ?>"><span id="elh_usuario_idusuario"><?= $Page->idusuario->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idusuario" id="z_idusuario" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->idusuario->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_usuario_idusuario" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idusuario->getInputTextType() ?>" name="x_idusuario" id="x_idusuario" data-table="usuario" data-field="x_idusuario" value="<?= $Page->idusuario->EditValue ?>" placeholder="<?= HtmlEncode($Page->idusuario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->idusuario->formatPattern()) ?>"<?= $Page->idusuario->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idusuario->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->nome->Visible) { // nome ?>
    <div id="r_nome" class="row"<?= $Page->nome->rowAttributes() ?>>
        <label for="x_nome" class="<?= $Page->LeftColumnClass ?>"><span id="elh_usuario_nome"><?= $Page->nome->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_nome" id="z_nome" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->nome->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_usuario_nome" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->nome->getInputTextType() ?>" name="x_nome" id="x_nome" data-table="usuario" data-field="x_nome" value="<?= $Page->nome->EditValue ?>" size="50" maxlength="100" placeholder="<?= HtmlEncode($Page->nome->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nome->formatPattern()) ?>"<?= $Page->nome->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nome->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
    <div id="r__login" class="row"<?= $Page->_login->rowAttributes() ?>>
        <label for="x__login" class="<?= $Page->LeftColumnClass ?>"><span id="elh_usuario__login"><?= $Page->_login->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__login" id="z__login" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->_login->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_usuario__login" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->_login->getInputTextType() ?>" name="x__login" id="x__login" data-table="usuario" data-field="x__login" value="<?= $Page->_login->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->_login->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_login->formatPattern()) ?>"<?= $Page->_login->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_login->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->senha->Visible) { // senha ?>
    <div id="r_senha" class="row"<?= $Page->senha->rowAttributes() ?>>
        <label for="x_senha" class="<?= $Page->LeftColumnClass ?>"><span id="elh_usuario_senha"><?= $Page->senha->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_senha" id="z_senha" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->senha->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_usuario_senha" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->senha->getInputTextType() ?>" name="x_senha" id="x_senha" data-table="usuario" data-field="x_senha" value="<?= $Page->senha->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->senha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->senha->formatPattern()) ?>"<?= $Page->senha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->senha->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="row"<?= $Page->status->rowAttributes() ?>>
        <label for="x_status" class="<?= $Page->LeftColumnClass ?>"><span id="elh_usuario_status"><?= $Page->status->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_status" id="z_status" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->status->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_usuario_status" class="ew-search-field ew-search-field-single">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span class="form-control-plaintext"><?= $Page->status->getDisplayValue($Page->status->EditValue) ?></span>
<?php } else { ?>
    <select
        id="x_status"
        name="x_status"
        class="form-select ew-select<?= $Page->status->isInvalidClass() ?>"
        <?php if (!$Page->status->IsNativeSelect) { ?>
        data-select2-id="fusuariosearch_x_status"
        <?php } ?>
        data-table="usuario"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage(false) ?></div>
<?= $Page->status->Lookup->getParamTag($Page, "p_x_status") ?>
<?php if (!$Page->status->IsNativeSelect) { ?>
<script>
loadjs.ready("fusuariosearch", function() {
    var options = { name: "x_status", selectId: "fusuariosearch_x_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusuariosearch.lists.status?.lookupOptions.length) {
        options.data = { id: "x_status", form: "fusuariosearch" };
    } else {
        options.ajax = { id: "x_status", form: "fusuariosearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.usuario.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
<?php } ?>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->ativo->Visible) { // ativo ?>
    <div id="r_ativo" class="row"<?= $Page->ativo->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_usuario_ativo"><?= $Page->ativo->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ativo" id="z_ativo" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->ativo->cellAttributes() ?>>
                <div class="d-flex align-items-start">
                <span id="el_usuario_ativo" class="ew-search-field ew-search-field-single">
<template id="tp_x_ativo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="usuario" data-field="x_ativo" name="x_ativo" id="x_ativo"<?= $Page->ativo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_ativo" class="ew-item-list"></div>
<selection-list hidden
    id="x_ativo"
    name="x_ativo"
    value="<?= HtmlEncode($Page->ativo->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_ativo"
    data-target="dsl_x_ativo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ativo->isInvalidClass() ?>"
    data-table="usuario"
    data-field="x_ativo"
    data-value-separator="<?= $Page->ativo->displayValueSeparatorAttribute() ?>"
    <?= $Page->ativo->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ativo->getErrorMessage(false) ?></div>
</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fusuariosearch"><?= $Language->phrase("Search") ?></button>
        <?php if ($Page->IsModal) { ?>
        <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fusuariosearch"><?= $Language->phrase("Cancel") ?></button>
        <?php } else { ?>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" form="fusuariosearch" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
    ew.addEventHandlers("usuario");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
