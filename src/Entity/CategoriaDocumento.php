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
 * Entity class for "categoria_documento" table
 */
#[Entity]
#[Table(name: "categoria_documento")]
class CategoriaDocumento extends AbstractEntity
{
    #[Id]
    #[Column(name: "idcategoria_documento", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idcategoriaDocumento;

    #[Column(type: "string")]
    private string $categoria;

    #[Column(type: "string")]
    private string $sigla;

    public function getIdcategoriaDocumento(): int
    {
        return $this->idcategoriaDocumento;
    }

    public function setIdcategoriaDocumento(int $value): static
    {
        $this->idcategoriaDocumento = $value;
        return $this;
    }

    public function getCategoria(): string
    {
        return HtmlDecode($this->categoria);
    }

    public function setCategoria(string $value): static
    {
        $this->categoria = RemoveXss($value);
        return $this;
    }

    public function getSigla(): string
    {
        return HtmlDecode($this->sigla);
    }

    public function setSigla(string $value): static
    {
        $this->sigla = RemoveXss($value);
        return $this;
    }
}
