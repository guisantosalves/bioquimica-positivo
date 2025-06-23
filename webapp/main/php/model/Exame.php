<?php
require_once __DIR__ . '/../dao/IGenericMainData.php';
class Exame implements IGenericMainData
{
    private int $id;
    private string $idPaciente;
    private int $idSchema;
    private DateTime $dataRealizacao;
    private array $dadosPreenchidos; // JSON no banco, array no PHP
    private string $responsavel;
    private string $observacoes;

    private Paciente $paciente;
    private ExameSchema $schema;

    public function __construct(
        int $id,
        string $idPaciente,
        int $idSchema,
        DateTime $dataRealizacao,
        array $dadosPreenchidos,
        string $responsavel,
        string $observacoes,
        Paciente $paciente,
        ExameSchema $schema
    ) {
        $this->id = $id;
        $this->idPaciente = $idPaciente;
        $this->idSchema = $idSchema;
        $this->dataRealizacao = $dataRealizacao;
        $this->dadosPreenchidos = $dadosPreenchidos;
        $this->responsavel = $responsavel;
        $this->observacoes = $observacoes;
        $this->paciente = $paciente;
        $this->schema = $schema;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getIdPaciente(): string
    {
        return $this->idPaciente;
    }
    public function getIdSchema(): int
    {
        return $this->idSchema;
    }
    public function getDataRealizacao(): DateTime
    {
        return $this->dataRealizacao;
    }
    public function getDadosPreenchidos(): array
    {
        return $this->dadosPreenchidos;
    }
    public function getResponsavel(): string
    {
        return $this->responsavel;
    }
    public function getObservacoes(): string
    {
        return $this->observacoes;
    }
    public function getPaciente(): Paciente
    {
        return $this->paciente;
    }
    public function getSchema(): ExameSchema
    {
        return $this->schema;
    }

    // Setters
    public function setIdPaciente(string $idPaciente): void
    {
        $this->idPaciente = $idPaciente;
    }
    public function setIdSchema(int $idSchema): void
    {
        $this->idSchema = $idSchema;
    }
    public function setDataRealizacao(DateTime $dataRealizacao): void
    {
        $this->dataRealizacao = $dataRealizacao;
    }
    public function setDadosPreenchidos(array $dadosPreenchidos): void
    {
        $this->dadosPreenchidos = $dadosPreenchidos;
    }
    public function setResponsavel(string $responsavel): void
    {
        $this->responsavel = $responsavel;
    }
    public function setObservacoes(string $observacoes): void
    {
        $this->observacoes = $observacoes;
    }
    public function setPaciente(Paciente $paciente): void
    {
        $this->paciente = $paciente;
    }
    public function setSchema(ExameSchema $schema): void
    {
        $this->schema = $schema;
    }
}
