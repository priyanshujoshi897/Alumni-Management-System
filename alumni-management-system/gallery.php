<?php
require_once "config/db.php";
include "includes/header.php";

$result = mysqli_query($conn, "SELECT * FROM gallery ORDER BY uploaded_at DESC");
?>

<h2 class="mb-4">Gallery</h2>

<div class="row">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="col-md-3 mb-4">
    <div class="card">
        <img src="uploads/<?php echo $row['image']; ?>" 
             class="card-img-top"
             style="height:200px;object-fit:cover;">
        <div class="card-body text-center">
            <p><?php echo $row['title']; ?></p>
        </div>
    </div>
</div>

<?php } ?>

</div>

<?php include "includes/footer.php"; ?>
