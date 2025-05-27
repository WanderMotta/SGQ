<?php

namespace PHPMaker2024\sgq;

// Table
$indicadores = Container("indicadores");
$indicadores->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($indicadores->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_indicadoresmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($indicadores->indicador->Visible) { // indicador ?>
        <tr id="r_indicador"<?= $indicadores->indicador->rowAttributes() ?>>
            <td class="<?= $indicadores->TableLeftColumnClass ?>"><?= $indicadores->indicador->caption() ?></td>
            <td<?= $indicadores->indicador->cellAttributes() ?>>
<span id="el_indicadores_indicador">
<span<?= $indicadores->indicador->viewAttributes() ?>>
<?= $indicadores->indicador->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($indicadores->periodicidade_idperiodicidade->Visible) { // periodicidade_idperiodicidade ?>
        <tr id="r_periodicidade_idperiodicidade"<?= $indicadores->periodicidade_idperiodicidade->rowAttributes() ?>>
            <td class="<?= $indicadores->TableLeftColumnClass ?>"><?= $indicadores->periodicidade_idperiodicidade->caption() ?></td>
            <td<?= $indicadores->periodicidade_idperiodicidade->cellAttributes() ?>>
<span id="el_indicadores_periodicidade_idperiodicidade">
<span<?= $indicadores->periodicidade_idperiodicidade->viewAttributes() ?>>
<?= $indicadores->periodicidade_idperiodicidade->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($indicadores->unidade_medida_idunidade_medida->Visible) { // unidade_medida_idunidade_medida ?>
        <tr id="r_unidade_medida_idunidade_medida"<?= $indicadores->unidade_medida_idunidade_medida->rowAttributes() ?>>
            <td class="<?= $indicadores->TableLeftColumnClass ?>"><?= $indicadores->unidade_medida_idunidade_medida->caption() ?></td>
            <td<?= $indicadores->unidade_medida_idunidade_medida->cellAttributes() ?>>
<span id="el_indicadores_unidade_medida_idunidade_medida">
<span<?= $indicadores->unidade_medida_idunidade_medida->viewAttributes() ?>>
<?= $indicadores->unidade_medida_idunidade_medida->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($indicadores->meta->Visible) { // meta ?>
        <tr id="r_meta"<?= $indicadores->meta->rowAttributes() ?>>
            <td class="<?= $indicadores->TableLeftColumnClass ?>"><?= $indicadores->meta->caption() ?></td>
            <td<?= $indicadores->meta->cellAttributes() ?>>
<span id="el_indicadores_meta">
<span<?= $indicadores->meta->viewAttributes() ?>>
<?= $indicadores->meta->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
