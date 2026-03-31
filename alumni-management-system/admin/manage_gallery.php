<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include "layout.php";

$result = mysqli_query($conn, "SELECT * FROM gallery ORDER BY uploaded_at DESC");
?>

<div class="card-box">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Manage Gallery</h4>
        <a href="add_gallery.php" class="btn btn-dark">Add New Image</a>
    </div>

    <?php if(mysqli_num_rows($result) > 0) { ?>

        <div class="row g-4">

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">

                        <?php if(!empty($row['image']) && file_exists("../uploads/" . $row['image'])) { ?>
                            <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" 
                                 class="card-img-top"
                                 style="height:200px;object-fit:cover;">
                        <?php } else { ?>
                            <div style="height:200px;display:flex;align-items:center;justify-content:center;background:#f1f5f9;">
                                <span class="text-muted">No Image</span>
                            </div>
                        <?php } ?>

                        <div class="card-body text-center">

                            <p class="fw-semibold mb-3">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </p>

                            <a href="delete_gallery.php?id=<?php echo $row['id']; ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Delete this image?');">
                               Delete
                            </a>

                        </div>

                    </div>
                </div>

            <?php } ?>

        </div>

    <?php } else { ?>

        <div class="alert alert-info text-center">
            No gallery images uploaded yet.
        </div>

    <?php } ?>

</div>

<?php include "layout_footer.php"; ?>
