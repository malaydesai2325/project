<!DOCTYPE html>
<html>
<head>
    <title>About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {
        background-color: black;
        color: white;
        font-family: Arial;
    }

    h2 {
        color: rgba(238,0,20,0.86);
        text-shadow: 0 0 8px rgba(238,0,20,0.7);
    }

    .section-box {
        background-color: #0a0a0a;
        padding: 25px;
        border-radius: 12px;
        border: 1px solid rgba(238,0,20,0.6);
        transition: 0.3s;
    }

    .section-box:hover {
        transform: scale(1.02);
        border-color: red;
        box-shadow: 0 0 20px rgba(255,0,0,0.3);
    }

    .highlight {
        color: rgba(238,0,20,0.86);
        font-weight: bold;
    }

    .team-photo {
        width: 100%;
        border-radius: 12px;
        border: 1px solid rgba(255,0,0,0.3);
    }

    .stats-box {
        border: 1px solid rgba(238,0,20,0.6);
        padding: 20px;
        border-radius: 12px;
        background-color: #111;
        text-align: center;
        margin-bottom: 20px;
        transition: 0.3s;
    }

    .stats-box:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(255,0,0,0.4);
    }

    .stats-number {
        font-size: 36px;
        color: rgba(238,0,20,0.86);
        font-weight: bold;
    }

    .btn-red {
        background-color: rgba(238,0,20,0.86);
        color: black;
        font-weight: bold;
    }

    .btn-red:hover {
        background-color: white;
        color: black;
    }
</style>

<body>

<div class="container py-5">

    <div class="mb-4">
        <a href="index.php" class="btn btn-red">← Back</a>
    </div>

    <h2 class="text-center mb-5">About Us</h2>

    <!-- WHO WE ARE -->
    <div class="section-box mb-5">
        <h4 class="highlight">Who We Are</h4>
        <p>
            We are a next-generation <span class="highlight">streetwear and fashion brand</span> 
            built for bold individuals who want to express their personality,
            confidence, and attitude through premium quality clothing.
        </p>
        <p>
            Every piece we create is inspired by modern culture, music,
            and urban lifestyle — blended with high-grade materials and
            cutting-edge designs.
        </p>
    </div>

    <!-- OUR MISSION -->
    <div class="section-box mb-5">
        <h4 class="highlight">Our Mission</h4>
        <p>
            Our mission is simple:
            <br>
            <span class="highlight">Deliver premium, comfortable, and stylish clothing at a fair price.</span>
        </p>
        <p>
            We work tirelessly to provide unique collections, fast delivery,
            and top-tier customer service — because you deserve the best,
            every single time.
        </p>
    </div>

    <!-- OUR JOURNEY -->
    <div class="section-box mb-5">
        <h4 class="highlight">Our Journey</h4>
        <p>
            What started as a small idea has grown into a full-fledged brand
            trusted by customers nationwide. With every new drop, every new 
            design, and every customer review — we evolve and get better.
        </p>
    </div>

    <!-- TEAM IMAGE -->
    <div class="mb-5">
        <img class="team-photo" src="https://via.placeholder.com/1200x400?text=Your+Team+Photo+Here" alt="Team">
    </div>

    <!-- STATS -->
    <div class="row text-center mb-5">
        <div class="col-md-4">
            <div class="stats-box">
                <div class="stats-number">50k+</div>
                <div>Happy Customers</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-box">
                <div class="stats-number">500+</div>
                <div>Premium Products</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-box">
                <div class="stats-number">4.9★</div>
                <div>Average Rating</div>
            </div>
        </div>
    </div>

    <!-- WHY CHOOSE US -->
    <div class="section-box mb-5">
        <h4 class="highlight">Why Choose Us?</h4>
        <ul>
            <li>🔥 Premium, High-Quality Fabrics</li>
            <li>🚚 Fast & Reliable Delivery</li>
            <li>💳 Secure Online Payments</li>
            <li>✔ Hassle-Free Returns</li>
            <li>🎧 24/7 Customer Support</li>
            <li>💯 100% Original Products</li>
        </ul>
    </div>



</div>

</body>
</html>
