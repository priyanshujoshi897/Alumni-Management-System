<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $delete = "DELETE FROM users WHERE id = $id AND role='alumni'";
    mysqli_query($conn, $delete);
}

header("Location: manage_alumni.php");
exit();
