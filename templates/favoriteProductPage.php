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
        <h2>Favorite Products:</h2>
        <?php while ($product = $result->fetch_assoc()) : ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card my-2 shadow-sm border" style="height: 550px">
                    <a href="/myecommerceapp/templates/productPage.php?id=<?php echo $product['productId']; ?>" class="text-decoration-none text-dark">
                        <div class="card-banner d-flex justify-content-center align-items-center rounded-2" style="height: 350px; background-image: url(<?php echo $product['image']; ?>); background-size: cover; background-position: center;"></div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text text-muted mb-1 small" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Model: <?php echo $product['description']; ?></p>
                            <p class="card-text text-muted mb-1 small"><span class="text-danger fw-bold">$<?php echo $product['price']; ?></span> <del class="text-muted small">$<?php echo $product['price']*1.2; ?></del></p>
                            </a>
                            <form action="/myecommerceapp/models/add-to-cart.php" method="post">
                            <input type="hidden" name="productId" value="<?php echo $product['productId']; ?>">
                                <div class="form-group">
                                <div class="form-group row">
                                <label for="quantity" class="col-sm-8 col-form-label">Quantity:</label>
                                <div class="col-sm-1 end-0">
                                    <input type="number" id="quantity" name="quantity" class="form-control ps-10 pe-0" value="1" min="1" style="width: 50px;">
                                </div>
                            </div>

                            </div>
                                <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                            </form>
                        </div>
                    
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php'; ?>
