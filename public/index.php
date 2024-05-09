<?php

ini_set("display_errors", 1);

session_start();

include '../includes/functions/task.php';
include '../includes/connection.php';


if (!isset($_SESSION['user_id'])) {

  header('Location: login.php');
  exit();
}


$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Nome da tarefa 

  $taskname = $_POST['taskname'];

  // Verificando se o nome da tarefa está vazio

  if (!empty($taskname)) {

    $action = insertTask($conn, $taskname, $user_id);

    header('Location: index.php');
    exit();
  }
}


// Lógica para recuperar as tarefas à fazer


if (isset($_GET['acao'])) {


  $action = $_GET['acao'];

  if (isset($action)) {
    switch ($action) {

      case 'filtrar':
        if ($_GET['tarefas'] === 'CANCELADAS') {

          $situation = 'CANCELADA';

          $tasks_filtered = getBySituation($conn, $user_id, $situation);
        } else {

          if ($_GET['tarefas'] === 'PENDENTES') {

            $situation = 'À FAZER';
            $tasks_filtered = getBySituation($conn, $user_id, $situation);
          }


          if ($_GET['tarefas'] === 'CONCLUÍDAS') {

            $situation = 'CONCLUÍDA';
            $tasks_filtered = getBySituation($conn, $user_id, $situation);
          }
        }

        break;

      case 'concluir':

        $id_task = $_GET['task_id'];
        $new_situation = 'CONCLUÍDA';
        updateSituation($conn, $user_id, $id_task, $new_situation);

        break;

      case 'cancelar':
        $id_task = $_GET['task_id'];
        $new_situation = 'CANCELADA';
        updateSituation($conn, $user_id, $id_task, $new_situation);
        break;

      default:
        header('Location: index.php');
        break;
    }
  }
} else {

  $tasks = getAll($conn, $user_id);
}


?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Minhas Tarefas</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
  <div class="container min-vh-100">

    <div class="row mt-3 mb-3 text-center">
      <p class="h1">Minhas Tarefas</p>
    </div>
    <div class="container-fluid d-flex justify-content-center align-items-center">
      <div class="col md-8">
        <div class="mt-3">
          <form class="d-flex justify-content-center align-items-center mb-4" action="index.php" method="post">
            <div data-mdb-input-init class="form-outline flex-fill">
              <input type="text" name="taskname" id="taskNameInput" class="form-control" placeholder="Nova Tarefa" />
            </div>
            <button type="submit" class="btn btn-primary ms-2">Adicionar</button>
          </form>
        </div>
      </div>
    </div>

    <div class="container-fluid mt-3 ">
      <ul class="nav nav-tabs mb-4 pb-2 align-items-center" role="tablist">

        <li class="nav-item" role="presentation">
          <a class="nav-link" data-mdb-tab-init href="index.php?acao=filtrar&tarefas=PENDENTES" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">À fazer</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" data-mdb-tab-init href="index.php?acao=filtrar&tarefas=CONCLUÍDAS" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">Concluídas</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" data-mdb-tab-init href="index.php?acao=filtrar&tarefas=CANCELADAS" role="tab" aria-controls="ex1-tabs-3" aria-selected="false">Canceladas</a>
        </li>

        <li class="nav-item" role="presentation">
          <a class="p-1 btn btn-secondary" data-mdb-tab-init href="index.php" role="tab" aria-controls="ex1-tabs-3" aria-selected="false">Remover Filtro</a>
        </li>

      </ul>
    </div>

    <div class="container-fluid">

      <?php if (isset($tasks)) : ?>
        <?php foreach ($tasks as $task) : ?>

          <ul class="list-group">

            <li class="container d-flex justify-content-space-between align-items-center mb-2 rounded" style="background-color: #f4f6f7;">
              <a href="index.php?acao=cancelar&task_id=<?= $task['id'] ?>" class="btn btn-danger m-2">Cancelar</a>
              <p class="m-auto"><?= $task['taskname']; ?></p>
              <a href="index.php?acao=concluir&task_id=<?= $task['id'] ?>" class="btn btn-success m-2">Concluir</a>
            </li>

          </ul>

        <?php endforeach; ?>

      <?php endif ?>
      <?php if (isset($tasks_filtered)) : ?>
        <?php foreach ($tasks_filtered as $task) : ?>
          <ul class="list-group">

            <li class="container d-flex justify-content-space-between align-items-center mb-2 rounded p-2" style="background-color: #f4f6f7;">
              <p class="m-auto"><?= $task['taskname']; ?></p>
            </li>
          </ul>
        <?php endforeach ?>
      <?php endif ?>
      <?php if (empty($tasks) && !isset($tasks_filtered)) : ?>
        <p class="text-center h2">Não há nada por aqui</p>
      <?php endif ?>
    </div>

    <script src="js/bootstrap.min.js"></script>
</body>

</html>