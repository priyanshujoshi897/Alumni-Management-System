<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include "layout.php";

/* Fetch events */
$result = mysqli_query($conn, "
    SELECT events.*, 
    (SELECT COUNT(*) FROM event_registrations 
     WHERE event_registrations.event_id = events.id) 
     AS total_registrations
    FROM events
    ORDER BY event_date DESC
");
?>

<div class="card-box">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Manage Events</h3>
        <a href="add_event.php" class="btn btn-dark">Add New Event</a>
    </div>

    <?php if(mysqli_num_rows($result) > 0) { ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Registrations</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']); ?></td>
                            <td><?= date("d M Y", strtotime($row['event_date'])); ?></td>
                            <td><?= htmlspecialchars($row['location']); ?></td>

                            <td>
                                <span class="badge bg-primary">
                                    <?= $row['total_registrations']; ?>
                                </span>
                            </td>

                            <td>
                                <a href="view_registrations.php?id=<?= $row['id']; ?>"
                                   class="btn btn-sm btn-outline-primary">
                                   View
                                </a>

                                <a href="delete_event.php?id=<?= $row['id']; ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Delete this event?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

    <?php } else { ?>

        <div class="alert alert-info text-center">
            No events added yet.
        </div>

    <?php } ?>

</div>

<?php include "layout_footer.php"; ?>
