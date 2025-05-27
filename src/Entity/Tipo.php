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
 * Entity class for "tipo" table
 */
#[Entity]
#[Table(name: "tipo")]
class Tipo extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idtipo;

    #[Column(type: "string")]
    private string $tipo;

    public function getIdtipo(): int
    {
        return $this->idtipo;
    }

    public function setIdtipo(int $value): static
    {
        $this->idtipo = $value;
        return $this;
    }

    public function getTipo(): string
    {
        return HtmlDecode($this->tipo);
    }

    public function setTipo(string $value): static
    {
        $this->tipo = RemoveXss($value);
        return $this;
    }
}
