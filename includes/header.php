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

<nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">LOGO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <div class="mr-5">
    <li class="nav-item dropdown-toggle">
        <a class="navbar-toggler-icon" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
        <ul class="dropdown-menu">
              <?php
              session_start();
              ?>
            <?php if (isset($_SESSION['username'])) { ?>
                <!-- User is logged in -->
                <li><span class="dropdown-header">Welcome, <?php echo $_SESSION['username']; ?>!</span></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-header" href="/myecommerceapp/models/logout.php">Logout</a></li>
            <?php } else { ?>
                <!-- User is not logged in -->
                <li><a class="dropdown-header" href="/myecommerceapp/templates/signIn.php">SignIn</a></li>
                <li><a class="dropdown-header" href="/myecommerceapp/templates/register.php">Register</a></li>
            <?php } ?>
        </ul>
    </li>
</div>
    </div>
  </div>
</nav>