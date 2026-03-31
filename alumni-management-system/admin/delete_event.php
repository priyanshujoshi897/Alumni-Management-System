<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id']);

/* Delete registrations first (important) */
mysqli_query($conn, "DELETE FROM event_registrations WHERE event_id = $id");

/* Then delete event */
mysqli_query($conn, "DELETE FROM events WHERE id = $id");

header("Location: manage_events.php");
exit();
