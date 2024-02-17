<?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Products</h1>
        <div class="col-md-6">
    <form action="/myecommerceapp/models/process-add-product.php" method="post" enctype="multipart/form-data">
        <!-- Existing form fields -->

        <!-- New file input field for uploading CSV files -->
        <div class="mb-3">
            <label for="csvFile" class="form-label">Upload CSV File:</label>
            <input type="file" id="csvFile" name="csvFile" class="form-control" accept=".csv" required>
            <small class="text-muted">Upload a CSV file containing product data.</small>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form action="/myecommerceapp/models/process-add-product.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" id="price" name="price" step="0.01" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image URL:</label>
                    <input type="text" id="image" name="image" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="number" id="stock" name="stock" class="form-control" required>
                </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="categoryId" class="form-label">Category:</label>
                <select id="categoryId" name="categoryId" class="form-select" required>
                    <?php
                    require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');
                    // Get database information
                    $databaseInfo = connectDatabase();
                    $conn = $databaseInfo['conn'];

                    // Fetch categories from the database
                    $categoriesSql = "SELECT * FROM categories";
                    $categoriesResult = $conn->query($categoriesSql);

                    // Check if there was an error with the query
                    if (!$categoriesResult) {
                        die("Error fetching categories: " . $conn->error);
                    }

                    // Display categories as options
                    while ($category = $categoriesResult->fetch_assoc()) {
                        echo '<option value="' . $category['categoryId'] . '">' . $category['categoryName'] . '</option>';
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="rowPosition" class="form-label">Row Position:</label>
                <input type="number" id="rowPosition" name="rowPosition" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="positionInRow" class="form-label">Position in Row:</label>
                <input type="number" id="positionInRow" name="positionInRow" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="displayOrder" class="form-label">Display Order:</label>
                <input type="number" id="displayOrder" name="displayOrder" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>
