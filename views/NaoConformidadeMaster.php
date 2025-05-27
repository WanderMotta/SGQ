<?php

namespace PHPMaker2024\sgq;

// Table
$nao_conformidade = Container("nao_conformidade");
$nao_conformidade->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($nao_conformidade->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_nao_conformidademaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($nao_conformidade->idnao_conformidade->Visible) { // idnao_conformidade ?>
        <tr id="r_idnao_conformidade"<?= $nao_conformidade->idnao_conformidade->rowAttributes() ?>>
            <td class="<?= $nao_conformidade->TableLeftColumnClass ?>"><?= $nao_conformidade->idnao_conformidade->caption() ?></td>
            <td<?= $nao_conformidade->idnao_conformidade->cellAttributes() ?>>
<span id="el_nao_conformidade_idnao_conformidade">
<span<?= $nao_conformidade->idnao_conformidade->viewAttributes() ?>>
<?= $nao_conformidade->idnao_conformidade->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nao_conformidade->dt_ocorrencia->Visible) { // dt_ocorrencia ?>
        <tr id="r_dt_ocorrencia"<?= $nao_conformidade->dt_ocorrencia->rowAttributes() ?>>
            <td class="<?= $nao_conformidade->TableLeftColumnClass ?>"><?= $nao_conformidade->dt_ocorrencia->caption() ?></td>
            <td<?= $nao_conformidade->dt_ocorrencia->cellAttributes() ?>>
<span id="el_nao_conformidade_dt_ocorrencia">
<span<?= $nao_conformidade->dt_ocorrencia->viewAttributes() ?>>
<?= $nao_conformidade->dt_ocorrencia->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nao_conformidade->titulo->Visible) { // titulo ?>
        <tr id="r_titulo"<?= $nao_conformidade->titulo->rowAttributes() ?>>
            <td class="<?= $nao_conformidade->TableLeftColumnClass ?>"><?= $nao_conformidade->titulo->caption() ?></td>
            <td<?= $nao_conformidade->titulo->cellAttributes() ?>>
<span id="el_nao_conformidade_titulo">
<span<?= $nao_conformidade->titulo->viewAttributes() ?>>
<?= $nao_conformidade->titulo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nao_conformidade->processo_idprocesso->Visible) { // processo_idprocesso ?>
        <tr id="r_processo_idprocesso"<?= $nao_conformidade->processo_idprocesso->rowAttributes() ?>>
            <td class="<?= $nao_conformidade->TableLeftColumnClass ?>"><?= $nao_conformidade->processo_idprocesso->caption() ?></td>
            <td<?= $nao_conformidade->processo_idprocesso->cellAttributes() ?>>
<span id="el_nao_conformidade_processo_idprocesso">
<span<?= $nao_conformidade->processo_idprocesso->viewAttributes() ?>>
<?= $nao_conformidade->processo_idprocesso->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nao_conformidade->departamentos_iddepartamentos->Visible) { // departamentos_iddepartamentos ?>
        <tr id="r_departamentos_iddepartamentos"<?= $nao_conformidade->departamentos_iddepartamentos->rowAttributes() ?>>
            <td class="<?= $nao_conformidade->TableLeftColumnClass ?>"><?= $nao_conformidade->departamentos_iddepartamentos->caption() ?></td>
            <td<?= $nao_conformidade->departamentos_iddepartamentos->cellAttributes() ?>>
<span id="el_nao_conformidade_departamentos_iddepartamentos">
<span<?= $nao_conformidade->departamentos_iddepartamentos->viewAttributes() ?>>
<?= $nao_conformidade->departamentos_iddepartamentos->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nao_conformidade->status_nc->Visible) { // status_nc ?>
        <tr id="r_status_nc"<?= $nao_conformidade->status_nc->rowAttributes() ?>>
            <td class="<?= $nao_conformidade->TableLeftColumnClass ?>"><?= $nao_conformidade->status_nc->caption() ?></td>
            <td<?= $nao_conformidade->status_nc->cellAttributes() ?>>
<span id="el_nao_conformidade_status_nc">
<span<?= $nao_conformidade->status_nc->viewAttributes() ?>>
<?= $nao_conformidade->status_nc->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($nao_conformidade->plano_acao->Visible) { // plano_acao ?>
        <tr id="r_plano_acao"<?= $nao_conformidade->plano_acao->rowAttributes() ?>>
            <td class="<?= $nao_conformidade->TableLeftColumnClass ?>"><?= $nao_conformidade->plano_acao->caption() ?></td>
            <td<?= $nao_conformidade->plano_acao->cellAttributes() ?>>
<span id="el_nao_conformidade_plano_acao">
<span<?= $nao_conformidade->plano_acao->viewAttributes() ?>>
<?= $nao_conformidade->plano_acao->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
