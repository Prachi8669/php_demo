<?php
$conn = new mysqli("localhost", "root", "", "ecommercemy");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare statement with placeholder
    $stmt = $conn->prepare("DELETE FROM tblproduct WHERE id = ?");
    if ($stmt) {
        // Bind parameter
        $stmt->bind_param("i", $id);

        // Execute and check if successful
        if ($stmt->execute()) {
           echo " <script>
        alert('Record deleted successfully.');
        window.location.href='index.php'; // redirect to admin page
        </script>";
           
        } else {
            echo "Error deleting record: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Invalid ID.";
}

// Close connection
$conn->close();
?>