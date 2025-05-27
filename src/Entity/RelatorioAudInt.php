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
 * Entity class for "relatorio_aud_int" table
 */
#[Entity]
#[Table(name: "relatorio_aud_int")]
class RelatorioAudInt extends AbstractEntity
{
    #[Id]
    #[Column(name: "idrelatorio_aud_int", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idrelatorioAudInt;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "plano_auditoria_int_idplano_auditoria_int", type: "integer")]
    private int $planoAuditoriaIntIdplanoAuditoriaInt;

    #[Column(name: "item_plano_aud_int_iditem_plano_aud_int", type: "integer")]
    private int $itemPlanoAudIntIditemPlanoAudInt;

    #[Column(type: "string")]
    private string $metodo;

    #[Column(type: "text")]
    private string $descricao;

    #[Column(type: "text")]
    private string $evidencia;

    #[Column(name: "nao_conformidade", type: "string")]
    private string $naoConformidade;

    public function __construct()
    {
        $this->metodo = "Analise Doc";
        $this->naoConformidade = "Nao";
    }

    public function getIdrelatorioAudInt(): int
    {
        return $this->idrelatorioAudInt;
    }

    public function setIdrelatorioAudInt(int $value): static
    {
        $this->idrelatorioAudInt = $value;
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

    public function getPlanoAuditoriaIntIdplanoAuditoriaInt(): int
    {
        return $this->planoAuditoriaIntIdplanoAuditoriaInt;
    }

    public function setPlanoAuditoriaIntIdplanoAuditoriaInt(int $value): static
    {
        $this->planoAuditoriaIntIdplanoAuditoriaInt = $value;
        return $this;
    }

    public function getItemPlanoAudIntIditemPlanoAudInt(): int
    {
        return $this->itemPlanoAudIntIditemPlanoAudInt;
    }

    public function setItemPlanoAudIntIditemPlanoAudInt(int $value): static
    {
        $this->itemPlanoAudIntIditemPlanoAudInt = $value;
        return $this;
    }

    public function getMetodo(): string
    {
        return $this->metodo;
    }

    public function setMetodo(string $value): static
    {
        if (!in_array($value, ["Analise Doc", "Evidencia", "Entrevista"])) {
            throw new \InvalidArgumentException("Invalid 'metodo' value");
        }
        $this->metodo = $value;
        return $this;
    }

    public function getDescricao(): string
    {
        return HtmlDecode($this->descricao);
    }

    public function setDescricao(string $value): static
    {
        $this->descricao = RemoveXss($value);
        return $this;
    }

    public function getEvidencia(): string
    {
        return HtmlDecode($this->evidencia);
    }

    public function setEvidencia(string $value): static
    {
        $this->evidencia = RemoveXss($value);
        return $this;
    }

    public function getNaoConformidade(): string
    {
        return $this->naoConformidade;
    }

    public function setNaoConformidade(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'nao_conformidade' value");
        }
        $this->naoConformidade = $value;
        return $this;
    }
}
