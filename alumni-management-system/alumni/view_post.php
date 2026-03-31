<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$post_id = intval($_GET['id']);

$post = mysqli_query($conn, "
    SELECT forum_posts.*, users.full_name 
    FROM forum_posts
    JOIN users ON forum_posts.user_id = users.id
    WHERE forum_posts.id = $post_id
");

$post_data = mysqli_fetch_assoc($post);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    mysqli_query($conn, "
        INSERT INTO forum_comments (post_id, user_id, comment)
        VALUES ($post_id, $user_id, '$comment')
    ");

    header("Location: view_post.php?id=$post_id");
    exit();
}

$comments = mysqli_query($conn, "
    SELECT forum_comments.*, users.full_name 
    FROM forum_comments
    JOIN users ON forum_comments.user_id = users.id
    WHERE post_id = $post_id
    ORDER BY forum_comments.created_at ASC
");

include "layout.php";
?>

<div class="card p-4 mb-4">
    <h3 class="fw-bold"><?php echo htmlspecialchars($post_data['title']); ?></h3>

    <p class="text-muted small">
        Posted by <?php echo htmlspecialchars($post_data['full_name']); ?>
        • <?php echo date("d M Y", strtotime($post_data['created_at'])); ?>
    </p>

    <p><?php echo nl2br(htmlspecialchars($post_data['content'])); ?></p>
</div>

<h5 class="mb-3">Comments</h5>

<?php while($row = mysqli_fetch_assoc($comments)) { ?>

<div class="card p-3 mb-3">
    <p class="mb-1">
        <?php echo nl2br(htmlspecialchars($row['comment'])); ?>
    </p>
    <small class="text-muted">
        <?php echo htmlspecialchars($row['full_name']); ?>
        • <?php echo date("d M Y H:i", strtotime($row['created_at'])); ?>
    </small>
</div>

<?php } ?>

<div class="card p-4 mt-4">
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Add Comment</label>
            <textarea name="comment" rows="3" class="form-control" required></textarea>
        </div>
        <button class="btn btn-primary">Post Comment</button>
    </form>
</div>

<?php include "layout_footer.php"; ?>