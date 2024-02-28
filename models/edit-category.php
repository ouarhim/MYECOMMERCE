<?php
// Include necessary files and establish a database connection
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Check if categoryId is provided
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    // Get database information
    $databaseInfo = connectDatabase();
    $conn = $databaseInfo['conn'];
    $settings = $databaseInfo['settings'];

    // Fetch category details
    $categorySql = "SELECT * FROM categories WHERE categoryId = ?";
    $stmt = $conn->prepare($categorySql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
        // Display edit form
        ?>
        <?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php';?>

        <form action="/myecommerceapp/models/update-category.php" method="POST">
            <input type="hidden" name="categoryId" value="<?php echo $category['categoryId']; ?>">
            <div class="form-group">
                <label for="categoryName">Category Name:</label>
                <input type="text" class="form-control" id="categoryName" name="categoryName" value="<?php echo $category['categoryName']; ?>">
            </div>
            <div class="form-group">
                <label for="iconClass">Icon Class:</label>
                <input type="text" class="form-control" id="iconClass" name="iconClass" value="<?php echo $category['iconClass']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
        <?php
    } else {
        echo "Category not found.";
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Category ID not provided.";
}
?>
