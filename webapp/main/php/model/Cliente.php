<?php

class Cliente implements IGenericMainData
{
    private string $id;
    private string $nome;
    private string $cpf;
    private DateTime $dataNascimento;
    private string $sexo;
    private string $telefone;
    private string $email;
    private string $endereco;
    private string $senha;
    private bool $paciente;
    private ?string $rgm = null;
    private array $exames = [];

    public function __construct(
        string $nome,
        string $cpf,
        DateTime $dataNascimento,
        string $sexo,
        string $telefone,
        string $email,
        string $endereco,
        string $senha,
        bool $paciente,
        ?string $rgm = null,
        array $exames = []
    ) {
        $this->id = uniqid(); // Simula UUID
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->dataNascimento = $dataNascimento;
        $this->sexo = $sexo;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->endereco = $endereco;
        $this->senha = $senha;
        $this->paciente = $paciente;
        $this->rgm = $rgm;
        $this->exames = $exames;
    }

    // Getters
    public function getId(): string
    {
        return $this->id;
    }
    public function getNome(): string
    {
        return $this->nome;
    }
    public function getCpf(): string
    {
        return $this->cpf;
    }
    public function getDataNascimento(): DateTime
    {
        return $this->dataNascimento;
    }
    public function getSexo(): string
    {
        return $this->sexo;
    }
    public function getTelefone(): string
    {
        return $this->telefone;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getEndereco(): string
    {
        return $this->endereco;
    }
    public function getSenha(): string
    {
        return $this->senha;
    }
    public function isPaciente(): bool
    {
        return $this->paciente;
    }
    public function getRgm(): ?string
    {
        return $this->rgm;
    }
    public function getExames(): array
    {
        return $this->exames;
    }

    // Setters
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }
    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }
    public function setDataNascimento(DateTime $dataNascimento): void
    {
        $this->dataNascimento = $dataNascimento;
    }
    public function setSexo(string $sexo): void
    {
        $this->sexo = $sexo;
    }
    public function setTelefone(string $telefone): void
    {
        $this->telefone = $telefone;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setEndereco(string $endereco): void
    {
        $this->endereco = $endereco;
    }
    public function setSenha(string $senha): void
    {
        $this->senha = $senha;
    }
    public function setPaciente(bool $paciente): void
    {
        $this->paciente = $paciente;
    }
    public function setRgm(?string $rgm): void
    {
        $this->rgm = $rgm;
    }
    public function setExames(array $exames): void
    {
        $this->exames = $exames;
    }

    // Opcional: adicionar um exame à lista
    public function adicionarExame($exame): void
    {
        $this->exames[] = $exame;
    }
}
