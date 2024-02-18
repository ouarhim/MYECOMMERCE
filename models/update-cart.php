<?php
session_start();

// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Retrieve form data
$productId = $_POST['productId'];
$quantity = $_POST['quantity'];

// Validate quantity
if (!is_numeric($quantity) || $quantity < 1) {
    // Invalid quantity, redirect back to the cart page with an error message
    $_SESSION['error'] = 'Invalid quantity';
    header("Location: /myecommerceapp/models/orderModel.php");
    exit();
}

// Fetch product details from the database
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];

$productSql = "SELECT * FROM products WHERE productId = ?";
$stmt = $conn->prepare($productSql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Calculate total price
$totalPrice = $product['price'] * $quantity;

// Update quantity and total price in the session cart
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity'] = $quantity;
    $_SESSION['cart'][$productId]['totalPrice'] = $totalPrice;
}

// Redirect back to the cart page
header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
?>
