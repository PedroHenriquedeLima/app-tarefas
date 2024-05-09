<?php

// Incluindo arquivo de conexao e funções

include '../includes/connection.php';
include '../includes/functions/user.php';

// Definindo mensagem ao usuário

$message = '';

// Verificando se a requisição é do tipo post

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Pegando os dados da requisição

  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Verificando se há algum dado vazio

  if (!empty($username) && !empty($email) && !empty($password)) {

    // Verificando se o email já existe nos registros
    $verify = verifyIfExists($conn, $email);


    if (!$verify) {
      // Ação para inserir usuário
      $success = insertUser($conn, $username, $email, $password);

      if ($success) {

        $user = getUserId($conn, $email);
        $user_id = $user['id'];

        session_start();

        $_SESSION['user_id'] = $user_id;

        header('Location: index.php');
        exit();
      } else {

        // Modificando a mensagem caso haja erro
        $message = 'Erro ao cadastrar usuário';
      }
    } else {

      // Caso o email já esteja registrado
      $message = 'Esse email já foi cadastrado!';
    }
  }
}


?>

<!doctype html>
<html lang="pt-BR">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar-se</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">

</head>

<body>


  <div class="container d-flex align-items  min-vh-100">

    <div class="container bg-body-tiertary h-50 m-auto border rounded" style="width: 320px">
      <form id="formRegister" action="registro.php" method="POST">

        <h3 class="h3 mt-3 mb-3">Registrar-se</h3>

        <div class="row mb-3 w-100 mx-auto">

          <label for="username" class="form-label">Nome</label>
          <input type="text" name="username" id="usernameInput" class="form-control">

        </div>
        <div class="row mb-3 w-100 mx-auto">

          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="emailInput" class="form-control">

        </div>

        <div class="row mb-4 w-100 mx-auto">

          <label for="password" class="form-label">Senha</label>
          <input type="password" name="password" id="passwordInput" class="form-control">

        </div>

        <div class="row mb-4 w-50 text-start mx-2">
          <input type="submit" value="Confirmar" class="btn btn-primary">
        </div>



        <p class="mb-3"><?= $message ?></p>
      </form>

    </div>

  </div>

  <script>
    document.getElementById('formRegister').addEventListener('submit', function(e) {


      var username = document.getElementById('usernameInput').value;
      var email = document.getElementById('emailInput').value;
      var password = document.getElementById('passwordInput').value;

      if (username === '' || email === '' || password === '') {
        e.preventDefault();
        alert('Não deixe campos vazios!');
      }

    });
  </script>


  <script src="js/bootstrap.min.js"></script>
</body>

</html>