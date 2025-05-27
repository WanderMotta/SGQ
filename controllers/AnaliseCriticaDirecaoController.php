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

class AnaliseCriticaDirecaoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/AnaliseCriticaDirecaoList[/{idanalise_critica_direcao}]", [PermissionMiddleware::class], "list.analise_critica_direcao")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseCriticaDirecaoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/AnaliseCriticaDirecaoAdd[/{idanalise_critica_direcao}]", [PermissionMiddleware::class], "add.analise_critica_direcao")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseCriticaDirecaoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/AnaliseCriticaDirecaoView[/{idanalise_critica_direcao}]", [PermissionMiddleware::class], "view.analise_critica_direcao")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseCriticaDirecaoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/AnaliseCriticaDirecaoEdit[/{idanalise_critica_direcao}]", [PermissionMiddleware::class], "edit.analise_critica_direcao")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseCriticaDirecaoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/AnaliseCriticaDirecaoDelete[/{idanalise_critica_direcao}]", [PermissionMiddleware::class], "delete.analise_critica_direcao")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AnaliseCriticaDirecaoDelete");
    }
}
