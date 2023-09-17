<?php
  session_start();
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
                "userDetail_id" => $_SESSION['id'],
                "plan_id" => $value,
                "status" => $status
            ]);
        }
        $sql = "SELECT name FROM user_details WHERE id = :userID";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":userID", $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
        $user_name = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbh->commit();
        // Discord通知を行う先
        $discordWebhookURL = "https://discord.com/api/webhooks/1152754404156510208/VXcIz8LVxBbNaXViJrp9aVH5TjXR_nV7CHUmld2bVtBsuapal7BHWMU2xM1SzY6OIwcX";
        $message = $user_name['name']."さんが入室しました"; 

        $data = [
            "content" => $message
        ];

        $options = [
            "http" => [
                "header" => "Content-Type: application/json",
                "method" => "POST",
                "content" => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($discordWebhookURL, false, $context);

        if ($result === FALSE) {
            echo "Discord通知の送信に失敗しました。";
        } else {
            echo "データが登録され、Discordに通知が送信されました。";
        }  
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
            $sql = "UPDATE userDetail_plan SET status = :status WHERE userDetail_id = :userDetail_id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([
                "status" => $status,
                "userDetail_id" => $_SESSION['id']
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