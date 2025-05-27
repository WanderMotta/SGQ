<?php

namespace PHPMaker2024\sgq\Entity;

use DateTime;
use DateTimeImmutable;
use DateInterval;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\DBAL\Types\Types;
use PHPMaker2024\sgq\AbstractEntity;
use PHPMaker2024\sgq\AdvancedSecurity;
use PHPMaker2024\sgq\UserProfile;
use function PHPMaker2024\sgq\Config;
use function PHPMaker2024\sgq\EntityManager;
use function PHPMaker2024\sgq\RemoveXss;
use function PHPMaker2024\sgq\HtmlDecode;
use function PHPMaker2024\sgq\EncryptPassword;

/**
 * Entity class for "analise_critica_direcao" table
 */
#[Entity]
#[Table(name: "analise_critica_direcao")]
class AnaliseCriticaDirecao extends AbstractEntity
{
    #[Id]
    #[Column(name: "idanalise_critica_direcao", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idanaliseCriticaDirecao;

    #[Column(type: "date")]
    private DateTime $data;

    #[Column(type: "string")]
    private string $participantes;

    #[Column(name: "usuario_idusuario", type: "integer")]
    private int $usuarioIdusuario;

    #[Column(name: "situacao_anterior", type: "text")]
    private string $situacaoAnterior;

    #[Column(name: "mudanca_sqg", type: "text")]
    private string $mudancaSqg;

    #[Column(name: "desempenho_eficacia", type: "text")]
    private string $desempenhoEficacia;

    #[Column(name: "satisfacao_cliente", type: "text")]
    private string $satisfacaoCliente;

    #[Column(name: "`objetivos_alcançados`", options: ["name" => "objetivos_alcançados"], type: "text")]
    private string $objetivosAlcancados;

    #[Column(name: "desempenho_processo", type: "text")]
    private string $desempenhoProcesso;

    #[Column(name: "nao_confomidade_acoes_corretivas", type: "text")]
    private string $naoConfomidadeAcoesCorretivas;

    #[Column(name: "monitoramento_medicao", type: "text")]
    private string $monitoramentoMedicao;

    #[Column(name: "resultado_auditoria", type: "text")]
    private string $resultadoAuditoria;

    #[Column(name: "desempenho_provedores_ext", type: "text")]
    private string $desempenhoProvedoresExt;

    #[Column(name: "suficiencia_recursos", type: "text")]
    private string $suficienciaRecursos;

    #[Column(name: "acoes_risco_oportunidades", type: "text")]
    private string $acoesRiscoOportunidades;

    #[Column(name: "oportunidade_melhora_entrada", type: "text")]
    private string $oportunidadeMelhoraEntrada;

    #[Column(name: "oportunidade_melhora_saida", type: "text")]
    private string $oportunidadeMelhoraSaida;

    #[Column(name: "qualquer_mudanca_sgq", type: "text")]
    private string $qualquerMudancaSgq;

    #[Column(name: "nec_recurso", type: "string")]
    private string $necRecurso;

    #[Column(type: "string", nullable: true)]
    private ?string $anexo;

    public function getIdanaliseCriticaDirecao(): int
    {
        return $this->idanaliseCriticaDirecao;
    }

    public function setIdanaliseCriticaDirecao(int $value): static
    {
        $this->idanaliseCriticaDirecao = $value;
        return $this;
    }

    public function getData(): DateTime
    {
        return $this->data;
    }

    public function setData(DateTime $value): static
    {
        $this->data = $value;
        return $this;
    }

    public function getParticipantes(): string
    {
        return HtmlDecode($this->participantes);
    }

    public function setParticipantes(string $value): static
    {
        $this->participantes = RemoveXss($value);
        return $this;
    }

    public function getUsuarioIdusuario(): int
    {
        return $this->usuarioIdusuario;
    }

    public function setUsuarioIdusuario(int $value): static
    {
        $this->usuarioIdusuario = $value;
        return $this;
    }

    public function getSituacaoAnterior(): string
    {
        return HtmlDecode($this->situacaoAnterior);
    }

    public function setSituacaoAnterior(string $value): static
    {
        $this->situacaoAnterior = RemoveXss($value);
        return $this;
    }

    public function getMudancaSqg(): string
    {
        return HtmlDecode($this->mudancaSqg);
    }

