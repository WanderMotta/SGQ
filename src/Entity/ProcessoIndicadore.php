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
 * Entity class for "processo_indicadores" table
 */
#[Entity]
#[Table(name: "processo_indicadores")]
class ProcessoIndicadore extends AbstractEntity
{
    #[Id]
    #[Column(name: "idprocesso_indicadores", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idprocessoIndicadores;

    #[Column(name: "processo_idprocesso", type: "integer")]
    private int $processoIdprocesso;

    #[Column(name: "indicadores_idindicadores", type: "integer")]
    private int $indicadoresIdindicadores;

    public function getIdprocessoIndicadores(): int
    {
        return $this->idprocessoIndicadores;
    }

    public function setIdprocessoIndicadores(int $value): static
    {
        $this->idprocessoIndicadores = $value;
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

    public function getIndicadoresIdindicadores(): int
    {
        return $this->indicadoresIdindicadores;
    }

    public function setIndicadoresIdindicadores(int $value): static
    {
        $this->indicadoresIdindicadores = $value;
        return $this;
    }
}
