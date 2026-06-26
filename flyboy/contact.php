<?php
// Handle contact form submission
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // ADMIN EMAIL - PUT YOUR REAL EMAIL HERE
    $to = "malaydesai2325@gmail.com";

    $subject = "New Contact Message from $name";

    $body = "You received a new message from your website:\n\n" .
            "Name: $name\n" .
            "Email: $email\n\n" .
            "Message:\n$message";

    // PROPER MAIL HEADERS
    $headers  = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // SEND EMAIL
    if (mail($to, $subject, $body, $headers)) {
        $success = "Your message has been sent successfully!";
    } else {
        $error = "Failed to send message. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {
        background-color: black;
        color: white;
        font-family: Arial;
    }

    h2 {
        color: rgba(238,0,20,0.86);
        text-shadow: 0 0 8px rgba(238,0,20,0.7);
    }

    .contact-box {
        background-color: #0a0a0a;
        border: 1px solid rgba(238,0,20,0.6);
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 40px;
    }

    .contact-info {
        background-color: #111;
        border: 1px solid rgba(238,0,20,0.6);
        padding: 20px;
        border-radius: 12px;
        height: 100%;
    }

    .icon {
        font-size: 30px;
        color: rgba(238,0,20,0.86);
        margin-right: 10px;
    }

    .btn-red {
        background-color: rgba(238,0,20,0.86);
        color: black;
        font-weight: bold;
    }

    .btn-red:hover {
        background-color: white;
        color: black;
    }

    input, textarea {
        background-color: #111;
        border: 1px solid rgba(255,0,0,0.4);
        color: white;
    }
</style>

<body>

<div class="container py-5">

    <div class="mb-4">
        <a href="index.php" class="btn btn-red">← Back</a>
    </div>

    <h2 class="text-center mb-5">Contact Us</h2>

    <div class="row">

        <!-- CONTACT FORM -->
        <div class="col-md-7">
            <div class="contact-box">

                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Your Name</label>
                        <input type="text" name="name" required class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your Email</label>
                        <input type="email" name="email" required class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your Message</label>
                        <textarea name="message" rows="5" required class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-red">Send Message</button>
                </form>
            </div>
        </div>

        <!-- CONTACT DETAILS -->
        <div class="col-md-5">
            <div class="contact-info">
                <h4 style="color:red;">Reach Us At</h4>

                <p><span class="icon">📍</span>Address: Binita park, Bardoli</p>
                <p><span class="icon">📞</span>Phone: +91 72018 83567</p>
                <p><span class="icon">✉️</span>Email: malaydesai2325@gmail.com</p>

                <h4 class="mt-4" style="color:red;">Follow Us</h4>

                <p><span class="icon">📸</span>Instagram: @_flyboyclothing_</p>
            </div>
        </div>

    </div>

</div>

</body>
</html>
