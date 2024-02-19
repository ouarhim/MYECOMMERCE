<?php
// Include the database connection file
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');
 // Get database information
 $databaseInfo = connectDatabase();
 $conn = $databaseInfo['conn'];
 $settings = $databaseInfo['settings'];

// Check if the query parameter is set
if (isset($_POST['query'])) {
    // Get the search query
    $searchQuery = $_POST['query'];

    // Sanitize the search query to prevent SQL injection
    $searchQuery = mysqli_real_escape_string($databaseInfo['conn'], $searchQuery); // Adjust as needed based on your database connection info

    // Prepare the SQL statement to search for products
    $sql = "SELECT * FROM products WHERE name LIKE '%$searchQuery%'";
    
    // Execute the SQL statement
    $result = $databaseInfo['conn']->query($sql); // Adjust as needed based on your database connection info

    // Check if there are any matching products
    if ($result->num_rows > 0) {
        // Display the matching products
        while ($row = $result->fetch_assoc()) {
            echo '<a class="dropdown-item product-link" style=" " href="/myecommerceapp/templates/productPage.php?id=' . $row['productId'] . '">' . $row['name'] . '</a>';

        }
    } else {
        // No matching products found
        echo '<span class="dropdown-item">No matching products found.</span>';
    }
} else {
    // Query parameter not provided
    echo '<span class="dropdown-item">Invalid request.</span>';
}
?>
<style>
  .px-1 {
    padding-right: 20.25rem!important;
    padding-left: 0.25rem!important;
}
  .mt-1 {
    margin-top: 2.5rem!important;
}
    .product-link {
    display: block;
    padding: 0.5rem 1rem;
    color: rgb(214, 122, 127);
    text-decoration: none;
}

.product-link:hover {
    background-color: #f8f9fa; /* Change the background color on hover */
    color: #000; /* Change the color on hover */
}

</style>