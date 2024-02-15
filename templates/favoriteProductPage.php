<?php include '/opt/lampp/htdocs/myecommerceapp/includes/header.php'; ?>
<?php
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');
// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect the user to the login page if not logged in
    header("Location: /myecommerceapp/templates/signIn.php");
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

<div class="container mt-4">
    <div class="row">
        <h2>Favorite page:</h2>
        <?php while ($product = $result->fetch_assoc()) : ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <a href="/myecommerceapp/templates/productPage.php?id=<?php echo $product['productId']; ?>" class="text-decoration-none text-dark">
                    <div class="card-banner d-flex justify-content-center align-items-center rounded-2" style="height: 350px; background-image: url(<?php echo $product['image']; ?>); background-size: cover; background-position: center;"></div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text">Model: <?php echo $product['description']; ?></p>
                            <p class="card-text">$<?php echo $product['price']; ?></p>
                        </div>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php'; ?>
