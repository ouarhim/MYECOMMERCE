<?php 
include '/opt/lampp/htdocs/myecommerceapp/includes/header.php';?>

<div class="container mt-5">
    <h1>Search Results</h1>
    <?php
    // Include the database connection file
    require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];
    $settings = $databaseInfo['settings'];

    // Check if the query parameter is set
    if (isset($_GET['query'])) {
        // Get the search query from the URL
        $searchQuery = $_GET['query'];

        // Sanitize the search query to prevent SQL injection (optional)
        // Here, we'll use mysqli_real_escape_string to sanitize the input
        $searchQuery = mysqli_real_escape_string($conn, $searchQuery);

        // Perform the database search query to find products matching the search query
        $sql = "SELECT * FROM products WHERE name LIKE '%$searchQuery%'";
        $result = $conn->query($sql);

        $userFavoriteProducts = [];
        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
            $userFavoritesSql = "SELECT productId FROM user_favorites WHERE userId = $userId";
            $userFavoritesResult = $conn->query($userFavoritesSql);
            while ($row = $userFavoritesResult->fetch_assoc()) {
                $userFavoriteProducts[] = $row['productId'];
            }
        }

        // Check if there are any matching products
        if ($result->num_rows > 0) {
            echo "<p>Showing results for: $searchQuery</p>";

            // Output each matching product
            echo '<div class="row">';
            while ($row = $result->fetch_assoc()) {
                $buttonColorClass = (in_array($row['productId'], $userFavoriteProducts)) ? 'text-danger' : 'text-secondary';

                echo '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">';
                echo '<div class="card my-2 shadow-sm border-1" style="height: 520px;">';
                echo '<a href="/myecommerceapp/templates/productPage.php?id=' . $row['productId'] . '" class="product-link text-decoration-none">';
                echo '<div class="card-banner d-flex justify-content-center align-items-center rounded-2" style="height: 350px; background-image: url(\'' . $row['image'] . '\'); background-size: cover; background-position: center;">';
                echo '<div class="badge bg-danger position-absolute top-0 start-0 pt-1">';
                echo '<h6><span class="badge bg-danger top-0 start-0 p-0">New</span></h6>';
                echo '</div>';
                echo '</div>';
                echo '<div class="card-body p-3 pb-0">';
                echo '<h5 class="card-title mb-1">' . $row['name'] . '</h5>';
                echo '<p class="card-text text-muted mb-1 small" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">';
                echo 'Discr: ' . $row['description'];
                echo '</p>';
                echo '<p class="card-text text-muted mb-1 small"><span class="text-danger fw-bold">$' . $row['price'] . '</span> <del class="text-muted small">$' . ($row['price'] * 1.2) . '</del></p>';
                echo '</div>';
                echo '</a>';
                echo '<div class="card-footer bg-white border-top-0">';
                echo '<form action="/myecommerceapp/models/add-to-favorites.php" method="post" class="d-inline">';
                echo '<input type="hidden" name="productId" value="' . $row['productId'] . '">';
                echo '<button type="submit" class="btn btn-light border px-2 pt-2 float-end icon-hover toggle-color"><i class="far fa-heart ' . $buttonColorClass . '"></i></button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            // No matching products found
            echo "<p>No matching products found.</p>";
        }
    } else {
        // No query parameter provided
        echo "<p>No search query specified.</p>";
    }
    ?>
</div>
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


<?php include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php'; ?>
