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

class RelatorioAuditoriaInternaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/RelatorioAuditoriaInternaList[/{idrelatorio_auditoria_interna}]", [PermissionMiddleware::class], "list.relatorio_auditoria_interna")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelatorioAuditoriaInternaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/RelatorioAuditoriaInternaAdd[/{idrelatorio_auditoria_interna}]", [PermissionMiddleware::class], "add.relatorio_auditoria_interna")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelatorioAuditoriaInternaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/RelatorioAuditoriaInternaView[/{idrelatorio_auditoria_interna}]", [PermissionMiddleware::class], "view.relatorio_auditoria_interna")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelatorioAuditoriaInternaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/RelatorioAuditoriaInternaEdit[/{idrelatorio_auditoria_interna}]", [PermissionMiddleware::class], "edit.relatorio_auditoria_interna")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelatorioAuditoriaInternaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/RelatorioAuditoriaInternaDelete[/{idrelatorio_auditoria_interna}]", [PermissionMiddleware::class], "delete.relatorio_auditoria_interna")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RelatorioAuditoriaInternaDelete");
    }
}
