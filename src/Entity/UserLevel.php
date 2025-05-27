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
 * Entity class for "UserLevels" table
 */
#[Entity]
#[Table(name: "UserLevels")]
class UserLevel extends AbstractEntity
{
    #[Id]
    #[Column(name: "UserLevelID", type: "integer", unique: true)]
    private int $userLevelId;

    #[Column(name: "UserLevelName", type: "string")]
    private string $userLevelName;

    public function getUserLevelId(): int
    {
        return $this->userLevelId;
    }

    public function setUserLevelId(int $value): static
    {
        $this->userLevelId = $value;
        return $this;
    }

    public function getUserLevelName(): string
    {
        return HtmlDecode($this->userLevelName);
    }

    public function setUserLevelName(string $value): static
    {
        $this->userLevelName = RemoveXss($value);
        return $this;
    }
}
