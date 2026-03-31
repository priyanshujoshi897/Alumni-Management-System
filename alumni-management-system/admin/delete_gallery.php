<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id']);

// Get image name first
$result = mysqli_query($conn, "SELECT image FROM gallery WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if ($data) {

    // Delete image file
    if (!empty($data['image']) && file_exists("../uploads/" . $data['image'])) {
        unlink("../uploads/" . $data['image']);
    }

    // Delete database record
    mysqli_query($conn, "DELETE FROM gallery WHERE id=$id");
}

header("Location: manage_gallery.php");
exit();
