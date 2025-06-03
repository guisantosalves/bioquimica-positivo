<?php
require __DIR__ . '/../dao/UserDao.php';
require __DIR__ . '/../model/User.php';

if (isset($_POST['cadastrar'])) {
    $userDao = new UserDao();
    $user = new User();
    $user->setNome($_POST['nome']);
    $user->setCpf($_POST['cpf']);
    $user->setDataNascimento(new DateTime($_POST['data_nascimento']));
    $user->setSexo($_POST['sexo']);
    $user->setTelefone($_POST['telefone']);
    $user->setEmail($_POST['email']);
    $user->setEndereco($_POST['endereco']);
    $user->setSenha(password_hash($_POST['senha'], PASSWORD_DEFAULT)); // Hash da senha por segurança
    $user->setRGM($_POST['rgm'] ?? null); // null se não enviado
    $user->setAdmin(isset($_POST['admin']) ? (bool) $_POST['admin'] : false); // checkbox ou valor booleano

    $userDao->inserir($user);
    header("Location: ../views/userManagement.php");
}

if (isset($_POST['salvar'])) {
    $user = new User();
    $user->setId($_POST['id']);
    $user->setNome($_POST['nome']);
    $user->setCpf($_POST['cpf']);
    $user->setDataNascimento(new DateTime($_POST['dataNascimento']));
    $user->setSexo($_POST['sexo']);
    $user->setTelefone($_POST['telefone']);
    $user->setEmail($_POST['email']);
    $user->setEndereco($_POST['endereco']);
    $user->setSenha($_POST['senha']);
    $user->setRGM($_POST['rgm'] ?? null);
    $user->setAdmin(isset($_POST['admin']) && $_POST['admin'] === '1');

    $userDao = new UserDao();
    $userDao->update($user->getId(), $user);

    header("Location: ../views/userManagement.php");

}


function listar()
{
    $userDao = new UserDao();
    $lista = $userDao->read();
    foreach ($lista as $user) {
        echo "<tr>
            <td>{$user->getId()}</td>
            <td>{$user->getNome()}</td>
            <td>{$user->getCpf()}</td>
            <td>{$user->getDataNascimento()->format('d/m/Y')}</td>
            <td>{$user->getSexo()}</td>
            <td>{$user->getTelefone()}</td>
            <td>{$user->getEmail()}</td>
            <td>{$user->getEndereco()}</td>
            <td>" . ($user->getRGM() ? $user->getRGM() : '-') . "</td>
            <td>" . ($user->isAdmin() ? 'Sim' : 'Não') . "</td>
            <td>
                <a href='../views/userManagement.php?editar={$user->getId()}'>
                    <i class='bi bi-pencil-square'></i> Editar
                </a> 
                <a href='../views/userManagement.php?excluir={$user->getId()}'>Excluir</a>
            </td>
        </tr>";
    }
}

function deleteOne($id)
{
    $userDao = new UserDao();
    $userDao->delete($id);
}

function getById($id)
{
    $userDao = new UserDao();
    return $userDao->readById($id);

}

?>