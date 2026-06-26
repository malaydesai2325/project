<?php
include "connect.php";
session_start();

if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>DASHBOARD</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container py-5">

    <h1 class="text-center mb-4" style="color:rgba(238,0,20,0.86);">Admin Dashboard</h1>

    <div class="text-center">
        <a href="products.php" class="btn btn-red m-2">Manage Products</a>
        <a href="categories.php" class="btn btn-red m-2">Manage Categories</a>
        <a href="admin_order.php" class="btn btn-red m-2">Manage Orders</a>
        <a href="logout.php" class="btn btn-danger m-2">Logout</a>
    </div>

</div>

</body>
</html>
