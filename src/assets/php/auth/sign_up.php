<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require('./../dbconnect.php');
  $stmt = $dbh->prepare("INSERT INTO users(email, password) VALUES( :email, :password)");

  $success=$stmt->execute([
    ":email" => $_POST["email"],
    ":password" => password_hash($_POST["password"],PASSWORD_DEFAULT),
  ]);

  

  if ($success) {
    // ユーザーのメール、パスワードが適切に登録された場合の処理
    $lastInsertId = $dbh->lastInsertId();

    $image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
    $image_path = dirname(__FILE__) . './../../../assets/img/' . $image_name;
    move_uploaded_file(
      $_FILES['image']['tmp_name'], 
      $image_path
    );
    
    $stmt = $dbh->prepare("INSERT INTO user_details(name, user_id, university, faculty, grade, posse, discord_user_id,image) VALUES(:name, :user_id, :university, :faculty, :grade, :posse, :discord_user_id,:image)");
    
    $success = $stmt->execute([
        ":name" => $_POST["name"],
        ":user_id" => $lastInsertId,
        ":university" => $_POST["university"],
        ":faculty" => $_POST["faculty"],
        ":grade" => $_POST["grade"],
        ":posse" => $_POST["posse"],
        ":discord_user_id" => $_POST["discord_user_id"],
        ":image" => $image_name
    ]);
    




    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirm_password"];

        if ($password !== $confirmPassword) {
            // エラーメッセージをセットしてユーザーをリダイレクト
            
            header("Location: /auth/sign_up.php");
            exit(); 
        }
    }


    if ($success) {
        // ユーザー詳細情報も正常に保存された場合の処理
        $_SESSION['id'] = $lastInsertId;
        header("Location: /index.php");
        exit(); // リダイレクトした後にスクリプトの実行を終了
    } else {
        // ユーザー詳細情報の保存が失敗した場合の処理
        header("Location: /auth/sign_up.php");
        exit(); // リダイレクトした後にスクリプトの実行を終了
    }
} else {
    // ユーザーの登録が失敗した場合の処理
    header("Location: /auth/sign_up.php");
    exit(); // リダイレクトした後にスクリプトの実行を終了
}
}