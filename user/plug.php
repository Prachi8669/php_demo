<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home-page</title>
    <?php include 'header.php';
    include 'header2.php'; ?>
</head>
<body>
  <div class="container-fluid">
    <div class="col-md-12">
      <div class="row">
        <h1 class="text-warning font-monospace text-center my-3">PLUG</h1>
        <?php
        include 'Config.php';
        $Record = mysqli_query($conn, "SELECT * FROM `tblproduct` WHERE PCategory='Plug'"); // ✅ फक्त लॅपटॉपसाठी डेटा आणला
        
        if (mysqli_num_rows($Record) > 0) {
            while ($row = mysqli_fetch_array($Record)) {
                echo "
                <div class='col-md-6 col-lg-4 m-auto mb-3'>
                  <form action='Insertcart.php' method='POST'> <!-- ✅ Add to Cart फॉर्म -->
                    <div class='card m-auto' style='width: 18rem;'>
                       <a href='specifications.php?id=$row[id] '><img src='../admin/product/$row[PImage]' class='card-img-top' style='height: 300px;'></a>
                      <div class='card-body text-center'>
                        <h5 class='card-title text-danger fs-4 fw-bold'>".$row['PName']."</h5>
                        <p class='card-text'>RS: ".$row['PPrice']."</p>
                        <p class='card-text text-danger fs-4 fw-bold'>".$row['Paria']."</p>
                        
                        <!-- ✅ Hidden inputs for cart -->
                        <input type='hidden' name='PName' value='".$row['PName']."'> 
                        <input type='hidden' name='PPrice' value='".$row['PPrice']."'> 
                        
                        <!-- ✅ Quantity input corrected -->
                        <input type='number' name='PQuantity' min='1' max='20' value='1' class='form-control' placeholder='Quantity'><br>
                        
                        <!-- ✅ Submit button -->
                        <input type='submit' name='addCart' class='btn btn-warning text-white w-100' value='Add To Cart'>
                      </div>
                    </div>
                  </form>
                </div>";
            }
        } else {
            echo "<h3 class='text-center text-danger'>No laptops available</h3>";
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
