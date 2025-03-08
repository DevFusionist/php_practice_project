<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      .card-columns {
        column-count: 3;
      }
      .card {
        height: 100%;
      }
      .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
      }
      .card-img-top {
        height: 200px;
        object-fit: cover;
      }
    </style>
  </head>
  <body>
      <?php
          // including the navbar
          include "./navbar.php";

          // Check if the user is logged in
          if (isset($_SESSION['email'])) {
              $email = htmlspecialchars($_SESSION['email']);
              echo "<h1 class='text-center my-4'>Welcome to Dashboard, $email</h1>";
          } else {
              echo "<h1 class='text-center my-4'>Welcome to Dashboard</h1>";
          }

          // Fetch products from JSONPlaceholder
          $json = file_get_contents('https://fakestoreapi.com/products');
          $products = json_decode($json, true);

          // Get the search term from the session
          $searchTerm = isset($_SESSION['search']) ? $_SESSION['search'] : '';

          // Filter products based on the search term
          if ($searchTerm) {
              $products = array_filter($products, function($product) use ($searchTerm) {
                  return preg_match('/\b' . preg_quote($searchTerm, '/') . '\b/i', $product['title']);
              });
          }
      ?>

      <div class="container">
        <div class="row" id="product-list">
          <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
              <div class="card">
                <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['title']); ?>">
                <div class="card-body">
                  <h5 class="card-title"><?php echo htmlspecialchars($product['title']); ?></h5>
                  <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                  <a href="#" class="btn btn-primary mt-auto">View Product</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

