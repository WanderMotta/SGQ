<?php
/**
 * PHPMaker 2024 User Level Settings
 */
namespace PHPMaker2024\sgq;

/**
 * User levels
 *
 * @var array<int, string>
 * [0] int User level ID
 * [1] string User level name
 */
$USER_LEVELS = [["-2","Anonymous"],
    ["0","Default"]];

/**
 * User level permissions
 *
 * @var array<string, int, int>
 * [0] string Project ID + Table name
 * [1] int User level ID
 * [2] int Permissions
 */
$USER_LEVEL_PRIVS = [["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}acao_risco_oportunidade","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}acao_risco_oportunidade","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}analise_critica_direcao","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}analise_critica_direcao","0","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}analise_negocio","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}analise_negocio","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}analise_swot","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}analise_swot","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}categoria_documento","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}categoria_documento","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}competencia","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}competencia","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}consideracoes","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}consideracoes","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}contexto","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}contexto","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}Dashboard","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}Dashboard","0","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}departamentos","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}departamentos","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}documento_externo","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}documento_externo","0","1388"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}documento_interno","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}documento_interno","0","1388"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}documento_registro","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}documento_registro","0","1388"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}frequencia","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}frequencia","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}gestao_mudanca","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}gestao_mudanca","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}graficos","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}graficos","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}impacto","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}impacto","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}indicadores","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}indicadores","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}item_plano_aud_int","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}item_plano_aud_int","0","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}item_rel_aud_interna","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}item_rel_aud_interna","0","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}localizacao","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}localizacao","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}nao_conformidade","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}nao_conformidade","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}objetivo_qualidade","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}objetivo_qualidade","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}origem_risco_oportunidade","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}origem_risco_oportunidade","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}periodicidade","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}periodicidade","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}plano_acao","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}plano_acao","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}plano_acao_nc","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}plano_acao_nc","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}plano_auditoria_int","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}plano_auditoria_int","0","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}processo","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}processo","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}processo_indicadores","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}processo_indicadores","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_analise_swot","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_analise_swot","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_cross_grafico","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_cross_grafico","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_processo_indicador","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_processo_indicador","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_processos","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_processos","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_view_aud_interna","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_view_aud_interna","0","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_view_plano_auditoria","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}rel_view_plano_auditoria","0","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}relatorio_aud_int","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}relatorio_aud_int","0","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}relatorio_auditoria_interna","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}relatorio_auditoria_interna","0","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}revisao_documento","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}revisao_documento","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}risco_oportunidade","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}risco_oportunidade","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}status_acao","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}status_acao","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}status_documento","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}status_documento","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}tipo","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}tipo","0","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}tipo_risco_oportunidade","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}tipo_risco_oportunidade","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}unidade_medida","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}unidade_medida","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}UserLevelPermissions","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}UserLevelPermissions","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}UserLevels","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}UserLevels","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}usuario","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}usuario","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}view_plano_auditoria","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}view_plano_auditoria","0","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}view_processo_indicador","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}view_processo_indicador","0","1384"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}view_relatoria_auditoria","-2","0"],
    ["{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}view_relatoria_auditoria","0","0"]];

/**
 * Tables
 *
 * @var array<string, string, string, bool, string>
 * [0] string Table name
 * [1] string Table variable name
 * [2] string Table caption
 * [3] bool Allowed for update (for userpriv.php)
 * [4] string Project ID
 * [5] string URL (for OthersController::index)
 */
