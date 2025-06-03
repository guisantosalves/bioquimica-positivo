<?php
if (isset($_GET['editar'])) {
    require '../controllers/UserController.php';

    $user = getById($_GET['editar']);

    echo "<form method='post' action='../controllers/UserController.php'>

    <input type='hidden' name='id' value='" . $user->getId() . "'>

    <div class='mb-3'>
        <label for='nome' class='form-label'>Nome</label>
        <input type='text' class='form-control' name='nome' value='" . $user->getNome() . "'>
    </div>

    <div class='mb-3'>
        <label for='cpf' class='form-label'>CPF</label>
        <input type='text' class='form-control' name='cpf' value='" . $user->getCpf() . "'>
    </div>

    <div class='mb-3'>
        <label for='dataNascimento' class='form-label'>Data de Nascimento</label>
        <input type='date' class='form-control' name='dataNascimento' value='" . $user->getDataNascimento()->format('Y-m-d') . "'>
    </div>

    <div class='mb-3'>
        <label for='sexo' class='form-label'>Sexo</label>
        <select class='form-control' name='sexo'>
            <option value='M' " . ($user->getSexo() === 'M' ? 'selected' : '') . ">Masculino</option>
            <option value='F' " . ($user->getSexo() === 'F' ? 'selected' : '') . ">Feminino</option>
        </select>
    </div>

    <div class='mb-3'>
        <label for='telefone' class='form-label'>Telefone</label>
        <input type='text' class='form-control' name='telefone' value='" . $user->getTelefone() . "'>
    </div>

    <div class='mb-3'>
        <label for='email' class='form-label'>E-mail</label>
        <input type='email' class='form-control' name='email' value='" . $user->getEmail() . "'>
    </div>

    <div class='mb-3'>
        <label for='endereco' class='form-label'>Endereço</label>
        <input type='text' class='form-control' name='endereco' value='" . $user->getEndereco() . "'>
    </div>

    <div class='mb-3'>
        <label for='senha' class='form-label'>Senha</label>
        <input type='password' class='form-control' name='senha' placeholder='Deixe em branco para manter a atual'>
    </div>

    <div class='mb-3'>
        <label for='RGM' class='form-label'>RGM</label>
        <input type='text' class='form-control' name='RGM' value='" . $user->getRGM() . "'>
    </div>

    <div class='mb-3'>
        <label for='admin' class='form-label'>Administrador?</label>
        <select class='form-control' name='admin'>
            <option value='1' " . ($user->isAdmin() ? 'selected' : '') . ">Sim</option>
            <option value='0' " . (!$user->isAdmin() ? 'selected' : '') . ">Não</option>
        </select>
    </div>

    <button type='submit' class='btn btn-primary' name='salvar'>Salvar</button>

</form>";

} else {

    echo "<form method='post' action='../controllers/UserController.php'>
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
            <option value='Masculino'>Masculino</option>
            <option value='Feminino'>Feminino</option>
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
        <label for='senha' class='form-label'>Senha</label>
        <input type='password' class='form-control' name='senha' required>
    </div>

    <div class='mb-3'>
        <label for='rgm' class='form-label'>RGM (opcional)</label>
        <input type='text' class='form-control' name='rgm'>
    </div>

    <div class='form-check mb-3'>
        <input type='checkbox' class='form-check-input' name='admin' value='1' id='admin'>
        <label class='form-check-label' for='admin'>Administrador</label>
    </div>

    <button type='submit' class='btn btn-primary' name='cadastrar'>Cadastrar</button>

</form>";
}

?>