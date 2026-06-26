<?php
session_start(); // ✅ Must start session first
include "connect.php";

if(isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();

    if ($admin) {
        // If passwords are hashed in DB
        if(password_verify($pass, $admin['password'])){
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: dashboard.php");
            exit();
        } 
        // If passwords are stored as plain text
        else if($pass === $admin['password']){
             $_SESSION['admin_id'] = $admin['id'];
             header("Location: dashboard.php");
             exit();
         }
        else {
            $error = "Invalid credentials!";
        }
    } else {
        $error = "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ADMIN LOGIN</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container py-5" style="max-width:400px;">
    <h2 class="text-center">Admin Login</h2>

    <?php if(isset($error)): ?>
        <p class="text-danger text-center"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input class="form-control mb-3" type="text" name="username" placeholder="Username" required>
        <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>

        <button name="login" class="btn btn-red w-100">Login</button>
    </form>
</div>

</body>
</html>
