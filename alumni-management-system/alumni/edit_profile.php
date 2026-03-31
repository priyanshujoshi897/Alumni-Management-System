<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch existing data
$query = "SELECT * FROM alumni_profiles WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Profile not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $linkedin = $_POST['linkedin'] ?? '';
    $current_company = $_POST['current_company'] ?? '';
    $job_title = $_POST['job_title'] ?? '';
    $employment_status = $_POST['employment_status'] ?? '';
    $bio = $_POST['bio'] ?? '';

    // Profile Photo Upload
    $profile_photo = $data['profile_photo'] ?? '';

    if (!empty($_FILES['profile_photo']['name'])) {

        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir);
        }

        $filename = time() . "_" . basename($_FILES["profile_photo"]["name"]);
        $target_file = $target_dir . $filename;

        move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file);

        $profile_photo = $filename;
    }

    mysqli_query($conn, "UPDATE alumni_profiles 
        SET phone='$phone',
            address='$address',
            linkedin='$linkedin',
            current_company='$current_company',
            job_title='$job_title',
            employment_status='$employment_status',
            bio='$bio',
            profile_photo='$profile_photo'
        WHERE user_id=$user_id");

    header("Location: dashboard.php");
    exit();
}

include "layout.php";
?>

<div class="card-box">
    <h3 class="mb-4">Edit Profile</h3>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control"
                   value="<?php echo htmlspecialchars($data['phone'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control"><?php echo htmlspecialchars($data['address'] ?? ''); ?></textarea>
        </div>

        <hr>

        <div class="mb-3">
            <label class="form-label">Profile Photo</label>
            <input type="file" name="profile_photo" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">LinkedIn URL</label>
            <input type="url" name="linkedin" class="form-control"
                   value="<?php echo htmlspecialchars($data['linkedin'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Current Company</label>
            <input type="text" name="current_company" class="form-control"
                   value="<?php echo htmlspecialchars($data['current_company'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Job Title</label>
            <input type="text" name="job_title" class="form-control"
                   value="<?php echo htmlspecialchars($data['job_title'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Employment Status</label>
            <select name="employment_status" class="form-select">
                <option value="">Select Status</option>
                <option value="Student" <?php if(($data['employment_status'] ?? '')=="Student") echo "selected"; ?>>Student</option>
                <option value="Employed" <?php if(($data['employment_status'] ?? '')=="Employed") echo "selected"; ?>>Employed</option>
                <option value="Entrepreneur" <?php if(($data['employment_status'] ?? '')=="Entrepreneur") echo "selected"; ?>>Entrepreneur</option>
                <option value="Higher Studies" <?php if(($data['employment_status'] ?? '')=="Higher Studies") echo "selected"; ?>>Higher Studies</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">About / Bio</label>
            <textarea name="bio" class="form-control"><?php echo htmlspecialchars($data['bio'] ?? ''); ?></textarea>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </div>

    </form>
</div>

<?php include "layout_footer.php"; ?>
