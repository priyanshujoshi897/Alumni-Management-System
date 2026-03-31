<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "
    SELECT * FROM jobs
    WHERE posted_by = '$user_id'
    ORDER BY created_at DESC
");

include "layout.php";
?>

<div class="card-box">
    <h3 class="mb-4">My Posted Jobs</h3>

<?php if(mysqli_num_rows($result) > 0) { ?>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>

       <div class="card mb-3 p-3">

    <h5><?php echo htmlspecialchars($row['title']); ?></h5>
    <p><strong>Company:</strong> <?php echo htmlspecialchars($row['company']); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>

    <div class="mt-2">
        <a href="view_applicants.php?job_id=<?php echo $row['id']; ?>" 
           class="btn btn-dark btn-sm">
           View Applicants
        </a>

        <a href="delete_job.php?id=<?php echo $row['id']; ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Are you sure you want to delete this job?');">
           Delete
        </a>
    </div>

</div>

    <?php } ?>

<?php } else { ?>

    <div class="alert alert-info">
        You have not posted any jobs yet.
    </div>

<?php } ?>

</div>

<?php include "layout_footer.php"; ?>
