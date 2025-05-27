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

class PlanoAcaoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoList[/{idplano_acao}]", [PermissionMiddleware::class], "list.plano_acao")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoAdd[/{idplano_acao}]", [PermissionMiddleware::class], "add.plano_acao")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoView[/{idplano_acao}]", [PermissionMiddleware::class], "view.plano_acao")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoEdit[/{idplano_acao}]", [PermissionMiddleware::class], "edit.plano_acao")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoDelete[/{idplano_acao}]", [PermissionMiddleware::class], "delete.plano_acao")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoSearch", [PermissionMiddleware::class], "search.plano_acao")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoSearch");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/PlanoAcaoPreview", [PermissionMiddleware::class], "preview.plano_acao")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoPreview", null, false);
    }
}
