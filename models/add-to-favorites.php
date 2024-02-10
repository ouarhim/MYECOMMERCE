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

        // Check if the product is already in user's favorites
        $checkSql = "SELECT * FROM user_favorites WHERE userId = ? AND productId = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ii", $userId, $productId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Product is already in favorites, so remove it
            $deleteSql = "DELETE FROM user_favorites WHERE userId = ? AND productId = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("ii", $userId, $productId);
            if ($deleteStmt->execute()) {
                // Product removed from favorites successfully
                echo json_encode(array('success' => true, 'action' => 'remove'));
            } else {
                // Error removing product from favorites
                echo json_encode(array('success' => false, 'error' => 'Error removing product from favorites'));
            }
            $deleteStmt->close();
        } else {
            // Product is not in favorites, so add it
            $addSql = "INSERT INTO user_favorites (userId, productId) VALUES (?, ?)";
            $addStmt = $conn->prepare($addSql);
            $addStmt->bind_param("ii", $userId, $productId);
            if ($addStmt->execute()) {
                // Product added to favorites successfully
                echo json_encode(array('success' => true, 'action' => 'add'));
            } else {
                // Error adding product to favorites
                echo json_encode(array('success' => false, 'error' => 'Error adding product to favorites'));
            }
            $addStmt->close();
        }

        $checkStmt->close();
    } else {
        // User is not logged in
        echo json_encode(array('success' => false, 'error' => 'User is not logged in'));
    }
} else {
    // Product ID not provided in the POST data
    echo json_encode(array('success' => false, 'error' => 'Product ID not provided'));
}
?>
