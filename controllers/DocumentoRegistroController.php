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

class DocumentoRegistroController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/DocumentoRegistroList[/{iddocumento_registro}]", [PermissionMiddleware::class], "list.documento_registro")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoRegistroList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/DocumentoRegistroAdd[/{iddocumento_registro}]", [PermissionMiddleware::class], "add.documento_registro")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoRegistroAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/DocumentoRegistroView[/{iddocumento_registro}]", [PermissionMiddleware::class], "view.documento_registro")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoRegistroView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/DocumentoRegistroEdit[/{iddocumento_registro}]", [PermissionMiddleware::class], "edit.documento_registro")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoRegistroEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/DocumentoRegistroDelete[/{iddocumento_registro}]", [PermissionMiddleware::class], "delete.documento_registro")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoRegistroDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/DocumentoRegistroSearch", [PermissionMiddleware::class], "search.documento_registro")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoRegistroSearch");
    }
}
