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

class CategoriaDocumentoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/CategoriaDocumentoList[/{idcategoria_documento}]", [PermissionMiddleware::class], "list.categoria_documento")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoriaDocumentoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/CategoriaDocumentoAdd[/{idcategoria_documento}]", [PermissionMiddleware::class], "add.categoria_documento")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoriaDocumentoAdd");
    }

    // addopt
    #[Map(["GET","POST","OPTIONS"], "/CategoriaDocumentoAddopt", [PermissionMiddleware::class], "addopt.categoria_documento")]
    public function addopt(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoriaDocumentoAddopt", null, false);
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/CategoriaDocumentoView[/{idcategoria_documento}]", [PermissionMiddleware::class], "view.categoria_documento")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoriaDocumentoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/CategoriaDocumentoEdit[/{idcategoria_documento}]", [PermissionMiddleware::class], "edit.categoria_documento")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoriaDocumentoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/CategoriaDocumentoDelete[/{idcategoria_documento}]", [PermissionMiddleware::class], "delete.categoria_documento")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoriaDocumentoDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/CategoriaDocumentoSearch", [PermissionMiddleware::class], "search.categoria_documento")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoriaDocumentoSearch");
    }
}
