<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'DB_E-Commerce');

// Website Configuration

define('BASE_URL','http://localhost/myecommerceapp/');

// Other Configuration

define('SITE_NAME','E-Commerce');
define('SESSION_EXPIRY', 60*30 ); // Session expires in 30 minute
 // API Key, Secrete Keys, etc

 define('API_KEY','my-api-key');

?>