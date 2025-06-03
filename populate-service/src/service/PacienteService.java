package service;

import model.Paciente;
import db.ConexaoBanco;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.util.List;

public class PacienteService implements ICrud {
  @Override
  public void inserir(IGenericData entidade) {
    if (!(entidade instanceof Paciente)) {
      System.err.println("Erro: A entidade fornecida não é um Paciente.");
      return;
    }
    Paciente paciente = (Paciente) entidade;
    Connection con = ConexaoBanco.conectar();
    if (con == null) {
      System.err.println("Erro: Não foi possível conectar ao banco de dados.");
      return;
    }

    String sql = "INSERT INTO Pacientes (id, nome, cpf, data_nascimento, sexo, telefone, email, endereco, senha, rgm) " +
            "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try (PreparedStatement pstmt = con.prepareStatement(sql)) {
      pstmt.setString(1, paciente.getId());
      pstmt.setString(2, paciente.getNome());
      pstmt.setString(3, paciente.getCpf());
      if (paciente.getDataNascimento() != null) {
        pstmt.setTimestamp(4, Timestamp.valueOf(paciente.getDataNascimento()));
      } else {
        pstmt.setNull(4, java.sql.Types.TIMESTAMP);
      }
      pstmt.setString(5, paciente.getSexo());
      pstmt.setString(6, paciente.getTelefone());
      pstmt.setString(7, paciente.getEmail());
      pstmt.setString(8, paciente.getEndereco());
      pstmt.setString(9, paciente.getSenha());
      pstmt.setString(10, paciente.getRGM());

      pstmt.executeUpdate();
      System.out.println("Paciente inserido no banco com sucesso: " + paciente.getNome() + " (ID: " + paciente.getId() + ")");

    } catch (SQLException e) {
      System.err.println("Erro ao inserir paciente no banco: " + e.getMessage());
      e.printStackTrace();
    }
  }

  @Override
  public void update(int id, IGenericData entidade) {
    System.out.println("Placeholder: Atualizar paciente com ID " + id);
  }

  @Override
  public void delete(int id) {
    System.out.println("Placeholder: Deletar paciente com ID " + id);
  }

  @Override
  public List<IGenericData> read() {
    System.out.println("Placeholder: Ler todos os pacientes");
    return List.of();
  }

  @Override
  public IGenericData readById(int id) {
    System.out.println("Placeholder: Ler paciente com ID " + id);
    return null;
  }
}