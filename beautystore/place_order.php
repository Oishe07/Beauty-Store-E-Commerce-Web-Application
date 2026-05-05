<?php
session_start();
include("includes/db.php"); // Your DB connection file

// Collect POST data and sanitize
$name = $conn->real_escape_string($_POST['name']);
$phone = $conn->real_escape_string($_POST['phone']);
$city = $conn->real_escape_string($_POST['city']);
$area = $conn->real_escape_string($_POST['area']);
$address = $conn->real_escape_string($_POST['address']);
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : 'N/A';
$note = isset($_POST['note']) ? $conn->real_escape_string($_POST['note']) : 'N/A';
$shipping = (int)$_POST['shipping'];
$payment = $conn->real_escape_string($_POST['payment']);

// Calculate subtotal from session cart
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

$subtotal = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    if (isset($products[$id])) {
        $subtotal += $products[$id]['price'] * $qty;
    }
}

$total = $subtotal + $shipping;

// Create order date/time
$order_date = date('Y-m-d');
$order_time = date('H:i:s');

// Insert order info into orders table (create this table accordingly)
$sql = "INSERT INTO orders (name, phone, city, area, address, email, note, shipping_cost, payment_method, subtotal, total, order_date, order_time, status) 
        VALUES ('$name', '$phone', '$city', '$area', '$address', '$email', '$note', $shipping, '$payment', $subtotal, $total, '$order_date', '$order_time', 'Pending')";

if ($conn->query($sql) === TRUE) {
    $order_id = $conn->insert_id;

    // Insert order items (create order_items table accordingly)
foreach ($_SESSION['cart'] as $id => $qty) {
    if (isset($products[$id])) {
        $price = $products[$id]['price'];
        $total_price = $price * $qty;
        $product_name = $conn->real_escape_string($products[$id]['name']);
        $product_image = $conn->real_escape_string($products[$id]['image']); // Add this line

        $conn->query("INSERT INTO order_items (order_id, product_id, product_name, product_image, quantity, price, total_price) 
                      VALUES ($order_id, $id, '$product_name', '$product_image', $qty, $price, $total_price)");
    }
}


    // Clear cart
    unset($_SESSION['cart']);

    // Redirect to order confirmation
    header("Location: order_confirmation.php?order_id=$order_id");
    exit;
} else {
    echo "Error: " . $conn->error;
}

