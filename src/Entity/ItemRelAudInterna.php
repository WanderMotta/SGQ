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
 * Entity class for "item_rel_aud_interna" table
 */
#[Entity]
#[Table(name: "item_rel_aud_interna")]
class ItemRelAudInterna extends AbstractEntity
{
    #[Id]
    #[Column(name: "iditem_rel_aud_interna", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $iditemRelAudInterna;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "processo_idprocesso", type: "integer")]
    private int $processoIdprocesso;

    #[Column(type: "text")]
    private string $descricao;

    #[Column(name: "acao_imediata", type: "text")]
    private string $acaoImediata;

    #[Column(name: "acao_contecao", type: "text")]
    private string $acaoContecao;

    #[Column(name: "abrir_nc", type: "string")]
    private string $abrirNc;

    #[Column(name: "relatorio_auditoria_interna_idrelatorio_auditoria_interna", type: "integer")]
    private int $relatorioAuditoriaInternaIdrelatorioAuditoriaInterna;

    public function __construct()
    {
        $this->abrirNc = "Sim";
    }

    public function getIditemRelAudInterna(): int
    {
        return $this->iditemRelAudInterna;
    }

    public function setIditemRelAudInterna(int $value): static
    {
        $this->iditemRelAudInterna = $value;
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

    public function getProcessoIdprocesso(): int
    {
        return $this->processoIdprocesso;
    }

    public function setProcessoIdprocesso(int $value): static
    {
        $this->processoIdprocesso = $value;
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

    public function getAcaoImediata(): string
    {
        return HtmlDecode($this->acaoImediata);
    }

    public function setAcaoImediata(string $value): static
    {
        $this->acaoImediata = RemoveXss($value);
        return $this;
    }

    public function getAcaoContecao(): string
    {
        return HtmlDecode($this->acaoContecao);
    }

    public function setAcaoContecao(string $value): static
    {
        $this->acaoContecao = RemoveXss($value);
        return $this;
    }

    public function getAbrirNc(): string
    {
        return $this->abrirNc;
    }

    public function setAbrirNc(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'abrir_nc' value");
        }
        $this->abrirNc = $value;
        return $this;
    }

    public function getRelatorioAuditoriaInternaIdrelatorioAuditoriaInterna(): int
    {
        return $this->relatorioAuditoriaInternaIdrelatorioAuditoriaInterna;
    }

    public function setRelatorioAuditoriaInternaIdrelatorioAuditoriaInterna(int $value): static
    {
        $this->relatorioAuditoriaInternaIdrelatorioAuditoriaInterna = $value;
        return $this;
    }
}
