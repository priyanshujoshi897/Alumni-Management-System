<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$job_id = intval($_GET['id']);

/* Check if job belongs to this user */
$check = mysqli_query($conn, "
    SELECT id FROM jobs 
    WHERE id='$job_id' AND posted_by='$user_id'
");

if(mysqli_num_rows($check) == 1) {

    // Delete applications first (avoid orphan data)
    mysqli_query($conn, "
        DELETE FROM job_applications 
        WHERE job_id='$job_id'
    ");

    // Delete job
    mysqli_query($conn, "
        DELETE FROM jobs 
        WHERE id='$job_id'
    ");
}

header("Location: my_jobs.php");
exit();
