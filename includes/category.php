<!-- Category Section -->
<section>
    <div class="container pt-5">
        <header class="mb-5">
            <h3>Category</h3>
        </header>
        <nav class="row gy-4">
            <?php
            require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

            // Fetch categories from the database
            $categoriesSql = "SELECT * FROM categories";
            $databaseInfo = connectDatabase();
            $conn = $databaseInfo['conn'];
            $settings = $databaseInfo['settings'];
            $categoriesResult = $conn->query($categoriesSql);

            // Display categories
            $categoryPerRow = 6;
            $iconCounter = 0;
            while ($category = $categoriesResult->fetch_assoc()) {
                if ($iconCounter % 6 === 0) {
                    echo '<div class="row">';
                }

                echo '<div class="col-lg-' . (12 / $categoryPerRow) . ' col-md-' . (12 / $categoryPerRow) . '12">';
                echo '<a href="#" class="text-center d-flex flex-column justify-content-center">';
                echo '<button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">';
                echo '<i class="' . $category['iconClass'] . ' fa-xl fa-fw"></i>';
                echo '</button>';
                echo '<div class="text-dark">' . $category['categoryName'] . '</div>';
                echo '</a>';
                echo '</div>';

                if ($iconCounter % $categoryPerRow  === $categoryPerRow - 1) {
                    echo '</div>';
                }

                $iconCounter++;
            }
            ?>
        </nav>
    </div>
</section>
