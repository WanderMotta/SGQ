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

class ContextoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ContextoList[/{idcontexto}]", [PermissionMiddleware::class], "list.contexto")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContextoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ContextoAdd[/{idcontexto}]", [PermissionMiddleware::class], "add.contexto")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContextoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ContextoView[/{idcontexto}]", [PermissionMiddleware::class], "view.contexto")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContextoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ContextoEdit[/{idcontexto}]", [PermissionMiddleware::class], "edit.contexto")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContextoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ContextoDelete[/{idcontexto}]", [PermissionMiddleware::class], "delete.contexto")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ContextoDelete");
    }
}
