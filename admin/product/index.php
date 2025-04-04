<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product-page</title>
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto border border-primary mt-3">
       
                <form action="insert.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <p class="text-center fw-bold fs-3 text-warning">Product Detail:</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Name:</label>
                        <input type="text" name="Pname" class="form-control" placeholder="Enter Product Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Price:</label>
                        <input type="number" name="Pprice" class="form-control" placeholder="Enter Product Price" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Add Product Image:</label>
                        <input type="file" name="Pimage" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select page category:</label>
                        <select class="form-select" name="Pages">
                            <option value="home">Home</option>
                            <option value="Laptop">Cables</option>
                            <option value="handtoos">Hand Tools</option>
                            <option value="fans">Fans</option>
                            <option value="Switches">Switches</option>
                            <option value="Socket">Socket</option>
                            <option value="Circuit ">Circuit Breakers</option>
                            <option value="Plug">Plug</option>
                            <option value="Batteries">Batteries</option>
                            <option value="Lighting">Lighting</option>
                            <option value="Pipes">Pipes</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Add Product Description:</label>
                        <textarea name="Paria" class="form-control" placeholder="Enter Product Description" required></textarea>
                    </div>
                    <button name="submit" class="bg-danger fs-4 fw-bold my-3 form-control text-white">Upload</button>
                </form>

            </div>
        </div>
    </div>

    <!--fetch data -->
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <table class="table border border-warning table-hover my-5">
                    <thead>
                        <tr>
                            <th class="bg-dark text-white fs-5 font-monospace text-center">Id</th>
                            <th class="bg-dark text-white fs-5 font-monospace text-center">Name</th>
                            <th class="bg-dark text-white fs-5 font-monospace text-center">Price</th>
                            <th class="bg-dark text-white fs-5 font-monospace text-center">Image</th>
                            <th class="bg-dark text-white fs-5 font-monospace text-center">Categories</th>
                            <th class="bg-dark text-white fs-5 font-monospace text-center">Description</th>
                            <th class="bg-dark text-white fs-5 font-monospace text-center">Delete</th>
                            <th class="bg-dark text-white fs-5 font-monospace text-center">Update</th>

                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        include 'Config.php';
                        $Record = mysqli_query($conn, "SELECT * FROM `tblproduct`");

                        while ($row = mysqli_fetch_array($Record)) {
                            echo "
                            <tr>
                                <td>$row[id]</td>
                                <td>$row[PName]</td>
                                <td>$row[PPrice]</td>
                                <td><img src='$row[PImage]' height='90px' width='200px'></td>
                                <td>$row[PCategory]</td>
                                <td>$row[Paria]</td>
                                <td>
                                    <a href='delete.php?id=$row[id]' class='btn btn-danger'>Delete</a>
                                </td>
                                <td>
                                    <a href='update.php?id=$row[id]' class='btn btn-warning'>Update</a>
                                </td>

                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

