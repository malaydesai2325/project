<?php
include "connect.php";
session_start();

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "LOGIN_REQUIRED"]);
    exit;
}

$user = $_SESSION['user_id'];
$product = $_POST['product_id'] ?? 0;
$size = $_POST['size'] ?? "";

if ($product == 0 || $size == "") {
    echo json_encode(["status" => "INVALID_DATA"]);
    exit;
}

// 1. Get quantity from cart
$cartQ = $conn->query("
    SELECT quantity 
    FROM cart_items 
    WHERE user_id = $user AND product_id = $product AND size = '$size'
");

if ($cartQ->num_rows == 0) {
    echo json_encode(["status" => "NOT_FOUND"]);
    exit;
}

$cartRow = $cartQ->fetch_assoc();
$qty = intval($cartRow['quantity']);

// 2. Restore this quantity into product_sizes
$conn->query("
    UPDATE product_sizes
    SET stock = stock + $qty
    WHERE product_id = $product AND size = '$size'
");

// 3. Get updated stock value
$result = $conn->query("
    SELECT stock FROM product_sizes
    WHERE product_id = $product AND size = '$size'
");
$stockRow = $result->fetch_assoc();
$restoredStock = intval($stockRow['stock']);

// 4. Delete item from cart
$conn->query("
    DELETE FROM cart_items
    WHERE user_id = $user AND product_id = $product AND size = '$size'
");

// 5. Return JSON response
echo json_encode([
    "status" => "SUCCESS",
    "product" => $product,
    "size" => $size,
    "stock" => $restoredStock
]);

?>
