<?php

function generateProductCard($product, $userFavoriteProducts) {
    $isFavorite = in_array($product['productId'], $userFavoriteProducts);
    
    echo '<div class="col-lg-4 col-md-6 mb-4">';
    echo '<div class="card my-2 shadow-0">';
    echo '<a href="/myecommerceapp/templates/productPage.php?id=' . $product['productId'] . '" class="product-link">'; // Link to product page
    echo '<div class="card-banner d-flex justify-content-center align-items-center rounded-2" style="height: 350px; background-image: url(\'' . $product['image'] . '\'); background-size: cover; background-position: center;">';
    echo '<div class="badge bg-danger position-absolute top-0 start-0 pt-1">';
    echo '<h6><span class="badge bg-danger top-0 start-0 p-0">New</span></h6>';
    echo '</div>';
    echo '</div>';
    echo '<div class="mask" style="height: 50px;"></div>';
    echo '<div class="card-body p-0 pt-3">';
    echo '<form action="/myecommerceapp/models/add-to-favorites.php" method="post" class="d-inline">';
    echo '<input type="hidden" name="productId" value="' . $product['productId'] . '">';
    // Check if the product is already in favorites and set the button color accordingly
    $buttonColorClass = (in_array($product['productId'], $userFavoriteProducts)) ? 'text-danger' : 'text-secondary';
    echo '<button type="submit" class="btn btn-light border px-2 pt-2 float-end icon-hover toggle-color"><i class="fas fa-heart fa-lg px-1 ' . $buttonColorClass . '"></i></button>';
    echo '</form>';
    echo '<h5 class="card-title">$' . $product['price'] . '</h5>';
    echo '<p class="card-text mb-0">' . $product['name'] . '</p>';
    echo '<p class="text-muted">';
    echo 'Model: ' . $product['description'];
    echo '</p>';
    echo '</div>';
    echo '</a>';
    echo '</div>';
    echo '</div>';
}

?>


