<?php
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Fetch products with display order
$productsSql = "SELECT * FROM products ORDER BY displayOrder";
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];
$productsResult = $conn->query($productsSql);

// Set the number of products to display per row
$productsPerRow = $settings['productsPerRow'];

// Display products
$counter = 0;
while ($product = $productsResult->fetch_assoc()) {
    if ($counter % $productsPerRow === 0) {
        echo '<div class="row">';
    }

    echo '<div class="col-lg-' . (12 / $productsPerRow) . ' col-md-' . (12 / $productsPerRow) . ' col-sm-6">';
    echo '<div class="card my-2 shadow-0">';
    echo '<a href="/myecommerceapp/templates/productPage.php?id=' . $product['productId'] . '" class="">'; // Link to product page
    echo '<div class="mask" style="height: 50px;">';
    echo '<div class="d-flex justify-content-start align-items-start h-100 m-2">';
    echo '<h6><span class="badge bg-danger pt-1">New</span></h6>';
    echo '</div>'; 
    echo '</div>';
    echo '<img src="' . $product['image'] . '" class="card-img-top rounded-2" style="aspect-ratio: 1 / 1"/>';
    echo '</a>';
    echo '<div class="card-body p-0 pt-3">';
    echo '<a href="#!" class="btn btn-light border px-2 pt-2 float-end icon-hover"><i class="fas fa-heart fa-lg px-1 text-secondary"></i></a>';
    echo '<h5 class="card-title">$' . $product['price'] . '</h5>';
    echo '<p class="card-text mb-0">' . $product['name'] . '</p>';
    echo '<p class="text-muted">';
    echo 'Model: ' . $product['description'];
    echo '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    if ($counter % $productsPerRow === $productsPerRow - 1) {
        echo '</div>';
    }

    $counter++;
}

// Close the last row if there are remaining cards
if ($counter % $productsPerRow !== 0) {
    echo '</div>';
}
?>
