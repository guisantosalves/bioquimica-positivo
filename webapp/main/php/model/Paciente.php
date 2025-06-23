<?php
require_once __DIR__ . '/../dao/IGenericMainData.php';
class Paciente implements IGenericMainData
{
    private string $id;
    private string $nome;
    private string $cpf;
    private DateTime $dataNascimento;
    private string $sexo;
    private string $telefone;
    private string $email;
    private string $endereco;
    private ?string $RGM;
    private array $exames = []; // Lista de objetos Exame

    // Getters e Setters

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getDataNascimento(): DateTime
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(DateTime $dataNascimento): void
    {
        $this->dataNascimento = $dataNascimento;
    }

    public function getSexo(): string
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo): void
    {
        $this->sexo = $sexo;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): void
    {
        $this->telefone = $telefone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEndereco(): string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): void
    {
        $this->endereco = $endereco;
    }

    public function getRGM(): ?string
    {
        return $this->RGM;
    }

    public function setRGM(?string $RGM): void
    {
        $this->RGM = $RGM;
    }

    public function getExames(): array
    {
        return $this->exames;
    }

    public function setExames(array $exames): void
    {
        $this->exames = $exames;
    }

    public function addExame(Exame $exame): void
    {
        $this->exames[] = $exame;
    }
}


?>