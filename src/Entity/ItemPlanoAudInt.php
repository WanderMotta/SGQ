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
 * Entity class for "item_plano_aud_int" table
 */
#[Entity]
#[Table(name: "item_plano_aud_int")]
class ItemPlanoAudInt extends AbstractEntity
{
    #[Id]
    #[Column(name: "iditem_plano_aud_int", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $iditemPlanoAudInt;

    #[Column(type: "date")]
    private DateTime $data;

    #[Column(name: "processo_idprocesso", type: "integer")]
    private int $processoIdprocesso;

    #[Column(type: "text")]
    private string $escopo;

    #[Column(name: "usuario_idusuario", type: "integer")]
    private int $usuarioIdusuario;

    #[Column(name: "plano_auditoria_int_idplano_auditoria_int", type: "integer")]
    private int $planoAuditoriaIntIdplanoAuditoriaInt;

    public function getIditemPlanoAudInt(): int
    {
        return $this->iditemPlanoAudInt;
    }

    public function setIditemPlanoAudInt(int $value): static
    {
        $this->iditemPlanoAudInt = $value;
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

    public function getProcessoIdprocesso(): int
    {
        return $this->processoIdprocesso;
    }

    public function setProcessoIdprocesso(int $value): static
    {
        $this->processoIdprocesso = $value;
        return $this;
    }

    public function getEscopo(): string
    {
        return HtmlDecode($this->escopo);
    }

    public function setEscopo(string $value): static
    {
        $this->escopo = RemoveXss($value);
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

    public function getPlanoAuditoriaIntIdplanoAuditoriaInt(): int
    {
        return $this->planoAuditoriaIntIdplanoAuditoriaInt;
    }

    public function setPlanoAuditoriaIntIdplanoAuditoriaInt(int $value): static
    {
        $this->planoAuditoriaIntIdplanoAuditoriaInt = $value;
        return $this;
    }
}
