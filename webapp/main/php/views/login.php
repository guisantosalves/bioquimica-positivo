<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="./css/login.css" />
  <title>Login</title>
</head>

<body>
  <div class="main-container">
    <div class="container-login">
      <div>
        <form method="post" action="../controllers/loginController.php">
          <div class="input-container">
            <label class="form-label" for="emailInputLogin">Email</label>
            <input class="form-control" type="text" name="email" id="emailInputLogin" />
          </div>

          <div class="input-container">
            <label class="form-label" for="passwordInputLogin">Senha</label>
            <input class="form-control" type="password" name="password" id="passwordInputLogin" />
            <a class="text-info" style="cursor: pointer;text-decoration:none;" href="./forgotPass.php">Esqueci minha
              senha</a>
          </div>
          <div class="btn-login-container">
            <button type="submit" name="login">Login</button>
          </div>
          <?php
          if (isset($_GET['login'])) {
            echo '<div class="input-container text-danger">Email ou senha incorreto</div>';
          }
          ?>
        </form>
      </div>
    </div>
  </div>
</body>

</html>