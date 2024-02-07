<?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php';?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Add Products</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>
                    <?php
    require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');
    // Get database information
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];
    $settings = $databaseInfo['settings'];

    // Fetch categories from the database
    $categoriesSql = "SELECT * FROM categories";
    $categoriesResult = $conn->query($categoriesSql);
    

    // Check if there was an error with the query
    if (!$categoriesResult) {
        die("Error fetching categories: " . $conn->error);
    }
    ?>
<!-- admin/add-product.php -->
<form action="/myecommerceapp/models/process-add-product.php" method="post">
    <label for="name">Product Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" step="0.01" required>

    <label for="image">Image URL:</label>
    <input type="text" id="image" name="image" required>

    <label for="stock">Stock:</label>
    <input type="number" id="stock" name="stock" required>

    <label for="rowPosition">Row Position:</label>
    <input type="number" id="rowPosition" name="rowPosition" required>
    <label>Category:
        <select name="categoryId">
            <?php
            
            while ($category = $categoriesResult->fetch_assoc()) {
                echo '<option value="' . $category['categoryId'] . '"';
                echo '>' . $category['categoryName'] . '</option>';
            }
            ?>
        </select>
    </label>

    <label for="positionInRow">Position in Row:</label>
    <input type="number" id="positionInRow" name="positionInRow" required>

    <label for="displayOrder">Display Order:</label>
    <input type="number" id="displayOrder" name="displayOrder" required>

    <input type="submit" value="Add Product">
</form>
