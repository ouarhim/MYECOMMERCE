<?php
// admin/process-add-product.php
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get product details from the form
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $stock = $_POST['stock'];
    $rowPosition = $_POST['rowPosition'];
    $positionInRow = $_POST['positionInRow'];
    $displayOrder = $_POST['displayOrder'];
    $categoryId = $_POST['categoryId']; // Add this line to get category ID

    // Validate input (add more validation as needed)

    // Insert the new product into the database
    // Get database information
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];
    $settings = $databaseInfo['settings'];

    $insertSql = "INSERT INTO products (name, description, price, image, stock, rowPosition, positionInRow, displayOrder, categoryId) 
                  VALUES ('$name', '$description', $price, '$image', $stock, $rowPosition, $positionInRow, $displayOrder, $categoryId)";

    if ($conn->query($insertSql) === TRUE) {
        echo "Product added successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
