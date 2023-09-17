<?php
  require_once('dbconnect.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['plans'])){
      $selectedValues = $_POST["plans"];
    }

    // 入室・退室判断
    if ($_POST['status'] === '入室') {
      $status = 1;

      try {
          $dbh->beginTransaction();

          foreach ($selectedValues as $value) {
              $sql = "INSERT INTO userDetail_plan (userDetail_id, plan_id, status) VALUES (:userDetail_id, :plan_id, :status)";
              $stmt = $dbh->prepare($sql);
              $stmt->execute([
                  "userDetail_id" => 1,
                  "plan_id" => $value,
                  "status" => $status
              ]);
          }
          $dbh->commit();
          header("Location: ". "/index.php");
          exit();
      } catch (PDOException $e) {
          $dbh->rollBack();
          echo "データベースエラー: " . $e->getMessage();
      }
    } elseif ($_POST['status'] === '退室') {
        $status = 0;

        try {
            $dbh->beginTransaction();
            $sql = "UPDATE userDetail_plan SET status = :status WHERE userDetail_id = 1";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([
                "status" => $status
            ]);
            $dbh->commit();

            header("Location: ". "/index.php");
            exit(); 
        } catch (PDOException $e) {
            $dbh->rollBack();
            echo "データベースエラー: " . $e->getMessage();
        }
    }
  }
?>