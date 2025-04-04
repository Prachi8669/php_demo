<?php
include("Config.php");

if(isset($_GET['query'])){
    $search_query = mysqli_real_escape_string($conn, $_GET['query']);
    
    // योग्य डेटा शोधण्यासाठी सुधारित क्वेरी
    $sql = "SELECT * FROM tblproduct WHERE PName LIKE '%$search_query%' OR PCategory LIKE '%$search_query%'";
    
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<style>
.img-container {
    width: 100%; /* कार्डच्या रुंदीप्रमाणे */
    height: 200px; /* तुम्हाला हवे असेल तेवढे */
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background-color: #f8f9fa;
    border-radius: 10px;
}

.img-container img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Image योग्य आकारात दिसण्यासाठी */
}
</style>
    <div class="container mt-4">
        <h2 class="text-center">Search Results for '<?php echo htmlspecialchars($search_query); ?>'</h2>
        <div class="row">
            <?php
            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    $pid = isset($row['id']) ? $row['id'] : 0; // ✅ योग्य कॉलम वापरा
            ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="img-container">
                        <img src="/admin/product/<?php echo htmlspecialchars($row['PImage']); ?>" alt="Product Image">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['PName']); ?></h5>
                        <p class="card-text">Price: <b>Rs <?php echo htmlspecialchars($row['PPrice']); ?></b></p>
                        <p class="text-success">✅ Free Delivery</p>

                        <!-- ⭐ रेटिंग सिस्टम (Free Delivery च्या खाली) -->
                        <div class="rating-section mt-2">
                            <label class="text-warning fs-5">Rate this product:</label>
                            <select id="rating_<?php echo $pid; ?>" class="form-select rating-select" data-product="<?php echo $pid; ?>">
                                <option value="1">★☆☆☆☆ (1 Star)</option>
                                <option value="2">★★☆☆☆ (2 Stars)</option>
                                <option value="3">★★★☆☆ (3 Stars)</option>
                                <option value="4">★★★★☆ (4 Stars)</option>
                                <option value="5">★★★★★ (5 Stars)</option>
                            </select>
                            <button class="btn btn-primary mt-2 submit-rating" data-product="<?php echo $pid; ?>">
                                Submit Rating
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p class='text-center text-danger'>No products found.</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $(".submit-rating").click(function () {
        var product_id = $(this).data("product");
        var rating = $("#rating_" + product_id).val();

        $.ajax({
            url: "rate_product.php",
            type: "POST",
            data: { product_id: product_id, rating: rating },
            success: function (response) {
                if (response.trim() == "success") {
                    alert("✅ Rating submitted successfully!");
                } else {
                    alert("❌ Error submitting rating. Please try again.");
                }
            },
            error: function () {
                alert("❌ AJAX request failed. Please check the console.");
            }
        });
    });
});
</script>