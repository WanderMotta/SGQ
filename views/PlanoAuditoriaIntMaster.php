<?php

namespace PHPMaker2024\sgq;

// Table
$plano_auditoria_int = Container("plano_auditoria_int");
$plano_auditoria_int->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($plano_auditoria_int->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_plano_auditoria_intmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($plano_auditoria_int->idplano_auditoria_int->Visible) { // idplano_auditoria_int ?>
        <tr id="r_idplano_auditoria_int"<?= $plano_auditoria_int->idplano_auditoria_int->rowAttributes() ?>>
            <td class="<?= $plano_auditoria_int->TableLeftColumnClass ?>"><?= $plano_auditoria_int->idplano_auditoria_int->caption() ?></td>
            <td<?= $plano_auditoria_int->idplano_auditoria_int->cellAttributes() ?>>
<span id="el_plano_auditoria_int_idplano_auditoria_int">
<span<?= $plano_auditoria_int->idplano_auditoria_int->viewAttributes() ?>>
<?= $plano_auditoria_int->idplano_auditoria_int->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($plano_auditoria_int->data->Visible) { // data ?>
        <tr id="r_data"<?= $plano_auditoria_int->data->rowAttributes() ?>>
            <td class="<?= $plano_auditoria_int->TableLeftColumnClass ?>"><?= $plano_auditoria_int->data->caption() ?></td>
            <td<?= $plano_auditoria_int->data->cellAttributes() ?>>
<span id="el_plano_auditoria_int_data">
<span<?= $plano_auditoria_int->data->viewAttributes() ?>>
<?= $plano_auditoria_int->data->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($plano_auditoria_int->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <tr id="r_usuario_idusuario"<?= $plano_auditoria_int->usuario_idusuario->rowAttributes() ?>>
            <td class="<?= $plano_auditoria_int->TableLeftColumnClass ?>"><?= $plano_auditoria_int->usuario_idusuario->caption() ?></td>
            <td<?= $plano_auditoria_int->usuario_idusuario->cellAttributes() ?>>
<span id="el_plano_auditoria_int_usuario_idusuario">
<span<?= $plano_auditoria_int->usuario_idusuario->viewAttributes() ?>>
<?= $plano_auditoria_int->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($plano_auditoria_int->criterio->Visible) { // criterio ?>
        <tr id="r_criterio"<?= $plano_auditoria_int->criterio->rowAttributes() ?>>
            <td class="<?= $plano_auditoria_int->TableLeftColumnClass ?>"><?= $plano_auditoria_int->criterio->caption() ?></td>
            <td<?= $plano_auditoria_int->criterio->cellAttributes() ?>>
<span id="el_plano_auditoria_int_criterio">
<span<?= $plano_auditoria_int->criterio->viewAttributes() ?>>
<?= $plano_auditoria_int->criterio->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($plano_auditoria_int->arquivo->Visible) { // arquivo ?>
        <tr id="r_arquivo"<?= $plano_auditoria_int->arquivo->rowAttributes() ?>>
            <td class="<?= $plano_auditoria_int->TableLeftColumnClass ?>"><?= $plano_auditoria_int->arquivo->caption() ?></td>
            <td<?= $plano_auditoria_int->arquivo->cellAttributes() ?>>
<span id="el_plano_auditoria_int_arquivo">
<span<?= $plano_auditoria_int->arquivo->viewAttributes() ?>>
<?= GetFileViewTag($plano_auditoria_int->arquivo, $plano_auditoria_int->arquivo->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
