<?php
// Include database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $categoryName = $_POST['categoryName'];
    $iconClass = $_POST['iconClass'];

    // Insert into categories table
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];
    $settings = $databaseInfo['settings'];
    $insertSql = "INSERT INTO categories (categoryName, iconClass) VALUES ('$categoryName', '$iconClass')";
    $result = $conn->query($insertSql);

    if ($result) {
        // Category added successfully
        header('Location: /myecommerceapp/models/categoriesModel.php'); // Redirect to categories page
        exit();
    } else {
        echo "Error adding category: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
