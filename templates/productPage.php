<?php

// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Get product ID from the URL parameter
$productId = isset($_GET['id']) ? $_GET['id'] : '';

// Get database information
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];

// Retrieve product details
$productSql = "SELECT * FROM products WHERE productId = $productId";
$productResult = $conn->query($productSql);
$product = $productResult->fetch_assoc();

// Fetch categories for dropdown
$categoriesSql = "SELECT * FROM categories";
$categoriesResult = $conn->query($categoriesSql);
$categories = $categoriesResult->fetch_assoc();
?>

<?php include '/opt/lampp/htdocs/myecommerceapp/includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Product Image -->
            <div class="card-banner d-flex justify-content-center align-items-center rounded-2" style="height: 400px; background-image: url(<?php echo $product['image']; ?>); background-size: cover; background-position: center;"></div>
        </div>
        <div class="col-md-6">
            <!-- Product Details -->
            <h2 class="mb-3"><?php echo $product['name']; ?></h2>
            <p class="text-muted">Category: <?php echo $categories['categoryName']; ?></p>
            <p class="text-muted">Description: <?php echo $product['description']; ?></p>
            <p class="card-text text-muted mb-1 small"><span class="text-danger fw-bold">$<?php echo $product['price']; ?></span> <del class="text-muted small">$<?php echo $product['price']*1.2; ?></del></p>
            <!-- Add to Cart Form -->
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

<?php include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php'; ?>
