<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include "layout.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize inputs
    $full_name  = mysqli_real_escape_string($conn, $_POST['full_name']);
    $roll_no    = mysqli_real_escape_string($conn, $_POST['roll_no']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $branch     = mysqli_real_escape_string($conn, $_POST['branch']);
    $semester   = mysqli_real_escape_string($conn, $_POST['semester']);
    $batch_year = mysqli_real_escape_string($conn, $_POST['batch_year']);
    $dob        = mysqli_real_escape_string($conn, $_POST['dob']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender     = mysqli_real_escape_string($conn, $_POST['gender']);
    $address    = mysqli_real_escape_string($conn, $_POST['address']);
    $hobbies    = mysqli_real_escape_string($conn, $_POST['hobbies']);
    $activities = mysqli_real_escape_string($conn, $_POST['activities']);

    // Default password
    $hashed_password = password_hash("alumni123", PASSWORD_DEFAULT);

    // Insert into users
    $insert_user = "INSERT INTO users 
        (full_name, roll_no, email, password, role, status)
        VALUES 
        ('$full_name', '$roll_no', '$email', '$hashed_password', 'alumni', 'approved')";

    if (mysqli_query($conn, $insert_user)) {

        $user_id = mysqli_insert_id($conn);

        $insert_profile = "INSERT INTO alumni_profiles
            (user_id, branch, semester, batch_year, dob, phone, gender, address, hobbies, activities)
            VALUES
            ('$user_id', '$branch', '$semester', '$batch_year', '$dob', '$phone', '$gender', '$address', '$hobbies', '$activities')";

        mysqli_query($conn, $insert_profile);

        $success = "Alumni added successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<div class="card-box">
    <h3 class="mb-4">Add Alumni</h3>

    <?php if($success) { ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php } ?>

    <?php if($error) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Roll No</label>
            <input type="text" name="roll_no" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Branch</label>
            <select name="branch" class="form-select" required>
                <option value="">-- Select Branch --</option>
                <option value="Information Technology">Information Technology</option>
                <option value="Electronics">Electronics</option>
                <option value="Mechanical">Mechanical</option>
                <option value="Electrical">Electrical</option>
                <option value="Civil">Civil</option>
                <option value="Pharmacy">Pharmacy</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Semester</label>
            <input type="text" name="semester" class="form-control">
        </div>

        <div class="mb-3">
            <label>Batch Year</label>
            <input type="number" name="batch_year" class="form-control">
        </div>

        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="dob" class="form-control">
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Gender</label>
            <input type="text" name="gender" class="form-control">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Hobbies</label>
            <textarea name="hobbies" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Activities</label>
            <textarea name="activities" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-dark">Add Alumni</button>

    </form>
</div>

<?php include "layout_footer.php"; ?>
