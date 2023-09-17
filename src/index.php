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
</body>
</html>