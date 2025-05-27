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

class RiscoOportunidadeController extends ControllerBase
{
    // Severidade (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/RiscoOportunidadeList/Severidade", [PermissionMiddleware::class], "list.risco_oportunidade.Severidade")]
    public function Severidade(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "RiscoOportunidadeList", "Severidade");
    }

    // GrauAtencao (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/RiscoOportunidadeList/GrauAtencao", [PermissionMiddleware::class], "list.risco_oportunidade.GrauAtencao")]
    public function GrauAtencao(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "RiscoOportunidadeList", "GrauAtencao");
    }

    // list
    #[Map(["GET","POST","OPTIONS"], "/RiscoOportunidadeList[/{idrisco_oportunidade}]", [PermissionMiddleware::class], "list.risco_oportunidade")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RiscoOportunidadeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/RiscoOportunidadeAdd[/{idrisco_oportunidade}]", [PermissionMiddleware::class], "add.risco_oportunidade")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RiscoOportunidadeAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/RiscoOportunidadeView[/{idrisco_oportunidade}]", [PermissionMiddleware::class], "view.risco_oportunidade")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RiscoOportunidadeView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/RiscoOportunidadeEdit[/{idrisco_oportunidade}]", [PermissionMiddleware::class], "edit.risco_oportunidade")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RiscoOportunidadeEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/RiscoOportunidadeDelete[/{idrisco_oportunidade}]", [PermissionMiddleware::class], "delete.risco_oportunidade")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RiscoOportunidadeDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/RiscoOportunidadeSearch", [PermissionMiddleware::class], "search.risco_oportunidade")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RiscoOportunidadeSearch");
    }

    // query
    #[Map(["GET","POST","OPTIONS"], "/RiscoOportunidadeQuery", [PermissionMiddleware::class], "query.risco_oportunidade")]
    public function query(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RiscoOportunidadeSearch", "RiscoOportunidadeQuery");
    }
}
