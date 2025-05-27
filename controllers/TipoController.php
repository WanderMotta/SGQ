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

class TipoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TipoList[/{idtipo}]", [PermissionMiddleware::class], "list.tipo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TipoAdd[/{idtipo}]", [PermissionMiddleware::class], "add.tipo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TipoView[/{idtipo}]", [PermissionMiddleware::class], "view.tipo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TipoEdit[/{idtipo}]", [PermissionMiddleware::class], "edit.tipo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TipoDelete[/{idtipo}]", [PermissionMiddleware::class], "delete.tipo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TipoDelete");
    }
}
