<?php
// Include database connection code
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Get user input from the form
$username = isset($_POST['username']) ? $_POST['username'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';

// Set role ID to 2 (admin)
$roleId = 2;

// Get database connection
$connInfo = connectDatabase();
$conn = $connInfo['conn'];
$settings = $connInfo['settings'];

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Before executing the query
echo "Connected successfully";

// Insert user data into the database
$sql = "INSERT INTO admins (username, email, password, roleId) VALUES ('$username', '$email', '$password', '$roleId')";

if ($conn->query($sql) === TRUE) {
    echo "User registered successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
