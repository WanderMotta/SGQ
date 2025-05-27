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
 * Entity class for "plano_auditoria_int" table
 */
#[Entity]
#[Table(name: "plano_auditoria_int")]
class PlanoAuditoriaInt extends AbstractEntity
{
    #[Id]
    #[Column(name: "idplano_auditoria_int", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idplanoAuditoriaInt;

    #[Column(type: "date")]
    private DateTime $data;

    #[Column(name: "usuario_idusuario", type: "integer")]
    private int $usuarioIdusuario;

    #[Column(type: "text")]
    private string $criterio;

    #[Column(type: "string", nullable: true)]
    private ?string $arquivo;

    public function getIdplanoAuditoriaInt(): int
    {
        return $this->idplanoAuditoriaInt;
    }

    public function setIdplanoAuditoriaInt(int $value): static
    {
        $this->idplanoAuditoriaInt = $value;
        return $this;
    }

    public function getData(): DateTime
    {
        return $this->data;
    }

    public function setData(DateTime $value): static
    {
        $this->data = $value;
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

    public function getCriterio(): string
    {
        return HtmlDecode($this->criterio);
    }

    public function setCriterio(string $value): static
    {
        $this->criterio = RemoveXss($value);
        return $this;
    }

    public function getArquivo(): ?string
    {
        return HtmlDecode($this->arquivo);
    }

    public function setArquivo(?string $value): static
    {
        $this->arquivo = RemoveXss($value);
        return $this;
    }
}
