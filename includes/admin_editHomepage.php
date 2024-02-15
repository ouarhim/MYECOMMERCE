<?php

// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Initialize variables for messages
$successMessage = $errorMessage = '';

// Assuming $conn is your database connection
$databaseInfo = connectDatabase();
$conn = $databaseInfo['conn'];
$settings = $databaseInfo['settings'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $mainTitle = $_POST['main_title'];
    $mainSubtitle = $_POST['main_subtitle'];
    $mainButtonText = $_POST['main_button_text'];
    $mainButtonLink = $_POST['main_button_link'];
    $asideTitle = $_POST['aside_title'];
    $asideSubtitle = $_POST['aside_subtitle'];
    $asideButtonText = $_POST['aside_button_text'];
    $asideButtonLink = $_POST['aside_button_link'];
    $backgroundImages = $_POST['background_image_url'];

    // Get the selected ID to update
    $selectedId = $_POST['select_id'];

    // Update the database with the new content using prepared statements
    $updateSql = "UPDATE homepage_content SET
    main_title = ?,
    main_subtitle = ?,
    main_button_text = ?,
    main_button_link = ?,
    aside_title = ?,
    aside_subtitle = ?,
    aside_button_text = ?,
    aside_button_link = ?,
    background_image_url= ?
    WHERE id = ?";

    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("sssssssssi", $mainTitle, $mainSubtitle, $mainButtonText, $mainButtonLink, $asideTitle, $asideSubtitle, $asideButtonText, $asideButtonLink, $backgroundImages, $selectedId);

      if ($stmt->execute()) {
      $successMessage = "Content updated successfully";
    } else {
        $errorMessage = "Error updating content: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch content from the database for displaying
$sqlContent = "SELECT * FROM homepage_content";
$resultContent = $conn->query($sqlContent);

$carouselItems = [];

if ($resultContent && $resultContent->num_rows > 0) {
    while ($row = $resultContent->fetch_assoc()) {
        $carouselItems[] = $row;
    }
}
?>

<!-- Your HTML form code goes here -->

<?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php'; ?>
<div class="container">
    <!-- Admin Panel: Edit Homepage Content Form -->
    <form action="/myecommerceapp/includes/admin_editHomepage.php" method="post" class="mt-5">
        <div class="mb-3">
            <label for="select_id" class="form-label">Select ID to Update:</label>
            <select id="select_id" name="select_id" class="form-select">
                <?php foreach ($carouselItems as $item) { ?>
                    <option value="<?php echo $item['id']; ?>"><?php echo $item['id']; ?></option>
                <?php } ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="main_title" class="form-label">Main Title:</label>
            <input type="text" id="main_title" name="main_title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="main_subtitle" class="form-label">Main Subtitle:</label>
            <textarea id="main_subtitle" name="main_subtitle" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="main_button_text" class="form-label">Main Button Text:</label>
            <input type="text" id="main_button_text" name="main_button_text" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="main_button_link" class="form-label">Main Button Link:</label>
            <input type="text" id="main_button_link" name="main_button_link" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="aside_title" class="form-label">Aside Title:</label>
            <input type="text" id="aside_title" name="aside_title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="aside_subtitle" class="form-label">Aside Subtitle:</label>
            <textarea id="aside_subtitle" name="aside_subtitle" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="aside_button_text" class="form-label">Aside Button Text:</label>
            <input type="text" id="aside_button_text" name="aside_button_text" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="aside_button_link" class="form-label">Aside Button Link:</label>
            <input type="text" id="aside_button_link" name="aside_button_link" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="background_image_url" class="form-label">Background Image URL:</label>
            <input type="text" id="background_image_url" name="background_image_url" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>

    <!-- Display messages -->
    <?php
    if ($successMessage) {
        echo '<div class="alert alert-success mt-3" role="alert">' . $successMessage . '</div>';
    }

    if ($errorMessage) {
        echo '<div class="alert alert-danger mt-3" role="alert">' . $errorMessage . '</div>';
    }
    ?>
</div>
