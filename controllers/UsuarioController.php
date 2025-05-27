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

class UsuarioController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/UsuarioList[/{idusuario}]", [PermissionMiddleware::class], "list.usuario")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsuarioList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/UsuarioAdd[/{idusuario}]", [PermissionMiddleware::class], "add.usuario")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsuarioAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/UsuarioView[/{idusuario}]", [PermissionMiddleware::class], "view.usuario")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsuarioView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/UsuarioEdit[/{idusuario}]", [PermissionMiddleware::class], "edit.usuario")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsuarioEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/UsuarioDelete[/{idusuario}]", [PermissionMiddleware::class], "delete.usuario")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsuarioDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/UsuarioSearch", [PermissionMiddleware::class], "search.usuario")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsuarioSearch");
    }
}
