<?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php';?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>


<?php
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Get database information
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];

// Fetch products with display order
$productsSql = "SELECT * FROM products ORDER BY displayOrder";
$productsResult = $conn->query($productsSql);

// Check if there was an error with the query
if (!$productsResult) {
    die("Error fetching products: " . $conn->error);
}

// Display products
echo '<table>';
echo '<tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Category</th><th>Stock</th><th>Action</th></tr>';

while ($product = $productsResult->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $product['productId'] . '</td>';
    echo '<td>' . $product['name'] . '</td>';
    echo '<td>' . $product['description'] . '</td>';
    echo '<td>' . $product['price'] . '</td>';
    echo '<td>' . $product['categoryId'] . '</td>';
    echo '<td>' . $product['stock'] . '</td>';
    echo '<td><a href="/myecommerceapp/models/edit-product.php?id=' . $product['productId'] . '">Edit</a> | <a href="/myecommerceapp/models/delete-product.php?id=' . $product['productId'] . '">Delete</a></td>';
    echo '</tr>';
}

echo '</table>';

// Close the database connection
$conn->close();
?>
