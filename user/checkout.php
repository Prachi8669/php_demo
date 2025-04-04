<?php
session_start();
include 'header.php';
include 'Config.php';

// Check if user is logged in
if (!isset($_SESSION['USER'])) {
    echo "<script>
    alert('Please login first to checkout');
    window.location.href='form/login.php';
    </script>";
    exit();
}

// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>
    alert('Your cart is empty');
    window.location.href='index.php';
    </script>";
    exit();
}

// Process order submission
if (isset($_POST['continue'])) {
    // Get user ID
    $username = $_SESSION['USER'];
    $stmt = $conn->prepare("SELECT id FROM tbluser WHERE UserName = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $user_id = $user_data['id'];
    $stmt->close();

    // Get delivery details
    $delivery_address = $_POST['address'];
    $delivery_city = $_POST['city'];
    $delivery_state = $_POST['state'];
    $delivery_pincode = $_POST['pincode'];
    $delivery_phone = $_POST['phone'];

    // Insert Order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, delivery_address, delivery_city, delivery_state, delivery_pincode, delivery_phone, order_status) 
                            VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("isssss", $user_id, $delivery_address, $delivery_city, $delivery_state, $delivery_pincode, $delivery_phone);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Add order items
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, product_price, product_quantity, total_price) 
                                VALUES (?, ?, ?, ?, ?)");

        foreach ($_SESSION['cart'] as $item) {
            $product_name = $item['productName'];
            $product_price = $item['productPrice'];
            $quantity = $item['productQuantity'];
            $total_price = $product_price * $quantity;

            $stmt->bind_param("isddi", $order_id, $product_name, $product_price, $quantity, $total_price);
            $stmt->execute();
        }
        $stmt->close();

        // Store Order ID & Total in Session for Payment
        $_SESSION['ORDER_ID'] = $order_id;
        $_SESSION['ORDER_TOTAL'] = array_sum(array_map(function($item) {
            return $item['productPrice'] * $item['productQuantity'];
        }, $_SESSION['cart']));

        // Clear cart
        unset($_SESSION['cart']);

        // Redirect to payment page
        header("Location: payment.php");
        exit();
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}

// Calculate total
$total = array_sum(array_map(function($item) {
    return $item['productPrice'] * $item['productQuantity'];
}, $_SESSION['cart']));
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Checkout</h2>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Summary</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['productName']); ?></td>
                                <td><?php echo htmlspecialchars($item['productQuantity']); ?></td>
                                <td>₹<?php echo htmlspecialchars($item['productPrice']); ?></td>
                                <td>₹<?php echo htmlspecialchars($item['productPrice'] * $item['productQuantity']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                                <td><strong>₹<?php echo htmlspecialchars($total); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <form method="POST" class="mt-4">
                        <h5 class="mb-3">Delivery Address</h5>
                        <div class="mb-3">
                            <label class="form-label">Street Address</label>
                            <textarea name="address" class="form-control" required rows="2"></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">PIN Code</label>
                                <input type="text" name="pincode" class="form-control" required pattern="[0-9]{6}" title="Please enter a valid 6-digit PIN code">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" required pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number">
                            </div>
                        </div>

                        <button type="submit" name="continue" class="btn btn-primary">Continue to Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
