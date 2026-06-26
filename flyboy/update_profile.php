<?php
session_start();
require "connect.php";

$action = $_POST['action'];
$otp = $_POST['otp'];

if ($otp != $_SESSION['otp']) {
    die("Invalid OTP!");
}

$user_id = $_SESSION['user_id'];

if ($action === "update_profile") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $conn->query("UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id=$user_id");

    unset($_SESSION['otp']);
    echo "Profile Updated Successfully!";
}

if ($action === "change_password") {

    $cur = $_POST['current_password'];
    $new = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $q = $conn->query("SELECT password FROM users WHERE id=$user_id");
    $dbpass = $q->fetch_assoc()['password'];

    if (!password_verify($cur, $dbpass)) {
        die("Incorrect current password!");
    }

    $conn->query("UPDATE users SET password='$new' WHERE id=$user_id");

    unset($_SESSION['otp']);
    echo "Password Changed Successfully!";
}
?>
