<?php
if(isset($_POST['submit'])){
    include 'Config.php';

    $product_name = $_POST['Pname'];
    $product_price = $_POST['Pprice'];
    $product_category = $_POST['Pages'];
    $product_aria = $_POST['Paria'];

    $product_image = $_FILES['Pimage'];
    $image_loc = $_FILES['Pimage']['tmp_name'];
    $image_name = $_FILES['Pimage']['name'];
    $img_des = "Uploadimage/" . $image_name;

    // Move image to folder
    if(move_uploaded_file($image_loc, $img_des)){
        // Insert product details into database
        $query = "INSERT INTO `tblproduct`(`PName`, `PPrice`, `Pimage`, `PCategory`, `Paria`) 
                  VALUES ('$product_name', '$product_price', '$img_des', '$product_category', '$product_aria')";

        if(mysqli_query($conn, $query)){
            echo "<script>alert('Product inserted successfully!');
            window.location.href='index.php';</script>";
            
        } else {
            echo "<script>alert('Error inserting product: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Error uploading image!');</script>";
    }
}
?>
