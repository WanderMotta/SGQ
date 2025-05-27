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
 * Entity class for "frequencia" table
 */
#[Entity]
#[Table(name: "frequencia")]
class Frequencia extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idfrequencia;

    #[Column(type: "string")]
    private string $frequencia;

    #[Column(type: "integer")]
    private int $grau;

    #[Column(type: "string")]
    private string $obs;

    public function getIdfrequencia(): int
    {
        return $this->idfrequencia;
    }

    public function setIdfrequencia(int $value): static
    {
        $this->idfrequencia = $value;
        return $this;
    }

    public function getFrequencia(): string
    {
        return HtmlDecode($this->frequencia);
    }

    public function setFrequencia(string $value): static
    {
        $this->frequencia = RemoveXss($value);
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

    public function getObs(): string
    {
        return HtmlDecode($this->obs);
    }

    public function setObs(string $value): static
    {
        $this->obs = RemoveXss($value);
        return $this;
    }
}
