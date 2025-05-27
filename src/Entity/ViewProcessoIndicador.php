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
 * Entity class for "view_processo_indicador" table
 */
#[Entity]
#[Table(name: "view_processo_indicador")]
class ViewProcessoIndicador extends AbstractEntity
{
    #[Column(type: "string", nullable: true)]
    private ?string $processo;

    #[Column(type: "string")]
    private string $indicador;

    #[Column(type: "string")]
    private string $periodicidade;

    #[Column(type: "string")]
    private string $unidade;

    #[Column(type: "decimal")]
    private string $meta;

    public function __construct()
    {
        $this->meta = "0.00";
    }

    public function getProcesso(): ?string
    {
        return HtmlDecode($this->processo);
    }

    public function setProcesso(?string $value): static
    {
        $this->processo = RemoveXss($value);
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

    public function getPeriodicidade(): string
    {
        return HtmlDecode($this->periodicidade);
    }

    public function setPeriodicidade(string $value): static
    {
        $this->periodicidade = RemoveXss($value);
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
