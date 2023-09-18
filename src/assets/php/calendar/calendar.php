<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  require('../dbconnect.php');
  session_start();
  $botToken = 'MTE1Mjg0MTAzMjUzMTE5Nzk1Mw.GFeyPn.24QazPd0BljZNKyH4__DEqa90CCcXeXhfehSt4';
  
  //リクエストされた日時
  $daysOfWeek = [
    'Sun' => '日',
    'Mon' => '月',
    'Tue' => '火',
    'Wed' => '水',
    'Thu' => '木',
    'Fri' => '金',
    'Sat' => '土',
  ];
  $timestamp = strtotime($_POST['event_date']);
  $dayOfWeekEnglish = date('D', $timestamp);
  $dayOfWeekJapanese = $daysOfWeek[$dayOfWeekEnglish];
  // 日付を指定の形式にフォーマット
  $request_date = date('Y/m/d (', $timestamp) . $dayOfWeekJapanese . ')';

  //userIdを取得
  if(isset($_POST['name'])){
    foreach ($_POST['name'] as $request_name) {
      try {
        $dbh->beginTransaction();
        $sql = "SELECT * FROM user_details WHERE name = :name";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
          ":name" => $request_name
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $sql = "SELECT * FROM user_details WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
          ":id" => $_SESSION['id']
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        //discord 通知
        $userId = $row['discord_user_id'];
            
        $message = $user['name'].'さんから'.$request_date.'にHarborsへのお誘いがきました。こちらから登録してください。 http://localhost:8080/calendar/calendar.php';

        $apiUrl = "https://discord.com/api/v10/users/@me/channels";

        $headers = [
          'Authorization: Bot ' . $botToken,
          'Content-Type: application/json',
        ];
            
        $data = json_encode([
          'recipient_id' => $userId,
        ]);

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);
        $responseData = json_decode($response, true);
        $channelId = $responseData['id'];
          
        $sendMessageUrl = "https://discord.com/api/v10/channels/{$channelId}/messages";
        $messageData = json_encode([
          'content' => $message,
        ]);

        $ch = curl_init($sendMessageUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $messageData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $dbh->commit();
      } catch (PDOException $e) {
        $dbh->rollBack();
        echo "データベースエラー: " . $e->getMessage();
      }
    }
  }

  $date = date("Y-m-d", strtotime($_POST["event_date"]));
  $start_time = sprintf("%02d:%02d:00", $_POST["start_hours"], $_POST["start_minutes"]);
  $end_time = sprintf("%02d:%02d:00", $_POST["end_hours"], $_POST["end_minutes"]);
  $stmt = $dbh->prepare("INSERT INTO Calendars (date, start_time, end_time, userdetail_id) VALUES (:date, :start_time, :end_time, :userdetail_id)");
  $stmt->execute([
    "date" => $date,
    "start_time" => $start_time,
    "end_time" => $end_time,
    "userdetail_id" => $_SESSION["id"]
  ]);

  $lastInsertedId = $dbh->lastInsertId();
  $stmt = $dbh->prepare("INSERT INTO calendar_plan (calendar_id, plan_id) VALUES (:calendar_id, :plan_id)");
    $stmt->execute([
      "calendar_id" => $lastInsertedId,
      "plan_id" => $_POST["plan"]
    ]);

  header("Location: ". "/calendar/calendar.php");


}