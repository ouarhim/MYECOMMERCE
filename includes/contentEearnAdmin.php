<?php
// Database connection and query to retrieve daily sales totals
if (!function_exists('connectDatabase')) {
    include '/opt/lampp/htdocs/myecommerceapp/includes/database.php';
}
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];


// Initialize arrays to store data for the chart
$labels = []; // Array to store dates
$totals = []; // Array to store total amounts for each date

// Query to fetch monthly sales totals
$query = "SELECT YEAR(orderDate) AS year, MONTH(orderDate) AS month, SUM(total) AS monthlyTotal 
          FROM ordersConfirmation 
          GROUP BY YEAR(orderDate), MONTH(orderDate)";
$result = $conn->query($query);

// Process query results to calculate monthly totals
$monthlyTotals = [];
while ($row = $result->fetch_assoc()) {
    $year = $row['year'];
    $month = $row['month'];
    $monthlyTotal = $row['monthlyTotal'];
    $monthlyTotals["$year-$month"] = $monthlyTotal;
}

// Calculate annual totals
$annualTotals = [];
foreach ($monthlyTotals as $key => $value) {
    $year = explode('-', $key)[0];
    if (!isset($annualTotals[$year])) {
        $annualTotals[$year] = 0;
    }
    $annualTotals[$year] += $value;
}

// Prepare data for JavaScript chart
$labels = array_keys($monthlyTotals);
$totals = array_values($monthlyTotals);

// Close the database connection
$conn->close();
?>

<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Earnings (Monthly)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($totals[0], 2); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Earnings (Annual)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format(array_sum($annualTotals), 2); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Pending Requests</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>