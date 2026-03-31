<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* APPLY LOGIC */
if(isset($_GET['apply'])) {
    $job_id = intval($_GET['apply']);

    $check = mysqli_query($conn, "
        SELECT id FROM job_applications 
        WHERE job_id='$job_id' AND user_id='$user_id'
    ");

    if(mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "
            INSERT INTO job_applications (job_id, user_id)
            VALUES ('$job_id', '$user_id')
        ");
    }

    header("Location: jobs.php");
    exit();
}

/* FETCH JOBS */
$result = mysqli_query($conn, "
    SELECT jobs.*, users.full_name 
    FROM jobs
    JOIN users ON jobs.posted_by = users.id
    ORDER BY jobs.created_at DESC
");

include "layout.php";
?>

<div class="card-box">
    <h3 class="mb-4">Available Jobs</h3>

<?php if(mysqli_num_rows($result) > 0) { ?>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="card mb-4 p-3">

            <h5 class="fw-bold"><?php echo htmlspecialchars($row['title']); ?></h5>

            <p class="mb-1">
                <strong>Company:</strong> <?php echo htmlspecialchars($row['company']); ?>
            </p>

            <p class="mb-1">
                <strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?>
            </p>

            <p class="mb-1">
                <strong>Posted By:</strong> <?php echo htmlspecialchars($row['full_name']); ?>
            </p>
             <p class="mb-1">
                <strong>Package:</strong> <?php echo htmlspecialchars($row['package']); ?>

            <p class="mb-2">
                <strong>Deadline:</strong> <?php echo $row['deadline']; ?>
            </p>

            <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>

            <?php
            $job_id = $row['id'];
            $checkApply = mysqli_query($conn, "
                SELECT id FROM job_applications 
                WHERE job_id='$job_id' AND user_id='$user_id'
            ");
            ?>

            <?php if(mysqli_num_rows($checkApply) == 0) { ?>
                <a href="jobs.php?apply=<?php echo $job_id; ?>" 
                   class="btn btn-primary">
                   Apply
                </a>
            <?php } else { ?>
                <button class="btn btn-success" disabled>
                    Applied
                </button>
            <?php } ?>

        </div>

    <?php } ?>

<?php } else { ?>

    <div class="alert alert-info">
        No jobs posted yet.
    </div>

<?php } ?>

</div>

<?php include "layout_footer.php"; ?>
