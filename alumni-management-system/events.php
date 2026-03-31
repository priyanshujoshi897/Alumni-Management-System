<?php
require_once "config/db.php";
include "includes/header.php";

$result = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date DESC");
?>

<h2 class="mb-5 text-center">Upcoming Events</h2>

<div class="row">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<?php
$isRegistered = false;

if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'alumni') {

    $user_id = $_SESSION['user_id'];
    $event_id = $row['id'];

    $check = mysqli_query($conn, "SELECT id FROM event_registrations 
                                  WHERE event_id=$event_id AND user_id=$user_id");

    if(mysqli_num_rows($check) > 0) {
        $isRegistered = true;
    }
}
?>

<div class="col-md-4 mb-4">
    <div class="card h-100">

        <?php if(!empty($row['image'])) { ?>
            <img src="uploads/<?php echo $row['image']; ?>" 
                 class="card-img-top" 
                 style="height:220px;object-fit:cover;">
        <?php } ?>

        <div class="card-body d-flex flex-column">

            <h5 class="fw-bold"><?php echo $row['title']; ?></h5>

            <p class="mb-1">
                <strong>Date:</strong> <?php echo $row['event_date']; ?>
            </p>

            <p class="mb-2">
                <strong>Location:</strong> <?php echo $row['location']; ?>
            </p>

            <p class="text-muted flex-grow-1">
                <?php echo substr($row['description'],0,100); ?>...
            </p>

            <div class="mt-3">

                <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'alumni') { ?>

                    <?php if($isRegistered) { ?>
                        <button class="btn btn-success w-100" disabled>
                            Registered
                        </button>
                    <?php } else { ?>
                        <a href="register_event.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-primary w-100">
                           Register
                        </a>
                    <?php } ?>

                <?php } else { ?>

                    <a href="login.php?redirect=events.php" class="btn btn-outline-primary w-100">
    Login to Register
</a>
                    </a>

                <?php } ?>

            </div>

        </div>

    </div>
</div>

<?php } ?>

</div>

<?php include "includes/footer.php"; ?>
