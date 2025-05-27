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
 * Entity class for "documento_externo" table
 */
#[Entity]
#[Table(name: "documento_externo")]
class DocumentoExterno extends AbstractEntity
{
    #[Id]
    #[Column(name: "iddocumento_externo", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $iddocumentoExterno;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "titulo_documento", type: "string")]
    private string $tituloDocumento;

    #[Column(type: "string")]
    private string $distribuicao;

    #[Column(name: "tem_validade", type: "string")]
    private string $temValidade;

    #[Column(name: "valido_ate", type: "date", nullable: true)]
    private ?DateTime $validoAte;

    #[Column(name: "restringir_acesso", type: "string")]
    private string $restringirAcesso;

    #[Column(name: "localizacao_idlocalizacao", type: "integer")]
    private int $localizacaoIdlocalizacao;

    #[Column(name: "usuario_responsavel", type: "integer")]
    private int $usuarioResponsavel;

    #[Column(type: "string")]
    private string $anexo;

    #[Column(type: "string", nullable: true)]
    private ?string $obs;

    public function __construct()
    {
        $this->distribuicao = "Eletronica";
        $this->temValidade = "Nao";
        $this->restringirAcesso = "Sim";
    }

    public function getIddocumentoExterno(): int
    {
        return $this->iddocumentoExterno;
    }

    public function setIddocumentoExterno(int $value): static
    {
        $this->iddocumentoExterno = $value;
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

    public function getTituloDocumento(): string
    {
        return HtmlDecode($this->tituloDocumento);
    }

    public function setTituloDocumento(string $value): static
    {
        $this->tituloDocumento = RemoveXss($value);
        return $this;
    }

    public function getDistribuicao(): string
    {
        return $this->distribuicao;
    }

    public function setDistribuicao(string $value): static
    {
        if (!in_array($value, ["Eletronica", "Fisica"])) {
            throw new \InvalidArgumentException("Invalid 'distribuicao' value");
        }
        $this->distribuicao = $value;
        return $this;
    }

    public function getTemValidade(): string
    {
        return $this->temValidade;
    }

    public function setTemValidade(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'tem_validade' value");
        }
        $this->temValidade = $value;
        return $this;
    }

    public function getValidoAte(): ?DateTime
    {
        return $this->validoAte;
    }

    public function setValidoAte(?DateTime $value): static
    {
        $this->validoAte = $value;
        return $this;
    }

    public function getRestringirAcesso(): string
    {
        return $this->restringirAcesso;
    }

    public function setRestringirAcesso(string $value): static
    {
        if (!in_array($value, ["Sim", "Nao"])) {
            throw new \InvalidArgumentException("Invalid 'restringir_acesso' value");
        }
        $this->restringirAcesso = $value;
        return $this;
    }

    public function getLocalizacaoIdlocalizacao(): int
    {
        return $this->localizacaoIdlocalizacao;
    }

    public function setLocalizacaoIdlocalizacao(int $value): static
    {
        $this->localizacaoIdlocalizacao = $value;
        return $this;
    }

    public function getUsuarioResponsavel(): int
    {
        return $this->usuarioResponsavel;
    }

    public function setUsuarioResponsavel(int $value): static
    {
        $this->usuarioResponsavel = $value;
        return $this;
    }

    public function getAnexo(): string
    {
        return HtmlDecode($this->anexo);
    }

    public function setAnexo(string $value): static
    {
        $this->anexo = RemoveXss($value);
        return $this;
    }

    public function getObs(): ?string
    {
        return HtmlDecode($this->obs);
    }

    public function setObs(?string $value): static
    {
        $this->obs = RemoveXss($value);
        return $this;
    }
}
