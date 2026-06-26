<?php 
include "connect.php"; 
session_start();

// Get selected category
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");

// Fetch products
if($category_id > 0){
    $items = $conn->query("SELECT * FROM products WHERE category_id = $category_id");
} else {
    $items = $conn->query("SELECT * FROM products");
}

// Get cart count
$cart_count = 0;
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $result = $conn->query("SELECT SUM(quantity) AS count FROM cart_items WHERE user_id = $user_id");
    $row = $result->fetch_assoc();
    $cart_count = $row['count'] ?? 0;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>PRODUCTS</title>

    <style>
        body { background-color: black; font-family: Arial; }
        h2 { color: rgba(238,0,20,0.86); }

        .product-card {
            background-color: #000;
            border: 1px solid rgba(238,0,20,0.6);
            transition: 0.3s;
            border-radius: 10px;
        }
        .product-card:hover { transform: scale(1.03); }

        .product-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        /* Normal red button */
        .btn-red {
            background-color: rgba(238,0,20,0.86);
            color: black;
            font-weight: bold;
            border: 1px solid rgba(238,0,20,0.6);
        }
        .btn-red:hover {
            background-color: white;
            color: black;
        }

        /* Black + red theme for selected buttons */
        .selected-style,
        .btn-red.active,
        .btn-red:active,
        .btn-red:focus {
            background-color: black !important;
            color: red !important;
            border: 2px solid red !important;
            font-weight: bold !important;
        }

        .size-btn {
            padding: 5px 12px;
            margin: 3px;
            background: #ddd;
            border: 1px solid #333;
            cursor: pointer;
        }

        .size-btn.disabled {
            background-color: #555;
            color: #999;
            cursor: not-allowed;
        }

        /* Size selected style */
        .size-btn.selected {
            background-color: black !important;
            color: red !important;
            border: 2px solid red !important;
            font-weight: bold;
        }

        /* Add-to-cart selected style */
        .add-to-cart.selected {
            background-color: black !important;
            color: red !important;
            border: 2px solid red !important;
        }

        #toast {
            position: fixed;
            right: 20px;
            bottom: 20px;
            background: rgba(238,0,20,0.95);
            color: white;
            padding: 14px 20px;
            border-radius: 8px;
            display: none;
            opacity: 0;
            transform: translateY(50px);
            transition: opacity .4s, transform .4s;
        }
        #toast.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        #cart-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 28px;
            color: red;
            cursor: pointer;
        }
        #cart-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background: yellow;
            color: black;
            border-radius: 50%;
            width: 22px; 
            height: 22px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>

<div id="cart-icon">
    🛒
    <div id="cart-count"><?= $cart_count ?></div>
</div>

<div class="container py-5">

    <a href="index.php" class="btn btn-red">← Back</a>

    <div class="mb-4 mt-3">
        <a href="men.php" class="btn btn-red <?= $category_id == 0 ? 'active' : '' ?>">All</a>

        <?php while($cat = $categories->fetch_assoc()): ?>
            <a href="men.php?category=<?= $cat['id'] ?>" 
               class="btn btn-red <?= $category_id == $cat['id'] ? 'active' : '' ?>">
                <?= htmlspecialchars($cat['category_name']) ?>
            </a>
        <?php endwhile; ?>
    </div>

    <div class="row g-4">

        <?php while($row = $items->fetch_assoc()): ?>
            <?php
            $product_id = $row['id'];
            $sizes = $conn->query("SELECT size, stock FROM product_sizes WHERE product_id = $product_id");
            ?>

            <div class="col-md-3">
                <div class="product-card p-2">

                    <img src="upload/<?= htmlspecialchars($row['image']) ?>" class="product-img">

                    <h6 class="text-danger mt-2"><?= htmlspecialchars($row['name']) ?></h6>
                    <p class="text-danger">₹<?= htmlspecialchars($row['price']) ?></p>

                    <div class="sizes-container" data-product-id="<?= $product_id ?>">
                        <?php while($sz = $sizes->fetch_assoc()): ?>
                            <button
                                class="size-btn <?= $sz['stock'] == 0 ? 'disabled' : '' ?>"
                                data-size="<?= $sz['size'] ?>"
                                data-stock="<?= $sz['stock'] ?>"
                                <?= $sz['stock'] == 0 ? 'disabled' : '' ?>
                            >
                                <?= strtoupper($sz['size']) ?> <?= $sz['stock'] == 0 ? "(Out)" : "" ?>
                            </button>
                        <?php endwhile; ?>
                    </div>

                    <button class="btn btn-red w-100 mt-2 add-to-cart" data-id="<?= $product_id ?>">
                        Add to Cart
                    </button>

                </div>
            </div>

        <?php endwhile; ?>
    </div>
</div>

<div id="toast"></div>

<script>
function showToast(msg){
    const toast=document.getElementById("toast");
    toast.textContent=msg;
    toast.classList.add("show");
    setTimeout(()=>toast.classList.remove("show"),1800);
}

function updateCartCount(delta=1){
    const c=document.getElementById("cart-count");
    c.textContent=parseInt(c.textContent)+delta;
}

document.querySelectorAll('.sizes-container').forEach(container => {

    let selectedSize=null;
    const productId = container.dataset.productId;

    const sizeBtns = container.querySelectorAll('.size-btn');
    const addBtn = container.closest('.product-card').querySelector('.add-to-cart');

    // Disable add button if no sizes available
    if([...sizeBtns].every(b => b.classList.contains("disabled"))){
        addBtn.disabled = true;
        addBtn.textContent="Out of Stock";
    }

    sizeBtns.forEach(btn=>{
        btn.addEventListener('click',()=>{
            if(btn.classList.contains('disabled')) return;

            selectedSize = btn.dataset.size;

            // Remove old selection
            sizeBtns.forEach(b=>b.classList.remove('selected'));
            addBtn.classList.remove("selected");

            // Apply new selection
            btn.classList.add('selected');
            addBtn.classList.add("selected");

            addBtn.disabled = false;
            addBtn.textContent = "Add to Cart";
        });
    });

    addBtn.addEventListener('click',()=>{
        if(!selectedSize) return showToast("Select size");

        let fd=new FormData();
        fd.append("product_id",productId);
        fd.append("size",selectedSize);

        fetch("add_to_cart.php",{method:"POST",body:fd})
        .then(r=>r.json())
        .then(res=>{

            if(res.status==="OUT_OF_STOCK"){
                showToast("Out of Stock!");

                sizeBtns.forEach(btn=>{
                    if(btn.dataset.size===selectedSize){
                        btn.classList.add("disabled");
                        btn.disabled=true;
                        btn.classList.remove("selected");
                        btn.textContent = selectedSize.toUpperCase()+" (Out)";
                    }
                });

                selectedSize=null;
                addBtn.classList.remove("selected");

                if([...sizeBtns].every(b=>b.classList.contains("disabled"))){
                    addBtn.disabled=true;
                    addBtn.textContent="Out of Stock";
                }
                return;
            }

            if(res.status==="LOGIN_REQUIRED"){
                window.location="login.php";
                return;
            }

            if(res.status==="SUCCESS"){
                showToast("Added to Cart!");
                updateCartCount();
            }
        })
        .catch(()=>showToast("Error adding to cart"));
    });

});
</script>

</body>
</html>
