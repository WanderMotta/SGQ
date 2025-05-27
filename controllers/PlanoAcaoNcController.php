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

class PlanoAcaoNcController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoNcList[/{idplano_acao_nc}]", [PermissionMiddleware::class], "list.plano_acao_nc")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoNcList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoNcAdd[/{idplano_acao_nc}]", [PermissionMiddleware::class], "add.plano_acao_nc")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoNcAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoNcView[/{idplano_acao_nc}]", [PermissionMiddleware::class], "view.plano_acao_nc")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoNcView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoNcEdit[/{idplano_acao_nc}]", [PermissionMiddleware::class], "edit.plano_acao_nc")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoNcEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoNcDelete[/{idplano_acao_nc}]", [PermissionMiddleware::class], "delete.plano_acao_nc")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoNcDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/PlanoAcaoNcSearch", [PermissionMiddleware::class], "search.plano_acao_nc")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoNcSearch");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/PlanoAcaoNcPreview", [PermissionMiddleware::class], "preview.plano_acao_nc")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PlanoAcaoNcPreview", null, false);
    }
}
