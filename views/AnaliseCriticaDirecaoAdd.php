<?php

namespace PHPMaker2024\sgq;

// Page object
$AnaliseCriticaDirecaoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { analise_critica_direcao: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fanalise_critica_direcaoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fanalise_critica_direcaoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["data", [fields.data.visible && fields.data.required ? ew.Validators.required(fields.data.caption) : null, ew.Validators.datetime(fields.data.clientFormatPattern)], fields.data.isInvalid],
            ["participantes", [fields.participantes.visible && fields.participantes.required ? ew.Validators.required(fields.participantes.caption) : null], fields.participantes.isInvalid],
            ["usuario_idusuario", [fields.usuario_idusuario.visible && fields.usuario_idusuario.required ? ew.Validators.required(fields.usuario_idusuario.caption) : null], fields.usuario_idusuario.isInvalid],
            ["situacao_anterior", [fields.situacao_anterior.visible && fields.situacao_anterior.required ? ew.Validators.required(fields.situacao_anterior.caption) : null], fields.situacao_anterior.isInvalid],
            ["mudanca_sqg", [fields.mudanca_sqg.visible && fields.mudanca_sqg.required ? ew.Validators.required(fields.mudanca_sqg.caption) : null], fields.mudanca_sqg.isInvalid],
            ["desempenho_eficacia", [fields.desempenho_eficacia.visible && fields.desempenho_eficacia.required ? ew.Validators.required(fields.desempenho_eficacia.caption) : null], fields.desempenho_eficacia.isInvalid],
            ["satisfacao_cliente", [fields.satisfacao_cliente.visible && fields.satisfacao_cliente.required ? ew.Validators.required(fields.satisfacao_cliente.caption) : null], fields.satisfacao_cliente.isInvalid],
            ["objetivos_alcancados", [fields.objetivos_alcancados.visible && fields.objetivos_alcancados.required ? ew.Validators.required(fields.objetivos_alcancados.caption) : null], fields.objetivos_alcancados.isInvalid],
            ["desempenho_processo", [fields.desempenho_processo.visible && fields.desempenho_processo.required ? ew.Validators.required(fields.desempenho_processo.caption) : null], fields.desempenho_processo.isInvalid],
            ["nao_confomidade_acoes_corretivas", [fields.nao_confomidade_acoes_corretivas.visible && fields.nao_confomidade_acoes_corretivas.required ? ew.Validators.required(fields.nao_confomidade_acoes_corretivas.caption) : null], fields.nao_confomidade_acoes_corretivas.isInvalid],
            ["monitoramento_medicao", [fields.monitoramento_medicao.visible && fields.monitoramento_medicao.required ? ew.Validators.required(fields.monitoramento_medicao.caption) : null], fields.monitoramento_medicao.isInvalid],
            ["resultado_auditoria", [fields.resultado_auditoria.visible && fields.resultado_auditoria.required ? ew.Validators.required(fields.resultado_auditoria.caption) : null], fields.resultado_auditoria.isInvalid],
            ["desempenho_provedores_ext", [fields.desempenho_provedores_ext.visible && fields.desempenho_provedores_ext.required ? ew.Validators.required(fields.desempenho_provedores_ext.caption) : null], fields.desempenho_provedores_ext.isInvalid],
            ["suficiencia_recursos", [fields.suficiencia_recursos.visible && fields.suficiencia_recursos.required ? ew.Validators.required(fields.suficiencia_recursos.caption) : null], fields.suficiencia_recursos.isInvalid],
            ["acoes_risco_oportunidades", [fields.acoes_risco_oportunidades.visible && fields.acoes_risco_oportunidades.required ? ew.Validators.required(fields.acoes_risco_oportunidades.caption) : null], fields.acoes_risco_oportunidades.isInvalid],
            ["oportunidade_melhora_entrada", [fields.oportunidade_melhora_entrada.visible && fields.oportunidade_melhora_entrada.required ? ew.Validators.required(fields.oportunidade_melhora_entrada.caption) : null], fields.oportunidade_melhora_entrada.isInvalid],
            ["oportunidade_melhora_saida", [fields.oportunidade_melhora_saida.visible && fields.oportunidade_melhora_saida.required ? ew.Validators.required(fields.oportunidade_melhora_saida.caption) : null], fields.oportunidade_melhora_saida.isInvalid],
            ["qualquer_mudanca_sgq", [fields.qualquer_mudanca_sgq.visible && fields.qualquer_mudanca_sgq.required ? ew.Validators.required(fields.qualquer_mudanca_sgq.caption) : null], fields.qualquer_mudanca_sgq.isInvalid],
            ["nec_recurso", [fields.nec_recurso.visible && fields.nec_recurso.required ? ew.Validators.required(fields.nec_recurso.caption) : null], fields.nec_recurso.isInvalid],
            ["anexo", [fields.anexo.visible && fields.anexo.required ? ew.Validators.fileRequired(fields.anexo.caption) : null], fields.anexo.isInvalid]
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

        // Multi-Page
        .setMultiPage(true)

        // Dynamic selection lists
        .setLists({
            "participantes": <?= $Page->participantes->toClientList($Page) ?>,
            "usuario_idusuario": <?= $Page->usuario_idusuario->toClientList($Page) ?>,
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
<form name="fanalise_critica_direcaoadd" id="fanalise_critica_direcaoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="analise_critica_direcao">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_AnaliseCriticaDirecaoAdd"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_analise_critica_direcao1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_analise_critica_direcao1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_analise_critica_direcao2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_analise_critica_direcao2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(3) ?>" data-bs-target="#tab_analise_critica_direcao3" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_analise_critica_direcao3" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(3)) ?>"><?= $Page->pageCaption(3) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(4) ?>" data-bs-target="#tab_analise_critica_direcao4" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_analise_critica_direcao4" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(4)) ?>"><?= $Page->pageCaption(4) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_analise_critica_direcao1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->data->Visible) { // data ?>
    <div id="r_data"<?= $Page->data->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_data" for="x_data" class="<?= $Page->LeftColumnClass ?>"><?= $Page->data->caption() ?><?= $Page->data->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->data->cellAttributes() ?>>
<span id="el_analise_critica_direcao_data">
<input type="<?= $Page->data->getInputTextType() ?>" name="x_data" id="x_data" data-table="analise_critica_direcao" data-field="x_data" value="<?= $Page->data->EditValue ?>" data-page="1" size="10" maxlength="10" placeholder="<?= HtmlEncode($Page->data->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->data->formatPattern()) ?>"<?= $Page->data->editAttributes() ?> aria-describedby="x_data_help">
<?= $Page->data->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->data->getErrorMessage() ?></div>
<?php if (!$Page->data->ReadOnly && !$Page->data->Disabled && !isset($Page->data->EditAttrs["readonly"]) && !isset($Page->data->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fanalise_critica_direcaoadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fanalise_critica_direcaoadd", "x_data", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->participantes->Visible) { // participantes ?>
    <div id="r_participantes"<?= $Page->participantes->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_participantes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->participantes->caption() ?><?= $Page->participantes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->participantes->cellAttributes() ?>>
<span id="el_analise_critica_direcao_participantes">
    <select
        id="x_participantes[]"
        name="x_participantes[]"
        class="form-control ew-select<?= $Page->participantes->isInvalidClass() ?>"
        data-select2-id="fanalise_critica_direcaoadd_x_participantes[]"
        data-table="analise_critica_direcao"
        data-field="x_participantes"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->participantes->caption())) ?>"
        data-modal-lookup="true"
        multiple
        size="1"
        data-page="1"
        data-value-separator="<?= $Page->participantes->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->participantes->getPlaceHolder()) ?>"
        <?= $Page->participantes->editAttributes() ?>>
        <?= $Page->participantes->selectOptionListHtml("x_participantes[]") ?>
    </select>
    <?= $Page->participantes->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->participantes->getErrorMessage() ?></div>
<?= $Page->participantes->Lookup->getParamTag($Page, "p_x_participantes") ?>
<script>
loadjs.ready("fanalise_critica_direcaoadd", function() {
    var options = { name: "x_participantes[]", selectId: "fanalise_critica_direcaoadd_x_participantes[]" };
    options.multiple = true;
    if (fanalise_critica_direcaoadd.lists.participantes?.lookupOptions.length) {
        options.data = { id: "x_participantes[]", form: "fanalise_critica_direcaoadd" };
    } else {
        options.ajax = { id: "x_participantes[]", form: "fanalise_critica_direcaoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.analise_critica_direcao.fields.participantes.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_idusuario->Visible) { // usuario_idusuario ?>
    <div id="r_usuario_idusuario"<?= $Page->usuario_idusuario->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_usuario_idusuario" for="x_usuario_idusuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_idusuario->caption() ?><?= $Page->usuario_idusuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_idusuario->cellAttributes() ?>>
<span id="el_analise_critica_direcao_usuario_idusuario">
    <select
        id="x_usuario_idusuario"
        name="x_usuario_idusuario"
        class="form-select ew-select<?= $Page->usuario_idusuario->isInvalidClass() ?>"
        <?php if (!$Page->usuario_idusuario->IsNativeSelect) { ?>
        data-select2-id="fanalise_critica_direcaoadd_x_usuario_idusuario"
        <?php } ?>
        data-table="analise_critica_direcao"
        data-field="x_usuario_idusuario"
        data-page="1"
        data-value-separator="<?= $Page->usuario_idusuario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->usuario_idusuario->getPlaceHolder()) ?>"
        <?= $Page->usuario_idusuario->editAttributes() ?>>
        <?= $Page->usuario_idusuario->selectOptionListHtml("x_usuario_idusuario") ?>
    </select>
    <?= $Page->usuario_idusuario->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->usuario_idusuario->getErrorMessage() ?></div>
<?= $Page->usuario_idusuario->Lookup->getParamTag($Page, "p_x_usuario_idusuario") ?>
<?php if (!$Page->usuario_idusuario->IsNativeSelect) { ?>
<script>
loadjs.ready("fanalise_critica_direcaoadd", function() {
    var options = { name: "x_usuario_idusuario", selectId: "fanalise_critica_direcaoadd_x_usuario_idusuario" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fanalise_critica_direcaoadd.lists.usuario_idusuario?.lookupOptions.length) {
        options.data = { id: "x_usuario_idusuario", form: "fanalise_critica_direcaoadd" };
    } else {
        options.ajax = { id: "x_usuario_idusuario", form: "fanalise_critica_direcaoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.analise_critica_direcao.fields.usuario_idusuario.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_analise_critica_direcao2" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->situacao_anterior->Visible) { // situacao_anterior ?>
    <div id="r_situacao_anterior"<?= $Page->situacao_anterior->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_situacao_anterior" for="x_situacao_anterior" class="<?= $Page->LeftColumnClass ?>"><?= $Page->situacao_anterior->caption() ?><?= $Page->situacao_anterior->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->situacao_anterior->cellAttributes() ?>>
<span id="el_analise_critica_direcao_situacao_anterior">
<textarea data-table="analise_critica_direcao" data-field="x_situacao_anterior" data-page="2" name="x_situacao_anterior" id="x_situacao_anterior" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->situacao_anterior->getPlaceHolder()) ?>"<?= $Page->situacao_anterior->editAttributes() ?> aria-describedby="x_situacao_anterior_help"><?= $Page->situacao_anterior->EditValue ?></textarea>
<?= $Page->situacao_anterior->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->situacao_anterior->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mudanca_sqg->Visible) { // mudanca_sqg ?>
    <div id="r_mudanca_sqg"<?= $Page->mudanca_sqg->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_mudanca_sqg" for="x_mudanca_sqg" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mudanca_sqg->caption() ?><?= $Page->mudanca_sqg->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mudanca_sqg->cellAttributes() ?>>
<span id="el_analise_critica_direcao_mudanca_sqg">
<textarea data-table="analise_critica_direcao" data-field="x_mudanca_sqg" data-page="2" name="x_mudanca_sqg" id="x_mudanca_sqg" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->mudanca_sqg->getPlaceHolder()) ?>"<?= $Page->mudanca_sqg->editAttributes() ?> aria-describedby="x_mudanca_sqg_help"><?= $Page->mudanca_sqg->EditValue ?></textarea>
<?= $Page->mudanca_sqg->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mudanca_sqg->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desempenho_eficacia->Visible) { // desempenho_eficacia ?>
    <div id="r_desempenho_eficacia"<?= $Page->desempenho_eficacia->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_desempenho_eficacia" for="x_desempenho_eficacia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->desempenho_eficacia->caption() ?><?= $Page->desempenho_eficacia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->desempenho_eficacia->cellAttributes() ?>>
<span id="el_analise_critica_direcao_desempenho_eficacia">
<textarea data-table="analise_critica_direcao" data-field="x_desempenho_eficacia" data-page="2" name="x_desempenho_eficacia" id="x_desempenho_eficacia" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->desempenho_eficacia->getPlaceHolder()) ?>"<?= $Page->desempenho_eficacia->editAttributes() ?> aria-describedby="x_desempenho_eficacia_help"><?= $Page->desempenho_eficacia->EditValue ?></textarea>
<?= $Page->desempenho_eficacia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desempenho_eficacia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->satisfacao_cliente->Visible) { // satisfacao_cliente ?>
    <div id="r_satisfacao_cliente"<?= $Page->satisfacao_cliente->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_satisfacao_cliente" for="x_satisfacao_cliente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->satisfacao_cliente->caption() ?><?= $Page->satisfacao_cliente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->satisfacao_cliente->cellAttributes() ?>>
<span id="el_analise_critica_direcao_satisfacao_cliente">
<textarea data-table="analise_critica_direcao" data-field="x_satisfacao_cliente" data-page="2" name="x_satisfacao_cliente" id="x_satisfacao_cliente" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->satisfacao_cliente->getPlaceHolder()) ?>"<?= $Page->satisfacao_cliente->editAttributes() ?> aria-describedby="x_satisfacao_cliente_help"><?= $Page->satisfacao_cliente->EditValue ?></textarea>
<?= $Page->satisfacao_cliente->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->satisfacao_cliente->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->objetivos_alcancados->Visible) { // objetivos_alcançados ?>
    <div id="r_objetivos_alcancados"<?= $Page->objetivos_alcancados->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_objetivos_alcancados" for="x_objetivos_alcancados" class="<?= $Page->LeftColumnClass ?>"><?= $Page->objetivos_alcancados->caption() ?><?= $Page->objetivos_alcancados->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->objetivos_alcancados->cellAttributes() ?>>
<span id="el_analise_critica_direcao_objetivos_alcancados">
<textarea data-table="analise_critica_direcao" data-field="x_objetivos_alcancados" data-page="2" name="x_objetivos_alcancados" id="x_objetivos_alcancados" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->objetivos_alcancados->getPlaceHolder()) ?>"<?= $Page->objetivos_alcancados->editAttributes() ?> aria-describedby="x_objetivos_alcancados_help"><?= $Page->objetivos_alcancados->EditValue ?></textarea>
<?= $Page->objetivos_alcancados->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->objetivos_alcancados->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desempenho_processo->Visible) { // desempenho_processo ?>
    <div id="r_desempenho_processo"<?= $Page->desempenho_processo->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_desempenho_processo" for="x_desempenho_processo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->desempenho_processo->caption() ?><?= $Page->desempenho_processo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->desempenho_processo->cellAttributes() ?>>
<span id="el_analise_critica_direcao_desempenho_processo">
<textarea data-table="analise_critica_direcao" data-field="x_desempenho_processo" data-page="2" name="x_desempenho_processo" id="x_desempenho_processo" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->desempenho_processo->getPlaceHolder()) ?>"<?= $Page->desempenho_processo->editAttributes() ?> aria-describedby="x_desempenho_processo_help"><?= $Page->desempenho_processo->EditValue ?></textarea>
<?= $Page->desempenho_processo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desempenho_processo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nao_confomidade_acoes_corretivas->Visible) { // nao_confomidade_acoes_corretivas ?>
    <div id="r_nao_confomidade_acoes_corretivas"<?= $Page->nao_confomidade_acoes_corretivas->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_nao_confomidade_acoes_corretivas" for="x_nao_confomidade_acoes_corretivas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nao_confomidade_acoes_corretivas->caption() ?><?= $Page->nao_confomidade_acoes_corretivas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nao_confomidade_acoes_corretivas->cellAttributes() ?>>
<span id="el_analise_critica_direcao_nao_confomidade_acoes_corretivas">
<textarea data-table="analise_critica_direcao" data-field="x_nao_confomidade_acoes_corretivas" data-page="2" name="x_nao_confomidade_acoes_corretivas" id="x_nao_confomidade_acoes_corretivas" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->nao_confomidade_acoes_corretivas->getPlaceHolder()) ?>"<?= $Page->nao_confomidade_acoes_corretivas->editAttributes() ?> aria-describedby="x_nao_confomidade_acoes_corretivas_help"><?= $Page->nao_confomidade_acoes_corretivas->EditValue ?></textarea>
<?= $Page->nao_confomidade_acoes_corretivas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nao_confomidade_acoes_corretivas->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monitoramento_medicao->Visible) { // monitoramento_medicao ?>
    <div id="r_monitoramento_medicao"<?= $Page->monitoramento_medicao->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_monitoramento_medicao" for="x_monitoramento_medicao" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monitoramento_medicao->caption() ?><?= $Page->monitoramento_medicao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monitoramento_medicao->cellAttributes() ?>>
<span id="el_analise_critica_direcao_monitoramento_medicao">
<textarea data-table="analise_critica_direcao" data-field="x_monitoramento_medicao" data-page="2" name="x_monitoramento_medicao" id="x_monitoramento_medicao" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->monitoramento_medicao->getPlaceHolder()) ?>"<?= $Page->monitoramento_medicao->editAttributes() ?> aria-describedby="x_monitoramento_medicao_help"><?= $Page->monitoramento_medicao->EditValue ?></textarea>
<?= $Page->monitoramento_medicao->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monitoramento_medicao->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->resultado_auditoria->Visible) { // resultado_auditoria ?>
    <div id="r_resultado_auditoria"<?= $Page->resultado_auditoria->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_resultado_auditoria" for="x_resultado_auditoria" class="<?= $Page->LeftColumnClass ?>"><?= $Page->resultado_auditoria->caption() ?><?= $Page->resultado_auditoria->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->resultado_auditoria->cellAttributes() ?>>
<span id="el_analise_critica_direcao_resultado_auditoria">
<textarea data-table="analise_critica_direcao" data-field="x_resultado_auditoria" data-page="2" name="x_resultado_auditoria" id="x_resultado_auditoria" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->resultado_auditoria->getPlaceHolder()) ?>"<?= $Page->resultado_auditoria->editAttributes() ?> aria-describedby="x_resultado_auditoria_help"><?= $Page->resultado_auditoria->EditValue ?></textarea>
<?= $Page->resultado_auditoria->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->resultado_auditoria->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desempenho_provedores_ext->Visible) { // desempenho_provedores_ext ?>
    <div id="r_desempenho_provedores_ext"<?= $Page->desempenho_provedores_ext->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_desempenho_provedores_ext" for="x_desempenho_provedores_ext" class="<?= $Page->LeftColumnClass ?>"><?= $Page->desempenho_provedores_ext->caption() ?><?= $Page->desempenho_provedores_ext->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->desempenho_provedores_ext->cellAttributes() ?>>
<span id="el_analise_critica_direcao_desempenho_provedores_ext">
<textarea data-table="analise_critica_direcao" data-field="x_desempenho_provedores_ext" data-page="2" name="x_desempenho_provedores_ext" id="x_desempenho_provedores_ext" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->desempenho_provedores_ext->getPlaceHolder()) ?>"<?= $Page->desempenho_provedores_ext->editAttributes() ?> aria-describedby="x_desempenho_provedores_ext_help"><?= $Page->desempenho_provedores_ext->EditValue ?></textarea>
<?= $Page->desempenho_provedores_ext->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desempenho_provedores_ext->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->suficiencia_recursos->Visible) { // suficiencia_recursos ?>
    <div id="r_suficiencia_recursos"<?= $Page->suficiencia_recursos->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_suficiencia_recursos" for="x_suficiencia_recursos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->suficiencia_recursos->caption() ?><?= $Page->suficiencia_recursos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->suficiencia_recursos->cellAttributes() ?>>
<span id="el_analise_critica_direcao_suficiencia_recursos">
<textarea data-table="analise_critica_direcao" data-field="x_suficiencia_recursos" data-page="2" name="x_suficiencia_recursos" id="x_suficiencia_recursos" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->suficiencia_recursos->getPlaceHolder()) ?>"<?= $Page->suficiencia_recursos->editAttributes() ?> aria-describedby="x_suficiencia_recursos_help"><?= $Page->suficiencia_recursos->EditValue ?></textarea>
<?= $Page->suficiencia_recursos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->suficiencia_recursos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->acoes_risco_oportunidades->Visible) { // acoes_risco_oportunidades ?>
    <div id="r_acoes_risco_oportunidades"<?= $Page->acoes_risco_oportunidades->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_acoes_risco_oportunidades" for="x_acoes_risco_oportunidades" class="<?= $Page->LeftColumnClass ?>"><?= $Page->acoes_risco_oportunidades->caption() ?><?= $Page->acoes_risco_oportunidades->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->acoes_risco_oportunidades->cellAttributes() ?>>
<span id="el_analise_critica_direcao_acoes_risco_oportunidades">
<textarea data-table="analise_critica_direcao" data-field="x_acoes_risco_oportunidades" data-page="2" name="x_acoes_risco_oportunidades" id="x_acoes_risco_oportunidades" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->acoes_risco_oportunidades->getPlaceHolder()) ?>"<?= $Page->acoes_risco_oportunidades->editAttributes() ?> aria-describedby="x_acoes_risco_oportunidades_help"><?= $Page->acoes_risco_oportunidades->EditValue ?></textarea>
<?= $Page->acoes_risco_oportunidades->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->acoes_risco_oportunidades->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->oportunidade_melhora_entrada->Visible) { // oportunidade_melhora_entrada ?>
    <div id="r_oportunidade_melhora_entrada"<?= $Page->oportunidade_melhora_entrada->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_oportunidade_melhora_entrada" for="x_oportunidade_melhora_entrada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->oportunidade_melhora_entrada->caption() ?><?= $Page->oportunidade_melhora_entrada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->oportunidade_melhora_entrada->cellAttributes() ?>>
<span id="el_analise_critica_direcao_oportunidade_melhora_entrada">
<textarea data-table="analise_critica_direcao" data-field="x_oportunidade_melhora_entrada" data-page="2" name="x_oportunidade_melhora_entrada" id="x_oportunidade_melhora_entrada" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->oportunidade_melhora_entrada->getPlaceHolder()) ?>"<?= $Page->oportunidade_melhora_entrada->editAttributes() ?> aria-describedby="x_oportunidade_melhora_entrada_help"><?= $Page->oportunidade_melhora_entrada->EditValue ?></textarea>
<?= $Page->oportunidade_melhora_entrada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->oportunidade_melhora_entrada->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(3) ?>" id="tab_analise_critica_direcao3" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->oportunidade_melhora_saida->Visible) { // oportunidade_melhora_saida ?>
    <div id="r_oportunidade_melhora_saida"<?= $Page->oportunidade_melhora_saida->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_oportunidade_melhora_saida" for="x_oportunidade_melhora_saida" class="<?= $Page->LeftColumnClass ?>"><?= $Page->oportunidade_melhora_saida->caption() ?><?= $Page->oportunidade_melhora_saida->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->oportunidade_melhora_saida->cellAttributes() ?>>
