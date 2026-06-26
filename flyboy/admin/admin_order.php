<?php
include "connect.php";
session_start();

// OPTIONAL: Admin authentication (enable if needed)
// if (!isset($_SESSION['admin'])) {
//     header("Location: admin_login.php");
//     exit();
// }

// FETCH ALL ORDERS
$orders = $conn->query("
    SELECT * FROM orders ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body { background-color: black; color: white; font-family: Arial; }

    h2 { color: rgba(238,0,20,0.86); }

    .order-card {
        border: 1px solid rgba(238,0,20,0.6);
        padding: 20px;
        border-radius: 10px;
        background-color: #000;
        margin-bottom: 20px;
    }

    .btn-red {
        background-color: rgba(238,0,20,0.86);
        color: black;
        font-weight: bold;
    }
    .btn-red:hover {
        background-color:white;
        color:black;
    }

    .status-select {
        background-color: #111;
        color: white;
        border: 1px solid red;
        padding: 5px;
        border-radius: 5px;
    }

    .item-box {
        border: 1px solid rgba(255,0,0,0.3);
        background-color: #111;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .item-box img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 5px;
    }
</style>

<body>

<div class="container py-5">

    <h2 class="text-center mb-4">Admin - Order Management</h2>

    <div class="mb-3">
        <a href="dashboard.php" class="btn btn-red">← Back</a>
    </div>

    <?php while($order = $orders->fetch_assoc()): ?>

        <div class="order-card">

            <h4 style="color:red;">Order #<?= $order['id'] ?></h4>

            <p><b>Name:</b> <?= $order['fullname'] ?></p>
            <p><b>Phone:</b> <?= $order['phone'] ?></p>
            <p><b>Address:</b> <?= $order['address'] ?></p>
            <p><b>Payment:</b> <?= $order['payment'] ?></p>
            <p><b>Total:</b> ₹<?= $order['total'] ?></p>

            <!-- STATUS UPDATE -->
            <form action="update_order_status.php" method="POST" class="d-flex">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

                <select name="status" class="status-select me-3">
                    <?php 
                    $statuses = ["Pending","Processing","Shipped","Delivered","Cancelled"];
                    foreach($statuses as $s): ?>
                        <option value="<?= $s ?>" <?= ($order['status']==$s)?"selected":"" ?>>
                            <?= $s ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="btn btn-red">Update</button>
            </form>

            <hr style="border-color:red;">

            <!-- ORDER ITEMS -->
            <h5>Items:</h5>

            <?php
            $items = $conn->query("
                SELECT order_items.*, products.name, products.image 
                FROM order_items
                JOIN products ON products.id = order_items.product_id
                WHERE order_id = {$order['id']}
            ");
            ?>

            <?php while($it = $items->fetch_assoc()): ?>
                <div class="item-box d-flex align-items-center">
                    <img src="upload/<?= $it['image'] ?>">

                    <div class="ms-3">
                        <p><b><?= $it['name'] ?></b></p>
                        <p>Size: <?= strtoupper($it['size']) ?></p>
                        <p>Quantity: <?= $it['quantity'] ?></p>
                        <p>Price: ₹<?= $it['price'] ?></p>
                    </div>
                </div>
            <?php endwhile; ?>

            <!-- DELETE ORDER -->
            <form action="delete_order.php" method="POST" class="mt-3">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <button onclick="return confirm('Are you sure?')" 
                        class="btn btn-danger w-100">
                    Delete Order
                </button>
            </form>

        </div>

    <?php endwhile; ?>

</div>

</body>
</html>
