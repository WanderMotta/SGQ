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

class ImpactoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ImpactoList[/{idimpacto}]", [PermissionMiddleware::class], "list.impacto")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImpactoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ImpactoAdd[/{idimpacto}]", [PermissionMiddleware::class], "add.impacto")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImpactoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ImpactoView[/{idimpacto}]", [PermissionMiddleware::class], "view.impacto")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImpactoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ImpactoEdit[/{idimpacto}]", [PermissionMiddleware::class], "edit.impacto")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImpactoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ImpactoDelete[/{idimpacto}]", [PermissionMiddleware::class], "delete.impacto")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImpactoDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/ImpactoSearch", [PermissionMiddleware::class], "search.impacto")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImpactoSearch");
    }
}
