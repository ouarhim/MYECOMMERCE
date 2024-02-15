<?php

require_once('/opt/lampp/htdocs/myecommerceapp/config/config.php');

// Establish Database Connection
function connectDatabase() {
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Initialize settings
    $settings = [];

    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, 81);

    // Check Connection
    if ($conn->connect_error){
        // Log error to a file
        error_log("Connection failed: " . $conn->connect_error);
        die("Oops! Something went wrong. Please try again later.");
    }

    // Fetch display settings
    $settingsSql = "SELECT * FROM displaySettings";
    $settingsResult = $conn->query($settingsSql);

    if ($settingsResult) {
        $settings = $settingsResult->fetch_assoc();

        // Set default values if settings not found
        $productsPerRow = $settings['productsPerRow'] ?? 3;
        $rowsPerPage = $settings['rowsPerPage'] ?? 10;
        $currentPage = $settings['currentPage'] ?? 1;

        // Store settings in the session for later use
        $_SESSION['displaySettings'] = [
            'productsPerRow' => $productsPerRow,
            'rowsPerPage' => $rowsPerPage,
            'currentPage' => $currentPage,
        ];

    } else {
        // Log error to a file
        error_log("Error fetching display settings: " . $conn->error);
        die("Oops! Something went wrong. Please try again later.");
    }

    return [
        'conn' => $conn,
        'settings' => $settings,
    ];
}

?>
