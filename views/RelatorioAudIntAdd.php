<?php

namespace PHPMaker2024\sgq;

// Page object
$RelatorioAudIntAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { relatorio_aud_int: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var frelatorio_aud_intadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frelatorio_aud_intadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["plano_auditoria_int_idplano_auditoria_int", [fields.plano_auditoria_int_idplano_auditoria_int.visible && fields.plano_auditoria_int_idplano_auditoria_int.required ? ew.Validators.required(fields.plano_auditoria_int_idplano_auditoria_int.caption) : null], fields.plano_auditoria_int_idplano_auditoria_int.isInvalid],
            ["item_plano_aud_int_iditem_plano_aud_int", [fields.item_plano_aud_int_iditem_plano_aud_int.visible && fields.item_plano_aud_int_iditem_plano_aud_int.required ? ew.Validators.required(fields.item_plano_aud_int_iditem_plano_aud_int.caption) : null, ew.Validators.integer], fields.item_plano_aud_int_iditem_plano_aud_int.isInvalid],
            ["metodo", [fields.metodo.visible && fields.metodo.required ? ew.Validators.required(fields.metodo.caption) : null], fields.metodo.isInvalid],
            ["descricao", [fields.descricao.visible && fields.descricao.required ? ew.Validators.required(fields.descricao.caption) : null], fields.descricao.isInvalid],
            ["evidencia", [fields.evidencia.visible && fields.evidencia.required ? ew.Validators.required(fields.evidencia.caption) : null], fields.evidencia.isInvalid],
            ["nao_conformidade", [fields.nao_conformidade.visible && fields.nao_conformidade.required ? ew.Validators.required(fields.nao_conformidade.caption) : null], fields.nao_conformidade.isInvalid]
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
            "plano_auditoria_int_idplano_auditoria_int": <?= $Page->plano_auditoria_int_idplano_auditoria_int->toClientList($Page) ?>,
            "item_plano_aud_int_iditem_plano_aud_int": <?= $Page->item_plano_aud_int_iditem_plano_aud_int->toClientList($Page) ?>,
            "metodo": <?= $Page->metodo->toClientList($Page) ?>,
            "nao_conformidade": <?= $Page->nao_conformidade->toClientList($Page) ?>,
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
<form name="frelatorio_aud_intadd" id="frelatorio_aud_intadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="relatorio_aud_int">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "item_plano_aud_int") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="item_plano_aud_int">
<input type="hidden" name="fk_iditem_plano_aud_int" value="<?= HtmlEncode($Page->item_plano_aud_int_iditem_plano_aud_int->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->plano_auditoria_int_idplano_auditoria_int->Visible) { // plano_auditoria_int_idplano_auditoria_int ?>
    <div id="r_plano_auditoria_int_idplano_auditoria_int"<?= $Page->plano_auditoria_int_idplano_auditoria_int->rowAttributes() ?>>
        <label id="elh_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int" for="x_plano_auditoria_int_idplano_auditoria_int" class="<?= $Page->LeftColumnClass ?>"><?= $Page->plano_auditoria_int_idplano_auditoria_int->caption() ?><?= $Page->plano_auditoria_int_idplano_auditoria_int->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->plano_auditoria_int_idplano_auditoria_int->cellAttributes() ?>>
<span id="el_relatorio_aud_int_plano_auditoria_int_idplano_auditoria_int">
    <select
        id="x_plano_auditoria_int_idplano_auditoria_int"
        name="x_plano_auditoria_int_idplano_auditoria_int"
        class="form-control ew-select<?= $Page->plano_auditoria_int_idplano_auditoria_int->isInvalidClass() ?>"
        data-select2-id="frelatorio_aud_intadd_x_plano_auditoria_int_idplano_auditoria_int"
        data-table="relatorio_aud_int"
        data-field="x_plano_auditoria_int_idplano_auditoria_int"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->plano_auditoria_int_idplano_auditoria_int->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->plano_auditoria_int_idplano_auditoria_int->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->plano_auditoria_int_idplano_auditoria_int->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->plano_auditoria_int_idplano_auditoria_int->editAttributes() ?>>
        <?= $Page->plano_auditoria_int_idplano_auditoria_int->selectOptionListHtml("x_plano_auditoria_int_idplano_auditoria_int") ?>
    </select>
    <?= $Page->plano_auditoria_int_idplano_auditoria_int->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->plano_auditoria_int_idplano_auditoria_int->getErrorMessage() ?></div>
<?= $Page->plano_auditoria_int_idplano_auditoria_int->Lookup->getParamTag($Page, "p_x_plano_auditoria_int_idplano_auditoria_int") ?>
<script>
loadjs.ready("frelatorio_aud_intadd", function() {
    var options = { name: "x_plano_auditoria_int_idplano_auditoria_int", selectId: "frelatorio_aud_intadd_x_plano_auditoria_int_idplano_auditoria_int" };
    if (frelatorio_aud_intadd.lists.plano_auditoria_int_idplano_auditoria_int?.lookupOptions.length) {
        options.data = { id: "x_plano_auditoria_int_idplano_auditoria_int", form: "frelatorio_aud_intadd" };
    } else {
        options.ajax = { id: "x_plano_auditoria_int_idplano_auditoria_int", form: "frelatorio_aud_intadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.relatorio_aud_int.fields.plano_auditoria_int_idplano_auditoria_int.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->item_plano_aud_int_iditem_plano_aud_int->Visible) { // item_plano_aud_int_iditem_plano_aud_int ?>
    <div id="r_item_plano_aud_int_iditem_plano_aud_int"<?= $Page->item_plano_aud_int_iditem_plano_aud_int->rowAttributes() ?>>
        <label id="elh_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int" class="<?= $Page->LeftColumnClass ?>"><?= $Page->item_plano_aud_int_iditem_plano_aud_int->caption() ?><?= $Page->item_plano_aud_int_iditem_plano_aud_int->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->item_plano_aud_int_iditem_plano_aud_int->cellAttributes() ?>>
<?php if ($Page->item_plano_aud_int_iditem_plano_aud_int->getSessionValue() != "") { ?>
<span<?= $Page->item_plano_aud_int_iditem_plano_aud_int->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->item_plano_aud_int_iditem_plano_aud_int->getDisplayValue($Page->item_plano_aud_int_iditem_plano_aud_int->ViewValue) ?></span></span>
<input type="hidden" id="x_item_plano_aud_int_iditem_plano_aud_int" name="x_item_plano_aud_int_iditem_plano_aud_int" value="<?= HtmlEncode($Page->item_plano_aud_int_iditem_plano_aud_int->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_relatorio_aud_int_item_plano_aud_int_iditem_plano_aud_int">
    <select
        id="x_item_plano_aud_int_iditem_plano_aud_int"
        name="x_item_plano_aud_int_iditem_plano_aud_int"
        class="form-control ew-select<?= $Page->item_plano_aud_int_iditem_plano_aud_int->isInvalidClass() ?>"
        data-select2-id="frelatorio_aud_intadd_x_item_plano_aud_int_iditem_plano_aud_int"
        data-table="relatorio_aud_int"
        data-field="x_item_plano_aud_int_iditem_plano_aud_int"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->item_plano_aud_int_iditem_plano_aud_int->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->item_plano_aud_int_iditem_plano_aud_int->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->item_plano_aud_int_iditem_plano_aud_int->getPlaceHolder()) ?>"
        <?= $Page->item_plano_aud_int_iditem_plano_aud_int->editAttributes() ?>>
        <?= $Page->item_plano_aud_int_iditem_plano_aud_int->selectOptionListHtml("x_item_plano_aud_int_iditem_plano_aud_int") ?>
    </select>
    <?= $Page->item_plano_aud_int_iditem_plano_aud_int->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->item_plano_aud_int_iditem_plano_aud_int->getErrorMessage() ?></div>
<?= $Page->item_plano_aud_int_iditem_plano_aud_int->Lookup->getParamTag($Page, "p_x_item_plano_aud_int_iditem_plano_aud_int") ?>
<script>
loadjs.ready("frelatorio_aud_intadd", function() {
    var options = { name: "x_item_plano_aud_int_iditem_plano_aud_int", selectId: "frelatorio_aud_intadd_x_item_plano_aud_int_iditem_plano_aud_int" };
    if (frelatorio_aud_intadd.lists.item_plano_aud_int_iditem_plano_aud_int?.lookupOptions.length) {
        options.data = { id: "x_item_plano_aud_int_iditem_plano_aud_int", form: "frelatorio_aud_intadd" };
    } else {
        options.ajax = { id: "x_item_plano_aud_int_iditem_plano_aud_int", form: "frelatorio_aud_intadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.relatorio_aud_int.fields.item_plano_aud_int_iditem_plano_aud_int.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->metodo->Visible) { // metodo ?>
    <div id="r_metodo"<?= $Page->metodo->rowAttributes() ?>>
        <label id="elh_relatorio_aud_int_metodo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->metodo->caption() ?><?= $Page->metodo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->metodo->cellAttributes() ?>>
<span id="el_relatorio_aud_int_metodo">
<template id="tp_x_metodo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="relatorio_aud_int" data-field="x_metodo" name="x_metodo" id="x_metodo"<?= $Page->metodo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_metodo" class="ew-item-list"></div>
<selection-list hidden
    id="x_metodo"
    name="x_metodo"
    value="<?= HtmlEncode($Page->metodo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_metodo"
    data-target="dsl_x_metodo"
    data-repeatcolumn="5"
    class="form-control<?= $Page->metodo->isInvalidClass() ?>"
    data-table="relatorio_aud_int"
    data-field="x_metodo"
    data-value-separator="<?= $Page->metodo->displayValueSeparatorAttribute() ?>"
    <?= $Page->metodo->editAttributes() ?>></selection-list>
<?= $Page->metodo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->metodo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descricao->Visible) { // descricao ?>
    <div id="r_descricao"<?= $Page->descricao->rowAttributes() ?>>
        <label id="elh_relatorio_aud_int_descricao" for="x_descricao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descricao->caption() ?><?= $Page->descricao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descricao->cellAttributes() ?>>
<span id="el_relatorio_aud_int_descricao">
<textarea data-table="relatorio_aud_int" data-field="x_descricao" name="x_descricao" id="x_descricao" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->descricao->getPlaceHolder()) ?>"<?= $Page->descricao->editAttributes() ?> aria-describedby="x_descricao_help"><?= $Page->descricao->EditValue ?></textarea>
<?= $Page->descricao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descricao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->evidencia->Visible) { // evidencia ?>
    <div id="r_evidencia"<?= $Page->evidencia->rowAttributes() ?>>
        <label id="elh_relatorio_aud_int_evidencia" for="x_evidencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->evidencia->caption() ?><?= $Page->evidencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->evidencia->cellAttributes() ?>>
<span id="el_relatorio_aud_int_evidencia">
<textarea data-table="relatorio_aud_int" data-field="x_evidencia" name="x_evidencia" id="x_evidencia" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->evidencia->getPlaceHolder()) ?>"<?= $Page->evidencia->editAttributes() ?> aria-describedby="x_evidencia_help"><?= $Page->evidencia->EditValue ?></textarea>
<?= $Page->evidencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->evidencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nao_conformidade->Visible) { // nao_conformidade ?>
    <div id="r_nao_conformidade"<?= $Page->nao_conformidade->rowAttributes() ?>>
        <label id="elh_relatorio_aud_int_nao_conformidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nao_conformidade->caption() ?><?= $Page->nao_conformidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nao_conformidade->cellAttributes() ?>>
<span id="el_relatorio_aud_int_nao_conformidade">
<template id="tp_x_nao_conformidade">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="relatorio_aud_int" data-field="x_nao_conformidade" name="x_nao_conformidade" id="x_nao_conformidade"<?= $Page->nao_conformidade->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_nao_conformidade" class="ew-item-list"></div>
<selection-list hidden
    id="x_nao_conformidade"
    name="x_nao_conformidade"
    value="<?= HtmlEncode($Page->nao_conformidade->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_nao_conformidade"
    data-target="dsl_x_nao_conformidade"
    data-repeatcolumn="5"
    class="form-control<?= $Page->nao_conformidade->isInvalidClass() ?>"
    data-table="relatorio_aud_int"
    data-field="x_nao_conformidade"
    data-value-separator="<?= $Page->nao_conformidade->displayValueSeparatorAttribute() ?>"
    <?= $Page->nao_conformidade->editAttributes() ?>></selection-list>
<?= $Page->nao_conformidade->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nao_conformidade->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="frelatorio_aud_intadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="frelatorio_aud_intadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("relatorio_aud_int");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
