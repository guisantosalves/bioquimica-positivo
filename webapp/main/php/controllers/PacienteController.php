<?php
require_once __DIR__ . '/../dao/PacienteDao.php';
require_once __DIR__ . '/../model/Paciente.php';

if (isset($_POST['cadastrar'])) {
    $pacienteDao = new PacienteDao('http://localhost:3000');
    $paciente = new Paciente();
    $paciente->setNome($_POST['nome']);
    $paciente->setCpf($_POST['cpf']);
    $paciente->setDataNascimento(new DateTime($_POST['dataNascimento']));
    $paciente->setSexo($_POST['sexo']);
    $paciente->setTelefone($_POST['telefone']);
    $paciente->setEmail($_POST['email']);
    $paciente->setEndereco($_POST['endereco']);
    $paciente->setRGM($_POST['rgm'] ?? null); // RGM pode ser opcional

    $pacienteDao->inserir($paciente);
    header("Location: ../views/pacienteList.php");
}

if (isset($_POST['salvar'])) {
    $paciente = new Paciente();
    $paciente->setId($_POST['id']);
    $paciente->setNome($_POST['nome']);
    $paciente->setCpf($_POST['cpf']);
    $paciente->setDataNascimento(new DateTime($_POST['dataNascimento']));
    $paciente->setSexo($_POST['sexo']);
    $paciente->setTelefone($_POST['telefone']);
    $paciente->setEmail($_POST['email']);
    $paciente->setEndereco($_POST['endereco']);
    $paciente->setRGM($_POST['rgm'] ?? null);

    $pacienteDao = new PacienteDao('http://localhost:3000');
    $pacienteDao->update($paciente->getId(), $paciente);

    header("Location: ../views/pacienteList.php");
}

function listarPacientes()
{
    $pacienteDao = new PacienteDao('http://localhost:3000');
    $lista = $pacienteDao->read();
    foreach ($lista as $paciente) {
        echo "<tr>
            <td>" . mb_strimwidth($paciente->getId(), 0, 10, '...') . "</td>
            <td>{$paciente->getNome()}</td>
            <td>{$paciente->getCpf()}</td>
            <td>{$paciente->getDataNascimento()->format('d/m/Y')}</td>
            <td>{$paciente->getSexo()}</td>
            <td>{$paciente->getTelefone()}</td>
            <td>{$paciente->getEmail()}</td>
            <td>" . mb_strimwidth($paciente->getEndereco(), 0, 20, '...') . "</td>
            <td>" . ($paciente->getRGM() ? $paciente->getRGM() : '-') . "</td>
            <td style='max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>
                <a style='margin-right: 10px;text-decoration: none;color: blue;' href='../views/pacienteManagement.php?editar={$paciente->getId()}'>
                    <button type='button' class='btn btn-sm btn-warning me-2'><i class='bi bi-pencil-square'></i></button>
                </a>
                <a style='margin-right: 10px;text-decoration: none;color: blue;' href='../views/pacienteManagement.php?excluir={$paciente->getId()}'>
                    <button type='button' class='btn btn-sm btn-danger me-2'><i class='bi bi-trash'></i></button>
                </a>
            </td>
        </tr>";
    }
}

function deletePaciente($id)
{
    $pacienteDao = new PacienteDao('http://localhost:3000');
    $pacienteDao->delete($id);
    header("Location: ../views/pacienteList.php");
}

function getPacienteById($id)
{
    $pacienteDao = new PacienteDao('http://localhost:3000');
    return $pacienteDao->readById($id);
}

function listarPacientesSelect($selectedId = null)
{
    $pacienteDao = new PacienteDao('http://localhost:3000');
    $lista = $pacienteDao->read();

    $html = "<div class='mb-3'>
        <label for='idPaciente'>Paciente</label>
        <select class='form-control' name='idPaciente' required>
        <option value=''>Selecione um paciente</option>";

    foreach ($lista as $paciente) {
        $selected = ($paciente->getId() === $selectedId) ? 'selected' : '';
        $html .= "<option value='{$paciente->getId()}' {$selected}>{$paciente->getNome()} - {$paciente->getCpf()}</option>";
    }

    $html .= "</select></div>";

    return $html;
}
?>