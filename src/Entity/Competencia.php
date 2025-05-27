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
 * Entity class for "competencia" table
 */
#[Entity]
#[Table(name: "competencia")]
class Competencia extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idcompetencia;

    #[Column(type: "integer")]
    private int $mes;

    #[Column(type: "integer")]
    private int $ano;

    #[Column(name: "data_base", type: "date")]
    private DateTime $dataBase;

    public function __construct()
    {
        $this->ano = 2023;
    }

    public function getIdcompetencia(): int
    {
        return $this->idcompetencia;
    }

    public function setIdcompetencia(int $value): static
    {
        $this->idcompetencia = $value;
        return $this;
    }

    public function getMes(): int
    {
        return $this->mes;
    }

    public function setMes(int $value): static
    {
        $this->mes = $value;
        return $this;
    }

    public function getAno(): int
    {
        return $this->ano;
    }

    public function setAno(int $value): static
    {
        $this->ano = $value;
        return $this;
    }

    public function getDataBase(): DateTime
    {
        return $this->dataBase;
    }

    public function setDataBase(DateTime $value): static
    {
        $this->dataBase = $value;
        return $this;
    }
}
