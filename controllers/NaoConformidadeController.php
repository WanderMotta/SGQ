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

class NaoConformidadeController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/NaoConformidadeList[/{idnao_conformidade}]", [PermissionMiddleware::class], "list.nao_conformidade")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "NaoConformidadeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/NaoConformidadeAdd[/{idnao_conformidade}]", [PermissionMiddleware::class], "add.nao_conformidade")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "NaoConformidadeAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/NaoConformidadeView[/{idnao_conformidade}]", [PermissionMiddleware::class], "view.nao_conformidade")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "NaoConformidadeView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/NaoConformidadeEdit[/{idnao_conformidade}]", [PermissionMiddleware::class], "edit.nao_conformidade")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "NaoConformidadeEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/NaoConformidadeDelete[/{idnao_conformidade}]", [PermissionMiddleware::class], "delete.nao_conformidade")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "NaoConformidadeDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/NaoConformidadeSearch", [PermissionMiddleware::class], "search.nao_conformidade")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "NaoConformidadeSearch");
    }
}
