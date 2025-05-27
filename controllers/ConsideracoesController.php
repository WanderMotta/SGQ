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

class ConsideracoesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ConsideracoesList[/{idconsideracoes}]", [PermissionMiddleware::class], "list.consideracoes")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConsideracoesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ConsideracoesAdd[/{idconsideracoes}]", [PermissionMiddleware::class], "add.consideracoes")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConsideracoesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ConsideracoesView[/{idconsideracoes}]", [PermissionMiddleware::class], "view.consideracoes")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConsideracoesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ConsideracoesEdit[/{idconsideracoes}]", [PermissionMiddleware::class], "edit.consideracoes")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConsideracoesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ConsideracoesDelete[/{idconsideracoes}]", [PermissionMiddleware::class], "delete.consideracoes")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConsideracoesDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/ConsideracoesSearch", [PermissionMiddleware::class], "search.consideracoes")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ConsideracoesSearch");
    }
}
