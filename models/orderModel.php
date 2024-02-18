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

// Process delete product action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteProductId'])) {
    $deleteProductId = $_POST['deleteProductId'];
    if (isset($cart[$deleteProductId])) {
        unset($cart[$deleteProductId]);
        $_SESSION['cart'] = $cart;
    }
}

?>

<div class="container mt-4">
    <h2>Shopping Cart</h2>
    <?php if (empty($cart)) : ?>
        <p>Your cart is empty.</p>
    <?php else : ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($cart as $productId => $item) : ?>
                <?php $product = getProductDetails($productId, $conn); ?>
                <div class="col">
                    <div class="card shadow">
                        <div class="card-banner d-flex justify-content-center align-items-center rounded-2" style="height: 350px; background-image: url(<?php echo $product['image']; ?>); background-size: cover; background-position: center;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <!-- Quantity adjustment -->
                            <form action="/myecommerceapp/models/update-cart.php" method="post">
                                <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                                <div class="input-group mb-3">
                                    <input type="number" name="quantity" class="form-control" value="<?php echo $item['quantity']; ?>" min="1">
                                    <button type="submit" class="btn btn-outline-secondary">Update</button>
                                </div>
                            </form>
                            <p class="card-text">Total Price: $<?php echo $item['totalPrice']; ?></p>
                        </div>
                        <form action="/myecommerceapp/models/orderModel.php" method="post" class="position-absolute top-0 end-0 m-2">
                            <input type="hidden" name="deleteProductId" value="<?php echo $productId; ?>">
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                <?php $totalPrice += $item['totalPrice']; ?>
            <?php endforeach; ?>
        </div>
        <div class="mt-4 pb-4">Total Price: $<?php echo $totalPrice; ?>
        <form action="/myecommerceapp/models/confirm-order.php" method="post" class="mt-4">
            <button type="submit" class="btn btn-primary">Confirm Order</button>
        </form></div>
    <?php endif; ?>
</div>

<?php include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php'; ?>
