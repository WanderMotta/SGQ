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

class AnaliseSwotController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/AnaliseSwotList[/{idanalise_swot}]", [PermissionMiddleware::class], "list.analise_swot")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseSwotList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/AnaliseSwotAdd[/{idanalise_swot}]", [PermissionMiddleware::class], "add.analise_swot")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseSwotAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/AnaliseSwotView[/{idanalise_swot}]", [PermissionMiddleware::class], "view.analise_swot")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseSwotView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/AnaliseSwotEdit[/{idanalise_swot}]", [PermissionMiddleware::class], "edit.analise_swot")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseSwotEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/AnaliseSwotDelete[/{idanalise_swot}]", [PermissionMiddleware::class], "delete.analise_swot")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseSwotDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/AnaliseSwotSearch", [PermissionMiddleware::class], "search.analise_swot")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseSwotSearch");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/AnaliseSwotPreview", [PermissionMiddleware::class], "preview.analise_swot")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseSwotPreview", null, false);
    }
}
