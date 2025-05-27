<?php

namespace PHPMaker2023\sgq;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * rel_cross_graficos controller
 */
class RelCrossGraficosController extends ControllerBase
{
    // crosstab
    public function crosstab(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelCrossGraficosCrosstab");
    }

    // EvidenciasxMes
    public function EvidenciasxMes(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "RelCrossGraficosCrosstab", "EvidenciasxMes");
    }
}
