<?php

// Incluindo arquivo de conexao e funções

include '../includes/connection.php';
include '../includes/functions/user.php';

// Definindo mensagem ao usuário

$message = '';

// Verificando se a requisição é do tipo post

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Pegando os dados da requisição
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificando se há algum dado vazio

    if (!empty($email) && !empty($password)) {

        $verify_user = verifyIfExists($conn, $email);

        if ($verify_user) {

            $verify_password = verifyPassword($conn, $email, $password);

            if ($verify_password) {

                session_start();

                $user = getUserId($conn, $email);

                $user_id = $user['id'];

                $_SESSION['user_id'] = $user_id;

                header('Location: index.php');
            } else {

                $message = 'Senha incorreta!';
            }
        } else {

            $message = 'Usuário não existe!';
        }
    }
}



?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

</head>

<body>
    <div class="container d-flex align-items min-vh-100">

        <div class="container bg-body-tiertary h-50 m-auto border rounded" style="width: 320px">
            <form action="login.php" method="post" id="formLogin">

                <h3 class="h3 mt-3 mb-3">Login</h3>
                <div class="row mb-3 w-100 mx-auto">

                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="emailInput" class="form-control">

                </div>

                <div class="row mb-4 w-100 mx-auto">

                    <label for="password" class="form-label">Senha</label>
                    <input type="password" name="password" id="passwordInput" class="form-control">

                </div>

                <div class="row mb-3 w-50 text-start mx-1">
                    <input type="submit" value="Login" class="btn btn-primary">
                </div>

                <div class="row mb-3 w-50 text-start mx-1">

                    <a class="mt-2" href="registro.php">Registre-se aqui</a>

                </div>

                <div class="row mb-2">
                    <p><?= $message ?></p>
                </div>
            </form>
        </div>

    </div>
    <script>
        document.getElementById('formLogin').addEventListener('submit', function(e) {


            var email = document.getElementById('emailInput').value;
            var password = document.getElementById('passwordInput').value;

            if (email === '' || password === '') {
                e.preventDefault();
                alert('Não deixe campos vazios!');
            }

        });
    </script>

    <script src="js/bootstrap.min.js"></script>

</html>