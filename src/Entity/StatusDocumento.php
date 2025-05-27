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
 * Entity class for "status_documento" table
 */
#[Entity]
#[Table(name: "status_documento")]
class StatusDocumento extends AbstractEntity
{
    #[Id]
    #[Column(name: "idstatus_documento", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idstatusDocumento;

    #[Column(type: "string")]
    private string $status;

    public function getIdstatusDocumento(): int
    {
        return $this->idstatusDocumento;
    }

    public function setIdstatusDocumento(int $value): static
    {
        $this->idstatusDocumento = $value;
        return $this;
    }

    public function getStatus(): string
    {
        return HtmlDecode($this->status);
    }

    public function setStatus(string $value): static
    {
        $this->status = RemoveXss($value);
        return $this;
    }
}
