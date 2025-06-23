<?php
require_once __DIR__ . '/../dao/ExameDao.php';
require_once __DIR__ . '/../model/Exame.php';
require_once __DIR__ . '/../dao/PacienteDao.php';
require_once __DIR__ . '/../dao/ExameSchemaDao.php';

$apiBaseUrl = 'http://localhost:3000';

if (isset($_POST['cadastrar'])) {
    $exameDao = new ExameDao($apiBaseUrl);
    $pacienteDao = new PacienteDao($apiBaseUrl);
    $schemaDao = new ExameSchemaDao($apiBaseUrl);

    $paciente = $pacienteDao->readById($_POST['idPaciente']);
    $schema = $schemaDao->readById($_POST['idSchema']);

    $exame = new Exame(
        0,
        $_POST['idPaciente'],
        (int) $_POST['idSchema'],
        new DateTime($_POST['dataRealizacao']),
        json_decode($_POST['dadosPreenchidos'], true),
        $_POST['responsavel'],
        $_POST['observacoes'],
        $paciente,
        $schema
    );

    $exameDao->inserir($exame);
    header("Location: ../views/exameList.php");
}

if (isset($_POST['salvar'])) {
    $exameDao = new ExameDao($apiBaseUrl);
    $pacienteDao = new PacienteDao($apiBaseUrl);
    $schemaDao = new ExameSchemaDao($apiBaseUrl);

    $currDao = $exameDao->readById($_POST['id']);

    $paciente = $pacienteDao->readById($_POST['idPaciente'] ?? $currDao->getIdPaciente());
    $schema = $schemaDao->readById($_POST['idSchema'] ?? $currDao->getIdSchema());

    $exame = new Exame(
        $_POST['id'],
        $paciente->getId(),
        (int) $schema->getId(),
        new DateTime($_POST['dataRealizacao']),
        $_POST['dadosPreenchidos'],
        $_POST['responsavel'],
        $_POST['observacoes'],
        $paciente,
        $schema
    );

    $exameDao->update($_POST['id'], $exame);
    header("Location: ../views/exameList.php");
}

function listarExames()
{
    $exameDao = new ExameDao('http://localhost:3000');
    $lista = $exameDao->read();

    foreach ($lista as $exame) {
        echo "<tr>
            <td>{$exame->getId()}</td>
            <td>" . $exame->getDataRealizacao()->format('d/m/Y H:i') . "</td>
            <td>{$exame->getResponsavel()}</td>
            <td>" . mb_strimwidth($exame->getPaciente()->getNome(), 0, 20, '...') . "</td>
            <td>" . mb_strimwidth($exame->getSchema()->getNome(), 0, 20, '...') . "</td>
            <td style='max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>
                <a style='margin-right: 10px;text-decoration: none;color: blue;' href='http://localhost:3000/exame/download/{$exame->getId()}'>
                    <button type='button' class='btn btn-sm btn-info me-2'><i class='bi bi-box-arrow-down'></i></button>
                </a>
                <a style='margin-right: 10px;text-decoration: none;color: blue;' href='../views/exameManagement.php?editar={$exame->getId()}'>
                    <button type='button' class='btn btn-sm btn-warning me-2'><i class='bi bi-pencil-square'></i></button>
                </a>
                <a style='margin-right: 10px;text-decoration: none;color: blue;' href='../views/exameManagement.php?excluir={$exame->getId()}'>
                    <button type='button' class='btn btn-sm btn-danger me-2'><i class='bi bi-trash'></i></button>
                </a>
            </td>
        </tr>";
    }
}

function deleteExame($id)
{
    $exameDao = new ExameDao('http://localhost:3000');
    $exameDao->delete($id);
    header("Location: ../views/exameList.php");
}

function getExameById($id)
{
    $exameDao = new ExameDao('http://localhost:3000');
    return $exameDao->readById($id);
}

function downloadExame($id)
{
    $exameDao = new ExameDao('http://localhost:3000');
    $exameDao->downloadExame($id);
    // header("Location: ../views/exameList.php");
}

function listarExameSchema($selectedId = null)
{
    $schemaDao = new ExameSchemaDao('http://localhost:3000');
    $lista = $schemaDao->read();

    $html = "<div class='mb-3'>
        <label for='idSchema'>Esquemas</label>
        <select class='form-control' name='idSchema' required>
        <option value=''>Selecione um schema</option>";

    foreach ($lista as $schema) {
        $selected = ($schema->getId() === $selectedId) ? 'selected' : '';
        $html .= "<option value='{$schema->getId()}' {$selected}>{$schema->getNome()}</option>";
    }

    $html .= "</select></div>";

    return $html;
}
?>