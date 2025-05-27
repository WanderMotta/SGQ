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
 * rel_view_aud_interna controller
 */
class RelViewAudInternaController extends ControllerBase
{
    // summary
    #[Map(["GET", "POST", "OPTIONS"], "/RelViewAudInterna", [PermissionMiddleware::class], "summary.rel_view_aud_interna")]
    public function summary(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelViewAudInternaSummary");
    }
}
