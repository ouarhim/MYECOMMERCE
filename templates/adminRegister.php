<?php

            session_start();

            // Assuming you have a 'roleId' stored in the session after login
            $userRoleId = $_SESSION['roleId'];

            // Define the role IDs that are allowed to access the page
            $allowedRoleIds = [1]; // Assuming 1 is superadmin and 2 is admin

            // Check if the user's role is allowed
            if (!in_array($userRoleId, $allowedRoleIds)) {
                // Redirect the user to a restricted access page or display an error message
                echo "You do not have permission to access this page.";
                // You can also redirect the user to the home page or any other suitable page
                header("Location: /myecommerceapp/includes/access-denied.php");
                exit();
            }

            // Continue with the rest of your code for the page or action
            // ...

        ?>

<!-- Your HTML registration form -->
<?php include '/opt/lampp/htdocs/myecommerceapp/includes/headerAdmin.php';?>
<div class="card-body px-4 py-5 px-md-5">
            <form action="/myecommerceapp/models/adminModel.php" method="post">
              <!-- 2 column grid layout with text inputs for the first and last names -->
              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <input type="text" id="username" name="username" class="form-control" />
                    <label class="form-label" for="username">User Name</label>
                  </div>
                </div>
              

              <!-- Email input -->
              <div class="form-outline mb-4">
                <input type="email" id="email" name="email" class="form-control" />
                <label class="form-label" for="email">Email address</label>
              </div>

              <!-- Password input -->
              <div class="form-outline mb-4">
                <input type="password" id="password" name="password" class="form-control" />
                <label class="form-label" for="password">Password</label>
                <div id="password-strength-indicator"></div>
              </div>

              <!-- Checkbox -->
              <div class="form-check d-flex justify-content-center mb-4">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                <label class="form-check-label" for="form2Example33">
                  Subscribe to our newsletter
                </label>
              </div>

              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block mb-4">
                Sign up
              </button>
            </form>
              <!-- Register buttons -->
              <div class="text-center">
                <p>or sign up with:</p>
                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-facebook-f"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-google"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-twitter"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-github"></i>
                </button>
              </div>
            
          </div>