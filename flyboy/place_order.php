<?php
include "connect.php";
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout.php");
    exit();
}

$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$payment = $_POST['payment'];

// FETCH CART ITEMS AGAIN (SAFETY CHECK)
$items = $conn->query("
    SELECT 
        cart_items.*, 
        products.price, 
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

    // ===========================================================
    // FIXED STOCK LOGIC
    //
    // 1. If stock >= cart qty → allow
    // 2. If stock == 0 → allow (customer added earlier)
    // 3. If stock > 0 but LESS than cart qty → BLOCK
    // ===========================================================

    if ($row['size_stock'] < $row['quantity']) {

        // Block ONLY when stock is positive but insufficient
        if ($row['size_stock'] > 0) {
            echo "<script>
                alert('Some items do not have enough stock left.');
                window.location='cart.php';
            </script>";
            exit();
        }

        // If stock is exactly 0 → allow order (item was in cart earlier)
        if ($row['size_stock'] == 0) {
            // allowed
        }
    }

    // Add to checkout memory
    $cartData[] = $row;
    $total += $row['price'] * $row['quantity'];
}

if (empty($cartData)) {
    header("Location: cart.php");
    exit();
}

// INSERT ORDER INTO DATABASE
$stmt = $conn->prepare("
    INSERT INTO orders (user_id, fullname, phone, address, payment, total)
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("issssd", $user, $fullname, $phone, $address, $payment, $total);
$stmt->execute();

$order_id = $stmt->insert_id;

// INSERT ORDER ITEMS + REDUCE STOCK
foreach ($cartData as $item) {

    // Insert items into order_items
    $stmt2 = $conn->prepare("
        INSERT INTO order_items (order_id, product_id, size, quantity, price)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt2->bind_param("iisid", 
        $order_id, 
        $item['product_id'], 
        $item['size'], 
        $item['quantity'], 
        $item['price']
    );
    $stmt2->execute();

    // Reduce stock (only if stock was above 0)
    $conn->query("
        UPDATE product_sizes 
        SET stock = GREATEST(stock - {$item['quantity']}, 0)
        WHERE product_id = {$item['product_id']}
        AND size = '{$item['size']}'
    ");
}

// CLEAR USER CART
$conn->query("DELETE FROM cart_items WHERE user_id = $user");

// REDIRECT TO SUCCESS PAGE
header("Location: order_success.php?order_id=" . $order_id);
exit();
?>
