<?php

namespace PHPMaker2024\sgq;

// Page object
$UsuarioAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { usuario: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fusuarioadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fusuarioadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["nome", [fields.nome.visible && fields.nome.required ? ew.Validators.required(fields.nome.caption) : null], fields.nome.isInvalid],
            ["_login", [fields._login.visible && fields._login.required ? ew.Validators.required(fields._login.caption) : null], fields._login.isInvalid],
            ["senha", [fields.senha.visible && fields.senha.required ? ew.Validators.required(fields.senha.caption) : null], fields.senha.isInvalid],
            ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
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
            "status": <?= $Page->status->toClientList($Page) ?>,
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
<form name="fusuarioadd" id="fusuarioadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="usuario">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->nome->Visible) { // nome ?>
    <div id="r_nome"<?= $Page->nome->rowAttributes() ?>>
        <label id="elh_usuario_nome" for="x_nome" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nome->caption() ?><?= $Page->nome->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nome->cellAttributes() ?>>
<span id="el_usuario_nome">
<input type="<?= $Page->nome->getInputTextType() ?>" name="x_nome" id="x_nome" data-table="usuario" data-field="x_nome" value="<?= $Page->nome->EditValue ?>" size="50" maxlength="100" placeholder="<?= HtmlEncode($Page->nome->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nome->formatPattern()) ?>"<?= $Page->nome->editAttributes() ?> aria-describedby="x_nome_help">
<?= $Page->nome->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nome->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
    <div id="r__login"<?= $Page->_login->rowAttributes() ?>>
        <label id="elh_usuario__login" for="x__login" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_login->caption() ?><?= $Page->_login->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_login->cellAttributes() ?>>
<span id="el_usuario__login">
<input type="<?= $Page->_login->getInputTextType() ?>" name="x__login" id="x__login" data-table="usuario" data-field="x__login" value="<?= $Page->_login->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->_login->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_login->formatPattern()) ?>"<?= $Page->_login->editAttributes() ?> aria-describedby="x__login_help">
<?= $Page->_login->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_login->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->senha->Visible) { // senha ?>
    <div id="r_senha"<?= $Page->senha->rowAttributes() ?>>
        <label id="elh_usuario_senha" for="x_senha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->senha->caption() ?><?= $Page->senha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->senha->cellAttributes() ?>>
<span id="el_usuario_senha">
<div class="input-group">
    <input type="password" name="x_senha" id="x_senha" autocomplete="new-password" data-table="usuario" data-field="x_senha" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->senha->getPlaceHolder()) ?>"<?= $Page->senha->editAttributes() ?> aria-describedby="x_senha_help">
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fa-solid fa-eye"></i></button>
</div>
<?= $Page->senha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->senha->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_usuario_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_usuario_status">
<span class="form-control-plaintext"><?= $Page->status->getDisplayValue($Page->status->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_usuario_status">
    <select
        id="x_status"
        name="x_status"
        class="form-select ew-select<?= $Page->status->isInvalidClass() ?>"
        <?php if (!$Page->status->IsNativeSelect) { ?>
        data-select2-id="fusuarioadd_x_status"
        <?php } ?>
        data-table="usuario"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <?= $Page->status->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
<?= $Page->status->Lookup->getParamTag($Page, "p_x_status") ?>
<?php if (!$Page->status->IsNativeSelect) { ?>
<script>
loadjs.ready("fusuarioadd", function() {
    var options = { name: "x_status", selectId: "fusuarioadd_x_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusuarioadd.lists.status?.lookupOptions.length) {
        options.data = { id: "x_status", form: "fusuarioadd" };
    } else {
        options.ajax = { id: "x_status", form: "fusuarioadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.usuario.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fusuarioadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fusuarioadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
