<?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
// Database connection and query to retrieve daily, monthly, and yearly sales totals
if (!function_exists('connectDatabase')) {
    include '/opt/lampp/htdocs/myecommerceapp/includes/database.php';
}
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];

// Initialize arrays to store data for the chart
$dailyLabels = $monthlyLabels = $yearlyLabels = []; // Array to store dates
$dailyTotals = $monthlyTotals = $yearlyTotals = []; // Array to store total amounts for each date

// Query to fetch daily sales totals
$query = "SELECT DATE(orderDate) AS orderDate, SUM(total) AS dailyTotal FROM ordersConfirmation GROUP BY DATE(orderDate)";
$result = $conn->query($query);

// Process query results for daily sales
while ($row = $result->fetch_assoc()) {
    $dailyLabels[] = $row['orderDate']; // Add date to labels array
    $dailyTotals[] = $row['dailyTotal']; // Add total amount to totals array
}

// Query to fetch monthly sales totals
$query = "SELECT DATE_FORMAT(orderDate, '%Y-%m') AS orderMonth, SUM(total) AS monthlyTotal FROM ordersConfirmation GROUP BY DATE_FORMAT(orderDate, '%Y-%m')";
$result = $conn->query($query);

// Process query results for monthly sales
while ($row = $result->fetch_assoc()) {
    $monthlyLabels[] = $row['orderMonth']; // Add month to labels array
    $monthlyTotals[] = $row['monthlyTotal']; // Add total amount to totals array
}

// Query to fetch yearly sales totals
$query = "SELECT YEAR(orderDate) AS orderYear, SUM(total) AS yearlyTotal FROM ordersConfirmation GROUP BY YEAR(orderDate)";
$result = $conn->query($query);

// Process query results for yearly sales
while ($row = $result->fetch_assoc()) {
    $yearlyLabels[] = $row['orderYear']; // Add year to labels array
    $yearlyTotals[] = $row['yearlyTotal']; // Add total amount to totals array
}

// Close the database connection
$conn->close();
?>
<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Sales Overview</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Chart data
    var salesData = {
        labels: <?php echo json_encode($dailyLabels); ?>, // Dates for daily sales
        datasets: [{
            label: 'Daily Sales',
            data: <?php echo json_encode($dailyTotals); ?>, // Total amounts for each date
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            borderColor: 'rgba(78, 115, 223, 1)',
            pointRadius: 3,
            pointBackgroundColor: 'rgba(78, 115, 223, 1)',
            pointBorderColor: 'rgba(78, 115, 223, 1)',
            pointHoverRadius: 3,
            pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
            pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
            pointHitRadius: 10,
            pointBorderWidth: 2
        }, {
            label: 'Monthly Sales',
            data: <?php echo json_encode($monthlyTotals); ?>, // Total amounts for each month
            backgroundColor: 'rgba(255, 193, 7, 0.1)',
            borderColor: 'rgba(255, 193, 7, 1)',
            pointRadius: 3,
            pointBackgroundColor: 'rgba(255, 193, 7, 1)',
            pointBorderColor: 'rgba(255, 193, 7, 1)',
            pointHoverRadius: 3,
            pointHoverBackgroundColor: 'rgba(255, 193, 7, 1)',
            pointHoverBorderColor: 'rgba(255, 193, 7, 1)',
            pointHitRadius: 10,
            pointBorderWidth: 2
        }, {
            label: 'Yearly Sales',
            data: <?php echo json_encode($yearlyTotals); ?>, // Total amounts for each year
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            borderColor: 'rgba(54, 162, 235, 1)',
            pointRadius: 3,
            pointBackgroundColor: 'rgba(54, 162, 235, 1)',
            pointBorderColor: 'rgba(54, 162, 235, 1)',
            pointHoverRadius: 3,
            pointHoverBackgroundColor: 'rgba(54, 162, 235, 1)',
            pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
            pointHitRadius: 10,
            pointBorderWidth: 2
        }]
    };

    // Chart options
    var chartOptions = {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'date'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return '$' + value;
                    }
                },
                gridLines: {
                    color: 'rgb(234, 236, 244)',
                    zeroLineColor: 'rgb(234, 236, 244)',
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }]
        },
        legend: {
            display: true
        }
    };

    // Get the canvas element
    var salesCtx = document.getElementById('salesChart').getContext('2d');

    // Create the sales chart
    var salesChart = new Chart(salesCtx, {
        type: 'line',
        data: salesData,
        options: chartOptions
    });
</script>
