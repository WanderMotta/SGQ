<?php

namespace PHPMaker2024\sgq;

// Page object
$GraficosEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fgraficosedit" id="fgraficosedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { graficos: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fgraficosedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fgraficosedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["idgraficos", [fields.idgraficos.visible && fields.idgraficos.required ? ew.Validators.required(fields.idgraficos.caption) : null], fields.idgraficos.isInvalid],
            ["competencia_idcompetencia", [fields.competencia_idcompetencia.visible && fields.competencia_idcompetencia.required ? ew.Validators.required(fields.competencia_idcompetencia.caption) : null], fields.competencia_idcompetencia.isInvalid],
            ["indicadores_idindicadores", [fields.indicadores_idindicadores.visible && fields.indicadores_idindicadores.required ? ew.Validators.required(fields.indicadores_idindicadores.caption) : null], fields.indicadores_idindicadores.isInvalid],
            ["data_base", [fields.data_base.visible && fields.data_base.required ? ew.Validators.required(fields.data_base.caption) : null], fields.data_base.isInvalid],
            ["valor", [fields.valor.visible && fields.valor.required ? ew.Validators.required(fields.valor.caption) : null, ew.Validators.float], fields.valor.isInvalid],
            ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid]
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
            "competencia_idcompetencia": <?= $Page->competencia_idcompetencia->toClientList($Page) ?>,
            "indicadores_idindicadores": <?= $Page->indicadores_idindicadores->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="graficos">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "indicadores") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="indicadores">
<input type="hidden" name="fk_idindicadores" value="<?= HtmlEncode($Page->indicadores_idindicadores->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idgraficos->Visible) { // idgraficos ?>
    <div id="r_idgraficos"<?= $Page->idgraficos->rowAttributes() ?>>
        <label id="elh_graficos_idgraficos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idgraficos->caption() ?><?= $Page->idgraficos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->idgraficos->cellAttributes() ?>>
<span id="el_graficos_idgraficos">
<span<?= $Page->idgraficos->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idgraficos->getDisplayValue($Page->idgraficos->EditValue))) ?>"></span>
<input type="hidden" data-table="graficos" data-field="x_idgraficos" data-hidden="1" name="x_idgraficos" id="x_idgraficos" value="<?= HtmlEncode($Page->idgraficos->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->competencia_idcompetencia->Visible) { // competencia_idcompetencia ?>
    <div id="r_competencia_idcompetencia"<?= $Page->competencia_idcompetencia->rowAttributes() ?>>
        <label id="elh_graficos_competencia_idcompetencia" for="x_competencia_idcompetencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->competencia_idcompetencia->caption() ?><?= $Page->competencia_idcompetencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->competencia_idcompetencia->cellAttributes() ?>>
<span id="el_graficos_competencia_idcompetencia">
    <select
        id="x_competencia_idcompetencia"
        name="x_competencia_idcompetencia"
        class="form-select ew-select<?= $Page->competencia_idcompetencia->isInvalidClass() ?>"
        <?php if (!$Page->competencia_idcompetencia->IsNativeSelect) { ?>
        data-select2-id="fgraficosedit_x_competencia_idcompetencia"
        <?php } ?>
        data-table="graficos"
        data-field="x_competencia_idcompetencia"
        data-value-separator="<?= $Page->competencia_idcompetencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->competencia_idcompetencia->getPlaceHolder()) ?>"
        <?= $Page->competencia_idcompetencia->editAttributes() ?>>
        <?= $Page->competencia_idcompetencia->selectOptionListHtml("x_competencia_idcompetencia") ?>
    </select>
    <?= $Page->competencia_idcompetencia->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->competencia_idcompetencia->getErrorMessage() ?></div>
