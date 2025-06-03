package service;

import model.ExameSchema;
import db.ConexaoBanco;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.List;
import java.util.Map;
import java.util.Iterator;

public class ExameSchemaService implements ICrud {

  // Helper para escapar strings para JSON (simplificado)
  private static String escapeJsonString(String str) {
    if (str == null) return "";
    return str.replace("\\", "\\\\").replace("\"", "\\\"");
  }

  // Helper para converter Map<String, Object> para uma string JSON (simplificado)
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
      }
      else { // Outros tipos são convertidos para string e escapados
        sb.append("\"").append(escapeJsonString(value.toString())).append("\"");
      }
      if (iterator.hasNext()) {
        sb.append(",");
      }
    }
    sb.append("}");
    return sb.toString();
  }

  // Helper para converter List<Map<String, Object>> para uma string JSON (simplificado)
  private static String listMapToJsonString(List<Map<String, Object>> list) {
    if (list == null || list.isEmpty()) {
      return "[]";
    }
    StringBuilder sb = new StringBuilder();
    sb.append("[");
    for (int i = 0; i < list.size(); i++) {
      sb.append(mapToJsonString(list.get(i)));
      if (i < list.size() - 1) {
        sb.append(",");
      }
    }
    sb.append("]");
    return sb.toString();
  }

  @Override
  public void inserir(IGenericData entidade) {
    if (!(entidade instanceof ExameSchema)) {
      System.err.println("Erro: A entidade fornecida não é um ExameSchema.");
      return;
    }
    ExameSchema schema = (ExameSchema) entidade;
    Connection con = ConexaoBanco.conectar();
    if (con == null) {
      System.err.println("Erro: Não foi possível conectar ao banco de dados.");
      return;
    }

    String sql = "INSERT INTO ExameSchema (id, nome, descricao, campos, versao) " +
            "VALUES (?, ?, ?, ?, ?)";

    try (PreparedStatement pstmt = con.prepareStatement(sql)) {
      pstmt.setInt(1, schema.getId());
      pstmt.setString(2, schema.getNome());
      pstmt.setString(3, schema.getDescricao());
      pstmt.setString(4, listMapToJsonString(schema.getCampos())); // Converte para JSON String
      pstmt.setString(5, schema.getVersao());

      pstmt.executeUpdate();
      System.out.println("Schema de Exame inserido no banco com sucesso: " + schema.getNome() + " (ID: " + schema.getId() + ")");

    } catch (SQLException e) {
      System.err.println("Erro ao inserir schema de exame no banco: " + e.getMessage());
      e.printStackTrace();
    }
  }

  @Override
  public void update(int id, IGenericData entidade) {
    System.out.println("Placeholder: Atualizar schema de exame com ID " + id);
  }

  @Override
  public void delete(int id) {
    System.out.println("Placeholder: Deletar schema de exame com ID " + id);
  }

  @Override
  public List<IGenericData> read() {
    System.out.println("Placeholder: Ler todos os schemas de exame");
    return List.of();
  }

  @Override
  public IGenericData readById(int id) {
    System.out.println("Placeholder: Ler schema de exame com ID " + id);
    return null;
  }
}