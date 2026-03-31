<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "
    SELECT forum_posts.*, users.full_name 
    FROM forum_posts
    JOIN users ON forum_posts.user_id = users.id
    ORDER BY forum_posts.created_at DESC
");

include "layout.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Discussion Forum</h2>
    <a href="create_post.php" class="btn btn-primary">Create Post</a>
</div>

<div class="row">

<?php if(mysqli_num_rows($result) > 0) { ?>

<?php while($row = mysqli_fetch_assoc($result)) { 

    $post_id = $row['id'];

    // Check if liked
    $like_check = mysqli_query($conn, "
        SELECT id FROM forum_likes 
        WHERE post_id=$post_id AND user_id=$user_id
    ");
    $isLiked = mysqli_num_rows($like_check) > 0;

    // Count total likes
    $like_count = mysqli_query($conn, "
        SELECT COUNT(*) as total FROM forum_likes 
        WHERE post_id=$post_id
    ");
    $like_total = mysqli_fetch_assoc($like_count)['total'];
?>

<div class="col-md-6 mb-4">
    <div class="card p-4 h-100 d-flex flex-column">

        <h5 class="fw-semibold mb-2">
            <?php echo htmlspecialchars($row['title']); ?>
        </h5>

        <p class="text-muted small mb-2">
            Posted by 
            <a href="view_profile.php?id=<?php echo $row['user_id']; ?>" 
               class="text-decoration-none fw-semibold">
               <?php echo htmlspecialchars($row['full_name']); ?>
            </a>
            • <?php echo date("d M Y", strtotime($row['created_at'])); ?>
        </p>

        <p class="text-muted flex-grow-1">
            <?php echo substr(htmlspecialchars($row['content']), 0, 120); ?>...
        </p>

        <div class="d-flex justify-content-between align-items-center mt-3">

            <!-- Like Button -->
            <a href="like_post.php?id=<?php echo $post_id; ?>" 
               class="btn btn-sm <?php echo $isLiked ? 'btn-success' : 'btn-outline-primary'; ?>">
                👍 <?php echo $isLiked ? 'Liked' : 'Like'; ?>
            </a>

            <small class="text-muted">
                <?php echo $like_total; ?> likes
            </small>

            <a href="view_post.php?id=<?php echo $post_id; ?>" 
               class="btn btn-outline-secondary btn-sm">
               View
            </a>
            <a href="delete_post.php?id=<?php echo $row['id']; ?>"
       class="btn btn-danger btn-sm ms-2"
       onclick="return confirm('Are you sure you want to delete this post?');">
       Delete
    </a>

        </div>

    </div>
</div>

<?php } ?>

<?php } else { ?>

<div class="col-12">
    <div class="alert alert-info text-center">
        No posts yet. Be the first to start a discussion.
    </div>
</div>

<?php } ?>

</div>

<?php include "layout_footer.php"; ?>
