<?php

namespace PHPMaker2024\sgq;

// Traces
$trace = @$Error["error"]["trace"];
if ($trace) {
    $card = preg_replace('/<button.+><\/button>/i', "", Config("DEBUG_MESSAGE_TEMPLATE"));
    $debug = $Language->phrase("Debug") ?: "Debug";
    $pre = "<pre>" . $Error["error"]["trace"] . "</pre>";
    $trace = str_replace(["%t", "%s"], [$debug, $pre], $card);
}
?>
<div class="error-page">
    <?php if (@$Error["statusCode"] > 200) { ?>
    <h2 class="headline <?= @$Error["error"]["class"] ?>"><?= $Error["statusCode"] ?></h2>
    <?php } ?>
    <div class="error-content">
        <?php if (@$Error["error"]["type"]) { ?>
        <h3><i class="fa-solid fa-triangle-exclamation <?= @$Error["error"]["class"] ?>"></i> <?= @$Error["error"]["type"] ?></h3>
        <?php } ?>
        <p><?= HtmlEncode(@$Error["error"]["description"]) ?></p>
        <?= $trace ?>
    </div>
    <!-- /.error-content -->
</div>
<!-- /.error-page -->
