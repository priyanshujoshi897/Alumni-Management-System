<?php
session_start();
require_once "config/db.php";

$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND status='approved'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['full_name'];

            if (!empty($redirect)) {
                header("Location: $redirect");
            } else {
                if ($user['role'] == 'admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: alumni/dashboard.php");
                }
            }
            exit();

        } else {
            $error = "Invalid password!";
        }

    } else {
        $error = "User not found or not approved!";
    }
}
?>

<?php include "includes/header.php"; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height:80vh;">

    <div class="card p-5" style="width: 100%; max-width: 420px;">

        <h3 class="text-center mb-4 fw-bold">Login</h3>

        <?php if(isset($error)) { ?>
            <div class="alert alert-danger text-center">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <?php if(!empty($redirect)) { ?>
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
            <?php } ?>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>

        </form>

        <p class="text-center mt-4 mb-0">
            Don't have an account?
            <a href="register.php">Register here</a>
        </p>

    </div>

</div>

<?php include "includes/footer.php"; ?>
