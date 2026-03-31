<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$job_id = intval($_GET['job_id']);

/* Check if this job belongs to logged-in user */
$check = mysqli_query($conn, "
    SELECT id FROM jobs 
    WHERE id='$job_id' AND posted_by='$user_id'
");

if(mysqli_num_rows($check) == 0) {
    echo "Unauthorized access.";
    exit();
}

/* Fetch applicants */
$result = mysqli_query($conn, "
    SELECT users.full_name, users.email
    FROM job_applications
    JOIN users ON job_applications.user_id = users.id
    WHERE job_applications.job_id = '$job_id'
");

include "layout.php";
?>

<div class="card-box">
    <h3 class="mb-4">Applicants</h3>

<?php if(mysqli_num_rows($result) > 0) { ?>

    <ul class="list-group">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <li class="list-group-item d-flex justify-content-between">
                <?php echo htmlspecialchars($row['full_name']); ?>
                <span class="text-muted">
                    <?php echo htmlspecialchars($row['email']); ?>
                </span>
            </li>
        <?php } ?>
    </ul>

<?php } else { ?>

    <div class="alert alert-info">
        No one has applied yet.
    </div>

<?php } ?>

</div>

<?php include "layout_footer.php"; ?>
