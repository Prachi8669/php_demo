<?php
// Check if 'ID' is passed in the URL
if (isset($_GET['ID']) && is_numeric($_GET['ID'])) {
    $ID = $_GET['ID']; // Get the ID from the URL parameter

    // Database connection
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'ecommercemy';
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Correct SQL query: Remove the '*' in the DELETE statement
    $sql = "DELETE FROM `tbluser` WHERE `id` = $ID";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect to the user.php page after successful deletion
        echo "<script>
                
                window.location.href='user.php'; // redirect back to the user list page
              </script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid ID.";
}
?>
