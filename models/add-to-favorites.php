<?php
session_start();
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Check if the productId is set in the POST data
if (isset($_POST['productId'])) {
    // Check if the user is logged in
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        $productId = $_POST['productId'];

        // Connect to the database
        $databaseInfo = connectDatabase();
        $conn = $databaseInfo['conn'];
        $settings = $databaseInfo['settings'];

        // Prepare and execute the SQL query to insert the product into user's favorites
        $sql = "INSERT INTO user_favorites (userId, productId) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $userId, $productId);

        if ($stmt->execute()) {
            // Product added to favorites successfully
            echo json_encode(array('success' => true));
        } else {
            // Error inserting product into favorites
            echo json_encode(array('success' => false, 'error' => 'Error inserting product into favorites'));
        }

        $stmt->close();
    } else {
        // User is not logged in
        echo json_encode(array('success' => false, 'error' => 'User is not logged in'));
    }
} else {
    // Product ID not provided in the POST data
    echo json_encode(array('success' => false, 'error' => 'Product ID not provided'));
}
?>
