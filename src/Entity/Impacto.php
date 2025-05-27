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
 * Entity class for "impacto" table
 */
#[Entity]
#[Table(name: "impacto")]
class Impacto extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idimpacto;

    #[Column(name: "tipo_risco_oportunidade_idtipo_risco_oportunidade", type: "integer")]
    private int $tipoRiscoOportunidadeIdtipoRiscoOportunidade;

    #[Column(type: "string")]
    private string $impacto;

    #[Column(type: "integer")]
    private int $grau;

    #[Column(type: "string", nullable: true)]
    private ?string $obs;

    public function getIdimpacto(): int
    {
        return $this->idimpacto;
    }

    public function setIdimpacto(int $value): static
    {
        $this->idimpacto = $value;
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

    public function getImpacto(): string
    {
        return HtmlDecode($this->impacto);
    }

    public function setImpacto(string $value): static
    {
        $this->impacto = RemoveXss($value);
        return $this;
    }

    public function getGrau(): int
    {
        return $this->grau;
    }

    public function setGrau(int $value): static
    {
        $this->grau = $value;
        return $this;
    }

    public function getObs(): ?string
    {
        return HtmlDecode($this->obs);
    }

    public function setObs(?string $value): static
    {
        $this->obs = RemoveXss($value);
        return $this;
    }
}
