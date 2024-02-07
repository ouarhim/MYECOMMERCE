<?php
session_start();

// Include database connection code
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user input from the form
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Get database connection
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];
    $settings = $databaseInfo['settings'];

    // Check if the user exists
    $sql = "SELECT userId, username, email, password, roleId FROM users WHERE email = '$email'
    UNION
    SELECT adminId as userId, username, email, password, roleId FROM admins WHERE email = '$email'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct
            $_SESSION['userId'] = $row['userId'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['roleId'] = $row['roleId'];

            if ($_SESSION['roleId'] == 1) {
                // Super Admin
                header('Location: /myecommerceapp/templates/adminDashboard.php');
            } elseif ($_SESSION['roleId'] == 2) {
                // Admin
                header('Location: /myecommerceapp/templates/adminDashboard.php');
            } else {
                // Regular User
                header('Location: /myecommerceapp/index.php');
            }
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }

    // Close the database connection
    $conn->close();
}
?>
