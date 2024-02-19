<!-- Category Section -->
<section class="pt-5">
    <div class="container">
        <header class="mb-4">
            <h3 class="text-center pb-3">Category</h3>
        </header>
        <div class="row gy-4">
            <?php
            require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

            // Fetch categories from the database
            $categoriesSql = "SELECT categoryId, categoryName, iconClass FROM categories";
            $databaseInfo = connectDatabase();
            $conn = $databaseInfo['conn'];
            $settings = $databaseInfo['settings'];
            $categoriesResult = $conn->query($categoriesSql);

            // Display categories
            $categoryPerRow = 6;
            $iconCounter = 0;
            while ($category = $categoriesResult->fetch_assoc()) {
                if ($iconCounter % $categoryPerRow === 0) {
                    echo '<div class="row">';
                }

                echo '<div class="col-lg-' . (12 / $categoryPerRow) . ' col-md-' . (12 / $categoryPerRow) . '">';
                echo '<a href="/myecommerceapp/templates/categoryPage.php?category_id=' . $category['categoryId'] . '" class="text-decoration-none text-dark d-flex flex-column align-items-center">';
                echo '<button type="button" class="btn btn-outline-secondary mb-2" data-mdb-ripple-color="dark">';
                echo '<i class="' . $category['iconClass'] . ' fa-xl fa-fw"></i>';
                echo '</button>';
                echo '<div class="text-center">' . $category['categoryName'] . '</div>';
                echo '</a>';
                echo '</div>';

                if ($iconCounter % $categoryPerRow === $categoryPerRow - 1 || $iconCounter === mysqli_num_rows($categoriesResult) - 1) {
                    echo '</div>';
                }

                $iconCounter++;
            }
            ?>
        </div>
    </div>
</section>
