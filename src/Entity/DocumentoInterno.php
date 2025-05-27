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
 * Entity class for "documento_interno" table
 */
#[Entity]
#[Table(name: "documento_interno")]
class DocumentoInterno extends AbstractEntity
{
    #[Id]
    #[Column(name: "iddocumento_interno", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $iddocumentoInterno;

    #[Column(name: "titulo_documento", type: "string")]
    private string $tituloDocumento;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(name: "restringir_acesso", type: "string")]
    private string $restringirAcesso;

    #[Column(name: "categoria_documento_idcategoria_documento", type: "integer")]
    private int $categoriaDocumentoIdcategoriaDocumento;

    #[Column(name: "processo_idprocesso", type: "integer")]
    private int $processoIdprocesso;

    #[Column(name: "usuario_idusuario", type: "integer")]
    private int $usuarioIdusuario;

    public function __construct()
    {
        $this->restringirAcesso = "Nao";
    }

    public function getIddocumentoInterno(): int
    {
        return $this->iddocumentoInterno;
    }

    public function setIddocumentoInterno(int $value): static
    {
        $this->iddocumentoInterno = $value;
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

    public function getDtCadastro(): DateTime
    {
        return $this->dtCadastro;
    }

    public function setDtCadastro(DateTime $value): static
    {
        $this->dtCadastro = $value;
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

    public function getCategoriaDocumentoIdcategoriaDocumento(): int
    {
        return $this->categoriaDocumentoIdcategoriaDocumento;
    }

    public function setCategoriaDocumentoIdcategoriaDocumento(int $value): static
    {
        $this->categoriaDocumentoIdcategoriaDocumento = $value;
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

    public function getUsuarioIdusuario(): int
    {
        return $this->usuarioIdusuario;
    }

    public function setUsuarioIdusuario(int $value): static
    {
        $this->usuarioIdusuario = $value;
        return $this;
    }
}
