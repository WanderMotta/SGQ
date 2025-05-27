<?php

namespace PHPMaker2024\sgq;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Slim\HttpCache\CacheProvider;
use Slim\Flash\Messages;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Platforms;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Events;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Mime\MimeTypes;
use FastRoute\RouteParser\Std;
use Illuminate\Encryption\Encrypter;
use HTMLPurifier_Config;
use HTMLPurifier;

// Connections and entity managers
$definitions = [];
$dbids = array_keys(Config("Databases"));
foreach ($dbids as $dbid) {
    $definitions["connection." . $dbid] = \DI\factory(function (string $dbid) {
        return ConnectDb(Db($dbid));
    })->parameter("dbid", $dbid);
    $definitions["entitymanager." . $dbid] = \DI\factory(function (ContainerInterface $c, string $dbid) {
        $cache = IsDevelopment()
            ? DoctrineProvider::wrap(new ArrayAdapter())
            : DoctrineProvider::wrap(new FilesystemAdapter(directory: Config("DOCTRINE.CACHE_DIR")));
        $config = Setup::createAttributeMetadataConfiguration(
            Config("DOCTRINE.METADATA_DIRS"),
            IsDevelopment(),
            null,
            $cache
        );
        $conn = $c->get("connection." . $dbid);
        return new EntityManager($conn, $config);
    })->parameter("dbid", $dbid);
}

return [
    "app.cache" => \DI\create(CacheProvider::class),
    "app.flash" => fn(ContainerInterface $c) => new Messages(),
    "app.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "views/"),
    "email.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "lang/"),
    "sms.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "lang/"),
    "app.audit" => fn(ContainerInterface $c) => (new Logger("audit"))->pushHandler(new AuditTrailHandler($GLOBALS["RELATIVE_PATH"] . "log/audit.log")), // For audit trail
    "app.logger" => fn(ContainerInterface $c) => (new Logger("log"))->pushHandler(new RotatingFileHandler($GLOBALS["RELATIVE_PATH"] . "log/log.log")),
    "sql.logger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debug.stack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "app.csrf" => fn(ContainerInterface $c) => new Guard($GLOBALS["ResponseFactory"], Config("CSRF_PREFIX")),
    "html.purifier.config" => fn(ContainerInterface $c) => HTMLPurifier_Config::createDefault(),
    "html.purifier" => fn(ContainerInterface $c) => new HTMLPurifier($c->get("html.purifier.config")),
    "debug.stack" => \DI\create(DebugStack::class),
    "debug.sql.logger" => \DI\create(DebugSqlLogger::class),
    "debug.timer" => \DI\create(Timer::class),
    "app.security" => \DI\create(AdvancedSecurity::class),
    "user.profile" => \DI\create(UserProfile::class),
    "app.session" => \DI\create(HttpSession::class),
    "mime.types" => \DI\create(MimeTypes::class),
    "app.language" => \DI\create(Language::class),
    PermissionMiddleware::class => \DI\create(PermissionMiddleware::class),
    ApiPermissionMiddleware::class => \DI\create(ApiPermissionMiddleware::class),
    JwtMiddleware::class => \DI\create(JwtMiddleware::class),
    Std::class => \DI\create(Std::class),
    Encrypter::class => fn(ContainerInterface $c) => new Encrypter(AesEncryptionKey(base64_decode(Config("AES_ENCRYPTION_KEY"))), Config("AES_ENCRYPTION_CIPHER")),

    // Tables
    "acao_risco_oportunidade" => \DI\create(AcaoRiscoOportunidade::class),
    "analise_critica_direcao" => \DI\create(AnaliseCriticaDirecao::class),
    "analise_negocio" => \DI\create(AnaliseNegocio::class),
    "analise_swot" => \DI\create(AnaliseSwot::class),
    "categoria_documento" => \DI\create(CategoriaDocumento::class),
    "competencia" => \DI\create(Competencia::class),
    "consideracoes" => \DI\create(Consideracoes::class),
    "contexto" => \DI\create(Contexto::class),
    "Dashboard2" => \DI\create(Dashboard2::class),
    "departamentos" => \DI\create(Departamentos::class),
    "documento_externo" => \DI\create(DocumentoExterno::class),
    "documento_interno" => \DI\create(DocumentoInterno::class),
    "documento_registro" => \DI\create(DocumentoRegistro::class),
    "frequencia" => \DI\create(Frequencia::class),
    "gestao_mudanca" => \DI\create(GestaoMudanca::class),
    "graficos" => \DI\create(Graficos::class),
    "impacto" => \DI\create(Impacto::class),
    "indicadores" => \DI\create(Indicadores::class),
    "item_plano_aud_int" => \DI\create(ItemPlanoAudInt::class),
    "item_rel_aud_interna" => \DI\create(ItemRelAudInterna::class),
    "localizacao" => \DI\create(Localizacao::class),
    "nao_conformidade" => \DI\create(NaoConformidade::class),
    "objetivo_qualidade" => \DI\create(ObjetivoQualidade::class),
    "origem_risco_oportunidade" => \DI\create(OrigemRiscoOportunidade::class),
    "periodicidade" => \DI\create(Periodicidade::class),
    "plano_acao" => \DI\create(PlanoAcao::class),
    "plano_acao_nc" => \DI\create(PlanoAcaoNc::class),
    "plano_auditoria_int" => \DI\create(PlanoAuditoriaInt::class),
    "processo" => \DI\create(Processo::class),
    "processo_indicadores" => \DI\create(ProcessoIndicadores::class),
    "rel_analise_swot" => \DI\create(RelAnaliseSwot::class),
    "rel_cross_grafico" => \DI\create(RelCrossGrafico::class),
    "rel_processo_indicador" => \DI\create(RelProcessoIndicador::class),
    "rel_processos" => \DI\create(RelProcessos::class),
    "rel_view_aud_interna" => \DI\create(RelViewAudInterna::class),
    "rel_view_plano_auditoria" => \DI\create(RelViewPlanoAuditoria::class),
    "relatorio_aud_int" => \DI\create(RelatorioAudInt::class),
    "relatorio_auditoria_interna" => \DI\create(RelatorioAuditoriaInterna::class),
    "revisao_documento" => \DI\create(RevisaoDocumento::class),
    "risco_oportunidade" => \DI\create(RiscoOportunidade::class),
    "status_acao" => \DI\create(StatusAcao::class),
    "status_documento" => \DI\create(StatusDocumento::class),
    "tipo" => \DI\create(Tipo::class),
    "tipo_risco_oportunidade" => \DI\create(TipoRiscoOportunidade::class),
    "unidade_medida" => \DI\create(UnidadeMedida::class),
    "UserLevelPermissions" => \DI\create(UserLevelPermissions::class),
    "UserLevels" => \DI\create(UserLevels::class),
    "usuario" => \DI\create(Usuario::class),
    "view_plano_auditoria" => \DI\create(ViewPlanoAuditoria::class),
    "view_processo_indicador" => \DI\create(ViewProcessoIndicador::class),
    "view_relatoria_auditoria" => \DI\create(ViewRelatoriaAuditoria::class),

    // User table
    "usertable" => \DI\get("usuario"),
] + $definitions;
