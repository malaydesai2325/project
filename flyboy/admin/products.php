<?php
include "connect.php";
session_start();
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

$items = $conn->query("SELECT products.*, categories.category_name FROM products JOIN categories ON products.category_id = categories.id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>PRODUCTS</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
<h2 class="text-center mb-4">Manage Products</h2>
<a href="dashboard.php" class="btn btn-red">← Back</a>
<a href="add_product.php" class="btn btn-red mb-3">+ Add Product</a>
<table class="table table-dark table-bordered text-center">
    <tr>
        <th>ID</th><th>Name</th><th>Price</th><th>Category</th><th>Sizes & Stock</th><th>Image</th><th>Actions</th>
    </tr>
    <?php while($row=$items->fetch_assoc()):
        $sizes = $conn->query("SELECT * FROM product_sizes WHERE product_id=".$row['id'])->fetch_all(MYSQLI_ASSOC);
    ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td>₹<?= $row['price'] ?></td>
        <td><?= htmlspecialchars($row['category_name']) ?></td>
        <td>
            <?php if($sizes): foreach($sizes as $sz): ?>
                <span class="badge bg-info text-dark"><?= $sz['size'] ?> (<?= $sz['stock'] ?>)</span>
            <?php endforeach; else: ?>
                <span>No sizes</span>
            <?php endif; ?>
        </td>
        <td><img src="../upload/<?= $row['image'] ?>" width="60"></td>
        <td>
            <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
            <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</div>
</body>
</html>