$USER_LEVEL_TABLES = [["acao_risco_oportunidade","acao_risco_oportunidade","Ações - Risco/Oportunidades",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","AcaoRiscoOportunidadeList"],
    ["analise_critica_direcao","analise_critica_direcao","Analise Critica Direção",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","AnaliseCriticaDirecaoList"],
    ["analise_negocio","analise_negocio","Analise do Negocio",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","AnaliseNegocioList"],
    ["analise_swot","analise_swot","Analise de Swot",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","AnaliseSwotList"],
    ["categoria_documento","categoria_documento","Categoria de Documentos",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","CategoriaDocumentoList"],
    ["competencia","competencia","Competencia",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","CompetenciaList"],
    ["consideracoes","consideracoes","Considerações Importantes",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","ConsideracoesList"],
    ["contexto","contexto","Contexto da Organização",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","ContextoList"],
    ["Dashboard","Dashboard2","Dashboard",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","Dashboard2"],
    ["departamentos","departamentos","Departamentos",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","DepartamentosList"],
    ["documento_externo","documento_externo","Documentos Externo",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","DocumentoExternoList"],
    ["documento_interno","documento_interno","Documentos Interno",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","DocumentoInternoList"],
    ["documento_registro","documento_registro","Registros",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","DocumentoRegistroList"],
    ["frequencia","frequencia","Frequencia",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","FrequenciaList"],
    ["gestao_mudanca","gestao_mudanca","Gestão de Mudanças",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","GestaoMudancaList"],
    ["graficos","graficos","Indices/Gráficos",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","GraficosList"],
    ["impacto","impacto","Severidade",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","ImpactoList"],
    ["indicadores","indicadores","Indicadores",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","IndicadoresList"],
    ["item_plano_aud_int","item_plano_aud_int","Plano",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","ItemPlanoAudIntList"],
    ["item_rel_aud_interna","item_rel_aud_interna","Auditoria Interna",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","ItemRelAudInternaList"],
    ["localizacao","localizacao","Localização Documento",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","LocalizacaoList"],
    ["nao_conformidade","nao_conformidade","Não Conformidade",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","NaoConformidadeList"],
    ["objetivo_qualidade","objetivo_qualidade","Objetivos da Qualidade",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","ObjetivoQualidadeList"],
    ["origem_risco_oportunidade","origem_risco_oportunidade","Origem [Risco/Oportunidade]",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","OrigemRiscoOportunidadeList"],
    ["periodicidade","periodicidade","Periodicidade",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","PeriodicidadeList"],
    ["plano_acao","plano_acao","Plano de Ação",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","PlanoAcaoList"],
    ["plano_acao_nc","plano_acao_nc","Plano de Ação",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","PlanoAcaoNcList"],
    ["plano_auditoria_int","plano_auditoria_int","Plano Aud Int",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","PlanoAuditoriaIntList"],
    ["processo","processo","Processos",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","ProcessoList"],
    ["processo_indicadores","processo_indicadores","Indicadores",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","ProcessoIndicadoresList"],
    ["rel_analise_swot","rel_analise_swot","Analise de Swot",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","RelAnaliseSwot"],
    ["rel_cross_grafico","rel_cross_grafico","Indicadores Gráficos",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","RelCrossGrafico"],
    ["rel_processo_indicador","rel_processo_indicador","Processos x Indicadores",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","RelProcessoIndicador"],
    ["rel_processos","rel_processos","Processos Existentes",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","RelProcessos"],
    ["rel_view_aud_interna","rel_view_aud_interna","Relatorio de Auditoria Interna",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","RelViewAudInterna"],
    ["rel_view_plano_auditoria","rel_view_plano_auditoria","Plano Auditoria Interna",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","RelViewPlanoAuditoria"],
    ["relatorio_aud_int","relatorio_aud_int","Relatorio",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","RelatorioAudIntList"],
    ["relatorio_auditoria_interna","relatorio_auditoria_interna","Auditoria Interna",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","RelatorioAuditoriaInternaList"],
    ["revisao_documento","revisao_documento","Revisão",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","RevisaoDocumentoList"],
    ["risco_oportunidade","risco_oportunidade","Gestão Risco ou Oportunidade",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","RiscoOportunidadeList"],
    ["status_acao","status_acao","Status da Ação",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","StatusAcaoList"],
    ["status_documento","status_documento","Status Documento",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","StatusDocumentoList"],
    ["tipo","tipo","Tipo",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","TipoList"],
    ["tipo_risco_oportunidade","tipo_risco_oportunidade","Tipo Risco/Oportunidade",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","TipoRiscoOportunidadeList"],
    ["unidade_medida","unidade_medida","Unidade de Medida",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","UnidadeMedidaList"],
    ["UserLevelPermissions","UserLevelPermissions","Tabelas de Permissões",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","UserLevelPermissionsList"],
    ["UserLevels","UserLevels","Usuários/Permissões",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","UserLevelsList"],
    ["usuario","usuario","Usuários",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","UsuarioList"],
    ["view_plano_auditoria","view_plano_auditoria","view plano auditoria",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","ViewPlanoAuditoriaList"],
    ["view_processo_indicador","view_processo_indicador","view processo indicador",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","ViewProcessoIndicadorList"],
    ["view_relatoria_auditoria","view_relatoria_auditoria","view relatorio aud int",true,"{E0FBA0D0-6EA0-4AAB-A8CC-5871C01EDF16}","ViewRelatoriaAuditoriaList"]];
