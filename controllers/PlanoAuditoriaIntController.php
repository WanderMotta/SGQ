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

class PlanoAuditoriaIntController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/PlanoAuditoriaIntList[/{idplano_auditoria_int}]", [PermissionMiddleware::class], "list.plano_auditoria_int")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAuditoriaIntList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/PlanoAuditoriaIntAdd[/{idplano_auditoria_int}]", [PermissionMiddleware::class], "add.plano_auditoria_int")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAuditoriaIntAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/PlanoAuditoriaIntView[/{idplano_auditoria_int}]", [PermissionMiddleware::class], "view.plano_auditoria_int")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAuditoriaIntView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/PlanoAuditoriaIntEdit[/{idplano_auditoria_int}]", [PermissionMiddleware::class], "edit.plano_auditoria_int")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAuditoriaIntEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/PlanoAuditoriaIntDelete[/{idplano_auditoria_int}]", [PermissionMiddleware::class], "delete.plano_auditoria_int")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAuditoriaIntDelete");
    }
}
