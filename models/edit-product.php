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

// Display a form with pre-filled product details
?>
<?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php';?>
<form action="/myecommerceapp/models/update-product.php" method="post">
    <label>Image: <input type="text" name="image"  value="<?php echo $product['image']; ?>"></label><br>
    <input type="hidden" name="productId" value="<?php echo $product['productId']; ?>">
    <label>Name: <input type="text" name="name" value="<?php echo $product['name']; ?>"></label><br>
    <label>Description: <textarea name="description"><?php echo $product['description']; ?></textarea></label><br>
    <label>Price: <input type="text" name="price" value="<?php echo $product['price']; ?>"></label><br>
    <label>Category:
        <select name="categoryId">
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
    </label><br>
    <label>Stock: <input type="text" name="stock" value="<?php echo $product['stock']; ?>"></label><br>
    <!-- Add other product fields as needed -->
    <input type="submit" value="Update Product">
</form>
<?php
// Close the database connection
$conn->close();
?>
