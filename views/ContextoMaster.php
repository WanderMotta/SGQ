<?php

namespace PHPMaker2024\sgq;

// Table
$contexto = Container("contexto");
$contexto->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($contexto->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_contextomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($contexto->ano->Visible) { // ano ?>
        <tr id="r_ano"<?= $contexto->ano->rowAttributes() ?>>
            <td class="<?= $contexto->TableLeftColumnClass ?>"><?= $contexto->ano->caption() ?></td>
            <td<?= $contexto->ano->cellAttributes() ?>>
<span id="el_contexto_ano">
<span<?= $contexto->ano->viewAttributes() ?>>
<?= $contexto->ano->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($contexto->revisao->Visible) { // revisao ?>
        <tr id="r_revisao"<?= $contexto->revisao->rowAttributes() ?>>
            <td class="<?= $contexto->TableLeftColumnClass ?>"><?= $contexto->revisao->caption() ?></td>
            <td<?= $contexto->revisao->cellAttributes() ?>>
<span id="el_contexto_revisao">
<span<?= $contexto->revisao->viewAttributes() ?>>
<?= $contexto->revisao->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($contexto->data->Visible) { // data ?>
        <tr id="r_data"<?= $contexto->data->rowAttributes() ?>>
            <td class="<?= $contexto->TableLeftColumnClass ?>"><?= $contexto->data->caption() ?></td>
            <td<?= $contexto->data->cellAttributes() ?>>
<span id="el_contexto_data">
<span<?= $contexto->data->viewAttributes() ?>>
<?= $contexto->data->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($contexto->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <tr id="r_usuario_idusuario"<?= $contexto->usuario_idusuario->rowAttributes() ?>>
            <td class="<?= $contexto->TableLeftColumnClass ?>"><?= $contexto->usuario_idusuario->caption() ?></td>
            <td<?= $contexto->usuario_idusuario->cellAttributes() ?>>
<span id="el_contexto_usuario_idusuario">
<span<?= $contexto->usuario_idusuario->viewAttributes() ?>>
<?= $contexto->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($contexto->usuario_idusuario1->Visible) { // usuario_idusuario1 ?>
        <tr id="r_usuario_idusuario1"<?= $contexto->usuario_idusuario1->rowAttributes() ?>>
            <td class="<?= $contexto->TableLeftColumnClass ?>"><?= $contexto->usuario_idusuario1->caption() ?></td>
            <td<?= $contexto->usuario_idusuario1->cellAttributes() ?>>
<span id="el_contexto_usuario_idusuario1">
<span<?= $contexto->usuario_idusuario1->viewAttributes() ?>>
<?= $contexto->usuario_idusuario1->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
