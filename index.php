<?php

session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/Todo.php');

// get todos
$todoApp = new \MyApp\Todo();
$todos = $todoApp->getAll();

// var_dump($todos);
// exit;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Todo List</title>
  <!-- BootstrapのCSS読み込み -->
  <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
  
  
  <link href="styles.css" rel="stylesheet">
</head>

<body>
  <div id="container">
    <h1>Todos</h1>
    <form action="" id="new_todo_form">
      <input type="text" id="new_todo" placeholder="タスクはありますか?">
    </form>
    <button class="btn btn-primary" data-checkAllClassName="checkGroupA" value=0>全選択</button>
    <ul id="todos">
    <?php foreach ($todos as $todo) : ?>
      <li id="todo_<?= h($todo->id); ?>" data-id="<?= h($todo->id); ?>">
        <input type="checkbox" class="update_todo checkGroupA" <?php if ($todo->state === '1') { echo 'checked'; } ?>>
        <span class="todo_title <?php if ($todo->state === '1') { echo 'done'; } ?>"><?= h($todo->title); ?></span>
        <button class="delete_todo btn btn-danger">削除</button>
      </li>
    <?php endforeach; ?>
      <li id="todo_template" data-id="">
        <input type="checkbox" class="update_todo checkGroupA">
        <span class="todo_title"></span>
        <button class="delete_todo btn btn-danger">削除</button>
      </li>
    </ul>
  </div>
  
  <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="todo.js"></script>
</body>
</html>
