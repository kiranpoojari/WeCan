<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'add_to_cart.php?id=' . $_GET['id'];
    header("Location: login.php");
    exit;
}

require 'db.php';

$product_id = intval($_GET['id'] ?? 0);
if (!$product_id) {
    header("Location: index.php");
    exit;
}

// You can store cart in session:
$_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + 1;

header("Location: cart.php");
exit;
