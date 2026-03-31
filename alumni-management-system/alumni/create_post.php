<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    mysqli_query($conn, "
        INSERT INTO forum_posts (user_id, title, content)
        VALUES ($user_id, '$title', '$content')
    ");

    header("Location: forum.php");
    exit();
}

include "layout.php";
?>

<h2 class="fw-bold mb-4">Create New Post</h2>

<div class="card p-4">

<form method="POST">

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" rows="5" class="form-control" required></textarea>
    </div>

    <button class="btn btn-primary">Publish Post</button>

</form>

</div>

<?php include "layout_footer.php"; ?>
