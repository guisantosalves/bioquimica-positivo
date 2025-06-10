<?php
require __DIR__ . '/../dao/LoginDao.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $loginD = new LoginDao();
    $LoginResult = $loginD->login($email, $pass);

    if ($LoginResult) {
        header("Location: ../views/userManagement.php");
    } else {
        header("Location: ../views/login.php?login=fail");
    }
}

if (isset($_POST['confirmChangePass'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    
    $loginD = new LoginDao();
    $changeResult = $loginD->changePass($email, $pass);
    
    header("Location: ../views/login.php");
}
?>