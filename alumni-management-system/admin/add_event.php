<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];

    $image = "";

    if (!empty($_FILES['image']['name'])) {

        $target_dir = "../uploads/";
        $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $image = time() . "." . $ext;

        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }

    mysqli_query($conn, "INSERT INTO events (title, description, event_date, location, image)
                         VALUES ('$title','$description','$event_date','$location','$image')");

    header("Location: manage_events.php");
    exit();
}

include "layout.php";
?>

<h2>Add Event</h2>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Event Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="event_date" class="form-control">
    </div>

    <div class="mb-3">
        <label>Location</label>
        <input type="text" name="location" class="form-control">
    </div>

    <div class="mb-3">
        <label>Event Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button class="btn btn-primary">Add Event</button>

</form>
<?php include "layout_footer.php"; ?>
