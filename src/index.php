<?php
require_once('./assets/php/dbconnect.php');
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: /auth/sign_in.php");
   // 外部から来たらログインページに遷移
  exit(); 
}
print_r($_SESSION);
//今いる人をとってくる処理
try {
  $dbh->beginTransaction();
  $sql = "SELECT
    ud.name AS user_name,
    CAST(ud.grade AS UNSIGNED) AS user_grade,
    ud.posse AS user_posse,
    ud.image AS user_image,
    GROUP_CONCAT(p.name) AS plans
  FROM
    user_details ud
  INNER JOIN
    userDetail_plan udp ON ud.id = udp.userDetail_id
  INNER JOIN
    plans p ON udp.plan_id = p.id
  WHERE
    udp.status = 1
  GROUP BY
    ud.name, ud.grade, ud.posse,ud.image;
  ";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $dbh->commit();
    
} catch (PDOException $e) {
  $dbh->rollBack();
  echo "データベースエラー: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="/dist/output.css" rel="stylesheet">
</head>
<body>
  <?php require("./components/header.php")?>
  <form method="POST" action='./assets/php/index.php'>
    <input type="checkbox" id="plan1" name="plans[]" value="1">
    <label for="plan1">業務</label><br>

    <input type="checkbox" id="plan2" name="plans[]" value="2">
    <label for="plan2">縦モク/横モク/MU</label><br>

    <input type="checkbox" id="plan3" name="plans[]" value="3">
    <label for="plan3">カリキュラム</label><br>

    <input type="checkbox" id="plan4" name="plans[]" value="4">
    <label for="plan4">その他</label><br>
       
    <button type="submit" name='status' value='入室'>入室</button>
    <button type="submit"name='status' value='退室'>退室</button>    
  </form>

  <h1>いる人リスト</h1>
  <table class='table'>
    <tr>
      <th>Image</th>
      <th>POSSE</th>
      <th>Grade</th>
      <th>User Name</th>
      <th>Plans</th>
    </tr>
    <?php foreach($results as $result){?>
      <tr>
        <td><img class="w-10 h-10 rounded-full" src="./assets/img/<?= $result["user_image"] ?>" alt="user_image"></td>
        <td><?=$result['user_posse']?></td>
        <td><?=$result['user_grade']?></td>
        <td><?=$result['user_name']?></td>
        <td>
          <?php $plans = explode(',', $result['plans']);
          foreach($plans as $plan){?>
          <?=$plan?><br>
          <?php }?>
        </td>
      </tr>
    <?php }?>
  </table>

</body>
</html>