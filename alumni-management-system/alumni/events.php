<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* REGISTER LOGIC */
if(isset($_GET['register'])) {

    $event_id = intval($_GET['register']);

    $check = mysqli_query($conn, "
        SELECT id FROM event_registrations
        WHERE event_id='$event_id' AND user_id='$user_id'
    ");

    if(mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "
            INSERT INTO event_registrations (event_id, user_id)
            VALUES ('$event_id', '$user_id')
        ");
    }

    header("Location: events.php");
    exit();
}

/* FETCH EVENTS */
$result = mysqli_query($conn, "
    SELECT * FROM events
    ORDER BY event_date DESC
");

include "layout.php";
?>

<div class="card-box">
    <h3 class="mb-4">Upcoming Events</h3>

<?php if(mysqli_num_rows($result) > 0) { ?>

    <div class="row">

    <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm">

                <?php if(!empty($row['image']) && file_exists("../uploads/".$row['image'])) { ?>
                    <img src="../uploads/<?php echo $row['image']; ?>"
                         class="img-fluid rounded mb-3"
                         style="height:200px; object-fit:cover;">
                <?php } ?>

                <h5 class="fw-bold"><?php echo htmlspecialchars($row['title']); ?></h5>

                <p class="mb-1">
                    <strong>Date:</strong>
                    <?php echo date("d M Y", strtotime($row['event_date'])); ?>
                </p>

                <p class="mb-1">
                    <strong>Location:</strong>
                    <?php echo htmlspecialchars($row['location']); ?>
                </p>

                <p>
                    <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                </p>

                <?php
                $event_id = $row['id'];
                $checkRegister = mysqli_query($conn, "
                    SELECT id FROM event_registrations
                    WHERE event_id='$event_id' AND user_id='$user_id'
                ");
                ?>

                <?php if(mysqli_num_rows($checkRegister) == 0) { ?>
                    <a href="events.php?register=<?php echo $event_id; ?>"
                       class="btn btn-primary">
                       Register
                    </a>
                <?php } else { ?>
                    <button class="btn btn-success" disabled>
                        Registered
                    </button>
                <?php } ?>

            </div>
        </div>

    <?php } ?>

    </div>

<?php } else { ?>

    <div class="alert alert-info">
        No events available.
    </div>

<?php } ?>

</div>

<?php include "layout_footer.php"; ?>
