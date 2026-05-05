<?php
// admin/edit_product.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../includes/db.php';

// Get product ID
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    die('Invalid product ID');
}

// Fetch existing product
$stmt = $conn->prepare("SELECT name, price, category_id, image FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();
if (!$product) {
    die('Product not found');
}

$msg = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $category_id = intval($_POST['category_id'] ?? 0);

    // Keep old image unless a new one is uploaded
    $image = $product['image'];
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = __DIR__ . '/../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $tmp = $_FILES['image']['tmp_name'];
        $file = basename($_FILES['image']['name']);
        $dst = $upload_dir . $file;
        if (move_uploaded_file($tmp, $dst)) {
            $image = 'uploads/' . $file;
        } else {
            $msg = 'Image upload failed.';
        }
    }

    if ($name && $price > 0 && $category_id > 0) {
        $stmt = $conn->prepare(
            "UPDATE products SET name = ?, price = ?, category_id = ?, image = ? WHERE id = ?"
        );
        $stmt->bind_param('sdisi', $name, $price, $category_id, $image, $id);
        if ($stmt->execute()) {
            $msg = 'Product updated successfully!';
            // Refresh product data
            $product['name'] = $name;
            $product['price'] = $price;
            $product['category_id'] = $category_id;
            $product['image'] = $image;
        } else {
            $msg = 'Database error: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $msg = 'Please enter valid name, price, and select a category.';
    }
}

// Fetch categories
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
  <meta charset="UTF-8">
  <title>Edit Product — Beauty Store Admin</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { padding-top: 4.5rem; }
    .sidebar { background: #f8f9fa; min-height: 100vh; }
    img.current-img { max-height: 100px; margin-bottom: 10px; }
  </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="dashboard.php">Beauty Store Admin</a>
  <span class="navbar-text">Logged in as <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></span>
  <a href="logout.php" class="btn btn-outline-light btn-sm ml-2">Logout</a>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block sidebar py-4">
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="products.php">Manage Products</a></li>
        <li class="nav-item"><a class="nav-link" href="add_product.php">Add Product</a></li>
        <li class="nav-item"><a class="nav-link active" href="edit_product.php">Edit Product</a></li>
        <li class="nav-item"><a class="nav-link" href="categories.php">Manage Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="orders.php">View Orders</a></li>
      </ul>
    </nav>

    <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <h1 class="mt-4 mb-4">Edit Product #<?= $id ?></h1>

      <?php if ($msg): ?>
        <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" novalidate>
        <div class="form-group">
          <label for="name">Product Name</label>
          <input type="text" class="form-control" id="name" name="name" required
                 value="<?= htmlspecialchars($product['name']) ?>">
        </div>

        <div class="form-group">
          <label for="price">Price (BDT)</label>
          <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" required
                 value="<?= htmlspecialchars($product['price']) ?>">
        </div>

        <div class="form-group">
          <label for="category_id">Category</label>
          <select class="form-control" id="category_id" name="category_id" required>
            <option value="">Select category</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['category_id'] ?>"
                <?= $cat['category_id'] == $product['category_id'] ? 'selected' : '' ?>
              ><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Current Image</label><br>
          <?php if ($product['image']): ?>
            <img src="../<?= htmlspecialchars($product['image']) ?>" class="current-img" alt="">
          <?php else: ?>
            <p><em>No image uploaded</em></p>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label for="image">Change Image</label>
          <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="products.php" class="btn btn-secondary ml-2">Cancel</a>
      </form>
    </main>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

