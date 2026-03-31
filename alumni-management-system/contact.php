<?php
require_once "config/db.php";
include "includes/header.php";

$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    mysqli_query($conn, "INSERT INTO contact_messages (name, email, subject, message)
                         VALUES ('$name','$email','$subject','$message')");

    $success = "Your message has been sent successfully!";
}
?>

<style>
.contact-card {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.06);
    background: white;
}

/* Left Panel */
.contact-left {
    background: linear-gradient(135deg, #6366F1, #6366F1);
    color: white;
    padding: 50px;
}

.contact-left h4 {
    font-weight: 600;
    margin-bottom: 30px;
}

.contact-left p {
    margin-bottom: 20px;
    line-height: 1.6;
    font-size: 15px;
}

/* Right Panel */
.contact-right {
    background: #ffffff;
    padding: 50px;
}

.contact-right h4 {
    font-weight: 600;
    margin-bottom: 25px;
}

/* Form Styling */
.form-control {
    border-radius: 12px;
    padding: 10px 15px;
    border: 1px solid #E5E7EB;
    box-shadow: none;
}

.form-control:focus {
    border-color: #6366F1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
}

/* Success Alert */
.alert-success {
    border-radius: 50px;
}
</style>

<div class="text-center mb-5">
    <h2>📞 Contact Us</h2>
    <p class="text-muted">We're here to help — get in touch with UGIP</p>
</div>

<?php if($success) { ?>
    <div class="alert alert-success text-center"><?php echo $success; ?></div>
<?php } ?>

<div class="container">
    <div class="row contact-card">

        <!-- LEFT SIDE -->
        <div class="col-md-6 contact-left">
            <h4>Our Contact Details</h4>

            <p><strong>📍 Address:</strong><br>
            UGIP, Sherwani, Nainital, Uttarakhand 263001, India</p>

            <p><strong>📞 Phone:</strong><br>
            +91 9876543210<br>
            +91 9123456789</p>

            <p><strong>✉ Email:</strong><br>
            info@gpnainital.ac.in</p>

            <p><strong>⏰ Office Hours:</strong><br>
            Monday – Saturday, 9 AM – 5 PM</p>
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6 contact-right">
            <h4>Send us a message</h4>

            <form method="POST">

                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Subject</label>
                    <input type="text" name="subject" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Message</label>
                    <textarea name="message" class="form-control" rows="4" required></textarea>
                </div>
<button class="btn btn-primary">Send Message</button>

            </form>
        </div>

    </div>
</div>

<?php include "includes/footer.php"; ?>
