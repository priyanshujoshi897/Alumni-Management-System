<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include "layout.php";

$event_id = intval($_GET['id']);

$event = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT title FROM events WHERE id = $event_id")
);

$registrations = mysqli_query($conn, "
    SELECT users.full_name, users.email
    FROM event_registrations
    JOIN users ON event_registrations.user_id = users.id
    WHERE event_registrations.event_id = $event_id
");
?>

<div class="card-box">
    <h4 class="mb-3">
        Registrations for: <?= htmlspecialchars($event['title']); ?>
    </h4>

    <?php if(mysqli_num_rows($registrations) > 0) { ?>

        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($registrations)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['full_name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                </tr>
            <?php } ?>
        </table>

    <?php } else { ?>

        <div class="alert alert-info">
            No registrations yet.
        </div>

    <?php } ?>

    <a href="manage_events.php" class="btn btn-dark mt-3">Back</a>
</div>
<?php include "layout_footer.php"; ?>
