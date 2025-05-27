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

class DocumentoExternoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/DocumentoExternoList[/{iddocumento_externo}]", [PermissionMiddleware::class], "list.documento_externo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoExternoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/DocumentoExternoAdd[/{iddocumento_externo}]", [PermissionMiddleware::class], "add.documento_externo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoExternoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/DocumentoExternoView[/{iddocumento_externo}]", [PermissionMiddleware::class], "view.documento_externo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoExternoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/DocumentoExternoEdit[/{iddocumento_externo}]", [PermissionMiddleware::class], "edit.documento_externo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoExternoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/DocumentoExternoDelete[/{iddocumento_externo}]", [PermissionMiddleware::class], "delete.documento_externo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoExternoDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/DocumentoExternoSearch", [PermissionMiddleware::class], "search.documento_externo")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoExternoSearch");
    }
}
