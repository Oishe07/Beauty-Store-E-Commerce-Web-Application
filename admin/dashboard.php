<?php
// admin/dashboard.php

// 1) Show all errors (dev only – remove or disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2) Start session & verify login
session_start();
if (!isset($_SESSION['user_id'])) {
    // not even logged in
    header('Location: ../login.php');
    exit;
}

// 3) Bootstrap your DB connection
require_once __DIR__ . '/../includes/db.php';

// 4) (Optional) Double-check that this user is still an admin
//    You can skip this if you add $_SESSION['user_role']=$user['role'] in login.php
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();
if ($role !== 'admin') {
    // not an admin
    header('Location: ../login.php');
    exit;
}

// 5) Fetch dashboard stats
$counts = ['products'=>0, 'categories'=>0, 'orders'=>0];
if ($stmt = $conn->prepare("
      SELECT
        (SELECT COUNT(*) FROM products)   AS prod_count,
        (SELECT COUNT(*) FROM categories) AS cat_count,
        (SELECT COUNT(*) FROM orders)     AS ord_count
")) {
    $stmt->execute();
    $stmt->bind_result($counts['products'], $counts['categories'], $counts['orders']);
    $stmt->fetch();
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    body { padding-top: 4.5rem; }
    .card-link { text-decoration: none; color: inherit; }
    .card-link:hover { text-decoration: none; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">RONGON</a>
    <span class="navbar-text">
      Logged in as <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>
    </span>
    <a href="logout.php" class="btn btn-outline-light btn-sm ml-2">Logout</a>
  </nav>

  <div class="container-fluid">
    <div class="row">

      <!-- Sidebar -->
      <nav class="col-md-2 d-none d-md-block bg-light sidebar py-4">
        <ul class="nav flex-column">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="products.php">Manage Products</a></li>
          <li class="nav-item"><a class="nav-link" href="add_product.php">Add Product</a></li>
          <li class="nav-item"><a class="nav-link" href="categories.php">Manage Categories</a></li>
          <li class="nav-item"><a class="nav-link" href="add_category.php">Add Category</a></li>
          <li class="nav-item"><a class="nav-link" href="orders.php">View Orders</a></li>
        </ul>
      </nav>

      <!-- Main content -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <h1 class="mt-4">Dashboard</h1>
        <div class="row mt-3">

          <!-- Products Card -->
          <div class="col-md-4 mb-4">
            <a href="products.php" class="card-link">
              <div class="card text-white bg-primary h-100">
                <div class="card-body">
                  <h5 class="card-title">Products</h5>
                  <p class="card-text display-4"><?= $counts['products'] ?></p>
                </div>
                <div class="card-footer">Manage Products</div>
              </div>
            </a>
          </div>

          <!-- Categories Card -->
          <div class="col-md-4 mb-4">
            <a href="categories.php" class="card-link">
              <div class="card text-white bg-success h-100">
                <div class="card-body">
                  <h5 class="card-title">Categories</h5>
                  <p class="card-text display-4"><?= $counts['categories'] ?></p>
                </div>
                <div class="card-footer">Manage Categories</div>
              </div>
            </a>
          </div>

          <!-- Orders Card -->
          <div class="col-md-4 mb-4">
            <a href="orders.php" class="card-link">
              <div class="card text-white bg-info h-100">
                <div class="card-body">
                  <h5 class="card-title">Orders</h5>
                  <p class="card-text display-4"><?= $counts['orders'] ?></p>
                </div>
                <div class="card-footer">View Orders</div>
              </div>
            </a>
          </div>

        </div>
      </main>

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"
  ></script>
</body>
</html>
