<?php
// Ensure session is not started multiple times
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: form/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home Page</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-dark">
        <div class="container-fluid text-white">
            <a class="navbar-brand text-white">
                <h1>Mystore</h1>
            </a>
            <span>
                <i class="fa-solid fa-user-shield"></i>
                Hello, Admin |
                <i class="fas fa-sign-out-alt"></i>
                <a href="form/logout.php" class="text-decoration-none text-white">Logout</a> |
                <a href="../user/index.php" class="text-decoration-none text-white">User Panel</a>
            </span>
        </div>
    </nav>

    <!-- Dashboard -->
    <div class="container mt-4">
        <h2 class="text-center">Dashboard</h2>
        <div class="row">
            <div class="col-md-6 bg-danger text-center m-auto py-3">
                <a href="product/index.php" class="text-white text-decoration-none fs-4 fw-bold px-5">Add Post</a>
                <a href="user.php" class="text-white text-decoration-none fs-4 fw-bold px-5">User</a>
                <a href="orders.php" class="text-white text-decoration-none fs-4 fw-bold px-5">Orders</a>
            </div>
        </div>
    </div>
</body>
</html>
