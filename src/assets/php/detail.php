<?php
require_once('./assets/php/dbconnect.php');
if (!isset($_SESSION['id'])) {
  header("Location: /auth/sign_in.php");
  // 外部から来たらログインページに遷移
  exit();
}
// クエリーパラメータを取得してくる
$user_id = $_GET['id'];
//該当の生徒をとってくる
$sql_student = "SELECT
  name, university, faculty, grade, posse, image from user_details
  WHERE user_id = :user_id";
$stmt_student = $dbh->prepare($sql_student);
$stmt_student->execute([':user_id' => $user_id]);
$student = $stmt_student->fetch(PDO::FETCH_ASSOC);
// echo "<pre>";
// print_r($student);
// echo "</pre>";

