<?php
session_start();
require_once 'db.php';
require_once 'functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - WeCan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="css/style.css" rel="stylesheet" />
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
      <div class="text-center mb-4">
        <img src="images/logo.png" alt="WeCan Logo" width="80" height="80">
        <h4 class="mt-3 fw-bold">Welcome to WeCan</h4>
        <p class="text-muted">Login to continue</p>
      </div>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <form method="POST" action="login.php">
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email address" required />
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required />
        </div>
        <div class="d-grid mb-2">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <div class="text-center">
          <small>Don't have an account? <a href="signup.php">Register</a></small>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
