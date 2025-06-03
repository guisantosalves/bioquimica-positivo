package service;

import model.User;
import db.ConexaoBanco;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.util.List;

public class UserService implements ICrud {
  @Override
  public void inserir(IGenericData entidade) {
    if (!(entidade instanceof User)) {
      System.err.println("Erro: A entidade fornecida não é um Usuário.");
      return;
    }
    User user = (User) entidade;
    Connection con = ConexaoBanco.conectar();
    if (con == null) {
      System.err.println("Erro: Não foi possível conectar ao banco de dados.");
      return;
    }

    String sql = "INSERT INTO Usuarios (id, nome, cpf, data_nascimento, sexo, telefone, email, endereco, senha, rgm, admin) " +
            "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try (PreparedStatement pstmt = con.prepareStatement(sql)) {
      pstmt.setString(1, user.getId());
      pstmt.setString(2, user.getNome());
      pstmt.setString(3, user.getCpf());
      if (user.getDataNascimento() != null) {
        pstmt.setTimestamp(4, Timestamp.valueOf(user.getDataNascimento()));
      } else {
        pstmt.setNull(4, java.sql.Types.TIMESTAMP);
      }
      pstmt.setString(5, user.getSexo());
      pstmt.setString(6, user.getTelefone());
      pstmt.setString(7, user.getEmail());
      pstmt.setString(8, user.getEndereco());
      pstmt.setString(9, user.getSenha());
      pstmt.setString(10, user.getRGM());
      pstmt.setBoolean(11, user.isAdmin());

      pstmt.executeUpdate();
      System.out.println("Usuário inserido no banco com sucesso: " + user.getNome() + " (ID: " + user.getId() + ")");

    } catch (SQLException e) {
      System.err.println("Erro ao inserir usuário no banco: " + e.getMessage());
      e.printStackTrace();
    }

  }

  @Override
  public void update(int id, IGenericData entidade) {
    System.out.println("Placeholder: Atualizar usuário com ID " + id);
  }

  @Override
  public void delete(int id) {
    System.out.println("Placeholder: Deletar usuário com ID " + id);
  }

  @Override
  public List<IGenericData> read() {
    System.out.println("Placeholder: Ler todos os usuários");
    return List.of();
  }

  @Override
  public IGenericData readById(int id) {
    System.out.println("Placeholder: Ler usuário com ID " + id);
    return null;
  }
}