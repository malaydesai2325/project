<?php
include "connect.php";
session_start();

header("Content-Type: application/json");

// Must be logged in
if(!isset($_SESSION['user_id'])){
    echo json_encode(["status" => "LOGIN_REQUIRED"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);
$size = $_POST['size'];

// Check stock
$check = $conn->query("
    SELECT stock 
    FROM product_sizes 
    WHERE product_id = $product_id AND size = '$size'
");

$row = $check->fetch_assoc();

if(!$row || $row['stock'] <= 0){
    echo json_encode(["status" => "OUT_OF_STOCK"]);
    exit;
}

// Deduct 1 stock
$conn->query("
    UPDATE product_sizes 
    SET stock = stock - 1 
    WHERE product_id = $product_id AND size = '$size'
");

// Check if item already exists in cart
$check_cart = $conn->query("
    SELECT id, quantity 
    FROM cart_items 
    WHERE user_id = $user_id AND product_id = $product_id AND size = '$size'
");

if($check_cart->num_rows > 0){
    $conn->query("
        UPDATE cart_items 
        SET quantity = quantity + 1 
        WHERE user_id = $user_id AND product_id = $product_id AND size = '$size'
    ");
} else {
    $conn->query("
        INSERT INTO cart_items (user_id, product_id, size, quantity) 
        VALUES ($user_id, $product_id, '$size', 1)
    ");
}

echo json_encode(["status" => "SUCCESS"]);
?>
