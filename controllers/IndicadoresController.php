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

class IndicadoresController extends ControllerBase
{
    // EvidenciaxMensal (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/IndicadoresList/EvidenciaxMensal", [PermissionMiddleware::class], "list.indicadores.EvidenciaxMensal")]
    public function EvidenciaxMensal(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "IndicadoresList", "EvidenciaxMensal");
    }

    // list
    #[Map(["GET","POST","OPTIONS"], "/IndicadoresList[/{idindicadores}]", [PermissionMiddleware::class], "list.indicadores")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "IndicadoresList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/IndicadoresAdd[/{idindicadores}]", [PermissionMiddleware::class], "add.indicadores")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "IndicadoresAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/IndicadoresView[/{idindicadores}]", [PermissionMiddleware::class], "view.indicadores")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "IndicadoresView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/IndicadoresEdit[/{idindicadores}]", [PermissionMiddleware::class], "edit.indicadores")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "IndicadoresEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/IndicadoresDelete[/{idindicadores}]", [PermissionMiddleware::class], "delete.indicadores")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "IndicadoresDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/IndicadoresSearch", [PermissionMiddleware::class], "search.indicadores")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "IndicadoresSearch");
    }

    // query
    #[Map(["GET","POST","OPTIONS"], "/IndicadoresQuery", [PermissionMiddleware::class], "query.indicadores")]
    public function query(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "IndicadoresSearch", "IndicadoresQuery");
    }
}
