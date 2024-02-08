<?php
session_start();

// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Retrieve stored product information from session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// If the cart is empty, redirect to the homepage or any other page
if (empty($cart)) {
    header("Location: /myecommerceapp/index.php");
    exit();
}

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: /myecommerceapp/login.php");
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['userId'];

// Initialize variables for order total
$totalPrice = 0;

// Establish database connection
$connInfo = connectDatabase();
$conn = $connInfo['conn'];
$settings = $connInfo['settings'];

// Calculate total price and build the order details
foreach ($cart as $productId => $item) {
    // Fetch product details from the database
    $productSql = "SELECT price FROM products WHERE productId = ?";
    $stmt = $conn->prepare($productSql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    // Calculate total price for each item
    $totalPrice += $product['price'] * $item['quantity'];
}

// Insert order details into the database
$orderDate = date("Y-m-d H:i:s");
$insertOrderSql = "INSERT INTO orders (userId, total, orderDate) VALUES (?, ?, ?)";
$stmt = $conn->prepare($insertOrderSql);
$stmt->bind_param("ids", $userId, $totalPrice, $orderDate);

if ($stmt->execute()) {
    $orderId = $stmt->insert_id; // Get the auto-generated order ID

    // Now, insert each product in the cart into the order_items table
    foreach ($cart as $productId => $item) {
        $quantity = $item['quantity'];
        $totalPrice = $item['totalPrice'];

        $insertOrderItemSql = "INSERT INTO orderItems (orderId, productId, quantity, totalPrice) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertOrderItemSql);
        $stmt->bind_param("iiid", $orderId, $productId, $quantity, $totalPrice);
        $stmt->execute();
    }

    // Clear the stored product information from the session after confirming the order
    unset($_SESSION['cart']);

    // Redirect to a confirmation page or any other desired page
    header("Location: /myecommerceapp/ordermodel.php?orderId=$orderId");
    exit();
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
