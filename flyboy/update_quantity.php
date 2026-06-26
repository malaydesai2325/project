<?php
include "connect.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    die("LOGIN_REQUIRED");
}

$user = $_SESSION['user_id'];
$product = $_POST['product_id'];
$size = $_POST['size'];
$newQty = intval($_POST['quantity']);

if ($newQty <= 0) {
    die("INVALID_QTY");
}

// 1. GET CURRENT CART QUANTITY
$cartQ = $conn->query("
    SELECT quantity 
    FROM cart_items
    WHERE user_id = $user AND product_id = $product AND size = '$size'
");

if ($cartQ->num_rows == 0) {
    die("NOT_FOUND");
}

$cartRow = $cartQ->fetch_assoc();
$currentQty = intval($cartRow['quantity']);

// 2. GET AVAILABLE STOCK FOR THAT SIZE
$stockQ = $conn->query("
    SELECT stock 
    FROM product_sizes
    WHERE product_id = $product AND size = '$size'
");

$stockRow = $stockQ->fetch_assoc();
$availableStock = intval($stockRow['stock']);

// If increasing quantity
if ($newQty > $currentQty) {

    $needed = $newQty - $currentQty;

    if ($needed > $availableStock) {
        echo "MAX_REACHED";
        exit;
    }

    // Reduce stock
    $conn->query("
        UPDATE product_sizes
        SET stock = stock - $needed
        WHERE product_id = $product AND size = '$size'
    ");
}

// If decreasing quantity
else if ($newQty < $currentQty) {

    $returnQty = $currentQty - $newQty;

    // Return stock back
    $conn->query("
        UPDATE product_sizes
        SET stock = stock + $returnQty
        WHERE product_id = $product AND size = '$size'
    ");
}

// Update final cart quantity
$conn->query("
    UPDATE cart_items
    SET quantity = $newQty
    WHERE user_id = $user AND product_id = $product AND size = '$size'
");

echo "SUCCESS";
?>
