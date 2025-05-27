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
 * Entity class for "status_acao" table
 */
#[Entity]
#[Table(name: "status_acao")]
class StatusAcao extends AbstractEntity
{
    #[Id]
    #[Column(name: "idstatus_acao", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idstatusAcao;

    #[Column(name: "status_acao", type: "string")]
    private string $statusAcao;

    public function getIdstatusAcao(): int
    {
        return $this->idstatusAcao;
    }

    public function setIdstatusAcao(int $value): static
    {
        $this->idstatusAcao = $value;
        return $this;
    }

    public function getStatusAcao(): string
    {
        return HtmlDecode($this->statusAcao);
    }

    public function setStatusAcao(string $value): static
    {
        $this->statusAcao = RemoveXss($value);
        return $this;
    }
}
