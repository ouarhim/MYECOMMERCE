<?php
// Start session
include '/opt/lampp/htdocs/myecommerceapp/includes/header.php';
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Function to retrieve order details from the database
function getOrderDetails($orderId, $conn) {
    $orderDetails = array();

    // Prepare and execute SQL query to retrieve order details
    $stmt = $conn->prepare("SELECT * FROM orders WHERE orderId = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the order exists
    if ($result->num_rows > 0) {
        // Fetch order details
        $orderDetails = $result->fetch_assoc();
    }

    // Close statement
    $stmt->close();

    return $orderDetails;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    // Validate form inputs (e.g., credit card information, address details)
    // For demonstration purposes, assume the form data is valid

    // Get order ID from the query string
    $orderId = $_GET['orderId']; // Ensure to validate and sanitize user inputs

    // Establish database connection
    $connInfo = connectDatabase();
    $conn = $connInfo['conn'];

    // Retrieve order details from the database based on the order ID
    $orderDetails = getOrderDetails($orderId, $conn);

    // Process form data, validate inputs, and perform necessary actions
    // For demonstration purposes, let's assume the form data is valid and the order is successfully processed

    // Display a confirmation message
    echo "Thank you for your purchase! Your order has been successfully placed.";

    // Close the database connection
    $conn->close();

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

    <!-- Billing Address -->
    <h3 class="mb-3">Billing Address</h3>
    <div class="mb-3">
        <label for="billing_address" class="form-label">Address:</label>
        <input type="text" id="billing_address" name="billing_address" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="billing_city" class="form-label">City:</label>
        <input type="text" id="billing_city" name="billing_city" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="billing_state" class="form-label">State:</label>
        <input type="text" id="billing_state" name="billing_state" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="billing_zip" class="form-label">ZIP Code:</label>
        <input type="text" id="billing_zip" name="billing_zip" class="form-control" required>
    </div>

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

    <button type="submit" class="btn btn-primary">Purchase Order</button>
</form>


<?php
    include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php';
}
?>
