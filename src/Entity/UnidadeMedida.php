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
 * Entity class for "unidade_medida" table
 */
#[Entity]
#[Table(name: "unidade_medida")]
class UnidadeMedida extends AbstractEntity
{
    #[Id]
    #[Column(name: "idunidade_medida", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idunidadeMedida;

    #[Column(type: "string")]
    private string $unidade;

    public function getIdunidadeMedida(): int
    {
        return $this->idunidadeMedida;
    }

    public function setIdunidadeMedida(int $value): static
    {
        $this->idunidadeMedida = $value;
        return $this;
    }

    public function getUnidade(): string
    {
        return HtmlDecode($this->unidade);
    }

    public function setUnidade(string $value): static
    {
        $this->unidade = RemoveXss($value);
        return $this;
    }
}
