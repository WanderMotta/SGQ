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
 * Entity class for "analise_swot" table
 */
#[Entity]
#[Table(name: "analise_swot")]
class AnaliseSwot extends AbstractEntity
{
    #[Id]
    #[Column(name: "idanalise_swot", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idanaliseSwot;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(type: "integer")]
    private int $fatores;

    #[Column(type: "integer")]
    private int $ponto;

    #[Column(type: "text")]
    private string $analise;

    #[Column(name: "impacto_idimpacto", type: "integer")]
    private int $impactoIdimpacto;

    #[Column(name: "contexto_idcontexto", type: "integer")]
    private int $contextoIdcontexto;

    public function getIdanaliseSwot(): int
    {
        return $this->idanaliseSwot;
    }

    public function setIdanaliseSwot(int $value): static
    {
        $this->idanaliseSwot = $value;
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

    public function getFatores(): int
    {
        return $this->fatores;
    }

    public function setFatores(int $value): static
    {
        $this->fatores = $value;
        return $this;
    }

    public function getPonto(): int
    {
        return $this->ponto;
    }

    public function setPonto(int $value): static
    {
        $this->ponto = $value;
        return $this;
    }

    public function getAnalise(): string
    {
        return HtmlDecode($this->analise);
    }

    public function setAnalise(string $value): static
    {
        $this->analise = RemoveXss($value);
        return $this;
    }

    public function getImpactoIdimpacto(): int
    {
        return $this->impactoIdimpacto;
    }

    public function setImpactoIdimpacto(int $value): static
    {
        $this->impactoIdimpacto = $value;
        return $this;
    }

    public function getContextoIdcontexto(): int
    {
        return $this->contextoIdcontexto;
    }

    public function setContextoIdcontexto(int $value): static
    {
        $this->contextoIdcontexto = $value;
        return $this;
    }
}
