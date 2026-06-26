<?php
include "connect.php";
session_start();

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>LOGIN</title>
</head>
<style>
    body{
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: black;
        margin: 0;
        font-family: Arial, sans-serif;
    }

form {
    text-align: center;
    border-radius: 10px;
    border: 1px solid rgba(238, 0, 20, 0.86); /* fixed border syntax */
    background-color: #000;
    padding: 30px 40px;
}



    .txt{
        border: 2px solid rgba(238, 0, 20, 0.86);
        border-radius: 5px;
        background-color: black;
        color: rgba(238, 0, 20, 0.86);;
        margin: 10px 0;
        font-size: 16px;
        outline: none;
        transition: 0.3s;
    }

    .txt:focus{
        box-shadow: 0 0 10px rgba(238, 0, 20, 0.8);
    }
    .txt::placeholder {
        color: rgba(238, 0, 20, 0.86);  /* neon red placeholder */
        opacity: 1; /* ensures full opacity in some browsers */
        
    }

    .btn{
        border: 2px solid rgba(238, 0, 20, 0.86);
        border-radius: 5px;
        padding: 8px 20px;
        margin-top: 10px;
        font-size: 18px;
        background-color: black;
        color: rgba(238, 0, 20, 0.86);
        cursor: pointer;
        transition: 0.3s;
    }

    .btn:hover{
        background-color: rgba(238, 0, 20, 0.86);
        color: black;
    }
</style>
<body>

<div class="container py-5">

    <form method="POST" class="mx-auto" style="max-width:400px;">
        <h2 class="text-center" style="color: rgba(238, 0, 20, 0.86); margin-bottom:10px ;">Login</h2>
        <input class="form-control mb-3 txt" type="email" name="email" placeholder="Email" required>
        <input class="form-control mb-3 txt" type="password" name="password" placeholder="Password" required>

        <button class="btn btn-red w-100" name="login">Login</button><br>
        <a href="signup.php" style="color: rgba(238, 0, 20, 0.86);text-decoration: 0;">create a new account?</a><br>
        <a href="forget_password.php" style="color: rgba(238, 0, 20, 0.86);text-decoration: 0;">forget password?</a>
    </form>
</div>

</body>
</html>
