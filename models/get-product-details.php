<?php
// get-product-details.php

// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Check if the orderId parameter is set
if (isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];

    // Establish database connection
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];

    // Fetch product details for the given order ID
    $sql = "SELECT products.name, orderItems.quantity FROM orderItems JOIN products ON orderItems.productId = products.productId WHERE orderItems.orderId = $orderId";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Output product details as HTML
        echo "<table class='table'>";
        echo "<thead>";
        echo "<tr><th>Product Name</th><th>Quantity</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "No products found for this order.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Order ID not provided.";
}
?>
