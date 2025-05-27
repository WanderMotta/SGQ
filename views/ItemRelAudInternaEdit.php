<?php

namespace PHPMaker2024\sgq;

// Page object
$ItemRelAudInternaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fitem_rel_aud_internaedit" id="fitem_rel_aud_internaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { item_rel_aud_interna: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fitem_rel_aud_internaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fitem_rel_aud_internaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["iditem_rel_aud_interna", [fields.iditem_rel_aud_interna.visible && fields.iditem_rel_aud_interna.required ? ew.Validators.required(fields.iditem_rel_aud_interna.caption) : null], fields.iditem_rel_aud_interna.isInvalid],
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["processo_idprocesso", [fields.processo_idprocesso.visible && fields.processo_idprocesso.required ? ew.Validators.required(fields.processo_idprocesso.caption) : null], fields.processo_idprocesso.isInvalid],
            ["descricao", [fields.descricao.visible && fields.descricao.required ? ew.Validators.required(fields.descricao.caption) : null], fields.descricao.isInvalid],
            ["acao_imediata", [fields.acao_imediata.visible && fields.acao_imediata.required ? ew.Validators.required(fields.acao_imediata.caption) : null], fields.acao_imediata.isInvalid],
            ["acao_contecao", [fields.acao_contecao.visible && fields.acao_contecao.required ? ew.Validators.required(fields.acao_contecao.caption) : null], fields.acao_contecao.isInvalid],
            ["abrir_nc", [fields.abrir_nc.visible && fields.abrir_nc.required ? ew.Validators.required(fields.abrir_nc.caption) : null], fields.abrir_nc.isInvalid],
            ["relatorio_auditoria_interna_idrelatorio_auditoria_interna", [fields.relatorio_auditoria_interna_idrelatorio_auditoria_interna.visible && fields.relatorio_auditoria_interna_idrelatorio_auditoria_interna.required ? ew.Validators.required(fields.relatorio_auditoria_interna_idrelatorio_auditoria_interna.caption) : null, ew.Validators.integer], fields.relatorio_auditoria_interna_idrelatorio_auditoria_interna.isInvalid]
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
            "processo_idprocesso": <?= $Page->processo_idprocesso->toClientList($Page) ?>,
            "abrir_nc": <?= $Page->abrir_nc->toClientList($Page) ?>,
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="item_rel_aud_interna">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "relatorio_auditoria_interna") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="relatorio_auditoria_interna">
<input type="hidden" name="fk_idrelatorio_auditoria_interna" value="<?= HtmlEncode($Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->iditem_rel_aud_interna->Visible) { // iditem_rel_aud_interna ?>
    <div id="r_iditem_rel_aud_interna"<?= $Page->iditem_rel_aud_interna->rowAttributes() ?>>
        <label id="elh_item_rel_aud_interna_iditem_rel_aud_interna" class="<?= $Page->LeftColumnClass ?>"><?= $Page->iditem_rel_aud_interna->caption() ?><?= $Page->iditem_rel_aud_interna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->iditem_rel_aud_interna->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_iditem_rel_aud_interna">
<span<?= $Page->iditem_rel_aud_interna->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->iditem_rel_aud_interna->getDisplayValue($Page->iditem_rel_aud_interna->EditValue))) ?>"></span>
<input type="hidden" data-table="item_rel_aud_interna" data-field="x_iditem_rel_aud_interna" data-hidden="1" name="x_iditem_rel_aud_interna" id="x_iditem_rel_aud_interna" value="<?= HtmlEncode($Page->iditem_rel_aud_interna->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <div id="r_processo_idprocesso"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <label id="elh_item_rel_aud_interna_processo_idprocesso" for="x_processo_idprocesso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->processo_idprocesso->caption() ?><?= $Page->processo_idprocesso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_processo_idprocesso">
    <select
        id="x_processo_idprocesso"
        name="x_processo_idprocesso"
        class="form-control ew-select<?= $Page->processo_idprocesso->isInvalidClass() ?>"
        data-select2-id="fitem_rel_aud_internaedit_x_processo_idprocesso"
        data-table="item_rel_aud_interna"
        data-field="x_processo_idprocesso"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->processo_idprocesso->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->processo_idprocesso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->processo_idprocesso->getPlaceHolder()) ?>"
        <?= $Page->processo_idprocesso->editAttributes() ?>>
        <?= $Page->processo_idprocesso->selectOptionListHtml("x_processo_idprocesso") ?>
    </select>
    <?= $Page->processo_idprocesso->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->processo_idprocesso->getErrorMessage() ?></div>
