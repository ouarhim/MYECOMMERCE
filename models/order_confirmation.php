
<?php
// Start session
include '/opt/lampp/htdocs/myecommerceapp/includes/header.php';
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Check if the confirmation ID is provided in the query string
if(isset($_GET['confirmationId'])) {
    // Get the confirmation ID from the query string
    $confirmationId = $_GET['confirmationId'];

    // Establish database connection
    $connInfo = connectDatabase();
    $conn = $connInfo['conn'];

    // Fetch order details from the database using the confirmation ID
    $getOrderSql = "SELECT * FROM ordersConfirmation WHERE confirmationId = ?";
    $stmt = $conn->prepare($getOrderSql);
    $stmt->bind_param("i", $confirmationId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the order exists
    if ($result->num_rows > 0) {
        // Fetch order details
        $orderDetails = $result->fetch_assoc();
        // Display order confirmation message and details
        echo "<h2 class='text-center'>Order Confirmation</h2>";
        echo "<p class='text-center'>Your order has been confirmed. Here are the details:</p>";
        echo "<p class='text-center'><strong>Order ID:</strong> " . $orderDetails['orderId'] . "</p>";
        echo "<p class='text-center'><strong>Total:</strong> $" . $orderDetails['total'] . "</p>";
        echo "<p class='text-center'><strong>Shipping Address:</strong> " . $orderDetails['shippingAddress'] . "</p>";
        echo "<p class='text-center'><strong>City:</strong> " . $orderDetails['shippingCity'] . "</p>";
        echo "<p class='text-center'><strong>State:</strong> " . $orderDetails['shippingState'] . "</p>";
        echo "<p class='text-center'><strong>ZIP Code:</strong> " . $orderDetails['shippingZip'] . "</p>";
    } else {
        // If the order is not found, display an error message
        echo "<p>Sorry, we couldn't find your order. Please contact customer support for assistance.</p>";
    }

    // Close the database connection
    $conn->close();
} else {
    // If confirmation ID is not provided in the query string, redirect to an error page or homepage
    header("Location: /myecommerceapp/error.php");
    exit();
}

// Include footer or any other necessary files
include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php';
?>
<style>
body {
            background-color: #f4f4f4;
        }
        .confirmation-box {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>