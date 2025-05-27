<?php

namespace PHPMaker2024\sgq;

// Table
$relatorio_auditoria_interna = Container("relatorio_auditoria_interna");
$relatorio_auditoria_interna->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($relatorio_auditoria_interna->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_relatorio_auditoria_internamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($relatorio_auditoria_interna->idrelatorio_auditoria_interna->Visible) { // idrelatorio_auditoria_interna ?>
        <tr id="r_idrelatorio_auditoria_interna"<?= $relatorio_auditoria_interna->idrelatorio_auditoria_interna->rowAttributes() ?>>
            <td class="<?= $relatorio_auditoria_interna->TableLeftColumnClass ?>"><?= $relatorio_auditoria_interna->idrelatorio_auditoria_interna->caption() ?></td>
            <td<?= $relatorio_auditoria_interna->idrelatorio_auditoria_interna->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_idrelatorio_auditoria_interna">
<span<?= $relatorio_auditoria_interna->idrelatorio_auditoria_interna->viewAttributes() ?>>
<?= $relatorio_auditoria_interna->idrelatorio_auditoria_interna->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($relatorio_auditoria_interna->data->Visible) { // data ?>
        <tr id="r_data"<?= $relatorio_auditoria_interna->data->rowAttributes() ?>>
            <td class="<?= $relatorio_auditoria_interna->TableLeftColumnClass ?>"><?= $relatorio_auditoria_interna->data->caption() ?></td>
            <td<?= $relatorio_auditoria_interna->data->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_data">
<span<?= $relatorio_auditoria_interna->data->viewAttributes() ?>>
<?= $relatorio_auditoria_interna->data->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($relatorio_auditoria_interna->origem_risco_oportunidade_idorigem_risco_oportunidade->Visible) { // origem_risco_oportunidade_idorigem_risco_oportunidade ?>
        <tr id="r_origem_risco_oportunidade_idorigem_risco_oportunidade"<?= $relatorio_auditoria_interna->origem_risco_oportunidade_idorigem_risco_oportunidade->rowAttributes() ?>>
            <td class="<?= $relatorio_auditoria_interna->TableLeftColumnClass ?>"><?= $relatorio_auditoria_interna->origem_risco_oportunidade_idorigem_risco_oportunidade->caption() ?></td>
            <td<?= $relatorio_auditoria_interna->origem_risco_oportunidade_idorigem_risco_oportunidade->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_origem_risco_oportunidade_idorigem_risco_oportunidade">
<span<?= $relatorio_auditoria_interna->origem_risco_oportunidade_idorigem_risco_oportunidade->viewAttributes() ?>>
<?= $relatorio_auditoria_interna->origem_risco_oportunidade_idorigem_risco_oportunidade->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($relatorio_auditoria_interna->auditor->Visible) { // auditor ?>
        <tr id="r_auditor"<?= $relatorio_auditoria_interna->auditor->rowAttributes() ?>>
            <td class="<?= $relatorio_auditoria_interna->TableLeftColumnClass ?>"><?= $relatorio_auditoria_interna->auditor->caption() ?></td>
            <td<?= $relatorio_auditoria_interna->auditor->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_auditor">
<span<?= $relatorio_auditoria_interna->auditor->viewAttributes() ?>>
<?= $relatorio_auditoria_interna->auditor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($relatorio_auditoria_interna->aprovador->Visible) { // aprovador ?>
        <tr id="r_aprovador"<?= $relatorio_auditoria_interna->aprovador->rowAttributes() ?>>
            <td class="<?= $relatorio_auditoria_interna->TableLeftColumnClass ?>"><?= $relatorio_auditoria_interna->aprovador->caption() ?></td>
            <td<?= $relatorio_auditoria_interna->aprovador->cellAttributes() ?>>
<span id="el_relatorio_auditoria_interna_aprovador">
<span<?= $relatorio_auditoria_interna->aprovador->viewAttributes() ?>>
<?= $relatorio_auditoria_interna->aprovador->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
