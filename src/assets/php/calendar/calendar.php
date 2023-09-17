<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  require('../dbconnect.php');
  $stmt = $dbh->prepare("INSERT INTO Calendars (date, start_time, status) VALUES (:userDetail_id, :plan_id, :status)");
  print_r($_POST);

}