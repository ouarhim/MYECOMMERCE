<?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php'; ?>

<div class="container mt-5">
    <h2>Order Confirmation Data</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Confirmation ID</th>
                <th scope="col">Order ID</th>
                <th scope="col">User ID</th>
                <th scope="col">Total</th>
                <th scope="col">Shipping Address</th>
                <th scope="col">City</th>
                <th scope="col">State</th>
                <th scope="col">ZIP Code</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');
            // Establish database connection
            $databaseInfo = connectDatabase();
            $conn = $databaseInfo['conn'];
            $settings = $databaseInfo['settings'];
            // Fetch data from the orderConfirmation table
            $sql = "SELECT * FROM ordersConfirmation";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['confirmationId'] . "</td>";
                    echo "<td>" . $row['orderId'] . "</td>";
                    echo "<td>" . $row['userId'] . "</td>";
                    echo "<td>" . $row['total'] . "</td>";
                    echo "<td>" . $row['shippingAddress'] . "</td>";
                    echo "<td>" . $row['shippingCity'] . "</td>";
                    echo "<td>" . $row['shippingState'] . "</td>";
                    echo "<td>" . $row['shippingZip'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No data available</td></tr>";
            }

            // Close database connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

