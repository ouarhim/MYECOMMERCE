<?php
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Get product ID from the URL parameter
$productId = $_GET['id'];

// Confirm deletion
echo '<p>Are you sure you want to delete this product?</p>';
echo '<a href="/myecommerceapp/models/confirm-delete-product.php?id=' . $productId . '">Yes</a> | <a href="/myecommerceapp/models/productModel.php">No</a>';
?>
