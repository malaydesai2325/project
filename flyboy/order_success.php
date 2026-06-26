<?php
include "connect.php";
session_start();

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order
$order = $conn->query("SELECT * FROM orders WHERE id = $order_id")->fetch_assoc();

// If order deleted in admin → show message + redirect
if (!$order) {
    echo "<script>
        alert('This order no longer exists.');
        window.location='index.php';
    </script>";
    exit();
}

// Fetch order items
$items = $conn->query("
    SELECT order_items.*, products.name, products.image
    FROM order_items
    JOIN products ON products.id = order_items.product_id
    WHERE order_id = $order_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Status</title>
    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
</head>

<style>
    body { background-color:black; color:white; font-family:Arial; }
    .success-box {
        border: 1px solid red;
        padding: 20px;
        border-radius: 10px;
        background-color: #000;
    }
    h2 { color: rgba(238,0,20,0.86); }
    .btn-red {
        background-color: rgba(238,0,20,0.86);
        color: black;
        font-weight: bold;
    }
    .btn-red:hover { background-color: white; color:black; }
    .item-card {
        border: 1px solid rgba(255,0,0,0.4);
        padding: 10px;
        border-radius: 10px;
        background-color: #111;
    }
    .item-card img {
        width: 80px;
        height: 80px;
        object-fit:cover;
        border-radius:5px;
    }
    .status-box {
        padding: 8px;
        border-radius: 5px;
        font-weight: bold;
        color:black;
        width: fit-content;
    }
    .Pending { background-color: yellow; }
    .Processing { background-color: #00b8ff; }
    .Shipped { background-color: orange; }
    .Delivered { background-color: #00ff62; }
    .Cancelled { background-color: red; color:white; }
</style>

<body>

<div class="container py-5">

    <h2 class="text-center mb-4">Order Details</h2>

    <div class="success-box mb-4">
        <h4 style="color:red;">Order ID: #<?= $order['id'] ?></h4>

        <!-- SHOW ORDER STATUS -->
        <p>
            <b>Status:</b> 
            <span class="status-box <?= $order['status'] ?>">
                <?= $order['status'] ?>
            </span>
        </p>

        <p><b>Name:</b> <?= $order['fullname'] ?></p>
        <p><b>Phone:</b> <?= $order['phone'] ?></p>
        <p><b>Address:</b> <?= $order['address'] ?></p>
        <p><b>Payment Method:</b> <?= $order['payment'] ?></p>
        <p><b>Total Paid:</b> ₹<?= $order['total'] ?></p>
    </div>

    <h4 style="color:red;">Items Ordered</h4>

    <?php while($row = $items->fetch_assoc()): ?>
        <div class="item-card d-flex align-items-center mb-3">
            <img src="upload/<?= $row['image'] ?>">
            <div class="ms-3">
                <h5><?= $row['name'] ?></h5>
                <p>Size: <?= strtoupper($row['size']) ?></p>
                <p>Quantity: <?= $row['quantity'] ?></p>
                <p>Price: ₹<?= $row['price'] ?></p>
            </div>
        </div>
    <?php endwhile; ?>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-red">Continue Shopping</a>
    </div>

</div>

</body>
</html>
