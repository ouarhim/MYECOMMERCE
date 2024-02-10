<?php 
include '/opt/lampp/htdocs/myecommerceapp/includes/header.php';

session_start();

// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Function to fetch product details from the database
function getProductDetails($productId, $conn) {
    $productSql = "SELECT * FROM products WHERE productId = $productId";
    $productResult = $conn->query($productSql);
    return $productResult->fetch_assoc();
}

// Retrieve stored product information from session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Establish database connection
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];

// Initialize total price variable
$totalPrice = 0;

// Display selected products and total price
foreach ($cart as $productId => $item) {
    $product = getProductDetails($productId, $conn);

    // Display product details, including image, quantity, name, and total price
    echo '<div class="col-lg-4 col-md-4 col-sm-6">';
    echo '<div class="card my-2 shadow-0">';
    echo '<img src="' . $product['image'] . '" class="card-img-top" alt="' . $product['name'] . '">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $product['name'] . '</h5>';
    echo '<p class="card-text">Quantity: ' . $item['quantity'] . '</p>';
    echo '<p class="card-text">Total Price: $' . $item['totalPrice'] . '</p>';
    echo '</div>'; // Close card-body
    echo '</div>'; // Close card
    echo '</div>'; // Close column

    // Update total price
    $totalPrice += $item['totalPrice'];
}

?>

<!-- Display total price -->
<div>Total Price: $<?php echo $totalPrice; ?></div>

<form action="/myecommerceapp/models/confirm-order.php" method="post">
    <button type="submit" class="btn btn-primary">Confirm Order</button>
</form>

<?php include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php'; ?>
