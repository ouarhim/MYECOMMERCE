<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY-Commerce Website</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/myecommerceapp/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/myecommerceapp/public/css/styles.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            <form id="searchForm" class="d-flex center" action="/myecommerceapp/templates/searchResults.php" method="GET">
              <input type="text" id="searchInput" class="form-control" name="query" placeholder="Search for products">
              <!-- Product List -->
              <div id="productList" class="dropdown-menu position-absolute bg-light border rounded-2 mt-1 px-1" style="width: 100px; display: none;"></div>
              <button id="searchButton" class="btn btn-outline-success" type="submit">Search</button>
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

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            var query = $(this).val().trim();

            // Make AJAX request to fetch matching products
            $.ajax({
                url: '/myecommerceapp/models/searchProducts.php',
                method: 'POST',
                data: { query: query },
                success: function(response) {
                    // Update the product list with the matching products
                    $('#productList').html(response);
                    if (query !== '') {
                        $('#productList').show();
                    } else {
                        $('#productList').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        
        // Get the search query from the input field
        var query = document.getElementById('searchInput').value.trim();
        
        // Redirect to the search results page with the search query as a query parameter
        window.location.href = '/myecommerceapp/templates/searchResults.php?query=' + encodeURIComponent(query);
    });
</script>


<!-- Bootstrap Bundle JS -->
<script src="/myecommerceapp/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
