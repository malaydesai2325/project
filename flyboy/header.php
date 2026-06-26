<?php
session_start(); // Make sure session is started
?>
    <style>
        body {
            background-color: black;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header { position: sticky; top: 0; z-index: 999; }

        .header-bg {
            background-color: #000;
            padding: 12px 0;
            border-bottom: 1px solid rgba(238, 0, 20, 0.3);
            animation: headerGlow 2s infinite alternate ease-in-out;
        }

        @keyframes headerGlow {
            0% { box-shadow: 0 0 10px rgba(238,0,20,0.6); }
            100% { box-shadow: 0 0 20px rgba(238,0,20,1); }
        }

        .logo-text {
            color: rgba(238, 0, 20, 0.86);
            font-size: 22px;
            font-weight: bold;
        }
        .logo-img { filter: drop-shadow(0 0 6px rgba(238, 0, 20, 1)); }

        .nav-link {
            color: rgba(238, 0, 20, 0.86) !important;
            font-size: 18px;
            position: relative;
        }

        .nav-link:hover {
            color: white !important;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            width: 0%;
            height: 2px;
            background: rgba(238, 0, 20, 1);
            left: 0;
            bottom: 0;
            transition: 0.4s ease;
        }
        .nav-link:hover::after { width: 100%; }

        .navbar-toggler { border-color: rgba(238, 0, 20, 0.86); }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23ff002a' viewBox='0 0 30 30'%3e%3cpath stroke='%23ff002a' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .dropdown-menu {
            background-color: #000;
            border: 1px solid rgba(238, 0, 20, 0.5);
        }

        .dropdown-item {
            color: rgba(238, 0, 20, 0.86);
        }
        .dropdown-item:hover {
            background-color: rgba(238, 0, 20, 0.8);
            color: black;
        }

        .cart-item {
            padding: 6px;
            border-bottom: 1px solid rgba(238, 0, 20, 0.3);
        }
        .cart-item:last-child { border-bottom: none; }
    </style>
<header class="header-bg">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="logo.png" width="100" class="rounded-pill logo-img me-2">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item"><a class="nav-link" href="men.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About us</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php"><i class="bi bi-cart"></i> Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="my_order.php">Orders</a></li>

                    <?php if(isset($_SESSION['user_id'])): ?>
                    <!-- Profile Dropdown shown only when logged in -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="myprofile.php">My Profile</a></li>
                            <li><hr></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <!-- Optional: show login/register if not logged in -->
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
</header>
