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

class ObjetivoQualidadeController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ObjetivoQualidadeList[/{idobjetivo_qualidade}]", [PermissionMiddleware::class], "list.objetivo_qualidade")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ObjetivoQualidadeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ObjetivoQualidadeAdd[/{idobjetivo_qualidade}]", [PermissionMiddleware::class], "add.objetivo_qualidade")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ObjetivoQualidadeAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ObjetivoQualidadeView[/{idobjetivo_qualidade}]", [PermissionMiddleware::class], "view.objetivo_qualidade")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ObjetivoQualidadeView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ObjetivoQualidadeEdit[/{idobjetivo_qualidade}]", [PermissionMiddleware::class], "edit.objetivo_qualidade")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ObjetivoQualidadeEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ObjetivoQualidadeDelete[/{idobjetivo_qualidade}]", [PermissionMiddleware::class], "delete.objetivo_qualidade")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ObjetivoQualidadeDelete");
    }

    // search
    #[Map(["GET","POST","OPTIONS"], "/ObjetivoQualidadeSearch", [PermissionMiddleware::class], "search.objetivo_qualidade")]
    public function search(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ObjetivoQualidadeSearch");
    }
}
