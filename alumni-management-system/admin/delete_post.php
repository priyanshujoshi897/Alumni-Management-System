<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$post_id = intval($_GET['id']);

// Delete comments first
mysqli_query($conn, "DELETE FROM forum_comments WHERE post_id=$post_id");

// Delete post
mysqli_query($conn, "DELETE FROM forum_posts WHERE id=$post_id");

header("Location: manage_forum.php");
exit();
