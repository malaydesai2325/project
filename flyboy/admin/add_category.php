<?php
include "connect.php"; // Your database connection
session_start();

// Check if admin is logged in
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

if(isset($_POST['add_category'])){
    $name = trim($_POST['name']);

    if(empty($name)){
        $error = "Category name cannot be empty!";
    } else {
        // Check if category already exists
        $stmt = $conn->prepare("SELECT id FROM categories WHERE category_name=? LIMIT 1");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $error = "Category already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
            $stmt->bind_param("s", $name);
            if($stmt->execute()){
                $success = "Category added successfully!";
            } else {
                $error = "Error adding category: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ADD CATEGORIES</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5" style="max-width:500px;">
    <h2>Add Category</h2>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <a href="categories.php" class="btn btn-red">← Back</a>
        <input type="text" name="name" class="form-control mb-3" placeholder="Category Name" required>
        <button name="add_category" class="btn btn-red w-100">Add Category</button>
    </form>

    <a href="categories.php" class="btn btn-secondary mt-3">Back to Categories</a>
</div>
</body>
</html>
