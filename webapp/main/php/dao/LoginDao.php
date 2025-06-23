<?php

require_once 'ConnectionFactory.php';

class LoginDao
{
    public function login($email, $senha)
    {
        try {
            $sql = 'SELECT * FROM user WHERE email = "' . $email . '"';
            $conn = ConnectionFactory::getConnection()->query($sql);
            $resultLogin = $conn->fetchAll(PDO::FETCH_ASSOC);

            $resultLoginFirst = $resultLogin[0];

            if (password_verify($senha, $resultLoginFirst['senha'])) {
                // correct login
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            echo "<p>Erro ao fazer login</p><p>$ex</p>";
        }
    }

    public function changePass($email, $senha)
    {
        try {
            $conn = ConnectionFactory::getConnection();

            $sql = 'SELECT * FROM user WHERE email = :email';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                $sqlUpdate = "UPDATE user SET 
                    senha = :senha
                WHERE email = :email";

                $connUpdate = ConnectionFactory::getConnection()->prepare($sqlUpdate);
                $connUpdate->bindValue(":senha", password_hash($senha, PASSWORD_DEFAULT));
                $connUpdate->bindValue(":email", $email);

                return $connUpdate->execute();
            } else {
                header("Location: ../views/forgotPass.php?isEmailWrong=true");
            }
        } catch (PDOException $ex) {
            echo "<p>Erro ao gerenciar usuário</p><p>$ex</p>";
        }
    }
}

?>