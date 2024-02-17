<?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Products</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Admin navigation/header (if any) -->

    <div class="container">
        <header>
            <h3>Manage Categories</h3>
        </header>

        <div class="row">
            <div class="col-md-6">
                <!-- Form to add a new category -->
                <form method="post" action="/myecommerceapp/models/process-add-category.php">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name:</label>
                        <input type="text" id="categoryName" name="categoryName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="iconClass" class="form-label">Category Icon (FontAwesome class):</label>
                        <input type="text" id="iconClass" name="iconClass" class="form-control" required>
                    </div>

                    <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>

        <!-- Display existing categories (if any) -->
    </div>

    <!-- Include necessary footer elements -->
</div>
