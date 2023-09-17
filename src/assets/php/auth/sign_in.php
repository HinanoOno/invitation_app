<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require('../assets/php/dbconnect.php');
  $stmt = $dbh->prepare("SELECT * FROM  users WHERE email=:email");

  $stmt->execute([
    ":email" => $_POST["email"],
  ]);  
  $user = $stmt->fetch();

  if(password_verify($_POST["password"], $user["password"])){
    session_start();
    $_SESSION['id'] = $user["id"];
    $_SESSION['name'] = $user["name"];

    header("Location: ". "/index.php");
  }
  else{
    header("Location: ". "/auth/sign_in.php");
  }
  
}




?>