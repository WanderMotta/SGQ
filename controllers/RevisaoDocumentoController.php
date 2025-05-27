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

class RevisaoDocumentoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/RevisaoDocumentoList[/{idrevisao_documento}]", [PermissionMiddleware::class], "list.revisao_documento")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RevisaoDocumentoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/RevisaoDocumentoAdd[/{idrevisao_documento}]", [PermissionMiddleware::class], "add.revisao_documento")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RevisaoDocumentoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/RevisaoDocumentoView[/{idrevisao_documento}]", [PermissionMiddleware::class], "view.revisao_documento")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RevisaoDocumentoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/RevisaoDocumentoEdit[/{idrevisao_documento}]", [PermissionMiddleware::class], "edit.revisao_documento")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RevisaoDocumentoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/RevisaoDocumentoDelete[/{idrevisao_documento}]", [PermissionMiddleware::class], "delete.revisao_documento")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RevisaoDocumentoDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/RevisaoDocumentoSearch", [PermissionMiddleware::class], "search.revisao_documento")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RevisaoDocumentoSearch");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/RevisaoDocumentoPreview", [PermissionMiddleware::class], "preview.revisao_documento")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RevisaoDocumentoPreview", null, false);
    }
}
