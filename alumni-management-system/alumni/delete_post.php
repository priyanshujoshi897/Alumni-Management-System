<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = intval($_GET['id']);

/* Check ownership */
$check = mysqli_query($conn, "
    SELECT id FROM forum_posts 
    WHERE id='$post_id' AND user_id='$user_id'
");

if(mysqli_num_rows($check) == 1) {

    // Optional: delete related replies if you have replies table
    // mysqli_query($conn, "DELETE FROM forum_replies WHERE post_id='$post_id'");

    mysqli_query($conn, "
        DELETE FROM forum_posts 
        WHERE id='$post_id'
    ");
}

header("Location: forum.php");
exit();
