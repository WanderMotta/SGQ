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
 * Entity class for "gestao_mudanca" table
 */
#[Entity]
#[Table(name: "gestao_mudanca")]
class GestaoMudanca extends AbstractEntity
{
    #[Id]
    #[Column(name: "idgestao_mudanca", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idgestaoMudanca;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(type: "string")]
    private string $titulo;

    #[Column(name: "dt_inicio", type: "date")]
    private DateTime $dtInicio;

    #[Column(type: "text")]
    private string $detalhamento;

    #[Column(type: "text")]
    private string $impacto;

    #[Column(type: "text")]
    private string $motivo;

    #[Column(type: "decimal")]
    private string $recursos;

    #[Column(name: "prazo_ate", type: "date")]
    private DateTime $prazoAte;

    #[Column(name: "departamentos_iddepartamentos", type: "integer")]
    private int $departamentosIddepartamentos;

    #[Column(name: "usuario_idusuario", type: "integer")]
    private int $usuarioIdusuario;

    #[Column(type: "string")]
    private string $implementado;

    #[Column(type: "integer")]
    private int $status;

    #[Column(type: "string")]
    private string $eficaz;

    public function __construct()
    {
        $this->recursos = "0.00";
        $this->implementado = "Sim";
        $this->status = 1;
        $this->eficaz = "Sim";
    }

    public function getIdgestaoMudanca(): int
    {
        return $this->idgestaoMudanca;
    }

    public function setIdgestaoMudanca(int $value): static
    {
        $this->idgestaoMudanca = $value;
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

    public function getTitulo(): string
    {
        return HtmlDecode($this->titulo);
    }

    public function setTitulo(string $value): static
    {
        $this->titulo = RemoveXss($value);
        return $this;
    }

    public function getDtInicio(): DateTime
    {
        return $this->dtInicio;
    }

    public function setDtInicio(DateTime $value): static
    {
        $this->dtInicio = $value;
        return $this;
    }

    public function getDetalhamento(): string
    {
        return HtmlDecode($this->detalhamento);
    }

    public function setDetalhamento(string $value): static
    {
        $this->detalhamento = RemoveXss($value);
        return $this;
    }

    public function getImpacto(): string
    {
        return HtmlDecode($this->impacto);
    }

    public function setImpacto(string $value): static
    {
        $this->impacto = RemoveXss($value);
        return $this;
    }

    public function getMotivo(): string
    {
        return HtmlDecode($this->motivo);
    }

    public function setMotivo(string $value): static
    {
        $this->motivo = RemoveXss($value);
        return $this;
    }

    public function getRecursos(): string
    {
        return $this->recursos;
    }

    public function setRecursos(string $value): static
    {
        $this->recursos = $value;
        return $this;
    }

    public function getPrazoAte(): DateTime
    {
        return $this->prazoAte;
    }

    public function setPrazoAte(DateTime $value): static
    {
        $this->prazoAte = $value;
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

    public function getUsuarioIdusuario(): int
    {
        return $this->usuarioIdusuario;
    }

    public function setUsuarioIdusuario(int $value): static
    {
        $this->usuarioIdusuario = $value;
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

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $value): static
    {
        $this->status = $value;
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
