<?php include "connect.php";
session_start();

if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); }

$categories = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
    <title>CATEGORIES</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container py-5">
    <h2 class="text-center mb-4">Manage Categories</h2>
    <a href="dashboard.php" class="btn btn-red">← Back</a>
    <a href="add_category.php" class="btn btn-red mb-3">+ Add Category</a>

    <table class="table table-dark table-bordered">
        <tr class="text-center">
            <th>ID</th><th>Category Name</th><th>Actions</th>
        </tr>

        <?php while($c = $categories->fetch_assoc()): ?>
        <tr class="text-center">
            <td><?= $c['id'] ?></td>
            <td><?= $c['category_name'] ?></td>
            <td>
                <a href="delete_category.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
