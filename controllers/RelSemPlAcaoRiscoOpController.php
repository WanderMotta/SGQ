<?php

namespace PHPMaker2023\sgq;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * rel_sem_pl_acao_risco_op controller
 */
class RelSemPlAcaoRiscoOpController extends ControllerBase
{
    // summary
    public function summary(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelSemPlAcaoRiscoOpSummary");
    }
}
