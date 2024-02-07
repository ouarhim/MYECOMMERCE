<?php
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Fetch content from the database
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];

// Fetch content from the homepage_content table
$sqlContent = "SELECT * FROM homepage_content";
$resultContent = $conn->query($sqlContent);

$carouselItems = [];

if ($resultContent && $resultContent->num_rows > 0) {
    while ($row = $resultContent->fetch_assoc()) {
        $carouselItems[] = $row;
    }
}


?>



<section class="pt-3">
    <div class="container">
        <div class="row gx-3">
            <main class="col-lg-9">
                <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($carouselItems as $index => $item) { ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <div class="card-banner d-flex justify-content-center align-items-center rounded-5" style="height: 350px; background-image: url('<?php echo $item['background_image_url']; ?>'); background-size: cover; background-position: center;">
                                    <div style="max-width: 500px; padding: 0;">
                                        <h2 class="text-white">
                                            <?php echo $item['main_title']; ?>
                                        </h2>
                                        <p class="text-">
                                            <?php echo $item['main_subtitle']; ?>
                                        </p>
                                        <a href="<?php echo $item['main_button_link']; ?>" class="btn btn-light shadow-0 text-primary">
                                            <?php echo $item['main_button_text']; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </main>
            <aside class="col-lg-3">
                <div class="card-banner h-100 rounded-5" style="background-color: #f87217;">
                    <div class="card-body text-center pb-5">
                        <h5 class="pt-5 text-white">
                            <?php echo $item['aside_title']; ?>
                        </h5>
                        <p class="text-white">
                            <?php echo $item['aside_subtitle']; ?>
                        </p>
                        <a href="<?php echo $item['aside_button_link']; ?>" class="btn btn-outline-light">
                            <?php echo $item['aside_button_text']; ?>
                        </a>
                    </div>
                </div>
            </aside>
        </div>
        <!-- row //end -->
    </div>
    <!-- container end.// -->
</section>


<?php
// Close the database connection
$conn->close();
?>
