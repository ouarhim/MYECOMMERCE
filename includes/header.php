<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/myecommerceapp/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/myecommerceapp/public/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>MY-Commerce Website</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand" href="/myecommerceapp/index.php">LOGO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/myecommerceapp/index.php">Home</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <div class="ms-3">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <?php
              if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
              ?>
              <?php if (isset($_SESSION['username'])) { ?>
                  <!-- User is logged in -->
                  <li><span class="dropdown-header">Welcome, <?php echo $_SESSION['username']; ?>!</span></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/myecommerceapp/templates/favoriteProductPage.php">Favorites</a></li>
                  <li><a class="dropdown-item" href="/myecommerceapp/models/orderModel.php">Order</a></li>
                  <li><a class="dropdown-item" href="/myecommerceapp/models/logout.php">Logout</a></li>
              <?php } else { ?>
                  <!-- User is not logged in -->
                  <li><a class="dropdown-item" href="/myecommerceapp/templates/signIn.php">SignIn</a></li>
                  <li><a class="dropdown-item" href="/myecommerceapp/templates/register.php">Register</a></li>
              <?php } ?>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<script src="/myecommerceapp/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
