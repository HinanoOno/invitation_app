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
  <link rel="stylesheet" href="./assets/style/checkbox.css">
  <link href="/dist/output.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.5/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <?php require("./components/header.php") ?>
  <form method="POST" action='./assets/php/index.php'>
    <div class="form-control">
      <label class="label cursor-pointer justify-center">
        <span class="border-blue-100 bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded ">業務</span>
        <input type="checkbox" class="checkbox " id="plan1" name="plans[]" value="1" />
      </label>
    </div>
    <div class="form-control">
      <label class="label cursor-pointer">
      <span class="border-red-200 bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded ">縦・横モク</span>
        <input type="checkbox" class="checkbox" id="plan2" name="plans[]" value="2" />
      </label>
    </div>
    <div class="form-control">
      <label class="label cursor-pointer">
      <span class="border-green-100 bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">カリキュラム</span>
        <input type="checkbox" class="checkbox" id="plan3" name="plans[]" value="3" />
      </label>
    </div>
    <div class="form-control">
      <label class="label cursor-pointer">
      <span class="bg-yellow-100 border-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">MU</span>
        <input type="checkbox" class="checkbox" id="plan4" name="plans[]" value="4" />
      </label>
    </div>
    <div class="form-control">
      <label class="label cursor-pointer">
      <span class="border-gray-100 bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">その他</span>
        <input type="checkbox" class="checkbox" id="plan5" name="plans[]" value="5" />
      </label>
    </div>

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

  <script src="./assets/scripts/checkbox.js"></script>
</body>

</html>