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
 * Entity class for "tipo_risco_oportunidade" table
 */
#[Entity]
#[Table(name: "tipo_risco_oportunidade")]
class TipoRiscoOportunidade extends AbstractEntity
{
    #[Id]
    #[Column(name: "idtipo_risco_oportunidade", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idtipoRiscoOportunidade;

    #[Column(name: "tipo_risco_oportunidade", type: "string")]
    private string $tipoRiscoOportunidade;

    public function getIdtipoRiscoOportunidade(): int
    {
        return $this->idtipoRiscoOportunidade;
    }

    public function setIdtipoRiscoOportunidade(int $value): static
    {
        $this->idtipoRiscoOportunidade = $value;
        return $this;
    }

    public function getTipoRiscoOportunidade(): string
    {
        return HtmlDecode($this->tipoRiscoOportunidade);
    }

    public function setTipoRiscoOportunidade(string $value): static
    {
        $this->tipoRiscoOportunidade = RemoveXss($value);
        return $this;
    }
}
