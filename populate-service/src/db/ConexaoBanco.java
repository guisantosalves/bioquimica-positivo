package db;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class ConexaoBanco {
  private static final String URL =
      "jdbc:mysql://localhost:3306/bioquimica?useSSL=false";
  private static final String USUARIO = "root";
  private static final String SENHA = "";
  private static Connection connection;

  public static Connection conectar() {
    try {
      if (connection == null) {
        connection = DriverManager.getConnection(URL, USUARIO, SENHA);
        return connection;
      } else {
        return connection;
      }
    } catch (SQLException e) {
      System.out.println("Erro ao conectar ao banco: " + e.getMessage());
    }
    return null;
  }
}
