<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$user_id = intval($_GET['id']);

$query = mysqli_query($conn, "
    SELECT users.*, alumni_profiles.*
    FROM users
    LEFT JOIN alumni_profiles ON users.id = alumni_profiles.user_id
    WHERE users.id = $user_id
");

$data = mysqli_fetch_assoc($query);

include "../includes/header.php";
?>

<div class="card p-4">

    <h3 class="fw-bold"><?php echo htmlspecialchars($data['full_name']); ?></h3>

    <p><strong>Branch:</strong> <?php echo htmlspecialchars($data['branch']); ?></p>
    <p><strong>Batch:</strong> <?php echo htmlspecialchars($data['batch_year']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($data['email']); ?></p>

    <?php if(!empty($data['bio'])) { ?>
        <p><strong>About:</strong> <?php echo nl2br(htmlspecialchars($data['bio'])); ?></p>
    <?php } ?>

    <?php if(!empty($data['linkedin'])) { ?>
        <p><a href="<?php echo $data['linkedin']; ?>" target="_blank">LinkedIn</a></p>
    <?php } ?>

</div>

<?php include "../includes/footer.php"; ?>
