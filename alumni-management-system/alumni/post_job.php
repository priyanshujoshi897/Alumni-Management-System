<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $deadline = $_POST['deadline'];
    $package = mysqli_real_escape_string($conn, $_POST['package'] ?? '');

    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO jobs 
              (posted_by, title, company, location, description, deadline, package)
              VALUES 
              ('$user_id', '$title', '$company', '$location', '$description', '$deadline', '$package')";

    if(mysqli_query($conn, $query)){
        $success = "Job posted successfully!";
    } else {
        $error = "Something went wrong: " . mysqli_error($conn);
    }
}

include "layout.php";
?>

<div class="card-box">
    <h3 class="mb-4">Post a Job</h3>

    <?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Job Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Company Name</label>
            <input type="text" name="company" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Package (e.g. ₹6 LPA)</label>
            <input type="text" name="package" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Application Deadline</label>
            <input type="date" name="deadline" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Job Description</label>
            <textarea name="description" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Post Job</button>

    </form>
</div>

<?php include "layout_footer.php"; ?>
