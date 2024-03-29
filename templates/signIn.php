<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  type="text/css" href="/myecommerceapp/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"  type="text/css" href="/myecommerceapp/public/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="/myecommerceapp/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <title>MY-Commerce Website</title>
    <!-- Add your CSS and other meta tags here -->
    
</head>
<body>

<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net//myecommerceapp/public/images/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <!-- this is the Form -->
          <form action="/myecommerceapp/models/userLogin.php" method="post">
                  <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                      <p class="lead fw-normal mb-0 me-3">Sign in with</p>
                      <button type="button" class="btn btn-primary btn-floating mx-1">
                          <i class="fab fa-facebook-f"></i>
                      </button>

                      <button type="button" class="btn btn-primary btn-floating mx-1">
                          <i class="fab fa-twitter"></i>
                      </button>

                      <button type="button" class="btn btn-primary btn-floating mx-1">
                          <i class="fab fa-linkedin-in"></i>
                      </button>
                  </div>

                  <div class="divider d-flex align-items-center my-4">
                      <p class="text-center fw-bold mx-3 mb-0">Or</p>
                  </div>

                  <!-- Email input -->
                  <div class="form-outline mb-4">
                      <input type="email" id="email" name="email" class="form-control form-control-lg"
                          placeholder="Enter a valid email address" />
                      <label class="form-label" for="email">Email address</label>
                  </div>

                  <!-- Password input -->
                  <div class="form-outline mb-3">
                      <input type="password" id="password" name="password" class="form-control form-control-lg"
                          placeholder="Enter password" />
                      <label class="form-label" for="password">Password</label>
                  </div>

                  <div class="d-flex justify-content-between align-items-center">
                      <!-- Checkbox -->
                      <div class="form-check mb-0">
                          <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" name="remember_me" />
                          <label class="form-check-label" for="form2Example3">
                              Remember me
                          </label>
                      </div>
                      <a href="#!" class="text-body">Forgot password?</a>
                  </div>

                  <div class="text-center text-lg-start mt-4 pt-2">
                      <button type="submit" class="btn btn-primary btn-lg"
                          style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                      <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="/myecommerceapp/templates/register.php"
                              class="link-danger">Register</a></p>
                  </div>
      </form>

      </div>
    </div>
  </div>

</section>
<?php include '/opt/lampp/htdocs/myecommerceapp/includes/footer.php';?>