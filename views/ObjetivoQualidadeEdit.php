<?php

namespace PHPMaker2024\sgq;

// Page object
$ObjetivoQualidadeEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fobjetivo_qualidadeedit" id="fobjetivo_qualidadeedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { objetivo_qualidade: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fobjetivo_qualidadeedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fobjetivo_qualidadeedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idobjetivo_qualidade", [fields.idobjetivo_qualidade.visible && fields.idobjetivo_qualidade.required ? ew.Validators.required(fields.idobjetivo_qualidade.caption) : null], fields.idobjetivo_qualidade.isInvalid],
            ["dt_cadastro", [fields.dt_cadastro.visible && fields.dt_cadastro.required ? ew.Validators.required(fields.dt_cadastro.caption) : null], fields.dt_cadastro.isInvalid],
            ["processo_idprocesso", [fields.processo_idprocesso.visible && fields.processo_idprocesso.required ? ew.Validators.required(fields.processo_idprocesso.caption) : null], fields.processo_idprocesso.isInvalid],
            ["objetivo", [fields.objetivo.visible && fields.objetivo.required ? ew.Validators.required(fields.objetivo.caption) : null], fields.objetivo.isInvalid],
            ["como_medir", [fields.como_medir.visible && fields.como_medir.required ? ew.Validators.required(fields.como_medir.caption) : null], fields.como_medir.isInvalid],
            ["o_q_sera_feito", [fields.o_q_sera_feito.visible && fields.o_q_sera_feito.required ? ew.Validators.required(fields.o_q_sera_feito.caption) : null], fields.o_q_sera_feito.isInvalid],
            ["como_avaliar", [fields.como_avaliar.visible && fields.como_avaliar.required ? ew.Validators.required(fields.como_avaliar.caption) : null], fields.como_avaliar.isInvalid],
            ["departamentos_iddepartamentos", [fields.departamentos_iddepartamentos.visible && fields.departamentos_iddepartamentos.required ? ew.Validators.required(fields.departamentos_iddepartamentos.caption) : null], fields.departamentos_iddepartamentos.isInvalid]
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
            "departamentos_iddepartamentos": <?= $Page->departamentos_iddepartamentos->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="objetivo_qualidade">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idobjetivo_qualidade->Visible) { // idobjetivo_qualidade ?>
    <div id="r_idobjetivo_qualidade"<?= $Page->idobjetivo_qualidade->rowAttributes() ?>>
        <label id="elh_objetivo_qualidade_idobjetivo_qualidade" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idobjetivo_qualidade->caption() ?><?= $Page->idobjetivo_qualidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idobjetivo_qualidade->cellAttributes() ?>>
<span id="el_objetivo_qualidade_idobjetivo_qualidade">
<span<?= $Page->idobjetivo_qualidade->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idobjetivo_qualidade->getDisplayValue($Page->idobjetivo_qualidade->EditValue))) ?>"></span>
<input type="hidden" data-table="objetivo_qualidade" data-field="x_idobjetivo_qualidade" data-hidden="1" name="x_idobjetivo_qualidade" id="x_idobjetivo_qualidade" value="<?= HtmlEncode($Page->idobjetivo_qualidade->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->processo_idprocesso->Visible) { // processo_idprocesso ?>
    <div id="r_processo_idprocesso"<?= $Page->processo_idprocesso->rowAttributes() ?>>
        <label id="elh_objetivo_qualidade_processo_idprocesso" for="x_processo_idprocesso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->processo_idprocesso->caption() ?><?= $Page->processo_idprocesso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->processo_idprocesso->cellAttributes() ?>>
<span id="el_objetivo_qualidade_processo_idprocesso">
    <select
        id="x_processo_idprocesso"
        name="x_processo_idprocesso"
        class="form-select ew-select<?= $Page->processo_idprocesso->isInvalidClass() ?>"
        <?php if (!$Page->processo_idprocesso->IsNativeSelect) { ?>
        data-select2-id="fobjetivo_qualidadeedit_x_processo_idprocesso"
        <?php } ?>
        data-table="objetivo_qualidade"
        data-field="x_processo_idprocesso"
        data-value-separator="<?= $Page->processo_idprocesso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->processo_idprocesso->getPlaceHolder()) ?>"
        <?= $Page->processo_idprocesso->editAttributes() ?>>
        <?= $Page->processo_idprocesso->selectOptionListHtml("x_processo_idprocesso") ?>
    </select>
    <?= $Page->processo_idprocesso->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->processo_idprocesso->getErrorMessage() ?></div>
