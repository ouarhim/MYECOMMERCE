<?php
// Start output buffering
ob_start();

// admin/process-add-product.php
require_once('/opt/lampp/htdocs/myecommerceapp/includes/database.php');

// Function to handle form submission
function handleFormSubmission() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Get product details from the form
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $stock = $_POST['stock'];
        $rowPosition = $_POST['rowPosition'];
        $positionInRow = $_POST['positionInRow'];
        $displayOrder = $_POST['displayOrder'];
        $categoryId = $_POST['categoryId']; // Add this line to get category ID

        // Validate input (add more validation as needed)

        // Insert the new product into the database
        // Get database information
        $databaseInfo = connectDatabase();
        $conn = $databaseInfo['conn'];
        $settings = $databaseInfo['settings'];

        $insertSql = "INSERT INTO products (name, description, price, image, stock, rowPosition, positionInRow, displayOrder, categoryId) 
                      VALUES ('$name', '$description', $price, '$image', $stock, $rowPosition, $positionInRow, $displayOrder, $categoryId)";

        if ($conn->query($insertSql) === TRUE) {
            echo "Product added successfully";
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    }
}

// Handle CSV file upload
function handleCSVUpload() {
    // Check if a CSV file was uploaded
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        // Get the temporary file path
        $csvFilePath = $_FILES['csvFile']['tmp_name'];

        // Open the CSV file for reading
        if (($handle = fopen($csvFilePath, 'r')) !== false) {
            // Establish database connection
            $databaseInfo = connectDatabase();
            $conn = $databaseInfo['conn'];

            // Read and process each row in the CSV file
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                // Extract data from the CSV row
                $name = $data[0];
                $description = $data[1];
                $price = $data[2];
                $image = $data[3];
                $stock = $data[4];
                $rowPosition = $data[5];
                $positionInRow = $data[6];
                $displayOrder = $data[7];
                $categoryId = $data[8]; // Assuming category ID is in the 9th column

                // Check if the category ID exists in the categories table
                $checkCategoryQuery = "SELECT categoryId FROM categories WHERE categoryId = ?";
                $checkStmt = $conn->prepare($checkCategoryQuery);
                $checkStmt->bind_param("i", $categoryId);
                $checkStmt->execute();
                $checkStmt->store_result();

                // If category ID does not exist, skip inserting the product
                if ($checkStmt->num_rows === 0) {
                    echo "Skipping product insertion: Category ID $categoryId does not exist in the categories table.<br>";
                    continue;
                }

                // Insert the product data into the database
                $insertSql = "INSERT INTO products (name, description, price, image, stock, rowPosition, positionInRow, displayOrder, categoryId) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertSql);
                $stmt->bind_param("ssdssiiii", $name, $description, $price, $image, $stock, $rowPosition, $positionInRow, $displayOrder, $categoryId);

                if ($stmt->execute()) {
                    // Product inserted successfully
                    echo "Product '{$name}' added successfully.<br>";
                } else {
                    // Error inserting product
                    echo "Error adding product '{$name}': " . $stmt->error . "<br>";
                }

                $stmt->close();
            }

            // Close the CSV file
            fclose($handle);

            // Close the database connection
            $conn->close();
        } else {
            // Error handling if unable to open the CSV file
            echo "Error: Unable to open the CSV file.<br>";
        }
    }
}

// Check if a CSV file was uploaded
if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
    // Handle CSV file upload
    handleCSVUpload();
} else {
    // Handle form submission
    handleFormSubmission();
}

// End output buffering and print captured output
echo ob_get_clean();
?>