<?= $Page->processo_idprocesso->Lookup->getParamTag($Page, "p_x_processo_idprocesso") ?>
<script>
loadjs.ready("fitem_rel_aud_internaedit", function() {
    var options = { name: "x_processo_idprocesso", selectId: "fitem_rel_aud_internaedit_x_processo_idprocesso" };
    if (fitem_rel_aud_internaedit.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x_processo_idprocesso", form: "fitem_rel_aud_internaedit" };
    } else {
        options.ajax = { id: "x_processo_idprocesso", form: "fitem_rel_aud_internaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.item_rel_aud_interna.fields.processo_idprocesso.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
    <div id="r_descricao"<?= $Page->descricao->rowAttributes() ?>>
        <label id="elh_item_rel_aud_interna_descricao" for="x_descricao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descricao->caption() ?><?= $Page->descricao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descricao->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_descricao">
<textarea data-table="item_rel_aud_interna" data-field="x_descricao" name="x_descricao" id="x_descricao" cols="50" rows="4" placeholder="<?= HtmlEncode($Page->descricao->getPlaceHolder()) ?>"<?= $Page->descricao->editAttributes() ?> aria-describedby="x_descricao_help"><?= $Page->descricao->EditValue ?></textarea>
<?= $Page->descricao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descricao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->acao_imediata->Visible) { // acao_imediata ?>
    <div id="r_acao_imediata"<?= $Page->acao_imediata->rowAttributes() ?>>
        <label id="elh_item_rel_aud_interna_acao_imediata" for="x_acao_imediata" class="<?= $Page->LeftColumnClass ?>"><?= $Page->acao_imediata->caption() ?><?= $Page->acao_imediata->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->acao_imediata->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_acao_imediata">
<textarea data-table="item_rel_aud_interna" data-field="x_acao_imediata" name="x_acao_imediata" id="x_acao_imediata" cols="50" rows="3" placeholder="<?= HtmlEncode($Page->acao_imediata->getPlaceHolder()) ?>"<?= $Page->acao_imediata->editAttributes() ?> aria-describedby="x_acao_imediata_help"><?= $Page->acao_imediata->EditValue ?></textarea>
<?= $Page->acao_imediata->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->acao_imediata->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->acao_contecao->Visible) { // acao_contecao ?>
    <div id="r_acao_contecao"<?= $Page->acao_contecao->rowAttributes() ?>>
        <label id="elh_item_rel_aud_interna_acao_contecao" for="x_acao_contecao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->acao_contecao->caption() ?><?= $Page->acao_contecao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->acao_contecao->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_acao_contecao">
<textarea data-table="item_rel_aud_interna" data-field="x_acao_contecao" name="x_acao_contecao" id="x_acao_contecao" cols="50" rows="3" placeholder="<?= HtmlEncode($Page->acao_contecao->getPlaceHolder()) ?>"<?= $Page->acao_contecao->editAttributes() ?> aria-describedby="x_acao_contecao_help"><?= $Page->acao_contecao->EditValue ?></textarea>
<?= $Page->acao_contecao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->acao_contecao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->abrir_nc->Visible) { // abrir_nc ?>
    <div id="r_abrir_nc"<?= $Page->abrir_nc->rowAttributes() ?>>
        <label id="elh_item_rel_aud_interna_abrir_nc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->abrir_nc->caption() ?><?= $Page->abrir_nc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->abrir_nc->cellAttributes() ?>>
<span id="el_item_rel_aud_interna_abrir_nc">
<template id="tp_x_abrir_nc">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="item_rel_aud_interna" data-field="x_abrir_nc" name="x_abrir_nc" id="x_abrir_nc"<?= $Page->abrir_nc->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_abrir_nc" class="ew-item-list"></div>
<selection-list hidden
    id="x_abrir_nc"
    name="x_abrir_nc"
    value="<?= HtmlEncode($Page->abrir_nc->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_abrir_nc"
    data-target="dsl_x_abrir_nc"
    data-repeatcolumn="5"
    class="form-control<?= $Page->abrir_nc->isInvalidClass() ?>"
    data-table="item_rel_aud_interna"
    data-field="x_abrir_nc"
    data-value-separator="<?= $Page->abrir_nc->displayValueSeparatorAttribute() ?>"
    <?= $Page->abrir_nc->editAttributes() ?>></selection-list>
<?= $Page->abrir_nc->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->abrir_nc->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->Visible) { // relatorio_auditoria_interna_idrelatorio_auditoria_interna ?>
    <div id="r_relatorio_auditoria_interna_idrelatorio_auditoria_interna"<?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->rowAttributes() ?>>
        <label id="elh_item_rel_aud_interna_relatorio_auditoria_interna_idrelatorio_auditoria_interna" for="x_relatorio_auditoria_interna_idrelatorio_auditoria_interna" class="<?= $Page->LeftColumnClass ?>"><?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->caption() ?><?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->cellAttributes() ?>>
<?php if ($Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getSessionValue() != "") { ?>
<span<?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getDisplayValue($Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->ViewValue))) ?>"></span>
<input type="hidden" id="x_relatorio_auditoria_interna_idrelatorio_auditoria_interna" name="x_relatorio_auditoria_interna_idrelatorio_auditoria_interna" value="<?= HtmlEncode($Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_item_rel_aud_interna_relatorio_auditoria_interna_idrelatorio_auditoria_interna">
<input type="<?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getInputTextType() ?>" name="x_relatorio_auditoria_interna_idrelatorio_auditoria_interna" id="x_relatorio_auditoria_interna_idrelatorio_auditoria_interna" data-table="item_rel_aud_interna" data-field="x_relatorio_auditoria_interna_idrelatorio_auditoria_interna" value="<?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->formatPattern()) ?>"<?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->editAttributes() ?> aria-describedby="x_relatorio_auditoria_interna_idrelatorio_auditoria_interna_help">
<?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->relatorio_auditoria_interna_idrelatorio_auditoria_interna->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fitem_rel_aud_internaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fitem_rel_aud_internaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("item_rel_aud_interna");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
