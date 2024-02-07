<?php
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Get product ID from the URL parameter
$productId = $_GET['id'];

// Get database information
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];

// Perform deletion
$deleteSql = "DELETE FROM products WHERE productId = $productId";
$conn->query($deleteSql);

// Redirect back to the products listing page
header('Location: /myecommerceapp/models/productModel.php');
exit();
?>
