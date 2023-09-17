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
    user_id,
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
    ud.name, ud.grade, ud.posse,ud.image, user_id;
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
  <link rel="stylesheet" href="./assets/style/reset.css">
  <link href="/dist/output.css" rel="stylesheet">
</head>

<body>
  <?php require("./components/header.php") ?>
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
    <button type="submit" name='status' value='退室'>退室</button>
  </form>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-4 py-3">
            Image
          </th>
          <th scope="col" class="px-4 py-3">
            Name
          </th>
          <th scope="col" class="px-4 py-3">
            Position
          </th>
          <th scope="col" class="px-4 py-3">
            Status
          </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($results as $result) { ?>
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th scope="row" class="flex items-center px-4 py-4 text-gray-900 whitespace-nowrap dark:text-white">
              <a href="./detail.php?id=<?= $result["user_id"] ?>">
                <img class="w-10 h-10 rounded-full" src="./assets/img/<?php print_r($result["user_image"]) ?>" alt="Jese image">
              </a>
            </th>
            <td class="px-4 py-4">
              <?= $result['user_posse'] . $result['user_grade'] ?>
            </td>
            <td class="px-4 py-4">
              <div class="text-sm text-gray-500 dark:text-gray-400">
                <?= $result['user_name'] ?>
              </div>
            </td>
            <td class="px-4 py-4">
              <?php $plans = explode(',', $result['plans']);
              foreach ($plans as $plan) { ?>
                <?= $plan ?><br>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>


</body>

</html>