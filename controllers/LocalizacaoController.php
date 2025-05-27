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

class LocalizacaoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/LocalizacaoList[/{idlocalizacao}]", [PermissionMiddleware::class], "list.localizacao")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalizacaoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/LocalizacaoAdd[/{idlocalizacao}]", [PermissionMiddleware::class], "add.localizacao")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalizacaoAdd");
    }

    // addopt
    #[Map(["GET","POST","OPTIONS"], "/LocalizacaoAddopt", [PermissionMiddleware::class], "addopt.localizacao")]
    public function addopt(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalizacaoAddopt", null, false);
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/LocalizacaoView[/{idlocalizacao}]", [PermissionMiddleware::class], "view.localizacao")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalizacaoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/LocalizacaoEdit[/{idlocalizacao}]", [PermissionMiddleware::class], "edit.localizacao")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalizacaoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/LocalizacaoDelete[/{idlocalizacao}]", [PermissionMiddleware::class], "delete.localizacao")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalizacaoDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/LocalizacaoSearch", [PermissionMiddleware::class], "search.localizacao")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LocalizacaoSearch");
    }
}
