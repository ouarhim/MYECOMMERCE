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
        echo '<div class="row d-flex justify-content-center">';
    }

    echo '<div class="col-lg-' . (12 / $productsPerRow) . ' col-md-' . (12 / $productsPerRow) . ' col-sm-6">';
    echo '<div class="card my-2 shadow-0">';
    echo '<a href="/myecommerceapp/templates/productPage.php?id=' . $product['productId'] . '" class="product-link">'; // Link to product page
    echo '<div class="card-banner d-flex justify-content-center align-items-center rounded-2" style="height: 350px; background-image: url(\'' . $product['image'] . '\'); background-size: cover; background-position: center;">';
    echo '<div class="badge bg-danger position-absolute top-0 start-0 p-2">';
    echo '<h6><span class="badge bg-danger top-0 start-0 p-0">New</span></h6>';
    echo '</div>';
    echo '</div>';
    echo '<div class="mask" style="height: 50px;"></div>';
    echo '<div class="card-body p-0 pt-3">';
    echo '<form action="/myecommerceapp/models/add-to-favorites.php" method="post" class="d-inline">';
    echo '<input type="hidden" name="productId" value="' . $product['productId'] . '">';
    echo '<button type="submit" class="btn btn-light border px-2 pt-2 float-end icon-hover toggle-color"><i class="fas fa-heart fa-lg px-1 text-secondary"></i></button>';
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

            // Send the AJAX request to add the product to the user's favorites
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
