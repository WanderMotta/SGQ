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
 * Entity class for "analise_negocio" table
 */
#[Entity]
#[Table(name: "analise_negocio")]
class AnaliseNegocio extends AbstractEntity
{
    #[Id]
    #[Column(name: "idanalise_negocio", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idanaliseNegocio;

    #[Column(type: "string")]
    private string $item;

    #[Column(type: "text")]
    private string $descrever;

    #[Column(type: "integer")]
    private int $posicao;

    public function getIdanaliseNegocio(): int
    {
        return $this->idanaliseNegocio;
    }

    public function setIdanaliseNegocio(int $value): static
    {
        $this->idanaliseNegocio = $value;
        return $this;
    }

    public function getItem(): string
    {
        return HtmlDecode($this->item);
    }

    public function setItem(string $value): static
    {
        $this->item = RemoveXss($value);
        return $this;
    }

    public function getDescrever(): string
    {
        return HtmlDecode($this->descrever);
    }

    public function setDescrever(string $value): static
    {
        $this->descrever = RemoveXss($value);
        return $this;
    }

    public function getPosicao(): int
    {
        return $this->posicao;
    }

    public function setPosicao(int $value): static
    {
        $this->posicao = $value;
        return $this;
    }
}
