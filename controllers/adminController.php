<?php

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Assuming you have a 'roleId' stored in the session after login
            $userRoleId = $_SESSION['roleId'];

            // Define the role IDs that are allowed to access the page
            $allowedRoleIds = [1, 2]; // Assuming 1 is superadmin and 2 is admin

            // Check if the user's role is allowed
            if (!in_array($userRoleId, $allowedRoleIds)) {
                // Redirect the user to a restricted access page or display an error message
                echo "You do not have permission to access this page.";
                // You can also redirect the user to the home page or any other suitable page
                header("Location: /myecommerceapp/index.php");
                exit();
            }

            // Continue with the rest of your code for the page or action
            // ...0

        ?>