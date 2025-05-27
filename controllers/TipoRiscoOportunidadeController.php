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

class TipoRiscoOportunidadeController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TipoRiscoOportunidadeList[/{idtipo_risco_oportunidade}]", [PermissionMiddleware::class], "list.tipo_risco_oportunidade")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoRiscoOportunidadeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TipoRiscoOportunidadeAdd[/{idtipo_risco_oportunidade}]", [PermissionMiddleware::class], "add.tipo_risco_oportunidade")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoRiscoOportunidadeAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TipoRiscoOportunidadeView[/{idtipo_risco_oportunidade}]", [PermissionMiddleware::class], "view.tipo_risco_oportunidade")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoRiscoOportunidadeView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TipoRiscoOportunidadeEdit[/{idtipo_risco_oportunidade}]", [PermissionMiddleware::class], "edit.tipo_risco_oportunidade")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoRiscoOportunidadeEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TipoRiscoOportunidadeDelete[/{idtipo_risco_oportunidade}]", [PermissionMiddleware::class], "delete.tipo_risco_oportunidade")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoRiscoOportunidadeDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/TipoRiscoOportunidadeSearch", [PermissionMiddleware::class], "search.tipo_risco_oportunidade")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoRiscoOportunidadeSearch");
    }
}
