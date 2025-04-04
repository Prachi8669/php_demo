<?php
// Include database connection
include 'Config.php';

// Check if 'id' is set and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // SQL query to fetch product details
    $Record = mysqli_query($conn, "SELECT * FROM `tblproduct` WHERE ID = $id");

    // Check if any record is found
    if (mysqli_num_rows($Record) > 0) {
        $data = mysqli_fetch_array($Record);
    } else {
        // If no product found, redirect to an error or list page
        echo "Product not found!";
        exit;
    }
} else {
    // If 'id' is not set or invalid, show an error or redirect
    echo "Invalid or missing product ID.";
    exit;
}

// Update Product on Form Submission
if (isset($_POST['update'])) {
    $product_name = $_POST['Pname'];
    $product_price = $_POST['Pprice'];
    $product_category = $_POST['Pages'];
    $product_aria = $_POST['Paria'];
    
    // Image Upload Handling
    $img_des = $data['PImage']; // Default to existing image if no new one uploaded.
    if ($_FILES['Pimage']['name'] != '') {
        $image_loc = $_FILES['Pimage']['tmp_name'];
        $image_name = $_FILES['Pimage']['name'];
        $img_des = "Uploadimage/" . $image_name;
        move_uploaded_file($image_loc, $img_des);
    }

    // Update query
    $update_query = "UPDATE `tblproduct` SET 
                     `PName` = '$product_name', 
                     `PPrice` = '$product_price', 
                     `PImage` = '$img_des', 
                     `PCategory` = '$product_category', 
                     `Paria` = '$product_aria' 
                     WHERE `id` = $id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Product updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error updating product: " . mysqli_error($conn) . "');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Update</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6 m-auto border border-primary mt-3">
            <form action="update.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <p class="text-center fw-bold fs-3 text-warning">Product Update:</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">Product Name:</label>
                    <input type="text" name="Pname" value="<?php echo $data['PName']; ?>" class="form-control" placeholder="Enter Product Name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Product Price:</label>
                    <input type="number" name="Pprice" value="<?php echo $data['PPrice']; ?>" class="form-control" placeholder="Enter Product Price" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Add Product Image:</label>
                    <input type="file" name="Pimage" class="form-control"><br>
                    <img src="<?php echo $data['PImage']; ?>" alt="Product Image" style="height:100px;">
                </div>
                <div class="mb-3">
                    <label class="form-label">Select Page Category:</label>
                    <select class="form-select" name="Pages">
                        <option value="home" <?php echo ($data['PCategory'] == 'home') ? 'selected' : ''; ?>>Home</option>
                        <option value="Laptop" <?php echo ($data['PCategory'] == 'Laptop') ? 'selected' : ''; ?>>Cables</option>
                        <option value="handtools" <?php echo ($data['PCategory'] == 'handtools') ? 'selected' : ''; ?>>Hand Tools</option>
                        <option value="fans" <?php echo ($data['PCategory'] == 'fans') ? 'selected' : ''; ?>>Fans</option>
                        <option value="Switches" <?php echo ($data['PCategory'] == 'Switches') ? 'selected' : ''; ?>>Switches</option>
                        <option value="Socket" <?php echo ($data['PCategory'] == 'Socket') ? 'selected' : ''; ?>>Socket</option>
                        <option value="Circuit" <?php echo ($data['PCategory'] == 'Circuit') ? 'selected' : ''; ?>>Circuit Breakers</option>
                        <option value="Plug" <?php echo ($data['PCategory'] == 'Plug') ? 'selected' : ''; ?>>Plug</option>
                        <option value="Batteries" <?php echo ($data['PCategory'] == 'Batteries') ? 'selected' : ''; ?>>Batteries</option>
                        <option value="Lighting" <?php echo ($data['PCategory'] == 'Lighting') ? 'selected' : ''; ?>>Lighting</option>
                        <option value="Pipes" <?php echo ($data['PCategory'] == 'Pipes') ? 'selected' : ''; ?>>Pipes</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Product Description:</label>
                    <textarea name="Paria" class="form-control" placeholder="Enter Product Description" required><?php echo $data['Paria']; ?></textarea>
                </div>
                <button name="update" class="bg-danger fs-4 fw-bold my-3 form-control text-white">Update</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
