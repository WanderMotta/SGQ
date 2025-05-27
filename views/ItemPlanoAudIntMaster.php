<?php

namespace PHPMaker2024\sgq;

// Table
$item_plano_aud_int = Container("item_plano_aud_int");
$item_plano_aud_int->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($item_plano_aud_int->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_item_plano_aud_intmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($item_plano_aud_int->iditem_plano_aud_int->Visible) { // iditem_plano_aud_int ?>
        <tr id="r_iditem_plano_aud_int"<?= $item_plano_aud_int->iditem_plano_aud_int->rowAttributes() ?>>
            <td class="<?= $item_plano_aud_int->TableLeftColumnClass ?>"><?= $item_plano_aud_int->iditem_plano_aud_int->caption() ?></td>
            <td<?= $item_plano_aud_int->iditem_plano_aud_int->cellAttributes() ?>>
<span id="el_item_plano_aud_int_iditem_plano_aud_int">
<span<?= $item_plano_aud_int->iditem_plano_aud_int->viewAttributes() ?>>
<?= $item_plano_aud_int->iditem_plano_aud_int->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($item_plano_aud_int->data->Visible) { // data ?>
        <tr id="r_data"<?= $item_plano_aud_int->data->rowAttributes() ?>>
            <td class="<?= $item_plano_aud_int->TableLeftColumnClass ?>"><?= $item_plano_aud_int->data->caption() ?></td>
            <td<?= $item_plano_aud_int->data->cellAttributes() ?>>
<span id="el_item_plano_aud_int_data">
<span<?= $item_plano_aud_int->data->viewAttributes() ?>>
<?= $item_plano_aud_int->data->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($item_plano_aud_int->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <tr id="r_processo_idprocesso"<?= $item_plano_aud_int->processo_idprocesso->rowAttributes() ?>>
            <td class="<?= $item_plano_aud_int->TableLeftColumnClass ?>"><?= $item_plano_aud_int->processo_idprocesso->caption() ?></td>
            <td<?= $item_plano_aud_int->processo_idprocesso->cellAttributes() ?>>
<span id="el_item_plano_aud_int_processo_idprocesso">
<span<?= $item_plano_aud_int->processo_idprocesso->viewAttributes() ?>>
<?= $item_plano_aud_int->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($item_plano_aud_int->escopo->Visible) { // escopo ?>
        <tr id="r_escopo"<?= $item_plano_aud_int->escopo->rowAttributes() ?>>
            <td class="<?= $item_plano_aud_int->TableLeftColumnClass ?>"><?= $item_plano_aud_int->escopo->caption() ?></td>
            <td<?= $item_plano_aud_int->escopo->cellAttributes() ?>>
<span id="el_item_plano_aud_int_escopo">
<span<?= $item_plano_aud_int->escopo->viewAttributes() ?>>
<?= $item_plano_aud_int->escopo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($item_plano_aud_int->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <tr id="r_usuario_idusuario"<?= $item_plano_aud_int->usuario_idusuario->rowAttributes() ?>>
            <td class="<?= $item_plano_aud_int->TableLeftColumnClass ?>"><?= $item_plano_aud_int->usuario_idusuario->caption() ?></td>
            <td<?= $item_plano_aud_int->usuario_idusuario->cellAttributes() ?>>
<span id="el_item_plano_aud_int_usuario_idusuario">
<span<?= $item_plano_aud_int->usuario_idusuario->viewAttributes() ?>>
<?= $item_plano_aud_int->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
