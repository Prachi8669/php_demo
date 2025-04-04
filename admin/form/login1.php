
<?php
session_start();
$servername = 'localhost';
$username = 'root';
$password = "";
$database = 'ecommercemy';

// Database connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['username'];
    $user_password = $_POST['userpassword'];

    // Checking if user is an admin
    $stmt_admin = $conn->prepare("SELECT * FROM `admin` WHERE username = ? AND userpassword = ?");
    $stmt_admin->bind_param("ss", $user_name, $user_password);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    // If found in admin table, set session for admin
    if ($result_admin->num_rows > 0) {
        $_SESSION['admin'] = $user_name;
        echo "
        <script>
        alert('Admin login successful!');
        window.location.href='../mystore.php'; // redirect to admin page
        </script>";
    } else {
        // Checking if user is a regular user
        $stmt_user = $conn->prepare("SELECT * FROM `admin` WHERE username = ? AND userpassword = ?");
        $stmt_user->bind_param("ss", $user_name, $user_password);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user->num_rows > 0) {
            $_SESSION['user'] = $user_name;
            echo "
            <script>
            alert('User login successful!');
            window.location.href='index.php'; // redirect to user home page
            </script>";
        } else {
            echo "
            <script>
            alert('Invalid username/password');
            window.location.href='login.php'; // redirect to login page if invalid credentials
            </script>";
        }
    }
    $stmt_admin->close();
    $stmt_user->close();
}

$conn->close();
?>
