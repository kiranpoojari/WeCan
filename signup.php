<?php
session_start();
require_once 'db.php';
require_once 'functions.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Email config (✅ Replace with your actual Gmail app password!)
if (!defined('SMTP_HOST')) define('SMTP_HOST', 'smtp.gmail.com');
if (!defined('SMTP_PORT')) define('SMTP_PORT', 587);
if (!defined('SMTP_SECURE')) define('SMTP_SECURE', 'tls');
if (!defined('EMAIL_FROM')) define('EMAIL_FROM', 'kiranpoojari2015@gmail.com');
if (!defined('EMAIL_FROM_NAME')) define('EMAIL_FROM_NAME', 'WeCan Support');
if (!defined('EMAIL_PASSWORD')) define('EMAIL_PASSWORD', 'jxzybxsnatqmkfxl'); // Your Gmail App Password

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $error = "Email already registered!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $password])) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = SMTP_HOST;
                $mail->SMTPAuth = true;
                $mail->Username = EMAIL_FROM;
                $mail->Password = EMAIL_PASSWORD;
                $mail->SMTPSecure = SMTP_SECURE;
                $mail->Port = SMTP_PORT;

                $mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);
                $mail->addAddress($email, $name);
                $mail->Subject = 'Welcome to WeCan!';
                $mail->Body = "Hi $name,\n\nThank you for registering at WeCan. Enjoy shopping!\n\n- Team WeCan";

                $mail->send();
                $success = "Signup successful. A confirmation email has been sent.";
            } catch (Exception $e) {
                $success = "Signup successful, but email not sent.";
            }
        } else {
            $error = "Signup failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Signup - WeCan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="css/style.css" rel="stylesheet" />
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
      <div class="text-center mb-4">
        <img src="images/logo.png" alt="WeCan Logo" width="80" height="80">
        <h4 class="mt-3 fw-bold">Create Your WeCan Account</h4>
      </div>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
      <?php endif; ?>

      <form method="POST" action="signup.php">
        <div class="mb-3">
          <input type="text" name="name" class="form-control" placeholder="Full Name" required />
        </div>
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email Address" required />
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Create Password" required />
        </div>
        <div class="d-grid mb-2">
          <button type="submit" class="btn btn-primary">Sign Up</button>
        </div>
        <div class="text-center">
          <small>Already have an account? <a href="login.php">Login</a></small>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
