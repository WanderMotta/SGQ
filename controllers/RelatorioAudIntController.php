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

class RelatorioAudIntController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/RelatorioAudIntList[/{idrelatorio_aud_int}]", [PermissionMiddleware::class], "list.relatorio_aud_int")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelatorioAudIntList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/RelatorioAudIntAdd[/{idrelatorio_aud_int}]", [PermissionMiddleware::class], "add.relatorio_aud_int")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelatorioAudIntAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/RelatorioAudIntView[/{idrelatorio_aud_int}]", [PermissionMiddleware::class], "view.relatorio_aud_int")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelatorioAudIntView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/RelatorioAudIntEdit[/{idrelatorio_aud_int}]", [PermissionMiddleware::class], "edit.relatorio_aud_int")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelatorioAudIntEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/RelatorioAudIntDelete[/{idrelatorio_aud_int}]", [PermissionMiddleware::class], "delete.relatorio_aud_int")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelatorioAudIntDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/RelatorioAudIntPreview", [PermissionMiddleware::class], "preview.relatorio_aud_int")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelatorioAudIntPreview", null, false);
    }
}
