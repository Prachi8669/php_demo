<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'ecommercemy';
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    // Collect data from the form
    $UserName = $_POST['name'];  // Changed variable to match typical column naming
    $Email = $_POST['email'];
    $Number = $_POST['number'];
    $Password = $_POST['password'];

    // Step 1: Check if the email already exists
    $Dup_Email = mysqli_query($conn, "SELECT * FROM `tbluser` WHERE `Email` = '$Email'");
    $Dup_UserName = mysqli_query($conn, "SELECT * FROM `tbluser` WHERE `UserName` = '$UserName'");  // Use correct column `UserName`
    
    // Step 2: If email exists, show an error message and stop the process
    if (mysqli_num_rows($Dup_Email) > 0) {
        echo "<script>
        alert('This Email is already taken');
        window.location.href='login.php';
        </script>";
        exit();
    }

    // Check if username exists
    if (mysqli_num_rows($Dup_UserName) > 0) {
        echo "<script>
        alert('This Username is already taken');
        window.location.href='register.php';
        </script>";
        exit();
    }

    // Step 3: If email and username don't exist, proceed with registration
    $stmt = $conn->prepare("INSERT INTO `tbluser` (`UserName`, `Email`, `Number`, `Password`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $UserName, $Email, $Number, $Password);

    // Execute the query and check for success
    if ($stmt->execute()) {
        // Display success popup
        echo "<script>
        alert('Registration successful!');
        window.location.href = 'login.php'; // Redirect to login page after success (optional)
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();

?>
