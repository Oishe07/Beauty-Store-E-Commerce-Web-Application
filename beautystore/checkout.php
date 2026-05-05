<?php
session_start();

// Example: Calculate subtotal from session cart (you can adapt as needed)
$products = [
    1 => ['name' => 'Velvet Matte Lipstick', 'price' => 299],
    2 => ['name' => 'Blush Palette', 'price' => 499],
    3 => ['name' => 'Liquid Eyeliner', 'price' => 199],
];

$subtotal = 0;
foreach ($_SESSION['cart'] ?? [] as $id => $qty) {
    if (isset($products[$id])) {
        $subtotal += $products[$id]['price'] * $qty;
    }
}

include("includes/header.php");
?>

<div class="container mt-5">
    <h2>Checkout</h2>
    <form action="place_order.php" method="post">
        <div class="row g-3">

            <div class="col-md-6">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>

            <div class="col-md-6">
                <input type="text" name="phone" class="form-control" placeholder="Phone" required>
            </div>

            <div class="col-md-6">
                <select name="city" class="form-control" required>
                    <option value="">Select City</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chattogram">Chattogram</option>
                    <!-- add more cities as needed -->
                </select>
            </div>

            <div class="col-md-6">
                <select name="area" class="form-control" required>
                    <option value="">Select Area</option>
                    <option value="Gulshan">Gulshan</option>
                    <option value="Dhanmondi">Dhanmondi</option>
                    <!-- add more areas as needed -->
                </select>
            </div>

            <div class="col-12">
                <input type="text" name="address" class="form-control" placeholder="Address" required>
            </div>

            <div class="col-12">
                <input type="email" name="email" class="form-control" placeholder="Email (optional)">
            </div>

            <div class="col-12">
                <textarea name="note" class="form-control" placeholder="Order Note (optional)"></textarea>
            </div>

            <div class="col-12">
                <label>Choose Shipping Method</label><br>
                <input type="radio" name="shipping" value="99" id="outside" checked>
                <label for="outside">Delivery Outside Dhaka (৳99)</label><br>
                <input type="radio" name="shipping" value="66" id="inside">
                <label for="inside">Delivery Inside Dhaka (৳66)</label>
            </div>

            <div class="col-12">
                <p>Subtotal: ৳<?= $subtotal ?></p>
                <p>Total: ৳<span id="total"><?= $subtotal + 99 ?></span></p>
            </div>

            <div class="col-12">
                <label>Choose Payment Method</label><br>
                <input type="radio" name="payment" value="Cash on Delivery" checked> Cash on Delivery<br>
                <input type="radio" name="payment" value="Bkash"> bKash<br>
                <input type="radio" name="payment" value="Pathao"> Pathao Pay<br>
                <input type="radio" name="payment" value="Card"> Pay with Card/Mobile Wallet
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success">Place Order</button>
            </div>

        </div>
    </form>
</div>

<script>
    // Update total dynamically based on shipping choice
    const subtotal = <?= $subtotal ?>;
    const totalSpan = document.getElementById('total');
    document.querySelectorAll('input[name="shipping"]').forEach(radio => {
        radio.addEventListener('change', () => {
            const shippingCost = parseInt(document.querySelector('input[name="shipping"]:checked').value);
            totalSpan.innerText = subtotal + shippingCost;
        });
    });
</script>

<?php include("includes/footer.php"); ?>
