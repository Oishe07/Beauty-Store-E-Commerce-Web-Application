<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Beauty Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css"> <!-- Your custom CSS -->
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar-unique {
      padding: 18px 30px;
      background-color: #fff3f7;
      border-bottom: 1px solid #ffe3eb;
    }
    .navbar-brand {
      font-weight: 700;
      font-size: 26px;
      color: #d63384;
      letter-spacing: 1px;
    }
    .form-search {
      border-radius: 30px;
      border: 1.5px solid #ffc0cb;
      padding-left: 2.5rem;
      font-size: 14px;
      height: 42px;
      transition: border 0.3s;
    }
    .form-search:focus {
      outline: none;
      border-color: #ff9fbf;
      box-shadow: 0 0 0 0.15rem rgba(255, 144, 176, 0.25);
    }
    .icon-search {
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
      color: #888;
    }
    .btn-nav {
      border-radius: 20px;
      padding: 6px 16px;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    .btn-wishlist {
      background-color: #dbeafe;
      color: #1e3a8a;
    }
    .btn-login {
      background-color: #e0f2f1;
      color: #004d40;
    }
    .btn-cart {
      background-color: #ffccd5;
      color: #b71c1c;
      position: relative;
    }
    .btn-cart span {
      position: absolute;
      top: -6px;
      right: 10px;
      background: white;
      color: #ff3366;
      border-radius: 50%;
      padding: 0px 7px;
      font-size: 12px;
      font-weight: bold;
    }
    .btn-nav:hover {
      opacity: 0.85;
    }
  </style>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-unique">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="index.php">RONGON</a>

<form action="search_results.php" method="GET" class="position-relative flex-grow-1 mx-4" style="max-width: 500px;">
  <i class="fas fa-search icon-search"></i>
  <input
    type="text"
    class="form-control form-search"
    name="q"
    placeholder="Search products, categories..."
    autocomplete="off"
  >
</form>

    <div class="d-flex gap-2 align-items-center">
      <a href="wishlist.php" class="btn btn-nav btn-wishlist">Wishlist</a>

      <?php if (isset($_SESSION['user_name'])): ?>
        <a class="btn btn-nav btn-login">Hi, <?= htmlspecialchars($_SESSION['user_name']) ?></a>
        <a href="logout.php" class="btn btn-nav btn-login">Logout</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-nav btn-login">Login</a>
      <?php endif; ?>

      <a href="cart.php" class="btn btn-nav btn-cart">
        Cart <span><?= $cart_count ?></span>
      </a>
    </div>
  </div>
</nav>

<div class="container mt-4">



