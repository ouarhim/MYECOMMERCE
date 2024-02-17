<?php
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Get product ID from the URL parameter
$productId = $_GET['id'];

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

// Include header
include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php';
?>

<div class="container mt-5">
    <h1>Edit Product</h1>
    <form action="/myecommerceapp/models/update-product.php" method="post">
        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="text" class="form-control" id="image" name="image" value="<?php echo $product['image']; ?>">
        </div>
        <input type="hidden" name="productId" value="<?php echo $product['productId']; ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" name="description"><?php echo $product['description']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>">
        </div>
        <div class="mb-3">
            <label for="categoryId" class="form-label">Category:</label>
            <select class="form-select" id="categoryId" name="categoryId">
                <?php
                while ($category = $categoriesResult->fetch_assoc()) {
                    echo '<option value="' . $category['categoryId'] . '"';
                    if ($category['categoryId'] == $product['categoryId']) {
                        echo ' selected';
                    }
                    echo '>' . $category['categoryName'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock:</label>
            <input type="text" class="form-control" id="stock" name="stock" value="<?php echo $product['stock']; ?>">
        </div>
        <!-- Add other product fields as needed -->
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

<?php
// Close the database connection
$conn->close();
?>
