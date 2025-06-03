<?php
if (isset($_GET["excluir"])) {
  require_once '../controllers/UserController.php';
  deleteOne($_GET['excluir']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <title>Gerenciamento de usuário</title>
</head>

<body>
  <?php include './header.php' ?>
  <div class="container">
    <!-- formulário -->
    <div class="row">
      <?php include 'forms/UserForm.php'; ?>
    </div>
    <!-- table -->
    <div class="row">
      <div class="col mx-4 mt-4">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nome</th>
              <th>Cpf</th>
              <th>Data de nascimento</th>
              <th>Sexo</th>
              <th>Telefone</th>
              <th>Email</th>
              <th>Endereço</th>
              <th>RGM</th>
              <th>admin</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <!-- chamar select * from-->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
              require_once '../controllers/UserController.php';
              listar();
            }
            ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</body>

</html>