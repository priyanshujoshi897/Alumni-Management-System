<?php
require_once "config/db.php";
include "includes/header.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST['full_name'];
    $roll_no = $_POST['roll_no'];
    $email = $_POST['email'];
    $password_raw = $_POST['password'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $batch_year = $_POST['batch_year'];
    $employment_status = $_POST['employment_status'];
    $current_company = $_POST['current_company'];
    $job_title = $_POST['job_title'];
    $linkedin = $_POST['linkedin'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // --- New: handle profile photo upload
    $profile_photo = null;
    $upload_dir = "uploads/";

    if (!empty($_FILES['profile_photo']['name'])) {
        $target_file = $upload_dir . basename($_FILES["profile_photo"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type (only images)
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($file_type, $allowed_types)) {
            $error = "Only JPG, JPEG, PNG & GIF images are allowed.";
        } else {
            // Generate safe unique name
            $new_filename = uniqid("profile_") . "." . $file_type;
            $target_path = $upload_dir . $new_filename;

            // Make sure uploads/ exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Save file
            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_path)) {
                $profile_photo = $target_path;
            } else {
                $error = "Failed to upload image.";
            }
        }
    }

    // --- Basic validations
    if (empty($full_name) || empty($roll_no) || empty($email) || empty($password_raw)) {
        $error = "Please fill all required fields.";
    }

    if (empty($error)) {

        // ✅ Check duplicate email or roll number
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR roll_no = ?");
        $check_stmt->bind_param("ss", $email, $roll_no);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $error = "Email or Roll Number already registered.";
        } else {
            $password = password_hash($password_raw, PASSWORD_DEFAULT);

            // Insert into users table
            $stmt1 = $conn->prepare("INSERT INTO users 
                (full_name, roll_no, email, password, role, status) 
                VALUES (?, ?, ?, ?, 'alumni', 'pending')");
            $stmt1->bind_param("ssss", $full_name, $roll_no, $email, $password);

            if ($stmt1->execute()) {
                $user_id = $stmt1->insert_id;

                // Insert into alumni_profiles table
                $stmt2 = $conn->prepare("INSERT INTO alumni_profiles
                    (user_id, branch, semester, batch_year, dob, phone, gender, address, linkedin,
                    current_company, job_title, employment_status, profile_photo)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                
                $stmt2->bind_param(
                    "isissssssssss",
                    $user_id,
                    $branch,
                    $semester,
                    $batch_year,
                    $dob,
                    $phone,
                    $gender,
                    $address,
                    $linkedin,
                    $current_company,
                    $job_title,
                    $employment_status,
                    $profile_photo
                );

                if ($stmt2->execute()) {
                    $success = "Registration successful! Waiting for admin approval.";
                    $_POST = array(); // clear form
                } else {
                    $error = "Profile saving failed.";
                }

            } else {
                $error = "User registration failed.";
            }
        }
    }
}
?> 

<div class="container mt-5 mb-5">
<div class="card p-4 shadow-sm">
<h3 class="mb-4 fw-bold text-center">Alumni Registration</h3>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="POST" enctype="multipart/form-data">

<!-- BASIC INFO -->
<h5 class="mb-3 fw-semibold">Basic Information</h5>
<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Full Name</label>
<input type="text" name="full_name" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Email Address</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Roll Number</label>
<input type="text" name="roll_no" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Date of Birth</label>
<input type="date" name="dob" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Gender</label>
<select name="gender" class="form-select" required>
<option value="">Select Gender</option>
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>
</div>

<!-- 🆕 Profile Photo Upload -->
<div class="col-md-12 mb-3">
<label class="form-label">Profile Photo</label>
<input type="file" name="profile_photo" accept="image/*" class="form-control">
<small class="text-muted">Upload your photo (JPG, JPEG, PNG, GIF)</small>
</div>

</div>

<!-- ACADEMIC INFO -->
<h5 class="mt-4 mb-3 fw-semibold">Academic Information</h5>
<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Branch</label>
<select name="branch" class="form-select" required>
<option value="">Select Branch</option>
<option>Information Technology</option>
<option>Electronics</option>
<option>Mechanical</option>
<option>Electrical</option>
<option>Civil</option>
<option>Pharmacy</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Semester</label>
<input type="number" name="semester" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Batch Year</label>
<input type="number" name="batch_year" class="form-control" required>
</div>

</div>

<!-- PROFESSIONAL INFO -->
<h5 class="mt-4 mb-3 fw-semibold">Professional Information</h5>
<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Current Status</label>
<select name="employment_status" id="employment_status" class="form-select">
<option value="">Select Status</option>
<option>Student</option>
<option>Working Professional</option>
<option>Intern</option>
<option>Entrepreneur</option>
<option>Not Working</option>
</select>
</div>

<div id="professional_fields" class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Company Name</label>
<input type="text" name="current_company" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Job Title</label>
<input type="text" name="job_title" class="form-control">
</div>

</div>

<div class="col-md-6 mb-3">
<label class="form-label">LinkedIn Profile</label>
<input type="url" name="linkedin" class="form-control">
</div>

</div>

<!-- CONTACT -->
<h5 class="mt-4 mb-3 fw-semibold">Contact Information</h5>
<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Phone Number</label>
<input type="text" name="phone" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Address</label>
<input type="text" name="address" class="form-control">
</div>

</div>

<div class="text-center mt-4">
<button type="submit" class="btn btn-primary px-5">Register</button>
</div>

</form>
</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {

    const dropdown = document.getElementById("employment_status");
    const fields = document.getElementById("professional_fields");

    function toggleFields() {
        if (dropdown.value === "Student" || dropdown.value === "Not Working") {
            fields.style.display = "none";
        } else {
            fields.style.display = "flex";
        }
    }

    // Run when page loads
    toggleFields();

    // Run when dropdown changes
    dropdown.addEventListener("change", toggleFields);

});
</script>