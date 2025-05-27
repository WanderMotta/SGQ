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

class UserLevelPermissionsController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/UserLevelPermissionsList[/{keys:.*}]", [PermissionMiddleware::class], "list.UserLevelPermissions")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "UserLevelPermissionsList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/UserLevelPermissionsAdd[/{keys:.*}]", [PermissionMiddleware::class], "add.UserLevelPermissions")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "UserLevelPermissionsAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/UserLevelPermissionsView[/{keys:.*}]", [PermissionMiddleware::class], "view.UserLevelPermissions")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "UserLevelPermissionsView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/UserLevelPermissionsEdit[/{keys:.*}]", [PermissionMiddleware::class], "edit.UserLevelPermissions")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "UserLevelPermissionsEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/UserLevelPermissionsDelete[/{keys:.*}]", [PermissionMiddleware::class], "delete.UserLevelPermissions")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "UserLevelPermissionsDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/UserLevelPermissionsSearch", [PermissionMiddleware::class], "search.UserLevelPermissions")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "UserLevelPermissionsSearch");
    }

    // Get keys as associative array
    protected function getKeyParams($args)
    {
        global $RouteValues;
        if (array_key_exists("keys", $args)) {
            $sep = Container("UserLevelPermissions")->RouteCompositeKeySeparator;
            $keys = explode($sep, $args["keys"]);
            if (count($keys) == 2) {
                $keyArgs = array_combine(["UserLevelID","_TableName"], $keys);
                $RouteValues = array_merge(Route(), $keyArgs);
                $args = array_merge($args, $keyArgs);
            }
        }
        return $args;
    }
}
