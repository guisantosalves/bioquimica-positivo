<?php
require_once __DIR__ . '/../dao/IGenericMainData.php';
class ExameSchema implements IGenericMainData
{
    private int $id;
    private string $nome;
    private string $descricao;
    private array $campos; // vindo de um campo JSON
    private string $versao;
    private array $exames = []; // relacionamento com vários exames

    public function __construct(
        int $id,
        string $nome,
        string $descricao,
        array $campos,
        string $versao,
        array $exames = []
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->campos = $campos;
        $this->versao = $versao;
        $this->exames = $exames;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getNome(): string
    {
        return $this->nome;
    }
    public function getDescricao(): string
    {
        return $this->descricao;
    }
    public function getCampos(): array
    {
        return $this->campos;
    }
    public function getVersao(): string
    {
        return $this->versao;
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
    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }
    public function setCampos(array $campos): void
    {
        $this->campos = $campos;
    }
    public function setVersao(string $versao): void
    {
        $this->versao = $versao;
    }
    public function setExames(array $exames): void
    {
        $this->exames = $exames;
    }

    // Adicionar exame individualmente
    public function adicionarExame($exame): void
    {
        $this->exames[] = $exame;
    }
}
