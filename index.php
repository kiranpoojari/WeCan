<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>WeCan | Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/index.css" />
</head>
<body>
<?php
  session_start();
  require_once 'db.php';
  $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
  $products = $stmt->fetchAll();
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container d-flex align-items-center">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="images/logo.png" alt="WeCan Logo" />
      <span class="fw-bold text-primary fs-3">WeCan</span>
    </a>

    <div class="ms-auto nav-buttons">
      <!-- Login button always visible -->
      <a href="login.php" class="btn btn-primary">Login</a>

      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="cart.php" class="btn btn-outline-primary position-relative ms-2">
          Cart
          <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">
            0
          </span>
        </a>
        <a href="logout.php" class="btn btn-outline-danger ms-2">Logout</a>
      <?php else: ?>
        <a href="templates/signup.html" class="btn btn-outline-primary ms-2">Signup</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Floating Offer Banner below header -->
<div class="container mt-3">
  <div class="offer-banner d-flex overflow-hidden py-2 px-3 rounded bg-warning bg-opacity-75 shadow-sm" id="offerBanner">
    <div class="offer-track d-flex" id="offerTrack">
      <div class="offer-card text-dark fw-bold me-4 flex-shrink-0">
        🎉 Mega Sale! Up to 50% off on top products. <a href="#" class="text-dark text-decoration-underline">Shop Now</a>
      </div>
      <div class="offer-card text-dark fw-bold me-4 flex-shrink-0">
        🚚 Free shipping on orders above ₹999. Hurry up!
      </div>
      <div class="offer-card text-dark fw-bold flex-shrink-0">
        🎁 Get extra 10% cashback with WeCan Wallet!
      </div>

      <!-- Duplicate for continuous loop -->
      <div class="offer-card text-dark fw-bold me-4 flex-shrink-0">
        🎉 Mega Sale! Up to 50% off on top products. <a href="#" class="text-dark text-decoration-underline">Shop Now</a>
      </div>
      <div class="offer-card text-dark fw-bold me-4 flex-shrink-0">
        🚚 Free shipping on orders above ₹999. Hurry up!
      </div>
      <div class="offer-card text-dark fw-bold flex-shrink-0">
        🎁 Get extra 10% cashback with WeCan Wallet!
      </div>
    </div>
  </div>
</div>

<div class="container py-5">
  <div class="row g-4">
    <?php foreach ($products as $product): ?>
      <div class="col-md-3 col-sm-6 fade-in">
        <div class="product-card bg-white">
          <img src="uploads/<?= htmlspecialchars($product['image']) ?>" class="img-fluid product-image" alt="<?= htmlspecialchars($product['name']) ?>" />
          <div class="p-3">
            <h6 class="fw-semibold mb-1"><?= htmlspecialchars($product['name']) ?></h6>
            <p class="text-muted mb-2">₹<?= number_format($product['price'], 2) ?></p>
            <a href="product_detail.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-primary">View</a>
            <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-outline-secondary ms-2">Add to Cart</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/index.js"></script>
</body>
</html>
