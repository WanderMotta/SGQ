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

class ProcessoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ProcessoList[/{idprocesso}]", [PermissionMiddleware::class], "list.processo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ProcessoAdd[/{idprocesso}]", [PermissionMiddleware::class], "add.processo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ProcessoView[/{idprocesso}]", [PermissionMiddleware::class], "view.processo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ProcessoEdit[/{idprocesso}]", [PermissionMiddleware::class], "edit.processo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ProcessoDelete[/{idprocesso}]", [PermissionMiddleware::class], "delete.processo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/ProcessoSearch", [PermissionMiddleware::class], "search.processo")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoSearch");
    }
}