<?= $Page->competencia_idcompetencia->Lookup->getParamTag($Page, "p_x_competencia_idcompetencia") ?>
<?php if (!$Page->competencia_idcompetencia->IsNativeSelect) { ?>
<script>
loadjs.ready("fgraficosedit", function() {
    var options = { name: "x_competencia_idcompetencia", selectId: "fgraficosedit_x_competencia_idcompetencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fgraficosedit.lists.competencia_idcompetencia?.lookupOptions.length) {
        options.data = { id: "x_competencia_idcompetencia", form: "fgraficosedit" };
    } else {
        options.ajax = { id: "x_competencia_idcompetencia", form: "fgraficosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.competencia_idcompetencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->indicadores_idindicadores->Visible) { // indicadores_idindicadores ?>
    <div id="r_indicadores_idindicadores"<?= $Page->indicadores_idindicadores->rowAttributes() ?>>
        <label id="elh_graficos_indicadores_idindicadores" for="x_indicadores_idindicadores" class="<?= $Page->LeftColumnClass ?>"><?= $Page->indicadores_idindicadores->caption() ?><?= $Page->indicadores_idindicadores->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->indicadores_idindicadores->cellAttributes() ?>>
<?php if ($Page->indicadores_idindicadores->getSessionValue() != "") { ?>
<span<?= $Page->indicadores_idindicadores->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->indicadores_idindicadores->getDisplayValue($Page->indicadores_idindicadores->ViewValue) ?></span></span>
<input type="hidden" id="x_indicadores_idindicadores" name="x_indicadores_idindicadores" value="<?= HtmlEncode($Page->indicadores_idindicadores->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_graficos_indicadores_idindicadores">
    <select
        id="x_indicadores_idindicadores"
        name="x_indicadores_idindicadores"
        class="form-select ew-select<?= $Page->indicadores_idindicadores->isInvalidClass() ?>"
        <?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
        data-select2-id="fgraficosedit_x_indicadores_idindicadores"
        <?php } ?>
        data-table="graficos"
        data-field="x_indicadores_idindicadores"
        data-value-separator="<?= $Page->indicadores_idindicadores->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->indicadores_idindicadores->getPlaceHolder()) ?>"
        <?= $Page->indicadores_idindicadores->editAttributes() ?>>
        <?= $Page->indicadores_idindicadores->selectOptionListHtml("x_indicadores_idindicadores") ?>
    </select>
    <?= $Page->indicadores_idindicadores->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->indicadores_idindicadores->getErrorMessage() ?></div>
<?= $Page->indicadores_idindicadores->Lookup->getParamTag($Page, "p_x_indicadores_idindicadores") ?>
<?php if (!$Page->indicadores_idindicadores->IsNativeSelect) { ?>
<script>
loadjs.ready("fgraficosedit", function() {
    var options = { name: "x_indicadores_idindicadores", selectId: "fgraficosedit_x_indicadores_idindicadores" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fgraficosedit.lists.indicadores_idindicadores?.lookupOptions.length) {
        options.data = { id: "x_indicadores_idindicadores", form: "fgraficosedit" };
    } else {
        options.ajax = { id: "x_indicadores_idindicadores", form: "fgraficosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.graficos.fields.indicadores_idindicadores.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->data_base->Visible) { // data_base ?>
    <div id="r_data_base"<?= $Page->data_base->rowAttributes() ?>>
        <label id="elh_graficos_data_base" for="x_data_base" class="<?= $Page->LeftColumnClass ?>"><?= $Page->data_base->caption() ?><?= $Page->data_base->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->data_base->cellAttributes() ?>>
<span id="el_graficos_data_base">
<span<?= $Page->data_base->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->data_base->getDisplayValue($Page->data_base->EditValue))) ?>"></span>
<input type="hidden" data-table="graficos" data-field="x_data_base" data-hidden="1" name="x_data_base" id="x_data_base" value="<?= HtmlEncode($Page->data_base->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valor->Visible) { // valor ?>
    <div id="r_valor"<?= $Page->valor->rowAttributes() ?>>
        <label id="elh_graficos_valor" for="x_valor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valor->caption() ?><?= $Page->valor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->valor->cellAttributes() ?>>
<span id="el_graficos_valor">
<input type="<?= $Page->valor->getInputTextType() ?>" name="x_valor" id="x_valor" data-table="graficos" data-field="x_valor" value="<?= $Page->valor->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->valor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->valor->formatPattern()) ?>"<?= $Page->valor->editAttributes() ?> aria-describedby="x_valor_help">
<?= $Page->valor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_graficos_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_graficos_obs">
<input type="<?= $Page->obs->getInputTextType() ?>" name="x_obs" id="x_obs" data-table="graficos" data-field="x_obs" value="<?= $Page->obs->EditValue ?>" size="25" maxlength="100" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->obs->formatPattern()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help">
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fgraficosedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fgraficosedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("graficos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
