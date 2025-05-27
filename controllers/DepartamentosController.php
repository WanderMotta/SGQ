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

class DepartamentosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/DepartamentosList[/{iddepartamentos}]", [PermissionMiddleware::class], "list.departamentos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DepartamentosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/DepartamentosAdd[/{iddepartamentos}]", [PermissionMiddleware::class], "add.departamentos")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DepartamentosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/DepartamentosView[/{iddepartamentos}]", [PermissionMiddleware::class], "view.departamentos")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DepartamentosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/DepartamentosEdit[/{iddepartamentos}]", [PermissionMiddleware::class], "edit.departamentos")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DepartamentosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/DepartamentosDelete[/{iddepartamentos}]", [PermissionMiddleware::class], "delete.departamentos")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DepartamentosDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/DepartamentosSearch", [PermissionMiddleware::class], "search.departamentos")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DepartamentosSearch");
    }
}
