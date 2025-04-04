<?php
include("Config.php");

if(isset($_POST['product_id']) && isset($_POST['rating'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);

    $query = "INSERT INTO product_ratings (product_id, rating) VALUES ('$product_id', '$rating')";
    
    if(mysqli_query($conn, $query)) {
        echo "success"; // ✅ Success message return कर रहा है
    } else {
        echo "error"; // ❌ Error message return कर रहा है
    }
}
?>
