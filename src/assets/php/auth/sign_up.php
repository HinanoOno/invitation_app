<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require('../assets/php/dbconnect.php');
  $stmt = $dbh->prepare("INSERT INTO users(email, password) VALUES( :email, :password)");

  $stmt->execute([
    ":email" => $_POST["email"],
    ":password" => password_hash($_POST["password"],PASSWORD_DEFAULT),
  ]);
  $stmt = $dbh->prepare("INSERT INTO user_details(name,university, faculty, grade, posse, discord_user_id)VALUES(:name, :university, :faculty, :grade, :posse ,:discord_user_id)");
  
    $stmt->execute([
      ":name" => $_POST["name"],
      ":university" => $_POST["university"],
      ":faculty" => $_POST["faculty"],
      ":grade" => $_POST["grade"],
      ":posse" => $_POST["posse"],
      ":discord_user_id" => $_POST["discord_user_id"],
    ]); 
  
  
  header("Location: ". "/index.php");
}
