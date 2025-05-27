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

class AnaliseNegocioController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/AnaliseNegocioList[/{idanalise_negocio}]", [PermissionMiddleware::class], "list.analise_negocio")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseNegocioList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/AnaliseNegocioAdd[/{idanalise_negocio}]", [PermissionMiddleware::class], "add.analise_negocio")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseNegocioAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/AnaliseNegocioView[/{idanalise_negocio}]", [PermissionMiddleware::class], "view.analise_negocio")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseNegocioView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/AnaliseNegocioEdit[/{idanalise_negocio}]", [PermissionMiddleware::class], "edit.analise_negocio")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseNegocioEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/AnaliseNegocioDelete[/{idanalise_negocio}]", [PermissionMiddleware::class], "delete.analise_negocio")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseNegocioDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/AnaliseNegocioSearch", [PermissionMiddleware::class], "search.analise_negocio")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseNegocioSearch");
    }
}
