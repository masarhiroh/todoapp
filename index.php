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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Todo List</title>
  <!-- BootstrapのCSS読み込み -->
  <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQueryテーマ読み込み -->
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/cupertino/jquery-ui.css">
  <!-- BootstrapのJS読み込み -->
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
  
  
  <link href="styles.css" rel="stylesheet">
</head>

<body>
  <section>
    <div class="container">
      <h1>
        Todos
      </h1>
      <div class="row">
        <div class="col-md-12 mb-4">
          <form action="" id="new_todo_form">
            <input type="text" id="new_todo" placeholder="タスク内容">
            <input type="text" id="new_todo_deadline" class="calendar" placeholder="期限">
            <br>
            <input type="submit" name="button" value="登録" class="btn btn-primary">
            <input type="reset" name="button" class="btn btn-danger">
          </form>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <table id="todos" class="table table-striped">
            <tr id="todos_head">
              <th>
                <i class="checkAll glyphicon glyphicon-check text-primary" data-checkAllClassName="checkGroupA" value=0></i>
              </th>
              <th>タスク</th>
              <th>期限</th>
              <th>
                <i class="glyphicon glyphicon-remove text-danger"></i>
              </th>
            </tr>
  
            <?php foreach ($todos as $todo) : ?>
              <tr id="todo_<?= h($todo->id); ?>" data-id="<?= h($todo->id); ?>">
                <td>
                  <input type="checkbox" class="update_todo checkGroupA" <?php if ($todo->state === '1') { echo 'checked'; } ?>>
                </td>
                <td class="todo_title <?php if ($todo->state === '1') { echo 'done'; } ?>">
                  <?= h($todo->title); ?>
                </td>
                <td class="todo_deadline">
                  <?= h($todo->deadline); ?>
                </td>
                <td>
                  <i class="delete_todo glyphicon glyphicon-trash text-danger"></i>
                </td>
              </tr>
            <?php endforeach; ?>
  
            <tr id="todo_template" data-id="">
              <td>
                <input type="checkbox" class="update_todo checkGroupA">
              </td>
              <td class="todo_title"></td>
              <td class="todo_deadline"></td>
              <td>
                <i class="delete_todo glyphicon glyphicon-trash text-danger"></i>
              </td>
            </tr>
          </table>
  
        </div>
      </div>
    </div>
  </section>
  
  <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="js/datepicker-ja.js"></script>
  <script src="js/todo.js"></script>
  <script>
    $(function() {
      $('.calendar').datepicker();
    });
  </script>
</body>
</html>
