<?php
require_once('./assets/php/dbconnect.php');
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: /auth/sign_in.php");
  // 外部から来たらログインページに遷移
  exit();
}
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
// echo "<pre>";
// print_r($results);
// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./assets/style/reset.css">
  <link rel="stylesheet" href="./assets/style/index.css">
  <link href="/dist/output.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.5/dist/full.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="./assets/style/header.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<div class="loader">
  <h1 class="title">
    <span>F</span>
    <span>L</span>
    <span>A</span>
    <span>T</span>
  </h1>
</div>
 

<body class="min-h-screen none flex-col mb-24 md:min-h-0 md:mb-36">
  <?php require("./components/header.php") ?>
  <div class="top-img" style="width: 100%;">
    <img src="./assets/img/harbors_top.jpg" alt="harbor" style="width: 100%; height: auto;">
  </div>

  <div class="font-bold text-gray-800 text-xl mt-6 mb-4 flex justify-center font-cursive md:text-2xl lg:text-3xl xl:text-4xl mt-8">
    Today's Plan
  </div>

  <form method="POST" action='./assets/php/index.php' class="w-1/2 mx-auto">
    <div class="form-control mb-1">
      <label class="label cursor-pointer">
        <span class="border-blue-100 bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded md:text-xl lg:text-2xl xl:text-3xl  ">業務</span>
        <input type="checkbox" class="checkbox " id="plan1" name="plans[]" value="1" />
      </label>
    </div>
    <div class="form-control mb-1">
      <label class="label cursor-pointer">
        <span class="border-red-200 bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded md:text-xl lg:text-2xl xl:text-3xl ">縦・横モク</span>
        <input type="checkbox" class="checkbox" id="plan2" name="plans[]" value="2" />
      </label>
    </div>
    <div class="form-control mb-1">
      <label class="label cursor-pointer">
        <span class="border-green-100 bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 md:text-xl lg:text-2xl xl:text-3xl ">カリキュラム</span>
        <input type="checkbox" class="checkbox" id="plan3" name="plans[]" value="3" />
      </label>
    </div>
    <div class="form-control mb-1">
      <label class="label cursor-pointer">
        <span class="bg-yellow-100 border-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300 md:text-xl lg:text-2xl xl:text-3xl ">MU</span>
        <input type="checkbox" class="checkbox" id="plan4" name="plans[]" value="4" />
      </label>
    </div>
    <div class="form-control mb-1">
      <label class="label cursor-pointer">
        <span class="border-gray-100 bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded md:text-xl lg:text-2xl xl:text-3xl ">その他</span>
        <input type="checkbox" class="checkbox" id="plan5" name="plans[]" value="5" />
      </label>
    </div>
    <div class="flex justify-center mb-6 mt-8 md:mb-8 md:mt-12">
      <div class="inline-flex rounded-md shadow-sm" role="group">
        <button type="submit" class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-l-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 md:text-2xl lg:text-3xl xl:text-4xl " name='status' value='入室'>
          入場
        </button>
        <button type="submit" class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-r-md hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 md:text-2xl lg:text-3xl xl:text-4xl " name="status" value="退室">
          退場
        </button>
      </div>
    </div>

  </form>

  <?php if (empty($results)) { ?>
    <!-- ここにalertで誰もいないこと伝えたいな -->
  <?php } else { ?>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 md:text-xl lg:text-2xl ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-4 py-3">
              Image
            </th>
            <th scope="col" class="px-4 py-3">
              Status
            </th>
            <th scope="col" class="px-4 py-3">
              Name
            </th>
            <th scope="col" class="px-4 py-3">
              Plan
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $result) { ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <th scope="row" class="flex items-center px-4 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                <a href="./detail.php?id=<?= $result["user_id"] ?>">
                  <img class="w-12 h-12 rounded-full" src="./assets/img/<?php print_r($result["user_image"]) ?>" alt="Jese image">
                </a>
              </th>
              <td class="px-4 py-4">
                <?= $result['user_posse'] . $result['user_grade'] ?>
              </td>
              <td class="px-4 py-4">
                <div class="text-sm text-gray-500 dark:text-gray-400 md:text-xl lg:text-2xl ">
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
  <?php } ?>
  <?php require("./components/footer.php") ?>

  <script>
  let lastScrollTop = 0;
  const header = document.querySelector('header.relative');
  console.log(header);

  window.addEventListener('scroll', () => {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    console.log(scrollTop);
    if (scrollTop > lastScrollTop){
       // 下にスクロールしたとき
       header.style.visibility = "hidden";
       header.style.opacity = "0";
    } else {
       // 上にスクロールしたとき
       header.style.visibility = "visible";
       header.style.opacity = "1";
    }
    lastScrollTop = scrollTop;
  });


  const CLASSNAME = "-visible";
  const TIMEOUT = 1500;
  const $target = $(".title");
 
  $(window).on('load', function () {
    $target.addClass(CLASSNAME);
    setTimeout(() => {
      $target.removeClass(CLASSNAME);
    }, TIMEOUT);


    const $loader = $('.loader');

    // ローダーを上にスライドして非表示にする
    setTimeout(function () {
      $loader.css('transform', 'translateY(-100%)');
      setTimeout(function () {
        $loader.css('display', 'none');
      }, 3000); // 上にスライドしてから0.5秒後に非表示にする
    }, 2000); // ローダーを表示してから2秒後に実行する
  });







 
</script>
</body>

</html>