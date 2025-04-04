<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <?php include 'header.php';
    include 'header2.php'; ?>
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <h1 class="text-warning font-monospace text-center my-3">SOCKED</h1>
                <?php
                include 'Config.php';

                
                $Record = mysqli_query($conn, "SELECT * FROM `tblproduct` WHERE `PCategory`='Socket'");
                
                if (mysqli_num_rows($Record) > 0) {
                    while ($row = mysqli_fetch_array($Record)) {
                        echo "
                        <div class='col-md-6 col-lg-4 m-auto mb-3'>
                            <div class='card m-auto' style='width: 18rem;'>
                                <img src='../admin/product/$row[PImage]' class='card-img-top' style='height: 300px;'>
                                <div class='card-body text-center'>
                                    <h5 class='card-title text-danger fs-4 fw-bold'>".$row['PName']."</h5>
                                    <p class='card-text'>Price: ₹".$row['PPrice']."</p>
                                    <p class='card-text text-danger fs-5'>".$row['Paria']."</p>
                                    
                                    <input type='number' min='1' max='20' placeholder='Quantity' class='form-control mb-2'>
                                    <input type='submit' class='btn btn-warning text-white w-100' value='Add To Cart'>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p class='text-center text-danger fs-4'>No Bags Found!</p>";
                }
                ?>
            </div>
        </div>
    </div> 
</body>
</html>
