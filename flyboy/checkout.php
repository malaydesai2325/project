<?php
include "connect.php";
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user_id'];

// FETCH CART ITEMS WITH SIZE STOCK
$items = $conn->query("
    SELECT 
        cart_items.*, 
        products.name, 
        products.price, 
        products.image,
        product_sizes.stock AS size_stock
    FROM cart_items
    JOIN products ON products.id = cart_items.product_id
    JOIN product_sizes ON product_sizes.product_id = cart_items.product_id
                        AND product_sizes.size = cart_items.size
    WHERE cart_items.user_id = $user
");

$cartData = [];
$total = 0;

while($row = $items->fetch_assoc()){
    $total += $row['price'] * $row['quantity'];
    $cartData[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Checkout</title>
</head>

<style>
    body { background-color: black; font-family: Arial; color: white; }

    h2 { color: rgba(238,0,20,0.86); }

    .checkout-card {
        background-color: #000;
        border: 1px solid rgba(238,0,20,0.6);
        border-radius: 10px;
        padding: 15px;
        transition: 0.3s;
    }

    .checkout-card img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border: 1px solid rgba(255,0,0,0.4);
        border-radius: 5px;
    }

    .btn-red {
        background-color: rgba(238,0,20,0.86);
        color: black;
        font-weight: bold;
    }

    .btn-red:hover { background-color: white; color: black; }

    .total-box {
        border: 1px solid rgba(238,0,20,0.6);
        padding: 20px;
        border-radius: 10px;
        background-color: #000;
        color: red;
        font-weight: bold;
    }

    .input-dark {
        background-color: #111;
        border: 1px solid red;
        color: white;
    }
</style>

<body>

<div class="container py-5">

    <h2 class="text-center mb-4">Checkout</h2>

    <div class="mb-3">
        <a href="cart.php" class="btn btn-red">← Back to Cart</a>
    </div>

    <?php if(empty($cartData)): ?>
        <p class="text-center" style="color:red;">Your cart is empty.</p>

    <?php else: ?>

    <!-- ORDER SUMMARY -->
    <h4 style="color:red;">Order Summary</h4>
    <?php foreach($cartData as $row): ?>
    <div class="checkout-card mb-3 p-3 d-flex align-items-center">

        <img src="upload/<?= htmlspecialchars($row['image']) ?>">

        <div class="ms-3 flex-grow-1">
            <h5><?= htmlspecialchars($row['name']) ?></h5>
            <p>Size: <b style="color:red;"><?= strtoupper(htmlspecialchars($row['size'])) ?></b></p>
            <p>Quantity: <?= $row['quantity'] ?></p>
            <p>Price: ₹<?= $row['price'] ?></p>
            <p>Subtotal: <span style="color:red;">₹<?= $row['price'] * $row['quantity'] ?></span></p>
        </div>

    </div>
    <?php endforeach; ?>

    <div class="total-box text-end">
        Total Payable: ₹<span id="total"><?= $total ?></span>
    </div>

    <!-- SHIPPING FORM -->
    <h4 class="mt-4" style="color:red;">Shipping Information</h4>

    <form action="place_order.php" method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="fullname" required class="form-control input-dark">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="phone" name="phone" required class="form-control input-dark">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" required class="form-control input-dark"></textarea>
        </div>

        <h4 class="mt-4" style="color:red;">Payment Method</h4>

        <div class="mb-3">
            <input type="radio" name="payment" value="COD" checked> Cash on Delivery <br>
            <input type="radio" name="payment" value="ONLINE"> Online Payment
        </div>

        <button type="submit" class="btn btn-red w-100 mt-3">Place Order</button>

    </form>

    <?php endif; ?>

</div>

</body>
</html>
