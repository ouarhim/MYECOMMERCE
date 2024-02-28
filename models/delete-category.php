<?php
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Define a variable to hold the error message
$errorMsg = "";

try {
    // Check if categoryId is provided
    if (isset($_GET['categoryId'])) {
        $categoryId = $_GET['categoryId'];

        // Get database information
        $databaseInfo = connectDatabase();
        $conn = $databaseInfo['conn'];

        // Delete category
        $deleteSql = "DELETE FROM categories WHERE categoryId = ?";
        $stmt = $conn->prepare($deleteSql);
        $stmt->bind_param("i", $categoryId);

        if ($stmt->execute()) {
            // Category deleted successfully, redirect to table.php
            header("Location: /myecommerceapp/models/categoriesModel.php");
            exit(); // Ensure no further code execution after redirection
        } else {
            $errorMsg = "Error deleting category. Please try again later."; // Custom error message
        }

        // Close the prepared statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // Set the error message when category ID is not provided
        $errorMsg = "Category ID not provided.";
    }
} catch (mysqli_sql_exception $e) {
    // Catch any mysqli_sql_exception and set a custom error message
    $errorMsg = "delet all products from this category ID  $categoryId "; // Custom error message
}

// Display the error message
echo "<script>";
echo "window.onload = function() {";
echo "  var errorMsg = '" . addslashes($errorMsg) . "';";
echo "  if (errorMsg !== '') {";
echo "    alert(errorMsg);";
echo "  }";
echo "}";
echo "</script>";
?>
