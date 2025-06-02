package model;

import java.time.LocalDateTime;
import java.util.Map;
import service.IGenericData;

public class Exame implements IGenericData {

  private int id;
  private String idPaciente;
  private int idSchema;
  private LocalDateTime dataRealizacao;
  private Map<String, Object> dadosPreenchidos; // Representação de JSON como Map
  private String responsavel;
  private String observacoes;

  private Paciente paciente;
  private ExameSchema schema;

  public Exame(int id, String idPaciente, int idSchema, LocalDateTime dataRealizacao,
      Map<String, Object> dadosPreenchidos, String responsavel, String observacoes,
      Paciente paciente, ExameSchema schema) {
    this.id = id;
    this.idPaciente = idPaciente;
    this.idSchema = idSchema;
    this.dataRealizacao = dataRealizacao;
    this.dadosPreenchidos = dadosPreenchidos;
    this.responsavel = responsavel;
    this.observacoes = observacoes;
    this.paciente = paciente;
    this.schema = schema;
  }

  // Getters
  public int getId() {
    return id;
  }

  public String getIdPaciente() {
    return idPaciente;
  }

  public int getIdSchema() {
    return idSchema;
  }

  public LocalDateTime getDataRealizacao() {
    return dataRealizacao;
  }

  public Map<String, Object> getDadosPreenchidos() {
    return dadosPreenchidos;
  }

  public String getResponsavel() {
    return responsavel;
  }

  public String getObservacoes() {
    return observacoes;
  }

  public Paciente getPaciente() {
    return paciente;
  }

  public ExameSchema getSchema() {
    return schema;
  }

  // Setters
  public void setIdPaciente(String idPaciente) {
    this.idPaciente = idPaciente;
  }

  public void setIdSchema(int idSchema) {
    this.idSchema = idSchema;
  }

  public void setDataRealizacao(LocalDateTime dataRealizacao) {
    this.dataRealizacao = dataRealizacao;
  }

  public void setDadosPreenchidos(Map<String, Object> dadosPreenchidos) {
    this.dadosPreenchidos = dadosPreenchidos;
  }

  public void setResponsavel(String responsavel) {
    this.responsavel = responsavel;
  }

  public void setObservacoes(String observacoes) {
    this.observacoes = observacoes;
  }

  public void setPaciente(Paciente paciente) {
    this.paciente = paciente;
  }

  public void setSchema(ExameSchema schema) {
    this.schema = schema;
  }
}

