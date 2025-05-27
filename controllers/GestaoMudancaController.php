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

class GestaoMudancaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/GestaoMudancaList[/{idgestao_mudanca}]", [PermissionMiddleware::class], "list.gestao_mudanca")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GestaoMudancaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/GestaoMudancaAdd[/{idgestao_mudanca}]", [PermissionMiddleware::class], "add.gestao_mudanca")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GestaoMudancaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/GestaoMudancaView[/{idgestao_mudanca}]", [PermissionMiddleware::class], "view.gestao_mudanca")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GestaoMudancaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/GestaoMudancaEdit[/{idgestao_mudanca}]", [PermissionMiddleware::class], "edit.gestao_mudanca")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GestaoMudancaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/GestaoMudancaDelete[/{idgestao_mudanca}]", [PermissionMiddleware::class], "delete.gestao_mudanca")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GestaoMudancaDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/GestaoMudancaSearch", [PermissionMiddleware::class], "search.gestao_mudanca")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "GestaoMudancaSearch");
    }
}
