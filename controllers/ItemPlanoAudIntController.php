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

class ItemPlanoAudIntController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ItemPlanoAudIntList[/{iditem_plano_aud_int}]", [PermissionMiddleware::class], "list.item_plano_aud_int")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemPlanoAudIntList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ItemPlanoAudIntAdd[/{iditem_plano_aud_int}]", [PermissionMiddleware::class], "add.item_plano_aud_int")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemPlanoAudIntAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ItemPlanoAudIntView[/{iditem_plano_aud_int}]", [PermissionMiddleware::class], "view.item_plano_aud_int")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemPlanoAudIntView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ItemPlanoAudIntEdit[/{iditem_plano_aud_int}]", [PermissionMiddleware::class], "edit.item_plano_aud_int")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemPlanoAudIntEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ItemPlanoAudIntDelete[/{iditem_plano_aud_int}]", [PermissionMiddleware::class], "delete.item_plano_aud_int")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemPlanoAudIntDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ItemPlanoAudIntPreview", [PermissionMiddleware::class], "preview.item_plano_aud_int")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemPlanoAudIntPreview", null, false);
    }
}
