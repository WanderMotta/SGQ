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

class StatusDocumentoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/StatusDocumentoList[/{idstatus_documento}]", [PermissionMiddleware::class], "list.status_documento")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusDocumentoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/StatusDocumentoAdd[/{idstatus_documento}]", [PermissionMiddleware::class], "add.status_documento")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusDocumentoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/StatusDocumentoView[/{idstatus_documento}]", [PermissionMiddleware::class], "view.status_documento")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusDocumentoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/StatusDocumentoEdit[/{idstatus_documento}]", [PermissionMiddleware::class], "edit.status_documento")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusDocumentoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/StatusDocumentoDelete[/{idstatus_documento}]", [PermissionMiddleware::class], "delete.status_documento")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusDocumentoDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/StatusDocumentoSearch", [PermissionMiddleware::class], "search.status_documento")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StatusDocumentoSearch");
    }
}
