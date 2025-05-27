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
 * Entity class for "graficos" table
 */
#[Entity]
#[Table(name: "graficos")]
class Grafico extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idgraficos;

    #[Column(name: "competencia_idcompetencia", type: "integer")]
    private int $competenciaIdcompetencia;

    #[Column(name: "indicadores_idindicadores", type: "integer")]
    private int $indicadoresIdindicadores;

    #[Column(name: "data_base", type: "date")]
    private DateTime $dataBase;

    #[Column(type: "decimal")]
    private string $valor;

    #[Column(type: "string", nullable: true)]
    private ?string $obs;

    public function __construct()
    {
        $this->valor = "0.00";
    }

    public function getIdgraficos(): int
    {
        return $this->idgraficos;
    }

    public function setIdgraficos(int $value): static
    {
        $this->idgraficos = $value;
        return $this;
    }

    public function getCompetenciaIdcompetencia(): int
    {
        return $this->competenciaIdcompetencia;
    }

    public function setCompetenciaIdcompetencia(int $value): static
    {
        $this->competenciaIdcompetencia = $value;
        return $this;
    }

    public function getIndicadoresIdindicadores(): int
    {
        return $this->indicadoresIdindicadores;
    }

    public function setIndicadoresIdindicadores(int $value): static
    {
        $this->indicadoresIdindicadores = $value;
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

    public function getValor(): string
    {
        return $this->valor;
    }

    public function setValor(string $value): static
    {
        $this->valor = $value;
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
