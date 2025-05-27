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

class DocumentoInternoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/DocumentoInternoList[/{iddocumento_interno}]", [PermissionMiddleware::class], "list.documento_interno")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoInternoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/DocumentoInternoAdd[/{iddocumento_interno}]", [PermissionMiddleware::class], "add.documento_interno")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoInternoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/DocumentoInternoView[/{iddocumento_interno}]", [PermissionMiddleware::class], "view.documento_interno")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoInternoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/DocumentoInternoEdit[/{iddocumento_interno}]", [PermissionMiddleware::class], "edit.documento_interno")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoInternoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/DocumentoInternoDelete[/{iddocumento_interno}]", [PermissionMiddleware::class], "delete.documento_interno")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoInternoDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/DocumentoInternoSearch", [PermissionMiddleware::class], "search.documento_interno")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DocumentoInternoSearch");
    }
}
