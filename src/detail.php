<?php
session_start();
require_once('./assets/php/detail.php');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/style/reset.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="../dist/output.css">
</head>

<body>
  <?php require("./components/header.php") ?>
  <main class="mt-2">
    <h2 class="font-cursive flex justify-center text-4xl">who am I ?</h2>
    <h4 class="font-cursive flex justify-center text-xl">~profile~</h4>
    <div class="flex justify-center">
      <img class="w-48 h-48 rounded-full" src="./assets/img/<?= $student["image"] ?>" alt="顔">
    </div>
    <div class="grid gap-6 mb-6 md:grid-cols-2 w-2/3 mx-auto">
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">名前</label>
            <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?= $student["name" ]?>" disabled>
        </div>
        <div>
            <label for="university" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">大学</label>
            <input type="text" id="university" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?= $student["university" ] . "大学"?>" disabled>
        </div>
        <div>
            <label for="faculty" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">学部</label>
            <input type="text" id="faculty" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?= $student["faculty"] . "学部"?>" disabled>
        </div>  
        <div>
            <label for="posse" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">所属posse</label>
            <input type="text" id="posse" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?= $student["posse"] . $student["grade"]?>" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>
        </div>
    </div>

  </main>
</body>

</html>