<?php
require 'ICrudData.php';
require 'ConnectionFactory.php';
require __DIR__ . '/../utils/ManageUuid.php';
class UserDao implements ICrudData
{
    public function inserir($user)
    {
        try {
            $sql = "INSERT INTO user (
                id, nome, cpf, dataNascimento, sexo, telefone, email, endereco, senha, rgm, admin
            ) VALUES (
                :id, :nome, :cpf, :dataNascimento, :sexo, :telefone, :email, :endereco, :senha, :rgm, :admin
            )";

            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":id", generateUUIDv4());
            $conn->bindValue(":nome", $user->getNome());
            $conn->bindValue(":cpf", $user->getCpf());
            $conn->bindValue(":dataNascimento", $user->getDataNascimento()->format("Y-m-d")); // ou "Y-m-d H:i:s" se usar datetime
            $conn->bindValue(":sexo", $user->getSexo());
            $conn->bindValue(":telefone", $user->getTelefone());
            $conn->bindValue(":email", $user->getEmail());
            $conn->bindValue(":endereco", $user->getEndereco());
            $conn->bindValue(":senha", $user->getSenha());
            $conn->bindValue(":rgm", $user->getRGM()); // como é nullable, ok enviar null
            $conn->bindValue(":admin", $user->isAdmin(), PDO::PARAM_BOOL);

            return $conn->execute();
        } catch (PDOException $ex) {
            echo "<p>Erro ao inserir usuário</p><p>$ex</p>";
        }

    }
    public function update(string $id, $user)
    {
        try {
            $sql = "";
            if ($user->getSenha() != "") {
                $sql = "UPDATE user SET 
                    nome = :nome,
                    cpf = :cpf,
                    dataNascimento = :dataNascimento,
                    sexo = :sexo,
                    telefone = :telefone,
                    email = :email,
                    endereco = :endereco,
                    senha = :senha,
                    RGM = :RGM,
                    admin = :admin
                WHERE id = :id";
            } else {
                $sql = "UPDATE user SET 
                    nome = :nome,
                    cpf = :cpf,
                    dataNascimento = :dataNascimento,
                    sexo = :sexo,
                    telefone = :telefone,
                    email = :email,
                    endereco = :endereco,
                    RGM = :RGM,
                    admin = :admin
                WHERE id = :id";
            }


            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":id", $id);
            $conn->bindValue(":nome", $user->getNome());
            $conn->bindValue(":cpf", $user->getCpf());
            $conn->bindValue(":dataNascimento", $user->getDataNascimento()->format('Y-m-d'));
            $conn->bindValue(":sexo", $user->getSexo());
            $conn->bindValue(":telefone", $user->getTelefone());
            $conn->bindValue(":email", $user->getEmail());
            $conn->bindValue(":endereco", $user->getEndereco());
            if ($user->getSenha() != "") {
                $conn->bindValue(":senha", $user->getSenha());
            }
            $conn->bindValue(":RGM", $user->getRGM());
            $conn->bindValue(":admin", $user->isAdmin(), PDO::PARAM_BOOL);

            return $conn->execute();
        } catch (PDOException $ex) {
            echo "<p>Erro ao atualizar usuário:</p><p>$ex</p>";
            return false;
        }
    }

    public function delete(string $id)
    {
        try {
            $sql = "DELETE FROM user WHERE id = :id";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":id", $id);
            return $conn->execute();
        } catch (PDOException $ex) {
            echo "<p>Erro ao excluir usuário:</p><p>$ex</p>";
            return false;
        }
    }

    public function read()
    {
        try {
            $sql = "SELECT * FROM user";
            $conn = ConnectionFactory::getConnection()->query($sql);
            $lista = $conn->fetchAll(PDO::FETCH_ASSOC);
            $userList = [];

            foreach ($lista as $row) {
                array_push($userList, $this->mapUser($row));
            }

            return $userList;
        } catch (PDOException $ex) {
            echo "<p>Ocorreu um erro ao executar a consulta</p> {$ex}";
            return [];
        }
    }

    private function mapUser($row)
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setNome($row['nome']);
        $user->setCpf($row['cpf']);
        $user->setDataNascimento(new DateTime($row['dataNascimento']));
        $user->setSexo($row['sexo']);
        $user->setTelefone($row['telefone']);
        $user->setEmail($row['email']);
        $user->setEndereco($row['endereco']);
        $user->setSenha($row['senha']);
        $user->setRGM($row['RGM']);
        $user->setAdmin((bool) $row['admin']);
        return $user;
    }

    public function readById($id)
    {
        try {
            $sql = "SELECT * FROM user WHERE id = :id";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":id", $id);
            $conn->execute();

            $row = $conn->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return $this->mapUser($row);
            }

            return null;
        } catch (PDOException $ex) {
            echo "<p>Erro ao buscar usuário por ID:</p><p>$ex</p>";
            return null;
        }
    }
}

?>