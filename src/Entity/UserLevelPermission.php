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
 * Entity class for "UserLevelPermissions" table
 */
#[Entity]
#[Table(name: "UserLevelPermissions")]
class UserLevelPermission extends AbstractEntity
{
    #[Id]
    #[Column(name: "UserLevelID", type: "integer")]
    private int $userLevelId;

    #[Id]
    #[Column(name: "TableName", type: "string")]
    private string $tableName;

    #[Column(name: "Permission", type: "integer")]
    private int $permission;

    public function __construct(int $userLevelId, string $tableName)
    {
        $this->userLevelId = $userLevelId;
        $this->tableName = $tableName;
    }

    public function getUserLevelId(): int
    {
        return $this->userLevelId;
    }

    public function setUserLevelId(int $value): static
    {
        $this->userLevelId = $value;
        return $this;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function setTableName(string $value): static
    {
        $this->tableName = $value;
        return $this;
    }

    public function getPermission(): int
    {
        return $this->permission;
    }

    public function setPermission(int $value): static
    {
        $this->permission = $value;
        return $this;
    }
}
