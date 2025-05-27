<?php

namespace PHPMaker2024\sgq;

// Table
$processo = Container("processo");
$processo->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($processo->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_processomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($processo->dt_cadastro->Visible) { // dt_cadastro ?>
        <tr id="r_dt_cadastro"<?= $processo->dt_cadastro->rowAttributes() ?>>
            <td class="<?= $processo->TableLeftColumnClass ?>"><?= $processo->dt_cadastro->caption() ?></td>
            <td<?= $processo->dt_cadastro->cellAttributes() ?>>
<span id="el_processo_dt_cadastro">
<span<?= $processo->dt_cadastro->viewAttributes() ?>>
<?= $processo->dt_cadastro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($processo->revisao->Visible) { // revisao ?>
        <tr id="r_revisao"<?= $processo->revisao->rowAttributes() ?>>
            <td class="<?= $processo->TableLeftColumnClass ?>"><?= $processo->revisao->caption() ?></td>
            <td<?= $processo->revisao->cellAttributes() ?>>
<span id="el_processo_revisao">
<span<?= $processo->revisao->viewAttributes() ?>>
<?= $processo->revisao->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($processo->tipo_idtipo->Visible) { // tipo_idtipo ?>
        <tr id="r_tipo_idtipo"<?= $processo->tipo_idtipo->rowAttributes() ?>>
            <td class="<?= $processo->TableLeftColumnClass ?>"><?= $processo->tipo_idtipo->caption() ?></td>
            <td<?= $processo->tipo_idtipo->cellAttributes() ?>>
<span id="el_processo_tipo_idtipo">
<span<?= $processo->tipo_idtipo->viewAttributes() ?>>
<?= $processo->tipo_idtipo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($processo->processo->Visible) { // processo ?>
        <tr id="r_processo"<?= $processo->processo->rowAttributes() ?>>
            <td class="<?= $processo->TableLeftColumnClass ?>"><?= $processo->processo->caption() ?></td>
            <td<?= $processo->processo->cellAttributes() ?>>
<span id="el_processo_processo">
<span<?= $processo->processo->viewAttributes() ?>>
<?= $processo->processo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($processo->responsaveis->Visible) { // responsaveis ?>
        <tr id="r_responsaveis"<?= $processo->responsaveis->rowAttributes() ?>>
            <td class="<?= $processo->TableLeftColumnClass ?>"><?= $processo->responsaveis->caption() ?></td>
            <td<?= $processo->responsaveis->cellAttributes() ?>>
<span id="el_processo_responsaveis">
<span<?= $processo->responsaveis->viewAttributes() ?>>
<?= $processo->responsaveis->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($processo->entradas->Visible) { // entradas ?>
        <tr id="r_entradas"<?= $processo->entradas->rowAttributes() ?>>
            <td class="<?= $processo->TableLeftColumnClass ?>"><?= $processo->entradas->caption() ?></td>
            <td<?= $processo->entradas->cellAttributes() ?>>
<span id="el_processo_entradas">
<span<?= $processo->entradas->viewAttributes() ?>>
<?= $processo->entradas->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($processo->atividade_principal->Visible) { // atividade_principal ?>
        <tr id="r_atividade_principal"<?= $processo->atividade_principal->rowAttributes() ?>>
            <td class="<?= $processo->TableLeftColumnClass ?>"><?= $processo->atividade_principal->caption() ?></td>
            <td<?= $processo->atividade_principal->cellAttributes() ?>>
<span id="el_processo_atividade_principal">
<span<?= $processo->atividade_principal->viewAttributes() ?>>
<?= $processo->atividade_principal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($processo->saidas_resultados->Visible) { // saidas_resultados ?>
        <tr id="r_saidas_resultados"<?= $processo->saidas_resultados->rowAttributes() ?>>
            <td class="<?= $processo->TableLeftColumnClass ?>"><?= $processo->saidas_resultados->caption() ?></td>
            <td<?= $processo->saidas_resultados->cellAttributes() ?>>
<span id="el_processo_saidas_resultados">
<span<?= $processo->saidas_resultados->viewAttributes() ?>>
<?= $processo->saidas_resultados->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($processo->formulario->Visible) { // formulario ?>
        <tr id="r_formulario"<?= $processo->formulario->rowAttributes() ?>>
            <td class="<?= $processo->TableLeftColumnClass ?>"><?= $processo->formulario->caption() ?></td>
            <td<?= $processo->formulario->cellAttributes() ?>>
<span id="el_processo_formulario">
<span<?= $processo->formulario->viewAttributes() ?>>
<?= GetFileViewTag($processo->formulario, $processo->formulario->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
