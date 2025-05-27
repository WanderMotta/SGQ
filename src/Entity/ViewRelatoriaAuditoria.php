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
 * Entity class for "view_relatoria_auditoria" table
 */
#[Entity]
#[Table(name: "view_relatoria_auditoria")]
class ViewRelatoriaAuditoria extends AbstractEntity
{
    #[Id]
    #[Column(name: "plano_nr", type: "integer", nullable: true)]
    #[GeneratedValue]
    private ?int $planoNr;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $data;

    #[Column(name: "auditor_lider", type: "string", nullable: true)]
    private ?string $auditorLider;

    #[Column(type: "string", nullable: true)]
    private ?string $processo;

    #[Column(type: "text", nullable: true)]
    private ?string $escopo;

    #[Column(type: "string", nullable: true)]
    private ?string $auditor;

    #[Column(type: "integer")]
    private int $item;

    #[Column(type: "text")]
    private string $descricao;

    #[Column(type: "text")]
    private string $evidencia;

    #[Column(name: "nao_conformidade", type: "string")]
    private string $naoConformidade;

    #[Column(type: "string")]
    private string $metodo;

    public function __construct()
    {
        $this->naoConformidade = "Nao";
        $this->metodo = "Analise Doc";
    }

    public function getPlanoNr(): ?int
    {
        return $this->planoNr;
    }

    public function setPlanoNr(?int $value): static
    {
        $this->planoNr = $value;
        return $this;
    }

    public function getData(): ?DateTime
    {
        return $this->data;
    }

    public function setData(?DateTime $value): static
    {
        $this->data = $value;
        return $this;
    }

    public function getAuditorLider(): ?string
    {
        return HtmlDecode($this->auditorLider);
    }

    public function setAuditorLider(?string $value): static
    {
        $this->auditorLider = RemoveXss($value);
        return $this;
    }

    public function getProcesso(): ?string
    {
        return HtmlDecode($this->processo);
    }

    public function setProcesso(?string $value): static
    {
        $this->processo = RemoveXss($value);
        return $this;
    }

    public function getEscopo(): ?string
    {
        return HtmlDecode($this->escopo);
    }

    public function setEscopo(?string $value): static
    {
        $this->escopo = RemoveXss($value);
        return $this;
    }

    public function getAuditor(): ?string
    {
        return HtmlDecode($this->auditor);
    }

    public function setAuditor(?string $value): static
    {
        $this->auditor = RemoveXss($value);
        return $this;
    }

    public function getItem(): int
    {
        return $this->item;
    }

    public function setItem(int $value): static
    {
        $this->item = $value;
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

    public function getEvidencia(): string
    {
        return HtmlDecode($this->evidencia);
    }

    public function setEvidencia(string $value): static
    {
        $this->evidencia = RemoveXss($value);
        return $this;
    }

    public function getNaoConformidade(): string
    {
        return $this->naoConformidade;
    }

    public function setNaoConformidade(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'nao_conformidade' value");
        }
        $this->naoConformidade = $value;
        return $this;
    }

    public function getMetodo(): string
    {
        return $this->metodo;
    }

    public function setMetodo(string $value): static
    {
        if (!in_array($value, ["Analise Doc", "Evidencia", "Entrevista"])) {
            throw new \InvalidArgumentException("Invalid 'metodo' value");
        }
        $this->metodo = $value;
        return $this;
    }
}
