<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: form/login.php");
    exit();
}

include 'mystore.php';
include 'product/Config.php';

// Update order status
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    mysqli_query($conn, "UPDATE orders SET order_status = '$new_status' WHERE order_id = $order_id");
}

// Get all orders with user details
$orders_query = mysqli_query($conn, "
    SELECT o.order_id, o.order_date, o.order_status,
           o.delivery_address, o.delivery_city, o.delivery_state, 
           o.delivery_pincode, o.delivery_phone,
           u.UserName, u.Email, u.Number,
           GROUP_CONCAT(oi.product_name, ' (', oi.product_quantity, ')' SEPARATOR ', ') as products,
           SUM(oi.total_price) as total_amount
    FROM orders o
    JOIN tbluser u ON o.user_id = u.id
    JOIN order_items oi ON o.order_id = oi.order_id
    GROUP BY o.order_id
    ORDER BY o.order_date DESC
");
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Order Management</h2>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Products</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Delivery Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($orders_query)): ?>
                    <tr>
                        <td>#<?php echo $order['order_id']; ?></td>
                        <td><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                        <td>
                            <?php echo htmlspecialchars($order['UserName']); ?><br>
                            <small class="text-muted"><?php echo htmlspecialchars($order['Email']); ?></small>
                        </td>
                        <td><?php echo htmlspecialchars($order['Number']); ?></td>
                        <td><?php echo htmlspecialchars($order['products']); ?></td>
                        <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td><?php echo $order['order_status']; ?></td>
                        <td>
                            <?php echo htmlspecialchars($order['delivery_address']); ?><br>
                            <?php echo htmlspecialchars($order['delivery_city']); ?>, 
                            <?php echo htmlspecialchars($order['delivery_state']); ?> - 
                            <?php echo htmlspecialchars($order['delivery_pincode']); ?><br>
                            Phone: <?php echo htmlspecialchars($order['delivery_phone']); ?>
                        </td>
                        <td>
                            <form method="POST" class="d-flex gap-2">
                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                <select name="new_status" class="form-select form-select-sm">
                                    <option value="Pending" <?php echo $order['order_status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Processing" <?php echo $order['order_status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                    <option value="Shipped" <?php echo $order['order_status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                    <option value="Delivered" <?php echo $order['order_status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                </select>
                                <button type="submit" name="update_status" class="btn btn-primary btn-sm">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div> 