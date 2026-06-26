<?php
include "connect.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user_id'];

// Fetch all orders for this user
$orders = $conn->query("
    SELECT * FROM orders 
    WHERE user_id = $user
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body { background-color:black; color:white; font-family:Arial; }

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
    .btn-red:hover { background-color:white; color:black; }

    .status-box {
        padding: 8px 10px;
        border-radius: 5px;
        font-weight: bold;
        color:black;
        width: fit-content;
    }
    .Pending { background: yellow; }
    .Processing { background: #00b8ff; }
    .Shipped { background: orange; }
    .Delivered { background: #00ff62; }
    .Cancelled { background: red; color:white; }

    .item-box {
        border: 1px solid rgba(255,0,0,0.3);
        padding: 10px;
        border-radius: 10px;
        background-color: #111;
        margin-bottom: 10px;
    }

    .item-box img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius:5px;
    }
</style>

<body>

<div class="container py-5">

    <h2 class="text-center mb-4">My Orders</h2>

    <div class="mb-3">
        <a href="index.php" class="btn btn-red">← Back</a>
    </div>

    <?php if ($orders->num_rows == 0): ?>
        <p class="text-center" style="color:red;">You have no orders yet.</p>

    <?php else: ?>

        <?php while ($order = $orders->fetch_assoc()): ?>

            <div class="order-card">

                <h4 style="color:red;">Order #<?= $order['id'] ?></h4>

                <p><b>Date:</b> <?= $order['created_at'] ?></p>

                <p>
                    <b>Status:</b>
                    <span class="status-box <?= $order['status'] ?>">
                        <?= $order['status'] ?>
                    </span>
                </p>

                <p><b>Total:</b> ₹<?= $order['total'] ?></p>
                <p><b>Payment:</b> <?= $order['payment'] ?></p>

                <button class="btn btn-red mt-2" 
                        onclick="document.getElementById('items<?= $order['id'] ?>').classList.toggle('d-none')">
                    View Items
                </button>

                <a href="order_success.php?order_id=<?= $order['id'] ?>" 
                    class="btn btn-danger mt-2">
                    View Order Page
                </a>

                <!-- Order Items (Hidden by default) -->
                <div id="items<?= $order['id'] ?>" class="d-none mt-3">

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
                                <p>Qty: <?= $it['quantity'] ?></p>
                                <p>Price: ₹<?= $it['price'] ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php if ($order['status'] == 'Pending'): ?>
    <a href="cancel_order.php?order_id=<?= $order['id'] ?>" 
       class="btn btn-warning mt-2"
       onclick="return confirm('Are you sure you want to cancel this order?');">
        Cancel Order
    </a>
<?php endif; ?>

                </div>

            </div>

        <?php endwhile; ?>

    <?php endif; ?>

</div>

</body>
</html>