<span id="el_analise_critica_direcao_oportunidade_melhora_saida">
<textarea data-table="analise_critica_direcao" data-field="x_oportunidade_melhora_saida" data-page="3" name="x_oportunidade_melhora_saida" id="x_oportunidade_melhora_saida" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->oportunidade_melhora_saida->getPlaceHolder()) ?>"<?= $Page->oportunidade_melhora_saida->editAttributes() ?> aria-describedby="x_oportunidade_melhora_saida_help"><?= $Page->oportunidade_melhora_saida->EditValue ?></textarea>
<?= $Page->oportunidade_melhora_saida->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->oportunidade_melhora_saida->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->qualquer_mudanca_sgq->Visible) { // qualquer_mudanca_sgq ?>
    <div id="r_qualquer_mudanca_sgq"<?= $Page->qualquer_mudanca_sgq->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_qualquer_mudanca_sgq" for="x_qualquer_mudanca_sgq" class="<?= $Page->LeftColumnClass ?>"><?= $Page->qualquer_mudanca_sgq->caption() ?><?= $Page->qualquer_mudanca_sgq->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->qualquer_mudanca_sgq->cellAttributes() ?>>
<span id="el_analise_critica_direcao_qualquer_mudanca_sgq">
<textarea data-table="analise_critica_direcao" data-field="x_qualquer_mudanca_sgq" data-page="3" name="x_qualquer_mudanca_sgq" id="x_qualquer_mudanca_sgq" cols="50" rows="2" placeholder="<?= HtmlEncode($Page->qualquer_mudanca_sgq->getPlaceHolder()) ?>"<?= $Page->qualquer_mudanca_sgq->editAttributes() ?> aria-describedby="x_qualquer_mudanca_sgq_help"><?= $Page->qualquer_mudanca_sgq->EditValue ?></textarea>
<?= $Page->qualquer_mudanca_sgq->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->qualquer_mudanca_sgq->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nec_recurso->Visible) { // nec_recurso ?>
    <div id="r_nec_recurso"<?= $Page->nec_recurso->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_nec_recurso" for="x_nec_recurso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nec_recurso->caption() ?><?= $Page->nec_recurso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nec_recurso->cellAttributes() ?>>
<span id="el_analise_critica_direcao_nec_recurso">
<input type="<?= $Page->nec_recurso->getInputTextType() ?>" name="x_nec_recurso" id="x_nec_recurso" data-table="analise_critica_direcao" data-field="x_nec_recurso" value="<?= $Page->nec_recurso->EditValue ?>" data-page="3" size="45" maxlength="45" placeholder="<?= HtmlEncode($Page->nec_recurso->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nec_recurso->formatPattern()) ?>"<?= $Page->nec_recurso->editAttributes() ?> aria-describedby="x_nec_recurso_help">
<?= $Page->nec_recurso->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nec_recurso->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(4) ?>" id="tab_analise_critica_direcao4" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->anexo->Visible) { // anexo ?>
    <div id="r_anexo"<?= $Page->anexo->rowAttributes() ?>>
        <label id="elh_analise_critica_direcao_anexo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->anexo->caption() ?><?= $Page->anexo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->anexo->cellAttributes() ?>>
<span id="el_analise_critica_direcao_anexo">
<div id="fd_x_anexo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_anexo"
        name="x_anexo"
        class="form-control ew-file-input"
        title="<?= $Page->anexo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="analise_critica_direcao"
        data-field="x_anexo"
        data-size="120"
        data-accept-file-types="<?= $Page->anexo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->anexo->UploadMaxFileSize ?>"
        data-max-number-of-files="<?= $Page->anexo->UploadMaxFileCount ?>"
        data-disable-image-crop="<?= $Page->anexo->ImageCropper ? 0 : 1 ?>"
        data-page="4"
        multiple
        aria-describedby="x_anexo_help"
        <?= ($Page->anexo->ReadOnly || $Page->anexo->Disabled) ? " disabled" : "" ?>
        <?= $Page->anexo->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFiles") ?></div>
    <?= $Page->anexo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->anexo->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_anexo" id= "fn_x_anexo" value="<?= $Page->anexo->Upload->FileName ?>">
<input type="hidden" name="fa_x_anexo" id= "fa_x_anexo" value="0">
<table id="ft_x_anexo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fanalise_critica_direcaoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fanalise_critica_direcaoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("analise_critica_direcao");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
