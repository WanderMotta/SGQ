<?php

namespace PHPMaker2023\sgq;

// Table
$competencia = Container("competencia");
?>
<?php if ($competencia->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_competenciamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($competencia->mes->Visible) { // mes ?>
        <tr id="r_mes"<?= $competencia->mes->rowAttributes() ?>>
            <td class="<?= $competencia->TableLeftColumnClass ?>"><?= $competencia->mes->caption() ?></td>
            <td<?= $competencia->mes->cellAttributes() ?>>
<span id="el_competencia_mes">
<span<?= $competencia->mes->viewAttributes() ?>>
<?= $competencia->mes->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($competencia->ano->Visible) { // ano ?>
        <tr id="r_ano"<?= $competencia->ano->rowAttributes() ?>>
            <td class="<?= $competencia->TableLeftColumnClass ?>"><?= $competencia->ano->caption() ?></td>
            <td<?= $competencia->ano->cellAttributes() ?>>
<span id="el_competencia_ano">
<span<?= $competencia->ano->viewAttributes() ?>>
<?= $competencia->ano->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
