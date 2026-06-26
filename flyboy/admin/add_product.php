<?php
include "connect.php";
session_start();
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

$cats = $conn->query("SELECT * FROM categories");
$allSizes = ['S','M','L','XL'];

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $cat = $_POST['category'];
    $desc = $_POST['description'];

    // Image upload
    $img = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$img);

    // Insert product
    $stmt = $conn->prepare("INSERT INTO products (name, price, category_id, description, image) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sdiss", $name, $price, $cat, $desc, $img);
    $stmt->execute();
    $product_id = $stmt->insert_id;

    // Insert sizes with stock
    if(isset($_POST['sizes'])){
        foreach($_POST['sizes'] as $s){
            $stock = (int)$_POST['stock_'.$s];
            $stmt2 = $conn->prepare("INSERT INTO product_sizes (product_id, size, stock) VALUES (?,?,?)");
            $stmt2->bind_param("isi", $product_id, $s, $stock);
            $stmt2->execute();
        }
    }

    header("Location: products.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ADD PRODUCT</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
<h2>Add Product</h2>
<form method="POST" enctype="multipart/form-data">
    <a href="products.php" class="btn btn-red">← Back</a>
    <input type="text" name="name" placeholder="Product Name" class="form-control mb-2" required>
    <input type="number" name="price" placeholder="Price" class="form-control mb-2" required>
    <select name="category" class="form-control mb-2" required>
        <option disabled selected>Select Category</option>
        <?php while($c = $cats->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>"><?= $c['category_name'] ?></option>
        <?php endwhile; ?>
    </select>
    <textarea name="description" placeholder="Description" class="form-control mb-2"></textarea>
    <label>Product Image</label>
    <input type="file" name="image" class="form-control mb-2" required>

    <label>Sizes & Stock</label><br>
    <?php foreach($allSizes as $s): ?>
        <input type="checkbox" name="sizes[]" value="<?= $s ?>"> <?= $s ?>
        <input type="number" name="stock_<?= $s ?>" placeholder="Stock for <?= $s ?>" min="0" class="mb-2"><br>
    <?php endforeach; ?>

    <button class="btn btn-red w-100" name="add">Add Product</button>
</form>
</div>
</body>
</html>
