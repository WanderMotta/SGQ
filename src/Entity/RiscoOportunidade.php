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
 * Entity class for "risco_oportunidade" table
 */
#[Entity]
#[Table(name: "risco_oportunidade")]
class RiscoOportunidade extends AbstractEntity
{
    #[Id]
    #[Column(name: "idrisco_oportunidade", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idriscoOportunidade;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "tipo_risco_oportunidade_idtipo_risco_oportunidade", type: "integer")]
    private int $tipoRiscoOportunidadeIdtipoRiscoOportunidade;

    #[Column(type: "string")]
    private string $titulo;

    #[Column(name: "origem_risco_oportunidade_idorigem_risco_oportunidade", type: "integer")]
    private int $origemRiscoOportunidadeIdorigemRiscoOportunidade;

    #[Column(type: "text")]
    private string $descricao;

    #[Column(type: "text")]
    private string $consequencia;

    #[Column(name: "frequencia_idfrequencia", type: "integer")]
    private int $frequenciaIdfrequencia;

    #[Column(name: "impacto_idimpacto", type: "integer")]
    private int $impactoIdimpacto;

    #[Column(name: "grau_atencao", type: "integer")]
    private int $grauAtencao;

    #[Column(name: "acao_risco_oportunidade_idacao_risco_oportunidade", type: "integer")]
    private int $acaoRiscoOportunidadeIdacaoRiscoOportunidade;

    #[Column(name: "plano_acao", type: "string")]
    private string $planoAcao;

    public function __construct()
    {
        $this->planoAcao = "Nao";
    }

    public function getIdriscoOportunidade(): int
    {
        return $this->idriscoOportunidade;
    }

    public function setIdriscoOportunidade(int $value): static
    {
        $this->idriscoOportunidade = $value;
        return $this;
    }

    public function getDtCadastro(): DateTime
    {
        return $this->dtCadastro;
    }

    public function setDtCadastro(DateTime $value): static
    {
        $this->dtCadastro = $value;
        return $this;
    }

    public function getTipoRiscoOportunidadeIdtipoRiscoOportunidade(): int
    {
        return $this->tipoRiscoOportunidadeIdtipoRiscoOportunidade;
    }

    public function setTipoRiscoOportunidadeIdtipoRiscoOportunidade(int $value): static
    {
        $this->tipoRiscoOportunidadeIdtipoRiscoOportunidade = $value;
        return $this;
    }

    public function getTitulo(): string
    {
        return HtmlDecode($this->titulo);
    }

    public function setTitulo(string $value): static
    {
        $this->titulo = RemoveXss($value);
        return $this;
    }

    public function getOrigemRiscoOportunidadeIdorigemRiscoOportunidade(): int
    {
        return $this->origemRiscoOportunidadeIdorigemRiscoOportunidade;
    }

    public function setOrigemRiscoOportunidadeIdorigemRiscoOportunidade(int $value): static
    {
        $this->origemRiscoOportunidadeIdorigemRiscoOportunidade = $value;
        return $this;
    }

    public function getDescricao(): string
    {
        return HtmlDecode($this->descricao);
    }

    public function setDescricao(string $value): static
    {
        $this->descricao = RemoveXss($value);
        return $this;
    }

    public function getConsequencia(): string
    {
        return HtmlDecode($this->consequencia);
    }

    public function setConsequencia(string $value): static
    {
        $this->consequencia = RemoveXss($value);
        return $this;
    }

    public function getFrequenciaIdfrequencia(): int
    {
        return $this->frequenciaIdfrequencia;
    }

    public function setFrequenciaIdfrequencia(int $value): static
    {
        $this->frequenciaIdfrequencia = $value;
        return $this;
    }

    public function getImpactoIdimpacto(): int
    {
        return $this->impactoIdimpacto;
    }

    public function setImpactoIdimpacto(int $value): static
    {
        $this->impactoIdimpacto = $value;
        return $this;
    }

    public function getGrauAtencao(): int
    {
        return $this->grauAtencao;
    }

    public function setGrauAtencao(int $value): static
    {
        $this->grauAtencao = $value;
        return $this;
    }

    public function getAcaoRiscoOportunidadeIdacaoRiscoOportunidade(): int
    {
        return $this->acaoRiscoOportunidadeIdacaoRiscoOportunidade;
    }

    public function setAcaoRiscoOportunidadeIdacaoRiscoOportunidade(int $value): static
    {
        $this->acaoRiscoOportunidadeIdacaoRiscoOportunidade = $value;
        return $this;
    }

    public function getPlanoAcao(): string
    {
        return $this->planoAcao;
    }

    public function setPlanoAcao(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'plano_acao' value");
        }
        $this->planoAcao = $value;
        return $this;
    }
}
