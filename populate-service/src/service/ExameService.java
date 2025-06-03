package service;

import model.Exame;
import db.ConexaoBanco;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.util.List;
import java.util.Map;
import java.util.Iterator;

public class ExameService implements ICrud {

  // Helper para escapar strings para JSON (simplificado) - pode ser movido para uma classe Util
  private static String escapeJsonString(String str) {
    if (str == null) return "";
    return str.replace("\\", "\\\\").replace("\"", "\\\"");
  }

  // Helper para converter Map<String, Object> para uma string JSON (simplificado) - pode ser movido para uma classe Util
  private static String mapToJsonString(Map<String, Object> map) {
    if (map == null || map.isEmpty()) {
      return "{}";
    }
    StringBuilder sb = new StringBuilder();
    sb.append("{");
    Iterator<Map.Entry<String, Object>> iterator = map.entrySet().iterator();
    while (iterator.hasNext()) {
      Map.Entry<String, Object> entry = iterator.next();
      sb.append("\"").append(escapeJsonString(entry.getKey())).append("\":");
      Object value = entry.getValue();
      if (value instanceof String) {
        sb.append("\"").append(escapeJsonString(value.toString())).append("\"");
      } else if (value instanceof Number || value instanceof Boolean) {
        sb.append(value.toString());
      } else if (value == null) {
        sb.append("null");
      } else { // Outros tipos são convertidos para string e escapados
        sb.append("\"").append(escapeJsonString(value.toString())).append("\"");
      }
      if (iterator.hasNext()) {
        sb.append(",");
      }
    }
    sb.append("}");
    return sb.toString();
  }


  @Override
  public void inserir(IGenericData entidade) {
    if (!(entidade instanceof Exame)) {
      System.err.println("Erro: A entidade fornecida não é um Exame.");
      return;
    }
    Exame exame = (Exame) entidade;
    Connection con = ConexaoBanco.conectar();
    if (con == null) {
      System.err.println("Erro: Não foi possível conectar ao banco de dados.");
      return;
    }

    String sql = "INSERT INTO Exames (id, id_paciente, id_schema, data_realizacao, dados_preenchidos, responsavel, observacoes) " +
            "VALUES (?, ?, ?, ?, ?, ?, ?)";

    try (PreparedStatement pstmt = con.prepareStatement(sql)) {
      pstmt.setInt(1, exame.getId());
      pstmt.setString(2, exame.getIdPaciente());
      pstmt.setInt(3, exame.getIdSchema());
      if (exame.getDataRealizacao() != null) {
        pstmt.setTimestamp(4, Timestamp.valueOf(exame.getDataRealizacao()));
      } else {
        pstmt.setNull(4, java.sql.Types.TIMESTAMP);
      }
      pstmt.setString(5, mapToJsonString(exame.getDadosPreenchidos())); // Converte para JSON String
      pstmt.setString(6, exame.getResponsavel());
      pstmt.setString(7, exame.getObservacoes());

      pstmt.executeUpdate();
      System.out.println("Exame inserido no banco com sucesso: ID " + exame.getId() + ", Paciente ID: " + exame.getIdPaciente());

    } catch (SQLException e) {
      System.err.println("Erro ao inserir exame no banco: " + e.getMessage());
      e.printStackTrace();
    }
  }

  @Override
  public void update(int id, IGenericData entidade) {
    System.out.println("Placeholder: Atualizar exame com ID " + id);
  }

  @Override
  public void delete(int id) {
    System.out.println("Placeholder: Deletar exame com ID " + id);
  }

  @Override
  public List<IGenericData> read() {
    System.out.println("Placeholder: Ler todos os exames");
    return List.of();
  }

  @Override
  public IGenericData readById(int id) {
    System.out.println("Placeholder: Ler exame com ID " + id);
    return null;
  }
}