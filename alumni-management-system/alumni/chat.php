<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'alumni') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* SEND MESSAGE */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {

    $receiver_id = intval($_POST['receiver_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (!empty($message)) {
        mysqli_query($conn, "
            INSERT INTO messages (sender_id, receiver_id, message)
            VALUES ('$user_id', '$receiver_id', '$message')
        ");
    }

    header("Location: chat.php?user=$receiver_id");
    exit();
}

/* SELECT CHAT USER */
$chat_user_id = isset($_GET['user']) ? intval($_GET['user']) : 0;

/* GET ALL ALUMNI */
$users = mysqli_query($conn, "
    SELECT id, full_name FROM users 
    WHERE role='alumni' AND id != '$user_id'
");

include "layout.php";
?>

<div class="row">

    <!-- LEFT: USERS LIST -->
    <div class="col-md-4">
        <div class="card-box">
            <h5 class="mb-3">Alumni</h5>

            <?php while($u = mysqli_fetch_assoc($users)) { ?>
                <div class="mb-2">
                    <a href="chat.php?user=<?php echo $u['id']; ?>"
                       class="btn btn-sm w-100 <?php echo ($chat_user_id == $u['id']) ? 'btn-primary' : 'btn-outline-dark'; ?>">
                        <?php echo htmlspecialchars($u['full_name']); ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- RIGHT: CHAT BOX -->
    <div class="col-md-8">
        <div class="card-box" style="height:500px; display:flex; flex-direction:column;">

            <?php if($chat_user_id > 0) { ?>

                <!-- CHAT MESSAGES -->
                <div style="flex:1; overflow-y:auto; margin-bottom:15px;">

                    <?php
                    $messages = mysqli_query($conn, "
                        SELECT * FROM messages
                        WHERE 
                        (sender_id='$user_id' AND receiver_id='$chat_user_id')
                        OR
                        (sender_id='$chat_user_id' AND receiver_id='$user_id')
                        ORDER BY sent_at ASC
                    ");

                    while($msg = mysqli_fetch_assoc($messages)) {
                        $isMe = ($msg['sender_id'] == $user_id);
                    ?>

                        <div class="mb-2 text-<?php echo $isMe ? 'end' : 'start'; ?>">
                            <div class="d-inline-block p-2 rounded 
                                <?php echo $isMe ? 'bg-primary text-white' : 'bg-light'; ?>">
                                <?php echo htmlspecialchars($msg['message']); ?>
                            </div>
                        </div>

                    <?php } ?>

                </div>

                <!-- SEND FORM -->
                <form method="POST" class="d-flex">
                    <input type="hidden" name="receiver_id" value="<?php echo $chat_user_id; ?>">
                    <input type="text" name="message" class="form-control me-2" placeholder="Type a message..." required>
                    <button class="btn btn-primary">Send</button>
                </form>

            <?php } else { ?>

                <div class="text-center text-muted mt-5">
                    Select an alumni to start chatting.
                </div>

            <?php } ?>

        </div>
    </div>

</div>

<?php include "layout_footer.php"; ?>
