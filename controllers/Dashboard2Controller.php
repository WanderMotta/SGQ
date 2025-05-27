<?php

namespace PHPMaker2024\sgq;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\sgq\Attributes\Delete;
use PHPMaker2024\sgq\Attributes\Get;
use PHPMaker2024\sgq\Attributes\Map;
use PHPMaker2024\sgq\Attributes\Options;
use PHPMaker2024\sgq\Attributes\Patch;
use PHPMaker2024\sgq\Attributes\Post;
use PHPMaker2024\sgq\Attributes\Put;

/**
 * Dashboard2 controller
 */
class Dashboard2Controller extends ControllerBase
{
    // dashboard
    #[Map(["GET", "POST", "OPTIONS"], "/Dashboard2", [PermissionMiddleware::class], "dashboard.Dashboard2")]
    public function dashboard(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Dashboard2");
    }

    // query
    #[Map(["GET", "POST", "OPTIONS"], "/Dashboard2Query", [PermissionMiddleware::class], "Dashboard2.query")]
    public function query(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args ,"Dashboard2", "Dashboard2Query");
    }
}
