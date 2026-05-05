<?php
// admin/products.php

// 1) Dev error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2) Session + auth guard (inline, so you don’t need a separate auth_check.php)
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// 3) DB connection
require_once __DIR__ . '/../includes/db.php';

// 4) Fetch all products with category name
$sql = "
  SELECT
    p.id,
    p.name,
    p.price,
    p.image,
    COALESCE(c.name, 'Uncategorized') AS category
  FROM products AS p
  LEFT JOIN categories AS c
    ON p.category_id = c.category_id
  ORDER BY p.id DESC
";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products — Beauty Store Admin</title>
  <link
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    body { padding-top: 4.5rem; }
    .sidebar { background: #f8f9fa; min-height: 100vh; }
    .nav-link.active { font-weight: bold; }
  </style>
</head>
<body>

  <!-- Navbar (same as dashboard) -->
  <nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="dashboard.php">Beauty Store Admin</a>
    <span class="navbar-text">
      Logged in as <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>
    </span>
    <a href="logout.php" class="btn btn-outline-light btn-sm ml-2">Logout</a>
  </nav>

  <div class="container-fluid">
    <div class="row">

      <!-- Sidebar -->
      <nav class="col-md-2 d-none d-md-block sidebar py-4">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="products.php">Manage Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add_product.php">Add Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="categories.php">Manage Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add_category.php">Add Category</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="orders.php">View Orders</a>
          </li>
        </ul>
      </nav>

      <!-- Main content -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
          <h1 class="h2">Manage Products</h1>
          <a href="add_product.php" class="btn btn-primary">Add New Product</a>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead class="thead-light">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td>৳<?= number_format($row['price'], 2) ?></td>
                <td>
                  <?php if (!empty($row['image'])): ?>
                    <img
                      src="../<?= htmlspecialchars($row['image']) ?>"
                      alt="<?= htmlspecialchars($row['name']) ?>"
                      style="height:50px; width:auto;"
                    >
                  <?php else: ?>
                    &mdash;
                  <?php endif; ?>
                </td>
                <td>
                  <a
                    href="edit_product.php?id=<?= $row['id'] ?>"
                    class="btn btn-sm btn-warning"
                  >Edit</a>
                  <a
                    href="delete_product.php?id=<?= $row['id'] ?>"
                    class="btn btn-sm btn-danger"
                    onclick="return confirm('Are you sure you want to delete this product?')"
                  >Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>
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
