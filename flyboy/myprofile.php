<?php
session_start();
require "connect.php"; // your DB connection

// Fake user data – replace with your actual session values
$user_id = $_SESSION['user_id'];
$query = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $query->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MY PRPFILE</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:black; color:white; }
.card { background:#111; border:1px solid red; }
.form-control { background:#000; color:white; border:1px solid red; }
.btn-red { background:red; color:white; }
.btn-red:hover { background:#ff3b3b; }
</style>

</head>

<body>


<div class="container mt-5">
        <div class="mb-3">
        <a href="index.php" class="btn btn-red">← Back</a>
    </div>
    <h2 class="text-center mb-4" style="color: #ff3b3b;">My Profile</h2>

    <div class="row">

        <!-- Profile Update -->
        <div class="col-md-6">
            <div class="card p-3">
                <h4 style="color:#ff3b3b;">Update Profile</h4>

                <form id="profileForm">

                    <input type="hidden" name="action" value="update_profile">

                    <div class="mb-3">
                        <label style="color:#fff;">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?= $user['name'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label style="color:#fff;">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label style="color:#fff;">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= $user['phone'] ?>" required>
                    </div>

                    <button type="button" class="btn btn-red mt-2" onclick="sendOtp('profile')">Send OTP</button>

                    <div id="profileOtpSection" style="display:none;">
                        <label class="mt-3">Enter OTP</label>
                        <input type="text" name="otp" class="form-control">
                        <button type="submit" class="btn btn-success mt-2">Verify & Update</button>
                    </div>

                </form>
            </div>
        </div>


        <!-- Change Password -->
        <div class="col-md-6">
            <div class="card p-3">
                <h4 style="color:#ff3b3b;">Change Password</h4>

                <form id="passwordForm">

                    <input type="hidden" name="action" value="change_password">

                    <div class="mb-3">
                        <label style="color:#fff;">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label style="color:#fff;">New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <button type="button" class="btn btn-red mt-2" onclick="sendOtp('password')">Send OTP</button>

                    <div id="passwordOtpSection" style="display:none;">
                        <label class="mt-3">Enter OTP</label>
                        <input type="text" name="otp" class="form-control">
                        <button type="submit" class="btn btn-success mt-2">Verify & Change</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>


<script>
function sendOtp(type) {
    fetch("send_otp.php?type=" + type)
        .then(res => res.text())
        .then(data => {
            alert(data);
            if (type === "profile") {
                document.getElementById("profileOtpSection").style.display = "block";
            } else {
                document.getElementById("passwordOtpSection").style.display = "block";
            }
        });
}

document.getElementById("profileForm").onsubmit = function(e) {
    e.preventDefault();
    fetch("update_profile.php", {
        method: "POST",
        body: new FormData(this)
    }).then(res => res.text()).then(alert);
}

document.getElementById("passwordForm").onsubmit = function(e) {
    e.preventDefault();
    fetch("update_profile.php", {
        method: "POST",
        body: new FormData(this)
    }).then(res => res.text()).then(alert);
}
</script>

</body>
</html>
