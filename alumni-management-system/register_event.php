<?php
require_once "config/db.php";
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'alumni') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$event_id = intval($_GET['id']);

mysqli_query($conn, "INSERT IGNORE INTO event_registrations (event_id, user_id)
                     VALUES ($event_id, $user_id)");

header("Location: events.php");
exit();
