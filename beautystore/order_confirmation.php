<?php
session_start();
include("includes/db.php"); // DB connection

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
if ($order_id == 0) {
    die("Invalid order ID.");
}

// Fetch order info
$order_res = $conn->query("SELECT * FROM orders WHERE id = $order_id");
$order = $order_res->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

// Fetch order items
$items_res = $conn->query("SELECT * FROM order_items WHERE order_id = $order_id");

include("includes/header.php");
?>

<div class="container my-5">
    <div class="alert alert-success">Your Order has placed Successfully.</div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5>Order Number: <span class="text-danger">#<?= $order['id'] ?></span></h5>
        <h5>Status: <span class="text-danger"><?= htmlspecialchars($order['status']) ?></span></h5>
    </div>

    <div class="row g-4">
        <!-- Delivery Address -->
        <div class="col-md-6">
            <div class="p-3 border rounded bg-white">
                <h6 class="mb-3 fw-bold">DELIVERY ADDRESS</h6>
                <p><strong>ADDRESS:</strong> <?= htmlspecialchars($order['address']) ?></p>
                <p><strong>AREA:</strong> <?= htmlspecialchars($order['area']) ?></p>
                <p><strong>CITY:</strong> <?= htmlspecialchars($order['city']) ?></p>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-6">
            <div class="p-3 border rounded bg-white">
                <h6 class="mb-3 fw-bold">ORDER SUMMARY</h6>
                <p><strong>Order Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
                <p><strong>Order Time:</strong> <?= htmlspecialchars($order['order_time']) ?></p>
                <p><strong>Sub Total:</strong> ৳<?= number_format($order['subtotal'], 2) ?></p>
                <p><strong>Delivery Fee:</strong> ৳<?= number_format($order['shipping_cost'], 2) ?></p>
                <hr>
                <h5>TOTAL: ৳<?= number_format($order['total'], 2) ?></h5>
            </div>
        </div>
    </div>

    <!-- Customer & Order Details -->
    <div class="mt-4 p-3 border rounded bg-white">
        <h6 class="mb-3 fw-bold">CUSTOMER & ORDER DETAILS</h6>
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td><strong>Customer Name</strong></td>
                    <td><?= htmlspecialchars($order['name']) ?></td>
                </tr>
                <tr>
                    <td><strong>Phone Number</strong></td>
                    <td><?= htmlspecialchars($order['phone']) ?></td>
                </tr>
                <tr>
                    <td><strong>Email Address</strong></td>
                    <td><?= htmlspecialchars($order['email']) ?></td>
                </tr>
                <tr>
                    <td><strong>Payment Method</strong></td>
                    <td><?= htmlspecialchars($order['payment_method']) ?></td>
                </tr>
                <tr>
                    <td><strong>Note</strong></td>
                    <td><?= htmlspecialchars($order['note']) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Order Items Table -->
    <div class="mt-4 p-3 border rounded bg-white">
        <h6 class="mb-3 fw-bold">ORDER ITEMS</h6>
        <table class="table">
<thead>
    <tr>
        <th>IMAGE</th>
        <th>ITEMS</th>
        <th>QTY</th>
        <th>PRICE</th>
        <th>TOTAL PRICE</th>
    </tr>
</thead>
<tbody>
    <?php while ($item = $items_res->fetch_assoc()): ?>
    <tr>
        <td><img src="<?= htmlspecialchars($item['product_image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" style="height: 50px;"></td>
        <td><?= htmlspecialchars($item['product_name']) ?></td>
        <td>x <?= $item['quantity'] ?></td>
        <td>৳<?= number_format($item['price'], 2) ?></td>
        <td>৳<?= number_format($item['total_price'], 2) ?></td>
    </tr>
    <?php endwhile; ?>
</tbody>

        </table>
    </div>
</div>

<?php include("includes/footer.php"); ?>
