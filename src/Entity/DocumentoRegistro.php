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
 * Entity class for "documento_registro" table
 */
#[Entity]
#[Table(name: "documento_registro")]
class DocumentoRegistro extends AbstractEntity
{
    #[Id]
    #[Column(name: "iddocumento_registro", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $iddocumentoRegistro;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(type: "string")]
    private string $titulo;

    #[Column(name: "categoria_documento_idcategoria_documento", type: "integer")]
    private int $categoriaDocumentoIdcategoriaDocumento;

    #[Column(name: "usuario_idusuario", type: "integer")]
    private int $usuarioIdusuario;

    #[Column(type: "string")]
    private string $anexo;

    public function getIddocumentoRegistro(): int
    {
        return $this->iddocumentoRegistro;
    }

    public function setIddocumentoRegistro(int $value): static
    {
        $this->iddocumentoRegistro = $value;
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

    public function getCategoriaDocumentoIdcategoriaDocumento(): int
    {
        return $this->categoriaDocumentoIdcategoriaDocumento;
    }

    public function setCategoriaDocumentoIdcategoriaDocumento(int $value): static
    {
        $this->categoriaDocumentoIdcategoriaDocumento = $value;
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
