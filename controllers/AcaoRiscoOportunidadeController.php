<?php

namespace PHPMaker2024\sgq;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\sgq\Attributes\Delete;
use PHPMaker2024\sgq\Attributes\Get;
use PHPMaker2024\sgq\Attributes\Map;
use PHPMaker2024\sgq\Attributes\Options;
use PHPMaker2024\sgq\Attributes\Patch;
use PHPMaker2024\sgq\Attributes\Post;
use PHPMaker2024\sgq\Attributes\Put;

class AcaoRiscoOportunidadeController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/AcaoRiscoOportunidadeList[/{idacao_risco_oportunidade}]", [PermissionMiddleware::class], "list.acao_risco_oportunidade")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AcaoRiscoOportunidadeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/AcaoRiscoOportunidadeAdd[/{idacao_risco_oportunidade}]", [PermissionMiddleware::class], "add.acao_risco_oportunidade")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AcaoRiscoOportunidadeAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/AcaoRiscoOportunidadeView[/{idacao_risco_oportunidade}]", [PermissionMiddleware::class], "view.acao_risco_oportunidade")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AcaoRiscoOportunidadeView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/AcaoRiscoOportunidadeEdit[/{idacao_risco_oportunidade}]", [PermissionMiddleware::class], "edit.acao_risco_oportunidade")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AcaoRiscoOportunidadeEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/AcaoRiscoOportunidadeDelete[/{idacao_risco_oportunidade}]", [PermissionMiddleware::class], "delete.acao_risco_oportunidade")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AcaoRiscoOportunidadeDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/AcaoRiscoOportunidadeSearch", [PermissionMiddleware::class], "search.acao_risco_oportunidade")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AcaoRiscoOportunidadeSearch");
    }
}
