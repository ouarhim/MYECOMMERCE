<?php
session_start();

// Check if the request method is POST and if the deleteProductId is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteProductId'])) {
    // Include the database connection
    require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];
    $settings = $databaseInfo['settings'];
    

    // Check if the user is logged in
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        $deleteProductId = $_POST['deleteProductId'];

        // Prepare and execute the SQL query to delete the product from user's favorites
        $deleteSql = "DELETE FROM user_favorites WHERE userId = ? AND productId = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("ii", $userId, $deleteProductId);

        // Execute the delete statement
        if ($deleteStmt->execute()) {
            // Product successfully deleted from favorites
            echo "Product successfully deleted from favorites.";
            header("Location: /myecommerceapp/templates/favoriteProductPage.php");
            exit(); // Terminate the script
        } else {
            // Error occurred while deleting the product
            echo "Error: " . $conn->error; // Output any error message from the database
            exit(); // Terminate the script
        }

    } else {
        // User is not logged in
        http_response_code(401); // Unauthorized
        echo "User is not logged in.";
        exit(); // Terminate the script
    }
} else {
    // Invalid request method or deleteProductId not provided
    http_response_code(400); // Bad Request
    echo "Invalid request.";
    exit(); // Terminate the script
}
?>