    public function setMudancaSqg(string $value): static
    {
        $this->mudancaSqg = RemoveXss($value);
        return $this;
    }

    public function getDesempenhoEficacia(): string
    {
        return HtmlDecode($this->desempenhoEficacia);
    }

    public function setDesempenhoEficacia(string $value): static
    {
        $this->desempenhoEficacia = RemoveXss($value);
        return $this;
    }

    public function getSatisfacaoCliente(): string
    {
        return HtmlDecode($this->satisfacaoCliente);
    }

    public function setSatisfacaoCliente(string $value): static
    {
        $this->satisfacaoCliente = RemoveXss($value);
        return $this;
    }

    public function getObjetivosAlcancados(): string
    {
        return HtmlDecode($this->objetivosAlcancados);
    }

    public function setObjetivosAlcancados(string $value): static
    {
        $this->objetivosAlcancados = RemoveXss($value);
        return $this;
    }

    public function getDesempenhoProcesso(): string
    {
        return HtmlDecode($this->desempenhoProcesso);
    }

    public function setDesempenhoProcesso(string $value): static
    {
        $this->desempenhoProcesso = RemoveXss($value);
        return $this;
    }

    public function getNaoConfomidadeAcoesCorretivas(): string
    {
        return HtmlDecode($this->naoConfomidadeAcoesCorretivas);
    }

    public function setNaoConfomidadeAcoesCorretivas(string $value): static
    {
        $this->naoConfomidadeAcoesCorretivas = RemoveXss($value);
        return $this;
    }

    public function getMonitoramentoMedicao(): string
    {
        return HtmlDecode($this->monitoramentoMedicao);
    }

    public function setMonitoramentoMedicao(string $value): static
    {
        $this->monitoramentoMedicao = RemoveXss($value);
        return $this;
    }

    public function getResultadoAuditoria(): string
    {
        return HtmlDecode($this->resultadoAuditoria);
    }

    public function setResultadoAuditoria(string $value): static
    {
        $this->resultadoAuditoria = RemoveXss($value);
        return $this;
    }

    public function getDesempenhoProvedoresExt(): string
    {
        return HtmlDecode($this->desempenhoProvedoresExt);
    }

    public function setDesempenhoProvedoresExt(string $value): static
    {
        $this->desempenhoProvedoresExt = RemoveXss($value);
        return $this;
    }

    public function getSuficienciaRecursos(): string
    {
        return HtmlDecode($this->suficienciaRecursos);
    }

    public function setSuficienciaRecursos(string $value): static
    {
        $this->suficienciaRecursos = RemoveXss($value);
        return $this;
    }

    public function getAcoesRiscoOportunidades(): string
    {
        return HtmlDecode($this->acoesRiscoOportunidades);
    }

    public function setAcoesRiscoOportunidades(string $value): static
    {
        $this->acoesRiscoOportunidades = RemoveXss($value);
        return $this;
    }

    public function getOportunidadeMelhoraEntrada(): string
    {
        return HtmlDecode($this->oportunidadeMelhoraEntrada);
    }

    public function setOportunidadeMelhoraEntrada(string $value): static
    {
        $this->oportunidadeMelhoraEntrada = RemoveXss($value);
        return $this;
    }

    public function getOportunidadeMelhoraSaida(): string
    {
        return HtmlDecode($this->oportunidadeMelhoraSaida);
    }

    public function setOportunidadeMelhoraSaida(string $value): static
    {
        $this->oportunidadeMelhoraSaida = RemoveXss($value);
        return $this;
    }

    public function getQualquerMudancaSgq(): string
    {
        return HtmlDecode($this->qualquerMudancaSgq);
    }

    public function setQualquerMudancaSgq(string $value): static
    {
        $this->qualquerMudancaSgq = RemoveXss($value);
        return $this;
    }

    public function getNecRecurso(): string
    {
        return HtmlDecode($this->necRecurso);
    }

    public function setNecRecurso(string $value): static
    {
        $this->necRecurso = RemoveXss($value);
        return $this;
    }

    public function getAnexo(): ?string
    {
        return HtmlDecode($this->anexo);
    }

    public function setAnexo(?string $value): static
    {
        $this->anexo = RemoveXss($value);
        return $this;
    }
}
