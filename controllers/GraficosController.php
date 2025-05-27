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

class GraficosController extends ControllerBase
{
    // EvidenciasxMes (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/GraficosList/EvidenciasxMes", [PermissionMiddleware::class], "list.graficos.EvidenciasxMes")]
    public function EvidenciasxMes(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "GraficosList", "EvidenciasxMes");
    }

    // list
    #[Map(["GET","POST","OPTIONS"], "/GraficosList[/{idgraficos}]", [PermissionMiddleware::class], "list.graficos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GraficosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/GraficosAdd[/{idgraficos}]", [PermissionMiddleware::class], "add.graficos")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GraficosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/GraficosView[/{idgraficos}]", [PermissionMiddleware::class], "view.graficos")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GraficosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/GraficosEdit[/{idgraficos}]", [PermissionMiddleware::class], "edit.graficos")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GraficosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/GraficosDelete[/{idgraficos}]", [PermissionMiddleware::class], "delete.graficos")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GraficosDelete");
    }

    // query
    #[Map(["GET","POST","OPTIONS"], "/GraficosQuery", [PermissionMiddleware::class], "query.graficos")]
    public function query(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GraficosSearch", "GraficosQuery");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/GraficosPreview", [PermissionMiddleware::class], "preview.graficos")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GraficosPreview", null, false);
    }
}
