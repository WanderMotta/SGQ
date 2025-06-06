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

class UserLevelsController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/UserLevelsList[/{UserLevelID}]", [PermissionMiddleware::class], "list.UserLevels")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserLevelsList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/UserLevelsAdd[/{UserLevelID}]", [PermissionMiddleware::class], "add.UserLevels")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserLevelsAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/UserLevelsView[/{UserLevelID}]", [PermissionMiddleware::class], "view.UserLevels")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserLevelsView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/UserLevelsEdit[/{UserLevelID}]", [PermissionMiddleware::class], "edit.UserLevels")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserLevelsEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/UserLevelsDelete[/{UserLevelID}]", [PermissionMiddleware::class], "delete.UserLevels")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserLevelsDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/UserLevelsSearch", [PermissionMiddleware::class], "search.UserLevels")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserLevelsSearch");
    }
}
