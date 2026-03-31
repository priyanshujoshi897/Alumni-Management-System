<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include "layout.php";

/* ===== Counts ===== */
$totalAlumni = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='alumni'")
);

$totalEvents = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM events")
);

$totalGallery = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM gallery")
);

$totalPosts = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM forum_posts")
);

/* ===== Recent Alumni ===== */
$recent = mysqli_query($conn, "
    SELECT full_name, email
    FROM users
    WHERE role='alumni'
    ORDER BY id DESC
    LIMIT 5
");
?>

<!-- =======================
     DASHBOARD STATS
======================= -->

<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="card-box text-center">
            <h6 class="text-muted">Total Alumni</h6>
            <h2 class="fw-bold"><?= $totalAlumni['total']; ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box text-center">
            <h6 class="text-muted">Total Events</h6>
            <h2 class="fw-bold"><?= $totalEvents['total']; ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box text-center">
            <h6 class="text-muted">Gallery Images</h6>
            <h2 class="fw-bold"><?= $totalGallery['total']; ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box text-center">
            <h6 class="text-muted">Forum Posts</h6>
            <h2 class="fw-bold"><?= $totalPosts['total']; ?></h2>
        </div>
    </div>

</div>

<!-- =======================
     RECENT ALUMNI
======================= -->

<div class="card-box mb-4">
    <h5 class="mb-3">Recently Added Alumni</h5>

    <?php if(mysqli_num_rows($recent) > 0) { ?>

        <div class="list-group">
            <?php while($row = mysqli_fetch_assoc($recent)) { ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($row['full_name']); ?>
                    <span class="text-muted small">
                        <?= htmlspecialchars($row['email']); ?>
                    </span>
                </div>
            <?php } ?>
        </div>

    <?php } else { ?>

        <div class="alert alert-info text-center">
            No alumni found.
        </div>

    <?php } ?>
</div>

<?php include "layout_footer.php"; ?>
