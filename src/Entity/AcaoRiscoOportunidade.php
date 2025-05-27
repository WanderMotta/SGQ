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
 * Entity class for "acao_risco_oportunidade" table
 */
#[Entity]
#[Table(name: "acao_risco_oportunidade")]
class AcaoRiscoOportunidade extends AbstractEntity
{
    #[Id]
    #[Column(name: "idacao_risco_oportunidade", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idacaoRiscoOportunidade;

    #[Column(name: "tipo_risco_oportunidade_idtipo_risco_oportunidade", type: "integer")]
    private int $tipoRiscoOportunidadeIdtipoRiscoOportunidade;

    #[Column(type: "string")]
    private string $acao;

    #[Column(type: "string")]
    private string $obs;

    public function getIdacaoRiscoOportunidade(): int
    {
        return $this->idacaoRiscoOportunidade;
    }

    public function setIdacaoRiscoOportunidade(int $value): static
    {
        $this->idacaoRiscoOportunidade = $value;
        return $this;
    }

    public function getTipoRiscoOportunidadeIdtipoRiscoOportunidade(): int
    {
        return $this->tipoRiscoOportunidadeIdtipoRiscoOportunidade;
    }

    public function setTipoRiscoOportunidadeIdtipoRiscoOportunidade(int $value): static
    {
        $this->tipoRiscoOportunidadeIdtipoRiscoOportunidade = $value;
        return $this;
    }

    public function getAcao(): string
    {
        return HtmlDecode($this->acao);
    }

    public function setAcao(string $value): static
    {
        $this->acao = RemoveXss($value);
        return $this;
    }

    public function getObs(): string
    {
        return HtmlDecode($this->obs);
    }

    public function setObs(string $value): static
    {
        $this->obs = RemoveXss($value);
        return $this;
    }
}
