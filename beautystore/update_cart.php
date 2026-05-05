<?php
session_start();

if (isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        if (is_numeric($qty) && $qty > 0) {
            $_SESSION['cart'][$id] = $qty;
        }
    }
}

header("Location: cart.php");
exit;
