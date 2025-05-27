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
 * Entity class for "origem_risco_oportunidade" table
 */
#[Entity]
#[Table(name: "origem_risco_oportunidade")]
class OrigemRiscoOportunidade extends AbstractEntity
{
    #[Id]
    #[Column(name: "idorigem_risco_oportunidade", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idorigemRiscoOportunidade;

    #[Column(type: "string")]
    private string $origem;

    #[Column(type: "string", nullable: true)]
    private ?string $obs;

    public function getIdorigemRiscoOportunidade(): int
    {
        return $this->idorigemRiscoOportunidade;
    }

    public function setIdorigemRiscoOportunidade(int $value): static
    {
        $this->idorigemRiscoOportunidade = $value;
        return $this;
    }

    public function getOrigem(): string
    {
        return HtmlDecode($this->origem);
    }

    public function setOrigem(string $value): static
    {
        $this->origem = RemoveXss($value);
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
