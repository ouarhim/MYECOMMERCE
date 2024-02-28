<?php
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['categoryId'], $_POST['categoryName'], $_POST['iconClass'])) {
    $categoryId = $_POST['categoryId'];
    $categoryName = $_POST['categoryName'];
    $iconClass = $_POST['iconClass'];

    // Get database information
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];

    // Update category
    $updateSql = "UPDATE categories SET categoryName = ?, iconClass = ? WHERE categoryId = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssi", $categoryName, $iconClass, $categoryId);

    if ($stmt->execute()) {
        // Category updated successfully, redirect to table.php
        header("Location: /myecommerceapp/models/categoriesModel.php");
        exit(); // Ensure no further code execution after redirection
    } else {
        echo "Error updating category: " . $conn->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
