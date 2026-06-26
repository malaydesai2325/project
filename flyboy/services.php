<!DOCTYPE html>
<html>
<head>
    <title>Our Services</title>
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

    .service-card {
        background-color: #0a0a0a;
        border: 1px solid rgba(238,0,20,0.6);
        border-radius: 12px;
        padding: 25px;
        transition: 0.3s;
        height: 100%;
    }

    .service-card:hover {
        transform: scale(1.05);
        border-color: red;
        box-shadow: 0 0 15px rgba(255,0,0,0.4);
    }

    .icon-box {
        font-size: 60px;
        color: rgba(238,0,20,0.86);
        margin-bottom: 15px;
        text-shadow: 0 0 10px red;
    }

    .btn-red {
        background-color: rgba(238,0,20,0.86);
        color: black;
        font-weight: bold;
        padding-left: 20px;
        padding-right: 20px;
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

    <h2 class="text-center mb-5">Our Premium Services</h2>

    <div class="row g-4">

        <!-- SERVICE 1 -->
        <div class="col-md-4">
            <div class="service-card text-center">
                <div class="icon-box">🚚</div>
                <h4>Fast Shipping</h4>
                <p>
                    We deliver your products quickly & safely to your doorstep.
                    Real-time tracking and smooth delivery experience.
                </p>
            </div>
        </div>

        <!-- SERVICE 2 -->
        <div class="col-md-4">
            <div class="service-card text-center">
                <div class="icon-box">💳</div>
                <h4>Secure Online Payments</h4>
                <p>
                    We support UPI, Cards, Netbanking & Wallets with 100% secure
                    Razorpay Payment Gateway integration.
                </p>
            </div>
        </div>

        <!-- SERVICE 3 -->
        <div class="col-md-4">
            <div class="service-card text-center">
                <div class="icon-box">🎁</div>
                <h4>Exclusive Collections</h4>
                <p>
                    We offer premium, unique, and limited-edition drops that you 
                    won't find anywhere else. Pure streetwear energy.
                </p>
            </div>
        </div>

        <!-- SERVICE 4 -->
        <div class="col-md-4">
            <div class="service-card text-center">
                <div class="icon-box">🔄</div>
                <h4>Easy Returns & Exchanges</h4>
                <p>
                    We offer a hassle-free return & exchange policy depending on 
                    product category and condition.
                </p>
            </div>
        </div>

        <!-- SERVICE 5 -->
        <div class="col-md-4">
            <div class="service-card text-center">
                <div class="icon-box">📞</div>
                <h4>24/7 Customer Support</h4>
                <p>
                    Need help? Our support team is available throughout the day 
                    to assist you with queries and order information.
                </p>
            </div>
        </div>

        <!-- SERVICE 6 -->
        <div class="col-md-4">
            <div class="service-card text-center">
                <div class="icon-box">🛠️</div>
                <h4>Size & Style Consulting</h4>
                <p>
                    Unsure about fit? Our team helps you pick the right size for 
                    every product based on your measurements.
                </p>
            </div>
        </div>

    </div>



</div>

</body>
</html>
