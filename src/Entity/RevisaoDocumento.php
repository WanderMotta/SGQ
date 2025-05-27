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
 * Entity class for "revisao_documento" table
 */
#[Entity]
#[Table(name: "revisao_documento")]
class RevisaoDocumento extends AbstractEntity
{
    #[Id]
    #[Column(name: "idrevisao_documento", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idrevisaoDocumento;

    #[Column(name: "documento_interno_iddocumento_interno", type: "integer")]
    private int $documentoInternoIddocumentoInterno;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "qual_alteracao", type: "text")]
    private string $qualAlteracao;

    #[Column(name: "status_documento_idstatus_documento", type: "integer")]
    private int $statusDocumentoIdstatusDocumento;

    #[Column(name: "revisao_nr", type: "integer")]
    private int $revisaoNr;

    #[Column(name: "usuario_elaborador", type: "integer")]
    private int $usuarioElaborador;

    #[Column(name: "usuario_aprovador", type: "integer")]
    private int $usuarioAprovador;

    #[Column(name: "dt_aprovacao", type: "date", nullable: true)]
    private ?DateTime $dtAprovacao;

    #[Column(type: "string")]
    private string $anexo;

    public function __construct()
    {
        $this->qualAlteracao = "Documento Inicial";
        $this->statusDocumentoIdstatusDocumento = "1";
        $this->revisaoNr = 0;
    }

    public function getIdrevisaoDocumento(): int
    {
        return $this->idrevisaoDocumento;
    }

    public function setIdrevisaoDocumento(int $value): static
    {
        $this->idrevisaoDocumento = $value;
        return $this;
    }

    public function getDocumentoInternoIddocumentoInterno(): int
    {
        return $this->documentoInternoIddocumentoInterno;
    }

    public function setDocumentoInternoIddocumentoInterno(int $value): static
    {
        $this->documentoInternoIddocumentoInterno = $value;
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

    public function getQualAlteracao(): string
    {
        return HtmlDecode($this->qualAlteracao);
    }

    public function setQualAlteracao(string $value): static
    {
        $this->qualAlteracao = RemoveXss($value);
        return $this;
    }

    public function getStatusDocumentoIdstatusDocumento(): int
    {
        return $this->statusDocumentoIdstatusDocumento;
    }

    public function setStatusDocumentoIdstatusDocumento(int $value): static
    {
        $this->statusDocumentoIdstatusDocumento = $value;
        return $this;
    }

    public function getRevisaoNr(): int
    {
        return $this->revisaoNr;
    }

    public function setRevisaoNr(int $value): static
    {
        $this->revisaoNr = $value;
        return $this;
    }

    public function getUsuarioElaborador(): int
    {
        return $this->usuarioElaborador;
    }

    public function setUsuarioElaborador(int $value): static
    {
        $this->usuarioElaborador = $value;
        return $this;
    }

    public function getUsuarioAprovador(): int
    {
        return $this->usuarioAprovador;
    }

    public function setUsuarioAprovador(int $value): static
    {
        $this->usuarioAprovador = $value;
        return $this;
    }

    public function getDtAprovacao(): ?DateTime
    {
        return $this->dtAprovacao;
    }

    public function setDtAprovacao(?DateTime $value): static
    {
        $this->dtAprovacao = $value;
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
}
