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
 * Entity class for "indicadores" table
 */
#[Entity]
#[Table(name: "indicadores")]
class Indicadore extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idindicadores;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(type: "string")]
    private string $indicador;

    #[Column(name: "periodicidade_idperiodicidade", type: "integer")]
    private int $periodicidadeIdperiodicidade;

    #[Column(name: "unidade_medida_idunidade_medida", type: "integer")]
    private int $unidadeMedidaIdunidadeMedida;

    #[Column(type: "decimal")]
    private string $meta;

    public function __construct()
    {
        $this->meta = "0.00";
    }

    public function getIdindicadores(): int
    {
        return $this->idindicadores;
    }

    public function setIdindicadores(int $value): static
    {
        $this->idindicadores = $value;
        return $this;
    }

    public function getDtCadastro(): DateTime
    {
        return $this->dtCadastro;
    }

    public function setDtCadastro(DateTime $value): static
    {
        $this->dtCadastro = $value;
        return $this;
    }

    public function getIndicador(): string
    {
        return HtmlDecode($this->indicador);
    }

    public function setIndicador(string $value): static
    {
        $this->indicador = RemoveXss($value);
        return $this;
    }

    public function getPeriodicidadeIdperiodicidade(): int
    {
        return $this->periodicidadeIdperiodicidade;
    }

    public function setPeriodicidadeIdperiodicidade(int $value): static
    {
        $this->periodicidadeIdperiodicidade = $value;
        return $this;
    }

    public function getUnidadeMedidaIdunidadeMedida(): int
    {
        return $this->unidadeMedidaIdunidadeMedida;
    }

    public function setUnidadeMedidaIdunidadeMedida(int $value): static
    {
        $this->unidadeMedidaIdunidadeMedida = $value;
        return $this;
    }

    public function getMeta(): string
    {
        return $this->meta;
    }

    public function setMeta(string $value): static
    {
        $this->meta = $value;
        return $this;
    }
}
