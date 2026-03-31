<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include "layout.php";

$result = mysqli_query($conn, "
    SELECT forum_posts.*, users.full_name
    FROM forum_posts
    JOIN users ON forum_posts.user_id = users.id
    ORDER BY forum_posts.created_at DESC
");
?>

<div class="card-box">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Manage Forum Posts</h4>
        <span class="text-muted">
            Total Posts: <?php echo mysqli_num_rows($result); ?>
        </span>
    </div>

    <?php if(mysqli_num_rows($result) > 0) { ?>

        <div class="table-responsive">
            <table class="table align-middle table-hover">

                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

                    <tr>
                        <td>
                            <strong>
                                <?php echo htmlspecialchars($row['title']); ?>
                            </strong>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['full_name']); ?>
                        </td>

                        <td>
                            <?php echo date("d M Y", strtotime($row['created_at'])); ?>
                        </td>

                        <td>
                            <a href="delete_post.php?id=<?php echo $row['id']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete this post?');">
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
            No forum posts found.
        </div>

    <?php } ?>

</div>

<?php include "layout_footer.php"; ?>
