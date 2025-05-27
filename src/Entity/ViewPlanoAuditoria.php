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
 * Entity class for "view_plano_auditoria" table
 */
#[Entity]
#[Table(name: "view_plano_auditoria")]
class ViewPlanoAuditoria extends AbstractEntity
{
    #[Id]
    #[Column(name: "idplano_auditoria_int", type: "integer")]
    #[GeneratedValue]
    private int $idplanoAuditoriaInt;

    #[Column(name: "`aud lider`", options: ["name" => "aud lider"], type: "string", nullable: true)]
    private ?string $audlider;

    #[Column(type: "text")]
    private string $criterio;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $data;

    #[Column(type: "string", nullable: true)]
    private ?string $processo;

    #[Column(type: "string", nullable: true)]
    private ?string $auditor;

    #[Column(type: "text", nullable: true)]
    private ?string $escopo;

    #[Column(name: "iditem_plano_aud_int", type: "integer", nullable: true)]
    #[GeneratedValue]
    private ?int $iditemPlanoAudInt;

    public function getIdplanoAuditoriaInt(): int
    {
        return $this->idplanoAuditoriaInt;
    }

    public function setIdplanoAuditoriaInt(int $value): static
    {
        $this->idplanoAuditoriaInt = $value;
        return $this;
    }

    public function getAudlider(): ?string
    {
        return HtmlDecode($this->audlider);
    }

    public function setAudlider(?string $value): static
    {
        $this->audlider = RemoveXss($value);
        return $this;
    }

    public function getCriterio(): string
    {
        return HtmlDecode($this->criterio);
    }

    public function setCriterio(string $value): static
    {
        $this->criterio = RemoveXss($value);
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

    public function getProcesso(): ?string
    {
        return HtmlDecode($this->processo);
    }

    public function setProcesso(?string $value): static
    {
        $this->processo = RemoveXss($value);
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

    public function getEscopo(): ?string
    {
        return HtmlDecode($this->escopo);
    }

    public function setEscopo(?string $value): static
    {
        $this->escopo = RemoveXss($value);
        return $this;
    }

    public function getIditemPlanoAudInt(): ?int
    {
        return $this->iditemPlanoAudInt;
    }

    public function setIditemPlanoAudInt(?int $value): static
    {
        $this->iditemPlanoAudInt = $value;
        return $this;
    }
}
