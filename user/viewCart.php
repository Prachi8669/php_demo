<?php
session_start();
include 'header.php'; // Header file include करें

// Remove Product Logic
if (isset($_POST['remove']) && isset($_POST['item'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['productName'] === $_POST['item']) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
            break;
        }
    }
    header('location:viewCart.php');
    exit();
}

// Update Product Quantity Logic
if (isset($_POST['update']) && isset($_POST['productQuantity'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['productName'] === $_POST['item']) {
            $_SESSION['cart'][$key]['productQuantity'] = $_POST['productQuantity'];
            break;
        }
    }
    header('location:viewCart.php');
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center bg-light mb-5 rounded">
            <h1 class="text-warning">My Cart</h1>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-around">
        <div class="col-sm-12 col-md-6 col-lg-9">
            <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                <table class="table table-bordered text-center">
                    <thead class="bg-danger text-white fs-5">
                        <tr>
                            <th>Index No.</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Product Quantity</th>
                            <th>Total Price</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $key => $value) {
                            $productName = htmlspecialchars($value['productName']);
                            $productPrice = htmlspecialchars($value['productPrice']);
                            $productQuantity = htmlspecialchars($value['productQuantity']);
                            $totalPrice = $productPrice * $productQuantity;
                            $total += $totalPrice;
                        ?>
                            <tr>
                                <form action="viewCart.php" method="POST">
                                    <td><?php echo htmlspecialchars($key); ?></td>
                                    <td><?php echo $productName; ?></td>
                                    <td><?php echo $productPrice; ?></td>
                                    <td>
                                        <input type="number" name="productQuantity" value="<?php echo $productQuantity; ?>" min="1">
                                    </td>
                                    <td><?php echo htmlspecialchars($totalPrice); ?></td>
                                    <td>
                                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                                        <input type="hidden" name="item" value="<?php echo $productName; ?>">
                                    </td>
                                    <td>
                                        <button type="submit" name="remove" class="btn btn-danger">Delete</button>
                                        <input type="hidden" name="item" value="<?php echo $productName; ?>">
                                    </td>
                                </form>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                            <td><strong><?php echo htmlspecialchars($total); ?></strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center text-danger">Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="text-center my-4">
<form action="checkout.php" method="get"> 
<input type="submit" value="Continue Shopping"  class="bg-info px-3 py-2 border-0 mx-3" name="continue-shopping"> 
<button class="bg-secondary p-3 py-2 border-0 text-light text-center"><a href="checkout.php" class="text-light"></a>Checkout</button></a>


</div>

