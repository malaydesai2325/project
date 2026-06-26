<?php
include "connect.php";
session_start();

$order_id = $_POST['order_id'];
$status = $_POST['status'];

$conn->query("
    UPDATE orders SET status='$status'
    WHERE id=$order_id
");

header("Location: admin_order.php");
?>
