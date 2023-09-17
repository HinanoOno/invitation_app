<?php
$dsn = 'mysql:host=db;dbname=posse;charset=utf8;';
$user = 'root';
$password = 'root';

try {
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo '接続失敗: ' . $e->getMessage();
  exit();
}

