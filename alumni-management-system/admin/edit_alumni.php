<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id']);

$query = "SELECT * FROM users 
          JOIN alumni_profiles ON users.id = alumni_profiles.user_id
          WHERE users.id = $id";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST['full_name'];
    $roll_no = $_POST['roll_no'];
    $email = $_POST['email'];
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $batch_year = $_POST['batch_year'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    mysqli_query($conn, "UPDATE users 
        SET full_name='$full_name', roll_no='$roll_no', email='$email'
        WHERE id=$id");

    mysqli_query($conn, "UPDATE alumni_profiles 
        SET branch='$branch',
            semester='$semester',
            batch_year='$batch_year',
            dob='$dob',
            phone='$phone',
            gender='$gender',
            address='$address',
        WHERE user_id=$id");

    header("Location: manage_alumni.php");
    exit();
}
include "layout.php";
?>

<h2>Edit Alumni</h2>

<form method="POST" class="mt-4">

    <div class="mb-3">
        <label>Full Name</label>
        <input type="text" name="full_name" class="form-control" value="<?php echo $data['full_name']; ?>" required>
    </div>

    <div class="mb-3">
        <label>Roll No</label>
        <input type="text" name="roll_no" class="form-control" value="<?php echo $data['roll_no']; ?>" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>" required>
    </div>

    <div class="mb-3">
        <label>Branch</label>
        <select name="branch" class="form-control">
            <option value="Information Technology" <?php if($data['branch']=="Information Technology") echo "selected"; ?>>Information Technology</option>
            <option value="Electronics" <?php if($data['branch']=="Electronics") echo "selected"; ?>>Electronics</option>
            <option value="Mechanical" <?php if($data['branch']=="Mechanical") echo "selected"; ?>>Mechanical</option>
            <option value="Electrical" <?php if($data['branch']=="Electrical") echo "selected"; ?>>Electrical</option>
            <option value="Civil" <?php if($data['branch']=="Civil") echo "selected"; ?>>Civil</option>
            <option value="Pharmacy" <?php if($data['branch']=="Pharmacy") echo "selected"; ?>>Pharmacy</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Semester</label>
        <select name="semester" class="form-control">
            <?php for($i=1; $i<=8; $i++) { ?>
                <option value="<?php echo $i; ?>" 
                    <?php if($data['semester']==$i) echo "selected"; ?>>
                    <?php echo $i; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Batch Year</label>
        <input type="number" name="batch_year" class="form-control" value="<?php echo $data['batch_year']; ?>">
    </div>

    <div class="mb-3">
        <label>Date of Birth</label>
        <input type="date" name="dob" class="form-control" value="<?php echo $data['dob']; ?>">
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="<?php echo $data['phone']; ?>">
    </div>

    <div class="mb-3">
        <label>Gender</label>
        <select name="gender" class="form-control">
            <option value="Male" <?php if($data['gender']=="Male") echo "selected"; ?>>Male</option>
            <option value="Female" <?php if($data['gender']=="Female") echo "selected"; ?>>Female</option>
            <option value="Other" <?php if($data['gender']=="Other") echo "selected"; ?>>Other</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control"><?php echo $data['address']; ?></textarea>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="manage_alumni.php" class="btn btn-secondary">Cancel</a>

</form>


<?php include "layout_footer.php"; ?>
