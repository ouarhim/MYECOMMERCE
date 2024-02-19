<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start(); // Start output buffering


// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/header.php');
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    // Validate form inputs (e.g., credit card information, address details)
    // For demonstration purposes, assume the form data is valid

    // Get order ID from the query string
    $orderId = $_GET['orderId']; // Ensure to validate and sanitize user inputs

    // Get form data
    $creditCardNumber = $_POST['credit_card_number'];
    $expirationDate = $_POST['expiration_date'];
    $cvv = $_POST['cvv'];
    $shippingAddress = $_POST['shipping_address'];
    $shippingCity = $_POST['shipping_city'];
    $shippingState = $_POST['shipping_state'];
    $shippingZip = $_POST['shipping_zip'];

    // Establish database connection
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];
    $settings = $databaseInfo['settings'];

    // Retrieve total price from the orders table
    $selectOrderSql = "SELECT total FROM orders WHERE orderId = ?";
    $stmt = $conn->prepare($selectOrderSql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $orderTotalPrice = $order['total'];

    // Insert order details into the ordersConfirmation table
    $orderDate = date("Y-m-d H:i:s");
    $insertOrderSql = "INSERT INTO ordersConfirmation (orderId, userId, total, shippingAddress, shippingCity, shippingState, shippingZip) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertOrderSql);
    $stmt->bind_param("iiissss", $orderId, $_SESSION['userId'], $orderTotalPrice, $shippingAddress, $shippingCity, $shippingState, $shippingZip);

    if ($stmt->execute()) {
        $confirmationId = $stmt->insert_id; // Get the auto-generated confirmation ID

        // Redirect to the order confirmation page with the confirmation ID
        header("Location: /myecommerceapp/models/order_confirmation.php?confirmationId=$confirmationId");
        exit();
    } else {
        // Redirect to an error page or display a message
        header("Location: /myecommerceapp/error.php");
        exit();
    }
} else {
    // Display the form

    ?>

    <!-- HTML Form for collecting information -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?orderId=' . $_GET['orderId']; ?>" method="post" class="mx-auto" style="max-width: 400px;">
        <h2 class="mb-4">Enter Payment and Shipping Information</h2>

        <!-- Credit Card Information -->
        <div class="mb-3">
            <label for="credit_card_number" class="form-label">Credit Card Number:</label>
            <input type="text" id="credit_card_number" name="credit_card_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="expiration_date" class="form-label">Expiration Date:</label>
            <input type="text" id="expiration_date" name="expiration_date" class="form-control" placeholder="MM/YYYY" required>
        </div>

        <div class="mb-3">
            <label for="cvv" class="form-label">CVV:</label>
            <input type="text" id="cvv" name="cvv" class="form-control" required>
        </div>

        <!-- Hidden input field to store order ID -->
        <input type="hidden" id="order_id" name="order_id" value="<?php echo $_GET['orderId']; ?>">

        <!-- Shipping Address -->
        <h3 class="mb-3">Shipping Address</h3>
        <div class="mb-3">
            <label for="shipping_address" class="form-label">Address:</label>
            <input type="text" id="shipping_address" name="shipping_address" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="shipping_city" class="form-label">City:</label>
            <input type="text" id="shipping_city" name="shipping_city" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="shipping_state" class="form-label">State:</label>
            <input type="text" id="shipping_state" name="shipping_state" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="shipping_zip" class="form-label">ZIP Code:</label>
            <input type="text" id="shipping_zip" name="shipping_zip" class="form-control" required>
        </div>

        <!-- Display total price -->
        <div class="mb-3">
            <label for="total_price" class="form-label"></label>
            <input type="hidden" id="total_price_display" name="total_price_display" class="form-control" value="<?php echo $orderTotalPrice; ?>" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Purchase Order</button>
    </form>

    <?php
    include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php';
}

ob_end_flush(); // Flush the output buffer and send the output to the browser
?>
