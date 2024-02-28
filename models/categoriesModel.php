<?php
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Get database information
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];

// Fetch categories
$categoriesSql = "SELECT * FROM categories";
$categoriesResult = $conn->query($categoriesSql);

// Check if there was an error with the query
if (!$categoriesResult) {
    die("Error fetching categories: " . $conn->error);
}
?>

<?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Categories</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Display categories -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Icon Class</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display categories
                while ($category = $categoriesResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $category['categoryId'] . '</td>';
                    echo '<td>' . $category['categoryName'] . '</td>';
                    echo '<td>' . $category['iconClass'] . '</td>';
                    echo '<td><a href="/myecommerceapp/models/edit-category.php?categoryId=' . $category['categoryId'] . '" class="btn btn-sm btn-primary">Edit</a> | <a href="/myecommerceapp/models/delete-category.php?categoryId=' . $category['categoryId'] . '" class="btn btn-sm btn-danger">Delete</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include necessary footer elements -->
</div>
