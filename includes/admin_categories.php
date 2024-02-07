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

        <!-- Form to add a new category -->
        <form method="post" action="/myecommerceapp/models/process-add-category.php">
            <label for="categoryName">Category Name:</label>
            <input type="text" name="categoryName" required>

            <label for="iconClass">Category Icon (FontAwesome class):</label>
            <input type="text" name="iconClass" required>

            <button type="submit" name="add_category">Add Category</button>
        </form>

        <!-- Display existing categories (similar to the previous response) -->
    </div>

    <!-- Include necessary footer elements -->
</body>
</html>
