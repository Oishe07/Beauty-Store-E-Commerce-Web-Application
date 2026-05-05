<?php
session_start();

$products = [
    // Top seller example products
    1 => ['name' => 'Velvet Matte Lipstick', 'price' => 299, 'image' => 'images/product1.jpg'],
    2 => ['name' => 'Blush Palette', 'price' => 499, 'image' => 'images/product2.jpg'],
    3 => ['name' => 'Liquid Eyeliner', 'price' => 199, 'image' => 'images/product3.jpg'],

    // Skincare
    101 => ['name' => 'Gentle Skin Cleanser', 'price' => 650, 'image' => 'images/skincare1.jpg'],
    102 => ['name' => 'Hydrating Toner', 'price' => 480, 'image' => 'images/skincare2.jpg'],
    103 => ['name' => 'Daily Moisturizer SPF 30', 'price' => 850, 'image' => 'images/skincare3.jpg'],

    // Makeup
    201 => ['name' => 'Longwear Foundation', 'price' => 999, 'image' => 'images/makeup1.jpg'],
    202 => ['name' => 'Cream Blush', 'price' => 499, 'image' => 'images/makeup2.jpg'],
    203 => ['name' => 'Glowy Highlighter', 'price' => 720, 'image' => 'images/makeup3.jpg'],

    // Haircare
    301 => ['name' => 'Anti-Dandruff Shampoo', 'price' => 540, 'image' => 'images/hair1.jpg'],
    302 => ['name' => 'Coconut Hair Oil', 'price' => 360, 'image' => 'images/hair2.jpg'],
    303 => ['name' => 'Silky Conditioner', 'price' => 450, 'image' => 'images/hair3.jpg'],

    // Fragrances
    401 => ['name' => 'Floral Bloom', 'price' => 1250, 'image' => 'images/perfume1.jpg'],
    402 => ['name' => 'Musk Night', 'price' => 1420, 'image' => 'images/perfume2.jpg'],
    403 => ['name' => 'Ocean Mist', 'price' => 1110, 'image' => 'images/perfume3.jpg'],

    // Body
    501 => ['name' => 'Body Lotion', 'price' => 599, 'image' => 'images/body1.jpg'],
    502 => ['name' => 'Shea Body Butter', 'price' => 850, 'image' => 'images/body2.jpg'],
    503 => ['name' => 'Exfoliating Body Scrub', 'price' => 420, 'image' => 'images/body3.jpg'],
];

include("includes/header.php");
?>

<h2>Your Cart</h2>

<?php if (empty($_SESSION['cart'])): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <form id="cart-form">
        <div class="row" id="cart-items">
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $qty):
            if (isset($products[$id])):
                $p = $products[$id];
                $subtotal = $p['price'] * $qty;
                $total += $subtotal;
        ?>
            <div class="col-md-6 mb-3" data-id="<?= $id ?>" data-price="<?= $p['price'] ?>">
                <div class="card shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= $p['image'] ?>" class="img-fluid rounded-start" alt="<?= $p['name'] ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
                                <p class="card-text">
                                    ৳<?= number_format($p['price'], 2) ?> x 
                                    <input type="number" class="form-control d-inline w-auto quantity" value="<?= $qty ?>" min="1" style="width: 70px;">
                                    = ৳<span class="subtotal"><?= number_format($subtotal, 2) ?></span>
                                </p>
                                <a href="remove_from_cart.php?id=<?= $id ?>" class="btn btn-sm btn-danger">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; endforeach; ?>
        </div>

        <h4>Total: ৳<span id="total"><?= number_format($total, 2) ?></span></h4>

        <div class="d-flex justify-content-end mt-3">
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        </div>
    </form>
<?php endif; ?>

<script>
document.querySelectorAll('.quantity').forEach(input => {
    input.addEventListener('input', function () {
        let total = 0;
        document.querySelectorAll('#cart-items > div').forEach(card => {
            const price = parseFloat(card.dataset.price);
            const qty = parseInt(card.querySelector('.quantity').value) || 1;
            const subtotal = price * qty;
            card.querySelector('.subtotal').innerText = subtotal.toFixed(2);
            total += subtotal;
        });
        document.getElementById('total').innerText = total.toFixed(2);
    });
});
</script>

<?php include("includes/footer.php"); ?>
