<?php

namespace PHPMaker2024\sgq;

// Dashboard Page object
$Dashboard2 = $Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Dashboard2: currentTable } });
var currentPageID = ew.PAGE_ID = "dashboard";
var currentForm;
var fDashboard2srch;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fDashboard2srch")
        .setPageId("dashboard")
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
<!-- Content Container -->
<div id="ew-report" class="ew-report">
<div class="btn-toolbar ew-toolbar">
<?php
    $Page->ExportOptions->render("body");
    $Page->SearchOptions->render("body");
?>
</div>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<!-- Dashboard Container -->
<div id="ew-dashboard" class="ew-dashboard">
<div class="row">
<div class="<?= $Dashboard2->ItemClassNames[0] ?>">
<div id="Item1" class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $Language->chartPhrase("graficos", "EvidenciasxMes", "ChartCaption") ?></h3>
    <?php if (!$Dashboard2->isExport()) { ?>
        <div class="card-tools">
    <?php if ($Dashboard2->CanRefresh) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= GetUrl("GraficosList/EvidenciasxMes?layout=false&" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport . "") ?>" data-load-on-init="<?= $Page->LoadOnInit ? "true" : "false" ?>"><i class="fa-solid fa-rotate"></i></button>
    <?php } ?>
    <?php if ($Dashboard2->CanMaximize) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fa-solid fa-maximize"></i></button>
    <?php } ?>
    <?php if ($Dashboard2->CanCollapse) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa-solid fa-minus"></i></button>
    <?php } ?>
        </div>
    <?php } ?>
    </div><!-- /.card-header -->
    <div class="card-body">
        <?= $Dashboard2->renderItem($this, 1) ?>
    </div><!-- /.card-body -->
</div><!-- /.card -->
</div>
<div class="<?= $Dashboard2->ItemClassNames[1] ?>">
<div id="Item2" class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $Language->chartPhrase("indicadores", "EvidenciaxMensal", "ChartCaption") ?></h3>
    <?php if (!$Dashboard2->isExport()) { ?>
        <div class="card-tools">
    <?php if ($Dashboard2->CanRefresh) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= GetUrl("IndicadoresList/EvidenciaxMensal?layout=false&" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport . "") ?>" data-load-on-init="<?= $Page->LoadOnInit ? "true" : "false" ?>"><i class="fa-solid fa-rotate"></i></button>
    <?php } ?>
    <?php if ($Dashboard2->CanMaximize) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fa-solid fa-maximize"></i></button>
    <?php } ?>
    <?php if ($Dashboard2->CanCollapse) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa-solid fa-minus"></i></button>
    <?php } ?>
        </div>
    <?php } ?>
    </div><!-- /.card-header -->
    <div class="card-body">
        <?= $Dashboard2->renderItem($this, 2) ?>
    </div><!-- /.card-body -->
</div><!-- /.card -->
</div>
<div class="<?= $Dashboard2->ItemClassNames[2] ?>">
<div id="Item3" class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $Language->chartPhrase("rel_cross_grafico", "EvidenciaxMensal", "ChartCaption") ?></h3>
    <?php if (!$Dashboard2->isExport()) { ?>
        <div class="card-tools">
    <?php if ($Dashboard2->CanRefresh) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= GetUrl("RelCrossGrafico/EvidenciaxMensal?layout=false&" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport . "") ?>" data-load-on-init="<?= $Page->LoadOnInit ? "true" : "false" ?>"><i class="fa-solid fa-rotate"></i></button>
    <?php } ?>
    <?php if ($Dashboard2->CanMaximize) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fa-solid fa-maximize"></i></button>
    <?php } ?>
    <?php if ($Dashboard2->CanCollapse) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa-solid fa-minus"></i></button>
    <?php } ?>
        </div>
    <?php } ?>
    </div><!-- /.card-header -->
    <div class="card-body">
        <?= $Dashboard2->renderItem($this, 3) ?>
    </div><!-- /.card-body -->
</div><!-- /.card -->
</div>
<div class="<?= $Dashboard2->ItemClassNames[3] ?>">
<div id="Item4" class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $Language->chartPhrase("risco_oportunidade", "Severidade", "ChartCaption") ?></h3>
    <?php if (!$Dashboard2->isExport()) { ?>
        <div class="card-tools">
    <?php if ($Dashboard2->CanRefresh) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= GetUrl("RiscoOportunidadeList/Severidade?layout=false&" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport . "") ?>" data-load-on-init="<?= $Page->LoadOnInit ? "true" : "false" ?>"><i class="fa-solid fa-rotate"></i></button>
    <?php } ?>
    <?php if ($Dashboard2->CanMaximize) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fa-solid fa-maximize"></i></button>
    <?php } ?>
    <?php if ($Dashboard2->CanCollapse) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa-solid fa-minus"></i></button>
    <?php } ?>
        </div>
    <?php } ?>
    </div><!-- /.card-header -->
    <div class="card-body">
        <?= $Dashboard2->renderItem($this, 4) ?>
    </div><!-- /.card-body -->
</div><!-- /.card -->
</div>
<div class="<?= $Dashboard2->ItemClassNames[4] ?>">
<div id="Item5" class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $Language->chartPhrase("risco_oportunidade", "GrauAtencao", "ChartCaption") ?></h3>
    <?php if (!$Dashboard2->isExport()) { ?>
        <div class="card-tools">
    <?php if ($Dashboard2->CanRefresh) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= GetUrl("RiscoOportunidadeList/GrauAtencao?layout=false&" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport . "") ?>" data-load-on-init="<?= $Page->LoadOnInit ? "true" : "false" ?>"><i class="fa-solid fa-rotate"></i></button>
    <?php } ?>
    <?php if ($Dashboard2->CanMaximize) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fa-solid fa-maximize"></i></button>
    <?php } ?>
    <?php if ($Dashboard2->CanCollapse) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa-solid fa-minus"></i></button>
    <?php } ?>
        </div>
    <?php } ?>
    </div><!-- /.card-header -->
    <div class="card-body">
        <?= $Dashboard2->renderItem($this, 5) ?>
    </div><!-- /.card-body -->
</div><!-- /.card -->
</div>
</div>
</div>
<!-- /.ew-dashboard -->
</div>
<!-- /.ew-report -->
<script>
loadjs.ready("load", () => jQuery('[data-card-widget="card-refresh"]')
    .on("loaded.fail.lte.cardrefresh", (e, jqXHR, textStatus, errorThrown) => console.error(errorThrown))
    .on("loaded.success.lte.cardrefresh", (e, result) => !ew.getError(result) || console.error(result)));
</script>
<?php if ($Dashboard2->isExport() && !$Dashboard2->isExport("print")) { ?>
<script class="ew-export-dashboard">
loadjs.ready("load", function() {
    ew.exportCustom("ew-dashboard", "<?= $Dashboard2->Export ?>", "Dashboard2");
    loadjs.done("exportdashboard");
});
</script>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
