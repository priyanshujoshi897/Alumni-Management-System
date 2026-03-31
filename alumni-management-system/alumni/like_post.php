<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$post_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

mysqli_query($conn, "
    INSERT IGNORE INTO forum_likes (post_id, user_id)
    VALUES ($post_id, $user_id)
");

header("Location: forum.php");
exit();
