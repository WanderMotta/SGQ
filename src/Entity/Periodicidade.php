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
 * Entity class for "periodicidade" table
 */
#[Entity]
#[Table(name: "periodicidade")]
class Periodicidade extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idperiodicidade;

    #[Column(type: "string")]
    private string $periodicidade;

    public function getIdperiodicidade(): int
    {
        return $this->idperiodicidade;
    }

    public function setIdperiodicidade(int $value): static
    {
        $this->idperiodicidade = $value;
        return $this;
    }

    public function getPeriodicidade(): string
    {
        return HtmlDecode($this->periodicidade);
    }

    public function setPeriodicidade(string $value): static
    {
        $this->periodicidade = RemoveXss($value);
        return $this;
    }
}
