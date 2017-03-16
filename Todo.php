<?php

// CSRF対策
// Token発行してSessionに格納
// フォームからもTokenを発行、送信
// Check

namespace MyApp;

class Todo {
  private $_db;

  public function __construct() {
    $this->_createToken();

    try {
      //postgres接続_cloud9用
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      
      //postgres接続_heroku用
/*
      $url = parse_url(getenv('DATABASE_URL'));
      $dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
      $this->_db = new \PDO($dsn, $url['user'], $url['pass']);
*/
      
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  private function _createToken() {
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
  }

  public function getAll() {
    $stmt = $this->_db->query("select * from todos order by id desc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function post() {
    $this->_validateToken();

    if (!isset($_POST['mode'])) {
      throw new \Exception('mode not set!');
    }

    switch ($_POST['mode']) {
      case 'update':
        return $this->_update();
      case 'create':
        return $this->_create();
      case 'delete':
        return $this->_delete();
      case 'checkAll':
        return $this->_checkAll();
    }
  }

  private function _validateToken() {
    if (
      !isset($_SESSION['token']) ||
      !isset($_POST['token']) ||
      $_SESSION['token'] !== $_POST['token']
    ) {
      throw new \Exception('invalid token!');
    }
  }

  private function _update() {
    if (!isset($_POST['id'])) {
      throw new \Exception('[update] id not set!');
    }

    $this->_db->beginTransaction();

    $sql = sprintf("update todos set state = (state + 1) %% 2 where id = %d", $_POST['id']);
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();

    $sql = sprintf("select state from todos where id = %d", $_POST['id']);
    $stmt = $this->_db->query($sql);
    $state = $stmt->fetchColumn();

    $this->_db->commit();

    return [
      'state' => $state
    ];
  }

  private function _create() {
    if (!isset($_POST['title']) || $_POST['title'] === '') {
      throw new \Exception('[create] title not set!');
    }

    $sql = "insert into todos (title , deadline) values (:title , :deadline)";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([':title' => $_POST['title'] , ':deadline' => $_POST['deadline'] ]);

    return [
      'id' => $this->_db->lastInsertId()
    ];
  }

  private function _delete() {
    if (!isset($_POST['id'])) {
      throw new \Exception('[delete] id not set!');
    }

    $sql = sprintf("delete from todos where id = %d", $_POST['id']);
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();

    return [];
  }
  
  private function _checkAll() {
    if (!isset($_POST['state'])) {
      throw new \Exception('[checkAll] state not set!');
    }

    $this->_db->beginTransaction();

    $sql = sprintf("update todos set state = %d", $_POST['state']);
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();
    
    $this->_db->commit();
  }
}
