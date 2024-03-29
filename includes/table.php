<?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php'; ?>
<body>
    


<div class="container mt-5">
    <h2>Order Confirmation Data</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Confirmation ID</th>
                <th scope="col">Order ID</th>
                <th scope="col">User Name</th>
                <th scope="col">Total</th>
                <th scope="col">Shipping Address</th>
                <th scope="col">City</th>
                <th scope="col">State</th>
                <th scope="col">ZIP Code</th>
                <th scope="col">Action</th> <!-- New column for Ship Order button -->
            </tr>
        </thead>
        <tbody>
            <?php
            require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');
            // Establish database connection
            $databaseInfo = connectDatabase();
            $conn = $databaseInfo['conn'];
            $settings = $databaseInfo['settings'];
            // Fetch data from the orderConfirmation table and join with users table to get user's name
            $sql = "SELECT ordersConfirmation.confirmationId, ordersConfirmation.orderId, users.username AS userName, ordersConfirmation.total, ordersConfirmation.shippingAddress, ordersConfirmation.shippingCity, ordersConfirmation.shippingState, ordersConfirmation.shippingZip, ordersConfirmation.shipped
                    FROM ordersConfirmation 
                    JOIN users ON ordersConfirmation.userId = users.userId"; // Assuming 'userId' is the common field between ordersConfirmation and users table
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['confirmationId'] . "</td>";
                    echo "<td>" . $row['orderId'] . "</td>";
                    echo "<td>" . $row['userName'] . "</td>";
                    echo "<td>" . $row['total'] . "</td>";
                    echo "<td>" . $row['shippingAddress'] . "</td>";
                    echo "<td>" . $row['shippingCity'] . "</td>";
                    echo "<td>" . $row['shippingState'] . "</td>";
                    echo "<td>" . $row['shippingZip'] . "</td>";
                    
                    // Check if the order has been shipped
                    $shipped = $row['shipped'] ? 'Yes' : 'No';
                    
                    // Button to ship order
                    if (!$row['shipped']) {
                        echo "<td><button class='btn btn-primary ship-order' data-order-id='" . $row['orderId'] . "'>Ship Order</button></td>";
                    } else {
                        echo "<td>Shipped</td>";
                    }
                    
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No data available</td></tr>";
            }

            // Close database connection
            $conn->close();
            ?>
        </tbody>
    </table>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</div>

<!-- Modal for displaying product details -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="productDetails">
                <!-- Product details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle the ship order button click event
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('ship-order')) {
            let orderId = e.target.dataset.orderId;
            // Fetch product details via AJAX and display them in the modal
            fetchProducts(orderId);
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
</script>
<a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    

    <!-- Bootstrap core JavaScript-->
    <script src="/myecommerceapp/public/js/jquery.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/myecommerceapp/public/js/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/myecommerceapp/public/js/sb-admin-2.min.js"></script>
</body>