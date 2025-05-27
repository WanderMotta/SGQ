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

class ProcessoIndicadoresController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ProcessoIndicadoresList[/{idprocesso_indicadores}]", [PermissionMiddleware::class], "list.processo_indicadores")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoIndicadoresList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ProcessoIndicadoresAdd[/{idprocesso_indicadores}]", [PermissionMiddleware::class], "add.processo_indicadores")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoIndicadoresAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ProcessoIndicadoresView[/{idprocesso_indicadores}]", [PermissionMiddleware::class], "view.processo_indicadores")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoIndicadoresView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ProcessoIndicadoresEdit[/{idprocesso_indicadores}]", [PermissionMiddleware::class], "edit.processo_indicadores")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoIndicadoresEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ProcessoIndicadoresDelete[/{idprocesso_indicadores}]", [PermissionMiddleware::class], "delete.processo_indicadores")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoIndicadoresDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/ProcessoIndicadoresSearch", [PermissionMiddleware::class], "search.processo_indicadores")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoIndicadoresSearch");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ProcessoIndicadoresPreview", [PermissionMiddleware::class], "preview.processo_indicadores")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ProcessoIndicadoresPreview", null, false);
    }
}
