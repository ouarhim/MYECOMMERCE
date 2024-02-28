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
    $settings = $databaseInfo['settings'];

    // Fetch product details for the given order ID
    $sql = "SELECT products.name, orderItems.quantity FROM orderItems JOIN products ON orderItems.productId = products.productId WHERE orderItems.orderId = $orderId";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Output product details as HTML
        echo "<table class='table'>";
        echo "<thead>";
        echo "<tr><th>order ID</th><th>Product Name</th><th>Quantity</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $orderId . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

        // Create a form with POST method to send orderId
        echo "<form id='shipping-form' action='/myecommerceapp/models/update-shipped-status.php' method='POST'>";
        echo "<input type='hidden' name='orderId' value='" . $orderId . "'>";
        echo "<button type='submit' class='btn btn-primary confirm-shipping' data-order-id='" . $orderId . "'>Confirm Shipping</button>";
        echo "</form>";
    } else {
        echo "No products found for this order.";
    }

    // Close the database connection
    $conn->close();
} 

?>
<script>
// JavaScript to handle the confirm shipping button click event
document.addEventListener('DOMContentLoaded', function() {
    const orderId = <?php echo isset($_GET['orderId']) ? $_GET['orderId'] : 'null'; ?>;
    if (orderId) {
        // Update the shipped status in the database
        updateShippedStatus(orderId)
            .then(() => {
                // Redirect to table.php after updating shipped status
                window.location.href = '/myecommerceapp/includes/table.php';
            })
            .catch(error => console.error('Error updating shipped status:', error));
    } else {
        console.error('Order ID not provided.');
    }
});

// Function to update shipped status via AJAX
async function updateShippedStatus(orderId) {
    try {
        const response = await fetch('/myecommerceapp/models/update-shipped-status.php', {
            method: 'POST',
            body: JSON.stringify({ orderId: orderId }), // Send orderId in the request body
            headers: {
                'Content-Type': 'application/json'
            }
        });
        const data = await response.text();
        // Log the response or handle it as per your requirement
        console.log(data);
    } catch (error) {
        throw new Error('Error updating shipped status:', error);
    }
}
</script>
