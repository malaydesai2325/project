<?php
include "connect.php";
session_start();

// Check admin login
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    die("Invalid category ID");
}

$id = intval($_GET['id']);

// Optional: Check if category has products before deleting
$stmt = $conn->prepare("SELECT id FROM products WHERE category_id=? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows > 0){
    die("Cannot delete category. It has products assigned!");
}

// Delete category
$stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
$stmt->bind_param("i", $id);
if($stmt->execute()){
    header("Location: categories.php?success=deleted");
    exit();
} else {
    die("Error deleting category: " . $conn->error);
}
?>
