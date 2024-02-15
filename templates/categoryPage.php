<?php include '/opt/lampp/htdocs/myecommerceapp/includes/header.php';?>
<?php
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');
require_once('/opt/lampp/htdocs/myecommerceapp/includes/productCard.php');

$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];

// Check if database connection is established
if (!$conn) {
    // Handle database connection error
    echo "Database connection failed.";
    // You can also log the error to a file for further investigation
    exit();
}
// Set the number of products to display per row
$productsPerRow = $settings['productsPerRow'];


// Check if category ID is provided in the URL
if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];

    // Fetch category information
    $categorySql = "SELECT * FROM categories WHERE categoryId = $categoryId";
    $categoryResult = $conn->query($categorySql);

    
    if ($categoryResult && $categoryResult->num_rows > 0) {
        $category = $categoryResult->fetch_assoc();
        $categoryName = $category['categoryName'];
    } else {
        $categoryName = "Unknown Category";
    }

    // Fetch products in the category
    $productsSql = "SELECT * FROM products WHERE categoryId = $categoryId";
    $productsResult = $conn->query($productsSql);
    
    // Fetch user's favorite products (assuming you have this logic in another file)
    $userFavoriteProducts = []; // Initialize user favorite products array
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        $userFavoritesSql = "SELECT productId FROM user_favorites WHERE userId = $userId";
        $userFavoritesResult = $conn->query($userFavoritesSql);
        while ($row = $userFavoritesResult->fetch_assoc()) {
            $userFavoriteProducts[] = $row['productId'];
        }
    }
} else {
    // Redirect or display an error message if category ID is not provided
    header("Location: /error.php"); // Example error page
    exit();
}
?>

<!-- Display products -->
<div class="section ">
    <h2>Category: <?php echo $categoryName; ?></h2> <!-- Display the category name -->
    <div class="row row d-flex justify-content-center">
        <?php if ($productsResult && $productsResult->num_rows > 0) { ?>
            <?php while ($product = $productsResult->fetch_assoc()) { ?>
                <?php generateProductCard($product, $userFavoriteProducts); ?>
            <?php } ?>
        <?php } else { ?>
            <p>No products found in this category.</p>
        <?php } ?>
    </div>
</div>
<style>
.product-link {
    text-decoration: none; /* Remove underline */
    color: inherit; /* Inherit text color */
    
}
.section {
padding: 4%;
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

<?php include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php';?>
