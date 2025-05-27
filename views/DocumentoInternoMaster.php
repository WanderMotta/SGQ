<?php

namespace PHPMaker2024\sgq;

// Table
$documento_interno = Container("documento_interno");
$documento_interno->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($documento_interno->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_documento_internomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($documento_interno->iddocumento_interno->Visible) { // iddocumento_interno ?>
        <tr id="r_iddocumento_interno"<?= $documento_interno->iddocumento_interno->rowAttributes() ?>>
            <td class="<?= $documento_interno->TableLeftColumnClass ?>"><?= $documento_interno->iddocumento_interno->caption() ?></td>
            <td<?= $documento_interno->iddocumento_interno->cellAttributes() ?>>
<span id="el_documento_interno_iddocumento_interno">
<span<?= $documento_interno->iddocumento_interno->viewAttributes() ?>>
<?= $documento_interno->iddocumento_interno->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($documento_interno->titulo_documento->Visible) { // titulo_documento ?>
        <tr id="r_titulo_documento"<?= $documento_interno->titulo_documento->rowAttributes() ?>>
            <td class="<?= $documento_interno->TableLeftColumnClass ?>"><?= $documento_interno->titulo_documento->caption() ?></td>
            <td<?= $documento_interno->titulo_documento->cellAttributes() ?>>
<span id="el_documento_interno_titulo_documento">
<span<?= $documento_interno->titulo_documento->viewAttributes() ?>>
<?= $documento_interno->titulo_documento->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($documento_interno->restringir_acesso->Visible) { // restringir_acesso ?>
        <tr id="r_restringir_acesso"<?= $documento_interno->restringir_acesso->rowAttributes() ?>>
            <td class="<?= $documento_interno->TableLeftColumnClass ?>"><?= $documento_interno->restringir_acesso->caption() ?></td>
            <td<?= $documento_interno->restringir_acesso->cellAttributes() ?>>
<span id="el_documento_interno_restringir_acesso">
<span<?= $documento_interno->restringir_acesso->viewAttributes() ?>>
<?= $documento_interno->restringir_acesso->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($documento_interno->categoria_documento_idcategoria_documento->Visible) { // categoria_documento_idcategoria_documento ?>
        <tr id="r_categoria_documento_idcategoria_documento"<?= $documento_interno->categoria_documento_idcategoria_documento->rowAttributes() ?>>
            <td class="<?= $documento_interno->TableLeftColumnClass ?>"><?= $documento_interno->categoria_documento_idcategoria_documento->caption() ?></td>
            <td<?= $documento_interno->categoria_documento_idcategoria_documento->cellAttributes() ?>>
<span id="el_documento_interno_categoria_documento_idcategoria_documento">
<span<?= $documento_interno->categoria_documento_idcategoria_documento->viewAttributes() ?>>
<?= $documento_interno->categoria_documento_idcategoria_documento->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($documento_interno->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <tr id="r_processo_idprocesso"<?= $documento_interno->processo_idprocesso->rowAttributes() ?>>
            <td class="<?= $documento_interno->TableLeftColumnClass ?>"><?= $documento_interno->processo_idprocesso->caption() ?></td>
            <td<?= $documento_interno->processo_idprocesso->cellAttributes() ?>>
<span id="el_documento_interno_processo_idprocesso">
<span<?= $documento_interno->processo_idprocesso->viewAttributes() ?>>
<?= $documento_interno->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($documento_interno->usuario_idusuario->Visible) { // usuario_idusuario ?>
        <tr id="r_usuario_idusuario"<?= $documento_interno->usuario_idusuario->rowAttributes() ?>>
            <td class="<?= $documento_interno->TableLeftColumnClass ?>"><?= $documento_interno->usuario_idusuario->caption() ?></td>
            <td<?= $documento_interno->usuario_idusuario->cellAttributes() ?>>
<span id="el_documento_interno_usuario_idusuario">
<span<?= $documento_interno->usuario_idusuario->viewAttributes() ?>>
<?= $documento_interno->usuario_idusuario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
