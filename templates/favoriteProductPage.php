<?php
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Check if the user is logged in
session_start();
if (!isset($_SESSION['userId'])) {
    // Redirect the user to the login page if not logged in
    header("Location: /myecommerceapp/login.php");
    exit();
}

$userId = $_SESSION['userId'];

$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];

$sql = "SELECT products.* FROM products INNER JOIN user_favorites ON products.productId = user_favorites.productId WHERE user_favorites.userId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<?php include '/opt/lampp/htdocs/myecommerceapp/includes/header.php'; ?>
<?php
while ($product = $result->fetch_assoc()) {
    // Display the product details here
    echo '<div class="card" style="width: 18rem;">';
    echo '<img src="' . $product['image'] . '" class="card-img-top" alt="' . $product['name'] . '">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $product['name'] . '</h5>';
    echo '<p class="card-text">' . $product['description'] . '</p>';
    echo '<p class="card-text">Price: $' . $product['price'] . '</p>';
    echo '<form action="/myecommerceapp/includes/remove_from_favorites.php" method="post">';
    echo '<input type="hidden" name="productId" value="' . $product['productId'] . '">';
    echo '<button type="submit" class="btn btn-danger">Remove from Favorites</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
}

$stmt->close();
?>
<?php include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php';?>
