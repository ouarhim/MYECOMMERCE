<?php
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];
// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productId = $_POST['productId'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $categoryId = $_POST['categoryId'];
    $stock = $_POST['stock'];
    $image = $_POST['image'];

    // Validate and update product in the database
    $updateSql = "UPDATE products SET name = '$name', description = '$description', price = $price, categoryId = $categoryId, stock = $stock, image = '$image' WHERE productId = $productId";
    $conn->query($updateSql);

    // Redirect back to the products listing page
    header('Location: /myecommerceapp/models/productModel.php');
    exit();
}
?>
