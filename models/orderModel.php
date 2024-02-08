<?php include '/opt/lampp/htdocs/myecommerceapp/includes/header.php'; ?>
<?php
session_start();

// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Retrieve stored product information from session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Display selected products and total price
foreach ($cart as $productId => $item) {
    // Fetch product details from the database
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];
    $settings = $databaseInfo['settings'];

    $productSql = "SELECT * FROM products WHERE productId = $productId";
    $productResult = $conn->query($productSql);
    $product = $productResult->fetch_assoc();
    // Display product details, quantity, and total price
    echo "Product Name: {$product['name']}, Quantity: {$item['quantity']}, Total Price: {$item['totalPrice']} <br>";
}
?>

<!-- Add a button to confirm the order -->

<form action="/myecommerceapp/models/confirm-order.php" method="post">
    <button type="submit">Confirm Order</button>
</form>
<?php include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php'; ?>
