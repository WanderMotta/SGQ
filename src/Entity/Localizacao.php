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
 * Entity class for "localizacao" table
 */
#[Entity]
#[Table(name: "localizacao")]
class Localizacao extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idlocalizacao;

    #[Column(type: "string")]
    private string $localizacao;

    #[Column(type: "string")]
    private string $ativo;

    public function __construct()
    {
        $this->ativo = "Sim";
    }

    public function getIdlocalizacao(): int
    {
        return $this->idlocalizacao;
    }

    public function setIdlocalizacao(int $value): static
    {
        $this->idlocalizacao = $value;
        return $this;
    }

    public function getLocalizacao(): string
    {
        return HtmlDecode($this->localizacao);
    }

    public function setLocalizacao(string $value): static
    {
        $this->localizacao = RemoveXss($value);
        return $this;
    }

    public function getAtivo(): string
    {
        return $this->ativo;
    }

    public function setAtivo(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'ativo' value");
        }
        $this->ativo = $value;
        return $this;
    }
}
