<?php
if (isset($_GET["excluir"])) {
    require_once '../controllers/ExameController.php';
    deleteExame($_GET['excluir']);
}
if (isset($_GET["download"])) {
    require_once '../controllers/ExameController.php';
    downloadExame($_GET["download"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <title>Gerenciamento de exame</title>
</head>

<body style="background-color: #BCB8B1">
    <?php include './header.php' ?>
    <div style="width: 100%; display: flex; justify-content: center;">
        <div class="mt-3 mb-3 bg-light p-3 border rounded" style="width: 50%;">
            <div class="container">
                <!-- formulário -->
                <?php include 'forms/ExameForm.php'; ?>
            </div>
        </div>
    </div>
</body>

</html>