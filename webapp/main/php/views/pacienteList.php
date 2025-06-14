<?php
if (isset($_GET["excluir"])) {
    require_once '../controllers/PacienteController.php';
    deleteOne($_GET['excluir']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <title>Tabela de Pacientes</title>
</head>

<body style="background-color: #BCB8B1">
    <?php include './header.php'; ?>

    <div style="width: 100%; display: flex; justify-content: center;">
        <div class="mt-3 mb-3 bg-light p-3 border rounded" style="width: 80%;">
            <div class="container">
                <div class="w-100 d-flex justify-content-between align-items-center">
                    <p class="h1">Pacientes</p>
                    <a href="./pacienteManagement.php" style="cursor: pointer;">
                        <svg fill="#000000" height="40px" width="40px" viewBox="0 0 490.2 490.2"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M418.5,418.5c95.6-95.6,95.6-251.2,0-346.8s-251.2-95.6-346.8,0s-95.6,251.2,0,346.8S322.9,514.1,418.5,418.5z M89,89 
                            c86.1-86.1,226.1-86.1,312.2,0s86.1,226.1,0,312.2s-226.1,86.1-312.2,0S3,175.1,89,89z" />
                            <path
                                d="M245.1,336.9c3.4,0,6.4-1.4,8.7-3.6c2.2-2.2,3.6-5.3,3.6-8.7v-67.3h67.3c3.4,0,6.4-1.4,8.7-3.6
                            c2.2-2.2,3.6-5.3,3.6-8.7c0-6.8-5.5-12.3-12.2-12.2h-67.3v-67.3c0-6.8-5.5-12.3-12.2-12.2c-6.8,0-12.3,5.5-12.2,12.2v67.3h-67.3
                            c-6.8,0-12.3,5.5-12.2,12.2c0,6.8,5.5,12.3,12.2,12.2h67.3v67.3C232.8,331.4,238.3,336.9,245.1,336.9z" />
                        </svg>
                    </a>
                </div>

                <!-- table -->
                <div class="row mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Data de Nascimento</th>
                                    <th>Sexo</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th>Endereço</th>
                                    <th>RGM</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                                    require_once '../controllers/PacienteController.php';
                                    listarPacientes();
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>