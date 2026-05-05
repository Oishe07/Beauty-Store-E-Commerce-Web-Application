<?php
// admin/orders.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../includes/db.php';

// 1) Handle Confirm / Reject
if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && isset($_POST['order_id'], $_POST['action'])
) {
    $order_id   = (int)$_POST['order_id'];
    $action     = $_POST['action'] === 'confirm' ? 'Confirmed' : 'Rejected';

    $stmt = $conn->prepare("
      UPDATE orders
      SET status = ?, updated_at = NOW()
      WHERE id = ?
    ");
    $stmt->bind_param("si", $action, $order_id);
    $stmt->execute();
    $stmt->close();

    header("Location: orders.php");
    exit;
}

// 2) Fetch orders + items
$sql = "
  SELECT
    o.id,
    o.name,
    o.phone,
    o.city,
    o.area,
    o.address,
    o.email,
    o.note,
    o.shipping_cost,
    o.payment_method,
    o.subtotal,
    o.total,
    o.order_date,
    o.order_time,
    o.status,
    o.updated_at,
    GROUP_CONCAT(p.name SEPARATOR ', ') AS products
  FROM orders AS o
  LEFT JOIN order_items AS oi ON oi.order_id = o.id
  LEFT JOIN products AS p ON p.id = oi.product_id
  GROUP BY o.id
  ORDER BY o.order_date DESC, o.order_time DESC
";
$result = $conn->query($sql);
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Orders — Admin</title>
  <link
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <style>
    body { padding-top: 4.5rem; }
    .table-sm td, .table-sm th { font-size: .85rem; }
  </style>
</head>
<body>

  <nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="dashboard.php">Beauty Store Admin</a>
    <span class="navbar-text">Logged in as <?=htmlspecialchars($_SESSION['user_name']??'Admin')?></span>
    <a href="logout.php" class="btn btn-outline-light btn-sm ml-2">Logout</a>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar py-4">
        <ul class="nav flex-column">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link active" href="orders.php">Manage Orders</a></li>
        </ul>
      </nav>

      <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <h1 class="mt-4">Orders</h1>

        <?php if ($result->num_rows > 0): ?>
          <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover">
              <thead class="thead-light">
                <tr>
                  <th>#</th><th>Customer</th><th>Phone</th><th>City</th><th>Area</th>
                  <th>Address</th><th>Email</th><th>Note</th><th>Products</th>
                  <th>Ship Cost</th><th>Payment</th><th>Subtotal</th><th>Total</th>
                  <th>Ordered At</th><th>Status</th><th>Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php while ($o = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= $o['id'] ?></td>
                  <td><?= htmlspecialchars($o['name']) ?></td>
                  <td><?= htmlspecialchars($o['phone']) ?></td>
                  <td><?= htmlspecialchars($o['city']) ?></td>
                  <td><?= htmlspecialchars($o['area']) ?></td>
                  <td><?= htmlspecialchars($o['address']) ?></td>
                  <td><?= htmlspecialchars($o['email']) ?></td>
                  <td><?= htmlspecialchars($o['note']) ?></td>
                  <td><?= htmlspecialchars($o['products']) ?></td>
                  <td>৳<?= number_format($o['shipping_cost'],2) ?></td>
                  <td><?= htmlspecialchars($o['payment_method']) ?></td>
                  <td>৳<?= number_format($o['subtotal'],2) ?></td>
                  <td>৳<?= number_format($o['total'],2) ?></td>
                  <td><?= htmlspecialchars($o['order_date']) ?> <?= htmlspecialchars($o['order_time']) ?></td>
                  <td><?= htmlspecialchars($o['status']) ?></td>
                  <td>
                    <?php if (strtolower($o['status']) === 'pending'): ?>
                      <form method="POST" style="display:inline">
                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                        <button name="action" value="confirm" class="btn btn-success btn-sm">Accept</button>
                      </form>
                      <form method="POST" style="display:inline">
                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                        <button name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                      </form>
                    <?php else: ?>
                      <small>Updated: <?= htmlspecialchars($o['updated_at']) ?></small>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p>No orders found.</p>
        <?php endif; ?>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
