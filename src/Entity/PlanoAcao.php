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
 * Entity class for "plano_acao" table
 */
#[Entity]
#[Table(name: "plano_acao")]
class PlanoAcao extends AbstractEntity
{
    #[Id]
    #[Column(name: "idplano_acao", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idplanoAcao;

    #[Column(name: "risco_oportunidade_idrisco_oportunidade", type: "integer")]
    private int $riscoOportunidadeIdriscoOportunidade;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "o_q_sera_feito", type: "text")]
    private string $oQSeraFeito;

    #[Column(name: "efeito_esperado", type: "text")]
    private string $efeitoEsperado;

    #[Column(name: "departamentos_iddepartamentos", type: "integer")]
    private int $departamentosIddepartamentos;

    #[Column(name: "origem_risco_oportunidade_idorigem_risco_oportunidade", type: "integer")]
    private int $origemRiscoOportunidadeIdorigemRiscoOportunidade;

    #[Column(name: "recursos_nec", type: "decimal")]
    private string $recursosNec;

    #[Column(name: "dt_limite", type: "date")]
    private DateTime $dtLimite;

    #[Column(type: "string")]
    private string $implementado;

    #[Column(name: "periodicidade_idperiodicidade", type: "integer")]
    private int $periodicidadeIdperiodicidade;

    #[Column(type: "string")]
    private string $eficaz;

    public function __construct()
    {
        $this->recursosNec = "0.00";
        $this->implementado = "Nao";
        $this->eficaz = "Nao";
    }

    public function getIdplanoAcao(): int
    {
        return $this->idplanoAcao;
    }

    public function setIdplanoAcao(int $value): static
    {
        $this->idplanoAcao = $value;
        return $this;
    }

    public function getRiscoOportunidadeIdriscoOportunidade(): int
    {
        return $this->riscoOportunidadeIdriscoOportunidade;
    }

    public function setRiscoOportunidadeIdriscoOportunidade(int $value): static
    {
        $this->riscoOportunidadeIdriscoOportunidade = $value;
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

    public function getDepartamentosIddepartamentos(): int
    {
        return $this->departamentosIddepartamentos;
    }

    public function setDepartamentosIddepartamentos(int $value): static
    {
        $this->departamentosIddepartamentos = $value;
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

    public function getPeriodicidadeIdperiodicidade(): int
    {
        return $this->periodicidadeIdperiodicidade;
    }

    public function setPeriodicidadeIdperiodicidade(int $value): static
    {
        $this->periodicidadeIdperiodicidade = $value;
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
}
