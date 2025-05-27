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
 * Entity class for "processo" table
 */
#[Entity]
#[Table(name: "processo")]
class Processo extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $idprocesso;

    #[Column(name: "dt_cadastro", type: "date")]
    private DateTime $dtCadastro;

    #[Column(type: "string")]
    private string $revisao;

    #[Column(name: "tipo_idtipo", type: "integer")]
    private int $tipoIdtipo;

    #[Column(type: "string")]
    private string $processo;

    #[Column(type: "string")]
    private string $responsaveis;

    #[Column(type: "text")]
    private string $objetivo;

    #[Column(name: "proc_antes", type: "integer")]
    private int $procAntes;

    #[Column(name: "proc_depois", type: "integer")]
    private int $procDepois;

    #[Column(name: "eqpto_recursos", type: "text")]
    private string $eqptoRecursos;

    #[Column(type: "text")]
    private string $entradas;

    #[Column(name: "atividade_principal", type: "text")]
    private string $atividadePrincipal;

    #[Column(name: "saidas_resultados", type: "text")]
    private string $saidasResultados;

    #[Column(name: "requsito_saidas", type: "text")]
    private string $requsitoSaidas;

    #[Column(type: "text")]
    private string $riscos;

    #[Column(type: "text")]
    private string $oportunidades;

    #[Column(name: "propriedade_externa", type: "text")]
    private string $propriedadeExterna;

    #[Column(type: "text")]
    private string $conhecimentos;

    #[Column(name: "documentos_aplicados", type: "text")]
    private string $documentosAplicados;

    #[Column(name: "proced_int_trabalho", type: "string")]
    private string $procedIntTrabalho;

    #[Column(type: "string")]
    private string $mapa;

    #[Column(type: "string", nullable: true)]
    private ?string $formulario;

    public function __construct()
    {
        $this->tipoIdtipo = 1;
    }

    public function getIdprocesso(): int
    {
        return $this->idprocesso;
    }

    public function setIdprocesso(int $value): static
    {
        $this->idprocesso = $value;
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

    public function getRevisao(): string
    {
        return HtmlDecode($this->revisao);
    }

    public function setRevisao(string $value): static
    {
        $this->revisao = RemoveXss($value);
        return $this;
    }

    public function getTipoIdtipo(): int
    {
        return $this->tipoIdtipo;
    }

    public function setTipoIdtipo(int $value): static
    {
        $this->tipoIdtipo = $value;
        return $this;
    }

    public function getProcesso(): string
    {
        return HtmlDecode($this->processo);
    }

    public function setProcesso(string $value): static
    {
        $this->processo = RemoveXss($value);
        return $this;
    }

    public function getResponsaveis(): string
    {
        return HtmlDecode($this->responsaveis);
    }

    public function setResponsaveis(string $value): static
    {
        $this->responsaveis = RemoveXss($value);
        return $this;
    }

    public function getObjetivo(): string
    {
        return HtmlDecode($this->objetivo);
    }

    public function setObjetivo(string $value): static
    {
        $this->objetivo = RemoveXss($value);
        return $this;
    }

    public function getProcAntes(): int
    {
        return $this->procAntes;
    }

    public function setProcAntes(int $value): static
    {
        $this->procAntes = $value;
        return $this;
    }

    public function getProcDepois(): int
    {
        return $this->procDepois;
    }

    public function setProcDepois(int $value): static
    {
        $this->procDepois = $value;
        return $this;
    }

    public function getEqptoRecursos(): string
    {
        return HtmlDecode($this->eqptoRecursos);
    }

    public function setEqptoRecursos(string $value): static
    {
        $this->eqptoRecursos = RemoveXss($value);
        return $this;
    }

    public function getEntradas(): string
    {
        return HtmlDecode($this->entradas);
    }

    public function setEntradas(string $value): static
    {
        $this->entradas = RemoveXss($value);
        return $this;
    }

    public function getAtividadePrincipal(): string
    {
        return HtmlDecode($this->atividadePrincipal);
    }

    public function setAtividadePrincipal(string $value): static
    {
        $this->atividadePrincipal = RemoveXss($value);
        return $this;
    }

    public function getSaidasResultados(): string
    {
        return HtmlDecode($this->saidasResultados);
    }

    public function setSaidasResultados(string $value): static
    {
        $this->saidasResultados = RemoveXss($value);
        return $this;
    }

    public function getRequsitoSaidas(): string
    {
        return HtmlDecode($this->requsitoSaidas);
    }

    public function setRequsitoSaidas(string $value): static
    {
        $this->requsitoSaidas = RemoveXss($value);
        return $this;
    }

    public function getRiscos(): string
    {
        return HtmlDecode($this->riscos);
    }

    public function setRiscos(string $value): static
    {
        $this->riscos = RemoveXss($value);
        return $this;
    }

    public function getOportunidades(): string
    {
        return HtmlDecode($this->oportunidades);
    }

    public function setOportunidades(string $value): static
    {
        $this->oportunidades = RemoveXss($value);
        return $this;
    }

    public function getPropriedadeExterna(): string
    {
        return HtmlDecode($this->propriedadeExterna);
    }

    public function setPropriedadeExterna(string $value): static
    {
        $this->propriedadeExterna = RemoveXss($value);
        return $this;
    }

    public function getConhecimentos(): string
    {
        return HtmlDecode($this->conhecimentos);
    }

    public function setConhecimentos(string $value): static
    {
        $this->conhecimentos = RemoveXss($value);
        return $this;
    }

    public function getDocumentosAplicados(): string
    {
        return HtmlDecode($this->documentosAplicados);
    }

    public function setDocumentosAplicados(string $value): static
    {
        $this->documentosAplicados = RemoveXss($value);
        return $this;
    }

    public function getProcedIntTrabalho(): string
    {
        return HtmlDecode($this->procedIntTrabalho);
    }

    public function setProcedIntTrabalho(string $value): static
    {
        $this->procedIntTrabalho = RemoveXss($value);
        return $this;
    }

    public function getMapa(): string
    {
        return HtmlDecode($this->mapa);
    }

    public function setMapa(string $value): static
    {
        $this->mapa = RemoveXss($value);
        return $this;
    }

    public function getFormulario(): ?string
    {
        return HtmlDecode($this->formulario);
    }

    public function setFormulario(?string $value): static
    {
        $this->formulario = RemoveXss($value);
        return $this;
    }
}
