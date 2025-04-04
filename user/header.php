<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Store</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Custom Banner Style */
        .carousel-item img {
            height: 400px;
            object-fit: cover;
        }
        .carousel-caption h5 {
            font-size: 3rem;
            font-weight: bold;
        }
        .carousel-caption p {
            font-size: 1.5rem;
            font-weight: 300;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid font-monospace">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="bannerpic/logo.jpg" alt="Logo" height="40" class="me-2"> <span>MyStore</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <form class="d-flex mx-auto" action="search.php" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Search product..." required>
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-warning"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a href="viewCart.php" class="nav-link text-warning">
                        <i class="fas fa-shopping-cart"></i> Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)
                    </a>
                </li>
                 <!-- Wishlist Link -->
                 <li class="nav-item">
                    <a href="wishlist.php" class="nav-link text-warning">
                        <i class="fas fa-heart"></i> Wishlist (<?php echo isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0; ?>)
                    </a>
                </li>
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['USER']) && !empty($_SESSION['USER'])) {
                        // Display logged-in user's name
                        echo '<span class="nav-link text-warning"><i class="fas fa-user-shield" style="margin-right: 5px;"></i>Hello, ' . htmlspecialchars($_SESSION['USER']) . ' |</span>';
                    } else {
                        // If not logged in, show Hello Guest
                        echo '<span class="nav-link text-warning"><i class="fas fa-user-shield" style="margin-right: 5px;"></i>Hello, Guest |</span>';
                    }
                    ?>
                </li>

                <!-- ligin/logout and admin links-->
          <?php  if(!isset($_SESSION['USER'])|| EMPTY($_SESSION['USER'])):  ?>
            <li class="nav-item">
                    <a href="form/login.php" class="nav-link text-warning"><i class="fas fa-user-shield"></i> Login</a>
                </li>
                <?php else:  ?>
            <li class="nav-item">
                    <a href="form/logout.php" class="nav-link text-warning"><i class="fas fa-user-shield"></i> Logout</a>
                </li>
            <?php endif;  ?>
                <li class="nav-item">
                    <a href="../admin/mystore.php" class="nav-link text-warning"><i class="fas fa-cogs"></i> Admin</a>
                </li>
                <?php if(isset($_SESSION['USER'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="my_orders.php">My Orders</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
