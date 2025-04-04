<?php
include 'config.php';
include 'header.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT PName, PPrice, Paria, PImage FROM tblproduct WHERE id = ?");

    if ($stmt) {
        // Bind parameter and execute statement
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo "
            <div class='container my-5'>
                <div class='row'>
                    <div class='col-md-6'>
                        <img src='../admin/product/{$row['PImage']}' alt='Product Image' class='img-fluid'>
                    </div>
                    <div class='col-md-6'>
                        <form action='Insertcart.php' method='POST'>
                            <input type='hidden' name='PName' value='{$row['PName']}'>
                            <input type='hidden' name='PPrice' value='{$row['PPrice']}'>
                            
                            <h2 class='product-title'>{$row['PName']}</h2>
                            <p class='product-price text-success'><b>Price:</b> ₹{$row['PPrice']}</p>
                            <p class='product-description'>{$row['Paria']}</p>

                            <div class='form-group'>
                                <label for='PQuantity'>Quantity</label>
                                <input type='number' name='PQuantity' id='PQuantity' min='1' max='20' class='form-control' required placeholder='Quantity'>
                            </div>

                            <div class='d-flex'>
                                <!-- Add to Cart button takes 50% width -->
                                <button type='submit' name='addCart' class='btn btn-warning my-2 flex-fill mr-2'>Add to Cart</button>
                                
                                <!-- Buy Now button takes 50% width -->
                                <button type='submit' name='buyNow' class='btn btn-danger my-2 flex-fill'>Buy Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            ";
        } else {
            echo "<p class='text-center text-danger'>Product not found.</p>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<p class='text-center text-danger'>Error preparing statement: " . $conn->error . "</p>";
    }
} else {
    echo "<p class='text-center text-danger'>Invalid product ID.</p>";
}

// Close database connection
$conn->close();
?>
