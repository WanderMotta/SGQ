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
 * Entity class for "consideracoes" table
 */
#[Entity]
#[Table(name: "consideracoes")]
class Consideracoe extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idconsideracoes;

    #[Column(type: "string")]
    private string $titulo;

    #[Column(type: "text")]
    private string $consideracao;

    public function getIdconsideracoes(): int
    {
        return $this->idconsideracoes;
    }

    public function setIdconsideracoes(int $value): static
    {
        $this->idconsideracoes = $value;
        return $this;
    }

    public function getTitulo(): string
    {
        return HtmlDecode($this->titulo);
    }

    public function setTitulo(string $value): static
    {
        $this->titulo = RemoveXss($value);
        return $this;
    }

    public function getConsideracao(): string
    {
        return HtmlDecode($this->consideracao);
    }

    public function setConsideracao(string $value): static
    {
        $this->consideracao = RemoveXss($value);
        return $this;
    }
}
