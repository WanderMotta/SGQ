<?php

namespace PHPMaker2024\sgq;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\sgq\Attributes\Delete;
use PHPMaker2024\sgq\Attributes\Get;
use PHPMaker2024\sgq\Attributes\Map;
use PHPMaker2024\sgq\Attributes\Options;
use PHPMaker2024\sgq\Attributes\Patch;
use PHPMaker2024\sgq\Attributes\Post;
use PHPMaker2024\sgq\Attributes\Put;

/**
 * rel_cross_grafico controller
 */
class RelCrossGraficoController extends ControllerBase
{
    // crosstab
    #[Map(["GET", "POST", "OPTIONS"], "/RelCrossGrafico", [PermissionMiddleware::class], "crosstab.rel_cross_grafico")]
    public function crosstab(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelCrossGraficoCrosstab");
    }

    // EvidenciaxMensal (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/RelCrossGrafico/EvidenciaxMensal", [PermissionMiddleware::class], "crosstab.rel_cross_grafico.EvidenciaxMensal")]
    public function EvidenciaxMensal(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "RelCrossGraficoCrosstab", "EvidenciaxMensal");
    }
}
