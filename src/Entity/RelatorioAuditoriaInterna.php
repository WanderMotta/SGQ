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
 * Entity class for "relatorio_auditoria_interna" table
 */
#[Entity]
#[Table(name: "relatorio_auditoria_interna")]
class RelatorioAuditoriaInterna extends AbstractEntity
{
    #[Id]
    #[Column(name: "idrelatorio_auditoria_interna", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idrelatorioAuditoriaInterna;

    #[Column(type: "date")]
    private DateTime $data;

    #[Column(name: "origem_risco_oportunidade_idorigem_risco_oportunidade", type: "integer")]
    private int $origemRiscoOportunidadeIdorigemRiscoOportunidade;

    #[Column(type: "integer")]
    private int $auditor;

    #[Column(type: "integer")]
    private int $aprovador;

    public function getIdrelatorioAuditoriaInterna(): int
    {
        return $this->idrelatorioAuditoriaInterna;
    }

    public function setIdrelatorioAuditoriaInterna(int $value): static
    {
        $this->idrelatorioAuditoriaInterna = $value;
        return $this;
    }

    public function getData(): DateTime
    {
        return $this->data;
    }

    public function setData(DateTime $value): static
    {
        $this->data = $value;
        return $this;
    }

    public function getOrigemRiscoOportunidadeIdorigemRiscoOportunidade(): int
    {
        return $this->origemRiscoOportunidadeIdorigemRiscoOportunidade;
    }

    public function setOrigemRiscoOportunidadeIdorigemRiscoOportunidade(int $value): static
    {
        $this->origemRiscoOportunidadeIdorigemRiscoOportunidade = $value;
        return $this;
    }

    public function getAuditor(): int
    {
        return $this->auditor;
    }

    public function setAuditor(int $value): static
    {
        $this->auditor = $value;
        return $this;
    }

    public function getAprovador(): int
    {
        return $this->aprovador;
    }

    public function setAprovador(int $value): static
    {
        $this->aprovador = $value;
        return $this;
    }
}
