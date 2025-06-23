<?php
require_once '../controllers/ExameController.php';
require_once '../controllers/PacienteController.php';

function printingForms($exame)
{
    $html = "<hr/>";
    $html .= "<h3>Preenchidos pelo schema</h3>";

    foreach ($exame->getSchema()->getCampos() as $item) {
        $nomeCampo = $item['nome'];
        $tipoCampo = $item['tipo'];
        $valor = $exame->getDadosPreenchidos()[$nomeCampo] ?? '';

        $html .= "
        <div class='mb-3'>
            <label class='form-label'>" . htmlspecialchars($nomeCampo) . "</label>
            <input type='" . htmlspecialchars($tipoCampo) . "' class='form-control' name='dadosPreenchidos[" . htmlspecialchars($nomeCampo) . "]' value='" . htmlspecialchars($valor) . "'>
        </div>
        ";
    }

    $html .= "<hr/>";
    return $html;
}

// Se for modo editar
if (isset($_GET['editar'])) {
    $exame = getExameById($_GET['editar']);

    echo "<form method='post' action='../controllers/ExameController.php'>
        <input type='hidden' name='id' value='" . $exame->getId() . "'>
        
        " . listarPacientesSelect($exame->getIdPaciente()) . "

        <div class='mb-3'>
            <label for='idSchema' class='form-label'>Schema do Exame</label>
            <input type='text' disabled class='form-control' name='idSchema' value='" . $exame->getSchema()->getNome() . "' required>
        </div>
        
        <div class='mb-3'>
            <label for='dataRealizacao' class='form-label'>Data de Realização</label>
            <input type='datetime-local' class='form-control' name='dataRealizacao' value='" . $exame->getDataRealizacao()->format('Y-m-d\TH:i') . "' required>
        </div>

        " . printingForms($exame) . "

        <div class='mb-3'>
            <label for='responsavel' class='form-label'>Responsável</label>
            <input type='text' class='form-control' name='responsavel' value='" . $exame->getResponsavel() . "' required>
        </div>

        <div class='mb-3'>
            <label for='observacoes' class='form-label'>Observações</label>
            <textarea class='form-control' name='observacoes' rows='3'>" . $exame->getObservacoes() . "</textarea>
        </div>

        <div class='w-100 d-flex justify-content-end'>
            <a href='./exameList.php'><button type='button' class='btn btn-danger'>Cancelar</button></a>
            <button type='submit' class='btn btn-primary ms-2' name='salvar'>Salvar</button>
        </div>
    </form>";
} else {
    // Modo cadastro
    echo "<form method='post' action='../controllers/ExameController.php'>

        " . listarPacientesSelect() . "

        " . listarExameSchema() . "

        <div class='mb-3'>
            <label for='dataRealizacao' class='form-label'>Data de Realização</label>
            <input type='datetime-local' class='form-control' name='dataRealizacao' required>
        </div>

        <div class='mb-3'>
            <label for='dadosPreenchidos' class='form-label'>Dados Preenchidos (JSON)</label>
            <textarea class='form-control' name='dadosPreenchidos' rows='5' required></textarea>
        </div>

        <div class='mb-3'>
            <label for='responsavel' class='form-label'>Responsável</label>
            <input type='text' class='form-control' name='responsavel' required>
        </div>

        <div class='mb-3'>
            <label for='observacoes' class='form-label'>Observações</label>
            <textarea class='form-control' name='observacoes' rows='3'></textarea>
        </div>

        <div class='w-100 d-flex justify-content-end'>
            <a href='./exameList.php'><button type='button' class='btn btn-danger'>Cancelar</button></a>
            <button type='submit' class='btn btn-primary ms-2' name='cadastrar'>Cadastrar</button>
        </div>
    </form>";
}
?>