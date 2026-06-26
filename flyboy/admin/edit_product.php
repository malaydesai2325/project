<?php
include "connect.php";
session_start();
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
$cats = $conn->query("SELECT * FROM categories");
$sizes_db = $conn->query("SELECT * FROM product_sizes WHERE product_id=$id")->fetch_all(MYSQLI_ASSOC);
$allSizes = ['S','M','L','XL'];

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $desc = $_POST['description'];

    $img = $product['image'];
    if($_FILES['image']['name'] != ""){
        $img = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$img);
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, category_id=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("sdissi", $name, $price, $category, $desc, $img, $id);
    $stmt->execute();

    // Update product sizes
    $conn->query("DELETE FROM product_sizes WHERE product_id=$id"); // remove old sizes
    if(isset($_POST['sizes'])){
        foreach($_POST['sizes'] as $s){
            $stock = (int)$_POST['stock_'.$s];
            $stmt2 = $conn->prepare("INSERT INTO product_sizes (product_id, size, stock) VALUES (?,?,?)");
            $stmt2->bind_param("isi", $id, $s, $stock);
            $stmt2->execute();
        }
    }

    header("Location: products.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>EDIT PRODUCT</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
<h2>Edit Product</h2>
<form method="POST" enctype="multipart/form-data">
    <a href="products.php" class="btn btn-red">← Back</a>
    <input type="text" name="name" class="form-control mb-2" value="<?= $product['name'] ?>" required>
    <input type="number" name="price" class="form-control mb-2" value="<?= $product['price'] ?>" required>
    <select name="category" class="form-control mb-2" required>
        <?php while($c = $cats->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>" <?= $product['category_id']==$c['id']?'selected':'' ?>><?= $c['category_name'] ?></option>
        <?php endwhile; ?>
    </select>
    <textarea name="description" class="form-control mb-2"><?= $product['description'] ?></textarea>
    <label>Replace Image (optional)</label>
    <input type="file" name="image" class="form-control mb-2">

    <label>Sizes & Stock</label><br>
    <?php foreach($allSizes as $s):
        $stock = 0;
        foreach($sizes_db as $sz){ if($sz['size']==$s) $stock=$sz['stock']; }
    ?>
        <input type="checkbox" name="sizes[]" value="<?= $s ?>" <?= $stock>0?'checked':'' ?>> <?= $s ?>
        <input type="number" name="stock_<?= $s ?>" value="<?= $stock ?>" min="0"><br>
    <?php endforeach; ?>

    <button class="btn btn-red w-100" name="update">Update Product</button>
</form>
</div>
</body>
</html>