<?= $Page->processo_idprocesso->Lookup->getParamTag($Page, "p_x_processo_idprocesso") ?>
<?php if (!$Page->processo_idprocesso->IsNativeSelect) { ?>
<script>
loadjs.ready("fobjetivo_qualidadeedit", function() {
    var options = { name: "x_processo_idprocesso", selectId: "fobjetivo_qualidadeedit_x_processo_idprocesso" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fobjetivo_qualidadeedit.lists.processo_idprocesso?.lookupOptions.length) {
        options.data = { id: "x_processo_idprocesso", form: "fobjetivo_qualidadeedit" };
    } else {
        options.ajax = { id: "x_processo_idprocesso", form: "fobjetivo_qualidadeedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.objetivo_qualidade.fields.processo_idprocesso.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->objetivo->Visible) { // objetivo ?>
    <div id="r_objetivo"<?= $Page->objetivo->rowAttributes() ?>>
        <label id="elh_objetivo_qualidade_objetivo" for="x_objetivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->objetivo->caption() ?><?= $Page->objetivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->objetivo->cellAttributes() ?>>
<span id="el_objetivo_qualidade_objetivo">
<textarea data-table="objetivo_qualidade" data-field="x_objetivo" name="x_objetivo" id="x_objetivo" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->objetivo->getPlaceHolder()) ?>"<?= $Page->objetivo->editAttributes() ?> aria-describedby="x_objetivo_help"><?= $Page->objetivo->EditValue ?></textarea>
<?= $Page->objetivo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->objetivo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->como_medir->Visible) { // como_medir ?>
    <div id="r_como_medir"<?= $Page->como_medir->rowAttributes() ?>>
        <label id="elh_objetivo_qualidade_como_medir" for="x_como_medir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->como_medir->caption() ?><?= $Page->como_medir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->como_medir->cellAttributes() ?>>
<span id="el_objetivo_qualidade_como_medir">
<textarea data-table="objetivo_qualidade" data-field="x_como_medir" name="x_como_medir" id="x_como_medir" cols="20" rows="2" placeholder="<?= HtmlEncode($Page->como_medir->getPlaceHolder()) ?>"<?= $Page->como_medir->editAttributes() ?> aria-describedby="x_como_medir_help"><?= $Page->como_medir->EditValue ?></textarea>
<?= $Page->como_medir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->como_medir->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->o_q_sera_feito->Visible) { // o_q_sera_feito ?>
    <div id="r_o_q_sera_feito"<?= $Page->o_q_sera_feito->rowAttributes() ?>>
        <label id="elh_objetivo_qualidade_o_q_sera_feito" for="x_o_q_sera_feito" class="<?= $Page->LeftColumnClass ?>"><?= $Page->o_q_sera_feito->caption() ?><?= $Page->o_q_sera_feito->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->o_q_sera_feito->cellAttributes() ?>>
<span id="el_objetivo_qualidade_o_q_sera_feito">
<textarea data-table="objetivo_qualidade" data-field="x_o_q_sera_feito" name="x_o_q_sera_feito" id="x_o_q_sera_feito" cols="20" rows="2" placeholder="<?= HtmlEncode($Page->o_q_sera_feito->getPlaceHolder()) ?>"<?= $Page->o_q_sera_feito->editAttributes() ?> aria-describedby="x_o_q_sera_feito_help"><?= $Page->o_q_sera_feito->EditValue ?></textarea>
<?= $Page->o_q_sera_feito->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->o_q_sera_feito->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->como_avaliar->Visible) { // como_avaliar ?>
    <div id="r_como_avaliar"<?= $Page->como_avaliar->rowAttributes() ?>>
        <label id="elh_objetivo_qualidade_como_avaliar" for="x_como_avaliar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->como_avaliar->caption() ?><?= $Page->como_avaliar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->como_avaliar->cellAttributes() ?>>
<span id="el_objetivo_qualidade_como_avaliar">
<textarea data-table="objetivo_qualidade" data-field="x_como_avaliar" name="x_como_avaliar" id="x_como_avaliar" cols="20" rows="2" placeholder="<?= HtmlEncode($Page->como_avaliar->getPlaceHolder()) ?>"<?= $Page->como_avaliar->editAttributes() ?> aria-describedby="x_como_avaliar_help"><?= $Page->como_avaliar->EditValue ?></textarea>
<?= $Page->como_avaliar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->como_avaliar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
    <div id="r_departamentos_iddepartamentos"<?= $Page->departamentos_iddepartamentos->rowAttributes() ?>>
        <label id="elh_objetivo_qualidade_departamentos_iddepartamentos" for="x_departamentos_iddepartamentos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->departamentos_iddepartamentos->caption() ?><?= $Page->departamentos_iddepartamentos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el_objetivo_qualidade_departamentos_iddepartamentos">
    <select
        id="x_departamentos_iddepartamentos"
        name="x_departamentos_iddepartamentos"
        class="form-select ew-select<?= $Page->departamentos_iddepartamentos->isInvalidClass() ?>"
        <?php if (!$Page->departamentos_iddepartamentos->IsNativeSelect) { ?>
        data-select2-id="fobjetivo_qualidadeedit_x_departamentos_iddepartamentos"
        <?php } ?>
        data-table="objetivo_qualidade"
        data-field="x_departamentos_iddepartamentos"
        data-value-separator="<?= $Page->departamentos_iddepartamentos->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->departamentos_iddepartamentos->getPlaceHolder()) ?>"
        <?= $Page->departamentos_iddepartamentos->editAttributes() ?>>
        <?= $Page->departamentos_iddepartamentos->selectOptionListHtml("x_departamentos_iddepartamentos") ?>
    </select>
    <?= $Page->departamentos_iddepartamentos->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->departamentos_iddepartamentos->getErrorMessage() ?></div>
<?= $Page->departamentos_iddepartamentos->Lookup->getParamTag($Page, "p_x_departamentos_iddepartamentos") ?>
<?php if (!$Page->departamentos_iddepartamentos->IsNativeSelect) { ?>
<script>
loadjs.ready("fobjetivo_qualidadeedit", function() {
    var options = { name: "x_departamentos_iddepartamentos", selectId: "fobjetivo_qualidadeedit_x_departamentos_iddepartamentos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fobjetivo_qualidadeedit.lists.departamentos_iddepartamentos?.lookupOptions.length) {
        options.data = { id: "x_departamentos_iddepartamentos", form: "fobjetivo_qualidadeedit" };
    } else {
        options.ajax = { id: "x_departamentos_iddepartamentos", form: "fobjetivo_qualidadeedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.objetivo_qualidade.fields.departamentos_iddepartamentos.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fobjetivo_qualidadeedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fobjetivo_qualidadeedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("objetivo_qualidade");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
