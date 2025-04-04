<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data using $_POST
    $Name = $_POST['name'];
    $Password = $_POST['password'];  // Corrected variable reference

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'ecommercemy';

    // Establish a connection to the database
    $conn = new mysqli($servername, $username, $password, $database);

    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM tbluser WHERE (UserName = ? OR Email = ?) AND Password = ?");
    $stmt->bind_param("sss", $Name, $Name, $Password);  // Bind parameters

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();
     session_start();
    // Check if the user is found
    if ($result->num_rows > 0) {
        
        $_SESSION['USER'] = $Name ;
        echo "
        <script>
        alert('Login successful');
        window.location.href = '../../user/index.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Incorrect email/username/password');
        window.location.href = 'login.php'; // redirect back to login
        </script>
        ";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
