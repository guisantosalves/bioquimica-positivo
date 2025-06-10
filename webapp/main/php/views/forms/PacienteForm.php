<?php
if (isset($_GET['editar'])) {
    require '../controllers/PacienteController.php';

    $paciente = getPacienteById($_GET['editar']);

    echo "<form method='post' action='../controllers/PacienteController.php'>

    <input type='hidden' name='id' value='" . $paciente->getId() . "'>

    <div class='mb-3'>
        <label for='nome' class='form-label'>Nome</label>
        <input type='text' class='form-control' name='nome' value='" . $paciente->getNome() . "'>
    </div>

    <div class='mb-3'>
        <label for='cpf' class='form-label'>CPF</label>
        <input type='text' class='form-control' name='cpf' value='" . $paciente->getCpf() . "'>
    </div>

    <div class='mb-3'>
        <label for='dataNascimento' class='form-label'>Data de Nascimento</label>
        <input type='date' class='form-control' name='dataNascimento' value='" . $paciente->getDataNascimento()->format('Y-m-d') . "'>
    </div>

    <div class='mb-3'>
        <label for='sexo' class='form-label'>Sexo</label>
        <select class='form-control' name='sexo'>
            <option value='M' " . ($paciente->getSexo() === 'M' ? 'selected' : '') . ">Masculino</option>
            <option value='F' " . ($paciente->getSexo() === 'F' ? 'selected' : '') . ">Feminino</option>
        </select>
    </div>

    <div class='mb-3'>
        <label for='telefone' class='form-label'>Telefone</label>
        <input type='text' class='form-control' name='telefone' value='" . $paciente->getTelefone() . "'>
    </div>

    <div class='mb-3'>
        <label for='email' class='form-label'>E-mail</label>
        <input type='email' class='form-control' name='email' value='" . $paciente->getEmail() . "'>
    </div>

    <div class='mb-3'>
        <label for='endereco' class='form-label'>Endereço</label>
        <input type='text' class='form-control' name='endereco' value='" . $paciente->getEndereco() . "'>
    </div>

    <div class='mb-3'>
        <label for='rgm' class='form-label'>RGM</label>
        <input type='text' class='form-control' name='rgm' value='" . $paciente->getRgm() . "'>
    </div>

    <div class='w-100 d-flex justify-content-end'>
        <div class='d-flex'>
            <a href='./pacienteList.php'><button type='button' class='btn btn-danger' name='cancelar'>Cancelar</button></a>
            <button type='submit' class='btn btn-primary ms-2' name='salvar'>Salvar</button>
        </div>
    </div>

</form>";

} else {

    echo "<form method='post' action='../controllers/PacienteController.php'>
    <div class='mb-3'>
        <label for='nome' class='form-label'>Nome</label>
        <input type='text' class='form-control' name='nome' required>
    </div>

    <div class='mb-3'>
        <label for='cpf' class='form-label'>CPF</label>
        <input type='text' class='form-control' name='cpf' required>
    </div>

    <div class='mb-3'>
        <label for='data_nascimento' class='form-label'>Data de Nascimento</label>
        <input type='date' class='form-control' name='data_nascimento' required>
    </div>

    <div class='mb-3'>
        <label for='sexo' class='form-label'>Sexo</label>
        <select class='form-control' name='sexo' required>
            <option value=''>Selecione</option>
            <option value='M'>Masculino</option>
            <option value='F'>Feminino</option>
            <option value='Outro'>Outro</option>
        </select>
    </div>

    <div class='mb-3'>
        <label for='telefone' class='form-label'>Telefone</label>
        <input type='text' class='form-control' name='telefone' required>
    </div>

    <div class='mb-3'>
        <label for='email' class='form-label'>E-mail</label>
        <input type='email' class='form-control' name='email' required>
    </div>

    <div class='mb-3'>
        <label for='endereco' class='form-label'>Endereço</label>
        <input type='text' class='form-control' name='endereco' required>
    </div>

    <div class='mb-3'>
        <label for='rgm' class='form-label'>RGM (opcional)</label>
        <input type='text' class='form-control' name='rgm'>
    </div>

    <div class='w-100 d-flex justify-content-end'>
        <div>
            <a href='./pacienteList.php'><button type='button' class='btn btn-danger' name='cancelar'>Cancelar</button></a>
            <button type='submit' class='btn btn-primary ms-2' name='cadastrar'>Cadastrar</button>
        </div>
    </div>

</form>";
}
?>