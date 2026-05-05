<?php
require_once 'includes/db.php';

$searchTerm = trim($_GET['q'] ?? '');

$results = [];

if ($searchTerm !== '') {
    $sql = "
        SELECT p.id, p.name, p.price, p.image, c.name AS category
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.category_id
        WHERE p.name LIKE ? OR c.name LIKE ?
        ORDER BY p.name ASC
    ";

    $stmt = $conn->prepare($sql);
    $wildcard = "%$searchTerm%";
    $stmt->bind_param("ss", $wildcard, $wildcard);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Search Results for <?= htmlspecialchars($searchTerm) ?></title>
  <link
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <style>
    body { padding-top: 70px; }
    .search-header {
      background-color: #ffe4e6; /* pastel pink or your brand color */
      padding: 15px 0;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1030;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .search-header .container {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .search-results {
      margin-top: 20px;
    }
    img.product-image {
      height: 50px;
      width: auto;
      border-radius: 4px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<div class="search-header">
  <div class="container">
    <h3 class="mb-0">Search Results</h3>
    <form action="search_results.php" method="GET" class="form-inline">
      <input
        type="text"
        name="q"
        class="form-control mr-2"
        placeholder="Search products, categories..."
        value="<?= htmlspecialchars($searchTerm) ?>"
        autocomplete="off"
      />
      <button type="submit" class="btn btn-outline-danger">Search</button>
    </form>
  </div>
</div>

<div class="container search-results">
  <h5>Results for: <em><?= htmlspecialchars($searchTerm) ?></em></h5>

  <?php if (count($results) > 0): ?>
    <table class="table table-striped table-bordered mt-3">
      <thead class="thead-light">
        <tr>
          <th>Product</th>
          <th>Category</th>
          <th>Price (৳)</th>
          <th>Image</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($results as $prod): ?>
          <tr>
            <td><?= htmlspecialchars($prod['name']) ?></td>
            <td><?= htmlspecialchars($prod['category'] ?: 'Uncategorized') ?></td>
            <td><?= number_format($prod['price'], 2) ?></td>
            <td>
              <?php if ($prod['image']): ?>
                <img src="<?= htmlspecialchars($prod['image']) ?>" class="product-image" alt="<?= htmlspecialchars($prod['name']) ?>">
              <?php else: ?>
                &mdash;
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-warning mt-3">
      No results found for <strong><?= htmlspecialchars($searchTerm) ?></strong>.
    </div>
  <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script
  src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"
></script>
</body>
</html>

