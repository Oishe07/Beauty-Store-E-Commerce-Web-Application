<?php
session_start();

$product_id = null;
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
} elseif (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
}

if ($product_id) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "Invalid product ID.";
}
?>




