<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  require('../dbconnect.php');
  session_start();
  $date = date("Y-m-d", strtotime($_POST["event_date"]));
  $start_time = sprintf("%02d:%02d:00", $_POST["start_hours"], $_POST["start_minutes"]);
  $end_time = sprintf("%02d:%02d:00", $_POST["end_hours"], $_POST["end_minutes"]);
  $stmt = $dbh->prepare("INSERT INTO Calendars (date, start_time, end_time, userdetail_id) VALUES (:date, :start_time, :end_time, :userdetail_id)");
  $stmt->execute([
    "date" => $date,
    "start_time" => $start_time,
    "end_time" => $end_time,
    "userdetail_id" => 1
  ]);

  $lastInsertedId = $dbh->lastInsertId();
  $stmt = $dbh->prepare("INSERT INTO calendar_plan (calendar_id, plan_id) VALUES (:calendar_id, :plan_id)");
    $stmt->execute([
      "calendar_id" => $lastInsertedId,
      "plan_id" => $_POST["plan"]
    ]);

  header("Location: ". "/calendar/calendar.php");
}