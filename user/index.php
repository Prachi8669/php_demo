<?php
session_start();
include 'header.php';
include 'header2.php';
include 'Config.php'; 

?>
<div class="container-fluid">
    <div class="row">
        <h1 class="text-warning font-monospace text-center my-3">Home</h1>

        <?php
        // डेटाबेस से सभी उत्पाद लाने के लिए SQL क्वेरी
        $Record = mysqli_query($conn, "SELECT * FROM tblproduct"); // यहाँ Home की कैटेगरी का फिल्टर हटा दिया गया है

        if (mysqli_num_rows($Record) > 0) {
            while ($row = mysqli_fetch_assoc($Record)) {
                echo "
                <div class='col-md-6 col-lg-4 m-auto mb-3'>
                    <form action='Insertcart.php' method='POST'>
                        <div class='card m-auto' style='width: 18rem;'>
                           <a href='specifications.php?id=$row[id] '> <img src='../admin/product/$row[PImage]' class='card-img-top' style='height: 300px;'></a>
                            <div class='card-body text-center'>
                                <h5 class='card-title text-danger fs-4 fw-bold'>$row[PName]</h5>
                                <p class='card-text text-danger fs-4 fw-bold'>RS: $row[PPrice]</p>
                                <p class='card-text text-danger fs-4 fw-bold'>$row[Paria]</p>
                                <input type='hidden' name='PName' value='$row[PName]'> 
                                <input type='hidden' name='PPrice' value='$row[PPrice]'> 
                                <input type='number' name='PQuantity' min='1' max='20' placeholder='Quantity' class='form-control my-2' required>
                                <input type='submit' name='addCart' class='btn btn-warning text-white w-100' value='Add To Cart'>
                                
                            </div>
                        </div>
                    </form>
                </div>";
            }
        } else {
            echo "<h3 class='text-center text-danger'>No Products Available</h3>";
        }
        ?>
    </div>
    
</div>

<?php
include'footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>






https://github.com/Prachi8669/php_project.git