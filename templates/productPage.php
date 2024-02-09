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
            <img src="<?php echo $product['image']; ?>" class="img-fluid" alt="Product Image">
        </div>
        <div class="col-md-6">
            <!-- Product Details -->
            <h2><?php echo $product['name']; ?></h2>
            <p class="text-muted">Category: <?php echo $categories['categoryName']; ?></p>
            <p class="text-muted">Description: <?php echo $product['description']; ?></p>
            <p class="lead">Price: $<?php echo $product['price']; ?></p>
            <!-- Add to Cart Form -->
            <form action="/myecommerceapp/models/add-to-cart.php" method="post">
                <input type="hidden" name="productId" value="<?php echo $product['productId']; ?>">
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1">
                </div>
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>
</div>

<?php include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php'; ?>
