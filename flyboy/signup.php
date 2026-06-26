<?php
include "connect.php";

if(isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone=$_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password,phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $pass, $phone);

    if ($stmt->execute()) {
        header("Location: login.php");
    } else {
        $error = "Email already exists!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SIGNUP</title>
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

    form{
        text-align: center;
        border-radius: 10px;
        border: 1px solid rgba(238, 0, 20, 0.86);
        background-color: #000;
        padding: 30px 40px;
        border-color: rgba(238, 0, 20, 0.86);
    }


    .txt{
        border: 2px solid rgba(238, 0, 20, 0.86);
        border-radius: 5px;
        background-color: black;
        color: rgba(238, 0, 20, 0.86);
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
        <h2 class="text-center" style="color: rgba(238, 0, 20, 0.86);">Create Account</h2>
        <input class="form-control mb-3 txt" type="text" name="name" placeholder="Full Name" required>
        <input class="form-control mb-3 txt" type="email" name="email" placeholder="Email" required>
        <input class="form-control mb-3 txt" type="password" name="password" placeholder="Password" required>
        <input class="form-control mb-3 txt" type="phone" name="phone" placeholder="Phone" required>

        <button class="btn btn-red w-100" name="signup">Sign Up</button><br>
        <a href="login.php" style="color: rgba(238, 0, 20, 0.86);text-decoration: 0;">Already a customer?</a>
    </form>
</div>

</body>
</html>
