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

class FrequenciaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/FrequenciaList[/{idfrequencia}]", [PermissionMiddleware::class], "list.frequencia")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FrequenciaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/FrequenciaAdd[/{idfrequencia}]", [PermissionMiddleware::class], "add.frequencia")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FrequenciaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/FrequenciaView[/{idfrequencia}]", [PermissionMiddleware::class], "view.frequencia")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FrequenciaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/FrequenciaEdit[/{idfrequencia}]", [PermissionMiddleware::class], "edit.frequencia")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FrequenciaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/FrequenciaDelete[/{idfrequencia}]", [PermissionMiddleware::class], "delete.frequencia")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FrequenciaDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/FrequenciaSearch", [PermissionMiddleware::class], "search.frequencia")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FrequenciaSearch");
    }
}
