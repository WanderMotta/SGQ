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
 * Entity class for "contexto" table
 */
#[Entity]
#[Table(name: "contexto")]
class Contexto extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idcontexto;

    #[Column(type: "integer")]
    private int $ano;

    #[Column(type: "integer")]
    private int $revisao;

    #[Column(type: "date")]
    private DateTime $data;

    #[Column(name: "usuario_idusuario", type: "integer")]
    private int $usuarioIdusuario;

    #[Column(name: "usuario_idusuario1", type: "integer")]
    private int $usuarioIdusuario1;

    #[Column(type: "string", nullable: true)]
    private ?string $obs;

    public function __construct()
    {
        $this->ano = 2023;
        $this->revisao = 0;
    }

    public function getIdcontexto(): int
    {
        return $this->idcontexto;
    }

    public function setIdcontexto(int $value): static
    {
        $this->idcontexto = $value;
        return $this;
    }

    public function getAno(): int
    {
        return $this->ano;
    }

    public function setAno(int $value): static
    {
        $this->ano = $value;
        return $this;
    }

    public function getRevisao(): int
    {
        return $this->revisao;
    }

    public function setRevisao(int $value): static
    {
        $this->revisao = $value;
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

    public function getUsuarioIdusuario1(): int
    {
        return $this->usuarioIdusuario1;
    }

    public function setUsuarioIdusuario1(int $value): static
    {
        $this->usuarioIdusuario1 = $value;
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
