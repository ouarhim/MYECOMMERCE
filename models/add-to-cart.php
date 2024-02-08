<?php
session_start();

// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Retrieve form data
$productId = $_POST['productId'];
$name = $_POST['name'];
$quantity = $_POST['quantity'];

// Fetch product details from the database
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];

$productSql = "SELECT * FROM products WHERE productId = $productId";
$productResult = $conn->query($productSql);
$product = $productResult->fetch_assoc();

// Calculate total price
$totalPrice = $product['price'] * $quantity;

// Store product ID, quantity, and total price in session
$_SESSION['cart'][$productId] = [
    'name' => $name,
    'quantity' => $quantity,
    'totalPrice' => $totalPrice
];

// Redirect back to the product page
header("Location: /myecommerceapp/templates/productPage.php?id=$productId");
exit();
?>
