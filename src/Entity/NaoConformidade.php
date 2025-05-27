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
 * Entity class for "nao_conformidade" table
 */
#[Entity]
#[Table(name: "nao_conformidade")]
class NaoConformidade extends AbstractEntity
{
    #[Id]
    #[Column(name: "idnao_conformidade", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idnaoConformidade;

    #[Column(name: "dt_ocorrencia", type: "date")]
    private DateTime $dtOcorrencia;

    #[Column(type: "integer")]
    private int $tipo;

    #[Column(type: "string")]
    private string $titulo;

    #[Column(name: "processo_idprocesso", type: "integer")]
    private int $processoIdprocesso;

    #[Column(type: "text")]
    private string $ocorrencia;

    #[Column(name: "origem_risco_oportunidade_idorigem_risco_oportunidade", type: "integer")]
    private int $origemRiscoOportunidadeIdorigemRiscoOportunidade;

    #[Column(name: "acao_imediata", type: "text", nullable: true)]
    private ?string $acaoImediata;

    #[Column(name: "causa_raiz", type: "text")]
    private string $causaRaiz;

    #[Column(name: "departamentos_iddepartamentos", type: "integer")]
    private int $departamentosIddepartamentos;

    #[Column(type: "string", nullable: true)]
    private ?string $anexo;

    #[Column(name: "status_nc", type: "integer")]
    private int $statusNc;

    #[Column(name: "plano_acao", type: "string")]
    private string $planoAcao;

    public function __construct()
    {
        $this->tipo = 1;
        $this->statusNc = 1;
        $this->planoAcao = "Nao";
    }

    public function getIdnaoConformidade(): int
    {
        return $this->idnaoConformidade;
    }

    public function setIdnaoConformidade(int $value): static
    {
        $this->idnaoConformidade = $value;
        return $this;
    }

    public function getDtOcorrencia(): DateTime
    {
        return $this->dtOcorrencia;
    }

    public function setDtOcorrencia(DateTime $value): static
    {
        $this->dtOcorrencia = $value;
        return $this;
    }

    public function getTipo(): int
    {
        return $this->tipo;
    }

    public function setTipo(int $value): static
    {
        $this->tipo = $value;
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

    public function getProcessoIdprocesso(): int
    {
        return $this->processoIdprocesso;
    }

    public function setProcessoIdprocesso(int $value): static
    {
        $this->processoIdprocesso = $value;
        return $this;
    }

    public function getOcorrencia(): string
    {
        return HtmlDecode($this->ocorrencia);
    }

    public function setOcorrencia(string $value): static
    {
        $this->ocorrencia = RemoveXss($value);
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

    public function getAcaoImediata(): ?string
    {
        return HtmlDecode($this->acaoImediata);
    }

    public function setAcaoImediata(?string $value): static
    {
        $this->acaoImediata = RemoveXss($value);
        return $this;
    }

    public function getCausaRaiz(): string
    {
        return HtmlDecode($this->causaRaiz);
    }

    public function setCausaRaiz(string $value): static
    {
        $this->causaRaiz = RemoveXss($value);
        return $this;
    }

    public function getDepartamentosIddepartamentos(): int
    {
        return $this->departamentosIddepartamentos;
    }

    public function setDepartamentosIddepartamentos(int $value): static
    {
        $this->departamentosIddepartamentos = $value;
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

    public function getStatusNc(): int
    {
        return $this->statusNc;
    }

    public function setStatusNc(int $value): static
    {
        $this->statusNc = $value;
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
