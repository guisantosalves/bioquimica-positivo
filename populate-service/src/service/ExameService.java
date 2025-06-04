package service;

import model.Exame;
import db.ConexaoBanco;
import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.util.List;


public class ExameService implements ICrud {
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

    String sql = "INSERT INTO Exame (id, idPaciente, idSchema, dataRealizacao, dadosPreenchidos, responsavel, observacoes) " +
            "VALUES (?, ?, ?, ?, ?, ?, ?)";

    try (PreparedStatement pstmt = con.prepareStatement(sql)) {

      ObjectMapper objectMapper = new ObjectMapper();
      String dadosPreenchidosJson = objectMapper.writeValueAsString(exame.getDadosPreenchidos());

      pstmt.setInt(1, exame.getId());
      pstmt.setString(2, exame.getIdPaciente());
      pstmt.setInt(3, exame.getIdSchema());
      if (exame.getDataRealizacao() != null) {
        pstmt.setTimestamp(4, Timestamp.valueOf(exame.getDataRealizacao()));
      } else {
        pstmt.setNull(4, java.sql.Types.TIMESTAMP);
      }
      pstmt.setString(5, dadosPreenchidosJson); // Usa a string JSON gerada pelo Jackson
      pstmt.setString(6, exame.getResponsavel());
      pstmt.setString(7, exame.getObservacoes());

      pstmt.executeUpdate();
      System.out.println("Exame inserido no banco com sucesso: ID " + exame.getId() + ", Paciente ID: " + exame.getIdPaciente());

    } catch (SQLException e) {
      System.err.println("Erro ao inserir exame no banco: " + e.getMessage());
      e.printStackTrace();
    } catch (JsonProcessingException e) { // Tratar a exceção do Jackson
      System.err.println("Erro ao converter dados preenchidos do exame para JSON: " + e.getMessage());
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