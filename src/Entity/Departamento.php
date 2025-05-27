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
 * Entity class for "departamentos" table
 */
#[Entity]
#[Table(name: "departamentos")]
class Departamento extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $iddepartamentos;

    #[Column(type: "string")]
    private string $departamento;

    public function getIddepartamentos(): int
    {
        return $this->iddepartamentos;
    }

    public function setIddepartamentos(int $value): static
    {
        $this->iddepartamentos = $value;
        return $this;
    }

    public function getDepartamento(): string
    {
        return HtmlDecode($this->departamento);
    }

    public function setDepartamento(string $value): static
    {
        $this->departamento = RemoveXss($value);
        return $this;
    }
}
