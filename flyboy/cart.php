<?php 
include "connect.php"; 
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user_id'];


// FETCH CART ITEMS WITH REAL STOCK FOR THAT SIZE
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
    <title>YOUR CART</title>
</head>

<style>
    body { background-color: black; font-family: Arial; color: white; }

    h2 { color: rgba(238,0,20,0.86); }

    .cart-card {
        background-color: #000;
        border: 1px solid rgba(238,0,20,0.6);
        border-radius: 10px;
        padding: 15px;
        transition: 0.3s;
    }

    .cart-card img {
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

    .quantity-input {
        width: 60px;
        text-align: center;
        padding: 4px;
    }
</style>

<body>

<div class="container py-5">
    <h2 class="text-center mb-4">Your Cart</h2>

    <div class="mb-3">
        <a href="index.php" class="btn btn-red">← Back</a>
    </div>

    <?php if(empty($cartData)): ?>
        <p class="text-center" style="color: red;">Your cart is empty.</p>

    <?php else: ?>
        <?php foreach($cartData as $row): ?>
        <div class="cart-card mb-3 p-3 d-flex align-items-center">
            
            <img src="upload/<?= htmlspecialchars($row['image']) ?>">

            <div class="ms-3 flex-grow-1">

                <h5><?= htmlspecialchars($row['name']) ?></h5>
                <p>Price: ₹<?= htmlspecialchars($row['price']) ?></p>

                <!-- SIZE DISPLAY -->
                <p>Size: <span style="color:red;"><?= strtoupper(htmlspecialchars($row['size'])) ?></span></p>

                <!-- CORRECT STOCK BASED ON SIZE -->
                <p>Available Stock: <?= htmlspecialchars($row['size_stock']) ?></p>

                <p>Quantity:
                    <input 
                        type="number" 
                        class="quantity-input"
                        min="1" 
                        max="<?= $row['size_stock'] ?>"
                        value="<?= $row['quantity'] ?>"
                        data-id="<?= $row['product_id'] ?>"
                        data-size="<?= $row['size'] ?>">
                </p>

                <p>Subtotal: ₹<span class="subtotal"><?= $row['price'] * $row['quantity'] ?></span></p>
            </div>

            <div class="d-flex flex-column align-items-end">
                <button 
                    class="btn btn-danger delete mb-2" 
                    data-id="<?= $row['product_id'] ?>"
                    data-size="<?= $row['size'] ?>">
                    Remove
                </button>
            </div>

        </div>
        <?php endforeach; ?>

        <div class="total-box text-end">
            Total: ₹<span id="total"><?= $total ?></span>
        </div>

        <div class="text-end mt-3">
            <a href="checkout.php" class="btn btn-red">Checkout</a>
        </div>

    <?php endif; ?>

</div>

<script>
// DELETE ITEM (product + size)
document.querySelectorAll(".delete").forEach(btn => {
    btn.onclick = () => {

        let fd = new FormData();
        fd.append("product_id", btn.dataset.id);
        fd.append("size", btn.dataset.size);

        fetch("delete_item.php", { method: "POST", body: fd })
        .then(res => res.text())
        .then(d => location.reload());
    };
});

localStorage.setItem("stockUpdated", JSON.stringify(res));

// UPDATE QUANTITY (product + size)
document.querySelectorAll(".quantity-input").forEach(input => {
    input.onchange = () => {

        let qty = parseInt(input.value);
        let product_id = input.dataset.id;
        let size = input.dataset.size;

        if (qty < 1) qty = 1;

        fetch("update_quantity.php", {
            method: "POST",
            body: new URLSearchParams({ product_id, size, quantity: qty })
        })
        .then(res => res.text())
        .then(d => {
            if (d.trim() === "MAX_REACHED") {
                alert("Cannot exceed available stock!");
            }
            location.reload();
        });
    };
});
</script>

</body>
</html>
