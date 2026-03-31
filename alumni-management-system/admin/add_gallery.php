<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $image = "";

    if (!empty($_FILES['image']['name'])) {

        $target_dir = "../uploads/";
        $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $image = time() . "." . $ext;

        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }

    mysqli_query($conn, "INSERT INTO gallery (title, image)
                         VALUES ('$title','$image')");

    header("Location: manage_gallery.php");
    exit();
}

include "layout.php";
?>

<h2>Add Gallery Photo</h2>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control">
    </div>

    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control" required>
    </div>

    <button class="btn btn-primary">Upload</button>

</form>

<?php include "layout_footer.php"; ?>
