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

class UnidadeMedidaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/UnidadeMedidaList[/{idunidade_medida}]", [PermissionMiddleware::class], "list.unidade_medida")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UnidadeMedidaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/UnidadeMedidaAdd[/{idunidade_medida}]", [PermissionMiddleware::class], "add.unidade_medida")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UnidadeMedidaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/UnidadeMedidaView[/{idunidade_medida}]", [PermissionMiddleware::class], "view.unidade_medida")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UnidadeMedidaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/UnidadeMedidaEdit[/{idunidade_medida}]", [PermissionMiddleware::class], "edit.unidade_medida")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UnidadeMedidaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/UnidadeMedidaDelete[/{idunidade_medida}]", [PermissionMiddleware::class], "delete.unidade_medida")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UnidadeMedidaDelete");
    }
}
