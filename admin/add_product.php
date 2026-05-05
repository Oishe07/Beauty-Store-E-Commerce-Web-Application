<?php
// admin/add_product.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../includes/db.php';

$msg = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $category_id = intval($_POST['category_id'] ?? 0);

    // Handle image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = __DIR__ . '/../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $tmp_name = $_FILES['image']['tmp_name'];
        $filename = basename($_FILES['image']['name']);
        $target_path = $upload_dir . $filename;
        if (move_uploaded_file($tmp_name, $target_path)) {
            $image = 'uploads/' . $filename;
        } else {
            $msg = "Failed to upload image.";
        }
    }

    // Validate and insert
    if ($name && $price > 0 && $category_id > 0) {
        $stmt = $conn->prepare(
            "INSERT INTO products (name, price, category_id, image) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("sdis", $name, $price, $category_id, $image);
        if ($stmt->execute()) {
            $msg = "Product added successfully!";
        } else {
            $msg = "Database error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $msg = "Please enter valid name, price, and select a category.";
    }
}

// Fetch categories for dropdown
$categories = [];
$res = $conn->query("SELECT category_id, name FROM categories ORDER BY name ASC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $categories[] = $row;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add New Product &mdash; Beauty Store Admin</title>
  <link
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <style>
    body { padding-top: 4.5rem; }
    .sidebar { background: #f8f9fa; min-height: 100vh; }
  </style>
</head>
<body>

  <!-- Navbar -->
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
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="products.php">Manage Products</a></li>
          <li class="nav-item"><a class="nav-link active" href="add_product.php">Add Product</a></li>
          <li class="nav-item"><a class="nav-link" href="categories.php">Manage Categories</a></li>
          <li class="nav-item"><a class="nav-link" href="add_category.php">Add Category</a></li>
          <li class="nav-item"><a class="nav-link" href="orders.php">View Orders</a></li>
        </ul>
      </nav>

      <!-- Main content -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <h1 class="mt-4 mb-4">Add New Product</h1>

        <?php if ($msg): ?>
          <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" novalidate>
          <div class="form-group">
            <label for="name">Product Name</label>
            <input
              type="text"
              class="form-control"
              id="name"
              name="name"
              required
              value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
            />
          </div>

          <div class="form-group">
            <label for="price">Price (BDT)</label>
            <input
              type="number"
              step="0.01"
              min="0"
              class="form-control"
              id="price"
              name="price"
              required
              value="<?= htmlspecialchars($_POST['price'] ?? '') ?>"
            />
          </div>

          <div class="form-group">
            <label for="category_id">Category</label>
            <select
              class="form-control"
              id="category_id"
              name="category_id"
              required
            >
              <option value="">Select category</option>
              <?php foreach ($categories as $cat): ?>
                <option
                  value="<?= $cat['category_id'] ?>"
                  <?= (isset($_POST['category_id']) && $_POST['category_id'] == $cat['category_id']) ? 'selected' : '' ?>
                >
                  <?= htmlspecialchars($cat['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="image">Product Image</label>
            <input
              type="file"
              class="form-control-file"
              id="image"
              name="image"
              accept="image/*"
            />
          </div>

          <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"
  ></script>
</body>
</html>
