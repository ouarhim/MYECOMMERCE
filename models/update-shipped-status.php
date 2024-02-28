<?php
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Check if orderId is provided
if (isset($_POST['orderId'])) {
    $orderId = $_POST['orderId'];

    // Establish database connection
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];

    // Update shipped status in the ordersConfirmation table
    $updateSql = "UPDATE ordersConfirmation SET shipped = 1 WHERE orderId = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
          // Shipped status updated successfully, redirect to table.php
          header("Location: /myecommerceapp/includes/table.php");
          exit(); // Ensure no further code execution after redirection
    } else {
        echo "Error updating shipped status: " . $conn->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Order ID not provided";
}
?>

<script>
    // JavaScript to handle the ship order button click event
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('confirm-shipping')) {
            e.preventDefault(); // Prevent default form submission
            let orderId = e.target.dataset.orderId;
            // Fetch product details via AJAX and display them in the modal
            fetchProducts(orderId);
            // Update the shipped status in the database
            updateShippedStatus(orderId);
        }
    });

    // Function to fetch product details via AJAX
    function fetchProducts(orderId) {
        fetch('/myecommerceapp/models/get-product-details.php?orderId=' + orderId)
            .then(response => response.text())
            .then(data => {
                document.getElementById('productDetails').innerHTML = data;
                $('#productModal').modal('show');
            })
            .catch(error => console.error('Error fetching product details:', error));
    }
    
    // Function to update shipped status via AJAX
    function updateShippedStatus(orderId) {
        fetch('/myecommerceapp/models/update-shipped-status.php?orderId=' + orderId, { method: 'POST' })
            .then(response => response.text())
            .then(data => console.log('Shipped status updated:', data))
            .catch(error => console.error('Error updating shipped status:', error));
    }
</script>

