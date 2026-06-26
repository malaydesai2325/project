<?php
include "connect.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user_id'];

// Validate order id
if (!isset($_GET['order_id'])) {
    header("Location: my_order.php");
    exit();
}

$order_id = intval($_GET['order_id']);

// Check if this order belongs to the user and is pending
$check = $conn->query("
    SELECT * FROM orders 
    WHERE id = $order_id AND user_id = $user AND status = 'Pending'
");

if ($check->num_rows == 0) {
    // Order cannot be canceled
    header("Location: my_orders.php");
    exit();
}

// Cancel the order
$conn->query("
    UPDATE orders 
    SET status = 'Cancelled' 
    WHERE id = $order_id
");

header("Location: my_order.php?cancelled=1");
exit();
?>
