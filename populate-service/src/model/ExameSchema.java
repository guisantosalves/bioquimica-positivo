package model;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import service.IGenericData;

public class ExameSchema implements IGenericData {

  private int id;
  private String nome;
  private String descricao;
  private List<Map<String, Object>> campos; // JSON em Java representado como lista de mapas
  private String versao;
  private List<Exame> exames = new ArrayList<>();

  public ExameSchema(int id, String nome, String descricao, List<Map<String, Object>> campos,
      String versao, List<Exame> exames) {
    this.id = id;
    this.nome = nome;
    this.descricao = descricao;
    this.campos = campos;
    this.versao = versao;
    this.exames = exames;
  }

  // Getters
  public int getId() {
    return id;
  }

  public String getNome() {
    return nome;
  }

  public String getDescricao() {
    return descricao;
  }

  public List<Map<String, Object>> getCampos() {
    return campos;
  }

  public String getVersao() {
    return versao;
  }

  public List<Exame> getExames() {
    return exames;
  }

  // Setters
  public void setNome(String nome) {
    this.nome = nome;
  }

  public void setDescricao(String descricao) {
    this.descricao = descricao;
  }

  public void setCampos(List<Map<String, Object>> campos) {
    this.campos = campos;
  }

  public void setVersao(String versao) {
    this.versao = versao;
  }

  public void setExames(List<Exame> exames) {
    this.exames = exames;
  }

  // Adicionar exame individualmente
  public void adicionarExame(Exame exame) {
    this.exames.add(exame);
  }
}
