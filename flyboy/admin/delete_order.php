<?php
include "connect.php";
session_start();

$order_id = $_POST['order_id'];

// Delete order items first
$conn->query("DELETE FROM order_items WHERE order_id = $order_id");

// Then delete order
$conn->query("DELETE FROM orders WHERE id = $order_id");

header("Location: admin_order.php");
?>
