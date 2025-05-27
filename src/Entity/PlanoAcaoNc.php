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
 * Entity class for "plano_acao_nc" table
 */
#[Entity]
#[Table(name: "plano_acao_nc")]
class PlanoAcaoNc extends AbstractEntity
{
    #[Id]
    #[Column(name: "idplano_acao_nc", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idplanoAcaoNc;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "nao_conformidade_idnao_conformidade", type: "integer")]
    private int $naoConformidadeIdnaoConformidade;

    #[Column(name: "o_q_sera_feito", type: "text")]
    private string $oQSeraFeito;

    #[Column(name: "efeito_esperado", type: "text")]
    private string $efeitoEsperado;

    #[Column(name: "usuario_idusuario", type: "integer")]
    private int $usuarioIdusuario;

    #[Column(name: "recursos_nec", type: "decimal")]
    private string $recursosNec;

    #[Column(name: "dt_limite", type: "date")]
    private DateTime $dtLimite;

    #[Column(type: "string")]
    private string $implementado;

    #[Column(type: "string")]
    private string $eficaz;

    #[Column(type: "text", nullable: true)]
    private ?string $evidencia;

    public function __construct()
    {
        $this->recursosNec = "0.00";
        $this->implementado = "Nao";
        $this->eficaz = "Nao";
    }

    public function getIdplanoAcaoNc(): int
    {
        return $this->idplanoAcaoNc;
    }

    public function setIdplanoAcaoNc(int $value): static
    {
        $this->idplanoAcaoNc = $value;
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

    public function getNaoConformidadeIdnaoConformidade(): int
    {
        return $this->naoConformidadeIdnaoConformidade;
    }

    public function setNaoConformidadeIdnaoConformidade(int $value): static
    {
        $this->naoConformidadeIdnaoConformidade = $value;
        return $this;
    }

    public function getOQSeraFeito(): string
    {
        return HtmlDecode($this->oQSeraFeito);
    }

    public function setOQSeraFeito(string $value): static
    {
        $this->oQSeraFeito = RemoveXss($value);
        return $this;
    }

    public function getEfeitoEsperado(): string
    {
        return HtmlDecode($this->efeitoEsperado);
    }

    public function setEfeitoEsperado(string $value): static
    {
        $this->efeitoEsperado = RemoveXss($value);
        return $this;
    }

    public function getUsuarioIdusuario(): int
    {
        return $this->usuarioIdusuario;
    }

    public function setUsuarioIdusuario(int $value): static
    {
        $this->usuarioIdusuario = $value;
        return $this;
    }

    public function getRecursosNec(): string
    {
        return $this->recursosNec;
    }

    public function setRecursosNec(string $value): static
    {
        $this->recursosNec = $value;
        return $this;
    }

    public function getDtLimite(): DateTime
    {
        return $this->dtLimite;
    }

    public function setDtLimite(DateTime $value): static
    {
        $this->dtLimite = $value;
        return $this;
    }

    public function getImplementado(): string
    {
        return $this->implementado;
    }

    public function setImplementado(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'implementado' value");
        }
        $this->implementado = $value;
        return $this;
    }

    public function getEficaz(): string
    {
        return $this->eficaz;
    }

    public function setEficaz(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'eficaz' value");
        }
        $this->eficaz = $value;
        return $this;
    }

    public function getEvidencia(): ?string
    {
        return HtmlDecode($this->evidencia);
    }

    public function setEvidencia(?string $value): static
    {
        $this->evidencia = RemoveXss($value);
        return $this;
    }
}
