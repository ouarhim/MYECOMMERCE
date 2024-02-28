<?php
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Fetch products with display order
$productsSql = "SELECT * FROM products WHERE productId != $productId ORDER BY displayOrder DESC LIMIT 8";
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];
$productsResult = $conn->query($productsSql);

// Set the number of products to display per row
$productsPerRow = $settings['productsPerRow'];

// Fetch user's favorite products
$userFavoriteProducts = [];
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $userFavoritesSql = "SELECT productId FROM user_favorites WHERE userId = $userId";
    $userFavoritesResult = $conn->query($userFavoritesSql);
    while ($row = $userFavoritesResult->fetch_assoc()) {
        $userFavoriteProducts[] = $row['productId'];
    }
}

// Display products
$counter = 0;
while ($product = $productsResult->fetch_assoc()) {
    if ($counter % $productsPerRow === 0) {
        echo '<div class="row d-flex justify-content-center">';
    }

    // Determine the color class for the heart icon based on whether the product is in favorites
    $buttonColorClass = (in_array($product['productId'], $userFavoriteProducts)) ? 'text-danger' : 'text-secondary';

    echo '<div class="col-lg-' . (12 / $productsPerRow) . ' col-md-' . (12 / $productsPerRow) . ' col-sm-6">';
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
<style>
.product-link {
    text-decoration: none; /* Remove underline */
    color: inherit; /* Inherit text color */
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const toggleButtons = document.querySelectorAll('.toggle-color');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const form = button.parentElement;
            const productId = form.querySelector('input[name="productId"]').value;

            // Toggle the color of the heart icon
            const heartIcon = button.querySelector('i.fa-heart');
            heartIcon.classList.toggle('text-secondary');
            heartIcon.classList.toggle('text-danger');

            // Send the AJAX request to add or remove the product from the user's favorites
            fetch('/myecommerceapp/models/add-to-favorites.php', {
                method: 'POST',
                body: new FormData(form),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data); // Log the response data for debugging
                // Optionally, you can show a message or update UI based on the response
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle errors here
            });
        });
    });
});
</script>
