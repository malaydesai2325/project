<?php
include "connect.php";
session_start();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Product ID");
}

$id = intval($_GET['id']);

// 1️⃣ Delete product from carts first (or other dependent tables)
$conn->query("DELETE FROM cart_items WHERE product_id=$id");

// 2️⃣ Delete the product
$stmt = $conn->prepare("DELETE FROM products WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: products.php");
    exit();
} else {
    die("Error deleting product: " . $conn->error);
}
?>
