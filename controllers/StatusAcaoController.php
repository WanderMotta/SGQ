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

class StatusAcaoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/StatusAcaoList[/{idstatus_acao}]", [PermissionMiddleware::class], "list.status_acao")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusAcaoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/StatusAcaoAdd[/{idstatus_acao}]", [PermissionMiddleware::class], "add.status_acao")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusAcaoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/StatusAcaoView[/{idstatus_acao}]", [PermissionMiddleware::class], "view.status_acao")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusAcaoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/StatusAcaoEdit[/{idstatus_acao}]", [PermissionMiddleware::class], "edit.status_acao")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusAcaoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/StatusAcaoDelete[/{idstatus_acao}]", [PermissionMiddleware::class], "delete.status_acao")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusAcaoDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/StatusAcaoSearch", [PermissionMiddleware::class], "search.status_acao")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusAcaoSearch");
    }
}
