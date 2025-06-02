package model;

import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;
import service.IGenericData;

public class Paciente implements IGenericData {

  private String id;
  private String nome;
  private String cpf;
  private LocalDateTime dataNascimento;
  private String sexo;
  private String telefone;
  private String email;
  private String endereco;
  private String senha;
  private String RGM;
  private List<Exame> exames = new ArrayList<>();

  // Getters e Setters

  public String getId() {
    return id;
  }

  public void setId(String id) {
    this.id = id;
  }

  public String getNome() {
    return nome;
  }

  public void setNome(String nome) {
    this.nome = nome;
  }

  public String getCpf() {
    return cpf;
  }

  public void setCpf(String cpf) {
    this.cpf = cpf;
  }

  public LocalDateTime getDataNascimento() {
    return dataNascimento;
  }

  public void setDataNascimento(LocalDateTime dataNascimento) {
    this.dataNascimento = dataNascimento;
  }

  public String getSexo() {
    return sexo;
  }

  public void setSexo(String sexo) {
    this.sexo = sexo;
  }

  public String getTelefone() {
    return telefone;
  }

  public void setTelefone(String telefone) {
    this.telefone = telefone;
  }

  public String getEmail() {
    return email;
  }

  public void setEmail(String email) {
    this.email = email;
  }

  public String getEndereco() {
    return endereco;
  }

  public void setEndereco(String endereco) {
    this.endereco = endereco;
  }

  public String getSenha() {
    return senha;
  }

  public void setSenha(String senha) {
    this.senha = senha;
  }

  public String getRGM() {
    return RGM;
  }

  public void setRGM(String RGM) {
    this.RGM = RGM;
  }

  public List<Exame> getExames() {
    return exames;
  }

  public void setExames(List<Exame> exames) {
    this.exames = exames;
  }

  public void addExame(Exame exame) {
    this.exames.add(exame);
  }
}

