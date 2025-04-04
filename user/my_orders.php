<?php
session_start();
include 'header.php';

if (!isset($_SESSION['USER'])) {
    header("Location: form/login.php");
    exit();
}

include 'Config.php';

// Get user ID
$username = $_SESSION['USER'];
$user_query = mysqli_query($conn, "SELECT id FROM tbluser WHERE UserName = '$username'");
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['id'];

// Get user's orders with ordered products
$orders_query = mysqli_query($conn, "
    SELECT o.order_id, o.order_date, o.order_status,
           GROUP_CONCAT(oi.product_name, ' (', oi.product_quantity, ')' SEPARATOR ', ') AS products,
           SUM(oi.total_price) AS total_amount
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    WHERE o.user_id = '$user_id'
    GROUP BY o.order_id
    ORDER BY o.order_date DESC
");
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">My Orders</h2>
    
    <?php if (mysqli_num_rows($orders_query) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Products</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($orders_query)): ?>
                        <tr>
                            <td>#<?php echo $order['order_id']; ?></td>
                            <td><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                            <td><?php echo htmlspecialchars($order['products']); ?></td>
                            <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo match($order['order_status']) {
                                        'Pending' => 'warning',
                                        'Processing' => 'info',
                                        'Shipped' => 'primary',
                                        'Delivered' => 'success',
                                        default => 'secondary'
                                    };
                                ?>">
                                    <?php echo $order['order_status']; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            You haven't placed any orders yet.
        </div>
    <?php endif; ?>
</div>
