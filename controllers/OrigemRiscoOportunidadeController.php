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

class OrigemRiscoOportunidadeController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/OrigemRiscoOportunidadeList[/{idorigem_risco_oportunidade}]", [PermissionMiddleware::class], "list.origem_risco_oportunidade")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "OrigemRiscoOportunidadeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/OrigemRiscoOportunidadeAdd[/{idorigem_risco_oportunidade}]", [PermissionMiddleware::class], "add.origem_risco_oportunidade")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "OrigemRiscoOportunidadeAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/OrigemRiscoOportunidadeView[/{idorigem_risco_oportunidade}]", [PermissionMiddleware::class], "view.origem_risco_oportunidade")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "OrigemRiscoOportunidadeView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/OrigemRiscoOportunidadeEdit[/{idorigem_risco_oportunidade}]", [PermissionMiddleware::class], "edit.origem_risco_oportunidade")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "OrigemRiscoOportunidadeEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/OrigemRiscoOportunidadeDelete[/{idorigem_risco_oportunidade}]", [PermissionMiddleware::class], "delete.origem_risco_oportunidade")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "OrigemRiscoOportunidadeDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/OrigemRiscoOportunidadeSearch", [PermissionMiddleware::class], "search.origem_risco_oportunidade")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "OrigemRiscoOportunidadeSearch");
    }
}
