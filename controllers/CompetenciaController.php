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

class CompetenciaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CompetenciaList[/{idcompetencia}]", [PermissionMiddleware::class], "list.competencia")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CompetenciaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/CompetenciaAdd[/{idcompetencia}]", [PermissionMiddleware::class], "add.competencia")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CompetenciaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/CompetenciaView[/{idcompetencia}]", [PermissionMiddleware::class], "view.competencia")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CompetenciaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CompetenciaEdit[/{idcompetencia}]", [PermissionMiddleware::class], "edit.competencia")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CompetenciaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/CompetenciaDelete[/{idcompetencia}]", [PermissionMiddleware::class], "delete.competencia")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CompetenciaDelete");
    }
}
