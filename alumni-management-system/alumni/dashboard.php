<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users 
          JOIN alumni_profiles ON users.id = alumni_profiles.user_id
          WHERE users.id = $user_id";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

include "layout.php";

?>

<h2 class="mb-4">Welcome, <?php echo $data['full_name']; ?></h2>

<div class="row">

    <div class="col-md-4 text-center">

        <?php if(!empty($data['profile_photo'])) { ?>
            <img src="../<?php echo $data['profile_photo']; ?>" 
     class="img-fluid rounded mb-3"
     style="max-height:200px;">
        <?php } else { ?>
            <img src="https://via.placeholder.com/200" 
                 class="img-fluid rounded mb-3">
        <?php } ?>

        <p><strong>Roll No:</strong> <?php echo $data['roll_no']; ?></p>
        <p><strong>Branch:</strong> <?php echo $data['branch']; ?></p>
        <p><strong>Semester:</strong> <?php echo $data['semester']; ?></p>
        <p><strong>Batch Year:</strong> <?php echo $data['batch_year']; ?></p>

    </div>

    <div class="col-md-8">

        <div class="card mb-3">
            <div class="card-body">

                <h5>Contact Information</h5>
                <p><strong>Email:</strong> <?php echo $data['email']; ?></p>
                <p><strong>Phone:</strong> <?php echo $data['phone']; ?></p>
                <p><strong>Address:</strong> <?php echo $data['address']; ?></p>

            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">

                <h5>Professional Information</h5>

                <?php if(!empty($data['employment_status'])) { ?>
                    <p><strong>Status:</strong> <?php echo $data['employment_status']; ?></p>
                <?php } ?>

                <?php if(!empty($data['current_company'])) { ?>
                    <p><strong>Company:</strong> <?php echo $data['current_company']; ?></p>
                <?php } ?>

                <?php if(!empty($data['job_title'])) { ?>
                    <p><strong>Job Title:</strong> <?php echo $data['job_title']; ?></p>
                <?php } ?>

            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">

                <h5>Social Links</h5>

                <?php if(!empty($data['linkedin'])) { ?>
                    <p>
                        <a href="<?php echo $data['linkedin']; ?>" target="_blank">
                            LinkedIn Profile
                        </a>
                    </p>
                <?php } ?>

                <?php if(!empty($data['instagram'])) { ?>
                    <p>
                        <a href="<?php echo $data['instagram']; ?>" target="_blank">
                            Instagram Profile
                        </a>
                    </p>
                <?php } ?>

            </div>
        </div>

        <?php if(!empty($data['bio'])) { ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5>About</h5>
                    <p><?php echo $data['bio']; ?></p>
                </div>
            </div>
        <?php } ?>

        <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
    

    </div>

<?php include "layout_footer.php"; ?>

