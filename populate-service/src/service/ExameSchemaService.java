package service;

import model.ExameSchema;
import db.ConexaoBanco;
import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.List;


public class ExameSchemaService implements ICrud {
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

      ObjectMapper objectMapper = new ObjectMapper();
      String camposJson = objectMapper.writeValueAsString(schema.getCampos());

      pstmt.setInt(1, schema.getId());
      pstmt.setString(2, schema.getNome());
      pstmt.setString(3, schema.getDescricao());
      pstmt.setString(4, camposJson); // Usa a string JSON gerada pelo Jackson
      pstmt.setString(5, schema.getVersao());

      pstmt.executeUpdate();
      System.out.println("Schema de Exame inserido no banco com sucesso: " + schema.getNome() + " (ID: " + schema.getId() + ")");

    } catch (SQLException e) {
      System.err.println("Erro ao inserir schema de exame no banco: " + e.getMessage());
      e.printStackTrace();
    } catch (JsonProcessingException e) { // Tratar a exceção do Jackson
      System.err.println("Erro ao converter campos do schema para JSON: " + e.getMessage());
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