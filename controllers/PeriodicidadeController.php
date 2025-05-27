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

class PeriodicidadeController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/PeriodicidadeList[/{idperiodicidade}]", [PermissionMiddleware::class], "list.periodicidade")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodicidadeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/PeriodicidadeAdd[/{idperiodicidade}]", [PermissionMiddleware::class], "add.periodicidade")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodicidadeAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/PeriodicidadeView[/{idperiodicidade}]", [PermissionMiddleware::class], "view.periodicidade")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodicidadeView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/PeriodicidadeEdit[/{idperiodicidade}]", [PermissionMiddleware::class], "edit.periodicidade")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodicidadeEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/PeriodicidadeDelete[/{idperiodicidade}]", [PermissionMiddleware::class], "delete.periodicidade")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodicidadeDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/PeriodicidadeSearch", [PermissionMiddleware::class], "search.periodicidade")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PeriodicidadeSearch");
    }
}
