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

class ItemRelAudInternaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ItemRelAudInternaList[/{iditem_rel_aud_interna}]", [PermissionMiddleware::class], "list.item_rel_aud_interna")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemRelAudInternaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ItemRelAudInternaAdd[/{iditem_rel_aud_interna}]", [PermissionMiddleware::class], "add.item_rel_aud_interna")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemRelAudInternaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ItemRelAudInternaView[/{iditem_rel_aud_interna}]", [PermissionMiddleware::class], "view.item_rel_aud_interna")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemRelAudInternaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ItemRelAudInternaEdit[/{iditem_rel_aud_interna}]", [PermissionMiddleware::class], "edit.item_rel_aud_interna")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemRelAudInternaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ItemRelAudInternaDelete[/{iditem_rel_aud_interna}]", [PermissionMiddleware::class], "delete.item_rel_aud_interna")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemRelAudInternaDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ItemRelAudInternaPreview", [PermissionMiddleware::class], "preview.item_rel_aud_interna")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ItemRelAudInternaPreview", null, false);
    }
}
