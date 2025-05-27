<?php

namespace PHPMaker2024\sgq;

// Table
$risco_oportunidade = Container("risco_oportunidade");
$risco_oportunidade->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($risco_oportunidade->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_risco_oportunidademaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($risco_oportunidade->idrisco_oportunidade->Visible) { // idrisco_oportunidade ?>
        <tr id="r_idrisco_oportunidade"<?= $risco_oportunidade->idrisco_oportunidade->rowAttributes() ?>>
            <td class="<?= $risco_oportunidade->TableLeftColumnClass ?>"><?= $risco_oportunidade->idrisco_oportunidade->caption() ?></td>
            <td<?= $risco_oportunidade->idrisco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_idrisco_oportunidade">
<span<?= $risco_oportunidade->idrisco_oportunidade->viewAttributes() ?>>
<?= $risco_oportunidade->idrisco_oportunidade->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($risco_oportunidade->tipo_risco_oportunidade_idtipo_risco_oportunidade->Visible) { // tipo_risco_oportunidade_idtipo_risco_oportunidade ?>
        <tr id="r_tipo_risco_oportunidade_idtipo_risco_oportunidade"<?= $risco_oportunidade->tipo_risco_oportunidade_idtipo_risco_oportunidade->rowAttributes() ?>>
            <td class="<?= $risco_oportunidade->TableLeftColumnClass ?>"><?= $risco_oportunidade->tipo_risco_oportunidade_idtipo_risco_oportunidade->caption() ?></td>
            <td<?= $risco_oportunidade->tipo_risco_oportunidade_idtipo_risco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_tipo_risco_oportunidade_idtipo_risco_oportunidade">
<span<?= $risco_oportunidade->tipo_risco_oportunidade_idtipo_risco_oportunidade->viewAttributes() ?>>
<?= $risco_oportunidade->tipo_risco_oportunidade_idtipo_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($risco_oportunidade->titulo->Visible) { // titulo ?>
        <tr id="r_titulo"<?= $risco_oportunidade->titulo->rowAttributes() ?>>
            <td class="<?= $risco_oportunidade->TableLeftColumnClass ?>"><?= $risco_oportunidade->titulo->caption() ?></td>
            <td<?= $risco_oportunidade->titulo->cellAttributes() ?>>
<span id="el_risco_oportunidade_titulo">
<span<?= $risco_oportunidade->titulo->viewAttributes() ?>>
<?= $risco_oportunidade->titulo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($risco_oportunidade->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <tr id="r_origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $risco_oportunidade->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
            <td class="<?= $risco_oportunidade->TableLeftColumnClass ?>"><?= $risco_oportunidade->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?></td>
            <td<?= $risco_oportunidade->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_origem_risco_oportunidade_idorigem_risco_oportunidade">
<span<?= $risco_oportunidade->origem_risco_oportunidade_idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $risco_oportunidade->origem_risco_oportunidade_idorigem_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($risco_oportunidade->frequencia_idfrequencia->Visible) { // frequencia_idfrequencia ?>
        <tr id="r_frequencia_idfrequencia"<?= $risco_oportunidade->frequencia_idfrequencia->rowAttributes() ?>>
            <td class="<?= $risco_oportunidade->TableLeftColumnClass ?>"><?= $risco_oportunidade->frequencia_idfrequencia->caption() ?></td>
            <td<?= $risco_oportunidade->frequencia_idfrequencia->cellAttributes() ?>>
<span id="el_risco_oportunidade_frequencia_idfrequencia">
<span<?= $risco_oportunidade->frequencia_idfrequencia->viewAttributes() ?>>
<?= $risco_oportunidade->frequencia_idfrequencia->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($risco_oportunidade->impacto_idimpacto->Visible) { // impacto_idimpacto ?>
        <tr id="r_impacto_idimpacto"<?= $risco_oportunidade->impacto_idimpacto->rowAttributes() ?>>
            <td class="<?= $risco_oportunidade->TableLeftColumnClass ?>"><?= $risco_oportunidade->impacto_idimpacto->caption() ?></td>
            <td<?= $risco_oportunidade->impacto_idimpacto->cellAttributes() ?>>
<span id="el_risco_oportunidade_impacto_idimpacto">
<span<?= $risco_oportunidade->impacto_idimpacto->viewAttributes() ?>>
<?= $risco_oportunidade->impacto_idimpacto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($risco_oportunidade->grau_atencao->Visible) { // grau_atencao ?>
        <tr id="r_grau_atencao"<?= $risco_oportunidade->grau_atencao->rowAttributes() ?>>
            <td class="<?= $risco_oportunidade->TableLeftColumnClass ?>"><?= $risco_oportunidade->grau_atencao->caption() ?></td>
            <td<?= $risco_oportunidade->grau_atencao->cellAttributes() ?>>
<span id="el_risco_oportunidade_grau_atencao">
<span<?= $risco_oportunidade->grau_atencao->viewAttributes() ?>>
<?= $risco_oportunidade->grau_atencao->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($risco_oportunidade->acao_risco_oportunidade_idacao_risco_oportunidade->Visible) { // acao_risco_oportunidade_idacao_risco_oportunidade ?>
        <tr id="r_acao_risco_oportunidade_idacao_risco_oportunidade"<?= $risco_oportunidade->acao_risco_oportunidade_idacao_risco_oportunidade->rowAttributes() ?>>
            <td class="<?= $risco_oportunidade->TableLeftColumnClass ?>"><?= $risco_oportunidade->acao_risco_oportunidade_idacao_risco_oportunidade->caption() ?></td>
            <td<?= $risco_oportunidade->acao_risco_oportunidade_idacao_risco_oportunidade->cellAttributes() ?>>
<span id="el_risco_oportunidade_acao_risco_oportunidade_idacao_risco_oportunidade">
<span<?= $risco_oportunidade->acao_risco_oportunidade_idacao_risco_oportunidade->viewAttributes() ?>>
<?= $risco_oportunidade->acao_risco_oportunidade_idacao_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($risco_oportunidade->plano_acao->Visible) { // plano_acao ?>
        <tr id="r_plano_acao"<?= $risco_oportunidade->plano_acao->rowAttributes() ?>>
            <td class="<?= $risco_oportunidade->TableLeftColumnClass ?>"><?= $risco_oportunidade->plano_acao->caption() ?></td>
            <td<?= $risco_oportunidade->plano_acao->cellAttributes() ?>>
<span id="el_risco_oportunidade_plano_acao">
<span<?= $risco_oportunidade->plano_acao->viewAttributes() ?>>
<?= $risco_oportunidade->plano_acao->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
