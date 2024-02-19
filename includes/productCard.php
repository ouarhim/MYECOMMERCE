<?php

function generateProductCard($product, $userFavoriteProducts) {
    $isFavorite = in_array($product['productId'], $userFavoriteProducts);
    // Determine the color class for the heart icon based on whether the product is in favorites
    $buttonColorClass = (in_array($product['productId'], $userFavoriteProducts)) ? 'text-danger' : 'text-secondary';

    
    echo '<div class="col-lg-4 col-md-6 mb-4">';
    echo '<div class="card my-2 shadow-sm border-1" style="height: 520px;">';
    echo '<a href="/myecommerceapp/templates/productPage.php?id=' . $product['productId'] . '" class="product-link text-decoration-none">';
    echo '<div class="card-banner d-flex justify-content-center align-items-center rounded-2" style="height: 350px; background-image: url(\'' . $product['image'] . '\'); background-size: cover; background-position: center;">';
    echo '<div class="badge bg-danger position-absolute top-0 start-0 pt-1">';
    echo '<h6><span class="badge bg-danger top-0 start-0 p-0">New</span></h6>';
    echo '</div>';
    echo '</div>';
    echo '<div class="card-body p-3 pb-0">';
    echo '<h5 class="card-title mb-1">' . $product['name'] . '</h5>';
    echo '<p class="card-text text-muted mb-1 small" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">';
    echo 'Discr: ' . $product['description'];
    echo '</p>';
    echo '<p class="card-text text-muted mb-1 small"><span class="text-danger fw-bold">$' . $product['price'] . '</span> <del class="text-muted small">$' . ($product['price'] * 1.2) . '</del></p>';
    echo '</div>';
    echo '</a>';
    echo '<div class="card-footer bg-white border-top-0">';
    echo '<form action="/myecommerceapp/models/add-to-favorites.php" method="post" class="d-inline">';
    echo '<input type="hidden" name="productId" value="' . $product['productId'] . '">';
    echo '<button type="submit" class="btn btn-light border px-2 pt-2 float-end icon-hover toggle-color"><i class="far fa-heart ' . $buttonColorClass . '"></i></button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

}

?>


