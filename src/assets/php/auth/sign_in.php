<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require('../assets/php/dbconnect.php');
  $stmt = $dbh->prepare("SELECT * FROM  users WHERE email=:email");

  $stmt->execute([
    ":email" => $_POST["email"],
  ]);
  $user = $stmt->fetch();
  if($user === false){
    session_start();
    $_SESSION["error_messages"] = ["メールアドレスまたはパスワードが間違っています。"];
    header("Location: ". "/auth/sign_in.php");
    exit();
  }

  if(password_verify($_POST["password"], $user["password"])){
    session_start();
    $_SESSION['id'] = $user["id"];
    //$_SESSION['name'] = $user["name"];

    header("Location: ". "/index.php");
  }
  else{
    session_start();
    $_SESSION["error_messages"] = ["メールアドレスまたはパスワードが間違っています。"];
    header("Location: ". "/auth/sign_in.php");
  }
}
