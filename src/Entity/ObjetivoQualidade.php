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
 * Entity class for "objetivo_qualidade" table
 */
#[Entity]
#[Table(name: "objetivo_qualidade")]
class ObjetivoQualidade extends AbstractEntity
{
    #[Id]
    #[Column(name: "idobjetivo_qualidade", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idobjetivoQualidade;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "processo_idprocesso", type: "integer")]
    private int $processoIdprocesso;

    #[Column(type: "text")]
    private string $objetivo;

    #[Column(name: "como_medir", type: "text")]
    private string $comoMedir;

    #[Column(name: "o_q_sera_feito", type: "text")]
    private string $oQSeraFeito;

    #[Column(name: "como_avaliar", type: "text")]
    private string $comoAvaliar;

    #[Column(name: "departamentos_iddepartamentos", type: "integer")]
    private int $departamentosIddepartamentos;

    public function getIdobjetivoQualidade(): int
    {
        return $this->idobjetivoQualidade;
    }

    public function setIdobjetivoQualidade(int $value): static
    {
        $this->idobjetivoQualidade = $value;
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

    public function getObjetivo(): string
    {
        return HtmlDecode($this->objetivo);
    }

    public function setObjetivo(string $value): static
    {
        $this->objetivo = RemoveXss($value);
        return $this;
    }

    public function getComoMedir(): string
    {
        return HtmlDecode($this->comoMedir);
    }

    public function setComoMedir(string $value): static
    {
        $this->comoMedir = RemoveXss($value);
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

    public function getComoAvaliar(): string
    {
        return HtmlDecode($this->comoAvaliar);
    }

    public function setComoAvaliar(string $value): static
    {
        $this->comoAvaliar = RemoveXss($value);
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
}
